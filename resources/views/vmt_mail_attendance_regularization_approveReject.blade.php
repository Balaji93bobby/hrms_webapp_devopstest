<?php

$general_info = \DB::table('vmt_client_master')->first();
//$employee_name =  \DB::table('users')->where('user_code','=',$employee->EMP_NO)->first('name');
$client_logo = request()->getSchemeAndHttpHost() . '' . $general_info->client_logo;
// dd(request()->getSchemeAndHttpHost()."".$general_info->client_logo);


?>


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
    .hover-text-orange-500:hover {
      color: #f97316 !important
    }
    @media (max-width: 600px) {
      .sm-w-full {
        width: 100% !important
      }
      .sm-px-0 {
        padding-left: 0 !important;
        padding-right: 0 !important
      }
      .sm-px-2 {
        padding-left: 8px !important;
        padding-right: 8px !important
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
    <div class="sm-px-4" style="width: 100%; border-radius: 8px; background-color: #e2e8f0; font-family: ui-sans-serif, system-ui, -apple-system, 'Segoe UI', sans-serif">
      <table align="center" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
          <td style="width: 600px; max-width: 100%">
            <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
              <tr>
                <td class="sm-py-3 sm-px-2" style="padding: 8px">
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
                        <table style="width: 100%; border-radius: 12px; background-color: #fff; padding-left: 32px; padding-right: 32px; padding-bottom: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1)" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td>
                              <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                  <td>
                                    <p style="margin-top: 40px; font-weight: 600; color: #334155;">Dear {{ $employeeName }}</p>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td style="padding-top: 12px; padding-bottom: 12px">
                              <p style="color: #334155"> This is to inform you that your “Attendance Regularizations” request has been {{ $status }} by your line manager {{ $managerName }} .</p>
                            </td>
                          </tr>
                          <tr style="width: 200px ; ">
                            <td>
                              <table style="width: 240px; background-color: #D0DBF0;  border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1); border: 1px solid gainsboro" align="center" cellpadding="0" cellspacing="0" role="presentation">
                                <tr style="border-radius: 12px;">
                                  <td align="center" style="border-radius: 12px;">
                                    <p style="font-weight: 600; color: #1e3a8a"> Regularizations {{ $status }}</p>
                                    <table align="center" style="margin-bottom: 20px; height: 80px; width: 80px; border-radius: 9999px; " cellpadding="0" cellspacing="0" role="presentation">
                                      <tr>
                                        @if($empAvatar['type'] == "avatar")
                                        <img src="data:image/png;base64,{{ $empAvatar['data'] }}" alt style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0; height: 64px; width: 64px; border-radius: 9999px; padding: 12px">
                                        @elseif($empAvatar['type'] == "shortname")
                                        <td align="center"
                                        style="">
                                        <table class="" style="margin-top: 10px !important ;">
                                            <tr>
                                                <td style="height: 64px !important;
                                                width: 64px !important;border-radius: 50%;background:#002f56;color:#ffffff;font-size:20px;font-weight:600;marign-top:10px !important">
                                                    <p class="" style="text-align: center !important">
                                          {{ $empAvatar['data'] }} </p>
                                                </td>
                                            </tr>
                                        </table>

                                           </td>
                                        @endif
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>
                              <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td>
                                        <p style="text-align: center; font-weight: 600; color: #1e3a8a;"> {{$managerName}} </p>
                                      </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <p class="sm-text-sm" style="margin: 32px 0 20px; text-align: center; color: #334155">
                                kindly Visit the HRMS portal for more details.
                              </p>
                            </td>
                          </tr>
                          <tr>
                            <td style="margin-bottom: 20px; text-align: center;">
                              <a href="{{ $loginLink }}/attendance-leave" style="border-radius: 6px; padding: 4px; color: #fb923c; text-decoration-line: none; outline-color: #fb923c; border: 1px solid rgb(235, 140, 23)">Click Here</a>
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
                        <p class="sm-text-sm" style="margin: 0; font-size: 18px; font-weight: 600; color: #f97316">ABShrms Automated System</p>
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
                        <a href class="hover-text-orange-500" style="color: #f97316; text-decoration: none">
                          info@abshrms.com
                        </a>
                      </td>
                    </tr>
                    <tr style="padding-left: 8px">
                      <td style="padding-top: 8px">
                        <table class="sm-w-full" align="center" style="margin-top: 8px; width: 200px" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td align="center" style="width: 25%;">
                              <a href="https://www.linkedin.com/company/ardenshr-services-private-limited/" target="_blank"><img src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-001.png" alt="LinkedIn" style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0;"></a>
                            </td>
                            <td align="center" style="width: 25%;">
                              <a href="https://www.instagram.com/ardenshr/" target="_blank"><img src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-002.png" alt="Instagram" style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0;"></a>
                            </td>
                            <td align="center" style="width: 25%;">
                              <a href="https://www.facebook.com/ArdensHR" target="_blank"><img src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-004.png" alt="Facebook" style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0;"></a>
                            </td>
                            <td align="center" style="width: 25%;">
                              <a href="https://www.youtube.com/channel/UCgZ7XpBoJvcWWvaiBS5GxHg" target="_blank"><img src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-003.png" alt="Youtube" style="max-width: 100%; vertical-align: middle; line-height: 1; border: 0;"></a>
                            </td>
                          </tr>
                        </table>
                        <table align="center" cellpadding="0" cellspacing="0" role="presentation">
                          <tr style="margin-bottom: 8px; margin-top: 8px">
                            <td style="padding-top: 12px">
                              <a class="sm-text-sm" href="https://www.abshrms.com" target="_blank" style="text-align: center; font-size: 14px; color: #334155; text-decoration: none">Copyright <span style="border-radius: 9999px;">&#169; </span>abshrms.com</a>
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
