<template>
  <swiper
    :slidesPerView="3"
    :initialSlide="1"
    :spaceBetween="120"
    :centeredSlides="true"
    :grabCursor="true"
    :freeMode="false"

    :modules="modules"
    class="mySwiper"
  >
    <swiper-slide class="rounded-lg">
        <img loading="lazy" class="cover" src="/images/slider/IVW - GALLERY - 01.webp">
        <p class="absolute mt-[340px] text-arc-yellow text-belanciaga text-7xl font-bold">01</p>
        <br>
        <p class="absolute mt-[470px] text-arc-yellow">
            <span class="text-3xl font-bold">Deadpool & Wolverine</span>
            <br>
            <span class="text-sm">[SHFiguarts & Marvel Legends]</span>
        </p>
    </swiper-slide>
    <swiper-slide>
        <img loading="lazy" class="cover" src="/images/slider/IVW - GALLERY - 02.webp"/>
        <p class="absolute mt-[340px] text-arc-yellow text-belanciaga text-7xl font-bold">02</p>
        <br>
        <p class="absolute mt-[470px] text-arc-yellow">
            <span class="text-3xl font-bold">Darna</span>
            <br>
            <span class="text-sm">[Loose Toys Collectibles]</span>
        </p>
    </swiper-slide>
    <swiper-slide>
        <img loading="lazy" class="cover" src="/images/slider/IVW - GALLERY - 03.webp"/>
        <p class="absolute mt-[340px] text-arc-yellow text-belanciaga text-7xl font-bold">03</p>
        <br>
        <p class="absolute mt-[470px] text-arc-yellow">
            <span class="text-3xl font-bold">Ghost Fighter</span>
            <br>
            <span class="text-sm">[Dasin Toys]</span>
        </p>
    </swiper-slide>
    <swiper-slide>
        <img loading="lazy" class="cover" src="/images/slider/IVW - GALLERY - 04.webp"/>
        <p class="absolute mt-[340px] text-arc-yellow text-belanciaga text-7xl font-bold">04</p>
        <br>
        <p class="absolute mt-[470px] text-arc-yellow">
            <span class="text-3xl font-bold">Fantastic Four</span>
            <br>
            <span class="text-sm">[Marvel Legends]</span>
        </p>
    </swiper-slide>
    <swiper-slide>
        <img loading="lazy" class="cover" src="/images/slider/IVW - GALLERY - 05.webp"/>
        <p class="absolute mt-[340px] text-arc-yellow text-belanciaga text-7xl font-bold">05</p>
        <br>
        <p class="absolute mt-[470px] text-arc-yellow">
            <span class="text-3xl font-bold">Final Fantasy IX</span>
            <br>
            <span class="text-sm">[Bring Arts Action Figures]</span>
        </p>
    </swiper-slide>
    <swiper-slide>
        <img loading="lazy" class="cover" src="/images/slider/IVW - GALLERY - 06.webp"/>
        <p class="absolute mt-[340px] text-arc-yellow text-belanciaga text-7xl font-bold">06</p>
        <br>
        <p class="absolute mt-[470px] text-arc-yellow">
            <span class="text-3xl font-bold">R2D2 & C3PO</span>
            <br>
            <span class="text-sm">[Medicom Mafex]</span>
        </p>
    </swiper-slide>
    <swiper-slide>
        <img loading="lazy" class="cover" src="/images/slider/IVW - GALLERY - 07.webp"/>
        <p class="absolute mt-[340px] text-arc-yellow text-belanciaga text-7xl font-bold">07</p>
        <br>
        <p class="absolute mt-[470px] text-arc-yellow">
            <span class="text-3xl font-bold">Rick & Morty</span>
            <br>
            <span class="text-sm">[Funko Figures]</span>
        </p>
    </swiper-slide>
    <swiper-slide>
        <img loading="lazy" class="cover" src="/images/slider/IVW - GALLERY - 08.webp"/>
        <p class="absolute mt-[340px] text-arc-yellow text-belanciaga text-7xl font-bold">08</p>
        <br>
        <p class="absolute mt-[470px] text-arc-yellow">
            <span class="text-3xl font-bold">Ryu</span>
            <br>
            <span class="text-sm">[SHFiguarts]</span>
        </p>
    </swiper-slide>
  </swiper>
</template>
<script>
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/free-mode';
import 'swiper/css/pagination';
import { FreeMode, Pagination } from 'swiper/modules';

export default {
    components: {
        Swiper,
        SwiperSlide,
    },
    setup() {
        return {
            modules: [FreeMode, Pagination],
        };
    },
};
</script>
<style>

.swiper {
    width: 140%;
    height: 100%;
    padding:30px;
    margin-left: -20%;
}

.swiper-slide {
    text-align: center;
    font-size: 18px;
    background: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    height:600px;
}
.swiper-slide p{
    opacity: 0;
}
@keyframes opacityUp {
    from {
        opacity: 0;
        transform:translate(0px, 0px);
    }
    to {
        opacity: 1;
        transform: translate(0px, -50px);
    }
}
.swiper-slide-active p{
    animation: opacityUp .7s forwards;
    animation-delay: .3s;
}
.swiper-slide img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: contain;
    transform: scale(1) !important;
}
@keyframes scaleDown {
    from {
        transform: scale(1) translate(0px, -50px);
        
    }
    to {
        transform: scale(1);
    }
}
.swiper-slide{
    background: none;
    transform: scale(1);
    animation: scaleDown 0.3s forwards;
}
@keyframes scaleUp {
    from {
        transform: scale(1);
    }
    to {
        transform: scale(1.5) translate(0px, -20px);
    }
}
.swiper-slide-active{
    animation: scaleUp 0.5s forwards;
}
</style>