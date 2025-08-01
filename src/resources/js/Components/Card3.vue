<!-- fix image min and max size-->
<template>
    <div class="flex flex-wrap -mx-2 overflow-hidden sm:-mx-2 md:-mx-2 lg:-mx-2 xl:-mx-2" v-if="model">

        <div class="my-2 px-2 w-full overflow-hidden sm:my-2 sm:px-2 sm:w-1/3 md:my-2 md:px-2 md:w-1/3 lg:my-2 lg:px-2 lg:w-1/3 xl:my-2 xl:px-2 xl:w-1/3">
            <img v-if="model.main_img" :src="model.main_img" alt="" width="1000" height="667" class="profile_img h-56 sm:h-full w-full object-cover object-top rounded-lg transition duration-500 group-hover:rounded-xl">
            <img v-else-if="model.profile_url" :src="model.profile_url" alt="" width="1000" height="667" class="profile_img h-56 sm:h-full w-full object-cover object-top rounded-lg transition duration-500 group-hover:rounded-xl">
            <img v-else src="/images/no_image.jpg" alt="" width="1000" height="667" class="profile_img h-56 sm:h-full w-full object-cover object-top rounded-lg transition duration-500 group-hover:rounded-xl">
        </div>

        <div class="my-2 px-2 w-full overflow-hidden sm:my-2 sm:px-2 sm:w-2/3 md:my-2 md:px-2 md:w-2/3 lg:my-2 lg:px-2 lg:w-2/3 xl:my-2 xl:px-2 xl:w-2/3">
            <div class="w-full pl-0 md:p-5">
                <div class="space-y-2">
                    <div class="space-y-4">
                        <h4 v-if="model.name" class="text-base md:text-md lg:text-lg xl:text-xl font-semibold text-nos-400 mb-4">{{ model.name }}</h4>

                        <table>
                            <tbody class="text-pesto align-top text-xs md:text-sm lg:text-md xl:text-lg">
                                <tr v-if="model.display_name"><td>Display Name: </td><td class="pl-1 font-bold">{{ model.display_name }}</td></tr>
                                <tr v-if="model.type_text"><td>Type: </td><td class="pl-1 font-bold">{{ model.type_text }}</td></tr>
                                <tr v-if="model.brand_text"><td>Brand: </td><td class="pl-1 font-bold">{{ model.brand_text }}</td></tr>
                                <tr v-if="model.scale_text"><td>Scale: </td><td class="pl-1 font-bold">{{ model.scale_text }}</td></tr>
                                <tr v-if="model.grade_text"><td>Grade: </td><td class="pl-1 font-bold">{{ model.grade_text }}</td></tr>
                                <tr v-if="model.line_text"><td>Line: </td><td class="pl-1 font-bold">{{ model.line_text }}</td></tr>
                                <tr v-if="model.series_text"><td>Series: </td><td class="pl-1 font-bold">{{ model.series_text }}</td></tr>
                                <tr v-if="model.group_text"><td>Group: </td><td class="pl-1 font-bold">{{ model.group_text }}</td></tr>
                                <tr v-if="model.wave_text"><td>Wave: </td><td class="pl-1 font-bold">{{ model.wave_text }}</td></tr>
                                <tr v-if="model.release_date"><td>Year Released: </td><td class="pl-1 font-bold">{{ model.release_date }}</td></tr>
                                <tr v-if="model.description"><td><br>Description: </td><td class="pl-1 font-bold"><br>{{ model.description }}</td></tr>
                                <tr v-if="model.code"><td>Code: </td><td class="pl-1 font-bold">{{ model.code }}</td></tr>
                                <tr v-if="model.manager_names"><td>Manager/s: </td><td class="pl-1 font-bold">{{ model.manager_names }}</td></tr>
                                <tr v-if="model.remarks"><td>Remarks: </td><td class="pl-1 font-bold">{{ model.remarks }}</td></tr>
                                <tr v-if="model.email"><td>Email: </td><td class="pl-1 font-bold">{{ model.email }}</td></tr>
                                <tr v-if="model.address"><td>Address: </td><td class="pl-1 font-bold">{{ model.address }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
	
	export default {
		props: [ 'model'],
	};

</script>
<style scoped>
.profile_img{
    max-height: 450px;
    object-fit: cover;
    object-position: top;
}
</style>