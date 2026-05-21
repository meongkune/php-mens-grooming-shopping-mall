<style>
  .shop-footer {
    margin-top: 72px;
    background:
      linear-gradient(135deg, rgba(18, 28, 30, 0.98), rgba(33, 52, 49, 0.98)),
      radial-gradient(circle at 12% 0%, rgba(59, 174, 160, 0.22), transparent 34%);
    color: rgba(255,255,255,0.78);
    border-top: 1px solid rgba(255,255,255,0.08);
  }

  .shop-footer__inner {
    padding: 48px 0 24px;
  }

  .shop-footer__brand {
    display: flex;
    align-items: center;
    gap: 14px;
    color: #fff;
    margin-bottom: 18px;
  }

  .shop-footer__brand img {
    width: 58px;
    height: 58px;
    object-fit: contain;
    border-radius: 16px;
    background: rgba(255,255,255,0.95);
    padding: 8px;
    box-shadow: 0 16px 36px rgba(0,0,0,0.28);
  }

  .shop-footer__brand strong {
    display: block;
    font-size: 20px;
    letter-spacing: 0;
    line-height: 1.15;
  }

  .shop-footer__brand span {
    display: block;
    margin-top: 4px;
    font-size: 12px;
    color: rgba(255,255,255,0.58);
    letter-spacing: 1.4px;
  }

  .shop-footer__copy {
    max-width: 430px;
    font-size: 14px;
    line-height: 1.8;
    color: rgba(255,255,255,0.66);
    margin-bottom: 22px;
  }

  .shop-footer__chips {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
  }

  .shop-footer__chip {
    display: inline-flex;
    align-items: center;
    min-height: 30px;
    padding: 6px 12px;
    border: 1px solid rgba(139, 218, 189, 0.28);
    border-radius: 999px;
    color: #dff9ee;
    background: rgba(139, 218, 189, 0.08);
    font-size: 12px;
    white-space: nowrap;
  }

  .shop-footer__title {
    color: #fff;
    font-size: 14px;
    font-weight: 800;
    margin-bottom: 14px;
    letter-spacing: 0;
  }

  .shop-footer__list {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .shop-footer__list li {
    margin-bottom: 9px;
    line-height: 1.55;
    font-size: 13px;
  }

  .shop-footer a {
    color: rgba(223, 249, 238, 0.86);
    text-decoration: none;
  }

  .shop-footer a:hover {
    color: #ffffff;
    text-decoration: none;
  }

  .shop-footer__contact {
    padding: 18px;
    border: 1px solid rgba(255,255,255,0.10);
    border-radius: 16px;
    background: rgba(255,255,255,0.06);
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.08);
  }

  .shop-footer__contact .phone {
    color: #fff;
    font-size: 22px;
    font-weight: 900;
    line-height: 1;
    margin-bottom: 10px;
  }

  .shop-footer__certs {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 16px;
  }

  .shop-footer__certs a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 96px;
    min-height: 36px;
    border-radius: 10px;
    background: rgba(255,255,255,0.92);
    padding: 5px 7px;
  }

  .shop-footer__certs img {
    max-width: 100%;
    max-height: 28px;
  }

  .shop-footer__bar {
    border-top: 1px solid rgba(255,255,255,0.10);
    padding: 18px 0 22px;
    color: rgba(255,255,255,0.52);
    font-size: 12px;
  }

  .shop-footer__bar .links {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-end;
    gap: 14px;
  }

  @media (max-width: 767.98px) {
    .shop-footer {
      margin-top: 48px;
    }

    .shop-footer__inner {
      padding: 36px 0 18px;
    }

    .shop-footer__bar .links {
      justify-content: flex-start;
      margin-top: 10px;
    }
  }
</style>

<footer class="shop-footer">
  <div class="container shop-footer__inner">
    <div class="row g-4">
      <div class="col-lg-5">
        <a href="index.html" class="shop-footer__brand">
          <img src="images/olive.png" alt="Olivelle">
          <div>
            <strong>Olivelle Men's Cosmetics</strong>
            <span>GROOMING SELECT STORE</span>
          </div>
        </a>
        <p class="shop-footer__copy">
          피부 타입과 생활 루틴에 맞춘 남성 그루밍 제품을 선별해 소개합니다.
          매일 쓰는 제품일수록 성분, 사용감, 배송 경험까지 균형 있게 관리합니다.
        </p>
        <div class="shop-footer__chips">
          <span class="shop-footer__chip">전 상품 세일 적용</span>
          <span class="shop-footer__chip">10만원 이상 무료배송</span>
          <span class="shop-footer__chip">평일 1~3일 출고</span>
        </div>
      </div>

      <div class="col-6 col-lg-2">
        <h6 class="shop-footer__title">Shop</h6>
        <ul class="shop-footer__list">
          <li><a href="index.html">Home</a></li>
          <li><a href="product_search.php">Product</a></li>
          <li><a href="cart.php">Cart</a></li>
          <li><a href="jumun_login.php">Order</a></li>
        </ul>
      </div>

      <div class="col-6 col-lg-2">
        <h6 class="shop-footer__title">Support</h6>
        <ul class="shop-footer__list">
          <li><a href="company.html">회사소개</a></li>
          <li><a href="useinfo.html">이용안내</a></li>
          <li><a href="policy.html">개인정보처리방침</a></li>
          <li><a href="qa.php">Q &amp; A</a></li>
          <li><a href="faq.html">FAQ</a></li>
        </ul>
      </div>

      <div class="col-lg-3">
        <div class="shop-footer__contact">
          <h6 class="shop-footer__title">Customer Care</h6>
          <div class="phone">02-3456-7890</div>
          <ul class="shop-footer__list">
            <li>평일 10:00 - 17:00</li>
            <li>점심 12:30 - 13:30</li>
            <li>contact@olivelle.co.kr</li>
          </ul>
          <div class="shop-footer__certs">
            <a href="http://www.ftc.go.kr/" target="_blank" rel="noopener">
              <img src="images/footer_pic1.gif" alt="FTC">
            </a>
            <a href="http://www.sgic.co.kr/" target="_blank" rel="noopener">
              <img src="images/footer_pic2.gif" alt="SGIC">
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container shop-footer__bar">
    <div class="row align-items-center gy-2">
      <div class="col-md-7">
        상호: 인덕주식회사 | 대표: 이명규 | 사업자등록번호: 847-21-563210 |
        주소: 서울특별시 노원구 공릉로 123, 인덕빌딩 5층
      </div>
      <div class="col-md-5">
        <div class="links">
          <a href="policy.html">Privacy</a>
          <a href="useinfo.html">Terms</a>
          <a href="admin/index.html">Admin</a>
        </div>
      </div>
      <div class="col-12">
        &copy; 2026 Olivelle Men's Cosmetics. All rights reserved.
      </div>
    </div>
  </div>
</footer>
