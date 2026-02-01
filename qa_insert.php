<?
	include "common.php";
	
	$title = addslashes($_REQUEST["title"]);
	
	$name=$_REQUEST["name"];
	$passwd=$_REQUEST["passwd"];
	
	$contents = addslashes($_REQUEST["contents"]);
	
	$writeday=date("Y-m-d");
	
	
	$sql = "INSERT INTO `qa`(`title`, `name`, `passwd`, `writeday`, `count`, `contents`) 
		    VALUES ('$title','$name','$passwd','$writeday',0,'$contents')";		
	$result=mysqli_query($db,$sql);
	if (!$result) exit("에러: $sql");	

	$insert_id = mysqli_insert_id($db);
	
	$sql="update qa set pos1=$insert_id ,pos2='A' where id=$insert_id";
	$result=mysqli_query($db,$sql);
	if (!$result) exit("에러: $sql");	
	
	echo("<script>location.href='qa.php'</script>");

?>