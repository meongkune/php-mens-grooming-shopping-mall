<?
include "main_top.php";

$o_name = $_REQUEST["o_name"] ?? "";
$o_tel1 = $_REQUEST["o_tel1"] ?? "";
$o_tel2 = $_REQUEST["o_tel2"] ?? "";
$o_tel3 = $_REQUEST["o_tel3"] ?? "";
$o_tel = sprintf("%-3s%-4s%-4s", $o_tel1, $o_tel2, $o_tel3);
$o_email = $_REQUEST["o_email"] ?? "";
$o_zip = $_REQUEST["o_zip"] ?? "";
$o_juso = $_REQUEST["o_juso"] ?? "";

$r_name = $_REQUEST["r_name"] ?? "";
$r_tel1 = $_REQUEST["r_tel1"] ?? "";
$r_tel2 = $_REQUEST["r_tel2"] ?? "";
$r_tel3 = $_REQUEST["r_tel3"] ?? "";
$r_tel = sprintf("%-3s%-4s%-4s", $r_tel1, $r_tel2, $r_tel3);
$r_email = $_REQUEST["r_email"] ?? "";
$r_zip = $_REQUEST["r_zip"] ?? "";
$r_juso = $_REQUEST["r_juso"] ?? "";
$memo = $_REQUEST["memo"] ?? "";
?>

<script>
	function Check_Value() {
		if (form2.pay_kind[0].checked) {
			if (form2.card_kind.value == 0) {
				alert("카드종류를 선택하세요.");	form2.card_kind.focus();	return;
			}
			if (!form2.card_no1.value || !form2.card_no2.value || !form2.card_no3.value || !form2.card_no4.value) {
				alert("카드번호를 입력하세요.");	form2.card_no1.focus();	return;
			}
			if (!form2.card_month.value) {
				alert("카드기간 월을 입력하세요.");	form2.card_month.focus();	return;
			}
			if (!form2.card_year.value) {
				alert("카드기간 년도를 입력하세요.");	form2.card_year.focus();	return;
			}
			if (!form2.card_pw.value) {
				alert("카드 비밀번호 뒤의 2자리를 입력하세요.");	form2.card_pw.focus();	return;
			}
		}
		else {
			if (form2.bank_kind.value == 0) {
				alert("입금할 은행을 선택하세요.");	form2.bank_kind.focus();	return;
			}
			if (!form2.bank_sender.value) {
				alert("입금자 이름을 입력하세요.");	form2.bank_sender.focus();	return;
			}
		}

		form2.card_kind.disabled = false;
		form2.card_no1.disabled = false;
		form2.card_no2.disabled = false;
		form2.card_no3.disabled = false;
		form2.card_no4.disabled = false;
		form2.card_year.disabled = false;
		form2.card_month.disabled = false;
		form2.card_pw.disabled = false;
		form2.card_halbu.disabled = false;
		form2.bank_kind.disabled = false;
		form2.bank_sender.disabled = false;

		form2.submit();
	}

	function togglePayment(type) {
		const card = document.getElementById("cardSection");
		const bank = document.getElementById("bankSection");
		const isCard = type === "card";

		card.style.display = isCard ? "block" : "none";
		bank.style.display = isCard ? "none" : "block";

		form2.card_kind.disabled = !isCard;
		form2.card_no1.disabled = !isCard;
		form2.card_no2.disabled = !isCard;
		form2.card_no3.disabled = !isCard;
		form2.card_no4.disabled = !isCard;
		form2.card_year.disabled = !isCard;
		form2.card_month.disabled = !isCard;
		form2.card_pw.disabled = !isCard;
		form2.card_halbu.disabled = !isCard;
		form2.bank_kind.disabled = isCard;
		form2.bank_sender.disabled = isCard;
	}
</script>

