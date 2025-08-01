<template>
    <div class="w-full no-bg content-center m-auto carbon" :class="textColor">
        <div class="lg:max-w-sm max-w-2xl rounded m-auto text-left flex flex-col justify-center h-full">
            <div class="px-6 py-4">
                <div class="text-white text-xl xl:text-2xl pb-4"><span :class="titleColor">{{ title }}</span></div>
                <p class="text-gray-400 text-lg xl:text-xl pb-4">{{ message }}</p>
            </div>
        </div>
    </div>
</template>


<script>
	
	export default {
		props: [ 'textColor', 'titleColor', 'title', 'message', 'hashtag1', 'hashtag2', 'hashtag3', 'hashtag4', 'hashtag5', 'hashtag6'],
	};

</script>