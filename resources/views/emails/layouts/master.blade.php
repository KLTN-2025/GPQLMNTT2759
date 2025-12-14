<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Hoa Sen School')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,.1);
        }
        .header {
            background: #0d6efd;
            color: #fff;
            padding: 15px;
            text-align: center;
            border-radius: 12px 12px 0 0;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 13px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>@yield('header', 'Thông báo từ Hoa Sen School')</h2>
        </div>

        <div class="content">
            @yield('content')
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} Hoa Sen School. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
