<template>
    <div class="privacy-container">
      <div class="privacy-main">
        <!-- Hero Section -->
        <div class="hero-section">
          <div class="hero-content">
            <h1 class="hero-title">Chính Sách Quyền Riêng Tư</h1>
            <p class="hero-subtitle">
              Chúng tôi cam kết bảo vệ thông tin cá nhân và quyền riêng tư của bạn
            </p>
          </div>
          <div class="hero-icon">
            <i class="fas fa-shield-alt"></i>
          </div>
        </div>
  
        <!-- Privacy Settings Section -->
        <div class="section-header">
          <h2>Cài Đặt Quyền Riêng Tư</h2>
          <div class="divider"></div>
        </div>
  
        <div class="privacy-settings">
          <div class="settings-grid">
            <!-- Profile Visibility -->
            <div class="setting-card">
              <div class="setting-header">
                <div class="setting-icon">
                  <i class="fas fa-user-circle"></i>
                </div>
                <div class="setting-info">
                  <h3>Hiển Thị Hồ Sơ</h3>
                  <p>Kiểm soát ai có thể xem thông tin hồ sơ của bạn</p>
                </div>
              </div>
              <div class="setting-controls">
                <div class="toggle-group">
                  <label class="toggle-option">
                    <input type="radio" name="profile" value="public" checked>
                    <span class="radio-custom"></span>
                    Công khai
                  </label>
                  <label class="toggle-option">
                    <input type="radio" name="profile" value="private">
                    <span class="radio-custom"></span>
                    Riêng tư
                  </label>
                </div>
              </div>
            </div>
  
            <!-- Data Collection -->
            <div class="setting-card">
              <div class="setting-header">
                <div class="setting-icon">
                  <i class="fas fa-database"></i>
                </div>
                <div class="setting-info">
                  <h3>Thu Thập Dữ Liệu</h3>
                  <p>Cho phép thu thập dữ liệu để cải thiện dịch vụ</p>
                </div>
              </div>
              <div class="setting-controls">
                <label class="switch">
                  <input type="checkbox" checked>
                  <span class="slider"></span>
                </label>
              </div>
            </div>
  
            <!-- Notifications -->
            <div class="setting-card">
              <div class="setting-header">
                <div class="setting-icon">
                  <i class="fas fa-bell"></i>
                </div>
                <div class="setting-info">
                  <h3>Thông Báo</h3>
                  <p>Nhận thông báo về hoạt động và cập nhật</p>
                </div>
              </div>
              <div class="setting-controls">
                <label class="switch">
                  <input type="checkbox" checked>
                  <span class="slider"></span>
                </label>
              </div>
            </div>
  
            <!-- Location Tracking -->
            <div class="setting-card">
              <div class="setting-header">
                <div class="setting-icon">
                  <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="setting-info">
                  <h3>Theo Dõi Vị Trí</h3>
                  <p>Cho phép ứng dụng truy cập vị trí của bạn</p>
                </div>
              </div>
              <div class="setting-controls">
                <label class="switch">
                  <input type="checkbox">
                  <span class="slider"></span>
                </label>
              </div>
            </div>
  
            <!-- Marketing Communications -->
            <div class="setting-card">
              <div class="setting-header">
                <div class="setting-icon">
                  <i class="fas fa-envelope"></i>
                </div>
                <div class="setting-info">
                  <h3>Email Marketing</h3>
                  <p>Nhận email về chương trình khuyến mãi và tin tức</p>
                </div>
              </div>
              <div class="setting-controls">
                <label class="switch">
                  <input type="checkbox">
                  <span class="slider"></span>
                </label>
              </div>
            </div>
  
            <!-- Two-Factor Authentication -->
            <div class="setting-card">
              <div class="setting-header">
                <div class="setting-icon">
                  <i class="fas fa-lock"></i>
                </div>
                <div class="setting-info">
                  <h3>Xác Thực 2 Bước</h3>
                  <p>Tăng cường bảo mật cho tài khoản của bạn</p>
                </div>
              </div>
              <div class="setting-controls">
                <button class="setup-btn">Thiết Lập</button>
              </div>
            </div>
          </div>
        </div>
  
        <!-- Privacy Policy Section -->
        <div class="section-header">
          <h2>Chính Sách Bảo Mật</h2>
          <div class="divider"></div>
        </div>
  
        <div class="policy-section">
          <div class="policy-content">
            <div class="policy-item">
              <h3><i class="fas fa-info-circle"></i> Thu Thập Thông Tin</h3>
              <p>
                Chúng tôi thu thập thông tin cá nhân mà bạn cung cấp trực tiếp cho chúng tôi, 
                chẳng hạn như khi bạn tạo tài khoản, liên hệ với chúng tôi hoặc sử dụng dịch vụ của chúng tôi.
              </p>
            </div>
  
            <div class="policy-item">
              <h3><i class="fas fa-shield-alt"></i> Bảo Vệ Thông Tin</h3>
              <p>
                Chúng tôi sử dụng các biện pháp bảo mật kỹ thuật và tổ chức phù hợp để bảo vệ 
                thông tin cá nhân của bạn khỏi việc truy cập, sử dụng hoặc tiết lộ trái phép.
              </p>
            </div>
  
            <div class="policy-item">
              <h3><i class="fas fa-share-alt"></i> Chia Sẻ Thông Tin</h3>
              <p>
                Chúng tôi không bán, cho thuê hoặc chia sẻ thông tin cá nhân của bạn với bên thứ ba 
                mà không có sự đồng ý của bạn, trừ khi được yêu cầu bởi pháp luật.
              </p>
            </div>
  
            <div class="policy-item">
              <h3><i class="fas fa-edit"></i> Quyền Của Bạn</h3>
              <p>
                Bạn có quyền truy cập, cập nhật, xóa hoặc hạn chế việc xử lý thông tin cá nhân của mình. 
                Liên hệ với chúng tôi để thực hiện các quyền này.
              </p>
            </div>
          </div>
        </div>
  
        <!-- Action Buttons -->
        <div class="action-section">
          <button class="save-btn">
            <i class="fas fa-save"></i>
            Lưu Cài Đặt
          </button>
          <button class="export-btn">
            <i class="fas fa-download"></i>
            Xuất Dữ Liệu
          </button>
          <button class="delete-btn">
            <i class="fas fa-trash"></i>
            Xóa Tài Khoản
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  
  // Reactive data for settings
  const profileVisibility = ref('public')
  const dataCollection = ref(true)
  const notifications = ref(true)
  const locationTracking = ref(false)
  const marketingEmails = ref(false)
  
  // Methods
  const saveSettings = () => {
    // Save settings logic
    console.log('Settings saved')
  }
  
  const exportData = () => {
    // Export user data logic
    console.log('Exporting data')
  }
  
  const deleteAccount = () => {
    // Delete account logic
    if (confirm('Bạn có chắc chắn muốn xóa tài khoản?')) {
      console.log('Account deletion requested')
    }
  }
  </script>
  
  <style lang="scss">
  @use "./style.scss";
  </style>
