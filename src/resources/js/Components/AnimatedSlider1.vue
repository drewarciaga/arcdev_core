<template>
	<div class="w-full no-bg py-5 content-center m-auto carbon h-slider" :class="textColor">
		<div class="max-w-sm rounded m-auto">
		  
            <div class="mr-0 md:mr-8 mb-6 md:mb-0" style="height: 100%;">
                <div class="" style="height: 100%; ">
                    <v-lazy>
                        <img :src="'/images/gallery/1.png'" class="w-6 max-h-7" :class="isMobile?'m-2':'m-auto'" alt="..." />
                    </v-lazy>
                </div>
                <div class="" style="height: 100%; ">
                    <v-lazy>
                        <img :src="'/images/gallery/1.png'" class="w-6 max-h-7" :class="isMobile?'m-2':'m-auto'" alt="..." />
                    </v-lazy>
                </div>
            </div>


		</div>
	</div>

</template>

<script>
	
	export default {
		props: [ 'textColor', 'titleColor', 'title', 'message', 'hashtag1', 'hashtag2', 'hashtag3', 'hashtag4', 'hashtag5', 'hashtag6'],
	};

</script>