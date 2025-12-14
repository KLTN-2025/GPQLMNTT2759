<template>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-3">
                        <i class='bx bx-calendar-check me-2'></i>
                        Quản lý lịch làm việc
                    </h5>
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link" :class="{ active: activeTab === 'teacher' }"
                                @click="activeTab = 'teacher'" href="javascript:void(0)">
                                <i class='bx bx-chalkboard me-2'></i>Lịch giáo viên
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" :class="{ active: activeTab === 'employee' }"
                                @click="activeTab = 'employee'" href="javascript:void(0)">
                                <i class='bx bx-user me-2'></i>Lịch nhân viên
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <ScheduleTeacher v-if="activeTab === 'teacher'" />
                    <ScheduleEmployee v-if="activeTab === 'employee'" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ScheduleTeacher from './ScheduleTeacher.vue';
import ScheduleEmployee from './ScheduleEmployee.vue';

export default {
    name: 'AdminSchedule',
    components: {
        ScheduleTeacher,
        ScheduleEmployee
    },
    data() {
        return {
            activeTab: 'teacher'
        };
    }
}
</script>

<style lang="scss" scoped>
.nav-link {
    cursor: pointer;
    color: #6c757d;
    transition: all 0.3s;

    &:hover {
        color: #495057;
    }

    &.active {
        color: #0d6efd;
        font-weight: 600;
    }
}
</style>
