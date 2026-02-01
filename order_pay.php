<?
	include "main_top.php";
	//주문자 정보
	$o_name=$_REQUEST["o_name"];
	
	$o_tel1=$_REQUEST["o_tel1"];
	$o_tel2=$_REQUEST["o_tel2"];
	$o_tel3=$_REQUEST["o_tel3"];
	$o_tel = sprintf("%-3s%-4s%-4s", $o_tel1, $o_tel2, $o_tel3);
	
	$o_email=$_REQUEST["o_email"];
	$o_zip=$_REQUEST["o_zip"];
	$o_juso=$_REQUEST["o_juso"];
	
	//배송자 정보
	$r_name=$_REQUEST["r_name"];
	
	$r_tel1=$_REQUEST["r_tel1"];
	$r_tel2=$_REQUEST["r_tel2"];
	$r_tel3=$_REQUEST["r_tel3"];
	$r_tel = sprintf("%-3s%-4s%-4s", $r_tel1, $r_tel2, $r_tel3);
	
	$r_email=$_REQUEST["r_email"];
	$r_zip=$_REQUEST["r_zip"];
	$r_juso=$_REQUEST["r_juso"];
	$memo=$_REQUEST["memo"];
	

	
?>	

<!-------------------------------------------------------------------------------------------->	
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	

