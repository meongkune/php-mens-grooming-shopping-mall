<?
	include "main_top.php";
?>

<!--  현재 페이지 자바스크립  -------------------------------------------->
<script>
	function NoMember_Check() 
	{
		if (!form2.name.value) {
			alert("이름을 입력해 주십시오.");
			form2.name.focus();
			return;
		}
		if (!form2.email.value) {
			alert("E-Mail을 입력해 주십시오.");
			form2.email.focus();
			return;
		}
		form2.submit();
	}
</script>

<!-- form2 시작 -->
<form name="form2" method="post" action="jumun.php">

<div class="row mb-0">
	<div class="col"></div>
	<div class="col" align="center">

		<h3 class="mt-5">비회원 주문조회</h3>
		<hr size="4px" class="m-0 mb-5">

		<table width="340" height="200" style="border:4px solid #e2e2e2" 
			bgcolor="#fcfcfc" class="table-borderless">
			<tr>
				<td align="center">
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
						<table class="table table-borderless mt-3 align-middle">
  <tr>
    <td width="20%">이름</td>
    <td width="50%">
      <input type="text" name="name" class="form-control" tabindex="1">
    </td>
    <td width="30%" rowspan="2" class="text-center align-middle">
      <a href="javascript:NoMember_Check();" tabindex="3"
         class="btn btn-success w-100 h-100" style="min-height:30px;">로그인</a>
    </td>
  </tr>
  <tr>
    <td>E-Mail</td>
    <td>
      <input type="text" name="email" class="form-control" tabindex="2">
    </td>
  </tr>
</table>

				
				</td>
			</tr>
			<tr><td><hr class="m-0"></td></tr>
			<tr height="50">
				<td align="center">※ 회원님은 로그인 후, 이용하세요.</td>
			</tr>
		</table>

	</div>
	<div class="col"></div>
</div>

</form>

<br><br><br><br><br>
<?
	include "main_bottom.php";
?>
