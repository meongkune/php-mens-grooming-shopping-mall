<?
	include "common.php";

	$id=$_REQUEST["id"];
	$passwd=$_REQUEST["passwd"];
	
	
	$sql="select * from qa where id=$id";
	
	$result=mysqli_query($db,$sql);
	if (!$result) exit("에러: $sql");
	
	$row= mysqli_fetch_array($result);
	
	if($passwd != $row["passwd"]){ // if($passwd <> $row["passwd"])
		echo("<script>
	alert(
	      '일치하지 않는 비밀번호입니다\\n' +
		  '암호 입력 다시 해보고 틀리면 니 말 맞음.'
	);
	history.back();</script>");}
	
	$sql="delete from qa where id=$id";
	
	$result=mysqli_query($db,$sql);
	if (!$result) exit("에러: $sql");	
	
	echo("<script>location.href='qa.php'</script>");
?>	