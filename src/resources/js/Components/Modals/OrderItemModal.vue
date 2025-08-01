<script setup>
import { ref, defineAsyncComponent } from 'vue'

const BreezeConfirmDialog = defineAsyncComponent(()=>
    import('@/Components/ConfirmDialog.vue')
)

defineExpose({
    showAddToCart, hideAddToCart
});

const addToCartRef          = ref()
const selectedItemId        = ref(null)

async function showAddToCart(hashid){
    selectedItemId.value = hashid
    addToCartRef.value.showConfirmDialog()
}

async function hideAddToCart(){
    selectedItemId.value = null
    addToCartRef.value.hideConfirmDialog()
}
</script>
<template>
<BreezeConfirmDialog title="Add To Cart" content="" ref="addToCartRef" width="70%">
    <slot />
</BreezeConfirmDialog>

</template>