import { ref, reactive } from 'vue'
import useEncryptUtils from '@/Composables/useEncryptUtils.js'
import useUtils from '@/Composables/useUtils.js'

export default function useOrganizerSettings(){
    const { decryptJsonResponseData, decryptedResponse } = useEncryptUtils()
    const { buildFormDataFromObject } = useUtils()
    const organizerSettingsErrors = ref([])

    const organizer_settings = reactive({
        organizer_id: null,
        organizer: null,
        subscription_start: null,
        subscription_end: null,
        subscription_length: null,
        subscription_type: null,
        subscription_amount: 0,
        modules: { },
        remarks: null,
    })

    async function getOrganizerSettings(){
        await axios.get('/getOrganizerSettings').then(async (response) => {
            if(response.data != null){
                await decryptJsonResponseData(response.data)
                response.data                              = decryptedResponse.value
                organizer_settings.subscription_start        = response.data.subscription_start
                organizer_settings.subscription_end          = response.data.subscription_end
                organizer_settings.subscription_length       = response.data.subscription_length
                organizer_settings.subscription_type         = response.data.subscription_type
                organizer_settings.subscription_amount       = response.data.subscription_amount
                organizer_settings.remarks                   = response.data.remarks
                organizer_settings.organizer_id              = response.data.organizer_id
                organizer_settings.organizer                 = response.data.organizer

                if(response.data.modules != null){
                    organizer_settings.modules = JSON.parse(response.data.modules)
                }
            }
        });
    }

    function setFormDataMainBanner(){
        const requiredFields = [ ];

        const fileFields = [ ];

        const allowedKeys = [
            'subscription_start',
            'subscription_end',
            'subscription_length',
            'subscription_type',
            'subscription_amount',
            'remarks',
        ];

        const data = {
            ...organizer_settings,
            modules: organizer_settings.modules ? JSON.stringify(organizer_settings.modules) : null,
        };

        return buildFormDataFromObject(data, requiredFields, fileFields, allowedKeys);
    }

    async function storeComapnySettings(){
        organizerSettingsErrors.value = []

        let formData = setFormDataMainBanner();

        await axios.post('/saveOrganizerSettings',formData
        ).then(response => {
            resetFields()
        }).catch(error => {
            if(error.response && error.response.status == 422){
                organizerSettingsErrors.value = error.response.data.errors
            }
        });
    }

    return {
        organizer_settings,
        organizerSettingsErrors,
        getOrganizerSettings,
        storeComapnySettings,
       
    }
}