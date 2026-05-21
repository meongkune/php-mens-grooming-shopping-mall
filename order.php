<?
include "main_top.php";

$o_name = "";
$o_tel1 = "";
$o_tel2 = "";
$o_tel3 = "";
$o_email = "";
$o_zip = "";
$o_juso = "";

if ($cookie_id) {
	$sql = "select * from member where id=$cookie_id";
	$result = mysqli_query($db, $sql);
	if (!$result) exit("에러: $sql");
	$row = mysqli_fetch_array($result);

	$o_name = $row["name"];
	$o_tel = $row["tel"];
	$o_tel1 = trim(substr($o_tel, 0, 3));
	$o_tel2 = trim(substr($o_tel, 3, 4));
	$o_tel3 = trim(substr($o_tel, 7, 4));
	$o_email = $row["email"];
	$o_zip = $row["zip"];
	$o_juso = $row["juso"];
}
?>

<script>
	function Check_Value() {
		if (!form2.o_name.value) {
			alert("주문자 이름이 잘못 되었습니다.");	form2.o_name.focus();	return;
		}
		if (!form2.o_tel1.value || !form2.o_tel2.value || !form2.o_tel3.value) {
			alert("주문자 휴대폰이 잘못 되었습니다.");	form2.o_tel1.focus();	return;
		}
		if (!form2.o_email.value) {
			alert("주문자 이메일이 잘못 되었습니다.");	form2.o_email.focus();	return;
		}
		if (!form2.o_zip.value) {
			alert("주문자 우편번호가 잘못 되었습니다.");	form2.o_zip.focus();	return;
		}
		if (!form2.o_juso.value) {
			alert("주문자 주소가 잘못 되었습니다.");	form2.o_juso.focus();	return;
		}
		if (!form2.r_name.value) {
			alert("받으실 분의 이름이 잘못 되었습니다.");	form2.r_name.focus();	return;
		}
		if (!form2.r_tel1.value || !form2.r_tel2.value || !form2.r_tel3.value) {
			alert("받으실 분의 휴대폰이 잘못 되었습니다.");	form2.r_tel1.focus();	return;
		}
		if (!form2.r_email.value) {
			alert("받으실 분의 이메일이 잘못 되었습니다.");	form2.r_email.focus();	return;
		}
		if (!form2.r_zip.value) {
			alert("배송지 우편번호가 잘못 되었습니다.");	form2.r_zip.focus();	return;
		}
		if (!form2.r_juso.value) {
			alert("배송지 주소가 잘못 되었습니다.");	form2.r_juso.focus();	return;
		}

		form2.submit();
	}

	function FindZip(zip_kind) {
		window.open("zipcode.php?zip_kind="+zip_kind, "", "scrollbars=no,width=490,height=320");
	}

	function SameCopy(str) {
		if (str == "Y") {
			form2.r_name.value = form2.o_name.value;
			form2.r_zip.value = form2.o_zip.value;
			form2.r_juso.value = form2.o_juso.value;
			form2.r_tel1.value = form2.o_tel1.value;
			form2.r_tel2.value = form2.o_tel2.value;
			form2.r_tel3.value = form2.o_tel3.value;
			form2.r_email.value = form2.o_email.value;
		}
		else {
			form2.r_name.value = "";
			form2.r_zip.value = "";
			form2.r_juso.value = "";
			form2.r_tel1.value = "";
			form2.r_tel2.value = "";
			form2.r_tel3.value = "";
			form2.r_email.value = "";
		}
	}
</script>

<div class="order-page">
	<div class="order-head">
		<div>
			<h4>주문/배송 정보</h4>
			<p>구매 상품을 확인하고 주문자와 배송지 정보를 입력하세요.</p>
		</div>
		<div class="order-steps">
			<span>장바구니</span><span>&gt;</span><span class="active">주문/결제</span><span>&gt;</span><span>완료</span>
		</div>
	</div>

	<div class="order-card">
		<div class="order-card-head">
			<h5>구매 내역</h5>
			<span>주문할 상품과 결제 예정 금액입니다.</span>
		</div>
		<div class="table-responsive">
			<table class="order-table">
				<thead>
					<tr>
						<th>상품정보</th>
						<th width="12%">수량</th>
						<th width="16%">판매가</th>
						<th width="16%">금액</th>
					</tr>
				</thead>
				<tbody>
<?
$cart = $_COOKIE["cart"] ?? [];
$n_cart = $_COOKIE["n_cart"] ?? 0;
$total = 0;

