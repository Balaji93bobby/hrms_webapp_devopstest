

// resent
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



// completed
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

// resent
const  offerDeleted= createApp(OfferLetterDelete);
offerDeleted.use(PrimeVue, { ripple: true });
offerDeleted.use(ConfirmationService);
offerDeleted.use(ToastService);
offerDeleted.use(DialogService);
offerDeleted.directive('tooltip', Tooltip);
offerDeleted.directive('badge', BadgeDirective);
offerDeleted.directive('ripple', Ripple);
offerDeleted.directive('styleclass', StyleClass);
offerDeleted.directive('focustrap', FocusTrap);
offerDeleted.component('DataTable', DataTable);
offerDeleted.component('Column', Column);
offerDeleted.component('InputText', InputText)
offerDeleted.component('Dialog', Dialog)
offerDeleted.component('Button', Button)
offerDeleted.mount("#deleted_offerletter");
