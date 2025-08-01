<script setup>
const props = defineProps({
    message: {
        default: ''
    },
    subText: {
        default: ''
    },
});

</script>
<template>

<div class="shadow-orange-500 shadow-lg text-white block rounded-lg px-6 py-6 backdrop-blur-[30px] bg-[hsla(0,0%,5%,0.55)] md:py-6 md:px-6">
    {{ message }}
    <br>
    <br>
    <span class="text-sm">
        {{ subText }}
    </span>
</div>

</template>