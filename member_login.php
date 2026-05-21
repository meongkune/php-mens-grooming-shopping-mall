<?
include "main_top.php";
?>

<script>
	function Check_Value() {
		if (!form2.uid.value) {
			alert("아이디를 입력하세요.");	form2.uid.focus();	return;
		}
		if (!form2.pwd.value) {
			alert("암호를 입력하세요.");	form2.pwd.focus();	return;
		}

		form2.submit();
	}
</script>

<style>
	.login-wrap {
		max-width: 520px;
		margin: 56px auto 0;
	}

	.login-title {
		text-align: center;
		margin-bottom: 24px;
	}

	.login-title h4 {
		font-size: 26px;
		font-weight: 900;
		letter-spacing: 0;
		color: #243036;
		margin-bottom: 8px;
	}

	.login-title p {
		font-size: 14px;
		color: #7a8586;
		margin: 0;
	}

	.login-form {
		background: #fff;
		border: 1px solid #e4ece8;
		border-radius: 18px;
		box-shadow: 0 18px 45px rgba(38, 65, 59, 0.08);
		overflow: hidden;
	}

	.login-section {
		padding: 26px 30px;
	}

	.login-section__head {
		margin-bottom: 18px;
	}

	.login-section__head h5 {
		font-size: 16px;
		font-weight: 900;
		color: #1f3d32;
		letter-spacing: 0;
		margin: 0 0 6px;
	}

	.login-section__head span {
		font-size: 12px;
		color: #8a9694;
	}

	.login-field {
		margin-bottom: 16px;
	}

	.login-field:last-child {
		margin-bottom: 0;
	}

	.login-field label {
		display: block;
		font-size: 13px;
		font-weight: 800;
		color: #344542;
		letter-spacing: 0;
		margin-bottom: 7px;
	}

	.login-form .form-control {
		height: 42px;
		border: 1px solid #d8e2dd;
		border-radius: 10px;
		font-size: 14px;
		letter-spacing: 0;
	}

	.login-form .form-control:focus {
		border-color: #3baea0;
		box-shadow: 0 0 0 0.18rem rgba(59,174,160,0.15);
	}

	.login-actions {
	   Q
		display: flex;
		justify-content: center;
		gap: 8px;
		flex-wrap: wrap;
		padding: 24px 30px 30px;
		background: #f8fbf9;
		border-top: 1px solid #edf2ef;
	}

	.login-btn-submit,
	.login-btn-sub {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		height: 44px;
		border-radius: 999px;
		font-weight: 900;
		letter-spacing: 0;
		padding: 0 22px 1px;
		line-height: 1;
	}

	.login-btn-submit {
		min-width: 150px;
		font-size: 15px;
		background: #1f3d32;
		border-color: #1f3d32;
		color: #fff !important;
	}

	.login-btn-sub {
		font-size: 13px;
		background: #fff;
		border: 1px solid #d8e2dd;
		color: #314a43 !important;
	}

	@media (max-width: 767.98px) {
		.login-wrap {
			margin-top: 36px;
		}

		.login-section,
		.login-actions {
			padding-left: 18px;
			padding-right: 18px;
		}

		.login-actions .btn {
			width: 100%;
		}
	}
</style>

<div class="login-wrap">
	<div class="login-title">
		<h4>로그인</h4>
		<p>회원 계정으로 로그인하면 주문과 배송 현황을 확인할 수 있습니다.</p>
	</div>

	<form name="form2" method="post" action="member_check.php" class="login-form">
		<div class="login-section">
			<div class="login-section__head">
				<h5>계정 정보</h5>
				<span>가입할 때 등록한 아이디와 암호를 입력하세요.</span>
			</div>

			<div class="login-field">
				<label>아이디</label>
				<input type="text" name="uid" class="form-control" tabindex="1">
			</div>

			<div class="login-field">
				<label>암호</label>
				<input type="password" name="pwd" class="form-control" tabindex="2">
			</div>
		</div>

		<div class="login-actions">
			<a href="javascript:Check_Value();" tabindex="3" class="btn login-btn-submit">로그인</a>
			<a href="member_idpw.php" class="btn login-btn-sub">아이디/암호 찾기</a>
			<a href="member_join.php" class="btn login-btn-sub">회원가입</a>
		</div>
	</form>
</div>

<br><br><br>

<?
include "main_bottom.php";
?>
