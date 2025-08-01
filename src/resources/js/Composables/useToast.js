import { createToast } from 'mosha-vue-toastify';

export default function useToast(){
    const toast = (message,type, timer = 2000) => {
        createToast(message, {
            type: type,
            position: 'top-right',
            timeout: timer,
            hideProgressBar: true,
            showIcon: true,
        })
    }

    return {
        toast
    }
}