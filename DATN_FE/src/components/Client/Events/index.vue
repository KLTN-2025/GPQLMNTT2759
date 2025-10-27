<template>
    <div class="events-container">
      <div class="events-header">
        <h1 class="events-title">Sự Kiện Đặc Biệt</h1>
        <p class="events-subtitle">
          Khám phá những hoạt động thú vị dành cho các bé
        </p>
      </div>
  
      <div class="events-content">
        <div class="events-grid">
          <div class="event-card" v-for="event in filteredEvents" :key="event.id">
            <div class="event-image">
              <img :src="event.image" :alt="event.title" />
              <div class="event-date-badge">
                <span class="date">{{ formatDate(event.date) }}</span>
              </div>
              <div class="event-status" :class="event.status">
                {{ getStatusText(event.status) }}
              </div>
            </div>
            <div class="event-content">
              <div class="event-category-tag" :class="event.category">
                <i :class="getCategoryIcon(event.category)"></i>
                {{ getCategoryName(event.category) }}
              </div>
              <h3 class="event-title">{{ event.title }}</h3>
              <p class="event-description">{{ event.description }}</p>
              <div class="event-details">
                <div class="event-time">
                  <i class="mdi mdi-clock-outline"></i>
                  <span>{{ event.time }}</span>
                </div>
                <div class="event-location">
                  <i class="mdi mdi-map-marker-outline"></i>
                  <span>{{ event.location }}</span>
                </div>
                <div class="event-participants">
                  <i class="mdi mdi-account-group-outline"></i>
                  <span>{{ event.participants }}/{{ event.maxParticipants }} người</span>
                </div>
              </div>
              <div class="event-actions">
                <v-btn
                  class="register-btn"
                  :color="event.isRegistered ? 'success' : 'primary'"
                  @click="registerEvent(event.id)"
                  :disabled="event.isRegistered || event.status === 'full'"
                  :loading="loadingEvents.includes(event.id)"
                >
                  <i class="mdi" :class="getButtonIcon(event)"></i>
                  {{ getButtonText(event) }}
                </v-btn>
                <v-btn 
                  class="detail-btn" 
                  variant="outlined"
                  @click="viewEventDetail(event.id)"
                >
                  <i class="mdi mdi-eye-outline"></i>
                  Xem chi tiết
                </v-btn>
              </div>
            </div>
          </div>
        </div>
  
        <!-- Upcoming Events Section -->
        <div class="upcoming-section">
          <h2 class="section-title">
            <i class="mdi mdi-calendar-clock"></i>
            Sự Kiện Sắp Tới
          </h2>
          <div class="upcoming-events">
            <div
              class="upcoming-card"
              v-for="upcoming in upcomingEvents"
              :key="upcoming.id"
              @click="viewEventDetail(upcoming.id)"
            >
              <div class="upcoming-date">
                <span class="day">{{ getDayFromDate(upcoming.date) }}</span>
                <span class="month">{{ getMonthFromDate(upcoming.date) }}</span>
              </div>
              <div class="upcoming-info">
                <h4>{{ upcoming.title }}</h4>
                <p>{{ upcoming.shortDescription }}</p>
                <div class="upcoming-countdown">
                  <i class="mdi mdi-timer-outline"></i>
                  <span>{{ getCountdown(upcoming.date) }}</span>
                </div>
              </div>
              <v-btn
                class="remind-btn"
                size="small"
                variant="outlined"
                @click.stop="setReminder(upcoming.id)"
                :color="upcoming.hasReminder ? 'success' : 'primary'"
              >
                <i class="mdi" :class="upcoming.hasReminder ? 'mdi-bell' : 'mdi-bell-outline'"></i>
                {{ upcoming.hasReminder ? 'Đã nhắc' : 'Nhắc nhở' }}
              </v-btn>
            </div>
          </div>
        </div>
  
        <!-- Event Categories -->
        <div class="categories-section">
          <h2 class="section-title">
            <i class="mdi mdi-view-grid"></i>
            Danh Mục Sự Kiện
          </h2>
          <div class="category-filters">
            <v-chip-group v-model="selectedCategory" column>
              <v-chip
                v-for="category in categories"
                :key="category.id"
                :value="category.id"
                filter
                variant="outlined"
                class="category-chip"
              >
                <i :class="category.icon"></i>
                {{ category.name }}
                <v-badge 
                  :content="getEventCountByCategory(category.id)" 
                  color="primary" 
                  inline
                ></v-badge>
              </v-chip>
            </v-chip-group>
          </div>
        </div>
  
        <!-- Statistics Section -->
        <div class="stats-section">
          <h2 class="section-title">
            <i class="mdi mdi-chart-line"></i>
            Thống Kê Hoạt Động
          </h2>
          <div class="stats-grid">
            <div class="stat-card">
              <div class="stat-icon">
                <i class="mdi mdi-calendar-multiple"></i>
              </div>
              <div class="stat-info">
                <h3>{{ events.length }}</h3>
                <p>Tổng sự kiện</p>
              </div>
            </div>
            <div class="stat-card">
              <div class="stat-icon">
                <i class="mdi mdi-account-check"></i>
              </div>
              <div class="stat-info">
                <h3>{{ registeredEventsCount }}</h3>
                <p>Đã đăng ký</p>
              </div>
            </div>
            <div class="stat-card">
              <div class="stat-icon">
                <i class="mdi mdi-clock-fast"></i>
              </div>
              <div class="stat-info">
                <h3>{{ upcomingEvents.length }}</h3>
                <p>Sắp diễn ra</p>
              </div>
            </div>
            <div class="stat-card">
              <div class="stat-icon">
                <i class="mdi mdi-trophy"></i>
              </div>
              <div class="stat-info">
                <h3>{{ completedEventsCount }}</h3>
                <p>Đã hoàn thành</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed, onMounted } from "vue";
  import { useRouter } from "vue-router";
  
  const router = useRouter();
  const selectedCategory = ref('all');
  const loadingEvents = ref([]);
  
  // Danh sách hình ảnh có sẵn từ thư mục Home
  const availableImages = [
    "/src/assets/images/Home/8fe40b65561cc239a2a12bb42ddc68b7_8e6497a465.webp",
    "/src/assets/images/Home/6cf34c24fc94b12664e299a5376d1746_b82caf16e0.webp",
    "/src/assets/images/Home/1_5ff39b692d.webp",
    "/src/assets/images/Home/c60c9957bd6a61a505156bdfe86a136c_cd267fc02b.webp",
    "/src/assets/images/Home/e0591e4c360abfcdc814cc2989fb4826_ea9363ed19.webp",
    "/src/assets/images/Home/anh-6-17184525388231291139336.webp",
    "/src/assets/images/Home/DJI-20250624152517-0068-D-JPG-7585-1755422519.webp",
    "/src/assets/images/Home/hoat-dong-ngoai-khoa-o-truong-tieu-hoc-3.png",
    "/src/assets/images/Home/lich-hoat-dong-cua-tre-tai-truong-mam-non.jpg_636767702616441017.jpg",
    "/src/assets/images/Home/cac-tro-choi-tieng-anh-cho-tre-mam-non.jpg"
  ];
  
  // Hàm random hình ảnh
  function getRandomImage() {
    return availableImages[Math.floor(Math.random() * availableImages.length)];
  }
  
  const events = ref([
    {
      id: 1,
      title: "Ngày Hội Thể Thao Nhí",
      description: "Các bé sẽ tham gia những trò chơi thể thao vui nhộn và bổ ích, giúp phát triển thể chất và tinh thần đồng đội.",
      image: getRandomImage(),
      date: "2024-02-15",
      time: "8:00 - 11:00",
      location: "Sân chơi trường",
      isRegistered: false,
      category: "sports",
      status: "open",
      participants: 15,
      maxParticipants: 30
    },
    {
      id: 2,
      title: "Lễ Hội Mùa Xuân",
      description: "Chào đón mùa xuân với những hoạt động văn nghệ, trò chơi dân gian và các món ăn truyền thống.",
      image: getRandomImage(),
      date: "2024-02-20",
      time: "9:00 - 15:00",
      location: "Hội trường",
      isRegistered: true,
      category: "cultural",
      status: "registered",
      participants: 25,
      maxParticipants: 40
    },
    {
      id: 3,
      title: "Cuộc Thi Vẽ Tranh",
      description: 'Các bé thể hiện tài năng nghệ thuật qua cuộc thi vẽ tranh với chủ đề "Ước mơ của em".',
      image: getRandomImage(),
      date: "2024-02-25",
      time: "14:00 - 16:00",
      location: "Phòng mỹ thuật",
      isRegistered: false,
      category: "art",
      status: "open",
      participants: 8,
      maxParticipants: 20
    },
    {
      id: 4,
      title: "Ngày Khoa Học Nhí",
      description: "Khám phá thế giới khoa học qua những thí nghiệm đơn giản và thú vị phù hợp với lứa tuổi.",
      image: getRandomImage(),
      date: "2024-03-01",
      time: "9:30 - 11:30",
      location: "Phòng thí nghiệm",
      isRegistered: false,
      category: "science",
      status: "full",
      participants: 15,
      maxParticipants: 15
    },
    {
      id: 5,
      title: "Buổi Biểu Diễn Âm Nhạc",
      description: "Các bé thể hiện tài năng âm nhạc qua những bài hát và điệu múa đáng yêu.",
      image: getRandomImage(),
      date: "2024-03-05",
      time: "16:00 - 17:30",
      location: "Sân khấu chính",
      isRegistered: false,
      category: "cultural",
      status: "open",
      participants: 12,
      maxParticipants: 50
    },
    {
      id: 6,
      title: "Ngày Hội Sách",
      description: "Khuyến khích tình yêu đọc sách qua các hoạt động kể chuyện và triển lãm sách.",
      image: getRandomImage(),
      date: "2024-03-10",
      time: "10:00 - 12:00",
      location: "Thư viện",
      isRegistered: true,
      category: "education",
      status: "registered",
      participants: 20,
      maxParticipants: 25
    }
  ]);
  
  const upcomingEvents = ref([
    {
      id: 7,
      title: "Sinh nhật tháng 3",
      shortDescription: "Chúc mừng sinh nhật các bé sinh tháng 3",
      date: "2024-03-15",
      hasReminder: false
    },
    {
      id: 8,
      title: "Dã ngoại mùa xuân",
      shortDescription: "Chuyến dã ngoại khám phá thiên nhiên",
      date: "2024-03-20",
      hasReminder: true
    },
    {
      id: 9,
      title: "Hội thi nấu ăn nhí",
      shortDescription: "Các bé học cách làm những món ăn đơn giản",
      date: "2024-03-25",
      hasReminder: false
    }
  ]);
  
  const categories = ref([
    { id: "all", name: "Tất cả", icon: "mdi-view-grid" },
    { id: "sports", name: "Thể thao", icon: "mdi-soccer" },
    { id: "cultural", name: "Văn hóa", icon: "mdi-drama-masks" },
    { id: "art", name: "Nghệ thuật", icon: "mdi-palette" },
    { id: "science", name: "Khoa học", icon: "mdi-flask" },
    { id: "education", name: "Giáo dục", icon: "mdi-book-open-variant" }
  ]);
  
  const filteredEvents = computed(() => {
    if (!selectedCategory.value || selectedCategory.value === "all") {
      return events.value;
    }
    return events.value.filter(
      (event) => event.category === selectedCategory.value
    );
  });
  
  const registeredEventsCount = computed(() => {
    return events.value.filter(event => event.isRegistered).length;
  });
  
  const completedEventsCount = computed(() => {
    return events.value.filter(event => new Date(event.date) < new Date()).length;
  });
  
  function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString("vi-VN", {
      day: "2-digit",
      month: "2-digit",
    });
  }
  
  function getDayFromDate(dateString) {
    const date = new Date(dateString);
    return date.getDate();
  }
  
  function getMonthFromDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString("vi-VN", { month: "short" });
  }
  
  function getCountdown(dateString) {
    const eventDate = new Date(dateString);
    const now = new Date();
    const diffTime = eventDate - now;
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    
    if (diffDays > 0) {
      return `Còn ${diffDays} ngày`;
    } else if (diffDays === 0) {
      return "Hôm nay";
    } else {
      return "Đã qua";
    }
  }
  
  function getStatusText(status) {
    const statusMap = {
      'open': 'Mở đăng ký',
      'full': 'Đã đầy',
      'registered': 'Đã đăng ký',
      'closed': 'Đã đóng'
    };
    return statusMap[status] || 'Không xác định';
  }
  
  function getButtonText(event) {
    if (event.isRegistered) return 'Đã đăng ký';
    if (event.status === 'full') return 'Đã đầy';
    return 'Đăng ký tham gia';
  }
  
  function getButtonIcon(event) {
    if (event.isRegistered) return 'mdi-check-circle';
    if (event.status === 'full') return 'mdi-account-multiple-remove';
    return 'mdi-account-plus';
  }
  
  function getCategoryIcon(category) {
    const iconMap = {
      'sports': 'mdi-soccer',
      'cultural': 'mdi-drama-masks',
      'art': 'mdi-palette',
      'science': 'mdi-flask',
      'education': 'mdi-book-open-variant'
    };
    return iconMap[category] || 'mdi-calendar';
  }
  
  function getCategoryName(category) {
    const nameMap = {
      'sports': 'Thể thao',
      'cultural': 'Văn hóa',
      'art': 'Nghệ thuật',
      'science': 'Khoa học',
      'education': 'Giáo dục'
    };
    return nameMap[category] || 'Khác';
  }
  
  function getEventCountByCategory(categoryId) {
    if (categoryId === 'all') return events.value.length;
    return events.value.filter(event => event.category === categoryId).length;
  }
  
  async function registerEvent(eventId) {
    const event = events.value.find((e) => e.id === eventId);
    if (event && !event.isRegistered && event.status !== 'full') {
      loadingEvents.value.push(eventId);
      
      // Simulate API call
      await new Promise(resolve => setTimeout(resolve, 1500));
      
      event.isRegistered = true;
      event.status = 'registered';
      event.participants += 1;
      
      loadingEvents.value = loadingEvents.value.filter(id => id !== eventId);
      console.log("Đăng ký sự kiện thành công:", eventId);
    }
  }
  
  function viewEventDetail(eventId) {
    router.push(`/events/${eventId}`);
  }
  
  function setReminder(eventId) {
    const event = upcomingEvents.value.find(e => e.id === eventId);
    if (event) {
      event.hasReminder = !event.hasReminder;
      console.log(`${event.hasReminder ? 'Đặt' : 'Hủy'} nhắc nhở cho sự kiện:`, eventId);
    }
  }
  
  // Refresh images periodically for dynamic effect
  function refreshEventImages() {
    events.value.forEach(event => {
      if (Math.random() > 0.7) { // 30% chance to change image
        event.image = getRandomImage();
      }
    });
  }
  
  onMounted(() => {
    // Load dữ liệu sự kiện từ API
    console.log('Events component mounted');
    
    // Refresh images every 30 seconds for dynamic effect
    setInterval(refreshEventImages, 30000);
  });
  </script>
  
  <style lang="scss">
  @use "./style.scss";
  </style>