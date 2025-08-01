import { ref, reactive } from 'vue'
import useEncryptUtils from '@/Composables/useEncryptUtils.js'
import useUtils from '@/Composables/useUtils.js'

export default function useUser(){
    const { decryptJsonResponseData, decryptedResponse } = useEncryptUtils()
    const { buildFormDataFromObject } = useUtils()
    const users        = ref([])
    const totalUsers   = ref(0)
    const user_list    = ref([])
    const userErrors   = ref([])

    const user = reactive({
        id: '',
        hashid: '',
        first_name: '',
        last_name: '',
        middle_name: '',
        full_name: '',
        username: '',
        email: '',
        password: '',
        password_confirmation: '',
        mobile_no: '',
        active: 1,
        locked: 0,
        image_url: null,
        image_img: null,
        thumbnail_url: null,
        thumbnail_img: null,
        delete_image_url: false,
        super_admin: 0,
        remarks: '',
        organizer_id: null,
        organizer: null,
    })

    const user_roles = reactive({
        admin: false,
        organizer: false,
        staff: false,
    })

    const userColumns = ref([
        { id:0, key: 'last_name',               title: 'Last Name',     sortable: true },
        { id:1, key: 'first_name',              title: 'First Name',    sortable: true },
        { id:2, key: 'middle_name',             title: 'Middle Name',   sortable: true },
        { id:3, key: 'thumbnail_url',           title: 'Image',         sortable: false, align: 'center' },
        { id:4, key: 'organizer.business_name', title: 'Organizer',     sortable: false },
        { id:5, key: 'active',                  title: 'Active',        sortable: false },
        { id:6, key: 'action',                  title: 'Action',        sortable: false },
    ]);

    const userRoleColumns = ref([
        { id:0, key: 'full_name',       title: 'Name',          sortable: true },
        { id:1, key: 'roles_names',     title: 'Roles',         sortable: false },
        { id:2, key: 'username',        title: 'Username',      sortable: true },
        { id:3, key: 'action',          title: 'Action',        sortable: false , width : '30%'},
    ]);

    function resetFields(){
        user.id = ''
        user.hashid = ''
        user.first_name = ''
        user.last_name = ''
        user.middle_name = ''
        user.full_name = ''
        user.username = ''
        user.email = ''
        user.password = ''
        user.password_confirmation = ''
        user.mobile_no = ''
        user.active = 1
        user.locked = 0
        user.image_url = null
        user.thumbnail_url = null
        user.super_admin = 0
        user.delete_image_url = false
        user.remarks = ''
        user.organizer_id = null
        user.organizer = null
    }

    async function getUser(user_id){
        await axios.get('/users/' + user_id).then(async (response) => {
            if(response.data){
                await decryptJsonResponseData(response.data)
                response.data           = decryptedResponse.value
                user.hashid             = response.data.hashid
                user.first_name         = response.data.first_name
                user.last_name          = response.data.last_name
                user.middle_name        = response.data.middle_name
                user.full_name          = response.data.full_name
                user.username           = response.data.username
                user.email              = response.data.email
                user.password           = response.data.password
                user.mobile_no          = response.data.mobile_no
                user.active             = response.data.active
                user.locked             = response.data.locked
                user.image_img          = response.data.image_url
                user.thumbnail_img      = response.data.thumbnail_url
                user.super_admin        = response.data.super_admin
                user.organizer_id       = response.data.organizer_id
                user.organizer          = response.data.organizer
            }
        })
    }

    async function getUserRole(user_id){
        await axios.get('/access_controls/user_role/' + user_id).then(response => {
            if(response.data){
                user.user_role_ids     = response.data
                user.id                = user_id
            }
        })
    }

    async function updateUserRole(selectedHashid){
        userErrors.value = []

        await axios.post('/updateUserRole',{
            user_id:          selectedHashid,
            role_ids:         user.user_role_ids
        }).then(response => {
            resetFields()
        }).catch(error => {
            if(error.response && error.response.status == 422){
                userErrors.value = error.response.data.errors
            }
        });
    }

    async function getAllUsers(page, perPage, sortField, sortOrder, searchInput, filters = null){
        await axios.get('/users/getAll',{
            params: {
                page:           page,
                itemsPerPage:   perPage,
                sortBy:         sortField,
                sortDesc:       sortOrder,
                search:         searchInput,
                filters:        JSON.stringify(filters),
            }
        }).then(async (response) => {
            await decryptJsonResponseData(response.data.data)
            users.value      = decryptedResponse.value
            totalUsers.value = response.data.total
        })
    }

    async function getUserList(){
        await axios.get('/getUserList').then(async (response) => {
            await decryptJsonResponseData(response.data)
            user_list.value = decryptedResponse.value
        });
    }

    function setFormData(){
        const requiredFields = [
            'first_name',
            'last_name',
            'email',
            'username',
        ];

        const fileFields = ['image_url'];

        const allowedKeys = [
            'middle_name',
            'mobile_no',
            'password',
            'password_confirmation',
            'active',
            'locked',
            'delete_image_url',
            'remarks',
            'organizer_id',
        ];

        const data = {
            ...user,
            delete_image_url: meal.delete_image_url === true ? 1 : null,
        };

        return buildFormDataFromObject(data, requiredFields, fileFields, allowedKeys);
    }

    async function storeUser(){
        userErrors.value = []

        let formData = setFormData();

        await axios.post('/users',formData
        ).then(response => {
            resetFields()
        }).catch(error => {
            if(error.response && error.response.status == 422){
                userErrors.value = error.response.data.errors
            }
        });
    }

    async function updateUser(user_id){
        userErrors.value = []

        let formData = setFormData();
        formData.append('_method', 'PUT')
        await axios.post('/users/'+user_id,formData
        ).then(response => {
            resetFields()
        }).catch(error => {
            if(error.response && error.response.status == 422){
                userErrors.value = error.response.data.errors
            }
        });
    }

    async function deleteUser(user_id){
        userErrors.value = []
        await axios.delete('/users/'+user_id).then(response => {
            if(response.data.error != null){
                userErrors.value = response.data.error
            }
        }).catch(error => {
            userErrors.value = error
        })
    }

    async function checkRole(role_name){
        userErrors.value = []
        await axios.get('/users/check_role/'+role_name).then(response => {
            if(response.data != null){
                user_roles.admin                = response.data.admin ?? false;
                user_roles.organizer            = response.data.organizer ?? false;
                user_roles.staff                = response.data.staff ?? false;
            }
            
        }).catch(error => {
            userErrors.value = error
        })
    }
    
    return {
        user,
        users,
        user_roles,
        user_list,
        totalUsers,
        userColumns,
        userRoleColumns,
        userErrors,
        resetFields,
        storeUser,
        updateUser,
        deleteUser,
        getUser,
        getAllUsers,
        getUserList,
        checkRole,
        getUserRole,
        updateUserRole,

    }
}