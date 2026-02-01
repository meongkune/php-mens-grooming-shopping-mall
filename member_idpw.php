<?
include "main_top.php";
?>

<!--  현재 페이지 자바스크립  -------------------------------------------->
<script language = "javascript">
	function SearchID() 
	{
		var uname = form2.name.value;
		var email = form2.email.value;
		if (form2.name.value == "") {
			alert("이름을 입력해 주십시오.");
			form2.name.focus();
			return;
		}
		if (form2.email.value == "") {
			alert("E-Mail을 입력해 주십시오.");
			form2.email.focus();
			return;
		}
		window.open("member_searchid.php?name="+uname+"&email="+email, "", 
			"width=300, height=210, top=100, left=100, scrollbars=no, status=no");
		form2.reset();
	}
	function SearchPW() 
	{
		var userid = form3.userid.value;
		var uname = form3.name.value;
		if (form3.userid.value == "") {
			alert("아이디를 입력해 주십시오.");
			form3.userid.focus();
			return;
		}
		if (form3.name.value == "") {
			alert("이름을 입력해 주십시오.");
			form3.name.focus();
			return;
		}
		window.open("member_searchpw.php?userid="+userid+"&name="+uname, "", 
			"width=300, height=210, top=100, left=100, scrollbars=no, status=no");
		form3.reset();
	}
</script>

<div class="row m-1 mb-0">
	<div class="col" align="center">

		<h4 class="m-3 mt-5">아이디/암호 찾기</h4>

		<hr size="4px" class="m-0">

		<br><br><br>

		<table width="340" height="300" style="border:4px solid #eeeeee"  bgcolor="#fcfcfc">
			<tr>
				<td align="center">
					<!-- form2 시작 ------>
					<form name="form2" method="post" action="">
					
					<table>
						<tr height="30">
							<td width="70%" colspan="2" class="ps-5">
								<font size="3" color="#017d77"><b>아이디 찾기</b></font>
							</td>
							<td width="25%"></td>
						</tr>
						<tr height="45">
							<td width="20%"><b>이름</b></td>
							<td width="50%">
								<div class="d-inline-flex">
									<input type="text" name="name" size="20" value="" 
										class="form-control form-control-sm" tabindex="1">
								</div>
							</td>
							<td width="30%" rowspan="2">
								<a href="javascript:SearchID()" class="btn btn-sm btn-dark text-white mx-2 pt-4" 
									style="height:75px;width:75px;"  tabindex="3">&nbsp;확인&nbsp;</a>
							</td>
						</tr>
						<tr height="45">
							<td><b>E-Mail</b></td>
							<td>
								<div class="d-inline-flex">
									<input type="text" name="email" size="20" value="" 
										class="form-control form-control-sm" tabindex="2">
								</div>
							</td>
						</tr>
					</table>
					</form>
					<!--form2 끝 ------>
				</td>
			</tr>
			<tr>
				<td><hr class="m-0"></td>
			</tr>
			<tr>
				<td align="center">
					<!-- form3 시작 ------>
					<form name="form3" method="post" action="">
					<table>
						<tr height="30">
							<td width="70%" colspan="2" class="ps-5">
								<font size="3" color="#0a3de4"><b>암호 찾기</b></font>
							</td>
							<td width="25%"></td>
						</tr>
						<tr height="45">
							<td width="20%"><b>ID</b></td>
							<td width="50%">
								<div class="d-inline-flex">
									<input type="text" name="userid" size="20" value="" 
										class="form-control form-control-sm" tabindex="4">
								</div>
							</td>
							<td width="30%" rowspan="2">
								<a href="javascript:SearchPW()" class="btn btn-sm btn-secondary text-white mx-2 pt-4" 
									style="height:75px;width:75px;"  tabindex="6">&nbsp;확인&nbsp;</a>
							</td>
						</tr>
						<tr height="45">
							<td><b>이름</b></td>
							<td>
								<div class="d-inline-flex">
									<input type="text" name="name" size="20" value="" 
										class="form-control form-control-sm" tabindex="5">
								</div>
							</td>
						</tr>
					</table>
					</form>
					<!--form3 끝 ------>
				</td>
			</tr>
		</table>

	</div>
</div>

<br><br><br><br><br><br><br><br>

<?
	include "main_bottom.php";
?>
