
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>ABShrms - Leave Request Mail </title>


</head>
<body>
<!-- partial:index.partial.html -->
<!doctype html>
<html lang="en-US">

<head>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>New Account Email Template</title>
    <meta name="description" content="New Account Email Template.">
    <style type="text/css">
        a:hover {text-decoration: underline !important;}
        .button {
  padding: 1px 10px;
  font-size: 19px;
  text-align: center;
  cursor: pointer;
  outline: none;
  color: orange;
  background-color: orange;

  border-radius: 15px;

}

.button:hover {background-color: #3e8e41}

.button:active {
  background-color: #3e8e41;
  box-shadow: 0 5px #666;
  transform: translateY(4px);
}

.bgimage {
  background-image: url("https://demo.abshrms.com/assets/images/email/Background.jpg");
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: 100% 100%;
}

    </style>
</head>
<body marginheight="0" topmargin="0" marginwidth="0" leftmargin="0">
    <div class="bgimage">
    <!-- 100% body table -->
    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor=""
        style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: 'Open Sans', sans-serif;">
        <tr>
            <td>
                <table style="background-color: #0f30d800; max-width:670px; margin:0 auto;" width="100%" border="0"
                    align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">
                            <a href="https://abshrms.com" title="logo" target="_blank">
                            <img src="{{$image_view}}" style="width:140px; height:40px;" alt="">
                          </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <table cellpadding="0" cellspacing="0" class="brand-content"
                                style=" width: 100%;
                                height: 332px;
                                background-image:url('https://demo.abshrms.com/assets/images/email/team.jpg');
                                background-size: cover;
                                text-align: center;
                                position: relative;">
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 35px;">
                                        <h1  style="color: #fff;">Leave Request Mail
                                        </h1>
                                        <p style="color: #fff;" >
                                            Leave Request Mail</strong>.</p>
                                       <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                            </table>
                            <br>
                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                style="max-width:500px; background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 35px;">

                                      <h5 class="card-title fw-bold text-center m-3"></h5>
                                      <p class="text-start ">Please review the leave request of {{ $employeeName}} - {{ $empCode}}</p>


                                        <a href="{{$loginLink}}" style="background:blue;text-decoration:none !important; display:inline-block; font-weight:500; margin-top:24px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;" type="submit">View Leave Request</a>

                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">
                           <p class="text-muted"> This e-mail was generated from ABShrms If you think this is SPAM, please do report to
                <a href="info@abshrms.com">info@abshrms.com</a>
            </p>
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" integrity="sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S" crossorigin="anonymous">

                <i><a href="
                    https://www.ardens.in/"><img src="{{url('assets/images/email/google.png')}}" width="30px" height="30px" ></a></i>
                <i><a href="https://www.facebook.com/ArdensHR"><img src="{{url('assets/images/email/facebook-logo-2019.png')}}" width="30px" height="30px" ></a></i>
                <i><a href="https://www.linkedin.com/company/ardenshr-services-private-limited/"><img src="{{url('assets/images/email/linkedin (1).png')}}" width="30px" height="30px" ></a></i>
                <i><a href="https://twitter.com/HrArdens"><img src="{{url('assets/images/email/twitter.png')}}" width="30px" height="30px" ></a></i>
                <i><a href="https://www.youtube.com/channel/UCgZ7XpBoJvcWWvaiBS5GxHg"><img src="{{url('assets/images/email/movie.png')}}" width="30px" height="30px" ></a></i>
                <i><a href="https://www.instagram.com/ardenshr/"><img src="{{url('assets/images/email/instagram.png')}}" width="30px" height="30px" ></a></i>


                        </td>
                    </tr>
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</div>
    <!--/100% body table-->
    <script src="{{ URL::asset('/assets/js/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/js/jquery.min.js') }}"></script>
       <!--  <script src="./Assets/js/bootstrap.min.js"></script>
        <script src="./Assets/js/jquery.min.js"></script> -->
</body>

</html>
<!-- partial -->

</body>
</html>


