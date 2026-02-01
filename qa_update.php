<?
	include "common.php";
	
	$id=$_REQUEST["id"];
	
	$title=addslashes($_REQUEST["title"]);
	
	$name=$_REQUEST["name"];
	$passwd=$_REQUEST["passwd"];	
	
	$contents=addslashes($_REQUEST["contents"]);
	
	$sql="update qa set title='$title' ,name='$name' , passwd='$passwd' , contents='$contents' 
		  where id=$id";
	$result=mysqli_query($db,$sql);
	if (!$result) exit("에러: $sql");	
	
	echo("<script>location.href='qa.php'</script>");

?>