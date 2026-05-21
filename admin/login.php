<?
include "common.php";
?>

<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>INDUK Mall Admin</title>
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/my.css" rel="stylesheet">
	<script src="../js/jquery-3.7.1.min.js"></script>
	<script src="../js/bootstrap.bundle.min.js"></script>
</head>
<body class="admin-login" onLoad="javascript:form1.adminid.focus();">

<script>
	function check_id()
	{
		if (!form1.adminid.value)
		{
			alert("ID를 입력해주세요");
			form1.adminid.focus();
			return false;
		}
		if (!form1.adminpw.value)
		{
			alert("암호를 입력해주세요");
			form1.adminpw.focus();
			return false;
		}
		return true;
	}
</script>

<div class="container">
	<form name="form1" method="post" action="login_check.php" onSubmit="return check_id();" class="admin-login-card">
		<div class="admin-login-head">
			<h3>Administrator Login</h3>
			<p>관리자 계정으로 접속해 상품, 주문, 회원 정보를 관리합니다.</p>
		</div>

		<div class="admin-login-body">
			<div class="admin-login-field">
				<label>아이디</label>
				<input type="text" name="adminid" value="" tabindex="1" class="form-control">
			</div>

			<div class="admin-login-field">
				<label>암호</label>
				<input type="password" name="adminpw" value="" tabindex="2" class="form-control">
			</div>

			<button type="submit" class="btn btn-admin-login">로그인</button>
		</div>
	</form>
</div>

</body>
</html>
