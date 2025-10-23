<template>
  <div class="container-main">
    <div class="header-mani animate-on-scroll" data-animation="fade-up">
      <div class="item-lef">
        <div class="item-title">
          <div class="form-title">
            <h4>Mẫu Giáo Hoa Sen</h4>
            <p class="txt-note">
              Mẫu giáo Sen Hồng là một ngôi trường mầm non thân thiện và sáng
              tạo, nơi trẻ em được khuyến khích khám phá thế giới xung quanh,
              phát triển toàn diện về tư duy, kỹ năng và tình cảm trong môi
              trường ấm áp và yêu thương.
            </p>
            <button className="btn-contact">Liên Hệ Ngay</button>
          </div>
        </div>
      </div>
      <div class="item-right">
        <img src="../../../assets/images/image 8 (1).png" alt="" />
      </div>
    </div>
    <div
      class="header-client animate-on-scroll"
      data-animation="fade-up"
      data-delay="200"
    >
      <div class="from-client">
        <p class="txt-partner">Liên kết đào tạo</p>
        <span class="txt-note"
          >Nầm non Hoa Sen được đầu tư và hợp tác với khac trường Quốc Tế</span
        >
      </div>
      <div class="from-partner">
        <img
          class="logo-school animate-on-scroll"
          data-animation="zoom-in"
          data-delay="100"
          src="../../../assets/images/Home/014e4f3e9d85c6666e1638f021879b20.png"
          alt=""
        />
        <img
          class="logo-school animate-on-scroll"
          data-animation="zoom-in"
          data-delay="200"
          src="../../../assets/images/Home/wlgYD7n8KtZ0Fx9da1PukRhZW1eNvbmXSmczDqEu.jpeg"
          alt=""
        />
        <img
          class="logo-school animate-on-scroll"
          data-animation="zoom-in"
          data-delay="300"
          src="../../../assets/images/Home/avatar-truong-mam-non-hoc-vien-iq-iq-school-55-le-lai-ghcqVeDw8ZyGNC97.jpg"
          alt=""
        />
        <img
          class="logo-school animate-on-scroll"
          data-animation="zoom-in"
          data-delay="400"
          src="../../../assets/images/Home/unnamed.png"
          alt=""
        />
        <img
          class="logo-school animate-on-scroll"
          data-animation="zoom-in"
          data-delay="500"
          src="../../../assets/images/Home/The-he-vang-1.png"
          alt=""
        />
      </div>
    </div>
    <div class="help-section animate-on-scroll" data-animation="fade-up">
      <div class="help-left">
        <div class="item-introduce">
          <img
            src="../../../assets/images/Home/helth (1).png"
            class="img-word animate-on-scroll"
            data-animation="rotate-in"
            alt=""
          />
          <h2
            class="animate-on-scroll"
            data-animation="fade-up"
            data-delay="200"
          >
            Vì sao phụ huynh nên đặt miền tin vào mần non Hoa Sen
          </h2>
          <p
            class="animate-on-scroll"
            data-animation="fade-up"
            data-delay="400"
          >
            Tại Mầm non Hoa Sen, bé được tham gia nhiều hoạt động vui chơi bổ
            ích như trò chơi vận động ngoài trời, vẽ tranh, làm đồ chơi sáng tạo
            và trải nghiệm chăm sóc cây xanh. Mỗi hoạt động đều giúp bé phát
            triển thể chất, trí tuệ và kỹ năng sống.
          </p>
        </div>
      </div>

      <div class="help-right">
        <div class="column-lef">
          <div
            @click="goToAdvantages"
            class="card animate-on-scroll"
            data-animation="slide-left"
            data-delay="100"
          >
            <div class="icon blue">
              <img
                class="img-feature"
                src="../../../assets/images/Home/box-search 1.png"
                alt=""
              />
            </div>
            <h3>Ưu điểm vượt trội Của Hoa Sen</h3>
            <p>Top 500 thuộc hệ thống giáo dục hàng đầu của châu á</p>
          </div>
          <div
            @click="goToEducationSystem"
            class="card animate-on-scroll"
            data-animation="slide-left"
            data-delay="300"
          >
            <div class="icon yellow">
              <img
                class="img-feature"
                src="../../../assets/images/products/empty-wallet 1.png"
                alt=""
              />
            </div>
            <h3>Hệ thống giáo dục hiện đại</h3>
            <p>Nơi thấu hiểu được nỗi lo của phụ huynh đối với con em</p>
          </div>
        </div>
        <div class="column-right">
          <div
            @click="goToTeacher"
            class="card animate-on-scroll"
            data-animation="slide-right"
            data-delay="200"
          >
            <div class="icon pink">
              <img
                class="img-feature"
                src="../../../assets/images/Home/code-1 1.png"
                alt=""
              />
            </div>
            <h3>Hình thức đào tạo chuẫn Quốc Tế</h3>
            <p>Nơi các đội ngũ giảng viên đến từ Mỹ,Úc,Canada....</p>
          </div>
          <div
            class="card animate-on-scroll"
            data-animation="slide-right"
            data-delay="400"
            @click="goToActivities"
          >
            <div class="icon green">
              <img
                class="img-feature"
                src="../../../assets/images/Home/chart-square 1.png"
                alt=""
              />
            </div>
            <h3>Các hoạt động thường xuyên</h3>
            <p>Nơi kết nối sự đoàn kết của các học sinh trong trường</p>
          </div>
        </div>
      </div>
    </div>
    <div class="education animate-on-scroll" data-animation="fade-up">
      <h1 class="animate-on-scroll" data-animation="fade-up">
        CHƯƠNG TRÌNH GIÁO DỤC
      </h1>
      <div class="education-ui">
        <div class="education-layout">
          <div class="form-education">
            <div class="education-lef">
              <div class="form-describe">
                <h4>Chương trình Giáo dục Mầm non</h4>
                <p>
                  Thiết kế theo định hướng giáo dục dựa trên năng lực, giúp trẻ
                  phát triển toàn diện hài hòa giữa thể chất, trí tuệ, tinh
                  thần, phẩm chất và mối quan hệ xã hội.
                </p>
                <button class="btn-click">Tìm hiểu ngay</button>
              </div>
            </div>
            <div class="education-right">
              <img
                class="img-education"
                src="../../../assets/images/Home/yJmRfMFSaXQT1sSjqAHwVugU16912mVG1sUG7yhe.jpeg"
                alt=""
              />
            </div>
          </div>
        </div>
        <div class="education-hover-ui">
          <div class="item-title">
            <div class="form-title">
              <h4>Chương trình giáo dục Mầm Non</h4>
              <p class="txt-note">
                Thiết kế theo định hướng giáo dục dựa trên năng lực, giúp trẻ
                phát triển toàn diện hài hòa giữa thể chất, trí tuệ, tinh thần,
                phẩm chất và mối quan hệ xã hội.
              </p>
              <button className="btn-contact">Xem Chi Tiết Hơn</button>
            </div>
          </div>
          <div class="item-diagram-lef">
            <div class="item-diagram">
              <img
                class="img-diagram"
                src="../../../assets/images/Home/diagram.png"
                alt=""
              />
            </div>
            <div class="txt-procedure">
              <p class="item-procedure">
                Dựa trên EYFS, chương trình chú trọng phát triển tư duy, kích
                thích trí tò mò và sáng tạo.
              </p>
              <p class="item-procedure">
                Đảm bảo đầu ra Cambridge Stage 1 và sẵn sàng vào lớp 1 theo lộ
                trình phổ thông.
              </p>

              <p class="item-procedure">
                Đội ngũ giáo viên Việt Nam và Nước ngoài đáp ứng các tiêu chí
                của Hội đồng các Trường Quốc tế CIS.
              </p>
              <p class="item-procedure">
                Cơ sở vật chất và vận hành theo chuẩn CIS, đặc biệt chú trọng an
                ninh, an toàn học đường
              </p>
              <p class="item-procedure">
                Tăng cường trải nghiệm học tập thông qua dự án và hoạt động thực
                tiễn, giúp trẻ phát triển tư duy phản biện và kỹ năng hợp tác.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="video-section animate-on-scroll" data-animation="fade-up">
      <div class="video-box animate-on-scroll" data-animation="slide-left">
        <iframe
          width="560"
          height="315"
          src="https://www.youtube.com/embed/DQDu60-C-ns"
          title="YouTube video player"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen
        ></iframe>
      </div>

      <div
        class="video-content animate-on-scroll"
        data-animation="slide-right"
        data-delay="200"
      >
        <h2>Những hoạt đông vui chơi của<br />Nầm non Hoa Sen</h2>
        <p>
          Tại Mầm non Hoa Sen, bé được tham gia nhiều hoạt động vui chơi bổ ích
          như trò chơi vận động ngoài trời, vẽ tranh, làm đồ chơi sáng tạo và
          trải nghiệm chăm sóc cây xanh. Mỗi hoạt động đều giúp bé phát triển
          thể chất, trí tuệ và kỹ năng sống.
        </p>
      </div>
    </div>
    <div class="form-swiper animate-on-scroll" data-animation="fade-up">
      <h1 class="animate-on-scroll" data-animation="fade-up">
        CÁC GIẢI THƯỞNG ẤN TƯỢNG
      </h1>
      <swiper
        :slidesPerView="3"
        :spaceBetween="30"
        :autoplay="{ delay: 2500, disableOnInteraction: false }"
        :loop="true"
        :pagination="{
          clickable: true,
        }"
        :modules="modules"
        class="mySwiper animate-on-scroll"
        data-animation="zoom-in"
        data-delay="200"
      >
        <swiper-slide>
          <img
            src="../../../assets/images/Home/viechannel-photos-sieu-tri-tue-tap-3-gia-hung-10-15736353894611049393168.webp"
            class="img-swiper"
            alt=""
          />
        </swiper-slide>
        <swiper-slide>
          <img
            src="../../../assets/images/Home/viechannel-photosthisinhquangbinh_SLTC.jpg"
            class="img-swiper"
            alt=""
          />
        </swiper-slide>
        <swiper-slide>
          <img
            src="../../../assets/images/Home/khan-gia-nhi20230718171204.jpg"
            class="img-swiper"
            alt=""
          />
        </swiper-slide>
        <swiper-slide>
          <img
            src="../../../assets/images/Home/sieu-tri-tue-sao-nhi-rinne-bat-khoc-ngung-quay-hinh-trong-tran-doi-dau-gia-hung-3683a2.jpg"
            class="img-swiper"
            alt=""
          />
        </swiper-slide>
        <swiper-slide>
          <img
            src="../../../assets/images/Home/unnamed.jpg"
            class="img-swiper"
            alt=""
          />
        </swiper-slide>
        <swiper-slide>
          <img
            src="../../../assets/images/Home/Sieu-Tri-Tue-Viet-Na.jpg"
            class="img-swiper"
            alt=""
          />
        </swiper-slide>
      </swiper>
      <p
        class="swiper-note animate-on-scroll"
        data-animation="fade-up"
        data-delay="400"
      >
        Những thành tích tiêu biểu của các cựu học sinh mần non Hoa Sen
      </p>
    </div>
    <div class="testimonial-section animate-on-scroll" data-animation="fade-up">
      <div class="testimonial-header">
        <h2 class="animate-on-scroll" data-animation="fade-up">
          Các giảng viên hàng đầu
        </h2>
        <p class="animate-on-scroll" data-animation="fade-up" data-delay="200">
          Các đội ngủ giảng viên là các thạc sĩ đầu ngành trong việc giảng dạy
        </p>
      </div>

      <div class="testimonial-body">
        <div
          class="testimonial-left animate-on-scroll"
          data-animation="slide-left"
        >
          <div class="main-client-img">
            <img :src="selectedTeacher.image" :alt="selectedTeacher.name" />
            <span class="circle-decoration"></span>
          </div>
        </div>

        <div
          class="testimonial-center animate-on-scroll"
          data-animation="fade-up"
          data-delay="200"
        >
          <h3>{{ selectedTeacher.name }}</h3>
          <p>{{ selectedTeacher.description }}</p>
        </div>

        <div
          class="testimonial-right animate-on-scroll"
          data-animation="slide-right"
          data-delay="400"
        >
          <div class="group-avatar-random">
            <img
              v-for="(teacher, index) in teachers"
              :key="index"
              :src="teacher.image"
              :class="[
                'avatar',
                `pos${index + 1}`,
                { active: selectedTeacher.id === teacher.id },
              ]"
              :alt="teacher.name"
              @click="selectTeacher(teacher)"
              style="cursor: pointer"
            />
          </div>
        </div>
      </div>
    </div>
    <div
      class="form-extracurricular animate-on-scroll"
      data-animation="fade-up"
    >
      <p class="txt-extracurricular animate-on-scroll" data-animation="fade-up">
        Chương trình Ngoại khóa
      </p>
      <p
        class="txt-describe animate-on-scroll"
        data-animation="fade-up"
        data-delay="200"
      >
        Câu lạc bộ ngoại khóa Hoa Sen được thiết kế đa năng, nội dung phong phú
        với nhiều môn học cho học sinh lựa chọn
      </p>
      <div class="item-extracurricular">
        <div
          class="item-environment animate-on-scroll"
          data-animation="zoom-in"
          data-delay="100"
        >
          <div class="from-word">
            <img
              class="img-word"
              src="../../../assets/images/Home/YpjdabYJIx5l2wCNYI5TJSrrfWhsDAApdqf4QSgK.jpeg"
              alt=""
            />
          </div>

          <p class="item-work">Lĩnh vực Bơi lội</p>
        </div>
        <div
          class="item-environment animate-on-scroll"
          data-animation="zoom-in"
          data-delay="200"
        >
          <div class="from-word">
            <img
              class="img-word"
              src="../../../assets/images/Home/2-6.jpg"
              alt=""
            />
          </div>

          <p class="item-work">Lĩnh vực nhảy múa</p>
        </div>
        <div
          class="item-environment animate-on-scroll"
          data-animation="zoom-in"
          data-delay="300"
        >
          <div class="from-word">
            <img
              class="img-word"
              src="../../../assets/images/Home/hoat-dong-ngoai-khoa-o-truong-tieu-hoc-3.png"
              alt=""
            />
          </div>

          <p class="item-work">Lĩnh vực Kỹ thuật</p>
        </div>
        <div
          class="item-environment animate-on-scroll"
          data-animation="zoom-in"
          data-delay="400"
        >
          <div class="from-word">
            <img
              class="img-word"
              src="../../../assets/images/Home/truong-mamnon-17072776867411513472472.jpg"
              alt=""
            />
          </div>

          <p class="item-work">Lĩnh vực làm nhóm</p>
        </div>
        <div
          class="item-environment animate-on-scroll"
          data-animation="zoom-in"
          data-delay="500"
        >
          <div class="from-word">
            <img
              class="img-word"
              src="../../../assets/images/Home/1_638505759099380765.jpg"
              alt=""
            />
          </div>

          <p class="item-work">Lĩnh vực sáng tác</p>
        </div>
      </div>
    </div>
    <div
      class="newsletter-container animate-on-scroll"
      data-animation="fade-up"
    >
      <div class="newsletter-content">
        <div
          class="newsletter-text animate-on-scroll"
          data-animation="slide-left"
        >
          <h2>Hãy để lại thông tin nếu cần</h2>
          <p>
            Đội ngũ nhân viên nhân sẽ tư vấn và giải đáp các vấn đề còn thắc mắc
            của các quý phụ huynh
          </p>
        </div>
        <div
          class="newsletter-form animate-on-scroll"
          data-animation="slide-right"
          data-delay="200"
        >
          <div class="form-email">
            <input placeholder="Enter your email address.." />
            <button>Contact Now</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { Swiper, SwiperSlide } from "swiper/vue";
