<template>
  <h1 class="font-[poppins] text-[18px] font-semibold text-[#000]">
    Resignation Approval
  </h1>

  <div class="flex justify-between mt-2">
    <ul
      class="divide-x nav nav-pills divide-solid nav-tabs-dashed mb-3 border-b-[3px] border-gray-300"
      role="presentation"
    >
      <li class="nav-item" role="presentation">
        <a
          class="px-2 position-relati3e !border-none font-['poppins'] text-[12px] text-[#001820]"
          id=""
          data-bs-toggle="pill"
          href=""
          role="tab"
          aria-controls=""
          aria-selected="true"
          @click="activeTab = 1"
          :class="[
            activeTab === 1 ? ' font-semibold' : 'font-medium !text-[#8B8B8B]',
          ]"
        >
          PENDING
          <!-- <span class="relative left-[60px] top-[-25px] flex h-3 w-3 !z-10"> -->
          <!-- :class="useStore.selfDashboardPublishedFormList ? useHelper.filterSelfAppraisalPendingStatusSource(useStore.selfDashboardPublishedFormList, '', 1).length > 0 ? '' : 'hidden' : 'hidden'"> -->
          <!-- <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                        </span> -->
        </a>
        <div
          v-if="activeTab === 1"
          class="relative h-1 rounded-l-3xl top-1"
          style="border: 2px solid #f9be00 !important"
        ></div>
      </li>
      <li class="nav-item" role="presentation">
        <a
          class="px-2 position-relative border-none font-['poppins'] text-[12px] text-[#001820]"
          id=""
          data-bs-toggle="pill"
          href=""
          role="tab"
          aria-controls=""
          aria-selected="true"
          @click="activeTab = 2"
          :class="[
            activeTab === 2 ? ' font-semibold' : 'font-medium !text-[#8B8B8B]',
          ]"
        >
          APPROVED
        </a>
        <div
          v-if="activeTab === 2"
          class="relative h-1 rounded-l-3xl top-1"
          style="border: 2px solid #f9be00 !important"
        ></div>
      </li>
      <li class="border-0 nav-item position-relative" role="presentation">
        <a
          class="text-center px-3 border-0 font-['poppins'] text-[12px] text-[#001820]"
          id=""
          data-bs-toggle="pill"
          href=""
          @click="activeTab = 3"
          :class="[
            activeTab === 3 ? ' font-semibold' : 'font-medium !text-[#8B8B8B]',
          ]"
          role="tab"
          aria-controls=""
          aria-selected="true"
        >
          REJECTED
        </a>
        <div
          v-if="activeTab === 3"
          class="h-1 relative top-1 bottom-[1px] left-0 w-[100%]"
          style="border: 2px solid #f9be00 !important"
        ></div>
      </li>
    </ul>
  </div>
  <div>

    <!-- Resignation Approval--Pending -->

    <div v-if="activeTab === 1">
      <div class="">
        <div class="flex">
          <p class="col-span-2 font-[poppins] font-medium text-[14px]">
            RESIGNATION APPROVAL
          </p>

          <div class="flex justify-end items-end gap-2">
            <span class="p-input-icon-left">
              <i class="pi pi-search" />
              <InputText
                class="pl-[30px] font-[poppins] text-[12px] text-[#001820] font-medium w-[211px]"
                v-model="value1"
                placeholder="Search"
              />
            </span>
            <span>
              <button
                class="flex p-2 gap-1 bg-[#E6E6E6] text-[14px] font-[poppins] font-medium rounded"
              >
                <i class="pi pi-download mt-1" />
                Download
              </button>
            </span>
            <span>
              <button
                class="font-[poppins] rounded text-[14px] bg-[#0873CD] text-[#fff] p-2 w-[99px]"
              >
                Approve
              </button>
            </span>
            <span>
              <button
                class="font-[poppins] rounded text-[14px] bg-[#E6E6E6] text-[#000] p-2 w-[84px]"
              >
                Reject
              </button>
            </span>
          </div>
        </div>
        <div class="grid grid-cols-6">
          <div class="card mt-2 col-span-6">
            <DataTable
              v-model:selection="selectedPending"
              :value="data"
              dataKey="id"
              tableStyle="min-width: 100%"
            >
              <Column
                selectionMode="multiple"
                headerStyle="width: 3rem"
              ></Column>
              <Column
                class="text-[12px] text-[#001820] font-semibold font-[poppins]"
                field="name"
                header="Employee"
              >
                <template #body="slotProps">
                  <p
                    class="flex flex-col justify-start items-start font-medium text-[16px] text-[#001820]"
                  >
                    {{ slotProps.data.name }}
                    <span class="text-[#535353] text-[12px]">{{
                      slotProps.data.emp_code
                    }}</span>
                  </p>
                </template>
              </Column>
              <Column
                class="text-[12px] text-[#001820] font-semibold font-[poppins]"
                field="resign_date"
                header="Date of Resignation Initiated"
              >
                <template>
                  <p class="text-[14px] font-medium">
                    {{ resign_date }}
                  </p>
                </template>
              </Column>
              <Column
                class="text-[12px] text-[#001820] font-semibold font-[poppins]"
                field="type"
                header="Resignation Type"
              >
                <template>
                  <p class="text-[14px] font-medium">
                    {{ type }}
                  </p>
                </template>
              </Column>
              <Column
                class="text-[12px] text-[#001820] font-semibold font-[poppins]"
                field="notice_date"
                header="Notice Period Date"
              >
                <template>
                  <p class="text-[14px] font-medium">
                    {{ notice_date }}
                  </p>
                </template>
              </Column>
              <Column
                class="text-[12px] text-[#001820] font-semibold font-[poppins]"
                field="expected_date"
                header="Expected Last Working Day"
              >
                <template>
                  <p class="text-[14px] font-medium">
                    {{ expected_date }}
                  </p>
                </template>
              </Column>
              <Column
                class="text-[12px] text-[#001820] font-semibold font-[poppins]"
                field="payroll_date"
                header="Payroll Processed Date"
              >
                <template>
                  <p class="text-[14px] font-medium">
                    {{ payroll_date }}
                  </p>
                </template>
              </Column>
              <Column
                class="text-[12px] text-[#001820] font-semibold font-[poppins]"
                field="asset"
                header="Asset Allocated"
              >
                <template>
                  <p class="text-[14px] font-medium">
                    {{ asset }}
                  </p>
                </template>
              </Column>
              <Column
                class="text-[12px] text-[#001820] font-semibold font-[poppins]"
                field=""
                header="Actions"
              >
                <template #body="">
                  <i
                    class="pi pi-ellipsis-h text-[#001820] cursor-pointer"
                    @click="toggle"
                  />
                  <OverlayPanel ref="op">
                    <div
                      class="flex flex-col justify-center items-center p-0 m-0"
                    >
                      <button
                        class="p-2 font-[poppins] text-[14px] border-[1px] border-[#DDDDDD] w-[100%]"
                      >
                        Approve
                      </button>
                      <button
                        class="p-2 font-[poppins] text-[14px] border-[1px] border-[#DDDDDD] w-[100%]"
                      >
                        Reject
                      </button>
                      <button
                        class="p-2 font-[poppins] text-[14px] border-[1px] border-[#DDDDDD] w-[100%]"
                        @click="visibleRight = true"
                      >
                        Allocate task
                      </button>
                    </div>
                  </OverlayPanel>
                </template>
              </Column>
            </DataTable>
            <Sidebar
              v-model:visible="visibleRight"
              position="right"
              class="!w-[30%]"
            >
              <template #header>
                <div
                  class="bg-[#000] text-[#fff] w-[100%] h-[60px] absolute top-0 left-0"
                >
                  <h1 class="m-4 text-[#ffff] font-['poppins] font-semibold">
                    Task Allocation
                  </h1>
                </div>
              </template>
              <div class="border-box p-3">
                <div class="grid grid-cols-6">
                  <div class="col-span-6 mx-2">
                    <label
                      class="font-[poppins] text-[14px] font-medium text-[#000]"
                      >Employee Code</label
                    ><br />
                    <!-- <div class="col-span-6"> -->
                    <div class="col-span-6 my-2 relative !w-[100%]">
                      <i class="pi pi-search absolute p-3 pt-3" />
                      <InputText
                        class="col-span-6 font-[poppins] text-[14px] text-[#8B8B8B] !w-[100%] font-medium h-[36px] border-[1px] border-[#BBBBBB] pl-9"
                        v-model="value"
                        placeholder="Search"
                      />
                    </div>
                    <!-- </div> -->
                  </div>

                  <div class="col-span-6 mx-2 my-2">
                    <label
                      class="font-[poppins] text-[14px] font-medium text-[#000]"
                      >Choose Department</label
                    >
                    <Dropdown
                      v-model="selectedDepartment"
                      :options="resignation_type"
                      showClear
                      optionLabel="department"
                      class="w-[100%] my-2 text-[#8B8B8B] font-[poppins] text-[14px] h-[36px] border-[1px] border-[#BBBBBB]"
                      placeholder="Choose Resignation type"
                    />
                  </div>
                  <div class="col-span-6 mx-2">
                    <label
                      class="font-[poppins] text-[14px] font-medium text-[#000]"
                      >Employee Name</label
                    >
                    <InputText
                      class="col-span-6 font-[poppins] text-[14px] text-[#8B8B8B] font-medium w-[100%] my-2 p-2 border-[1px] border-[#BBBBBB] h-[35px]"
                      v-model="value1"
                      placeholder="Enter Employee Name"
                    />
                  </div>
                  <div
                    class="col-span-6 gap-2 flex justify-center items-center my-4"
                  >
                    <!-- <button class="border-[1px] text-[#001820] bg-[#fff] border-[#001820] rounded p-1 w-[15%] font-[poppins] text-[14px]">Save</button> -->
                    <button
                      class="border-[1px] bg-[#001820] text-[#fff] border-[#001820] rounded p-1 w-[20%] font-[poppins] text-[14px]"
                    >
                      Confirm
                    </button>
                  </div>
                </div>
              </div>
            </Sidebar>
          </div>
        </div>
      </div>
    </div>

    <!-- Resignation Approval--Approved -->

    <div v-if="activeTab === 2">
      <div class="">
        <div class="flex">
          <p class="col-span-2 font-[poppins] font-medium text-[14px]">
            RESIGNATION APPROVAL
          </p>
          <div class="flex justify-end items-end gap-2">
            <span class="p-input-icon-left">
              <i class="pi pi-search" />
              <InputText
                class="pl-[30px] font-[poppins] text-[12px] text-[#001820] font-medium w-[211px]"
                v-model="value1"
                placeholder="Search"
              />
            </span>
            <span>
              <button
                class="flex p-2 gap-1 bg-[#E6E6E6] text-[14px] font-[poppins] font-medium rounded"
              >
                <i class="pi pi-download mt-1" />
                Download
              </button>
            </span>
            <!-- <span>
    <button class="font-[poppins] rounded text-[14px] bg-[#0873CD] text-[#fff] p-2 w-[99px]">Approve</button>
