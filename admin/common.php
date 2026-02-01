<?
	error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
	ini_set("display_errors",1);
	
	mysqli_report(MYSQLI_REPORT_OFF);
	
	$db = mysqli_connect("localhost","shop9","1234","shop9");
	if (!$db) exit("하연결에러하");
	
	$admin_id="admin";
	$admin_pw="1234";
	
	$a_menu=array("분류선택","스킨케어","맨즈케어","스페셜케어","마스크팩&패드","클렌징","선케어","바디&헤어","메이크업");
	$n_menu=count($a_menu);
	
	$a_status = array("상품상태", "판매중", "판매중지", "품절"); // 상품상태
	$n_status = count($a_status);

	$a_icon = array("아이콘 선택", "New", "Hit", "Sale"); // 아이콘
	$n_icon = count($a_icon);

	$a_text1 = array("", "제품이름", "제품번호"); // 검색어
	$n_text1 = count($a_text1);
	
	$baesongbi=2500;
	$max_baesongbi=100000; // 배송비 2500원을 내는 금액 최대 범위
	
	$a_state = array("전체", "주문신청", "주문확인","입금확인", "배송중", "주문완료","주문취소"); // 검색어
	$n_state = count($a_state);
	
	
	// 카드 종류
	$card_kinds = [
		1 => "국민카드",
		2 => "신한카드",
		3 => "우리카드",
		4 => "하나카드"
	];

	// 할부 개월 수
	$card_halbu = [
		0 => "일시불",
		3 => "3개월",
		6 => "6개월",
		9 => "9개월",
		12 => "12개월"
	];

	// 무통장 은행
	$bank_kinds = [
		1 => "국민은행 111-00000-0000",
		2 => "신한은행 222-00000-0000"
	];

	
	
	$page_line=5;
	$page_block=5;
	
		function mypagination($query, $args, &$count, &$pagebar)
	{
		global $db, $page_line, $page_block;			// 서버DB 정보

		$page=$_REQUEST["page"] ? $_REQUEST["page"] : 1;	// page초기화
		
		$url=basename($_SERVER['PHP_SELF']) . "?" . $args;    // 문서이름?전송할 변수들
		
		// 전체 레코드개수
		$sql = strtolower( $query );
		$sql ="select count(*) " . substr($sql, strpos($sql,"from"));
		$result=mysqli_query($db, $sql);
		if (!$result) exit("에러: $sql <br>" . mysqli_error($db));
		$row=mysqli_fetch_array($result);
		$count = $row[0];

		// 페이지내 자료
		$first = ($page-1) * $page_line;
		
		$sql = str_replace(";", "", $query);
		$sql .= " limit $first, $page_line";
		$result=mysqli_query($db, $sql);
		if (!$result) exit("에러: $sql <br>" . mysqli_error($db));

		// pagebar html
		$pages = ceil($count/$page_line);				// 페이지수
		$blocks = ceil($pages/$page_block);			// 블록수 
		$block = ceil($page/$page_block);			// 블록 위치
		$page_s = $page_block * ($block-1);		// 블록의 시작페이지
		$page_e = $page_block * $block;				// 블록의 마지막페이지
		if ($blocks <= $block) $page_e = $pages;

		$pagebar ="<nav>
			<ul class='pagination pagination-sm justify-content-center py-1'>";

		if ($block > 1)				// 이전 블록으로
			$pagebar .="<li class='page-item'>
					<a class='page-link' href='$url&page=$page_s'>◀</a>
				</li>";

		for($i=$page_s+1; $i<=$page_e; $i++)
		{
			if ($page == $i)			// 선택한 page
				$pagebar .="<li class='page-item active'>
						<span class='page-link mycolor1'>$i</span>
					</li>";
			else
				$pagebar .="<li class='page-item'>
						<a class='page-link' href='$url&page=$i'>$i</a>
					</li>";
		}

		if ($block < $blocks)		// 다음 블록으로
			$pagebar .="<li class='page-item'>
					<a class='page-link' href='$url&page=" . $page_e+1 . "'>▶</a>
				</li>";
				
		$pagebar .="</ul>
			</nav>";
			
		return $result;
	}
?>