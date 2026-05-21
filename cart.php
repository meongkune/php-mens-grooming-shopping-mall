<?
	include "main_top.php";
?>

<script>
	function cart_edit(kind,pos) 
	{
		if (kind=="deleteall") {
			if (confirm("정말로 신중하게 고려해서 장바구니를 비우시겠습니까?")) {
				alert("장바구니를 비웠습니다!!!");
				location.href = "cart_edit.php?kind=deleteall";
			}
		}
		else if (kind=="delete")
			location.href = "cart_edit.php?kind=delete&pos="+pos;
		else if (kind=="update") {
			var num=eval("form2.num"+pos).value;
			location.href = "cart_edit.php?kind=update&pos="+pos+"&num="+num;
		}
}
</script>

<form name="form2" method="post" action="">
<div class="container my-5">
	<h4 class="text-center mb-4 position-relative">
		<b>장바구니</b>
		<span style="position: absolute; right: 0; top: 50%; transform: translateY(-50%); font-size: 16px;">
			<b style="color: #000;">장바구니</b> &nbsp;&gt;&nbsp; 주문/결제 &nbsp;&gt;&nbsp; 완료
		</span>
	</h4>
	
	<div class="table-responsive">
	<table class="table align-middle text-center table-bordered">
		<thead class="table-light">
		<tr>
			<th width="10%">이미지</th>
			<th width="35%">상품정보</th>
			<th width="10%">판매가</th>
			<th width="20%">수량</th>
			<th width="10%">금액</th>
			<th width="10%">삭제</th>
		</tr>
		</thead>
		<tbody>
		<?
		$cart = $_COOKIE["cart"];
		$n_cart = $_COOKIE["n_cart"];
		$total = 0;
		if (!$n_cart) $n_cart = 0;

		for ($i = 1; $i <= $n_cart; $i++) {
			if ($cart[$i]) {
				list($id, $num, $opts_id1, $opts_id2, $extra_price) = explode("^", $cart[$i]);
$extra_price = (int)$extra_price;
				$opt_name1 = $opt_name2 = "";
				if (is_numeric($opts_id1) && (int)$opts_id1 > 0) {
					$res1 = mysqli_query($db, "select * from opts where id = $opts_id1");
					if ($res1) $opt_name1 = mysqli_fetch_array($res1)['name'];
				}
				if (is_numeric($opts_id2) && (int)$opts_id2 > 0) {
					$res2 = mysqli_query($db, "select * from opts where id = $opts_id2");
					if ($res2) $opt_name2 = mysqli_fetch_array($res2)['name'];
				}

				$sql = "select * from product where id = $id";
				$res = mysqli_query($db, $sql);
				if (!$res) exit("에러: $sql");
				$product = mysqli_fetch_array($res);
				$price = $product["price"];
				$sale_price = round($price * (100 - $product["discount"]) / 100);
				$base_price = ($product["icon_sale"] == 1) ? $sale_price : $price;
$product_total = ($base_price + $extra_price) * $num;

				$total += $product_total;
		?>
		<tr>
			<td><a href="product_ex.php?id=<?=$id?>"><img src="product/<?=$product['image1']?>" width="60" height="70"></a></td>
			<td>
				<a href="product_ex.php?id=<?=$id?>" class="text-decoration-none text-dark fw-bold"><?=$product['coname']?> <?=$product['name']?></a><br>
				<? if ($opt_name1 || $opt_name2) { ?>
					<small><b>[옵션]</b> <?= $opt_name1 ?> &nbsp; <?= $opt_name2 ?></small>
				<? } ?>
			</td>
			<?php
$base_price = ($product['icon_sale'] == 1) ? $sale_price : $price;
$total_price_each = $base_price + $extra_price;
?>
<td><?=number_format($total_price_each)?>원</td>

			<td>
				<div class="d-flex justify-content-center align-items-center">
					<input type="number" name="num<?=$i;?>" value="<?=$num;?>" min="1" class="form-control form-control-sm text-center me-2" style="width: 60px;">
					<a href="javascript:cart_edit('update','<?=$i;?>')" class="btn btn-sm btn-outline-success">수정</a>
				</div>
			</td>
			<td><?=number_format($product_total)?>원</td>
			<td><a href="javascript:cart_edit('delete','<?=$i;?>')" class="btn btn-sm btn-outline-danger">삭제</a></td>
		</tr>
		<?
			}
		}
		if ($total > 0 && $total < $max_baesongbi) {
			$final_total = $total + $baesongbi;
		} else {
			$baesongbi = 0;
			$final_total = $total;
		}
		?>
		<tr class="table-light">
			<td colspan="6" class="text-end pe-4">
				<small class="text-primary fw-bold">총 합계금액</small> : 상품구매금액( <?=number_format($total)?>원 ) + 배송비( <?=($baesongbi) ? number_format($baesongbi)."원" : "무료";?> ) = <b class="fs-6"> <?=number_format($final_total)?>원</b>
			</td>
		</tr>
		</tbody>
	</table>
	</div>

	<div class="text-center mt-3">
		<a href="index.html" class="btn btn-outline-secondary btn-sm mx-1">계속 쇼핑하기</a>
		<? if($n_cart > 0 && !empty($cart)) { ?>
		<a href="javascript:cart_edit('deleteall',0)" class="btn btn-outline-secondary btn-sm mx-1">장바구니 비우기</a>
		<a href="order.php" class="btn btn-dark btn-sm mx-1">결제하기</a>
		<? } ?>
	</div>
</div>
</form>

<? include "main_bottom.php"; ?>
