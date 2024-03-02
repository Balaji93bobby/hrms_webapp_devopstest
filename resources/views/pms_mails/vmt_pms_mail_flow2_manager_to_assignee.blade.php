<?php

$general_info = \DB::table('vmt_client_master')->first();
//$employee_name =  \DB::table('users')->where('user_code','=',$employee->EMP_NO)->first('name');
$client_logo = request()->getSchemeAndHttpHost() . '' . $general_info->client_logo;
// dd(request()->getSchemeAndHttpHost()."".$general_info->client_logo);


?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <style>
        .txt-left {
            text-align: left;
        }

        .txt-right {
            text-align: right;
        }

        .txt-center {
            text-align: center;
        }

        .text-strong {
            font-weight: 600;
        }

        .padding-t_0 {
            padding-top: 0px;
        }

        .padding-b_0 {
            padding-bottom: 0px;
        }

        .padding-t-b_0 {
            padding-bottom: 0px;
            padding-top: 0px;
        }

        .margin-t-b_0 {
            margin-top: 0px;
            margin-bottom: 0px;
        }

        .padding-0 {
            padding: 0px;
        }
    </style>
</head>

<body>
    <!-- Flow 2 : Mail sent to employee, when manager sets KPI goal -->

    @if ($approvalStatus == 'publish')

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
                .hover-bg-green-700:hover {
                  background-color: #15803d !important
                }
                .hover-bg-red-700:hover {
                  background-color: #b91c1c !important
                }
                .hover-text-orange-500:hover {
                  color: #f97316 !important
                }
                @media (max-width: 600px) {
                  .sm-mx-3 {
                    margin-left: 12px !important;
                    margin-right: 12px !important
                  }
                  .sm-w-full {
                    width: 100% !important
                  }
                  .sm-px-0 {
                    padding-left: 0 !important;
                    padding-right: 0 !important
                  }
                  .sm-px-4 {
                    padding-left: 16px !important;
                    padding-right: 16px !important
                  }
                  .sm-px-6 {
                    padding-left: 24px !important;
                    padding-right: 24px !important
                  }
                  .sm-py-3 {
                    padding-top: 12px !important;
                    padding-bottom: 12px !important
                  }
                  .sm-text-sm {
                    font-size: 14px !important
                  }
                }
              </style>
            </head>
            <body style="margin: 0; width: 100%; padding: 0; -webkit-font-smoothing: antialiased; word-break: break-word">
              <div role="article" aria-roledescription="email" aria-label lang="en">
                <div class="sm-px-4" style="border-radius: 8px; background-color: #e2e8f0; font-family: ui-sans-serif, system-ui, -apple-system, 'Segoe UI', sans-serif">
                  <table align="center" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                      <td style="width: 600px; max-width: 100%">
                        <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td class="sm-py-3 sm-px-6" style="padding: 12px">
                              <table class="sm-w-full" style="margin-left: auto; margin-right: auto; margin-top: 16px; width: 500px" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                  <td>
                                    <img src={{ URL::asset('assets/clients/ess/logos/logo_abs.png') }} width="100" alt style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0; float: left">
                                    <img src={{ $client_logo }} width="100" alt style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0; float: right">
                                  </td>
                                </tr>
                              </table>
                              <table class="sm-w-full" style="margin-left: auto; margin-right: auto; width: 600px" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                  <td style="width: 25%">
                                    <p style="background-color: #1e3a8a; padding: 2px"></p>
                                  </td>
                                  <td style="width: 25%;">
                                    <p style="background-color: #ea580c; padding: 2px"></p>
                                  </td>
                                  <td style="width: 25%;">
                                    <p style="background-color: #1e3a8a; padding: 2px;"></p>
                                  </td>
                                  <td style="width: 25%;">
                                    <p style="background-color: #ea580c; padding: 2px;"></p>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td class="sm-px-0" style="width: 100%; padding-left: 24px; padding-right: 24px; text-align: left">
                              <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                  <td>
                                    <table style="width: 100%; border-radius: 12px; background-color: #fff; padding-left: 32px; padding-right: 32px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1)" cellpadding="0" cellspacing="0" role="presentation">
                                      <tr>
                                        <td style="text-align: center">
                                          <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                                            <tr>
                                              <td>
                                                @if($emp_avatar['type'] == "avatar")
                                                <img src="data:image/png;base64,{{ $emp_avatar['data'] }}" alt style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0; height: 64px; width: 64px; border-radius: 9999px; padding: 12px">
                                                @elseif($emp_avatar['type'] == "shortname")
                                                <td align="center"
                                                style="">
                                                <table class="" style="margin-top: 10px !important ;">
                                                    <tr>
                                                        <td style="height: 64px !important;
                                                        width: 64px !important;border-radius: 50%;background:#002f56;color:#ffffff;font-size:20px;font-weight:600;marign-top:10px !important">
                                                            <p class="" style="text-align: center !important">
                                                  {{ $emp_avatar['data'] }} </p>
                                                        </td>
                                                    </tr>
                                                </table>

                                                   </td>
                                                @endif
                                              </td>
                                            </tr>
                                          </table>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="padding-top: 12px; padding-bottom: 12px; text-align: center">
                                          <p style="margin: 0 0 12px; font-size: 30px; line-height: 24px">Hi <span style="margin: 0 0 12px; font-size: 30px; font-weight: 600; line-height: 24px">{{ $user_emp_name }}</span></p>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>

                                          <p class="sm-text-sm" style="margin: 0 0 24px; color: #334155">
                                            The purpose of this mail is to inform you that,
                                              your respective OKR/Goals as well as your reporting manager's expectations and directions
                                          for {{ $appraisal_year }} - {{$appraisal_period }}.
                                      </p>
                                          <p class="sm-text-sm" style="margin: 0 0 24px; color: #334155">
                                            Request you to Accept or Reject this OKR/PMS forms using the
                                            buttons below.
                                      </p>
                                          </p>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="text-align: center;">
                                          <a href class="hover-bg-green-700 sm-mx-3" style="margin-left: 48px; margin-right: 48px; border-radius: 9999px; background-color: #22c55e; padding: 8px 16px; font-size: 14px; font-weight: 600; color: #fff; text-decoration: none">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="height: 12px; width: 12px">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                                            </svg>
                                            Accept
                                          </a>
                                          <a href class="hover-bg-red-700 sm-mx-3" style="margin-left: 48px; margin-right: 48px; border-radius: 9999px; background-color: #ef4444; padding: 8px 16px; font-size: 14px; font-weight: 600; color: #fff; text-decoration: none">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="height: 12px; width: 12px;">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Reject
                                          </a>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                          <p class="sm-text-sm" style="margin: 32px 0 4px; color: #334155">
                                            Note - When rejecting
                                              an OKR/PMS form, kindly include the reason for rejection in
                                              the
                                              response email/HRMS portal.
                                          </p>
                                          <p class="sm-text-sm" style="margin: 0 0 24px; color: #334155">
                                            We wish you achieve your greatest goals
                                              moving
                                              forward.
                                          </p>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td class="sm-px-6" style="padding-top: 8px; padding-bottom: 8px">
                              <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                  <td style="text-align: center;">
                                    <p class="sm-text-sm" style="margin: 0; font-size: 18px; color: #334155">Cheers,</p>
                                    <p class="sm-text-sm" style="margin: 0; font-size: 18px; font-weight: 600; color: #f97316">ABS_OKR Automated System</p>
                                    <table class="sm-w-full" style="margin: 0 auto; width: 600px" cellpadding="0" cellspacing="0" role="presentation">
                                      <tr>
                                        <td style="width: 25%;">
                                          <p style="background-color: #1e3a8a; padding: 2px;"></p>
                                        </td>
                                        <td style="width: 25%;">
                                          <p style="background-color: #ea580c; padding: 2px;"></p>
                                        </td>
                                        <td style="width: 25%;">
                                          <p style="background-color: #1e3a8a; padding: 2px;"></p>
                                        </td>
                                        <td style="width: 25%;">
                                          <p style="background-color: #ea580c; padding: 2px;"></p>
                                        </td>
                                      </tr>
                                    </table>
                                    <p class="sm-text-sm" style="margin: 0; color: #334155">This e-mail was generated from ABShrms, if
                                      think
                                      this is a spam,please do report</p>
                                    <a href class="hover-text-orange-500" style="color: #f97316; text-decoration: none;">
                                      info@abshrms.com
                                    </a>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="padding-top: 12px">
                                    <table class="sm-w-full" align="center" style="width: 200px" cellpadding="0" cellspacing="0" role="presentation">
                                      <tr>
                                        <td style="width: 25%;">
                                          <a href="https://www.linkedin.com/company/ardenshr-services-private-limited/" target="_blank" style="margin-right: 20px"><img src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-001.png" alt="LinkedIn" style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0;"></a>
                                        </td>
                                        <td style="width: 25%;">
                                          <a href="https://www.instagram.com/ardenshr/" target="_blank" style="margin-right: 20px"><img src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-002.png" alt="Instagram" style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0;"></a>
                                        </td>
                                        <td style="width: 25%;">
                                          <a href="https://www.facebook.com/ArdensHR" target="_blank" style="margin-right: 20px"><img src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-004.png" alt="Facebook" style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0;"></a>
                                        </td>
                                        <td style="width: 25%;">
                                          <a href="https://www.youtube.com/channel/UCgZ7XpBoJvcWWvaiBS5GxHg" target="_blank"><img src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-003.png" alt="Youtube" style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0;"></a>
                                        </td>
                                      </tr>
                                    </table>
                                    <table align="center" cellpadding="0" cellspacing="0" role="presentation">
                                      <tr style="margin: 0 0 4px;">
                                        <td style="padding-top: 12px;">
                                          <a class="sm-text-sm" href="https://www.abshrms.com" target="_blank" style="text-align: center; font-size: 14px; color: #334155; text-decoration: none">Copyright <span style="border-radius: 9999px; border-color: #000">&#169; </span>abshrms.com</a>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </body>
            </html>

    @elseif ($approvalStatus == 'approved')

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
        .hover-bg-green-700:hover {
          background-color: #15803d !important
        }
        .hover-bg-red-700:hover {
          background-color: #b91c1c !important
        }
        .hover-text-orange-500:hover {
          color: #f97316 !important
        }
        @media (max-width: 600px) {
          .sm-mx-3 {
            margin-left: 12px !important;
            margin-right: 12px !important
          }
          .sm-w-full {
            width: 100% !important
          }
          .sm-px-0 {
            padding-left: 0 !important;
            padding-right: 0 !important
          }
          .sm-px-4 {
            padding-left: 16px !important;
            padding-right: 16px !important
          }
          .sm-px-6 {
            padding-left: 24px !important;
            padding-right: 24px !important
          }
          .sm-py-3 {
            padding-top: 12px !important;
            padding-bottom: 12px !important
          }
          .sm-text-sm {
            font-size: 14px !important
          }
        }
      </style>
    </head>
    <body style="margin: 0; width: 100%; padding: 0; -webkit-font-smoothing: antialiased; word-break: break-word">
      <div role="article" aria-roledescription="email" aria-label lang="en">
        <div class="sm-px-4" style="border-radius: 8px; background-color: #e2e8f0; font-family: ui-sans-serif, system-ui, -apple-system, 'Segoe UI', sans-serif">
          <table align="center" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
              <td style="width: 600px; max-width: 100%">
                <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                  <tr>
                    <td class="sm-py-3 sm-px-6" style="padding: 12px">
                      <table class="sm-w-full" style="margin-left: auto; margin-right: auto; margin-top: 16px; width: 500px" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                          <td>
                            <img src={{ URL::asset('assets/clients/ess/logos/logo_abs.png') }} width="100" alt style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0; float: left">
                            <img src={{ $client_logo }} width="100" alt style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0; float: right">
                          </td>
                        </tr>
                      </table>
                      <table class="sm-w-full" style="margin-left: auto; margin-right: auto; width: 600px" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                          <td style="width: 25%">
                            <p style="background-color: #1e3a8a; padding: 2px"></p>
                          </td>
                          <td style="width: 25%;">
                            <p style="background-color: #ea580c; padding: 2px"></p>
                          </td>
                          <td style="width: 25%;">
                            <p style="background-color: #1e3a8a; padding: 2px;"></p>
                          </td>
                          <td style="width: 25%;">
                            <p style="background-color: #ea580c; padding: 2px;"></p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td class="sm-px-0" style="width: 100%; padding-left: 24px; padding-right: 24px; text-align: left">
                      <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                          <td>
                            <table style="width: 100%; border-radius: 12px; background-color: #fff; padding-left: 32px; padding-right: 32px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1)" cellpadding="0" cellspacing="0" role="presentation">
                              <tr>
                                <td style="text-align: center">
                                    <table style="width: 100%;" cellpadding="0" cellspacing="0" role="none">
                                      <tr>
                                        <td>
                                            @if($emp_avatar['type'] == "avatar")
                                            <img src="data:image/png;base64,{{ $emp_avatar['data'] }}" alt style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0; height: 64px; width: 64px; border-radius: 9999px; padding: 12px">
                                            @elseif($emp_avatar['type'] == "shortname")
                                            <td align="center"
                                            style="">
                                            <table class="" style="margin-top: 10px !important ;">
                                                <tr>
                                                    <td style="height: 64px !important;
                                                    width: 64px !important;border-radius: 50%;background:#002f56;color:#ffffff;font-size:20px;font-weight:600;marign-top:10px !important">
                                                        <p class="" style="text-align: center !important">
                                              {{ $emp_avatar['data'] }} </p>
                                                    </td>
                                                </tr>
                                            </table>

                                               </td>
                                            @endif
                                          </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                                <tr>
                                <td style="padding-top: 12px; padding-bottom: 12px; text-align: center">
                                  <p style="margin: 0 0 12px; font-size: 30px; line-height: 24px">Hi <span style="margin: 0 0 12px; font-size: 30px; font-weight: 600; line-height: 24px">{{ $user_emp_name }}</span></p>
                                </td>
                              </tr>
                              <tr>
                                <td>

                                  <p class="sm-text-sm" style="margin: 0 0 24px; color: #334155">
                                    This is to inform you that , has {{ $sender_gender }} {{ $user_manager_name }}, has
                                    Approved your OKR/ PMS forms.
                                </p>
                              </p>
                                  <p class="sm-text-sm" style="margin: 0 0 24px; color: #334155">
                                    Request you to kindly have a “Great Conversation” with
                                        {{ $sender_gender }} {{ $user_manager_name }} and
                                        Complete the OKR/PMS
                                        within the time
                                        frame.
                                    </p>
                              </p>
                              <p class="sm-text-sm" style="margin: 0 0 24px; color: #334155">

                                <a class="" style="text-align: center"
                                href="{{ $login_Link }}">
                                Kindly visit the HRMS portal for more details
                            </a>
                                </p>
                                  </p>

                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td class="sm-px-6" style="padding-top: 8px; padding-bottom: 8px">
                      <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                          <td style="text-align: center;">
                            <p class="sm-text-sm" style="margin: 0; font-size: 18px; color: #334155">Cheers,</p>
                            <p class="sm-text-sm" style="margin: 0; font-size: 18px; font-weight: 600; color: #f97316">ABS_OKR Automated System</p>
                            <table class="sm-w-full" style="margin: 0 auto; width: 600px" cellpadding="0" cellspacing="0" role="presentation">
                              <tr>
                                <td style="width: 25%;">
                                  <p style="background-color: #1e3a8a; padding: 2px;"></p>
                                </td>
                                <td style="width: 25%;">
                                  <p style="background-color: #ea580c; padding: 2px;"></p>
                                </td>
                                <td style="width: 25%;">
                                  <p style="background-color: #1e3a8a; padding: 2px;"></p>
                                </td>
                                <td style="width: 25%;">
                                  <p style="background-color: #ea580c; padding: 2px;"></p>
                                </td>
                              </tr>
                            </table>
                            <p class="sm-text-sm" style="margin: 0; color: #334155">This e-mail was generated from ABShrms, if
                              think
                              this is a spam,please do report</p>
                            <a href class="hover-text-orange-500" style="color: #f97316; text-decoration: none;">
                              info@abshrms.com
                            </a>
                          </td>
                        </tr>
                        <tr>
                          <td style="padding-top: 12px">
                            <table class="sm-w-full" align="center" style="width: 200px" cellpadding="0" cellspacing="0" role="presentation">
                              <tr>
                                <td style="width: 25%;">
                                  <a href="https://www.linkedin.com/company/ardenshr-services-private-limited/" target="_blank" style="margin-right: 20px"><img src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-001.png" alt="LinkedIn" style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0;"></a>
                                </td>
                                <td style="width: 25%;">
                                  <a href="https://www.instagram.com/ardenshr/" target="_blank" style="margin-right: 20px"><img src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-002.png" alt="Instagram" style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0;"></a>
                                </td>
                                <td style="width: 25%;">
                                  <a href="https://www.facebook.com/ArdensHR" target="_blank" style="margin-right: 20px"><img src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-004.png" alt="Facebook" style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0;"></a>
                                </td>
                                <td style="width: 25%;">
                                  <a href="https://www.youtube.com/channel/UCgZ7XpBoJvcWWvaiBS5GxHg" target="_blank"><img src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-003.png" alt="Youtube" style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0;"></a>
                                </td>
                              </tr>
                            </table>
                            <table align="center" cellpadding="0" cellspacing="0" role="presentation">
                              <tr style="margin: 0 0 4px;">
                                <td style="padding-top: 12px;">
                                  <a class="sm-text-sm" href="https://www.abshrms.com" target="_blank" style="text-align: center; font-size: 14px; color: #334155; text-decoration: none">Copyright <span style="border-radius: 9999px; border-color: #000">&#169; </span>abshrms.com</a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </body>
    </html>

    @elseif ($approvalStatus == 'rejected')

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
        .hover-bg-green-700:hover {
          background-color: #15803d !important
        }
        .hover-bg-red-700:hover {
          background-color: #b91c1c !important
        }
        .hover-text-orange-500:hover {
          color: #f97316 !important
        }
        @media (max-width: 600px) {
          .sm-mx-3 {
            margin-left: 12px !important;
            margin-right: 12px !important
          }
          .sm-w-full {
            width: 100% !important
          }
          .sm-px-0 {
            padding-left: 0 !important;
            padding-right: 0 !important
          }
          .sm-px-4 {
            padding-left: 16px !important;
            padding-right: 16px !important
          }
          .sm-px-6 {
            padding-left: 24px !important;
            padding-right: 24px !important
          }
          .sm-py-3 {
            padding-top: 12px !important;
            padding-bottom: 12px !important
          }
          .sm-text-sm {
            font-size: 14px !important
          }
        }
      </style>
    </head>
    <body style="margin: 0; width: 100%; padding: 0; -webkit-font-smoothing: antialiased; word-break: break-word">
      <div role="article" aria-roledescription="email" aria-label lang="en">
        <div class="sm-px-4" style="border-radius: 8px; background-color: #e2e8f0; font-family: ui-sans-serif, system-ui, -apple-system, 'Segoe UI', sans-serif">
          <table align="center" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
              <td style="width: 600px; max-width: 100%">
                <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                  <tr>
                    <td class="sm-py-3 sm-px-6" style="padding: 12px">
                      <table class="sm-w-full" style="margin-left: auto; margin-right: auto; margin-top: 16px; width: 500px" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                          <td>
                            <img src={{ URL::asset('assets/clients/ess/logos/logo_abs.png') }} width="100" alt style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0; float: left">
                            <img src={{ $client_logo }} width="100" alt style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0; float: right">
                          </td>
                        </tr>
                      </table>
                      <table class="sm-w-full" style="margin-left: auto; margin-right: auto; width: 600px" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                          <td style="width: 25%">
                            <p style="background-color: #1e3a8a; padding: 2px"></p>
                          </td>
                          <td style="width: 25%;">
                            <p style="background-color: #ea580c; padding: 2px"></p>
                          </td>
                          <td style="width: 25%;">
                            <p style="background-color: #1e3a8a; padding: 2px;"></p>
                          </td>
                          <td style="width: 25%;">
                            <p style="background-color: #ea580c; padding: 2px;"></p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td class="sm-px-0" style="width: 100%; padding-left: 24px; padding-right: 24px; text-align: left">
                      <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                          <td>
                            <table style="width: 100%; border-radius: 12px; background-color: #fff; padding-left: 32px; padding-right: 32px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1)" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td style="text-align: center">
                                        <table style="width: 100%;" cellpadding="0" cellspacing="0" role="none">
                                          <tr>
                                            <td>
                                                @if($emp_avatar['type'] == "avatar")
                                                <img src="data:image/png;base64,{{ $emp_avatar['data'] }}" alt style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0; height: 64px; width: 64px; border-radius: 9999px; padding: 12px">
                                                @elseif($emp_avatar['type'] == "shortname")
                                                <td align="center"
                                                style="">
                                                <table class="" style="margin-top: 10px !important ;">
                                                    <tr>
                                                        <td style="height: 64px !important;
                                                        width: 64px !important;border-radius: 50%;background:#002f56;color:#ffffff;font-size:20px;font-weight:600;marign-top:10px !important">
                                                            <p class="" style="text-align: center !important">
                                                  {{ $emp_avatar['data'] }} </p>
                                                        </td>
                                                    </tr>
                                                </table>

                                                   </td>
                                                @endif
                                              </td>
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>
                              <tr>
                                <td style="padding-top: 12px; padding-bottom: 12px; text-align: center">
                                  <p style="margin: 0 0 12px; font-size: 30px; line-height: 24px">Hi <span style="margin: 0 0 12px; font-size: 30px; font-weight: 600; line-height: 24px">{{ $user_emp_name }}</span></p>
                                </td>
                              </tr>
                              <tr>
                                <td>

                                  <p class="sm-text-sm" style="margin: 0 0 24px; color: #334155">
                                    This is to inform you that, {{ $sender_gender }} {{ $user_manager_name }} has rejected your OKR/ PMS forms due to " {{ $comments_manager }} "
                                </p>

                              </p>
                                  <p class="sm-text-sm" style="margin: 0 0 24px; color: #334155">
                                    Request you to kindly have a “Great Conversation” with  {{ $sender_gender }} {{ $user_manager_name }} and Complete the OKR/PMS within the time frame.
                              </p>
                                  </p>
                                  <p>
                                    <a class="" style="text-align: center"
                                            href="{{ $login_Link }}">
                                            Kindly visit the HRMS portal for more details
                                        </a>
                                    </p>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td class="sm-px-6" style="padding-top: 8px; padding-bottom: 8px">
                      <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                          <td style="text-align: center;">
                            <p class="sm-text-sm" style="margin: 0; font-size: 18px; color: #334155">Cheers,</p>
                            <p class="sm-text-sm" style="margin: 0; font-size: 18px; font-weight: 600; color: #f97316">ABS_OKR Automated System</p>
                            <table class="sm-w-full" style="margin: 0 auto; width: 600px" cellpadding="0" cellspacing="0" role="presentation">
                              <tr>
                                <td style="width: 25%;">
                                  <p style="background-color: #1e3a8a; padding: 2px;"></p>
                                </td>
                                <td style="width: 25%;">
                                  <p style="background-color: #ea580c; padding: 2px;"></p>
                                </td>
                                <td style="width: 25%;">
                                  <p style="background-color: #1e3a8a; padding: 2px;"></p>
                                </td>
                                <td style="width: 25%;">
                                  <p style="background-color: #ea580c; padding: 2px;"></p>
                                </td>
                              </tr>
                            </table>
                            <p class="sm-text-sm" style="margin: 0; color: #334155">This e-mail was generated from ABShrms, if
                              think
                              this is a spam,please do report</p>
                            <a href class="hover-text-orange-500" style="color: #f97316; text-decoration: none;">
                              info@abshrms.com
                            </a>
                          </td>
                        </tr>
                        <tr>
                          <td style="padding-top: 12px">
                            <table class="sm-w-full" align="center" style="width: 200px" cellpadding="0" cellspacing="0" role="presentation">
                              <tr>
                                <td style="width: 25%;">
                                  <a href="https://www.linkedin.com/company/ardenshr-services-private-limited/" target="_blank" style="margin-right: 20px"><img src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-001.png" alt="LinkedIn" style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0;"></a>
                                </td>
                                <td style="width: 25%;">
                                  <a href="https://www.instagram.com/ardenshr/" target="_blank" style="margin-right: 20px"><img src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-002.png" alt="Instagram" style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0;"></a>
                                </td>
                                <td style="width: 25%;">
                                  <a href="https://www.facebook.com/ArdensHR" target="_blank" style="margin-right: 20px"><img src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-004.png" alt="Facebook" style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0;"></a>
                                </td>
                                <td style="width: 25%;">
                                  <a href="https://www.youtube.com/channel/UCgZ7XpBoJvcWWvaiBS5GxHg" target="_blank"><img src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-003.png" alt="Youtube" style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0;"></a>
                                </td>
                              </tr>
                            </table>
                            <table align="center" cellpadding="0" cellspacing="0" role="presentation">
                              <tr style="margin: 0 0 4px;">
                                <td style="padding-top: 12px;">
                                  <a class="sm-text-sm" href="https://www.abshrms.com" target="_blank" style="text-align: center; font-size: 14px; color: #334155; text-decoration: none">Copyright <span style="border-radius: 9999px; border-color: #000">&#169; </span>abshrms.com</a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </body>
    </html>

    @elseif ($approvalStatus == 'completed')

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
        .hover-bg-green-700:hover {
          background-color: #15803d !important
        }
        .hover-bg-red-700:hover {
          background-color: #b91c1c !important
        }
        .hover-text-orange-500:hover {
          color: #f97316 !important
        }
        @media (max-width: 600px) {
          .sm-mx-3 {
            margin-left: 12px !important;
            margin-right: 12px !important
          }
          .sm-w-full {
            width: 100% !important
          }
          .sm-px-0 {
            padding-left: 0 !important;
            padding-right: 0 !important
          }
          .sm-px-4 {
            padding-left: 16px !important;
            padding-right: 16px !important
          }
          .sm-px-6 {
            padding-left: 24px !important;
            padding-right: 24px !important
          }
          .sm-py-3 {
            padding-top: 12px !important;
            padding-bottom: 12px !important
          }
          .sm-text-sm {
            font-size: 14px !important
          }
        }
      </style>
    </head>
    <body style="margin: 0; width: 100%; padding: 0; -webkit-font-smoothing: antialiased; word-break: break-word">
      <div role="article" aria-roledescription="email" aria-label lang="en">
        <div class="sm-px-4" style="border-radius: 8px; background-color: #e2e8f0; font-family: ui-sans-serif, system-ui, -apple-system, 'Segoe UI', sans-serif">
          <table align="center" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
              <td style="width: 600px; max-width: 100%">
                <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                  <tr>
                    <td class="sm-py-3 sm-px-6" style="padding: 12px">
                      <table class="sm-w-full" style="margin-left: auto; margin-right: auto; margin-top: 16px; width: 500px" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                          <td>
                            <img src={{ URL::asset('assets/clients/ess/logos/logo_abs.png') }} width="100" alt style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0; float: left">
                            <img src={{ $client_logo }} width="100" alt style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0; float: right">
                          </td>
                        </tr>
                      </table>
                      <table class="sm-w-full" style="margin-left: auto; margin-right: auto; width: 600px" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                          <td style="width: 25%">
                            <p style="background-color: #1e3a8a; padding: 2px"></p>
                          </td>
                          <td style="width: 25%;">
                            <p style="background-color: #ea580c; padding: 2px"></p>
                          </td>
                          <td style="width: 25%;">
                            <p style="background-color: #1e3a8a; padding: 2px;"></p>
                          </td>
                          <td style="width: 25%;">
                            <p style="background-color: #ea580c; padding: 2px;"></p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td class="sm-px-0" style="width: 100%; padding-left: 24px; padding-right: 24px; text-align: left">
                      <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                          <td>
                            <table style="width: 100%; border-radius: 12px; background-color: #fff; padding-left: 32px; padding-right: 32px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1)" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td style="text-align: center">
                                        <table style="width: 100%;" cellpadding="0" cellspacing="0" role="none">
                                          <tr>
                                            <td>
                                                @if($emp_avatar['type'] == "avatar")
                                                <img src="data:image/png;base64,{{ $emp_avatar['data'] }}" alt style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0; height: 64px; width: 64px; border-radius: 9999px; padding: 12px">
                                                @elseif($emp_avatar['type'] == "shortname")
                                                <td align="center"
                                                style="">
                                                <table class="" style="margin-top: 10px !important ;">
                                                    <tr>
                                                        <td style="height: 64px !important;
                                                        width: 64px !important;border-radius: 50%;background:#002f56;color:#ffffff;font-size:20px;font-weight:600;marign-top:10px !important">
                                                            <p class="" style="text-align: center !important">
                                                  {{ $emp_avatar['data'] }} </p>
                                                        </td>
                                                    </tr>
                                                </table>

                                                   </td>
                                                @endif
                                              </td>
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>
                              <tr>
                                <td style="padding-top: 12px; padding-bottom: 12px; text-align: center">
                                  <p style="margin: 0 0 12px; font-size: 30px; line-height: 24px">Hi <span style="margin: 0 0 12px; font-size: 30px; font-weight: 600; line-height: 24px">{{ $user_emp_name }}</span></p>
                                </td>
                              </tr>
                              <tr>
                                <td>

                                  <p class="sm-text-sm" style="margin: 0 0 24px; color: #334155">
                                    This is to inform you that your Manager {{$sender_gender}} {{ $user_manager_name }} has successfully submitted his/her “Manager-Review for
                                    {{$appraisal_year}}{{$appraisal_period}}
                                </p>

                              </p>
                                  <p class="sm-text-sm" style="margin: 0 0 24px; color: #334155">
                                    If you have any questions or concerns, don’t hesitate to reach out to your reporting manager or the HR team.
                              </p>
                                  </p>
                                  <p>
                                    <a class="" style="text-align: center"
                                            href="{{ $login_Link }}">
                                            Kindly visit the HRMS portal for more details HRMS LINK to be Provided
                                        </a>
                                    </p>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td class="sm-px-6" style="padding-top: 8px; padding-bottom: 8px">
                      <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                          <td style="text-align: center;">
                            <p class="sm-text-sm" style="margin: 0; font-size: 18px; color: #334155">Cheers,</p>
                            <p class="sm-text-sm" style="margin: 0; font-size: 18px; font-weight: 600; color: #f97316">ABS_OKR Automated System</p>
                            <table class="sm-w-full" style="margin: 0 auto; width: 600px" cellpadding="0" cellspacing="0" role="presentation">
                              <tr>
                                <td style="width: 25%;">
                                  <p style="background-color: #1e3a8a; padding: 2px;"></p>
                                </td>
                                <td style="width: 25%;">
                                  <p style="background-color: #ea580c; padding: 2px;"></p>
                                </td>
                                <td style="width: 25%;">
                                  <p style="background-color: #1e3a8a; padding: 2px;"></p>
                                </td>
                                <td style="width: 25%;">
                                  <p style="background-color: #ea580c; padding: 2px;"></p>
                                </td>
                              </tr>
                            </table>
                            <p class="sm-text-sm" style="margin: 0; color: #334155">This e-mail was generated from ABShrms, if
                              think
                              this is a spam,please do report</p>
                            <a href class="hover-text-orange-500" style="color: #f97316; text-decoration: none;">
                              info@abshrms.com
                            </a>
                          </td>
                        </tr>
                        <tr>
                          <td style="padding-top: 12px">
                            <table class="sm-w-full" align="center" style="width: 200px" cellpadding="0" cellspacing="0" role="presentation">
                              <tr>
                                <td style="width: 25%;">
                                  <a href="https://www.linkedin.com/company/ardenshr-services-private-limited/" target="_blank" style="margin-right: 20px"><img src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-001.png" alt="LinkedIn" style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0;"></a>
                                </td>
                                <td style="width: 25%;">
                                  <a href="https://www.instagram.com/ardenshr/" target="_blank" style="margin-right: 20px"><img src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-002.png" alt="Instagram" style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0;"></a>
                                </td>
                                <td style="width: 25%;">
                                  <a href="https://www.facebook.com/ArdensHR" target="_blank" style="margin-right: 20px"><img src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-004.png" alt="Facebook" style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0;"></a>
                                </td>
                                <td style="width: 25%;">
                                  <a href="https://www.youtube.com/channel/UCgZ7XpBoJvcWWvaiBS5GxHg" target="_blank"><img src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-003.png" alt="Youtube" style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0;"></a>
                                </td>
                              </tr>
                            </table>
                            <table align="center" cellpadding="0" cellspacing="0" role="presentation">
                              <tr style="margin: 0 0 4px;">
                                <td style="padding-top: 12px;">
                                  <a class="sm-text-sm" href="https://www.abshrms.com" target="_blank" style="text-align: center; font-size: 14px; color: #334155; text-decoration: none">Copyright <span style="border-radius: 9999px; border-color: #000">&#169; </span>abshrms.com</a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </body>
    </html>

    @endif

</body>
</html>
