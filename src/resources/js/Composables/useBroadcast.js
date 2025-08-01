import { ref } from 'vue'

export default function useBroadcast(){
    const broadCastErrors   = ref([])

    async function broadcastPosAddToCart(payload){
        broadCastErrors.value = []
        if(payload != null){
           
            const simplifiedItems = payload.order_items.map(item => ({
                price: item.price,
                quantity: item.quantity,
                thumbnail_url: item.thumbnail_url,
                total_price: item.total_price,
                name: item.name,
            }));

            const final_payload = {
                total_amount: payload.total_amount,
                /*order_total_amount: 1258,
                service_charge_amount: 125.80000000000001,
                service_charge_value: 10,
                service_mode: 0,
                service_mode_text: "Dine-in",
                vat_amount: 134.78571428571425,
                vat_exempt_sales: 0,
                vat_value: 12,
                vatable_sales: 1123.2142857142856,
                zero_rated_sales: 0,*/
                order_items: simplifiedItems
            }

            await axios.get('/broadcastPosAddToCart',{
                params: {
                    payload:           final_payload,
                
                }
            }).then(response => {
                //console.log('broadcastPosAddToCart')

            });
        }

    }

    return {
        broadcastPosAddToCart,
        broadCastErrors,
    }
}