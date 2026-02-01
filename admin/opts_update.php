<?
	include "common.php";
	
	$id=$_REQUEST["id"];
	$id1=$_REQUEST["id1"];
	$name=$_REQUEST["name"];
	
	$sql="update opts set name='$name' where id=$id1";
	
	$result=mysqli_query($db,$sql);
	if (!$result) exit("에러: $sql");
	
	echo("<script>location.href='opts.php?id=$id'</script>");
	
?>	
	