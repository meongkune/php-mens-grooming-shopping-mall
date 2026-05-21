<?
include "main_top.php";

$id=$_REQUEST["id"];
$text1=$_REQUEST["text1"] ?? "";

$sql="select * from qa where id=$id";
$result=mysqli_query($db,$sql);
if (!$result) exit("에러: $sql");
$row= mysqli_fetch_array($result);

$contents=stripslashes($row["contents"]);
$contents=nl2br($contents);
?>

<script>
	function Go_Reply()	{
		form2.action="qa_reply.php";
		form2.submit();
	}

	function Check_Modify()	{
		if (form2.passwd.value)
		{
				form2.action="qa_edit.php";
				form2.submit();
		}
		else
		{
			alert('암호를 입력하세요.');
			form2.passwd.focus();
		}
		return;
	}

	function Check_Delete()	{
		if (form2.passwd.value)
		{
				form2.action="qa_delete.php";
				form2.submit();
		}
		else
		{
			alert('암호를 입력하세요.');
			form2.passwd.focus();
		}
		return;
	}
</script>

<div class="clean-page">
	<div class="clean-head">
		<h4>Q &amp; A</h4>
		<p>문의 내용을 확인하고 답변, 수정, 삭제를 진행할 수 있습니다.</p>
	</div>

	<div class="clean-card">
		<div class="clean-meta-grid">
			<div class="label">제목</div>
			<div><?=htmlspecialchars(stripslashes($row["title"])); ?></div>
			<div class="label">작성자</div>
			<div><?=$row["name"]; ?></div>
			<div class="label">작성일</div>
			<div><?=$row["writeday"]; ?></div>
			<div class="label">조회</div>
			<div><?=$row["count"]; ?></div>
		</div>
		<div class="clean-content-box">
			<?=$contents; ?>
		</div>
	</div>

<?
$count=$row["count"];
$sql1="update qa set count=$count+1 where id=$id";
$result1=mysqli_query($db,$sql1);
if (!$result1) exit("에러: $sql1");
?>

	<form name="form2" method="post" action="" class="clean-card clean-form mt-3">
		<input type="hidden" name="page" value="1">
		<input type="hidden" name="text1" value="<?=$text1;?>">
		<input type="hidden" name="id" value="<?=$id;?>">

		<div class="clean-section">
			<div class="row align-items-end">
				<div class="col-md-4 clean-field mb-md-0">
					<label>비밀번호</label>
					<input type="password" name="passwd" class="form-control">
				</div>
				<div class="col-md-8 text-md-end">
					<a href="javascript:Go_Reply();" class="btn clean-btn clean-btn-primary">답글</a>
					<a href="javascript:Check_Modify();" class="btn clean-btn clean-btn-secondary">수정</a>
					<a href="javascript:Check_Delete();" class="btn clean-btn clean-btn-secondary">삭제</a>
					<a href="javascript:history.back()" class="btn clean-btn clean-btn-secondary">목록</a>
				</div>
			</div>
		</div>
	</form>
</div>

<br><br><br>

<?
include "main_bottom.php";
?>
