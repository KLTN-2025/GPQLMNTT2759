# 🎓 DATN Backend - Hệ Thống Quản Lý Mầm Non

Backend API cho hệ thống quản lý trường mầm non, được xây dựng với Laravel 12.

## 📋 Mục lục

-   [Tính năng](#-tính-năng)
-   [Công nghệ](#️-công-nghệ)
-   [Yêu cầu hệ thống](#-yêu-cầu-hệ-thống)
-   [Cài đặt](#-cài-đặt)
-   [Cấu hình](#️-cấu-hình)
-   [API Documentation](#-api-documentation)
-   [Cấu trúc dự án](#-cấu-trúc-dự-án)

## ✨ Tính năng

### 👥 Quản lý người dùng (3 vai trò)

#### **Admin (Quản trị viên)**

-   📊 Dashboard và thống kê tổng quan
-   👨‍💼 Quản lý nhân viên
-   👨‍🏫 Quản lý giáo viên
-   👶 Quản lý học sinh
-   👪 Quản lý phụ huynh
-   🏫 Quản lý lớp học & năm học
-   🔐 Phân quyền và quản lý chức vụ

#### **Giáo viên (Teacher)**

-   👨‍👩‍👧‍👦 Quản lý lớp học của mình
-   ✅ Điểm danh học sinh
-   💬 Chat với phụ huynh (1-1 và group chat)
-   📝 Báo cáo hoạt động
-   🗓️ Xem lịch làm việc
-   💊 Theo dõi sức khỏe học sinh

#### **Phụ huynh (Parent)**

-   👀 Xem thông tin con em
-   💬 Chat với giáo viên
-   🍽️ Xem thực đơn
-   💰 Tra cứu và thanh toán học phí
-   📢 Nhận thông báo

### 🏫 Quản lý học vụ

-   📚 Quản lý lớp học và năm học
-   ✅ Điểm danh tự động
-   📊 Báo cáo định kỳ
-   📅 Lịch làm việc giáo viên và nhân viên

### 🍽️ Quản lý dinh dưỡng

-   🥗 Quản lý thực đơn theo ngày/tuần
-   🍲 Quản lý món ăn và bữa ăn
-   📋 Chi tiết thực đơn với dinh dưỡng
-   📊 Thống kê món ăn

### 💰 Quản lý tài chính

-   💳 Quản lý học phí theo học kỳ
-   💸 Theo dõi thanh toán
-   📄 Xuất hóa đơn
-   📊 Thống kê thu chi

### 💊 Quản lý sức khỏe

-   📋 Hồ sơ sức khỏe học sinh
-   📏 Theo dõi chiều cao, cân nặng
-   💉 Lịch sử khám bệnh
-   📊 Thống kế sức khỏe

### 📢 Thông báo & Tin tức

-   📣 Gửi thông báo cho phụ huynh
-   📰 Quản lý bài viết/tin tức
-   ✉️ Thông báo theo nhóm đối tượng

### 💬 Hệ thống Chat

-   💬 Chat 1-1 giữa giáo viên và phụ huynh
-   👥 Group chat theo lớp học
-   🔔 Thông báo tin nhắn mới
-   ✅ Đánh dấu đã đọc

### 🤖 AI Chatbot

-   💬 Tư vấn tự động bằng Groq AI
-   📚 Tra cứu thông tin trường học
-   🍽️ Hỏi thực đơn, lịch học
-   👨‍🏫 Thông tin giáo viên, học sinh

## 🛠️ Công nghệ

### Core Framework

-   **Laravel**: 12.x
-   **PHP**: ^8.2
-   **Database**: MySQL 8.0+

### Main Packages

-   **laravel/sanctum**: ^4.0 - API authentication
-   **laravel/reverb**: ^1.6 - WebSocket broadcasting
-   **pusher/pusher-php-server**: ^7.2 - Real-time messaging
-   **darkaonline/l5-swagger**: ^9.0 - API documentation

### Development Tools

-   **laravel/pint**: ^1.13 - Code styling
-   **laravel/sail**: ^1.41 - Docker development
-   **phpunit/phpunit**: ^11.5.3 - Testing

## 📦 Yêu cầu hệ thống

### Môi trường phát triển

```
- PHP >= 8.2
- Composer >= 2.0
- MySQL >= 8.0 hoặc MariaDB >= 10.5
- Node.js >= 18.x & NPM >= 9.x
- XAMPP/WAMP/MAMP hoặc Laravel Sail
```

### Extensions PHP cần thiết

```
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
```

## 🚀 Cài đặt

### 1. Clone repository

```bash
git clone https://github.com/KLTN-2025/GPQLMNTT2759.git
cd GPQLMNTT2759/DATN_BE
```

### 2. Cài đặt dependencies

```bash
composer install
```

### 3. Cấu hình môi trường

```bash
# Copy file .env.example
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Cấu hình database

Mở file `.env` và cập nhật thông tin database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=datn_be
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Chạy migration và seeder

```bash
# Tạo database nếu chưa có
mysql -u root -p -e "CREATE DATABASE datn_be;"

# Chạy migration
php artisan migrate

# Chạy seeder (tùy chọn - tạo dữ liệu mẫu)
php artisan db:seed
```

### 6. Khởi động server

```bash
php artisan serve
```

Server sẽ chạy tại: `http://localhost:8000`

## ⚙️ Cấu hình

### Email Configuration

Để gửi email reset password, cấu hình SMTP trong `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

📖 **Xem hướng dẫn chi tiết**: [GMAIL_SETUP.md](GMAIL_SETUP.md)

### Pusher/Broadcasting (Real-time)

Cấu hình cho chat real-time:

```env
BROADCAST_CONNECTION=pusher

PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=ap1
```

### Groq AI Configuration

Để sử dụng chatbot AI:

```env
GROQ_API_KEY=your_groq_api_key_here
```

> ⚠️ **Lưu ý**: Đừng commit file `.env` vào Git. API key phải được giữ bí mật.

## 📚 API Documentation

### Swagger UI

Truy cập API documentation tại:

```
http://localhost:8000/api/documentation
```

### Main API Endpoints

#### 🔐 Authentication

**Admin Login**

```http
POST /api/admin/login
Content-Type: application/json

{
  "email": "admin@example.com",
  "password": "password"
}
```

**Teacher Login**

```http
POST /api/teacher/login
Content-Type: application/json

{
  "email": "teacher@example.com",
  "password": "password"
}
```

**Parent Login**

```http
POST /api/login
Content-Type: application/json

{
  "email": "parent@example.com",
  "password": "password"
}
```

#### 👥 User Management (Admin Only)

**Get Students**

```http
GET /api/admin/hoc-sinh/data
Authorization: Bearer {token}
```

**Create Student**

```http
POST /api/admin/hoc-sinh/create
Authorization: Bearer {token}
Content-Type: application/json

{
  "ho_ten": "Nguyen Van A",
  "ngay_sinh": "2020-01-01",
  "gioi_tinh": 1,
  "id_phu_huynh": 1,
  "id_lop_hoc": 1
}
```

#### 💬 Chat API

**Get Conversations (Teacher/Parent)**

```http
GET /api/teacher/chat/conversations
Authorization: Bearer {token}
```

**Send Message**

```http
POST /api/teacher/chat/send-message
Authorization: Bearer {token}
Content-Type: application/json

{
  "conversation_id": 1,
  "message": "Hello"
}
```

**Group Chat Messages**

```http
GET /api/teacher/group-chat/{groupId}/messages
Authorization: Bearer {token}
```

#### 🤖 AI Chatbot

**Chat with AI**

```http
POST /api/tu-van-ai
Content-Type: application/json

{
  "message": "Hôm nay thực đơn có món gì?",
  "conversation_history": []
}
```

### 📱 Client API Endpoints

Tất cả client APIs sử dụng prefix `/api/client` hoặc `/api/phu-huynh`:

```
GET    /api/client/profile/data          - Lấy thông tin profile
POST   /api/client/profile/update        - Cập nhật profile
GET    /api/client/bai-viet/data         - Lấy danh sách bài viết
GET    /api/client/chat/conversations    - Lấy danh sách cuộc trò chuyện
POST   /api/client/chat/send-message     - Gửi tin nhắn
```

## 📁 Cấu trúc dự án

```
DATN_BE/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Controllers
│   │   │   ├── Api/             # API Controllers
│   │   │   ├── BaiVietController.php
│   │   │   ├── ChatController.php
│   │   │   ├── GiaoVienController.php
│   │   │   ├── HocSinhController.php
│   │   │   └── ...
│   │   └── Middleware/          # Custom middleware
│   ├── Models/                  # Eloquent models
│   └── Services/               # Business logic services
├── config/                     # Configuration files
├── database/
│   ├── migrations/            # Database migrations
│   ├── seeders/              # Database seeders
│   └── factories/            # Model factories
├── routes/
│   ├── api.php               # API routes
│   └── web.php               # Web routes
├── storage/
│   ├── app/                  # Application files
│   ├── framework/            # Framework files
│   └── logs/                 # Log files
├── .env.example              # Environment template
├── composer.json             # PHP dependencies
└── artisan                   # CLI tool
```

### Key Directories

-   **`app/Http/Controllers`**: Chứa tất cả controllers xử lý logic nghiệp vụ
-   **`app/Models`**: Models đại diện cho các bảng database
-   **`database/migrations`**: Schema định nghĩa cấu trúc database
-   **`database/seeders`**: Tạo dữ liệu mẫu
-   **`routes/api.php`**: Định nghĩa tất cả API endpoints
-   **`storage/logs`**: Log files của application

## 🔧 Commands hữu ích

### Development

```bash
# Chạy development server
php artisan serve

# Xem danh sách routes
php artisan route:list

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Tạo controller mới
php artisan make:controller YourController

# Tạo model mới
php artisan make:model YourModel -m

# Tạo migration
php artisan make:migration create_your_table
```

### Database

```bash
# Chạy migrations
php artisan migrate

# Rollback migration
php artisan migrate:rollback

# Reset database
php artisan migrate:fresh

# Reset và seed
php artisan migrate:fresh --seed
```

### Testing

```bash
# Chạy tests
php artisan test

# Chạy specific test
php artisan test --filter=YourTestName
```

## 🔒 Bảo mật

-   ✅ Tất cả API endpoints yêu cầu authentication (trừ login/register)
-   ✅ Sử dụng Laravel Sanctum cho token-based authentication
-   ✅ CORS được cấu hình chính xác
-   ✅ Input validation cho tất cả requests
-   ✅ Password được hash bằng bcrypt
-   ✅ Protection against SQL injection, XSS
-   ⚠️ **Không bao giờ commit file `.env`**
-   ⚠️ **API keys phải được bảo mật**

## 📝 License

[MIT License](LICENSE)

## 👥 Team

Dự án tốt nghiệp - KLTN 2025

## 🆘 Hỗ trợ

Nếu gặp vấn đề, vui lòng:

1. Kiểm tra [GMAIL_SETUP.md](GMAIL_SETUP.md) cho email configuration
2. Kiểm tra file `storage/logs/laravel.log`
3. Đảm bảo database đã được migrate
4. Kiểm tra permission của thư mục `storage/` và `bootstrap/cache/`

---

**Happy Coding! 🚀**
