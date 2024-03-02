
<template>
    <div class="card">
        <DataTable :value="vmt_holidays" editMode="row" dataKey="id" v-model:editingRows="editingRows" @row-edit-save="onRowEditSave" responsiveLayout="scroll">
            <Column field="id" header="id" style="width:20%">
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" autofocus />
                </template>
            </Column>
            <Column field="holiday_name" header="holiday_name" style="width:20%">
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" />
                </template>
            </Column>
            <Column field="holiday_description" header="holiday_description" style="width:20%">
                <template #editor="{ data, field }">
                    <Dropdown v-model="data[field]" :options="statuses" optionLabel="label" optionValue="value" placeholder="Select a Status">
                        <template #option="slotProps">
                            <span :class="'product-badge status-' + slotProps.option.value.toLowerCase()">{{slotProps.option.label}}</span>
                        </template>
                    </Dropdown>
                </template>
                <template #body="slotProps">
                    {{getStatusLabel(slotProps.data.inventoryStatus)}}
                </template>
            </Column>
            <Column field="holiday_date" header="holiday_date" style="width:20%">
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" />
                </template>
            </Column>
            <Column :rowEditor="true" style="width:10%; min-width:8rem" bodyStyle="text-align:center"></Column>
        </DataTable>
    </div>
    <!-- <h1 v-for="hol in vmt_holidays" :key="hol.id">{{hol}}</h1> -->
</template>

<script>
import axios from 'axios';
export default{
    data(){
        return{
            editingRows: [],
            vmt_holidays :'',
        }
    },
    methods: {
        onCellEditComplete(event) {
            let { data, newValue, field } = event;

            switch (field) {
                case 'quantity':
                case 'price':
                    if (this.isPositiveInteger(newValue))
                        data[field] = newValue;
                    else
                        event.preventDefault();
                break;

                default:
                    if (newValue.trim().length > 0)
                        data[field] = newValue;
                    else
                        event.preventDefault();
                break;
            }
        },
        isPositiveInteger(val) {
            let str = String(val);
            str = str.trim();
            if (!str) {
                return false;
            }
            str = str.replace(/^0+/, "") || "0";
            var n = Math.floor(Number(str));
            return n !== Infinity && String(n) === str && n >= 0;
        },
        onRowEditSave(event) {
            let { newData, index } = event;

            this.products2[index] = newData;
        },
        getStatusLabel(status) {
            switch(status) {
                case 'INSTOCK':
                    return 'In Stock';

                case 'LOWSTOCK':
                    return 'Low Stock';

                case 'OUTOFSTOCK':
                    return 'Out of Stock';

                default:
                    return 'NA';
            }
        }
    },
    created(){
        axios.get("/fetch-holidays").then((response)=>(this.vmt_holidays=response.data));
    }
};          

</script>