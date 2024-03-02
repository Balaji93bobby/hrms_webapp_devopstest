<?php

$general_info = \DB::table('vmt_client_master')->first();
//$employee_name =  \DB::table('users')->where('user_code','=',$employee->EMP_NO)->first('name');
$client_logo = request()->getSchemeAndHttpHost() . '' . $general_info->client_logo;
// dd(request()->getSchemeAndHttpHost()."".$general_info->logo_img);
$bank_names = \DB::table('vmt_banks')->get();

?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">


    <style>
        table {
            width: 100%;
            vertical-align: middle;
            border-collapse: collapse;
            border: 1.5pt solid #c33a36;

        }

        .payslip_table tr td {
            border: 1.5pt solid #c33a36;
            padding: 0px 4px;

        }

        table td:last-child {}

        .border-less {
            border: 0px !important;
        }

        tr {
            height: 12.55pt;
        }

        td {
            width: 81.35pt
        }

        .padding-md {
            /* padding: 2pt 0pt; */
        }

        .margin-0 {
            margin: 0px;
        }

        p {
            font-size: 9pt;
            margin-top: 3pt;
            margin-bottom: 3pt;
            padding: 0px 5px;
        }


        .sm {}

        .md {}

        .lg {}

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

        .header-row {
            height: 50px;
        }

        td.bg-ash {
            background-color: #c1c1c1;
        }
    </style>
</head>

