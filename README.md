# PHP Men's Grooming Shop 🛒

## 📌 프로젝트 개요
이 프로젝트는 **PHP와 MySQL을 사용해 구현한 남성 중심 화장품 쇼핑몰 웹 프로젝트**입니다.  
올리브영 스타일의 쇼핑몰 구조를 참고하여 **상품 관리, 관리자 페이지, Q&A 게시판** 등을 직접 구현한 학습·과제용 프로젝트입니다.

## 🛒 쇼핑몰 주제
- **주제:** 남성 그루밍 · 화장품 쇼핑몰  
- **컨셉:** Olive Young 스타일을 참고한 온라인 화장품 몰  
- **특징:**
  - 남성 중심 화장품/그루밍 제품
  - 할인, New/Hit/Sale 아이콘
  - 관리자 기반 상품 관리

## 🧱 기술 스택
- **Backend:** PHP (procedural, 레거시 스타일)
- **Database:** MySQL (mysqli)
- **Frontend:** HTML, CSS, Bootstrap, JavaScript
- **Server 환경:** PHP 7+ (구버전 PHP 코드 일부 수정 포함)
- **Version Control:** Git / GitHub


## 🧩 주요 기능 구성

### 1️⃣ 상품 관리 (관리자 페이지)
- 상품 등록 / 수정 / 삭제
- 상품 분류(카테고리)
- 옵션 관리 (opt1 / opt2)
- 상품 상태 관리 (판매중 / 판매중지 / 품절)
- 아이콘 관리 (New / Hit / Sale)
- 할인율 적용
- 상품 이미지 1~3장 업로드 및 선택적 삭제
- 등록일 직접 지정 가능

### 2️⃣ 쇼핑몰 상품 페이지
- 상품 정보 출력
- 이미지 미리보기 및 확대 모달
- 옵션 선택 구조

### 3️⃣ Q&A 게시판
- 게시글 목록 / 상세보기
- 게시글 작성
- 답글 기능
- 게시글 수정 / 삭제
- **비밀번호 기반 게시글 보호**
- 조회수 증가 기능
- 서버 측(PHP)에서 비밀번호 검증 처리

### 4️⃣ 공통 구조
- `common.php`, `main_top.php`, `main_bottom.php` 등 공통 include 구조
- DB 연결 및 공통 설정 분리
- SQL 직접 작성 방식 (ORM 미사용)



## 🛠️ 구현 과정에서 고려한 사항

- PHP 7+ 환경에서 제거된 함수(`eregi_replace`)를 `preg_replace` / `str_ireplace` 등으로 수정
- 클라이언트(JavaScript)에서 민감 정보 검증을 하지 않고 **서버(PHP)에서 비밀번호 검증**
- `<textarea>`와 `<input>`의 데이터 전송 방식 차이 이해 및 적용
- 관리자 중심 구조이므로 로그인/권한 구조 확장 가능성 고려



<img width="2572" height="2884" alt="메인" src="https://github.com/user-attachments/assets/4ff0fde7-8043-4539-a43b-86603c49d01c" />
<img width="2560" height="2143" alt="회원가입" src="https://github.com/user-attachments/assets/89f14ad5-361d-4bf0-8171-24df8b415c91" />
<img width="2560" height="1631" alt="장바구니" src="https://github.com/user-attachments/assets/9ad76436-8b1b-4f77-8e83-1187f786cd3e" />
<img width="2560" height="2153" alt="주문조회" src="https://github.com/user-attachments/assets/05fefeed-912d-4651-b3b3-1e50ee2e70de" />

