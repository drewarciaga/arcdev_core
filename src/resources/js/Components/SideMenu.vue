<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue'
import useUser from '@/Composables/User/useUser.js'

const { checkRole, user_roles } = useUser()
const moved = ref(true)

onMounted(async () => {
    await checkRole('admin')

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

function toggleChevron(event){
    let parent = event.target.closest(".sideNav")
    let menu = parent.querySelector('.chevron')
    let submenu = parent.querySelector('ul')

    if ( menu != null && menu.classList.contains('mdi-chevron-down') ){
        menu.classList.toggle('mdi-chevron-up');
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
    <div class="relative top-0 bg-mt-blue-1000 h-100vh">
        <!-- Sidebar starts -->
        <!-- Remove class [ hidden ] and replace [ sm:flex ] with [ flex ] -->
        <div class="w-56 absolute sm:relative bg-arc-darkgray-1000 shadow md:h-full flex-col justify-between hidden lg:flex min-h-screen">
            <div class="px-3">
                <ul class="mt-12">
                    <Link :href="route('dashboard')" class="text-sm ml-2" >
                        <li class="flex w-full justify-between text-slate-200 hover:text-slate-500 cursor-pointer items-center">
                            <span class="mdi mdi-view-dashboard"> Dashboard</span>
                        </li>
                    </Link>

                    <span  class="text-sm ml-2 sideNav" data-collapse-toggle="usersSideNav"  @click="toggleChevron($event)">
                        <li class="flex w-full justify-between text-slate-200 hover:text-slate-500 cursor-pointer items-center">
                            <span class="mdi mdi-account"> Users</span>
                            <span class="mdi mdi-chevron-down chevron"></span>
                        </li>
                        <ul id="usersSideNav" class="hidden ml-2">
                            <Link :href="route('users.index')" class="text-sm ml-2" >
                                <li class="flex w-full justify-between text-slate-200 hover:text-slate-500 cursor-pointer items-center">
                                    <span class="mdi mdi-account"> All Users</span>
                                </li>
                            </Link>
                            <Link :href="route('users.create')" class="text-sm ml-4" >
                                <li class="flex w-full justify-between text-slate-200 hover:text-slate-500 cursor-pointer items-center">
                                    <span class="mdi mdi-plus-circle"> Add New</span>
                                </li>
                            </Link>
                        </ul>
                    </span>

                    <Link :href="route('admin.index')" class="text-sm ml-2" >
                        <li class="flex w-full justify-between text-slate-200 hover:text-slate-500 cursor-pointer items-center">
                            <span class="mdi mdi-card-bulleted-settings"> Admin</span>
                        </li>
                    </Link>
                </ul>
            </div>
        </div>
        <div class="w-56 z-40 absolute bg-mt-blue-1000 shadow md:h-full flex-col justify-between lg:hidden transition duration-150 ease-in-out min-h-screen" id="mobile-nav">
            <div id="openSideBar" class="h-10 w-10 bg-mt-blue-1000 absolute right-0 mt-16 -mr-10 flex items-center shadow rounded-tr rounded-br justify-center cursor-pointer bg-arc-red-1000" @click="sidebarHandler(true)">
                <span class="mdi mdi-tune-vertical text-slate-200" ></span>
            </div>
            <div id="closeSideBar" class="hidden h-10 w-10 bg-gray-900 absolute right-0 mt-16 -mr-10 items-center shadow rounded-tr rounded-br justify-center cursor-pointer text-white" @click="sidebarHandler(false)">
                <span class="mdi mdi-close"></span>
            </div>
            <div class="px-2">
                <ul class="mt-12">
                    <Link :href="route('dashboard')" class="text-sm ml-2" >
                        <li class="flex w-full justify-between text-slate-200 hover:text-slate-500 cursor-pointer items-center">
                            <span class="mdi mdi-view-dashboard"> Dashboard</span>
                        </li>
                    </Link>

                    <span  class="text-sm ml-2 sideNav" data-collapse-toggle="usersSideNavMobile"  @click="toggleChevron($event)" >
                        <li class="flex w-full justify-between text-slate-200 hover:text-slate-500 cursor-pointer items-center">
                            <span class="mdi mdi-account"> Clients</span>
                            <span class="mdi mdi-chevron-down chevron"></span>
                        </li>

                        <ul id="usersSideNavMobile" class="hidden ml-2">
                            <Link :href="route('users.index')" class="text-sm ml-2" >
                                <li class="flex w-full justify-between text-slate-200 hover:text-slate-500 cursor-pointer items-center">
                                    <span class="mdi mdi-account"> All Users</span>
                                </li>
                            </Link>
                            <Link :href="route('users.create')" class="text-sm ml-2" >
                                <li class="flex w-full justify-between text-slate-200 hover:text-slate-500 cursor-pointer items-center">
                                    <span class="mdi mdi-plus-circle"> Add New</span>
                                </li>
                            </Link>
                        </ul>
                    </span>

                  
                    <Link :href="route('admin.index')" class="text-sm ml-2" >
                        <li class="flex w-full justify-between text-slate-200 hover:text-slate-500 cursor-pointer items-center">
                            <span class="mdi mdi-card-bulleted-settings"> Admin</span>
                        </li>
                    </Link>

                </ul>
            </div>
           
        </div>
        <!-- Sidebar ends -->

    </div>
</template>