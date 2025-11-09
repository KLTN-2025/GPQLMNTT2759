<template>
    <footer class="page-footer">
        <div class="footer-content">
            <p class="mb-0 text-center">
                <span class="text-primary">©</span> {{ currentYear }} Trường Mầm Non Hoa Sen -
                <span class="text-primary">Hệ thống quản lý dành cho Giáo viên</span>
            </p>
        </div>
    </footer>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const currentYear = ref(new Date().getFullYear());

onMounted(() => {
    // Update year if needed
    const updateYear = () => {
        currentYear.value = new Date().getFullYear();
    };
    updateYear();
});
</script>

<style scoped>
.page-footer {
    background: white;
    border-top: 1px solid #e9ecef;
    padding: 0.75rem 0;
    margin-top: auto;
}

.footer-content {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
}

.footer-content p {
    color: #6c757d;
    font-size: 0.9rem;
}

.text-primary {
    color: #667eea !important;
    font-weight: 500;
}

@media (max-width: 768px) {
    .page-footer {
        padding: 0.5rem 0;
    }

    .footer-content p {
        font-size: 0.75rem;
    }
}
</style>
