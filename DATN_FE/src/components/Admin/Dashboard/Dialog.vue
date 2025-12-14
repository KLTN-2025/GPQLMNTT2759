<template>
    <div v-if="isVisible" class="dialog-overlay" @click="closeDialog">
      <div class="dialog-container" @click.stop>
        <div class="dialog-header">
          <h3 class="dialog-title">
            <i class="bx bx-user-plus me-2"></i>
            Thêm học sinh mới
          </h3>
          <button class="dialog-close" @click="closeDialog">
            <i class="bx bx-x"></i>
          </button>
        </div>
        
        <div class="dialog-body">
          <form @submit.prevent="submitForm">
            <div class="row">
              <!-- Thông tin cơ bản -->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Họ và tên <span class="required">*</span></label>
                  <input 
                    type="text" 
                    class="form-control" 
                    v-model="formData.fullName"
                    placeholder="Nhập họ và tên học sinh"
                    required
                  >
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Ngày sinh <span class="required">*</span></label>
                  <input 
                    type="date" 
                    class="form-control" 
                    v-model="formData.birthDate"
                    required
                  >
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Giới tính <span class="required">*</span></label>
                  <select class="form-control" v-model="formData.gender" required>
                    <option value="">Chọn giới tính</option>
                    <option value="male">Nam</option>
                    <option value="female">Nữ</option>
                  </select>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Lớp học <span class="required">*</span></label>
                  <select class="form-control" v-model="formData.class" required>
                    <option value="">Chọn lớp học</option>
                    <option value="mam">Lớp Mầm</option>
                    <option value="choi">Lớp Chồi</option>
                    <option value="la">Lớp Lá</option>
                  </select>
                </div>
              </div>
              
              <!-- Thông tin phụ huynh -->
              <div class="col-12">
                <h5 class="section-title">
                  <i class="bx bx-users me-2"></i>
                  Thông tin phụ huynh
                </h5>
              </div>
              
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Họ tên cha <span class="required">*</span></label>
                  <input 
                    type="text" 
                    class="form-control" 
                    v-model="formData.fatherName"
                    placeholder="Nhập họ tên cha"
                    required
                  >
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Số điện thoại cha</label>
                  <input 
                    type="tel" 
                    class="form-control" 
                    v-model="formData.fatherPhone"
                    placeholder="Nhập số điện thoại"
                  >
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Họ tên mẹ <span class="required">*</span></label>
                  <input 
                    type="text" 
                    class="form-control" 
                    v-model="formData.motherName"
                    placeholder="Nhập họ tên mẹ"
                    required
                  >
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Số điện thoại mẹ</label>
                  <input 
                    type="tel" 
                    class="form-control" 
                    v-model="formData.motherPhone"
                    placeholder="Nhập số điện thoại"
                  >
                </div>
              </div>
              
              <div class="col-12">
                <div class="form-group">
                  <label class="form-label">Địa chỉ</label>
                  <textarea 
                    class="form-control" 
                    v-model="formData.address"
                    placeholder="Nhập địa chỉ"
                    rows="3"
                  ></textarea>
                </div>
              </div>
              
              <div class="col-12">
                <div class="form-group">
                  <label class="form-label">Ghi chú</label>
                  <textarea 
                    class="form-control" 
                    v-model="formData.notes"
                    placeholder="Ghi chú thêm về học sinh"
                    rows="2"
                  ></textarea>
                </div>
              </div>
            </div>
          </form>
        </div>
        
        <div class="dialog-footer">
          <button type="button" class="btn btn-outline-secondary" @click="closeDialog">
            <i class="bx bx-x me-2"></i>
            Hủy
          </button>
          <button type="button" class="btn btn-primary" @click="submitForm" :disabled="isSubmitting">
            <i class="bx bx-check me-2" v-if="!isSubmitting"></i>
            <i class="bx bx-loader-alt bx-spin me-2" v-else></i>
            {{ isSubmitting ? 'Đang lưu...' : 'Lưu học sinh' }}
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { ref, reactive } from 'vue'
  
  export default {
    name: 'StudentDialog',
    props: {
      isVisible: {
        type: Boolean,
        default: false
      }
    },
    emits: ['close', 'submit'],
    setup(props, { emit }) {
      const isSubmitting = ref(false)
      
      const formData = reactive({
        fullName: '',
        birthDate: '',
        gender: '',
        class: '',
        fatherName: '',
        fatherPhone: '',
        motherName: '',
        motherPhone: '',
        address: '',
        notes: ''
      })
      
      const closeDialog = () => {
        emit('close')
        resetForm()
      }
      
      const resetForm = () => {
        Object.keys(formData).forEach(key => {
          formData[key] = ''
        })
      }
      
      const submitForm = async () => {
        if (!formData.fullName || !formData.birthDate || !formData.gender || 
            !formData.class || !formData.fatherName || !formData.motherName) {
          alert('Vui lòng điền đầy đủ thông tin bắt buộc!')
          return
        }
        
        isSubmitting.value = true
        
        try {
          // Simulate API call
          await new Promise(resolve => setTimeout(resolve, 1500))
          
          emit('submit', { ...formData })
          closeDialog()
          
          // Show success message
          alert('Thêm học sinh thành công!')
        } catch (error) {
          alert('Có lỗi xảy ra, vui lòng thử lại!')
        } finally {
          isSubmitting.value = false
        }
      }
      
      return {
        formData,
        isSubmitting,
        closeDialog,
        submitForm
      }
    }
  }
  </script>
  
  <style lang="scss" scoped>
  .dialog-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    animation: fadeIn 0.3s ease;
  }
  
  .dialog-container {
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    width: 90%;
    max-width: 800px;
    max-height: 90vh;
    overflow: hidden;
    animation: slideUp 0.3s ease;
  }
  
  .dialog-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 24px 32px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
  }
  
  .dialog-title {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
  }
  
  .dialog-close {
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    padding: 8px;
    border-radius: 8px;
    transition: all 0.2s;
    
    &:hover {
      background: rgba(255, 255, 255, 0.1);
    }
  }
  
  .dialog-body {
    padding: 32px;
    max-height: 60vh;
    overflow-y: auto;
  }
  
  .section-title {
    color: #2d3748;
    font-size: 1.1rem;
    font-weight: 600;
    margin: 24px 0 16px 0;
    padding-bottom: 8px;
    border-bottom: 2px solid #e2e8f0;
  }
  
  .form-group {
    margin-bottom: 20px;
  }
  
  .form-label {
    display: block;
    margin-bottom: 8px;
    color: #374151;
    font-weight: 500;
    font-size: 0.9rem;
  }
  
  .required {
    color: #ef4444;
  }
  
  .form-control {
    width: 100%;
    padding: 12px 16px;
    border: 1.5px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.2s;
    background: white;
    
    &:focus {
      outline: none;
      border-color: #667eea;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    &::placeholder {
      color: #9ca3af;
    }
  }
  
  select.form-control {
    cursor: pointer;
  }
  
  textarea.form-control {
    resize: vertical;
    min-height: 80px;
  }
  
  .dialog-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 12px;
    padding: 24px 32px;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
  }
  
  .btn {
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 500;
    font-size: 0.95rem;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    
    &:disabled {
      opacity: 0.6;
      cursor: not-allowed;
    }
  }
  
  .btn-outline-secondary {
    background: white;
    color: #6b7280;
    border: 1.5px solid #d1d5db;
    
    &:hover:not(:disabled) {
      background: #f9fafb;
      border-color: #9ca3af;
    }
  }
  
  .btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    
    &:hover:not(:disabled) {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }
  }
  
  .bx-spin {
    animation: spin 1s linear infinite;
  }
  
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  
  @keyframes slideUp {
    from {
      opacity: 0;
      transform: translateY(30px) scale(0.95);
    }
    to {
      opacity: 1;
      transform: translateY(0) scale(1);
    }
  }
  
  @keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
  }
  
  // Custom scrollbar
  .dialog-body::-webkit-scrollbar {
    width: 6px;
  }
  
  .dialog-body::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
  }
  
  .dialog-body::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
  }
  
  .dialog-body::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
  }
  
  // Responsive
  @media (max-width: 768px) {
    .dialog-container {
      width: 95%;
      margin: 20px;
    }
    
    .dialog-header,
    .dialog-body,
    .dialog-footer {
      padding: 20px;
    }
    
    .dialog-title {
      font-size: 1.1rem;
    }
    
    .btn {
      padding: 10px 16px;
      font-size: 0.9rem;
    }
  }
  </style>
