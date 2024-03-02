<template>
    <!-- <Template1 /> -->
    <!-- <div id="app" ref="document">
      <div id="element-to-convert">
       <Template1 />
      </div>
      <button @click="exportToPDF">Export to PDF</button>
    </div> -->

    <VueHtml2pdf
        :show-layout="false"
        :float-layout="true"
        :enable-download="true"
        :preview-modal="true"
        :paginate-elements-by-height="1400"
        filename="hee hee"
        :pdf-quality="4"
        :manual-pagination="false"
        pdf-format="a4"
        pdf-orientation="landscape"
        pdf-content-width="100%"

        @progress="onProgress($event)"
        @hasStartedGeneration="hasStartedGeneration()"
        @hasGenerated="hasGenerated($event)"
        ref="html2Pdf"
    >
        <template #pdf-content>
            <!-- PDF Content Here -->
        <Template1 />
        </template>
    </VueHtml2pdf>
    <button @click="generateReport">Export to PDF</button>

  </template>
  
  <script setup>
import Template1 from './templates/template1.vue'
  import VueHtml2pdf from 'vue3-html2pdf'
import { ref } from 'vue'

 const html2Pdf = ref()

  function generateReport () {
    html2Pdf.value.generatePdf()
     
        }

    
 
  </script>
  
  <style>  </style>