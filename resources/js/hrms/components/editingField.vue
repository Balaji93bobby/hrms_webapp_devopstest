<template>
    <div class="flex items-center my-2">
      <InputText
        v-if="!isEditing"
        type="text"
        v-model="item.alias_name"
        class="w-48 h-10 !bg-[#f0efef] !border-[rgb(246,246,246)] p-2"
        @blur="endEditing"
      />
      <span v-else @dblclick="startEditing">{{ item.alias_name }}</span>
    </div>
  </template>

  <script>
  import { ref } from 'vue';

  export default {
    props: {
      item: Object,
    },
    setup(props) {
      const isEditing = ref(false);

      const startEditing = () => {
        isEditing.value = true;
      };

      const endEditing = () => {
        isEditing.value = false;
      };

      return {
        isEditing,
        startEditing,
        endEditing,
      };
    },
  };
  </script>