<div class="order-page">
	<div class="order-head">
		<div>
			<h4>결제 정보</h4>
			<p>구매 내역을 확인하고 결제 수단을 선택하세요.</p>
		</div>
		<div class="order-steps">
			<span>장바구니</span><span>&gt;</span><span class="active">주문/결제</span><span>&gt;</span><span>완료</span>
		</div>
	</div>

	<div class="order-card">
		<div class="order-card-head">
			<h5>구매 내역</h5>
			<span>결제 전 최종 확인 내역입니다.</span>
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

	<form name="form2" method="post" action="order_insert.php">
		<input type="hidden" name="o_name" value="<?=htmlspecialchars($o_name, ENT_QUOTES);?>">
		<input type="hidden" name="o_tel" value="<?=htmlspecialchars($o_tel, ENT_QUOTES);?>">
		<input type="hidden" name="o_email" value="<?=htmlspecialchars($o_email, ENT_QUOTES);?>">
		<input type="hidden" name="o_zip" value="<?=htmlspecialchars($o_zip, ENT_QUOTES);?>">
		<input type="hidden" name="o_juso" value="<?=htmlspecialchars($o_juso, ENT_QUOTES);?>">
		<input type="hidden" name="r_name" value="<?=htmlspecialchars($r_name, ENT_QUOTES);?>">
		<input type="hidden" name="r_tel" value="<?=htmlspecialchars($r_tel, ENT_QUOTES);?>">
		<input type="hidden" name="r_email" value="<?=htmlspecialchars($r_email, ENT_QUOTES);?>">
		<input type="hidden" name="r_zip" value="<?=htmlspecialchars($r_zip, ENT_QUOTES);?>">
		<input type="hidden" name="r_juso" value="<?=htmlspecialchars($r_juso, ENT_QUOTES);?>">
		<input type="hidden" name="memo" value="<?=htmlspecialchars($memo, ENT_QUOTES);?>">

		<div class="order-card">
			<div class="order-card-head">
				<h5>결제 방법</h5>
				<span>카드 결제 또는 무통장 입금을 선택하세요.</span>
			</div>
			<div class="order-pay-layout">
				<div class="order-pay-methods">
					<label class="order-pay-method" for="payCard">
						<input type="radio" name="pay_kind" value="0" id="payCard" checked onclick="togglePayment('card')">
						카드 결제
					</label>
					<label class="order-pay-method" for="payBank">
						<input type="radio" name="pay_kind" value="1" id="payBank" onclick="togglePayment('bank')">
						무통장 입금
					</label>
				</div>

				<div class="order-pay-panel">
					<div id="cardSection">
						<div class="order-pay-row">
							<label>카드 종류</label>
							<select name="card_kind" class="form-select" style="max-width:240px">
								<option value="0">카드종류 선택</option>
								<option value="1">국민카드</option>
								<option value="2">신한카드</option>
								<option value="3">우리카드</option>
								<option value="4">하나카드</option>
							</select>
						</div>
						<div class="order-pay-row">
							<label>카드 번호</label>
							<div class="order-inline">
								<input type="text" name="card_no1" maxlength="4" class="form-control text-center" style="width:76px">
								<span>-</span>
								<input type="text" name="card_no2" maxlength="4" class="form-control text-center" style="width:76px">
								<span>-</span>
								<input type="text" name="card_no3" maxlength="4" class="form-control text-center" style="width:76px">
								<span>-</span>
								<input type="text" name="card_no4" maxlength="4" class="form-control text-center" style="width:76px">
							</div>
						</div>
						<div class="order-pay-row">
							<label>카드 기간</label>
							<div class="order-inline">
								<input type="text" name="card_month" maxlength="2" class="form-control text-center" style="width:76px">
								<span>월</span>
								<input type="text" name="card_year" maxlength="2" class="form-control text-center" style="width:76px">
								<span>년</span>
							</div>
						</div>
						<div class="order-pay-row">
							<label>카드 비밀번호</label>
							<div class="order-inline">
								<span>**</span>
								<input type="password" name="card_pw" maxlength="2" class="form-control text-center" style="width:76px">
							</div>
						</div>
						<div class="order-pay-row">
							<label>할부</label>
							<select name="card_halbu" class="form-select" style="max-width:180px">
								<option value="0">일시불</option>
								<option value="3">3개월</option>
								<option value="6">6개월</option>
								<option value="9">9개월</option>
								<option value="12">12개월</option>
							</select>
						</div>
					</div>

					<div id="bankSection" style="display:none">
						<div class="order-pay-row">
							<label>입금 은행</label>
							<select name="bank_kind" class="form-select" style="max-width:320px" disabled>
								<option value="0">은행 선택</option>
								<option value="1">국민은행 111-00000-0000</option>
								<option value="2">신한은행 222-00000-0000</option>
							</select>
						</div>
						<div class="order-pay-row">
							<label>입금자 이름</label>
							<input type="text" name="bank_sender" class="form-control" style="max-width:240px" disabled>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="order-actions">
			<a href="javascript:history.back()" class="btn order-btn order-btn-secondary">이전</a>
			<a href="javascript:Check_Value()" class="btn order-btn order-btn-primary">결제하기</a>
		</div>
	</form>
</div>

<br><br><br>

<?
include "main_bottom.php";
?>
