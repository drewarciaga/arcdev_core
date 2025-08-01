<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import { isMobile } from 'mobile-device-detect';
import { Autoplay, Navigation, Pagination } from 'swiper/modules';
const props = defineProps({
    slides: {
        default: null
    }
})
const modules= [Autoplay, Navigation, Pagination]
</script>
<template>
<div class="swiper-container" v-if="props.slides != null">
	<swiper
		:slidesPerView="2"
		:centeredSlides="isMobile ? true:false"
		:spaceBetween="30"
		:loop="true"
		:autoplay="{
			delay: 0,
			disableOnInteraction: false,
			pauseOnMouseEnter: false,
		}"
		:speed="3000"
		:navigation="true"
		:grabCursor="true"
		:modules="modules"
		:pagination="{ clickable: true }"
		class="mySwiper"
		id="glide-sample"
		:lazy="true"
		:breakpoints="{
			'425': {
				slidesPerView: 2,
				spaceBetween: 30,
			},
			'810': {
				slidesPerView: 3,
				spaceBetween: 40,
			},
			'1200': {
				slidesPerView: 4,
				spaceBetween: 50,
			},
			'1400': {
				slidesPerView: 5,
				spaceBetween: 50,
			},
		}"
	>
		<swiper-slide v-for="slide in props.slides" :key="slide.bg">
		<v-lazy>
			<img
				:src="slide.bg_img" class="min-h-[400px]"
			/>
		</v-lazy>
			
			<div class="swiper-lazy-preloader"></div>
	  	</swiper-slide>
		<swiper-slide style="width:0px !important; visibility: hidden;" class="last-item"></swiper-slide>
	</swiper>
</div>
</template>

<style scoped>
.last-item{
    width: 0px !important;
}

.swiper {
	width: 100%;
	height: 100%;
	margin:20px;
}

.swiper-slide-horizontal {
	height: 260px;
	width: 460px !important;
	text-align: center;
	font-size: 18px;
	background: #fff;

	/* Center slide text vertically */
	display: -webkit-box;
	display: -ms-flexbox;
	display: -webkit-flex;
	display: flex;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	-webkit-justify-content: center;
	justify-content: center;
	-webkit-box-align: center;
	-ms-flex-align: center;
	-webkit-align-items: center;
	align-items: center;
}

.swiper-slide {
	height: 400px;
	width: 300px;
	text-align: center;
	font-size: 18px;
	background: #fff;

	/* Center slide text vertically */
	display: -webkit-box;
	display: -ms-flexbox;
	display: -webkit-flex;
	display: flex;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	-webkit-justify-content: center;
	justify-content: center;
	-webkit-box-align: center;
	-ms-flex-align: center;
	-webkit-align-items: center;
	align-items: center;
	box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
}

@media screen and (max-width: 1400px){
	.swiper-slide {
		height: 380px;
		width: 225px;
	}
}

@media screen and (max-width: 810px){
	.swiper-slide {
		height: 260px;
		width: 170px;
	}
}
@media screen and (max-width: 425px){
	.swiper-slide {
		height: 300px;
		width: 200px !important;
	}
	.swiper-slide:first-child {
		height: 300px;
		width: 200px !important;
		margin-left: -30px;
	}
}

.swiper-slide img {
  display: block;
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: top;
}

.swiper-container{
	width: 100%;
    padding: 40px 10px 40px 10px;
    overflow: hidden;
    /*clip-path: inset(0 10% 0 0);
    margin-left: 5%;*/
}
@media screen and (max-width: 810px){
	.swiper-container{
		margin-left: 0;
		padding: 24px 0px 24px 0px;
	}
}
@media screen and (max-width: 425px){
	.swiper-container{
		margin-left: 0;
		padding: 15px 0px 15px 0px;
	}
}

.bg-contain{
    background-size: contain !important;
    background-repeat: no-repeat;
    background-position: initial;
}
.bg-cover{
	background-size: cover !important;
    background-repeat: no-repeat;
    background-position: initial;
}
</style>