import { onMounted, onUnmounted, ref } from "vue";
import { useRouter } from "vue-router";

import "swiper/css";

import "swiper/css/pagination";

import { Pagination, Autoplay } from "swiper/modules";

export default {
  components: {
    Swiper,
    SwiperSlide,
  },
  setup() {
    const router = useRouter();

    const goToTeacher = () => {
      router.push("/teacher");
    };
    const goToEducationSystem = () => {
      router.push("/educationSystem");
    };
    const goToAdvantages = () => {
      router.push("/advantages");
    };

    const goToActivities = () => {
      router.push("/activities");
    };

    let observer = null;

    const teachers = ref([
      {
        id: 1,
        name: "Matthew Paul",
        image: "/src/assets/images/Home/unsplash_3TLl_97HNJo.png",

        description:
          "Giáo sư tiến sĩ,hiện đang công tác và làm việc tại nầm non Hoa Sen,trưởng bộ môn toán học,chuyên viên nghiên cứu nhân tạo",
      },
      {
        id: 2,
        name: "Dr. Sarah Johnson",
        image: "/src/assets/images/Home/unsplash_O3ymvT7Wf9U.png",
        description:
          "Tiến sĩ Tâm lý học trẻ em, chuyên gia phát triển nhận thức và kỹ năng xã hội cho trẻ mầm non, có 15 năm kinh nghiệm giảng dạy",
      },
      {
        id: 3,
        name: "Prof. Emily Chen",
        image: "/src/assets/images/Home/unsplash_OhKElOkQ3RE.png",
        description:
          "Giáo sư ngôn ngữ học, chuyên về phương pháp giảng dạy song ngữ cho trẻ em, tốt nghiệp từ Đại học Harvard",
      },
      {
        id: 4,
        name: "Dr. Michael Brown",
        image: "/src/assets/images/Home/unsplash_mEZ3PoFGs_k.png",
        description:
          "Tiến sĩ Khoa học Giáo dục, chuyên gia về phương pháp Montessori và giáo dục sáng tạo cho trẻ mầm non",
      },
      {
        id: 5,
        name: "Ms. Lisa Wang",
        image: "/src/assets/images/Home/vuducminh.jpg",
        description:
          "Thạc sĩ Nghệ thuật và Âm nhạc, chuyên viên phát triển khả năng sáng tạo và thẩm mỹ cho trẻ em qua các hoạt động nghệ thuật",
      },
      {
        id: 6,
        name: "Dr. David Kim",
        image:
          "/src/assets/images/Home/anh-man-hinh-2024-11-06-luc-135114-1730876342129923305433.webp",
        description:
          "Tiến sĩ Khoa học Thể thao, chuyên gia phát triển thể chất và vận động cho trẻ mầm non, cựu vận động viên Olympic",
      },
      {
        id: 7,
        name: "Prof. Anna Nguyen",
        image: "/src/assets/images/Home/giao-su-phan-van-truong.webp",
        description:
          "Giáo sư Văn học và Ngôn ngữ Việt Nam, chuyên gia về phương pháp giảng dạy tiếng Việt và văn hóa truyền thống cho trẻ em",
      },
      {
        id: 8,
        name: "Dr. James Wilson",
        image:
          "/src/assets/images/Home/ad-4nxfur8m7q7cadw7bgjko-fwarcavqvq6vti3ymrpwduqitmsrbeyxwiihjmpsetjpqho4vifpqr7m-py4sjgmla5nicwhe6aalmkkhlrm3laijd3qcldksggereu86-nw2a-sqzh1cryb04hk5zmu5kqf6-o-7828.png",
        description:
          "Tiến sĩ Công nghệ Giáo dục, chuyên gia về ứng dụng công nghệ hiện đại trong giảng dạy trẻ mầm non và phát triển tư duy logic",
      },
    ]);
    const selectedTeacher = ref(teachers.value[0]);
    const selectTeacher = (teacher) => {
      selectedTeacher.value = teacher;
    };

    const initScrollAnimation = () => {
      observer = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              const element = entry.target;
              const animation = element.dataset.animation;
              const delay = element.dataset.delay || 0;

              setTimeout(() => {
                element.classList.add(
                  "animate-visible",
                  `animate-${animation}`
                );
              }, parseInt(delay));

              observer.unobserve(element);
            }
          });
        },
        {
          threshold: 0.1,
          rootMargin: "0px 0px -50px 0px",
        }
      );
      const animateElements = document.querySelectorAll(".animate-on-scroll");
      animateElements.forEach((el) => {
        observer.observe(el);
      });
    };

    onMounted(() => {
      setTimeout(() => {
        initScrollAnimation();
      }, 100);
    });

    onUnmounted(() => {
      if (observer) {
        observer.disconnect();
      }
    });

    return {
      modules: [Pagination, Autoplay],
      teachers,
      selectedTeacher,
      selectTeacher,
      goToTeacher,
      goToEducationSystem,
      goToAdvantages,
      goToActivities,
    };
  },
};
</script>
<style lang="scss">
@use "./style.scss";
</style>
