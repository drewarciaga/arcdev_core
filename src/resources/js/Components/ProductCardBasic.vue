<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    product: {
        type: Object,
        default: null,
    },
    labelHeight: {
        type: String,
        default: ' h-1/2',
    },
    cardHeight: {
        type: String,
        default: 'w-44 h-72'
    },
    selected: {
        type: Boolean,
        default: false,
    },
});

const productThumbnail = ref('')

watch(
    () => props.product,
    (newValue, oldValue) => { 
        productThumbnail.value = newValue.thumbnail_url
        productThumbnail.value = productThumbnail.value ? productThumbnail.value.replace(/ /g, '%20') : null
    }
);

if(props.product != null){
    productThumbnail.value = props.product.thumbnail_url != null ? props.product.thumbnail_url : '/images/logo.jpg'
    productThumbnail.value = productThumbnail.value ? productThumbnail.value.replace(/ /g, '%20') : null
}
</script>

<template>
<div :class="[cardHeight, selected ? 'selectedCard' : '']" class="shadow-md rounded-xl duration-500 hover:scale-110 hover:shadow-xl bg-cover bg-center relative" :style="{ 'backgroundImage': `url(${productThumbnail})` }" >
    <!--<img v-if="product.thumbnail_url != null && product.thumbnail_url != ''" :src="product.thumbnail_url" alt="Product" class="h-24 w-auto m-auto object-cover mt-2" />
    <img v-else src="/images/no_image_product.webp" alt="Product" class="h-24 w-full object-cover" / -->

    <div :class="labelHeight" class="overflow-hidden w-full rounded-b-xl opacity-100 cursor-pointer absolute from-arc-lightgray/90 to-transparent/10 bg-gradient-to-t bottom-0 text-white">
        <div class="mx-3 min-h-[75px]">
            <p class="text-sm font-bold line-clamp-2 block capitalize  line-clamp-2">{{ props.product.name }}</p>
            <p class="text-xs font-semibold text-gray-200 cursor-auto " v-if="props.product.baf_name != null">BAF Part: {{ props.product.baf_name }}</p>
        </div>
        <slot/>
    </div>
</div>
</template>
<style scoped>
.selectedCard{
    border-radius: 0.8rem !important;
    box-shadow: 0 0 .2rem #fff, 0 0 .2rem #fff, 0 0 1.2rem #1379fe, 0 0 0.8rem #1379fe, 0 0 1.8rem #1379fe, inset 0 0 1.3rem #1379fe;
}
</style>