<?
	include "common.php";

	$id=$_REQUEST["id"];
	$sql="select * from jumun where id='$id' ";
	$result = mysqli_query($db, $sql);
	if (!$result) exit("에러: $sql");
	
	$row=mysqli_fetch_array($result);

?>
<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>INDUK Mall</title>
	<link  href="../css/bootstrap.min.css" rel="stylesheet">
	<link  href="../css/my.css" rel="stylesheet">
	<script src="..js/jquery-3.7.1.min.js"></script>
	<script src="../js/bootstrap.bundle.min.js"></script>
	<script src="../js/my.js"></script>
</head>
<body>

<div class="container">
<!-------------------------------------------------------------------------------------------->	
<script> document.write(admin_menu());</script>
<!-------------------------------------------------------------------------------------------->	

<div class="row mx-1 justify-content-center">
	<div class="col-sm-10" align="center">

	<h4 class="m-0 mb-3">주문 ( <?=$id;?> )</h4>

	<table class="table table-sm table-bordered mb-3">
		<tr>
			<td width="15%" class="bg-light">상태</td>
			<td width="35%"><?=$a_state[$row["state"]]; ?></td>
			<td width="15%" class="bg-light">주문일</td>
			<td width="35%"><?=$row["jumunday"]; ?></td>
		</tr>
	</table>

	<table class="table table-sm table-bordered mb-2">
		<tr>
			<td width="15%" class="bg-light"><b>주문자</b></td>
			<td width="35%"><?=$row["o_name"]; ?></td>
			<td width="15%" class="bg-light">구분</td>
			<td width="35%"><?=($row["member_id"]==0)?"비회원":"회원"; ?></td>
		</tr>
		<tr>
			<td class="bg-light">전화</td><td><?=trim(substr($row["o_tel"],0,3)); ?>-<?=trim(substr($row["o_tel"],3,4)); ?>-<?=trim(substr($row["o_tel"],7,4)); ?></td>
			<td class="bg-light">E-Mail</td><td><?=$row["o_email"]; ?></td>
		</tr>
		<tr>
			<td class="bg-light">주소</td>
			<td align="left" colspan="3">&nbsp;(<?=$row["o_zip"]; ?>)<?=$row["o_juso"]; ?></td>
		</tr>
	</table>

	<table class="table table-sm table-bordered mb-3">
		<tr>
			<td width="15%" class="bg-light"><b>수신자</b></td>
			<td width="35%"><?=$row["r_name"]; ?></td>
			<td width="15%" class="bg-light"></td>
			<td></td>
		</tr>
		<tr>
			<td class="bg-light">전화</td>
			<td><?=trim(substr($row["r_tel"],0,3)); ?>-<?=trim(substr($row["r_tel"],3,4)); ?>-<?=trim(substr($row["r_tel"],7,4)); ?></td>
			<td class="bg-light">E-Mail</td>
			<td><?=$row["r_email"]; ?></td>
		</tr>
		<tr>
			<td class="bg-light">주소</td>
			<td align="left" colspan="3">&nbsp;(<?=$row["r_zip"]; ?>)<?=$row["r_juso"]; ?></td>
		</tr>
		<tr height="50">
			<td class="bg-light">메모</td>
			<td align="left" valign="top" colspan="3">&nbsp;<?=$row["memo"]; ?></td>
		</tr>
	</table>

<? if ($row["pay_kind"]==0){ ?>		
	<table class="table table-sm table-bordered mb-3">
		<tr>
			<td width="15%" class="bg-light"><b>카드</b></td>
			<td width="35%"><?= $card_kinds[$row["card_kind"]] ; ?></td>
			<td width="15%" class="bg-light">승인</td>
			<td width="35%"><?=$row["card_okno"]; ?></td>
		</tr>
		<tr>
			<td class="bg-light">할부</td><td><?= $card_halbu[$row["card_halbu"]] ; ?></td>
			<td class="bg-light"></td><td></td>
		</tr>
	</table>


<? } else { ?>   <!----- 난 이부분을 < } > 하고서 < else { > 로 했더니 동작 안돼서 저렇게 바꿈(꺽새 부분에 물음표는 이게 주석처리안돼서 일부러 뺌 알아둬) ---> 

	<table class="table table-sm table-bordered mb-3">
		<tr>
			<td class="bg-light"><b>무통장</b></td><td><?= $bank_kinds[$row["bank_kind"]] ; ?></td> 
			<td class="bg-light">입금자</td><td><?=$row["bank_sender"]; ?></td>
		</tr>
	</table>
<? } ?>

	<table class="table table-sm table-bordered mb-3">
		<tr class="bg-light">
			<td>제품명</td>
			<td width="10%">수량</td>
			<td width="10%">단가</td>
			<td width="10%">금액</td>
			<td width="10%">할인</td>
			<td width="20%">옵션</td>
		</tr>
		
		
<?
	$sql="select product.name as name0, jumuns.num as num, jumuns.price as price, jumuns.prices as prices, jumuns.discount as discount, 
		  opts1.name as name1, opts2.name as name2 
		  FROM jumuns 
        LEFT JOIN product ON jumuns.product_id = product.id  
        LEFT JOIN opts as opts1 ON jumuns.opts_id1 = opts1.id
        LEFT JOIN opts as opts2 ON jumuns.opts_id2 = opts2.id
        WHERE jumuns.jumun_id = '$id'";
		  
	$result = mysqli_query($db, $sql);
	if (!$result) exit("에러: $sql");	  
		  
	foreach($result as $row) {
		
		$name2 = $row['name2'] ? $row['name2'] : ""; // 옵션2가 없으면 "" 으로 표시
		$name1 = $row['name1'] ? $row['name1'] : ""; // 옵션1이 없을 때 처리
		$name0 = $row['name0'] ? $row['name0'] : "배송비"; // 상품명이 없으면 (예: 배송비), 직접 지정
		
		
		$prices += $row["prices"];
?>		
		<tr>
			<td align="center"><?=$name0;?></td>
			<td><?= ($name0=="배송비") ? " " : $row["num"];?></td>
			<td align="center"><?=number_format($row["price"]);?>원</td>
			<td align="center"><?=number_format($row["prices"]);?>원</td>
			<td><?=($row["discount"]==0)?"  ":$row["discount"]. "%";?></td>	
			<td align="center"> <?=$name1;?> <?=($name1 && $name2)?"/":"";?> <?= $name2;?></td>
		</tr>
		
<?
	}
?>
</table>

	<table class="table table-sm table-bordered mb-3 p-2">
		<tr>
			<td width="15%" class="bg-light">총금액</td>
			<td width="85%" align="right" style="font-size:18px"><b><?=number_format($prices);?> 원 끝!!!</b>&nbsp;</td>
		</tr>
	</table>

	<a href="javascript:print();"  class="btn btn-sm btn-dark text-white my-2">&nbsp;프린트&nbsp;</a>&nbsp;
	<a href="javascript:history.back();"  class="btn btn-sm btn-outline-dark my-2">&nbsp;돌아가기&nbsp;</a>

	</div>
</div>
<!-------------------------------------------------------------------------------------------->	
</div>

</body>
</html>
