<template>
  <div class="teacher-messages-page">
    <div class="chat-container">
      <div class="row g-3">
        <!-- Sidebar Column (Fixed width) -->
        <div class="col-4">
          <div class="chat-sidebar">
            <!-- 1. Mode Toggles -->
            <div class="chat-mode-tabs">
              <button :class="['mode-tab', { active: chatMode === 'group' }]" @click="switchMode('group')">
                <i class="bx bx-group"></i>
                <span>Nhóm lớp</span>
              </button>
              <button :class="['mode-tab', { active: chatMode === 'private' }]" @click="switchMode('private')">
                <i class="bx bx-user"></i>
                <span>Riêng tư</span>
              </button>
            </div>

            <!-- 2. Search -->
            <div class="search-box">
              <i class="bx bx-search"></i>
              <input type="text" placeholder="Tìm kiếm..." v-model="searchQuery" />
            </div>

            <!-- 3. Lists Area -->
            <!-- Group List -->
            <div v-if="chatMode === 'group'" class="conversations-list">
              <div v-if="groupChat" class="conversation-item group-item" :class="{ active: selectedGroupChat }"
                @click="selectGroupChat">
                <div class="conversation-avatar group-avatar">
                  <i class="bx bx-group"></i>
                </div>
                <div class="conversation-info">
                  <div class="conversation-header">
                    <h6>{{ groupChat.ten_nhom }}</h6>
                    <span class="conversation-time">{{ lastGroupMessageTime }}</span>
                  </div>
                  <p class="conversation-preview">{{ lastGroupMessage }}</p>
                  <span v-if="groupUnreadCount > 0" class="unread-badge">{{ groupUnreadCount }}</span>
                </div>
              </div>
              <div v-else class="empty-state">
                <div class="spinner-border text-primary" role="status" v-if="loadingGroup">
                  <span class="visually-hidden">Loading...</span>
                </div>
                <div v-else>
                  <i class="bx bx-error-circle"></i>
                  <p>Không tìm thấy nhóm lớp</p>
                </div>
              </div>
            </div>

            <!-- Private List -->
            <div v-else class="conversations-list">
              <button class="btn-new-chat" @click="showParentModal = true">
                <i class="bx bx-plus-circle"></i>
                Tạo cuộc trò chuyện mới
              </button>

              <div v-for="conv in filteredPrivateConversations" :key="conv.id" class="conversation-item"
                :class="{ active: selectedPrivateConv === conv.id }" @click="selectPrivateConversation(conv.id)">
                <div class="conversation-avatar">
                  <img :src="conv.partner_avatar || '/assets/images/users/default-avatar.png'"
                    :alt="conv.partner_name" />
                  <span v-if="conv.online" class="online-badge"></span>
                </div>
                <div class="conversation-info">
                  <div class="conversation-header">
                    <h6>{{ conv.partner_name }}</h6>
                    <span class="conversation-time">{{ formatTime(conv.last_time) }}</span>
                  </div>
                  <p class="conversation-preview">{{ conv.last_message || 'Bắt đầu trò chuyện' }}</p>
                  <span v-if="conv.unread_count > 0" class="unread-badge">{{ conv.unread_count }}</span>
                </div>
              </div>

              <div v-if="privateConversations.length === 0 && !loadingPrivate" class="empty-state">
                <i class="bx bx-message-dots"></i>
                <p>Chưa có cuộc trò chuyện nào</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Chat Area Column (Fixed width) -->
        <div class="col-8">
          <div class="chat-area">
            <!-- Case 1: Group Chat Active -->
            <template v-if="chatMode === 'group' && selectedGroupChat">
              <div class="chat-header">
                <div class="chat-header-info">
                  <div class="chat-avatar group-avatar">
                    <i class="bx bx-group"></i>
                  </div>
                  <div class="chat-details">
                    <h5>{{ groupChat.ten_nhom }}</h5>
                    <p>{{ groupParticipantsCount }} thành viên</p>
                  </div>
                </div>
              </div>

              <div class="chat-messages" ref="groupMessagesContainer">
                <div v-for="message in groupMessages" :key="message.id" class="message-bubble"
                  :class="message.sender_type === 'giao_vien' ? 'message-sent' : 'message-received'">
                  <div class="message-content">
                    <p class="sender-name" v-if="message.sender_type === 'phu_huynh'">
                      {{ message.nguoi_gui_info?.ho_va_ten }}
                    </p>
                    <p class="message-text">{{ message.noi_dung }}</p>
                    <span class="message-timestamp">{{ formatTime(message.created_at) }}</span>
                  </div>
                </div>
              </div>

              <div class="chat-input-area">
                <div class="chat-input-wrapper">
                  <input type="text" class="chat-input" placeholder="Nhập tin nhắn gửi nhóm..."
                    v-model="newGroupMessage" @keyup.enter="sendGroupMessage" />
                  <button class="btn-send" @click="sendGroupMessage" :disabled="!newGroupMessage.trim()">
                    <i class="bx bx-send"></i>
                  </button>
                </div>
              </div>
            </template>

            <!-- Case 2: Private Chat Active -->
            <template v-else-if="chatMode === 'private' && selectedPrivateConv">
              <div class="chat-header">
                <div class="chat-header-info">
                  <div class="chat-avatar">
                    <img :src="getSelectedPrivateConv().partner_avatar || '/assets/images/users/default-avatar.png'"
                      alt="Avatar" />
                  </div>
                  <div class="chat-details">
                    <h5>{{ getSelectedPrivateConv().partner_name }}</h5>
                    <p v-if="getSelectedPrivateConv().online" class="status-online">Đang hoạt động</p>
                  </div>
                </div>
              </div>

              <div class="chat-messages" ref="privateMessagesContainer">
                <div v-for="message in getPrivateMessages()" :key="message.id" class="message-bubble"
                  :class="message.sender === 'me' ? 'message-sent' : 'message-received'">
                  <div class="message-content">
                    <p class="message-text">{{ message.noi_dung || message.text }}</p>
                    <span class="message-timestamp">{{ formatTime(message.created_at || message.time) }}</span>
                  </div>
                </div>
              </div>

              <div class="chat-input-area">
                <div class="chat-input-wrapper">
                  <input type="text" class="chat-input" placeholder="Nhập tin nhắn..." v-model="newPrivateMessage"
                    @keyup.enter="sendPrivateMessage" />
                  <button class="btn-send" @click="sendPrivateMessage" :disabled="!newPrivateMessage.trim()">
                    <i class="bx bx-send"></i>
                  </button>
                </div>
              </div>
            </template>

            <!-- Case 3: Empty State -->
            <div v-else class="chat-empty">
              <i class="bx bx-message-square-dots"></i>
              <h3>Chọn cuộc trò chuyện để bắt đầu</h3>
              <p>Chọn từ danh sách bên trái hoặc tạo cuộc trò chuyện mới</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modals -->
    <div class="modal fade" :class="{ show: showParentModal }" :style="{ display: showParentModal ? 'block' : 'none' }"
      v-if="showParentModal" @click.self="showParentModal = false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Chọn phụ huynh</h5>
            <button type="button" class="btn-close" @click="showParentModal = false"></button>
          </div>
          <div class="modal-body">
            <div class="parent-search-box">
              <i class="bx bx-search"></i>
              <input type="text" placeholder="Tìm kiếm..." v-model="parentSearchQuery" />
            </div>
            <div class="parent-list">
              <div v-for="parent in filteredParents" :key="parent.id" class="parent-item"
                @click="createConversation(parent.id)">
                <div class="parent-avatar">
                  <i class="bx bx-user"></i>
                </div>
                <div class="parent-info">
                  <h6>{{ parent.ho_ten }}</h6>
                  <p>{{ parent.email }}</p>
                </div>
                <i class="bx bx-message-square-add"></i>
              </div>
              <div v-if="filteredParents.length === 0" class="empty-parents">
                <p>Không tìm thấy kết quả</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted, onUnmounted, nextTick } from 'vue';
