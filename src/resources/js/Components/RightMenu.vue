<script setup>
import { ref, onMounted, onBeforeUnmount  } from 'vue'
const drawer = ref(false)
const props = defineProps({
    id: {
        type: String,
        default: '',
    },
});
onMounted(async () => {
    document.addEventListener('click', handleClickOutside);
});
onBeforeUnmount(async () => {
	// Remove event listener when component is destroyed
	document.removeEventListener('click', handleClickOutside);
});

const handleClickOutside = (event) => {
	const drawerElement = document.getElementById('myDrawer'+props.id);
	const buttonElement = document.getElementById('myDrawerButton'+props.id);
	if (
		drawer.value &&
		drawerElement &&
		!drawerElement.contains(event.target) &&
		buttonElement &&
		!buttonElement.contains(event.target) 
	) {
		drawer.value = false;
	}
};

function showRightMenu(){
    drawer.value = true
}

function hideRightMenu(){
    drawer.value = false
}

function trigger(){
    drawer.value = !drawer.value
}

defineExpose({
    showRightMenu,
    hideRightMenu,
    trigger
});

</script>
<template>
	<v-card style="z-index:99999 !important;" :id="'myDrawer'+props.id">
		<v-layout>
			<v-navigation-drawer
				v-model="drawer"
				location="right"
				permanent
				>
				<slot />
			</v-navigation-drawer>
		</v-layout>
	</v-card>
</template>
<style scoped>
.v-navigation-drawer--right.v-navigation-drawer--active {
  width: 300px !important;
}
</style>