<template>
    <div class="messages-page">
        <div class="page-header mb-4">
            <h2 class="page-title">
                <i class="bx bx-message me-2"></i>Tin Nhắn
            </h2>
            <p class="page-subtitle">Nhắn tin với phụ huynh và đồng nghiệp</p>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Danh sách tin nhắn</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="message-list">
                            <div class="message-item" :class="{ active: selectedMessage === msg.id }"
                                v-for="msg in messages" :key="msg.id" @click="selectedMessage = msg.id">
                                <img :src="msg.avatar" class="message-avatar" :alt="msg.name" />
                                <div class="message-info">
                                    <h6>{{ msg.name }}</h6>
                                    <p>{{ msg.lastMessage }}</p>
                                    <small>{{ msg.time }}</small>
                                </div>
                                <span v-if="msg.unread" class="unread-badge">{{ msg.unread }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Cuộc trò chuyện</h5>
                    </div>
                    <div class="card-body">
                        <div class="chat-area">
                            <div class="text-center text-muted">
                                <i class="bx bx-message-dots" style="font-size: 3rem;"></i>
                                <p>Chọn một cuộc trò chuyện để bắt đầu</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';

export default {
    name: 'Messages',
    setup() {
        const selectedMessage = ref(null);
        const messages = ref([
            { id: 1, name: 'Phụ huynh Nguyễn Văn A', lastMessage: 'Con em hôm nay học thế nào ạ?', time: '10 phút trước', unread: 2, avatar: '/src/assets/images/avatars/avatar-1.png' },
            { id: 2, name: 'Phụ huynh Trần Thị B', lastMessage: 'Cảm ơn cô nhiều!', time: '1 giờ trước', unread: 0, avatar: '/src/assets/images/avatars/avatar-2.png' },
            { id: 3, name: 'Giáo viên Lê Thị C', lastMessage: 'Ngày mai họp tổ nhé!', time: '2 giờ trước', unread: 1, avatar: '/src/assets/images/avatars/avatar-3.png' },
        ]);

        return { selectedMessage, messages };
    }
};
</script>

<style scoped>
.messages-page {
    padding: 20px;
}

.message-list {
    max-height: 600px;
    overflow-y: auto;
}

.message-item {
    display: flex;
    align-items: center;
    padding: 15px;
    border-bottom: 1px solid #e9ecef;
    cursor: pointer;
    transition: background 0.3s ease;
    position: relative;
}

.message-item:hover,
.message-item.active {
    background: #f8f9fa;
}

.message-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 15px;
}

.message-info {
    flex: 1;
}

.message-info h6 {
    margin: 0;
    font-weight: 600;
}

.message-info p {
    margin: 5px 0;
    font-size: 0.9rem;
    color: #6c757d;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.message-info small {
    color: #999;
}

.unread-badge {
    background: #667eea;
    color: white;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 600;
}

.chat-area {
    min-height: 500px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
