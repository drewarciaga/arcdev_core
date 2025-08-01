<script setup>
import useUtils from '@/Composables/useUtils.js'
const emits = defineEmits(['removeCartItem'])

const { numberWithCommas } = useUtils()
defineProps({
    item: {
        default: null
    },
    dimension:{
        type: String,
        default: 'w-full h-auto',
    },
    hideRemove:{
        type: Boolean,
        default: false,
    },
    nameDimension:{
        type: String,
        default: 'w-32',
    },
    index:{
        default: null
    },
    priceFontSize:{
        type: String,
        default: 'text-xs lg:text-xs xl:text-sm'
    }
});

function removeCartItem(index){
    emits('removeCartItem',index)
}

</script>

<template>

<div class="flex items-center p-2 w-full" v-if="item != null">
    <div class="shrink-0">
        <v-avatar       
            rounded="0"
            size="44"
        >
            <v-img :src="item.thumbnail_url != null ? item.thumbnail_url : '/images/no_image.jpg'"></v-img>
        </v-avatar>
      
    </div>
    <div class="grid grid-cols-4">
        <div class="ms-2 lg:ms-4 col-span-2" :class="nameDimension">
            <p class="text-xs xl:text-sm line-clamp-1 text-black">
                {{ item.name }}
            </p>
            <p class="text-xs line-clamp-1 text-black">
                {{ item.price != null ? '₱' + numberWithCommas(item.price) : ''  }}
            </p>
        </div>
        <slot name="control-buttons" />
        <div class="inline-flex items-center justify-end font-semibold text-black px-2 line-clamp-1">
            <div>
                <p :class="priceFontSize">{{ item.total_price != null ? '₱' + numberWithCommas(item.total_price) : ''  }}</p>
                <p class="text-xs text-arc-red hover:text-arc-red-900" v-if="!hideRemove" @click="removeCartItem(index)">remove</p>
            </div>
        </div>
    </div>
</div>
</template>