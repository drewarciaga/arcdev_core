import { ref, reactive } from 'vue'

export default function useRole(){
    const roles        = ref([])
    const totalRoles   = ref(0)
    const role_list    = ref([])
    const errors       = ref([])

    const role = reactive({
        id: '',
        name: '',
    })

    const columns = ref([
        { id:0, key: 'name',     title: 'Name',   sortable: true },
        { id:1, key: 'action',   title: 'Action', sortable: false },
    ]);

    function resetFields(){
        role.id = ''
        role.name = ''
    }

    async function getRole(role_id){
        await axios.get('/roles/' + role_id).then(response => {
            if(response.data){
                role.id                = response.data.id
                role.name              = response.data.name
            }
        })
    }

    async function getAllRoles(searchInput){
        await axios.get('/roles/getAll',{
            params: {
                search: searchInput
            }
        }).then(response => {
            roles.value      = response.data.data
            totalRoles.value = response.data.total
        })
    }

    async function getRoleList(){
        await axios.get('/getRoleList').then(response => {
            role_list.value = response.data
        });
    }

    function setFormData(){
        let formData = new FormData();
        formData.append('name', role.name);

        return formData;
    }

    async function storeRole(){
        errors.value = []

        let formData = setFormData();

        await axios.post('/roles',formData
        ).then(response => {
            resetFields()
        }).catch(error => {
            if(error.response && error.response.status == 422){
                errors.value = error.response.data.errors
            }
        });
    }

    async function updateRole(role_id){
        errors.value = []

        let formData = setFormData();
        formData.append('_method', 'PUT')
        await axios.post('/roles/'+role_id,formData
        ).then(response => {
            resetFields()
        }).catch(error => {
            if(error.response && error.response.status == 422){
                errors.value = error.response.data.errors
            }
        });
    }

    async function deleteRole(role_id){
        errors.value = []

        await axios.delete('/roles/'+role_id).then(response => {
            if(response.data.error != null){
                errors.value = response.data.error
            }
        }).catch(error => {
            errors.value = error
        })
    }
    
    return {
        role,
        roles,
        role_list,
        totalRoles,
        columns,
        errors,
        resetFields,
        storeRole,
        updateRole,
        deleteRole,
        getRole,
        getAllRoles,
        getRoleList,
    }
}