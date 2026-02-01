<?
	include "main_top.php";
	$cookie_id=$_COOKIE["cookie_id"];
	$name=$_REQUEST["name"];
	$email=$_REQUEST["email"];
	
	if($cookie_id || ($name && $email))
	{
		if($cookie_id)
			$sql="select * from jumun where member_id=$cookie_id order by id desc";
		else {
			 $member_sql = "SELECT * FROM member WHERE name='$name' AND email='$email'";//내가 추가한 부분
			 $member_result = mysqli_query($db, $member_sql);
			 if (!$member_result) exit("에러: $member_sql");
			 $member_row = mysqli_fetch_array($member_result);
			 
			 if ($member_row) {
				echo "<script>
					alert(
						'이미 등록이 완료된 회원내역입니다.\\n' +
						'개인정보 보호 차원에서라도\\n' + '로그인부터 하고 다시 주문내역을 조회 하시길 바랍니다.'
					);
					location.href='member_login.php'; 
				</script>";
				exit;
			 } //여기까지 추가한 부분
			
			 $sql="select * from jumun where o_name='$name' and o_email='$email' order by id desc";
		}	
			
		
		$args = "name=$name&email=$email";
		$result = mypagination($sql, $args, $count, $pagebar);
		
	
		
		
	}
	else
		echo("<script>location.href='jumun_login.php'</script>");
	
	
	//책에 없는거 내가 추가한 부분
	if ($count == 0) {
        
		if ($cookie_id){ // 로그인 상태인데 주문 내역이 없는 경우 → 바로 이전페이지로 돌아가기
			echo "<script>
            alert(
                '조회된 주문이 없습니다.\\n' +
                '구매할 상품부터 먼저 결제하시길 바랍니다.'
            );
            history.back();  // 이전 페이지(로그인 폼)로 돌아갑니다.
        </script>";
		}
		else {  // 비회원으로 주문조회했는데 없는 경우 → 로그인폼(jumun_login.php)으로 이동
			echo "<script>
            alert(
                '조회된 주문이 없습니다.\\n' +
                '이름과 이메일을 다시 확인해 주세요.'
            );
            location.href='jumun_login.php';  // jumun_login.php 페이지로 리다이렉트
        </script>";
			
		}
		
        exit;  // 스크립트 여기서 멈춤
    }
?>




<!--

<div class="row m-1 mt-4 mb-0">
	<div class="col" align="center">

		<h4 class="m-3">주문조회</h4>

		<hr class="m-0">
		<table class="table table-sm mb-4">
			<tr height="40" class="bg-light">
				<td width="15%">주문일</td>
				<td width="15%">주문번호</td>
				<td width="35%">제품정보</td>
				<td width="15%" align="right">결제금액</td>
				<td width="20%">주문상태</td>
			</tr>
			
<?	
		foreach($result as $row)
		{
			$id=$row["id"]; //주문번호
			
			$color="black";
			if ($row["state"]==5) $color="blue";
			if ($row["state"]==6) $color="red";
?>			
			<tr height="40">
				<td><?=$row["jumunday"];?></td>
				<td class="mywordwrap">
					<a href="jumun_info.php?id=<?=$id; ?>" style="font-size:14px;color:#0066CC"><?=$id; ?></a>
				</td>
				<td align="center"><?=$row["product_names"]; ?></td>
				<td align="right" style="font-size:14px;"><?=number_format($row["totalprice"]); ?>원</td>
				<td><font color="$color"><?=$a_state[$row["state"]]; ?></a></td>
			</tr>
<?
		
		}
?>			
		</table>

	</div>
</div>

-->
<?
	# echo $pagebar;
?>	

<div class="row justify-content-center mt-5">
  <div class="col-md-10">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="text-center mb-4">주문조회</h4>

        <table class="table table-bordered text-center align-middle">
          <thead class="table-light">
            <tr>
              <th style="width: 15%;">주문일</th>
              <th style="width: 15%;">주문번호</th>
              <th style="width: 35%;">제품정보</th>
              <th style="width: 15%;">결제금액</th>
              <th style="width: 20%;">주문상태</th>
            </tr>
          </thead>
          <tbody>
<?php foreach ($result as $row):
  $id = $row["id"];
  $color = match ($row["state"]) {
    5 => 'blue',
    6 => 'red',
    default => '#333'
  };
?>
            <tr>
              <td><?= $row["jumunday"]; ?></td>
              <td>
                <a href="jumun_info.php?id=<?= $id; ?>" class="text-primary" style="font-size: 14px;">
                  <?= $id; ?>
                </a>
              </td>
              <td class="text-center"><?= $row["product_names"]; ?></td>
              <td style="font-size:14px;"><?= number_format($row["totalprice"]); ?>원</td>
              <td style="color:<?= $color; ?>; font-weight:600;"><?= $a_state[$row["state"]]; ?></td>
            </tr>
<?php endforeach; ?>
          </tbody>
        </table>

        <div class="text-center mt-3">
          <?= $pagebar; ?>
        </div>
      </div>
    </div>
  </div>
</div>













<br><br><br>

<?
	include "main_bottom.php";
?>
