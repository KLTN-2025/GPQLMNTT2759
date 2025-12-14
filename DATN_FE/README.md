# 🌟 Laura School – Digital Kindergarten Platform

> Một hệ sinh thái Vue 3 giúp số hóa toàn bộ hoạt động của trường mầm non, kết nối chặt chẽ giữa **Ban giám hiệu – Giáo viên – Phụ huynh**.

---

## 🧭 Tổng quan

Laura School tách giao diện theo 3 miền chức năng:

| Không gian  | Đường dẫn chính  | Mô tả                                                                  |
| ----------- | ---------------- | ---------------------------------------------------------------------- |
| **Client**  | `/`, `/login`, … | Website/phụ huynh: giới thiệu, blog, sự kiện, hồ sơ, học phí, mailbox  |
| **Admin**   | `/admin/**`      | Ban giám hiệu: dashboard, nhân sự, lớp học, học phí, thực đơn, báo cáo |
| **Teacher** | `/teacher/**`    | Giáo viên: điểm danh, bài giảng, nhật ký, sức khỏe, thực đơn, báo cáo  |

Mỗi miền có màn hình **Login / Forgot Password / Reset Password** và gọi API thông qua client riêng (baseRequestClient/Admin/Teacher).

---

## ✨ Tính năng chính

### Client (Phụ huynh)

- Landing page, chương trình học, blog/sự kiện.
- Quản lý hồ sơ phụ huynh & con, lịch học, sổ liên lạc.
- Theo dõi học phí, lịch sử thanh toán, hướng dẫn nộp tiền.
- Mailbox/notification kết nối với giáo viên & nhà trường.

### Admin

- Dashboard tổng quan, thống kê học phí – sĩ số – sức khỏe.
- Quản lý nhân sự, phân quyền, lịch làm việc.
- Quản lý học sinh, lớp học, điểm danh, thực đơn, sức khỏe.
- Quản lý thông báo, bài viết, hoạt động ngoại khóa.

### Teacher

- Dashboard lớp phụ trách, lịch dạy.
- Ghi nhật ký lớp, gửi thông báo, đánh giá học sinh.
- Quản lý bài giảng, kế hoạch bài học, thực đơn trong ngày.

---

## 🗂 Cấu trúc chính

```
src/
├─ assets/                # Logo, hình ảnh, icon
├─ components/
│  ├─ Client/             # Module giao diện phụ huynh
│  ├─ Admin/              # Module quản trị
│  └─ Teachers/          # Module giáo viên
├─ core/
│  ├─ baseRequestClient.ts
│  ├─ baseRequestAdmin.ts
│  └─ baseRequestTeacher.ts
├─ layout/                # Layout & menu dùng chung
├─ router/
│  ├─ index.js            # Khai báo route
│  ├─ checkAdmin.js       # route guard
│  └─ checkTeacher.js
└─ store/, utils/, ...
```

---

## 🛠 Tech stack

- **Vue 3** + **Vite**
- **Vue Router**
- **Pinia** (nếu dùng store tập trung)
- **Axios** (request layer riêng cho từng vai trò)
- **SCSS / CSS Modules**
- **Font Awesome / Boxicons**
- **ESLint & Prettier**

---

## ⚙️ Cài đặt & chạy

```bash
# 1. Cài dependencies
npm install

# 2. Chạy môi trường phát triển
npm run dev

# 3. Build production
npm run build

# 4. Preview production build
npm run preview

# 5. Lint code (nếu đã setup ESLint)
npm run lint

# 6. Type check (nếu dùng TypeScript)
npm run type-check
```

> Cấu hình endpoint/tokens trong `.env`. Ví dụ: `VITE_API_URL`, `VITE_ADMIN_TOKEN_KEY`, …

---

## 🚀 CI/CD Pipeline

Dự án đã được cấu hình với **GitHub Actions** để tự động build, test và deploy.

### Workflows có sẵn:

- **CI Pipeline**: Build và test tự động khi push/PR
- **Deploy to Vercel**: Deploy tự động lên Vercel
- **Deploy to Netlify**: Deploy tự động lên Netlify
- **Deploy to FTP**: Deploy tự động lên FTP server
- **Docker Build**: Build và push Docker image
- **Code Quality**: Kiểm tra code quality
- **Security Scan**: Quét lỗ hổng bảo mật

### Setup CI/CD:

Xem chi tiết trong file [`CI_CD_SETUP.md`](./CI_CD_SETUP.md)

**Quick Start:**
1. Push code lên GitHub
2. Vào **Settings → Secrets and variables → Actions**
3. Thêm secrets cần thiết (Vercel/Netlify/FTP tokens)
4. Workflows sẽ tự động chạy khi push code

### Docker Deployment:

```bash
# Build Docker image
docker build -t laura-school .

# Run container
docker run -p 80:80 laura-school
```

---

## 🔐 Định tuyến & phân quyền

- Client: `/login`, `/forgot-password`, `/reset-password`.
- Teacher: `/teacher/login`, `/teacher/forgot-password`, `/teacher/reset-password`.
- Admin: `/admin/login`, `/admin/forgot-password`, `/admin/reset-password`.
- Route `/admin/**` được bảo vệ bởi `checkAdmin`, `/teacher/**` bởi `checkTeacher`. Hai guard này kiểm tra token từ localStorage và chuyển hướng nếu chưa xác thực.

---

## 🌈 Quy ước UI

- Client dùng tông sáng, nhấn mạnh hình ảnh marketing (HomePage, Blog, Events…).
- Admin & Teacher dùng theme gradient tím–xanh, card bo tròn, đổ bóng nhẹ.
- Form tĩnh (ví dụ `Client/Profile`) đã có data mẫu để dễ dàng thay bằng dữ liệu API.
- Khi thêm component mới, tạo file SCSS riêng trong cùng thư mục để tránh xung đột.

---

## 🧪 Tài liệu phát triển

- Ưu tiên viết logic hiển thị ngay trong template bằng `v-if`, computed thay cho getter rời rạc.
- Với các request, sử dụng đúng client (`baseRequestClient`, `baseRequestAdmin`, `baseRequestTeacher`) để tự động gắn baseURL & token.
- Khi mở rộng router, thêm meta `layout` (`client`, `blank`, `admin`, …) để layout wrapper biết cách render.

---

## 🤝 Đóng góp

1. Fork & tạo nhánh mới.
2. Commit theo chuẩn rõ ràng.
3. Tạo Pull Request mô tả thay đổi & ảnh minh họa (nếu có).

---

## 📮 Liên hệ

- Website: [https://lauraschool.edu.vn](https://lauraschool.edu.vn)
- Email: info.contact@lauraschool.edu.vn
- Facebook: [fb.com/lauraschool](https://facebook.com/lauraschool)
- Youtube · Zalo · TikTok: đang cập nhật

> **Slogan**: “Laura School – Quản lý thông minh, kết nối yêu thương.”

---

🎉 Cảm ơn bạn đã đồng hành cùng dự án!
