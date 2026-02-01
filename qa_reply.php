<?
	include "main_top.php";

	$id=$_REQUEST["id"];
	
	$sql="select * from qa where id=$id";
	
	$result=mysqli_query($db,$sql);
	if (!$result) exit("에러: $sql");
	
	$row=mysqli_fetch_array($result);
	
	$pos1=$row["pos1"];
	$pos2=$row["pos2"];
	
	$title = $row["title"];
	if (stripos($title, "Re:") !== 0) {
    $title = "Re:" . $title;
	}
	$title = stripslashes($title);
	
	#$title = "Re:" . stripslashes($row["title"]);
	
		$contents = stripslashes($row["contents"]);
	$original_name = $row["name"];

	// 내용에서 각 줄을 분리하여 ::를 붙여줄 텍스트를 만들기
	$quoted_lines = explode("\n", $contents);
	$quoted_text = "";
	$first_line = true; // 첫 번째 줄만 ::를 붙여주는 플래그
	$answer_started = false; // "▶답변:"이 시작되었는지 여부를 추적

	foreach ($quoted_lines as $line) {
		// "▶답변:"이 나오기 전까지는 "::"를 붙이고, 그 이후에는 붙이지 않음
		if (strlen(trim($line)) > 0 && !$answer_started) {
			// "▶답변:"을 찾으면 이후 줄에는 ::를 붙이지 않도록 설정
			if (strpos($line, "▶답변:") !== false) {
				$answer_started = true; // "▶답변:" 시작
				$quoted_text .= ":: " . $line . "\n"; // "::"를 붙임
			} else {
				$quoted_text .= ":: " . $line . "\n"; // 첫 번째 줄에만 "::"를 붙임
			}
		} else {
			// "▶답변:" 이후 줄에는 그냥 내용만 출력
			$quoted_text .= $line . "\n";
		}
	}

	// 내용 앞에 원본 글 정보 추가
	$contents = ":: 『{$original_name}님의 글』\n" . $quoted_text . "▶답변: ";


	
	
	
	
	
	
	
	
/* 	$contents = stripslashes($row["contents"]);
$original_name = $row["name"];
$quoted_lines = explode("\n", $contents);
$quoted_text = "";
foreach ($quoted_lines as $line) {
    $quoted_text .= ":: " . $line . "\n";
}
$contents = ":: 『{$original_name}님의 글』\n" . $quoted_text . "▶답변: ";
	
	 */
	
	
	#$contents = stripslashes($row["contents"]);  
	#$contents = "::  『". $row["name"] . "님의 글 』\n::\n::" .
	#			str_replace("\n","\n::",$contents) . "\n::\n▶답변: ";
?>
<!--  현재 페이지 자바스크립 -->
<script >
	function Check_Value() {
		if (!form2.title.value) {
			alert('글제목을 입력하여 주십시요');
			form1.title.focus();
			return;    		
		}
		if (!form2.name.value) {
			alert('이름을 입력하여 주십시요');
			form2.name.focus();
			return;    		
		}
	  if (!form2.passwd.value) {
			alert('암호를 입력하여 주십시요');
			form2.password.focus();
			return;    		
		}
		form2.submit();
	}
</script>

<!--  form2 시작 -->
<form name="form2" method="post" action="qa_insertreply.php">

<input type="hidden" name="page" value="1">
<input type="hidden" name="text1" value="">
<input type="hidden" name="id" value="<?=$id;?>">
<input type="hidden" name="pos1" value="<?=$pos1;?>">
<input type="hidden" name="pos2" value="<?=$pos2;?>">

<div class="row m-1  mb-0 justify-content-center">
	<div class="col" align="center">

		<h4 class="mt-5">Q & A</h4>

		<hr style="height:2px" class="mb-0">
		<table class="table table-sm m-0">
			<tr>
				<td width="15%" class="bg-light">제목</td>
				<td align="left" class="px-2">
					<div class="d-inline-flex">
						<input type="text" name="title" size="85" value="<?=htmlspecialchars($title);?>" 
							class="form-control form-control-sm">				
					</div>
				</td>
			</tr>
			<tr>
				<td class="bg-light">작성자</td>
				<td align="left" class="px-2">
					<div class="d-inline-flex">
						<input type="text" name="name" size="20" value="" 
							class="form-control form-control-sm">				
					</div>
				</td>
			</tr>
			<tr>
				<td class="bg-light">비밀번호</td>
				<td align="left" class="px-2">
					<div class="d-inline-flex">
						<input type="password" name="passwd" size="20" value="<?=$row["passwd"];?>" 
							class="form-control form-control-sm">				
					</div>
				</td>
			</tr>
			<tr>
				<td class="bg-light">내용</td>
				<td align="left" class="p-2">
					<textarea name="contents" rows="10" cols="85" 
						class="form-control form-control-sm p-2"><?=htmlspecialchars($contents);?>
					</textarea>
				</td>
			</tr>
		</table>

		<table width="100%" class="m-2">
			<tr>
				<td align="center" class="pe-2">
					<a href="javascript:Check_Value();" 
						class="btn btn-sm btn-dark text-white">저장</a>&nbsp;&nbsp;
					<a href="javascript:history.back()" 
						class="btn btn-sm btn-dark text-white">목록</a>
				</td>
			</tr>
		</table>
	
	</div>
</div>

</form>

<br><br><br>

<?
	include "main_bottom.php";
?>
 
 