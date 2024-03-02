<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">


            <div class="page-title-right">
                <ol class="breadcrumb m-0  fw-bold ">
                    @if (Str::contains(currentLoggedInUserRole(), ["Super Admin",'Admin', 'HR']))
                        <li class="crumb-item"><a href="{{ route('pms-dashboard') }}" class="text-muted">Org Appraisal</a>
                        </li>
                    @endif
                    @if (Str::contains(currentLoggedInUserRole(), ["Super Admin",'Admin', 'HR', 'Manager']))
                        <li class="crumb-item"><a href="{{ route('team-appraisal-pms-dashboard') }}"
                                class="text-muted">Team Appraisal</a>
                        </li>
                    @endif
                    @if (Str::contains(currentLoggedInUserRole(), ["Super Admin",'Admin', 'HR', 'Manager']))
                        <li class="crumb-item"><a href="{{ route('employee-appraisal-pms-dashboard') }}"
                                class="text-muted">Self
                                Appraisal</a></li>
                    @endif
                    @if (Str::contains(currentLoggedInUserRole(), ["Super Admin",'Admin', 'HR']))
                        <li class="crumb-item"><a href="{{ route('vmt_config_pms') }}" class="text-muted">pms
                                Config</a></li>
                    @endif
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
