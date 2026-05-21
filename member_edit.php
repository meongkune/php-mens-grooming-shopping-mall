<?
include "main_top.php";

$cookie_id = $_COOKIE["cookie_id"];

$sql = "select * from member where id=$cookie_id ";
$result=mysqli_query($db,$sql);
if (!$result) exit("에러: $sql");
$row=mysqli_fetch_array($result);

$tel1=trim(substr($row["tel"],0,3));
$tel2=trim(substr($row["tel"],3,4));
$tel3=trim(substr($row["tel"],7,4));

$birthday1=trim(substr($row["birthday"],0,4));
$birthday2=trim(substr($row["birthday"],5,2));
$birthday3=trim(substr($row["birthday"],8,2));
?>

<script>
	function FindZip(zip_kind)
	{
		window.open("zipcode.php?zip_kind="+zip_kind, "", "scrollbars=no,width=490,height=320");
	}

	function Check_Value() {
		if (form2.pwd.value != form2.pwd1.value) {
			alert("암호가 일치하지 않습니다.");
			form2.pwd.focus();	return;
		}
		if (!form2.name.value) {
			alert("이름이 잘못되었습니다.");	form2.name.focus();	return;
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

<div class="clean-page">
	<div class="clean-head">
		<h4>회원정보 수정</h4>
		<p>계정 정보와 배송에 필요한 기본 정보를 관리합니다.</p>
	</div>

	<form name="form2" method="post" action="member_update.php" class="clean-card clean-form">
		<div class="clean-section">
			<div class="clean-section-head">
				<h5>계정 정보</h5>
				<span>아이디는 변경할 수 없습니다.</span>
			</div>
			<div class="row">
				<div class="col-md-6 clean-field">
					<label>아이디</label>
					<input type="text" value="<?=$row["uid"]; ?>" class="form-control" readonly>
				</div>
				<div class="col-md-6 clean-field">
					<label>이름 <span class="clean-required">*</span></label>
					<input type="text" name="name" value="<?=$row["name"]; ?>" class="form-control">
				</div>
				<div class="col-md-6 clean-field">
					<label>새 비밀번호</label>
					<input type="password" name="pwd" value="" class="form-control">
					<span class="clean-help">변경할 때만 입력하세요.</span>
				</div>
				<div class="col-md-6 clean-field">
					<label>새 비밀번호 확인</label>
					<input type="password" name="pwd1" value="" class="form-control">
				</div>
			</div>
		</div>

		<div class="clean-section">
			<div class="clean-section-head">
				<h5>연락처 정보</h5>
				<span>주문 안내와 본인 확인에 사용됩니다.</span>
			</div>
			<div class="row">
				<div class="col-md-6 clean-field">
					<label>핸드폰 <span class="clean-required">*</span></label>
					<div class="clean-inline">
						<input type="text" name="tel1" maxlength="3" value="<?=$tel1; ?>" class="form-control text-center" style="width:74px">
						<span>-</span>
						<input type="text" name="tel2" maxlength="4" value="<?=$tel2; ?>" class="form-control text-center" style="width:92px">
						<span>-</span>
						<input type="text" name="tel3" maxlength="4" value="<?=$tel3; ?>" class="form-control text-center" style="width:92px">
					</div>
				</div>
				<div class="col-md-6 clean-field">
					<label>E-Mail <span class="clean-required">*</span></label>
					<input type="text" name="email" value="<?=$row["email"]; ?>" class="form-control">
				</div>
				<div class="col-md-6 clean-field">
					<label>생일 <span class="clean-required">*</span></label>
					<div class="clean-inline">
						<input type="text" name="birthday1" maxlength="4" value="<?=$birthday1; ?>" class="form-control text-center" style="width:92px">
						<span>-</span>
						<input type="text" name="birthday2" maxlength="2" value="<?=$birthday2; ?>" class="form-control text-center" style="width:74px">
						<span>-</span>
						<input type="text" name="birthday3" maxlength="2" value="<?=$birthday3; ?>" class="form-control text-center" style="width:74px">
					</div>
				</div>
			</div>
		</div>

		<div class="clean-section">
			<div class="clean-section-head">
				<h5>배송지 정보</h5>
				<span>기본 배송 주소입니다.</span>
			</div>
			<div class="clean-field">
				<label>주소 <span class="clean-required">*</span></label>
				<div class="clean-inline mb-2">
					<input type="text" name="zip" maxlength="5" value="<?=$row["zip"]; ?>" class="form-control" style="width:110px">
					<a href="javascript:FindZip(0);" class="btn clean-btn clean-btn-primary">우편번호 찾기</a>
				</div>
				<input type="text" name="juso" value="<?=$row["juso"]; ?>" class="form-control">
			</div>
		</div>

		<div class="clean-actions">
			<a href="javascript:Check_Value();" class="btn clean-btn clean-btn-primary" style="min-width:170px">회원정보 수정</a>
		</div>
	</form>
</div>

<br><br>

<?
include "main_bottom.php";
?>
