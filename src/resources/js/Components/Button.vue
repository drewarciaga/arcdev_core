<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
    color: {
        type: String,
        default: ' bg-pesto',
    },
    hoverColor: {
        type: String,
        default: 'hover:bg-pesto-800',
    },
    activeColor: {
        type: String,
        default: 'active:bg-pesto-800',
    },
    textColor: {
        trpe: String,
        default: 'text-white'
    },
    textSize: {
        trpe: String,
        default: 'text-xs'
    },
    dimension: {
        trpe: String,
        default: ''
    }
});

</script>

<template>
    <button :type="type" class="inline-flex items-center px-3 lg:px-4 py-2 border border-transparent rounded-md font-semibold uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-25 disabled:bg-slate-500"
            :class="[color, hoverColor, activeColor, textColor, textSize, dimension]"
    >
        <slot />
    </button>
</template>