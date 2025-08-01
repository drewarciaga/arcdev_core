<script setup>
import BreezeBadge from '@/Components/Badge.vue';
</script>
<template>
    <div class="flex space-x-2 mb-4">
        <p class="text-xs text-white leading-none">Stock:</p>
        <BreezeBadge :text="'Normal'"
                        :bgColor="'bg-green-700 hover:bg-green-600'"
                        :textColor="'text-white'"
                        class="cursor-pointer"
        ></BreezeBadge>
        <BreezeBadge :text="'Low Stock'"
                        :bgColor="'bg-orange-500 hover:bg-orange-300'"
                        :textColor="'text-white'"
                        class="cursor-pointer"
        ></BreezeBadge>
        <BreezeBadge :text="'Out of Stock'"
                        :bgColor="'bg-red-600 hover:bg-red-400'"
                        :textColor="'text-white'"
                        class="cursor-pointer"
        ></BreezeBadge>
        <BreezeBadge :text="'Overstock'"
                        :bgColor="'bg-blue-700 hover:bg-blue-500'"
                        :textColor="'text-white'"
                        class="cursor-pointer"
        ></BreezeBadge>
    </div>
</template>