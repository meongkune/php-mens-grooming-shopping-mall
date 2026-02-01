<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
?>

<?
	include "common.php";
	
	//주문자 정보
	$o_name=$_REQUEST["o_name"];
	$o_tel = $_REQUEST["o_tel"];
	$o_email=$_REQUEST["o_email"];
	$o_zip=$_REQUEST["o_zip"];
	$o_juso=$_REQUEST["o_juso"];
	
	//배송자 정보
	$r_name=$_REQUEST["r_name"];
	$r_tel = $_REQUEST["r_tel"];
	$r_email=$_REQUEST["r_email"];
	$r_zip=$_REQUEST["r_zip"];
	$r_juso=$_REQUEST["r_juso"];
	$memo=$_REQUEST["memo"];
	
	//결제정보
	$pay_kind=$_REQUEST["pay_kind"];
	
	$card_kind=$_REQUEST["card_kind"];      // ?$_REQUEST["card_kind"]:0; 할부랑 카드 종류에 관해서 테스트해보니 무통장으로 선택해서 카드쪽 선택 항목들이 
											// 막혀있다한들 기본 값이 0들이기에 값은 어케해서든 일로 넘어오게되어있음 추가로 내가 우리카드 선택하고 9개월 했다가 
											// 무통장으로 선택해서 최종 결제해도 3,9 값들이 넘어오게 되어있음
	$card_no1=$_REQUEST["card_no1"];//카드번호 는 테이블에 저장 안함
	$card_no2=$_REQUEST["card_no2"];//카드번호 는 테이블에 저장 안함
	$card_no3=$_REQUEST["card_no3"];//카드번호 는 테이블에 저장 안함
	$card_no4=$_REQUEST["card_no4"];//카드번호 는 테이블에 저장 안함
	$card_month=$_REQUEST["card_month"];//카드기간 는 테이블에 저장 안함
	$card_year=$_REQUEST["card_year"];//카드기간 는 테이블에 저장 안함
	$card_pw=$_REQUEST["card_pw"];//카드암호 는 테이블에 저장 안함
	$card_halbu=$_REQUEST["card_halbu"]; //?$_REQUEST["card_halbu"]:0;
	
	
	$bank_kind=$_REQUEST["bank_kind"];  //?$_REQUEST["bank_kind"]:0;
	$bank_sender=$_REQUEST["bank_sender"];  //?$_REQUEST["bank_sender"]:"";
	
	//새주문번호 
	$sql="select id from jumun where jumunday=curdate() order by id desc limit 1"; 
	$result=mysqli_query($db,$sql);
	if (!$result) exit("에러: $sql");    
	$count=mysqli_num_rows($result);
	$row = mysqli_fetch_array($result);

	$today=date("Ymd");
	$today=substr($today,-6);
	
	if ($count>0){    // 주문번호가 있으면
		 $previous_id = $row['id'];
		 $substr_id=(int)substr($previous_id,-4);// 정수 변환
		 $substr_id++; //0002 → 3
		 $substr_id = sprintf("%04d", $substr_id); // 3 → "0003"
		 $new_id = $today . $substr_id;} //새주문번호 = 오늘날짜 . (가장 큰 주문번호 뒤 4자리 + 1);
	else
		 $new_id = $today . "0001"; //새주문번호 = 오늘날짜 . "0001";


	$card_okno=$new_id; // 카드승인번호는 주문번호로 대체
	$card_okno=($pay_kind==0) ? $card_okno : ""; //무통장일 경우엔 없어야지 않나 싶어? 교수님걸로 확인함! 
	
	
	 
	$jumun_id=$new_id; //새주문번호 $jumun_id를 알아낸다.
	$totalprice = 0;//총금액=0;
	
	$product_nums = 0;
	$product_names = "";
	
	$cart = $_COOKIE["cart"];
	$n_cart = $_COOKIE["n_cart"];
	
	for($i=1;$i<=$n_cart;$i++)
	{	
		if ($cart[$i])        // 제품정보가 있는 경우만
		{
			// 장바구니 cookie에서 제품번호, 수량, 소옵션번호1,2 알아내기
			list($product_id, $num, $opts_id1, $opts_id2, $extra_price) = explode("^", $cart[$i]);

$opts_id1 = ($opts_id1 == 'none' || empty($opts_id1)) ? 'NULL' : (int)$opts_id1;
$opts_id2 = ($opts_id2 == 'none' || empty($opts_id2)) ? 'NULL' : (int)$opts_id2;
$extra_price = (int)$extra_price;

$sql="select * from product where id=$product_id";
$result = mysqli_query($db, $sql);
if (!$result) exit("에러: $sql");
$row = mysqli_fetch_array($result);

if($row["icon_sale"]==1)
    $base_price = round($row["price"] * (100 - $row["discount"]) / 100);
else
    $base_price = $row["price"];

$price = $base_price + $extra_price;  // 옵션가 반영된 단가
$prices = $price * $num;
$discount = $row["discount"];

$sql = "INSERT INTO jumuns (jumun_id, product_id, num, price, prices, discount, opts_id1, opts_id2)
        VALUES ($jumun_id, $product_id, $num, $price, $prices, $discount, $opts_id1, $opts_id2)";
$result = mysqli_query($db, $sql);
if (!$result) exit("에러: $sql");

setcookie("cart[$i]", "");
$totalprice += $prices;
$product_nums++;
if ($product_nums == 1) $product_names = $row["name"];

		}
	}
		if ($product_nums > 1)    // 제품수가 2개 이상인 경우만, '외 ?' 추가
		{
			$tmp = $product_nums - 1;
			$product_names = $product_names . " 외 " . $tmp;
		} 

	 	
	if ($totalprice < $max_baesongbi )    // 배송비가 있는 경우 약간 의아한 조건문? 왜 굳이? 이 레코드를 추가하는거지
		{ $sql="INSERT INTO jumuns ( jumun_id, product_id, num, price, prices, discount , opts_id1, opts_id2) VALUES ($jumun_id,0,1,$baesongbi,$baesongbi,0,0,0)"; // insert SQL문을 이용하여 jumuns테이블에 배송비 정보 저장.
		  $result=mysqli_query($db,$sql);
		  if (!$result) exit("에러: $sql");
		  
		  $totalprice = $totalprice + $baesongbi;// 총금액 = 총금액 + 배송비;
	}
	
	$cookie_id=$_COOKIE["cookie_id"];
	
	//주문자가 회원인지 비회원인지 조사 ($cookie_id).
	if ($cookie_id)
		$member_id = $cookie_id;
	else
		$member_id = 0;	
	
	$jumunday=date("Y-m-d"); //주문일
	
	$state = 1; //state는 주문신청인 1로 지정해야한다고 책이 적혀있네?는데 관리자쪽에서 1~6까지에 대한 주문신청 주문확인 입금확인 등 다양한 상황 설정해놨으니 지금은 당장의 책에 있는대로
	
	$product_names=addslashes($product_names);
	$memo=addslashes($memo);
	
	$sql="INSERT INTO jumun (`id`, `member_id`, `jumunday`, `product_names`, `product_nums`, 
	`o_name`, `o_tel`, `o_email`, `o_zip`, `o_juso`, 
	`r_name`, `r_tel`, `r_email`, `r_zip`, `r_juso`, `memo`, 
	`pay_kind`, `card_okno`, `card_halbu`, `card_kind`,
	`bank_kind`, `bank_sender`,
	`totalprice`, `state`) 
	VALUES ('$jumun_id', $member_id,'$jumunday','$product_names',$product_nums ,'$o_name','$o_tel','$o_email','$o_zip','$o_juso','$r_name','$r_tel','$r_email','$r_zip','$r_juso','$memo',
	$pay_kind,'$card_okno',$card_halbu,$card_kind,$bank_kind,'$bank_sender',$totalprice, $state)";

	$result=mysqli_query($db,$sql);
	if (!$result) exit("에러: $sql");

	echo("<script>location.href='order_ok.php'</script>");
?>
	