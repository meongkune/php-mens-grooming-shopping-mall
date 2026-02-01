<!---내가 만든 php문 ---->

<?
	if ($_COOKIE["cookie_admin"] != "yes") {
        echo "<script>
            alert('관리자 로그인이 필요합니다?!');
            location.href='index.html';
        </script>";
        exit();
    }
?>