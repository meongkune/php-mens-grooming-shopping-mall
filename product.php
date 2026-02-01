<?
	include "main_top.php";
	
	$id=$_REQUEST["id"];
	$sql="select * from product where id=$id";
	$result=mysqli_query($db,$sql);
	if (!$result) exit("에러: $sql");    
	$row=mysqli_fetch_array($result);
	
	$raw_price = $row["price"]; // 원래 숫자값 유지
	$format_price = number_format($raw_price); // 문자열로 표시용
	$sale_price = round($raw_price * (100 - $row["discount"]) / 100); // 계산은 숫자로
	$format_sale_price = number_format($sale_price);
	
	
	
?>
<!-------------------------------------------------------------------------------------------->	
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	

<!--  현재 페이지 Javascript  -------------------------------------------->
<script >
	function cal_price() {
    let unit_price;

    if (form2.sale && form2.sale.value) {
        unit_price = parseInt(form2.sale.value);
    } else {
        unit_price = parseInt(form2.price.value);
    }

    const quantity = parseInt(form2.num.value) || 0;

    const total = unit_price * quantity;
    form2.prices.value = total.toLocaleString()+ "원";
}

	function check_form2(str) 
	{
		if (form2.opts1.value==0) {
			alert("옵션1을 선택하십시요.");
			form2.opts1.focus();
			return;
		}
		if (form2.opts2.value==0) {
			alert("옵션2를 선택하십시요.");
			form2.opts2.focus();
			return;
		}
		if (!form2.num.value) {
			alert("수량을 입력하십시요.");
			form2.num.focus();
			return;
		}
		if (str == "D") {
			form2.action = "cart_edit.php";
			form2.kind.value = "order";
			form2.submit();
		}
		else {
			form2.action = "cart_edit.php";
			form2.submit();
		}
	}
	
</script>

<!-- form2 시작  -->
<form name="form2" method="post" action="">
<input type="hidden" name="kind" value="insert">
<input type="hidden" name="id" value="<?=$id;?>">
<input type="hidden" name="price" value="<?=$raw_price;?>">

<? if ($row["icon_sale"] == 1) { ?>
<input type="hidden" name="sale" value="<?=$sale_price;?> ">
<? } ?>

<!--  상품 사진/정보(제품명,가격,옵션)  -->
<div class="row mx-1 my-4">
	<div class="col" align="center">

		<table class="table table-sm table-borderless">
			<tr>
				<td valign="top" align="center" width="50%">
					<img src="product/<?=$row["image2"];?>" width="80%" 
						class="img-thumbnail img-fluid mt-2"  style="cursor:zoom-in" 
						data-bs-toggle="modal" data-bs-target="#zoomModal">
				</td>
				<td  width="50%" align="center" valign="top" class="px-0">
					<hr size="5px" width="100%" class="my-2">
					<table width="100%" style="font-size:12px;" class="table table-sm table-borderless p-0 m-0">
						<tr height="50">
							<td colspan="2"  align="center" style="font-size:20px; color: #222222;">
								<?=$row["name"];?>
							</td>
						</tr>
						<tr height="35">
							<td colspan="2" align="center">
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
						</tr>
					<?
						if ($row["icon_sale"] != 1){
						echo' <tr><td colspan="2"><hr class="my-2"></td></tr>
						<tr height="35">
							<td width="30%" align="center">판매가</td>
							<td width="70%" align="left" style="font-size:15px;">' . $format_price . '원</td>
						</tr>';
						}
						
					   if ($row["icon_sale"] == 1) {
						echo '<tr><td colspan="2"><hr class="my-2"></td></tr>
						<tr height="35">
							<td width="30%" align="center">판매가</td>
							<td width="70%" align="left" style="font-size:15px;"><strike>' . $format_price . '원</strike></td>
						</tr>
							<tr height="35">
									<td align="center">할인가</td>
									<td style="font-size:15px;" align="left">' . $format_sale_price . '원</td> 
								  </tr>';
						}
						?>
						<!----//바로 윗 부분 문법 참고하자--->
