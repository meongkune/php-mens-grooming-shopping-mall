<?
	include "common.php";
	
	if ($_COOKIE["cookie_admin"] != "yes") {
        echo "<script>
            alert('관리자 로그인이 필요합니다!');
            location.href='index.html';
        </script>";
        exit();
    }
	
	$sql = "SELECT * FROM opt ORDER BY id ";
	$result = mypagination($sql, $args, $count, $pagebar);

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

<script> document.write(admin_menu());</script>


<div class="row mx-1  justify-content-center">
	<div class="col-sm-10" align="center">

		<h4 class="m-0">옵션</h4>

		<div class="row myfs13">
			<div class="col" align="left" style="padding-top:8px"">
				&nbsp;옵션수 : <font color="red"><?= $count; ?></font>
			</div>
			<div class="col" align="right">
				<a href="opt_new.html" class="btn btn-sm mycolor1 myfs12">옵션 추가</a>&nbsp;
			</div>
		</div>
		</form>

		<table class="table table-sm table-bordered table-hover my-1">
			<tr class="bg-light">
				<td width="10%">번호</td>
				<td>옵션명</td>
				<td width="25%">수정 / 삭제</td>
				<td width="25%">소옵션 편집</td>
			</tr>
			<? 
	foreach($result as $row)
	{
		 $id=$row["id"];
		 
?>
	<tr>
	<td><?=$id; ?></td>
	<td><?=$row["name"]; ?></td>
	<td>
				<a href="opt_edit.php?id=<?=$id; ?>" class="btn btn-sm mybutton-blue">수정</a>
					<a href="opt_delete.php?id=<?=$id; ?>" class="btn btn-sm mybutton-red" 
						onclick="javascript:return confirm('삭제할까요 ?');">삭제</a>				
				</td>
				<td>
					<a href="opts.php?id=<?=$id; ?>" class="btn btn-sm mybutton-gray">소옵션 편집</a>
				</td>
	</tr>
<?
	}
?>
	
			
		</table>
	</div>
</div>
<?
echo $pagebar;
?>
<!-------------------------------------------------------------------------------------------->	
</div>

</body>
</html>
