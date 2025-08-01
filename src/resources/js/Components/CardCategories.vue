<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    bg: {
        type: String,
        default: '',
    },
    caption: {
        type: String,
        default: '',
    },
    message: {
        type: String,
        default: '',
    },
    message2: {
        type: String,
        default: '',
    },
    textColor: {
        type: String,
        default: '',
    },
    paddingY: {
        type: String,
        default: '',
    },
    bgColor: {
        type: String,
        default: '',
    },
    link: {
        type: String,
        default: '#',
    },
});
</script>
<template>
<Link :href="link" >
    <div class="justify-center m-auto" style="max-width:720px;">
        <div class="block rounded-lg shadow-lg bg-black md:flex flex-wrap shadow-orange-500 card-category " :class="[bgColor, textColor]">
            <div class="card2-img-div w-full rounded-lg">
                <div class="overflow-hidden aspect-video cursor-pointer rounded-lg relative group h-full w-full" >
                    <div class="z-30 opacity-0 group-hover:opacity-100 transition duration-300 ease-in-out cursor-pointer absolute from-neon-orange-1000/90 to-transparent/2 bg-gradient-to-t inset-x-0 -bottom-2 pt-30 h-3/4 ">
                        <div class="font-bold text-lg category-name  absolute bottom-10 left-4 text-left">{{ caption }}</div>
                    </div>
                    <img class="object-cover object-top w-full aspect-square transition duration-300 ease-in-out h-38 md:h-48 lg:h-56 xl:h-70" :src="(bg != null && bg != '') ? bg : '/images/logo.jpg'" />
                </div>
            </div>
        </div>
    </div>
</Link>
</template>

<style scoped>
.card2-image{
    background-position: center !important;
    background-color: black;
}
.card2-img-div{
    height: 200px;
}
.card2-caption-div{
    height: 200px;
}

@media screen and (max-width: 1400px){
    .card2-img-div{
        height: 180px;
    }
    .card2-caption-div{
        height: 180px;
    }
}
</style>