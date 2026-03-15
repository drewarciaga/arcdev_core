import { ref, reactive } from 'vue'
import { usePage } from '@inertiajs/vue3'
import useEncryptUtils from '@/Composables/useEncryptUtils.js'
import useUtils from '@/Composables/useUtils.js'

const organizers = ref([])
const totalOrganizers = ref(0)
const organizer_list = ref([])
const organizerErrors = ref([])
const organizerSharedLoaded = ref(false)

const organizer = reactive({
    id: '',
    hashid: '',
    business_name: null,
    first_name: '',
    last_name: '',
    middle_name: '',
    full_name: '',
    domain_name: '',
    email: '',
    mobile_no: '',
    mobile_no_2: '',
    business_address: '',
    active: 1,
    image_url: null,
    image_img: null,
    thumbnail_url: null,
    thumbnail_img: null,
    delete_image_url: false,
    delete_profile_url: false,
    organizer_type: 0,
    remarks: '',
    social_media_data: [],
    profile_url: null,
    profile_img: null,
    profile_thumb_url: null,
    profile_thumb_img: null,
    slug: null,
    venue_id: null,
})

const organizerColumns = ref([
    { id: 0, key: 'business_name', title: 'Business Name', sortable: true },
    { id: 1, key: 'first_name', title: 'First Name', sortable: true },
    { id: 2, key: 'last_name', title: 'Last Name', sortable: true },
    { id: 3, key: 'middle_name', title: 'Middle Name', sortable: true },
    { id: 4, key: 'domain_name', title: 'Domain Name', sortable: true },
    { id: 5, key: 'thumbnail_url', title: 'Image', sortable: false, align: 'center' },
    { id: 6, key: 'profile_thumb_url', title: 'Profile', sortable: false, align: 'center' },
    { id: 7, key: 'type_text', title: 'Type', sortable: true },
    { id: 8, key: 'active', title: 'Active', sortable: true },
    { id: 9, key: 'action', title: 'Action', sortable: false },
])

function applySharedOrganizer(data) {
    if ( !data ) {
        return
    }

    organizer.id = data.id ?? organizer.id
    organizer.hashid = data.hashid ?? organizer.hashid
    organizer.business_name = data.business_name ?? organizer.business_name
    organizer.domain_name = data.domain_name ?? organizer.domain_name
    organizer.image_img = data.image_url ?? organizer.image_img
    organizer.thumbnail_img = data.thumbnail_img ?? data.thumbnail_url ?? organizer.thumbnail_img
    organizer.image_url = data.image_url ?? organizer.image_url
    organizer.thumbnail_url = data.thumbnail_url ?? organizer.thumbnail_url
}

