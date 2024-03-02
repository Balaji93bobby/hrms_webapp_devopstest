<?php

$general_info = \DB::table('vmt_client_master')->first();
//$employee_name =  \DB::table('users')->where('user_code','=',$employee->EMP_NO)->first('name');
$client_logo = request()->getSchemeAndHttpHost() . '' . $general_info->client_logo;

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

                                            <tr>
                                                <td colspan="4" align="left" class="border-less"
                                                    style="padding:10px ;">

                                                    <p class="text-strong " style="margin: 0px 0px 0px ">Dear
                                                        {{ $employeeName }},</p>
                                                    <p class="" style="  ">
                                                        This is to inform you that your profile details documents has been
                                                        {{ $status }}
                                                        by your line manager <b class="f-14"> {{ $managerName }} - {{ $managerCode }}<b>
                                                    </p>


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
                                                        Profile Details Documents {{ $status }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" align="center">
                                                        {{-- <div
                                                            style="text-align:center;display:flex;height:100px;width:100px;margin:auto;border-radius:50%;background:#1b7df7;color:#ffffff;justify-content: center;
                                                            align-items: center;font-weight:600px;font-size:20px">
                                                            <p style="width:100%;height:100%;text-center;position:relative;top:38px;">MS</p>

                                                        </div> --}}

                                                        <table>
                                                            <tbody>
                                                                <tr></tr>
                                                                    <?php $empAvatar = $empAvatar ?>
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
                                                        style="color:#002f56;font-weight:600;font-size:16px;padding-bottom:20px;"
                                                        align="center">
                                                        {{ $managerName }}
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td colspan="8" style="" align="center">
                                                        <p style="padding-bottom:10px; "> Kindly visit the HRMS portal
                                                            for more details.</p>
                                                        <a class="" type="button"
                                                            href="{{ $loginLink }}/attendance-leave"
                                                            style="text-decoration:none;cursor: pointer;font-weight:600;border:1px solid #ff8f1b;color:#fa9530;background:transparent;padding: 4px;
                                                            border-radius: 5px;">
                                                            Click Here
                                                        </a>
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
                                                    This e-mail was generated from ABShrms if you think this is
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
                                                        <img src="https://www.google.com/search?q=apple+play+store+icon&sxsrf=ALiCzsZSwDGRUaWhIVHPyEIWAF1rMhliTQ:1668528882836&source=lnms&tbm=isch&sa=X&ved=2ahUKEwjziu-6yrD7AhVTSGwGHW9cA5oQ_AUoAXoECAEQAw&biw=1366&bih=625&dpr=1#imgrc=jcbrOXCevaqqyM"
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
                                                <td align="center" width="100%" style="padding-bottom:0px !important;"
                                                    style="margin-right: 10px">
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
