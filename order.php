<?
	include "main_top.php";
	$o_name=""; 
	$o_tel="";
	$o_email=""; 
	$o_zip="" ;
	$o_juso=""	;//간혹 이상한 값이 찍힐 수 있기 때문에 일단 ""로 하자...
	if ($cookie_id)
	{
		$sql="select * from member where id=$cookie_id";
		$result=mysqli_query($db,$sql);
		if (!$result) exit("에러: $sql");  
		$row=mysqli_fetch_array($result);	
		
		$o_name=$row["name"];
		$o_tel=$row["tel"];
		
		$o_tel1=trim(substr($o_tel,0,3));
		$o_tel2=trim(substr($o_tel,3,4));
		$o_tel3=trim(substr($o_tel,7,4));
		
		
		
		
		$o_email=$row["email"];
		$o_zip=$row["zip"];
		$o_juso=$row["juso"];
		
		
		
	}
?>

<script>
			function Check_Value() {
				if (!form2.o_name.value) {
					alert("주문자 이름이 잘못 되었습니다.");	form2.o_name.focus();	return;
				}
				if (!form2.o_tel1.value || !form2.o_tel2.value || !form2.o_tel3.value) {
					alert("핸드폰이 잘못 되었습니다.");	form2.o_tel1.focus();	return;
				}
				if (!form2.o_email.value) {
					alert("이메일이 잘못 되었습니다.");	form2.o_email.focus();	return;
				}
				if (!form2.o_zip.value) {
					alert("우편번호가 잘못 되었습니다.");	form2.o_zip.focus();	return;
				}
				if (!form2.o_juso.value) {
					alert("주소가 잘못 되었습니다.");	form2.o_juso.focus();	return;
				}

				if (!form2.r_name.value) {
					alert("받으실 분의 이름이 잘못 되었습니다.");	form2.r_name.focus();	return;
				}
				if (!form2.r_tel1.value || !form2.r_tel2.value || !form2.r_tel3.value) {
					alert("핸드폰이 잘못 되었습니다.");	form2.r_tel1.focus();	return;
				}
				if (!form2.r_email.value) {
					alert("이메일이 잘못 되었습니다.");	form2.r_email.focus();	return;
				}
				if (!form2.r_zip.value) {
					alert("우편번호가 잘못 되었습니다.");	form2.r_zip.focus();	return;
				}
				if (!form2.r_juso.value) {
					alert("주소가 잘못 되었습니다.");	form2.r_juso.focus();	return;
				}

				form2.submit();
			}

			function FindZip(zip_kind) 
			{
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
$extra_price = (int)$extra_price;
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

<style>
form[name="form2"] .row .col {
  max-width: 600px;
  margin: 0 auto;
  text-align: left;
}
/* 테이블 셀 스타일 */
table td {
  padding: 5px 0;
  vertical-align: middle;
}

/* 기본 input 스타일 */
input.form-control-sm,
textarea.form-control-sm {
  max-width: 100%;
  min-width: 60px;
  width: auto;
}

/* 이름 input (3자 정도만) */
input[name="o_name"],
input[name="r_name"] {
  width: 120px;
}

/* 이메일, 주소, 메모 input */
input[name="o_email"],
input[name="r_email"],
input[name="o_juso"],
input[name="r_juso"],
textarea[name="memo"] {
  width: 300px;
}

/* 우편번호 input */
input[name="o_zip"],
input[name="r_zip"] {
  width: 100px;
}

/* 전화번호 input */
input[name="o_tel1"],
input[name="o_tel2"],
input[name="o_tel3"],
input[name="r_tel1"],
input[name="r_tel2"],
input[name="r_tel3"] {
  width: 60px;
  text-align: center;
}

/* 테두리 박스 (입체감 효과) */
.boxed-section {
  border: 1px solid #ccc;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
  background-color: #fafafa;
  margin-bottom: 20px;
}

/* 섹션 타이틀 */
font[size="4"] {
  font-weight: bold;
  font-size: 18px;
}

/* 구분선 */
hr {
  border: none;
  border-top: 1px solid #ccc;
  margin: 5px 0 15px 0;
}

/* 입력 박스 여백 제거 */
.form-control-sm {
  padding: 0.25rem 0.5rem;
  font-size: 13px;
  border-radius: 4px;
  border: 1px solid #ccc;
}

/* 메모 textarea */
textarea[name="memo"] {
  width: 300px;
  resize: none;
}

/* 버튼 여백 */
a.btn {
  margin-left: 5px;
}

/* 다음 버튼 중앙 정렬 */
.next-button-wrapper {
  text-align: center;
  margin: 30px 0;
}

/* 반응형 */
@media (max-width: 600px) {
  .row .col {
    max-width: 100%;
  }

  input[name="o_name"],
  input[name="r_name"],
  input[name="o_email"],
  input[name="r_email"],
  input[name="o_juso"],
  input[name="r_juso"],
  textarea[name="memo"] {
    width: 100%;
  }

  input[name="o_zip"],
  input[name="r_zip"] {
    width: 80px;
  }

  textarea[name="memo"] {
    width: 100%;
  }
}
</style>



<!-- form2 시작  여기가 핵심!!!! -->
<form name="form2" method="post" action="order_pay.php">

<div class="row mx-1 my-0">
  <div class="col boxed-section" align="center">
    <font size="4" color="#B90319">주문정보</font>
    <hr class="m-0 my-2">
		
		<table  style="font-size:13px;">
			<tr height="40">
				<td align="left" width="100">이름 <font color="red">*</font></td>
				<td align="left">
					<div class="d-inline-flex">
						<input type="text" name="o_name" size="20" value="<?=$o_name;?>" 
							class="form-control form-control-sm">
					</div>
				</td>
			</tr>
			<tr height="40">
				<td align="left" width="20%">휴대폰 <font color="red">*</font></td>
				<td align="left">
					<div class="d-inline-flex">
						<input type="text" name="o_tel1" size="3" maxlength="3" value="<?=$o_tel1;?>" 
							class="form-control form-control-sm">-
						<input type="text" name="o_tel2" size="4" maxlength="4" value="<?=$o_tel2;?>"		
							class="form-control form-control-sm">-
						<input type="text" name="o_tel3" size="4" maxlength="4" value="<?=$o_tel3;?>"		
							class="form-control form-control-sm">
					</div>
				</td>
			</tr>
			<tr height="40">
				<td align="left">이메일 <font color="red">*</font></td>
				<td align="left">
					<div class="d-inline-flex">
						<input type="text" name="o_email" size="50" value="<?=$o_email;?>" 
							class="form-control form-control-sm">
					</div>
				</td>
			</tr>
			<tr height="80">
				<td align="left">주소 <font color="red">*</font></td>
				<td align="left">
					<div class="d-inline-flex mb-1">
						<input type="text" name="o_zip" size="5" maxlength="5" value="<?=$o_zip; ?>" 
							class="form-control form-control-sm">&nbsp;
					</div>
					<a href="javascript:FindZip(1)"  class="btn btn-sm btn-secondary text-white mb-1"  
						style="font-size:12px">우편번호 찾기</a><br>
					<div class="d-inline-flex">
						<input type="text" name="o_juso" size="50" value="<?=$o_juso;?>" 
							class="form-control form-control-sm">
					</div>
				</td>
			</tr>
		</table>
		
	</div>
</div>

<br>

<div class="row mx-1 my-3">
  <div class="col boxed-section" align="center">
    <font size="4" color="#B90319">배송정보</font>
    <hr class="m-0 my-2">
	
		<table style="font-size:13px;">
			<tr height="40">
				<td align="left" width="20%">위 복사</td>
				<td align="left">
					<div class="d-inline-flex">
						<div class="form-check">
							<input class="form-check-input" type="radio" name="same" 
								onclick="javascript:SameCopy('Y')">
							<label class="form-check-label me-2">예</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="same" 
								onclick="javascript:SameCopy('N')">
							<label class="form-check-label">아니오</label>
						</div>
					</div>
				</td>
			</tr>
			<tr height="40">
				<td align="left">이름 <font color="red">*</font></td>
				<td align="left">
					<div class="d-inline-flex">
						<input type="text" name="r_name" size="20" value="" class="form-control form-control-sm">
					</div>
				</td>
			</tr>
			<tr height="40">
				<td align="left">휴대폰 <font color="red">*</font></td>
				<td align="left">
					<div class="d-inline-flex">
						<input type="text" name="r_tel1" size="3" maxlength="3" value="010" 
							class="form-control form-control-sm">-
						<input type="text" name="r_tel2" size="4" maxlength="4" value=""
							class="form-control form-control-sm">-
						<input type="text" name="r_tel3" size="4" maxlength="4" value=""
							class="form-control form-control-sm">
					</div>
				</td>
			</tr>
			<tr height="40">
				<td align="left">이메일 <font color="red">*</font></td>
				<td align="left">
					<div class="d-inline-flex">
						<input type="text" name="r_email" size="50" value="" 
							class="form-control form-control-sm">
					</div>
				</td>
			</tr>
			<tr height="80">
				<td align="left">주소 <font color="red">*</font></td>
				<td align="left">
					<div class="d-inline-flex mb-1">
						<input type="text" name="r_zip" size="5" maxlength="5" value="" 
							class="form-control form-control-sm">&nbsp;
					</div>
					<a href="javascript:FindZip(2)"  class="btn btn-sm btn-secondary text-white mb-1"  
						style="font-size:12px">우편번호 찾기</a><br>
					<div class="d-inline-flex">
						<input type="text" name="r_juso" size="50" value="" 
							class="form-control form-control-sm">
					</div>
				</td>
			</tr>
			<tr height="90">
				<td align="left">요구사항</td>
				<td align="left">
					<div class="d-inline-flex">
						<textarea name="memo" cols="50" rows="3" 
							class="form-control form-control-sm"></textarea>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>

<div class="next-button-wrapper">
  <a href="javascript:Check_Value()" class="btn btn-sm btn-dark text-white">
    &nbsp;다 &nbsp;&nbsp; 음&nbsp;
  </a>
</div>

</form>

<br><br><br>

<?
	include "main_bottom.php";
?>
