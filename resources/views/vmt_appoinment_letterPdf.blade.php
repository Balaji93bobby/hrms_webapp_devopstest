<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>ABS - AppointementLetter</title>
  <style type="text/css">
    .appointment-letter {
      padding: 20px;
    }
    .appointment-letter td {
      padding: 5px 10px;
    }
    .appointment-letter table {
      width: 100%;
    }
    .page-break { page-break-before: always; }

    /*@page { margin: 8px 25px; }*/
    header { position: fixed; top: -60px; left: 0px; right: 0px; padding:8px 10px; }
    footer { position: fixed; bottom: -60px; left: 0px; right: 0px; padding:8px 10px;}
  </style>
</head>
<body>

  <header>
    <table>
      <tr>
        <td style="background-color: #006aa6;">
          <img alt="" src="data:image/png;base64,{{base64_encode(file_get_contents(public_path('/assets/images/appoinment_header.jpg')))}}" style="width: 100%;" />
        </td>
      </tr>
    </table>
  </header>

  <footer>
    <table>
      <tr>
        <td style="background-color: #006aa6;">
          <img alt="" src="data:image/png;base64,{{base64_encode(file_get_contents(public_path('/assets/images/appoinment_footer.jpg')))}}" style="width: 100%;" />
        </td>
      </tr>
    </table>
  </footer>

<table style="padding-top: 0px; padding-bottom: 0px; margin-top: 0px; margin-bottom: 0px;">

  <tr>
    <td style="font-family:Arial,Helvetica,sans-serif; font-size:12px;">
      <p>
        <div class="appointment-letter">
          <p style="text-align: center;font-size:20px">
            PRIVATE AND CONFIDENTIAL
          </p>
          <p> {{$data['employee_code']}} <br/>
            Date: {{$data['doj'] }}
          </p>
          <p>{{$data['employee_name']}}<br/>
            {{$data['current_address']}}
          </p>
          <p>
            Dear {{$data['employee_name']}},
          </p>
          <p> We thank you for deciding to be a part of the Company <b>Ardens Business Solutions Private Limited</b>  family.
          </p>
          <p> Congratulations! We are pleased to confirm that you have been selected to work for Ardens Business Solutions Private Limited. We are delighted to make you the following job offer.  </p>
          <p>The position we are offering you is that of {{$data['designation']}} at a monthly salary of Rs.{{$data['net_income']}}/- with an annual cost to the company Rs.1,50,000/-.  </p>
          <p> This position reports to {{$data['l1_manager_name']}}. Your working hours will be from 9AM to 6PM  </p>
          <p>Commencement of employment: You have joined our services on date of joining and the said date has been recorded as your Date of Joining and will be considered as such for all future purposes pertaining to your employmentƒassociation with us.</p>
          <p>Compensation & Benefits: Please refer to Annexure I, for details of your remuneration and benefits as applicable to you. The aforesaid CTC is subject to applicable taxes and statutory deductions that may prevail from time to time.
          </p>
          <p>
            <b>Transfer:</b>
            <li> While your current posting is in Location with Department, the company reserves the right to transfer you to another location, unit, department or company, associate company, subsidiary company, group company based on its requirements.</li>
            <li>In the event of such transfer you will be required to abide by the rules and regulations, service conditions and benefits of the department, store and location where you are transferred to.</li>
          </p>

          <p>
            <b>Governing Terms & Conditions:</b>
            <li> You will be governed by the clauses mentioned in your Service Agreement, TCOC (Tata Code of Conduct), company HR policies and POSH (Prevention of Sexual Harassment) at all points of time during your tenure of employment with the company. Please note that the appointment is subject to the backgroundƒdocument verification. Please note that failure to adhere to these norms, may lead to immediate termination from the services of the company.
            </li>
          </p>
          <p>
            <b>Declarations:</b>
            <li>This appointment is made on the basis of information provided by you. Should it prove untrueƒincorrect at any time, the Company reserves the rights to take appropriate action including forthwith termination of service. We shall be entitled to initiate necessary enquiries with the source of reference provided by you. In case of unfavorable report, we shall be entitled to take appropriate steps including forthwith terminating this agreement
            </li>
          </p>
          <p>Wish you a successful professional stint with us. We look forward to a mutually beneficial and enriching experience having you on board. All the best!</p>
          <p>Warm Regards,<br/>
            For <b>Ardens Business Solutions Private Limited</b>
          </p>
          <p>Name : <br/>
            Authorised Signatory Designation :
          </p>
          <p>
            <div style="float:right;width:50%;">
              I have read the above terms and conditions of my appointment. I accept the same.<br/>
              <u>_____________</u><br/>
              Applicant Name : {{$data['employee_name']}}<br/>
              Employee Code :  {{$data['employee_code']}}
            </div>
          </p>


