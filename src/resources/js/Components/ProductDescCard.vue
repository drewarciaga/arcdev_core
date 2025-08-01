<script setup>
defineProps({
    model: {
        type: Object,
        default: null,
    },
    isAdmin: {
        type: Boolean,
        default: true,
    },
    cardHeight: {
        type: String,
        default: 'sm:h-full h-44'
    }
});
</script>

<template>
    <div class="flex flex-wrap overflow-hidden" v-if="model">
        <div class="my-2 w-full overflow-hidden sm:my-2 sm:w-1/3 md:my-2 md:w-1/3 lg:my-2 lg:w-1/3 xl:my-2 xl:w-1/3">
            <img v-if="model.image_img" :src="model.image_img" alt="" class="profile_img w-full object-cover object-top rounded-l-lg transition duration-500 group-hover:rounded-xl" :class="cardHeight" >
            <img v-else-if="model.image_url" :src="model.image_url" alt="" class="profile_img w-full object-cover object-top rounded-l-lg transition duration-500 group-hover:rounded-xl" :class="cardHeight" >
            <img v-else src="/images/no_image.jpg" alt="" class="profile_img w-full object-cover object-top rounded-l-lg transition duration-500 group-hover:rounded-xl" :class="cardHeight" >
        </div>

        <div class="my-2 w-full overflow-hidden sm:my-2 sm:w-2/3 md:my-2 md:w-2/3 lg:my-2 lg:w-2/3 xl:my-2 xl:w-2/3 relative">
            <div class="w-full absolute">
                <slot />
            </div>
            <v-lazy >
                <img  class="pointer-events-none absolute opacity-10 object-cover h-full hidden lg:block w-full"
                        :src="'images/abstract_overlay.png'" alt=""  aria-hidden="">
            </v-lazy>
            <div class="w-full pl-0 md:p-5 ml-3 h-44" >
                <div class="space-y-4">
                    <h4 v-if="model.name" class="text-base md:text-md lg:text-xl xl:text-2xl font-semibold text-arc-blue2 mt-2 mb-4 ml-2">{{ model.name }}</h4>

                    <div class="grid grid-cols-6 grid-rows-6 gap-2">
                        <div class="col-span-6 overflow-auto h-28 ml-2 text-sm pb-4" v-html="model.description"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</template>
<style scoped>
.profile_img{
    max-height: 320px;
    object-fit: contain;
    object-position: top;
}
.min-width-td {
    display: inline-block;
    min-width: 150px;
}
</style>