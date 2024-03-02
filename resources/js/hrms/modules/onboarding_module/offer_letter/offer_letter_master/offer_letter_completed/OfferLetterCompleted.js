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
import ColumnGroup from 'primevue/columngroup';     //optional for column grouping
import Row from 'primevue/row';
import InputText from 'primevue/inputtext'
import Dialog from 'primevue/dialog'





const  offerComplete= createApp(OfferLetterCompleted);
offerComplete.use(PrimeVue, { ripple: true });
offerComplete.use(ConfirmationService);
offerComplete.use(ToastService);
offerComplete.use(DialogService);
offerComplete.directive('tooltip', Tooltip);
offerComplete.directive('badge', BadgeDirective);
offerComplete.directive('ripple', Ripple);
offerComplete.directive('styleclass', StyleClass);
offerComplete.directive('focustrap', FocusTrap);
offerComplete.component('DataTable', DataTable);
offerComplete.component('Column', Column);
offerComplete.component('InputText', InputText)
offerComplete.component('Dialog', Dialog)
offerComplete.component('Button', Button)

offerComplete.mount("#offerletter_completedTable");
