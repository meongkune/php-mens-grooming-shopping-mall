<?php
include "common.php";
$cookie_id = $_COOKIE["cookie_id"];
$find_text = $_REQUEST["find_text"] ?? "";
$sql = "SELECT * FROM product WHERE name LIKE '%$find_text%' ORDER BY name";
$args = "find_text=$find_text";
$result = mypagination($sql, $args, $count, $pagebar);
?>
<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Olivelle Men’s Cosmetics</title>

	<link rel="icon" href="images/olive1.png" type="image/png">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	

	
	<script src="js/jquery-3.7.1.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<link href="css/custom.css" rel="stylesheet">
	<style>
	* {
      font-family: 'Noto Sans KR', sans-serif !important;
    }

    body {
      font-size: 16px;
      font-weight: 700; /* 기본을 Bold로! */
    }

    h1, h2, h3, .product-info-table td[colspan="2"], .price-box {
      font-weight: 900; /* 제목, 가격 등은 더 강렬하게 */
    }
		body {
			font-family: 'Pretendard', sans-serif;
			background-color: #f4f6f8;
			color: #333;
		}
		a {
			color: #3BAEA0;
			text-decoration: none;
			transition: 0.2s ease-in-out;
		}
		a:hover {
			color: #2C3E50;
			text-decoration: underline;
		}
		.nav-link {
			color: #333 !important;
			font-weight: 500;
			padding: 8px 12px;
			border-radius: 8px;
			transition: background 0.2s ease-in-out;
		}
		.nav-link:hover {
			background-color: #e0f7f4;
			color: #3BAEA0 !important;
			font-weight: 600;
		}
		.carousel-caption {
			background: rgba(0, 0, 0, 0.3);
			padding: 1rem;
			border-radius: 10px;
		}
		.carousel-caption h1, .carousel-caption h3 {
			text-shadow: 0px 0px 6px rgba(0, 0, 0, 0.3);
			font-weight: 700;
		}
		.carousel-item img {
			height: 450px;
			object-fit: cover;
			border-radius: 12px;
		}
		form input[type="text"] {
			border-radius: 20px;
			padding-left: 14px;
		}
		form .btn {
			border-radius: 20px;
			padding: 5px 16px;
			background-color: #3BAEA0;
			color: white;
			border: none;
			transition: 0.2s ease-in-out;
		}
		form .btn:hover {
			background-color: #2C3E50;
		}
		.shadow-sm {
			box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04) !important;
		}
		.container {
			max-width: 1140px;
		}
		footer {
			background-color: #2C3E50;
			color: white;
		}
	</style>
</head>
<body>

<div class="container mt-3">
<!-- 헤더 영역 -->
<div class="row align-items-center justify-content-between py-3">
  <div class="col-auto d-flex align-items-center">
    <a href="index.html" class="d-flex align-items-center text-dark text-decoration-none">
      <img src="images/olive.png" width="50" class="me-2">
      <div class="fw-bold" style="font-size: 20px; font-family: 'Courier New', monospace;">
        Olivelle Men’s Cosmetics
      </div>
    </a>
  </div>
  <div class="col text-end">
    <nav class="d-inline-flex align-items-center gap-3" style="font-family: 'Courier New', monospace; font-size: 14px;">
      <?php
        if (!$cookie_id) {
          echo '
            <a href="index.html">Home</a> |
            <a href="member_login.php">Login</a> |
            <a href="member_join.php">회원가입</a> |
            <a href="cart.php">장바구니</a> |
            <a href="jumun_login.php">주문조회</a> |
            <a href="qa.php">Q & A</a> |
            <a href="faq.html">FAQ</a>';
        } else {
          echo '
            <a href="index.html">Home</a> |
            <a href="member_logout.php">Logout</a> |
            <a href="member_edit.php">회원정보수정</a> |
            <a href="cart.php">장바구니</a> |
            <a href="jumun.php">주문조회</a> |
            <a href="qa.php">Q & A</a> |
            <a href="faq.html">FAQ</a>';
        }
      ?>
    </nav>
  </div>
</div>


<script>
function goRandomProduct(productIds) {
    const randomIndex = Math.floor(Math.random() * productIds.length);
    const selectedId = productIds[randomIndex];
    window.location.href = `product_ex.php?id=${selectedId}`;
}
</script>


	<!-- 슬라이드 -->
	<div id="carouselExampleIndicators" class="carousel slide mt-4" data-bs-ride="carousel" data-bs-interval="4000">
		<div class="carousel-indicators">
			<?php for ($i = 0; $i < 4; $i++): ?>
				<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?= $i ?>" <?= $i == 0 ? 'class="active" aria-current="true"' : '' ?>></button>
			<?php endfor; ?>
		</div>
		
		
<div class="carousel-inner shadow-sm">
    <div class="carousel-item active">
        <a href="product_ex.php?id=63">
            <img src="images/snature.jpg" class="d-block w-100">
        </a>
    </div>
    <div class="carousel-item">
        <a href="product_ex.php?id=82">
            <img src="images/cure.jpg" class="d-block w-100">
        </a>
    </div>
<div class="carousel-item">
    <img src="images/stable.jpg" class="d-block w-100" style="cursor:pointer;" onclick="goRandomProduct(['65', '111', '72'])">
</div>
<div class="carousel-item">
    <img src="images/mild.jpg" class="d-block w-100" style="cursor:pointer;" onclick="goRandomProduct(['110', '109', '80'])">
</div>
   
</div>

		
		
		
		<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
			<span class="carousel-control-prev-icon"></span>
			<span class="visually-hidden">Previous</span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
			<span class="carousel-control-next-icon"></span>
			<span class="visually-hidden">Next</span>
		</button>
	</div>

	<!-- 메뉴 + 검색 -->
	<div class="row bg-white border rounded shadow-sm mt-4 p-2">
		<div class="col d-flex align-items-center">
			<ul class="nav me-auto">
				<?php
				for ($i = 1; $i < $n_menu; $i++) {
					echo ('<li class="nav-item"><a class="nav-link" href="menu.php?menu=' . $i . '">' . $a_menu[$i] . '</a></li>');
				}
				?>
			</ul>
			<form name="form1" method="post" action="product_search.php" class="d-flex">
				<input type="text" name="find_text" class="form-control form-control-sm me-2" placeholder="상품명 검색">
				<button class="btn btn-dark">Search</button>
			</form>
		</div>
	</div>

	<!-- 여기에 상품 목록 삽입 예정 -->

	
</div>
</body>
</html>
