<template>
    <div class="client-messages-page">
        <!-- Header -->
        <div class="messages-header">
            <div class="header-content">
                <div class="header-icon">
                    <i class='bx bx-message-rounded-dots'></i>
                </div>
                <div class="header-text">
                    <h1>Nhắn Tin</h1>
                    <p>Trò chuyện với giáo viên chủ nhiệm của bé</p>
                </div>
            </div>
        </div>

        <!-- Chat Container -->
        <div class="chat-container">
            <div class="row g-0">
                <!-- Chat Sidebar - col-4 -->
                <div class="col-lg-4 col-md-5 col-12">
                    <div class="chat-sidebar">
                        <div class="sidebar-header">
                            <h3>Cuộc trò chuyện</h3>
                            <div class="search-box">
                                <i class='bx bx-search'></i>
                                <input type="text" placeholder="Tìm kiếm..." v-model="searchQuery" />
                            </div>
                        </div>

                        <div class="conversation-list">
                            <div v-for="conv in filteredConversations" :key="conv.id" class="conversation-item"
                                :class="{ active: selectedConversation === conv.id }"
                                @click="selectConversation(conv.id)">
                                <div class="conv-avatar">
                                    <img :src="conv.avatar" :alt="conv.name" />
                                    <span v-if="conv.online" class="online-dot"></span>
                                </div>
                                <div class="conv-info">
                                    <div class="conv-header">
                                        <h4>{{ conv.name }}</h4>
                                        <span class="conv-time">{{ conv.time }}</span>
                                    </div>
                                    <p class="conv-preview">{{ conv.lastMessage }}</p>
                                </div>
                                <span v-if="conv.unread" class="unread-badge">{{ conv.unread }}</span>
                            </div>

                            <div v-if="filteredConversations.length === 0" class="empty-state">
                                <i class='bx bx-message-x'></i>
                                <p>Chưa có cuộc trò chuyện nào</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chat Area - col-8 -->
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="chat-area">
                        <div v-if="selectedConversation" class="chat-active">
                            <!-- Chat Header -->
                            <div class="chat-header">
                                <div class="chat-user">
                                    <img :src="selectedUser.avatar" :alt="selectedUser.name" />
                                    <div class="chat-user-info">
                                        <h4>{{ selectedUser.name }}</h4>
                                        <span class="status">
                                            <i class='bx bxs-circle'
                                                :class="selectedUser.online ? 'online' : 'offline'"></i>
                                            {{ selectedUser.online ? 'Đang hoạt động' : 'Offline' }}
                                        </span>
                                    </div>
                                </div>
                                <button class="btn-icon" title="Thông tin">
                                    <i class='bx bx-info-circle'></i>
                                </button>
                            </div>

                            <!-- Messages -->
                            <div class="messages-container" ref="messagesContainer">
                                <div v-for="(msg, index) in currentMessages" :key="index" class="message"
                                    :class="msg.sender === 'me' ? 'message-sent' : 'message-received'">
                                    <div class="message-bubble">
                                        <p>{{ msg.text }}</p>
                                        <span class="message-time">{{ msg.time }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Input Area -->
                            <div class="chat-input-area">
                                <button class="btn-attach" title="Đính kèm file">
                                    <i class='bx bx-paperclip'></i>
                                </button>
                                <input type="text" class="message-input" placeholder="Nhập tin nhắn..."
                                    v-model="newMessage" @keyup.enter="sendMessage" />
                                <button class="btn-send" @click="sendMessage" :disabled="!newMessage.trim()">
                                    <i class='bx bx-send'></i>
                                </button>
                            </div>
                        </div>

                        <!-- Empty State -->
                        <div v-else class="chat-empty">
                            <div class="empty-content">
                                <i class='bx bx-message-square-dots'></i>
                                <h3>Chào mừng bạn đến trang nhắn tin</h3>
                                <p>Chọn cuộc trò chuyện để bắt đầu nhắn tin với giáo viên</p>
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
import baseRequestClient from '../../../core/baseRequestClient';

export default {
    name: 'ClientMessages',
    setup() {
        const selectedConversation = ref(null);
        const searchQuery = ref('');
        const newMessage = ref('');
        const conversations = ref([]);
        const chatMessages = ref({});
        const messagesContainer = ref(null);

        const filteredConversations = computed(() => {
            if (!searchQuery.value) return conversations.value;
            return conversations.value.filter(conv =>
                conv.name?.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                conv.lastMessage?.toLowerCase().includes(searchQuery.value.toLowerCase())
            );
        });

        const selectedUser = computed(() => {
            return conversations.value.find(c => c.id === selectedConversation.value) || {};
        });

        const currentMessages = computed(() => {
            return chatMessages.value[selectedConversation.value] || [];
        });

        const selectConversation = async (id) => {
            selectedConversation.value = id;

            try {
                const res = await baseRequestClient.get(`phu-huynh/chat/messages/${id}`);
                if (res.data.status) {
                    chatMessages.value[id] = res.data.data;
                    await nextTick();
                    scrollToBottom();
                }

                await baseRequestClient.post(`phu-huynh/chat/mark-as-read/${id}`);

                const conv = conversations.value.find(c => c.id === id);
                if (conv) conv.unread = 0;
            } catch (error) {
                console.error('Error loading messages:', error);
            }
        };

        const sendMessage = async () => {
            if (!newMessage.value.trim() || !selectedConversation.value) return;

            try {
                const res = await baseRequestClient.post('phu-huynh/chat/send-message', {
                    conversation_id: selectedConversation.value,
                    noi_dung: newMessage.value
                });

                if (res.data.status) {
                    if (!chatMessages.value[selectedConversation.value]) {
                        chatMessages.value[selectedConversation.value] = [];
                    }

                    chatMessages.value[selectedConversation.value].push(res.data.data);

                    const conv = conversations.value.find(c => c.id === selectedConversation.value);
                    if (conv) {
                        conv.lastMessage = newMessage.value;
                        conv.time = 'Vừa xong';
                    }

                    newMessage.value = '';
                    await nextTick();
                    scrollToBottom();
                }
            } catch (error) {
                console.error('Error sending message:', error);
            }
        };

        const loadConversations = async () => {
            try {
                const res = await baseRequestClient.get('phu-huynh/chat/conversations');
                if (res.data.status) {
                    conversations.value = res.data.data.map(conv => ({
                        id: conv.id,
                        name: conv.partner_name,
                        avatar: conv.partner_avatar || '/default-avatar.png',
                        lastMessage: conv.last_message || 'Chưa có tin nhắn',
                        time: conv.last_time || '',
                        unread: conv.unread_count,
                        online: conv.online
                    }));

                    setupWebSocketListeners();
                }
            } catch (error) {
                console.error('Error loading conversations:', error);
            }
        };

        const scrollToBottom = () => {
            if (messagesContainer.value) {
                messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
            }
        };

        // WebSocket setup
        const channels = ref([]);

        const setupWebSocketListeners = () => {
            channels.value.forEach(channel => channel.stopListening('MessageSent'));
            channels.value = [];

            conversations.value.forEach(conv => {
                const channel = window.Echo.private(`conversation.${conv.id}`);

                channel.listen('MessageSent', async (event) => {
                    if (selectedConversation.value === conv.id) {
                        if (!chatMessages.value[conv.id]) {
                            chatMessages.value[conv.id] = [];
                        }
                        chatMessages.value[conv.id].push(event.message);
                        await nextTick();
                        scrollToBottom();
                    }

                    const conversation = conversations.value.find(c => c.id === conv.id);
                    if (conversation) {
                        conversation.lastMessage = event.message.text;
                        conversation.time = event.message.time;
                        conversation.unread = selectedConversation.value === conv.id ? 0 : (conversation.unread || 0) + 1;

                        conversations.value = [
                            conversation,
                            ...conversations.value.filter(c => c.id !== conv.id)
                        ];
                    }
                });

                channels.value.push(channel);
            });
        };

        onMounted(() => {
            loadConversations();
        });

        onUnmounted(() => {
            channels.value.forEach(channel => {
                channel.stopListening('MessageSent');
            });
        });

        return {
            selectedConversation,
            searchQuery,
            newMessage,
            conversations,
            filteredConversations,
            selectedUser,
            currentMessages,
            messagesContainer,
            selectConversation,
            sendMessage,
        };
    }
};
</script>

<style lang="scss" scoped>
@import './style.scss';
</style>
