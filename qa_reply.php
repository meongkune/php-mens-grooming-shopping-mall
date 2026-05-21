<?
include "main_top.php";

$id=$_REQUEST["id"];

$sql="select * from qa where id=$id";
$result=mysqli_query($db,$sql);
if (!$result) exit("에러: $sql");
$row=mysqli_fetch_array($result);

$pos1=$row["pos1"];
$pos2=$row["pos2"];

$title = $row["title"];
if (stripos($title, "Re:") !== 0) {
	$title = "Re:" . $title;
}
$title = stripslashes($title);

$contents = stripslashes($row["contents"]);
$original_name = $row["name"];
$quoted_lines = explode("\n", $contents);
$quoted_text = "";
foreach ($quoted_lines as $line) {
	$quoted_text .= ":: " . $line . "\n";
}
$contents = ":: " . $original_name . "님의 글\n" . $quoted_text . "\n답변: ";
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
		<p>문의글에 답변을 작성합니다.</p>
	</div>

	<form name="form2" method="post" action="qa_insertreply.php" class="clean-card clean-form">
		<input type="hidden" name="page" value="1">
		<input type="hidden" name="text1" value="">
		<input type="hidden" name="id" value="<?=$id;?>">
		<input type="hidden" name="pos1" value="<?=$pos1;?>">
		<input type="hidden" name="pos2" value="<?=$pos2;?>">

		<div class="clean-section">
			<div class="clean-section-head">
				<h5>답변 작성</h5>
				<span>기존 문의 내용은 본문에 인용됩니다.</span>
			</div>

			<div class="clean-field">
				<label>제목 <span class="clean-required">*</span></label>
				<input type="text" name="title" value="<?=htmlspecialchars($title);?>" class="form-control">
			</div>

			<div class="row">
				<div class="col-md-6 clean-field">
					<label>작성자 <span class="clean-required">*</span></label>
					<input type="text" name="name" value="" class="form-control">
				</div>
				<div class="col-md-6 clean-field">
					<label>비밀번호 <span class="clean-required">*</span></label>
					<input type="password" name="passwd" value="<?=$row["passwd"];?>" class="form-control">
				</div>
			</div>

			<div class="clean-field">
				<label>내용</label>
				<textarea name="contents" class="form-control"><?=htmlspecialchars($contents);?></textarea>
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
