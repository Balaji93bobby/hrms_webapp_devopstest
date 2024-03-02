<template>
    <Dialog header="Header" visible="we" :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '25vw' }" :modal="true"
        :closable="false" :closeOnEscape="false">

        <template #header>
            Attendance Regularize
        </template>
        <form id="regularizationForm">

            <input type="hidden" name="regularization_type" id="regularization_type" value="" />
            <div class="row">
                <div class="mb-2 col-12">
                    <div class="row">
                        <div class="col-6"><label class="text-ash-medium fs-15">Date</label></div>
                        <div class="col-6">
                            <span class="text-ash-medium fs-15" id="current_date">--/--/----,Monday</span>

                            <input type="hidden" class="text-ash-medium form-control fs-15" name="attendance_date"
                                id="attendance_date">
                        </div>
                    </div>
                </div>
                <div class="mb-2 col-12" id="div_actual_user_time">
                    <div class="row">
                        <div class="col-6">
                            <label class="text-ash-medium fs-15">
                                Actual Timing <span id="timing_label_suffix">(Late Arrival)</span>
                            </label>
                        </div>
                        <div class="col-6">
                            <span class="text-ash-medium fs-15" id="actual_user_time"></span>
                            <input type="hidden" name="attendance_user" id="attendance_user">
                            <input type="hidden" class="text-ash-medium form-control fs-15" name="user_time" id="user_time">
                        </div>
                    </div>
                </div>
                <div class="mb-2 col-12">
                    <div class="row">
                        <div class="col-6"><label class="text-ash-medium fs-15">Regularize Timing
                                as</label>
                        </div>
                        <div class="col-6">
                            <input class="text-ash-medium form-control fs-15" name="regularize_time" id="regularize_time">
                        </div>
                    </div>
                </div>
                <div id="div_reason_editable">
                    <div class="mb-2 col-12">
                        <div class="row">
                            <div class="col-6"><label class="text-ash-medium fs-15">Reason</label></div>
                            <div class="col-6">
                                <select name="reason" class="form-select btn-line-orange" id="reason_mip"
                                    onchange="showReasonBox(this)">
                                    <option selected hidden disabled>
                                        Choose Reason for MIP
                                    </option>
                                    <option value="Permission">Permission</option>
                                    <option value="Forgot to Punch">Forgot to Punch</option>
                                    <option value="Technical Error">Technical Error</option>
                                    <option value="Others">Others</option>
                                </select>
                                <select name="reason" class="form-select btn-line-orange" id="reason_mop"
                                    onchange="showReasonBox(this)">
                                    <option selected hidden disabled>
                                        Choose Reason for MOP
                                    </option>
                                    <option value="Permission">Permission</option>
                                    <option value="Forgot to Punch">Forgot to Punch</option>
                                    <option value="Technical Error">Technical Error</option>
                                    <option value="Others">Others</option>
                                </select>
                                <select name="reason" class="form-select btn-line-orange" id="reason_lc"
                                    onchange="showReasonBox(this)">
                                    <option selected hidden disabled>
                                        Choose Reason for LC
                                    </option>
                                    <option value="Permission">Permission</option>
                                    <option value="Technical Error">Technical Error</option>
                                    <option value="Others">Others</option>
                                </select>
                                <select name="reason" class="form-select btn-line-orange" id="reason_eg"
                                    onchange="showReasonBox(this)">
                                    <option selected hidden disabled>
                                        Choose Reason for EG
                                    </option>
                                    <option value="Permission">Permission</option>
                                    <option value="Technical Error">Technical Error</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 ">
                        <div class="row">
                            <div class="col-12">
                                <textarea name="custom_reason" id="reasonBox" cols="30" rows="3" class="form-control "
                                    placeholder="Reason here...." style="display:none"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="div_reason_noneditable">
                    <div class="mb-2 col-12">
                        <div class="row">
                            <div class="col-6"><label class="text-ash-medium fs-15">Reason</label>
                            </div>
                            <div class="col-6">
                                <input class="text-ash-medium form-control fs-15" name="txt_reason_noneditable"
                                    id="txt_reason_noneditable" value="EMPTY" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2 col-12" id="div_custom_reason">
                        <div class="row">
                            <div class="col-6"><label class="text-ash-medium fs-15">Custom Reason</label>
                            </div>
                            <div class="col-6">
                                <input class="text-ash-medium form-control fs-15" name="txt_customreason_noneditable"
                                    id="txt_customreason_noneditable" value="EMPTY" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2 col-12">
                        <div class="row">
                            <div class="col-6"><label class="text-ash-medium fs-15">Status</label>
                            </div>
                            <div class="col-6">
                                <input class="text-ash-medium form-control fs-15" name="txt_apply_status"
                                    id="txt_apply_status" value="EMPTY" readonly>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
        <div class="py-2 border-0 modal-footer" id="div_btn_applyRegularize">

            <button type="button" class="btn btn-orange" onclick="attendanceRegularize()">Apply
                Request</button>
        </div>
    </Dialog>
</template>
