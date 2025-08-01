import { ref, reactive } from 'vue'
//import useMyCollection from '@/Composables/MyCollections/useMyCollection';
import useToast from '@/Composables/useToast'
import useFavorite from '@/Composables/MyCollections/useFavorite.js'
import useMyCollection from '@/Composables/MyCollections/useMyCollection';
import useWishlist from '@/Composables/MyCollections/useWishlist';

const { toast } = useToast()
const { removeItemFromMyCollectionByItemId, myCollectionErrors, addProductToMyCollections } = useMyCollection()
const { favoritesError, addToFavorites, removeFromFavorites, removeFromFavoritesById, getAllFavoriteProducts } = useFavorite()
const { wishListsError, addToWishLists, removeFromWishLists, removeFromWishListsById } = useWishlist()

export default function useMyCollectionUtils(){
    const myCollectionUtilRes = reactive({
        items : [],
        totalItems: 0,
        errors: []
    })

    async function addToWishListItemsUtil(item_id){
        myCollectionUtilRes.errors = []
        await addToWishLists(item_id)
        if(wishListsError.value.length > 0){
            toast('Add To Wish List Failed', 'danger', 5000 )
            myCollectionUtilRes.errors = wishListsError.value
        }else{
            toast('Add To Wish List Successful!', 'success')
        }
    }

    async function removeFromWishListItemsUtil(item_id){
        myCollectionUtilRes.errors = []
        await removeFromWishLists(item_id)
        if(wishListsError.value.length > 0){
            toast('Remove From Wish List Failed', 'danger', 5000 )
            myCollectionUtilRes.errors = wishListsError.value
        }else{
            toast('Remove From Wish List Successful!', 'success')
        }
    }

    async function removeFromWishListItemsByIdUtil(favorite_id){
        myCollectionUtilRes.errors = []
        await removeFromWishListsById(favorite_id)
        if(wishListsError.value.length > 0){
            toast('Remove Wish List Failed', 'danger', 5000 )
            myCollectionUtilRes.errors = wishListsError.value
        }else{
            toast('Remove Wish List Successful!', 'success')
        }
    }

    async function addToFavoriteItemsUtil(item_id){
        myCollectionUtilRes.errors = []
        await addToFavorites(item_id)
        if(favoritesError.value.length > 0){
            toast('Add To Favorites Failed', 'danger', 5000 )
            myCollectionUtilRes.errors = favoritesError.value
        }else{
            toast('Add To Favorites Successful!', 'success')
        }
    }
    
    async function removeFromFavoriteItemsUtil(item_id){
        myCollectionUtilRes.errors = []
        await removeFromFavorites(item_id)
        if(favoritesError.value.length > 0){
            toast('Remove Favorites Failed', 'danger', 5000 )
            myCollectionUtilRes.errors = favoritesError.value
        }else{
            toast('Remove Favorites Successful!', 'success')
        }
    }

    async function removeFromFavoriteItemsByIdUtil(favorite_id){
        myCollectionUtilRes.errors = []
        await removeFromFavoritesById(favorite_id)
        if(favoritesError.value.length > 0){
            toast('Remove Favorites Failed', 'danger', 5000 )
            myCollectionUtilRes.errors = favoritesError.value
        }else{
            toast('Remove Favorites Successful!', 'success')
        }
    }

    async function addItemToMyCollectionsUtil(collection_id, item_id){
        myCollectionUtilRes.errors = []
        await addProductToMyCollections(collection_id, item_id)
        if(myCollectionErrors.value.length > 0){
            toast('Add To Collection Failed! : ' + myCollectionErrors.value, 'danger', 5000 )
            myCollectionUtilRes.errors = myCollectionErrors.value
        }else{
            toast('Add To Collection Successful!', 'success')
        }
    }

    async function removeItemFromMyCollectionByItemIdUtil(collection_id, item_id){
        myCollectionUtilRes.errors = []
        await removeItemFromMyCollectionByItemId(collection_id, item_id)
    
        if(collection_id == 'all'){
            if(myCollectionErrors.value.length > 0){
                toast('Remove Item from All My Collections Failed' + myCollectionErrors.value, 'danger', 5000 )
            }else{
                toast('Remove Item from All My Collections Successful', 'success')
          
                //$('#myCollectionsListModal').hide();
               // $('#removeFromAllCollectionsModal').hide();
                //$('#showModalMenu').hide();        
            }
        }else{
            if(myCollectionErrors.value.length > 0){
                toast('Remove Item from My Collections Failed' + myCollectionErrors.value, 'danger', 5000 )
            }else{
                toast('Remove Item from My Collections Successful', 'success')
          
                //$('#myCollectionsListModal').hide();
                //$('#showModalMenu').hide();
            }
        }
    }

    return {
        myCollectionUtilRes,
        addToWishListItemsUtil,
        removeFromWishListItemsUtil,
        removeFromWishListItemsByIdUtil,
        addToFavoriteItemsUtil,
        removeFromFavoriteItemsUtil,
        removeFromFavoriteItemsByIdUtil,
        addItemToMyCollectionsUtil,
        removeItemFromMyCollectionByItemIdUtil,
    }
}