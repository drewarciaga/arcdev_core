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
        <div class="block p-1 lg:p-3 rounded-lg shadow-lg bg-black md:flex flex-wrap neon-border-blue" :class="[bgColor, textColor]">
            <div class="card2-caption-div sm:w-full lg:w-1/3">
                <h5 class="text-lg leading-tight font-medium mb-2 py-4 min-h-1/2">{{ caption }}</h5>
                <div class="mt-4 mb-10">
                    
                </div>
                <p class="text-sm mb-4">
                {{ message }}
                </p>
                <slot />
            </div>
            <div class="card2-img-div sm:w-full lg:w-2/3 px-2 py-4 md:py-8 lg:py-2">
                <div class="block lazy bg-cover bg-center bg-no-repeat h-full w-full card2-image" :data-original="bg"></div>
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
    height: 260px;;
}
.card2-caption-div{
    height: 260px;
}

@media screen and (max-width: 1400px){
    .card2-img-div{
        height: 220px;
    }
    .card2-caption-div{
        height: 220px;
    }
}
</style>