for ($i = 1; $i <= $n_cart; $i++) {
	if (!empty($cart[$i])) {
		list($id, $num, $opts_id1, $opts_id2, $extra_price) = array_pad(explode("^", $cart[$i]), 5, 0);
		$extra_price = (int)$extra_price;
		$opt_name1 = $opt_name2 = "";

		if (is_numeric($opts_id1) && (int)$opts_id1 > 0) {
			$res1 = mysqli_query($db, "select * from opts where id = $opts_id1");
			if ($res1) $opt_name1 = mysqli_fetch_array($res1)["name"];
		}
		if (is_numeric($opts_id2) && (int)$opts_id2 > 0) {
			$res2 = mysqli_query($db, "select * from opts where id = $opts_id2");
			if ($res2) $opt_name2 = mysqli_fetch_array($res2)["name"];
		}

		$sql = "select * from product where id = $id";
		$res = mysqli_query($db, $sql);
		if (!$res) exit("에러: $sql");
		$product = mysqli_fetch_array($res);
		$price = $product["price"];
		$sale_price = round($price * (100 - $product["discount"]) / 100);
		$base_price = ($product["icon_sale"] == 1) ? $sale_price : $price;
		$total_price_each = $base_price + $extra_price;
		$product_total = $total_price_each * $num;
		$total += $product_total;
?>
					<tr>
						<td>
							<div class="order-product">
								<a href="product_ex.php?id=<?=$id?>"><img src="product/<?=$product["image1"]?>" alt=""></a>
								<div>
									<a href="product_ex.php?id=<?=$id?>"><?=htmlspecialchars(($product["coname"] ?? "") . " " . $product["name"]);?></a>
									<? if ($opt_name1 || $opt_name2) { ?>
										<small>옵션: <?=htmlspecialchars(trim($opt_name1 . " " . $opt_name2));?></small>
									<? } ?>
								</div>
							</div>
						</td>
						<td class="text-center"><?=number_format($num);?></td>
						<td class="text-end"><?=number_format($total_price_each);?>원</td>
						<td class="text-end"><?=number_format($product_total);?>원</td>
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
				</tbody>
			</table>
		</div>
		<div class="order-total">
			<span>상품 <?=number_format($total);?>원</span>
			<span>+</span>
			<span>배송비 <?=($baesongbi) ? number_format($baesongbi)."원" : "무료";?></span>
			<span>=</span>
			<strong><?=number_format($final_total);?>원</strong>
		</div>
	</div>

	<form name="form2" method="post" action="order_pay.php">
		<div class="order-form-grid">
			<div class="order-card">
				<div class="order-card-head">
					<h5>주문자 정보</h5>
					<span>연락 가능한 정보를 입력하세요.</span>
				</div>
				<div class="order-section">
					<div class="order-field">
						<label>이름 <span class="order-required">*</span></label>
						<input type="text" name="o_name" value="<?=$o_name;?>" class="form-control">
					</div>
					<div class="order-field">
						<label>휴대폰 <span class="order-required">*</span></label>
						<div class="order-inline">
							<input type="text" name="o_tel1" maxlength="3" value="<?=$o_tel1;?>" class="form-control text-center" style="width:74px">
							<span>-</span>
							<input type="text" name="o_tel2" maxlength="4" value="<?=$o_tel2;?>" class="form-control text-center" style="width:92px">
							<span>-</span>
							<input type="text" name="o_tel3" maxlength="4" value="<?=$o_tel3;?>" class="form-control text-center" style="width:92px">
						</div>
					</div>
					<div class="order-field">
						<label>이메일 <span class="order-required">*</span></label>
						<input type="text" name="o_email" value="<?=$o_email;?>" class="form-control">
					</div>
					<div class="order-field">
						<label>주소 <span class="order-required">*</span></label>
						<div class="order-inline mb-2">
							<input type="text" name="o_zip" maxlength="5" value="<?=$o_zip;?>" class="form-control" style="width:110px">
							<a href="javascript:FindZip(1)" class="btn order-btn order-btn-secondary">우편번호 찾기</a>
						</div>
						<input type="text" name="o_juso" value="<?=$o_juso;?>" class="form-control">
					</div>
				</div>
			</div>

			<div class="order-card">
				<div class="order-card-head">
					<h5>배송 정보</h5>
					<span>상품을 받을 주소를 입력하세요.</span>
				</div>
				<div class="order-section">
					<div class="order-field">
						<label>주문자 정보 복사</label>
						<div class="order-copy">
							<div class="form-check">
								<input class="form-check-input" type="radio" name="same" id="sameY" onclick="SameCopy('Y')">
								<label class="form-check-label" for="sameY">예</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="same" id="sameN" onclick="SameCopy('N')">
								<label class="form-check-label" for="sameN">아니오</label>
							</div>
						</div>
					</div>
					<div class="order-field">
						<label>이름 <span class="order-required">*</span></label>
						<input type="text" name="r_name" value="" class="form-control">
					</div>
					<div class="order-field">
						<label>휴대폰 <span class="order-required">*</span></label>
						<div class="order-inline">
							<input type="text" name="r_tel1" maxlength="3" value="010" class="form-control text-center" style="width:74px">
							<span>-</span>
							<input type="text" name="r_tel2" maxlength="4" value="" class="form-control text-center" style="width:92px">
							<span>-</span>
							<input type="text" name="r_tel3" maxlength="4" value="" class="form-control text-center" style="width:92px">
						</div>
					</div>
					<div class="order-field">
						<label>이메일 <span class="order-required">*</span></label>
						<input type="text" name="r_email" value="" class="form-control">
					</div>
					<div class="order-field">
						<label>주소 <span class="order-required">*</span></label>
						<div class="order-inline mb-2">
							<input type="text" name="r_zip" maxlength="5" value="" class="form-control" style="width:110px">
							<a href="javascript:FindZip(2)" class="btn order-btn order-btn-secondary">우편번호 찾기</a>
						</div>
						<input type="text" name="r_juso" value="" class="form-control">
					</div>
					<div class="order-field">
						<label>요구사항</label>
						<textarea name="memo" class="form-control"></textarea>
					</div>
				</div>
			</div>
		</div>

		<div class="order-actions">
			<a href="cart.php" class="btn order-btn order-btn-secondary">장바구니로</a>
			<a href="javascript:Check_Value()" class="btn order-btn order-btn-primary">다음</a>
		</div>
	</form>
</div>

<br><br><br>

<?
include "main_bottom.php";
?>
