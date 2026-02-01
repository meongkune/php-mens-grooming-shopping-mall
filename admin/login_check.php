<?
	include "common.php";
	
	/* 
	setcookie("$cookie_admin",)
 */	
	$adminid = $_REQUEST["adminid"];
	$adminpw = $_REQUEST["adminpw"];
	

	/* $sql="select id from member where uid='$uid' and pwd='$pwd'";
	$result = mysqli_query($db, $sql);
	if (!$result) exit("에러: $sql"); */	
	
	/* $row = mysqli_fetch_array($result); //레코드 읽기
	$count = $row[0]; //레코드 개수 */
	
	if($adminid == $admin_id && $adminpw == $admin_pw)
	{
		setcookie("cookie_admin","yes");  	
		echo("<script>location.href='member.php'</script>");
		
	}
	else {
		setcookie("cookie_admin","");
		echo("<script>location.href='index.html'</script>");
	}
	
?>