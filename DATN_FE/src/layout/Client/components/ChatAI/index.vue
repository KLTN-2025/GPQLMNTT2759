<template>
  <div>
    <!-- Floating round button -->
    <button
      class="chat-fab"
      aria-label="Open chat"
      v-if="!isOpen"
      @click="toggleChat"
    >
      <svg class="chat-fab__icon" viewBox="0 0 24 24" aria-hidden="true">
        <path
          d="M4 4h16v12H7l-3 3V4zm3 5h10M7 9h10M7 12h7"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
        />
      </svg>
    </button>

    <!-- Chat container -->
    <div
      v-if="isOpen"
      class="chat-container"
      role="dialog"
      aria-modal="true"
      aria-label="Chat dialog"
    >
      <header class="chat-header">
        <div class="chat-header__title">
          <span class="chat-header__avatar">🤖</span>
          <div>
            <div class="chat-header__name">Chat Assistant</div>
            <div class="chat-header__status">Online</div>
          </div>
        </div>
        <button
          class="chat-header__close"
          aria-label="Close chat"
          @click="toggleChat"
        >
          ✖
        </button>
      </header>

      <div ref="messagesEl" class="chat-messages">
        <div
          v-for="(m, idx) in messages"
          :key="idx"
          class="chat-message"
          :class="m.role === 'user' ? 'chat-message--user' : 'chat-message--bot'"
        >
          <div class="chat-message__bubble">{{ m.text }}</div>
          <div class="chat-message__meta">{{ m.time }}</div>
        </div>
      </div>

      <footer class="chat-input">
        <input
          v-model="draft"
          type="text"
          class="chat-input__field"
          placeholder="Nhập tin nhắn và nhấn Enter..."
          @keydown.enter="send"
        />
        <button
          class="chat-input__send"
          :disabled="!canSend"
          @click="send"
          aria-label="Send message"
        >
          Gửi
        </button>
      </footer>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted, nextTick } from 'vue'

// State
const isOpen = ref(false)
const draft = ref('')
const messages = ref([
  {
    role: 'bot',
    text: 'Xin chào! Mình có thể giúp gì cho bạn?',
    time: formatTime(new Date()),
  },
])

const messagesEl = ref(null)

// Helpers
function formatTime(d) {
  const hh = String(d.getHours()).padStart(2, '0')
  const mm = String(d.getMinutes()).padStart(2, '0')
  return `${hh}:${mm}`
}

const canSend = ref(false)
watch(draft, (v) => {
  canSend.value = String(v || '').trim().length > 0
})

// Auto-scroll when messages change
watch(messages, async () => {
  await nextTick()
  if (messagesEl.value) {
    messagesEl.value.scrollTop = messagesEl.value.scrollHeight
  }
}, { deep: true })

onMounted(() => {
  // Ensure initial scroll
  nextTick(() => {
    if (messagesEl.value) {
      messagesEl.value.scrollTop = messagesEl.value.scrollHeight
    }
  })
})

// Actions
function toggleChat() {
  isOpen.value = !isOpen.value
  if (isOpen.value) {
    nextTick(() => {
      if (messagesEl.value) {
        messagesEl.value.scrollTop = messagesEl.value.scrollHeight
      }
    })
  }
}

function send() {
  const text = draft.value.trim()
  if (!text) return
  const now = new Date()

  messages.value.push({
    role: 'user',
    text,
    time: formatTime(now),
  })
  draft.value = ''

  // Simulate bot reply
  setTimeout(() => {
    messages.value.push({
      role: 'bot',
      text: getBotReply(text),
      time: formatTime(new Date()),
    })
  }, 500)
}

function getBotReply(input) {
  const lower = input.toLowerCase()
  if (lower.includes('hello') || lower.includes('xin chào')) {
    return 'Chào bạn! Mình luôn sẵn sàng hỗ trợ.'
  }
  if (lower.includes('giúp')) {
    return 'Bạn mô tả thêm vấn đề để mình hỗ trợ nhé.'
  }
  return 'Mình đã nhận được tin nhắn, cảm ơn bạn!'
}
</script>

<style src="./style.scss" lang="scss" scoped></style>