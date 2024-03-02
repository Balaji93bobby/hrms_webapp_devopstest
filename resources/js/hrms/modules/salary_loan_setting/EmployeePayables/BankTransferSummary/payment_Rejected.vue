<template>
    <div class="mt-[12px]">
        <DataTable  ref="dt" dataKey="user_code" :paginator="true" :rows="10"
        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
        :rowsPerPageOptions="[5, 10, 25]" :filters="filters"
        currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records"
        responsiveLayout="scroll" class="!min-w-full  !max-w-full" >
        <Column selectionMode="multiple" headerStyle="width: 1.5rem" ></Column>
        <Column field="name" header="Employees" style="min-width: 8rem"></Column>
        <Column field="loan_req_id" header="Loan Req ID" style="min-width: 8rem"></Column>
        <Column field="nature_of_payment" header="Nature of Payments" style="min-width: 8rem"></Column>
        <Column field="amt_borrow" header="Amount" style="min-width: 8rem"></Column>
        <Column field="loan_req_date" header="Initiate Date" style="min-width: 8rem"></Column>
        <Column field="bank" header="Bank Details" style="min-width: 8rem"></Column>
        <Column field="department_name" header="Download" style="min-width: 8rem"></Column>
        <Column field="department_name" header="Action" style="min-width: 8rem"></Column>
        </DataTable>
    </div>
</template>
<script setup>

</script>