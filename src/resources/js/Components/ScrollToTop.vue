<template>
    <transition name="fade">
        <div id="pagetop" class="fixed right-4 bottom-4" v-show="scY > 300" @click="toTop">
            <button color='primary' type="button" class="inline-block items-center rounded-full mx-1 bg-pesto hover:bg-pesto-800 text-white text-3xl focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg transition duration-150 ease-in-out w-12 h-12 opacity-70 hover:opacity-80">
                <span class="mdi mdi-chevron-up"></span>
            </button>
        </div>
    </transition>
</template>
<script>
    export default{
        data() {
            return {
                scTimer: 0,
                scY: 0,
            }
        },
            mounted() {
            window.addEventListener('scroll', this.handleScroll);
        },
        methods:{
            handleScroll: function () {
                if (this.scTimer) return;
                    this.scTimer = setTimeout(() => {
                        this.scY = window.scrollY;
                        clearTimeout(this.scTimer);
                        this.scTimer = 0;
                    }, 100);
            },
            toTop: function () {
                    window.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
            },
        }
    }
</script>