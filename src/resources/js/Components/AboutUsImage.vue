<script setup>
defineProps({
    bg: {
        type: String,
        default: '',
    },
    name: {
        type: String,
        default: '',
    },
    position: {
        type: String,
        default: '',
    },
    height: {
        type: String,
        default: 'h-[400px] md:h-[200px] lg:h-[320px]',
    }
});
</script>
<template>
  
<div class="block relative rounded-lg shadow-md text-white w-full cursor-pointer">
    <div class="mx-[20px] md:mx-[0px]">
        <v-lazy>
            <img :class="height" class="w-full object-cover object-top" :src="bg" alt="" />
        </v-lazy>
    </div>
    <div class="mx-[20px] md:mx-[0px] opacity-100 cursor-pointer absolute from-arc-lightgray3/90 to-transparent/0 bg-gradient-to-t inset-x-0 bottom-0 text-white h-1/3 ">
        <p class="font-bold text-lg category-name absolute bottom-10 text-center w-full">{{ name }}<br>{{ position }}</p>
    </div>
</div>

</template>