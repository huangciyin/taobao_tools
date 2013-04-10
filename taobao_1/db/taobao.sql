-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 04 月 10 日 08:50
-- 服务器版本: 5.5.29
-- PHP 版本: 5.3.10-1ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `taobao`
--

-- --------------------------------------------------------

--
-- 表的结构 `aftersale`
--

CREATE TABLE IF NOT EXISTS `aftersale` (
  `ID` int(255) NOT NULL AUTO_INCREMENT,
  `uID` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `mark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `aftersale`
--

INSERT INTO `aftersale` (`ID`, `uID`, `title`, `mark`) VALUES
(1, '2074082786', 'title1', 'mark2222mark3333mark4444'),
(2, '2074082786', 'title2', 'mark333333mark4444444'),
(3, '2074082786', 'title3', ''),
(18, '2074082786', 'title4', '');

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `uID` varchar(255) NOT NULL,
  `tID` varchar(255) NOT NULL,
  `created` varchar(255) DEFAULT NULL,
  `printStatus` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`uID`, `tID`, `created`, `printStatus`) VALUES
('2074082786', '92098581098727', '2013-04-08 09:19:17', ''),
('2074082786', '92132035448727', '2013-04-01 11:34:07', ''),
('2074082786', '92097176108727', '2013-04-01 10:29:20', ''),
('2074082786', '92197561686910', '2013-03-13 17:54:53', ''),
('2074082786', '92094501796610', '2013-03-13 16:29:25', ''),
('2074082786', '92094501766610', '2013-03-13 16:05:10', ''),
('2074082786', '92197561516610', '2013-03-13 16:00:09', ''),
('2074082786', '92197561466610', '2013-03-13 15:31:51', ''),
('2074082786', '92098581998727', '2013-04-09 16:28:02', ''),
('2074082786', '92134752239709', '2013-04-09 16:25:35', '');

-- --------------------------------------------------------

--
-- 表的结构 `refundlist`
--

CREATE TABLE IF NOT EXISTS `refundlist` (
  `refundID` varchar(255) NOT NULL,
  `uID` varchar(255) NOT NULL,
  `created` varchar(255) NOT NULL,
  `mark` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `refundlist`
--

INSERT INTO `refundlist` (`refundID`, `uID`, `created`, `mark`, `status`) VALUES
('40080080138410', '2074082786', '2013-02-28 10:40:00', '备注', '0'),
('40059280050343', '2074082786', '2012-11-01 17:46:42', '备注', '0');

-- --------------------------------------------------------

--
-- 表的结构 `stocklist`
--

CREATE TABLE IF NOT EXISTS `stocklist` (
  `uID` varchar(255) NOT NULL,
  `numID` varchar(255) NOT NULL,
  `outerID` varchar(255) NOT NULL,
  `stock` int(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `stocklist`
--

INSERT INTO `stocklist` (`uID`, `numID`, `outerID`, `stock`) VALUES
('2074082786', '2000032000107', '', 0),
('2074082786', '1500015891283', '20120620001', 0),
('2074082786', '1500015475141', '', 0),
('2074082786', '1500014277061', '7946', 0),
('2074082786', '2000033065162', '123', 0),
('2074082786', '2000032284442', '', 0),
('2074082786', '1500031707727', '', 0),
('2074082786', '1500028648888', '', 0),
('2074082786', '1500028648887', '', 0),
('2074082786', '1500024236007', '', 0),
('2074082786', '1500022074369', '12345', 0),
('2074082786', '1500020436438', '111', 0),
('2074082786', '1500020172515', '', 0),
('2074082786', '1500018698915', 'JZ0153', 0),
('2074082786', '1500015474589', '', 0),
('2074082786', '1500015464869', '', 0),
('2074082786', '1500015215033', 'adidasRT', 0),
('2074082786', '1500027273125', '', 0),
('2074082786', '1500027062565', '1234567890', 0),
('2074082786', '1500008694736', '', 0),
('2074082786', '1500013839457', 'M0001', 0),
('2074082786', '1500015098359', '', 0),
('2074082786', '1500008061942', '123123', 0),
('2074082786', '1500009562822', '', 0),
('2074082786', '1500012027558', '450', 0),
('2074082786', '1500015623484', '', 0),
('2074082786', '1500018337369', 'heizai2012001', 0),
('2074082786', '1500023014007', '', 0),
('2074082786', '1500018148236', '', 0),
('2074082786', '1500024611810', '', 0),
('2074082786', '1500026955044', '1500026955044', 0),
('2074082786', '1500009791573', '12112', 0),
('2074082786', '1500016027314', '', 0),
('2074082786', '1500010676467', '', 0),
('2074082786', '1500022742089', '', 0),
('2074082786', '2000034206527', '500546078', 0),
('2074082786', '1500008781138', '', 0),
('2074082786', '2000032757791', '', 0),
('2074082786', '1500016658991', '', 0),
('2074082786', '1500017861871', '', 0),
('2074082786', '1500008189630', '6941183203809', 0),
('2074082786', '1500021413124', '1414', 0),
('2074082786', '2000032826025', 'FC511200M', 0),
('2074082786', '2000034028086', '', 0),
('2074082786', '1500017778880', '3000', 0),
('2074082786', '1500028640009', '', 0),
('2074082786', '1500018883511', '449', 0),
('2074082786', '1500014376418', '', 0),
('2074082786', '1500014371459', '450', 0),
('2074082786', '1500014238218', '11111', 0);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userID` int(128) NOT NULL AUTO_INCREMENT,
  `uID` varchar(255) NOT NULL,
  `userName` varchar(255) DEFAULT NULL,
  `userSessionkey` varchar(255) DEFAULT NULL,
  `userAddress` varchar(255) DEFAULT NULL,
  `userTel` varchar(255) DEFAULT NULL,
  `userShopname` varchar(255) DEFAULT NULL,
  `customExpress1` varchar(255) DEFAULT NULL,
  `customExpress2` varchar(255) DEFAULT NULL,
  `customExpress3` varchar(255) DEFAULT NULL,
  `customMark1` varchar(255) DEFAULT NULL,
  `customMark2` varchar(255) DEFAULT NULL,
  `customMark3` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`userID`, `uID`, `userName`, `userSessionkey`, `userAddress`, `userTel`, `userShopname`, `customExpress1`, `customExpress2`, `customExpress3`, `customMark1`, `customMark2`, `customMark3`) VALUES
(1, '2074082786', '张三', '6101e295565009351598f0c09712990e734a31a7e73c2922074082786', '上海市上海市上海市', '18017642313', '张三的店', '415px237px413px129px454px197px111px140px110px37px150px100px136px19px62px-213px314px-265px564px-317px', '', '', '自定义一', '自定义二', '自定义三');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
