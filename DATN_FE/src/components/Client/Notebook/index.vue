<template>
  <div class="notebook-detail-container">
    <div class="handbook-list">
      <div
        class="handbook-card scroll-animate"
        @click="goTNotebookDetail"
        ref="card1"
      >
        <img
          src="../../../assets/images/Home/cam_nang_phu_huynh_hoc_sinh_bac_mam_nonoz4q5t4e_ini_4244142c_a8b5346814_0f529442a5.webp"
          alt="Mầm non"
          class="handbook-image"
        />
        <p class="handbook-title">Cẩm nang phụ huynh học sinh bậc Mầm non</p>
      </div>

      <div class="handbook-card scroll-animate" ref="card2">
        <img
          src="../../../assets/images/Home/cam_nang_phu_huynh_hoc_sinh_bac_mam_nonoz4q5t4e_ini_4244142c_a8b5346814_0f529442a5.webp"
          alt="Tiểu học"
          class="handbook-image"
        />
        <p class="handbook-title">Cẩm nang phụ huynh học sinh bậc Tiểu học</p>
      </div>

      <div class="handbook-card scroll-animate" ref="card3">
        <img
          src="../../../assets/images/Home/cam_nang_phu_huynh_hoc_sinh_bac_mam_nonoz4q5t4e_ini_4244142c_a8b5346814_0f529442a5.webp"
          alt="Trung học"
          class="handbook-image"
        />
        <p class="handbook-title">Cẩm nang phụ huynh học sinh bậc Trung học</p>
      </div>
    </div>
  </div>
</template>
<script setup>
import { useRouter } from "vue-router";
import { onMounted, ref } from "vue";

const router = useRouter();
const card1 = ref(null);
const card2 = ref(null);
const card3 = ref(null);

function goTNotebookDetail() {
  router.push("/notebook-detail");
}

onMounted(() => {
  // Tạo Intersection Observer để theo dõi khi elements xuất hiện
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          // Thêm class 'visible' khi element xuất hiện trong viewport
          entry.target.classList.add("visible");
        }
      });
    },
    {
      threshold: 0.1, // Trigger khi 10% element xuất hiện
      rootMargin: "0px 0px -50px 0px", // Trigger sớm hơn 50px
    }
  );

  // Observe tất cả các card
  const cards = [card1.value, card2.value, card3.value];
  cards.forEach((card, index) => {
    if (card) {
      // Thêm delay khác nhau cho mỗi card
      card.style.animationDelay = `${index * 0.2}s`;
      observer.observe(card);
    }
  });

  // Cleanup observer khi component unmount
  return () => {
    observer.disconnect();
  };
});
</script>
<style lang="scss">
@use "./style.scss";
</style>
