<?php
include "main_top.php";

$id = $_REQUEST["id"]; // 주문번호

// 주문 상품 목록 불러오기 (jumuns + 상품, 옵션 join)
$sql = "SELECT 
            product.id AS id, 
            product.name AS product_name, 
            product.image1 AS product_image1, 
            opts1.name AS name1, 
            opts2.name AS name2,
            jumuns.num AS jumuns_num, 
            jumuns.price AS jumuns_price, 
            jumuns.prices AS jumuns_prices
        FROM ((jumuns 
            LEFT JOIN opts AS opts1 ON jumuns.opts_id1 = opts1.id)
            LEFT JOIN opts AS opts2 ON jumuns.opts_id2 = opts2.id)
            LEFT JOIN product ON jumuns.product_id = product.id
        WHERE jumuns.jumun_id = '$id'";
$result = mysqli_query($db, $sql);
if (!$result) exit("에러: $sql");

// 주문 상세 정보 가져오기 (결제 방식 등)
$sql2 = "SELECT * FROM jumun WHERE id = '$id'";
$result2 = mysqli_query($db, $sql2);
if (!$result2) exit("에러: $sql2");
$row2 = mysqli_fetch_array($result2);

// 전화번호 null 검사 및 포맷팅
$o_tel = $row2["o_tel"] ?? "";
$r_tel = $row2["r_tel"] ?? "";

$o_tel_display = (strlen($o_tel) === 11) 
    ? substr($o_tel, 0, 3) . "-" . substr($o_tel, 3, 4) . "-" . substr($o_tel, 7, 4)
    : $o_tel;

$r_tel_display = (strlen($r_tel) === 11) 
    ? substr($r_tel, 0, 3) . "-" . substr($r_tel, 3, 4) . "-" . substr($r_tel, 7, 4)
    : $r_tel;

// 총 결제금액 누적용
$total = 0;
?>

<div class="container my-4" style="max-width:900px;">
    <h4 class="mb-4 text-center">주문 상세 정보</h4>

    <!-- 주문상품내역 -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light">
            <strong>주문상품내역</strong>
        </div>
        <div class="card-body p-0">
            <table class="table table-sm mb-0">
                <thead class="table-light text-center">
                    <tr>
                        <th width="15%">이미지</th>
                        <th width="35%">상품정보</th>
                        <th width="15%">판매가</th>
                        <th width="15%">수량</th>
                        <th width="20%">금액</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $row): 
                        $product_name = $row['product_name'] ?: "배송비";
                        $product_id = $row["id"];
                        $img_src = $row['product_name'] ? $row['product_image1'] : "baesong.webp";
                        $total += $row['jumuns_prices'];
                    ?>
                    <tr class="align-middle text-center">
                        <td><img src="product/<?= $img_src ?>" width="60" height="70"></td>
                        <td class="text-start">
                            <?php if ($product_id): ?>
                                <a href="product.php?id=<?= $product_id ?>" style="color:#0066CC;"><?= $product_name ?></a><br>
                            <?php else: ?>
                                <?= $product_name ?><br>
                            <?php endif; ?>
                            <?php if ($row["name1"] || $row["name2"]): ?>
                                <small><b>[옵션]</b> <?= $row["name1"] ?> <?= $row["name2"] ?></small>
                            <?php endif; ?>
                        </td>
                        <td><?= number_format($row['jumuns_price']) ?>원</td>
                        <td><?= $row['jumuns_num'] ?></td>
                        <td><?= number_format($row['jumuns_prices']) ?>원</td>
                    </tr>
                    <?php endforeach; ?>
                    <tr class="table-light text-end pe-3">
                        <td colspan="5"><strong class="text-primary">결제금액: <?= number_format($total) ?>원</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 결제정보 -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light">
            <strong class="text-danger">결제정보</strong>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-3 fw-bold">주문번호:</div><div class="col-3"><?= $row2["id"] ?></div>
                <div class="col-3 fw-bold">결제금액:</div><div class="col-3"><?= number_format($total) ?>원</div>
            </div>
            <div class="row mb-2">
                <div class="col-3 fw-bold">결제방식:</div><div class="col-3"><?= $row2["pay_kind"] == 0 ? "카드" : "무통장" ?></div>
                <?php if ($row2["pay_kind"] == 1): ?>
                    <div class="col-3 fw-bold">무통장:</div><div class="col-3"><?= $bank_kinds[$row2["bank_kind"]] ?></div>
                    <div class="col-3 fw-bold">입금자:</div><div class="col-3"><?= $row2["bank_sender"] ?></div>
                <?php else: ?>
                    <div class="col-3 fw-bold">승인번호:</div><div class="col-3"><?= $row2["card_okno"] ?></div>
                    <div class="col-3 fw-bold">카드종류:</div><div class="col-3"><?= $card_kinds[$row2["card_kind"]] ?></div>
                    <div class="col-3 fw-bold">할부:</div><div class="col-3"><?= $card_halbu[$row2["card_halbu"]] ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- 주문자 정보 -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light">
            <strong class="text-danger">주문자 정보</strong>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-3 fw-bold">이름:</div><div class="col-3"><?= $row2["o_name"] ?></div>
                <div class="col-3 fw-bold">핸드폰:</div><div class="col-3"><?= $o_tel_display ?></div>
            </div>
            <div class="row">
                <div class="col-3 fw-bold">이메일:</div><div class="col-9"><?= $row2["o_email"] ?></div>
            </div>
        </div>
    </div>

    <!-- 배송 정보 -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light">
            <strong class="text-danger">배송 정보</strong>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-3 fw-bold">수취인:</div><div class="col-3"><?= $row2["r_name"] ?></div>
                <div class="col-3 fw-bold">핸드폰:</div><div class="col-3"><?= $r_tel_display ?></div>
            </div>
            <div class="row mb-2">
                <div class="col-3 fw-bold">주소:</div><div class="col-9"><?= $row2["r_zip"] ?> <?= $row2["r_juso"] ?></div>
            </div>
            <div class="row">
                <div class="col-3 fw-bold">메모:</div><div class="col-9"><?= $row2["memo"] ?></div>
            </div>
        </div>
    </div>

    <!-- 돌아가기 버튼 -->
    <div class="text-center mb-4">
        <a href="javascript:history.back();" class="btn btn-dark">&nbsp;돌아가기&nbsp;</a>
    </div>
</div>

<?php include "main_bottom.php"; ?>
