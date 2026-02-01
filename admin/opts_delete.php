<?
	include "common.php";
	
	$id=$_REQUEST["id"];
	$id1=$_REQUEST["id1"];
	
	$sql="delete from opts where id=$id1 ";
	$result=mysqli_query($db,$sql);
	if(!$result)exit("에러: $sql");
	
	echo("<script>location.href='opts.php?id=$id'</script>");
?>