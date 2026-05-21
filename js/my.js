function admin_menu()
{
	if (document.body) document.body.classList.add("admin-page");

	var s_menu;

	s_menu = "<nav class='navbar navbar-expand-lg navbar-dark admin-navbar'>" + "\n"
		+ "			<div class='container-fluid px-3 px-lg-4'>" + "\n"
		+ "				<a class='navbar-brand admin-brand' href='../admin/index.html'><span>Olivelle</span> 관리자</a>" + "\n"
		+ "				<button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>" + "\n"
		+ "				<span class='navbar-toggler-icon'></span>" + "\n"
		+ "				</button>" + "\n"
		+ "				<div class='collapse navbar-collapse' id='navbarNav'>" + "\n"
		+ "					<ul class='navbar-nav me-auto admin-nav-list'>" + "\n"
		+ "						<li class='nav-item'><a class='nav-link' href='member.php'>회원관리</a></li>" + "\n"
		+ "						<li class='nav-item'><a class='nav-link' href='product.php'>상품관리</a></li>" + "\n"
		+ "						<li class='nav-item'><a class='nav-link' href='jumun.php'>주문관리</a></li>" + "\n"
		+ "						<li class='nav-item'><a class='nav-link' href='opt.php'>옵션관리</a></li>" + "\n"
		+ "						<li class='nav-item'><a class='nav-link' href='faq.html'>FAQ</a></li>" + "\n"
		+ "					</ul>" + "\n"
		+ "					<div class='d-flex gap-2 admin-nav-actions'>" + "\n"
		+ "						<a class='btn btn-sm btn-admin-outline' href='../index.html'>SHOP</a>" + "\n"
		+ "						<a class='btn btn-sm btn-admin-solid' href='logout.php'>LOGOUT</a>" + "\n"
		+ "					</div>" + "\n"
		+ "				</div>" + "\n"
		+ "			</div>" + "\n"
		+ "		</nav>" + "\n"
		+ "		<div class='admin-spacer'></div>" + "\n";

	return s_menu;
}
