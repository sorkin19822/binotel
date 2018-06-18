-- phpMyAdmin SQL Dump
-- version 4.7.8
-- https://www.phpmyadmin.net/
--
-- Хост: dobrocli.mysql.ukraine.com.ua
-- Час створення: Трв 15 2018 р., 16:59
-- Версія сервера: 5.7.16-10-log
-- Версія PHP: 7.0.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `dobrocli_apteka`
--

-- --------------------------------------------------------

--
-- Структура таблиці `call`
--

CREATE TABLE `call` (
  `id` int(11) NOT NULL,
  `didNumber` varchar(13) NOT NULL,
  `externalNumber` varchar(13) NOT NULL,
  `internalNumber` int(11) NOT NULL,
  `generalCallID` varchar(13) NOT NULL,
  `callType` tinyint(1) NOT NULL,
  `companyID` int(11) NOT NULL,
  `requestType` varchar(15) NOT NULL,
  `createAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `called`
--

CREATE TABLE `called` (
  `id` int(11) NOT NULL,
  `generalCallID` varchar(13) NOT NULL,
  `billsec` int(11) NOT NULL,
  `disposition` varchar(15) NOT NULL,
  `companyID` int(11) NOT NULL,
  `requestType` varchar(15) NOT NULL,
  `createAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `call`
--
ALTER TABLE `call`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `called`
--
ALTER TABLE `called`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `call`
--
ALTER TABLE `call`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `called`
--
ALTER TABLE `called`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
