<script setup>
import { ref, onMounted } from 'vue'
const props = defineProps({
    bg: {
        default: ''
    },
    mask: {
        default: ''
    },
    maskImg: {
        default: ''
    },
    bgSize: {
        default: ''
    }
})

const bgStyle = ref('')
const maskImgStyle = ref('')

onMounted(async () => {
    if(props.bg != ''){
        bgStyle.value = 'background-image: url(' + props.bg +');'
    }

    if(props.maskImg != ''){
        maskImgStyle.value = 'mask-image: url(' + props.maskImg +');'
    }
});
</script>

<template>
    <div
        class="container flex items-center justify-center h-screen m-auto mb-12 bg-fixed bg-center bg-cover" :class="[mask, bgSize]" :style="[bgStyle, maskImgStyle]"
        >
    </div>
</template>

<style scoped>
	
	.mtop-70 {
		margin-top: 70%;
	}
    .bg-contain{
        background-size: contain !important;
        background-repeat: no-repeat;
        background-position: initial;
    }
    .bg-cover{
        background-repeat: no-repeat;
        background-position: initial;
    }
</style>