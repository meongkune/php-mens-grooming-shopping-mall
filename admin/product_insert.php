<?
	include "common.php";
	
	$id = $_REQUEST["id"];
	$menu =$_REQUEST["menu"];
	$name =$_REQUEST["name"];
	$name = addslashes($name);
	$code =$_REQUEST["code"];
	$coname =$_REQUEST["coname"];
	$price =$_REQUEST["price"];
	$opt1 =$_REQUEST["opt1"];
	$opt2 =$_REQUEST["opt2"];
	$contents =$_REQUEST["contents"];
	$contents = addslashes($contents);
	$status =$_REQUEST["status"];
	$icon_new =$_REQUEST["icon_new"]? $_REQUEST["icon_new"]  : 0;
	$icon_hit =$_REQUEST["icon_hit"]? $_REQUEST["icon_hit"]  : 0;
	$icon_sale =$_REQUEST["icon_sale"]? $_REQUEST["icon_sale"]  : 0;
	$regday =$_REQUEST["regday"];
	/* $image1 =$_REQUEST["image1"];
	$image2 =$_REQUEST["image2"];
	$image3 =$_REQUEST["image3"]; */
	$discount =$_REQUEST["icon_sale"] ? $_REQUEST["discount"] : 0;
	
	
	$fname1 = "";

	if ($_FILES["image1"]["error"] == 0)  // 선택한 그림파일이 있는지 조사
	{
		$fname1 = $_FILES["image1"]["name"];  // 그림 파일이름
		if (!move_uploaded_file($_FILES["image1"]["tmp_name"],
			"../product/$fname1")) exit("업로드 실패.");
	}
	
	$fname2= "";

	if ($_FILES["image2"]["error"] == 0)  // 선택한 그림파일이 있는지 조사
	{
		$fname2 = $_FILES["image2"]["name"];  // 그림 파일이름
		if (!move_uploaded_file($_FILES["image2"]["tmp_name"],
			"../product/$fname2")) exit("업로드 실패.");
	}
	
	$fname3 = "";

	if ($_FILES["image3"]["error"] == 0)  // 선택한 그림파일이 있는지 조사
	{
		$fname3 = $_FILES["image3"]["name"];  // 그림 파일이름
		if (!move_uploaded_file($_FILES["image3"]["tmp_name"],
			"../product/$fname3")) exit("업로드 실패.");
	}
	

	$sql = "INSERT INTO product( menu, code, name, coname, price, opt1, opt2, contents, status, regday, icon_new, 
	icon_hit, icon_sale, discount, image1, image2, image3) VALUES ( $menu, '$code', '$name', '$coname', $price, $opt1, $opt2, 
	'$contents', $status, '$regday', $icon_new, $icon_hit, $icon_sale, $discount, '$fname1', '$fname2', '$fname3')";
	
	$result=mysqli_query($db,$sql);
	if (!$result) exit("에러: $sql");
	
	echo("<script>location.href='product.php'</script>");
?>