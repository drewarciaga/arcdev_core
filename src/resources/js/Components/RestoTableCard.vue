<script setup>
import { ref } from 'vue'

const props = defineProps({
    table: {
        type: Object,
        default: null,
    },
    labelHeight: {
        type: String,
        default: ' h-2/5',
    },
    cardHeight: {
        type: String,
        default: 'w-36 h-56'
    },
    selected: {
        type: Boolean,
        default: false,
    },
});

const tableThumbnail = ref('/images/table.png')

</script>

<template>
<div :class="[cardHeight, selected ? 'selectedCard' : '']" class="shadow-md duration-500 hover:scale-110 hover:shadow-xl bg-contain bg-top bg-arc-turquoise relative" :style="{ 'backgroundImage': `url(${tableThumbnail})` }" >
    <!--<img v-if="table.thumbnail_url != null && table.thumbnail_url != ''" :src="table.thumbnail_url" alt="Product" class="h-24 w-auto m-auto object-cover mt-2" />
    <img v-else src="/images/no_image_table.webp" alt="Product" class="h-24 w-full object-cover" / -->

    <div :class="labelHeight" class="rounded-b-lg overflow-hidden w-full opacity-100 cursor-pointer absolute from-arc-lightgray/90 to-transparent/20 bg-gradient-to-t bottom-0 text-white">
        <div class="mx-3 min-h-[25px]">
            <p class="text-sm font-bold block capitalize line-clamp-2">Table: {{ props.table.table_no }}</p>
        </div>
        <slot/>
    </div>
</div>
</template>
<style scoped>
.selectedCard{
    border-radius: 0.8rem !important;
    box-shadow: 0 0 .2rem #fff, 0 0 .2rem #fff, 0 0 1.2rem #1379fe, 0 0 0.8rem #1379fe, 0 0 1.8rem #1379fe, inset 0 0 1.3rem #1379fe;
}
</style>