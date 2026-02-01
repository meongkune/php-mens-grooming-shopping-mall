<?
include "main_top.php";
?>


<!-------------------------------------------------------------------------------------------->	
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	

<!--  현재 페이지 자바스크립  -------------------------------------------->
<script>
	function Check_Value() {
		if (!form2.uid.value) {
			alert("아이디를 입력하세요.");	form2.uid.focus();	return;
		}
		if (!form2.pwd.value) {
			alert("암호를 입력하세요.");	form2.pwd.focus();	return;
		}

		form2.submit();
	}
</script>

<!-- form2 시작 -->
<form name="form2" method="post" action="member_check.php">

<div class="row mb-0">
	<div class="col"></div>
	<div class="col" align="center">

<h3 class="mt-5 mb-4">Login</h3>

		<table width="340" height="200" style="border:4px solid #e2e2e2" 
			bgcolor="#fcfcfc" class="table-borderless">
			<tr>
				<td align="center">
				
						<table class="table table-borderless mt-3 align-middle">
  <tr>
    <td width="20%">아이디</td>
    <td width="50%">
      <input type="text" name="uid" class="form-control" tabindex="1">
    </td>
    <td width="30%" rowspan="2" class="text-center align-middle">
      <a href="javascript:Check_Value();" tabindex="3" 
         class="btn btn-success w-100 h-100" style="min-height:30px;">로그인</a>
    </td>
  </tr>
  <tr>
    <td>암 호</td>
    <td>
      <input type="password" name="pwd" class="form-control" tabindex="2">
    </td>
  </tr>
</table>
	
				
				</td>
			</tr>
			<tr><td><hr class="m-0"></td></tr>
			<tr height="80">
    <td align="center">
        <div class="d-flex flex-column align-items-center">
            <a href="member_idpw.php" class="btn btn-sm mybutton mb-2">아이디 / 암호 찾기 (실제 가능!)</a>
			
            <a href="member_join.php" class="btn btn-sm mybutton">회원가입</a>
        </div>
    </td>
</tr>
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
