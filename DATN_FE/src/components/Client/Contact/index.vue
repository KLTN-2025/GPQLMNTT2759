<template>
  <div class="container-contact">
    <div class="from-contact">
      <div class="location-contact">
        <div class="header-title">
          <h3>HỆ THỐNG TRƯỜNG MẦM NON HOA SEN</h3>
        </div>
        <div class="form-locations">
          <div class="item-location">
            <p class="name-location">Cơ sở Hoa Sen Riverside</p>
            <p class="id-location">
              <v-icon left small>mdi-map-marker</v-icon>
              Lô A2.4 Trần Đăng Ninh, phường Hòa Cường, Thành phố Đà Nẵng
            </p>
            <p class="number-phone">
              <v-icon left small>mdi-phone</v-icon>
              (+84) 236.378.7777
            </p>
          </div>
          <div class="item-location">
            <p class="name-location">Cơ sở Hoa Sen Riverside</p>
            <p class="id-location">
              <v-icon left small>mdi-map-marker</v-icon>
              Lô A2.4 Trần Đăng Ninh, phường Hòa Cường, Thành phố Đà Nẵng
            </p>
            <p class="number-phone">
              <v-icon left small>mdi-phone</v-icon>
              (+84) 236.378.7777
            </p>
          </div>
          <div class="item-location">
            <p class="name-location">Cơ sở Hoa Sen Riverside</p>
            <p class="id-location">
              <v-icon left small>mdi-map-marker</v-icon>
              Lô A2.4 Trần Đăng Ninh, phường Hòa Cường, Thành phố Đà Nẵng
            </p>
            <p class="number-phone">
              <v-icon left small>mdi-phone</v-icon>
              (+84) 236.378.7777
            </p>
          </div>
          <div class="item-location">
            <p class="name-location">Cơ sở Hoa Sen Riverside</p>
            <p class="id-location">
              <v-icon left small>mdi-map-marker</v-icon>
              Lô A2.4 Trần Đăng Ninh, phường Hòa Cường, Thành phố Đà Nẵng
            </p>
            <p class="number-phone">
              <v-icon left small>mdi-phone</v-icon>
              (+84) 236.378.7777
            </p>
          </div>
          <div class="item-location">
            <p class="name-location">Cơ sở Hoa Sen Riverside</p>
            <p class="id-location">
              <v-icon left small>mdi-map-marker</v-icon>
              Lô A2.4 Trần Đăng Ninh, phường Hòa Cường, Thành phố Đà Nẵng
            </p>
            <p class="number-phone">
              <v-icon left small>mdi-phone</v-icon>
              (+84) 236.378.7777
            </p>
          </div>
        </div>
      </div>
      <div class="information-contact">
        <iframe
          class="location-map"
          width="100%"
          height="300"
          style="border: 0; border-radius: 8px"
          loading="lazy"
          allowfullscreen
          referrerpolicy="no-referrer-when-downgrade"
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3834.442265599778!2d108.21633321537591!3d16.039777744635576!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314219e1dc3dcf6b%3A0x2a0a79ea43d21bd3!2zVHLhuqduIMSQw6FuZyBOaW5oLCBIw7JhIEPhuqduZyBObGFtLCDEkMOgIE5hbmc!5e0!3m2!1svi!2s!4v1721212345678"
        ></iframe>
      </div>
    </div>
    <div class="form-fill">
      <div class="form-img">
        <img
          class="img-school"
          src="../../../assets/images/Home/HVH_03931_2_2_xoa_d_6a134e028d.jpg"
          alt=""
        />
      </div>
      <div class="form-fill-information">
        <div class="form-input">
          <h3 class="title-contact">LIÊN HỆ VỚI CHÚNG TÔI</h3>
          <form action="" class="form-submit">
            <input type="text" class="input-text" placeholder="Họ và tên" />
            <input type="email" class="input-text" placeholder="Email" />
            <input type="tel" class="input-text" placeholder="Số điện thoại" />
            <input type="text" class="input-text" placeholder="Tiêu đề" />

            <select class="input-text">
              <option disabled selected>Chọn khối lớp quan tâm</option>
              <option>Mầm</option>
              <option>Chồi</option>
              <option>Lá</option>
            </select>

            <select class="input-text">
              <option disabled selected>Chọn cơ sở quan tâm</option>
              <option>Hoa Sen Riverside</option>
              <option>Hoa Sen Center</option>
            </select>

            <textarea
              class="input-text"
              rows="2"
              placeholder="Nội dung"
            ></textarea>

            <button class="btn-submit">
              GỬI YÊU CẦU LIÊN HỆ
            </button>
          </form>
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
