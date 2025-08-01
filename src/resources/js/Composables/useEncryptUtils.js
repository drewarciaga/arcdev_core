import CryptoJS from 'crypto-es'
import { ref } from 'vue'

const Sha256     = ref(CryptoJS.SHA256);
const Hex        = ref(CryptoJS.enc.Hex);
const Utf8       = ref(CryptoJS.enc.Utf8);
const Base64     = ref(CryptoJS.enc.Base64);
const AES        = ref(CryptoJS.AES);
const secret_key = ref(import.meta.env.VITE_HASHIDS_SALT);
const secret_iv  = ref(import.meta.env.VITE_SECRET_IV);

export default function useEncryptUtils(){
    const decryptedResponse = ref([])

    async function decryptJsonResponseData(reseponseData){
        let key = Sha256.value(secret_key.value).toString(Hex.value).substr(0, 32); 
        let iv = Sha256.value(secret_iv.value).toString(Hex.value).substr(0, 16);

        // Decryption
        let decrypted = AES.value.decrypt(reseponseData, Utf8.value.parse(key), {
            iv: Utf8.value.parse(iv),
        }).toString(Utf8.value);

        if(decrypted != null && decrypted != ''){
            decryptedResponse.value = JSON.parse(decrypted)
        }
    }

    return {
        decryptJsonResponseData,
        decryptedResponse,
    }
}