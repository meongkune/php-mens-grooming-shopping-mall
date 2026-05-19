# DB 복구 분석

이 문서는 PHP 코드에서 직접 사용한 SQL을 기준으로 역추적했다. 화면 복구가 목적이므로 과도한 정규화는 하지 않았고, 코드상 0/NULL 같은 센티널 값이 섞이는 관계는 외래키로 강제하지 않았다.

## 공통 DB 연결 점검

- `common.php`, `admin/common.php`: `mysqli_connect("localhost","shop9","1234","shop9")`
- `zipcode.php`: `mysqli_connect("localhost", "zip", "zips","zip")`
- XAMPP 기본 MySQL은 보통 `localhost / root / 빈 비밀번호` 조합이다. 현재 설정을 그대로 쓰려면 MySQL에 `shop9` 사용자와 `zip` 사용자를 만들어야 한다.
- 변경 제안(아직 PHP 파일 미수정): 로컬 XAMPP에서 바로 실행하려면 `common.php`와 `admin/common.php`의 연결을 `mysqli_connect("localhost","root","","shop9")`로 바꾸는 방법이 가장 단순하다. `zipcode.php`도 별도 `zip` DB를 유지한다면 `mysqli_connect("localhost","root","","zip")`로 맞추는 편이 쉽다.

## 테이블별 용도와 근거

### `product`

- 용도: 상품 목록, 상세, 검색, 관리자 상품 등록/수정/삭제.
- 근거 PHP: `main.php`, `main_top.php`, `menu.php`, `product.php`, `product_ex.php`, `product_search.php`, `cart.php`, `order.php`, `order_pay.php`, `order_insert.php`, `admin/product.php`, `admin/product_new.php`, `admin/product_edit.php`, `admin/product_insert.php`, `admin/product_update.php`, `admin/product_delete.php`.
- 주요 컬럼: `id`, `menu`, `code`, `name`, `coname`, `price`, `opt1`, `opt2`, `contents`, `status`, `regday`, `icon_new`, `icon_hit`, `icon_sale`, `discount`, `image1`, `image2`, `image3`.
- 관계/한계: `opt1`, `opt2`는 `opt.id`를 가리키는 것으로 보이나 0을 "옵션 없음"으로 사용하므로 외래키를 강제하지 않았다. `menu`, `status`, 아이콘 값은 `common.php` 배열 인덱스 기반이다.

### `opt`

- 용도: 옵션 그룹 관리. 상품 등록/수정 화면에서 옵션 그룹 선택.
- 근거 PHP: `admin/opt.php`, `admin/opt_insert.php`, `admin/opt_edit.php`, `admin/opt_update.php`, `admin/opt_delete.php`, `admin/product_new.php`, `admin/product_edit.php`, `product_ex.php`.
- 주요 컬럼: `id`, `name`.
- 관계/한계: `product.opt1/opt2`, `opts.opt_id`와 연결된다. 기존 코드가 삭제 시 연쇄 처리를 하지 않아 SQL에는 주석으로만 관계를 표시했다.

### `opts`

- 용도: 옵션 그룹에 속한 실제 선택 항목. 상품 상세, 장바구니, 주문 상세에서 표시.
- 근거 PHP: `admin/opts.php`, `admin/opts_insert.php`, `admin/opts_edit.php`, `admin/opts_update.php`, `admin/opts_delete.php`, `product.php`, `product_ex.php`, `junproduct.php`, `cart.php`, `order.php`, `order_pay.php`, `order_insert.php`, `jumun_info.php`, `admin/jumun_info.php`.
- 주요 컬럼: `id`, `opt_id`, `name`.
- 관계/한계: `opts.opt_id -> opt.id`로 추정. 일부 오래된 파일(`New file.php`)은 `opts.no`를 조회하지만 현재 다른 코드와 불일치하므로 `no` 컬럼은 확정하지 않았다.

### `member`

- 용도: 회원 가입, 로그인, 정보 수정, 관리자 회원 관리, 주문 조회의 회원 판별.
- 근거 PHP: `member_insert.php`, `member_check.php`, `member_idcheck.php`, `member_edit.php`, `member_update.php`, `member_searchid.php`, `member_searchpw.php`, `jumun.php`, `order.php`, `admin/member.php`, `admin/member_edit.php`, `admin/member_update.php`, `admin/member_delete.php`.
- 주요 컬럼: `id`, `uid`, `pwd`, `name`, `tel`, `zip`, `juso`, `email`, `birthday`, `gubun`.
- 관계/한계: `jumun.member_id`가 `member.id`를 가리키지만 비회원 주문은 0을 저장하므로 외래키를 만들지 않았다. 비밀번호는 평문으로 사용된다.

### `jumun`