export default function useOrganizer() {
    const page = usePage()
    const { decryptJsonResponseData, decryptedResponse } = useEncryptUtils()
    const { buildFormDataFromObject } = useUtils()

    const hydrateFromPage = () => {
        const sharedOrganizer = page.props?.organizer ?? null

        if ( sharedOrganizer ) {
            applySharedOrganizer(sharedOrganizer)
            organizerSharedLoaded.value = true
        }
    }

    hydrateFromPage()

    function resetFields() {
        organizer.id = ''
        organizer.hashid = ''
        organizer.business_name = null
        organizer.first_name = ''
        organizer.last_name = ''
        organizer.middle_name = ''
        organizer.full_name = ''
        organizer.domain_name = ''
        organizer.email = ''
        organizer.mobile_no = ''
        organizer.mobile_no_2 = ''
        organizer.business_address = ''
        organizer.active = 1
        organizer.image_url = null
        organizer.image_img = null
        organizer.thumbnail_url = null
        organizer.thumbnail_img = null
        organizer.delete_image_url = false
        organizer.delete_profile_url = false
        organizer.organizer_type = 0
        organizer.remarks = ''
        organizer.social_media_data = []
        organizer.slug = null
        organizer.venue_id = null
    }

    async function getOrganizer(organizer_id) {
        await axios.get('/organizers/' + organizer_id).then(async (response) => {
            if ( response.data ) {
                await decryptJsonResponseData(response.data)
                response.data = decryptedResponse.value
                organizer.hashid = response.data.hashid
                organizer.business_name = response.data.business_name
                organizer.first_name = response.data.first_name
                organizer.last_name = response.data.last_name
                organizer.middle_name = response.data.middle_name
                organizer.full_name = response.data.full_name
                organizer.domain_name = response.data.domain_name
                organizer.email = response.data.email
                organizer.mobile_no = response.data.mobile_no
                organizer.mobile_no_2 = response.data.mobile_no_2
                organizer.business_address = response.data.business_address
                organizer.active = response.data.active
                organizer.image_img = response.data.image_url
                organizer.thumbnail_img = response.data.thumbnail_url
                organizer.profile_img = response.data.profile_url
                organizer.profile_thumb_img = response.data.profile_thumb_url
                organizer.organizer_type = response.data.organizer_type
                organizer.remarks = response.data.remarks
                organizer.venue_id = response.data.venue_id

                if ( response.data.social_media_data != null ) {
                    organizer.social_media_data = JSON.parse(response.data.social_media_data)
                }

                organizer.slug = response.data.slug
            }
        })
    }

    async function getAllOrganizers(pageNumber, perPage, sortField, sortOrder, searchInput, filters = null) {
        await axios.get('/organizers/getAll', {
            params: {
                page: pageNumber,
                itemsPerPage: perPage,
                sortBy: sortField,
                sortDesc: sortOrder,
                search: searchInput,
                filters: JSON.stringify(filters),
            },
        }).then(async (response) => {
            await decryptJsonResponseData(response.data.data)
            organizers.value = decryptedResponse.value
            totalOrganizers.value = response.data.total
        })
    }

    async function getOrganizerList() {
        await axios.get('/getOrganizerList').then(async (response) => {
            await decryptJsonResponseData(response.data)
            organizer_list.value = decryptedResponse.value
        })
    }

    function setFormData() {
        const requiredFields = [
            'business_name',
            'first_name',
            'last_name',
        ]

        const fileFields = [
            'image_url',
            'profile_url',
        ]

        const allowedKeys = [
            'middle_name',
            'domain_name',
            'email',
            'mobile_no',
            'mobile_no_2',
            'business_address',
            'active',
            'organizer_type',
            'slug',
            'venue_id',
        ]

        const data = {
            ...organizer,
            delete_image_url: organizer.delete_image_url === true ? 1 : null,
            delete_profile_url: organizer.delete_profile_url === true ? 1 : null,
            social_media_data: organizer.social_media_data ? JSON.stringify(organizer.social_media_data) : null,
        }

        return buildFormDataFromObject(data, requiredFields, fileFields, allowedKeys)
    }

    async function storeOrganizer() {
        organizerErrors.value = []

        const formData = setFormData()

        await axios.post('/organizers', formData).then(() => {
            resetFields()
        }).catch((error) => {
            if ( error.response && error.response.status == 422 ) {
                organizerErrors.value = error.response.data.errors
            }
        })
    }

    async function updateOrganizer(organizer_id) {
        organizerErrors.value = []

        const formData = setFormData()
        formData.append('_method', 'PUT')

        await axios.post('/organizers/' + organizer_id, formData).then(() => {
            resetFields()
        }).catch((error) => {
            if ( error.response && error.response.status == 422 ) {
                organizerErrors.value = error.response.data.errors
            }
        })
    }

    async function deleteOrganizer(organizer_id) {
        organizerErrors.value = []

        await axios.delete('/organizers/' + organizer_id).then((response) => {
            if ( response.data.error != null ) {
                organizerErrors.value = response.data.error
            }
        }).catch((error) => {
            organizerErrors.value = error
        })
    }

    async function getOrganizerLogo(force = false) {
        hydrateFromPage()

        if ( !force && organizerSharedLoaded.value && ( organizer.thumbnail_img || organizer.image_img ) ) {
            return
        }

        await axios.get('/getOrganizerLogo').then(async (response) => {
            if ( response.data ) {
                if ( response.data.logo == null ) {
                    organizer.image_img = response.data.image_url
                    organizer.thumbnail_img = response.data.thumbnail_url
                    organizer.image_url = response.data.image_url
                    organizer.thumbnail_url = response.data.thumbnail_url
                    organizerSharedLoaded.value = true
                }
            }
        })
    }

    return {
        organizer,
        organizers,
        organizer_list,
        totalOrganizers,
        organizerColumns,
        organizerErrors,
        resetFields,
        storeOrganizer,
        updateOrganizer,
        deleteOrganizer,
        getOrganizer,
        getAllOrganizers,
        getOrganizerList,
        getOrganizerLogo,
    }
}