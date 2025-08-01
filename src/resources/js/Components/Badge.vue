<script setup>
defineProps({
	bgColor: {
		type: String,
		default: 'primary', // can be a utility class or hex
	},
	textColor: {
		type: String,
		default: 'primary', // can be a utility class or hex
	},
	text: {
		default: '',
	},
	boxColor: {
		type: String,
		default: '',
	},
	fontSize: {
		type: String,
		default: 'text-xs',
	},
});
</script>

<template>
	<span
		:class="[isColorClass(bgColor) ? bgColor : '', isColorClass(textColor) ? textColor : '', fontSize]"
		:style="mergeStyles(boxColor, bgColor, textColor)"
		class="inline-block py-1 px-2.5 leading-none text-center whitespace-nowrap align-baseline font-bold rounded"
	>
		{{ text }}
	</span>
</template>

<script>
/**
 * Helper to detect if a value is a CSS class (e.g., 'bg-red-500') vs hex color.
 */
function isColorClass(color) {
	return typeof color === 'string' && !color.startsWith('#') && !color.startsWith('rgb')
}

/**
 * Merges inline style values, prioritizing `boxColor` but falling back to hex color props.
 */
function mergeStyles(boxColor, bgColor, textColor) {
	let style = {}

	if (typeof boxColor === 'string' && boxColor.trim() !== '') {
		try {
			const inline = boxColor.includes(':')
				? Object.fromEntries(boxColor.split(';').map(rule => {
					const [key, val] = rule.split(':')
					return key && val ? [key.trim(), val.trim()] : null
				}).filter(Boolean))
				: {}
			style = { ...style, ...inline }
		} catch (e) {

		}
	}

	// If bgColor is a hex/rgb code
	if (!isColorClass(bgColor)) {
		style.backgroundColor = bgColor
	}

	// If textColor is a hex/rgb code
	if (!isColorClass(textColor)) {
		style.color = textColor
	}

	return style
}
</script>
