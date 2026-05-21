<?
include "main_top.php";
?>

<script>
	function FindZip(zip_kind)
	{
		w=window.open("zipcode.php?zip_kind="+zip_kind, "zip",
			"width=440,height=320,scrollbars=no");
	}

	function check_id()	{
		if (!form2.uid.value) {
			alert("ID를 입력하십시오.");	form2.uid.focus();	return;
		}
		window.open("member_idcheck.php?uid="+form2.uid.value,"",
			"width=300,height=200,scrollbar=no");
	}

	function Check_Value() {
		if (!form2.check_id.value) {
			alert("중복ID 조사를 먼저 하십시오.");	form2.uid.focus();	return;
		}
		if (!form2.uid.value) {
			alert("아이디가 잘못되었습니다.");	form2.uid.focus();	return;
		}
		if (!form2.pwd.value) {
			alert("암호가 잘못되었습니다.");	form2.pwd.focus();	return;
		}
		if (!form2.pwd1.value) {
			alert("암호 확인이 잘못되었습니다.");	form2.pwd1.focus();	return;
		}
		if (form2.pwd.value != form2.pwd1.value) {
			alert("암호가 일치하지 않습니다.");
			form2.pwd.focus();	return;
		}
		if (!form2.birthday1.value || !form2.birthday2.value || !form2.birthday3.value) {
			alert("생일이 잘못되었습니다.");	form2.birthday1.focus();	return;
		}
		if (!form2.tel1.value || !form2.tel2.value || !form2.tel3.value) {
			alert("핸드폰이 잘못되었습니다.");	form2.tel1.focus();	return;
		}
		if (!form2.zip.value) {
			alert("우편번호가 잘못되었습니다.");	form2.zip.focus();	return;
		}
		if (!form2.juso.value) {
			alert("주소가 잘못되었습니다.");	form2.juso.focus();	return;
		}
		if (!form2.email.value) {
			alert("이메일이 잘못되었습니다.");	form2.email.focus();	return;
		}

		form2.submit();
	}
</script>

<style>
	.join-wrap {
		max-width: 860px;
		margin: 56px auto 0;
	}

	.join-title {
		text-align: center;
		margin-bottom: 24px;
	}

	.join-title h4 {
		font-size: 26px;
		font-weight: 900;
		letter-spacing: 0;
		color: #243036;
		margin-bottom: 8px;
	}

	.join-title p {
		font-size: 14px;
		color: #7a8586;
		margin: 0;
	}

	.join-form {
		background: #fff;
		border: 1px solid #e4ece8;
		border-radius: 18px;
		box-shadow: 0 18px 45px rgba(38, 65, 59, 0.08);
		overflow: hidden;
	}

	.join-section {
		padding: 26px 30px;
		border-top: 1px solid #edf2ef;
	}

	.join-section:first-of-type {
		border-top: 0;
	}

	.join-section__head {
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 14px;
		margin-bottom: 18px;
	}

	.join-section__head h5 {
		font-size: 16px;
		font-weight: 900;
		color: #1f3d32;
		letter-spacing: 0;
		margin: 0;
	}

	.join-section__head span {
		font-size: 12px;
		color: #8a9694;
	}

	.join-field {
		margin-bottom: 16px;
	}

	.join-field:last-child {
		margin-bottom: 0;
	}

	.join-field label {
		display: block;
		font-size: 13px;
		font-weight: 800;
		color: #344542;
		letter-spacing: 0;
		margin-bottom: 7px;
	}

	.join-required {
		color: #d95d4f;
		margin-left: 3px;
	}

	.join-form .form-control {
		height: 40px;
		border: 1px solid #d8e2dd;
		border-radius: 10px;
		font-size: 14px;
		letter-spacing: 0;
	}

	.join-form .form-control:focus {
		border-color: #3baea0;
		box-shadow: 0 0 0 0.18rem rgba(59,174,160,0.15);
	}

	.join-inline {
		display: flex;
		align-items: center;
		gap: 8px;
	}

	.join-help {
		display: block;
		font-size: 12px;
		color: #8a9694;
		margin-top: 6px;
	}

	.join-actions {
		display: flex;
		justify-content: center;
		padding: 24px 30px 30px;
		background: #f8fbf9;
		border-top: 1px solid #edf2ef;
	}

	.join-btn-check {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		height: 40px;
		border-radius: 10px;
		background: #314a43;
		border-color: #314a43;
		font-size: 13px;
		font-weight: 800;
		padding: 0 14px 1px;
		line-height: 1;
		white-space: nowrap;
	}

	.join-btn-submit {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		min-width: 170px;
		height: 44px;
		border-radius: 999px;
		font-size: 15px;
		font-weight: 900;
		background: #1f3d32;
		border-color: #1f3d32;
		padding: 0 22px 1px;
		line-height: 1;
	}

	@media (max-width: 767.98px) {
		.join-wrap {
			margin-top: 36px;
		}

		.join-section,
		.join-actions {
			padding-left: 18px;
			padding-right: 18px;
		}

		.join-section__head {
			display: block;
		}

		.join-section__head span {
			display: block;
			margin-top: 6px;
		}

		.join-inline {
			flex-wrap: wrap;
		}
	}