</div>
</p>
</td>
</tr>
</table>
<table class="page-break" style="width:100%;">
 <tr >
    <td style="font-family:Arial,Helvetica,sans-serif; font-size:12px;">

        <div class="appointment-letter"  style="margin-top:40px;">
          <p style="clear: both;">Encl:<br/>
            1) Service Agreement
          </p>
        <p>
          <table border=1 cellspacing=0 >
              <tr>
                <td colspan="3" style="text-align:center"><b>ANNEXURE I</b></td>
              </tr>
              <tr>
               <td colspan="3" style="text-align:center"><b>Ardens Business Solutions Private Limited</b></td>
              </tr>
               <tr >
                <td style="width:40%">Employee No </td>
                 <td colspan="2">{{$data['employee_code']}}</td>
              </tr>
             <tr >
                <td style="width:40%">Name  </td>
                 <td colspan="2">{{$data['employee_name']}}</td>
              </tr>
             <tr >
                <td style="width:40%">Designation  </td>
                 <td colspan="2">{{$data['designation']}}</td>
              </tr>
             <tr >
                <td style="width:40%">Department  </td>
                 <td colspan="2">{{$data['department']}}</td>
              </tr>
              <tr >
                <td style="width:40%">Date of Joining  </td>
                 <td colspan="2">{{$data['doj']}}</td>
              </tr>
              <tr >
                <td style="width:40%">Remarks  </td>
                 <td colspan="2"></td>
              </tr>
               <tr >
          	 <tr>
                <td colspan="3" style="text-align:center"><b>SALARY BREAK - UP DETAILS</b></td>
              </tr>
                <td style="width:40%">SALARY COMPONENTS </td>
                 <td >INR PER MONTH</td>
                 <td >INR PER ANNUM</td>
              </tr>
              <tr >
                <td style="width:40%">Basic  </td>
                 <td >{{$data['basic_monthly']}}</td>
                 <td >{{$data['basic_yearly']}}</td>
              </tr>
             <tr >
                <td style="width:40%">HRA  </td>
                 <td >{{$data['hra_monthly']}}</td>
                 <td >{{$data['hra_yearly']}}</td>
              </tr>
             <tr >
                <td style="width:40%">Special Allowance</td>
                 <td >{{$data['spl_allowance_monthly']}}</td>
                 <td >{{$data['spl_allowance_yearly']}}</td>
              </tr>
             <tr >
                <td style="width:40%">Gross Salary</td>
                 <td >{{$data['gross_monthly']}}</td>
                 <td >{{$data['gross_yearly']}}</td>
              </tr>
             <tr >
                <td style="width:40%">Employer's Contribution to EPF </td>
                 <td >{{$data['employer_epf_monthly']}}</td>
                 <td >{{$data['employer_epf_yearly']}}</td>
              </tr>
             <tr >
                <td style="width:40%">Employer's Contribution to ESI </td>
                 <td >{{$data['employer_esi_monthly']}}</td>
                 <td >{{$data['employer_esi_yearly']}}</td>
              </tr>
             <tr >
                <td style="width:40%">CTC (Cost to the company)</td>
                 <td >{{$data['ctc_monthly']}}</td>
                 <td >{{$data['ctc_yearly']}}</td>
              </tr>
             <tr >
                <td style="width:40%">Employee's Contribution to EPF</td>
                 <td >{{$data['employee_epf_monthly']}}</td>
                 <td >{{$data['employee_epf_yearly']}}</td>
              </tr>
             <tr >
                <td style="width:40%">Employee's Contribution to ESI</td>
                 <td >{{$data['employer_esi_monthly']}}</td>
                 <td >{{$data['employer_esi_yearly']}}</td>
              </tr>
             <tr >
                <td style="width:40%">Employee's Contribution to PT  </td>
                 <td >{{$data['employer_pt_monthly']}}</td>
                 <td >{{$data['employer_pt_yearly']}}</td>
              </tr>
              <tr >
                <td style="width:40%">Net - Take Home</td>
                 <td >{{$data['net_take_home_monthly']}}</td>
                 <td >{{$data['net_take_home_yearly']}}</td>
              </tr>
              <tr >
                <td colspan="3" style="width:40%">Remarks: ---------------.
            </td>
            </tr>
          </table>
          <br>
        </div>
      </p>
    </td>
  </tr>

<tr>

  </br>

</tr>

</table>
<!-- partial -->

</body>
</html>
