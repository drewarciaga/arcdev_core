<script setup>
const props = defineProps({
    logo: {
        default: '/images/logo.png',
    },
    sideMenu:{
        default: false
    }
});

</script>
<template>
    <img :src="props.logo" alt="Arcdev" class="object-cover h-full w-full max-w-[120px]" :class="sideMenu ? 'mx-1' : ''">
</template>