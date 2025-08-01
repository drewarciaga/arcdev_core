<script setup>
import { ref, defineAsyncComponent } from 'vue'

const BreezeConfirmDialog = defineAsyncComponent(()=>
    import('@/Components/ConfirmDialog.vue')
)

defineExpose({
    showItemActionsMenu, hideItemActionsMenu
});

const itemActionsMenuRef    = ref()
const selectedItemId        = ref(null)

async function showItemActionsMenu(hashid){
    selectedItemId.value = hashid
    itemActionsMenuRef.value.showConfirmDialog()
}

async function hideItemActionsMenu(){
    selectedItemId.value = null
    itemActionsMenuRef.value.hideConfirmDialog()
}
</script>
<template>
<BreezeConfirmDialog title="Select Action" content="" ref="itemActionsMenuRef">
    <div class="modal-body relative p-4">
        <ul class="w-96 text-center m-auto">
            <slot />
        </ul>
    </div>
</BreezeConfirmDialog>

</template>