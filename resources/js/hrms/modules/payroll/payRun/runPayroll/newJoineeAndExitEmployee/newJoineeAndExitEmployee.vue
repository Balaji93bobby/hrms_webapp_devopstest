<template>
    <div class=" investments-wrapper">
        <div class="mb-2 shadow card left-line p-1">
            <div class="pt-1 pb-0 card-body">
                <ul class="divide-x nav nav-pills divide-solid nav-tabs-dashed" id="pills-tab" role="tablist">
                    <li class="mx-4 nav-item ember-view" role="presentation">
                        <a class="nav-link active ember-view " id="pills-home-tab" data-bs-toggle="pill" href=""
                            data-bs-target="#New" role="tab" aria-controls="pills-home" aria-selected="true">
                           1.New Joinees</a>
                    </li>
                    <li class=" nav-item ember-view" role="presentation">
                        <a class="mx-4 nav-link ember-view" id="pills-home-tab" data-bs-toggle="pill" href=""
                            data-bs-target="#Exit" role="tab" aria-controls="pills-home" aria-selected="true">
                           2.Employee in Exit Process</a>
                    </li>
                    <li class=" nav-item ember-view" role="presentation">
                        <a class="mx-4 nav-link ember-view" id="pills-home-tab" data-bs-toggle="pill" href=""
                            data-bs-target="#Settlement" role="tab" aria-controls="pills-home" aria-selected="true">
                           3.Full & Final Settlement</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="p-2 rounded-lg card my-2">
            <p>All leave (approved or pending) that falls under this payroll cycle month will be displayed here.</p>
        </div>
        <div class="mb-0 card">
            <div class="card-body">
                <div class="tab-content " id="pills-tabContent">
                    <div class="tab-pane fade active show" id="New" role="tabpanel"
                        aria-labelledby="pills-home-tab">                    
                    </div>
                    <div class="tab-pane fade " id="Exit" role="tabpanel">
                    </div>
                    <div class="tab-pane fade " id="Settlement" role="tabpanel">
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</template>