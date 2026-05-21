-- shop9 recovery seed
-- XAMPP/MySQL에서 그대로 import 하면 shop9 데이터베이스와 기본 데이터가 생성됩니다.

CREATE DATABASE IF NOT EXISTS `shop9`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;
USE `shop9`;

SET NAMES utf8mb4;
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
  `tel` VARCHAR(20) NOT NULL,
  `zip` VARCHAR(10) NOT NULL,
  `juso` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `birthday` DATE NOT NULL,
  `gubun` TINYINT NOT NULL DEFAULT 0,
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
  `opt_id` INT UNSIGNED NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_opts_opt_id` (`opt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `product` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu` TINYINT NOT NULL DEFAULT 0,
  `code` VARCHAR(50) NOT NULL,
  `name` VARCHAR(200) NOT NULL,
  `coname` VARCHAR(100) NOT NULL,
  `price` INT UNSIGNED NOT NULL DEFAULT 0,
  `opt1` INT UNSIGNED NOT NULL DEFAULT 0,
  `opt2` INT UNSIGNED NOT NULL DEFAULT 0,
  `contents` TEXT NULL,
  `status` TINYINT NOT NULL DEFAULT 1,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `qa` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `pos1` INT UNSIGNED NULL,
  `pos2` VARCHAR(20) NULL,
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
  `id` BIGINT UNSIGNED NOT NULL,
  `member_id` INT UNSIGNED NOT NULL DEFAULT 0,
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
  `pay_kind` TINYINT NOT NULL DEFAULT 0,
  `card_okno` VARCHAR(30) NOT NULL DEFAULT '',
  `card_halbu` TINYINT NOT NULL DEFAULT 0,
  `card_kind` TINYINT NOT NULL DEFAULT 0,
  `bank_kind` TINYINT NOT NULL DEFAULT 0,
  `bank_sender` VARCHAR(50) NOT NULL DEFAULT '',
  `totalprice` INT UNSIGNED NOT NULL DEFAULT 0,
  `state` TINYINT NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `idx_jumun_member` (`member_id`),
  KEY `idx_jumun_day_state` (`jumunday`, `state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `jumuns` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `jumun_id` BIGINT UNSIGNED NOT NULL,
  `product_id` INT UNSIGNED NOT NULL DEFAULT 0,
  `num` INT UNSIGNED NOT NULL DEFAULT 1,
  `price` INT UNSIGNED NOT NULL DEFAULT 0,
  `prices` INT UNSIGNED NOT NULL DEFAULT 0,
  `discount` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `opts_id1` INT UNSIGNED NULL,
  `opts_id2` INT UNSIGNED NULL,
  PRIMARY KEY (`id`),
  KEY `idx_jumuns_jumun_id` (`jumun_id`),
  KEY `idx_jumuns_product_id` (`product_id`)
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
(1, '용기형태');

INSERT INTO `opts` (`id`, `opt_id`, `name`) VALUES
(1, 1, '튜브형'),
(2, 1, '펌프형'),
(3, 1, '스프레이형'),
(4, 1, '드롭퍼형'),
(5, 1, '캡슐형'),
(6, 1, '자/크림단지형'),
(7, 1, '스틱형'),
(8, 1, '리필 파우치형');

