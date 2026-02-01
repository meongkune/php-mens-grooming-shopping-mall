<!-- 상품 상세 페이지 -->
<?
  include "main_top.php";
  $id = $_REQUEST["id"];
  $sql = "select * from product where id=$id";
  $result = mysqli_query($db, $sql);
  if (!$result) exit("에러: $sql");
  $row = mysqli_fetch_array($result);

  $raw_price = $row["price"];
  $format_price = number_format($raw_price);
  $sale_price = round($raw_price * (100 - $row["discount"]) / 100);
  $format_sale_price = number_format($sale_price);

  $price = ($row["icon_sale"] == 1) ? $sale_price : $raw_price;
?>

<style>
  .img-thumbnail-hover {
    transition: transform 0.3s ease;
  }
  .img-thumbnail-hover:hover {
    transform: scale(1.2);
    z-index: 999;
  }
  .img-detail {
    transition: none !important;
    transform: none !important;
  }
  .product-info-table td {
    font-size: 16px;
    padding: 6px 0;
  }
  .product-info-table td[colspan="2"] {
    font-size: 22px;
    font-weight: bold;
  }
  .product-qty input {
    width: 60px;
    text-align: center;
    font-size: 16px;
  }
  .price-box {
    font-size: 20px;
    font-weight: bold;
    color: #d9534f;
  }
</style>
<script>
const optionExtraPrices = {
  41: 0,     // 기본
  37: 3000,  // +25ml
  38: 6000,  // +50ml
  39: 9000,  // +75ml
  40: 12000  // +100ml
};

function cal_price() {
  const qty = parseInt(form2.num.value) || 1;
  const base_price = parseInt(form2.price.value);
  const opt1 = form2.opts1 ? parseInt(form2.opts1.value) : 41;
  const extra_price = optionExtraPrices[opt1] || 0;
  const total = (base_price + extra_price) * qty;
  
  document.getElementById("total_price").innerText = "₩" + total.toLocaleString();
  form2.extra_price.value = extra_price; // hidden input에 저장
}

function check_form2(str) {
  if (form2.opts1 && form2.opts1.value == 0) {
    alert("옵션1을 선택하십시요.");
    form2.opts1.focus();
    return;
  }
  if (form2.opts2 && form2.opts2.value == 0) {
    alert("옵션2를 선택하십시요.");
    form2.opts2.focus();
    return;
  }
  if (!form2.num.value) {
    alert("수량을 입력하십시요.");
    form2.num.focus();
    return;
  }

  // 가격 반영
  cal_price();

  form2.action = "cart_edit.php";
  form2.kind.value = (str == "D") ? "order" : "insert";
  form2.submit();
}

window.addEventListener("DOMContentLoaded", function () {
  form2.num.addEventListener("input", cal_price);
  if (form2.opts1) form2.opts1.addEventListener("change", cal_price);
});
</script>

<style>
  .custom-select-box {
    width: 100%;
    max-width: 200px;
    padding: 8px 12px;
    font-size: 15px;
    border: 1px solid #ccc;
    border-radius: 12px;
    background-color: #fff;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg fill='%23666' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 18px 18px;
    cursor: pointer;
  }

  .custom-select-box:focus {
    outline: none;
    border-color: #999;
    box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
  }
</style>

<style>

  .product-box {
    border: 1.5px solid #e0e0e0;
    border-radius: 12px;
    padding: 20px 30px;
    background-color: #fff;
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.03);
  }

