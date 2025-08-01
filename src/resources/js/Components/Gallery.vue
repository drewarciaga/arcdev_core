<script setup>
import BreezeGalleryImage from '@/Components/GalleryImage.vue';

defineProps({
    items: {
        img: String,
        title: String,
        subtitle: String
    },
});
</script>

<template>
<div>
    <div class="gallery-image">
        <template v-for="item in items" :key="item">
            <BreezeGalleryImage :img="item.img" :title="item.title" :subtitle="item.subtitle"></BreezeGalleryImage>
        </template>
    </div>
</div>

</template>

<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

.gallery-image {
    padding: 20px;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}
</style>