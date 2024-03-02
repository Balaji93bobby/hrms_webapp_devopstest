<script setup>
    import { ref, onMounted } from 'vue'
    const counter = ref(0)

    onMounted(() => {
        console.log("Initial value of counter : "+counter.value);
    });

    function addCounter(){
        counter.value++;
        console.log("Counter value : "+counter.value);
    }

    function subCounter(){
        counter.value--;
        console.log("Counter value : "+counter.value);
    }

</script>
<template>
    <Card style="width: 25rem; margin-bottom: 2em; background-color: darkcyan;">
        <template #header>
            <img alt="user header" src="../../../../images/goals_assignment.png" style="width: 100px;height: 100px">
        </template>
        <template #title>
            Test Card Layout
        </template>
        <template #content>
                This is a test card layout... {{ counter }}
        </template>
        <template #footer>
            <Button icon="pi pi-check" @click="addCounter()" label="Add" />
            <Button icon="pi pi-check" @click="subCounter()" label="Sub" />
            <Button icon="pi pi-check" label="Save" />
            <Button icon="pi pi-times" label="Cancel" class="p-button-secondary" style="margin-left: .5em" />
        </template>
    </Card>
</template>
