<template>
    <div class="mx-auto pt-12 mt-3 px-4" v-if="listView == 'list'"  :key="componentKey">
        <div class="relative w-full"  v-for="item in items" :key="item.id">
            <InfiniteCard
                :item="item"
                :hideDelete="hideDelete"
                :hideEdit="hideEdit"
                :routeName="routeName"
                :hasPopupEdit="hasPopupEdit"
                @viewModel="$emit('viewModel', item.id)"
                @deleteModel="$emit('deleteModel', item.id)"
                @editModel="$emit('editModel', item.id)"
                @addToOwned="addToOwned"
                @addToFavorites="addToFavorites"
                @addToWishlists="addToWishlists"
                @removeFromFavorites="removeFromFavorites"
                @removeFromWishlists="removeFromWishlists"
                @showModalMenu="showModalMenu"
            ></InfiniteCard>
        </div>
        <Observer @intersect="intersected"/>
    </div>

    <div class="mx-auto pt-12 mt-3 px-4" v-else-if="listView == 'grid'">
        <div class="px-4 flex flex-wrap -mx-1 overflow-hidden sm:-mx-1 md:-mx-1 lg:-mx-1 xl:-mx-1 mb-72 infinite-card-2" v-if="routeName=='my_collections'">
            <div class="my-2 px-2 w-1full overflow-hidden sm:my-2 sm:px-2 sm:w-full md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/3" v-for="item in items" :key="item.id">
                <div class="relative h-48 md:h-64 lg:h-72 xl:h-80 ">
                    <InfiniteCardMyCollection
                        :item="item"
                        :hideDelete="hideDelete"
                        :hideEdit="hideEdit"
                        :routeName="routeName"
                        @viewModel="$emit('viewModel', item.id)"
                        @addToFavorites="addToFavorites"
                        @addToWishlists="addToWishlists"
                        @removeFromFavorites="removeFromFavorites"
                        @removeFromWishlists="removeFromWishlists"
                    ></InfiniteCardMyCollection>
                </div>
            </div>
        </div>
        <div class="px-4 flex flex-wrap -mx-1 overflow-hidden sm:-mx-1 md:-mx-1 lg:-mx-1 xl:-mx-1 mb-72 infinite-card-2" v-else>
            <div class="rounded-xl my-2 px-2 w-1/3 overflow-hidden sm:my-2 sm:px-2 sm:w-1/4 md:my-2 md:px-2 md:w-1/4 lg:my-3 lg:px-3 lg:w-1/5 xl:my-3 xl:px-3 xl:w-1/6" v-for="item in items" :key="item.id">
                <div class="relative h-48 md:h-64 lg:h-72 xl:h-80 ">
                    <InfiniteCard2
                        :item="item"
                        :hideDelete="hideDelete"
                        :hideEdit="hideEdit"
                        :hideActions="hideActions"
                        :routeName="routeName"
                        @viewModel="$emit('viewModel', item.id)"
                        @addToOwned="addToOwned"
                        @addToFavorites="addToFavorites"
                        @addToWishlists="addToWishlists"
                        @removeFromFavorites="removeFromFavorites"
                        @removeFromWishlists="removeFromWishlists"
                        @showModalMenu="showModalMenu"
                    ></InfiniteCard2>
                </div>
            </div>
        </div>
        <h1 class="text-white text-sm relative bottom-20 -mt-48 text-center w-full uppercase mt-20" v-show="showEndofLine">
            Show more <span class="mdi mdi-chevron-double-down"></span>
        </h1>
        <Observer @intersect="intersected"/>
    </div>

    <ScrollToTop></ScrollToTop>
</template>
<script>
import axios from 'axios'
import Observer from "../Components/Observer.vue";
import InfiniteCard from "../Components/InfiniteCard.vue";
import InfiniteCard2 from "../Components/InfiniteCard2.vue";
import InfiniteCardMyCollection from "../Components/InfiniteCardMyCollection.vue";
import ScrollToTop from "../Components/ScrollToTop.vue";

export default{
    emits: ['viewModel', 'deleteModel', 'editModel', 'addToOwned', 'addToFavorites', 'addToWishlists', 'removeFromFavorites', 'removeFromWishlists', 'showModalMenu'],
    props: [ 'searchInput', 'hideDelete', 'listView', 'triggerRefresh', 'hideEdit', 'hideActions', 'routeName', 'compKey', 'filters', 'large', 'hasPopupEdit'],
    components: {
        Observer, InfiniteCard, InfiniteCard2, ScrollToTop, InfiniteCardMyCollection
    },
    data() {
        return {
            items: [],
            page: 1,
            perPage: 21,
            totalItems: 0,
            stopFetch: false,
            holdFunction: false,
            componentKey: 0,
            componentKey2: 0,
            selectedItem: null,
            showEndofLine: true,
        }
    },
    methods:{
        async intersected (fromSearch = false) {

            if(this.stopFetch == false && (fromSearch || this.holdFunction == false)){
                let ret = await axios.get('/'+this.routeName+'/getAll',{
                    params: {
                        page: this.page,
                        itemsPerPage: this.perPage,
                        search: this.searchInput,
                        filters: JSON.stringify(this.filters),
                    }
                })
                
                this.totalItems = ret.data.total
                this.items      = this.items.concat(ret.data.data)
                this.page++

                if(ret.data.data.length == 0){
                    this.stopFetch = true
                    this.showEndofLine = false
                }
            }
        },
        addToOwned(id){
            this.$emit('addToOwned', id)
        },
        addToFavorites(id){
            this.$emit('addToFavorites', id)
        },
        addToWishlists(id){
            this.$emit('addToWishlists', id)
        },
        removeFromFavorites(id){
            this.$emit('removeFromFavorites', id)
        },
        removeFromWishlists(id){
            this.$emit('removeFromWishlists', id)
        },
        showModalMenu(id){
            this.$emit('showModalMenu', id)
        },
        
    },
    watch: {
        searchInput: async function(val){
           
        },
        triggerRefresh: async function(val){
            if(val == true){
                this.items = []
                this.page = 1
                this.totalItems = 0
                this.stopFetch = false
                this.holdFunction = true
                await this.intersected(true)
                this.holdFunction = false
                this.showEndofLine = true
            }
        },
    }
}
</script>