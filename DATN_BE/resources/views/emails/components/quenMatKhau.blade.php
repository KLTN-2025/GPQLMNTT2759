<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Reset Mật Khẩu - Mầm Non Hoa Sen</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: 'Inter', sans-serif; color: #334155;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f1f5f9; padding: 40px 0;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0"
                    style="background-color: #ffffff; border-radius: 18px; overflow: hidden; box-shadow: 0 12px 28px rgba(0,0,0,0.08);">

                    <!-- HEADER -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #1e293b, #334155); padding: 50px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #fff; font-size: 30px; font-weight: 700;">🏫 Mầm Non Hoa Sen</h1>
                            <p style="margin-top: 8px; color: #cbd5e1; font-size: 15px;">
                                Hệ thống Quản Lý Trường Mầm Non
                            </p>
                        </td>
                    </tr>

                    <!-- BODY -->
                    <tr>
                        <td style="padding: 45px 40px;">

                            <!-- Banner thông báo -->
                            <div style="background: #fff7ed; border: 1px solid #fdba74; padding: 18px 20px;
                                border-radius: 12px; margin-bottom: 25px;">
                                <h3 style="margin: 0; color: #c2410c; font-size: 17px; font-weight: 600;">
                                    📩 Yêu Cầu Tạo Mật Khẩu Mới
                                </h3>
                                <p style="margin: 6px 0 0; color: #c2410c; font-size: 14px;">
                                    Chúng tôi đã nhận yêu cầu reset mật khẩu của bạn.
                                </p>
                            </div>

                            <!-- Chào -->
                            <h2 style="margin: 0; margin-bottom: 10px; text-align: center; color: #1e293b; font-size: 23px;">
                                Xin chào <span style="color: #f59e0b;">{{ $ho_va_ten }}</span> 👋
                            </h2>
                            <p style="text-align: center; margin: 0 0 30px; color: #475569; font-size: 16px;">
                                Dưới đây là mã OTP để đặt lại mật khẩu cho tài khoản của bạn.
                            </p>

                            <!-- OTP -->
                            <div style="text-align: center; margin: 35px 0;">
                                <div style="
                                    display: inline-block;
                                    background: linear-gradient(135deg, #f59e0b, #d97706);
                                    color: #ffffff;
                                    padding: 22px 45px;
                                    border-radius: 18px;
                                    font-size: 34px;
                                    font-weight: 700;
                                    letter-spacing: 10px;
                                    box-shadow: 0 8px 20px rgba(245, 158, 11, 0.35);
                                ">
                                    {{ $otp }}
                                    {{-- 123456 --}}
                                </div>
                            </div>

                            <!-- Hiệu lực -->
                            <div style="background: #fee2e2; border: 1px solid #f87171;
                                padding: 20px; border-radius: 14px; text-align: center;">
                                <h4 style="margin: 0 0 8px; color: #b91c1c; font-size: 16px; font-weight: 600;">
                                    ⏳ Thời gian hiệu lực
                                </h4>
                                <p style="margin: 0; color: #b91c1c; font-size: 14px;">
                                    Mã OTP có hiệu lực trong <strong>5 phút</strong>.<br>
                                    Hãy yêu cầu mã mới nếu OTP đã hết hạn.
                                </p>
                            </div>

                            <!-- Note -->
                            <div style="background: #eff6ff; border: 1px solid #60a5fa; padding: 20px;
                                border-radius: 14px; margin-top: 30px;">
                                <h4 style="margin: 0 0 10px; color: #1d4ed8; font-size: 16px;">
                                    🔒 Lưu ý bảo mật
                                </h4>
                                <ul style="margin: 0; padding-left: 20px; color: #1d4ed8; font-size: 14px;">
                                    <li>Không chia sẻ mã OTP cho bất kỳ ai.</li>
                                    <li>Nếu bạn không yêu cầu thao tác này, hãy bỏ qua email.</li>
                                    <li>Liên hệ ngay với quản trị nếu nghi ngờ có truy cập bất thường.</li>
                                </ul>
                            </div>

                            <!-- Support -->
                            <div style="text-align: center; margin-top: 40px; padding-top: 30px; border-top: 1px solid #e2e8f0;">
                                <p style="margin: 0; color: #64748b; font-size: 14px;">
                                    Cần hỗ trợ? Liên hệ:
                                    <a href="mailto:support@qlmn.com" style="color: #f59e0b; font-weight: 600;">
                                        support@qlmn.com
                                    </a>
                                </p>
                            </div>

                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background: #f8fafc; text-align: center; padding: 25px;">
                            <p style="margin: 0; color: #64748b; font-size: 12px;">
                                © 2025 Mầm Non Hoa Sen. Tất cả quyền được bảo lưu.
                            </p>
                            <p style="margin: 0; color: #94a3b8; font-size: 11px;">
                                Địa chỉ: 123 Đường Giáo Dục, Quận 1, TP.HCM • Hotline: 1900-QLMN
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>
</body>

</html>