<body>


            <div class="main-page appointment-letter">
                <div class="sub-page" style="text-align: justify;font-size: 15px;">
                    <table class="letter-format" style="padding:0;" contenteditable="true">
                        <tbody>
                            <tr>
                                <td align="left" class="pb-30" colspan="8">
                                    <img src="{{ URL::asset('assets/images/precede.png') }}" class=""
                                        alt="user-pic" style="height:55px;width:180px;">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="">
                                    <p class="fw-600 txt-left " style="">
                                        Mr. Xyz
                                    </p>
                                    <p class="fw-600 txt-left">
                                        yyy

                                    </p>

                                </td>
                                <td colspan="4" style=" ">
                                    <p class="fw-600 txt-right " style="">
                                        Date: DD/MM/YYYY
                                    </p>


                                </td>
                            </tr>
                            <tr>
                                <td colspan="8" class="pb-pt-5" align="left">
                                    <p class="fw-600 txt-left " style="">
                                        Dear Mr. Xyz,
                                    </p>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="8" class="" align="left">
                                    <p class=" " style="">
                                        We at Precede Workforce Solutions India Pvt Ltd would like to create
                                        an environment and culture committed to cooperation, quality, and
                                        responsiveness that permeate every activity. We treat business
                                        ethics no different from personal ethics leading to an atmosphere
                                        that is exciting, transparent, rewarding, and challenging. Above
                                        all, we need employees who strongly believe in nurturing a culture
                                        of ideas, questions, challenges, feedback, and prudent risk-taking.
                                        It also places a demand upon the employees to be active, and
                                        innovative with the ability to create, gather and use knowledge.

                                    </p>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="8" class="pt-pb-10" align="left">
                                    <p class=" " style="">
                                        With reference to your application and subsequent discussion, we
                                        have pleasure in appointing you as a <span class="fw-600 txt-left">
                                            Xyz </span>&nbsp; and place on
                                        record the following terms and conditions for your knowledge
                                        /acceptance:

                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8" class="border-bottom-line2 " align="left"
                                    style="padding-bottom: 57px">
                                    <ol type="1">
                                        <li>
                                            <p class="  fw-600" style="">DATE OF APPOINTMENT:
                                            </p>
                                            <p class="  pt-pb-5" style="">
                                                Your date of appointment is effective from the date of
                                                joining but not later than &nbsp;<span
                                                    class="fw-600 ">DD/MM/YYYY</span>&nbsp;
                                            </p>
                                            <p class=" " style="">
                                                At the time of joining, we request you to furnish
                                                testimonials of your educational qualifications and a
                                                relieving letter from the previous organization.
                                            </p>
                                            <p class="  pt-pb-5" style="">
                                                This is also conditional upon your being free from any
                                                contractual restrictions preventing you from accepting this
                                                offer or starting work on the date of joining.
                                            </p>
                                        </li>
                                        <li>
                                            <p class="  fw-600" style="">
                                                TIMINGS:
                                            </p>
                                            <p class="  pt-pb-5" style="">
                                                Your current timings will be from 09:00 am to 7:00 pm from
                                                Monday to Friday.
                                            </p>
                                        </li>
                                        <li>
                                            <p class="  fw-600" style="">
                                                NOTICE PERIOD:

                                            </p>
                                            <p class="  pt-pb-5" style="">
                                                This contract of employment is terminable by either party by
                                                giving two months notice (60 days) period.

                                            </p>
                                            <p class=" " style="">
                                                The company shall have the right to terminate your
                                                employment without notice if:
                                            </p>
                                            <p>

                                            <ol type="a">
                                                <li>

                                                    <p class="  pt-pb-5" style="">
                                                        You commit any material breach of any of your duties
                                                        and responsibilities under this contract.
                                                    </p>

                                                </li>
                                                <li>

                                                    <p class="  " style="">
                                                        Any particulars mentioned in your application are
                                                        found false at any point of time or found to have
                                                        willfully suppressed any material information.

                                                    </p>

                                                </li>
                                                <li>

                                                    <p class="  pt-pb-5" style="">
                                                        You become insolvent or bankrupt or any charged with
                                                        any criminal offense, which is prejudicial of the
                                                        interest of the Company.
                                                    </p>

                                                </li>
                                                <li>

                                                    <p class="  pt-pb-5" style="">
                                                        If at any time in our opinion, which is final in
                                                        this matter, you are found guilty of dishonesty,
                                                        disorderly behavior, negligence, indiscipline, an
                                                        absence of duty without permission, or any other
                                                        conduct considered by us as detrimental to the
                                                        interests of the company.

                                                    </p>
                                                </li>
                                            </ol>
                                            </p>

                                        </li>
                                    </ol>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="8" style=" " class="">
                                    <p class="fw-600 txt-center  margin-0" style="font-size:">
                                        PRECEDE WORKFORCE SOLUTIONS INDIA PRIVATE LIMITED
                                    </p>
                                    <p class=" txt-center margin-0"> <span class="f-11"> <span
                                                class="precede_primary_color f-11 fw-600">CIN -
                                            </span>U74900TN2015PTC100900</span> &nbsp; <span class="f-11"> <span
                                                class="precede_primary_color f-11  fw-600"> GSTIN -
                                            </span>33AAICP1477F1ZH</span></p>
                                    <p class="margin-0 txt-center"><span class="fw-600 ">Corporate Office:
                                        </span>No-2/29, Vengaivasal Main Road, Santhosapuram, East Tambaram,
                                        Chennai-600 073. </p>
                                    <p class="margin-0 txt-center"><span class="fw-600 ">Branch Office:
                                        </span> No-606, 1st B Main Road, Domlur, Bangalore -560071,
                                        Karnataka, India.</p>
                                    <div style="padding: 0px 5px;display:flex;font-size:95%;">
                                        <div style="margin-right:10px;"> <img
                                                src="{{ URL::asset('assets/images/appointment/precede/phone.jpg') }}"
                                                class="" alt=""
                                                style="height:20px;width:20px;">+91-44-2278 2288 </div>
                                        <div style="margin-right:10px;"> <img
                                                src="{{ URL::asset('assets/images/appointment/precede/mobile.jpg') }}"
                                                class="" alt="" style="height:20px;width:20px;">+91-97898
                                            37408 </div>
                                        <div style="margin-right:10px;"> <img
                                                src="{{ URL::asset('assets/images/appointment/precede/mail.jpg') }}"
                                                class="" alt=""
                                                style="height:20px;width:20px;">info@precedehrsolutions.com
                                        </div>
                                        <div> <img
                                                src="{{ URL::asset('assets/images/appointment/precede/computer.jpg') }}"
                                                class="" alt=""
                                                style="height:20px;width:20px;">www.precedehrsolutions.com
                                        </div>
                                    </div>
                                </td>
                            </tr>




                        </tbody>
                    </table>
                </div>
            </div>


            <div class="main-page appointment-letter">
                <div class="sub-page" style="text-align: justify;>
                    <table class="letter-format"
                    style="padding:0;">
                    <table class="letter-format" style="padding:0;">
                        <tbody>
                            <tr>
                                <td align="left" class="pb-30" colspan="8">
                                    <img src="{{ URL::asset('assets/images/precede.png') }}" class=""
                                        alt="user-pic" style="height:55px;width:180px;">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8" class="">
                                    <p class="fw-600 txt-left " style="">
                                        4. COMPENSATION PACKAGE:

                                    </p>
                                    <p class=" pt-pb-5">
                                        You will be paid an annual package of &nbsp;<span class="fw-600 txt-left"> YYY
                                        </span>&nbsp;-and your
                                        service
                                        being placed at any one of the
                                        client locations in Chennai.


                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8" class="  pt-pb-5">
                                    <table class="salary-table" style="padding:0;">
                                        <tbody>
                                            <tr>
                                                <td class="bg-orange" colspan="8">
                                                    <p class="txt-center fw-600">Salary Structure</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="bg-ash" colspan="4">
                                                    <p class="txt-left fw-600">Particulars</p>
                                                </td>
                                                <td class="bg-ash" colspan="2">
                                                    <p class="txt-center fw-600">CTC Per Month Rs</p>
                                                </td>
                                                <td class="bg-ash" colspan="2">
                                                    <p class="txt-center fw-600">CTC Per Annum Rs</p>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="" colspan="4">
                                                    <p class="txt-left ">Basic</p>
                                                </td>
                                                <td class="" colspan="2">
                                                    <p class="txt-right "></p>
                                                </td>
                                                <td class="" colspan="2">
                                                    <p class="txt-right "></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="" colspan="4">
                                                    <p class="txt-left ">House Rent Allowance </p>
                                                </td>
                                                <td class="" colspan="2">
                                                    <p class="txt-right "></p>
                                                </td>
                                                <td class="" colspan="2">
                                                    <p class="txt-right "></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="" colspan="4">
                                                    <p class="txt-left ">Statutory Bonus</p>
                                                </td>
                                                <td class="" colspan="2">
                                                    <p class="txt-right "></p>
                                                </td>
                                                <td class="" colspan="2">
                                                    <p class="txt-right "></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="" colspan="4">
                                                    <p class="txt-left ">Special Allowance</p>
                                                </td>
                                                <td class="" colspan="2">
                                                    <p class="txt-right "></p>
                                                </td>
                                                <td class="" colspan="2">
                                                    <p class="txt-right "></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="bg-ash" colspan="4">
                                                    <p class="txt-left fw-600">Gross</p>
                                                </td>
                                                <td class="bg-ash" colspan="2">
                                                    <p class="txt-right fw-600"></p>
                                                </td>
                                                <td class="bg-ash" colspan="2">
                                                    <p class="txt-right fw-600"></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="" colspan="4">
                                                    <p class="txt-left ">Employer EPF</p>
                                                </td>
                                                <td class="" colspan="2">
                                                    <p class="txt-right "></p>
                                                </td>
                                                <td class="" colspan="2">
                                                    <p class="txt-right "></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="" colspan="4">
                                                    <p class="txt-left ">Employer ESC</p>
                                                </td>
                                                <td class="" colspan="2">
                                                    <p class="txt-right "></p>
                                                </td>
                                                <td class="" colspan="2">
                                                    <p class="txt-right "></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="bg-ash" colspan="4">
                                                    <p class="txt-left fw-600">Total Cost to Company</p>
                                                </td>
                                                <td class="bg-ash" colspan="2">
                                                    <p class="txt-right fw-600"></p>
                                                </td>
                                                <td class="bg-ash" colspan="2">
                                                    <p class="txt-right fw-600"></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="" colspan="4">
                                                    <p class="txt-left ">Employee EPF </p>
                                                </td>
                                                <td class="" colspan="2">
                                                    <p class="txt-right "></p>
                                                </td>
                                                <td class="" colspan="2">
                                                    <p class="txt-right "></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="" colspan="4">
                                                    <p class="txt-left ">Employee ESI </p>
                                                </td>
                                                <td class="" colspan="2">
                                                    <p class="txt-right "></p>
                                                </td>
                                                <td class="" colspan="2">
                                                    <p class="txt-right "></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="bg-ash" colspan="4">
                                                    <p class="txt-left fw-600">Net Take Home</p>
                                                </td>
                                                <td class="bg-ash" colspan="2">
                                                    <p class="txt-right fw-600"></p>
                                                </td>
                                                <td class="bg-ash" colspan="2">
                                                    <p class="txt-right fw-600"></p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="" style=" ">
                                    <p class="fw-600 txt-left pt-pb-5" style="">
                                        5. TRANSFER:
                                    </p>
                                    <p class="">
                                        You will be liable to transfer in such capacity as the Company may
                                        from time to time determine to
                                        any other location, department, and establishment of the Company. In
                                        such a case, you will be
                                        governed by the terms and conditions of service applicable to the
                                        new assignment.
                                    </p>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="" style=" ">
                                    <p class="fw-600 pt-pb-5 txt-left " style="">
                                        6. TRAVEL:

                                    </p>
                                    <p class="">
                                        You will be required to undertake travel on Company work and you
                                        will be reimbursed travel
                                        expenses for this as per Company rules
                                    </p>

                                </td>
                            </tr>

                            <tr>
                                <td colspan="" class="border-bottom-line2" style="padding-bottom: 49px;">
                                    <p class="fw-600 pt-pb-5 txt-left " style="">
                                        7. CONFIDENTIAL INFORMATION:

                                    </p>
                                    <p class="">
                                        You shall not during your said employment or at any time thereafter
                                        divulge to any person
                                        whosoever or make any use whatsoever for you own purpose or for any
                                        during your said
                                        employment as to business or affairs of the Company or its method as
                                        to any trade secret or secret
                                        processes of the Company and you shall during the said employment
                                        also use your best endeavors
                                        to prevent any other person from doing so
                                    </p>

                                </td>
                            </tr>


                            <tr>
                                <td colspan="8" style=" " class="">
                                    <p class="fw-600 txt-center  margin-0" style="font-size:">
                                        PRECEDE WORKFORCE SOLUTIONS INDIA PRIVATE LIMITED
                                    </p>
                                    <p class=" txt-center margin-0"> <span class="f-11"> <span
                                                class="precede_primary_color f-11 fw-600">CIN -
                                            </span>U74900TN2015PTC100900</span> &nbsp; <span class="f-11"> <span
                                                class="precede_primary_color f-11  fw-600"> GSTIN -
                                            </span>33AAICP1477F1ZH</span></p>
                                    <p class="margin-0 txt-center"><span class="fw-600 ">Corporate Office:
                                        </span>No-2/29, Vengaivasal Main Road, Santhosapuram, East Tambaram,
                                        Chennai-600 073. </p>
                                    <p class="margin-0 txt-center"><span class="fw-600 ">Branch Office:
                                        </span> No-606, 1st B Main Road, Domlur, Bangalore -560071,
                                        Karnataka, India.</p>
                                    <div style="padding: 0px 5px;display:flex;font-size:95%;">
                                        <div style="margin-right:10px;"> <img
                                                src="{{ URL::asset('assets/images/appointment/precede/phone.jpg') }}"
                                                class="" alt=""
                                                style="height:20px;width:20px;">+91-44-2278 2288 </div>
                                        <div style="margin-right:10px;"> <img
                                                src="{{ URL::asset('assets/images/appointment/precede/mobile.jpg') }}"
                                                class="" alt=""
                                                style="height:20px;width:20px;">+91-97898 37408 </div>
                                        <div style="margin-right:10px;"> <img
                                                src="{{ URL::asset('assets/images/appointment/precede/mail.jpg') }}"
                                                class="" alt=""
                                                style="height:20px;width:20px;">info@precedehrsolutions.com
                                        </div>
                                        <div> <img
                                                src="{{ URL::asset('assets/images/appointment/precede/computer.jpg') }}"
                                                class="" alt=""
                                                style="height:20px;width:20px;">www.precedehrsolutions.com
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="main-page appointment-letter">
                <div class="sub-page" style="text-align: justify;font-size: 15px;">
                    <table class="letter-format" style="padding:0;">
                        <tbody>
                            <tr>
                                <td align="left" class="pb-30" colspan="8">
                                    <img src="{{ URL::asset('assets/images/precede.png') }}" class=""
                                        alt="user-pic" style="height:55px;width:180px;">
                                </td>
                            </tr>
                            <tr>

                                <td colspan="" style=" ">
                                    <p class="fw-600 txt-left " style="">
                                        8. PROTECTION OF INTEREST:

                                    </p>
                                    <p class="pt-pb-5 ">
                                        If you conceive any new or advanced methods of improving
                                        process/systems in relation to the
                                        operation of the Company, such developments will be fully
                                        communicated to the Company and will
                                        be and remain sole right/property of the Company.

                                    </p>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="" style=" " class="">
                                    <p class="fw-600 txt-left " style="">
                                        9. CONFLICT OF INTEREST:


                                    </p>
                                    <p class=" pt-pb-5 ">
                                        The Company has adopted a conflict-of-interest policy in respect of
                                        its employees. This policy is
                                        intended to avoid conflict of interest between the personal interest
                                        of an employee and the interest of the Company in its dealings with
                                        suppliers, customers and all other organizations or individuals
                                        doing or seeking to do business with the Company.

                                    </p>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="" style="border-bottom:5px solid #777171">
                                    <p class="fw-600">
                                        10. RETIREMENT / TERMINATION / RESIGNATION:
                                    </p>
                                    <p class=" pt-pb-5 ">
                                        You will be retired from the services of the Company on your
                                        completing the age of 58 years, or
                                        such other retiring age the Management may decide.

                                    </p>
                                    <p class=" pt-pb-5  ">
                                        At the time of retirement/termination/resignation, you will
                                        immediately hand over to the Company
                                        all correspondence, documentation, data, software, etc. belonging to
                                        the company or relating to its
                                        business and shall not make or retain any copies of these items.
                                    </p>

                                    <p class=" pb-pt-15 txt-left " style="">
                                        Yours Sincerely,

                                    </p>
                                    <p class=" pt-pb-5 txt-left fw-600" style="">
                                        For PRECEDE WORKFORCE SOLUTIONS INDIA PVT LTD.

                                    </p>
                                    <p class=" pt-pb-5 txt-left fw-600 " style="">
                                        David Siddharthan (Director)
                                    </p>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="" style=" " class=" pt-30 pb-30   ">
                                    <p class="txt-left fw-600"> Acceptance:</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="" style=" " class=" ">
                                    <p class="txt-left ">I M A ASHVATH have read and hereby accept the
                                        above-mentioned terms and conditions.
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="" style="border-bottom:5px solid #777171" class=" pt-pb-5 ">
                                    <p class="txt-left fw-600 "> Signature:
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="" style="padding-bottom: 208px;" class="border-bottom-line2 ">
                                    <p class="txt-left "> Please indicate your acceptance of the
                                        terms by signing and returning the duplicate copy thereof.
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8" style=" " class="">
                                    <p class="fw-600 txt-center  margin-0" style="font-size:">
                                        PRECEDE WORKFORCE SOLUTIONS INDIA PRIVATE LIMITED
                                    </p>
                                    <p class=" txt-center margin-0"> <span class="f-11"> <span
                                                class="precede_primary_color f-11 fw-600">CIN -
                                            </span>U74900TN2015PTC100900</span> &nbsp; <span class="f-11"> <span
                                                class="precede_primary_color f-11  fw-600"> GSTIN -
                                            </span>33AAICP1477F1ZH</span></p>
                                    <p class="margin-0 txt-center"><span class="fw-600 ">Corporate Office:
                                        </span>No-2/29, Vengaivasal Main Road, Santhosapuram, East Tambaram,
                                        Chennai-600 073. </p>
                                    <p class="margin-0 txt-center"><span class="fw-600 ">Branch Office:
                                        </span> No-606, 1st B Main Road, Domlur, Bangalore -560071,
                                        Karnataka, India.</p>
                                    <div style="padding: 0px 5px;display:flex;font-size:95%;">
                                        <div style="margin-right:10px;"> <img
                                                src="{{ URL::asset('assets/images/appointment/precede/phone.jpg') }}"
                                                class="" alt=""
                                                style="height:20px;width:20px;">+91-44-2278 2288 </div>
                                        <div style="margin-right:10px;"> <img
                                                src="{{ URL::asset('assets/images/appointment/precede/mobile.jpg') }}"
                                                class="" alt=""
                                                style="height:20px;width:20px;">+91-97898 37408 </div>
                                        <div style="margin-right:10px;"> <img
                                                src="{{ URL::asset('assets/images/appointment/precede/mail.jpg') }}"
                                                class="" alt=""
                                                style="height:20px;width:20px;">info@precedehrsolutions.com
                                        </div>
                                        <div> <img
                                                src="{{ URL::asset('assets/images/appointment/precede/computer.jpg') }}"
                                                class="" alt=""
                                                style="height:20px;width:20px;">www.precedehrsolutions.com
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>



</body>

</html>
