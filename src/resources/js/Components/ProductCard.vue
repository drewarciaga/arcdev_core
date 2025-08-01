<script setup>
import { ref } from 'vue'
import BreezeButton from '@/Components/Button.vue';
import useUtils from '@/Composables/useUtils.js'
const emit = defineEmits(['addToOrder']);
const order_quantity = ref(1)
const { numberOnly, numberWithCommas } = useUtils()

defineProps({
    product: {
        type: Object,
        default: null,
    },
});
function subtractQty(){
    if(order_quantity.value > 1 ){
        order_quantity.value--
    }
}

function addQty(){
    if(order_quantity.value != 0 ){
        order_quantity.value++
    }
}
</script>

<template>
<div class="w-44 bg-white shadow-md rounded-xl duration-500 hover:scale-105 hover:shadow-xl" :class="product.stock == 0 ? 'opacity-55' : ''">
    <img v-if="product.thumbnail_url != null && product.thumbnail_url != ''" :src="product.thumbnail_url" alt="Product" class="h-24 w-auto m-auto object-cover rounded-t-xl" />
    <img v-else src="/images/no_image_product.webp" alt="Product" class="h-24 w-full object-cover rounded-t-xl" />

    <div class="px-4 py-3 w-full">
        <p class="text-sm font-bold text-black line-clamp-2 block capitalize min-h-[42px]">{{ product.name }}</p>
        <p class="text-xs font-semibold text-gray-400 cursor-auto">Stock: {{ numberWithCommas(product.stock) }}</p>
        <div class="flex items-center">
            <p class="text-sm font-semibold text-black cursor-auto my-3">&#8369;{{ numberWithCommas(product.price) }}</p>
        </div>

        <div class="flex w-full items-center justify-center my-2">
            <button
                :disabled="product.stock == 0"
                @click="subtractQty"
                type="button"
                class="bg-white-1000 rounded-l border text-gray-600 hover:bg-gray-100 active:bg-gray-200 disabled:opacity-50 inline-flex items-center px-2 py-1 border-r border-gray-200">
                <span class="mdi mdi-minus"></span>
            </button>
            <div
                class="bg-gray-100 border-t border-b border-gray-100 text-gray-600 hover:bg-gray-100 inline-flex items-center py-1 select-none">
                <input class="w-14 text-center h-7" v-model="order_quantity" @keypress="numberOnly"></input>
            </div>
            <button
                :disabled="product.stock == 0"
                @click="addQty"
                type="button"
                class="bg-white-1000 rounded-r border text-gray-600 hover:bg-gray-100 active:bg-gray-200 disabled:opacity-50 inline-flex items-center px-2 py-1 border-r border-gray-200">
                <span class="mdi mdi-plus"></span>
            </button>
        </div>

        <BreezeButton :type="'button'" @click="$emit('addToOrder', product.id, order_quantity)" class=" w-full flex items-center justify-center" :disabled="product.stock == 0">
            Add to Order
        </BreezeButton>
    </div>
</div>
</template>