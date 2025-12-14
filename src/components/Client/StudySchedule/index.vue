<template>
  <div class="study-schedule-container">
    <!-- Hero Section -->
    <div class="hero-section">
      <div class="hero-content">
        <h1 class="hero-title">Lịch Học Của Bé</h1>
        <p class="hero-subtitle">
          Theo dõi lịch học hàng tuần và các hoạt động của con em bạn
        </p>
      </div>
      <div class="hero-decoration">
        <div class="floating-icon">
          <i class="mdi mdi-calendar-clock"></i>
        </div>
      </div>
    </div>

    <!-- Current Week Info -->
    <div class="week-info">
      <div class="week-navigation">
        <button class="nav-btn" @click="previousWeek">
          <i class="mdi mdi-chevron-left"></i>
        </button>
        <div class="current-week">
          <h2>{{ currentWeekText }}</h2>
          <p>{{ currentDateRange }}</p>
        </div>
        <button class="nav-btn" @click="nextWeek">
          <i class="mdi mdi-chevron-right"></i>
        </button>
      </div>
    </div>

    <!-- Schedule Grid -->
    <div class="schedule-grid">
      <div class="time-column">
        <div class="time-header">Giờ học</div>
        <div v-for="time in timeSlots" :key="time.id" class="time-slot">
          {{ time.start }} - {{ time.end }}
        </div>
      </div>

      <div v-for="day in weekDays" :key="day.id" class="day-column">
        <div class="day-header" :class="{ today: day.isToday }">
          <div class="day-name">{{ day.name }}</div>
          <div class="day-date">{{ day.date }}</div>
        </div>

        <div v-for="time in timeSlots" :key="time.id" class="schedule-cell">
          <div
            v-if="getSubjectForTimeSlot(day.id, time.id)"
            class="subject-card"
            :class="getSubjectForTimeSlot(day.id, time.id).type"
            @click="openSubjectDetail(getSubjectForTimeSlot(day.id, time.id))"
          >
            <div class="subject-name">
              {{ getSubjectForTimeSlot(day.id, time.id).name }}
            </div>
            <div class="subject-teacher">
              {{ getSubjectForTimeSlot(day.id, time.id).teacher }}
            </div>
            <div class="subject-room">
              {{ getSubjectForTimeSlot(day.id, time.id).room }}
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Today's Highlights -->
    <div class="today-highlights">
      <h3>Hoạt động hôm nay</h3>
      <div class="highlights-grid">
        <div
          v-for="activity in todayActivities"
          :key="activity.id"
          class="activity-card"
        >
          <div class="activity-icon">
            <i :class="activity.icon"></i>
          </div>
          <div class="activity-info">
            <h4>{{ activity.title }}</h4>
            <p>{{ activity.time }}</p>
            <span class="activity-status" :class="activity.status">{{
              activity.statusText
            }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Stats -->
    <div class="quick-stats">
      <div class="stat-card">
        <div class="stat-icon">
          <i class="mdi mdi-book-open-page-variant"></i>
        </div>
        <div class="stat-info">
          <div class="stat-number">{{ weeklyStats.totalSubjects }}</div>
          <div class="stat-label">Môn học tuần này</div>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon">
          <i class="mdi mdi-clock-outline"></i>
        </div>
        <div class="stat-info">
          <div class="stat-number">{{ weeklyStats.totalHours }}</div>
          <div class="stat-label">Giờ học</div>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon">
          <i class="mdi mdi-account-group"></i>
        </div>
        <div class="stat-info">
          <div class="stat-number">{{ weeklyStats.activities }}</div>
          <div class="stat-label">Hoạt động</div>
        </div>
      </div>
    </div>

    <!-- Subject Detail Modal -->
    <div
      v-if="selectedSubject"
      class="modal-overlay"
      @click="closeSubjectDetail"
    >
      <div class="subject-modal" @click.stop>
        <div class="modal-header">
          <h3>{{ selectedSubject.name }}</h3>
          <button class="close-btn" @click="closeSubjectDetail">
            <i class="mdi mdi-close"></i>
          </button>
        </div>
        <div class="modal-content">
          <div class="subject-details">
            <div class="detail-item">
              <i class="mdi mdi-account"></i>
              <span>Giáo viên: {{ selectedSubject.teacher }}</span>
            </div>
            <div class="detail-item">
              <i class="mdi mdi-map-marker"></i>
              <span>Phòng học: {{ selectedSubject.room }}</span>
            </div>
            <div class="detail-item">
              <i class="mdi mdi-clock"></i>
              <span>Thời gian: {{ selectedSubject.time }}</span>
            </div>
            <div class="detail-item">
              <i class="mdi mdi-information"></i>
              <span>Mô tả: {{ selectedSubject.description }}</span>
            </div>
          </div>
          <div class="subject-materials">
            <h4>Dụng cụ học tập</h4>
            <ul>
              <li v-for="material in selectedSubject.materials" :key="material">
                {{ material }}
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";

// Reactive data
const currentWeek = ref(0);
const selectedSubject = ref(null);

// Time slots
const timeSlots = ref([
  { id: 1, start: "7:30", end: "8:15" },
  { id: 2, start: "8:15", end: "9:00" },
  { id: 3, start: "9:15", end: "10:00" },
  { id: 4, start: "10:00", end: "10:45" },
  { id: 5, start: "14:00", end: "14:45" },
  { id: 6, start: "14:45", end: "15:30" },
]);

// Helper function để format ngày
const formatDate = (date) => {
  const day = date.getDate().toString().padStart(2, "0");
  const month = (date.getMonth() + 1).toString().padStart(2, "0");
  return `${day}/${month}`;
};

// Week days - computed để thay đổi theo tuần
const weekDays = computed(() => {
  const baseDate = new Date(2024, 10, 25); // 25/11/2024 (tháng 10 vì tháng bắt đầu từ 0)
  const weekOffset = currentWeek.value * 7;

  return [
    {
      id: "monday",
      name: "Thứ 2",
      date: formatDate(
        new Date(baseDate.getTime() + weekOffset * 24 * 60 * 60 * 1000)
      ),
      isToday: false,
    },
    {
      id: "tuesday",
      name: "Thứ 3",
      date: formatDate(
        new Date(baseDate.getTime() + (weekOffset + 1) * 24 * 60 * 60 * 1000)
      ),
      isToday: false,
    },
    {
      id: "wednesday",
      name: "Thứ 4",
      date: formatDate(
        new Date(baseDate.getTime() + (weekOffset + 2) * 24 * 60 * 60 * 1000)
      ),
      isToday: false,
    },
    {
      id: "thursday",
      name: "Thứ 5",
      date: formatDate(
        new Date(baseDate.getTime() + (weekOffset + 3) * 24 * 60 * 60 * 1000)
      ),
      isToday: false,
    },
    {
      id: "friday",
      name: "Thứ 6",
      date: formatDate(
        new Date(baseDate.getTime() + (weekOffset + 4) * 24 * 60 * 60 * 1000)
      ),
      isToday: false,
    },
  ];
});

// Dữ liệu lịch học cho nhiều tuần
const allWeeksScheduleData = ref({
  0: {
    // Tuần 1
    monday: {
      1: {
        name: "Toán học",
        teacher: "Cô Lan",
        room: "P101",
        type: "math",
        time: "7:30 - 8:15",
        description: "Học đếm số và phép cộng cơ bản",
        materials: ["Sách toán", "Bút chì", "Tẩy"],
      },
      2: {
        name: "Tiếng Việt",
        teacher: "Cô Hoa",
        room: "P101",
        type: "language",
        time: "8:15 - 9:00",
        description: "Học chữ cái và đọc",
        materials: ["Sách tiếng Việt", "Vở", "Bút chì"],
      },
      5: {
        name: "Âm nhạc",
        teacher: "Cô Mai",
        room: "P201",
        type: "music",
        time: "14:00 - 14:45",
        description: "Học hát và nhạc cụ",
        materials: ["Không cần dụng cụ"],
      },
    },
    tuesday: {
      1: {
        name: "Tiếng Anh",
        teacher: "Ms. Anna",
        room: "P102",
        type: "english",
        time: "7:30 - 8:15",
        description: "Học từ vựng cơ bản",
        materials: ["Sách tiếng Anh", "Flashcard"],
      },
      3: {
        name: "Thể dục",
        teacher: "Thầy Nam",
        room: "Sân",
        type: "sports",
        time: "9:15 - 10:00",
        description: "Vận động và chơi thể thao",
        materials: ["Quần áo thể thao", "Giày thể thao"],
      },
      6: {
        name: "Mỹ thuật",
        teacher: "Cô Linh",
        room: "P301",
        type: "art",
        time: "14:45 - 15:30",
        description: "Vẽ và tô màu",
        materials: ["Giấy A4", "Bút màu", "Cọ vẽ"],
      },
    },
    wednesday: {
      2: {
        name: "Khoa học",
        teacher: "Cô Nga",
        room: "P103",
        type: "science",
        time: "8:15 - 9:00",
        description: "Khám phá thiên nhiên",
        materials: ["Kính lúp", "Sổ ghi chép"],
      },
      4: {
        name: "Toán học",
        teacher: "Cô Lan",
        room: "P101",
        type: "math",
        time: "10:00 - 10:45",
        description: "Học hình học cơ bản",
        materials: ["Sách toán", "Thước kẻ"],
      },
    },
    thursday: {
      1: {
        name: "Tiếng Việt",
        teacher: "Cô Hoa",
        room: "P101",
        type: "language",
        time: "7:30 - 8:15",
        description: "Luyện viết chữ",
        materials: ["Vở ô li", "Bút chì"],
      },
      3: {
        name: "Âm nhạc",
        teacher: "Cô Mai",
        room: "P201",
        type: "music",
        time: "9:15 - 10:00",
        description: "Học nhạc cụ đơn giản",
        materials: ["Không cần dụng cụ"],
      },
      5: {
        name: "Thể dục",
        teacher: "Thầy Nam",
        room: "Sân",
        type: "sports",
        time: "14:00 - 14:45",
        description: "Chạy và nhảy",
        materials: ["Quần áo thể thao"],
      },
    },
    friday: {
      2: {
        name: "Mỹ thuật",
        teacher: "Cô Linh",
        room: "P301",
        type: "art",
        time: "8:15 - 9:00",
        description: "Làm đồ thủ công",
        materials: ["Giấy màu", "Keo dán", "Kéo"],
      },
      4: {
        name: "Tiếng Anh",
        teacher: "Ms. Anna",
        room: "P102",
        type: "english",
        time: "10:00 - 10:45",
        description: "Học hội thoại",
        materials: ["Sách tiếng Anh"],
      },
      6: {
        name: "Khoa học",
        teacher: "Cô Nga",
        room: "P103",
        type: "science",
        time: "14:45 - 15:30",
        description: "Thí nghiệm đơn giản",
        materials: ["Dụng cụ thí nghiệm"],
      },
    },
  },
  1: {
    // Tuần 2
    monday: {
      1: {
        name: "Văn học",
        teacher: "Cô Hoa",
        room: "P101",
        type: "language",
        time: "7:30 - 8:15",
        description: "Đọc truyện cổ tích",
        materials: ["Sách văn học", "Vở ghi chép"],
      },
      3: {
        name: "Toán nâng cao",
        teacher: "Cô Lan",
        room: "P101",
        type: "math",
        time: "9:15 - 10:00",
        description: "Học phép trừ",
        materials: ["Sách toán", "Bút chì", "Thước"],
      },
      5: {
        name: "Kỹ năng sống",
        teacher: "Cô Thu",
        room: "P104",
        type: "life-skills",
        time: "14:00 - 14:45",
        description: "Học cách giao tiếp",
        materials: ["Không cần dụng cụ"],
      },
    },
    tuesday: {
      2: {
        name: "Tiếng Anh giao tiếp",
        teacher: "Ms. Anna",
        room: "P102",
        type: "english",
        time: "8:15 - 9:00",
        description: "Luyện phát âm",
        materials: ["Sách tiếng Anh", "Audio"],
      },
      4: {
        name: "Thể dục nhịp điệu",
        teacher: "Thầy Nam",
        room: "Sân",
        type: "sports",
        time: "10:00 - 10:45",
        description: "Học nhảy đơn giản",
        materials: ["Quần áo thể thao", "Giày nhẹ"],
      },
      6: {
        name: "Công nghệ",
        teacher: "Thầy Minh",
        room: "P401",
        type: "technology",
        time: "14:45 - 15:30",
        description: "Làm quen với máy tính",
        materials: ["Không cần dụng cụ"],
      },
    },
    wednesday: {
      1: {
        name: "Khoa học thực hành",
        teacher: "Cô Nga",
        room: "P103",
        type: "science",
        time: "7:30 - 8:15",
        description: "Quan sát thực vật",
        materials: ["Kính lúp", "Sổ quan sát"],
      },
      3: {
        name: "Âm nhạc dân gian",
        teacher: "Cô Mai",
        room: "P201",
        type: "music",
        time: "9:15 - 10:00",
        description: "Học hát dân ca",
        materials: ["Không cần dụng cụ"],
      },
      5: {
        name: "Toán tư duy",
        teacher: "Cô Lan",
        room: "P101",
        type: "math",
        time: "14:00 - 14:45",
        description: "Giải đố toán học",
        materials: ["Đồ chơi toán học"],
      },
    },
    thursday: {
      2: {
        name: "Lịch sử",
        teacher: "Thầy Hùng",
        room: "P105",
        type: "history",
        time: "8:15 - 9:00",
        description: "Tìm hiểu quê hương",
        materials: ["Sách lịch sử", "Bản đồ"],
      },
      4: {
        name: "Mỹ thuật sáng tạo",
        teacher: "Cô Linh",
        room: "P301",
        type: "art",
        time: "10:00 - 10:45",
        description: "Tạo hình từ đất sét",
        materials: ["Đất sét", "Dụng cụ tạo hình"],
      },
      6: {
        name: "Thể dục trò chơi",
        teacher: "Thầy Nam",
        room: "Sân",
        type: "sports",
        time: "14:45 - 15:30",
        description: "Chơi các trò chơi vận động",
        materials: ["Bóng", "Dây nhảy"],
      },
    },
    friday: {
      1: {
        name: "Đạo đức",
        teacher: "Cô Hương",
        room: "P106",
        type: "ethics",
        time: "7:30 - 8:15",
        description: "Học về lòng tốt",
        materials: ["Sách đạo đức"],
      },
      3: {
        name: "Tiếng Anh trò chơi",
        teacher: "Ms. Anna",
        room: "P102",
        type: "english",
        time: "9:15 - 10:00",
        description: "Học qua trò chơi",
        materials: ["Thẻ từ vựng", "Đồ chơi"],
      },
      5: {
        name: "Khoa học vui",
        teacher: "Cô Nga",
        room: "P103",
        type: "science",
        time: "14:00 - 14:45",
        description: "Thí nghiệm màu sắc",
        materials: ["Dụng cụ thí nghiệm an toàn"],
      },
    },
  },
});

// Computed property để lấy dữ liệu lịch học theo tuần hiện tại
const scheduleData = computed(() => {
  return allWeeksScheduleData.value[currentWeek.value] || {};
});

// Today's activities - cập nhật theo tuần
const todayActivities = computed(() => {
  if (currentWeek.value === 0) {
    return [
      {
        id: 1,
        title: "Tiếng Anh",
        time: "7:30 - 8:15",
        icon: "mdi mdi-translate",
        status: "completed",
        statusText: "Đã hoàn thành",
      },
      {
        id: 2,
        title: "Thể dục",
        time: "9:15 - 10:00",
        icon: "mdi mdi-run",
        status: "current",
        statusText: "Đang diễn ra",
      },
      {
        id: 3,
        title: "Mỹ thuật",
        time: "14:45 - 15:30",
        icon: "mdi mdi-palette",
        status: "upcoming",
        statusText: "Sắp tới",
      },
    ];
  } else if (currentWeek.value === 1) {
    return [
      {
        id: 1,
        title: "Văn học",
        time: "7:30 - 8:15",
        icon: "mdi mdi-book-open-variant",
        status: "completed",
        statusText: "Đã hoàn thành",
      },
      {
        id: 2,
        title: "Tiếng Anh giao tiếp",
        time: "8:15 - 9:00",
        icon: "mdi mdi-translate",
        status: "current",
        statusText: "Đang diễn ra",
      },
      {
        id: 3,
        title: "Công nghệ",
        time: "14:45 - 15:30",
        icon: "mdi mdi-laptop",
        status: "upcoming",
        statusText: "Sắp tới",
      },
    ];
  }
  return [];
});

// Weekly stats - cập nhật theo tuần
const weeklyStats = computed(() => {
  if (currentWeek.value === 0) {
    return {
      totalSubjects: 8,
      totalHours: 12,
      activities: 15,
    };
  } else if (currentWeek.value === 1) {
    return {
      totalSubjects: 9,
      totalHours: 14,
      activities: 18,
    };
  }
  return {
    totalSubjects: 0,
    totalHours: 0,
    activities: 0,
  };
});

// Computed properties
const currentWeekText = computed(() => {
  const weekNumber = Math.abs(currentWeek.value) + 1;
  return `Tuần ${weekNumber}`;
});

const currentDateRange = computed(() => {
  const baseDate = new Date(2024, 10, 25); // 25/11/2024
  const weekOffset = currentWeek.value * 7;
  const startDate = new Date(
    baseDate.getTime() + weekOffset * 24 * 60 * 60 * 1000
  );
  const endDate = new Date(
    baseDate.getTime() + (weekOffset + 4) * 24 * 60 * 60 * 1000
  );

  return `${formatDate(startDate)} - ${formatDate(endDate)}/2024`;
});

// Methods
const getSubjectForTimeSlot = (dayId, timeId) => {
  return scheduleData.value[dayId]?.[timeId] || null;
};

const openSubjectDetail = (subject) => {
  selectedSubject.value = subject;
};

const closeSubjectDetail = () => {
  selectedSubject.value = null;
};

const previousWeek = () => {
  currentWeek.value--;
};

const nextWeek = () => {
  currentWeek.value++;
};

onMounted(() => {
  // Initialize component
});
</script>

<style lang="scss">
@import "./style.scss";
</style>
