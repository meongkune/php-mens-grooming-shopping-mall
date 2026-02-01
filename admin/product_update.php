<?
	include "common.php";
	$id=$_REQUEST["id"];
	$menu =$_REQUEST["menu"];
	$code =$_REQUEST["code"];
	$name =$_REQUEST["name"];
	$name = addslashes($name);
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
	$discount =$_REQUEST["icon_sale"] ? $_REQUEST["discount"] : 0;
	
	
	
	
	$imagename1 =$_REQUEST["imagename1"]; //이미지 관련
	$checkno1 =$_REQUEST["checkno1"];
	$imagename2 =$_REQUEST["imagename2"];
	$checkno2 =$_REQUEST["checkno2"];
	$imagename3 =$_REQUEST["imagename3"];
	$checkno3 =$_REQUEST["checkno3"];
	
	
	
	
	
	$fname1 = $imagename1;              // 기존 파일이름
	if ($checkno1 == "1") $fname1 = ""; // 삭제 체크가 된 경우
	if ($_FILES["image1"]["error"] == 0) // 파일이름이 있는지 조사
	{
		$fname1 = $_FILES["image1"]["name"];
		if (!move_uploaded_file($_FILES["image1"]["tmp_name"],
			"../product/$fname1")) exit("업로드 실패.");
	}
	
	$fname2 = $imagename2;              // 기존 파일이름
	if ($checkno2 == "1") $fname2 = ""; // 삭제 체크가 된 경우
	if ($_FILES["image2"]["error"] == 0) // 파일이름이 있는지 조사
	{
		$fname2 = $_FILES["image2"]["name"];
		if (!move_uploaded_file($_FILES["image2"]["tmp_name"],
			"../product/$fname2")) exit("업로드 실패.");
	}
	
	$fname3 = $imagename3;              // 기존 파일이름
	if ($checkno3 == "1") $fname3 = ""; // 삭제 체크가 된 경우
	if ($_FILES["image3"]["error"] == 0) // 파일이름이 있는지 조사
	{
		$fname3 = $_FILES["image3"]["name"];
		if (!move_uploaded_file($_FILES["image3"]["tmp_name"],
			"../product/$fname3")) exit("업로드 실패.");
	}	


	$sql="update product set menu=$menu, code='$code',name='$name',coname='$coname',price=$price ,
	opt1=$opt1,opt2=$opt2,
	contents='$contents',status=$status,regday='$regday',
	icon_new=$icon_new, icon_hit=$icon_hit,icon_sale=$icon_sale,discount=$discount, 
	image1='$fname1',image2='$fname2',image3='$fname3' where id=$id";
	
	
	
	
	$result=mysqli_query($db,$sql);
	if (!$result) exit("에러: $sql");
	
	echo("<script>location.href='product.php'</script>");
?>