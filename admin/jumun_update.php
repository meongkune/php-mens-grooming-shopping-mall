<?
	include "common.php";
	
	$id=$_REQUEST["id"];
	$state=$_REQUEST["state"];

	
	$sql="update jumun set state=$state where id='$id'";	
	$result=mysqli_query($db,$sql);
	if (!$result) exit("에러: $sql");
	
	echo("<script>location.href='jumun.php'</script>");
	
?>		