<?
 include "common.php";
 
 include "admin_check.php";
 
 
 $day1=$_REQUEST["day1"]?$_REQUEST["day1"]: date("Y-m-d",strtotime("-1month"));
 $day2=$_REQUEST["day2"]?$_REQUEST["day2"]: date("Y-m-d");
 $sel1=$_REQUEST["sel1"]?$_REQUEST["sel1"]: 0;
 $sel2=$_REQUEST["sel2"]?$_REQUEST["sel2"]: 1;
 $text1=$_REQUEST["text1"]?$_REQUEST["text1"]: "";
 
 if (!$sel1) $sel1=0;
 if (!$sel2) $sel2=0;
 if (!$text1) $text1="";
 
 $k=0;


if ($day1 != "" && $day2 != "") {
	$s[$k] = "jumunday between '$day1' and '$day2' ";
	$k++;
}
	

 
if ($sel1 != 0) { $s[$k] = "state=". $sel1 ; $k++; }

if ($text1) {
    if ($sel2 == 1) {
        $s[$k] = "id like '%" . $text1 . "%'"; //$sql=" select * from member where name like '%$text1%'  order by name ";
        $k++; //꼭 없어도 된다
    } elseif ($sel2 == 2) {
        $s[$k] = "o_name like '%" . $text1 . "%'";
        $k++; //꼭 없어도 된다
    } else {
		$s[$k] = "product_names like '%" . $text1 . "%'";
        $k++; //꼭 없어도 된다
	}
		
}

if ($k > 0)
{
    $tmp=implode(" and ", $s);
    $tmp = " where ". $tmp;
}
 
 $sql="select * from jumun ". $tmp ."  order by id desc";
 
 
 $args = "day1=$day1&day2=$day2&sel1=$sel1&sel2=$sel2&text1=$text1";
 $result = mypagination($sql, $args, $count, $pagebar);
 
 
?>

<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>현재 작업 진행중입니당~</title>
	<link  href="../css/bootstrap.min.css" rel="stylesheet">
	<link  href="../css/my.css" rel="stylesheet">
	<script src="..js/jquery-3.7.1.min.js"></script>
	<script src="../js/bootstrap.bundle.min.js"></script>
	<script src="../js/my.js"></script>
	
	<style>

/* hover시 */
select[name="state"]:hover {
    border-color: #007bff;
    background-color: #d0f0fd;
    cursor: pointer;
}

/* focus시 */
select[name="state"]:focus {
    border-color: #0056b3;
    box-shadow: 0 0 5px rgba(0, 86, 179, 0.5);
    outline: none;
    background-color: #ffffff;
}
	</style>
	
</head>
<body>

<div class="container">
<!-------------------------------------------------------------------------------------------->	
<script> document.write(admin_menu());</script>
<!-------------------------------------------------------------------------------------------->	

<script>
	function  search_clear()
		{
			form1.sel1.value="0";
			form1.sel2.value="1";

			form1.text1.value="";
		}
		
	function go_update(id,pos)
	{
		
		state=form1.state[pos].value;
		//form1.state.value=form1.state[pos].value;
			
		
		location.href="jumun_update.php?id="+id+
		"&state="+state+
		
		"&page="+(form1.page ? form1.page.value : 1)+//이 부분을 추가하거나 빼거나 결국엔 form1에 page와 관련된 게 없는데 이거 도대체 왜 넣은거지?
			"&sel1="+form1.sel1.value+
			"&sel2="+form1.sel2.value+
			"&text1="+form1.text1.value+
			"&day1="+form1.day1.value+
			"&day2="+form1.day2.value;
	}

//	스타일때문에 추가
	function changeColor(sel) {
    var selectedOption = sel.options[sel.selectedIndex];
    sel.style.transition = 'color 0.3s ease'; // 색깔 부드럽게 변환
    sel.style.color = selectedOption.style.color;
}

// 페이지 열릴 때 초기 색 적용인데 없어도 그만인듯
window.onload = function() {
    const selects = document.querySelectorAll('select[name="state"]');
    selects.forEach(changeColor);
}

</script>

