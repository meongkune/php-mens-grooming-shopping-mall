<?
	include "common.php";
	
	$id=$_REQUEST["id"];
	
		
	$sql="select * from product where id=$id";
	
	$result=mysqli_query($db,$sql);
	if (!$result) exit("에러: $sql");
	$row= mysqli_fetch_array($result); //  제품정보관련된 $ row  고
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
<script>
	function imageView(strImage)
	{
		this.document.images["big"].src = strImage;
	}
</script>

<form name="form1" method="post" action="product_update.php" 
	enctype="multipart/form-data">

<input type="hidden" name="id" value="<?=$id ?>">

<div class="row mx-1  justify-content-center">
	<div class="col" align="center">

		<h4 class="m-0 mb-3">제품</h4>

		<table class="table table-sm table-bordered myfs12 m-0 p-0">
			<tr>
				<td width="15%" class="bg-light">상품분류</td>
				<td align="left" class="ps-2">
					<div class="d-inline-flex">
						<select name="menu" class="form-select form-select-sm bg-light myfs12">
							<? 
					
					for($i=0; $i<$n_menu; $i++)
					{
						$tmp = ($i==$row["menu"]) ? "selected" : "";
						echo("<option value='$i' $tmp>$a_menu[$i]</option>");
					}
					
					?>
						</select>&nbsp;
					</div>
				</td>
			</tr>
			<tr>
				<td class="bg-light">상품코드</td>
				<td align="left" class="ps-2">
					<div class="d-inline-flex">
						<input type="text" name="code" size="20" value="<?=$row["code"]; ?>" class="form-control form-control-sm">
					</div>
				</td>
			</tr>
			<tr>
				<td class="bg-light">상품명</td>
				<td align="left" class="ps-2">
					<div class="d-inline-flex">
						<input type="text" name="name" size="80" value="<?=stripslashes($row["name"]); ?>" class="form-control form-control-sm">
					</div>
				</td>
			</tr>
			<tr>
				<td class="bg-light">제조사</td>
				<td align="left" class="ps-2">
					<div class="d-inline-flex">
						<input type="text" name="coname" size="30" value="<?=$row["coname"]; ?>" class="form-control form-control-sm">
					</div>
				</td>
			</tr>
			<tr>
				<td class="bg-light">판매가</td>
				<td align="left" class="ps-2">
					<div class="d-inline-flex">
						<input type="text" name="price" size="12" value="<?=$row["price"]; ?>" class="form-control form-control-sm">
					</div> 원
				</td>
			</tr>
			<?
			$sql ="select * from opt order by name";
			$result=mysqli_query($db,$sql); // opt 테이블의 레코드들이 가져와지는 거고
			if (!$result) exit("에러: $sql");
			?>
			
			<tr>
				<td class="bg-light">옵션</td>
				<td align="left" class="ps-2">
					<div class="d-inline-flex">
						<select name="opt1" class="form-select form-select-sm bg-light myfs12 me-2" style="width:100px">
							<option value="0">옵션 선택</option>
							<?
							foreach( $result as $row1 )
							{
								if ($row["opt1"] == $row1["id"])
									echo("<option value='$row1[id]' selected>$row1[name]</option>");
								else
									echo("<option value='$row1[id]'>$row1[name]</option>");
							}
							?>
						</select>
						<select name="opt2" class="form-select form-select-sm bg-light myfs12 me-2" style="width:100px">
							<option value="0">옵션 선택</option>
							<?
							foreach( $result as $row1 )
							{
								if ($row["opt2"] == $row1["id"])
									echo("<option value='$row1[id]' selected>$row1[name]</option>");
								else
									echo("<option value='$row1[id]'>$row1[name]</option>");
							}
							?>
						</select>&nbsp;
					</div>
				</td>
			</tr>
			
			
			
			<tr>
				<td class="bg-light">제품설명</td>
				<td align="left" class="ps-2">
					<div class="d-inline-flex">
						<textarea name="contents" rows="5" cols="80" 
							class="form-control form-control-sm myfs12"><?=stripslashes($row["contents"]); ?></textarea>
					</div>
				</td>
			</tr>
			<tr>
				<td class="bg-light">삼품상태</td> 
				<td align="left" class="ps-2">
				<?
					if ($row["status"]==1)
					echo ' <div class="form-check form-check-inline pt-2">
						<input class="form-check-input" type="radio" name="status" value="1" checked>
						<label class="form-check-label me-2">판매중</label>
					</div> 
					<div class="form-check form-check-inline">
					
					<input class="form-check-input" type="radio" name="status" value="2" > 
						<label class="form-check-labe me-2">판매중지</label> 
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="status" value="3" >						
						<label class="form-check-label me-2">품절</label> 
					</div> ';
					
						if ($row["status"]==2)
							echo '
					<div class="form-check form-check-inline pt-2">
						<input class="form-check-input" type="radio" name="status" value="1" >
						<label class="form-check-label me-2">판매중</label>
					</div> 
					<div class="form-check form-check-inline">
					
					<input class="form-check-input" type="radio" name="status" value="2" checked> 
						<label class="form-check-labe me-2">판매중지</label> 
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="status" value="3" >						
						<label class="form-check-label me-2">품절</label> 
					</div> ';
					
						if ($row["status"]==3)
							echo '
					<div class="form-check form-check-inline pt-2">
						<input class="form-check-input" type="radio" name="status" value="1" >
						<label class="form-check-label me-2">판매중</label>
					</div> 
					<div class="form-check form-check-inline">
					
					<input class="form-check-input" type="radio" name="status" value="2" > 
						<label class="form-check-labe me-2">판매중지</label> 
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="status" value="3" checked >						
						<label class="form-check-label me-2">품절</label> 
					</div> '; // 존나게 비효율적
					?>
				</td>
			</tr>
			<tr>
				<td class="bg-light">아이콘</td>
				<td align="left" class="ps-2">
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" value="1" name="icon_new"  <?= $row["icon_new"]==1? "checked" : ""; ?>>
							<label class="form-check-label me-2">New</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" value="1" name="icon_hit" <?= $row["icon_hit"]==1? "checked" : ""; ?>>
							<label class="form-check-label me-2">Hit</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" value="1" name="icon_sale" <?= $row["icon_sale"]==1? "checked" : ""; ?>>
							<label class="form-check-label me-2">sale</label>
						</div>
						할인율: &nbsp;
						<div class="d-inline-flex">
							<input type="text" name="discount" value="<?= $row["discount"]; ?>" size="2" maxlength="3" class="form-control form-control-sm">
						</div> %
				</td>
			</tr>
			<tr>
				<td class="bg-light">등록일</td>
				<td align="left" class="ps-2">
					<div class="d-inline-flex">
						<input type="date" name="regday" value="<?=$row["regday"]; ?>" class="form-control form-control-sm">
					</div>
				</td>
			</tr>
			<tr>
				<td class="bg-light">이미지<br>(삭제할 그림 체크)</td>
				<td align="left" class="ps-2">
					<table class="my-1">
					<tr>
						<td>
							<img src="../product/<?=$row["image1"];?>" width="50" height="50" class="img-thumbnail" 
								style='cursor:pointer' data-bs-toggle="modal" data-bs-target="#zoomModal" 
								onclick="document.getElementById('zoomModalLabel').innerText='File name: <?=$row["image1"];?>'; picname.src='../product/<?=$row["image1"];?>'">
						</td>
						<td align="left" class="ps-3">
							<input type="hidden" name="imagename1" value="<?=$row["image1"];?>">
							<input type="checkbox" name="checkno1" value="1">
							<b>이미지1이요 : </b><?=$row["image1"];?><br>
							<div class="d-inline-flex">
								<input type="file" name="image1" class="form-control form-control-sm myfs12">
							</div>
						</td>
					</tr>
					</table>
					<table class="mb-1">
					<tr>
						<td>
							<img src="../product/<?=$row["image2"];?>" width="50" height="50" class="img-thumbnail" 
								style='cursor:pointer' data-bs-toggle="modal" data-bs-target="#zoomModal" 
								onclick="document.getElementById('zoomModalLabel').innerText='File name: <?=$row["image2"];?>'; picname.src='../product/<?=$row["image2"];?>'">
						</td>
						<td align="left" class="ps-3">
							<input type="hidden" name="imagename2" value="<?=$row["image2"];?>">
							<input type="checkbox" name="checkno2" value="1">
							<b>이미지2 : </b>&nbsp;<?=$row["image2"];?><br>
							<div class="d-inline-flex">
								<input type="file" name="image2" class="form-control form-control-sm myfs12">
							</div>
						</td>
					</tr>
					</table>
					<table class="mb-1">
					<tr>
						<td>
							<img src="../product/<?=$row["image3"];?>" width="50" height="50" class="img-thumbnail" 
								style='cursor:pointer' data-bs-toggle="modal" data-bs-target="#zoomModal" 
								onclick="document.getElementById('zoomModalLabel').innerText='File name: <?=$row["image3"];?>'; picname.src='../product/<?=$row["image3"];?>'">
						</td>
						<td align="left" class="ps-3">
							<input type="hidden" name="imagename3" value="<?=$row["image3"];?>">
							<input type="checkbox" name="checkno3" value="1">
							<b>이미지3 : </b>&nbsp;<?=$row["image3"];?><br>
							<div class="d-inline-flex">
								<input type="file" name="image3" class="form-control form-control-sm myfs12">
							</div>
						</td>
					</tr>
					</table>
				</td>
			</tr>
		</table>

		<a href="javascript:form1.submit();"  
			class="btn btn-sm btn-dark text-white my-2">&nbsp;저 장&nbsp;</a>&nbsp;
		<a href="javascript:history.back();"  
		class="btn btn-sm btn-dark btn-outline-dark text-white my-2">&nbsp;돌아가기&nbsp;</a>

	</div>
</div>
<br>
<!-------------------------------------------------------------------------------------------->	
</div>

</body>
</html>

<!-- Zoom Modal 이미지 -->
<div class="modal fade" id="zoomModal" tabindex="-1" aria-labelledby="zoomModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header bg-light">
				<h5 class="modal-title" id="zoomModalLabel">상품명1</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" align="center">
				<img src="#" name="picname" class="img-fluid img-thumbnail" style='cursor:pointer' data-bs-dismiss="modal">
			</div>
		</div>
	</div>
</div>