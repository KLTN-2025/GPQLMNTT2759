<template>
    <div v-if="showModal" class="modal-overlay" @click="closeModal">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <div class="modal-icon" :style="{ background: selectedAdvantage?.color }">
            <i :class="selectedAdvantage?.icon"></i>
          </div>
          <h2>{{ selectedAdvantage?.title }}</h2>
          <button class="close-btn" @click="closeModal">
            <i class="fas fa-times"></i>
          </button>
        </div>
        
        <div class="modal-body">
          <div class="modal-description">
            <h3>Mô tả chi tiết</h3>
            <p>{{ selectedAdvantage?.description }}</p>
            <p>{{ selectedAdvantage?.detailedDescription }}</p>
          </div>
          
          <div class="modal-features">
            <h3>Các tính năng nổi bật</h3>
            <ul>
              <li v-for="(feature, index) in selectedAdvantage?.features" :key="index">
                <i class="fas fa-check-circle"></i>
                {{ feature }}
              </li>
            </ul>
          </div>
          
          <div class="modal-benefits" v-if="selectedAdvantage?.benefits">
            <h3>Lợi ích mang lại</h3>
            <div class="benefits-grid">
              <div v-for="(benefit, index) in selectedAdvantage?.benefits" :key="index" class="benefit-item">
                <i :class="benefit.icon"></i>
                <div>
                  <h4>{{ benefit.title }}</h4>
                  <p>{{ benefit.description }}</p>
                </div>
              </div>
            </div>
          </div>
          
          <div class="modal-stats" v-if="selectedAdvantage?.stats">
            <h3>Thống kê</h3>
            <div class="stats-grid">
              <div v-for="(stat, index) in selectedAdvantage?.stats" :key="index" class="stat-item">
                <div class="stat-number">{{ stat.number }}</div>
                <div class="stat-label">{{ stat.label }}</div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="modal-footer">
          <button class="btn-primary" @click="closeModal">Đăng ký tham quan</button>
          <button class="btn-secondary" @click="closeModal">Liên hệ tư vấn</button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'AdvantageDialog',
    props: {
      showModal: {
        type: Boolean,
        default: false
      },
      selectedAdvantage: {
        type: Object,
        default: null
      }
    },
    emits: ['close'],
    methods: {
      closeModal() {
        this.$emit('close');
      }
    }
  };
  </script>
