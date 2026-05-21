<?
include "main_top.php";
?>

<script>
	function Check_Value() {
		if (!form2.title.value) {
			alert('글 제목을 입력하여 주십시오');
			form2.title.focus();
			return;
		}
		if (!form2.name.value) {
			alert('이름을 입력하여 주십시오');
			form2.name.focus();
			return;
		}
		if (!form2.passwd.value) {
			alert('암호를 입력하여 주십시오');
			form2.passwd.focus();
			return;
		}
		form2.submit();
	}
</script>

<div class="clean-page">
	<div class="clean-head">
		<h4>Q &amp; A</h4>
		<p>문의 내용을 남겨주시면 확인 후 답변드립니다.</p>
	</div>

	<form name="form2" method="post" action="qa_insert.php" class="clean-card clean-form">
		<div class="clean-section">
			<div class="clean-section-head">
				<h5>문의 작성</h5>
				<span>제목, 작성자, 비밀번호는 필수입니다.</span>
			</div>

			<div class="clean-field">
				<label>제목 <span class="clean-required">*</span></label>
				<input type="text" name="title" class="form-control">
			</div>

			<div class="row">
				<div class="col-md-6 clean-field">
					<label>작성자 <span class="clean-required">*</span></label>
					<input type="text" name="name" class="form-control">
				</div>
				<div class="col-md-6 clean-field">
					<label>비밀번호 <span class="clean-required">*</span></label>
					<input type="password" name="passwd" class="form-control">
				</div>
			</div>

			<div class="clean-field">
				<label>내용</label>
				<textarea name="contents" class="form-control"></textarea>
			</div>
		</div>

		<div class="clean-actions">
			<a href="javascript:Check_Value();" class="btn clean-btn clean-btn-primary">저장</a>
			<a href="javascript:history.back()" class="btn clean-btn clean-btn-secondary">목록</a>
		</div>
	</form>
</div>

<br><br><br>

<?
include "main_bottom.php";
?>
