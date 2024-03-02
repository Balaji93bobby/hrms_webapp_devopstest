<template>

    <div class="h-full w-full  ">
        <div class="card-body d-flex justify-content-between align-items-center  py-2 mt-2  w-full" >

          <div class=" flex justify-start  w-full ">
            <!--  -->
            <div class="  ">
              <div class=" shadow-sm bg-white rounded-md  mr-2 h-[150px] w-[320px] 2xl:w-[383px] " >
                <div class=" h-[50px] px-2 d-flex align-items-center"  style="background-color: #fff" >
                    <p class=" fs-5 ">Bank Transfer</p>
                </div>
                <div class="flex justify-content-between align-items-start p-3 h-[135px] rounded-b-md" style="background-color: #E6E6E6;" >
                    <div>
                        <p class="text-[12px] md:text-[13px] xl:text-[16px]">Default Batch for Bank Transfer</p>
                        <p class="text-[12px] md:text-[13px] xl:text-[16px] text-gray-700 mt-2">188 Employees</p>
                    </div>
                    <div>
                        <button class="bg-gray-200 p-2 rounded-md shadow-md mt-2 w-[90px]  text-[12px]  xl:text-[13px] " >Not Paid</button>
                    </div>
                </div>
              </div>

              <div class=" bg-white shadow-sm p-3 mt-16 h-26  w-[320px] 2xl:w-[383px]">
                <p class="text-[14px]  xl:text-[16px] mb-2 font-semibold" >Salary to be Paid</p>
                <div class=" d-flex justify-content-between align-items-center  w-full">
                    <!-- <div class=" d-flex justify-content-between align-items-center "> -->
                        <p class="text-[13px]  xl:text-[14px]  text-left font-medium">Total Employees</p>
                    <p class=" text-right font-semibold">188</p>
                    <!-- </div> -->
                </div>
                <div class="border-b-2 w-full my-[16px]"></div>
                <div class="grid grid-cols-2 mt-2 ">
                  <p class=" text-[14px] font-medium" style="color:  #535353;" >Bank Transfer</p>
                  <p class=" text-[16px] text-right font-semibold">INR 6,40,800</p>
                  <p class=" text-gray col-span-3 text-center">+</p>
                  <p class=" text-[14px] font-medium" style="color:  #535353;" >Cash Payment</p>
                  <p class=" text-[16px] text-right font-semibold">INR 0</p>
                  <p class=" text-gray col-span-3 text-center">+</p>
                  <p class=" text-[14px] font-medium" style="color:  #535353;" >cheque Payments</p>
                  <p class=" text-[16px] text-right font-semibold">INR 0</p>
                  <p class=" text-gray col-span-3 text-center">=</p>
                  <p class=" text-[14px] font-medium" style="color:  #535353;" >Salaries to be Paid</p>
                  <p class=" text-[16px] text-right font-semibold">INR 1,15,40,800</p>
                </div>
            </div>

            </div>
            <!-- tableStyle="min-width: 20rem" -->
            <div class=" border ml-2 xl:w-[100%]   xxl:w-full" style="background-color: #E6E6E6; w-full">
              <!-- <div class=" rounded-md  ml-2 xl:w-[1000px]   xxl:w-full" style="background-color: #E6E6E6; w-full"> -->
                <DataTable ref="dt" dataKey="user_code" :paginator="true" :rows="10"
                                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                                :rowsPerPageOptions="[5, 10, 25]" :filters="filters"
                                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} Records"
                                responsiveLayout="scroll" class="!min-w-full  !max-w-full" >
                                <Column selectionMode="multiple" headerStyle="width: 1.5rem" ></Column>
                                <Column field="user_code" header="Bank Name" style="min-width: 8rem"></Column>
                                <Column field="user_code" header="Total Amount" style="min-width: 8rem"></Column>
                                <Column field="name" header="Employees" style="min-width: 8rem"></Column>
                                <Column field="department_name" header="Download" style="min-width: 8rem"></Column>
                            </DataTable>
            <!-- </div> -->

            </div>
          </div>

        </div>
    </div>
</template>
<style>

.p-multiselect-label,.p-placeholder{
 position: relative !important ;
  bottom: 2px !important; }

  .p-multiselect-trigger-icon , .pi-chevron-down{
    rotate: 270deg !important;
  }

</style>

<script setup>

</script>

<style lang="sass" scoped>


#btn-download
  cursor: pointer
  display: block
  width: 48px
  height: 48px
  border-radius: 50%
  -webkit-tap-highlight-color: transparent
  //transform: scale(2)
  //centering
  position: absolute
  top: calc(50% - 24px)
  left: calc(50% - 24px)
  &:hover
    background: rgba(#223254,.03)
  svg
    margin: 16px 0 0 16px
    fill: none
    transform: translate3d(0,0,0)
    polyline,
    path
      stroke: #0077FF
      stroke-width: 2
      stroke-linecap: round
      stroke-linejoin: round
      transition: all .3s ease
      transition-delay: .3s
    path#check
      stroke-dasharray: 38
      stroke-dashoffset: 114
      transition: all .4s ease
  &.downloaded
    svg
      .svg-out
        opacity: 0
        animation: drop .3s linear
        transition-delay: .4s
      path#check
        stroke: #20CCA5
        stroke-dashoffset: 174
        transition-delay: .4s

@keyframes drop
  20%
    transform: (translate(0, -3px))
  80%
    transform: (translate(0, 2px))
  95%
    transform: (translate(0, 0))

</style>
