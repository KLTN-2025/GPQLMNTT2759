# 🎨 DATN Frontend - Hệ Thống Quản Lý Mầm Non

Frontend application cho hệ thống quản lý trường mầm non, được xây dựng với Vue 3 + Vuetify 3.

## 📋 Mục lục

- [Tính năng](#-tính-năng)
- [Công nghệ](#️-công-nghệ)
- [Yêu cầu hệ thống](#-yêu-cầu-hệ-thống)
- [Cài đặt](#-cài-đặt)
- [Cấu hình](#️-cấu-hình)
- [Cấu trúc dự án](#-cấu-trúc-dự-án)
- [Deployment](#-deployment)

## ✨ Tính năng

### 🌐 3 Portal chính

#### **1. 👨‍💼 Admin Portal** (`/admin/*`)

- 📊 Dashboard với biểu đồ thống kê
- 👥 Quản lý người dùng (nhân viên, giáo viên, phụ huynh, học sinh)
- 🏫 Quản lý lớp học và năm học
- 🔐 Phân quyền chi tiết
- 💰 Quản lý học phí và tài chính
- 🍽️ Quản lý thực đơn và món ăn
- 💊 Theo dõi sức khỏe học sinh
- 📢 Gửi thông báo
- 📰 Quản lý bài viết/tin tức
- 📅 Lịch làm việc nhân viên

#### **2. 👨‍🏫 Teacher Portal** (`/teacher/*`)

- 📚 Quản lý lớp học của mình
- ✅ Điểm danh học sinh hàng ngày
- 💬 Chat với phụ huynh
  - Chat 1-1 riêng tư
  - Group chat theo lớp
- 📝 Tạo và quản lý báo cáo
- 💊 Theo dõi sức khỏe học sinh
- 🗓️ Xem lịch làm việc
- 📊 Xem báo cáo tiến độ
- 👤 Quản lý profile cá nhân

#### **3. 👨‍👩‍👧‍👦 Parent/Client Portal** (`/` và `/client/*`)

- 🏠 Trang chủ với thông tin trường
- 📰 Xem tin tức và bài viết
- 👶 Thông tin con em
- 🍽️ Xem thực đơn hàng ngày/tuần
- 💰 Tra cứu và thanh toán học phí
- 💬 Chat với giáo viên
- 📢 Nhận thông báo
- 📖 Sổ liên lạc điện tử
- 👤 Quản lý profile

### 🎨 UI/UX Features

- 🎨 Material Design với Vuetify 3
- 📱 Responsive design (mobile, tablet, desktop)
- 🌙 Dark mode support (tùy chọn)
- 🔔 Real-time notifications
- 💬 Real-time chat với Pusher
- 📊 Interactive charts với ECharts
- 🎭 Smooth animations và transitions
- 🖼️ Image galleries
- 📄 PDF export (jsPDF)
- 📊 Excel export (xlsx)

### 🤖 AI Features

- 💬 Chatbot tư vấn tự động
- 🧠 Powered by Groq SDK
- 📚 Tra cứu thông tin trường học
- 🍽️ Hỏi đáp về thực đơn

## 🛠️ Công nghệ

### Core Framework

- **Vue**: 3.3.4
- **Vite**: 6.3.5 - Build tool
- **Vue Router**: 4.0.13 - Routing
- **Vuetify**: 3.9.0 - Material Design Components

### UI & Styling

- **@mdi/font**: 7.4.47 - Material Design Icons
- **@mui/icons-material**: 7.2.0 - MUI Icons
- **Sass**: 1.89.2 - CSS preprocessor

### Communication

- **Axios**: 1.10.0 - HTTP client
- **laravel-echo**: 2.2.6 - WebSocket client
- **pusher-js**: 8.4.0 - Real-time messaging

### Charts & Visualization

- **chart.js**: 4.5.0 - Charts
- **echarts**: 5.5.1 - Advanced charts
- **vue-echarts**: 7.0.3 - Vue ECharts wrapper

### AI & Utilities

- **groq-sdk**: 0.37.0 - AI chatbot
- **@meforma/vue-toaster**: 1.3.0 - Toast notifications
- **jspdf**: 3.0.3 - PDF generation
- **jspdf-autotable**: 5.0.2 - PDF tables
- **xlsx**: 0.18.5 - Excel export/import
- **swiper**: 11.2.10 - Image slider
- **page-flip**: 2.0.7 - Book flip effect

### Development Tools

- **ESLint**: 8.57.0 - Code linting
- **eslint-plugin-vue**: 9.23.0 - Vue linting

## 📦 Yêu cầu hệ thống

```
- Node.js >= 18.x
- NPM >= 9.x hoặc Yarn >= 1.22
- Modern browser (Chrome, Firefox, Safari, Edge)
```

## 🚀 Cài đặt

### 1. Clone repository

```bash
git clone https://github.com/KLTN-2025/GPQLMNTT2759.git
cd GPQLMNTT2759/DATN_FE
```

### 2. Cài đặt dependencies

```bash
npm install
# hoặc
yarn install
```

### 3. Cấu hình môi trường

```bash
# Copy file .env.example
cp .env.example .env
```

Cập nhật file `.env`:

```env
# API Backend URL
VITE_API_URL=http://localhost:8000/api

# Pusher Configuration
VITE_PUSHER_APP_KEY=your_pusher_key
VITE_PUSHER_APP_CLUSTER=ap1

# Groq AI
VITE_GROQ_API_KEY=your_groq_api_key
```

### 4. Khởi động development server

```bash
npm run dev
# hoặc
yarn dev
```

Application sẽ chạy tại: `http://localhost:5173`

## ⚙️ Cấu hình

### API Configuration

File `src/main.js` chứa cấu hình axios:

```javascript
axios.defaults.baseURL =
  import.meta.env.VITE_API_URL || "http://localhost:8000/api";
```

### Router Configuration

File `src/router/index.js` định nghĩa routes với 3 layout chính:

- **blank**: Trang login, forgot password
- **client**: Portal phụ huynh
- **teacher**: Portal giáo viên
- **admin**: Portal quản trị (default layout)

### Pusher/Echo Configuration

Real-time chat được cấu hình trong các component chat:

```javascript
import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;
window.Echo = new Echo({
  broadcaster: "pusher",
  key: import.meta.env.VITE_PUSHER_APP_KEY,
  cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
  forceTLS: true,
});
```

## 📁 Cấu trúc dự án

```
DATN_FE/
├── public/                      # Static assets
│   └── favicon.ico
├── src/
│   ├── components/             # Vue components
│   │   ├── Admin/             # Admin portal components
│   │   │   ├── Dashboard/
│   │   │   ├── Students/
│   │   │   ├── Teachers/
│   │   │   ├── Parents/
│   │   │   ├── Classes/
│   │   │   ├── Tuition/
│   │   │   ├── Menu/
│   │   │   ├── Health/
│   │   │   ├── Notifications/
│   │   │   ├── Articles/
│   │   │   └── ...
│   │   ├── Teachers/          # Teacher portal components
│   │   │   ├── Dashboard/
│   │   │   ├── MyClass/
│   │   │   ├── Attendance/
│   │   │   ├── Messages/
│   │   │   ├── Health/
│   │   │   ├── Reports/
│   │   │   └── ...
│   │   └── Client/            # Parent/Client portal components
│   │       ├── HomePage/
│   │       ├── Blog/
│   │       ├── Contact/
│   │       ├── Messages/
│   │       ├── Tuition/
│   │       ├── Meal/
│   │       ├── Profile/
│   │       └── ...
│   ├── router/                # Vue Router configuration
│   │   ├── index.js          # Main routes
│   │   ├── checkAdmin.js     # Admin auth guard
│   │   ├── checkTeacher.js   # Teacher auth guard
│   │   └── checkClient.js    # Client auth guard
│   ├── assets/               # Images, styles
│   ├── layouts/              # Layout components (nếu có)
│   ├── App.vue               # Root component
│   └── main.js               # Application entry point
├── .env.example              # Environment template
├── .eslintrc.js             # ESLint configuration
├── index.html               # HTML template
├── package.json             # NPM dependencies & scripts
├── vite.config.js           # Vite configuration
└── README.md                # This file
```

### Component Structure

#### Admin Components (`/src/components/Admin/`)

```
Admin/
├── Dashboard/               # Trang chủ admin
├── Students/               # Quản lý học sinh
├── Teachers/               # Quản lý giáo viên
├── Parents/                # Quản lý phụ huynh
├── Staff/                  # Quản lý nhân viên
├── Classes/                # Quản lý lớp học
├── Permissions/            # Phân quyền
├── Tuition/                # Quản lý học phí
├── Menu/                   # Quản lý thực đơn
├── Health/                 # Quản lý sức khỏe
├── Notifications/          # Quản lý thông báo
├── Articles/               # Quản lý bài viết
├── Schedule/               # Lịch làm việc
└── Profile/                # Profile admin
```

#### Teacher Components (`/src/components/Teachers/`)

```
Teachers/
├── Dashboard/              # Trang chủ giáo viên
├── MyClass/                # Lớp học của tôi
├── Attendance/             # Điểm danh
├── Messages/               # Tin nhắn
├── Health/                 # Sức khỏe học sinh
├── Reports/                # Báo cáo
├── Progress/               # Tiến độ học tập
├── Schedule/               # Lịch làm việc
└── Profile/                # Profile giáo viên
```

#### Client Components (`/src/components/Client/`)

```
Client/
├── HomePage/               # Trang chủ
├── Blog/                   # Tin tức
├── Contact/                # Liên hệ
├── Messages/               # Tin nhắn với giáo viên
├── Tuition/                # Học phí
├── Meal/                   # Thực đơn
├── Notebook/               # Sổ liên lạc
├── Profile/                # Thông tin cá nhân
├── Auth/                   # Đăng nhập/đăng ký
└── ...
```

## 🔧 Commands hữu ích

### Development

```bash
# Start dev server
npm run dev

# Build for production
npm run build

# Preview production build
npm run preview

# Run linter
npm run lint

# Type check (nếu dùng TypeScript)
npm run type-check
```

### Build & Deployment

```bash
# Build for production
npm run build:prod

# Build output sẽ ở thư mục dist/
```

## 📱 Responsive Breakpoints

Application được tối ưu cho các breakpoints sau (Vuetify):

```
xs: 0-600px      # Mobile
sm: 600-960px    # Tablet portrait
md: 960-1264px   # Tablet landscape
lg: 1264-1904px  # Desktop
xl: 1904px+      # Large desktop
```

## 🎨 Theming

### Vuetify Theme

Cấu hình trong `src/main.js`:

```javascript
const vuetify = createVuetify({
  theme: {
    defaultTheme: "light",
    themes: {
      light: {
        colors: {
          primary: "#1976D2",
          secondary: "#424242",
          accent: "#82B1FF",
          error: "#FF5252",
          info: "#2196F3",
          success: "#4CAF50",
          warning: "#FFC107",
        },
      },
    },
  },
});
```

## 🔒 Authentication & Guards

### Route Guards

3 loại guard được sử dụng:

**Admin Guard** (`/src/router/checkAdmin.js`)

```javascript
// Kiểm tra admin token và role
if (!token || role !== "admin") {
  return "/admin/login";
}
```

**Teacher Guard** (`/src/router/checkTeacher.js`)

```javascript
// Kiểm tra teacher token
if (!token) {
  return "/teacher/login";
}
```

**Client Guard** (`/src/router/checkClient.js`)

```javascript
// Kiểm tra client/parent token
if (!token) {
  return "/login";
}
```

### Token Storage

Token được lưu trong localStorage:

```javascript
// Lưu token
localStorage.setItem("admin_token", token);
localStorage.setItem("teacher_token", token);
localStorage.setItem("parent_token", token);

// Axios interceptor tự động gửi token
axios.interceptors.request.use((config) => {
  const token = localStorage.getItem("admin_token");
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});
```

## 🚀 Deployment

### Build cho Production

```bash
npm run build
```

Thư mục `dist/` sẽ chứa files đã build.

### Deployment Options

#### 1. **Netlify** (Recommended)

File `netlify.toml` đã được cấu hình:

```toml
[build]
  publish = "dist"
  command = "npm run build"

[[redirects]]
  from = "/*"
  to = "/index.html"
  status = 200
```

Deploy:

```bash
# Connect to Netlify
netlify init

# Deploy
netlify deploy --prod
```

#### 2. **Vercel**

File `vercel.json` đã được cấu hình:

```bash
vercel --prod
```

#### 3. **Docker**

File `Dockerfile` đã sẵn sàng:

```bash
docker build -t datn-fe .
docker run -p 80:80 datn-fe
```

#### 4. **Static Hosting**

Upload thư mục `dist/` lên:

- GitHub Pages
- Firebase Hosting
- AWS S3 + CloudFront
- Azure Static Web Apps

### Environment Variables for Production

Đảm bảo cập nhật `.env.production`:

```env
VITE_API_URL=https://your-api-domain.com/api
VITE_PUSHER_APP_KEY=your_production_pusher_key
VITE_PUSHER_APP_CLUSTER=ap1
```

## 🐛 Debugging

### Vue DevTools

Cài đặt Vue DevTools extension để debug:

- [Chrome Extension](https://chrome.google.com/webstore/detail/vuejs-devtools/nhdogjmejiglipccpnnnanhbledajbpd)
- [Firefox Extension](https://addons.mozilla.org/en-US/firefox/addon/vue-js-devtools/)

### Console Logs

Trong development mode, bật console logs:

```javascript
if (import.meta.env.DEV) {
  console.log("Debug info:", data);
}
```

## 🆘 Troubleshooting

### Common Issues

**1. "Cannot connect to API"**

```bash
# Kiểm tra VITE_API_URL trong .env
# Đảm bảo backend đang chạy
```

**2. "Module not found"**

```bash
# Xóa node_modules và reinstall
rm -rf node_modules package-lock.json
npm install
```

**3. "Chat không hoạt động"**

```bash
# Kiểm tra Pusher credentials
# Đảm bảo Laravel Echo đã được cấu hình đúng
```

**4. "Build failed"**

```bash
# Clear cache và rebuild
npm run clean
npm run build
```

## 📚 Documentation Links

- [Vue 3 Docs](https://vuejs.org/)
- [Vuetify 3 Docs](https://vuetifyjs.com/)
- [Vite Docs](https://vitejs.dev/)
- [Vue Router Docs](https://router.vuejs.org/)
- [ECharts Docs](https://echarts.apache.org/)

## 📝 License

[MIT License](LICENSE)

## 👥 Team

Dự án tốt nghiệp - KLTN 2025

---

**Happy Coding! 🎨✨**
