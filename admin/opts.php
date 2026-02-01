<?
	include "../common.php";
	
	$id=$_REQUEST["id"];
	
	$sql= "select name from opt where id = $id" ;
	
	$result=mysqli_query($db,$sql);
	if (!$result) exit("에러: $sql");    
	$row= mysqli_fetch_array($result);
	
	$sql="select * from opts where opt_id = $id order by name";
	
	$result=mysqli_query($db,$sql);
	if (!$result) exit("에러: $sql");  
	
	$count = mysqli_num_rows($result); //쓸데가 없음


?>

<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>INDUK Mall</title>
	<link  href="../css/bootstrap.min.css" rel="stylesheet">
	<link  href="../css/my.css" rel="stylesheet">
	<script src="..js/jquery-3.7.1.min.js"></script>
	<script src="../js/bootstrap.bundle.min.js"></script>
	<script src="../js/my.js"></script>
</head>
<body>

<div class="container">
<!-------------------------------------------------------------------------------------------->	
<script> document.write(admin_menu());</script>
<!-------------------------------------------------------------------------------------------->	

<div class="row mx-1  justify-content-center">
	<div class="col-sm-10" align="center">

	<h4 class="m-0">소옵션</h4>

	<div class="row myfs13">
		<div class="col" align="left" style="padding-top:8px"">
			&nbsp;옵션명 : <font color="red"><?= $row["name"]; ?></font>
		</div>
		<div class="col" align="right">
			<div class="d-inline-flex">
				<a href="opts_new.php?id=<?=$id; ?>" class="btn btn-sm mycolor1 myfs12">소옵션 추가</a>&nbsp;
			</div>
		</div>
	</div>
	</form>

	<table class="table table-sm table-bordered table-hover my-1">
		<tr class="bg-light">
			<td width="25%">소옵션 번호</td>
			<td>소옵션명</td>
			<td width="25%">수정 / 삭제</td>
		</tr>
	
	<?	while ($opt = mysqli_fetch_array($result)):?>
	<tr>
	<td><?=$opt["id"]; ?></td>
	<td><?=$opt["name"]; ?></td>
	
			<td>
				<a href="opts_edit.php?id=<?=$id; ?>&id1=<?=$opt["id"]; ?>" class="btn btn-sm mybutton-blue">수정</a>
				<a href="opts_delete.php?id=<?=$id; ?>&id1=<?=$opt["id"]; ?>" class="btn btn-sm mybutton-red" onclick="javascript:return confirm('삭제할까요 ?');">삭제</a>				
			</td>
	</tr>
<?
	endwhile;
?>
		
	</table>

	<a href="opt.php"  class="btn btn-sm btn-outline-dark my-2">&nbsp;돌아가기&nbsp;</a>

	</div>
</div>
<!-------------------------------------------------------------------------------------------->	
</div>

</body>
</html>
