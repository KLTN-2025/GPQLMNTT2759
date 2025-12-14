<template>
    <div class="notes-page">
        <!-- Header Section -->
        <div class="page-header education-theme">
            <div class="container-fluid">
                <div class="page-header-content">
                    <div class="page-icon">
                        <i class="bx bx-edit"></i>
                    </div>
                    <div class="page-info">
                        <h1 class="page-title">Sổ Đầu Bài</h1>
                        <p class="page-subtitle">Ghi chép nội dung giảng dạy hàng ngày</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes Content -->
        <div class="notes-content">
            <div class="container-fluid">
                <div class="row g-4">
                    <!-- Create Note Form -->
                    <div class="col-xl-8">
                        <div class="note-form-card">
                            <div class="card-header-custom">
                                <div class="header-content">
                                    <div class="header-icon">
                                        <i class="bx bx-edit-alt"></i>
                                    </div>
                                    <div class="header-text">
                                        <h5 class="card-title">Tạo ghi chú mới</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="saveNote">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Ngày <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" v-model="newNote.date" required />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Môn học <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" v-model="newNote.subject"
                                                placeholder="VD: Toán, Tiếng Việt..." required />
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Nội dung bài học <span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" rows="8" v-model="newNote.content"
                                                placeholder="Ghi chú nội dung bài học..." required></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bx bx-save"></i>
                                                Lưu ghi chú
                                            </button>
                                            <button type="button" class="btn btn-secondary" @click="resetForm">
                                                <i class="bx bx-reset"></i>
                                                Đặt lại
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Notes -->
                    <div class="col-xl-4">
                        <div class="recent-notes-card">
                            <div class="card-header-custom">
                                <div class="header-content">
                                    <div class="header-icon">
                                        <i class="bx bx-history"></i>
                                    </div>
                                    <div class="header-text">
                                        <h5 class="card-title">Ghi chú gần đây</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div v-if="recentNotes.length === 0" class="empty-notes">
                                    <i class="bx bx-note"></i>
                                    <p>Chưa có ghi chú nào</p>
                                </div>
                                <div v-else class="notes-list">
                                    <div v-for="note in recentNotes" :key="note.id" class="note-item"
                                        @click="loadNote(note)">
                                        <div class="note-header">
                                            <span class="note-date">
                                                <i class="bx bx-calendar"></i>
                                                {{ note.date }}
                                            </span>
                                            <span class="note-subject-badge">
                                                {{ note.subject }}
                                            </span>
                                        </div>
                                        <div class="note-preview">
                                            {{ note.content.substring(0, 100) }}...
                                        </div>
                                        <div class="note-actions">
                                            <button class="btn-icon" @click.stop="editNote(note)" title="Chỉnh sửa">
                                                <i class="bx bx-edit"></i>
                                            </button>
                                            <button class="btn-icon" @click.stop="deleteNote(note)" title="Xóa">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
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
    name: 'Notes',
    setup() {
        const newNote = ref({
            date: new Date().toISOString().split('T')[0],
            subject: '',
            content: ''
        });

        const recentNotes = ref([
            {
                id: 1,
                date: '01/10/2024',
                subject: 'Toán',
                content: 'Học đếm số từ 1-10, nhận biết hình dạng cơ bản. Học sinh rất tích cực tham gia, đa số đã nắm được cách đếm. Cần luyện tập thêm về nhận biết hình dạng.'
            },
            {
                id: 2,
                date: '30/09/2024',
                subject: 'Tiếng Việt',
                content: 'Học chữ cái A, B, C. Luyện phát âm và viết. Học sinh hào hứng với bài học mới. Một số em cần hỗ trợ thêm về cách phát âm.'
            }
        ]);

        const saveNote = () => {
            if (!newNote.value.subject || !newNote.value.content) {
                alert('Vui lòng điền đầy đủ thông tin');
                return;
            }

            const note = {
                id: Date.now(),
                date: formatDate(newNote.value.date),
                subject: newNote.value.subject,
                content: newNote.value.content
            };

            recentNotes.value.unshift(note);
            resetForm();
            alert('Lưu ghi chú thành công!');
        };

        const resetForm = () => {
            newNote.value = {
                date: new Date().toISOString().split('T')[0],
                subject: '',
                content: ''
            };
        };

        const loadNote = (note) => {
            newNote.value = {
                date: reverseFormatDate(note.date),
                subject: note.subject,
                content: note.content
            };
        };

        const editNote = (note) => {
            loadNote(note);
            // Scroll to form
            window.scrollTo({ top: 0, behavior: 'smooth' });
        };

        const deleteNote = (note) => {
            if (confirm('Bạn có chắc chắn muốn xóa ghi chú này?')) {
                const index = recentNotes.value.findIndex(n => n.id === note.id);
                if (index > -1) {
                    recentNotes.value.splice(index, 1);
                }
            }
        };

        const formatDate = (dateString) => {
            const date = new Date(dateString);
            return date.toLocaleDateString('vi-VN', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        };

        const reverseFormatDate = (dateString) => {
            const parts = dateString.split('/');
            return `${parts[2]}-${parts[1]}-${parts[0]}`;
        };

        return {
            newNote,
            recentNotes,
            saveNote,
            resetForm,
            loadNote,
            editNote,
            deleteNote
        };
    }
};
</script>

<style lang="scss">
@use './style.scss';
</style>
