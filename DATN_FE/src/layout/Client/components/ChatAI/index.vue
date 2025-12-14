<template>
  <div>
    <!-- Floating Chat Button -->
    <div
      :class="['chat-fab', { 'is-active': chatOpen }]"
      @click="toggleChat"
    >
      <div class="chat-fab-icon">
        <transition name="icon-fade" mode="out-in">
          <img v-if="!chatOpen" :src="botAvatar" alt="AI" key="avatar" />
          <svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" key="close">
            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </transition>
      </div>
    </div>

    <!-- Chat Window -->
    <transition name="chat-fade">
      <div v-if="chatOpen" class="chat-container">
        <!-- Background Overlay -->
        <div class="chat-bg-overlay"></div>

        <!-- Header -->
       
        <!-- Messages Area -->
        <div class="chat-body" ref="messagesEl">
          <!-- Copilot-style Welcome Screen -->
          <div v-if="messages.length === 0" class="welcome-container">
            <div class="welcome-content">
              <h1>{{ greeting }}</h1>
              <h2>Mầm non Hoa Sen có thể giúp gì cho bạn?</h2>
              
              <div class="suggestion-grid">
                <button class="suggestion-card" @click="fillDraft('Thực đơn hôm nay có gì?')">
                  <span class="icon">🥦</span>
                  <span class="text">Thực đơn</span>
                </button>
                <button class="suggestion-card" @click="fillDraft('Học phí tháng này bao nhiêu?')">
                  <span class="icon">💰</span>
                  <span class="text">Học phí</span>
                </button>
                <button class="suggestion-card" @click="fillDraft('Thời gian đưa đón trẻ?')">
                  <span class="icon">⏰</span>
                  <span class="text">Giờ giấc</span>
                </button>
                <button class="suggestion-card" @click="fillDraft('Hoạt động ngoại khóa sắp tới?')">
                  <span class="icon">🎨</span>
                  <span class="text">Hoạt động</span>
                </button>
              </div>
            </div>
          </div>

          <!-- Message List -->
          <TransitionGroup v-else name="message-anim" tag="div" class="message-list">
            <div
              v-for="(msg, index) in messages"
              :key="index"
              :class="['message-row', msg.role === 'user' ? 'message-right' : 'message-left']"
            >
              <div v-if="msg.role !== 'user'" class="message-avatar">
                <img :src="botAvatar" alt="Bot" />
              </div>
              
              <div class="message-content">
                <div class="message-bubble" v-html="formatMessage(msg.text)"></div>
                <!-- <div class="message-time">{{ msg.time }}</div> -->
              </div>
            </div>

            <!-- Typing Indicator -->
            <div v-if="isLoading" class="message-row message-left" key="typing">
              <div class="message-avatar">
                <img :src="botAvatar" alt="Bot" />
              </div>
              <div class="message-bubble typing-bubble">
                <div class="typing-dots">
                  <span></span><span></span><span></span>
                </div>
              </div>
            </div>
          </TransitionGroup>
        </div>

        <!-- Floating Input Area -->
        <div class="chat-footer">
          <div class="input-capsule">
            <button class="attach-btn">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
            <input
              type="text"
              v-model="draft"
              @keyup.enter="send"
              placeholder="Nhập câu hỏi của bạn..."
              :disabled="isLoading"
            />
            <div class="input-actions">
               <button class="send-btn" @click="send" :disabled="!canSend">
                <svg viewBox="0 0 24 24" fill="currentColor">
                   <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                </svg>
              </button>
            </div>
          </div>
          <div class="footer-note">AI có thể mắc lỗi. Hãy kiểm tra thông tin quan trọng.</div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, watch, onMounted, nextTick, computed } from 'vue'
import axios from 'axios'
import botAvatar from '../../../../assets/images/logo-icon.png'

const API_BASE_URL = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'

const chatOpen = ref(false)
const draft = ref('')
const messages = ref([])
const isLoading = ref(false)
const messagesEl = ref(null)

