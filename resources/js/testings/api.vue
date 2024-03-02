<template></template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
const data = ref([]);
const loading = ref(true);

const fetchData = async () => {
    try {
        const response = await axios.get(`http://115.240.254.90:81/iclock/Main.aspx`);
        data.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchData();
});


</script>
