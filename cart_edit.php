<?
	include "common.php";
	$cart = $_COOKIE["cart"];        // 장바구니: 제품정보(배열)          없으면 null 또는 빈 배열 비슷하게 됨
    $n_cart = $_COOKIE["n_cart"];    // 장바구니: 제품개수                  없으면 null
    $kind = $_REQUEST["kind"];
	$pos = $_REQUEST["pos"];
	
	$id = $_REQUEST["id"];
	$num = $_REQUEST["num"]; 
	//$opts_id1 = $_REQUEST["opts1"];
	//$opts_id2 = $_REQUEST["opts2"];
	$opts_id1 = ($_REQUEST["opts1"] === "") ? null : $_REQUEST["opts1"]; //어차피 none이 넘어가는것도 문자열이라서 이 삼항연산자는 무조건 후자의 값으로 넘어갈수 밖에없네.
	$opts_id2 = ($_REQUEST["opts2"] === "") ? null : $_REQUEST["opts2"];
	
	
	$extra_price = $_REQUEST["extra_price"] ?? 0;
	
	
if (!$n_cart) $n_cart = 0;        // 장바구니 제품개수($n_cart) 초기화
   switch ($kind)
   {
	   
	   
	   
case "insert":
case "order":
    $n_cart++;
    $cart[$n_cart] = implode("^", array($id, $num, $opts_id1, $opts_id2, $extra_price));  // ⬅ extra_price 포함
    setcookie("cart[$n_cart]", $cart[$n_cart]);
    setcookie("n_cart", $n_cart);
    break;

case "delete":                  // 장바구니 삭제
       setcookie("cart[$pos]",""); // 쿠키 값 삭제.
       break;

case "update":
    list($id, $old_num, $opts_id1, $opts_id2, $extra_price) = explode("^", $cart[$pos]);
    $num = $_REQUEST["num"];  // 새 수량만 반영
    $cart[$pos] = implode("^", array($id, $num, $opts_id1, $opts_id2, $extra_price));  // 기존 옵션/가격 유지
    setcookie("cart[$pos]", $cart[$pos]);
    break;

 
case "deleteall":              // 장바구니 전체 비우기
       for ($i = 1; $i <= $n_cart; $i++) {
           if ($cart[$i]) 
			  setcookie("cart[$i]",""); //cookie값 삭제.
       }
       $n_cart = 0; //$n_cart 쿠키값을 0으로 초기화.
	   setcookie("n_cart", $n_cart);
       break;
   }

if ($kind == "order")
   echo("<script>location.href='order.php'</script>");
else
   echo("<script>location.href='cart.php'</script>");
  
?>