const greeting = computed(() => {
  const hour = new Date().getHours()
  if (hour < 12) return 'Chào buổi sáng'
  if (hour < 18) return 'Chào buổi chiều'
  return 'Chào buổi tối'
})

function formatTime(d) {
  if (!d) return ''
  const date = new Date(d)
  const hh = String(date.getHours()).padStart(2, '0')
  const mm = String(date.getMinutes()).padStart(2, '0')
  return `${hh}:${mm}`
}

function formatMessage(text) {
  if (!text) return ''
  return text
    .replace(/\n/g, '<br>')
    .replace(/^[•\-*]\s+(.+)$/gm, '<div class="list-item">• $1</div>')
    .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
}

// Basic local responses for demo/fallback
function getCurrentDayInfo() {
  const days = ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy']
  const now = new Date()
  return {
    dayName: days[now.getDay()],
    fullDate: `${now.getDate()}/${now.getMonth() + 1}/${now.getFullYear()}`,
    time: formatTime(now)
  }
}

function getBasicResponse(message) {
  const msg = message.toLowerCase().trim()
  const dayInfo = getCurrentDayInfo()
  
  if (msg.match(/(hôm nay|bây giờ).*(thứ mấy|ngày nào)/i)) {
    return `Hôm nay là ${dayInfo.dayName}, ngày ${dayInfo.fullDate}.`
  }
  if (msg.match(/(mấy giờ|bây giờ|hiện tại)/i)) {
    return `Hiện tại là ${dayInfo.time}, ${dayInfo.dayName}, ngày ${dayInfo.fullDate}.`
  }
  if (msg.match(/^(hi|hello|chào|xin chào)$/i)) {
    return `Xin chào! Tôi là AI Hoa Sen. Tôi có thể giúp gì cho bạn?`
  }
  return null
}

const canSend = computed(() => {
  return String(draft.value || '').trim().length > 0 && !isLoading.value
})

watch([messages, isLoading], async () => {
  await nextTick()
  if (messagesEl.value) {
    messagesEl.value.scrollTo({
      top: messagesEl.value.scrollHeight,
      behavior: 'smooth'
    })
  }
}, { deep: true })

async function loadChatHistory() {
  try {
    const response = await axios.post(`${API_BASE_URL}/chat/history`, {}, {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('token') || ''}`,
        'Content-Type': 'application/json'
      }
    })
    if (response.data.success && response.data.history?.length) {
      messages.value = response.data.history.map(msg => ({
        role: msg.role === 'assistant' ? 'bot' : 'user',
        text: msg.content,
        time: formatTime(new Date())
      }))
    }
  } catch (error) {
    console.error('Error loading history:', error)
  }
}

onMounted(loadChatHistory)

function toggleChat() {
  chatOpen.value = !chatOpen.value
}

function resetChat() {
  messages.value = [] // Optional: clear view to show welcome screen again, or navigate home
}

function fillDraft(text) {
  draft.value = text
  send()
}

async function send() {
  const text = draft.value.trim()
  if (!text || isLoading.value) return
  
  messages.value.push({
    role: 'user',
    text,
    time: formatTime(new Date())
  })
  draft.value = ''
  
  const basicResponse = getBasicResponse(text)
  if (basicResponse) {
    isLoading.value = true
    setTimeout(() => {
      messages.value.push({
        role: 'bot',
        text: basicResponse,
        time: formatTime(new Date())
      })
      isLoading.value = false
    }, 500)
    return
  }
  
  isLoading.value = true
  try {
    const response = await axios.post(`${API_BASE_URL}/tu-van-ai`, 
      { message: text },
      {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token') || ''}`,
          'Content-Type': 'application/json'
        }
      }
    )
    if (response.data.success && response.data.data) {
      messages.value.push({
        role: 'bot',
        text: response.data.data,
        time: formatTime(new Date())
      })
    }
  } catch (error) {
    messages.value.push({
      role: 'bot',
      text: 'Xin lỗi, đã có lỗi xảy ra. Vui lòng thử lại.',
      time: formatTime(new Date())
    })
  } finally {
    isLoading.value = false
  }
}
</script>

<style src="./style.scss" lang="scss" scoped></style>
