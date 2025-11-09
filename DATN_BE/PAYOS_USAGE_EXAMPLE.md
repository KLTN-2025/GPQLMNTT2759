# PayOS Service - Hướng dẫn sử dụng

## Cấu hình

Thêm các biến môi trường vào file `.env`:

```env
# PayOS Configuration
PAYOS_CLIENT_ID=your_client_id_here
PAYOS_API_KEY=your_api_key_here
PAYOS_CHECKSUM_KEY=your_checksum_key_here
PAYOS_BASE_URL=https://api-merchant.payos.vn
PAYOS_RETURN_URL=http://127.0.0.1:8000/payment/success
PAYOS_CANCEL_URL=http://127.0.0.1:8000/payment/cancel
```

## API Endpoints

### 1. Tạo thanh toán học phí

```http
POST /api/payment/create-hoc-phi
Content-Type: application/json

{
    "id_hoc_phi": 1,
    "id_hoc_sinh": 1
}
```

**Response:**

```json
{
    "status": true,
    "message": "Tạo link thanh toán thành công",
    "data": {
        "payment_url": "https://pay.payos.vn/web/...",
        "order_code": "HOCPHI_1234567890_1234",
        "amount": 500000,
        "hoc_sinh": "Nguyễn Văn A",
        "hoc_phi": "Học phí tháng 1/2024"
    }
}
```

### 2. Tạo thanh toán tùy chỉnh

```http
POST /api/payment/create-custom
Content-Type: application/json

{
    "amount": 100000,
    "description": "Thanh toán dịch vụ bổ sung",
    "items": [
        {
            "name": "Dịch vụ xe đưa đón",
            "quantity": 1,
            "price": 100000
        }
    ],
    "expired_at": "2024-12-31 23:59:59"
}
```

### 3. Lấy thông tin thanh toán

```http
GET /api/payment/info?order_code=HOCPHI_1234567890_1234
```

### 4. Hủy thanh toán

```http
POST /api/payment/cancel
Content-Type: application/json

{
    "order_code": "HOCPHI_1234567890_1234",
    "reason": "Khách hàng yêu cầu hủy"
}
```

### 5. Danh sách thanh toán học phí

```http
GET /api/payment/hoc-phi-list?page=1
```

## Sử dụng trong Controller

```php
<?php

namespace App\Http\Controllers;

use App\Services\PayosService;
use Illuminate\Http\Request;

class YourController extends Controller
{
    protected $payosService;

    public function __construct(PayosService $payosService)
    {
        $this->payosService = $payosService;
    }

    public function createPayment(Request $request)
    {
        $paymentData = [
            'order_code' => $this->payosService->generateOrderCode('CUSTOM'),
            'amount' => 100000,
            'description' => 'Thanh toán dịch vụ',
            'items' => [
                [
                    'name' => 'Dịch vụ A',
                    'quantity' => 1,
                    'price' => 100000
                ]
            ]
        ];

        $result = $this->payosService->createPaymentLink($paymentData);

        if ($result['success']) {
            return redirect($result['data']['checkoutUrl']);
        } else {
            return back()->with('error', $result['message']);
        }
    }
}
```

## Sử dụng trực tiếp Service

```php
use App\Services\PayosService;

// Tạo instance
$payosService = new PayosService();

// Tạo thanh toán học phí
$hocPhiData = [
    'so_tien' => 500000,
    'ten_hoc_phi' => 'Học phí tháng 1/2024'
];

$hocSinhData = [
    'ho_va_ten' => 'Nguyễn Văn A'
];

$result = $payosService->createHocPhiPayment($hocPhiData, $hocSinhData);

if ($result['success']) {
    $paymentUrl = $result['data']['checkoutUrl'];
    // Redirect user to payment URL
} else {
    // Handle error
    $errorMessage = $result['message'];
}
```

## Webhook Handler

Tạo route webhook trong `routes/web.php`:

```php
Route::post('/payment/webhook', [PaymentController::class, 'handleWebhook']);
```

Webhook sẽ nhận các sự kiện:

-   `PAID`: Thanh toán thành công
-   `CANCELLED`: Thanh toán bị hủy
-   `EXPIRED`: Thanh toán hết hạn

## Xử lý Webhook

```php
public function handleWebhook(Request $request)
{
    $webhookData = $request->all();

    // Xác thực webhook
    if (!$this->payosService->verifyWebhook($webhookData)) {
        return response()->json(['error' => 'Invalid signature'], 400);
    }

    $orderCode = $webhookData['orderCode'];
    $status = $webhookData['status'];

    switch ($status) {
        case 'PAID':
            // Cập nhật trạng thái thanh toán thành công
            $this->updatePaymentStatus($orderCode, 'paid');
            break;
        case 'CANCELLED':
            // Cập nhật trạng thái thanh toán bị hủy
            $this->updatePaymentStatus($orderCode, 'cancelled');
            break;
        case 'EXPIRED':
            // Cập nhật trạng thái thanh toán hết hạn
            $this->updatePaymentStatus($orderCode, 'expired');
            break;
    }

    return response()->json(['success' => true]);
}
```

## Các method chính của PayosService

### 1. createPaymentLink($data)

Tạo link thanh toán mới

### 2. getPaymentInfo($orderCode)

Lấy thông tin thanh toán theo order code

### 3. cancelPayment($orderCode, $reason)

Hủy thanh toán

### 4. verifyWebhook($data)

Xác thực webhook từ PayOS

### 5. createHocPhiPayment($hocPhiData, $hocSinhData)

Tạo thanh toán học phí (method tiện ích)

### 6. generateOrderCode($prefix)

Tạo order code duy nhất

### 7. handleWebhook($webhookData)

Xử lý webhook từ PayOS

## Lưu ý quan trọng

1. **Bảo mật**: Luôn xác thực webhook trước khi xử lý
2. **Logging**: Service tự động log các hoạt động quan trọng
3. **Error Handling**: Luôn kiểm tra kết quả trả về
4. **Order Code**: Phải duy nhất, sử dụng `generateOrderCode()`
5. **Amount**: Số tiền tính bằng VND (không có dấu phẩy)

## Testing

Để test trong môi trường development, sử dụng PayOS sandbox:

```env
PAYOS_BASE_URL=https://api-merchant-sandbox.payos.vn
```

## Troubleshooting

### Lỗi thường gặp:

1. **Invalid signature**: Kiểm tra `PAYOS_CHECKSUM_KEY`
2. **Invalid client ID**: Kiểm tra `PAYOS_CLIENT_ID`
3. **Invalid API key**: Kiểm tra `PAYOS_API_KEY`
4. **Order code exists**: Sử dụng `generateOrderCode()` để tạo code mới

### Debug:

Bật logging để xem chi tiết lỗi:

```php
Log::info('PayOS Debug', [
    'request_data' => $data,
    'response' => $result
]);
```
