<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
    buttonColor: {
        type: String,
        default: 'bg-cameo hover:bg-arc-gold-900 active:bg-arc-gold-900',
    }
});

</script>
<template>
    <button :type="type" :class="buttonColor" class="block items-center px-4 py-2  border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-25">
        <slot />
    </button>
</template>