import "primevue/resources/themes/lara-light-blue/theme.css";
import "primevue/resources/primevue.min.css";
import "primeicons/primeicons.css";
import '../../assests/tailwind.css'


import { createApp } from "vue";
import { createPinia } from "pinia";
import PrimeVue from "primevue/config";
import BadgeDirective from "primevue/badgedirective";
import Button from 'primevue/button';
import FocusTrap from 'primevue/focustrap';
import Ripple from 'primevue/ripple';
import StyleClass from 'primevue/styleclass';
import Tooltip from 'primevue/tooltip';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ConfirmDialog from 'primevue/confirmdialog';
import DialogService from 'primevue/dialogservice';
import Toast from 'primevue/toast';
import Dialog from 'primevue/dialog';
import Dropdown from 'primevue/dropdown';
import ConfirmationService from 'primevue/confirmationservice';
import ToastService from 'primevue/toastservice';
import ProgressSpinner from 'primevue/progressspinner';
import InputText from 'primevue/inputtext'
import Row from 'primevue/row'
import ColumnGroup from 'primevue/columngroup'
import InputNumber from 'primevue/inputnumber'
import FileUpload from 'primevue/fileupload';
import Calendar from 'primevue/calendar'
import Textarea from 'primevue/textarea'
import Chips from 'primevue/chips';

import OverlayPanel from 'primevue/overlaypanel';




import  employee_reimbursement from './EmployeeReimbursements.vue'



const app = createApp(employee_reimbursement);
const pinia=createPinia()

app.use(PrimeVue, { ripple: true });
app.use(ConfirmationService);
app.use(ToastService);
app.use(DialogService);
app.use(pinia)


app.directive('tooltip', Tooltip);
app.directive('badge', BadgeDirective);
app.directive('ripple', Ripple);
app.directive('styleclass', StyleClass);
app.directive('focustrap', FocusTrap);

app.component('Button', Button);
app.component('DataTable', DataTable);
app.component('Column', Column);
app.component('ColumnGroup', ColumnGroup)
app.component('Row', Row)
app.component('Toast', Toast);
app.component('OverlayPanel', OverlayPanel);
app.component('ConfirmDialog',ConfirmDialog);
app.component('Dropdown',Dropdown);
app.component('InputText', InputText);
app.component('Dialog', Dialog);
app.component('ProgressSpinner', ProgressSpinner)
app.component('Calendar', Calendar)
app.component('Textarea', Textarea)
app.component('Chips', Chips)
app.component('InputNumber', InputNumber)

app.mount("#vjs_employee_reimbursement");

