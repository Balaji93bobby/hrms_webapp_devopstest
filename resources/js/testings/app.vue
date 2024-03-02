<template>
    <div class="carousel">
      <div class="carousel-items">
        <div v-for="(item, index) in items" :key="index" class="carousel-item" :class="{ active: currentIndex === index }">
          {{ item }}
        </div>
      </div>
      <button @click="changeSlide(-1)" class="change-button">Previous</button>
      <button @click="changeSlide(1)" class="change-button">Next</button>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';

  const items = ref(['Item 1', 'Item 2', 'Item 3', 'Item 4']);
  const currentIndex = ref(0);

  const changeSlide = (step) => {
    currentIndex.value = (currentIndex.value + step + items.length) % items.length;
  };
  </script>

  <style>
  .carousel {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .carousel-items {
    display: flex;
    overflow: hidden;
    width: 300px;
    margin-bottom: 16px;
  }

  .carousel-item {
    flex: 0 0 300px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #ccc;
    transition: transform 0.3s ease;
  }

  .carousel-item.active {
    transform: translateX(0);
  }

  .carousel-item:not(.active) {
    transform: translateX(-100%);
  }

  .change-button {
    margin: 0 4px;
  }
  </style>
