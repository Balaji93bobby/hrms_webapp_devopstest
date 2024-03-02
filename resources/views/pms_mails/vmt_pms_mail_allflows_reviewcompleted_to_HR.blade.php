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


	<p>
		Dear {{$hr_name}},</p>
		<p>
            This is to inform you that KRA/KPI of <b>{{ $assignee_name }}</b> for the apprisal year <b>{{ $appraisal_year}}</b> and period <b>{{ strtoupper($appraisal_period)}}</b> has been completed and
            reviewed by their manager <b>{{ $manager_name }}</b>.
            Kindly check the same in the HRMS Portal.


        <p>
        Regards<br/>
        Team HR
	</p>
        <table id="wrapper" cellpadding="0" cellspacing="0" width="552"
        style="max-width:552px; height: auto; margin: 0 auto;   font-size: 14px !important; color: #403e3c; line-height: 24px;table-layout:fixed; width:100%;border:1px solid rgba(44, 43, 43, 0.185);border-radius:5px;padding:10px">
        <tbody>
            {{-- @if (Str::contains(currentLoggedInUserRole(), ['Employee'])) --}}
            <tr>
                <td>
                    <table border="0" cellpadding="24" cellspacing="0" bgcolor="#ffffff"
                        style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;padding-top:0px;">
                        <tbody>
                            <tr>
                                <td align="center" style="padding:0;">

                                    <table cellpadding="20" cellspacing="0" width="100%" align="center">
                                        <tbody>
                                            <tr>
                                                <td colspan="8" align="center" class="border-less">
                                                    <img src={{ $client_logo }} style="height:45px;width:150px;"
                                                        title="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" align="left" class="border-less">


                                                    <p>Greetings from the HR Team,</p>
                                                    <p></p>
                                                    <p>This is to inform you that your team member <b>Mr. /Ms.
                                                            @php echo $user_emp_name; @endphp </b> has successfully submitted
                                                        his/her Self-Review for<b>@php echo $appraisal_period; @endphp </b></p>
                                                    <p>Request you to complete the OKR Manager review against OKR
                                                        /PMS
                                                        forms using the buttons below</p>

                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="8" style="" align="center"
                                                    class="  padding-t-b_0  ">

                                                    <a class="" type="button"
                                                        style="text-decoration:none;cursor: pointer; margin-right:10px;color:#ffffff;padding: 7px 30px;border: 2px solid #c5b203;background: #c5b203;border-radius: 4px;font-weight:600">
                                                        Review
                                                    </a>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="8" class="">

                                                    <p>Also, kindly have a “Great Conversation” with <b>Mr. /Ms.
                                                            @php echo $user_emp_name; @endphp </b> and Complete the OKR/PMS within
                                                        the time frame.</p>
                                                    <p>Kindly visit the HRMS portal for more details </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="
                        8" align="right"
                                                    class="padding-t-b_0 ">
                                                    <p class="tet-right margin-t-b_0 " class="margin:0px;"><b>Cheers,</b>
                                                    </p>
                                                    <p class="tet-right margin-t-b_0 "><b>ABS_OKR Automated System.</b>
                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td style="padding: 0px;">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td align="center" style="padding-top:10px ">
                                                    This e-mail was generated from ABShrms if you think this is
                                                    SPAM,please do report to <a href="info@abshrms.com"
                                                        style="text-decoration: none;color:none;">info<span
                                                            style="color:#fa9530;">@abshrms.com</span></a>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-bottom: 10px">
                                    <table style="text-align:center; width:100%; padding:10px 0px;">
                                        <tbody>
                                            <tr>
                                                <td align="right" colspan="4" style="padding: 0;">
                                                    <a href="#" class="">
                                                        <img src="{{ URL::asset('assets/images/apple_play_store.png') }}"
                                                            alt="" class=""
                                                            style="margin:0px 0px 0px 20px;">
                                                    </a>

                                                </td>
                                                <td align="left" colspan="4" style="padding: 0;">
                                                    <a href="#" class="">
                                                        <img src="{{ URL::asset('assets/images/Google_Play_Store.png') }}"
                                                            alt="" class=""
                                                            style="margin:0px 0px 0px 20px;">
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:0 !important;">
                                    <table align="center" style="text-align:center;width:100%" width="100%">
                                        <tbody>
                                            <tr>
                                                <td align="center" width="100%"
                                                    style="padding-bottom:0px !important;"
                                                    style="margin-right: 10px">
                                                    <div class="fm-sm-container">
                                                        <a href="https://www.linkedin.com/company/ardenshr-services-private-limited/"
                                                            target="_blank" style="margin-right: 20px"><img
                                                                src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-001.png"
                                                                alt="LinkedIn"></a>
                                                        <a href="https://www.instagram.com/ardenshr/"
                                                            target="_blank" style="margin-right: 20px"><img
                                                                src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-002.png"
                                                                alt="Instagram"></a>
                                                        <a href="https://www.facebook.com/ArdensHR"
                                                            target="_blank" style="margin-right: 20px"><img
                                                                src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-004.png"
                                                                alt="Facebook"></a>
                                                        <a href="https://www.youtube.com/channel/UCgZ7XpBoJvcWWvaiBS5GxHg"
                                                            target="_blank"><img
                                                                src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-003.png"
                                                                alt="Youtube"></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>

                            </tr>

                        </tbody>
                    </table>

                </td>
            </tr>

        </tbody>
    </table>

</body>
</html>
