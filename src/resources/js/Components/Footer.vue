<script setup>
import useUtils from '@/Composables/useUtils.js'

const { app_copyright } = useUtils()
const props = defineProps({
    title: {
        default: ''
    },
    subtitle: {
        default: ''
    },
    links: {
        default: null
    },
    backgroundColor:{
        default: 'bg-eiffelTower'
    },
    overlay_url:{
        default: ''
    },
})

</script>
<template>
  <footer class="relative overflow-hidden bg-[#1a1613] text-white py-12 px-4">
    <!-- Background Image -->
    <div
      v-if="overlay_url"
      class="absolute inset-0 w-full h-full bg-cover bg-center z-0"
      :style="{ backgroundImage: `url('${overlay_url}')` }"
    ></div>
    <!-- Dark overlay (for contrast) -->
    <div class="absolute inset-0 bg-[#1a1613] bg-opacity-80 z-10"></div>

    <!-- Footer content -->
    <div class="relative z-20 max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-32">
      <!-- Opening Hours -->
      <div>
        <h2 class="font-bold text-lg md:text-xl mb-6 tracking-wide">OPENING HOURS</h2>
        <ul class="space-y-1 font-light">
          <li class="flex justify-between"><span>MONDAY</span> <span class="text-[#b3956b]">CLOSED</span></li>
          <li class="flex justify-between"><span>TUESDAY</span> <span>9:00 - 22:00</span></li>
          <li class="flex justify-between"><span>WEDNESDAY</span> <span>9:00 - 22:00</span></li>
          <li class="flex justify-between"><span>THURSDAY</span> <span>9:00 - 22:00</span></li>
          <li class="flex justify-between"><span>FRIDAY *</span> <span>9:00 - 1:00</span></li>
          <li class="flex justify-between"><span>SATURDAY *</span> <span>12:00 - 1:00</span></li>
          <li class="flex justify-between"><span>SUNDAY</span> <span>9:00 - 22:00</span></li>
        </ul>
      </div>
    
    
      <!-- Contact Us -->
      <div>
        <h2 class="font-bold text-lg md:text-xl mb-6 tracking-wide">CONTACT US</h2>
        <div class="space-y-2">
          <p>
            <a href="mailto:barista@qodeinteractive.com" class="text-[#b3956b] hover:underline">barista@qodeinteractive.com</a>
          </p>
          <p>1-444-123-4559</p>
          <p>Block 7 Lot 12 Teodora St. Segunda Village, Brgy Platero, Binan Laguna, Philippines</p>
        </div>
       
        <!-- Social Media -->
        <div class="flex gap-4 mt-8">
          <a href="#" aria-label="Facebook" class="hover:text-[#b3956b] transition">
            <!-- Facebook SVG -->
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"
                 stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
          <a href="#" aria-label="Twitter" class="hover:text-[#b3956b] transition">
            <!-- Twitter SVG -->
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53A4.48 4.48 0 0 0 22.4 1.64a9.09 9.09 0 0 1-2.89 1.1A4.48 4.48 0 0 0 16.11.36c-2.37 0-4.29 1.92-4.29 4.29 0 .34.04.67.11.99A12.8 12.8 0 0 1 3.15 1.62a4.26 4.26 0 0 0-.58 2.16c0 1.48.75 2.78 1.89 3.54a4.4 4.4 0 0 1-1.94-.54v.06c0 2.07 1.47 3.8 3.43 4.19a4.52 4.52 0 0 1-2.92.1c.82 2.58 3.2 4.47 6.01 4.52A9 9 0 0 1 2 19.54c-.67 0-1.34-.04-1.99-.12A12.8 12.8 0 0 0 7.5 21c8.04 0 12.45-6.67 12.45-12.45 0-.19 0-.39-.01-.58A9.09 9.09 0 0 0 23 3z"
                 stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
          <a href="#" aria-label="Instagram" class="hover:text-[#b3956b] transition">
            <!-- Instagram SVG -->
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"
                 stroke-linecap="round" stroke-linejoin="round"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" stroke-linecap="round" stroke-linejoin="round"/><line x1="17.5" y1="6.5" x2="17.5" y2="6.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        </div>
      </div>

    </div>
  </footer>
</template>