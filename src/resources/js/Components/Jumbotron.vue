<script setup>
import { ref } from 'vue'
import BreezeButton from '@/Components/Button.vue';
import Observer from "@/Components/Observer.vue";

const props = defineProps({

    main_text: {
        default: ''
    },
    top_sub_text: {
        default: ''
    },
    sub_text: {
        default: ''
    },
    buttons: {
        default: []
    }
})

const jumbotronTextAnimation = ref(false)
const buttonsAnimation       = ref(false)
</script>
<template>

<section class="w-full overflow-hidden z-10">
    <div class="py-8 px-4 mx-auto w-full text-center lg:py-4 mb-28">
        <Observer @intersect="jumbotronTextAnimation = true" @separate="jumbotronTextAnimation = false"/>
        <div class="animate__animated shadow-orange-500 shadow-lg m-10 relative mx-auto max-w-6xl rounded-lg bg-gradient-to-tr from-nos-pink-900 to-blue-300 p-0.5"
            :class="jumbotronTextAnimation?'animate__fadeInUp':''"
        >
            <div class="bg-gray-900 p-7 rounded-md">
                <p class="mb-2 text-lg lg:text-sm font-normal text-gray-600  sm:px-16 lg:px-48 uppercase">
                    {{ top_sub_text }}
                </p>
                <h1 class="bg-gradient-to-r from-nos-blue-1000 to-nos-pink-400 bg-clip-text text-transparent text-center w-full text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-none mb-4 uppercase">
                    {{ main_text }}
                </h1>
                <p class="mb-8 text-lg lg:text-sm font-normal text-gray-600  sm:px-16 lg:px-20 uppercase">
                    {{ sub_text }}
                </p>
            </div>
        </div>

        <Observer @intersect="buttonsAnimation = true" @separate="buttonsAnimation = false"/>
        <div class="animate__animated buttonsAnimation flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0" v-if="props.buttons.length > 0"
            :class="buttonsAnimation?'animate__fadeIn':'animate__fadeOut'"
        >
            <div v-for="button in props.buttons" :key="button.text" class="px-2">
                <a :href="button.url ? button.url : ''">
                    <BreezeButton :type="'button'"  color="secondary">
                        <span>{{ button.text }}</span> 
                    </BreezeButton>
                </a>
            </div>

        </div>
    </div>
</section>

</template>
<style scoped>
.buttonsAnimation{
    animation-duration: 3s;
    --animate-delay: 2s;
}
</style>