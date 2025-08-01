<template>
	<div class="observer"/>
</template>

<script>
export default {
	props: ['options'],
	data: () => ({
		observer: null,
	}),
	mounted() {
		const options = this.options || {};
		this.observer = new IntersectionObserver(([entry]) => {
			if (entry && entry.isIntersecting) {
				this.$emit("intersect");
			}else{
				this.$emit("separate");
			}
		}, options);

		this.observer.observe(this.$el);
	},
	destroyed() {
		this.observer.disconnect();
	},
};
</script>