<template>
    <footer class="admin-footer">
        <div class="footer-content">
            <div class="footer-left">
                <p>&copy; 2024 Trường Mầm Non Hoa Sen. Tất cả quyền được bảo lưu.</p>
            </div>
            <div class="footer-right">
                <p>Hệ thống quản lý mầm non</p>
            </div>
        </div>
    </footer>
</template>

<script>
export default {
    name: "BotAdmin"
}
</script>

<style scoped>
.admin-footer {
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
    padding: 15px 20px;
    margin-top: auto;
    position: relative;
    z-index: 100;
}

.footer-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
}

.footer-left p,
.footer-right p {
    margin: 0;
    color: #6c757d;
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .footer-content {
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }
}
</style>