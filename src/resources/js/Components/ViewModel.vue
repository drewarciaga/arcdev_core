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
    modelData:{
        default: {}
    },
    width:{
        default: 700
    }
});

const dialog = ref(false)

function showViewModel(){
    dialog.value = true
}

function hideViewModel(){
    dialog.value = false
}

defineExpose({
    showViewModel,
    hideViewModel
});

</script>


<template>
    <v-dialog v-model="dialog" :width="width">
        <v-card>
            <div class="relative p-4 w-full max-h-full">
                
                <!-- Modal Head -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900">
                        View {{ model }}
                    </h3>
                    <button @click="hideViewModel" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                        <span class="mdi mdi-close"></span>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <section v-if="!isLoading">
                        <div class="modal-body relative p-4">
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
                <div class="flex items-end justify-end p-2">
                    <BreezeButton
                        :type="'button'"
                        :color="'bg-pesto hover:bg-pesto-800'"
                        class="flex items-center justify-center"
                        @click="hideViewModel"
                    >
                        Close
                    </BreezeButton>
                </div>
            </div>
        </v-card>
    </v-dialog>
</template>