</span>
<span>
    <button class="font-[poppins] rounded text-[14px] bg-[#E6E6E6] text-[#000] p-2 w-[84px]" >Reject</button>
</span> -->
          </div>
        </div>
        <div class="grid grid-cols-6">
          <div class="card mt-2 col-span-6">
            <DataTable
              v-model:selection="selectedPending"
              :value="data"
              dataKey="id"
              tableStyle="min-width: 100%"
            >
              <Column
                selectionMode="multiple"
                headerStyle="width: 3rem"
              ></Column>
              <Column
                class="text-[12px] text-[#001820] font-semibold font-[poppins]"
                field="name"
                header="Employee"
              >
                <template #body="slotProps">
                  <p
                    class="flex flex-col justify-start items-start font-medium text-[16px] text-[#001820]"
                  >
                    {{ slotProps.data.name }}
                    <span class="text-[#535353] text-[12px]">{{
                      slotProps.data.emp_code
                    }}</span>
                  </p>
                </template>
              </Column>
              <Column
                class="text-[12px] text-[#001820] font-semibold font-[poppins]"
                field="resign_date"
                header="Date of Resignation Initiated"
              >
                <template>
                  <p class="text-[14px] font-medium">
                    {{ resign_date }}
                  </p>
                </template>
              </Column>
              <Column
                class="text-[12px] text-[#001820] font-semibold font-[poppins]"
                field="type"
                header="Resignation Type"
              >
                <template>
                  <p class="text-[14px] font-medium">
                    {{ type }}
                  </p>
                </template>
              </Column>
              <Column
                class="text-[12px] text-[#001820] font-semibold font-[poppins]"
                field="notice_date"
                header="Notice Period Date"
              >
                <template>
                  <p class="text-[14px] font-medium">
                    {{ notice_date }}
                  </p>
                </template>
              </Column>
              <Column
                class="text-[12px] text-[#001820] font-semibold font-[poppins]"
                field="expected_date"
                header="Expected Last Working Day"
              >
                <template>
                  <p class="text-[14px] font-medium">
                    {{ expected_date }}
                  </p>
                </template>
              </Column>
              <Column
                class="text-[12px] text-[#001820] font-semibold font-[poppins]"
                field="payroll_date"
                header="Payroll Processed Date"
              >
                <template>
                  <p class="text-[14px] font-medium">
                    {{ payroll_date }}
                  </p>
                </template>
              </Column>
              <Column
                class="text-[12px] text-[#001820] font-semibold font-[poppins]"
                field="asset"
                header="Asset Allocated"
              >
                <template>
                  <p class="text-[14px] font-medium">
                    {{ asset }}
                  </p>
                </template>
              </Column>
              <!-- <Column class="text-[12px] text-[#001820] font-semibold font-[poppins]" field="" header="Actions">
                <template #body="">
                    <i class="pi pi-ellipsis-h text-[#001820] cursor-pointer"  @click="toggle"/>
                    <OverlayPanel ref="op">
                        <div class="flex flex-col justify-center items-center p-0 m-0 ">
                            <button class="p-2 font-[poppins] text-[14px] border-[1px] border-[#DDDDDD] w-[100%]">Approve</button>
                        <button class="p-2 font-[poppins] text-[14px] border-[1px] border-[#DDDDDD] w-[100%]">Reject</button>
                        <button class="p-2 font-[poppins] text-[14px] border-[1px] border-[#DDDDDD] w-[100%]" @click="visibleRight = true">Allocate task</button>
                        </div>
                        
                    </OverlayPanel>
                    
                </template>
            </Column> -->
            </DataTable>
            <Sidebar
              v-model:visible="visibleRight"
              position="right"
              class="!w-[30%]"
            >
              <template #header>
                <div
                  class="bg-[#000] text-[#fff] w-[100%] h-[60px] absolute top-0 left-0"
                >
                  <h1 class="m-4 text-[#ffff] font-['poppins] font-semibold">
                    Task Allocation
                  </h1>
                </div>
              </template>
              <div class="border-box p-3">
                <div class="grid grid-cols-6">
                  <div class="col-span-6 mx-2">
                    <label
                      class="font-[poppins] text-[14px] font-medium text-[#000]"
                      >Employee Code</label
                    ><br />
                    <!-- <div class="col-span-6"> -->
                    <div class="col-span-6 my-2 relative !w-[100%]">
                      <i class="pi pi-search absolute p-3 pt-3" />
                      <InputText
                        class="col-span-6 font-[poppins] text-[14px] text-[#8B8B8B] !w-[100%] font-medium h-[36px] border-[1px] border-[#BBBBBB] pl-9"
                        v-model="value"
                        placeholder="Search"
                      />
                    </div>
                    <!-- </div> -->
                  </div>

                  <div class="col-span-6 mx-2 my-2">
                    <label
                      class="font-[poppins] text-[14px] font-medium text-[#000]"
                      >Choose Department</label
                    >
                    <Dropdown
                      v-model="selectedDepartment"
                      :options="resignation_type"
                      showClear
                      optionLabel="department"
                      class="w-[100%] my-2 text-[#8B8B8B] font-[poppins] text-[14px] h-[36px] border-[1px] border-[#BBBBBB]"
                      placeholder="Choose Resignation type"
                    />
                  </div>
                  <div class="col-span-6 mx-2">
                    <label
                      class="font-[poppins] text-[14px] font-medium text-[#000]"
                      >Employee Name</label
                    >
                    <InputText
                      class="col-span-6 font-[poppins] text-[14px] text-[#8B8B8B] font-medium w-[100%] my-2 p-2 border-[1px] border-[#BBBBBB] h-[35px]"
                      v-model="value1"
                      placeholder="Enter Employee Name"
                    />
                  </div>
                  <div
                    class="col-span-6 gap-2 flex justify-center items-center my-4"
                  >
                    <!-- <button class="border-[1px] text-[#001820] bg-[#fff] border-[#001820] rounded p-1 w-[15%] font-[poppins] text-[14px]">Save</button> -->
                    <button
                      class="border-[1px] bg-[#001820] text-[#fff] border-[#001820] rounded p-1 w-[20%] font-[poppins] text-[14px]"
                    >
                      Confirm
                    </button>
                  </div>
                </div>
              </div>
            </Sidebar>
          </div>
        </div>
      </div>
    </div>

    <!-- Resignation Approval--Rejected -->

    <div v-if="activeTab === 3">
      <div class="">
        <div class="flex">
          <p class="col-span-2 font-[poppins] font-medium text-[14px]">
            RESIGNATION APPROVAL
          </p>
          <div class="flex justify-end items-end gap-2">
            <span class="p-input-icon-left">
              <i class="pi pi-search" />
              <InputText
                class="pl-[30px] font-[poppins] text-[12px] text-[#001820] font-medium w-[211px]"
                v-model="value1"
                placeholder="Search"
              />
            </span>
            <span>
              <button
                class="flex p-2 gap-1 bg-[#E6E6E6] text-[14px] font-[poppins] font-medium rounded"
              >
                <i class="pi pi-download mt-1" />
                Download
              </button>
            </span>
            <!-- <span>
    <button class="font-[poppins] rounded text-[14px] bg-[#0873CD] text-[#fff] p-2 w-[99px]">Approve</button>
