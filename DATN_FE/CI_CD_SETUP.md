# 🚀 Hướng dẫn Setup CI/CD

Dự án này đã được cấu hình với GitHub Actions để tự động build, test và deploy.

## 📋 Tổng quan

### Workflows có sẵn:

1. **CI Pipeline** (`.github/workflows/ci.yml`)
   - Chạy khi push/PR vào `main`, `develop`, `master`
   - Build project với Node.js 18.x và 20.x
   - Chạy linter (nếu có)
   - Upload build artifacts

2. **Deploy to Vercel** (`.github/workflows/deploy-vercel.yml`)
   - Deploy tự động khi push vào `main`/`master`
   - Cần setup Vercel secrets

3. **Deploy to Netlify** (`.github/workflows/deploy-netlify.yml`)
   - Deploy tự động khi push vào `main`/`master`
   - Cần setup Netlify secrets

4. **Deploy to FTP** (`.github/workflows/deploy-ftp.yml`)
   - Deploy tự động khi push vào `main`/`master`
   - Cần setup FTP secrets

5. **Docker Build** (`.github/workflows/deploy-docker.yml`)
   - Build và push Docker image lên GitHub Container Registry
   - Chạy khi push tags `v*` hoặc vào `main`/`master`

---

## 🔧 Setup Secrets trong GitHub

### 1. Vào Settings → Secrets and variables → Actions

### 2. Thêm các secrets sau:

#### Cho Vercel:
- `VERCEL_TOKEN`: Token từ Vercel dashboard
- `VERCEL_ORG_ID`: Organization ID từ Vercel
- `VERCEL_PROJECT_ID`: Project ID từ Vercel

#### Cho Netlify:
- `NETLIFY_AUTH_TOKEN`: Token từ Netlify dashboard
- `NETLIFY_SITE_ID`: Site ID từ Netlify

#### Cho FTP:
- `FTP_SERVER`: Địa chỉ FTP server (ví dụ: ftp.example.com)
- `FTP_USERNAME`: Username FTP
- `FTP_PASSWORD`: Password FTP
- `FTP_SERVER_DIR`: Thư mục deploy trên server (mặc định: `/`)

#### Cho Build:
- `VITE_API_URL`: URL API backend (nếu cần)

---

## 📦 Deploy Options

### Option 1: Vercel (Recommended)

1. Tạo account tại [vercel.com](https://vercel.com)
2. Import project từ GitHub
3. Lấy `VERCEL_TOKEN`, `VERCEL_ORG_ID`, `VERCEL_PROJECT_ID`
4. Thêm vào GitHub Secrets
5. File `vercel.json` đã được cấu hình sẵn

### Option 2: Netlify

1. Tạo account tại [netlify.com](https://netlify.com)
2. Tạo site mới và kết nối với GitHub repo
3. Lấy `NETLIFY_AUTH_TOKEN` và `NETLIFY_SITE_ID`
4. Thêm vào GitHub Secrets
5. File `netlify.toml` đã được cấu hình sẵn

### Option 3: FTP Server

1. Có FTP server sẵn (cPanel, FileZilla Server, etc.)
2. Thêm FTP credentials vào GitHub Secrets
3. Workflow sẽ tự động deploy khi push code

### Option 4: Docker

1. Build Docker image:
   ```bash
   docker build -t your-app-name .
   ```

2. Run container:
   ```bash
   docker run -p 80:80 your-app-name
   ```

3. Hoặc sử dụng GitHub Container Registry:
   - Images sẽ được push tự động khi có tag `v*`
   - Pull image: `docker pull ghcr.io/username/repo:tag`

---

## 🧪 Local Testing

### Test build:
```bash
npm run build
```

### Test Docker:
```bash
docker build -t test-app .
docker run -p 8080:80 test-app
# Mở http://localhost:8080
```

### Test lint (nếu đã setup ESLint):
```bash
npm run lint
```

---

## 🔄 Workflow Triggers

### Automatic:
- **Push** vào `main`/`master` → Chạy CI + Deploy
- **Pull Request** → Chỉ chạy CI (không deploy)

### Manual:
- Vào **Actions** tab trên GitHub
- Chọn workflow muốn chạy
- Click **Run workflow**

---

## 📝 Environment Variables

Tạo file `.env.production` cho production build:

```env
VITE_API_URL=https://api.yourdomain.com
VITE_APP_NAME=Laura School
```

Vite sẽ tự động load các biến này khi build.

---

## 🐛 Troubleshooting

### Build fails:
- Kiểm tra Node.js version (cần >= 18)
- Kiểm tra dependencies: `npm ci`
- Xem logs trong GitHub Actions

### Deploy fails:
- Kiểm tra secrets đã được setup đúng chưa
- Kiểm tra network/firewall cho FTP
- Kiểm tra permissions cho Vercel/Netlify

### Docker build fails:
- Kiểm tra Dockerfile syntax
- Kiểm tra nginx.conf có đúng format không

---

## 📚 Tài liệu tham khảo

- [GitHub Actions Docs](https://docs.github.com/en/actions)
- [Vercel Docs](https://vercel.com/docs)
- [Netlify Docs](https://docs.netlify.com)
- [Vite Deployment Guide](https://vitejs.dev/guide/static-deploy.html)

---

## ✅ Checklist Setup

- [ ] Đã tạo GitHub repository
- [ ] Đã push code lên GitHub
- [ ] Đã chọn platform deploy (Vercel/Netlify/FTP/Docker)
- [ ] Đã thêm secrets vào GitHub
- [ ] Đã test build local: `npm run build`
- [ ] Đã push code và kiểm tra workflow chạy
- [ ] Đã verify deploy thành công

---

**Lưu ý:** Chỉ enable workflow phù hợp với nhu cầu của bạn. Không cần enable tất cả workflows cùng lúc.