<div class="row mx-1 justify-content-center">
	<div class="col" align="center">

		<h4 class="m-0 mb-3">주문 조회</h4>

		<form name="form1" method="post" action="jumun.php">
		
		<table class="table table-sm table-borderless m-0 p-0">
			<tr>
				<td width="20%" align="left" style="padding-top:8px">
					주문수 : <font color="red"><?= $count; ?></font>
				</td>
				<td align="right">
				
					기간:
					<div class="d-inline-flex align-items-center">
						<input type="date" name="day1" value="<?= $day1; ?>" 
							class="form-control form-control-sm"  style="width:120px" >&nbsp;<span style="line-height: 32px;">~</span>&nbsp;
						<input type="date" name="day2" value="<?= $day2; ?>" 
							class="form-control form-control-sm" style="width:120px" >
					</div>

					<div class="d-inline-flex">
						<select name="sel1" class="form-select form-select-sm bg-light myfs12" style="width:100px">				
							<? 
								for($i=0; $i<$n_state; $i++)
								{
									$tmp = ($i==$sel1) ? "selected" : "";
									echo("<option value='$i' $tmp>$a_state[$i]</option>");
								}
							?>	
						</select>&nbsp;
					
						<select name="sel2" class="form-select bg-light myfs12" style="width:105px">
							<option value="1" <?= ($sel2==1) ? "selected" : "";?>>주문번호</option>
							<option value="2" <?= ($sel2==2) ? "selected" : "";?>>고객명</option>
							<option value="3" <?= ($sel2==3) ? "selected" : "";?>>상품명</option>						
						</select>
					</div>
					<div class="d-inline-flex">
						<div class="input-group input-group-sm">
							<input type="text" name="text1" value="<?= $text1; ?>" 
								class="form-control myfs12" style="width:100px" 
								onKeydown="if (event.keyCode == 13) { form1.submit(); }"> 
							<button class="btn mycolor1 myfs12" type="button" 
								onClick="form1.submit();">검색</button>
						</div>
					</div>
					
					<div class="d-inline-flex">
						<a href="javascript:search_clear()" class="btn btn-sm mycolor1 myfs12">초기화</a>
					</div>
					
				</td>
			</tr>
		</table>
		
		<table class="table table-sm table-bordered table-hover my-1">
			<tr class="bg-light">
				<td>주문번호</td>
				<td>주문일</td>
				<td width="30%">제품명</td>
				<td width="5%">제품수</td>
				<td>금액</td>
				<td>주문자</td>
				<td width="5%">결제</td>
				<td width="20%">주문상태</td>
				<td width="5%">삭제</td>
			</tr>
<?
		$pos = 0; // select box 순서 추적용
		
		foreach($result as $row)
		{
			
			$id=$row["id"]; //주문번호
			
			if($row["pay_kind"]==0)
				$pay_kind="카드";
			else
				$pay_kind="무통장";
			//$pay_kind = ($row["pay_kind"] == 0) ? "카드" : "무통장";
			
			
			//콤보박스 색상 아직 미해결############################################ 아직 미심쩍어.. 뭔가 찜찜................................
			$state=$row["state"];
			
?>			
			<tr>
				<td class="mywordwrap">
					<a href="jumun_info.php?id=<?=$id; ?>" style="color:#0085dd"><?= $id; ?></a>
				</td>
				<td><?=$row["jumunday"]; ?></td>
				<td align="center" class="mywordwrap"><?=$row["product_names"]; ?></td>	
				<td><?=$row["product_nums"]; ?></td>	
				<td align="center" class="mywordwrap"><?=number_format($row["totalprice"]); ?>원</td>	
				<td><?=$row["o_name"]; ?></td>	
				<td><?=$pay_kind;?></td>	
				<td>
					<div class="d-sm-inline-flex">
					
						<select name="state" class="form-select form-select-sm myfs12 me-1" style='font-size:9pt;' onchange="changeColor(this)">
					<? 
					
						for($i=1; $i<$n_state; $i++)
						{
							
							$color="black";
							if ($i==5) $color="blue";
							if ($i==6) $color="red";
							
							$tmp = ($i==$state) ? "selected" : "";
							
							echo("<option value='$i' $tmp style='color:$color;'>$a_state[$i]</option>");
						}
					 
					?>
						</select>
						<a href="javascript:go_update('<?=$id; ?>',<?=$pos; ?>);" 
							class="btn btn-sm mybutton-blue" style="width:50px;">수정</a>
					</div>
				</td>
				<td>
					<a href="jumun_delete.php?id=<?=$id; ?>" 
						class="btn btn-sm mybutton-red" 
						onclick="javascript:return confirm('삭제할까요 ?');">삭제</a>				
				</td>
			</tr>
<?
		$pos++; // 다음 줄로 넘어갈 때 인덱스 증가
		}
?>			
			
		</table>

		<input type="hidden" name="state">
		
		
		</form>

<?
	echo $pagebar;
?>	

	</div>
</div>
<!-------------------------------------------------------------------------------------------->	
</div>

</body>
</html>
