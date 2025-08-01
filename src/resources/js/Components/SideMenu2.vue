<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue'
import useUser from '@/Composables/User/useUser.js'
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import useOrganizer from '@/Composables/Organizer/useOrganizer.js'

const { organizer, getOrganizerLogo } = useOrganizer()    
const { checkRole, user_roles } = useUser()
const moved = ref(true)
const windowToggle = ref(false)
const inventory_chevron = ref('mdi-chevron-down')

onMounted(async () => {
    await getOrganizerLogo()
    await checkRole('admin,super_admin,manager')

    var sideBar = document.getElementById("mobile-nav");
    if(sideBar){
        sideBar.style.transform = "translateX(-225px)";
    }
});

function sidebarHandler() {
    var sideBar = document.getElementById("mobile-nav");
    if(sideBar){
        sideBar.style.transform = "translateX(-225px)";
        if (moved.value) {
            sideBar.style.transform = "translateX(0px)";
            moved.value = false;
        } else {
            sideBar.style.transform = "translateX(-225px)";
            moved.value = true;    
        }
    }
}

function toggleChevron(event, name){
    let parent = event.target.closest(".sideNav")
    let menu = parent.querySelector('.chevron')
    let submenu = parent.querySelector('ul')

    /*if ( menu != null && menu.classList.contains('mdi-chevron-down') ){
        menu.classList.toggle('mdi-chevron-up');
    }*/
    if(name == 'inventory'){
        if(inventory_chevron.value == 'mdi-chevron-down'){
            inventory_chevron.value = 'mdi-chevron-up'
        }else{
            inventory_chevron.value = 'mdi-chevron-down'
        }
    }

    if(submenu != null){
        if(submenu.classList.contains('hidden')){
            submenu.classList.toggle('hidden');
        }else{
            submenu.classList.add("hidden");
        }
        
    }
}
</script>
<template>
    <div class="relative top-0 bg-mt-blue-1000 h-100vh" @mouseenter="windowToggle = true" @mouseleave="windowToggle = false">
        <!-- Sidebar starts -->
        <!-- Remove class [ hidden ] and replace [ sm:flex ] with [ flex ] -->
        <!--div :class="windowToggle ? 'w-56' : 'w-20'" class="absolute sm:relative bg-arc-darkgray-1000 shadow md:h-full flex-col justify-between hidden lg:flex min-h-screen transition-all duration-300 ease-in-out" id="window-nav">
            <div class="px-3">
                <ul class="mt-12">

                    <Link :href="route('admin.index')" class="text-sm ml-2" v-if="user_roles.admin">
                        <li :class="windowToggle ? '' : 'justify-center'" class="whitespace-nowrap flex w-full justify-between text-slate-200 hover:text-slate-500 cursor-pointer items-center">
                            <p :class="windowToggle ? '' : 'text-3xl'" class="mdi mdi-card-bulleted-settings transition-all duration-300 ease-in-out">
                                <span class="text-sm transition-all duration-300 ease-in-out" :class="windowToggle ? '' : 'hidden'">Admin</span>
                            </p>
                        </li>
                    </Link>
                </ul>
            </div>
        </div-->
        <div  class="hidden lg:flex min-h-screen" id="window-nav">
            <v-card style="z-index:99999 !important;">
                <v-layout>
                    <v-navigation-drawer
                        expand-on-hover
                        rail
                        permanent
                    >
                        <v-list class="flex items-center justify-center">
                        <!--v-list-item
                            prepend-avatar="https://randomuser.me/api/portraits/women/85.jpg"
                            subtitle="sandra_a88@gmailcom"
                            title="Sandra Adams"
                        ></v-list-item-->
                        <BreezeApplicationLogo :logo="organizer.thumbnail_img" :sideMenu="true" />
                        </v-list>

                        <v-divider></v-divider>

                        <v-list density="compact" nav>
                            <Link :href="route('dashboard')" class="" >
                                <v-list-item prepend-icon="mdi-view-dashboard" title="Dashboard" value="dashboard"></v-list-item>
                            </Link>

                            <Link :href="route('showPosPage')" class="" >
                                <v-list-item prepend-icon="mdi-cash-register" title="Point of Sale" value="pos"></v-list-item>
                            </Link>

                            <Link :href="route('orders.index')" v-if="user_roles.admin || user_roles.manager">
                                <v-list-item prepend-icon="mdi-food" title="Orders" value="orders"></v-list-item>
                            </Link>

                            <Link :href="route('daily_shifts.index')" v-if="user_roles.admin || user_roles.manager">
                                <v-list-item prepend-icon="mdi-clock-time-eight" title="Daily Shifts" value="daily_shifts"></v-list-item>
                            </Link>
             
                            <span class="sideNav" data-collapse-toggle="inventorySideNav"  @click="toggleChevron($event, 'inventory')" >
                                <v-list-item prepend-icon="mdi-clipboard-list" :append-icon="inventory_chevron" title="Inventory" value="inventory"></v-list-item>

                                <ul id="inventorySideNav" class="hidden ml-1">
                                    <Link :href="route('product_inventory.index')" class="" >
                                        <v-list-item prepend-icon="mdi-cup" title="Product Inventory" value="products"></v-list-item>
                                    </Link>
                                    <Link :href="route('raw_material_inventory.index')" class="" >
                                        <v-list-item prepend-icon="mdi-shaker" title="Raw Material Inventory" value="raw_materials"></v-list-item>
                                    </Link>
                                    <Link :href="route('prep_food_inventory.index')" class="" >
                                        <v-list-item prepend-icon="mdi-food-variant" title="Prep Food Inventory" value="prep_food"></v-list-item>
                                    </Link>
                                    <Link :href="route('spoilages.index')" class="" >
                                        <v-list-item prepend-icon="mdi-pot-steam-outline" title="Spoilages" value="spoilages"></v-list-item>
                                    </Link>
                                </ul>
                            </span>

                            <Link :href="route('expenses.index')" v-if="user_roles.admin || user_roles.manager">
                                <v-list-item prepend-icon="mdi-cash-multiple" title="Expenses" value="expenses"></v-list-item>
                            </Link>

                            <span class="sideNav" data-collapse-toggle="salesReportSideNav"  @click="toggleChevron($event, 'salesReport')" >
                                <v-list-item prepend-icon="mdi-chart-areaspline" :append-icon="inventory_chevron" title="Sales Report" value="salesReport"></v-list-item>

                                <ul id="salesReportSideNav" class="hidden ml-1">
                                    <Link :href="route('viewDailySalesReport')" class="" >
                                        <v-list-item prepend-icon="mdi-clipboard-list-outline" title="Daliy Sales Report" value="daliy_sales_report"></v-list-item>
                                    </Link>
                                    <Link :href="route('viewMonthlySalesReport')" class="" >
                                        <v-list-item prepend-icon="mdi-chart-bar" title="Monthly Sales Report" value="monthly_sales_report"></v-list-item>
                                    </Link>
                                </ul>
                            </span>

                            <Link :href="route('admin.index')" v-if="user_roles.admin">
                                <v-list-item prepend-icon="mdi-card-bulleted-settings" title="Admin" value="admin"></v-list-item>
                            </Link>
                            <Link :href="route('organizerSettings')" v-if="user_roles.super_admin">
                                <v-list-item prepend-icon="mdi-office-building-cog" title="Organizer Settings" value="organizer_settings"></v-list-item>
                            </Link>

                        </v-list>
                    </v-navigation-drawer>

                    <v-main style="height: 250px"></v-main>
                </v-layout>
            </v-card>
        </div>
        <div class="w-56 z-40 absolute bg-white shadow md:h-full flex-col justify-between lg:hidden transition duration-150 ease-in-out min-h-screen" id="mobile-nav">
            <div id="openSideBar" class="bg-pesto hover:bg-pesto-800 h-10 w-10 absolute right-0 mt-16 -mr-10 flex items-center shadow rounded-tr rounded-br justify-center cursor-pointer" @click="sidebarHandler(true)">
                <span class="mdi mdi-tune-vertical text-slate-200 hover:text-slate-500 mobile-nav-text"></span>
            </div>
            <div id="closeSideBar" class="hidden h-10 w-10 bg-gray-900 absolute right-0 mt-16 -mr-10 items-center shadow rounded-tr rounded-br justify-center cursor-pointer text-white" @click="sidebarHandler(false)">
                <span class="mdi mdi-close"></span>
            </div>
            <div class="px-2">
                <ul class="mt-12">
                    <Link :href="route('dashboard')" class="text-sm ml-2" >
                        <li class="flex w-full justify-between text-slate-200 hover:text-slate-500 mobile-nav-text cursor-pointer items-center">
                            <span class="mdi mdi-view-dashboard"> Dashboard</span>
                        </li>
                    </Link>

                    <Link :href="route('dashboard')" class="text-sm ml-2" >
                        <li class="flex w-full justify-between text-slate-200 hover:text-slate-500 mobile-nav-text cursor-pointer items-center">
                            <span class="mdi mdi-card-bulleted-settings"> My Collections</span>
                        </li>
                    </Link>

                    <span  class="text-sm ml-2 sideNav" data-collapse-toggle="usersSideNavMobile"  @click="toggleChevron($event)" >
                        <li class="flex w-full justify-between text-slate-200 hover:text-slate-500 mobile-nav-text cursor-pointer items-center">
                            <span class="mdi mdi-account"> Clients</span>
                            <span class="mdi mdi-chevron-down chevron"></span>
                        </li>

                        <ul id="usersSideNavMobile" class="hidden ml-2">
                            <Link :href="route('users.index')" class="text-sm ml-2" >
                                <li class="flex w-full justify-between text-slate-200 hover:text-slate-500 mobile-nav-text cursor-pointer items-center">
                                    <span class="mdi mdi-account"> All Users</span>
                                </li>
                            </Link>
                            <Link :href="route('users.create')" class="text-sm ml-2" >
                                <li class="flex w-full justify-between text-slate-200 hover:text-slate-500 mobile-nav-text cursor-pointer items-center">
                                    <span class="mdi mdi-plus-circle"> Add New</span>
                                </li>
                            </Link>
                        </ul>
                    </span>

                    <Link :href="route('admin.index')" class="text-sm ml-2" >
                        <li class="flex w-full justify-between text-slate-200 hover:text-slate-500 mobile-nav-text cursor-pointer items-center">
                            <span class="mdi mdi-card-bulleted-settings"> Admin</span>
                        </li>
                    </Link>

                </ul>
            </div>
           
        </div>
        <!-- Sidebar ends -->

    </div>
</template>