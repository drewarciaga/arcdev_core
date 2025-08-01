<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
	modelValue: {
		type: String,
		default: null
	}
})

const emit = defineEmits(['update:modelValue'])

const dialog = ref(false)
const internalColor = ref('')

const swatches = ref([
	[
		['#FF0000', '#AA0000', '#550000'],
		['#FFFF00', '#AAAA00', '#555500'],
		['#00FF00', '#00AA00', '#005500'],
		['#00FFFF', '#00AAAA', '#005555'],
		['#0000FF', '#0000AA', '#000055']
	]
])

watch(
	() => props.modelValue,
	(newColor) => {
		internalColor.value = newColor
	},
	{ immediate: true }
)

watch(internalColor, (val) => {
	emit('update:modelValue', val)
})

const resetColor = () => {
	internalColor.value = null
	emit('update:modelValue', null)
}
</script>

<template>
	<div>
		<div
			class="color-box"
			:style="{ backgroundColor: props.modelValue || '#ffffff' }"
			@click="dialog = true"
		></div>

		<v-dialog v-model="dialog" max-width="400">
			<v-card>
				<v-card-title class="text-h6">Select Color</v-card-title>
				<v-card-text>
					<v-color-picker
						v-model="internalColor"
						hide-inputs
						show-swatches
						:swatches="swatches.value"
						class="ma-2"
					/>
				</v-card-text>
				<v-card-actions>
					<v-btn text color="error" @click="resetColor">Reset</v-btn>
					<v-spacer />
					<v-btn text @click="dialog = false">Close</v-btn>
				</v-card-actions>
			</v-card>
		</v-dialog>
	</div>
</template>

<style scoped>
    .color-box {
        width: 40px;
        height: 40px;
        border-radius: 4px;
        cursor: pointer;
        border: 2px solid #ccc;
    }
</style>