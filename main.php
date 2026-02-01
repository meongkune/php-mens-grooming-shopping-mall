<?php
	include "main_top.php";
?>

<!-- 상품 타이틀 -->
<div class="row mt-5 mb-3">
	<div class="col text-center">
		<h2 class="fw-bold text-dark-emphasis">All</h2>
	</div>	
</div>	

<!-- 상품 리스트 -->
<div class="row">
<?php
	$page_line=8;
	$sql="select * from product where status=1 order by rand()";
	$args = "menu=$menu&sort=$sort";	
	$result = mypagination($sql, $args, $count, $pagebar);
	
	foreach($result as $row)
	{
		$id = $row["id"];
		$raw_price = $row["price"];
		$format_price = number_format($raw_price);
		$sale_price = round($raw_price * (100 - $row["discount"]) / 100);
		$format_sale_price = number_format($sale_price);
?>
	<!-- 상품 카드 -->
	<div class="col-md-3 mb-4">
		<div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
			<a href="product_ex.php?id=<?=$id;?>">
				<img src="product/<?=$row["image1"];?>" 
					style="width: 100% !important; height: auto !important; object-fit: cover !important; display: block;"
				   class="card-img-top img-fluid"></a>	
			</a>
			<div class="card-body bg-white text-center">
				<h6 class="card-title mb-2 fw-semibold">
					<a href="product_ex.php?id=<?=$id;?>" class="text-dark text-decoration-none">
						<?=htmlspecialchars($row["name"]);?>
					</a>
				</h6>
				
				<!-- 아이콘들 -->
				<div class="mb-2">
					<?php if ($row["icon_new"] == 1): ?>
    <span class="badge badge-new">NEW</span>
<?php endif; ?>
<?php if ($row["icon_hit"] == 1): ?>
    <span class="badge badge-hit">HIT</span>
<?php endif; ?>
<?php if ($row["icon_sale"] == 1): ?>
    <span class="badge badge-sale">SALE <?= $row["discount"] ?>%</span>
<?php endif; ?>
	
				</div>

				<!-- 가격 -->
				<?php if ($row["icon_sale"]): ?>
					<p class="mb-0">
						<small class="text-muted"><s>₩<?=$format_price;?></s></small><br>
						<b class="text-danger fs-5">₩<?=$format_sale_price;?></b>
					</p>
				<?php else: ?>
					<p class="mb-0"><b class="text-dark fs-5">₩<?=$format_price;?></b></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php
	}
	echo $pagebar;
?>
</div>

<?php include "main_bottom.php"; ?>
