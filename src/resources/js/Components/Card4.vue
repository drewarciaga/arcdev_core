<script setup>
defineProps({
    title: {
        type: String,
        default: '',
    },
    bg: {
        type: String,
        default: '',
    },
    caption: {
        type: String,
        default: '',
    },
    owned: {
        type: Boolean,
        default: false,
    },
    hideOwnedBadge: {
        type: Boolean,
        default: false,
    }
});
</script>
<template>
    <div class="block relative bg-grey shadow-md text-white h-full w-full cursor-pointer">
        <div>
            <v-lazy>
                <img class="lazy md:h-[200px] lg:h-[320px] w-full object-cover object-top" :src="bg" alt="" />
            </v-lazy>
        </div>
        <div class="p-6 flex flex-wrap justify-center">
            <p class="mb-2 text-black">{{ title }}</p>
            <p class="mb-10 leading-tight line-clamp-4 text-xs md:text-sm text-center text-arc-lightgray">
                {{ caption }}
            </p>
            <slot />
    
        </div>
  
    </div>
</template>