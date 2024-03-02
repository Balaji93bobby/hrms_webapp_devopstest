@extends('layouts.master')

@section('content')
    <div>
        <div id="msform" class="pms-config-wrapper">
            <h3>PMS Configuration</h3>

            @if ($data && $data->id)
                <form id="form-1" method="POST" action="{{ route('store_config_pms', $data->id) }}"
                    enctype="multipart/form-data">
                @else
                    <form id="form-1" method="POST" action="{{ route('store_config_pms') }}"
                        enctype="multipart/form-data">
            @endif
            @csrf
            <div class="card shadow mb-0 ">
                <div class="card-body justify-content-center align-items-center ">
                    <div class="header-card-text">
                        <h6>KPI Goals Settings</h6>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                            <label class="" for="selected_head">Calendar Type</label>
                        </div>
                        <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">
                            <select placeholder="Select Calendar Type" name="calendar_type" id="calendar_type"
                                class="onboard-form form-control select2_form_without_search" required>
                                <option value="">Select</option>
                                <option name="financial_year" @if ($data && $data->calendar_type=='financial_year') selected @endif value="financial_year">Financial Year</option>
                                <option name="calendar_year" @if ($data && $data->calendar_type=='calendar_year') selected @endif value="calendar_year">Calendar Year</option>

                                {{-- <option value="hr" @if ($data && $data->selected_head && 'hr' == $data->selected_head) selected @endif>HR --}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                            <label class="" for="selected_head">Year</label>
                        </div>
                        <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">
                            <input type="text" name="year" id="year" class="onboard-form form-control" required
                                <?php
                                    $financial_year_shortvalue = 'April - March';
                                    $calendar_year_shortvalue = 'January - December';

                                    $financial_year_value ="April - ".date('Y')." to March - ".date('Y') + 1 ;
                                    $calendar_year_value ="January - ".date('Y')." to December - ".date('Y');
                                    $selected_year_value = '';
                                    $selected_year_shortvalue = '';

                                    if($data && $data->year == 'April - March')
                                    {
                                        $selected_year_value = $financial_year_value;
                                        $selected_year_shortvalue = $financial_year_shortvalue;
                                    }
                                    else
                                    if($data && $data->year == 'January - December')
                                    {
                                        $selected_year_value = $calendar_year_value;
                                        $selected_year_shortvalue = $calendar_year_shortvalue;

                                    }
                                ?>
                                value="{{ $data->year ?? ''}}" readonly />
                            <input type="hidden" name="hidden_year" id="hidden_year" value="{{ $selected_year_shortvalue}}">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                            <label class="" for="selected_head">Frequency</label>
                        </div>
                        <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">
                            <?php
                            ?>
                            <select name="selected_frequency" id="selected_frequency"
                                class="onboard-form form-control select2_form_without_search" required>
                                <option value="" >Select Frequency</option>
                                <option value="monthly"    @if ($data && $data->frequency=='monthly') selected @endif  >Monthly</option>
                                <option value="quarterly"  @if ($data && $data->frequency=='quarterly') selected @endif    >Quarterly</option>
                                <option value="halfYearly" @if ($data && $data->frequency=='halfYearly') selected @endif    >Half Yearly</option>
                                <option value="yearly"     @if ($data && $data->frequency=='yearly') selected @endif    >Yearly</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                            <label class="" for="selected_head">Assignment Period</label>
                        </div>
                        <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">

                            <select name="assignment_period_start" id="assignment_period_start"
                                class="form-control form-select">
                                <option value="" selected disabled>Select Assignment Period</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-body justify-content-center align-items-center ">
                    <div class="header-card-text">
                        <h6>Rating Grid</h6>
                    </div>
                    <div class="form-card">
                        <div class="row mt-1">
                            <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                                <label for="">Show Rating card in Review Page?</label>

                            </div>
                            <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">

                                <div class="d-flex">
                                    <div class="form-check me-2">
                                        <input class="form-check-input" type="radio" name="radiobtn_show_ratingcard" id="radiobtn_show_ratingcard_true" value="true"
                                        @if ($data && $data->can_show_ratingcard_in_reviewpage=='true') checked @endif
                                        />
                                        <label class="form-check-label" for="radiobtn_show_ratingcard_true">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radiobtn_show_ratingcard" id="radiobtn_show_ratingcard_false" value="false"
                                        @if ($data && $data->can_show_ratingcard_in_reviewpage=='false') checked @endif

                                        />
                                        <label class="form-check-label" for="radiobtn_show_ratingcard_false">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                                <label for="">Show Overall Score card in Review Page?</label>

                            </div>
                            <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">

                                <div class="d-flex">
                                    <div class="form-check me-2">
                                        <input class="form-check-input" type="radio" name="radiobtn_show_overallscorecard_in_reviewpage" id="radiobtn_show_overallscorecard_in_reviewpage_true" value="true"
                                        @if ($data && $data->can_show_overallscorecard_in_reviewpage=='true') checked @endif

                                        />
                                        <label class="form-check-label" for="radiobtn_show_overallscorecard_in_reviewpage_true">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radiobtn_show_overallscorecard_in_reviewpage" id="radiobtn_show_overallscorecard_in_reviewpage_false" value="false"
                                        @if ($data && $data->can_show_overallscorecard_in_reviewpage=='false') checked @endif

                                        />
                                        <label class="form-check-label" for="radiobtn_show_overallscorecard_in_reviewpage_false">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                                <label for="">Show Overall Score card in Self-Appraisal Dashboard?</label>

                            </div>
                            <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">

                                <div class="d-flex">
                                    <div class="form-check me-2">
                                        <input class="form-check-input" type="radio" name="radiobtn_show_overallscorecard_in_selfappraisaldashboard" id="radiobtn_show_overallscorecard_in_selfappraisaldashboard_true" value="true"
                                        @if ($data && $data->can_show_overallscorecard_in_selfappraisal_dashboard=='true') checked @endif
                                        />
                                        <label class="form-check-label" for="radiobtn_show_overallscorecard_in_selfappraisaldashboard_true">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radiobtn_show_overallscorecard_in_selfappraisaldashboard" id="radiobtn_show_overallscorecard_in_selfappraisaldashboard_false" value="false"
                                        @if ($data && $data->can_show_overallscorecard_in_selfappraisal_dashboard=='false') checked @endif

                                        />
                                        <label class="form-check-label" for="radiobtn_show_overallscorecard_in_selfappraisaldashboard_false">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body justify-content-center align-items-center ">
                    <div class="header-card-text">
                        <h6>PMS Configuration</h6>
                    </div>
                    <div class="form-card">
                        <div class="row mt-1">
                            <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                                <label class="" for="selected_columns">Column needs to be shown in
                                    KPI</label>
                            </div>
                            <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">
                                <!-- <select placeholder="Select Column" name="selected_columns[]" id="selected_columns" class="onboard-form form-control select2_form_without_search" multiple required>
                                                                        <option value="">Select Column</option> -->
                                <div class="row">
                                    <div class="col-3">
                                        <input class="mr-1" type="checkbox" name="dimension_check" id="dimension_check"
                                            @if ($data && $data->selected_columns && in_array('dimension', explode(',', $data->selected_columns))) checked @endif>
                                        <label for="dimension_check" style="margin-left:2px;">Dimension</label>
                                    </div>
                                    <div class="col-3">
                                        <input class="mr-1" type="checkbox" name="kpi_check" id="kpi_check"
                                            @if ($data && $data->selected_columns && in_array('kpi', explode(',', $data->selected_columns))) checked @endif>
                                        <label for="kpi_check" style="margin-left:2px;">KPI</label>
                                    </div>
                                    <div class="col-3">
                                        <input class="mr-1" type="checkbox" name="operational_check"
                                            id="operational_check" @if ($data && $data->selected_columns && in_array('operational_definition', explode(',', $data->selected_columns))) checked @endif>
                                        <label for="operational_check" style="margin-left:2px;">Operational</label>
                                    </div>
                                    <div class="col-3">
                                        <input class="mr-1" type="checkbox" name="measure_check" id="measure_check"
                                            @if ($data && $data->selected_columns && in_array('measure', explode(',', $data->selected_columns))) checked @endif>
                                        <label for="measure_check" style="margin-left:2px;">Measure</label>
                                    </div>
                                    <div class="col-3">
                                        <input class="mr-1" type="checkbox" name="frequency_check"
                                            id="frequency_check" @if ($data && $data->selected_columns && in_array('frequency', explode(',', $data->selected_columns))) checked @endif>
                                        <label for="frequency_check" style="margin-left:2px;">Frequency</label>
                                    </div>
                                    <div class="col-3">
                                        <input class="mr-1" type="checkbox" name="target_check" id="target_check"
                                            @if ($data && $data->selected_columns && in_array('target', explode(',', $data->selected_columns))) checked @endif>
                                        <label for="target_check" style="margin-left:2px;">Target</label>
                                    </div>
                                    <div class="col-3">
                                        <input class="mr-1" type="checkbox" name="stretchTarget_check"
                                            id="stretchTarget_check" @if ($data && $data->selected_columns && in_array('stretch_target', explode(',', $data->selected_columns))) checked @endif>
                                        <label for="stretchTarget_check" style="margin-left:2px;">Stretch
                                            Target</label>
                                    </div>
                                    <div class="col-3">
                                        <input class="mr-1" type="checkbox" name="source_check" id="source_check"
                                            @if ($data && $data->selected_columns && in_array('source', explode(',', $data->selected_columns))) checked @endif>
                                        <label for="source_check" style="margin-left:2px;">Source</label>
                                    </div>
                                    <div class="col-3">
                                        <input class="mr-1" type="checkbox" name="kpiWeightage_check"
                                            id="kpiWeightage_check" @if ($data && $data->selected_columns && in_array('kpi_weightage', explode(',', $data->selected_columns))) checked @endif>
                                        <label for="kpiWeightage_check" style="margin-left:2px;">KPI
                                            Weightage</label>
                                    </div>
                                    <!-- </select> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                            <label class="" for="selected_head">Final KPI score based on</label>
                        </div>
                        <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">
                            <select placeholder="Select Head" name="selected_head" id="selected_head"
                                class="onboard-form form-control select2_form_without_search" required>
                                <option value="">Select Head</option>
                                <option value="manager" @if ($data && $data->selected_head && 'manager' == $data->selected_head) selected @endif>
                                    Manager</option>
                                <option value="hr" @if ($data && $data->selected_head && 'hr' == $data->selected_head) selected @endif>HR
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                            <label class="" for="selected_head">Maximum Line Manager levels for Appraisal
                                Review</label>
                        </div>
                        <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">
                            <select placeholder="Select Review Levels" name="selected_reviewlevels"
                                id="selected_reviewlevels" class="onboard-form form-control select2_form_without_search"
                                required>
                                <option value="">Select Review Levels</option>
                                <option value="L1" @if ($data && $data->selected_reviewlevel && 'L1' == $data->selected_reviewlevel) selected @endif>
                                    L1</option>
                                <option value="L2" @if ($data && $data->selected_reviewlevel && 'L2' == $data->selected_reviewlevel) selected @endif>L2
                                </option>
                                <option value="L3" @if ($data && $data->selected_reviewlevel && 'L3' == $data->selected_reviewlevel) selected @endif>L3
                                </option>
                                {{-- <option value="L1" >L1</option>
                                        <option value="L2" >L2</option>
                                        <option value="L3" >L3</option> --}}
                            </select>
                        </div>
                    </div>
                    <h6 class="mt-3">Change column name as per your preference</h6>
                    <div class="row mt-1">
                        @if ($data && $data->selected_columns && in_array('dimension', explode(',', $data->selected_columns)))
                            <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                                <label class="" for="selected_head">Dimension</label>
                            </div>
                            <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">
                                <input placeholder="" type="text" name="dimension"
                                    value="{{ $data && $data->header && $data->header['dimension'] ? $data->header['dimension'] : 'Dimension' }}"
                                    class="onboard-form form-control" required>
                            </div>
                        @else
                        @endif
                    </div>
                    <div class="row mt-1">
                        @if ($data && $data->selected_columns && in_array('kpi', explode(',', $data->selected_columns)))
                            <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                                <label class="" for="selected_head">KPI</label>
                            </div>
                            <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">
                                <input placeholder="" type="text" name="kpi"
                                    value="{{ $data && $data->header && $data->header['kpi'] ? $data->header['kpi'] : 'KPI' }}"
                                    class="onboard-form form-control" required>
                            </div>
                        @else
                        @endif
                    </div>
                    <div class="row mt-1">
                        @if ($data && $data->selected_columns && in_array('operational', explode(',', $data->selected_columns)))
                            <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                                <label class="" for="selected_head">Operational Definition</label>
                            </div>
                            <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">
                                <input placeholder="" type="text" name="operational"
                                    value="{{ $data && $data->header && $data->header['operational'] ? $data->header['operational'] : 'Operational Definition' }}"
                                    class="onboard-form form-control" required>
                            </div>
                        @else
                        @endif
                    </div>
                    <div class="row mt-1">
                        @if ($data && $data->selected_columns && in_array('measure', explode(',', $data->selected_columns)))
                            <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                                <label class="" for="selected_head">Measure</label>
                            </div>
                            <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">
                                <input placeholder="" type="text" name="measure"
                                    value="{{ $data && $data->header && $data->header['measure'] ? $data->header['measure'] : 'Measure' }}"
                                    class="onboard-form form-control" required>
                            </div>
                        @else
                        @endif
                    </div>
                    <div class="row mt-1">
                        @if ($data && $data->selected_columns && in_array('frequency', explode(',', $data->selected_columns)))
                            <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                                <label class="" for="selected_head">Frequency</label>
                            </div>
                            <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">
                                <input placeholder="" type="text" name="frequency"
                                    value="{{ $data && $data->header && $data->header['frequency'] ? $data->header['frequency'] : 'Frequency' }}"
                                    class="onboard-form form-control" required>
                            </div>
                        @else
                        @endif
                    </div>
                    <div class="row mt-1">
                        @if ($data && $data->selected_columns && in_array('target', explode(',', $data->selected_columns)))
                            <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                                <label class="" for="selected_head">Target</label>
                            </div>
                            <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">
                                <input placeholder="" type="text" name="target"
                                    value="{{ $data && $data->header && $data->header['target'] ? $data->header['target'] : 'Target' }}"
                                    class="onboard-form form-control" required>
                            </div>
                        @else
                        @endif
                    </div>
                    <div class="row mt-1">
                        @if ($data && $data->selected_columns && in_array('stretchTarget', explode(',', $data->selected_columns)))
                            <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                                <label class="" for="selected_head">Stretch Target</label>
                            </div>
                            <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">
                                <input placeholder="" type="text" name="stretchTarget"
                                    value="{{ $data && $data->header && $data->header['stretchTarget'] ? $data->header['stretchTarget'] : 'Stretch Target' }}"
                                    class="onboard-form form-control" required>
                            </div>
                        @else
                        @endif
                    </div>
                    <div class="row mt-1">
                        @if ($data && $data->selected_columns && in_array('source', explode(',', $data->selected_columns)))
                            <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                                <label class="" for="selected_head">Source</label>
                            </div>
                            <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">
                                <input placeholder="" type="text" name="source"
                                    value="{{ $data && $data->header && $data->header['source'] ? $data->header['source'] : 'Source' }}"
                                    class="onboard-form form-control" required>
                            </div>
                        @else
                        @endif
                    </div>
                    <div class="row mt-1">
                        @if ($data && $data->selected_columns && in_array('kpiWeightage', explode(',', $data->selected_columns)))
                            <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                                <label class="" for="selected_head">KPI Weightage</label>
                            </div>
                            <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">
                                <input placeholder="" type="text" name="kpiWeightage"
                                    value="{{ $data && $data->header && $data->header['kpiWeightage'] ? $data->header['kpiWeightage'] : 'KPI Weightage ( % )' }}"
                                    class="onboard-form form-control" required>
                            </div>
                        @else
                        @endif
                    </div>
                    <div class="table-content mb-1">
                        <h6>Appraisee's Annual Score & Rating</h6>

                        <table class="table align-middle mb-0 table-bordered  table-striped data-table" id="table">

                            <thead class="thead" id="tHead">
                                <tr>

                                    <th scope="col">Score Range</th>
                                    <th scope="col">Performance Rating</th>
                                    <th scope="col">Ranking</th>
                                    <th scope="col">Recommendation</th>
                                    {{-- <th scope="col">Sort Order</th> --}}




                                </tr>
                            </thead>
                            <tbody class="tbody" id="tbody">
                                @foreach ($config_data as $iteem)
                                    <tr>
                                        {{-- <td>{{ $iteem->score_range }} --}}
                                        <td> <a class="update" data-name="performance_rating" data-type="text"
                                                data-pk="{{ $iteem->id }}"
                                                data-title="Enter name">{{ $iteem->score_range }}</a></td>
                                        </td>
                                        <td> <a class="update" data-name="performance_rating" data-type="text"
                                                data-pk="{{ $iteem->id }}"
                                                data-title="Enter name">{{ $iteem->performance_rating }}</a></td>
                                        {{-- <td >{{ $iteem->ranking }}
                                        </td> --}}
                                        <td> <a class="update" data-name="performance_rating" data-type="text"
                                                data-pk="{{ $iteem->id }}"
                                                data-title="Enter name">{{ $iteem->ranking }}</a></td>
                                        <td><a class="update" data-name="action" data-type="text"
                                                data-pk="{{ $iteem->id }}"
                                                data-title="Enter name">{{ $iteem->action }}</a></td>
                                        {{-- <td ><a  class="update" data-name="sort_order" data-type="text" data-pk="{{ $iteem->id }}" data-title="Enter name">{{ $iteem->sort_order }}</a></td> --}}
                                @endforeach
                                </tr>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="text-end mt-3">
                                <button type="button" data="row-6" next="row-6" placeholder="" name="next"
                                    class="btn btn-orange " onclick="update_config()">Submit</button>
                            </div>  --}}

                    <div class="text-end mt-3">
                        <button type="submit" data="row-6" next="row-6" placeholder="" name="next"
                            class="btn btn-orange " value="Submit">Submit</button>
                    </div>
                    </form>



                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <!-- ui notifications -->

    <script src="{{ URL::asset('/assets/libs/prismjs/prismjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/notifications.init.js') }}"></script>
    <!-- apexcharts -->

    <!-- for validating -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/css/jquery-editable.css"
        rel="stylesheet" />

    <script>
        $.fn.poshytip = {
            defaults: null
        }
    </script>
    <script>
        var swaL_loadingPopup = null;

        function showLoadingDialog(){

            swaL_loadingPopup = Swal.fire({
                    title: 'Please wait',
                    html: 'Loading PMS Configuration',
                    //timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                        const b = Swal.getHtmlContainer().querySelector('b')
                    },
                    willClose: () => {
                    }
                }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        console.log('Loading dialog closed');
                    }
                });


        }

        $(document).ready(function() {


            showLoadingDialog();


            $('#calendar_type').change(function() {
                console.log($('#calendar_type').val());
                if ($('#calendar_type').val() == 'financial_year') {
                    $('#year').val("April - "+<?php echo date('Y'); ?>+ " to March - "+<?= date('Y') + 1 ?> );
                    $('#hidden_year').val("April - March");
                }
                else
                if ($('#calendar_type').val() == 'calendar_year') {
                    $('#year').val("January - "+<?php echo date('Y'); ?>+ " to December - "+<?= date('Y')?> );
                    $('#hidden_year').val("January - December");

                } else {
                    $('#year').val('');
                }

                $('#hidden_calendar_year').val($("#year option:selected").text())

                if ($('#calendar_type').val() != '') {
                    var frequencyDataResult =
                        '<option value="" disabled>Select frequency</option><option value="monthly">Monthly</option><option value="quarterly">Quarterly</option><option value="halfYearly">Half Yearly</option><option value="yearly">Yearly</option>';
                    $('#selected_frequency').html(frequencyDataResult);
                } else {
                    var frequencyDataResult =
                        '<option value="" disabled>Select frequency</option>';
                    $('#selected_frequency').html(frequencyDataResult)
                    //$('#selected_frequency').trigger('change');
                }

            });

            $('#selected_frequency').change(function() {
                frequencyChange();
                console.log("Updating frequency dropdown");

            });



            setTimeout(() => {
                $('#selected_frequency').trigger('change')
            }, 500);

            function frequencyChange() {
                var data = "";
                var year = new Date().getFullYear();
                var nextyear = year + 1;
                if ($('#selected_frequency').val() == 'monthly') {

                    if ($('#calendar_type').val() == 'financial_year') {
                        year = year;
                        nextyear = year + 1;

                        data =
                            "<option value='' selected disabled>Select frequency</option><option value='apr'>April - " +
                            year +
                            "</option><option value='may'>May - " + year + "</option><option value='june'>June - " +
                            year + "</option><option value='july'>July - " + year +
                            "</option><option value='aug'>August - " + year +
                            "</option><option value='sept'>September - " + year +
                            "</option><option value='oct'>October - " + year +
                            "</option><option value='nov'>November - " + year +
                            "</option><option value='dec'>December - " + year +
                            "</option><option value='jan'>January - " + nextyear +
                            "</option><option value='feb'>February - " + nextyear +
                            "</option><option value='mar'>March - " + nextyear + "</option>";
                    } else {
                        data =
                            "<option value='' selected disabled>Select frequency</option><option value='jan'>January - " +
                            year +
                            "</option><option value='feb'>February - " + year +
                            "</option><option value='mar'>March - " + year +
                            "</option><option value='apr'>April - " + year + "</option><option value='may'>May - " +
                            year + "</option><option value='june'>June - " + year +
                            "</option><option value='july'>July - " + year +
                            "</option><option value='aug'>August - " + year +
                            "</option><option value='sept'>September - " + year +
                            "</option><option value='oct'>October - " + year +
                            "</option><option value='nov'>November - " + year +
                            "</option><option value='dec'>December - " + year + "</option>";
                    }
                } else if ($('#selected_frequency').val() == 'quarterly') {
                    if ($('#calendar_type').val() == 'financial_year')
                    {
                        year = year - 1;
                        nextyear = year + 1;
                        data ="<option value='' selected disabled>Select Assignment Period</option><option value='q1'>Q1 (Apr-Jun)</option><option value='q2'>Q2 (July-Sept)</option><option value='q3'>Q3 (Oct-Dec)</option><option value='q4'>Q4 (Jan-Mar)</option>";
                    }
                    else
                    {
                        data ="<option value='' selected disabled>Select Assignment Period</option><option value='q1'>Q1(Jan-Mar)</option><option value='q2'>Q2(Apr-June)</option><option value='q3'>Q3(July-Sept)</option><option value='q4'>Q4(Oct-Dec)</option>";
                    }
                } else if ($('#selected_frequency').val() == 'halfYearly') {
                    if ($('#calendar_type').val() == 'financial_year')
                    {
                        year = year - 1;
                        nextyear = year + 1;
                        data = "<option value='' selected disabled>Select Assignment Period</option><option value='h1'>H1</option><option value='h2'>H2</option>";
                    }
                    else
                    {
                        data = "<option value=''>Select</option><option value='h1'>H1(Jan-June)</option><option value='h2'>H2(July-Dec)</option>";
                    }

                } else {
                    data = "<option value=''>Select</option><option value='yearly'>Yearly</option>";
                }
                $('#assignment_period_start').html(data);

                let selectionAssignmentPeriod_Value = "{{ $data->assignment_period }}";
                //Update the assignment dropdown value also.
                $('#assignment_period_start option[value='+selectionAssignmentPeriod_Value+']').attr("selected", "selected");

                //dismiss loading dialog
                Swal.close();
            }

        });


    </script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/js/jquery-editable-poshytip.min.js">
    </script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.19.0/jquery.validate.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $.fn.editable.defaults.mode = 'inline';


        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': '{{ csrf_token() }}'

            }

        });



        $('.update').editable({


            url: "{{ route('store_config_pms_rating') }}",

            type: 'text',

            pk: 1,

            name: 'name',

            title: 'Enter name'

        });
    </script>
    <script>
        $(document).ready(function() {
            $('.select2_form_without_search').each(function() {
                var placeholder = $(this).attr('placeholder')
                placeholder = (placeholder == undefined) ? '' : placeholder;
                $(this).select2({
                    width: '100%',
                    minimumResultsForSearch: Infinity,
                    placeholder: placeholder,
                });
            });
        });


        // function update_config(){
        //     var ref_id = $('#id').val();
        //     var performance = $('#performance_rating').val();
        //     alert(ref_id);
        //        $.ajax({
        //   //  url: "{{ route('updateUserAccountStatus') }}",
        //     type: "POST",
        //     data: {
        //         _token: "{{ csrf_token() }}",
        //         "status": status,
        //         "id": id,
        //     },
        //     success: function(data) {
        //         //window.location.reload();
        //         $('#tr_'+id).remove();
        //         console.log("Deleting TR "+'#tr_'+id);
        //         //console.log(data);
        //     }
        // });
        // }
    </script>
@endsection