</style>

<div class="join-wrap">
	<div class="join-title">
		<h4>회원 가입</h4>
		<p>필수 정보를 입력하면 주문과 배송 조회를 더 편하게 이용할 수 있습니다.</p>
	</div>

	<form name="form2" method="post" action="member_insert.php" class="join-form">
		<input type="hidden" name="check_id" value="">

		<div class="join-section">
			<div class="join-section__head">
				<h5>계정 정보</h5>
				<span>로그인에 사용하는 기본 정보입니다.</span>
			</div>

			<div class="row">
				<div class="col-md-6 join-field">
					<label>아이디 <span class="join-required">*</span></label>
					<div class="join-inline">
						<input type="text" name="uid" value="" class="form-control flex-grow-1">
						<a href="javascript:check_id();" class="btn btn-secondary text-white join-btn-check">중복 확인</a>
					</div>
				</div>

				<div class="col-md-6 join-field">
					<label>이름 <span class="join-required">*</span></label>
					<input type="text" name="name" value="" class="form-control">
				</div>

				<div class="col-md-6 join-field">
					<label>비밀번호 <span class="join-required">*</span></label>
					<input type="password" name="pwd" value="" pattern="^([a-z0-9_]){6,50}$" placeholder="영문자, 숫자, 밑줄만 이용" class="form-control">
					<span class="join-help">6자 이상, 영문 소문자/숫자/밑줄 조합</span>
				</div>

				<div class="col-md-6 join-field">
					<label>비밀번호 확인 <span class="join-required">*</span></label>
					<input type="password" name="pwd1" value="" pattern="^([a-z0-9_]){6,50}$" placeholder="비밀번호를 한 번 더 입력" class="form-control">
				</div>
			</div>
		</div>

		<div class="join-section">
			<div class="join-section__head">
				<h5>연락처 정보</h5>
				<span>주문 안내와 본인 확인에 사용됩니다.</span>
			</div>

			<div class="row">
				<div class="col-md-6 join-field">
					<label>핸드폰 <span class="join-required">*</span></label>
					<div class="join-inline">
						<input type="text" name="tel1" maxlength="3" value="010" class="form-control text-center" style="width:74px">
						<span>-</span>
						<input type="text" name="tel2" maxlength="4" value="" class="form-control text-center" style="width:92px">
						<span>-</span>
						<input type="text" name="tel3" maxlength="4" value="" class="form-control text-center" style="width:92px">
					</div>
				</div>

				<div class="col-md-6 join-field">
					<label>E-Mail <span class="join-required">*</span></label>
					<input type="text" name="email" value="" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" class="form-control" placeholder="contact@example.com">
				</div>

				<div class="col-md-6 join-field">
					<label>생일 <span class="join-required">*</span></label>
					<div class="join-inline">
						<input type="text" name="birthday1" maxlength="4" value="" class="form-control text-center" placeholder="YYYY" style="width:92px">
						<span>-</span>
						<input type="text" name="birthday2" maxlength="2" value="" class="form-control text-center" placeholder="MM" style="width:74px">
						<span>-</span>
						<input type="text" name="birthday3" maxlength="2" value="" class="form-control text-center" placeholder="DD" style="width:74px">
					</div>
				</div>
			</div>
		</div>

		<div class="join-section">
			<div class="join-section__head">
				<h5>배송지 정보</h5>
				<span>첫 주문 시 기본 배송지로 사용할 주소입니다.</span>
			</div>

			<div class="join-field">
				<label>주소 <span class="join-required">*</span></label>
				<div class="join-inline mb-2">
					<input type="text" name="zip" id="zip11" maxlength="5" value="" class="form-control" style="width:110px">
					<a href="javascript:FindZip(0);" class="btn btn-secondary text-white join-btn-check">우편번호 찾기</a>
				</div>
				<input type="text" name="juso" id="juso11" value="" class="form-control" placeholder="주소를 입력하세요">
			</div>
		</div>

		<div class="join-actions">
			<a href="javascript:Check_Value();" class="btn btn-dark text-white join-btn-submit">회원가입</a>
		</div>
	</form>
</div>

<br><br>

<?
include "main_bottom.php";
?>
