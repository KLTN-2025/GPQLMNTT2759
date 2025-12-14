<!-- <template>
  <div class="header-menu-container">
    <div class="header-menu">
      <div class="form-nav">
        <div class="nav-menu">
          <div class="item-home" @click="goToDashboard">Dashboard</div>

          <div class="post-wrapper" @mouseenter="hoverNhanSu = true" @mouseleave="hoverNhanSu = false">
            <div class="item-home">Nhân Sự</div>
            <transition name="fade-slide">
              <v-card class="blog-dropdown" v-show="hoverNhanSu">
                <v-list v-model:opened="open">
                  <v-list-item @click="goToPhanQuyen" title="Phân Quyền" class="logout-item" />
                  <v-list-item @click="goToNhanVien" title="Nhân Viên" class="logout-item" />
                  <v-list-item @click="goToGiaoVien" title="Giáo Viên" class="logout-item" />
                </v-list>
              </v-card>
            </transition>
          </div>

          <div class="post-wrapper" @mouseenter="hoverHocSinh = true" @mouseleave="hoverHocSinh = false">
            <div class="item-home">Học Sinh & PH</div>
            <transition name="fade-slide">
              <v-card class="blog-dropdown" v-show="hoverHocSinh">
                <v-list v-model:opened="open">
                  <v-list-item @click="goToHocSinh" title="Học Sinh" class="logout-item" />
                  <v-list-item @click="goToPhuHuynh" title="Phụ Huynh" class="logout-item" />
                  <v-list-item @click="goToDiemDanh" title="Điểm Danh" class="logout-item" />
                </v-list>
              </v-card>
            </transition>
          </div>

          <div class="item-home" @click="goToLopHoc">Lớp Học</div>
          <div class="item-home" @click="goToSucKhoe">Sức Khỏe</div>
          <div class="item-home" @click="goToHocPhi">Học Phí</div>
          <div class="item-home" @click="goToThucDon">Thực Đơn</div>

          <div class="post-wrapper" @mouseenter="hoverBaoCao = true" @mouseleave="hoverBaoCao = false">
            <div class="item-home">Báo cáo & TK</div>
            <transition name="fade-slide">
              <v-card class="blog-dropdown" v-show="hoverBaoCao">
                <v-list v-model:opened="open">
                  <v-list-item @click="goToTaiChinh" title="Tài Chính" class="logout-item" />
                  <v-list-item @click="goToBaoCao" title="Báo Cáo" class="logout-item" />
                  <v-list-item @click="goToThongKe" title="Thống Kê" class="logout-item" />
                </v-list>
              </v-card>
            </transition>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

const hover = ref(false);
const hoverNhanSu = ref(false);
const hoverHocSinh = ref(false);
const hoverBaoCao = ref(false);
const open = ref(["Settings"]);

const router = useRouter();

// Navigation functions
function goToDashboard() {
  router.push("/admin/dashboard");
}

function goToPhanQuyen() {
  router.push("/admin/phan-quyen");
}

function goToNhanVien() {
  router.push("/admin/nhan-vien");
}

function goToGiaoVien() {
  router.push("/admin/giao-vien");
}

function goToHocSinh() {
  router.push("/admin/hoc-sinh");
}

function goToPhuHuynh() {
  router.push("/admin/phu-huynh");
}

function goToDiemDanh() {
  router.push("/admin/diem-danh");
}

function goToLopHoc() {
  router.push("/admin/lop-hoc");
}

function goToSucKhoe() {
  router.push("/admin/suc-khoe");
}

function goToHocPhi() {
  router.push("/admin/hoc-phi");
}

function goToThucDon() {
  router.push("/admin/thuc-don");
}

function goToTaiChinh() {
  router.push("/admin/tai-chinh");
}

function goToBaoCao() {
  router.push("/admin/bao-cao");
}

function goToThongKe() {
  router.push("/admin/thong-ke");
}

function goToProfile() {
  router.push("/admin/profile");
}

function goToPrivacy() {
  router.push("/admin/privacy");
}

function goToSystemConfig() {
  router.push("/admin/system-config");
}

function goToBackup() {
  router.push("/admin/backup");
}

function handleLogout() {
  // Implement logout logic
  console.log("Logging out...");
  router.push("/login");
}
</script>

<style lang="scss">
@use "./style.scss";
</style> -->
