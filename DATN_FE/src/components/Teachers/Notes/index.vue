<template>
    <div class="notes-page">
        <div class="page-header mb-4">
            <h2 class="page-title">
                <i class="bx bx-edit me-2"></i>Sổ Đầu Bài
            </h2>
            <p class="page-subtitle">Ghi chép nội dung giảng dạy hàng ngày</p>
        </div>

        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Tạo ghi chú mới</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Ngày</label>
                            <input type="date" class="form-control" v-model="newNote.date" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Môn học</label>
                            <input type="text" class="form-control" v-model="newNote.subject"
                                placeholder="VD: Toán, Tiếng Việt..." />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nội dung bài học</label>
                            <textarea class="form-control" rows="5" v-model="newNote.content"
                                placeholder="Ghi chú nội dung bài học..."></textarea>
                        </div>
                        <button class="btn btn-primary">
                            <i class="bx bx-save me-2"></i>Lưu ghi chú
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Ghi chú gần đây</h5>
                    </div>
                    <div class="card-body">
                        <div class="note-item" v-for="note in recentNotes" :key="note.id">
                            <div class="note-date">{{ note.date }}</div>
                            <div class="note-subject">{{ note.subject }}</div>
                            <p class="note-preview">{{ note.content.substring(0, 50) }}...</p>
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
    name: 'Notes',
    setup() {
        const newNote = ref({
            date: new Date().toISOString().split('T')[0],
            subject: '',
            content: ''
        });

        const recentNotes = ref([
            { id: 1, date: '01/10/2024', subject: 'Toán', content: 'Học đếm số từ 1-10, nhận biết hình dạng cơ bản...' },
            { id: 2, date: '30/09/2024', subject: 'Tiếng Việt', content: 'Học chữ cái A, B, C. Luyện phát âm và viết...' }
        ]);

        return { newNote, recentNotes };
    }
};
</script>

<style scoped>
.notes-page {
    padding: 20px;
}

.note-item {
    padding: 12px;
    border-left: 3px solid #667eea;
    background: #f8f9fa;
    margin-bottom: 12px;
    border-radius: 8px;
}

.note-date {
    font-size: 0.85rem;
    color: #6c757d;
}

.note-subject {
    font-weight: 600;
    color: #2c3e50;
}

.note-preview {
    font-size: 0.9rem;
    margin: 5px 0 0 0;
    color: #6c757d;
}
</style>
