<?
	include "common.php";
	$n_cart = $_COOKIE["n_cart"]; 
	$cart = $_COOKIE["cart"]; 
	/* $id = $_REQUEST["id"];	 */
	$uid = $_REQUEST["uid"];
	$pwd = $_REQUEST["pwd"];
	

	$sql="select id, gubun from member where uid='$uid' and pwd='$pwd'";
	$result = mysqli_query($db, $sql);
	if (!$result) exit("에러: $sql");	
	
	$row = mysqli_fetch_array($result); //레코드 읽기
	$count = $row[0]; //--> $count=mysqli_num_rows($result); 이거해도 상관없는듯.. gpt한테 물어본거 있음.. 그리고 사실상 저 $count는 1일 가능성이 농후함
	
	
	if($row["gubun"]==0) 
		{if($count>0)
		{
			setcookie("cookie_id",$row["id"]); 
			for ($i = 1; $i <= $n_cart; $i++) {
			if ($cart[$i]) 
			  setcookie("cart[$i]",""); //cookie값 삭제.
			}
			setcookie("n_cart", "");
			echo("<script>location.href='index.html'</script>"); //main.php로 가는 거임
			
		}
		else
			echo("<script>location.href='member_login.php'</script>");
		
		}
		
	else	{
?>		
		<script>
	function Check_gubun() {
		
			alert("이미 탈퇴한 회원이니까 다른 걸로 접속해봐!!");	
			return;
	}
	Check_gubun();
		</script>

	
<?	
			}
	
		echo("<script>location.href='member_login.php'</script>");
	
?>

