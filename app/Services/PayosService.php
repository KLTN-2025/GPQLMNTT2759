<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class PayosService
{
    private $clientId;
    private $apiKey;
    private $checksumKey;
    private $baseUrl;
    private $returnUrl;
    private $cancelUrl;

    public function __construct()
    {
        $this->clientId = config('services.payos.client_id');
        $this->apiKey = config('services.payos.api_key');
        $this->checksumKey = config('services.payos.checksum_key');
        $this->baseUrl = config('services.payos.base_url', 'https://api-merchant.payos.vn');
        $this->returnUrl = config('services.payos.return_url');
        $this->cancelUrl = config('services.payos.cancel_url');
    }

    /**
     * Tạo link thanh toán PayOS
     *
     * @param array $data
     * @return array
     */
    public function createPaymentLink(array $data): array
    {
        try {
            $paymentData = [
                'orderCode' => $data['order_code'],
                'amount' => $data['amount'],
                'description' => $data['description'],
                'items' => $data['items'] ?? [],
                'returnUrl' => $this->returnUrl,
                'cancelUrl' => $this->cancelUrl,
                'expiredAt' => $data['expired_at'] ?? null,
            ];

            // Tạo checksum
            $paymentData['signature'] = $this->createSignature($paymentData);

            $response = Http::withHeaders([
                'x-client-id' => $this->clientId,
                'x-api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/v2/payment-requests', $paymentData);

            if ($response->successful()) {
                $result = $response->json();
                Log::info('PayOS payment link created successfully', [
                    'order_code' => $data['order_code'],
                    'payment_link' => $result['data']['checkoutUrl'] ?? null
                ]);

                return [
                    'success' => true,
                    'data' => $result['data'] ?? $result,
                    'message' => 'Tạo link thanh toán thành công'
                ];
            } else {
                $error = $response->json();
                Log::error('PayOS payment link creation failed', [
                    'order_code' => $data['order_code'],
                    'error' => $error
                ]);

                return [
                    'success' => false,
                    'message' => $error['message'] ?? 'Có lỗi xảy ra khi tạo link thanh toán',
                    'error_code' => $error['code'] ?? null
                ];
            }
        } catch (Exception $e) {
            Log::error('PayOS service error', [
                'message' => $e->getMessage(),
                'order_code' => $data['order_code'] ?? null
            ]);

            return [
                'success' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Lấy thông tin thanh toán theo order code
     *
     * @param string $orderCode
     * @return array
     */
    public function getPaymentInfo(string $orderCode): array
    {
        try {
            $response = Http::withHeaders([
                'x-client-id' => $this->clientId,
                'x-api-key' => $this->apiKey,
            ])->get($this->baseUrl . '/v2/payment-requests/' . $orderCode);

            if ($response->successful()) {
                $result = $response->json();
                return [
                    'success' => true,
                    'data' => $result['data'] ?? $result
                ];
            } else {
                $error = $response->json();
                return [
                    'success' => false,
                    'message' => $error['message'] ?? 'Không thể lấy thông tin thanh toán',
                    'error_code' => $error['code'] ?? null
                ];
            }
        } catch (Exception $e) {
            Log::error('PayOS get payment info error', [
                'message' => $e->getMessage(),
                'order_code' => $orderCode
            ]);

            return [
                'success' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Hủy thanh toán
     *
     * @param string $orderCode
     * @param string $cancellationReason
     * @return array
     */
    public function cancelPayment(string $orderCode, string $cancellationReason = 'Hủy thanh toán'): array
    {
        try {
            $cancelData = [
                'cancellationReason' => $cancellationReason
            ];

            $response = Http::withHeaders([
                'x-client-id' => $this->clientId,
                'x-api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/v2/payment-requests/' . $orderCode . '/cancel', $cancelData);

            if ($response->successful()) {
                $result = $response->json();
                Log::info('PayOS payment cancelled successfully', [
                    'order_code' => $orderCode,
                    'reason' => $cancellationReason
                ]);

                return [
                    'success' => true,
                    'data' => $result['data'] ?? $result,
                    'message' => 'Hủy thanh toán thành công'
                ];
            } else {
                $error = $response->json();
                Log::error('PayOS payment cancellation failed', [
                    'order_code' => $orderCode,
                    'error' => $error
                ]);

                return [
                    'success' => false,
                    'message' => $error['message'] ?? 'Không thể hủy thanh toán',
                    'error_code' => $error['code'] ?? null
                ];
            }
        } catch (Exception $e) {
            Log::error('PayOS cancel payment error', [
                'message' => $e->getMessage(),
                'order_code' => $orderCode
            ]);

            return [
                'success' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Xác thực webhook từ PayOS
     *
     * @param array $data
     * @return bool
     */
    public function verifyWebhook(array $data): bool
    {
        try {
            $signature = $data['signature'] ?? '';
            unset($data['signature']);

            $expectedSignature = $this->createSignature($data);

            return hash_equals($expectedSignature, $signature);
        } catch (Exception $e) {
            Log::error('PayOS webhook verification error', [
                'message' => $e->getMessage(),
                'data' => $data
            ]);

            return false;
        }
    }

    /**
     * Tạo chữ ký số (signature) cho PayOS
     *
     * @param array $data
     * @return string
     */
    private function createSignature(array $data): string
    {
        // Sắp xếp các key theo thứ tự alphabet
        ksort($data);

        // Tạo chuỗi query string
        $queryString = http_build_query($data);

        // Tạo signature bằng HMAC SHA256
        return hash_hmac('sha256', $queryString, $this->checksumKey);
    }

    /**
     * Tạo order code duy nhất
     *
     * @param string $prefix
     * @return string
     */
    public function generateOrderCode(string $prefix = 'QLMN'): string
    {
        return $prefix . '_' . time() . '_' . rand(1000, 9999);
    }

    /**
     * Tạo dữ liệu thanh toán cho học phí
     *
     * @param array $hocPhiData
     * @param array $hocSinhData
     * @return array
     */
    public function createHocPhiPayment(array $hocPhiData, array $hocSinhData): array
    {
        $orderCode = $this->generateOrderCode('HOCPHI');

        $paymentData = [
            'order_code' => $orderCode,
            'amount' => $hocPhiData['so_tien'],
            'description' => "Thanh toán học phí - {$hocSinhData['ho_va_ten']} - {$hocPhiData['ten_hoc_phi']}",
            'items' => [
                [
                    'name' => $hocPhiData['ten_hoc_phi'],
                    'quantity' => 1,
                    'price' => $hocPhiData['so_tien']
                ]
            ],
            'expired_at' => now()->addDays(7)->timestamp
        ];

        return $this->createPaymentLink($paymentData);
    }

    /**
     * Xử lý webhook từ PayOS
     *
     * @param array $webhookData
     * @return array
     */
    public function handleWebhook(array $webhookData): array
    {
        try {
            // Xác thực webhook
            if (!$this->verifyWebhook($webhookData)) {
                Log::warning('PayOS webhook verification failed', $webhookData);
                return [
                    'success' => false,
                    'message' => 'Webhook verification failed'
                ];
            }

            $orderCode = $webhookData['orderCode'] ?? '';
            $status = $webhookData['status'] ?? '';
            $amount = $webhookData['amount'] ?? 0;

            Log::info('PayOS webhook received', [
                'order_code' => $orderCode,
                'status' => $status,
                'amount' => $amount
            ]);

            // Xử lý theo trạng thái thanh toán
            switch ($status) {
                case 'PAID':
                    return $this->handlePaymentSuccess($orderCode, $webhookData);
                case 'CANCELLED':
                    return $this->handlePaymentCancelled($orderCode, $webhookData);
                case 'EXPIRED':
                    return $this->handlePaymentExpired($orderCode, $webhookData);
                default:
                    Log::warning('Unknown PayOS payment status', [
                        'order_code' => $orderCode,
                        'status' => $status
                    ]);
                    return [
                        'success' => false,
                        'message' => 'Unknown payment status'
                    ];
            }
        } catch (Exception $e) {
            Log::error('PayOS webhook handling error', [
                'message' => $e->getMessage(),
                'data' => $webhookData
            ]);

            return [
                'success' => false,
                'message' => 'Webhook handling error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Xử lý thanh toán thành công
     *
     * @param string $orderCode
     * @param array $webhookData
     * @return array
     */
    private function handlePaymentSuccess(string $orderCode, array $webhookData): array
    {
        // TODO: Cập nhật trạng thái thanh toán trong database
        // TODO: Gửi email xác nhận thanh toán
        // TODO: Cập nhật trạng thái học phí

        Log::info('Payment success processed', [
            'order_code' => $orderCode,
            'amount' => $webhookData['amount'] ?? 0
        ]);

        return [
            'success' => true,
            'message' => 'Payment success processed'
        ];
    }

    /**
     * Xử lý thanh toán bị hủy
     *
     * @param string $orderCode
     * @param array $webhookData
     * @return array
     */
    private function handlePaymentCancelled(string $orderCode, array $webhookData): array
    {
        // TODO: Cập nhật trạng thái thanh toán trong database

        Log::info('Payment cancelled processed', [
            'order_code' => $orderCode
        ]);

        return [
            'success' => true,
            'message' => 'Payment cancellation processed'
        ];
    }

    /**
     * Xử lý thanh toán hết hạn
     *
     * @param string $orderCode
     * @param array $webhookData
     * @return array
     */
    private function handlePaymentExpired(string $orderCode, array $webhookData): array
    {
        // TODO: Cập nhật trạng thái thanh toán trong database

        Log::info('Payment expired processed', [
            'order_code' => $orderCode
        ]);

        return [
            'success' => true,
            'message' => 'Payment expiration processed'
        ];
    }
}
