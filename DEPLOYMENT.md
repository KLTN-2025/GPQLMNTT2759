# 🚀 Hướng dẫn Deploy

Tài liệu này hướng dẫn cách deploy ứng dụng Laura School lên các platform khác nhau.

---

## 📋 Mục lục

1. [Deploy lên Vercel](#vercel)
2. [Deploy lên Netlify](#netlify)
3. [Deploy lên FTP Server](#ftp)
4. [Deploy với Docker](#docker)
5. [Deploy thủ công](#manual)

---

## <a name="vercel"></a>1. Deploy lên Vercel

### Cách 1: Sử dụng GitHub Actions (Tự động)

1. Tạo account tại [vercel.com](https://vercel.com)
2. Import project từ GitHub
3. Lấy các thông tin sau từ Vercel Dashboard:
   - **Token**: Settings → Tokens
   - **Org ID**: Settings → General
   - **Project ID**: Project Settings → General
4. Thêm vào GitHub Secrets:
   - `VERCEL_TOKEN`
   - `VERCEL_ORG_ID`
   - `VERCEL_PROJECT_ID`
5. Push code lên `main` branch → Tự động deploy

### Cách 2: Sử dụng Vercel CLI

```bash
# Install Vercel CLI
npm i -g vercel

# Login
vercel login

# Deploy
vercel --prod
```

### Cấu hình

File `vercel.json` đã được cấu hình sẵn với:
- SPA routing (rewrite to index.html)
- Cache headers cho static assets
- Build command: `npm run build`

---

## <a name="netlify"></a>2. Deploy lên Netlify

### Cách 1: Sử dụng GitHub Actions (Tự động)

1. Tạo account tại [netlify.com](https://netlify.com)
2. Tạo site mới và kết nối với GitHub repo
3. Lấy các thông tin sau:
   - **Auth Token**: User settings → Applications → Personal access tokens
   - **Site ID**: Site settings → General → Site details
4. Thêm vào GitHub Secrets:
   - `NETLIFY_AUTH_TOKEN`
   - `NETLIFY_SITE_ID`
5. Push code lên `main` branch → Tự động deploy

### Cách 2: Sử dụng Netlify CLI

```bash
# Install Netlify CLI
npm i -g netlify-cli

# Login
netlify login

# Deploy
netlify deploy --prod
```

### Cấu hình

File `netlify.toml` đã được cấu hình sẵn với:
- Build command: `npm run build`
- Publish directory: `dist`
- SPA routing (redirect to index.html)
- Cache headers cho static assets

---

## <a name="ftp"></a>3. Deploy lên FTP Server

### Setup GitHub Secrets

1. Vào GitHub → Settings → Secrets and variables → Actions
2. Thêm các secrets sau:
   - `FTP_SERVER`: Địa chỉ FTP (ví dụ: `ftp.example.com`)
   - `FTP_USERNAME`: Username FTP
   - `FTP_PASSWORD`: Password FTP
   - `FTP_SERVER_DIR`: Thư mục deploy (ví dụ: `/public_html`)

### Deploy

Push code lên `main` branch → Workflow sẽ tự động deploy lên FTP server.

### Lưu ý

- Đảm bảo FTP server có đủ quyền ghi
- Kiểm tra firewall không chặn kết nối FTP
- Nên sử dụng SFTP nếu có thể (cần cấu hình thêm)

---

## <a name="docker"></a>4. Deploy với Docker

### Build Image

```bash
docker build -t laura-school:latest .
```

### Run Container

```bash
docker run -d \
  -p 80:80 \
  --name laura-school \
  laura-school:latest
```

### Docker Compose

Tạo file `docker-compose.yml`:

```yaml
version: '3.8'

services:
  laura-school:
    build: .
    ports:
      - "80:80"
    restart: unless-stopped
    environment:
      - NODE_ENV=production
```

Chạy:
```bash
docker-compose up -d
```

### Deploy lên Server

1. Build image trên máy local hoặc CI/CD
2. Push lên registry (GitHub Container Registry, Docker Hub, etc.)
3. Pull và run trên server:

```bash
# Pull image
docker pull ghcr.io/username/repo:tag

# Run
docker run -d -p 80:80 --name laura-school ghcr.io/username/repo:tag
```

---

## <a name="manual"></a>5. Deploy thủ công

### Bước 1: Build

```bash
npm install
npm run build
```

### Bước 2: Upload

Upload thư mục `dist/` lên web server (Apache, Nginx, etc.)

### Bước 3: Cấu hình Web Server

#### Nginx

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/laura-school/dist;
    index index.html;

    location / {
        try_files $uri $uri/ /index.html;
    }

    location /assets/ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

#### Apache

Tạo file `.htaccess` trong thư mục `dist/`:

```apache
<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteBase /
  RewriteRule ^index\.html$ - [L]
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteRule . /index.html [L]
</IfModule>
```

---

## 🔧 Environment Variables

Tạo file `.env.production` trước khi build:

```env
VITE_API_URL=https://api.yourdomain.com
VITE_APP_NAME=Laura School
```

Build với environment variables:

```bash
npm run build
```

---

## ✅ Checklist Deploy

- [ ] Đã test build local: `npm run build`
- [ ] Đã cấu hình environment variables
- [ ] Đã setup secrets (nếu dùng CI/CD)
- [ ] Đã test deploy trên staging
- [ ] Đã verify ứng dụng hoạt động đúng
- [ ] Đã setup monitoring/logging (nếu cần)
- [ ] Đã backup database (nếu có)

---

## 🐛 Troubleshooting

### Build fails

- Kiểm tra Node.js version (>= 18)
- Xóa `node_modules` và `package-lock.json`, chạy lại `npm install`
- Kiểm tra lỗi trong console

### Deploy fails

- Kiểm tra secrets đã đúng chưa
- Kiểm tra network/firewall
- Xem logs trong GitHub Actions hoặc platform dashboard

### 404 errors sau khi deploy

- Kiểm tra cấu hình SPA routing (rewrite to index.html)
- Kiểm tra base path trong `vite.config.js`

### Assets không load

- Kiểm tra base URL trong `vite.config.js`
- Kiểm tra CORS settings
- Kiểm tra cache headers

---

## 📚 Tài liệu tham khảo

- [Vite Deployment Guide](https://vitejs.dev/guide/static-deploy.html)
- [Vercel Docs](https://vercel.com/docs)
- [Netlify Docs](https://docs.netlify.com)
- [Docker Docs](https://docs.docker.com)
- [Nginx Docs](https://nginx.org/en/docs/)

---

**Lưu ý:** Chọn phương pháp deploy phù hợp với infrastructure và nhu cầu của bạn.

