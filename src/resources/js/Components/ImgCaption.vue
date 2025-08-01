<template>
	<div class="flex flex-wrap bg-cover h-screen lazy" :class="mask" :style="maskImgStyle" :data-original="bg">
		<div class="bg-white-400 h-full w-full">
			<div class="m-10 text-center text-black-400 absolute">
				<h6 class="text-6xl mb-10">{{ caption }}</h6>
				<div class="text-left m-10 text-black-400 relative"><h2>{{ message }}</h2></div>
			</div>

			<div class="h-full w-full flex" v-if="link">
				<button class="m-auto text-center bg-transparent hover:bg-gray-700 text-white hover:text-gray py-2 px-4 border border-white-500 hover:border-transparent rounded ">
	              VIEW MORE
	            </button>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: ['bg', 'caption', 'message', 'link', 'mask', 'maskImg'],
	computed: {
		maskImgStyle () {
			if(this.maskImg != null){
				return  'mask-image: url(' +this.maskImg+');'
			}else{
				return ''
			}
			
		}
	},
};
</script>

<style>
	.mtop-70 {
		margin-top: 70%;
	}
    .bg-contain{
        background-size: contain !important;
        background-repeat: no-repeat;
        background-position: initial;
    }
    .bg-cover{
        background-repeat: no-repeat;
        background-position: initial;
    }
</style>