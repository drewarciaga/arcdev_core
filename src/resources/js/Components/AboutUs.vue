<script setup>
import { ref } from 'vue'
import BreezeAboutUsImage from '@/Components/AboutUsImage.vue';
import Observer from "@/Components/Observer.vue";

const textAnimation        = ref(false)
const teamMembersAnimation = ref(false)

const props = defineProps({
    about_us: {
        default: null,
    },
});
</script>
<template>

<div class="flex flex-wrap w-full h-full md:p-20"  v-show="about_us.team_leader_profile_img != null">
    <Observer @intersect="textAnimation = true" @separate="textAnimation = false" class="h-full absolute"/>
    <div class="animate__animated text-center relative w-full md:w-1/3"
        :class="textAnimation ?'animate__fadeInLeft':'animate__fadeOutRight'"
    >
        <BreezeAboutUsImage
            :name="about_us.team_leader_name"
            :position="about_us.team_leader_position"
            :bg="about_us.team_leader_profile_img"
            class="animate__animated"
        
            :height="'h-[300px] md:h-[320px] lg:h-[420px]'"
        >  
        </BreezeAboutUsImage>
    </div>
    <div class="text-left relative w-full md:w-2/3 p-5 sm:px-12 md:px-4 lg:px-5 xl:px-7"  >

    
    <div class="animate__animated textAnimation"
        :class="textAnimation ?'animate__fadeInUp':'animate__fadeOutDown'"
    >
        <h6 class="title text-sm md:text-md lg:text-md uppercase text-white">{{ about_us.top_sub_text }}</h6>
        <h1 class="mb-0 md:mb-4 title text-xl md:text-2xl lg:text-4xl uppercase text-white">{{ about_us.sub_text }}</h1>
        <br/>
        <div v-html="about_us.main_text" class="text-xs md:text-sm lg:text-lg text-white"></div>
    </div>

    </div>
</div>
<div class="flex flex-wrap w-full h-full bg-gd-3">
    <div class="flex flex-wrap w-full h-full"  v-show="about_us.team_members != null && about_us.team_members.length > 0">
        <h1 class="m-auto mb-4 title text-xl md:text-2xl lg:text-4xl uppercase text-white">{{ about_us.header }}</h1>
    </div>
    <div class="flex flex-wrap justify-center w-full mb-10 sm:px-0 md:px-14">
        <Observer @intersect="teamMembersAnimation = true" @separate="teamMembersAnimation = false" class="h-full absolute"/>
        <div class="pb-2 lg:pb-4 xl:pb-14 w-full md:w-1/3 lg:w-1/5 xl:w-1/6 sm:px-0 md:px-2 lg:px-2 xl:px-4 transition ease-in-out hover:scale-110 duration-300 h-auto"
            v-for="(team_member, index) in about_us.team_members" :key="team_member.name"
        >
            <BreezeAboutUsImage
                :name="team_member.name"
                :position="team_member.position"
                :bg="team_member.profile_url"
                class="animate__animated"
                :class="teamMembersAnimation ?'animate__zoomIn':'animate__zoomOut', 'teamMemberAnimation' + index"
            >  
            </BreezeAboutUsImage>
        
        </div>
    </div>
</div>
</template>

<style scoped>
.card2-image{
    background-position: center !important;
    background-color: black;
}
.card2-img-div{
    height: 260px;;
}
.card2-caption-div{
    height: 260px;
}

@media screen and (max-width: 1400px){
    .card2-img-div{
        height: 220px;
    }
    .card2-caption-div{
        height: 220px;
    }
}

.textAnimation{
    animation-delay: 0.3s; 
}
.teamMemberAnimation0{
    animation-delay: 0.3s; 
    animation-duration: 1s;
}
.teamMemberAnimation1{
    animation-delay: 0.6s; 
    animation-duration: 1s;
}
.teamMemberAnimation2{
    animation-delay: 0.9s; 
    animation-duration: 1s;  
}
</style>