<? if ($row["opt1"] || $row["opt2"]) {
    echo '<tr><td colspan="2"><hr class="my-2"></td></tr>';
}  //선 추가 관련해서 옵션1만 있는 경우, 옵션2만 있는 경우, 둘 다 있는 경우, 둘 다 없는 경우  --------> 또는(OR) 문법 사용
?>
		<?
		if ($row["opt1"]){
			$sql="select * from opts where opt_id=$row[opt1]";
			$result=mysqli_query($db,$sql);
			if (!$result) exit("에러: $sql");  
			
		?>
						
						
						<!--- if ($row["opt1"]){ 원래 여기였는데 이게 옵션 선택안한것들 장바구니 추가를 고려하다보니..-->
						<tr>
							<td align="center">옵션1</td>
							<td  align="left">
							
								<select name="opts1" class="form-select form-select-sm mb-2" style="width:90%;font-size:12px;">
									<option value="0" selected>옵션을 선택하세요.</option>
									<?
									foreach( $result as $row1 )
									{
										if ($row["opt1"] == $row1["id"])
											echo("<option value='$row1[id]' selected>$row1[name]</option>");
										else
											echo("<option value='$row1[id]'>$row1[name]</option>");
									}
									?>
									
								</select>
								
							</td>
						</tr>
		<?
						 }else {
    echo '<input type="hidden" name="opts1" value="none">'; //  여기때문에 그래서 그 결제 최종단계서 오류 났던거임 -----------------------------------------------------------------------------------------------------------------------------------------------
}
		?>					
						
		<?
		if ($row["opt2"]){
			$sql="select * from opts where opt_id=$row[opt2]";
			$result=mysqli_query($db,$sql);
			if (!$result) exit("에러: $sql"); 
		?>	
							
								
							<!--- if ($row["opt2"]){ 원래 여기였는데 이게 옵션 선택안한것들 장바구니 추가를 고려하다보니..-->
						<tr>
							<td align="center">옵션2</td>
							<td  align="left">		
								<select name="opts2" class="form-select form-select-sm" style="width:90%;font-size:12px;">
									<option value="0" selected>옵션을 선택하세요.</option>
									<?
									foreach( $result as $row1 )
									{
										if ($row["opt2"] == $row1["id"])
											echo("<option value='$row1[id]' selected>$row1[name]</option>");
										else
											echo("<option value='$row1[id]'>$row1[name]</option>");
									}
									?>
								</select>
							
							</td>
						</tr>
						
							<?
						 }
						 else {
    echo '<input type="hidden" name="opts2" value="none">'; //  여기때문에 그래서 그 결제 최종단계서 오류 났던거임 -----------------------------------------------------------------------------------------------------------------------------------------------
}
		?>	
						<tr><td colspan="2"><hr class="my-2"></td></tr>
						<tr>
							<td align="center">수량</td>
							<td  align="left">
								<div class="d-inline-flex">
									<input type="text" name="num" size="5" value="1" 
										class="form-control form-control-sm" style="text-align:center;"
										onChange="javascript:cal_price()">
								</div>
							</td>
						</tr>
						<script>
						window.onload = function() {
							cal_price();
						};
						</script>
						<tr>
							<td align="center">금액</td>
							<td align="left">
								<div class="d-inline-flex">
									<input type="text" name="prices" value="" size="10" 
										class="form-control form-control-sm"
										style="border:0;background-color:white;text-align:left;font-size:18px;font-weight:bold;" readonly>
										 
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="2" height="100" align="center">
								<a href="javascript:check_form2('D')" 
									class="btn btn-sm btn-secondary text-light">바로 구매</a>&nbsp;&nbsp;&nbsp;&nbsp;
								<a href="javascript:check_form2('C')" 
									class="btn btn-sm btn-outline-secondary">장바구니</a>
							</td>
						</tr>
					</table>

				</td>
			</tr>
		</table>

	</div>
</div>

</form>
<!-- form2 끝 -->
<!-- 이미지가 있어야 그리고 if문 쓰기
 image3가 있어야지 떠야할 소스-->
 
<? if($row["image3"]){ ?>
<hr class="my-0 mx-3">

<div align="center">
	<br>
	본 제품의 상세설명은 다음과 같습니다....
	<br><br>
	<img src="product/<?= $row["image3"] ?>" class="img-thumbnail" style="border:0">
</div>	
<? } ?>


<?
/* 또다른 방식 if($row["image3"]) {
    echo '
    <hr class="my-0 mx-3">

    <div align="center">
        <br>
        본 제품의 상세설명은 다음과 같습니다....
        <br><br>
        <img src="product/' . $row["image3"] . '" class="img-thumbnail" style="border:0">
    </div>';
} */
?> 

<br><br>

<!-- Zoom Modal 이미지 -->
<div class="modal fade" id="zoomModal" tabindex="-1" aria-labelledby="zoomModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="zoomModalLabel"><?=$row["image2"];?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div align="center" class="modal-body">
        <img src="product/<?=$row["image2"];?>" class="img-thumbnail" style="cursor:pointer" class="btn-close"  data-bs-dismiss="modal" aria-label="Close">
      </div>
    </div>
  </div>
</div>

<!-------------------------------------------------------------------------------------------->	
<!-- 끝 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	

<?
	include "main_bottom.php";
?>