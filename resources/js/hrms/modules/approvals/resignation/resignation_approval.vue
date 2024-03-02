<template>
         <div class="mb-2 card left-line">
            <div class="pt-1 pb-0 card-body">
                <div class="row">
                    <div class="col-9">
                        <ul class="nav nav-pills nav-tabs-dashed" role="tablist">
                            <li class="mx-4 nav-item text-muted" role="presentation">
                                <a class="pb-2 nav-link active" data-bs-toggle="tab" href="#team-resignation" aria-selected="true"
                                    role="tab">
                                    Team
                                </a>
                            </li>
                            <li class="nav-item text-muted " role="presentation">
                                <a class="pb-2 nav-link" data-bs-toggle="tab" href="#org-resignation" aria-selected="true"
                                    role="tab">
                                    Org
                                </a>
                            </li>

                        </ul>

                    </div>
                 
                </div>
            </div>
        </div>


        <div class="mb-0 card">
            <div class="card-body">
                <div class="tab-content " id="pills-tabContent">
                    <div class="tab-pane fade active show " id="team-resignation" role="tabpanel" aria-labelledby="pills-home-tab">
                        <TeamApproval />
                    </div>
                    <div class="tab-pane fade" id="org-resignation" role="tabpanel" aria-labelledby="pills-home-tab">
                        <OrgApproval />
                    </div>
                 </div>
           </div>
        </div>   
</template>


<script setup>

import TeamApproval from './team_resignation_approval/team_resignation_approval.vue'
import OrgApproval from './org_resignation_approval/org_resignation_approval.vue'

</script>