<?
	include "main_top.php";
	
	$id=$_REQUEST["id"]; //주문번호 관련 id임
	
	$sql="select product.id as id, product.name as product_name, product.image1 as product_image1, 
				 opts1.name as name1, opts2.name as name2,
				 jumuns.num as jumuns_num, jumuns.price as jumuns_price, jumuns.prices as jumuns_prices
				 from((jumuns left join opts as opts1 on jumuns.opts_id1=opts1.id)
					          left join opts as opts2 on jumuns.opts_id2=opts2.id)
							  left join product on jumuns.product_id=product.id
							  WHERE jumuns.jumun_id = '$id'";
	$result=mysqli_query($db,$sql);
	if (!$result) exit("에러: $sql");  
						  
?>

<div class="row m-1 mt-4 mb-0">
	<div class="col" align="center">

		<h4 class="m-3">주문상품내역</h4>

		<hr class="m-0">
		<table class="table table-sm mb-4">
			<tr height="30" class="bg-light">
				<td width="15%">이미지</td>
				<td width="35%">상품정보</td>
				<td width="15%">판매가</td>
				<td width="20%">수량</td>
				<td width="15%">금액</td>
			</tr>
<?
			$total=0;
			foreach ($result as $row){
				$product_name = $row['product_name'] ? $row['product_name'] : "배송비";
				$product_id=$row["id"];
?>				
			<tr height="85" style="font-size:14px;">
			<td>
			<? if($product_id){ ?> 
				<a href="product.php?id=<?=$product_id ;?>">
				<img src="product/<?= $row['product_name'] ? $row['product_image1'] : "baesong.webp" ;?>" width="60" height="70"></a>
				<td align="center" valign="middle">
					<a href="product.php?id=<?=$product_id ;?>" style="color:#0066CC"><?= $product_name; ?></a><br>
			<? } else { ?>	
				<img src="product/<?= $row['product_name'] ? $row['product_image1'] : "baesong.webp" ;?>" width="60" height="70">
				<td align="center" valign="middle">
					<?= $product_name; ?><br>
			<? } ?>
	
			<? if ($row["name1"] || $row["name2"]) { ?>
					<small><b>[옵션] </b> <?= $row["name1"]; ?> &nbsp; <?= $row["name2"]; ?></small>
			<? } ?>	
				</td>
				<td><?=number_format($row['jumuns_price']);?>원</td>
				<td><?=$row['jumuns_num'];?></td>
				<td><?=number_format($row['jumuns_prices']);?>원</td>
			</td>
			</td>			
			</tr>
<?
			$total+=$row['jumuns_prices'];
			}
?>			
			<tr height="30" align="right" class="bg-light" style="font-size:14px;">
				<td colspan="5" class="pe-2">
					<font color="#0066CC">결제금액</font> : <font style="font-size:16px"><b><?=number_format($total);?>원</b></font>
				</td>
			</tr>
		</table>
	</div>
</div>

<?
	
	$sql="select * from jumun where id='$id' ";
	$result = mysqli_query($db, $sql);
	if (!$result) exit("에러: $sql");
	
	$row=mysqli_fetch_array($result);

?>

	
<div class="row m-1">
	<div class="col" align="center">
	
		<h4 class="m-0"><font size="4" color="#B90319">결제내역</font></h4>
		<hr class="m-2">
		<table class="table table-sm table-borderless">
			<tr height="30">
				<td width="20%"><b>주문번호 :</b></td><td width="30%"> <?=$row["id"];?></font></td>
				<td width="20%"><b>결제금액 :</b></td><td width="30%"><?=number_format($total);?>원</td>
			</tr>
			<tr height="30">
				<td><b>결제방식 :</b></td><td><?=($row["pay_kind"] == 0) ? "카드" : "무통장" ;?></td>
			
<? if ($row["pay_kind"] == 1) { ?>

			<tr height="30">	
				<td><b>무통장 :</b></td>
				<td><?= $bank_kinds[$row["bank_kind"]]; ?></td>
				<td><b>입금자 :</b></td>
				<td><?= $row["bank_sender"]; ?></td>
			</tr>

<? } else { ?>
			
				<td><b>승인번호 :</b></td>
				<td><?= $row["card_okno"]; ?></td>
				
			</tr>
			<tr height="30">
				<td><b>카드종류 :</b></td>
				<td><?= $card_kinds[$row["card_kind"]]; ?></td>
				<td><b>할부 :</b></td>
				<td><?= $card_halbu[$row["card_halbu"]]; ?></td>
			</tr>

<? } ?>
			
		</table>
	</div>
</div>

<div class="row m-1">
	<div class="col" align="center">
	
		<h4 class="m-0"><font size="4" color="#B90319">주문자</font></h4>
		<hr class="m-2">
		<table class="table table-sm table-borderless">
			<tr height="30">
				<td width="20%"><b>주문자 :</b></td><td width="30%"><?=$row["o_name"]; ?></td>
				<td width="20%"><b>핸드폰 :</b></td><td width="30%"><?=trim(substr($row["o_tel"],0,3)); ?>-<?=trim(substr($row["o_tel"],3,4)); ?>-<?=trim(substr($row["o_tel"],7,4)); ?></td>
			</tr>
			<tr height="30">
				<td><b>이메일 :</b></td><td colspan="3" align="left"><?=$row["o_email"]; ?></td>
			</tr>
		</table>
	</div>
</div>

<div class="row m-1">
	<div class="col" align="center">
	
		<h4 class="m-0"><font size="4" color="#B90319">배송내역</font></h4>
		<hr class="m-2">
	
		<table class="table table-sm table-borderless">
			<tr height="30">
				<td width="20%"><b>수취인 :</b></td><td width="30%"><?=$row["r_name"]; ?></td>
				<td width="20%"><b>핸드폰 :</b></td><td width="30%"><?=trim(substr($row["r_tel"],0,3)); ?>-<?=trim(substr($row["r_tel"],3,4)); ?>-<?=trim(substr($row["r_tel"],7,4)); ?></td>
			</tr>
			<tr height="30">
				<td><b>주소 :</b></td><td colspan="3" align="left"><?=$row["r_zip"]; ?><?=$row["r_juso"]; ?></td>
			</tr>
			<tr height="30">
				<td><b>메모 :</b></td><td colspan="3" align="left"><?=$row["memo"]; ?></td>
			</tr>
		</table>
	</div>
</div>

<br>
<div class="row">
	<div class="col" align="center">
		<a href="javascript:history.back();" class="btn btn-sm btn-dark text-white">&nbsp;돌아가기&nbsp;</a>
	</div>
</div>

<br><br>

<?
	include "main_bottom.php";
?>