<script>
	function Check_Value() 
	{
		
		if (form2.pay_kind[0].checked)
		{
			if (form2.card_kind.value==0) {
				alert("카드종류를 선택하세요.");	form2.card_kind.focus();	return;
			}
			if (!form2.card_no1.value) {
				alert("카드번호를 입력하세요.");	form2.card_no1.focus();	return;
			}
			if (!form2.card_no2.value) {
				alert("카드번호를 입력하세요.");	form2.card_no2.focus();	return;
			}
			if (!form2.card_no3.value) {
				alert("카드번호를 입력하세요.");	form2.card_no3.focus();	return;
			}
			if (!form2.card_no4.value) {
				alert("카드번호를 입력하세요.");	form2.card_no4.focus();	return;
			}
			if (!form2.card_month.value) {
				alert("카드기간 월을 입력하세요.");	form2.card_month.focus();	return;
			}
			if (!form2.card_year.value) {
				alert("카드기간 년도를 입력하세요.");	form2.card_year.focus();	return;
			}
			if (!form2.card_pw.value) {
				alert("카드 비밀번호 뒷의 2자리를 입력하세요.");	form2.card_pw.focus();	return;
			}
		}
		else
		{
			if (form2.bank_kind.value==0) {
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

	function PaySel(n) 
	{
		if (n == 0) {
			form2.card_kind.disabled = false;
			form2.card_no1.disabled = false;
			form2.card_no2.disabled = false;
			form2.card_no3.disabled = false;
			form2.card_no4.disabled = false;
			form2.card_year.disabled = false;
			form2.card_month.disabled = false;
			form2.card_halbu.disabled = false;
			form2.card_pw.disabled = false;
			form2.bank_kind.disabled = true;
			form2.bank_sender.disabled = true;
		}
		else {
			form2.card_kind.disabled = true;
			form2.card_no1.disabled = true;
			form2.card_no2.disabled = true;
			form2.card_no3.disabled = true;
			form2.card_no4.disabled = true;
			form2.card_year.disabled = true;
			form2.card_month.disabled = true;
			form2.card_halbu.disabled = true;
			form2.card_pw.disabled = true;
			form2.bank_kind.disabled = false;
			form2.bank_sender.disabled = false;
		}
	}
</script>

<div class="row m-1 mb-0 justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm rounded-3 border-0 mb-4">
            <div class="card-header bg-white border-bottom text-center">
                <h4 class="m-0" style="color: #B90319;">구매 내역</h4>
            </div>
            <div class="card-body p-0">
                <table class="table align-middle text-center mb-0">
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
				$opt_name1 = $opt_name2 = "";
				if ($opts_id1) {
					$res1 = mysqli_query($db, "select * from opts where id = $opts_id1");
					if ($res1) $opt_name1 = mysqli_fetch_array($res1)['name'];
				}
				if ($opts_id2) {
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
				<a href="product_ex.php?id=<?=$id?>" class="text-decoration-none text-dark fw-bold"><?=$product['company']?> <?=$product['name']?></a><br>
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
					<span class="form-control form-control-sm text-center" style="width: 60px; background-color: #f9f9f9; border: 1px solid #ddd; font-weight: 600;">
  <?=$num;?>
</span>

					
				</div>
			</td>
			<td><?=number_format($product_total)?>원</td>
			<td><a href="javascript:cart_edit('delete','<?=$i;?>')" class="btn btn-sm btn-outline-danger">삭제</a></td>
		</tr>
		<?
			}
		}
		if ($total < $max_baesongbi) {
			$final_total = $total + $baesongbi;
		} else {
			$baesongbi = 0;
			$final_total = $total;
		}
		?>
		</tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="6" class="text-end pe-4 py-3">
                                <small class="text-primary fw-bold">총 합계금액</small> : 
                                상품구매금액( <?=number_format($total)?>원 ) + 
                                배송비( <?=($baesongbi) ? number_format($baesongbi)."원" : "무료";?> ) = 
                                <b class="fs-6 text-dark"> <?=number_format($final_total)?>원</b>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- form2 시작 -->
<form name="form2" method="post" action="order_insert.php">


<input type="hidden" name="product_id[]" value="<?=$id?>">
<input type="hidden" name="num[]" value="<?=$num?>">
<input type="hidden" name="opts_id1[]" value="<?=$opts_id1?>">
<input type="hidden" name="opts_id2[]" value="<?=$opts_id2?>">
<input type="hidden" name="extra_price[]" value="<?=$extra_price?>">
<input type="hidden" name="base_price[]" value="<?=$base_price?>">













<input type="hidden" name="o_name"	value="<?=$o_name;?>">
<input type="hidden" name="o_tel"		value="<?=$o_tel;?>">
<input type="hidden" name="o_email"	value="<?=$o_email;?>">
<input type="hidden" name="o_zip"		value="<?=$o_zip;?>">
<input type="hidden" name="o_juso"	value="<?=$o_juso;?>">

<input type="hidden" name="r_name"	value="<?=$r_name;?>">
<input type="hidden" name="r_tel"		value="<?=$r_tel;?>">
<input type="hidden" name="r_email"	value="<?=$r_email;?>">
<input type="hidden" name="r_zip"		value="<?=$r_zip;?>">
<input type="hidden" name="r_juso"		value="<?=$r_juso;?>">
<input type="hidden" name="memo"	value="<?=addslashes($memo);?>">

<!-- 결제 방식 전체 박스 -->
<style>
  .payment-box {
    max-width: 500px;
    margin: auto;
    border: 1px solid #ddd;
    border-radius: 12px;
    padding: 20px;
    background: #f9f9f9;
  }

  .payment-box h4 {
    color: #B90319;
    margin-bottom: 16px;
  }

  .payment-box .form-section {
    display: none;
    margin-top: 15px;
  }

  .payment-box .form-control,
  .payment-box .form-select {
    font-size: 13px;
    height: 30px;
    padding: 4px 8px;
  }

  .form-control.short {
    width: 60px;
  }

  .form-control.mid {
    width: 100px;
  }

  .form-select.short {
    width: 200px;
  }

  .form-row {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
  }

  .form-row label {
    width: 120px;
    font-size: 13px;
    text-align: right;
    margin-right: 10px;
  }

  #cardSection,
  #bankSection {
    display: none;
  }

  .form-footer {
    text-align: center;
    margin-top: 20px;
  }
</style>

<div class="payment-box">
  <h4>결제 방법</h4>

<div class="form-row">
  <label>결제 수단</label>
  <div class="d-flex gap-3">
    <label class="d-flex align-items-center gap-1 mb-0" for="payCard" style="cursor: pointer;">
      <input type="radio" name="pay_kind" value="0" id="payCard" checked onclick="togglePayment('card')">
      💳 카드 결제
    </label>
    <label class="d-flex align-items-center gap-1 mb-0" for="payBank" style="cursor: pointer;">
      <input type="radio" name="pay_kind" value="1" id="payBank" onclick="togglePayment('bank')">
      🏦 무통장 입금
    </label>
  </div>
</div>


  <!-- 카드결제 -->
  <div id="cardSection" class="form-section" style="display: block;">
    <div class="form-row">
      <label>카드 종류</label>
      <select name="card_kind" class="form-select short">
        <option value="0">카드종류 선택</option>
        <option value="1">국민카드</option>
        <option value="2">신한카드</option>
        <option value="3">우리카드</option>
        <option value="4">하나카드</option>
      </select>
    </div>
    <div class="form-row">
      <label>카드 번호</label>
      <input type="text" name="card_no1" maxlength="4" class="form-control short me-1">
      <input type="text" name="card_no2" maxlength="4" class="form-control short me-1">
      <input type="text" name="card_no3" maxlength="4" class="form-control short me-1">
      <input type="text" name="card_no4" maxlength="4" class="form-control short">
    </div>
    <div class="form-row">
      <label>카드 기간</label>
      <input type="text" name="card_month" maxlength="2" class="form-control short me-1">월
      <input type="text" name="card_year" maxlength="2" class="form-control short ms-2 me-1">년
    </div>
    <div class="form-row">
      <label>카드 비밀번호</label>
      **&nbsp;<input type="password" name="card_pw" maxlength="2" class="form-control short">
    </div>
    <div class="form-row">
      <label>할부</label>
      <select name="card_halbu" class="form-select short">
        <option value="0">일시불</option>
        <option value="3">3개월</option>
        <option value="6">6개월</option>
        <option value="9">9개월</option>
        <option value="12">12개월</option>
      </select>
    </div>
  </div>

  <!-- 무통장입금 -->
  <div id="bankSection" class="form-section">
    <div class="form-row">
      <label>입금 은행</label>
      <select name="bank_kind" class="form-select short">
        <option value="0">은행 선택</option>
        <option value="1">국민은행 111-00000-0000</option>
        <option value="2">신한은행 222-00000-0000</option>
      </select>
    </div>
    <div class="form-row">
      <label>입금자 이름</label>
      <input type="text" name="bank_sender" class="form-control" style="width: 200px;">
    </div>
  </div>

  <!-- 결제 버튼 -->
  <div class="form-footer">
    <a href="javascript:Check_Value()" class="btn btn-danger btn-sm px-4 py-1">결제하기</a>
  </div>
</div>

<script>
  function togglePayment(type) {
    const card = document.getElementById('cardSection');
    const bank = document.getElementById('bankSection');
    if (type === 'card') {
      card.style.display = 'block';
      bank.style.display = 'none';
    } else {
      card.style.display = 'none';
      bank.style.display = 'block';
    }
  }
</script>

<br><br><br>

<!-------------------------------------------------------------------------------------------->	
<!-- 끝 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	

<!-- 화면 하단 (main_bottom) : 회사소개/이용안내/개인보호정책 -->
<?
	include "main_bottom.php";
?>	