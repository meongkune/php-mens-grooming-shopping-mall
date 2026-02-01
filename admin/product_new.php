<?
 include "common.php";
 
 
  $menu= $_REQUEST["menu"] ? $_REQUEST["menu"]: 0;
  $opt1= $_REQUEST["opt1"] ? $_REQUEST["opt1"]: 0; //지금 이 코드에선 무의미? 한거 같은디
  $opt2= $_REQUEST["opt2"] ? $_REQUEST["opt2"]: 0; //지큼 이 코드에선 무의미? 한거 같은디  value='0'이런식으로 해도 ㄱㅊ
  
 ?>
<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>INDUK Meongkune</title>
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

<form name="form1" method="post" action="product_insert.php" enctype="multipart/form-data">

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
						$tmp = ($i==$menu) ? "selected" : "";
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
						<input type="text" name="code" size="20" value="" class="form-control form-control-sm">
					</div>
				</td>
			</tr>
			<tr>
				<td class="bg-light">상품명</td>
				<td align="left" class="ps-2">
					<div class="d-inline-flex">
						<input type="text" name="name" size="80" value="" class="form-control form-control-sm">
					</div>
				</td>
			</tr>
			<tr>
				<td class="bg-light">제조사</td>
				<td align="left" class="ps-2">
					<div class="d-inline-flex">
						<input type="text" name="coname" size="30" value="" class="form-control form-control-sm">
					</div>
				</td>
			</tr>
			<tr>
				<td class="bg-light">판매가</td>
				<td align="left" class="ps-2">
					<div class="d-inline-flex">
						<input type="text" name="price" size="12" value="" class="form-control form-control-sm">
					</div> 원
				</td>
			</tr>
			
			<?
                        $sql="select * from opt order by id";
                        $result=mysqli_query($db,$sql);
                        if(!$result)exit("에러: $sql");
                        
                        
                     ?>
         <tr>
            <td class="bg-light">옵션</td>
            <td align="left" class="ps-2">
               <div class="d-inline-flex">
                  <select name="opt1" class="form-select form-select-sm bg-light myfs12 me-2" style="width:100px">
                     <option value="0" selected>옵션 선택</option>
                  <?
                     while ($row = mysqli_fetch_array($result)) 
                     {
                        if (isset($_REQUEST["opt1"]) && $_REQUEST["opt1"] == $row["id"]) 
                        {
                           echo("<option value=' " . $row["id"] . " ' selected>" . $row["name"] . "</option>");
                        }
                        else 
                        {
                           echo("<option value='" . $row["id"] . "'>" . $row["name"] . "</option>");
                        }
                     }
                  ?>

						</select>
						<select name="opt2" class="form-select form-select-sm bg-light myfs12 me-2" style="width:100px">
							<option value="0" selected>옵션 선택</option>
				<?
					 mysqli_data_seek($result,0);
                     while ($row = mysqli_fetch_array($result)) 
                     {
						
                        if (isset($_REQUEST["opt2"]) && $_REQUEST["opt2"] == $row["id"]) 
                        {
                           echo("<option value='" . $row["id"] . "' selected>" . $row["name"] . "</option>");
                        }
                        else 
                        {
                           echo("<option value='" . $row["id"] . "'>" . $row["name"] . "</option>");
                        }
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
						<textarea name="contents" rows="5" cols="80" class="form-control form-control-sm myfs12"></textarea>
					</div>
				</td>
			</tr>
			<tr>
				<td class="bg-light">삼품상태</td>
				<td align="left" class="ps-2">
					<div class="form-check form-check-inline pt-2">
						<input class="form-check-input" type="radio" name="status" value="1" checked>
						<label class="form-check-label me-2">판매중</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="status" value="2">
						<label class="form-check-labe me-2">판매중지</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="status" value="3">
						<label class="form-check-label me-2">품절</label>
					</div>
				</td>
			</tr>
			
			<tr>
				<td class="bg-light">아이콘</td>
				<td align="left" class="ps-2">
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" value="1" name="icon_new" checked>
							<label class="form-check-label me-2">New</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" value="1" name="icon_hit">
							<label class="form-check-label me-2">Hit</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" value="1" name="icon_sale">
							<label class="form-check-label me-2">sale</label>
						</div>
						할인율: &nbsp;
						<div class="d-inline-flex">
							<input type="text" name="discount" value="0" size="2" maxlength="3" class="form-control form-control-sm"> 
						</div> %
				</td>
			</tr>
			<tr>
			<?
			 $today=date("Y-m-d");
			?>
				<td class="bg-light">등록일</td>
				<td align="left" class="ps-2">
					<div class="d-inline-flex">
						<input type="date" name="regday" value="<?echo ("$today");?>" class="form-control form-control-sm">
					</div>
				</td>
			</tr>
			<tr>
				<td class="bg-light">이미지</td>
				<td align="left" class="ps-2">
					<b>이미지1 : </b>&nbsp;
					<div class="d-inline-flex mb-1">
						<input type="file" name="image1" class="form-control form-control-sm myfs12">
					</div>
					<br>
					<b>이미지2 : </b>&nbsp;
					<div class="d-inline-flex mb-1">
						<input type="file" name="image2" class="form-control form-control-sm myfs12">
					</div>
					<br>
					<b>이미지3 : </b>&nbsp;
					<div class="d-inline-flex">
						<input type="file" name="image3" class="form-control form-control-sm myfs12">
					</div>
				</td>
			</tr>
		</table>

		<a href="javascript:form1.submit();"  class="btn btn-sm btn-dark text-white my-2">&nbsp;저 장&nbsp;</a>&nbsp;
		<a href="javascript:history.back();"  class="btn btn-sm btn-outline-dark my-2">&nbsp;돌아가기&nbsp;</a>

	</div>
</div>
<br>
<!-------------------------------------------------------------------------------------------->	
</div>

</body>
</html>
