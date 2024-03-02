<template>
          <LoadingSpinner v-if="ManageWelcomeMailStatusStore.loading"  class="absolute z-50 bg-white w-[100%] h-[100%]"/>
    <div class="w-full p-2">
        <h6 class="my-2 text-lg font-semibold">Manage WelcomeMail Status</h6>

        <div class="my-4 table-responsive">
            <DataTable :value="ManageWelcomeMailStatusStore.array_employees_list" :paginator="true" :rows="10" dataKey="id"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records" responsiveLayout="scroll"
                v-model:filters="filters" filterDisplay="menu" :loading="loading2" :globalFilterFields="['name', 'status']">
                <Column headerStyle="width: 3rem"></Column>
                <Column field="empcode" header="Employee code" headerStyle="width: 3rem">
                </Column>
                <Column field="empname" header="Employee Name"></Column>
                <Column field="personal mail" header="Personal Mail"></Column>
                <Column field="welcome_mail_status" header="Welcome Mail Status">
                    <template #body="slotProps">
                        <div>
                            <Button @click="showConfirmationDialog(slotProps.data.empcode)" label="Send mail"
                                class="btn btn-primary" />
                            <br />

                            <h4 v-if="slotProps.data.welcome_mail_status == null">Mail Not Sent</h4>
                            <h4 v-else class="text-green-500 "> Sent</h4>
                        </div>
                    </template>
                </Column>
                <Column field="onboard_docs_approval_mail_status" header="Onboard Document Approval Mail Status">
                    <template #body="slotProps">
                        <h1 v-if="slotProps.data.value == null || slotProps.data == 0"
                            v-tooltip="'Normally, mail is sent when docs are reviewed'">Mail Not Sent</h1>
                        <h1 v-if="slotProps.data.value == 1">Mail Sent</h1>
                    </template>

                    <!-- onboard_docs_approval_mail_status -->
                </Column>
                <!-- <Column field="" header="Mail Status">  </Column> -->
                <Column field="acc_activation_mail_status" header="Activation Mail Status">
                    <template #body="slotProps">
                        <h1 v-if="slotProps.data.value == null || slotProps.data == 0"
                            v-tooltip="'Normally, mail is sent once onboarding is done'">Mail Not Sent</h1>
                        <h1 v-if="slotProps.data.value == 1">Mail Sent</h1>
                    </template>
                </Column>

            </DataTable>
        </div>

        <Dialog header="Confirmation" v-model:visible="ManageWelcomeMailStatusStore.sendWelcomeMail_Status_diaconfirmation"
            :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '350px' }" :modal="true">
            <div class="confirmation-content">

                <i class="mr-3 pi pi-exclamation-triangle" style="font-size: 2rem" />
                <span>Are you sure you want to send Welcome Mail?</span>
            </div>

            <div class="d-flex mt-11 " style="position: relative; right: -180px; width: 140px;">

                <Button class="py-2 mr-3 btn-primary" label="Yes" icon="pi pi-check"
                    @click="ManageWelcomeMailStatusStore.send_WelcomeMail(selectedUserCode)" autofocus />
                <Button label="No" icon="pi pi-times"
                    @click="ManageWelcomeMailStatusStore.sendWelcomeMail_Status_diaconfirmation = false"
                    class="py-2 p-button-text" autofocus />

            </div>

        </Dialog>
    </div>
</template>

<script setup>
import { ref, onMounted, reactive, computed } from "vue";
import { useManageWelcomeMailStatusStore } from './ManageWelcomeMailStatusService';
import LoadingSpinner from "../../../components/LoadingSpinner.vue";

const ManageWelcomeMailStatusStore = useManageWelcomeMailStatusStore();


const selectedUserCode = ref();


onMounted(() => {
    ManageWelcomeMailStatusStore.getManageWelcomeMailStatus()

});

function showConfirmationDialog(selected_user_code) {
    selectedUserCode.value = selected_user_code;
    console.log(selected_user_code);
    ManageWelcomeMailStatusStore.sendWelcomeMail_Status_diaconfirmation = true;

}



</script>

<style lang="scss">
.p-dialog-mask .p-component-overlay .p-component-overlay-enter {
    z-index: 0 !important;
}
</style>