.product-info-table hr {
  border: none;
  border-top: 1.5px solid #000; /* 연민트 */
  margin: 16px 0;
}

  .product-title {
    font-weight: bold;
    font-size: 20px;
    color: #c62828;
  }

  .badge-new, .badge-hit, .badge-sale {
    font-size: 12px;
    padding: 3px 6px;
    border-radius: 4px;
  }
  .badge-new { background-color: #ff8a65; color: white; }
  .badge-hit { background-color: #fdd835; color: black; }
  .badge-sale { background-color: #ef5350; color: white; }
</style>



<form name="form2" method="post" action="">
<input type="hidden" name="kind" value="insert">
<input type="hidden" name="id" value="<?=$id;?>">
<input type="hidden" name="price" value="<?=$price;?>">
<input type="hidden" name="extra_price" value="0">

<div class="row mx-1 my-4 align-items-stretch"> <!-- ✅ 수정된 row -->

  <!-- ✅ 왼쪽 컬럼: 상품 이미지 -->
  <div class="col d-flex flex-column"> <!-- ✅ flex-column 추가 -->
    <div class="product-box"> <!-- ✅ 동일한 박스 구조 -->
      <img src="product/<?=$row["image2"];?>" width="80%" 
        class="img-thumbnail img-fluid mt-2 img-thumbnail-hover"  
        data-bs-toggle="modal" data-bs-target="#zoomModal">
    </div>
  </div>

  <!-- ✅ 오른쪽 컬럼: 상품 정보 -->
  <div class="col d-flex flex-column"> <!-- ✅ flex-column 추가 -->
    <div class="product-box"> <!-- ✅ 동일한 박스 구조 -->
      <table width="100%" class="table table-sm table-borderless p-0 m-0 product-info-table">
        <tr height="50">
          <td colspan="2" align="center" class="product-title"><?=$row["name"]?></td>
        </tr>
        <tr>
          <td colspan="2" class="text-center py-2">
            <?php
              if ($row["icon_new"] == 1) echo '<span class="badge-new me-1">NEW</span>';
              if ($row["icon_hit"] == 1) echo '<span class="badge-hit me-1">HIT</span>';
              if ($row["icon_sale"] == 1) echo '<span class="badge-sale me-1">SALE ' . $row["discount"] . '%</span>';
            ?>
          </td>
        </tr>

        <? if ($row["icon_sale"] != 1) { ?>
          <tr><td colspan="2"><hr></td></tr>
          <tr><td align="center">판매가</td><td align="left">₩<?=$format_price?></td></tr>
        <? } else { ?>
          <tr><td colspan="2"><hr></td></tr>
          <tr><td align="center">판매가</td><td align="left"><strike>₩<?=$format_price?></strike></td></tr>
          <tr><td align="center">할인가</td><td align="left">₩<?=$format_sale_price?></td></tr>
        <? } ?>

        <? if ($row["opt1"] || $row["opt2"]) echo '<tr><td colspan="2"><hr></td></tr>'; ?>

        <? if ($row["opt1"]) {
  // 옵션1 이름 불러오기
  $sql_optname1 = "SELECT name FROM opt WHERE id = $row[opt1]";
  $res_optname1 = mysqli_query($db, $sql_optname1);
  $row_optname1 = mysqli_fetch_array($res_optname1);
  $opt1_name = $row_optname1["name"];

  // 옵션1 항목 불러오기
  $sql_opts1 = "SELECT * FROM opts WHERE opt_id = $row[opt1]";
  $res_opts1 = mysqli_query($db, $sql_opts1);
?>
  <tr>
    <td align="center"><?=$opt1_name?></td>
    <td align="left">
      <select name="opts1" class="form-select form-select-sm mb-2 custom-select-box">
        <option value="0">옵션을 선택하세요.</option>
        <? while ($row1 = mysqli_fetch_array($res_opts1)) {
          echo "<option value='$row1[id]'>$row1[name]</option>";
        } ?>
      </select>
    </td>
  </tr>
<? } else echo '<input type="hidden" name="opts1" value="none">'; ?>


        <? if ($row["opt1"]) { ?>
        <tr><td colspan="2"><hr></td></tr>
        <? } ?>

        <tr>
          <td align="center">수량</td>
          <td align="left" class="product-qty">
            <input type="text" name="num" value="1" class="form-control form-control-sm" maxlength="3">
          </td>
        </tr>

        <tr>
          <td align="center">금액</td>
          <td align="left">
            <div id="total_price" class="price-box">₩<?=number_format($price)?></div>
          </td>
        </tr>

        <tr>
          <td colspan="2" align="center" class="pt-3">
            <a href="javascript:check_form2('D')" class="btn btn-sm btn-dark me-2">바로 구매</a>
            <a href="javascript:check_form2('C')" class="btn btn-sm btn-outline-secondary">장바구니</a>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>

</form>

<? if($row["image3"]){ ?>
<hr class="my-0 mx-3">
<div class="section-detail">
  <h3>세부정보</h3>
</div>
<div align="center">
  <img src="product/<?=$row["image3"]?>" class="img-thumbnail w-75 img-detail">
</div>
<? } ?>


<br>
<!-- 확대 모달 -->
<div class="modal fade" id="zoomModal" tabindex="-1" aria-labelledby="zoomModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="zoomModalLabel"><?=$row["image2"]?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div align="center" class="modal-body">
        <img src="product/<?=$row["image2"]?>" class="img-thumbnail" style="cursor:pointer" data-bs-dismiss="modal">
      </div>
    </div>
  </div>
</div>

<? include "main_bottom.php"; ?>
