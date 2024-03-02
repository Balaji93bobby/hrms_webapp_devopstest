<?php

$general_info = \DB::table('vmt_client_master')->first();
//$employee_name =  \DB::table('users')->where('user_code','=',$employee->EMP_NO)->first('name');
$client_logo = request()->getSchemeAndHttpHost() . '' . $general_info->client_logo;
// dd(request()->getSchemeAndHttpHost()."".$general_info->client_logo);


?>


<!DOCTYPE html>
<html lang="en">

<head>
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
    </style>
</head>

<body style="background-color:; padding: 5px; margin: 0;">
    <table id="wrapper" cellpadding="0" cellspacing="0" width="552"
        style="max-width:552px; height: auto; margin: 0 auto;   font-size: 14px !important; color: #403e3c; line-height: 24px;">
        <tbody>
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
                                                <td colspan="4" align="center" class="border-less">
                                                    <img src={{ $client_logo }} style="height:45px;width:150px;"
                                                        title="">
                                                </td>
                                            </tr>
                                            {{-- <tr>
                                                <td colspan="4" align="left" class="border-less"
                                                    style="padding:10px ;">
                                                    SUB – Absent Regularization Approval from Mr/Ms/Mrs Xyz
                                                </td>
                                            </tr> --}}
                                            <tr>
                                                <td colspan="4" align="left" class="border-less"
                                                    style="padding:10px ;">

                                                    <p class="text-strong " style="margin: 0px 0px 0px ">Dear
                                                        {{ $managerName }}</p>
                                                    <p class="" style="  ">
                                                        You have been sent the following “Absent Regularizations”
                                                        request for approval. Please review the below details</p>


                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" style="padding:0px 40px 0px;" colspan="">
                                    <div class=""
                                        style="height:auto;width:90%;border-radius:5px;padding:10px;margin:auto;">
                                        <table
                                            style="table-layout:fixed; width:100%;border:1px solid rgba(44, 43, 43, 0.185);border-radius:5px;padding:10px">
                                            <tbody>

                                                <tr>
                                                    <td colspan="8"
                                                        style="color:#002f56;font-weight:600;font-size:20px;padding-bottom:20px;"
                                                        align="center">
                                                        Absent Regularizations
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" align="center">


                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    @if ($empAvatar->type == 'shortname')
                                                                        <td align="center"
                                                                            style="height: 100px;
                                                                            width: 100px;border-radius: 50%;background:#002f56;color:#ffffff;font-size:20px;font-weight:600;">
                                                                            {{ $empAvatar->data }}
                                                                        </td>
                                                                    @elseif($empAvatar->type == 'avatar')
                                                                        <td align="center"
                                                                            style="height: 100px;
                                                                            width: 100px;border-radius: 50%;">

                                                                            <?php

                                                                            $imageURL = request()->getSchemeAndHttpHost() . '/images/' . $empAvatar->data;

                                                                            ?>
                                                                            <img class="rounded-circle header-profile-user"
                                                                                src="{{ $imageURL }}"
                                                                                alt="user_image"
                                                                                style="height: 100%;width: 100%;border-radius: 50%;">
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            </tbody>

                                                        </table>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td colspan="8"
                                                        style="color:#002f56;font-weight:600;font-size:20px;padding-bottom:20px;"
                                                        align="center">
                                                        {{ $employeeName }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="8" style="" align="center"
                                                        style="padding-bottom:0px;">
                                                        <p style="padding-bottom:10px;">Approve or Reject this request
                                                            using the buttons below.</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="" align="right">

                                                        <a class="" type="button"
                                                            href="{{ $loginLink }}/attendance-regularization-approvals"
                                                            style="text-decoration:none;cursor: pointer; margin-right:30px;color:#ffffff;padding: 7px 30px;border: 2px solid #90f10c;background: #90f10c;border-radius: 4px;font-weight:600">
                                                            Approve
                                                        </a>
                                                    </td>
                                                    <td colspan="4" style="" align="left">

                                                        <a class="" type="button"
                                                            href="{{ $loginLink }}/attendance-regularization-approvals"
                                                            style="text-decoration:none;cursor: pointer;margin-left:30px;color:#ffffff;padding: 7px 30px;border: 2px solid #f12d0c;background: #ff2500;border-radius: 4px;font-weight:600">
                                                            Reject
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" style="" align="center">
                                                        <p style="padding-top:0px;font-size:12px;"><span
                                                                style="color:#fa9530;"> Note - </span>When rejecting a
                                                            regularization request, kindly include the reason for
                                                            rejection in the response email</p>
                                                    </td>
                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 0px;">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td align="center" style="padding:10px 0px 0px 0px">
                                                    This e-mail was generatd from ABShrms if you think this is
                                                    SPAM,please do report to<a href="info@abshrms.com"
                                                        style="text-decoration: none;color:none;"> info<span
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
                                                        <img src="{{ URL::asset('assets/images/Google_Play_Store.png') }}"
                                                            alt="" class=""
                                                            style="margin:0px 20px 0px 0px">
                                                    </a>

                                                </td>
                                                <td align="left" colspan="4" style="padding: 0;">
                                                    <a href="#" class="">
                                                        <img src="{{ URL::asset('assets/images/apple_play_store.png') }}"
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
                                                    style="padding-bottom:0px !important;" style="margin-right: 10px">
                                                    <div class="fm-sm-container">
                                                        <a href="https://www.linkedin.com/company/ardenshr-services-private-limited/"
                                                            target="_blank" style="margin-right: 20px"><img
                                                                src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-001.png"
                                                                alt="LinkedIn"></a>
                                                        <a href="https://www.instagram.com/ardenshr/" target="_blank"
                                                            style="margin-right: 20px"><img
                                                                src="https://abs-website-assets.s3.ap-south-1.amazonaws.com/common-assets/social-media-ic/sm-ic-002.png"
                                                                alt="Instagram"></a>
                                                        <a href="https://www.facebook.com/ArdensHR" target="_blank"
                                                            style="margin-right: 20px"><img
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
