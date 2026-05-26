# PHP Men's Grooming Shopping Mall

남성 화장품/그루밍 상품을 판매하는 **PHP + MySQL 기반 쇼핑몰 프로젝트**입니다.  
프론트 쇼핑몰(상품 탐색/장바구니/주문)과 관리자 백오피스(상품/옵션/회원/주문 관리), Q&A 게시판까지 하나의 레포지토리에 포함되어 있습니다.

---

## 1) 프로젝트 개요

- **프로젝트 성격**: PHP 절차형 스타일로 구성된 전통적인 쇼핑몰 학습/실습 프로젝트
- **도메인**: 남성 그루밍/스킨케어 중심 커머스
- **구성**
  - 사용자 페이지: 메인, 카테고리, 상세, 장바구니, 주문/결제, 회원, Q&A
  - 관리자 페이지: 상품/옵션/회원/주문 관리
  - 부가 예제: 주소록(`juso/`) 및 우편번호 조회(`zipcode.php`)

---

## 2) 기술 스택

- **Backend**: PHP (procedural)
- **DB**: MySQL + `mysqli`
- **Frontend**: HTML, CSS, Bootstrap, JavaScript(jQuery 포함)
- **정적 자원**: `images/`, `product/`, `css/`, `js/`

---

## 3) 디렉터리/파일 구조

### 루트(사용자 쇼핑몰)

- `main.php`, `main_top.php`, `main_bottom.php`: 메인 진입/공통 레이아웃
- `menu.php`, `product.php`, `product_ex.php`, `product_search.php`: 상품 목록/상세/검색
- `cart.php`, `cart_edit.php`, `order.php`, `order_pay.php`, `order_insert.php`, `order_ok.php`: 장바구니/주문 파이프라인
- `member_*.php`: 회원가입/로그인/정보수정/ID·PW 찾기
- `qa*.php`: Q&A 게시판(CRUD + 답글)
- `common.php`: 공용 상수, 배열 코드북, DB 연결, 페이징 함수

### 관리자

- `admin/` 하위 파일 전반
  - `admin/product*.php`: 상품 CRUD
  - `admin/opt*.php`, `admin/opts*.php`: 옵션 그룹/옵션 항목 관리
  - `admin/member*.php`: 회원 관리
  - `admin/jumun*.php`: 주문 관리(상태 변경/삭제 포함)
  - `admin/common.php`: 관리자 공통 설정/DB 연결/페이징

### 보조 기능

- `juso/`: 주소록 예제 페이지
- `zipcode.php`, `zipcode.html`: 우편번호 검색용 별도 DB 연동
- `recovery.sql`, `bgroom_products_seed.sql`: DB 복구/시드 참고 자료
- `analysis.md`: 코드 기반 DB/테이블 역추적 문서

---

## 4) 핵심 기능

## 4-1. 상품 노출/탐색

- 메인에서 판매중(`status=1`) 상품을 랜덤 노출
- 할인/아이콘(New/Hit/Sale) 기반 가격/뱃지 표현
- 상품 상세에서 옵션 조합 선택

## 4-2. 장바구니/주문

- 쿠키 기반 장바구니 유지 (`cart`, `n_cart`)
- 주문 시 `jumun`(헤더) + `jumuns`(라인) 분리 저장
- 당일 주문번호 시퀀싱(`YYMMDD + 4자리`)
- 결제수단(카드/무통장) 분기, 배송비 조건 처리

## 4-3. 회원

- 회원 가입/로그인/수정/조회 기능 제공
- 주문 시 회원/비회원 분기(`member_id` 사용)

## 4-4. Q&A 게시판

- 목록/상세/작성/수정/삭제
- 답글 트리(`pos1`, `pos2`) 구조
- 게시글 비밀번호 확인 로직 기반 보호

## 4-5. 관리자 백오피스

- 상품/옵션/회원/주문 CRUD
- 주문 상태(주문신청~주문완료/취소) 관리

---

## 5) 실행 전 준비

## 5-1. 권장 환경

- PHP 7.x 이상
- MySQL/MariaDB
- Apache 또는 PHP 내장 서버

## 5-2. DB 생성/복구

1. `shop9` DB 생성
2. `recovery.sql` 또는 보유한 스키마/데이터 SQL 적용
3. 필요 시 `bgroom_products_seed.sql`로 상품 데이터 보강
4. 우편번호 기능 사용 시 `zip` DB 및 `zip1 ~ zip17` 테이블 준비

> 실제 프로젝트에는 DB 덤프 상태가 환경마다 다를 수 있어, `analysis.md`를 참고해 컬럼 누락 여부를 먼저 점검하는 것을 권장합니다.

## 5-3. DB 접속정보 확인

`common.php`, `admin/common.php`의 접속 정보가 현재 환경과 일치해야 합니다.

```php
$db = mysqli_connect("localhost", "root", "1234", "shop9");
```

`zipcode.php`는 별도 `zip` DB를 사용하므로 함께 맞춰야 합니다.

---

## 6) 주요 데이터 모델(요약)

- `product`: 상품 본체(가격, 상태, 아이콘, 할인율, 이미지)
- `opt` / `opts`: 옵션 그룹 / 옵션 항목
- `member`: 회원
- `jumun`: 주문 헤더(주문자/수령자/결제/상태/총액)
- `jumuns`: 주문 라인(상품별 수량/금액/옵션)
- `qa`: Q&A 게시판
- `juso`: 주소록 예제
- `zip1~zip17`: 우편번호 검색 데이터

상세 근거와 컬럼 해석은 `analysis.md`에 정리되어 있습니다.

---

## 7) 코드 특성 및 유지보수 메모

- 전반적으로 **절차형 + 직접 SQL 문자열 조합** 패턴
- 일부 페이지에서 `$_REQUEST`, 쿠키를 직접 사용
- 화면/로직/쿼리가 한 파일에 혼재되어 있어 기능별 분리 리팩터링 여지 큼
- 레거시 특성상 인코딩/파일명/샘플 이미지 상태가 균일하지 않을 수 있음

---

## 8) 개선 제안(다음 단계)

- 비밀번호 해시(`password_hash`) 적용
- Prepared Statement 적용(SQL Injection 방지 강화)
- 공통 유틸/검증 로직 분리
- `.env` 기반 DB 설정 분리
- 주문/결제 트랜잭션 처리 보강
- 관리자 인증 세션 강화를 통한 권한 분리

---

## 9) 참고 문서

- `analysis.md`: DB 및 기능 역추적 분석
- `git-upload-flow.md`: 업로드/버전관리 관련 메모
