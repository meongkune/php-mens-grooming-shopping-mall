<?
$db = mysqli_connect("localhost", "root", "1234", "zip");
if (!$db) exit("DB연결에러");

$sel = $_REQUEST["sel"] ?? 1;
$text1 = $_REQUEST["text1"] ?? "";
$zip_kind = $_REQUEST["zip_kind"] ?? 0;
?>

<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>우편번호 찾기</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/my.css" rel="stylesheet">
	<script src="js/jquery-3.7.1.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
</head>
<body class="zip-body">

<script>
	function SearchZip()
	{
		if (!form.text1.value)
		{
			alert("검색하실 도로명이나 건물명을 입력해 주십시오.");
			form.text1.focus();
			return;
		}
		form.submit();
	}

	function SendZip(zip_kind)
	{
		if (!form1.post_no.value) {
			alert("검색 결과에서 주소를 선택해 주십시오.");
			form1.post_no.focus();
			return;
		}
		if (!form1.jusor.value) {
			alert("나머지 주소를 입력하여 주십시오.");
			form1.jusor.focus();
			return;
		}
		if (!opener || !opener.form2) {
			alert("주소를 입력할 원래 창을 찾을 수 없습니다.");
			return;
		}

		var str = form1.post_no.value.split("^^");
		var zip = str[0];
		var juso = str[1] + " " + form1.jusor.value;

		if (zip_kind == 1) {
			opener.form2.o_zip.value = zip;
			opener.form2.o_juso.value = juso;
		} else if (zip_kind == 2) {
			opener.form2.r_zip.value = zip;
			opener.form2.r_juso.value = juso;
		} else {
			opener.form2.zip.value = zip;
			opener.form2.juso.value = juso;
		}

		self.close();
	}
</script>

<div class="zip-page">
	<div class="zip-head">
		<h4>우편번호 찾기</h4>
		<p>도로명 또는 건물명 일부를 입력해 검색하세요.</p>
	</div>

	<form name="form" method="post" action="zipcode.php" class="zip-search">
		<input type="hidden" name="zip_kind" value="<?=$zip_kind?>">

		<div class="input-group">
			<select name="sel" class="form-select">
<?
$sido = array(
	1=>"서울", 2=>"경기", 3=>"인천", 4=>"강원", 5=>"충북", 6=>"세종",
	7=>"충남", 8=>"대전", 9=>"경북", 10=>"대구", 11=>"울산", 12=>"부산",
	13=>"경남", 14=>"전북", 15=>"전남", 16=>"광주", 17=>"제주"
);
foreach ($sido as $key => $name) {
	$tmp = ($key == $sel) ? "selected" : "";
	echo "<option value='$key' $tmp>$name</option>";
}
?>
			</select>
			<input type="text" name="text1" value="<?=htmlspecialchars($text1);?>" class="form-control" onKeydown="if (event.keyCode == 13) { SearchZip(); return false; }">
			<a href="javascript:SearchZip()" class="btn zip-btn zip-btn-primary">검색</a>
		</div>
	</form>

	<form name="form1" class="zip-result">
		<label>검색 결과</label>
		<select name="post_no" class="form-select" size="6">
<?
$has_result = false;
if ($text1) {
	$table = "zip" . (int)$sel;
	$safe_text = mysqli_real_escape_string($db, $text1);
	$sql = "SELECT * FROM $table
		WHERE zip LIKE '%$safe_text%'
		   OR juso1 LIKE '%$safe_text%'
		   OR juso2 LIKE '%$safe_text%'
		   OR juso3 LIKE '%$safe_text%'
		   OR juso4 LIKE '%$safe_text%'
		   OR juso5 LIKE '%$safe_text%'
		   OR juso6 LIKE '%$safe_text%'
		   OR juso7 LIKE '%$safe_text%'";
	$result = mysqli_query($db, $sql);

	if (!$result) {
		echo "<option value=''>DB 오류: " . htmlspecialchars(mysqli_error($db)) . "</option>";
	} else {
		while ($row = mysqli_fetch_assoc($result)) {
			$has_result = true;
			$zip = $row["zip"];
			$address = $row["juso1"] . " " . $row["juso2"] . " " . $row["juso3"] . " " . $row["juso4"];
			if ($row["juso5"]) $address .= $row["juso5"];
			if ($row["juso6"] != "0") $address .= "-" . $row["juso6"];
			if ($row["juso7"]) $address .= " " . $row["juso7"];
			$value = htmlspecialchars($zip . "^^" . $address, ENT_QUOTES);
			$text = htmlspecialchars("[$zip] $address");
			echo "<option value='$value'>$text</option>";
		}
		if (!$has_result) {
			echo "<option value=''>검색 결과가 없습니다.</option>";
		}
	}
} else {
	echo "<option value=''>검색어를 입력한 뒤 검색하세요.</option>";
}
?>
		</select>

		<label class="mt-3">나머지 주소</label>
		<input type="text" name="jusor" id="jusor" value="" class="form-control" placeholder="동/호수 등 상세주소">
	</form>

	<div class="zip-actions">
		<a href="javascript:self.close();" class="btn zip-btn zip-btn-secondary">닫기</a>
		<a href="javascript:SendZip(<?= (int)$zip_kind ?>);" class="btn zip-btn zip-btn-primary">확인</a>
	</div>
</div>

</body>
</html>
