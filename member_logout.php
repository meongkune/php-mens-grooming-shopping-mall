<?
	include "common.php";
	
    setcookie("cookie_id","");  
	
	$n_cart = $_COOKIE["n_cart"]; 
	$cart = $_COOKIE["cart"]; 
	
	for ($i = 1; $i <= $n_cart; $i++) {
			if ($cart[$i]) 
			  setcookie("cart[$i]",""); //cookie값 삭제.
			}
			setcookie("n_cart", "");
	
	echo("<script>location.href='index.html'</script>");
?>