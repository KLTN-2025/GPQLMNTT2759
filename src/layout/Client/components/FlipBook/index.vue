<template>
  <div class="handbook-container">
    <h1 class="title-handbook">CẨM NANG PHỤ HUYNH HỌC SINH BẬC MẦM NON</h1>
    <div class="from-page">
      <div ref="bookEl" class="book" style="width: 600px; height: 400px"></div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { PageFlip } from "page-flip";
import page1 from "../../../../assets/images/Home/CAM_NANG_MAM_NON_2024_SKL_file_in_hinh_anh_0_5842e0788d.jpg";
import page2 from "../../../../assets/images/Home/CAM_NANG_MAM_NON_2024_SKL_file_in_hinh_anh_2_4ab8d0285c.jpg";
import page3 from "../../../../assets/images/Home/CAM_NANG_MAM_NON_2024_SKL_file_in_hinh_anh_3_b22200e709.jpg";
import page4 from "../../../../assets/images/Home/CAM_NANG_MAM_NON_2024_SKL_file_in_hinh_anh_4_64e9d8b008.jpg";

const bookEl = ref(null);

onMounted(() => {
  const pageFlip = new PageFlip(bookEl.value, {
    width: 600,
    height: 800,
    size: "fixed",
    maxShadowOpacity: 0.5,
    showCover: true,
    mobileScrollSupport: false,
  });

  pageFlip.loadFromImages([page1, page2, page3, page4]);
});
</script>
<style lang="scss">
@use "./style.scss";
</style>
