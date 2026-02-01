<?
	include "common.php";
	
	$name=$_REQUEST["name"];
	$email=$_REQUEST["email"];
	
	$member_sql="select * from member where name='$name' and email='$email'";
	$member_result = mysqli_query($db, $member_sql);
	if (!$member_result) exit("에러: $member_sql");
	
	$member_row=mysqli_fetch_array($member_result);
	$count=mysqli_num_rows($member_result);

?>

<!doctype html>
<html lang="kr" style="overflow:hidden">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>INDUK Mall</title>
	<link  href="css/bootstrap.min.css" rel="stylesheet">
	<link  href="css/my.css" rel="stylesheet">
	<script src="js/jquery-3.7.1.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container-fulid">

<!--  페이지 제목 -->
<div class="row m-0">
	<div class="col bg-light" align="center">
		<h4 class="m-2">회원 ID 확인</h4>
	</div>	
</div>	

<div class="row">
	<div class="col" align="center">
		<hr style="height:2px" class="my-0">
		<br><br>
<? if($count==1) { ?>
		문의하신 아이디는 <b><?=$member_row["uid"];?></b>입니다.<br>
<? } else { ?>
		문의하신 정보는 없습니다.
<? } ?>		
		<br><br><br>
		<a href="javascript:self.close();" class="btn btn-sm btn-dark text-white myfont">확 인</a>&nbsp;&nbsp;

	</div>
</div>

<!-------------------------------------------------------------------------------------------->	
</div>

</body>
</html>
