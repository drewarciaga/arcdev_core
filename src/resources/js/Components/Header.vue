<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    from_logout: Boolean,
    welcome_page_settings: Object,
    user: Object,
    logo: String,
    logo_text: String,
})

function toggleMenu(){
    const burgerMenu = document.getElementById('burger-menu');
    const mobileMenu = document.getElementById('mobile-menu');
   
    if (mobileMenu.classList.contains('max-h-0')) {
        mobileMenu.classList.remove('max-h-0');
        mobileMenu.classList.add('max-h-96'); // Adjust this value based on your content height
    } else {
        mobileMenu.classList.remove('max-h-96');
        mobileMenu.classList.add('max-h-0');
    }
}
</script>
<template>
	<nav class="bg-none text-white shadow-md fixed w-full top-0 z-50 w-full" style="position: fixed; left: 0; right: 0; width: 100vw; max-width: 100vw; min-width: 100vw;">
		<div class="mx-auto px-4 sm:px-6 lg:px-8">
			<div class="relative flex items-center h-14">
				<!-- Logo on the left -->
				<div class="flex-shrink-0 flex items-center">
					<a href="#" class="text-xl font-bold text-white">{{ props.logo_text }}</a>
				</div>

				<!-- Nav links in the center (hidden on mobile) -->
				<div class="hidden md:flex items-center space-x-4 absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
					<a href="#" class="text-silkyWhite-900 hover:text-eiffelTower px-3 py-2 uppercase">Home</a>
					<a href="#" class="text-silkyWhite-900 hover:text-eiffelTower px-3 py-2 uppercase">Menu</a>
					<a href="#" class="text-silkyWhite-900 hover:text-eiffelTower px-3 py-2 uppercase">Contact</a>
				</div>

				<!-- Login button on the right (hidden on mobile) -->
				<div class="hidden md:flex items-center">
					<div v-if="canLogin" class="absolute top-0 right-0 px-6 py-4 sm:block z-max">
						<Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-sm text-silkyWhite-900 hover:text-eiffelTower cursor-pointer uppercase">
							Dashboard
						</Link>

						<template v-else>
							<Link :href="route('login')" class="text-sm text-silkyWhite-900 hover:text-eiffelTower cursor-pointer uppercase">
								Log in
							</Link>

							<Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-silkyWhite-900 hover:text-eiffelTower cursor-pointer uppercase">
								Register
							</Link>
						</template>
					</div>
				</div>

				<!-- Burger menu for mobile -->
				<div class="flex items-center md:hidden ml-auto">
					<button id="burger-menu" class="text-icedCoffee hover:text-silkyWhite focus:outline-none" @click="toggleMenu">
						<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
						</svg>
					</button>
				</div>
			</div>
		</div>

		<!-- Mobile menu (hidden by default) -->
		<div id="mobile-menu" class="md:hidden overflow-hidden transition-all duration-300 ease-in-out max-h-0">
			<div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
				<a href="#" class="block text-icedCoffee hover:text-silkyWhite px-3 py-2 uppercase">Home</a>
				<a href="#" class="block text-icedCoffee hover:text-silkyWhite px-3 py-2 uppercase">Menu</a>
				<a href="#" class="block text-icedCoffee hover:text-silkyWhite px-3 py-2 uppercase">Contact</a>
				<div v-if="canLogin" class="">
					<Link v-if="$page.props.auth.user" :href="route('dashboard')" class="block text-icedCoffee hover:text-silkyWhite px-3 py-2 cursor-pointer uppercase">
						Dashboard
					</Link>

					<template v-else>
						<Link :href="route('login')" class="block text-silkyWhite-900 hover:text-eiffelTower px-3 py-2 cursor-pointer uppercase">
							Log in
						</Link>

						<Link v-if="canRegister" :href="route('register')" class="block text-silkyWhite-900 hover:text-eiffelTower px-3 py-2 cursor-pointer uppercase">
							Register
						</Link>
					</template>
				</div>
			</div>
		</div>
	</nav>
</template>