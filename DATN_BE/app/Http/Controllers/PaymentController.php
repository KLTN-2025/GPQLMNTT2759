<?php

namespace App\Http\Controllers;

use App\Services\PayosService;
use App\Models\DongHocPhi;
use App\Models\HocPhi;
use App\Models\HocSinh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    protected $payosService;

    public function __construct(PayosService $payosService)
    {
        $this->payosService = $payosService;
    }

    /**
     * Tạo link thanh toán học phí
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createHocPhiPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_hoc_phi' => 'required|exists:hoc_phis,id',
            'id_hoc_sinh' => 'required|exists:hoc_sinhs,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            // Lấy thông tin học phí và học sinh
            $hocPhi = HocPhi::findOrFail($request->id_hoc_phi);
            $hocSinh = HocSinh::findOrFail($request->id_hoc_sinh);

            // Tạo thanh toán
            $result = $this->payosService->createHocPhiPayment(
                $hocPhi->toArray(),
                $hocSinh->toArray()
            );

            if ($result['success']) {
                // Lưu thông tin thanh toán vào database
                DongHocPhi::create([
                    'id_hoc_phi' => $hocPhi->id,
                    'id_hoc_sinh' => $hocSinh->id,
                    'so_tien_dong' => $hocPhi->so_tien,
                    'ngay_dong' => now(),
                    'hinh_thuc_thanh_toan' => 'PayOS',
                    'ghi_chu' => 'Đang chờ thanh toán',
                    'tinh_trang' => false, // Chưa thanh toán
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Tạo link thanh toán thành công',
                    'data' => [
                        'payment_url' => $result['data']['checkoutUrl'] ?? null,
                        'order_code' => $result['data']['orderCode'] ?? null,
                        'amount' => $hocPhi->so_tien,
                        'hoc_sinh' => $hocSinh->ho_va_ten,
                        'hoc_phi' => $hocPhi->ten_hoc_phi
                    ]
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => $result['message']
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy thông tin thanh toán
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPaymentInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_code' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Order code là bắt buộc'
            ], 400);
        }

        $result = $this->payosService->getPaymentInfo($request->order_code);

        return response()->json($result);
    }

    /**
     * Hủy thanh toán
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_code' => 'required|string',
            'reason' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Order code là bắt buộc'
            ], 400);
        }

        $result = $this->payosService->cancelPayment(
            $request->order_code,
            $request->reason ?? 'Hủy thanh toán'
        );

        return response()->json($result);
    }

    /**
     * Xử lý webhook từ PayOS
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleWebhook(Request $request)
    {
        try {
            $result = $this->payosService->handleWebhook($request->all());

            if ($result['success']) {
                return response()->json($result);
            } else {
                return response()->json($result, 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Webhook error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Trang thành công thanh toán
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function paymentSuccess(Request $request)
    {
        $orderCode = $request->get('orderCode');
        $status = $request->get('status');

        return view('payment.success', compact('orderCode', 'status'));
    }

    /**
     * Trang hủy thanh toán
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function paymentCancel(Request $request)
    {
        $orderCode = $request->get('orderCode');
        $status = $request->get('status');

        return view('payment.cancel', compact('orderCode', 'status'));
    }

    /**
     * Lấy danh sách thanh toán học phí
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHocPhiPayments(Request $request)
    {
        try {
            $payments = DongHocPhi::with(['hocPhi', 'hocSinh'])
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            return response()->json([
                'status' => true,
                'data' => $payments
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tạo thanh toán tùy chỉnh
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createCustomPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1000',
            'description' => 'required|string|max:255',
            'items' => 'nullable|array',
            'expired_at' => 'nullable|date|after:now'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $paymentData = [
                'order_code' => $this->payosService->generateOrderCode('CUSTOM'),
                'amount' => $request->amount,
                'description' => $request->description,
                'items' => $request->items ?? [],
                'expired_at' => $request->expired_at ? strtotime($request->expired_at) : null
            ];

            $result = $this->payosService->createPaymentLink($paymentData);

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}
