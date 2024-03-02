<template>
    <div class="manage_employee-wrapper">
        <div class="mb-2 card left-line">
            <div class="pt-1 pb-0 card-body">
                <ul class="nav nav-pills nav-tabs-dashed" role="tablist">
                    <li class="mx-4 nav-item text-muted" role="presentation">
                        <a class="pb-2 nav-link active" data-bs-toggle="tab" href="#org_level" aria-selected="true"
                            role="tab">
                            Org Level
                        </a>
                    </li>
                    <li class="mx-4 nav-item text-muted" role="presentation">
                        <a class="pb-2 nav-link" data-bs-toggle="tab" href="#team_level" aria-selected="true" role="tab">
                            Team Level
                        </a>
                    </li>
                    <li class="mx-4 nav-item text-muted" role="presentation">
                        <a class="pb-2 nav-link" data-bs-toggle="tab" href="#employee_level" aria-selected="true"
                            role="tab">
                            Employee Level
                        </a>
                    </li>
                </ul>
            </div>
        </div>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane show fade active" id="org_level" role="tabpanel"
                        aria-labelledby="pills-profile-tab">
                        <PMSFormsTableView />
                    </div>

                    <div class="tab-pane fade" id="team_level" role="tabpanel" aria-labelledby="pills-profile-tab"></div>
                    <div class="tab-pane fade" id="employee_level" role="tabpanel" aria-labelledby="pills-profile-tab">
                    </div>
                </div>
            </div>

</template>

<script setup>
import PMSFormsTableView from "../pms_forms_mgmt/table_view/PMSFormsTableView.vue";
</script>

<style>
.page-content {
    padding: calc(30px + 1.5rem) calc(1.5rem / 2) 60px calc(1.5rem / 2);
}
</style>

