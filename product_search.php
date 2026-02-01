<?
	include "main_top.php";
	
	/* $id=$_REQUEST["id"]; */
?>

<!-------------------------------------------------------------------------------------------->	
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	
<div class="row m-1 mt-4 mb-0">
	<div class="col" align="center">

		<h4 class="m-3">상품검색</h4>

		<hr class="m-0">
		<table class="table table-sm mb-4">
			<tr height="40" class="bg-light">
				<td width="15%">이미지</td>
				<td width="45%">상품정보</td>
				<td width="20%">판매가</td>
				<td width="20%">금액</td>
			</tr>
	<? 
	foreach($result as $row)
	{
		$id = $row["id"]; 
	    $image1 = $row["image1"]; // 이미지 필드명
		$raw_price = $row["price"]; // 원래 숫자값 유지
		$format_price = number_format($raw_price); // 문자열로 표시용
		$sale_price = round($raw_price * (100 - $row["discount"]) / 100); // 계산은 숫자로 추가로 여기서만 일단 반올림 하는 거 뻈다!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		$format_sale_price = number_format($sale_price);
	?>	
			<tr height="85" style="font-size:14px;">
				<td>
					<a href="product.php?id=<?=$id;?>"><img src="product/<?=$image1;?>" width="60" height="70"></a>
				</td>
				<td align="center" valign="middle">
					<a href="product.php?id=<?=$id;?>" style="color:#0066CC"><?=$row["name"];?></a><br>
					<?
						if ($row["icon_new"] == 1) {
							echo '<img src="images/i_new.gif">&nbsp;';
						}
						if ($row["icon_hit"] == 1) {
							echo '<img src="images/i_hit.gif">&nbsp;';
						}
						if ($row["icon_sale"] == 1) {
							echo '<img src="images/i_sale.gif">&nbsp;';
							echo '<span style="color:red; font-size:12.5px;">' . $row["discount"] . '%</span>';
						}
					?>
				</td>

				<?
				if ($row["icon_sale"] == 1){
				echo' <td><strike>' . $format_price . ' 원</strike></td>
					  <td><b>' . $format_sale_price . ' 원</b></td>';}				
				if ($row["icon_sale"] != 1){
				echo' <td>' . $format_price . ' 원</td>
					  <td><b>' . $format_price . ' 원</b></td>';}				
				?>
	
			</tr>
		<?
	}
		?>		
		</table>
<?
	echo $pagebar;
?>	

	</div>
</div>



<br><br><br>

<!-------------------------------------------------------------------------------------------->	
<!-- 끝 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	

<!-- 화면 하단 (main_bottom) : 회사소개/이용안내/개인보호정책 -->
<?
	include "main_bottom.php"
?>