import baseRequestTeacher from '../../../core/baseRequestTeacher';
// Import Echo only if configured globally or locally, assuming global window.Echo usage or verified import
// If window.Echo is used, we check for it.

export default {
  name: 'TeacherMessages',
  setup() {
    // UI State
    const chatMode = ref('group'); // 'group' | 'private'
    const searchQuery = ref('');
    const loadingGroup = ref(false);
    const loadingPrivate = ref(false);

    // Group Data
    const groupChat = ref(null);
    const selectedGroupChat = ref(false);
    const groupMessages = ref([]);
    const newGroupMessage = ref('');
    const groupUnreadCount = ref(0);
    const groupMessagesContainer = ref(null);

    // Private Data
    const privateConversations = ref([]);
    const selectedPrivateConv = ref(null);
    const privateMessages = ref({}); // Map: convId -> messages[]
    const newPrivateMessage = ref('');
    const privateMessagesContainer = ref(null);

    // Modal Data
    const showParentModal = ref(false);
    const parentsList = ref([]);
    const parentSearchQuery = ref('');

    // --- Computed Properties ---

    const filteredPrivateConversations = computed(() => {
      if (!searchQuery.value) return privateConversations.value;
      const query = searchQuery.value.toLowerCase();
      return privateConversations.value.filter(conv =>
        conv.partner_name?.toLowerCase().includes(query)
      );
    });

    const filteredParents = computed(() => {
      if (!parentSearchQuery.value) return parentsList.value;
      const query = parentSearchQuery.value.toLowerCase();
      return parentsList.value.filter(parent =>
        parent.ho_ten?.toLowerCase().includes(query) ||
        parent.email?.toLowerCase().includes(query)
      );
    });

    const lastGroupMessage = computed(() => {
      if (groupMessages.value.length === 0) return 'Chưa có tin nhắn';
      return groupMessages.value[groupMessages.value.length - 1]?.noi_dung || '';
    });

    const lastGroupMessageTime = computed(() => {
      if (groupMessages.value.length === 0) return '';
      return formatTime(groupMessages.value[groupMessages.value.length - 1]?.created_at);
    });

    const groupParticipantsCount = computed(() => 20); // Placeholder or API data

    // --- Actions ---

    const switchMode = (mode) => {
      chatMode.value = mode;
      selectedGroupChat.value = false;
      selectedPrivateConv.value = null;
    };

    const formatTime = (dateString) => {
      if (!dateString) return '';
      const date = new Date(dateString);
      const now = new Date();
      const diff = now - date;

      if (diff < 60000) return 'Vừa xong';
      if (diff < 3600000) return `${Math.floor(diff / 60000)} phút trước`;
      if (diff < 86400000) return `${Math.floor(diff / 3600000)} giờ trước`;
      return date.toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit' });
    };

    const scrollToBottom = (container) => {
      if (container) {
        container.scrollTop = container.scrollHeight;
      }
    };

    // --- API Calls ---

    const loadGroupChat = async () => {
      loadingGroup.value = true;
      try {
        const res = await baseRequestTeacher.get('teacher/group-chat/my-class');
        if (res.data.status) {
          groupChat.value = res.data.data;
          await loadGroupMessages();
        }
      } catch (error) {
        console.error('Group chat error:', error);
      } finally {
        loadingGroup.value = false;
      }
    };

    const loadGroupMessages = async () => {
      if (!groupChat.value) return;
      try {
        const res = await baseRequestTeacher.get(`teacher/group-chat/${groupChat.value.id}/messages`);
        if (res.data.status) {
          const rawMessages = res.data.data?.messages || res.data.data || [];
          groupMessages.value = Array.isArray(rawMessages) ? rawMessages.reverse() : [];
          await nextTick();
          scrollToBottom(groupMessagesContainer.value);
        }
      } catch (error) {
        console.error('Load group msgs error:', error);
      }
    };

    const sendGroupMessage = async () => {
      if (!newGroupMessage.value.trim() || !groupChat.value) return;
      try {
        const res = await baseRequestTeacher.post(`teacher/group-chat/${groupChat.value.id}/send`, {
          noi_dung: newGroupMessage.value
        });
        if (res.data.status) {
          groupMessages.value.push(res.data.data);
          newGroupMessage.value = '';
          await nextTick();
          scrollToBottom(groupMessagesContainer.value);
        }
      } catch (error) {
        console.error('Send group msg error:', error);
      }
    };

    const selectGroupChat = async () => {
      selectedGroupChat.value = true;
      selectedPrivateConv.value = null;
      await nextTick();
      scrollToBottom(groupMessagesContainer.value);
    };

    // --- Private Chats ---

    const loadPrivateConversations = async () => {
      loadingPrivate.value = true;
      try {
        const res = await baseRequestTeacher.get('teacher/chat/conversations');
        if (res.data.status) {
          privateConversations.value = res.data.data || [];
        }
      } catch (error) {
        console.error('Load priv convs error:', error);
      } finally {
        loadingPrivate.value = false;
      }
    };

    const selectPrivateConversation = async (convId) => {
      selectedPrivateConv.value = convId;
      selectedGroupChat.value = false;

      try {
        const res = await baseRequestTeacher.get(`teacher/chat/messages/${convId}`);
        if (res.data.status) {
          const rawMessages = res.data.data?.messages || res.data.data || [];
          privateMessages.value[convId] = Array.isArray(rawMessages) ? rawMessages : [];
          await nextTick();
          scrollToBottom(privateMessagesContainer.value);
        }
        await baseRequestTeacher.post(`teacher/chat/mark-as-read/${convId}`);
      } catch (error) {
        console.error('Select priv conv error:', error);
      }
    };

    const sendPrivateMessage = async () => {
      if (!newPrivateMessage.value.trim() || !selectedPrivateConv.value) return;
      try {
        const res = await baseRequestTeacher.post('teacher/chat/send-message', {
          conversation_id: selectedPrivateConv.value,
          noi_dung: newPrivateMessage.value
        });
        if (res.data.status) {
          if (!privateMessages.value[selectedPrivateConv.value]) {
            privateMessages.value[selectedPrivateConv.value] = [];
          }
          privateMessages.value[selectedPrivateConv.value].push(res.data.data);
          newPrivateMessage.value = '';
          await nextTick();
          scrollToBottom(privateMessagesContainer.value);
        }
      } catch (error) {
        console.error('Send priv msg error:', error);
      }
    };

    const getSelectedPrivateConv = () => {
      return privateConversations.value.find(c => c.id === selectedPrivateConv.value) || {};
    };

    const getPrivateMessages = () => {
      return privateMessages.value[selectedPrivateConv.value] || [];
    };

    // --- Parent Modal ---

    const loadParents = async () => {
      try {
        const res = await baseRequestTeacher.get('teacher/my-class/phu-huynh/data');
        if (res.data.status) {
          parentsList.value = res.data.data || [];
        }
      } catch (error) {
        console.error('Load parents error:', error);
      }
    };

    const createConversation = async (parentId) => {
      try {
        const res = await baseRequestTeacher.get(`teacher/chat/conversation/${parentId}`);
        if (res.data.status) {
          showParentModal.value = false;
          chatMode.value = 'private';
          // Refresh list to show new conversation immediately if needed
          await loadPrivateConversations();
          selectPrivateConversation(res.data.data.conversation_id || res.data.data.id);
        }
      } catch (error) {
        console.error('Create conv error:', error);
      }
    };

    // --- WebSockets ---

    const setupWebSocketListeners = () => {
      if (!window.Echo) return;

      // Listen for group messages
      if (groupChat.value?.id) {
        window.Echo.private(`group-chat.${groupChat.value.id}`)
          .listen('GroupMessageSent', (e) => {
            if (e.message) {
              groupMessages.value.push(e.message);
              if (selectedGroupChat.value) {
                nextTick(() => scrollToBottom(groupMessagesContainer.value));
              } else {
                groupUnreadCount.value++;
              }
            }
          });
      }

      // Additional listeners for private chats can be added here or dynamically
    };

    onMounted(async () => {
      await Promise.all([
        loadGroupChat(),
        loadPrivateConversations(),
        loadParents()
      ]);
      setupWebSocketListeners();

      // Auto-select group chat if available
      if (groupChat.value) {
        selectGroupChat();
      }
    });

    onUnmounted(() => {
      if (window.Echo && groupChat.value?.id) {
        window.Echo.leave(`group-chat.${groupChat.value.id}`);
      }
    });

    return {
      // State
      chatMode,
      searchQuery,
      loadingGroup,

      // Group
      groupChat,
      selectedGroupChat,
      groupMessages,
      newGroupMessage,
      groupUnreadCount,
      groupMessagesContainer,
      lastGroupMessage,
      lastGroupMessageTime,
      groupParticipantsCount,

      // Private
      privateConversations,
      selectedPrivateConv,
      newPrivateMessage,
      privateMessagesContainer,
      filteredPrivateConversations,

      // Modal
      showParentModal,
      parentSearchQuery,
      filteredParents,

      // Actions
      switchMode,
      selectGroupChat,
      sendGroupMessage,
      selectPrivateConversation,
      sendPrivateMessage,
      createConversation,

      // Helpers
      getSelectedPrivateConv,
      getPrivateMessages,
      formatTime,
    };
  }
};
</script>

<style scoped src="./style.scss"></style>
