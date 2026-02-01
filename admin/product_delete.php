<?
	include "common.php";
	
	$id=$_REQUEST["id"];
	
	
	$sql="delete from product where id=$id ";
	$result=mysqli_query($db,$sql);
	if(!$result)exit("에러: $sql");
	
	echo("<script>location.href='product.php'</script>");
?>