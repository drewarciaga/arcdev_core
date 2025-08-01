<script setup>
import useUtils from '@/Composables/useUtils.js'

defineProps({
    order: {
        default: null,
    },
});

const { numberWithCommas } = useUtils()

</script>
<template>
    <div class="w-full" v-if="order != null">
        <div class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2 text-sm">
                <div class="w-full">
                    <div class="flex w-full">
                        <div class="font-semibold w-44">Order No.:</div>
                        <div>{{ order.order_no }}</div>
                    </div>
                    <div class="flex w-full">
                        <div class="font-semibold w-44">Restaurant:</div>
                        <div>{{ order.restaurant_name }}</div>
                    </div>
                    <div class="flex w-full">
                        <div class="font-semibold w-44">Transaction Date:</div>
                        <div>{{ order.transaction_date }}</div>
                    </div>
                    <div class="flex w-full">
                        <div class="font-semibold w-44">Customer:</div>
                        <div>{{ order.customer_name }}</div>
                    </div>
                    <div class="flex w-full">
                        <div class="font-semibold w-44">Service Mode:</div>
                        <div>{{ order.service_mode_text }}</div>
                    </div>
                    
                    <div class="flex w-full">
                        <div class="font-semibold w-44">Receipt No.:</div>
                        <div>{{ order.receipt_no }}</div>
                    </div>
                    <div class="flex w-full">
                        <div class="font-semibold w-44">Remarks:</div>
                        <div>{{ order.remarks }}</div>
                    </div>
                    <div class="flex w-full">
                        <div class="font-semibold w-44">Encoder:</div>
                        <div>{{ order.order_encoder != null ? order.order_encoder.full_name : '' }}</div>
                    </div>
                    <div class="flex w-full">
                        <div class="font-semibold w-44">Status:</div>
                        <div>{{ order.status_text }}</div>
                    </div>
                </div>
                <div class="w-full">
                    <div class="flex w-full">
                        <div class="font-semibold w-44">Sub Total:</div>
                        <div>{{ '₱' + numberWithCommas(order.subtotal_amount) }}</div>
                    </div>
                    <div class="flex w-full">
                        <div class="font-semibold w-44">Service Charge:</div>
                        <div>
                        {{ order.service_charge_value != null ? '('+order.service_charge_value+'%) ₱' + numberWithCommas(order.service_charge_amount) : 'N/A' }}
                        </div>
                    </div>
                    <div class="flex w-full">
                        <div class="font-semibold w-44">Discount:</div>
                        <div>
                        {{ order.discount_value != null ? '('+order.discount_value+'%) ₱' + numberWithCommas(order.discount_amount) : 'N/A' }}
                        </div>
                    </div>
                    <div class="flex w-full">
                        <div class="font-semibold w-44">Total Amount:</div>
                        <div>{{ '₱' + numberWithCommas(order.total_amount) }}</div>
                    </div>
                    <div class="flex w-full">
                        <div class="font-semibold w-44">Amount Paid:</div>
                        <div>{{ '₱' + numberWithCommas(order.amount_paid) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>