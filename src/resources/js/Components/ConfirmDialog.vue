<script setup>
import { ref } from 'vue'
defineProps({
    title: {
        type: String,
        default: 'submit',
    },
    content: {
        default: '#',
    },
});

const dialog = ref(false)

function showConfirmDialog(){
    dialog.value = true
}

function hideConfirmDialog(){
    dialog.value = false
}

defineExpose({
    showConfirmDialog,
    hideConfirmDialog
});
</script>
<template>

<v-dialog v-model="dialog" width="auto">

    <v-card>
        <div class="flex items-center justify-between px-4 md:px-5 border-b rounded-t dark:border-gray-600">
            <h5 class="py-4 px-2 text-xl font-medium leading-normal text-gray-800" id="confirmDialogScrollableLabel">
                {{ title }}
            </h5>
            <button @click="hideConfirmDialog" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                <span class="mdi mdi-close"></span>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        <v-card-text v-if="content != null && content != ''">
            <div v-html="content"></div>
        </v-card-text>

        <v-card-actions>
            <slot />
        </v-card-actions>
    </v-card>
</v-dialog>

</template>