<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
  <meta charset="utf-8">
  <meta name="x-apple-disable-message-reformatting">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="format-detection" content="telephone=no, date=no, address=no, email=no, url=no">
  <meta name="color-scheme" content="light dark">
  <meta name="supported-color-schemes" content="light dark">
  <!--[if mso]>
  <noscript>
    <xml>
      <o:OfficeDocumentSettings xmlns:o="urn:schemas-microsoft-com:office:office">
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
  </noscript>
  <style>
    td,th,div,p,a,h1,h2,h3,h4,h5,h6 {font-family: "Segoe UI", sans-serif; mso-line-height-rule: exactly;}
  </style>
  <![endif]-->
  <style>
       @import url('https://fonts.googleapis.com/css2?family=Lobster&family=Poppins&display=swap');
       *{
        font-family: 'Lobster', cursive ;
        font-family: 'Poppins', sans-serif;
       }
    .float-right {
      float: right
    }
    .float-left {
      float: left
    }
    @media (max-width: 600px) {
      .sm-w-full {
        width: 100% !important
      }
      .sm-px-2 {
        padding-left: 8px !important;
        padding-right: 8px !important
      }
      .sm-py-3 {
        padding-top: 12px !important;
        padding-bottom: 12px !important
      }
    }
  </style>
</head>
<body style="margin: 0; width: 100%; padding: 0; -webkit-font-smoothing: antialiased; word-break: break-word">
  <div role="article" aria-roledescription="email" aria-label lang="en">
    <div class="sm-px-2" style="border-radius: 8px; background-color: #000; font-family: ui-sans-serif, system-ui, -apple-system, 'Segoe UI', sans-serif">
      <table align="center" cellpadding="0" cellspacing="0" role="none">
        <tr>
          <td style="height: 100vh; background-color: #fff">
            <table style="width: 90%" cellpadding="0" cellspacing="0" role="none">
              <tr>
                <td class="sm-py-3 sm-px-2" style="width: 900px; padding: 12px">
                  <table class="sm-w-full" style="margin-left: auto; margin-right: auto;  width: 100%; background-color: #fff; height: 150px" cellpadding="0" cellspacing="0" role="none">
                    <tr style="display: flex; width: 100%; align-items: center; justify-content: space-between">
                      <td style="display: flex; width: 100%; flex-direction: column; justify-content: center; padding-left: 40px">
                        <p style="font-size: 35px; font-weight: 600; color: #000">PAYSLIP <span style="font-weight: 400; color: #6b7280">{{ $date_month['Month']}} {{$date_month['Year']}}</span></p>
                        <p style="font-size: 18px; color: #000; height: 10px; margin-top:-15px">{{$client_details[0]['client_fullname']}}</p>
                        <p style="width: 300px; font-size: 14px; color: #000; margin-bottom: 10px; height: 24px">{{ $client_details[0]['address'] }}</p>
                      </td>
                      <td>
                        <img src={{ $client_details[0]['client_logo'] }} width="100" alt style="max-width: 100%;margin-bottom:-80px; vertical-align: middle; line-height: 1; border: 0; width: 300px;">
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr style="display: flex; justify-content: center; width: 100%">
                <td style="margin-left: 50px; width: 100%">
                  <table class="sm-w-full" style="margin-left: auto; margin-right: auto; width: 100%" cellpadding="0" cellspacing="0" role="none">
                    <tr style="width: 100%;">
                      <td style="width: 100%;">
                        <p style="position: relative; font-weight: 600; color: #000;margin-top:50px">Employee Name : {{ $personal_details[0]['name'] }}</p>
                        <table border="2" style="border-color: #000; width: 100%" cellpadding="0" cellspacing="0" role="none">
                          <tr>
                          </tr>
                        </table>
                        <table style="height: 16px; width: 100%" cellpadding="0" cellspacing="0" role="none">
                          <tr style="height: 16px; width: 100%;">
                            <td style="width:25%">
                              <p style="display: flex; height: 8px; font-size: 14px; color: #6b7280">Employee Code</p>
                              <p style="display: flex; font-size:14px; color: #000;">{{ $personal_details[0]['user_code']}}</p>
                            </td>
                            <td style="height: 16px;width:25%">
                              <p style="display: flex; height: 8px; font-size: 14px; color: #6b7280;">Date Of Joining</p>
                              <p style="display: flex; border-width: 1px; border-color: #000; font-size:14px; color: #000">{{ $personal_details[0]['doj']}}</p>
                            </td>
                            <td style="height: 16px;width:25%">
                              <p style="display: flex; height: 8px; font-size: 14px; color: #6b7280;">Designation</p>
                              <p style="display: flex; font-size:14px; color: #000;">{{ $personal_details[0]['designation']}}</p>
                            </td>
                            <td style="width:25%">
                              <p style="display: flex; height: 8px; font-size: 14px; color: #6b7280;">Department</p>
                              <p style="display: flex; font-size:14px; color: #000;">{{ $personal_details[0]['department_name']}}</p>
                            </td>
                          </tr>
                        </table>
                        <table border="1" style="border-color: #f3f4f6; width: 100%" cellpadding="0" cellspacing="0" role="none">
                          <tr>
                          </tr>
                        </table>
                        <table style="width: 100%;" cellpadding="0" cellspacing="0" role="none">
                          <tr style="width: 100%;">

                            <td style="width:25%">
                              <p style="display: flex; height: 8px; font-size: 14px; color: #6b7280;">Payment Mode</p>
                              <p style="display: flex; border-width: 1px; border-color: #000; font-size:14px; color: #000;">{{ " - " }}</p>
                            </td>
                            <td style="width:25%">
                              <p style="display: flex; height: 8px; font-size: 14px; color: #6b7280;">Bank Name</p>
                              <p style="display: flex; font-size:14px; color: #000;">{{ $personal_details[0]['bank_name']}}</p>
                            </td>
                            <td style="width:25%">
                              <p style="display: flex; height: 8px; font-size: 14px; color: #6b7280;">Bank Account</p>
                              <p style="display: flex; font-size:14px; color: #000;">{{ $personal_details[0]['bank_account_number']}}</p>
                            </td>
                            <td style="width:25%">
                              <p style="margin-bottom: 0; display: flex; height: 8px; font-size: 14px; color: #6b7280;">Bank IFSC</p>
                              <p style="display: flex; font-size:14px; color: #000;">{{ $personal_details[0]['bank_ifsc_code']}}</p>
                            </td>
                          </tr>
                        </table>
                        <table border="1" style="border-color: #f3f4f6; width: 100%;" cellpadding="0" cellspacing="0" role="none">
                          <tr>
                          </tr>
                        </table>

                        <table style="width: 100%;" cellpadding="0" cellspacing="0" role="none">
                          <tr style="width: 100%;">
                            <td style="width:25%">
                              <p style="display: flex; height: 8px; font-size: 14px; color: #6b7280;">PAN</p>
                              <p style="display: flex; border-width: 1px; border-color: #000; font-size:14px; color: #000;">{{ $personal_details[0]['pan_number']}}</p>
                            </td>
                            <td style="width:25%">
                              <p style="display: flex; height: 8px; font-size: 14px; color: #6b7280;">ESIC</p>
                              <p style="display: flex; font-size:14px; color: #000;">{{$personal_details[0]['esic_number'] ?? '-'}}</p>
                            </td>
                            <td style="width:25%">
                              <p style="display: flex; height: 8px; font-size: 14px; color: #6b7280;">UAN</p>
                              <p style="display: flex; font-size:14px; color: #000;">{{ $personal_details[0]['uan_number']}}</p>
                            </td>

                            <td style="width:25%">
                              <p style="margin-bottom: 0; display: flex; height: 8px; font-size: 14px; color: #6b7280;">EPF Number</p>
                              <p style="display: flex; font-size:14px; color: #000;">{{ empty($personal_details[0]['epf_number']) ? " - " : $personal_details[0]['epf_number'] }}</p>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>

              <tr>
                <td>
                  <table class="sm-w-full" style="margin-right: auto; width: 95%; margin-left: 50px" cellpadding="0" cellspacing="0" role="none">


                    <tr>
                      <td>
                        <p style="font-weight: 600; color: #000;">LEAVE DETAILS</p>
                        <table border="2" style="border-color: #000; width: 100%;" cellpadding="0" cellspacing="0" role="none">
                          <tr>
                          </tr>
                        </table>
                        <table style="width: 100%;" cellpadding="0" cellspacing="0" role="none">
                          <tr style="width: 100%;">
                            <td style="width:25%">
                              <p style="display: flex; height: 8px; font-size: 14px; color: #6b7280; marign-top:-10px; ">Leave Type</p>
                              @foreach ($leave_data as $key => $single_leave)
                              <p style="display: flex; border-width: 1px; border-color: #000; font-size:14px; color: #000; marign-top:-10px;">{{ $single_leave['leave_type'] }}
                               </p>
                               @endforeach
                            </td>
                            <td style="width:25%">
                              <p style="display: flex; height: 8px; font-size: 14px; color: #6b7280; marign-top:-10px; "> Opening Balance</p>
                              @foreach ($leave_data as $key => $single_leave)
                              <p style="display: flex; font-size:14px; color: #000; marign-top:-10px; ">{{ $single_leave['opening_balance']}}</p>
                              @endforeach
                            </td>
                            <td style="width:25%">
                              <p style="display: flex; height: 8px; font-size: 14px; color: #6b7280; marign-top:-10px;">Availed</p>
                              @foreach ($leave_data as $key => $single_leave)
                              <p style="display: flex; font-size:14px; color: #000; marign-top:-10px;">{{ $single_leave['availed']}}</p>
                              @endforeach
                            </td>
                            <td style="width:25%">
                              <p style="margin-bottom: 0; display: flex; height: 8px; font-size: 14px; color: #6b7280;">Closing Balance</p>
                              @foreach ($leave_data as $key => $single_leave)
                              <p style="display: flex; font-size:14px; color: #000;">{{ $single_leave['closing_balance']}}</p>
                              @endforeach
                            </td>
                          </tr>
                        </table>

                        <table border="1" style="border-color: #f3f4f6; width: 100%;" cellpadding="0" cellspacing="0" role="none">
                          {{-- <tr>
                          </tr> --}}
                        </table>
                      </td>
                    </tr>

                    <tr>
                      <td>
                        <p style="font-weight: 600; color: #000;">SALARY DETAILS</p>
                        <table border="2" style="border-color: #000; width: 100%;" cellpadding="0" cellspacing="0" role="none">
                          <tr>
                          </tr>
                        </table>
                        <table style="width: 100%;" cellpadding="0" cellspacing="0" role="none">
                          <tr style="width: 100%;">
                            <td style="">
                              <p style="display: flex; height: 8px; font-size: 14px; color: #6b7280; marign-top:-10px;"> Total Working Days</p>
                              <p style="display: flex; border-width: 1px; border-color: #000; font-size:14px; color: #000; marign-top:-10px;">{{ $salary_details['worked_Days']}}</p>
                            </td>
                            <td>
                              <p style="display: flex; height: 8px; font-size: 14px; color: #6b7280; marign-top:-10px"> Actual Payable Days </p>
                              <p style="display: flex; font-size:14px; color: #000; marign-top:-10px;">{{ $salary_details['month_days']}}</p>
                            </td>
                            <td>
                              <p style="display: flex; height: 8px; font-size: 14px; color: #6b7280; marign-top:-10px;"> Loss Of Pay Days</p>
                              <p style="display: flex; font-size:14px; color: #000; marign-top:-10px;">{{ $salary_details['lop']}}</p>
                            </td>
                            <td>
                              <p style="margin-bottom: 0; display: flex; height: 8px; font-size: 14px; color: #6b7280; marign-top:-10px;">Arrears Days Payable</p>
                              <p style="display: flex; font-size:14px; color: #000;">{{ $salary_details['arrears_Days']}}</p>
                            </td>
                          </tr>
                        </table>

                        <table border="1" style="border-color: #f3f4f6; width: 100%;" cellpadding="0" cellspacing="0" role="none">
                          <tr>
                          </tr>
                        </table>
                      </td>
                    </tr>


                    <tr>
                      <td style="display: flex; width: 100%; justify-content: center;">
                        <table style="width:65%; margin-bottom: auto;" cellpadding="0" cellspacing="0" role="none">
                          <tr>
                            <td style="width:40%">
                              <p style="height: 8px; font-weight: 600; color: #000;">EARNINGS</p>
                            </td>
                            <td style="width:20%">
                              <p style="height: 8px; font-weight: 600; color: #000; margin-left:-1px; text-align:left;">Fixed</p>
                            </td>

                            <td style="width:20%">
                                @if (!empty($arrears[0]))
                                <p style="height: 8px; font-weight: 600; color: #000;margin-left:-1px; text-align:left;">Arrears</p>
                                @endif
                              </td>

                            <td style="width:20%">
                              <p style="height: 8px; font-weight: 600; color: #000;margin-left:-1px;">Earned</p>
                            </td>
                          </tr>
                          @foreach ($earnings[0] as $earned_key => $single_earnings)

                          @if ($earned_key == "Total Earnings")
                          <tr>
                            <td style="width:40%">
                              <p style="height: 8px; color: #000; font-weight:700 ">{{$earned_key."(A)"}} </p>
                            </td>
                            <td style="width:20%">
                         @if($earned_key =="Basic" || $earned_key =="HRA")

                                @foreach ($compensatory_data as $key => $single_value )

                                  <p style="height: 8px; color: #000; ">{{ $single_value[$earned_key] }}</p>

                                @endforeach
                          @endif
                            </td>
                            <td style="width:20%">
                            @if (!empty($arrears[0]))

                            @foreach ($arrears[0] as $key => $single_value )

                            @if($key == $earned_key)
                            <p style="height: 8px; color: #000; ">{{ $single_value }}</p>
                            @endif

                           @endforeach

                            @endif
                            </td>
                            <td style="width:20%">
                              <p style="height: 8px; color: #000; font-weight:700"> {{ $single_earnings}} </p>
                            </td>
                          </tr>
                          @else
                          <tr>
                            <td style="width:40%">
                              <p style="height: 8px; color: #000;">{{$earned_key}}</p>
                            </td>
                            <td style="width:20%">


                                @foreach ($compensatory_data as $key => $single_value )

                                @if($earned_key =="Basic" || $earned_key =="HRA")
                                  <p style="height: 8px; color: #000; font-weight:700 ">{{ $single_value[$earned_key] }}</p>

                                  @endif
                                @endforeach

                            </td>
                            <td style="width:20%">
                                @if (!empty($arrears[0]))

                                @foreach ($arrears[0] as $key => $single_value )

                                    @if($key == $earned_key)
                                    <p style="height: 8px; color: #000; ">{{ $single_value }}</p>
                                    @endif

                               @endforeach

                                @endif
                            </td>
                            <td style="width:20%">
                              <p style="height: 8px; color: #000;">{{ $single_earnings}}</p>
                            </td>
                          </tr>
                          @endif
                          @endforeach
                        </table>

                        <table style="height: 20px; width: 45%;border-left: 0.4px solid rgba(128, 128, 128, 0.603);" cellpadding="0" cellspacing="0" role="none">
                          <tr style="height: 4px">
                            <td style="padding-left: 4px;">
                              <p style="height: 8px; font-weight: 600; color: #000;">CONTRIBUTIONS</p>
                            </td>
                          </tr>
                          @foreach ($contribution[0] as $key => $single_contribution)
                          @if ($key =="Total Contribution")
                          <tr style="height: 4px;">
                            <td style="padding-left: 4px;">
                              <p style="height: 4px; color: #000; font-weight:700 ;">{{ $key."(B)" }}</p>
                            </td>
                            <td style="padding-left: 4px;">
                              <p style="height: 4px; color: #000; font-weight:700; text-align:end;">{{ $single_contribution }}</p>
                            </td>
                          </tr>
                         @else
                         <tr style="height: 4px;">
                            <td style="padding-left: 4px;">
                              <p style="height: 4px; color: #000;">{{$key}}</p>
                            </td>
                            <td >
                              <p style="height: 4px; color: #000; text-align:end;">{{ $single_contribution }}</p>
                            </td>
                          </tr>
                         @endif
                         @endforeach

                         <tr style="height: 4px;">
                            <td>
                              <p style="height: 4px; padding-left: 4px; font-weight: 700; color: #000;">TAXES & DEDUCTIONS</p>
                            </td>
                          </tr>
                          @foreach ($Tax_Deduction[0] as $key => $single_taxdeduction)
                          @if ( $key == "Total Deduction")
                          <tr style="height: 4px;">
                            <td>
                              <p style="height: 4px; color: #000; font-weight:700; padding-left: 4px;">{{ $key."(C)" }}</p>
                            </td>
                            <td>
                              <p style="height: 4px; color: #000; font-weight:700; text-align:end;
                              " >{{  $single_taxdeduction }}</p>
                            </td>
                          </tr>
                          @else
                          <tr style="height: 4px;">
                            <td>
                              <p style="height: 4px; color: #000; padding-left: 4px;"> {{ $key }} </p>
                            </td>
                            <td>
                              <p style="height: 4px; color: #000; text-align:end;">  {{  $single_taxdeduction }}</p>
                            </td>
                          </tr>
                          @endif
                          @endforeach
                        </table>
                      </td>
                      {{--  --}}
                      {{--  --}}
                    </tr>

                    <tr>
                      <td>
                        <table style="border:0.4px solid gray ; width:100%; margin-top:10px;" ></table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr style="height: 100px">
                <td style="width: 100%;">
                  <table style="width: 100%;" cellpadding="0" cellspacing="0" role="none">
                    @foreach ($over_all[0] as $key => $total_sumvalue)
                    @if ($key == "Net Salary in words")
                    <tr style="margin-left: 45px; display: flex; width: 100%; justify-content: center">
                      <td style="width: 40%">
                        <p style="height: 16px; color: #000 ">{{ $key }} </p>
                      </td>
                      <td style="width: 70%">
                        <p style="height: 16px; color: #000; font-weight:700">  {{ $total_sumvalue }}</p>
                      </td>
                    </tr>
                    @else
                    <tr style="margin-left: 45px; display: flex; width: 100%; justify-content: center">
                        <td style="width: 40%">
                          <p style="height: 16px; color: #000">{{ $key }} (A-B-C)</p>
                        </td>
                        <td style="width: 70%">
                          <p style="height: 16px; color: #000;"> <span style="font-family: sans-serif;"> &#8377;</span>  {{ $total_sumvalue }}</p>
                        </td>
                      </tr>
                      @endif
                      @endforeach
                  </table>
                </td>
              </tr>
              <tr style="height: 100px; width: 100%">
                <td style="display: flex; width: 60%; justify-content: center">
                  <p style="color: #000;"> <span style="font-weight: 700;">**Note :</span> All amounts displayed in this payslip are in <span style="font-weight: 700;">INR</span> </p>
                </td>
                <td style="display: flex; width: 65%; justify-content: flex-start">
                  <p style="margin-left: 45px; font-size:14px; color: #000">*This is computer generated statement, does not require signature.</p>
                </td>
              </tr>
              <tr style="height: 50px;">
                <td> </td>
              </tr>
                <td style="width: 100%;">
                  <p style="font-size: 12px;color: gray; margin-left:640px; margin-bottom:-50px;">Generated by</p>
                    <img src="{{ URL::asset('assets/images/ABSlogo/ABS hrms Mobile logo(1).png') }}" style="width: 100px; height:100%; float:right;" alt="">
                </td>
            </tr>
              <tr style="height: 100px;">
                <td> </td>
              </tr>

            </table>
          </td>
        </tr>
      </table>
    </div>
  </div>
</body>
</html>
