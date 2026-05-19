-- Recovery SQL inferred from the PHP source.
-- Target: XAMPP/MySQL, main shopping mall DB name used by common.php: shop9.
-- Import as a privileged MySQL user, for example root in phpMyAdmin.

CREATE DATABASE IF NOT EXISTS `shop9`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;
USE `shop9`;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `jumuns`;
DROP TABLE IF EXISTS `jumun`;
DROP TABLE IF EXISTS `qa`;
DROP TABLE IF EXISTS `product`;
DROP TABLE IF EXISTS `opts`;
DROP TABLE IF EXISTS `opt`;
DROP TABLE IF EXISTS `member`;
DROP TABLE IF EXISTS `juso`;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE `member` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` VARCHAR(50) NOT NULL,
  `pwd` VARCHAR(100) NOT NULL,
  `name` VARCHAR(50) NOT NULL,
  `tel` VARCHAR(20) NOT NULL COMMENT 'PHP stores 01012345678-like text using sprintf("%-3s%-4s%-4s")',
  `zip` VARCHAR(10) NOT NULL,
  `juso` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `birthday` DATE NOT NULL,
  `gubun` TINYINT NOT NULL DEFAULT 0 COMMENT '0=member, 1=withdrawn/admin screen label',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_member_uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `opt` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `opts` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `opt_id` INT UNSIGNED NOT NULL COMMENT 'Code treats this as opt.id',
  `name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_opts_opt_id` (`opt_id`)
  -- Relationship inferred: opts.opt_id -> opt.id. Not enforced because legacy code does not manage cascades.
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `product` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu` TINYINT NOT NULL DEFAULT 0 COMMENT 'Index into $a_menu in common.php',
  `code` VARCHAR(50) NOT NULL,
  `name` VARCHAR(200) NOT NULL,
  `coname` VARCHAR(100) NOT NULL,
  `price` INT UNSIGNED NOT NULL DEFAULT 0,
  `opt1` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Code treats this as opt.id; 0 means no option',
  `opt2` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Code treats this as opt.id; 0 means no option',
  `contents` TEXT NULL,
  `status` TINYINT NOT NULL DEFAULT 1 COMMENT '1=sale, 2=stopped, 3=sold out in common.php arrays',
  `regday` DATE NOT NULL,
  `icon_new` TINYINT NOT NULL DEFAULT 0,
  `icon_hit` TINYINT NOT NULL DEFAULT 0,
  `icon_sale` TINYINT NOT NULL DEFAULT 0,
  `discount` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `image1` VARCHAR(255) NOT NULL DEFAULT '',
  `image2` VARCHAR(255) NOT NULL DEFAULT '',
  `image3` VARCHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_product_menu_status` (`menu`, `status`),
  KEY `idx_product_name` (`name`)
  -- Relationships inferred: product.opt1/product.opt2 -> opt.id when nonzero. Not enforced because 0 is used as "none".
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `qa` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `pos1` INT UNSIGNED NULL COMMENT 'Thread root id; first post is updated to its own id',
  `pos2` VARCHAR(20) NULL COMMENT 'Reply path such as A, AA, AB',
  `title` VARCHAR(200) NOT NULL,
  `name` VARCHAR(50) NOT NULL,
  `passwd` VARCHAR(50) NOT NULL,
  `writeday` DATE NOT NULL,
  `count` INT UNSIGNED NOT NULL DEFAULT 0,
  `contents` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_qa_thread` (`pos1`, `pos2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `jumun` (
  `id` BIGINT UNSIGNED NOT NULL COMMENT 'Generated as YYMMDD + 4-digit sequence',
  `member_id` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 means guest order',
  `jumunday` DATE NOT NULL,
  `product_names` VARCHAR(255) NOT NULL,
  `product_nums` INT UNSIGNED NOT NULL DEFAULT 0,
  `o_name` VARCHAR(50) NOT NULL,
  `o_tel` VARCHAR(20) NOT NULL,
  `o_email` VARCHAR(100) NOT NULL,
  `o_zip` VARCHAR(10) NOT NULL,
  `o_juso` VARCHAR(255) NOT NULL,
  `r_name` VARCHAR(50) NOT NULL,
  `r_tel` VARCHAR(20) NOT NULL,
  `r_email` VARCHAR(100) NOT NULL,
  `r_zip` VARCHAR(10) NOT NULL,
  `r_juso` VARCHAR(255) NOT NULL,
  `memo` VARCHAR(255) NOT NULL DEFAULT '',
  `pay_kind` TINYINT NOT NULL DEFAULT 0 COMMENT '0=card, 1=bank transfer',
  `card_okno` VARCHAR(30) NOT NULL DEFAULT '',
  `card_halbu` TINYINT NOT NULL DEFAULT 0,
  `card_kind` TINYINT NOT NULL DEFAULT 0,
  `bank_kind` TINYINT NOT NULL DEFAULT 0,
  `bank_sender` VARCHAR(50) NOT NULL DEFAULT '',
  `totalprice` INT UNSIGNED NOT NULL DEFAULT 0,
  `state` TINYINT NOT NULL DEFAULT 1 COMMENT 'Index into $a_state in common.php',
  PRIMARY KEY (`id`),
  KEY `idx_jumun_member` (`member_id`),
  KEY `idx_jumun_day_state` (`jumunday`, `state`)
  -- Relationship inferred: member_id -> member.id only when member_id > 0. Not enforced because guests use 0.
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `jumuns` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `jumun_id` BIGINT UNSIGNED NOT NULL,
  `product_id` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 is used for delivery fee row',
  `num` INT UNSIGNED NOT NULL DEFAULT 1,
  `price` INT UNSIGNED NOT NULL DEFAULT 0,
  `prices` INT UNSIGNED NOT NULL DEFAULT 0,
  `discount` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `opts_id1` INT UNSIGNED NULL,
  `opts_id2` INT UNSIGNED NULL,
  PRIMARY KEY (`id`),
  KEY `idx_jumuns_jumun_id` (`jumun_id`),
  KEY `idx_jumuns_product_id` (`product_id`)
  -- Relationships inferred: jumun_id -> jumun.id, product_id -> product.id except product_id=0 shipping rows,
  -- opts_id1/opts_id2 -> opts.id except 0/NULL. Not enforced for legacy sentinel values.
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `juso` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `tel` VARCHAR(20) NOT NULL,
  `sm` TINYINT NOT NULL DEFAULT 0,
  `birthday` DATE NOT NULL,
  `juso` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_juso_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `member` (`id`, `uid`, `pwd`, `name`, `tel`, `zip`, `juso`, `email`, `birthday`, `gubun`) VALUES
(1, 'hong', '1234', '홍길동', '01012345678', '04524', '서울 중구 세종대로 110', 'hong@example.com', '1993-05-12', 0),
(2, 'portfolio', '1234', '포트폴리오고객', '01098765432', '06164', '서울 강남구 테헤란로 521', 'portfolio@example.com', '1998-11-03', 0);

INSERT INTO `opt` (`id`, `name`) VALUES
(1, '용량'),
(2, '피부타입'),
(3, '향'),
(4, '색상');

INSERT INTO `opts` (`id`, `opt_id`, `name`) VALUES
(1, 2, '건성'),
(2, 2, '지성'),
(3, 2, '민감성'),
(4, 3, '무향'),
(5, 3, '시트러스'),
(6, 3, '우디'),
(37, 1, '+25ml'),
(38, 1, '+50ml'),
(39, 1, '+75ml'),
(40, 1, '+100ml'),
(41, 1, '기본');

INSERT INTO `product`
(`id`, `menu`, `code`, `name`, `coname`, `price`, `opt1`, `opt2`, `contents`, `status`, `regday`, `icon_new`, `icon_hit`, `icon_sale`, `discount`, `image1`, `image2`, `image3`) VALUES
(63, 1, 'SKIN-063', '에스네이처 아쿠아 스쿠알란 수분크림', 'S.NATURE', 25000, 1, 2, '가볍고 촉촉한 남성 데일리 수분크림입니다.', 1, '2026-05-01', 1, 1, 1, 15, 'SNATURE GEL CREAM 07 01.jpg', 'SNATURE GEL CREAM 07 01.jpg', 'screencapture-oliveyoung-co-kr-store-goods-getGoodsDetail-do-2025-04-23-13_52_48.png'),
(65, 2, 'MASK-065', '올리벨 포어 케어 클렌징 폼', 'Olivelle', 12900, 1, 0, '피지와 노폐물을 산뜻하게 씻어내는 클렌징 폼입니다.', 1, '2026-05-02', 1, 0, 0, 0, 'A00000018887434ko.jpg', 'A00000018887434ko.jpg', ''),
(72, 3, 'CARE-072', '브그룸 남성 올인원 로션 80ml', 'B.GROOM', 19800, 1, 3, '스킨과 로션을 한번에 관리하는 올인원 제품입니다.', 1, '2026-05-03', 0, 1, 1, 10, '15505269_1331912_3228_org.jpg', '15505269_1331912_3228_org.jpg', 'screencapture-bgroom-co-kr-product-80ml-29-category-77-display-1-2025-06-18-00_02_46.png'),
(80, 4, 'HAND-080', 'DMCK 블랙 앰플 30ml', 'DMCK', 32000, 1, 0, '거칠어진 피부에 영양감을 주는 집중 케어 앰플입니다.', 1, '2026-05-04', 0, 1, 0, 0, 'MPIC100.jpg', 'MPIC100.jpg', ''),
(82, 5, 'CURE-082', '큐어 마일드 진정 토너', 'CURE', 16500, 1, 2, '면도 후 예민해진 피부를 편안하게 정돈합니다.', 1, '2026-05-05', 1, 0, 1, 20, '1733447127314273.jpeg', '1733447127314273.jpeg', ''),
(109, 6, 'SUN-109', '트리 내추럴 선크림', 'Tree Lab', 22000, 1, 0, '백탁을 줄인 데일리 선 케어 제품입니다.', 1, '2026-05-06', 0, 0, 0, 0, 'a28ec11396279.jpg', 'a28ec11396279.jpg', ''),
(110, 7, 'BODY-110', '스테이블 바디 워시', 'Stable', 18000, 1, 3, '운동 후에도 산뜻한 남성 바디 워시입니다.', 1, '2026-05-07', 1, 0, 0, 0, 'MPIC100.jpg', 'MPIC100.jpg', ''),
(111, 8, 'MAKE-111', '메이크프렘 쉐이빙 크림', 'make p:rem', 14500, 1, 0, '부드러운 면도를 돕는 저자극 쉐이빙 크림입니다.', 1, '2026-05-08', 0, 1, 1, 12, 'p3.png', 'p3.png', ''),
(112, 1, 'SKIN-112', '라운드랩 리얼 히알루론 토너', 'Round Lab', 21000, 1, 2, '건조한 피부에 수분감을 보충하는 토너입니다.', 1, '2026-05-09', 0, 0, 1, 18, 'p1.png', 'p1.png', ''),
(113, 2, 'MASK-113', '올리브 남성 진정 마스크', 'Olivelle', 9900, 0, 0, '면도와 외부 자극 후 사용하는 진정 마스크입니다.', 1, '2026-05-10', 1, 0, 0, 0, 'p2.png', 'p2.png', '');

INSERT INTO `qa` (`id`, `pos1`, `pos2`, `title`, `name`, `passwd`, `writeday`, `count`, `contents`) VALUES
(1, 1, 'A', '배송은 얼마나 걸리나요?', '홍길동', '1234', '2026-05-15', 4, '평일 기준 배송 기간을 알고 싶습니다.'),
(2, 1, 'AA', '답변: 배송 안내', '관리자', '1234', '2026-05-15', 1, '평일 오후 주문은 보통 1~3일 안에 도착합니다.'),
(3, 3, 'A', '민감성 피부도 사용할 수 있나요?', '포트폴리오고객', '1234', '2026-05-16', 2, '면도 후 자극이 많은 편이라 추천 상품이 궁금합니다.');

INSERT INTO `jumun`
(`id`, `member_id`, `jumunday`, `product_names`, `product_nums`, `o_name`, `o_tel`, `o_email`, `o_zip`, `o_juso`, `r_name`, `r_tel`, `r_email`, `r_zip`, `r_juso`, `memo`, `pay_kind`, `card_okno`, `card_halbu`, `card_kind`, `bank_kind`, `bank_sender`, `totalprice`, `state`) VALUES
(2605190001, 1, '2026-05-19', '에스네이처 아쿠아 스쿠알란 수분크림 외1', 2, '홍길동', '01012345678', 'hong@example.com', '04524', '서울 중구 세종대로 110', '홍길동', '01012345678', 'hong@example.com', '04524', '서울 중구 세종대로 110', '부재 시 문 앞에 놓아주세요.', 0, '2605190001', 3, 1, 0, '', 48500, 2),
(2605190002, 0, '2026-05-19', '브그룸 남성 올인원 로션 80ml', 1, '비회원고객', '01022223333', 'guest@example.com', '06164', '서울 강남구 테헤란로 521', '비회원고객', '01022223333', 'guest@example.com', '06164', '서울 강남구 테헤란로 521', '', 1, '', 0, 0, 1, '비회원고객', 20320, 1);

INSERT INTO `jumuns`
(`jumun_id`, `product_id`, `num`, `price`, `prices`, `discount`, `opts_id1`, `opts_id2`) VALUES
(2605190001, 63, 1, 21250, 21250, 15, 41, 3),
(2605190001, 65, 1, 12900, 12900, 0, 37, NULL),
(2605190001, 0, 1, 2500, 2500, 0, 0, 0),
(2605190002, 72, 1, 17820, 17820, 10, 41, 5),
(2605190002, 0, 1, 2500, 2500, 0, 0, 0);

INSERT INTO `juso` (`name`, `tel`, `sm`, `birthday`, `juso`) VALUES
('홍길동', '01012345678', 0, '1993-05-12', '서울 중구 세종대로 110'),
('포트폴리오고객', '01098765432', 1, '1998-11-03', '서울 강남구 테헤란로 521');

-- zipcode.php connects to a separate database named zip.
-- This minimal schema prevents the address popup from failing during portfolio capture.
CREATE DATABASE IF NOT EXISTS `zip`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;
USE `zip`;

DROP TABLE IF EXISTS `zip17`;
DROP TABLE IF EXISTS `zip16`;
DROP TABLE IF EXISTS `zip15`;
DROP TABLE IF EXISTS `zip14`;
DROP TABLE IF EXISTS `zip13`;
DROP TABLE IF EXISTS `zip12`;
DROP TABLE IF EXISTS `zip11`;
DROP TABLE IF EXISTS `zip10`;
DROP TABLE IF EXISTS `zip9`;
DROP TABLE IF EXISTS `zip8`;
DROP TABLE IF EXISTS `zip7`;
DROP TABLE IF EXISTS `zip6`;
DROP TABLE IF EXISTS `zip5`;
DROP TABLE IF EXISTS `zip4`;
DROP TABLE IF EXISTS `zip3`;
DROP TABLE IF EXISTS `zip2`;
DROP TABLE IF EXISTS `zip1`;

CREATE TABLE `zip1` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `zip` VARCHAR(10) NOT NULL,
  `juso1` VARCHAR(50) NOT NULL,
  `juso2` VARCHAR(50) NOT NULL,
  `juso3` VARCHAR(50) NOT NULL,
  `juso4` VARCHAR(100) NOT NULL,
  `juso5` VARCHAR(100) NOT NULL DEFAULT '',
  `juso6` VARCHAR(20) NOT NULL DEFAULT '0',
  `juso7` VARCHAR(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_zip1_search` (`juso4`, `juso7`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `zip2` LIKE `zip1`;
CREATE TABLE `zip3` LIKE `zip1`;
CREATE TABLE `zip4` LIKE `zip1`;
CREATE TABLE `zip5` LIKE `zip1`;
CREATE TABLE `zip6` LIKE `zip1`;
CREATE TABLE `zip7` LIKE `zip1`;
CREATE TABLE `zip8` LIKE `zip1`;
CREATE TABLE `zip9` LIKE `zip1`;
CREATE TABLE `zip10` LIKE `zip1`;
CREATE TABLE `zip11` LIKE `zip1`;
CREATE TABLE `zip12` LIKE `zip1`;
CREATE TABLE `zip13` LIKE `zip1`;
CREATE TABLE `zip14` LIKE `zip1`;
CREATE TABLE `zip15` LIKE `zip1`;
CREATE TABLE `zip16` LIKE `zip1`;
CREATE TABLE `zip17` LIKE `zip1`;

INSERT INTO `zip1` (`zip`, `juso1`, `juso2`, `juso3`, `juso4`, `juso5`, `juso6`, `juso7`) VALUES
('04524', '서울특별시', '중구', '', '세종대로', '', '110', ''),
('06164', '서울특별시', '강남구', '', '테헤란로', '', '521', '');

USE `shop9`;
