<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	@if($approvalStatus == "none")
	<p>Dear @php echo $user_emp_name; @endphp,
	</P>
	<p>																							
		Greetings from the HR Team!!! </p>
		<p>																									
		&nbsp;&nbsp;&nbsp;Thank you for participating in our performance review. Your time, honesty and cooperation was really appreciated. The session won’t be successful without you.																									
		The HR team has successfully completed your PMS review process.																									
		Thank you once again and have a wonderful day.	</p>
		<p>																								
		Regards	<br>																								
		Team HR</p>
		@elseif ($approvalStatus == "post")
		<p>@php echo $user_emp_name; @endphp</p>

		@elseif ($approvalStatus == "announcement")
		<p>@php echo $user_emp_name; @endphp</p>
		<p>@php echo $title_data; @endphp</p>
		<p>@php echo $details_data; @endphp</p>
		@endif
</body>
</html>