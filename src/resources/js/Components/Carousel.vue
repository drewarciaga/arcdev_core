<script setup>
import { ref, onMounted } from 'vue'
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/effect-fade';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import { Autoplay, EffectFade, Navigation, Pagination } from 'swiper/modules';

const modules = ref([ Autoplay, EffectFade, Navigation, Pagination])
const isLoop = ref(false)
const props = defineProps({

    slides: {
        default: null
    }
})

onMounted(async () => {
	if(props.slides != null && props.slides.lenght > 4){
		isLoop.value = true
	}
});

</script>
<template>
	<swiper
	    :style="{
			'--swiper-navigation-color': '#fff',
			'--swiper-pagination-color': '#fff',
		}"
		:spaceBetween="30"
		:effect="'fade'"
		:navigation="false"
		:pagination="false"
		:centeredSlides="true"
		:autoplay="{
			delay: 5500,
			disableOnInteraction: false,
		}"
		:modules="modules"
		class="mySwiper h-full"

		:loop="isLoop"
		:lazy="true"
	>
    <swiper-slide v-for="(slide, index) in props.slides">
		<img :src="slide.bg_img" class="object-cover w-full h-full" />
	</swiper-slide>
	
  </swiper>
</template>
<style scope>


.swiper-slide-active{
	opacity:1 !important;
}
.swiper-pagination-bullet{
	opacity:.7 !important;
	background: #fff !important;
	box-shadow: 0 0 .2rem #f7f7f7, 0 0 .2rem #f7f7f7, 0 0 1.2rem #f7f7f7, 0 0 0.8rem #f7f7f7, 0 0 1.8rem #f7f7f7, inset 0 0 1.3rem #f7f7f7;
}
.swiper-pagination-bullet-active{
	opacity:1 !important;
	background:#fff !important;
	box-shadow: 0 0 .2rem #fff, 0 0 .2rem #fff, 0 0 1.2rem #fff, 0 0 0.8rem #fff, 0 0 1.8rem #fff, inset 0 0 1.3rem #fff;
}

.swiper-button-prev, .swiper-button-next{
	color:white !important;
}
.swiper-button-disabled{
	opacity:.1 !important;
}
</style>