<template>
    <div ref="adminMenu">
        <div class="flex flex-wrap -mx-1 overflow-hidden sm:-mx-1 md:-mx-1 lg:-mx-1 xl:-mx-1">
            <div class="my-1 px-2 w-full overflow-hidden sm:my-1 sm:px-2 sm:w-full md:my-1 md:px-2 md:w-1/2 lg:my-1 lg:px-2 lg:w-1/4 xl:my-1 xl:px-2 xl:w-1/6" v-for="item in layout" :key="item.i">
                <div class="block justify-center">
                    <div class="block rounded-lg shadow-lg bg-white max-w-sm text-center mb-6">
                        <div class="flex py-2 px-6">
                            <span class="mdi mdi-drag-horizontal-variant text-black vue-draggable-handle px-6 mx-4" style="font-size:25pt"></span>
                        </div>
                        <span class="mdi text-pesto m-auto relative top-2" :class="item.icon" style="font-size:35px;"></span>
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
                        <div class="py-2 px-6">
    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </template>
    
    <script>
    import BreezeButton from '@/Components/Button.vue';
    import { Link } from '@inertiajs/vue3';
    
    export default {
    
        components: {
            BreezeButton, Link
    
        },
        mounted: function (){
            let gridWidth = this.$refs.adminMenu.clientWidth
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
            
            this.getAdminMenuItems(newBreakpoint)
        },
        data() {
            return {
                cols: {
                    lg:6,
                    md:4,
                    sm:3,
                    xs:2,
                    xxs:1
                },
                draggable: true,
                resizable: false,
                responsive: true,
                adminMenuItems: [],
                isLoading: false,
                breakpoints: {
                    lg: 1400,
                    md: 996,
                    sm: 768,
                    xs: 480,
                    xxs: 0
                },
                layouts : {},
                layout : [],
                currentBreakPoint: ''
            }
        },
        methods: {
            breakpointChangedEvent: function(newBreakpoint, newLayout){
                //console.log("BREAKPOINT CHANGED breakpoint=", newBreakpoint, ", layout: ", newLayout );
                this.layout = newLayout
                this.currentBreakPoint = newBreakpoint
            },
            getAdminMenuItems(newBreakpoint){
                axios.get('/admin/getAdminMenuItems',{
                    params: {
                        breakpoint: newBreakpoint,
                    }
                    }).then(response => {
                    this.layouts = response.data.layouts
                    
                    this.layout = this.layouts[newBreakpoint]
                })
            },
        }
    
        
    }
    </script>
    
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