- 용도: 주문 헤더. 주문자/수령자/결제/상태/총액 저장.
- 근거 PHP: `order_insert.php`, `jumun.php`, `jumun_info.php`, `admin/jumun.php`, `admin/jumun_info.php`, `admin/jumun_update.php`, `admin/jumun_delete.php`.
- 주요 컬럼: `id`, `member_id`, `jumunday`, `product_names`, `product_nums`, `o_name`, `o_tel`, `o_email`, `o_zip`, `o_juso`, `r_name`, `r_tel`, `r_email`, `r_zip`, `r_juso`, `memo`, `pay_kind`, `card_okno`, `card_halbu`, `card_kind`, `bank_kind`, `bank_sender`, `totalprice`, `state`.
- 관계/한계: `id`는 `YYMMDD` + 4자리 순번 형식이다. `pay_kind`는 코드상 0=카드, 1=무통장으로 사용된다. `state`는 `common.php`의 `$a_state` 배열 인덱스다.

### `jumuns`

- 용도: 주문 상세 라인. 상품별 수량/단가/금액/할인/옵션 저장.
- 근거 PHP: `order_insert.php`, `jumun_info.php`, `jumun_info_old.php`, `admin/jumun_info.php`, `admin/jumun_delete.php`.
- 주요 컬럼: `id`(추정 자동번호), `jumun_id`, `product_id`, `num`, `price`, `prices`, `discount`, `opts_id1`, `opts_id2`.
- 관계/한계: `jumun_id -> jumun.id`, `product_id -> product.id`, `opts_id1/opts_id2 -> opts.id` 관계가 보인다. 다만 배송비를 `product_id=0`, 옵션 없음에 `0` 또는 `NULL`을 사용하므로 외래키는 강제하지 않았다. `id` 컬럼은 코드에서 직접 사용하지 않지만 주문 상세 행 식별을 위해 추정 추가했다.

### `qa`

- 용도: Q&A 게시판 원글/답글, 조회수, 비밀번호 기반 수정/삭제.
- 근거 PHP: `qa.php`, `qa_new.php`, `qa_insert.php`, `qa_read.php`, `qa_reply.php`, `qa_insertreply.php`, `qa_edit.php`, `qa_update.php`, `qa_delete.php`.
- 주요 컬럼: `id`, `pos1`, `pos2`, `title`, `name`, `passwd`, `writeday`, `count`, `contents`.
- 관계/한계: `pos1`은 원글 묶음, `pos2`는 답글 경로(`A`, `AA` 등)로 쓰인다. DB 제약보다는 코드 로직으로 유지된다.

### `juso`

- 용도: `juso` 폴더의 주소록 실습/관리 화면.
- 근거 PHP: `juso/juso_list.php`, `juso/juso_insert.php`, `juso/juso_edit.php`, `juso/juso_update.php`, `juso/juso_delete.php`.
- 주요 컬럼: `id`, `name`, `tel`, `sm`, `birthday`, `juso`.
- 관계/한계: 쇼핑몰 핵심 기능과 직접 연결되지 않는 별도 예제성 기능으로 보인다.

### `zip1` ~ `zip17`

- 용도: 우편번호 팝업 검색.
- 근거 PHP: `zipcode.php`.
- 주요 컬럼: `id`(추정), `zip`, `juso1`, `juso2`, `juso3`, `juso4`, `juso5`, `juso6`, `juso7`.
- 관계/한계: `zipcode.php`는 쇼핑몰 DB가 아니라 별도 `zip` DB에 접속한다. 실제 전국 우편번호 데이터는 복구할 수 없으므로 화면 오류 방지용 최소 샘플만 넣었다.

## 기능별 테이블 사용

- 사용자 상품 화면: `product`, `opt`, `opts`
- 사용자 장바구니/결제: `product`, `opts`, `member`, `jumun`, `jumuns`
- 사용자 주문 조회: `jumun`, `jumuns`, `product`, `opts`, `member`
- 사용자 Q&A: `qa`
- 회원 기능: `member`, 우편번호 팝업은 별도 `zip.zipN`
- 관리자 상품 관리: `product`, `opt`, `opts`
- 관리자 회원 관리: `member`
- 관리자 주문 관리: `jumun`, `jumuns`, `product`, `opts`
- 주소록 예제: `juso`

## 복구 한계

- 원본 한글 인코딩이 일부 깨져 있어 라벨 의미는 코드의 변수명과 SQL 사용처를 우선했다.
- 상품 원본 데이터는 없으므로 `product/`와 `images/`의 실제 파일명을 이용해 화면이 깨지지 않는 더미 상품을 만들었다.
- `New file.php`의 `opts.no` 조회는 다른 파일의 `opts.id` 구조와 충돌해 확정하지 않았다.
- `zip` DB의 실제 데이터는 없다. `zipcode.php`가 실패하지 않을 정도의 최소 구조와 서울 샘플만 포함했다.
