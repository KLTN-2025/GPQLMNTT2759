<template>
  <div class="parent-container">
    <div class="mail-search-box">
      <i class="mdi mdi-magnify search-icon"></i>
      <input type="text" placeholder="Tìm kiếm trong thư" />
      <i class="mdi mdi-tune filter-icon"></i>
    </div>
    <div class="form-parent">
      <div class="form-position">
        <div class="item-parent-seed">
          <v-icon class="icon-mail" left>mdi-email-outline</v-icon>
          <p>Hộp Thư Đến</p>
        </div>
        <div class="item-parent-seed">
          <v-icon class="icon-mail" left>mdi-star-outline</v-icon>
          <p>Có Gắn Dấu Sao</p>
        </div>
        <div class="item-parent-seed">
          <v-icon class="icon-mail" left>mdi-eye-off-outline</v-icon>
          <p>Đã Tạm Ẩn</p>
        </div>
      </div>
      <div class="parents">
        <div class="email-list">
          <div class="email-item">
            <input type="checkbox" />
            <v-icon class="star-icon">mdi-star-outline</v-icon>
            <span class="sender">Hoa Sen</span>
            <span class="subject"
              >Do thời tiết xấu và lũ lụt ở nhiều hơn nên Hoa Sen thông báo cho
              các em nghỉ ngày hôm nay...</span
            >

            <span class="time">17 thg 7</span>
          </div>

          <div class="email-item">
            <input type="checkbox" />
            <v-icon class="star-icon">mdi-star-outline</v-icon>
            <span class="sender">Hoa Sen</span>
            <span class="subject"
              >Thông báo các quý phụ huynh đến thăm dự buổi họp phụ huynh hằng
              tháng ngày 19/07/2025...</span
            >

            <span class="time">16 thg 7</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {};
</script>
<style lang="scss">
@use "./style.scss";
</style>
