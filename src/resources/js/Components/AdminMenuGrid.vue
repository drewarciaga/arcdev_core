<script setup>
import BreezeButton from '@/Components/Button.vue';
import { Link } from '@inertiajs/vue3';
import { ref, reactive, onMounted } from 'vue'

const adminMenu             = ref()
const draggable             = ref(true)
const resizable             = ref(false)
const responsive            = ref(true)
const layouts               = ref()
const layout                = ref([])
const currentBreakPoint     = ref('')

const cols = reactive({
    lg:6,
    md:4,
    sm:3,
    xs:2,
    xxs:1
})

const breakpoints = reactive({
    lg: 1400,
    md: 996,
    sm: 768,
    xs: 480,
    xxs: 0
})

onMounted(async () => {
    let gridWidth = adminMenu.value.clientWidth

    let newBreakpoint = ''
    if(gridWidth > 1400){
        newBreakpoint = 'lg'
    }else if(gridWidth > 996){
        newBreakpoint = 'md'
    }else if(gridWidth > 768){
        newBreakpoint = 'sm'
    }else if(gridWidth > 480){
        newBreakpoint = 'xs'
    }else{
        newBreakpoint = 'xxs'
    }

    await getAdminMenuItems(newBreakpoint)
});

function breakpointChangedEvent(newBreakpoint, newLayout){
    layout.value = newLayout
    currentBreakPoint.value = newBreakpoint
}

async function getAdminMenuItems(newBreakpoint){
    axios.get('/admin/getAdminMenuItems',{
        params: {
            breakpoint: newBreakpoint,
        }
        }).then(response => {
        layouts.value = response.data.layouts
        layout.value = layouts.value[newBreakpoint]
    })
}
function movedEvent(i, newX, newY){
    layouts.value[currentBreakPoint.value] = layouts.value[currentBreakPoint.value]

    axios.post('/admin/updateAdminMenuGrid',{
        layouts: layouts.value,
    }).then(response => {

    }).catch(error => {
        console.log(error);
    });
}
</script>

<template>
    <div ref="adminMenu">
        <grid-layout :layout.sync="layout"
                     :responsive-layouts="layouts"
                     :col-num="4"
                     :cols="cols"
                     :row-height="50"
                     :is-draggable="draggable"
                     :is-resizable="resizable"
                     :vertical-compact="true"
                     :use-css-transforms="true"
                     :responsive="responsive"
                     @breakpoint-changed="breakpointChangedEvent"
                     :breakpoints="breakpoints"
        >
            <grid-item v-for="item in layout" :key="item.i"
                       :x="item.x"
                       :y="item.y"
                       :w="item.w"
                       :h="item.h"
                       :i="item.i"
                       :max-h="5"
                       :min-h="5"
                       class="GradientBorder"
                       drag-allow-from=".vue-draggable-handle"
                       drag-ignore-from=".no-drag"
                       @moved="movedEvent"
            >
       
                <div class="block justify-center">
                    <div class="block rounded-lg shadow-lg bg-white max-w-sm text-center">
                        <div class="flex py-6 px-6">
                            <span class="mdi mdi-drag-horizontal-variant text-black vue-draggable-handle px-6 mx-4" style="font-size:25pt"></span>
                        </div>
                        <span class="mdi text-pesto m-auto absolute top-2" :class="item.icon" style="font-size:35px; margin-left:-18px;"></span>
                        <div class="p-6">
                            <h5 class="text-gray-900 text-lg font-medium mb-2 m-auto" style="height:28px; width:200px">{{item.title?item.title:""}}</h5>
                            <p class="text-gray-700 text-sm mb-4 m-auto" style="height:70px; width:200px">
                                {{item.desc?item.desc:""}}
                            </p>

                            <Link :href="item.link ? route(item.link) : ''">
                                <BreezeButton :type="'button'">
                                    <span>View</span> 
                                </BreezeButton>
                            </Link>
                        </div>
                        <div class="py-3 px-6"></div>
                    </div>
                </div>
            </grid-item>
        </grid-layout>
    </div>
</template>

<style scoped>
.vue-grid-layout {
    background: none;
}
.vue-grid-item:not(.vue-grid-placeholder) {
    border: 4px solid linear-gradient(90deg,#2746a2 0%, #8017ac 80%);

    color:white;
}
.vue-grid-item .resizing {
    opacity: 0.9;
}
.vue-grid-item .static {
    background: #cce;
}
.vue-grid-item .text {
    font-size: 24px;
    text-align: center;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto;
    height: 100%;
    width: 100%;
}
.vue-grid-item .no-drag {
    height: 100%;
    width: 100%;
}
.vue-grid-item .minMax {
    font-size: 12px;
}
.vue-grid-item .add {
    cursor: move;
}
.vue-draggable-handle {
    position: absolute;
    width: 20px;
    height: 20px;
    top: 0;
    left: 0;
    background-position: bottom right;
    padding: 0 8px 8px 0;
    background-repeat: no-repeat;
    background-origin: content-box;
    box-sizing: border-box;
    cursor: move;
}
.module-border-wrap {
    max-width: 250px;
    padding: 1rem;
    position: relative;
    background: linear-gradient(to right, rgb(60, 85, 199), purple);
    padding: 3px;
}

.module {
    background: #222;
    color: white;
    padding: 2rem;
}
</style>