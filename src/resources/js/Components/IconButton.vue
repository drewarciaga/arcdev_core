<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
    color: {
        type: String,
        default: 'primary',
    },
    isActive: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <div class="flex space-x-2 justify-center">
        <div v-if="isActive">
            <button type="button" class="inline-block rounded-md bg-pesto text-white leading-normal uppercase shadow-md hover:bg-pesto-800 active:bg-pesto-800 hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg transition duration-150 ease-in-out w-9 h-9 mx-1">
                <slot />
            </button>
        </div>
        <div v-else>
            <button type="button" class="inline-block rounded-md bg-pesto text-white leading-normal uppercase shadow-md hover:bg-pesto-800 active:bg-pesto-800 hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg transition duration-150 ease-in-out w-9 h-9 mx-1">
                <slot />
            </button>
        </div>
    </div>
</template>