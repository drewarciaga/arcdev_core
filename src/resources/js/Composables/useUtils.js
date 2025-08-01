import { ref } from 'vue'

export default function useUtils(){
    const app_version     = ref('1.0.1')
    const app_copyright   = ref('2025')

    const txn_status_list = ref([
        { value:0, label: 'Pending'},
        { value:1, label: 'Approved' },
        { value:2, label: 'Rejected' },
        { value:3, label: 'Canceled' },
        { value:4, label: 'On Hold' },
        { value:5, label: 'Started' },
        { value:6, label: 'Finished' },
        { value:7, label: 'Closed' },
    ]);

    const condition_list = ref([
        { value: 0, label: 'MISB'},
        { value: 1, label: 'MOC'},
        { value: 2, label: 'MIB'},
        { value: 3, label: 'BIB'},
        { value: 4, label: 'KLB'},
        { value: 5, label: 'Unbuilt'},
        { value: 6, label: 'Built'},
        { value: 7, label: 'Loose'},
        { value: 8, label: 'Loose - Incomplete'},
        { value: 9, label: 'Loose - Complete'},
    ])

    const my_collections_status_list = ref([
        { value: 0, label: 'Incomplete'},
        { value: 1, label: 'Complete'},
    ])

    const social_media_list = ref([
        { value: 0, label: 'Facebook'},
        { value: 1, label: 'Instagram'},
        { value: 2, label: 'TikTok'},
        { value: 3, label: 'Youtube'},
        { value: 4, label: 'Pinterest'},
        { value: 5, label: 'X/Twitter'},
    ])

    const active_list = ref([
        { value:1, label: 'Active' },
        { value:0, label: 'Inactive' },
    ]);

    const civil_status_list = ref([
        { value:0, label: 'Single' },
        { value:1, label: 'Married' },
    ]);

    const gender_list = ref([
        { value:'M', label: 'Male' },
        { value:'F', label: 'Female' },
    ]);
    
    function decimalOnly ($event) {
        let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
        if(keyCode == 13){ //enter key
            //allow submit
        }else if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
            $event.preventDefault();
        }
    }

    function numberOnly ($event) {
        let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
        if(keyCode == 13){ //enter key
            //allow submit
        }else if (keyCode < 48 || keyCode > 57) {
            $event.preventDefault();
        }
    }

    function numberWithCommas(x) {
        if(x != null){
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }else{
            return ""
        }
    }

    function isNumeric(value) {
        return !isNaN(parseFloat(value)) && isFinite(value);
    }

    const positions_list = ref([
        { value:0, label: 'Owner' },
        { value:1, label: 'Manager' },
        { value:2, label: 'Chef' },
        { value:3, label: 'Cook' },
        { value:4, label: 'Cashier' },
        { value:5, label: 'Staff' },
        { value:6, label: 'Waiter' },
        { value:7, label: 'Dish Washer' },
        { value:8, label: 'Janitor' },
        { value:9, label: 'Delivery Man' },
        { value:10, label: 'Barista' },
    ]);

    const employment_status_list = ref([
        { value:0, label: 'Hired'},
        { value:1, label: 'Resigned' },
        { value:2, label: 'Suspended' },
        { value:3, label: 'AWOL' },
        { value:4, label: 'Dismissed' },
        { value:5, label: 'End of Contract' },
        { value:6, label: 'OJT' },
    ]);

    const uom_list = ref([
        { value:0, label: 'g (gram)'},
        { value:1, label: 'kg (kilogram)' },
        { value:2, label: 'L (liter)' },
        { value:3, label: 'mL (milliliter)' },
        { value:4, label: 'gal (gallon)' },
        { value:5, label: 'oz (ounce)' },
        { value:6, label: 'lb (pound)' },
        { value:7, label: 'Per Piece' },
        { value:8, label: 'Per Pack' },
        { value:9, label: 'Per Box' },
        { value:10, label: 'Per Bottle' },
        { value:11, label: 'Tablespoon' },
        { value:12, label: 'Teaspoon' },
    ]);

    const editorOptions = {
        theme: 'snow',  // You can choose 'snow', 'bubble', or custom theme
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'], // Enable bold, italic, and underline
            ],
        },
        placeholder: 'Description',
    };

    const payment_method_list = ref([
        { value:0, label: 'Cash'},
        { value:1, label: 'Credit/Debit Card' },
        { value:2, label: 'E-Wallet' },
        { value:3, label: 'Bank Transfer' },
        { value:4, label: 'Online Payment Gateways' },
        { value:5, label: 'Loyalty Points' },
        { value:6, label: 'Voucher' },
    ]);

    const e_wallet_list = ref([
        { value:0, label: 'GCash'},
        { value:1, label: 'Maya' },
        { value:2, label: 'GrabPay' },
        { value:3, label: 'ShopeePay' },
    ]);

    const bank_list = ref([
        { value:0, label: 'AUB'},
        { value:1, label: 'BDO' },
        { value:2, label: 'BPI' },
        { value:3, label: 'Metrobank' },
        { value:4, label: 'Union Bank' },
    ]);

    const subscription_type_list = ref([
        { value: 0, label: 'Basic Tablet'},
        { value: 1, label: 'Premium Tablet'},
        { value: 2, label: 'Basic PC'},
        { value: 3, label: 'Premium PC'},
        { value: 4, label: 'Basic Dual Tablet'},
        { value: 5, label: 'Basic Dual PC'},
        { value: 6, label: 'Premium Dual Tablet'},
        { value: 7, label: 'Premium Dual PC'},
    ])

    const vat_type_list = ref([
        { value:0, label: 'No VAT'},
        { value:1, label: 'VAT Inclusive' },
        { value:2, label: 'VAT Exclusive' },
    ]);

    const salary_type_list = ref([
        { value:0, label: 'Hourly' },
        { value:1, label: 'Daily' },
        { value:2, label: 'Fixed Rate' },
    ]);

    const daily_shift_type_list = ref([
        { value:'AM', label: 'AM' },
        { value:'PM', label: 'PM' },
    ]);

    const expense_status_list = ref([
        { value:0, label: 'Pending' },
        { value:1, label: 'Approved' },
        { value:2, label: 'Issued' },
        { value:3, label: 'Rejected' },
    ]);

    const spoilage_type_list = ref([
        { value:0, label: 'Cancelled Order' },
        { value:1, label: 'Cooking Process' },
        { value:2, label: 'Expired' },
        { value:3, label: 'Inventory Correction' },
        { value:4, label: 'Others' },
    ]);
    
    function appendIfValid(formData, key, value, isFile = false) {
        if (value != null) {
            if (isFile && value.name != null) {
                formData.append(key, value, value.name);
            } else {
                formData.append(key, value);
            }
        }
    }

    function buildFormDataFromObject(obj, requiredFields = [], fileFields = [], allowedKeys = []) {
        const formData = new FormData();

        // Always-required fields
        requiredFields.forEach(key => {
            formData.append(key, obj[key]);
        });

        const keysToCheck = allowedKeys.length ? allowedKeys : Object.keys(obj);

        // Optional fields
        keysToCheck.forEach(key => {
            if (!requiredFields.includes(key)) {
                appendIfValid(formData, key, obj[key], fileFields.includes(key));
            }
        });

        return formData;
    }

    return {
        app_version,
        app_copyright,
        decimalOnly,
        numberOnly,
        condition_list,
        numberWithCommas,
        my_collections_status_list,
        social_media_list,
        active_list,
        civil_status_list,
        gender_list,
        txn_status_list,
        positions_list,
        employment_status_list,
        uom_list,
        editorOptions,
        payment_method_list,
        e_wallet_list,
        isNumeric,
        bank_list,
        subscription_type_list,
        vat_type_list,
        salary_type_list,
        daily_shift_type_list,
        expense_status_list,
        buildFormDataFromObject,
        spoilage_type_list
    }

}