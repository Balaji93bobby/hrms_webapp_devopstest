import "primeflex/primeflex.css";
import "primevue/resources/themes/lara-light-blue/theme.css";
import "primevue/resources/primevue.min.css";
import "primeicons/primeicons.css";



import { createApp } from "vue";
import { createPinia } from "pinia";
import router from '../router'
import PrimeVue from "primevue/config";
import BadgeDirective from "primevue/badgedirective";
import BlockUI from 'primevue/blockui';
import Button from 'primevue/button';
import ConfirmationService from 'primevue/confirmationservice';
import DialogService from 'primevue/dialogservice'
import FocusTrap from 'primevue/focustrap';
import Ripple from 'primevue/ripple';
import StyleClass from 'primevue/styleclass';
import ToastService from 'primevue/toastservice';
import Tooltip from 'primevue/tooltip';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';     //optional for column grouping
import Row from 'primevue/row';
import InputText from 'primevue/inputtext'
import Dialog from 'primevue/dialog'

import OfferLetter from './offer_letter_generation.vue'


const app = createApp(OfferLetter);
const pinia=createPinia()

app.use(PrimeVue, { ripple: true });
app.use(router);
app.use(pinia)
app.use(ConfirmationService);
app.use(ToastService);
app.use(DialogService);
app.directive('tooltip', Tooltip);
app.directive('badge', BadgeDirective);
app.directive('ripple', Ripple);
app.directive('styleclass', StyleClass);
app.directive('focustrap', FocusTrap);
app.component('DataTable', DataTable);
app.component('Column', Column);
app.component('InputText', InputText)
app.component('Dialog',Dialog)
app.component('Button', Button)

app.mount("#OfferLetter");
