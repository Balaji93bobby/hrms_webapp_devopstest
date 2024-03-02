import "primeflex/primeflex.css";
import "primevue/resources/themes/lara-light-blue/theme.css";
import "primevue/resources/primevue.min.css";
import "primeicons/primeicons.css";


import { createApp } from "vue";
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
import ColumnGroup from 'primevue/columngroup';
import Row from 'primevue/row';
import InputText from 'primevue/inputtext'
import Dialog from 'primevue/dialog'



const  offerResent= createApp(OfferLetterResent);
offerResent.use(PrimeVue, { ripple: true });
offerResent.use(ConfirmationService);
offerResent.use(ToastService);
offerResent.use(DialogService);
offerResent.directive('tooltip', Tooltip);
offerResent.directive('badge', BadgeDirective);
offerResent.directive('ripple', Ripple);
offerResent.directive('styleclass', StyleClass);
offerResent.directive('focustrap', FocusTrap);
offerResent.component('DataTable', DataTable);
offerResent.component('Column', Column);
offerResent.component('InputText', InputText)
offerResent.component('Dialog', Dialog)
offerResent.component('Button', Button)
offerResent.mount("#offerletter_resentTable");
