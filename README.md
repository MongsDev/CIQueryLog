# CIQueryLog
CodeIgniter Query Log PHP

database.php 설정의 save_queries 값이 true 인 모든 쿼리를 DB에 url과 함께 저장하는 소스코드

서버 부담을 덜기 위해 1 request에 1회 일괄 저장함.

Query_log MySQL DDL

CREATE TABLE `query_log` (
  `no` int(11) NOT NULL AUTO_INCREMENT COMMENT 'No',
  `url` varchar(255) NOT NULL COMMENT 'url',
  `query` text NOT NULL COMMENT 'query',
  `checksum` varchar(255) DEFAULT NULL COMMENT 'md5check',
  `wdate` datetime NOT NULL COMMENT 'wdate',
  PRIMARY KEY (`no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='쿼리로그테이블'



파일로 로깅시 query 함수 사용
/system/database/DB_driver.php
