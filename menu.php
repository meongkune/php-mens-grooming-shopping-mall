<?
	include "main_top.php";
	
	$menu=$_REQUEST["menu"]?$_REQUEST["menu"]: "1";
	$sort = $_REQUEST["sort"] ?? "0";  // 기본은 아무 정렬 안 한 상태
	
	if ($sort==1)       $sql="and icon_new=1 order by id desc";   // 신상품
	elseif ($sort==2)   $sql="and icon_hit=1 order by id desc";   // 인기상품
	elseif ($sort==3)   $sql="order by name";                     // 이름순
	elseif ($sort==4)   $sql="order by price";               // 낮은 가격순
	elseif ($sort == 5) $sql="order by price desc";                    // 높은 가격순
	else                  $sql = "order by name"; // sort=0일 때도 상품명 기준으로 정렬
	$sql = "select * from product where menu=$menu and status=1 " . $sql;

	$args = "menu=$menu&sort=$sort";	
	$result = mypagination($sql, $args, $count, $pagebar);
	
	$row = mysqli_fetch_array($result);

	
?>

<!--  Category 제목 -->
<div class="row mt-5">
	<div class="col" align="center">
		<h2 style="border-bottom: none; margin-bottom: 0px;"><?=$a_menu[$menu];?></h2>

	</div>	
</div>	

<!--  상품개수 & 정렬 -->
<div class="row m-0">
	<div class="col-2" align="left" style="font-size:20px">
		Total <b><?=$count;?></b> items
	</div>	
	<div class="col" align="right" style="font-size:15px">
<?	
	$a_sort = array("정렬상태","신상품","인기상품","상품명","낮은가격","높은가격");
	$n_sort = count($a_sort);

	for($i=1; $i<$n_sort; $i++)
	{
		if ($sort != "0" && $i == $sort)
			echo("<a href='menu.php?menu=$menu&sort=$i'><b><font color='steelblue'>$a_sort[$i]</font></b></a>&nbsp;|&nbsp;");
		else
			echo("<a href='menu.php?menu=$menu&sort=$i'>$a_sort[$i]</a>&nbsp;|&nbsp;");
	}
?>	
	</div>	
</div>	
<hr class="mt-0 mb-4">

<!--  상품 진열  -->
<div class="row">
<?
	$page_line=4;
	foreach($result as $row)
	{
		 $id=$row["id"];
		 $raw_price = $row["price"]; // 원래 숫자값 유지
		 $format_price = number_format($raw_price); // 문자열로 표시용
		 $sale_price = round($raw_price * (100 - $row["discount"]) / 100); // 계산은 숫자로
		 $format_sale_price = number_format($sale_price);
		 
		 
?>		 
		<!--  상품1  -->
	<div class="col-sm-3 mb-3">
		<div class="card h-100">
			<div class="zoom_image" align="center">
			
				<a href="product_ex.php?id=<?=$id;?>"><img src="product/<?=$row["image1"];?>"
				   style="width: 100% !important; height: auto !important; object-fit: cover !important; display: block;"
				   class="card-img-top img-fluid"></a>				
					<!--height="360"  style="width: 100%; object-fit: cover;" class="card-img-top img-fluid"></a>-->
					
			</div>
			<div class="card-body bg-light" align="center" style="font-size:15px;">
				<div class="card-title">
				
					<a href="product_ex.php?id=<?=$id;?>"><?=$row["name"];?></a><br>
					<?php
	if ($row["icon_new"] == 1) {
		echo '<span class="badge badge-new">NEW</span>&nbsp;';
	}
	if ($row["icon_hit"] == 1) {
		echo '<span class="badge badge-hit">HIT</span>&nbsp;';
	}
	if ($row["icon_sale"] == 1) {
		echo '<span class="badge badge-sale">SALE ' . $row["discount"] . '%</span>';
	}
?>

 
				</div>
				<?
				if ($row["icon_sale"] == 1) {
					echo '<p class="card-text"><strike><small>₩' . $format_price . '</small></strike>&nbsp;&nbsp;<b>₩' . $format_sale_price . '</b></p>';
				}
				else {
					echo '<p class="card-text"><b>₩' . $format_price . '</b><br></p>';
				}
				?>
					
			</div>
		</div>
	</div>
<?
	}
?>
<?
	echo $pagebar;
?>

</div>
<br>

<!-------------------------------------------------------------------------------------------->	
<!-- 끝 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	

<?
	include "main_bottom.php";
?>