INSERT INTO `product`
(`id`, `menu`, `code`, `name`, `coname`, `price`, `opt1`, `opt2`, `contents`, `status`, `regday`, `icon_new`, `icon_hit`, `icon_sale`, `discount`, `image1`, `image2`, `image3`) VALUES
(1, 1, 'BG190-004', '브링그린 티트리 시카 수딩 크림 80ml', '브링그린', 20500, 1, 0, '민감하고 건조한 피부에 사용하기 좋은 진정 보습 크림입니다. 산뜻한 젤 크림 제형으로 데일리 수분 케어에 적합합니다.', 1, '2026-05-19', 1, 1, 1, 18, '1.png', '1.png', ''),
(2, 5, 'BG190-005', '에스네이처 아쿠아 스쿠알란 수분 클렌징폼 207ml', '에스네이처', 16500, 1, 0, '스쿠알란과 보습 성분을 담은 대용량 클렌징폼입니다. 매일 쓰기 부담 없는 촉촉한 세안감을 제공합니다.', 1, '2026-05-19', 0, 1, 1, 12, '2.png', '2.png', ''),
(3, 1, 'BG190-006', '웰라쥬 리얼 히알루로닉 100 토너 200ml', 'wellage', 13500, 1, 0, '히알루론산 성분으로 세안 후 건조한 피부에 수분감을 더해주는 데일리 토너입니다.', 1, '2026-05-19', 0, 1, 1, 15, '3.jpg', '3.jpg', ''),
(4, 1, 'BG190-007', '에스네이처 아쿠아 오아시스 수분 젤크림 80ml', '에스네이처', 19900, 1, 0, '끈적임을 줄이고 산뜻한 수분감을 주는 젤 타입 크림입니다. 유분 부담 없이 보습을 채우기 좋습니다.', 1, '2026-05-19', 1, 1, 1, 20, '4.png', '4.png', '4_1.png'),
(5, 1, 'BG190-008', '아누아 히알루비타 세럼 50ml', '아누아', 15900, 1, 0, '수분과 생기 케어를 함께 담은 세럼입니다. 토너 다음 단계에서 피부 컨디션을 정돈하기 좋습니다.', 1, '2026-05-19', 1, 0, 1, 10, '5.jpg', '5.jpg', ''),
(6, 1, 'BG190-009', '라운드랩 약콩 판테놀 토너 250ml', '라운드랩', 13900, 1, 0, '약콩과 판테놀 성분으로 세안 후 건조한 피부에 편안한 수분감을 더해주는 기초 토너입니다.', 1, '2026-05-19', 0, 0, 1, 17, '6.jpg', '6.jpg', ''),
(7, 7, 'BG190-010', '그라펜 메가 홀드 슈퍼 스프레이 250ml + 100ml', '그라펜', 19900, 1, 0, '강한 고정력이 필요한 헤어 스타일링용 스프레이 구성입니다. 외출 전 스타일을 오래 유지하기 좋습니다.', 1, '2026-05-19', 1, 1, 1, 22, '7.jpg', '7.jpg', ''),
(8, 1, 'BG190-011', 'DMCK 클린 아크 앰플 30ml 1+1', 'DMCK', 38900, 1, 0, '트러블과 진정 고민 피부를 위한 앰플 1+1 구성입니다. 집중 케어가 필요한 부위에 사용하기 좋습니다.', 1, '2026-05-19', 0, 1, 1, 25, '8.png', '8.png', ''),
(9, 7, 'BG190-013', '에이킨 쿨 바디 앤 베이비 워시 250ml', 'AEKIN', 9900, 1, 0, '가볍고 산뜻한 사용감의 워시입니다. 민감한 피부도 매일 깔끔하게 사용할 수 있도록 구성했습니다.', 1, '2026-05-19', 0, 0, 1, 8, '9.jpg', '9.jpg', ''),
(10, 3, 'BG190-014', '라운드랩 1025 독도 필링젤 대용량 155ml', '라운드랩', 9900, 1, 0, '피부 표면의 묵은 각질을 부드럽게 관리하는 필링젤입니다. 얼굴과 바디의 거친 부위를 케어하기 좋습니다.', 1, '2026-05-19', 0, 0, 1, 13, '10.jpg', '10.jpg', ''),
(11, 1, 'BG190-015', '더랩 바이 블랑두 올리고 히알루론산 토너 300ml', '더랩 바이 블랑두', 15600, 1, 0, '피부 pH 밸런스와 수분 정돈을 위한 토너입니다. 넉넉한 용량으로 아침저녁 데일리 케어에 적합합니다.', 1, '2026-05-19', 1, 0, 1, 16, '11.jpg', '11.jpg', '');

INSERT INTO `qa` (`id`, `pos1`, `pos2`, `title`, `name`, `passwd`, `writeday`, `count`, `contents`) VALUES
(1, 1, 'A', '배송은 얼마나 걸리나요?', '홍길동', '1234', '2026-05-15', 4, '평일 기준 배송 기간이 궁금합니다.'),
(2, 1, 'AA', '답변: 배송 안내', '관리자', '1234', '2026-05-15', 1, '평일 오후 주문은 보통 1~3일 안에 출고됩니다.'),
(3, 3, 'A', '민감한 피부도 사용할 수 있나요?', '포트폴리오고객', '1234', '2026-05-16', 2, '진정 라인 중 민감 피부에 맞는 상품 추천 부탁드립니다.');

INSERT INTO `jumun`
(`id`, `member_id`, `jumunday`, `product_names`, `product_nums`, `o_name`, `o_tel`, `o_email`, `o_zip`, `o_juso`, `r_name`, `r_tel`, `r_email`, `r_zip`, `r_juso`, `memo`, `pay_kind`, `card_okno`, `card_halbu`, `card_kind`, `bank_kind`, `bank_sender`, `totalprice`, `state`) VALUES
(2605190001, 1, '2026-05-19', '브링그린 티트리 시카 수딩 크림 80ml 외', 2, '홍길동', '01012345678', 'hong@example.com', '04524', '서울 중구 세종대로 110', '홍길동', '01012345678', 'hong@example.com', '04524', '서울 중구 세종대로 110', '부재 시 문 앞에 놓아주세요.', 0, '2605190001', 3, 1, 0, '', 35310, 2),
(2605190002, 0, '2026-05-19', '에스네이처 아쿠아 오아시스 수분 젤크림 80ml', 1, '비회원고객', '01022223333', 'guest@example.com', '06164', '서울 강남구 테헤란로 521', '비회원고객', '01022223333', 'guest@example.com', '06164', '서울 강남구 테헤란로 521', '', 1, '', 0, 0, 1, '비회원고객', 18420, 1);

INSERT INTO `jumuns`
(`jumun_id`, `product_id`, `num`, `price`, `prices`, `discount`, `opts_id1`, `opts_id2`) VALUES
(2605190001, 1, 1, 16810, 16810, 18, 6, NULL),
(2605190001, 2, 1, 14520, 14520, 12, 1, NULL),
(2605190001, 0, 1, 2500, 2500, 0, 0, 0),
(2605190002, 4, 1, 15920, 15920, 20, 6, NULL),
(2605190002, 0, 1, 2500, 2500, 0, 0, 0);

INSERT INTO `juso` (`name`, `tel`, `sm`, `birthday`, `juso`) VALUES
('홍길동', '01012345678', 0, '1993-05-12', '서울 중구 세종대로 110'),
('포트폴리오고객', '01098765432', 1, '1998-11-03', '서울 강남구 테헤란로 521');

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
