
<script setup>
const emit = defineEmits(['triggerEvent']);

defineProps({
	metrics: {
		default: [],
	},
});
</script>
<template>
<div class="flex flex-wrap -mx-1 overflow-hidden sm:-mx-1 md:-mx-1 lg:-mx-1 xl:-mx-1 mb-3">
    <div class="shadow-gray-600 drop-shadow-md my-1 px-1 w-full overflow-hidden sm:my-1 sm:px-1 sm:w-full md:my-1 md:px-1 md:w-1/2 lg:my-2 lg:px-1 lg:w-1/4 xl:my-2 xl:px-1 xl:w-1/4 cursor-pointer"
        @click="$emit('triggerEvent', metric.action)"
        v-for="(metric,i) in metrics" :key="metric.name"
    >
        <div class="bg-white border rounded-lg p-2 hover:bg-gray-300">
            <div class="flex flex-row items-center">
                <div class="flex-shrink pr-4">
                    <div class="inline-flex flex-shrink-0 justify-center items-center w-9 h-9 text-white bg-pesto rounded-lg">
                        <i class="text-lg" :class="[metric.icon]" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="flex-1 text-center">
                    <h5 class="text-xs font-bold uppercase text-gray-400">{{metrics[i].name}}</h5>
                    <h3 class="text-xl font-bold text-gray-600" :class="metric.value_color">{{metric.value}}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
</template>