</span>
<span>
    <button class="font-[poppins] rounded text-[14px] bg-[#E6E6E6] text-[#000] p-2 w-[84px]" >Reject</button>
</span> -->
          </div>
        </div>
        <div class="grid grid-cols-6">
          <div class="card mt-2 col-span-6">
            <DataTable
              v-model:selection="selectedPending"
              :value="data"
              dataKey="id"
              tableStyle="min-width: 100%"
            >
              <Column
                selectionMode="multiple"
                headerStyle="width: 3rem"
              ></Column>
              <Column
                class="text-[12px] text-[#001820] font-semibold font-[poppins]"
                field="name"
                header="Employee"
              >
                <template #body="slotProps">
                  <p
                    class="flex flex-col justify-start items-start font-medium text-[16px] text-[#001820]"
                  >
                    {{ slotProps.data.name }}
                    <span class="text-[#535353] text-[12px]">{{
                      slotProps.data.emp_code
                    }}</span>
                  </p>
                </template>
              </Column>
              <Column
                class="text-[12px] text-[#001820] font-semibold font-[poppins]"
                field="resign_date"
                header="Date of Resignation Initiated"
              >
                <template>
                  <p class="text-[14px] font-medium">
                    {{ resign_date }}
                  </p>
                </template>
              </Column>
              <Column
                class="text-[12px] text-[#001820] font-semibold font-[poppins]"
                field="type"
                header="Resignation Type"
              >
                <template>
                  <p class="text-[14px] font-medium">
                    {{ type }}
                  </p>
                </template>
              </Column>
              <Column
                class="text-[12px] text-[#001820] font-semibold font-[poppins]"
                field="notice_date"
                header="Notice Period Date"
              >
                <template>
                  <p class="text-[14px] font-medium">
                    {{ notice_date }}
                  </p>
                </template>
              </Column>
              <Column
                class="text-[12px] text-[#001820] font-semibold font-[poppins]"
                field="expected_date"
                header="Expected Last Working Day"
              >
                <template>
                  <p class="text-[14px] font-medium">
                    {{ expected_date }}
                  </p>
                </template>
              </Column>
              <Column
                class="text-[12px] text-[#001820] font-semibold font-[poppins]"
                field="payroll_date"
                header="Payroll Processed Date"
              >
                <template>
                  <p class="text-[14px] font-medium">
                    {{ payroll_date }}
                  </p>
                </template>
              </Column>
              <Column
                class="text-[12px] text-[#001820] font-semibold font-[poppins]"
                field="asset"
                header="Asset Allocated"
              >
                <template>
                  <p class="text-[14px] font-medium">
                    {{ asset }}
                  </p>
                </template>
              </Column>
              <!-- <Column class="text-[12px] text-[#001820] font-semibold font-[poppins]" field="" header="Actions">
                <template #body="">
                    <i class="pi pi-ellipsis-h text-[#001820] cursor-pointer"  @click="toggle"/>
                    <OverlayPanel ref="op">
                        <div class="flex flex-col justify-center items-center p-0 m-0 ">
                            <button class="p-2 font-[poppins] text-[14px] border-[1px] border-[#DDDDDD] w-[100%]">Approve</button>
                        <button class="p-2 font-[poppins] text-[14px] border-[1px] border-[#DDDDDD] w-[100%]">Reject</button>
                        <button class="p-2 font-[poppins] text-[14px] border-[1px] border-[#DDDDDD] w-[100%]" @click="visibleRight = true">Allocate task</button>
                        </div>
                        
                    </OverlayPanel>
                    
                </template>
            </Column> -->
            </DataTable>

            <!-- Allocate task Sidebar -->
            <Sidebar
              v-model:visible="visibleRight"
              position="right"
              class="!w-[30%]"
            >
              <template #header>
                <div
                  class="bg-[#000] text-[#fff] w-[100%] h-[60px] absolute top-0 left-0"
                >
                  <h1 class="m-4 text-[#ffff] font-['poppins] font-semibold">
                    Task Allocation
                  </h1>
                </div>
              </template>
              <div class="border-box p-3">
                <div class="grid grid-cols-6">
                  <div class="col-span-6 mx-2">
                    <label
                      class="font-[poppins] text-[14px] font-medium text-[#000]"
                      >Employee Code</label
                    ><br />
                    <!-- <div class="col-span-6"> -->
                    <div class="col-span-6 my-2 relative !w-[100%]">
                      <i class="pi pi-search absolute p-3 pt-3" />
                      <InputText
                        class="col-span-6 font-[poppins] text-[14px] text-[#8B8B8B] !w-[100%] font-medium h-[36px] border-[1px] border-[#BBBBBB] pl-9"
                        v-model="value"
                        placeholder="Search"
                      />
                    </div>
                    <!-- </div> -->
                  </div>

                  <div class="col-span-6 mx-2 my-2">
                    <label
                      class="font-[poppins] text-[14px] font-medium text-[#000]"
                      >Choose Department</label
                    >
                    <Dropdown
                      v-model="selectedDepartment"
                      :options="resignation_type"
                      showClear
                      optionLabel="department"
                      class="w-[100%] my-2 text-[#8B8B8B] font-[poppins] text-[14px] h-[36px] border-[1px] border-[#BBBBBB]"
                      placeholder="Choose Resignation type"
                    />
                  </div>
                  <div class="col-span-6 mx-2">
                    <label
                      class="font-[poppins] text-[14px] font-medium text-[#000]"
                      >Employee Name</label
                    >
                    <InputText
                      class="col-span-6 font-[poppins] text-[14px] text-[#8B8B8B] font-medium w-[100%] my-2 p-2 border-[1px] border-[#BBBBBB] h-[35px]"
                      v-model="value1"
                      placeholder="Enter Employee Name"
                    />
                  </div>
                  <div
                    class="col-span-6 gap-2 flex justify-center items-center my-4"
                  >
                    <!-- <button class="border-[1px] text-[#001820] bg-[#fff] border-[#001820] rounded p-1 w-[15%] font-[poppins] text-[14px]">Save</button> -->
                    <button
                      class="border-[1px] bg-[#001820] text-[#fff] border-[#001820] rounded p-1 w-[20%] font-[poppins] text-[14px]"
                    >
                      Confirm
                    </button>
                  </div>
                </div>
              </div>
            </Sidebar>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";

const op = ref();

const toggle = (event) => {
  op.value.toggle(event);
};

const activeTab = ref(1);

const visibleRight = ref(false);

const data = ref([
  {
    id: 1,
    name: "Abcdef",
    emp_code: "AB123",
    resign_date: "01/01/2024",
    type: "Resignation type",
    notice_date: "01/01/2024",
    expected_date: "01/01/2024",
    payroll_date: "01/01/2024",
    asset: "Yes",
  },
]);
const selectedPending = ref();
</script>

<style>
.p-overlaypanel .p-overlaypanel-content {
  padding: 0 !important;
}

.p-inputtext {
  /* background: #BBBBBB; */
  font-family: poppins;
}
.p-dropdown-item {
  font-family: poppins;
  font-size: 14px;
  color: #001820;
}

.empcode {
  width: 100% !important;
  height: 35px !important;
}
</style>
