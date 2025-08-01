<script setup>
defineProps({
    isLoading: {
        type: Boolean,
        default: false,
    },
});
</script>
<template>
  
    <v-progress-circular indeterminate color="primary" v-show="isLoading" class="screen-loader"></v-progress-circular>
</template>
<style scoped>
.screen-loader{
    position: fixed; /* or absolute */
    top: 50%;
    left: 50%;
    display: block;
    position: fixed;
    z-index: 99999;
}
</style>