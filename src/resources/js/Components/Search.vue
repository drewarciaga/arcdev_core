<script setup>
import { ref, onMounted } from 'vue';

const searchInput = ref('');
const searchInputRef = ref();
const hasFocus = ref(false);

const emit = defineEmits(['search']);

function search(){
    emit('search',searchInput)
    searchInputRef.value.select()
}

function search2(){
    if(searchInput.value == ""){
        emit('search',searchInput)
        searchInputRef.value.select()
    }
}

function addKeyListener(){
    window.addEventListener("keyup", function(e) {
        if(hasFocus.value == true && e.keyCode == 13){
            search()
        }
    }.bind(this));
}

onMounted(() => {
    addKeyListener()
});

function clearInput(){
    searchInput.value = null
}

defineExpose({
    clearInput,
});

const props = defineProps({
    mainMargin: {
        default: 'mb-3',
    },
    subMargin: {
        default: 'mb-4',
    },
    placeHolder: {
        default: 'Search',
    },
});
</script>
<template>
<div class="xl:w-96" :class="mainMargin">
    <div class="input-group relative flex flex-wrap items-stretch w-full" :class="subMargin">
    <input v-model="searchInput" ref="searchInputRef" onclick="this.select()" @keyup="search2" @focus="hasFocus = true" @blur="hasFocus = false" type="search" class="search-field form-control relative flex-auto min-w-0 block w-full px-3 py-1.5 text-sm lg:text-base text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-mt-blue-800 focus:outline-none" :placeholder="placeHolder" :aria-label="placeHolder" aria-describedby="button-addon2">
    <button @click="search" class="btn px-3 py-2.5 bg-pesto text-white text-xs leading-tight uppercase rounded shadow-md hover:bg-pesto-800 hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:bg-mt-blue-900 active:shadow-lg transition duration-150 ease-in-out flex items-center" type="button" id="button-addon2">
        <span class="mdi mdi-magnify text-base font-extrabold"></span>
    </button>
    </div>
</div>
</template>
<style scoped>
.search-field{
    width: 1%;
}
</style>