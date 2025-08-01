<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
    color: {
        type: String,
        default: '',
    },
    dimension: {
        type: String,
        default: ' w-9 h-9 ',
    },
    border: {
        type: String,
        default: ' focus:shadow-lg focus:outline-none ',
    },
});

</script>

<template>
    <button :type="type" class="items-center rounded-full mx-1 active:shadow-lg transition duration-150 ease-in-out "
        :class="[color, dimension, border]"
        >
        <slot />
    </button>
</template>
