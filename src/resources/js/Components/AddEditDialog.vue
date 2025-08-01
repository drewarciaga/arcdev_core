<script setup>
import { ref } from 'vue'
import BreezeButton from '@/Components/Button.vue';
defineProps({
    model: {
        type: String,
        default: ''
    },
    isLoading: {
        type: Boolean,
        default: false
    },
    width:{
        default: 700
    },
    action:{
        default: 'Add'
    },
    hideClose: {
        type: Boolean,
        default: false
    },
    persistent: { type: Boolean, default: false },
});

const dialog = ref(false)

function showAddEditDialog(){
    dialog.value = true
}

function hideAddEditDialog(){
    dialog.value = false
}

defineExpose({
    showAddEditDialog,
    hideAddEditDialog
});
</script>

<template>
    <v-dialog v-model="dialog" :width="width" :persistent="persistent">
        <v-card>
            <div class="relative p-1 xl:p-4 w-full max-h-full">
                
                <!-- Modal Head -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900">
                        {{ action }} {{ model }}
                    </h3>
                    <button @click="hideAddEditDialog" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                        <span class="mdi mdi-close"></span>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-0 md:p-1 space-y-4">
                    <section v-if="!isLoading">
                        <div class="modal-body relative p-0 xl:p-4">
                            <slot />
                        </div>
                    </section>
                    <section v-else>
                        <div class="p-4">
                            <v-skeleton-loader type="paragraph"></v-skeleton-loader>
                        </div>
                    </section>
                </div>

                <!-- Modal footer -->
                <div class="flex flex-wrap relative items-end justify-end p-2">
                    <BreezeButton
                        v-if="!hideClose"
                        :type="'button'"
                        :color="'bg-pesto hover:bg-pesto-800'"
                        class="flex items-center justify-center"
                        @click="hideAddEditDialog"
                    >
                        Close
                    </BreezeButton>
                </div>
            </div>
        </v-card>
    </v-dialog>
</template>