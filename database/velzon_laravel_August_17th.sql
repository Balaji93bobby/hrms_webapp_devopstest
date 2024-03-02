-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2022 at 11:32 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `velzon_laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank_list`
--

CREATE TABLE `bank_list` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_length` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_length` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_list`
--

INSERT INTO `bank_list` (`id`, `bank_name`, `min_length`, `max_length`, `status`) VALUES
(1, 'ANDHRA BANK', '15', '15', 'A'),
(2, 'ANDHRA PRADESH GRAMEENA VIKAS BANK', '11', '11', 'A'),
(3, 'ALLAHABAD BANK', '11', '11', 'A'),
(4, 'ASSAM GRAMIN VIKASH BANK', '13', '13', 'A'),
(5, 'ARYAVART BANK', '15', '15', 'A'),
(6, 'AU SMALL FINANCE BANK', '16', '16', 'A'),
(7, 'AXIS BANK', '15', '15', 'A'),
(8, 'BANDHAN BANK', '14', '14', 'A'),
(9, 'BANK OF BARODA', '14', '14', 'A'),
(10, 'BANK OF INDIA', '15', '15', 'A'),
(11, 'BANK OF MAHARASHTRA', '11', '11', 'A'),
(12, 'BARODA RAJASTHAN KSHETRIYA GRAMIN BANK', '14', '14', 'A'),
(13, 'BARODA UP GRAMIN BANK', '11', '11', 'A'),
(14, 'BANGIYA GRAMIN VIKASH BANK', '11', '11', 'A'),
(15, 'CENTRAL BANK OF INDIA', '10', '10', 'A'),
(16, 'CANARA BANK', '13', '13', 'A'),
(17, 'CATHOLIC SYRIAN BANK', '18', '18', 'A'),
(18, 'CITI BANK', '10', '10', 'A'),
(19, 'CITY UNION BANK', '15', '15', 'A'),
(20, 'CORPORATION BAN', '	8', '	8', 'A'),
(21, 'DCB BANK', '14', '14', 'A'),
(22, 'DENA BANK', '12', '12', 'A'),
(23, 'DHANALAKSHMI BANK', '16', '16', 'A'),
(24, 'EQUITAS SMALL FINANCE BANK', '12', '12', 'A'),
(25, 'FEDERAL BANK', '14', '14', 'A'),
(26, 'HDFC BANK', '13', '14', 'A'),
(27, 'HSBC BANK', '12', '12', 'A'),
(28, 'ICICI BANK', '12', '12', 'A'),
(29, 'IDFC FIRST BANK', '11', '11', 'A'),
(30, 'INDIAN BANK', '	9', '	9', 'A'),
(31, 'INDIAN OVERSEAS BANK', '15', '15', 'A'),
(32, 'INDUSIND BANK', '13', '13', 'A'),
(33, 'IDBI BANK', '13', '16', 'A'),
(34, 'JAMMU AND KASHMIR BANK', '16', '16', 'A'),
(35, 'KARNATAKA BANK', '16', '16', 'A'),
(36, 'KARUR VYSYA BANK', '16', '16', 'A'),
(37, 'KARNATAKA VIKAS GRAMEENA BANK', '16', '16', 'A'),
(38, 'KERALA GRAMIN BANK', '14', '14', 'A'),
(39, 'KOTAK MAHINDRA BANK', '14', '14', 'A'),
(40, 'LAKSHMI VILAS BANK', '16', '16', 'A'),
(41, 'NAINITAL BANK', '16', '16', 'A'),
(42, 'MADHYANCHAL GRAMIN BANK', '10', '10', 'A'),
(43, 'ORIENTAL BANK OF COMMERCE', '14', '14', 'A'),
(44, 'ODISHA GRAMYA BANK', '11', '11', 'A'),
(45, 'PUNJAB NATIONAL BANK', '16', '16', 'A'),
(46, 'PUNJAB & SIND BANK', '14', '14', 'A'),
(47, 'Prathama UP Gramin Bank', '14', '14', 'A'),
(48, 'RBL BANK', '12', '12', 'A'),
(49, 'RAJASTHAN MARUDHARA GRAMIN BANK', '12', '12', 'A'),
(50, 'STANDARD CHARTERED BANK', '11', '11', 'A'),
(51, 'STATE BANK OF BIKANER AND JAIPUR', '11', '11', 'A'),
(52, 'SAPTAGIRI GRAMIN BANK', '11', '11', 'A'),
(53, 'SARVA HARYANA GRAMIN BANK', '14', '14', 'A'),
(54, 'STATE BANK OF INDIA', '11', '11', 'A'),
(55, 'STATE BANK OF HYDERABAD', '11', '11', 'A'),
(56, 'STATE BANK OF TRAVANCORE', '11', '11', 'A'),
(57, 'SOUTH INDIAN BANK', '16', '16', 'A'),
(58, 'SYNDICATE BANK', '14', '14', 'A'),
(59, 'TAMILNADU MERCANTILE BANK', '6', '15', 'A'),
(60, 'UNION BANK OF INDIA', '15', '15', 'A'),
(61, 'UNITED BANK OF INDIA', '13', '13', 'A'),
(62, 'UCO BANK', '14', '14', 'A'),
(63, 'UTTAR BIHAR GRAMIN BANK', '16', '16', 'A'),
(64, 'UTKAL GRAMEEN BANK', '12', '12', 'A'),
(65, 'VIJAYA BANK(Now BoB)', '15', '15', 'A'),
(66, 'YES BANK', '15', '15', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `countries_list`
--

CREATE TABLE `countries_list` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dialing_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries_list`
--

INSERT INTO `countries_list` (`id`, `country_name`, `country_code`, `dialing_code`, `currency_name`, `currency_code`, `timezone`, `status`) VALUES
(1, 'Afghanistan', 'AF', '+93', 'Afghan afghani ', 'AFN', 'UTC+04:30 ', 'A'),
(2, 'Aland Islands', 'AX', '+358', 'Euro ', 'EUR', '', 'A'),
(3, 'Albania', 'AL', '+355', 'Albanian lek ', 'ALL', 'UTC+01:00 ', 'A'),
(4, 'Algeria', 'DZ', '+213', 'Algerian dinar ', 'DZD', 'UTC ', 'A'),
(5, 'American Samoa', 'AS', '+1', '', '', 'UTC-11:00 ', 'A'),
(6, 'Andorra', 'AD', '+376', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(7, 'Angola', 'AO', '+244', 'Angolan kwanza ', 'AOA', 'UTC+01:00 ', 'A'),
(8, 'Anguilla', 'AI', '+1', 'East Caribbean dollar ', 'XCD', 'UTC-04:00 ', 'A'),
(9, 'Antarctica', 'AQ', '+672', '', '', '', 'A'),
(10, 'Antigua and Barbuda', 'AG', '+1', 'East Caribbean dollar ', 'XCD', 'UTC-04:00 ', 'A'),
(11, 'Argentina', 'AR', '+54', 'Argentine peso ', 'ARS', 'UTC-03:00 ', 'A'),
(12, 'Armenia', 'AM', '+374', 'Armenian dram ', 'AMD', 'UTC+04:00 ', 'A'),
(13, 'Aruba', 'AW', '+297', 'Aruban florin ', 'AWG', 'UTC-04:00 ', 'A'),
(14, 'Australia', 'AU', '+61', 'Australian dollar ', 'AUD', 'UTC+07:00 - UTC+10:00 ', 'A'),
(15, 'Austria', 'AT', '+43', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(16, 'Azerbaijan', 'AZ', '+994', 'Azerbaijani manat ', 'AZN', 'UTC+04:00 ', 'A'),
(17, 'Bahamas', 'BS', '+1', 'Bahamian dollar ', 'BSD', 'UTC-05:00 ', 'A'),
(18, 'Bahrain', 'BH', '+973', 'Bahraini dinar ', 'BHD', 'UTC+03:00 ', 'A'),
(19, 'Bangladesh', 'BD', '+880', 'Bangladeshi taka ', 'BDT', 'UTC+06:00 ', 'A'),
(20, 'Barbados', 'BB', '+1', 'Barbadian dollar ', 'BBD', 'UTC-04:00 ', 'A'),
(21, 'Belarus', 'BY', '+375', 'Belarusian ruble ', 'BYR', 'UTC+03:00 ', 'A'),
(22, 'Belgium', 'BE', '+32', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(23, 'Belize', 'BZ', '+501', 'Belize dollar ', 'BZD', 'UTC-06:00 ', 'A'),
(24, 'Benin', 'BJ', '+229', 'West African CFA franc ', 'XOF', 'UTC+01:00 ', 'A'),
(25, 'Bermuda', 'BM', '+1', 'Bermudian dollar ', 'BMD', 'UTC-04:00 ', 'A'),
(26, 'Bhutan', 'BT', '+975', 'Bhutanese ngultrum ', 'BTN', 'UTC+05:30 ', 'A'),
(27, 'Bolivia', 'BO', '+591', 'Bolivian boliviano ', 'BOB', 'UTC-04:00 ', 'A'),
(28, 'Caribbean Netherlands', 'BQ', '+599', 'United States dollar ', 'USD', '', 'A'),
(29, 'Bosnia and Herzegovina', 'BA', '+387', 'Bosnia and Herzegovina convertible mark ', 'BAM', 'UTC+01:00 ', 'A'),
(30, 'Botswana', 'BW', '+267', 'Botswana pula ', 'BWP', 'UTC+02:00 ', 'A'),
(31, 'Bouvet Island', 'BV', '+55', '', '', '', 'A'),
(32, 'Brazil', 'BR', '+55', 'Brazilian real ', 'BRL', 'UTC-05:00', 'A'),
(33, 'British Indian Ocean Territory', 'IO', '+246', 'United States dollar ', 'USD', 'UTC+06 ', 'A'),
(34, 'Brunei', 'BN', '+673', 'Brunei dollar ', 'BND', 'UTC+08:00 ', 'A'),
(35, 'Bulgaria', 'BG', '+359', 'Bulgarian lev ', 'BGN', 'UTC+02:00 ', 'A'),
(36, 'Burkina Faso', 'BF', '+226', 'West African CFA franc ', 'XOF', 'UTC ', 'A'),
(37, 'Burundi', 'BI', '+257', 'Burundian franc ', 'BIF', 'UTC+02:00 ', 'A'),
(38, 'Cambodia', 'KH', '+855', 'Cambodian riel ', 'KHR', 'UTC+07:00 ', 'A'),
(39, 'Cameroon', 'CM', '+237', 'Central African CFA franc ', 'XAF', 'UTC+01:00 ', 'A'),
(40, 'Canada', 'CA', '+1', 'Canadian dollar ', 'CAD', 'UTC-08:00', 'A'),
(41, 'CapeVerde', 'CV', '+238', 'Cape Verdean escudo ', 'CVE', 'UTC-01:00 ', 'A'),
(42, 'Cayman Islands', 'KY', '+1', 'Cayman Islands dollar ', 'KYD', 'UTC-05:00 ', 'A'),
(43, 'Central African Republic', 'CF', '+236', 'Central African CFA franc ', 'XAF', 'UTC+01:00 ', 'A'),
(44, 'Chad', 'TD', '+235', 'Central African CFA franc ', 'XAF', 'UTC+01:00 ', 'A'),
(45, 'Chile', 'CL', '+56', 'Chilean peso ', 'CLP', 'UTC-04:00 ', 'A'),
(46, 'China', 'CN', '+86', 'Chinese yuan ', 'CNY', 'UTC+08:00 ', 'A'),
(47, 'ChristmasIsland', 'CX', '+61', 'Australian dollar ', 'AUD', 'UTC+07 ', 'A'),
(48, 'Cocos(Keeling)Islands', 'CC', '+891', 'Australian dollar ', 'AUD', 'UTC+06:30 ', 'A'),
(49, 'Colombia', 'CO', '+57', 'Colombian peso ', 'COP', 'UTC-05:00 ', 'A'),
(50, 'Comoros', 'KM', '+269', 'Comorian franc ', 'KMF', 'UTC+03:00 ', 'A'),
(51, 'Republic of the Congo', 'CG', '+242', 'Central African CFA franc ', 'XAF', 'UTC+01:00 ', 'A'),
(52, 'Democratic Republic of the Congo', 'CD', '+243', 'Congolese franc ', 'CDF', 'UTC+01:00', 'A'),
(53, 'Cook Islands', 'CK', '+682', 'New Zealand dollar ', 'NZD', 'UTC-10:00 ', 'A'),
(54, 'CostaRica', 'CR', '+506', 'Costa Rican colon ', 'CRC', 'UTC-06:00 ', 'A'),
(55, 'Ivory Coast', 'CI', '+225', 'West African CFA franc ', 'XOF', '', 'A'),
(56, 'Croatia', 'HR', '+385', 'Croatian kuna ', 'HRK', 'UTC+01:00 ', 'A'),
(57, 'Cuba', 'CU', '+53', 'Cuban convertible peso ', 'CUC', 'UTC-03:00 ', 'A'),
(58, 'Curacao', 'CW', '+599', 'Netherlands Antillean guilder ', 'ANG', '', 'A'),
(59, 'Cyprus', 'CY', '+357', 'Euro ', 'EUR', 'UTC+02:00 ', 'A'),
(60, 'Czech Republic', 'CZ', '+420', 'Czech koruna ', 'CZK', 'UTC+01:00 ', 'A'),
(61, 'Denmark', 'DK', '+45', 'Danish krone ', 'DKK', 'UTC+01:00 ', 'A'),
(62, 'Djibouti', 'DJ', '+253', 'Djiboutian franc ', 'DJF', 'UTC+03:00 ', 'A'),
(63, 'Dominica', 'DM', '+1', 'East Caribbean dollar ', 'XCD', 'UTC-04:00 ', 'A'),
(64, 'Dominican Republic', 'DO', '+1', 'Dominican peso ', 'DOP', 'UTC-04:00 ', 'A'),
(65, 'East Timor', 'TL', '+670', 'United States dollar ', 'USD', 'UTC+09 ', 'A'),
(66, 'Ecuador', 'EC', '+593', 'United States dollar ', 'USD', 'UTC-05:00 ', 'A'),
(67, 'Egypt', 'EG', '+20', 'Egyptian pound ', 'EGP', 'UTC+02:00 ', 'A'),
(68, 'El Salvador', 'SV', '+503', 'Salvadoran colon ', 'SVC', 'UTC-06:00 ', 'A'),
(69, 'Equatorial Guinea', 'GQ', '+240', 'Central African CFA franc ', 'XAF', 'UTC+01:00 ', 'A'),
(70, 'Eritrea', 'ER', '+291', 'Eritrean nakfa ', 'ERN', 'UTC+03:00 ', 'A'),
(71, 'Estonia', 'EE', '+372', 'Euro ', 'EUR', 'UTC+03:00 ', 'A'),
(72, 'Ethiopia', 'ET', '+251', 'Ethiopian birr ', 'ETB', 'UTC+03:00 ', 'A'),
(73, 'Falkland Islands (Islas Malvinas)', 'FK', '+500', 'Falkland Islands pound ', 'FKP', 'UTC-04:00 ', 'A'),
(74, 'Faroe Islands', 'FO', '+298', 'Danish krone ', 'DKK', 'UTC ', 'A'),
(75, 'Fiji', 'FJ', '+679', 'Fijian dollar ', 'FJD', 'UTC+12:00 ', 'A'),
(76, 'Finland', 'FI', '+358', 'Euro ', 'EUR', 'UTC+02:00 ', 'A'),
(77, 'France', 'FR', '+33', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(78, 'French Guiana', 'GF', '+594', '', '', 'UTC-01:00 ', 'A'),
(79, 'French Polynesia', 'PF', '+689', 'CFP franc ', 'XPF', 'UTC-10:00 ', 'A'),
(80, 'French Southern and Antarctic Lands', 'TF', '+262', 'Euro ', 'EUR', '', 'A'),
(81, 'Gabon', 'GA', '+241', 'Central African CFA franc ', 'XAF', 'UTC+01:00 ', 'A'),
(82, 'Gambia', 'GM', '+220', 'Gambian dalasi ', 'GMD', 'UTC ', 'A'),
(83, 'Georgia', 'GE', '+995', 'Georgian lari ', 'GEL', 'UTC+04:00 ', 'A'),
(84, 'Germany', 'DE', '+49', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(85, 'Ghana', 'GH', '+233', 'Ghanaian cedi ', 'GHS', 'UTC ', 'A'),
(86, 'Gibraltar', 'GI', '+350', 'Gibraltar pound ', 'GIP', 'UTC+01:00 ', 'A'),
(87, 'Greece', 'GR', '+30', 'Euro ', 'EUR', 'UTC+02:00 ', 'A'),
(88, 'Greenland', 'GL', '+299', 'Danish krone ', 'DKK', 'UTC-03:00 ', 'A'),
(89, 'Grenada', 'GD', '+1', 'East Caribbean dollar ', 'XCD', 'UTC-04:00 ', 'A'),
(90, 'Guadeloupe', 'GP', '+590', '', '', 'UTC-04:00 ', 'A'),
(91, 'Guam', 'GU', '+1', 'United States dollar ', 'USD', 'UTC+10:00 ', 'A'),
(92, 'Guatemala', 'GT', '+502', 'Guatemalan quetzal ', 'GTQ', 'UTC-06:00 ', 'A'),
(93, 'Guernsey', 'GG', '+44', 'Guernsey pound', '?GGP', 'UTC ', 'A'),
(94, 'Guinea', 'GN', '+224', 'Guinean franc ', 'GNF', 'UTC ', 'A'),
(95, 'Guinea-Bissau', 'GW', '+245', 'West African CFA franc ', 'XOF', 'UTC ', 'A'),
(96, 'Guyana', 'GY', '+592', 'Guyanese dollar ', 'GYD', 'UTC-03:00 ', 'A'),
(97, 'Haiti', 'HT', '+509', 'Haitian gourde ', 'HTG', 'UTC-05:00 ', 'A'),
(98, 'Heard Island and McDonald Islands', 'HM', '+0', '', '', 'UTC+05 ', 'A'),
(99, 'Honduras', 'HN', '+504', 'Honduran lempira ', 'HNL', 'UTC-06:00 ', 'A'),
(100, 'HongKong', 'HK', '+852', 'Hong Kong dollar ', 'HKD', 'UTC+08:00 ', 'A'),
(101, 'Hungary', 'HU', '+36', 'Hungarian forint ', 'HUF', 'UTC+01:00 ', 'A'),
(102, 'Iceland', 'IS', '+354', 'Icelandic krona ', 'ISK', 'UTC ', 'A'),
(103, 'India', 'IN', '+91', 'Indian rupee ', 'INR', 'UTC+05:30 ', 'A'),
(104, 'Indonesia', 'ID', '+62', 'Indonesian rupiah ', 'IDR', 'UTC+07:00', 'A'),
(105, 'Iran', 'IR', '+98', 'Iranian rial ', 'IRR', 'UTC+03:30 ', 'A'),
(106, 'Iraq', 'IQ', '+964', 'Iraqi dinar ', 'IQD', 'UTC+03:00 ', 'A'),
(107, 'Ireland', 'IE', '+353', 'Euro ', 'EUR', 'UTC ', 'A'),
(108, 'Isle of Man', 'IM', '+44', 'Manx pound', 'IMP', 'UTC ', 'A'),
(109, 'Israel', 'IL', '+972', 'Israeli new shekel ', 'ILS', 'UTC+02:00 ', 'A'),
(110, 'Italy', 'IT', '+39', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(111, 'Jamaica', 'JM', '+1', 'Jamaican dollar', 'JMD', 'UTC-05:00 ', 'A'),
(112, 'Japan', 'JP', '+81', 'Japanese yen ', 'JPY', 'UTC+09:00 ', 'A'),
(113, 'Jersey', 'JE', '+44', 'Jersey  pound ', '?JEP', 'UTC ', 'A'),
(114, 'Jordan', 'JO', '+962', 'Jordanian dinar ', 'JOD', 'UTC+02:00 ', 'A'),
(115, 'Kazakhstan', 'KZ', '+7', 'Kazakhstani tenge ', 'KZT', 'UTC+06:00 ', 'A'),
(116, 'Kenya', 'KE', '+254', 'Kenyan shilling ', 'KES', 'UTC+03:00 ', 'A'),
(117, 'Kiribati', 'KI', '+686', 'Australian dollar ', 'AUD', 'UTC+12:00 ', 'A'),
(118, 'Kuwait', 'KW', '+965', 'Kuwaiti dinar ', 'KWD', 'UTC+03:00 ', 'A'),
(119, 'Kyrgyzstan', 'KG', '+996', 'Kyrgyzstani som ', 'KGS', 'UTC+06:00 ', 'A'),
(120, 'Laos', 'LA', '+856', 'Lao kip ', 'LAK', 'UTC+07:00 ', 'A'),
(121, 'Latvia', 'LV', '+371', 'Latvian lats ', 'LVL', 'UTC+03:00 ', 'A'),
(122, 'Lebanon', 'LB', '+961', 'Lebanese pound ', 'LBP', 'UTC+02:00 ', 'A'),
(123, 'Lesotho', 'LS', '+266', 'Lesotho loti ', 'LSL', 'UTC+02:00 ', 'A'),
(124, 'Liberia', 'LR', '+231', 'Liberian dollar ', 'LRD', 'UTC ', 'A'),
(125, 'Libya', 'LY', '+218', 'Libyan dinar ', 'LYD', 'UTC+02:00 ', 'A'),
(126, 'Liechtenstein', 'LI', '+423', 'Swiss franc ', 'CHF', 'UTC+01:00 ', 'A'),
(127, 'Lithuania', 'LT', '+370', 'Lithuanian litas ', 'LTL', 'UTC+02:00 ', 'A'),
(128, 'Luxembourg', 'LU', '+352', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(129, 'Macau', 'MO', '+853', 'Macanese pataca ', 'MOP', 'UTC+08:00 ', 'A'),
(130, 'Macedonia', 'MK', '+389', 'Macedonian denar ', 'MKD', 'UTC+01:00 ', 'A'),
(131, 'Madagascar', 'MG', '+261', 'Malagasy ariary ', 'MGA', 'UTC+03:00 ', 'A'),
(132, 'Malawi', 'MW', '+265', 'Malawian kwacha ', 'MWK', 'UTC+02:00 ', 'A'),
(133, 'Malaysia', 'MY', '+60', 'Malaysian ringgit ', 'MYR', 'UTC+08:00 ', 'A'),
(134, 'Maldives', 'MV', '+960', 'Maldivian rufiyaa ', 'MVR', 'UTC+05:00 ', 'A'),
(135, 'Mali', 'ML', '+223', 'West African CFA franc ', 'XOF', 'UTC ', 'A'),
(136, 'Malta', 'MT', '+356', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(137, 'Marshall Islands', 'MH', '+692', 'United States dollar ', 'USD', 'UTC+10:00 ', 'A'),
(138, 'Martinique', 'MQ', '+596', '', '', 'UTC-04:00 ', 'A'),
(139, 'Mauritania', 'MR', '+222', 'Mauritanian ouguiya ', 'MRO', 'UTC ', 'A'),
(140, 'Mauritius', 'MU', '+230', 'Mauritian rupee ', 'MUR', 'UTC+04:00 ', 'A'),
(141, 'Mayotte', 'YT', '+262', 'Euro ', 'EUR', 'UTC+03:00 ', 'A'),
(142, 'Mexico', 'MX', '+52', 'Mexican peso ', 'MXN', 'UTC-06:00 ', 'A'),
(143, 'Federated States of Micronesia', 'FM', '+691', 'Micronesian dollar ', 'None', 'UTC+10:00 ', 'A'),
(144, 'Republic of Moldova', 'MD', '+373', 'Moldovan leu ', 'MDL', 'UTC+03:00 ', 'A'),
(145, 'Monaco', 'MC', '+377', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(146, 'Mongolia', 'MN', '+976', 'Mongolian togrog ', 'MNT', 'UTC+08:00 ', 'A'),
(147, 'Montenegro', 'ME', '+382', 'Euro ', 'EUR', 'UTC+01 ', 'A'),
(148, 'Montserrat', 'MS', '+1', 'East Caribbean dollar ', 'XCD', 'UTC-04:00 ', 'A'),
(149, 'Morocco', 'MA', '+212', 'Moroccan dirham ', 'MAD', 'UTC ', 'A'),
(150, 'Mozambique', 'MZ', '+258', 'Mozambican metical ', 'MZN', 'UTC+02:00 ', 'A'),
(151, 'Myanmar', 'MM', '+95', 'Myanma kyat ', 'MMK', 'UTC+06:30 ', 'A'),
(152, 'Namibia', 'NA', '+264', 'Namibian dollar ', 'NAD', 'UTC+02:00 ', 'A'),
(153, 'Nauru', 'NR', '+674', 'Australian dollar ', 'AUD', 'UTC+12:00 ', 'A'),
(154, 'Nepal', 'NP', '+977', 'Nepalese rupee ', 'NPR', 'UTC+05:30 ', 'A'),
(155, 'Netherlands', 'NL', '+31', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(156, 'New Caledonia', 'NC', '+687', 'CFP franc ', 'XPF', 'UTC+11:00 ', 'A'),
(157, 'New Zealand', 'NZ', '+64', 'New Zealand dollar ', 'NZD', 'UTC+12:00 ', 'A'),
(158, 'Nicaragua', 'NI', '+505', 'Nicaraguan crodoba ', 'NIO', 'UTC-06:00 ', 'A'),
(159, 'Niger', 'NE', '+227', 'West African CFA franc ', 'XOF', 'UTC+01:00 ', 'A'),
(160, 'Nigeria', 'NG', '+234', 'Nigerian naira ', 'NGN', 'UTC+01:00 ', 'A'),
(161, 'Niue', 'NU', '+683', 'New Zealand dollar ', 'NZD', 'UTC-11:00 ', 'A'),
(162, 'Norfolk Island', 'NF', '+672', 'Australian dollar ', 'AUD', 'UTC+11:30 ', 'A'),
(163, 'North Korea', 'KP', '+850', 'North Korean won ', 'KPW', 'UTC+09:00 ', 'A'),
(164, 'Northern Mariana Islands', 'MP', '+1', 'United States dollar ', 'USD', 'UTC+10:00 ', 'A'),
(165, 'Norway', 'NO', '+47', 'Norwegian krone ', 'NOK', 'UTC+01:00 ', 'A'),
(166, 'Oman', 'OM', '+968', 'Omani rial ', 'OMR', 'UTC+04:00 ', 'A'),
(167, 'Pakistan', 'PK', '+92', 'Pakistani rupee ', 'PKR', 'UTC+05:00 ', 'A'),
(168, 'Palau', 'PW', '+680', 'Palauan dollar ', 'None', 'UTC+09:00 ', 'A'),
(169, 'PalestinianTerritory,Occupied', 'PS', '+970', '', '', 'UTC+02:00 ', 'A'),
(170, 'Panama', 'PA', '+507', 'Panamanian balboa ', 'PAB', 'UTC-05:00 ', 'A'),
(171, 'Papua New Guinea', 'PG', '+675', 'Papua New Guinean kina ', 'PGK', 'UTC+10:00 ', 'A'),
(172, 'Paraguay', 'PY', '+595', 'Paraguayan guarani', 'PYG', 'UTC-04:00 ', 'A'),
(173, 'Peru', 'PE', '+51', 'Peruvian nuevo sol ', 'PEN', 'UTC-05:00 ', 'A'),
(174, 'Philippines', 'PH', '+63', 'Philippine peso ', 'PHP', 'UTC+08:00 ', 'A'),
(175, 'Pitcairn', 'PN', '+872', 'New Zealand dollar ', 'NZD', 'UTC-08 ', 'A'),
(176, 'Poland', 'PL', '+48', 'Polish zloty ', 'PLN', 'UTC+01:00 ', 'A'),
(177, 'Portugal', 'PT', '+351', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(178, 'Puerto Rico', 'PR', '+1', 'United States dollar ', 'USD', 'UTC-04:00 ', 'A'),
(179, 'Qatar', 'QA', '+974', 'Qatari riyal ', 'QAR', 'UTC+03:00 ', 'A'),
(180, 'Reunion', 'RE', '+262', '', '', 'UTC+04:00 ', 'A'),
(181, 'Romania', 'RO', '+40', 'Romanian leu ', 'RON', 'UTC+02:00 ', 'A'),
(182, 'Russia', 'RU', '+7', 'Russian ruble ', 'RUB', 'UTC+03:00 ', 'A'),
(183, 'Rwanda', 'RW', '+250', 'Rwandan franc ', 'RWF', 'UTC+02:00 ', 'A'),
(184, 'Saint Barthelemy', 'BL', '+590', 'Euro ', 'EUR', 'UTC-04 ', 'A'),
(185, 'Saint Helena', 'SH', '+290', 'Saint Helena pound ', 'SHP', 'UTC ', 'A'),
(186, 'Saint Kitts and Nevis', 'KN', '+1', 'East Caribbean dollar ', 'XCD', 'UTC-04:00 ', 'A'),
(187, 'Saint Lucia', 'LC', '+1', 'East Caribbean dollar ', 'XCD', 'UTC-04:00 ', 'A'),
(188, 'Saint Martin(Frenchpart)', 'MF', '+590', 'Euro ', 'EUR', 'UTC-04 ', 'A'),
(189, 'Saint Pierreand Miquelon', 'PM', '+508', 'Euro ', 'EUR', 'UTC-03 ', 'A'),
(190, 'Saint Vincent and the Grenadines', 'VC', '+1', 'East Caribbean dollar ', 'XCD', 'UTC-04 ', 'A'),
(191, 'Samoa', 'WS', '+685', 'Samoan tala ', 'WST', 'UTC-11:00 ', 'A'),
(192, 'San Marino', 'SM', '+378', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(193, 'Sao Tome and Principe', 'ST', '+239', 'Sao Tome and Principe dobra ', 'STD', 'UTC ', 'A'),
(194, 'Saudi Arabia', 'SA', '+966', 'Saudi riyal ', 'SAR', 'UTC+03:00 ', 'A'),
(195, 'Senegal', 'SN', '+221', 'West African CFA franc ', 'XOF', 'UTC ', 'A'),
(196, 'Serbia', 'RS', '+381', 'Serbian dinar ', 'RSD', 'UTC+01:00 ', 'A'),
(197, 'Seychelles', 'SC', '+248', 'Seychellois rupee ', 'SCR', 'UTC+04:00 ', 'A'),
(198, 'Sierra Leone', 'SL', '+232', 'Sierra Leonean leone ', 'SLL', 'UTC ', 'A'),
(199, 'Singapore', 'SG', '+65', 'Brunei dollar ', 'BND', 'UTC+08:00 ', 'A'),
(200, 'Sint Maarten', 'SX', '+1', 'Netherlands Antillean guilder ', 'ANG', '', 'A'),
(201, 'Slovakia', 'SK', '+421', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(202, 'Slovenia', 'SI', '+386', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(203, 'Solomon Islands', 'SB', '+677', 'Solomon Islands dollar ', 'SBD', 'UTC+11:00 ', 'A'),
(204, 'Somalia', 'SO', '+252', 'Somali shilling ', 'SOS', 'UTC+03:00 ', 'A'),
(205, 'South Africa', 'ZA', '+27', 'South African rand ', 'ZAR', 'UTC+02:00 ', 'A'),
(206, 'South Georgia and the South Sandwich Islands', 'GS', '+500', 'British pound ', 'GBP', 'UTC-02 ', 'A'),
(207, 'South Korea', 'KR', '+82', 'South Korean won ', 'KRW', 'UTC+09:00 ', 'A'),
(208, 'Spain', 'ES', '+34', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(209, 'SriLanka', 'LK', '+94', 'Sri Lankan rupee ', 'LKR', 'UTC+05:30 ', 'A'),
(210, 'Sudan', 'SD', '+249', 'Sudanese pound ', 'SDG', 'UTC+02:00 ', 'A'),
(211, 'Suriname', 'SR', '+597', 'Surinamese dollar ', 'SRD', 'UTC-03:30 ', 'A'),
(212, 'Svalbard and Jan Mayen', 'SJ', '+47', '', '', '', 'A'),
(213, 'Swaziland', 'SZ', '+268', 'Swazi lilangeni ', 'SZL', 'UTC+02:00 ', 'A'),
(214, 'Sweden', 'SE', '+46', 'Swedish krona ', 'SEK', 'UTC+01:00 ', 'A'),
(215, 'Switzerland', 'CH', '+41', 'Swiss franc ', 'CHF', 'UTC+01:00 ', 'A'),
(216, 'Syrian Arab Republic', 'SY', '+963', 'Syrian pound ', 'SYP', 'UTC+02:00 ', 'A'),
(217, 'Taiwan', 'TW', '+886', 'New Taiwan dollar ', 'TWD', 'UTC+08:00 ', 'A'),
(218, 'Tajikistan', 'TJ', '+992', 'Tajikistani somoni ', 'TJS', 'UTC+06:00 ', 'A'),
(219, 'Tanzania', 'TZ', '+255', 'Tanzanian shilling ', 'TZS', 'UTC+03:00 ', 'A'),
(220, 'Thailand', 'TH', '+66', 'Thai baht ', 'THB', 'UTC+07:00 ', 'A'),
(221, 'Togo', 'TG', '+228', 'West African CFA franc ', 'XOF', 'UTC ', 'A'),
(222, 'Tokelau', 'TK', '+690', 'New Zealand dollar ', 'NZD', 'UTC-10 ', 'A'),
(223, 'Tonga', 'TO', '+676', 'Tongan paoanga ', 'TOP', 'UTC+13:00 ', 'A'),
(224, 'Trinidad and Tobago', 'TT', '+1', 'Trinidad and Tobago dollar ', 'TTD', 'UTC-04:00 ', 'A'),
(225, 'Tunisia', 'TN', '+216', 'Tunisian dinar ', 'TND', 'UTC+01:00 ', 'A'),
(226, 'Turkey', 'TR', '+90', 'Turkish lira ', 'TRY', 'UTC+02:00 ', 'A'),
(227, 'Turkmenistan', 'TM', '+993', 'Turkmenistani manat ', 'TMT', 'UTC+05:00 ', 'A'),
(228, 'Turksand Caicos Islands', 'TC', '+1', 'United States dollar ', 'USD', 'UTC-05:00 ', 'A'),
(229, 'Tuvalu', 'TV', '+688', 'Australian dollar ', 'AUD', 'UTC+12:00 ', 'A'),
(230, 'Uganda', 'UG', '+256', 'Ugandan shilling ', 'UGX', 'UTC+03:00 ', 'A'),
(231, 'Ukraine', 'UA', '+380', 'Ukrainian hryvnia ', 'UAH', 'UTC+03:00 ', 'A'),
(232, 'United Arab Emirates', 'AE', '+971', 'United Arab Emirates dirham ', 'AED', 'UTC+04:00 ', 'A'),
(233, 'United Kingdom', 'GB', '+44', 'Pound sterling', 'GBP', '', 'A'),
(234, 'United States', 'US', '+1', 'United States dollar ', 'USD', 'UTC-11:00', 'A'),
(235, 'United States Minor Outlying Islands', 'UM', '+1', 'United States dollar ', 'USD', '', 'A'),
(236, 'Uruguay', 'UY', '+598', 'Uruguayan peso ', 'UYU', 'UTC-03:00 ', 'A'),
(237, 'Uzbekistan', 'UZ', '+998', 'Uzbekistani som ', 'UZS', 'UTC+06:00 ', 'A'),
(238, 'Vanuatu', 'VU', '+678', 'Vanuatu vatu ', 'VUV', 'UTC+11:00 ', 'A'),
(239, 'VaticanCity', 'VA', '+379', 'Euro ', 'EUR', 'UTC+01 ', 'A'),
(240, 'Venezuela', 'VE', '+58', 'Venezuelan bolivar', 'VEF', 'UTC-04:00 ', 'A'),
(241, 'Vietnam', 'VN', '+84', 'Vietnamese dong', 'VND', 'UTC+07:00 ', 'A'),
(242, 'British Virgin Islands', 'VG', '+1', 'British Virgin Islands dollar ', 'None', 'UTC-04 ', 'A'),
(243, 'United States Virgin Islands', 'VI', '+1', 'United States dollar ', 'USD', 'UTC-04 ', 'A'),
(244, 'WallisandFutuna', 'WF', '+681', 'CFP franc ', 'XPF', 'UTC+12:00 ', 'A'),
(245, 'WesternSahara', 'EH', '+212', 'Moroccan dirham ', 'MAD', '', 'A'),
(246, 'Yemen', 'YE', '+967', 'Yemeni rial ', 'YER', 'UTC+03:00 ', 'A'),
(247, 'Zambia', 'ZM', '+260', 'Zambian kwacha ', 'ZMK', 'UTC+02:00 ', 'A'),
(248, 'Zimbabwe', 'ZW', '+263', 'Botswana pula ', 'BWP', 'UTC+02:00 ', 'A'),
(249, 'Afghanistan', 'AF', '+93', 'Afghan afghani ', 'AFN', 'UTC+04:30 ', 'A'),
(250, 'Aland Islands', 'AX', '+358', 'Euro ', 'EUR', '', 'A'),
(251, 'Albania', 'AL', '+355', 'Albanian lek ', 'ALL', 'UTC+01:00 ', 'A'),
(252, 'Algeria', 'DZ', '+213', 'Algerian dinar ', 'DZD', 'UTC ', 'A'),
(253, 'American Samoa', 'AS', '+1', '', '', 'UTC-11:00 ', 'A'),
(254, 'Andorra', 'AD', '+376', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(255, 'Angola', 'AO', '+244', 'Angolan kwanza ', 'AOA', 'UTC+01:00 ', 'A'),
(256, 'Anguilla', 'AI', '+1', 'East Caribbean dollar ', 'XCD', 'UTC-04:00 ', 'A'),
(257, 'Antarctica', 'AQ', '+672', '', '', '', 'A'),
(258, 'Antigua and Barbuda', 'AG', '+1', 'East Caribbean dollar ', 'XCD', 'UTC-04:00 ', 'A'),
(259, 'Argentina', 'AR', '+54', 'Argentine peso ', 'ARS', 'UTC-03:00 ', 'A'),
(260, 'Armenia', 'AM', '+374', 'Armenian dram ', 'AMD', 'UTC+04:00 ', 'A'),
(261, 'Aruba', 'AW', '+297', 'Aruban florin ', 'AWG', 'UTC-04:00 ', 'A'),
(262, 'Australia', 'AU', '+61', 'Australian dollar ', 'AUD', 'UTC+07:00 - UTC+10:00 ', 'A'),
(263, 'Austria', 'AT', '+43', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(264, 'Azerbaijan', 'AZ', '+994', 'Azerbaijani manat ', 'AZN', 'UTC+04:00 ', 'A'),
(265, 'Bahamas', 'BS', '+1', 'Bahamian dollar ', 'BSD', 'UTC-05:00 ', 'A'),
(266, 'Bahrain', 'BH', '+973', 'Bahraini dinar ', 'BHD', 'UTC+03:00 ', 'A'),
(267, 'Bangladesh', 'BD', '+880', 'Bangladeshi taka ', 'BDT', 'UTC+06:00 ', 'A'),
(268, 'Barbados', 'BB', '+1', 'Barbadian dollar ', 'BBD', 'UTC-04:00 ', 'A'),
(269, 'Belarus', 'BY', '+375', 'Belarusian ruble ', 'BYR', 'UTC+03:00 ', 'A'),
(270, 'Belgium', 'BE', '+32', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(271, 'Belize', 'BZ', '+501', 'Belize dollar ', 'BZD', 'UTC-06:00 ', 'A'),
(272, 'Benin', 'BJ', '+229', 'West African CFA franc ', 'XOF', 'UTC+01:00 ', 'A'),
(273, 'Bermuda', 'BM', '+1', 'Bermudian dollar ', 'BMD', 'UTC-04:00 ', 'A'),
(274, 'Bhutan', 'BT', '+975', 'Bhutanese ngultrum ', 'BTN', 'UTC+05:30 ', 'A'),
(275, 'Bolivia', 'BO', '+591', 'Bolivian boliviano ', 'BOB', 'UTC-04:00 ', 'A'),
(276, 'Caribbean Netherlands', 'BQ', '+599', 'United States dollar ', 'USD', '', 'A'),
(277, 'Bosnia and Herzegovina', 'BA', '+387', 'Bosnia and Herzegovina convertible mark ', 'BAM', 'UTC+01:00 ', 'A'),
(278, 'Botswana', 'BW', '+267', 'Botswana pula ', 'BWP', 'UTC+02:00 ', 'A'),
(279, 'Bouvet Island', 'BV', '+55', '', '', '', 'A'),
(280, 'Brazil', 'BR', '+55', 'Brazilian real ', 'BRL', 'UTC-05:00', 'A'),
(281, 'British Indian Ocean Territory', 'IO', '+246', 'United States dollar ', 'USD', 'UTC+06 ', 'A'),
(282, 'Brunei', 'BN', '+673', 'Brunei dollar ', 'BND', 'UTC+08:00 ', 'A'),
(283, 'Bulgaria', 'BG', '+359', 'Bulgarian lev ', 'BGN', 'UTC+02:00 ', 'A'),
(284, 'Burkina Faso', 'BF', '+226', 'West African CFA franc ', 'XOF', 'UTC ', 'A'),
(285, 'Burundi', 'BI', '+257', 'Burundian franc ', 'BIF', 'UTC+02:00 ', 'A'),
(286, 'Cambodia', 'KH', '+855', 'Cambodian riel ', 'KHR', 'UTC+07:00 ', 'A'),
(287, 'Cameroon', 'CM', '+237', 'Central African CFA franc ', 'XAF', 'UTC+01:00 ', 'A'),
(288, 'Canada', 'CA', '+1', 'Canadian dollar ', 'CAD', 'UTC-08:00', 'A'),
(289, 'CapeVerde', 'CV', '+238', 'Cape Verdean escudo ', 'CVE', 'UTC-01:00 ', 'A'),
(290, 'Cayman Islands', 'KY', '+1', 'Cayman Islands dollar ', 'KYD', 'UTC-05:00 ', 'A'),
(291, 'Central African Republic', 'CF', '+236', 'Central African CFA franc ', 'XAF', 'UTC+01:00 ', 'A'),
(292, 'Chad', 'TD', '+235', 'Central African CFA franc ', 'XAF', 'UTC+01:00 ', 'A'),
(293, 'Chile', 'CL', '+56', 'Chilean peso ', 'CLP', 'UTC-04:00 ', 'A'),
(294, 'China', 'CN', '+86', 'Chinese yuan ', 'CNY', 'UTC+08:00 ', 'A'),
(295, 'ChristmasIsland', 'CX', '+61', 'Australian dollar ', 'AUD', 'UTC+07 ', 'A'),
(296, 'Cocos(Keeling)Islands', 'CC', '+891', 'Australian dollar ', 'AUD', 'UTC+06:30 ', 'A'),
(297, 'Colombia', 'CO', '+57', 'Colombian peso ', 'COP', 'UTC-05:00 ', 'A'),
(298, 'Comoros', 'KM', '+269', 'Comorian franc ', 'KMF', 'UTC+03:00 ', 'A'),
(299, 'Republic of the Congo', 'CG', '+242', 'Central African CFA franc ', 'XAF', 'UTC+01:00 ', 'A'),
(300, 'Democratic Republic of the Congo', 'CD', '+243', 'Congolese franc ', 'CDF', 'UTC+01:00', 'A'),
(301, 'Cook Islands', 'CK', '+682', 'New Zealand dollar ', 'NZD', 'UTC-10:00 ', 'A'),
(302, 'CostaRica', 'CR', '+506', 'Costa Rican colon ', 'CRC', 'UTC-06:00 ', 'A'),
(303, 'Ivory Coast', 'CI', '+225', 'West African CFA franc ', 'XOF', '', 'A'),
(304, 'Croatia', 'HR', '+385', 'Croatian kuna ', 'HRK', 'UTC+01:00 ', 'A'),
(305, 'Cuba', 'CU', '+53', 'Cuban convertible peso ', 'CUC', 'UTC-03:00 ', 'A'),
(306, 'Curacao', 'CW', '+599', 'Netherlands Antillean guilder ', 'ANG', '', 'A'),
(307, 'Cyprus', 'CY', '+357', 'Euro ', 'EUR', 'UTC+02:00 ', 'A'),
(308, 'Czech Republic', 'CZ', '+420', 'Czech koruna ', 'CZK', 'UTC+01:00 ', 'A'),
(309, 'Denmark', 'DK', '+45', 'Danish krone ', 'DKK', 'UTC+01:00 ', 'A'),
(310, 'Djibouti', 'DJ', '+253', 'Djiboutian franc ', 'DJF', 'UTC+03:00 ', 'A'),
(311, 'Dominica', 'DM', '+1', 'East Caribbean dollar ', 'XCD', 'UTC-04:00 ', 'A'),
(312, 'Dominican Republic', 'DO', '+1', 'Dominican peso ', 'DOP', 'UTC-04:00 ', 'A'),
(313, 'East Timor', 'TL', '+670', 'United States dollar ', 'USD', 'UTC+09 ', 'A'),
(314, 'Ecuador', 'EC', '+593', 'United States dollar ', 'USD', 'UTC-05:00 ', 'A'),
(315, 'Egypt', 'EG', '+20', 'Egyptian pound ', 'EGP', 'UTC+02:00 ', 'A'),
(316, 'El Salvador', 'SV', '+503', 'Salvadoran colon ', 'SVC', 'UTC-06:00 ', 'A'),
(317, 'Equatorial Guinea', 'GQ', '+240', 'Central African CFA franc ', 'XAF', 'UTC+01:00 ', 'A'),
(318, 'Eritrea', 'ER', '+291', 'Eritrean nakfa ', 'ERN', 'UTC+03:00 ', 'A'),
(319, 'Estonia', 'EE', '+372', 'Euro ', 'EUR', 'UTC+03:00 ', 'A'),
(320, 'Ethiopia', 'ET', '+251', 'Ethiopian birr ', 'ETB', 'UTC+03:00 ', 'A'),
(321, 'Falkland Islands (Islas Malvinas)', 'FK', '+500', 'Falkland Islands pound ', 'FKP', 'UTC-04:00 ', 'A'),
(322, 'Faroe Islands', 'FO', '+298', 'Danish krone ', 'DKK', 'UTC ', 'A'),
(323, 'Fiji', 'FJ', '+679', 'Fijian dollar ', 'FJD', 'UTC+12:00 ', 'A'),
(324, 'Finland', 'FI', '+358', 'Euro ', 'EUR', 'UTC+02:00 ', 'A'),
(325, 'France', 'FR', '+33', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(326, 'French Guiana', 'GF', '+594', '', '', 'UTC-01:00 ', 'A'),
(327, 'French Polynesia', 'PF', '+689', 'CFP franc ', 'XPF', 'UTC-10:00 ', 'A'),
(328, 'French Southern and Antarctic Lands', 'TF', '+262', 'Euro ', 'EUR', '', 'A'),
(329, 'Gabon', 'GA', '+241', 'Central African CFA franc ', 'XAF', 'UTC+01:00 ', 'A'),
(330, 'Gambia', 'GM', '+220', 'Gambian dalasi ', 'GMD', 'UTC ', 'A'),
(331, 'Georgia', 'GE', '+995', 'Georgian lari ', 'GEL', 'UTC+04:00 ', 'A'),
(332, 'Germany', 'DE', '+49', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(333, 'Ghana', 'GH', '+233', 'Ghanaian cedi ', 'GHS', 'UTC ', 'A'),
(334, 'Gibraltar', 'GI', '+350', 'Gibraltar pound ', 'GIP', 'UTC+01:00 ', 'A'),
(335, 'Greece', 'GR', '+30', 'Euro ', 'EUR', 'UTC+02:00 ', 'A'),
(336, 'Greenland', 'GL', '+299', 'Danish krone ', 'DKK', 'UTC-03:00 ', 'A'),
(337, 'Grenada', 'GD', '+1', 'East Caribbean dollar ', 'XCD', 'UTC-04:00 ', 'A'),
(338, 'Guadeloupe', 'GP', '+590', '', '', 'UTC-04:00 ', 'A'),
(339, 'Guam', 'GU', '+1', 'United States dollar ', 'USD', 'UTC+10:00 ', 'A'),
(340, 'Guatemala', 'GT', '+502', 'Guatemalan quetzal ', 'GTQ', 'UTC-06:00 ', 'A'),
(341, 'Guernsey', 'GG', '+44', 'Guernsey pound', '?GGP', 'UTC ', 'A'),
(342, 'Guinea', 'GN', '+224', 'Guinean franc ', 'GNF', 'UTC ', 'A'),
(343, 'Guinea-Bissau', 'GW', '+245', 'West African CFA franc ', 'XOF', 'UTC ', 'A'),
(344, 'Guyana', 'GY', '+592', 'Guyanese dollar ', 'GYD', 'UTC-03:00 ', 'A'),
(345, 'Haiti', 'HT', '+509', 'Haitian gourde ', 'HTG', 'UTC-05:00 ', 'A'),
(346, 'Heard Island and McDonald Islands', 'HM', '+0', '', '', 'UTC+05 ', 'A'),
(347, 'Honduras', 'HN', '+504', 'Honduran lempira ', 'HNL', 'UTC-06:00 ', 'A'),
(348, 'HongKong', 'HK', '+852', 'Hong Kong dollar ', 'HKD', 'UTC+08:00 ', 'A'),
(349, 'Hungary', 'HU', '+36', 'Hungarian forint ', 'HUF', 'UTC+01:00 ', 'A'),
(350, 'Iceland', 'IS', '+354', 'Icelandic krona ', 'ISK', 'UTC ', 'A'),
(351, 'India', 'IN', '+91', 'Indian rupee ', 'INR', 'UTC+05:30 ', 'A'),
(352, 'Indonesia', 'ID', '+62', 'Indonesian rupiah ', 'IDR', 'UTC+07:00', 'A'),
(353, 'Iran', 'IR', '+98', 'Iranian rial ', 'IRR', 'UTC+03:30 ', 'A'),
(354, 'Iraq', 'IQ', '+964', 'Iraqi dinar ', 'IQD', 'UTC+03:00 ', 'A'),
(355, 'Ireland', 'IE', '+353', 'Euro ', 'EUR', 'UTC ', 'A'),
(356, 'Isle of Man', 'IM', '+44', 'Manx pound', 'IMP', 'UTC ', 'A'),
(357, 'Israel', 'IL', '+972', 'Israeli new shekel ', 'ILS', 'UTC+02:00 ', 'A'),
(358, 'Italy', 'IT', '+39', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(359, 'Jamaica', 'JM', '+1', 'Jamaican dollar', 'JMD', 'UTC-05:00 ', 'A'),
(360, 'Japan', 'JP', '+81', 'Japanese yen ', 'JPY', 'UTC+09:00 ', 'A'),
(361, 'Jersey', 'JE', '+44', 'Jersey  pound ', '?JEP', 'UTC ', 'A'),
(362, 'Jordan', 'JO', '+962', 'Jordanian dinar ', 'JOD', 'UTC+02:00 ', 'A'),
(363, 'Kazakhstan', 'KZ', '+7', 'Kazakhstani tenge ', 'KZT', 'UTC+06:00 ', 'A'),
(364, 'Kenya', 'KE', '+254', 'Kenyan shilling ', 'KES', 'UTC+03:00 ', 'A'),
(365, 'Kiribati', 'KI', '+686', 'Australian dollar ', 'AUD', 'UTC+12:00 ', 'A'),
(366, 'Kuwait', 'KW', '+965', 'Kuwaiti dinar ', 'KWD', 'UTC+03:00 ', 'A'),
(367, 'Kyrgyzstan', 'KG', '+996', 'Kyrgyzstani som ', 'KGS', 'UTC+06:00 ', 'A'),
(368, 'Laos', 'LA', '+856', 'Lao kip ', 'LAK', 'UTC+07:00 ', 'A'),
(369, 'Latvia', 'LV', '+371', 'Latvian lats ', 'LVL', 'UTC+03:00 ', 'A'),
(370, 'Lebanon', 'LB', '+961', 'Lebanese pound ', 'LBP', 'UTC+02:00 ', 'A'),
(371, 'Lesotho', 'LS', '+266', 'Lesotho loti ', 'LSL', 'UTC+02:00 ', 'A'),
(372, 'Liberia', 'LR', '+231', 'Liberian dollar ', 'LRD', 'UTC ', 'A'),
(373, 'Libya', 'LY', '+218', 'Libyan dinar ', 'LYD', 'UTC+02:00 ', 'A'),
(374, 'Liechtenstein', 'LI', '+423', 'Swiss franc ', 'CHF', 'UTC+01:00 ', 'A'),
(375, 'Lithuania', 'LT', '+370', 'Lithuanian litas ', 'LTL', 'UTC+02:00 ', 'A'),
(376, 'Luxembourg', 'LU', '+352', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(377, 'Macau', 'MO', '+853', 'Macanese pataca ', 'MOP', 'UTC+08:00 ', 'A'),
(378, 'Macedonia', 'MK', '+389', 'Macedonian denar ', 'MKD', 'UTC+01:00 ', 'A'),
(379, 'Madagascar', 'MG', '+261', 'Malagasy ariary ', 'MGA', 'UTC+03:00 ', 'A'),
(380, 'Malawi', 'MW', '+265', 'Malawian kwacha ', 'MWK', 'UTC+02:00 ', 'A'),
(381, 'Malaysia', 'MY', '+60', 'Malaysian ringgit ', 'MYR', 'UTC+08:00 ', 'A'),
(382, 'Maldives', 'MV', '+960', 'Maldivian rufiyaa ', 'MVR', 'UTC+05:00 ', 'A'),
(383, 'Mali', 'ML', '+223', 'West African CFA franc ', 'XOF', 'UTC ', 'A'),
(384, 'Malta', 'MT', '+356', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(385, 'Marshall Islands', 'MH', '+692', 'United States dollar ', 'USD', 'UTC+10:00 ', 'A'),
(386, 'Martinique', 'MQ', '+596', '', '', 'UTC-04:00 ', 'A'),
(387, 'Mauritania', 'MR', '+222', 'Mauritanian ouguiya ', 'MRO', 'UTC ', 'A'),
(388, 'Mauritius', 'MU', '+230', 'Mauritian rupee ', 'MUR', 'UTC+04:00 ', 'A'),
(389, 'Mayotte', 'YT', '+262', 'Euro ', 'EUR', 'UTC+03:00 ', 'A'),
(390, 'Mexico', 'MX', '+52', 'Mexican peso ', 'MXN', 'UTC-06:00 ', 'A'),
(391, 'Federated States of Micronesia', 'FM', '+691', 'Micronesian dollar ', 'None', 'UTC+10:00 ', 'A'),
(392, 'Republic of Moldova', 'MD', '+373', 'Moldovan leu ', 'MDL', 'UTC+03:00 ', 'A'),
(393, 'Monaco', 'MC', '+377', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(394, 'Mongolia', 'MN', '+976', 'Mongolian togrog ', 'MNT', 'UTC+08:00 ', 'A'),
(395, 'Montenegro', 'ME', '+382', 'Euro ', 'EUR', 'UTC+01 ', 'A'),
(396, 'Montserrat', 'MS', '+1', 'East Caribbean dollar ', 'XCD', 'UTC-04:00 ', 'A'),
(397, 'Morocco', 'MA', '+212', 'Moroccan dirham ', 'MAD', 'UTC ', 'A'),
(398, 'Mozambique', 'MZ', '+258', 'Mozambican metical ', 'MZN', 'UTC+02:00 ', 'A'),
(399, 'Myanmar', 'MM', '+95', 'Myanma kyat ', 'MMK', 'UTC+06:30 ', 'A'),
(400, 'Namibia', 'NA', '+264', 'Namibian dollar ', 'NAD', 'UTC+02:00 ', 'A'),
(401, 'Nauru', 'NR', '+674', 'Australian dollar ', 'AUD', 'UTC+12:00 ', 'A'),
(402, 'Nepal', 'NP', '+977', 'Nepalese rupee ', 'NPR', 'UTC+05:30 ', 'A'),
(403, 'Netherlands', 'NL', '+31', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(404, 'New Caledonia', 'NC', '+687', 'CFP franc ', 'XPF', 'UTC+11:00 ', 'A'),
(405, 'New Zealand', 'NZ', '+64', 'New Zealand dollar ', 'NZD', 'UTC+12:00 ', 'A'),
(406, 'Nicaragua', 'NI', '+505', 'Nicaraguan crodoba ', 'NIO', 'UTC-06:00 ', 'A'),
(407, 'Niger', 'NE', '+227', 'West African CFA franc ', 'XOF', 'UTC+01:00 ', 'A'),
(408, 'Nigeria', 'NG', '+234', 'Nigerian naira ', 'NGN', 'UTC+01:00 ', 'A'),
(409, 'Niue', 'NU', '+683', 'New Zealand dollar ', 'NZD', 'UTC-11:00 ', 'A'),
(410, 'Norfolk Island', 'NF', '+672', 'Australian dollar ', 'AUD', 'UTC+11:30 ', 'A'),
(411, 'North Korea', 'KP', '+850', 'North Korean won ', 'KPW', 'UTC+09:00 ', 'A'),
(412, 'Northern Mariana Islands', 'MP', '+1', 'United States dollar ', 'USD', 'UTC+10:00 ', 'A'),
(413, 'Norway', 'NO', '+47', 'Norwegian krone ', 'NOK', 'UTC+01:00 ', 'A'),
(414, 'Oman', 'OM', '+968', 'Omani rial ', 'OMR', 'UTC+04:00 ', 'A'),
(415, 'Pakistan', 'PK', '+92', 'Pakistani rupee ', 'PKR', 'UTC+05:00 ', 'A'),
(416, 'Palau', 'PW', '+680', 'Palauan dollar ', 'None', 'UTC+09:00 ', 'A'),
(417, 'PalestinianTerritory,Occupied', 'PS', '+970', '', '', 'UTC+02:00 ', 'A'),
(418, 'Panama', 'PA', '+507', 'Panamanian balboa ', 'PAB', 'UTC-05:00 ', 'A'),
(419, 'Papua New Guinea', 'PG', '+675', 'Papua New Guinean kina ', 'PGK', 'UTC+10:00 ', 'A'),
(420, 'Paraguay', 'PY', '+595', 'Paraguayan guarani', 'PYG', 'UTC-04:00 ', 'A'),
(421, 'Peru', 'PE', '+51', 'Peruvian nuevo sol ', 'PEN', 'UTC-05:00 ', 'A'),
(422, 'Philippines', 'PH', '+63', 'Philippine peso ', 'PHP', 'UTC+08:00 ', 'A'),
(423, 'Pitcairn', 'PN', '+872', 'New Zealand dollar ', 'NZD', 'UTC-08 ', 'A'),
(424, 'Poland', 'PL', '+48', 'Polish zloty ', 'PLN', 'UTC+01:00 ', 'A'),
(425, 'Portugal', 'PT', '+351', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(426, 'Puerto Rico', 'PR', '+1', 'United States dollar ', 'USD', 'UTC-04:00 ', 'A'),
(427, 'Qatar', 'QA', '+974', 'Qatari riyal ', 'QAR', 'UTC+03:00 ', 'A'),
(428, 'Reunion', 'RE', '+262', '', '', 'UTC+04:00 ', 'A'),
(429, 'Romania', 'RO', '+40', 'Romanian leu ', 'RON', 'UTC+02:00 ', 'A'),
(430, 'Russia', 'RU', '+7', 'Russian ruble ', 'RUB', 'UTC+03:00 ', 'A'),
(431, 'Rwanda', 'RW', '+250', 'Rwandan franc ', 'RWF', 'UTC+02:00 ', 'A'),
(432, 'Saint Barthelemy', 'BL', '+590', 'Euro ', 'EUR', 'UTC-04 ', 'A'),
(433, 'Saint Helena', 'SH', '+290', 'Saint Helena pound ', 'SHP', 'UTC ', 'A'),
(434, 'Saint Kitts and Nevis', 'KN', '+1', 'East Caribbean dollar ', 'XCD', 'UTC-04:00 ', 'A'),
(435, 'Saint Lucia', 'LC', '+1', 'East Caribbean dollar ', 'XCD', 'UTC-04:00 ', 'A'),
(436, 'Saint Martin(Frenchpart)', 'MF', '+590', 'Euro ', 'EUR', 'UTC-04 ', 'A'),
(437, 'Saint Pierreand Miquelon', 'PM', '+508', 'Euro ', 'EUR', 'UTC-03 ', 'A'),
(438, 'Saint Vincent and the Grenadines', 'VC', '+1', 'East Caribbean dollar ', 'XCD', 'UTC-04 ', 'A'),
(439, 'Samoa', 'WS', '+685', 'Samoan tala ', 'WST', 'UTC-11:00 ', 'A'),
(440, 'San Marino', 'SM', '+378', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(441, 'Sao Tome and Principe', 'ST', '+239', 'Sao Tome and Principe dobra ', 'STD', 'UTC ', 'A'),
(442, 'Saudi Arabia', 'SA', '+966', 'Saudi riyal ', 'SAR', 'UTC+03:00 ', 'A'),
(443, 'Senegal', 'SN', '+221', 'West African CFA franc ', 'XOF', 'UTC ', 'A'),
(444, 'Serbia', 'RS', '+381', 'Serbian dinar ', 'RSD', 'UTC+01:00 ', 'A'),
(445, 'Seychelles', 'SC', '+248', 'Seychellois rupee ', 'SCR', 'UTC+04:00 ', 'A'),
(446, 'Sierra Leone', 'SL', '+232', 'Sierra Leonean leone ', 'SLL', 'UTC ', 'A'),
(447, 'Singapore', 'SG', '+65', 'Brunei dollar ', 'BND', 'UTC+08:00 ', 'A'),
(448, 'Sint Maarten', 'SX', '+1', 'Netherlands Antillean guilder ', 'ANG', '', 'A'),
(449, 'Slovakia', 'SK', '+421', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(450, 'Slovenia', 'SI', '+386', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(451, 'Solomon Islands', 'SB', '+677', 'Solomon Islands dollar ', 'SBD', 'UTC+11:00 ', 'A'),
(452, 'Somalia', 'SO', '+252', 'Somali shilling ', 'SOS', 'UTC+03:00 ', 'A'),
(453, 'South Africa', 'ZA', '+27', 'South African rand ', 'ZAR', 'UTC+02:00 ', 'A'),
(454, 'South Georgia and the South Sandwich Islands', 'GS', '+500', 'British pound ', 'GBP', 'UTC-02 ', 'A'),
(455, 'South Korea', 'KR', '+82', 'South Korean won ', 'KRW', 'UTC+09:00 ', 'A'),
(456, 'Spain', 'ES', '+34', 'Euro ', 'EUR', 'UTC+01:00 ', 'A'),
(457, 'SriLanka', 'LK', '+94', 'Sri Lankan rupee ', 'LKR', 'UTC+05:30 ', 'A'),
(458, 'Sudan', 'SD', '+249', 'Sudanese pound ', 'SDG', 'UTC+02:00 ', 'A'),
(459, 'Suriname', 'SR', '+597', 'Surinamese dollar ', 'SRD', 'UTC-03:30 ', 'A'),
(460, 'Svalbard and Jan Mayen', 'SJ', '+47', '', '', '', 'A'),
(461, 'Swaziland', 'SZ', '+268', 'Swazi lilangeni ', 'SZL', 'UTC+02:00 ', 'A'),
(462, 'Sweden', 'SE', '+46', 'Swedish krona ', 'SEK', 'UTC+01:00 ', 'A'),
(463, 'Switzerland', 'CH', '+41', 'Swiss franc ', 'CHF', 'UTC+01:00 ', 'A'),
(464, 'Syrian Arab Republic', 'SY', '+963', 'Syrian pound ', 'SYP', 'UTC+02:00 ', 'A'),
(465, 'Taiwan', 'TW', '+886', 'New Taiwan dollar ', 'TWD', 'UTC+08:00 ', 'A'),
(466, 'Tajikistan', 'TJ', '+992', 'Tajikistani somoni ', 'TJS', 'UTC+06:00 ', 'A'),
(467, 'Tanzania', 'TZ', '+255', 'Tanzanian shilling ', 'TZS', 'UTC+03:00 ', 'A'),
(468, 'Thailand', 'TH', '+66', 'Thai baht ', 'THB', 'UTC+07:00 ', 'A'),
(469, 'Togo', 'TG', '+228', 'West African CFA franc ', 'XOF', 'UTC ', 'A'),
(470, 'Tokelau', 'TK', '+690', 'New Zealand dollar ', 'NZD', 'UTC-10 ', 'A'),
(471, 'Tonga', 'TO', '+676', 'Tongan paoanga ', 'TOP', 'UTC+13:00 ', 'A'),
(472, 'Trinidad and Tobago', 'TT', '+1', 'Trinidad and Tobago dollar ', 'TTD', 'UTC-04:00 ', 'A'),
(473, 'Tunisia', 'TN', '+216', 'Tunisian dinar ', 'TND', 'UTC+01:00 ', 'A'),
(474, 'Turkey', 'TR', '+90', 'Turkish lira ', 'TRY', 'UTC+02:00 ', 'A'),
(475, 'Turkmenistan', 'TM', '+993', 'Turkmenistani manat ', 'TMT', 'UTC+05:00 ', 'A'),
(476, 'Turksand Caicos Islands', 'TC', '+1', 'United States dollar ', 'USD', 'UTC-05:00 ', 'A'),
(477, 'Tuvalu', 'TV', '+688', 'Australian dollar ', 'AUD', 'UTC+12:00 ', 'A'),
(478, 'Uganda', 'UG', '+256', 'Ugandan shilling ', 'UGX', 'UTC+03:00 ', 'A'),
(479, 'Ukraine', 'UA', '+380', 'Ukrainian hryvnia ', 'UAH', 'UTC+03:00 ', 'A'),
(480, 'United Arab Emirates', 'AE', '+971', 'United Arab Emirates dirham ', 'AED', 'UTC+04:00 ', 'A'),
(481, 'United Kingdom', 'GB', '+44', 'Pound sterling', 'GBP', '', 'A'),
(482, 'United States', 'US', '+1', 'United States dollar ', 'USD', 'UTC-11:00', 'A'),
(483, 'United States Minor Outlying Islands', 'UM', '+1', 'United States dollar ', 'USD', '', 'A'),
(484, 'Uruguay', 'UY', '+598', 'Uruguayan peso ', 'UYU', 'UTC-03:00 ', 'A'),
(485, 'Uzbekistan', 'UZ', '+998', 'Uzbekistani som ', 'UZS', 'UTC+06:00 ', 'A'),
(486, 'Vanuatu', 'VU', '+678', 'Vanuatu vatu ', 'VUV', 'UTC+11:00 ', 'A'),
(487, 'VaticanCity', 'VA', '+379', 'Euro ', 'EUR', 'UTC+01 ', 'A'),
(488, 'Venezuela', 'VE', '+58', 'Venezuelan bolivar', 'VEF', 'UTC-04:00 ', 'A'),
(489, 'Vietnam', 'VN', '+84', 'Vietnamese dong', 'VND', 'UTC+07:00 ', 'A'),
(490, 'British Virgin Islands', 'VG', '+1', 'British Virgin Islands dollar ', 'None', 'UTC-04 ', 'A'),
(491, 'United States Virgin Islands', 'VI', '+1', 'United States dollar ', 'USD', 'UTC-04 ', 'A'),
(492, 'WallisandFutuna', 'WF', '+681', 'CFP franc ', 'XPF', 'UTC+12:00 ', 'A'),
(493, 'WesternSahara', 'EH', '+212', 'Moroccan dirham ', 'MAD', '', 'A'),
(494, 'Yemen', 'YE', '+967', 'Yemeni rial ', 'YER', 'UTC+03:00 ', 'A'),
(495, 'Zambia', 'ZM', '+260', 'Zambian kwacha ', 'ZMK', 'UTC+02:00 ', 'A'),
(496, 'Zimbabwe', 'ZW', '+263', 'Botswana pula ', 'BWP', 'UTC+02:00 ', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_05_10_023444_create_permission_tables', 1),
(6, '2022_05_18_123444_create_vmt_360_questions_table', 2),
(7, '2022_05_20_123444_create_vmt_360_forms_table', 3),
(8, '2022_05_22_123444_create_vmt_360_user_forms_table', 4),
(9, '2022_05_24_123444_create_vmt_360_employee_hierarchy_table', 5),
(10, '2022_05_31_100000_create_vmt_general_settings_table', 6),
(11, '2022_06_05_123456_create_vmt_employee_payslip_table', 7),
(12, '2022_06_07_123456_create_vmt_client_master_table', 8),
(13, '2022_06_08_123456_create_vmt_employees_table', 9),
(14, '2022_06_13_111222_create_vmt_performance_apraisal_questions_table', 10),
(15, '2022_06_22_123123_create_vmt_employee_office_details_table', 11),
(16, '2022_06_22_125125_create_vmt_client_master_table', 11),
(17, '2022_06_26_121212_create_vmt_kpi_table', 12),
(18, '2022_06_27_022837_add_userid_to_vmt_employee_details_table', 12),
(19, '2022_06_27_121212_create_vmt_employee_pms_goals_table', 12),
(20, '2022_06_28_150516_add_self_review_to_vmt_employee_pms_goals_table_table', 12),
(21, '2022_07_01_032937_add_manager_emp_id_to_vmt_employee_details_table', 13),
(22, '2022_07_02_061836_change_vmt_employee_details_table_column', 14),
(24, '2022_07_03_224136_create_vmt_leaves_table', 15),
(25, '2022_07_03_224453_create_vmt_employee_actions_table', 15),
(26, '2022_07_04_072245_add_dummy_data_to_vmt_performance_apraisal_questions_table', 16),
(27, '2022_07_05_041200_add_files_column_to_vmt_employee_details_table', 17),
(28, '2014_10_12_000000_create_countries_list_table', 18),
(29, '2014_10_12_000000_create_state_table', 18),
(30, '2014_10_12_000000_create_bank_list_table', 19),
(31, '2014_10_12_000000_create_vmt_employee_compensatory_details_table', 20),
(32, '2014_10_12_000000_create_vmt_employee_experience_table', 21),
(33, '2014_10_12_000000_create_poll_voting_details_table', 22),
(34, '2014_10_12_000000_create_polling_questions_table', 22),
(35, '2022_07_20_073139_create_notifications_table', 22),
(36, '2022_07_20_075344_create_vmt_holidays_table', 22),
(37, '2022_07_03_221908_create_vmt_employee_attendances_table', 23),
(38, '2022_07_20_082329_add_user_id_to_vmt_employee_attendance_table', 24),
(39, '2022_07_21_084956_create_vmt_asset_inventories_table', 25),
(41, '2022_07_25_050341_add_bloodgroup_to_employee_details_table', 27),
(42, '2022_07_26_051833_create_vmt_config_pms_table', 28),
(43, '2022_07_26_091550_create_vmt_department_table', 29),
(44, '2022_07_26_145428_add_active_to_users_table', 30),
(45, '2022_07_26_111410_vmt_announcement', 31),
(46, '2022_07_23_120549_create_vmt_dashboard_posts_table', 32),
(47, '2022_08_05_123550_create_kpi_form_table', 33),
(48, '2022_08_06_171959_add_columns_vmt_employee_details', 34),
(49, '2022_08_09_192423_add_emp_no_users_table', 35),
(51, '2022_08_09_204023_create_vmt_master_configs_table', 36),
(52, '2022_08_13_123203_create_vmt_p_m_s__k_p_i_form_models_table', 37),
(53, '2022_08_13_124056_create_vmt_p_m_s__k_p_i_form_details_models_table', 37),
(54, '2022_08_13_131446_create_vmt_p_m_s__k_p_i_form_assigned_models_table', 37),
(55, '2022_08_13_140427_create_vmt_p_m_s__k_p_i_form_reviews_models_table', 37),
(56, '2022_08_16_204425_add_isadmin_column', 37);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `created` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`, `created`) VALUES
(4, 'App\\Models\\User', 1, '2022-07-01 11:46:52'),
(4, 'App\\Models\\User', 7, '2022-07-01 11:46:39'),
(4, 'App\\Models\\User', 122, '2022-08-16 21:08:49'),
(5, 'App\\Models\\User', 4, '2022-07-01 11:39:38'),
(5, 'App\\Models\\User', 5, '2022-07-01 11:46:39'),
(5, 'App\\Models\\User', 6, '2022-07-01 11:46:39'),
(5, 'App\\Models\\User', 31, '2022-07-05 07:20:40'),
(5, 'App\\Models\\User', 35, '2022-07-05 08:29:37'),
(5, 'App\\Models\\User', 57, '2022-07-10 07:10:42'),
(5, 'App\\Models\\User', 60, '2022-07-11 10:11:39'),
(5, 'App\\Models\\User', 63, '2022-07-11 10:17:25'),
(5, 'App\\Models\\User', 66, '2022-07-11 10:27:07'),
(5, 'App\\Models\\User', 68, '2022-07-11 10:45:40'),
(5, 'App\\Models\\User', 79, '2022-07-11 11:31:44'),
(5, 'App\\Models\\User', 83, '2022-07-11 11:33:11'),
(5, 'App\\Models\\User', 84, '2022-07-11 11:41:35'),
(5, 'App\\Models\\User', 85, '2022-07-11 12:04:46'),
(5, 'App\\Models\\User', 87, '2022-07-11 12:05:36'),
(5, 'App\\Models\\User', 88, '2022-07-11 12:49:05'),
(5, 'App\\Models\\User', 89, '2022-07-11 19:00:21'),
(5, 'App\\Models\\User', 90, '2022-07-11 19:04:57'),
(5, 'App\\Models\\User', 91, '2022-07-11 19:13:02'),
(5, 'App\\Models\\User', 92, '2022-07-12 04:55:15'),
(5, 'App\\Models\\User', 93, '2022-07-16 10:51:55'),
(5, 'App\\Models\\User', 96, '2022-07-16 10:53:48'),
(5, 'App\\Models\\User', 98, '2022-07-16 11:01:47'),
(5, 'App\\Models\\User', 99, '2022-07-16 11:04:51'),
(5, 'App\\Models\\User', 100, '2022-07-16 11:57:14'),
(5, 'App\\Models\\User', 101, '2022-07-20 08:52:27'),
(5, 'App\\Models\\User', 105, '2022-07-20 08:55:23'),
(5, 'App\\Models\\User', 107, '2022-07-20 14:00:36'),
(5, 'App\\Models\\User', 108, '2022-07-27 12:10:00'),
(5, 'App\\Models\\User', 109, '2022-07-27 12:10:01'),
(5, 'App\\Models\\User', 110, '2022-07-27 19:39:39'),
(5, 'App\\Models\\User', 111, '2022-07-27 19:39:40'),
(5, 'App\\Models\\User', 112, '2022-07-28 10:12:36'),
(5, 'App\\Models\\User', 113, '2022-07-28 10:54:19'),
(5, 'App\\Models\\User', 114, '2022-07-28 11:06:44'),
(5, 'App\\Models\\User', 115, '2022-07-28 11:06:45'),
(5, 'App\\Models\\User', 116, '2022-08-10 18:00:42'),
(5, 'App\\Models\\User', 117, '2022-08-10 18:01:11'),
(5, 'App\\Models\\User', 118, '2022-08-10 18:03:01'),
(5, 'App\\Models\\User', 119, '2022-08-10 18:06:22'),
(5, 'App\\Models\\User', 120, '2022-08-10 18:09:37'),
(6, 'App\\Models\\User', 2, '2022-07-01 11:46:39'),
(6, 'App\\Models\\User', 3, '2022-07-01 11:39:54');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Performance_Appraisal', 'web', '2022-05-17 09:56:37', '2022-05-17 09:56:37'),
(2, 'Self_Appraisal', 'web', '2022-05-17 09:56:38', '2022-05-17 09:56:38'),
(3, 'Team', 'web', '2022-05-17 10:56:36', '2022-05-17 10:56:36'),
(4, 'ORG', 'web', '2022-05-17 10:56:36', '2022-05-17 10:56:36'),
(5, 'L1_Review', 'web', '2022-05-17 10:58:30', '2022-05-17 10:58:30'),
(6, 'L2_Review', 'web', '2022-05-17 10:58:30', '2022-05-17 10:58:30'),
(7, '360_Degree_Review', 'web', '2022-05-19 00:19:24', '2022-05-19 00:19:24'),
(8, 'Final_Review', 'web', '2022-05-19 00:19:24', '2022-05-19 00:19:24');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `polling_questions`
--

CREATE TABLE `polling_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `polling_questions`
--

INSERT INTO `polling_questions` (`id`, `question`, `options`, `created_at`, `updated_at`) VALUES
(1, 'Which place do you want to go for a Vacation?', '[\"Ooty\", \"Magalaya\", \"Kanyakumari\"]', '2022-07-21 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `poll_voting_details`
--

CREATE TABLE `poll_voting_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `polling_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `selected_option` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `poll_voting_details`
--

INSERT INTO `poll_voting_details` (`id`, `user_id`, `polling_id`, `selected_option`, `created_at`, `updated_at`) VALUES
(1, '1', '1', 'Magalaya', '2022-07-21 11:07:37', '2022-07-21 12:53:32');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(4, 'Admin', 'web', '2022-05-19 00:19:14', '2022-05-19 00:19:14'),
(5, 'Employee', 'web', '2022-05-27 12:36:50', '2022-05-27 12:36:50'),
(6, 'Manager', 'web', '2022-06-08 23:18:27', '2022-06-08 23:18:27'),
(8, 'HR', 'web', '2022-05-19 00:19:14', '2022-05-19 00:19:14');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 4),
(1, 5),
(1, 6),
(1, 8),
(2, 4),
(2, 5),
(2, 6),
(2, 8),
(3, 4),
(3, 6),
(3, 8),
(4, 4),
(4, 5),
(4, 6),
(4, 8),
(5, 4),
(5, 6),
(5, 8),
(6, 4),
(6, 6),
(6, 8),
(7, 4),
(7, 6),
(7, 8),
(8, 4),
(8, 6),
(8, 8);

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`id`, `country_id`, `country_code`, `state_name`, `status`) VALUES
(1, '359', 'IN', 'Andhra Pradesh', 'A'),
(2, '359', 'IN', 'Andaman and Nicobar Islands', 'A'),
(3, '359', 'IN', 'Arunachal Pradesh', 'A'),
(4, '359', 'IN', 'Assam', 'A'),
(5, '359', 'IN', 'Bihar', 'A'),
(6, '359', 'IN', 'Chandigarh', 'A'),
(7, '359', 'IN', 'Chhattisgarh', 'A'),
(8, '359', 'IN', 'Dadar and Nagar Haveli', 'A'),
(9, '359', 'IN', 'Daman and Diu', 'A'),
(10, '359', 'IN', 'Delhi', 'A'),
(11, '359', 'IN', 'Lakshadweep', 'A'),
(12, '359', 'IN', 'Puducherry', 'A'),
(13, '359', 'IN', 'Goa', 'A'),
(14, '359', 'IN', 'Gujarat', 'A'),
(15, '359', 'IN', 'Haryana', 'A'),
(16, '359', 'IN', 'Himachal Pradesh', 'A'),
(17, '359', 'IN', 'Jammu and Kashmir', 'A'),
(18, '359', 'IN', 'Jharkhand', 'A'),
(19, '359', 'IN', 'Karnataka', 'A'),
(20, '359', 'IN', 'Kerala', 'A'),
(21, '359', 'IN', 'Madhya Pradesh', 'A'),
(22, '359', 'IN', 'Maharashtra', 'A'),
(23, '359', 'IN', 'Manipur', 'A'),
(24, '359', 'IN', 'Meghalaya', 'A'),
(25, '359', 'IN', 'Mizoram', 'A'),
(26, '359', 'IN', 'Nagaland', 'A'),
(27, '359', 'IN', 'Odisha', 'A'),
(28, '359', 'IN', 'Punjab', 'A'),
(29, '359', 'IN', 'Rajasthan', 'A'),
(30, '359', 'IN', 'Sikkim', 'A'),
(31, '359', 'IN', 'Tamil Nadu', 'A'),
(32, '359', 'IN', 'Telangana', 'A'),
(33, '359', 'IN', 'Tripura', 'A'),
(34, '359', 'IN', 'Uttar Pradesh', 'A'),
(35, '359', 'IN', 'Uttarakhand', 'A'),
(36, '359', 'IN', 'West Bengal', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_code` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` smallint(6) NOT NULL DEFAULT 1,
  `is_admin` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '\'0\'',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `user_code`, `email`, `active`, `is_admin`, `email_verified_at`, `password`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'HR Augustin', 'EMP100', 'hr_augustin@vasagroup.abshrms.com', 1, '0', NULL, '$2y$10$vry5bkqFn25Jq/5JVRldEurny4slho/O2NI6Nlla57o0QKf3X0kjW', '', NULL, '2022-07-02 08:21:19', '2022-08-05 11:39:14'),
(2, 'Mgr Max Kumar', 'Vasa102', 'mr_max@vasagroup.abshrms.com', 1, '0', NULL, '$2y$10$UKk2.2IvqstWjcGFypCZke8M8sEiwJjaz9lcMYYJj6TkpGxP/cYzi', '', NULL, '2022-07-02 08:24:54', '2022-07-22 11:30:09'),
(3, 'Mgr Srini', 'Vasa103', 'mr_srini@vasagroup.abshrms.com', 1, '0', NULL, '$2y$10$POvQAXpAfD9dTJRhXzi1c.iKK2WuPm06GZdT1LVdp0Osmy6Z5eeIS', '', NULL, '2022-07-02 08:26:28', '2022-07-02 08:26:28'),
(4, 'Emp Praveen', 'Vasa104', 'emp_praveen@vasagroup.abshrms.com', 1, '0', NULL, '$2y$10$V/ic6IaAsqm4J0c5wJh5qO2WqV5xCejPnJ8W3Q9D/YlFyXFsngccS', '', NULL, '2022-07-02 08:27:47', '2022-07-25 04:35:46'),
(5, 'Emp Srini', NULL, 'emp_srini@vasagroup.abshrms.com', 1, '0', NULL, '$2y$10$QcdBLKenRbpQfxGksRgPOOIhO4uARYBP.Gz1uunj5og5iQPGRkMGa', '', NULL, '2022-07-02 08:28:55', '2022-07-02 08:28:55'),
(6, 'Emp Vijay', NULL, 'emp_vijay@vasagroup.abshrms.com', 1, '0', NULL, '$2y$10$6swUzQBnWWdh/pn21yA7pujVLj/iYX3c4Jj2QVEl4ie8dVXg/cEum', '', NULL, '2022-07-02 08:29:57', '2022-07-02 08:29:57'),
(7, 'SA Ardens', NULL, 'sa_ardens@vasagroup.abshrms.com', 1, '0', NULL, '$2y$10$OKCjTO7Z4BaMXU8mq8HyFeJ6WuIeCD58hYzxcIqRgoqU8rzIi8tHe', '', NULL, '2022-07-02 08:31:11', '2022-07-02 08:31:11'),
(119, 'Emp 1', NULL, 'test@gmail.com', 0, '0', NULL, '$2y$10$VPZtrwDzg5T0/HNuXZg6n.LvmNHTVMgxOU8Qob3hKJgwOaOt8AOhK', 'Emp 1_avatar.jpg', NULL, '2022-08-10 12:36:22', '2022-08-10 12:36:22'),
(120, 'Emp 2', NULL, 'test@gmail.com1', 0, '0', NULL, '$2y$10$ItoZShJPpH5PW2iz59cC6.SCO/65.Vq3hPDPXv2figaAPm7Qgi6gK', 'Emp 2_avatar.jpg', NULL, '2022-08-10 12:39:37', '2022-08-10 12:39:37'),
(122, 'Super Admin', 'SA100', 'superadmin@vasagroup.abshrms.com', 1, '1', NULL, '$2y$10$vry5bkqFn25Jq/5JVRldEurny4slho/O2NI6Nlla57o0QKf3X0kjW', '', NULL, '2022-07-02 08:21:19', '2022-08-05 11:39:14');

-- --------------------------------------------------------

--
-- Table structure for table `vmt_announcement`
--

CREATE TABLE `vmt_announcement` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ann_author_id` int(11) NOT NULL,
  `title_data` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details_data` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_publish` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vmt_announcement`
--

INSERT INTO `vmt_announcement` (`id`, `ann_author_id`, `title_data`, `details_data`, `is_publish`, `created_at`, `updated_at`) VALUES
(1, 1, 'Title test 1', 'details test2', 0, '2022-07-28 10:11:30', '2022-07-28 10:11:30'),
(2, 1, 'Title test 1', 'details test2', 0, '2022-07-28 10:11:50', '2022-07-28 10:11:50'),
(3, 1, 'title', 'annoucenment', 0, '2022-07-28 10:45:18', '2022-07-28 10:45:18'),
(4, 1, 'Title test 1', 'details test2', 0, '2022-07-28 10:45:18', '2022-07-28 10:45:18');

-- --------------------------------------------------------

--
-- Table structure for table `vmt_asset_inventories`
--

CREATE TABLE `vmt_asset_inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asset_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asset_type` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asset_status` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_number` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warranty` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendor` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assignee` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assigned_date` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vmt_asset_inventories`
--

INSERT INTO `vmt_asset_inventories` (`id`, `asset_name`, `asset_type`, `asset_status`, `serial_number`, `warranty`, `vendor`, `assignee`, `assigned_date`, `invoice`, `created_at`, `updated_at`) VALUES
(2, 'OnePlus X', 'Mobile', NULL, 'TX1-ABB-333', '1 years', 'OnePlus', 'Srini', '2022-10-1', 'sample_asset_invoice.pdf', '2022-07-21 13:25:30', '2022-07-21 13:25:30'),
(3, 'Dell Laptop', 'Laptop', NULL, '111-222-333', '3 years', 'HP', 'Srini', '2022-1-1', 'sample_asset_invoice.pdf', '2022-07-21 13:25:30', '2022-07-21 13:25:30'),
(4, 'Samsung X', 'Mobile', NULL, 'TX1-ABB-333', '1 years', 'OnePlus', 'Srini', '2022-10-1', 'sample_asset_invoice.pdf', '2022-07-21 13:25:30', '2022-07-21 13:25:30'),
(5, 'Acer Tx 01', 'Laptop', 'Active', 'SR:21323123123', '2 years', 'Acer', 'Srini', '2022-07-15', NULL, '2022-07-21 20:17:05', '2022-07-21 20:17:05');

-- --------------------------------------------------------

--
-- Table structure for table `vmt_client_master`
--

CREATE TABLE `vmt_client_master` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_code` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contract_start_date` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contract_end_date` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cin_number` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_tan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_pan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gst_no` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `epf_reg_number` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `esic_reg_number` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prof_tax_reg_number` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lwf_reg_number` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authorised_person_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authorised_person_designation` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authorised_person_contact_number` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authorised_person_contact_email` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doc_uploads` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subscription_type` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vmt_client_master`
--

INSERT INTO `vmt_client_master` (`id`, `client_code`, `client_name`, `address`, `contract_start_date`, `contract_end_date`, `cin_number`, `company_tan`, `company_pan`, `gst_no`, `epf_reg_number`, `esic_reg_number`, `prof_tax_reg_number`, `lwf_reg_number`, `authorised_person_name`, `authorised_person_designation`, `authorised_person_contact_number`, `authorised_person_contact_email`, `billing_address`, `shipping_address`, `doc_uploads`, `product`, `subscription_type`, `created_at`, `updated_at`) VALUES
(19, 'Demo', 'Vasa', NULL, '2022-06-01', '2022-06-14', '111', '111111111', '1111111111', '18AABCU9603R1ZM', '1111111', '1111111111111111111', '11111111', '11111111', '1Vasa', 'Vasas', '9999988887', 'praveenkumar.techdev@gmail.com', 'asdf', 'asdf', NULL, 'Recruitment', 'Quarterly', '2022-06-29 16:13:29', '2022-08-09 17:15:47'),
(46, 'CAAf', 'CAAFE', NULL, '2021-06-08', '2024-10-15', 'BBH93834', 'NGP002911G', 'BREPP0698R', '18AABCU9603R1ZM', 'GRVSP00780890000000456', '897667895554897865656555', '897865656555', '7854465865476', 'CJ', 'DSGD', '8986645456', 'VIJAYARAJA2312@GMAIL.COM', 'ANNA NAGAR', 'T NAGAR', 'doc_1658326471.png', 'Payroll', 'Quarterly', '2022-07-20 14:14:31', '2022-07-20 14:14:31');

-- --------------------------------------------------------

--
-- Table structure for table `vmt_config_master`
--

CREATE TABLE `vmt_config_master` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `config_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `config_value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vmt_config_master`
--

INSERT INTO `vmt_config_master` (`id`, `config_name`, `config_value`, `created_at`, `updated_at`) VALUES
(1, 'client_code', 'Demo', NULL, '2022-08-09 17:35:44'),
(2, 'can_send_appointmentletter_after_onboarding', 'true', NULL, '2022-08-09 17:35:44');

-- --------------------------------------------------------

--
-- Table structure for table `vmt_config_pms`
--

CREATE TABLE `vmt_config_pms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `selected_columns` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `selected_head` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `column_header` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vmt_dashboard_posts`
--

CREATE TABLE `vmt_dashboard_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `author_id` int(11) NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vmt_dashboard_posts`
--

INSERT INTO `vmt_dashboard_posts` (`id`, `author_id`, `message`, `post_image`, `created_at`, `updated_at`) VALUES
(1, 1, 'Hello', 'post-.srini_square.jpg', '2022-07-27 11:04:47', '2022-07-27 11:04:47'),
(2, 1, 'gyyhuhkuicvfghv', 'post-.Screenshot 2022-04-05 132639.png', '2022-07-27 11:05:08', '2022-07-27 11:05:08'),
(3, 1, 'Testing', NULL, '2022-07-27 11:50:46', '2022-07-27 11:50:46'),
(4, 1, 'helo all, i am testing it', NULL, '2022-07-28 11:46:38', '2022-07-28 11:46:38'),
(5, 1, 'helo all, i am testing it', NULL, '2022-07-28 11:46:40', '2022-07-28 11:46:40'),
(6, 1, 'helo all, i am testing it', NULL, '2022-07-28 11:46:41', '2022-07-28 11:46:41'),
(7, 1, 'helo all, i am testing it', NULL, '2022-07-28 11:46:41', '2022-07-28 11:46:41'),
(8, 1, 'helo all, i am testing it', NULL, '2022-07-28 11:46:41', '2022-07-28 11:46:41'),
(9, 1, 'helo all, i am testing it', NULL, '2022-07-28 11:46:42', '2022-07-28 11:46:42'),
(10, 1, 'helo all, i am testing it', NULL, '2022-07-28 11:46:42', '2022-07-28 11:46:42'),
(11, 1, 'helo all, i am testing it', NULL, '2022-07-28 11:46:42', '2022-07-28 11:46:42'),
(12, 1, 'helo all, i am testing it', NULL, '2022-07-28 11:46:42', '2022-07-28 11:46:42'),
(13, 1, 'helo all, i am testing it', NULL, '2022-07-28 11:46:42', '2022-07-28 11:46:42'),
(14, 1, 'helo all, i am testing it', NULL, '2022-07-28 11:46:42', '2022-07-28 11:46:42'),
(15, 1, 'helo all, i am testing it', NULL, '2022-07-28 11:46:43', '2022-07-28 11:46:43'),
(16, 1, 'helo all, i am testing it', NULL, '2022-07-28 11:46:43', '2022-07-28 11:46:43'),
(17, 1, 'helo all, i am testing it', NULL, '2022-07-28 11:46:45', '2022-07-28 11:46:45'),
(18, 1, 'helo all, i am testing it', NULL, '2022-07-28 11:46:47', '2022-07-28 11:46:47'),
(19, 1, 'helo all, i am testing it', NULL, '2022-07-28 11:46:47', '2022-07-28 11:46:47'),
(20, 1, 'helo all, i am testing it', NULL, '2022-07-28 11:46:47', '2022-07-28 11:46:47'),
(21, 1, 'helo all, i am testing it', NULL, '2022-07-28 11:46:47', '2022-07-28 11:46:47'),
(22, 1, 'helo all, i am testing it', 'post-.1024.png', '2022-07-28 11:46:59', '2022-07-28 11:46:59'),
(23, 1, 'helo all, i am testing it', 'post-.1024.png', '2022-07-28 11:47:00', '2022-07-28 11:47:00'),
(24, 1, 'helo all, i am testing it', 'post-.1024.png', '2022-07-28 11:47:00', '2022-07-28 11:47:00'),
(25, 1, 'helo all, i am testing it', 'post-.1024.png', '2022-07-28 11:47:00', '2022-07-28 11:47:00'),
(26, 1, 'helo all, i am testing it', 'post-.1024.png', '2022-07-28 11:47:00', '2022-07-28 11:47:00'),
(27, 1, 'helo all, i am testing it', 'post-.1024.png', '2022-07-28 11:47:00', '2022-07-28 11:47:00'),
(28, 1, 'helo all, i am testing it', 'post-.1024.png', '2022-07-28 11:47:01', '2022-07-28 11:47:01'),
(29, 1, 'helo all, i am testing it', 'post-.1024.png', '2022-07-28 11:47:01', '2022-07-28 11:47:01');

-- --------------------------------------------------------

--
-- Table structure for table `vmt_department`
--

CREATE TABLE `vmt_department` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vmt_department`
--

INSERT INTO `vmt_department` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'IT', 'A', '2022-07-26 12:51:08', NULL),
(2, 'Sales', 'A', '2022-07-26 12:51:08', NULL),
(3, 'HR', 'A', '2022-07-26 12:51:08', NULL),
(4, 'Support', 'A', '2022-07-26 12:51:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vmt_employee_actions`
--

CREATE TABLE `vmt_employee_actions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `action_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action_message` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trigger_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vmt_employee_attendance`
--

CREATE TABLE `vmt_employee_attendance` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checkin_time` datetime DEFAULT NULL,
  `checkout_time` datetime DEFAULT NULL,
  `shift_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `leave_type_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vmt_employee_attendance`
--

INSERT INTO `vmt_employee_attendance` (`id`, `user_id`, `date`, `checkin_time`, `checkout_time`, `shift_type`, `leave_type_id`, `created_at`, `updated_at`) VALUES
(1, '1', '2022-07-20', '2022-07-20 17:29:19', '2022-07-20 17:29:21', NULL, NULL, '2022-07-20 17:29:19', '2022-07-20 17:29:21'),
(2, '1', '2022-07-20', '2022-07-20 17:29:21', '2022-07-20 17:29:42', NULL, NULL, '2022-07-20 17:29:21', '2022-07-20 17:29:42'),
(3, '1', '2022-07-20', '2022-07-20 17:29:43', '2022-07-20 17:29:45', NULL, NULL, '2022-07-20 17:29:43', '2022-07-20 17:29:45'),
(4, '1', '2022-07-20', '2022-07-20 17:29:45', '2022-07-20 17:31:44', NULL, NULL, '2022-07-20 17:29:45', '2022-07-20 17:31:44'),
(5, '1', '2022-07-20', '2022-07-20 17:31:46', '2022-07-20 17:31:50', NULL, NULL, '2022-07-20 17:31:46', '2022-07-20 17:31:50'),
(6, '1', '2022-07-20', '2022-07-20 17:31:54', '2022-07-20 17:32:12', NULL, NULL, '2022-07-20 17:31:54', '2022-07-20 17:32:12'),
(7, '1', '2022-07-20', '2022-07-20 17:32:14', '2022-07-20 17:32:15', NULL, NULL, '2022-07-20 17:32:14', '2022-07-20 17:32:15'),
(8, '1', '2022-07-20', '2022-07-20 17:32:16', '2022-07-20 17:34:54', NULL, NULL, '2022-07-20 17:32:16', '2022-07-20 17:34:54'),
(9, '1', '2022-07-20', '2022-07-20 17:34:55', '2022-07-20 19:29:07', NULL, NULL, '2022-07-20 17:34:55', '2022-07-20 19:29:07'),
(10, '1', '2022-07-20', '2022-07-20 19:29:09', '2022-07-20 19:39:24', NULL, NULL, '2022-07-20 19:29:09', '2022-07-20 19:39:24'),
(11, '1', '2022-07-21', '2022-07-21 04:19:50', '2022-07-21 04:19:50', NULL, NULL, '2022-07-21 04:19:50', '2022-07-21 04:19:50'),
(12, '1', '2022-07-21', '2022-07-21 04:48:47', '2022-07-21 04:48:49', NULL, NULL, '2022-07-21 04:48:47', '2022-07-21 04:48:49'),
(13, '1', '2022-07-21', '2022-07-21 04:48:56', '2022-07-21 04:49:02', NULL, NULL, '2022-07-21 04:48:56', '2022-07-21 04:49:02'),
(14, '1', '2022-07-21', '2022-07-21 05:14:25', '2022-07-21 05:14:25', NULL, NULL, '2022-07-21 05:14:25', '2022-07-21 05:14:25'),
(15, '1', '2022-07-21', '2022-07-21 05:40:59', '2022-07-21 05:41:00', NULL, NULL, '2022-07-21 05:40:59', '2022-07-21 05:41:00'),
(16, '1', '2022-07-21', '2022-07-21 07:22:57', '2022-07-21 07:22:59', NULL, NULL, '2022-07-21 07:22:57', '2022-07-21 07:22:59'),
(17, '1', '2022-07-21', '2022-07-21 11:23:09', '2022-07-21 11:23:15', NULL, NULL, '2022-07-21 11:23:09', '2022-07-21 11:23:15'),
(18, '1', '2022-07-21', '2022-07-21 11:23:17', '2022-07-21 11:23:18', NULL, NULL, '2022-07-21 11:23:17', '2022-07-21 11:23:18'),
(19, '1', '2022-07-21', '2022-07-21 11:23:19', '2022-07-21 11:23:20', NULL, NULL, '2022-07-21 11:23:19', '2022-07-21 11:23:20'),
(20, '1', '2022-07-21', '2022-07-21 11:23:21', '2022-07-21 11:23:32', NULL, NULL, '2022-07-21 11:23:21', '2022-07-21 11:23:32'),
(21, '1', '2022-07-21', '2022-07-21 11:23:32', '2022-07-21 11:42:19', NULL, NULL, '2022-07-21 11:23:32', '2022-07-21 11:42:19'),
(22, '1', '2022-07-21', '2022-07-21 11:42:51', '2022-07-21 11:42:52', NULL, NULL, '2022-07-21 11:42:51', '2022-07-21 11:42:52'),
(23, '1', '2022-07-22', '2022-07-22 04:20:16', '2022-07-22 04:20:25', NULL, NULL, '2022-07-22 04:20:16', '2022-07-22 04:20:25'),
(24, '1', '2022-07-22', '2022-07-22 04:20:29', '2022-07-22 04:20:31', NULL, NULL, '2022-07-22 04:20:29', '2022-07-22 04:20:31'),
(25, '1', '2022-07-22', '2022-07-22 04:20:32', '2022-07-22 04:20:33', NULL, NULL, '2022-07-22 04:20:32', '2022-07-22 04:20:33'),
(26, '1', '2022-07-22', '2022-07-22 08:48:59', '2022-07-22 08:49:06', NULL, NULL, '2022-07-22 08:48:59', '2022-07-22 08:49:06'),
(27, '2', '2022-07-22', '2022-07-22 11:24:44', '2022-07-22 11:24:47', NULL, NULL, '2022-07-22 11:24:44', '2022-07-22 11:24:47'),
(28, '2', '2022-07-22', '2022-07-22 11:30:42', '2022-07-22 11:30:43', NULL, NULL, '2022-07-22 11:30:42', '2022-07-22 11:30:43'),
(29, '1', '2022-07-22', '2022-07-22 11:30:50', '2022-07-22 11:30:52', NULL, NULL, '2022-07-22 11:30:50', '2022-07-22 11:30:52'),
(30, '1', '2022-07-22', '2022-07-22 11:30:53', '2022-07-22 11:30:54', NULL, NULL, '2022-07-22 11:30:53', '2022-07-22 11:30:54'),
(31, '1', '2022-07-22', '2022-07-22 11:30:56', '2022-07-22 11:30:58', NULL, NULL, '2022-07-22 11:30:56', '2022-07-22 11:30:58'),
(32, '1', '2022-07-22', '2022-07-22 11:30:59', '2022-07-22 11:31:01', NULL, NULL, '2022-07-22 11:30:59', '2022-07-22 11:31:01'),
(33, '1', '2022-07-22', '2022-07-22 12:10:59', '2022-07-22 12:11:01', NULL, NULL, '2022-07-22 12:10:59', '2022-07-22 12:11:01'),
(34, '1', '2022-07-22', '2022-07-22 12:11:16', '2022-07-22 18:17:06', NULL, NULL, '2022-07-22 12:11:16', '2022-07-22 18:17:06'),
(35, '1', '2022-07-22', '2022-07-22 18:17:07', '2022-07-22 18:17:08', NULL, NULL, '2022-07-22 18:17:07', '2022-07-22 18:17:08'),
(36, '1', '2022-07-23', '2022-07-22 18:17:12', '2022-07-23 12:11:01', NULL, NULL, '2022-07-22 18:17:12', '2022-07-23 12:11:01'),
(37, '1', '2022-07-23', '2022-07-23 12:11:05', '2022-07-23 12:11:06', NULL, NULL, '2022-07-23 12:11:05', '2022-07-23 12:11:06'),
(38, '1', '2022-07-23', '2022-07-23 12:11:07', '2022-07-23 12:11:08', NULL, NULL, '2022-07-23 12:11:07', '2022-07-23 12:11:08'),
(39, '1', '2022-07-23', '2022-07-23 12:11:09', '2022-07-23 12:11:10', NULL, NULL, '2022-07-23 12:11:09', '2022-07-23 12:11:10'),
(40, '1', '2022-07-23', '2022-07-23 12:11:10', '2022-07-23 12:11:11', NULL, NULL, '2022-07-23 12:11:10', '2022-07-23 12:11:11'),
(41, '1', '2022-07-23', '2022-07-23 12:11:11', '2022-07-23 12:11:11', NULL, NULL, '2022-07-23 12:11:11', '2022-07-23 12:11:11'),
(42, '1', '2022-07-23', '2022-07-23 12:11:12', '2022-07-23 12:11:12', NULL, NULL, '2022-07-23 12:11:12', '2022-07-23 12:11:12'),
(43, '1', '2022-07-23', '2022-07-23 12:11:12', NULL, NULL, NULL, '2022-07-23 12:11:12', '2022-07-23 12:11:12'),
(44, '1', '2022-07-23', '2022-07-23 12:11:13', '2022-07-23 12:11:14', NULL, NULL, '2022-07-23 12:11:13', '2022-07-23 12:11:14'),
(45, '1', '2022-07-23', '2022-07-23 12:11:13', NULL, NULL, NULL, '2022-07-23 12:11:13', '2022-07-23 12:11:13'),
(46, '1', '2022-07-23', '2022-07-23 12:11:14', '2022-07-23 12:11:15', NULL, NULL, '2022-07-23 12:11:14', '2022-07-23 12:11:15'),
(47, '1', '2022-07-23', '2022-07-23 12:11:16', '2022-07-23 12:11:17', NULL, NULL, '2022-07-23 12:11:16', '2022-07-23 12:11:17'),
(48, '1', '2022-07-23', '2022-07-23 22:17:27', '2022-07-23 22:17:33', NULL, NULL, '2022-07-23 16:47:27', '2022-07-23 16:47:33'),
(49, '1', '2022-07-25', '2022-07-25 09:34:43', '2022-07-25 09:34:49', NULL, NULL, '2022-07-25 04:04:43', '2022-07-25 04:04:49'),
(50, '1', '2022-07-25', '2022-07-25 09:34:52', '2022-07-25 09:34:56', NULL, NULL, '2022-07-25 04:04:52', '2022-07-25 04:04:56'),
(51, '1', '2022-07-25', '2022-07-25 09:45:30', '2022-07-25 10:07:08', NULL, NULL, '2022-07-25 04:15:30', '2022-07-25 04:37:08'),
(52, '1', '2022-07-25', '2022-07-25 10:07:11', NULL, NULL, NULL, '2022-07-25 04:37:11', '2022-07-25 04:37:11'),
(53, '1', '2022-07-25', '2022-07-25 14:36:04', '2022-07-25 14:36:09', NULL, NULL, '2022-07-25 09:06:04', '2022-07-25 09:06:09'),
(54, '1', '2022-07-25', '2022-07-25 14:36:12', '2022-07-25 14:36:46', NULL, NULL, '2022-07-25 09:06:12', '2022-07-25 09:06:46'),
(55, '1', '2022-07-25', '2022-07-25 14:37:11', '2022-07-25 15:13:37', NULL, NULL, '2022-07-25 09:07:11', '2022-07-25 09:43:37'),
(56, '1', '2022-07-25', '2022-07-25 15:13:41', '2022-07-25 15:37:58', NULL, NULL, '2022-07-25 09:43:41', '2022-07-25 10:07:58'),
(57, '1', '2022-07-25', '2022-07-25 15:38:40', '2022-07-25 16:14:27', NULL, NULL, '2022-07-25 10:08:40', '2022-07-25 10:44:27'),
(58, '1', '2022-07-26', '2022-07-25 16:14:36', '2022-07-26 11:15:17', NULL, NULL, '2022-07-25 10:44:36', '2022-07-26 05:45:17'),
(59, '1', '2022-07-26', '2022-07-26 11:15:19', '2022-07-26 11:15:23', NULL, NULL, '2022-07-26 05:45:19', '2022-07-26 05:45:23'),
(60, '1', '2022-07-26', '2022-07-26 11:15:24', '2022-07-26 11:15:30', NULL, NULL, '2022-07-26 05:45:24', '2022-07-26 05:45:30'),
(61, '1', '2022-07-27', '2022-07-26 11:15:32', '2022-07-27 12:13:35', NULL, NULL, '2022-07-26 05:45:32', '2022-07-27 06:43:35'),
(62, '1', '2022-07-27', '2022-07-27 12:13:38', '2022-07-27 12:13:46', NULL, NULL, '2022-07-27 06:43:38', '2022-07-27 06:43:46'),
(63, '1', '2022-07-27', '2022-07-27 12:13:47', '2022-07-27 12:13:55', NULL, NULL, '2022-07-27 06:43:47', '2022-07-27 06:43:55'),
(64, '1', '2022-07-27', '2022-07-27 12:13:55', '2022-07-27 12:13:59', NULL, NULL, '2022-07-27 06:43:55', '2022-07-27 06:43:59'),
(65, '1', '2022-07-27', '2022-07-27 12:14:01', '2022-07-27 17:49:05', NULL, NULL, '2022-07-27 06:44:01', '2022-07-27 12:19:05'),
(66, '1', '2022-07-27', '2022-07-27 17:49:07', '2022-07-27 19:07:10', NULL, NULL, '2022-07-27 12:19:07', '2022-07-27 13:37:10'),
(67, '1', '2022-07-27', '2022-07-27 19:07:12', '2022-07-27 19:44:26', NULL, NULL, '2022-07-27 13:37:12', '2022-07-27 14:14:26'),
(68, '1', '2022-07-28', '2022-07-27 19:44:27', '2022-07-28 11:14:41', NULL, NULL, '2022-07-27 14:14:27', '2022-07-28 05:44:41'),
(69, '4', '2022-07-27', '2022-07-28 03:16:08', '2022-07-28 03:16:12', NULL, NULL, '2022-07-27 21:46:08', '2022-07-27 21:46:12'),
(70, '1', '2022-07-29', '2022-07-28 11:15:19', '2022-07-29 09:56:25', NULL, NULL, '2022-07-28 05:45:19', '2022-07-29 04:26:25'),
(71, '1', '2022-07-29', '2022-07-29 10:43:44', '2022-07-29 18:01:17', NULL, NULL, '2022-07-29 05:13:44', '2022-07-29 12:31:17'),
(72, '1', '2022-07-29', '2022-07-29 18:01:20', '2022-07-29 18:01:40', NULL, NULL, '2022-07-29 12:31:20', '2022-07-29 12:31:40'),
(73, '1', '2022-07-29', '2022-07-29 18:01:41', '2022-07-29 18:02:02', NULL, NULL, '2022-07-29 12:31:41', '2022-07-29 12:32:02'),
(74, '1', '2022-08-03', '2022-07-29 18:02:14', '2022-08-03 16:17:10', NULL, NULL, '2022-07-29 12:32:14', '2022-08-03 10:47:10'),
(75, '1', '2022-08-03', '2022-08-03 16:17:12', '2022-08-03 17:11:14', NULL, NULL, '2022-08-03 10:47:12', '2022-08-03 11:41:14'),
(76, '1', '2022-08-06', '2022-08-03 17:11:19', '2022-08-06 11:35:33', NULL, NULL, '2022-08-03 11:41:19', '2022-08-06 06:05:33'),
(77, '1', '2022-08-06', '2022-08-06 11:35:36', '2022-08-06 11:35:41', NULL, NULL, '2022-08-06 06:05:36', '2022-08-06 06:05:41'),
(78, '1', '2022-08-16', '2022-08-06 15:32:14', '2022-08-17 00:43:14', NULL, NULL, '2022-08-06 10:02:14', '2022-08-16 13:43:14'),
(79, '1', '2022-08-16', '2022-08-17 00:44:40', '2022-08-17 00:44:42', NULL, NULL, '2022-08-16 13:44:40', '2022-08-16 13:44:42'),
(80, '1', '2022-08-16', '2022-08-17 00:49:02', '2022-08-17 01:42:17', NULL, NULL, '2022-08-16 13:49:02', '2022-08-16 14:42:17'),
(81, '1', '2022-08-16', '2022-08-17 01:44:24', '2022-08-17 01:44:29', NULL, NULL, '2022-08-16 14:44:24', '2022-08-16 14:44:29'),
(82, '1', '2022-08-16', '2022-08-17 01:44:38', '2022-08-17 01:44:46', NULL, NULL, '2022-08-16 14:44:38', '2022-08-16 14:44:46'),
(83, '1', '2022-08-16', '2022-08-17 01:45:29', '2022-08-17 01:45:32', NULL, NULL, '2022-08-16 14:45:29', '2022-08-16 14:45:32'),
(84, '1', '2022-08-16', '2022-08-17 01:45:51', '2022-08-17 01:46:00', NULL, NULL, '2022-08-16 14:45:51', '2022-08-16 14:46:00'),
(85, '1', '2022-08-16', '2022-08-17 01:46:36', '2022-08-17 01:46:45', NULL, NULL, '2022-08-16 14:46:36', '2022-08-16 14:46:45'),
(86, '1', '2022-08-16', '2022-08-17 01:48:55', '2022-08-17 01:49:04', NULL, NULL, '2022-08-16 14:48:55', '2022-08-16 14:49:04'),
(87, '1', '2022-08-16', '2022-08-17 01:49:16', '2022-08-17 01:49:20', NULL, NULL, '2022-08-16 14:49:16', '2022-08-16 14:49:20'),
(88, '1', '2022-08-16', '2022-08-17 01:49:38', '2022-08-17 01:49:42', NULL, NULL, '2022-08-16 14:49:38', '2022-08-16 14:49:42'),
(89, '1', '2022-08-16', '2022-08-17 01:49:47', '2022-08-17 01:49:51', NULL, NULL, '2022-08-16 14:49:47', '2022-08-16 14:49:51'),
(90, '1', '2022-08-16', '2022-08-17 01:50:11', '2022-08-17 01:51:43', NULL, NULL, '2022-08-16 14:50:11', '2022-08-16 14:51:43'),
(91, '1', '2022-08-16', '2022-08-17 01:51:45', '2022-08-17 01:54:27', NULL, NULL, '2022-08-16 14:51:45', '2022-08-16 14:54:27'),
(92, '1', '2022-08-16', '2022-08-17 01:54:30', '2022-08-17 01:54:33', NULL, NULL, '2022-08-16 14:54:30', '2022-08-16 14:54:33'),
(93, '1', '2022-08-16', '2022-08-17 02:29:00', NULL, NULL, NULL, '2022-08-16 15:29:00', '2022-08-16 15:29:00');

-- --------------------------------------------------------

--
-- Table structure for table `vmt_employee_compensatory_details`
--

CREATE TABLE `vmt_employee_compensatory_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `basic` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hra` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Statutory_bonus` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `child_education_allowance` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `food_coupon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lta` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `special_allowance` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_allowance` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gross` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `epf_employer_contribution` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `esic_employer_contribution` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `insurance` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `graduity` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cic` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `epf_employee` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `esic_employee` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `professional_tax` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `labour_welfare_fund` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `net_income` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vmt_employee_compensatory_details`
--

INSERT INTO `vmt_employee_compensatory_details` (`id`, `user_id`, `basic`, `hra`, `Statutory_bonus`, `child_education_allowance`, `food_coupon`, `lta`, `special_allowance`, `other_allowance`, `gross`, `epf_employer_contribution`, `esic_employer_contribution`, `insurance`, `graduity`, `cic`, `epf_employee`, `esic_employee`, `professional_tax`, `labour_welfare_fund`, `net_income`, `created_at`, `updated_at`) VALUES
(1, 88, '65000', '330', '390', '2344', '70', '44', '70', '77', '68325', '4', '6', '44', '55', '68434', '22', '99', '100', '55', '68492', '2022-07-11 12:49:05', '2022-07-11 12:49:05'),
(2, 89, '50000', '1000', '100', '100', '1000', '100', '100', '100', '52500', '100', '100', '1001', '100', '53801', '100', '100', '100', '100', '51599', '2022-07-11 19:00:21', '2022-07-11 19:00:21'),
(3, 90, '50000', '1000', '100', '100', '1000', '100', '100', '100', '52500', '100', '100', '1001', '100', '53801', '100', '100', '100', '100', '51599', '2022-07-11 19:04:57', '2022-07-11 19:04:57'),
(4, 91, '60000', '1000', '100', '100', '100', '100', '100', '100', '61600', '100', '100', '100', '100', '62000', '100', '100', '100', '100', '61600', '2022-07-11 19:13:02', '2022-07-11 19:13:02'),
(5, 92, '55000', '50', '700', '50', '60', '70', '80', '90', '56100', '55', '400', '700', '55', '57310', '22', '66', '77', '99', '55154', '2022-07-12 04:55:15', '2022-07-12 04:55:15'),
(6, 93, '230000', '20', '30', '12', '12', '1', '11111111', '1111', '11342297', '11', '11', '11', '11', '11342341', '11', '11', '1', '11', '11342287', '2022-07-16 10:51:55', '2022-07-16 10:51:55'),
(7, 96, '230000', '20', '30', '12', '12', '1', '11111111', '1111', '11342297', '11', '11', '11', '11', '11342341', '11', '11', '1', '11', '11342287', '2022-07-16 10:53:48', '2022-07-16 10:53:48'),
(8, 98, '230000', '20', '30', '12', '12', '1', '11111111', '1111', '11342297', '11', '11', '11', '11', '11342341', '11', '11', '1', '11', '11342287', '2022-07-16 11:01:47', '2022-07-16 11:01:47'),
(9, 99, '230000', '20', '30', '12', '12', '1', '11111111', '1111', '11342297', '11', '11', '11', '11', '11342341', '11', '11', '1', '11', '11342287', '2022-07-16 11:04:51', '2022-07-16 11:04:51'),
(10, 101, '50000', '4000', '56', '666', '899', '455', '566', '565', '57207', '5654', '344', '654', '45', '63904', '65', '1000', '533', '3434', '55542', '2022-07-20 08:52:27', '2022-07-20 08:52:27'),
(11, 105, '50000', '4000', '56', '666', '899', '455', '566', '565', '57207', '5654', '344', '654', '45', '63904', '65', '1000', '533', '3434', '55542', '2022-07-20 08:55:23', '2022-07-20 08:55:23'),
(12, 107, '50000', '899', '900', '100', '200', '500', '800', '700', '54099', '100', '444', '333', '88', '55064', '999', '373', '239', '393', '55138', '2022-07-20 14:00:36', '2022-07-20 14:00:36'),
(13, 108, '12000', '2000', '1000', '120', '100', '120', '120', '120', '15580', '100', '100', '100', '100', '15980', '100', '200', '100', '100', '16280', '2022-07-27 12:10:00', '2022-07-27 12:10:00'),
(14, 109, '12000', '2000', '1000', '120', '100', '120', '120', '120', '15580', '100', '100', '100', '100', '15980', '100', '200', '100', '100', '16280', '2022-07-27 12:10:01', '2022-07-27 12:10:01'),
(15, 110, '12000', '2000', '1000', '120', '100', '120', '120', '120', '15580', '100', '100', '100', '100', '15980', '100', '200', '100', '100', '16280', '2022-07-27 19:39:39', '2022-07-27 19:39:39'),
(16, 111, '12000', '2000', '1000', '120', '100', '120', '120', '120', '15580', '100', '100', '100', '100', '15980', '100', '200', '100', '100', '16280', '2022-07-27 19:39:40', '2022-07-27 19:39:40'),
(17, 112, '60000', '8989', '689', '767', '897', '776', '676', '667', '73461', '676', '676', '677', '7667', '83157', '7667', '6777', '6767', '6777', '91753', '2022-07-28 10:12:36', '2022-07-28 10:12:36'),
(18, 113, '12000', '2000', '1000', '120', '100', '120', '120', '120', '15580', '100', '100', '100', '100', '15980', '100', '200', '100', '100', '16280', '2022-07-28 10:54:19', '2022-07-28 10:54:19'),
(19, 114, '30000', '2343', '1000', '120', '100', '888', '887', '778', '36116', '87', '87', '878', '878', '38046', '877', '788', '788', '878', '41203', '2022-07-28 11:06:44', '2022-07-28 11:06:44'),
(20, 115, '70000', '7787', '777', '777', '766', '567', '766', '765', '82205', '7656', '657', '67', '76', '90661', '56', '67', '76', '656', '76204', '2022-07-28 11:06:45', '2022-07-28 11:06:45'),
(21, 116, '12000', '2000', '1000', '120', '100', '120', '120', '120', '15580', '100', '100', '100', '100', '15980', '100', '200', '100', '100', '16280', '2022-08-10 12:30:43', '2022-08-10 12:30:43'),
(22, 117, '12000', '2000', '1000', '120', '100', '120', '120', '120', '15580', '100', '100', '100', '100', '15980', '100', '200', '100', '100', '16280', '2022-08-10 12:31:11', '2022-08-10 12:31:11'),
(23, 118, '12000', '2000', '1000', '120', '100', '120', '120', '120', '15580', '100', '100', '100', '100', '15980', '100', '200', '100', '100', '16280', '2022-08-10 12:33:01', '2022-08-10 12:33:01'),
(24, 119, '12000', '2000', '1000', '120', '100', '120', '120', '120', '15580', '100', '100', '100', '100', '15980', '100', '200', '100', '100', '16280', '2022-08-10 12:36:22', '2022-08-10 12:36:22'),
(25, 120, '12000', '2000', '1000', '120', '100', '120', '120', '120', '15580', '100', '100', '100', '100', '15980', '100', '200', '100', '100', '16280', '2022-08-10 12:39:38', '2022-08-10 12:39:38');

-- --------------------------------------------------------

--
-- Table structure for table `vmt_employee_details`
--

CREATE TABLE `vmt_employee_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `emp_no` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doj` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dol` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_number` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_ack` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhar_number` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `epf_number` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `esic_number` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marrital_status` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `basic` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hra` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `child_edu_allowance` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spl_alw` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_fixed_gross` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `epfemployer` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `esicemployer` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ctc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `epfemployee` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `esicemployee` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pt` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `net` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `esic_applicability` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_number` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_ifsc_code` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_number` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `present_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permanent_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_age` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_age` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spouse_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spouse_age` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kid_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kid_age` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhar_card_file` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhar_card_backend_file` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_card_file` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passport_file` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voters_id_file` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dl_file` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `education_certificate_file` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reliving_letter_file` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `blood_group` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `children` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passport_date` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passport_number` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience_json` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `family_info_json` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_json` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vmt_employee_details`
--

INSERT INTO `vmt_employee_details` (`id`, `userid`, `emp_no`, `gender`, `status`, `doj`, `dol`, `location`, `dob`, `father_name`, `pan_number`, `pan_ack`, `aadhar_number`, `uan`, `epf_number`, `esic_number`, `marrital_status`, `basic`, `hra`, `child_edu_allowance`, `spl_alw`, `total_fixed_gross`, `epfemployer`, `esicemployer`, `ctc`, `epfemployee`, `esicemployee`, `pt`, `net`, `esic_applicability`, `mobile_number`, `bank_name`, `bank_ifsc_code`, `bank_account_number`, `present_address`, `permanent_address`, `father_age`, `mother_name`, `mother_age`, `spouse_name`, `spouse_age`, `kid_name`, `kid_age`, `aadhar_card_file`, `aadhar_card_backend_file`, `pan_card_file`, `passport_file`, `voters_id_file`, `dl_file`, `education_certificate_file`, `reliving_letter_file`, `created_at`, `updated_at`, `blood_group`, `children`, `religion`, `nationality`, `passport_date`, `passport_number`, `experience_json`, `family_info_json`, `contact_json`) VALUES
(1, 1, 'EMP100', NULL, NULL, '2022-06-02', '2022-06-02', 'asdf', '2022-06-30', 'Arr', 'BTEPP0598R', NULL, '223412341234', NULL, NULL, NULL, 'Select', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9384604063', 'ASSAM GRAMIN VIKASH BANK', '3423', '2525', 'asdf', 'asdf', NULL, 'jjj', NULL, 'asd', '2022-05-31', 'a', '2022-06-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-06-29 16:33:53', '2022-07-30 06:19:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 2, 'Vasa102', NULL, NULL, '2022-06-02', '2022-06-02', 'asdf', '2022-06-30', 'Arr', 'BTEPP0598R', NULL, '223412341234', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9999999998', 'asdfadsf', '3423', '123412341234', 'asdf', 'asdf', NULL, 'jjj', NULL, 'asd', '2022-05-31', 'a', '2022-06-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-06-29 16:33:53', '2022-07-25 04:31:13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 3, 'Vasa103', 'male', NULL, '2022-06-02', '2022-06-02', 'asdf', '2022-06-30', 'Arr', 'BTEPP0598R', NULL, '223412341234', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9999999999', 'asdfadsf', '3423', '123412341234', 'asdf', 'asdf', NULL, 'jjj', NULL, 'asd', '2022-05-31', 'a', '2022-06-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-06-29 16:33:53', '2022-06-29 16:33:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 4, 'Vasa104', 'Male', 'ACTIVE', '44652', NULL, 'CHENNAI', '35525', 'S.Martin Charles', 'GASPM9000E', NULL, '283110730101', '101803791305', 'TNAMB24340250000010093', '5133163873', 'Select', '9000', '4500', '200', '1300', '=SUM(S96:V96)', '=IF(W96-T96>15000,15000*12%,(W96-T96)*12%)', '=ROUND(IF(W96<=21000,W96*3.25%,0),0)', '=SUM(W96:Y96)', '=IF(W96-T96>15000,15000*12%,(W96-T96)*12%)', '=ROUND(IF(W96<=21000,Z96*0.75%,0),0)', '208', '=W96-AA96-AB96-AC96', '=IF(W96>21000,\"NO\",\"YES\")', '9698944302', 'ANDHRA BANK', 'SBIN0003373', '20287210068', 'Dunamis machines,Edappalayam,Red Hills, Chennai', 'Velankanni puram,chetriya patti(po),attur(tk),Dindigul (dt)-624302', '04/04/1975', 'M.Mariya Arockiyammmal', '04/05/1978', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-06-08 23:01:59', '2022-07-25 14:26:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 5, 'Vasa105', 'male', NULL, '2022-06-02', '2022-06-02', 'asdf', '2022-06-30', 'Arr', 'BTEPP0598R', NULL, '223412341234', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9999999999', 'asdfadsf', '3423', '123412341234', 'asdf', 'asdf', NULL, 'jjj', NULL, 'asd', '2022-05-31', 'a', '2022-06-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-06-29 16:33:53', '2022-06-29 16:33:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 6, 'Vasa106', 'male', NULL, '2022-06-02', '2022-06-02', 'asdf', '2022-06-30', 'Arr', 'BTEPP0598R', NULL, '223412341234', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9999999999', 'asdfadsf', '3423', '123412341234', 'asdf', 'asdf', NULL, 'jjj', NULL, 'asd', '2022-05-31', 'a', '2022-06-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-06-29 16:33:53', '2022-06-29 16:33:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(106, 35, 'Vasa8', 'male', NULL, '2021-10-27', '2021-10-27', 'chennai', '1989-06-13', 'Tom', 'BREPP0698R', NULL, '223412341234', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7483747473', 'Indian Bank', 'IB76587', '9987554446', 'pillayar kovil street', 'pillayar kovil street', NULL, 'Jerry', NULL, 'Spike', '1987-07-09', 'gddg,uuuu,bbb', '2019-06-20', 'doc_1657009777.png', NULL, 'doc_1657009777.png', 'doc_1657009777.png', 'doc_1657009777.png', 'doc_1657009777.png', 'doc_1657009777.png', 'doc_1657009777.png', '2022-07-05 08:29:37', '2022-07-05 08:29:37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(107, 88, 'VASA107', 'male', NULL, '2022-07-20', '2022-07-20', 'CHENNAI', '2003-08-19', 'TOM', 'BREPP0698R', NULL, '693858584838', NULL, NULL, NULL, 'single', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9284768483', 'BANK OF INDIA', 'IDIB0000218', '948383838385738', 'NEHRU STREET', 'NEHRU STREET', NULL, 'BEN', NULL, NULL, NULL, NULL, NULL, 'doc_1657543745.png', NULL, 'doc_1657543745.png', 'doc_1657543745.png', 'doc_1657543745.png', 'doc_1657543745.png', 'doc_1657543745.png', 'doc_1657543745.png', '2022-07-11 12:49:05', '2022-07-11 12:49:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(108, 89, 'VASA108', 'male', NULL, '2022-07-01', '2022-07-01', 'ASDF', '2004-07-01', 'ASDF', 'BREPP0698R', NULL, '223412341234', NULL, NULL, NULL, 'single', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9999988888', 'CENTRAL BANK OF INDIA', 'BKID0008213', '1231231232', 'ASDF', 'ASDF', NULL, 'ASDF', NULL, NULL, NULL, NULL, NULL, 'doc_1657566021.jpg', 'doc_1657566021.jpg', 'doc_1657566021.jpg', 'doc_1657566021.jpg', 'doc_1657566021.jpg', 'doc_1657566021.jpg', 'doc_1657566021.jpg', 'doc_1657566021.jpg', '2022-07-11 19:00:21', '2022-07-11 19:00:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(109, 90, 'VASA108', 'male', NULL, '2022-07-01', '2022-07-01', 'ASDF', '2004-07-01', 'ASDF', 'BREPP0698R', NULL, '223412341234', NULL, NULL, NULL, 'single', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9999988888', 'CENTRAL BANK OF INDIA', 'BKID0008213', '1231231232', 'ASDF', 'ASDF', NULL, 'ASDF', NULL, NULL, NULL, NULL, NULL, 'doc_1657566297.jpg', 'doc_1657566297.jpg', 'doc_1657566297.jpg', 'doc_1657566297.jpg', 'doc_1657566297.jpg', 'doc_1657566297.jpg', 'doc_1657566297.jpg', 'doc_1657566297.jpg', '2022-07-11 19:04:57', '2022-07-11 19:04:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(110, 91, 'VASA110', 'male', NULL, '2022-07-12', '2022-07-12', 'ASDF', '2004-07-01', 'ASDF', 'BREPP0698R', NULL, '223412341234', NULL, NULL, NULL, 'married', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9999988888', 'CENTRAL BANK OF INDIA', 'BKID0008213', '1234123434', 'ASDF', 'ASDF', NULL, 'ASDF', NULL, 'FFFF', '2022-07-13', '[\"c1\",\"c2\"]', '[\"2022-07-12\",\"2022-07-13\"]', 'doc_1657566782.png', 'doc_1657566782.png', 'doc_1657566782.png', 'doc_1657566782.png', 'doc_1657566782.png', 'doc_1657566782.png', 'doc_1657566782.png', 'doc_1657566782.png', '2022-07-11 19:13:02', '2022-07-11 19:13:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(111, 92, 'VASA111', 'male', NULL, '2022-07-07', '2022-07-07', 'CHENNAI', '2003-06-23', 'TOM', 'BREPP0698R', NULL, '457535789746', NULL, NULL, NULL, 'single', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '8635689533', 'INDIAN BANK', 'IDIB0005389', '636863577', 'BHARATHIYAR NAGAR', 'BHARATHIYAR NAGAR', NULL, 'JERRY', NULL, NULL, NULL, NULL, NULL, 'doc_1657601715.png', NULL, 'doc_1657601715.png', 'doc_1657601715.png', 'doc_1657601715.png', 'doc_1657601715.png', 'doc_1657601715.png', 'doc_1657601715.png', '2022-07-12 04:55:15', '2022-07-12 04:55:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(112, 93, 'VASA112', 'male', NULL, '2022-07-16', '2022-07-16', 'CHENNAI', '2022-07-16', 'TEST', '', 'BREPP0698R', '223412341234', NULL, NULL, NULL, 'single', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '8248375355', NULL, NULL, NULL, 'CHENNAI', 'CHENNAI', NULL, 'TEST', NULL, NULL, NULL, NULL, NULL, 'doc_1657968715.png', NULL, 'doc_1657968715.png', 'doc_1657968715.png', NULL, NULL, 'doc_1657968715.png', NULL, '2022-07-16 10:51:55', '2022-07-16 10:51:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(113, 96, 'VASA112', 'male', NULL, '2022-07-16', '2022-07-16', 'CHENNAI', '2022-07-16', 'TEST', '', 'BREPP0698R', '223412341234', NULL, NULL, NULL, 'single', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '8248375355', 'BANK OF BARODA', 'BKID0008213', '23245258565666', 'CHENNAI', 'CHENNAI', NULL, 'TEST', NULL, NULL, NULL, NULL, NULL, 'doc_1657968828.png', NULL, 'doc_1657968828.png', 'doc_1657968828.png', NULL, NULL, 'doc_1657968828.png', NULL, '2022-07-16 10:53:48', '2022-07-16 10:53:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(114, 98, 'VASA112', 'male', NULL, '2022-07-16', '2022-07-16', 'CHENNAI', '2022-07-16', 'TEST', '', 'BREPP0698R', '223412341234', NULL, NULL, NULL, 'single', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '8248375355', 'BANK OF BARODA', 'BKID0008213', '23245258565666', 'CHENNAI', 'CHENNAI', NULL, 'TEST', NULL, NULL, NULL, NULL, NULL, 'doc_1657969307.png', NULL, 'doc_1657969307.png', 'doc_1657969307.png', NULL, NULL, 'doc_1657969307.png', NULL, '2022-07-16 11:01:47', '2022-07-16 11:01:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(115, 99, 'VASA112', 'male', NULL, '2022-07-16', '2022-07-16', 'CHENNAI', '2022-07-16', 'TEST', '', 'BREPP0698R', '223412341234', NULL, NULL, NULL, 'single', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '8248375355', 'BANK OF BARODA', 'BKID0008213', '23245258565666', 'CHENNAI', 'CHENNAI', NULL, 'TEST', NULL, NULL, NULL, NULL, NULL, 'doc_1657969491.png', NULL, 'doc_1657969491.png', 'doc_1657969491.png', 'doc_1657969491.png', 'doc_1657969491.png', 'doc_1657969491.png', 'doc_1657969491.png', '2022-07-16 11:04:51', '2022-07-16 11:04:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(116, 100, 'VASA116', 'male', NULL, '2022-07-14', '2022-07-14', NULL, '2022-07-14', NULL, 'AUJPA5100C', NULL, '763768745831', NULL, NULL, NULL, 'single', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9999999999', NULL, 'ICIC0000009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-07-16 11:57:14', '2022-07-16 11:57:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(117, 101, 'VASA117', 'male', NULL, '2022-07-13', '2022-07-13', 'CHENNAI', '2001-12-06', 'HJH', 'BREPP0698R', NULL, '223412341234', NULL, NULL, NULL, 'single', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '8965465456', 'INDIAN BANK', 'IDIB000A009', '586949486', 'BHARATHIYAR NAGAR,', 'BHARATHIYAR NAGAR, VIRALIMALAI ROAD', NULL, 'NBK', NULL, NULL, NULL, NULL, NULL, 'doc_1658307147.jpg', NULL, 'doc_1658307147.png', 'doc_1658307147.png', 'doc_1658307147.png', 'doc_1658307147.png', 'doc_1658307147.jpeg', 'doc_1658307147.png', '2022-07-20 08:52:27', '2022-07-20 08:52:27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(118, 105, 'VASA117', 'male', NULL, '2022-07-13', '2022-07-13', 'CHENNAI', '2001-12-06', 'HJH', 'BREPP0698R', NULL, '223412341234', NULL, NULL, NULL, 'single', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '8965465456', 'INDIAN BANK', 'IDIB000A009', '586949486', 'BHARATHIYAR NAGAR,', 'BHARATHIYAR NAGAR, VIRALIMALAI ROAD', NULL, 'NBK', NULL, NULL, NULL, NULL, NULL, 'doc_1658307323.jpg', 'doc_1658307323.png', 'doc_1658307323.png', 'doc_1658307323.png', 'doc_1658307323.png', 'doc_1658307323.png', 'doc_1658307323.jpeg', 'doc_1658307323.png', '2022-07-20 08:55:23', '2022-07-20 08:55:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(119, 107, 'VASA119', 'male', NULL, '2022-07-05', '2022-07-05', 'CHENNAI', '2000-02-01', 'HJH', 'BREPP0698R', NULL, '223412341234', NULL, NULL, NULL, 'single', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9384848383', 'INDIAN BANK', 'IDIB000A009', '837373737', 'BHARATHIYAR NAGAR', 'BHARATHIYAR NAGAR, VIRALIMALAI ROAD', NULL, 'NBK', NULL, NULL, NULL, NULL, NULL, 'doc_1658325636.jpg', 'doc_1658325636.png', 'doc_1658325636.png', 'doc_1658325636.png', 'doc_1658325636.png', 'doc_1658325636.png', 'doc_1658325636.png', 'doc_1658325636.png', '2022-07-20 14:00:36', '2022-07-20 14:00:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(120, 108, 'Vasa120', NULL, NULL, '1970-01-01', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-07-27 12:10:00', '2022-07-27 12:10:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(121, 109, 'Vasa121', NULL, NULL, '1970-01-01', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-07-27 12:10:01', '2022-07-27 12:10:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(122, 110, 'Vasa122', NULL, NULL, '1970-01-01', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-07-27 19:39:39', '2022-07-27 19:39:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(123, 111, 'Vasa123', NULL, NULL, '1970-01-01', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-07-27 19:39:40', '2022-07-27 19:39:40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(124, 112, 'VASA124', 'male', NULL, '2022-07-30', '2022-07-30', 'CHENNAI', '2001-06-04', 'EJKB', 'BREPP0698R', NULL, '223412341234', NULL, NULL, NULL, 'single', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '8866654655', 'ASSAM GRAMIN VIKASH BANK', 'IDIB000M121', '1234567898778', 'CHENNAI', 'CHENNAI', NULL, 'JKBK', NULL, NULL, NULL, NULL, NULL, 'doc_1659003156.jpg', 'doc_1659003156.jpg', 'doc_1659003156.jpg', 'doc_1659003156.jpg', 'doc_1659003156.png', 'doc_1659003156.png', 'doc_1659003156.jpg', 'doc_1659003156.jpg', '2022-07-28 10:12:36', '2022-07-28 10:12:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(125, 113, 'Vasa125', 'male', NULL, '1970-01-01', '1970-01-01', 'Chennai', '1970-01-01', 'Test', 'ABCPE0123F', NULL, '987878888888', NULL, NULL, NULL, 'single', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '186713737', 'IOB', 'IFSC0123456', '1289945287', 'test', 'test', NULL, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-07-28 10:54:19', '2022-07-28 10:54:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(126, 114, 'Vasa126', NULL, NULL, '1970-01-01', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-07-28 11:06:44', '2022-07-28 11:06:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(127, 115, 'Vasa127', NULL, NULL, '1970-01-01', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Select', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '58585858', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-07-28 11:06:45', '2022-07-28 11:44:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(128, 116, 'Demo128', NULL, NULL, '1970-01-01', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-10 12:30:42', '2022-08-10 12:30:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(129, 117, 'Demo129', NULL, NULL, '1970-01-01', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-10 12:31:11', '2022-08-10 12:31:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(130, 118, 'Demo130', NULL, NULL, '1970-01-01', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-10 12:33:01', '2022-08-10 12:33:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(131, 119, 'Demo131', NULL, NULL, '1970-01-01', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-10 12:36:22', '2022-08-10 12:36:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(132, 120, 'Demo132', NULL, NULL, '1970-01-01', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-10 12:39:37', '2022-08-10 12:39:37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vmt_employee_experiences`
--

CREATE TABLE `vmt_employee_experiences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_position` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `period_from` date NOT NULL,
  `period_to` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vmt_employee_experiences`
--

INSERT INTO `vmt_employee_experiences` (`id`, `emp_id`, `user_id`, `company_name`, `location`, `job_position`, `period_from`, `period_to`, `created_at`, `updated_at`) VALUES
(1, '1', '1', 'wdwd', 'wdwdw232323', 'wdwd', '2022-07-19', '2022-07-30', '2022-07-19 10:45:20', '2022-07-19 10:45:20'),
(2, '4', '4', 'sdfasdf', 'dfsdf', 'sdfsdf', '2022-07-12', '2022-07-05', '2022-07-25 14:25:54', '2022-07-25 14:25:54'),
(3, '1', '1', 'hfhfyjhvhj', 'dfsefsfsf', 'sefesfes', '2022-07-13', '2022-07-29', '2022-07-26 08:17:28', '2022-07-26 08:17:28'),
(4, '1', '1', 'Sff', 'Ddd', 'Xgg', '2022-07-26', '2022-07-29', '2022-07-26 16:20:36', '2022-07-26 16:20:36'),
(5, '1', '1', 'Ddd', 'Dcc', 'Dcf', '2022-07-26', '2022-07-26', '2022-07-26 16:20:36', '2022-07-26 16:20:36');

-- --------------------------------------------------------

--
-- Table structure for table `vmt_employee_hierarchies`
--

CREATE TABLE `vmt_employee_hierarchies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `child_count` smallint(6) NOT NULL,
  `child_nodes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vmt_employee_hierarchies`
--

INSERT INTO `vmt_employee_hierarchies` (`id`, `user_id`, `parent_id`, `child_count`, `child_nodes`, `created_at`, `updated_at`) VALUES
(35, 1, NULL, 3, '6', '2022-05-27 12:37:19', '2022-05-27 12:37:19'),
(36, 1, NULL, 3, '5', '2022-05-27 12:37:19', '2022-05-27 12:37:19'),
(37, 1, NULL, 3, '4', '2022-05-27 12:37:19', '2022-05-27 12:37:19');

-- --------------------------------------------------------

--
-- Table structure for table `vmt_employee_office_details`
--

CREATE TABLE `vmt_employee_office_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_id` int(11) NOT NULL,
  `user_id` int(5) NOT NULL,
  `department_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost_center` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmation_period` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `holiday_location` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `l1_manager_code` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `l1_manager_designation` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `l1_manager_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `l2_manager_code` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `l2_manager_designation` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `l2_manager_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `l3_manager_code` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `l3_manager_designation` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `l3_manager_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `l4_manager_code` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `l4_manager_designation` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `l4_manager_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_location` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `officical_mail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `official_mobile` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_notice` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vmt_employee_office_details`
--

INSERT INTO `vmt_employee_office_details` (`id`, `emp_id`, `user_id`, `department_id`, `process`, `designation`, `cost_center`, `confirmation_period`, `holiday_location`, `l1_manager_code`, `l1_manager_designation`, `l1_manager_name`, `l2_manager_code`, `l2_manager_designation`, `l2_manager_name`, `l3_manager_code`, `l3_manager_designation`, `l3_manager_name`, `l4_manager_code`, `l4_manager_designation`, `l4_manager_name`, `work_location`, `officical_mail`, `official_mobile`, `emp_notice`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'IT', 'asdf', 'Admin', 'asdf', 'asdf', 'asdf', '', 'Manager', 'Mgr Srini', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'com.java.praveen@gmail.com', '9999999999', '3', '2022-06-29 16:34:57', '2022-07-20 08:40:55'),
(2, 2, 2, 'IT', 'asdf', 'Manager', 'asdf', 'asdf', 'asdf', 'EMP100', 'Admin', 'HR Augustin', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'voidmaxtech@gmail.com', '9999999999', '3', '2022-06-29 16:34:57', '2022-07-25 04:31:13'),
(3, 3, 3, 'IT', 'asdf', 'Manager', 'asdf', 'asdf', 'asdf', 'EMP100', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'srinivasan9841@gmail.com', '9999999999', '3', '2022-06-29 16:34:57', '2022-06-29 16:34:57'),
(4, 4, 4, 'IT', 'asdf', 'Employee', 'asdf', 'asdf', 'asdf', 'Vasa102', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'praveenkumar.techdev@gmail.com', '9999999999', '3', '2022-06-29 16:30:18', '2022-06-29 16:30:18'),
(5, 5, 5, 'IT', 'asdf', 'Employee', 'asdf', 'asdf', 'asdf', 'Vasa102', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'srinivasan9841@gmail.com', '9999999999', '3', '2022-06-29 16:34:57', '2022-06-29 16:34:57'),
(6, 6, 6, 'IT', 'asdf', 'Employee', 'asdf', 'asdf', 'asdf', 'Vasa103', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'emp_vijay@vasagroup.abshrms.com', '9999999999', '3', '2022-06-29 16:34:57', '2022-06-29 16:34:57'),
(7, 7, 7, 'IT', 'asdf', 'Hr', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'sa_ardens@vasagroup.abshrms.com', '9999999999', '3', '2022-06-29 16:30:18', '2022-06-29 16:30:18'),
(45, 106, 35, 'cse', 'jg', 'Manager', 'OMR', '22days', 'kerala', '1237', 'dhd', 'Raju', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'chennai', 'vijayaraja231216@gmail.com', '8282822828', '12', '2022-07-05 08:29:37', '2022-07-05 08:29:37'),
(46, 107, 88, 'IT', 'asdf', 'EMP', 'CHENNAI', '5', 'JAIPUR', 'FGJSK', NULL, 'BOB', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'CHENNAI', 'VIJAYARAJA231216@GMAIL.COM', '9284768483', '2', '2022-07-11 12:49:05', '2022-07-11 12:49:05'),
(47, 108, 89, 'IT', 'asdf', 'SDF', 'SDF', '5', 'SADF', 'DF', NULL, 'ASDF', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ASDF', 'PRAVEENKUMAR.ARJUNAN@GMAIL.COM', '9999988888', '30', '2022-07-11 19:00:21', '2022-07-11 19:00:21'),
(48, 109, 90, 'IT', 'asdf', 'SDF', 'SDF', '5', 'SADF', 'DF', NULL, 'ASDF', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ASDF', 'PRAVEENKUMAR.ARJUNAN@GMAIL.COM', '9999988888', '30', '2022-07-11 19:04:57', '2022-07-11 19:04:57'),
(49, 110, 91, 'IT', 'asdf', 'ASDF', 'ASDF', '2', 'ASDF', 'ASDF', NULL, 'ASDF', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ASDF', 'PRAVEENKUMAR.ARJUNAN@GMAIL.COM', '9999988888', '10', '2022-07-11 19:13:02', '2022-07-11 19:13:02'),
(50, 111, 92, 'IT', 'asdf', 'EMP', 'CHENNAI', '4', 'AUSTRALIA', 'HRDH', NULL, 'RAJ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'CHENNAI', 'VIJAYARAJA2312@GMAIL.COM', '8635689533', '6', '2022-07-12 04:55:15', '2022-07-12 04:55:15'),
(51, 112, 93, 'IT', 'asdf', '1', '1', '1', 'CODE123', 'CODE123', NULL, 'CODE123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'CHENNAI', 'CODE123@GMAIL.COM', '8987512684', '3', '2022-07-16 10:51:55', '2022-07-16 10:51:55'),
(52, 113, 96, 'IT', 'asdf', '1', '1', '1', 'CODE123', 'CODE123', NULL, 'CODE123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'CHENNAI', 'CODE123@GMAIL.COM', '8987512684', '3', '2022-07-16 10:53:48', '2022-07-16 10:53:48'),
(53, 114, 98, 'IT', 'asdf', '1', '1', '1', 'CODE123', 'CODE123', NULL, 'CODE123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'CHENNAI', 'CODE123@GMAIL.COM', '8987512684', '3', '2022-07-16 11:01:47', '2022-07-16 11:01:47'),
(54, 115, 99, 'IT', 'asdf', '1', '1', '1', 'CODE123', 'CODE123', NULL, 'CODE123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'CHENNAI', 'CODE123@GMAIL.COM', '8987512684', '3', '2022-07-16 11:04:51', '2022-07-16 11:04:51'),
(55, 116, 100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-07-16 11:57:14', '2022-07-16 11:57:14'),
(56, 117, 101, 'IT', 'asdf', 'JGH', 'GNHBB8', '1', 'KERALA', 'MG', NULL, 'RAJU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'CHENNAI', 'VIJAYARAJA2312@GMAIL.COM', '8787567654', '7', '2022-07-20 08:52:27', '2022-07-20 08:52:27'),
(57, 118, 105, 'IT', 'asdf', 'JGH', 'GNHBB8', '1', 'KERALA', 'MG', NULL, 'RAJU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'CHENNAI', 'VIJAYARAJA231216@GMAIL.COM', '8787567654', '7', '2022-07-20 08:55:23', '2022-07-20 08:55:23'),
(58, 119, 107, 'IT', 'asdf', 'JGH', 'GNHBB', '2', 'KERALA', 'MG', NULL, 'RAJU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'CHENNAI', 'VIJAYARAJA2312@GMAIL.COM', '9273737373', '7', '2022-07-20 14:00:36', '2022-07-20 14:00:36'),
(59, 120, 108, NULL, NULL, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-07-27 12:10:00', '2022-07-27 12:10:00'),
(60, 121, 109, NULL, NULL, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-07-27 12:10:01', '2022-07-27 12:10:01'),
(61, 122, 110, NULL, NULL, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-07-27 19:39:39', '2022-07-27 19:39:39'),
(62, 123, 111, NULL, NULL, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-07-27 19:39:40', '2022-07-27 19:39:40'),
(63, 124, 112, 'IT', 'asdf', 'HJ', '6', '4', 'KER', 'GHH', NULL, 'VCG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'CHENNAI', 'VIJAYARAJA2312@GMIAL.COM', '8483838383', '8', '2022-07-28 10:12:36', '2022-07-28 10:12:36'),
(64, 125, 113, 'test', 'test', 'test', 'test', '1970-01-01', 'Chennai', 'VASA102', NULL, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Chennai', 'test@gmail.com', '1286608618', '2', '2022-07-28 10:54:19', '2022-07-28 10:54:19'),
(65, 126, 114, NULL, NULL, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-07-28 11:06:44', '2022-07-28 11:06:44'),
(66, 127, 115, NULL, NULL, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-07-28 11:06:45', '2022-07-28 11:06:45'),
(67, 128, 116, NULL, NULL, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-10 12:30:43', '2022-08-10 12:30:43'),
(68, 129, 117, NULL, NULL, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-10 12:31:11', '2022-08-10 12:31:11'),
(69, 130, 118, NULL, NULL, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-10 12:33:01', '2022-08-10 12:33:01'),
(70, 131, 119, NULL, NULL, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-10 12:36:22', '2022-08-10 12:36:22'),
(71, 132, 120, NULL, NULL, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-10 12:39:37', '2022-08-10 12:39:37');

-- --------------------------------------------------------

--
-- Table structure for table `vmt_employee_payslip`
--

CREATE TABLE `vmt_employee_payslip` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `EMP_NO` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `EMP_NAME` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Gender` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DESIGNATION` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DEPARTMENT` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DOJ` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `LOCATION` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DOB` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Father_Name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PAN_Number` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Aadhar_Number` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `UAN` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `EPF_Number` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ESIC_Number` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Bank_Name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Account_Number` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Bank_IFSC_Code` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PAYROLL_MONTH` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `BASIC` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `HRA` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CHILD_EDU_ALLOWANCE` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `SPL_ALW` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TOTAL_FIXED_GROSS` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `MONTH_DAYS` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Worked_Days` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Arrears_Days` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `LOP` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Earned_BASIC` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `BASIC_ARREAR` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Earned_HRA` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `HRA_ARREAR` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Earned_CHILD_EDU_ALLOWANCE` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CHILD_EDU_ALLOWANCE_ARREAR` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Earned_SPL_ALW` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `SPL_ALW_ARREAR` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Overtime` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TOTAL_EARNED_GROSS` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PF_WAGES` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PF_WAGES_ARREAR_EPFR` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `EPFR` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `EPFR_ARREAR` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `EDLI_CHARGES` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `EDLI_CHARGES_ARREARS` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PF_ADMIN_CHARGES` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PF_ADMIN_CHARGES_ARREARS` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `EMPLOYER_ESI` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Employer_LWF` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CTC` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `EPF_EE` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `EPF_EE_ARREAR` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `EMPLOYEE_ESIC` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PROF_TAX` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TDS` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `SAL_ADV` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CANTEEN_DEDN` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `OTHER_DEDUC` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `LWF` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TOTAL_DEDUCTIONS` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NET_TAKE_HOME` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Rupees` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `EL_Opn_Bal` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Availed_EL` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Balance_EL` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Rename` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Email` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Greetings` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vmt_employee_payslip`
--

INSERT INTO `vmt_employee_payslip` (`id`, `EMP_NO`, `user_id`, `EMP_NAME`, `Gender`, `DESIGNATION`, `DEPARTMENT`, `DOJ`, `LOCATION`, `DOB`, `Father_Name`, `PAN_Number`, `Aadhar_Number`, `UAN`, `EPF_Number`, `ESIC_Number`, `Bank_Name`, `Account_Number`, `Bank_IFSC_Code`, `PAYROLL_MONTH`, `BASIC`, `HRA`, `CHILD_EDU_ALLOWANCE`, `SPL_ALW`, `TOTAL_FIXED_GROSS`, `MONTH_DAYS`, `Worked_Days`, `Arrears_Days`, `LOP`, `Earned_BASIC`, `BASIC_ARREAR`, `Earned_HRA`, `HRA_ARREAR`, `Earned_CHILD_EDU_ALLOWANCE`, `CHILD_EDU_ALLOWANCE_ARREAR`, `Earned_SPL_ALW`, `SPL_ALW_ARREAR`, `Overtime`, `TOTAL_EARNED_GROSS`, `PF_WAGES`, `PF_WAGES_ARREAR_EPFR`, `EPFR`, `EPFR_ARREAR`, `EDLI_CHARGES`, `EDLI_CHARGES_ARREARS`, `PF_ADMIN_CHARGES`, `PF_ADMIN_CHARGES_ARREARS`, `EMPLOYER_ESI`, `Employer_LWF`, `CTC`, `EPF_EE`, `EPF_EE_ARREAR`, `EMPLOYEE_ESIC`, `PROF_TAX`, `TDS`, `SAL_ADV`, `CANTEEN_DEDN`, `OTHER_DEDUC`, `LWF`, `TOTAL_DEDUCTIONS`, `NET_TAKE_HOME`, `Rupees`, `EL_Opn_Bal`, `Availed_EL`, `Balance_EL`, `Rename`, `Email`, `Greetings`, `created_at`, `updated_at`) VALUES
(1, 'Vasa100', 1, 'HR Augustin', 'MALE', 'MANAGING DIRECTOR', 'NA', '44531', 'CHENNAI', '27677', 'AUGUSTIN', 'ANFPB2903B', '274172155880', '101771607810', 'TNAMB24340250000010049', 'Not Applicable', 'HDFC BANK', '50100233172698', 'HDFC0002064', 'Apr-22', '36000', '18000', '200', '5800', '60000', '30', '30', '0', '0', '36000', '0', '18000', '0', '200', '0', '5800', '0', '0', '60000', '15000', '0', '1800', '0', '75', '0', '75', '0', '0', '0', '61950', '1800', '0', '0', '208', '2990', '0', '210', '0', '0', '5208', '54792', 'Rupees Fifty Four Thousand Seven Hundred Ninety Two Only', '8.75', '0', '8.75', '=B2&\"_\"&C2&\"_\"&\"Payslip\"&\"_\"&S2', 'DOSS@DUNAMISMACHINES.CO.IN', '=\"Dear\"&\" \"&C2', '2022-07-12 16:42:40', '2022-07-12 16:42:40'),
(2, 'Vasa102', 2, 'Max Kumar', 'MALE', 'OPERATION HEAD', 'NA', '44531', 'CHENNAI', '29651', 'AUGUSTIN', 'DPNPS8104E', '264881744119', '101573946699', 'TNAMB24340250000010042', 'Not Applicable', 'HDFC BANK', '50100233173738', 'HDFC0002064', 'Apr-22', '60000', '30000', '200', '9800', '100000', '30', '30', '0', '0', '60000', '0', '30000', '0', '200', '0', '9800', '0', '0', '100000', '15000', '0', '1800', '0', '75', '0', '75', '0', '0', '0', '101950', '1800', '0', '0', '208', '11880', '0', '210', '0', '0', '14098', '85902', 'Rupees Eighty Five Thousand Nine Hundred Two Only', '25.5', '0', '25.5', '=B3&\"_\"&C3&\"_\"&\"Payslip\"&\"_\"&S3', 'samueldoss307@gmail.com', '=\"Dear\"&\" \"&C3', '2022-07-12 16:42:40', '2022-07-12 16:42:40'),
(3, 'Vasa100', 1, 'HR Augustin', 'MALE', 'MANAGING DIRECTOR', 'NA', '44531', 'CHENNAI', '27677', 'AUGUSTIN', 'ANFPB2903B', '274172155880', '101771607810', 'TNAMB24340250000010049', 'Not Applicable', 'HDFC BANK', '50100233172698', 'HDFC0002064', 'May-22', '37000', '18000', '200', '5800', '60000', '30', '30', '0', '0', '36000', '0', '18000', '0', '200', '0', '5800', '0', '0', '60000', '15000', '0', '1800', '0', '75', '0', '75', '0', '0', '0', '61950', '1800', '0', '0', '208', '2990', '0', '210', '0', '0', '5208', '54792', 'Rupees Fifty Four Thousand Seven Hundred Ninety Two Only', '8.75', '0', '8.75', '=B4&\"_\"&C4&\"_\"&\"Payslip\"&\"_\"&S4', 'DOSS@DUNAMISMACHINES.CO.IN', '=\"Dear\"&\" \"&C4', '2022-07-12 16:42:40', '2022-07-12 16:42:40'),
(4, 'Vasa100', 1, 'HR Augustin', 'MALE', 'MANAGING DIRECTOR', 'NA', '44531', 'CHENNAI', '27677', 'AUGUSTIN', 'ANFPB2903B', '274172155880', '101771607810', 'TNAMB24340250000010049', 'Not Applicable', 'HDFC BANK', '50100233172698', 'HDFC0002064', 'June-22', '38000', '18000', '200', '5800', '60000', '30', '30', '0', '0', '36000', '0', '18000', '0', '200', '0', '5800', '0', '0', '60000', '15000', '0', '1800', '0', '75', '0', '75', '0', '0', '0', '61950', '1800', '0', '0', '208', '2990', '0', '210', '0', '0', '5208', '54792', 'Rupees Fifty Four Thousand Seven Hundred Ninety Two Only', '8.75', '0', '8.75', '=B5&\"_\"&C5&\"_\"&\"Payslip\"&\"_\"&S5', 'DOSS@DUNAMISMACHINES.CO.IN', '=\"Dear\"&\" \"&C5', '2022-07-12 16:42:40', '2022-07-12 16:42:40'),
(5, 'Vasa100', 1, 'HR Augustin', 'MALE', 'MANAGING DIRECTOR', 'NA', '44531', 'CHENNAI', '27677', 'AUGUSTIN', 'ANFPB2903B', '274172155880', '101771607810', 'TNAMB24340250000010049', 'Not Applicable', 'HDFC BANK', '50100233172698', 'HDFC0002064', 'July-22', '39000', '18000', '200', '5800', '60000', '30', '30', '0', '0', '36000', '0', '18000', '0', '200', '0', '5800', '0', '0', '60000', '15000', '0', '1800', '0', '75', '0', '75', '0', '0', '0', '61950', '1800', '0', '0', '208', '2990', '0', '210', '0', '0', '5208', '54792', 'Rupees Fifty Four Thousand Seven Hundred Ninety Two Only', '8.75', '0', '8.75', '=B6&\"_\"&C6&\"_\"&\"Payslip\"&\"_\"&S6', 'DOSS@DUNAMISMACHINES.CO.IN', '=\"Dear\"&\" \"&C6', '2022-07-12 16:42:40', '2022-07-12 16:42:40');

-- --------------------------------------------------------

--
-- Table structure for table `vmt_employee_pms_goals_table`
--

CREATE TABLE `vmt_employee_pms_goals_table` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `self_kpi_review` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `self_kpi_percentage` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `self_kpi_comments` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_kpi_review` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_kpi_percentage` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_kpi_comments` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hr_kpi_review` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hr_kpi_percentage` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hr_kpi_comments` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kpi_table_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assignment_period` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coverage` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reviewer_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_link` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_kpi_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_employee_submitted` tinyint(4) DEFAULT NULL,
  `is_employee_accepted` tinyint(4) DEFAULT NULL,
  `is_manager_submitted` tinyint(4) DEFAULT NULL,
  `is_manager_approved` tinyint(255) DEFAULT NULL,
  `is_hr_submitted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `appraiser_comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_rejection_comments` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_rejection_comments` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vmt_client_master`
--

CREATE TABLE `vmt_client_master` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `short_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login_instruction` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_logo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_img` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vmt_client_master`
--

INSERT INTO `vmt_client_master` (`id`, `short_name`, `login_instruction`, `client_logo`, `background_img`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, '/generalinfo/client-logo.png', '/generalinfo/1656890592-bg.jpg', '2022-06-08 00:24:40', '2022-08-16 13:42:46'),
(2, 'Hello', 'adfasdfasdf', '/generalinfo/1654667695-logo.png', '/generalinfo/1654667695-bg.jpg', '2022-06-08 00:24:55', '2022-06-08 00:24:55');

-- --------------------------------------------------------

--
-- Table structure for table `vmt_general_settings`
--

CREATE TABLE `vmt_general_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `workflow_component` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `associate_wise_template` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kra_competency` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `increment_percentage` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report_component` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating_preference` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `annual_score_calculation` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_employee_review_rating` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_review_components` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `percentage_components` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `percentage_groupwise` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `finalscore_calculation_method` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `achievement_based_rating` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_all_managers_to_employee` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_rated_managers` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating_period_based` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating_component` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vmt_general_settings`
--

INSERT INTO `vmt_general_settings` (`id`, `workflow_component`, `associate_wise_template`, `kra_competency`, `increment_percentage`, `report_component`, `rating_preference`, `annual_score_calculation`, `show_employee_review_rating`, `employee_review_components`, `percentage_components`, `percentage_groupwise`, `finalscore_calculation_method`, `achievement_based_rating`, `show_all_managers_to_employee`, `show_rated_managers`, `rating_period_based`, `rating_component`, `created_at`, `updated_at`) VALUES
(1, 'Option-1', 'on', 'Option-1', 'Option-1', 'Option-1', 'Option-1', 'Option-1', 'on', 'Option-1', 'Option-1', 'on', 'Option-1', 'on', 'on', 'on', 'Monthssss', 'Option-1', '2022-05-31 12:20:46', '2022-05-31 12:20:46');

-- --------------------------------------------------------

--
-- Table structure for table `vmt_holidays`
--

CREATE TABLE `vmt_holidays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `holiday_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `holiday_date` datetime DEFAULT NULL,
  `holiday_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vmt_holidays`
--

INSERT INTO `vmt_holidays` (`id`, `created_at`, `updated_at`, `holiday_name`, `holiday_date`, `holiday_description`, `image`) VALUES
(1, NULL, NULL, 'Independance Day', '2022-08-15 00:00:00', 'Government Holiday', 'independence.jpg'),
(2, NULL, NULL, 'Gandhi Jayanthi', '2022-10-02 00:00:00', 'Government Holiday', 'gandhi_jayandhi.png'),
(3, NULL, NULL, 'Ganesh Chadurthi', '2022-08-31 00:00:00', 'Government Holiday', 'ganesh_chadurthi.png'),
(4, NULL, NULL, 'Onam', '2022-08-30 00:00:00', 'Government Holiday', 'onam.png'),
(5, NULL, NULL, 'Raksha Bandhan', '2022-08-11 00:00:00', 'Government Holiday', 'raksha_bandhan.png');

-- --------------------------------------------------------

--
-- Table structure for table `vmt_kpi_form_table`
--

CREATE TABLE `vmt_kpi_form_table` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dimension` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kpi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `operational_definition` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `measure` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `frequency` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `stretch_target` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kpi_weightage` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vmt_kpi_table`
--

CREATE TABLE `vmt_kpi_table` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kpi_rows` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vmt_kpi_table`
--

INSERT INTO `vmt_kpi_table` (`id`, `kpi_rows`, `author_id`, `author_name`, `created_at`, `updated_at`) VALUES
(26, '43,44', '4', 'Emp Praveen', '2022-07-03 03:11:09', '2022-07-03 03:11:09'),
(27, '45', '2', 'Mgr Max Kumar', '2022-07-03 06:15:25', '2022-07-03 06:15:25'),
(28, '46,47,48', '1', 'HR Augustin', '2022-07-03 17:34:37', '2022-07-03 17:34:37'),
(29, '51,52,53', '1', 'HR Augustin', '2022-07-05 05:42:28', '2022-07-05 05:42:28'),
(30, '54', '4', 'Emp Praveen', '2022-07-07 13:07:03', '2022-07-07 13:07:03'),
(31, '55', '4', 'Emp Praveen', '2022-07-07 13:12:50', '2022-07-07 13:12:50'),
(32, '56', '4', 'Emp Praveen', '2022-07-08 09:16:37', '2022-07-08 09:16:37'),
(33, '62,63,64,65,66', '1', 'HR Augustin', '2022-07-14 12:06:30', '2022-07-14 12:06:30'),
(34, '67,68,69,70,71', '1', 'HR Augustin', '2022-07-14 18:06:31', '2022-07-14 18:06:31'),
(35, '72,73,74,75,76', '1', 'HR Augustin', '2022-07-14 18:07:51', '2022-07-14 18:07:51'),
(36, '77', '1', 'HR Augustin', '2022-07-16 12:08:23', '2022-07-16 12:08:23'),
(37, '78,79,80,81,82', '1', 'HR Augustin', '2022-07-17 03:04:02', '2022-07-17 03:04:02'),
(38, '83,84,85,86', '4', 'Emp Praveen', '2022-07-18 07:00:21', '2022-07-18 07:00:21'),
(39, '87,88,89,90,91', '1', 'HR Augustin', '2022-08-02 13:21:03', '2022-08-02 13:21:03'),
(40, '92,93,94,95,96', '1', 'HR Augustin', '2022-08-02 13:21:41', '2022-08-02 13:21:41'),
(41, '97,98,99,100,101', '1', 'HR Augustin', '2022-08-04 14:05:28', '2022-08-04 14:05:28'),
(42, '102,103,104,105,106', '1', 'HR Augustin', '2022-08-04 14:06:30', '2022-08-04 14:06:30');

-- --------------------------------------------------------

--
-- Table structure for table `vmt_leaves`
--

CREATE TABLE `vmt_leaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `leave_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `leave_max_limit` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vmt_leaves`
--

INSERT INTO `vmt_leaves` (`id`, `leave_type`, `leave_max_limit`, `created_at`, `updated_at`) VALUES
(1, 'sick_leave', '10', '2022-07-03 23:22:43', '2022-07-03 23:22:43'),
(2, 'lop_leave', '5', '2022-07-03 23:22:43', '2022-07-03 23:22:43'),
(3, 'casual_leave', '3', '2022-07-03 23:22:43', '2022-07-03 23:22:43'),
(4, 'compensatory_leave', '2', '2022-07-03 23:22:43', '2022-07-03 23:22:43'),
(5, 'flexidayoff_leave', '8', '2022-07-03 23:22:43', '2022-07-03 23:22:43');

-- --------------------------------------------------------

--
-- Table structure for table `vmt_performance_apraisal_questions`
--

CREATE TABLE `vmt_performance_apraisal_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dimension` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kpi` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operational_definition` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `measure` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `frequency` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stretch_target` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kpi_weightage` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vmt_performance_apraisal_questions`
--

INSERT INTO `vmt_performance_apraisal_questions` (`id`, `dimension`, `kpi`, `operational_definition`, `measure`, `frequency`, `target`, `stretch_target`, `source`, `kpi_weightage`, `author_id`, `author_name`, `created_at`, `updated_at`) VALUES
(43, 'July 3rd 2pm emp types', 'July 3rd 2pm', 'July 3rd 2pm', NULL, NULL, NULL, NULL, NULL, NULL, '4', 'Emp Praveen', '2022-07-03 03:11:09', '2022-07-03 03:11:09'),
(44, 'July 3rd 2pm emp types', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4', 'Emp Praveen', '2022-07-03 03:11:09', '2022-07-03 03:11:09'),
(45, 'Finance', 'Ensuring Timely payout to employees on the Salary & reimbursement claimed (Target > 95%) Adherence to Statutory & Compliance regulations KCF/RR: reduce 0-1-2 ratings in KCF by Q4 assessment', 'Adherence to Statutory & Compliance regulations KCF/RR:reduce 0-1-2 ratings in KCF by Q4 assessment Bottom line impact', 'Tracking of reimbursement should be done till Payout. Follow a comprehensive checklist & ensure NIL deviations to Statutory & compliance norms. Timely reports to Finance Team as per the requirement. Concerns raised on KCF to be ascertained & gaps in the process to be arrested. Aim to have all KCF points under 4 or 5 category by Q4', 'Monthly', '100% Compliance', '100% Compliance', 'System / Manual', '15%', '1', 'HR Augustin', '2022-07-03 06:15:25', '2022-07-03 06:15:25'),
(46, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', 'HR Augustin', '2022-07-03 17:34:37', '2022-07-03 17:34:37'),
(47, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', 'HR Augustin', '2022-07-03 17:34:37', '2022-07-03 17:34:37'),
(48, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', 'HR Augustin', '2022-07-03 17:34:37', '2022-07-03 17:34:37'),
(49, 'Finance', 'Ensuring Timely payout to employees on the Salary & reimbursement claimed (Target > 95%) Adherence to Statutory & Compliance regulations KCF/RR: reduce 0-1-2 ratings in KCF by Q4 assessment', 'Adherence to Statutory & Compliance regulations KCF/RR:reduce 0-1-2 ratings in KCF by Q4 assessment Bottom line impact', 'Tracking of reimbursement should be done till Payout. Follow a comprehensive checklist & ensure NIL deviations to Statutory & compliance norms. Timely reports to Finance Team as per the requirement. Concerns raised on KCF to be ascertained & gaps in the process to be arrested. Aim to have all KCF points under 4 or 5 category by Q4', 'Monthly', '100% Compliance', '100% Compliance', 'System / Manual', '15%', '1', 'Admin', '2022-07-04 08:08:55', '2022-07-04 08:08:55'),
(50, 'Customer', 'Drive Improvement on Payroll & Reimbursement process Improve Reimbursement TAT (Target 100%) Quality of deliverables (Target 100%) Timely Query handling (Target 100%)', 'Drive Improvement on Input Adherance (Target > 85%) Improve Payroll TAT (Target 100%) Quality of deliverables (Target 100%) Timely Query handling (Target 100%) Tax Related (Insource Proof Verification & Form 16) Target 100%', 'Monitor the entire process & ascertain the NVA\\\'s. Removing the NVA\\\'s will help us to strengthen the process with an improved TAT. Improve the hygiene of the process through proactive mails, regular concalls, etc. Jump to action when Client is not adhereing to timelines / proper info provided. Conduct regular calls with Clients & understand their pain areas. Take remedial action & improve upon. Records the minutes & circulate with action plan. Ensure friction free delivery by completing the task within TAT agreed with the Clients. Cultivate \"First time Right\" culture amongst Team members Monitor & ensure Queries of consultants / clients / employees are handled within TAT with appropriate & relevant response. Automate the entire reimbursement process which will inturn improve the Productivity, Quality TAT', 'Monthly', 'TAT : 100% Quality : 100% Query Handling TAT - 100%', 'Input Adherence : 95% TAT : 100% Quality : 100%', 'FO /BO', '25%', '1', 'Admin', '2022-07-04 08:08:55', '2022-07-04 08:08:55'),
(51, 'ddkslflkj', 'fkdjsaljfd', 'djflajflk', 'dkjaljfd', 'jljlfjlaj1`', '100', 'aksdl`', 'aksdl`', '50', '1', 'HR Augustin', '2022-07-05 05:42:28', '2022-07-05 05:42:28'),
(52, 'aksdl`', 'aksdl`', 'aksdl`', 'aksdl`', 'aksdl`', 'aksdl`', 'aksdl`', 'aksdl`', '10', '1', 'HR Augustin', '2022-07-05 05:42:28', '2022-07-05 05:42:28'),
(53, 'aksdl`', 'aksdl`', 'aksdl`', 'aksdl`', 'aksdl`', 'aksdl`', 'aksdl`', 'aksdl`', '40', '1', 'HR Augustin', '2022-07-05 05:42:28', '2022-07-05 05:42:28'),
(54, 'Finance July 7th 6:35pm', 'jkl', 'jkl', 'jkl', 'jkl', 'jkl', 'jkl', 'jlk', '100', '4', 'Emp Praveen', '2022-07-07 13:07:03', '2022-07-07 13:07:03'),
(55, 'Finance July 7th 6:42pm', 'hjk', 'hjk', 'hj', 'hjk', 'hjk', 'h', 'hjk', '100', '4', 'Emp Praveen', '2022-07-07 13:12:50', '2022-07-07 13:12:50'),
(56, 'DFJLAJFLAJSF', 'JLJLJ', 'LJLJLKJ', 'LJLKJLKJ', 'LJLJLJ', '100', '200', 'JPJPJ', '100', '4', 'Emp Praveen', '2022-07-08 09:16:37', '2022-07-08 09:16:37'),
(57, 'Shared Goals', 'Lead system enhancement in Paybill ensuring 100% compliance \nMonitor & adhere to 100% Accurate, On time statutory remittance and issual of Form 16\n\n', 'Ensure to dig deep & arrest the deviations.Remove unwanted reports from Paybill which will help in friction free process.\nForm 16  & 24Q from Paybill, Investment portal enhancement should be carried out.On time generation, validation & reconcilation of Statutory reports to ensure NIL deviation from Statutory guidelines\nEnsuring the KCF guidelines are adhered on day to day basis with a strignent control.\nBetter Team Control which will in turn help in overall development\nEncourging the Team members for all Cross functional activites & drive it for their improvement\nAscertain the Time study of the process & have optimal resources required. \n', 'Reduction in > 45 days onboarding - by  25% by Q2 , progressively to reach 90% by Q4 \nReduction in rework\nF&F end to end completion and payout within 30 days from LWD / Date of intimation                             Payment of Bonus Act , Payment of Wages Act.', 'Monthly', '0.95', '> 95 %', 'System / Manual\n', '20%', '1', 'HR Augustin', '2022-07-08 11:57:00', '2022-07-08 11:57:00'),
(58, 'Finance', 'Ensuring Timely payout to employees (Target > 95%)\nAdherence to Statutory & Compliance regulations \nZero KCF in < 3 rating                                                                                                                                     10% FTE Efficiency on the budgeted FTEs for 2018                                                                                                 ', '\nAdherence to Statutory & Compliance regulations \nKCF/RR: reduce 0-1-2 ratings in KCF by Q4 assessment                                                                                                   \nBottom line impact', 'Rollover by 5th of everymonth\nFollow a comprehensive checklist & ensure NIL deviations to Statutory & compliance norms.\nTimely reports to Finance Team as per the requirement.\nConcerns raised on KCF to be ascertained & gaps in the process to be arrested. Aim to have all KCF points under 4 or 5 category by Q4', 'Monthly', '100% Compliance\n', '> 10% FTE efficiency', 'System / Manual\n', '15%', '1', 'HR Augustin', '2022-07-08 11:57:00', '2022-07-08 11:57:00'),
(59, 'Customer', '\nImprove Payroll TAT  - raise the bar from 24 hours to 8 hours (Target 100%)                          Improve F n F TAT - Raise the bar from 4 days to 2 days ( Target 100%)\nQuality of deliverables  -- Reduction in error rates to less than 0.1% (Target 100%)\nTimely Query handling  - REsponse to queries in 24 hours both to EWs and Internal (Target 100%)\nTax Related (Insource Proof Verification & Form 16) (Taget 100%)\n', 'Drive Improvement on Input Adherance (Target > 85%)\nImprove Payroll TAT (Target 100%)\nQuality of deliverables (Target 100%)\nTimely Query handling (Target 100%)\nTax Related (Insource Proof Verification & Form 16) Target 100%\n', 'Monitor the Team\'s ability to track the Input delays of your Clients & take remedial action to improve their timely adherence through proactive mails, regular concalls, etc. Jump to action when Client is not adhereing to timelines.\nConduct regular calls with Clients & understand their pain areas. Take remedial action & improve upon. Records the minutes & circulate with action plan.\nEnsure friction free delivery by completing the task within TAT by regularly monitoring through AICP Tracker.\nCultivate First time Right culture amongst Team members\nMonitor & ensure Queries of consultants / clients / employees are handled within TAT with appropriate & relevant response.\nInsource Tax Proof verification & Form 16 activity. Ensure timely issual of Form 16 for employees with ZERO defect & NIL cost concerns (+ve tax) \n', 'Daily', '\nTAT : 100%\nQuality : 100%\nTax Proof  : 100%\n', 'Input Adherence : 95%\n\nTAT : 100%\nQuality : 100%\n', 'System / Manual\n', '0.25', '1', 'HR Augustin', '2022-07-08 11:57:00', '2022-07-08 11:57:00'),
(60, 'Process', '\nNo Rework in processing (Target <1%)\nCI - Project - Reimbursement Automation & CSSL Reimbursement Automation\n100% of staff lean trained \n\n', 'Awareness and Adherence to Quality Processes without compromising on Compliance (Target 100%)\nPerformance & Cross Functional activities\nNo Rework in processing (Target <1%)\nProcess Improvement ( Implemented Ideas)\nAutomation of Reimbursement Process\n', 'Acheive & sustain 100% in Quality of deliverables (Measured through Internal & external trackers)\nSupport within process (not individuals) at the time of crisis.\nArrest the gap which results in re-work & discuss with Team members / Consultants for further action.\nImprovement in the existing process is very vital. Ensure Team members contribute more ideas which ideally converts into reduction of FTE\'s / improve the Quality of deliverable.\n', 'Daily', 'Quality : 100%\nRe-work : 1%\n\n', 'Quality : 100%\nRe-work : 1%\n\n', ' Measured through Internal & external trackers\n', '20%', '1', 'HR Augustin', '2022-07-08 11:57:00', '2022-07-08 11:57:00'),
(61, 'Best People', 'Team Motivation & Proactiveness ,Share knowledge with colleagues  (training to regional CET)\nDevelop succession planning and backup following 5:3:1 model\nSelf Development,Late Attendance hindering deliverables\nAvoiding Unplanned leaves ,Ensuring Work place ethics\n', 'Appropriate back up plan should be documented / training provided.\nRegularly conduct team meetings understand their grievances & take corrective action.\nBe a Mentor. Encourage Buddy Processing & train the New / Low perfomers to acheive higher standards.\nTrain the Leaders to become better Leaders & ensure Team members are growing.\nEncourging the Team members for all Cross functional activites & drive it for their improvement\n', 'Ensure Team members are punctual to office & adheres to Company policies & regulations.\nRegularly conduct team meetings understand their grievances & take corrective action.\nAim to acheive more & move up in the ladder by taking more responsibilites as is required for your next role.\nPlan my leaves with prior intimation to my reporting Manager.\nEnsure to maintain a clear desk by your Team members and avoid chits chats during office hours.\nBe a Mentor. Encourage Buddy Processing & train the New / Low perfomers to acheive higher standards.\nTrain the Leaders to become better Leaders & ensure Team members are growing.\n', 'Daily', 'Adhere to Company Policies & regulations\n10% increase in GPS Scores vs last year / above treshold for Randstad India\nSuccession planning for self and TMs', '> 90 % GPS scores in all dimensions', 'Manual', '0.2', '1', 'HR Augustin', '2022-07-08 11:57:00', '2022-07-08 11:57:00'),
(62, 'Shared Goals', 'Lead system enhancement in Paybill ensuring 100% compliance \r\nMonitor & adhere to 100% Accurate, On time statutory remittance and issual of Form 16', 'Ensure to dig deep & arrest the deviations.Remove unwanted reports from Paybill which will help in friction free process.\r\nForm 16  & 24Q from Paybill, Investment portal enhancement should be carried out.On time generation, validation & reconcilation of Statutory reports to ensure NIL deviation from Statutory guidelines\r\nEnsuring the KCF guidelines are adhered on day to day basis with a strignent control.\r\nBetter Team Control which will in turn help in overall development\r\nEncourging the Team members for all Cross functional activites & drive it for their improvement\r\nAscertain the Time study of the process & have optimal resources required.', 'Reduction in > 45 days onboarding - by  25% by Q2 , progressively to reach 90% by Q4 \r\nReduction in rework\r\nF&F end to end completion and payout within 30 days from LWD / Date of intimation                             Payment of Bonus Act , Payment of Wages Act.', 'Monthly', '0.95', '> 95 %', 'System / Manual', '20%', '1', 'HR Augustin', '2022-07-14 12:06:30', '2022-07-14 12:06:30'),
(63, 'Finance', 'Ensuring Timely payout to employees (Target > 95%)\r\nAdherence to Statutory & Compliance regulations \r\nZero KCF in < 3 rating                                                                                                                                     10% FTE Efficiency on the budgeted FTEs for 2018', 'Adherence to Statutory & Compliance regulations \r\nKCF/RR: reduce 0-1-2 ratings in KCF by Q4 assessment                                                                                                   \r\nBottom line impact', 'Rollover by 5th of everymonth\r\nFollow a comprehensive checklist & ensure NIL deviations to Statutory & compliance norms.\r\nTimely reports to Finance Team as per the requirement.\r\nConcerns raised on KCF to be ascertained & gaps in the process to be arrested. Aim to have all KCF points under 4 or 5 category by Q4', 'Monthly', '100% Compliance', '> 10% FTE efficiency', 'System / Manual', '15%', '1', 'HR Augustin', '2022-07-14 12:06:30', '2022-07-14 12:06:30'),
(64, 'Customer', 'Improve Payroll TAT  - raise the bar from 24 hours to 8 hours (Target 100%)                          Improve F n F TAT - Raise the bar from 4 days to 2 days ( Target 100%)\r\nQuality of deliverables  -- Reduction in error rates to less than 0.1% (Target 100%)\r\nTimely Query handling  - REsponse to queries in 24 hours both to EWs and Internal (Target 100%)\r\nTax Related (Insource Proof Verification & Form 16) (Taget 100%)', 'Drive Improvement on Input Adherance (Target > 85%)\r\nImprove Payroll TAT (Target 100%)\r\nQuality of deliverables (Target 100%)\r\nTimely Query handling (Target 100%)\r\nTax Related (Insource Proof Verification & Form 16) Target 100%', 'Monitor the Team\'s ability to track the Input delays of your Clients & take remedial action to improve their timely adherence through proactive mails, regular concalls, etc. Jump to action when Client is not adhereing to timelines.\r\nConduct regular calls with Clients & understand their pain areas. Take remedial action & improve upon. Records the minutes & circulate with action plan.\r\nEnsure friction free delivery by completing the task within TAT by regularly monitoring through AICP Tracker.\r\nCultivate First time Right culture amongst Team members\r\nMonitor & ensure Queries of consultants / clients / employees are handled within TAT with appropriate & relevant response.\r\nInsource Tax Proof verification & Form 16 activity. Ensure timely issual of Form 16 for employees with ZERO defect & NIL cost concerns (+ve tax)', 'Daily', 'TAT : 100%\r\nQuality : 100%\r\nTax Proof  : 100%', 'Input Adherence : 95%\r\n\r\nTAT : 100%\r\nQuality : 100%', 'System / Manual', '25%', '1', 'HR Augustin', '2022-07-14 12:06:30', '2022-07-14 12:06:30'),
(65, 'Process', 'No Rework in processing (Target <1%)\r\nCI - Project - Reimbursement Automation & CSSL Reimbursement Automation\r\n100% of staff lean trained', 'Awareness and Adherence to Quality Processes without compromising on Compliance (Target 100%)\r\nPerformance & Cross Functional activities\r\nNo Rework in processing (Target <1%)\r\nProcess Improvement ( Implemented Ideas)\r\nAutomation of Reimbursement Process', 'Acheive & sustain 100% in Quality of deliverables (Measured through Internal & external trackers)\r\nSupport within process (not individuals) at the time of crisis.\r\nArrest the gap which results in re-work & discuss with Team members / Consultants for further action.\r\nImprovement in the existing process is very vital. Ensure Team members contribute more ideas which ideally converts into reduction of FTE\'s / improve the Quality of deliverable.', 'Daily', 'Quality : 100%\r\nRe-work : 1%', 'Quality : 100%\r\nRe-work : 1%', 'Measured through Internal & external trackers', '20%', '1', 'HR Augustin', '2022-07-14 12:06:30', '2022-07-14 12:06:30'),
(66, 'Best People', 'Team Motivation & Proactiveness ,Share knowledge with colleagues  (training to regional CET)\r\nDevelop succession planning and backup following 5:3:1 model\r\nSelf Development,Late Attendance hindering deliverables\r\nAvoiding Unplanned leaves ,Ensuring Work place ethics', 'Appropriate back up plan should be documented / training provided.\r\nRegularly conduct team meetings understand their grievances & take corrective action.\r\nBe a Mentor. Encourage Buddy Processing & train the New / Low perfomers to acheive higher standards.\r\nTrain the Leaders to become better Leaders & ensure Team members are growing.\r\nEncourging the Team members for all Cross functional activites & drive it for their improvement', 'Ensure Team members are punctual to office & adheres to Company policies & regulations.\r\nRegularly conduct team meetings understand their grievances & take corrective action.\r\nAim to acheive more & move up in the ladder by taking more responsibilites as is required for your next role.\r\nPlan my leaves with prior intimation to my reporting Manager.\r\nEnsure to maintain a clear desk by your Team members and avoid chits chats during office hours.\r\nBe a Mentor. Encourage Buddy Processing & train the New / Low perfomers to acheive higher standards.\r\nTrain the Leaders to become better Leaders & ensure Team members are growing.', 'Daily', 'Adhere to Company Policies & regulations\r\n10% increase in GPS Scores vs last year / above treshold for Randstad India\r\nSuccession planning for self and TMs', '> 90 % GPS scores in all dimensions', 'Manual', '20%', '1', 'HR Augustin', '2022-07-14 12:06:30', '2022-07-14 12:06:30'),
(67, 'Shared Goals', 'Lead system enhancement in Paybill ensuring 100% compliance \r\nMonitor & adhere to 100% Accurate, On time statutory remittance and issual of Form 16', 'Ensure to dig deep & arrest the deviations.Remove unwanted reports from Paybill which will help in friction free process.\r\nForm 16  & 24Q from Paybill, Investment portal enhancement should be carried out.On time generation, validation & reconcilation of Statutory reports to ensure NIL deviation from Statutory guidelines\r\nEnsuring the KCF guidelines are adhered on day to day basis with a strignent control.\r\nBetter Team Control which will in turn help in overall development\r\nEncourging the Team members for all Cross functional activites & drive it for their improvement\r\nAscertain the Time study of the process & have optimal resources required.', 'Reduction in > 45 days onboarding - by  25% by Q2 , progressively to reach 90% by Q4 \r\nReduction in rework\r\nF&F end to end completion and payout within 30 days from LWD / Date of intimation                             Payment of Bonus Act , Payment of Wages Act.', 'Monthly', '0.95', '> 95 %', 'System / Manual', '20%', '1', 'HR Augustin', '2022-07-14 18:06:31', '2022-07-14 18:06:31'),
(68, 'Finance', 'Ensuring Timely payout to employees (Target > 95%)\r\nAdherence to Statutory & Compliance regulations \r\nZero KCF in < 3 rating                                                                                                                                     10% FTE Efficiency on the budgeted FTEs for 2018', 'Adherence to Statutory & Compliance regulations \r\nKCF/RR: reduce 0-1-2 ratings in KCF by Q4 assessment                                                                                                   \r\nBottom line impact', 'Rollover by 5th of everymonth\r\nFollow a comprehensive checklist & ensure NIL deviations to Statutory & compliance norms.\r\nTimely reports to Finance Team as per the requirement.\r\nConcerns raised on KCF to be ascertained & gaps in the process to be arrested. Aim to have all KCF points under 4 or 5 category by Q4', 'Monthly', '100% Compliance', '> 10% FTE efficiency', 'System / Manual', '15%', '1', 'HR Augustin', '2022-07-14 18:06:31', '2022-07-14 18:06:31'),
(69, 'Customer', 'Improve Payroll TAT  - raise the bar from 24 hours to 8 hours (Target 100%)                          Improve F n F TAT - Raise the bar from 4 days to 2 days ( Target 100%)\r\nQuality of deliverables  -- Reduction in error rates to less than 0.1% (Target 100%)\r\nTimely Query handling  - REsponse to queries in 24 hours both to EWs and Internal (Target 100%)\r\nTax Related (Insource Proof Verification & Form 16) (Taget 100%)', 'Drive Improvement on Input Adherance (Target > 85%)\r\nImprove Payroll TAT (Target 100%)\r\nQuality of deliverables (Target 100%)\r\nTimely Query handling (Target 100%)\r\nTax Related (Insource Proof Verification & Form 16) Target 100%', 'Monitor the Team\'s ability to track the Input delays of your Clients & take remedial action to improve their timely adherence through proactive mails, regular concalls, etc. Jump to action when Client is not adhereing to timelines.\r\nConduct regular calls with Clients & understand their pain areas. Take remedial action & improve upon. Records the minutes & circulate with action plan.\r\nEnsure friction free delivery by completing the task within TAT by regularly monitoring through AICP Tracker.\r\nCultivate First time Right culture amongst Team members\r\nMonitor & ensure Queries of consultants / clients / employees are handled within TAT with appropriate & relevant response.\r\nInsource Tax Proof verification & Form 16 activity. Ensure timely issual of Form 16 for employees with ZERO defect & NIL cost concerns (+ve tax)', 'Daily', 'TAT : 100%\r\nQuality : 100%\r\nTax Proof  : 100%', 'Input Adherence : 95%\r\n\r\nTAT : 100%\r\nQuality : 100%', 'System / Manual', '25%', '1', 'HR Augustin', '2022-07-14 18:06:31', '2022-07-14 18:06:31'),
(70, 'Process', 'No Rework in processing (Target <1%)\r\nCI - Project - Reimbursement Automation & CSSL Reimbursement Automation\r\n100% of staff lean trained', 'Awareness and Adherence to Quality Processes without compromising on Compliance (Target 100%)\r\nPerformance & Cross Functional activities\r\nNo Rework in processing (Target <1%)\r\nProcess Improvement ( Implemented Ideas)\r\nAutomation of Reimbursement Process', 'Acheive & sustain 100% in Quality of deliverables (Measured through Internal & external trackers)\r\nSupport within process (not individuals) at the time of crisis.\r\nArrest the gap which results in re-work & discuss with Team members / Consultants for further action.\r\nImprovement in the existing process is very vital. Ensure Team members contribute more ideas which ideally converts into reduction of FTE\'s / improve the Quality of deliverable.', 'Daily', 'Quality : 100%\r\nRe-work : 1%', 'Quality : 100%\r\nRe-work : 1%', 'Measured through Internal & external trackers', '20%', '1', 'HR Augustin', '2022-07-14 18:06:31', '2022-07-14 18:06:31'),
(71, 'Best People', 'Team Motivation & Proactiveness ,Share knowledge with colleagues  (training to regional CET)\r\nDevelop succession planning and backup following 5:3:1 model\r\nSelf Development,Late Attendance hindering deliverables\r\nAvoiding Unplanned leaves ,Ensuring Work place ethics', 'Appropriate back up plan should be documented / training provided.\r\nRegularly conduct team meetings understand their grievances & take corrective action.\r\nBe a Mentor. Encourage Buddy Processing & train the New / Low perfomers to acheive higher standards.\r\nTrain the Leaders to become better Leaders & ensure Team members are growing.\r\nEncourging the Team members for all Cross functional activites & drive it for their improvement', 'Ensure Team members are punctual to office & adheres to Company policies & regulations.\r\nRegularly conduct team meetings understand their grievances & take corrective action.\r\nAim to acheive more & move up in the ladder by taking more responsibilites as is required for your next role.\r\nPlan my leaves with prior intimation to my reporting Manager.\r\nEnsure to maintain a clear desk by your Team members and avoid chits chats during office hours.\r\nBe a Mentor. Encourage Buddy Processing & train the New / Low perfomers to acheive higher standards.\r\nTrain the Leaders to become better Leaders & ensure Team members are growing.', 'Daily', 'Adhere to Company Policies & regulations\r\n10% increase in GPS Scores vs last year / above treshold for Randstad India\r\nSuccession planning for self and TMs', '> 90 % GPS scores in all dimensions', 'Manual', '20%', '1', 'HR Augustin', '2022-07-14 18:06:31', '2022-07-14 18:06:31'),
(72, 'Shared Goals', 'Lead system enhancement in Paybill ensuring 100% compliance \r\nMonitor & adhere to 100% Accurate, On time statutory remittance and issual of Form 16', 'Ensure to dig deep & arrest the deviations.Remove unwanted reports from Paybill which will help in friction free process.\r\nForm 16  & 24Q from Paybill, Investment portal enhancement should be carried out.On time generation, validation & reconcilation of Statutory reports to ensure NIL deviation from Statutory guidelines\r\nEnsuring the KCF guidelines are adhered on day to day basis with a strignent control.\r\nBetter Team Control which will in turn help in overall development\r\nEncourging the Team members for all Cross functional activites & drive it for their improvement\r\nAscertain the Time study of the process & have optimal resources required.', 'Reduction in > 45 days onboarding - by  25% by Q2 , progressively to reach 90% by Q4 \r\nReduction in rework\r\nF&F end to end completion and payout within 30 days from LWD / Date of intimation                             Payment of Bonus Act , Payment of Wages Act.', 'Monthly', '0.95', '> 95 %', 'System / Manual', '20%', '1', 'HR Augustin', '2022-07-14 18:07:51', '2022-07-14 18:07:51'),
(73, 'Finance', 'Ensuring Timely payout to employees (Target > 95%)\r\nAdherence to Statutory & Compliance regulations \r\nZero KCF in < 3 rating                                                                                                                                     10% FTE Efficiency on the budgeted FTEs for 2018', 'Adherence to Statutory & Compliance regulations \r\nKCF/RR: reduce 0-1-2 ratings in KCF by Q4 assessment                                                                                                   \r\nBottom line impact', 'Rollover by 5th of everymonth\r\nFollow a comprehensive checklist & ensure NIL deviations to Statutory & compliance norms.\r\nTimely reports to Finance Team as per the requirement.\r\nConcerns raised on KCF to be ascertained & gaps in the process to be arrested. Aim to have all KCF points under 4 or 5 category by Q4', 'Monthly', '100% Compliance', '> 10% FTE efficiency', 'System / Manual', '15%', '1', 'HR Augustin', '2022-07-14 18:07:51', '2022-07-14 18:07:51'),
(74, 'Customer', 'Improve Payroll TAT  - raise the bar from 24 hours to 8 hours (Target 100%)                          Improve F n F TAT - Raise the bar from 4 days to 2 days ( Target 100%)\r\nQuality of deliverables  -- Reduction in error rates to less than 0.1% (Target 100%)\r\nTimely Query handling  - REsponse to queries in 24 hours both to EWs and Internal (Target 100%)\r\nTax Related (Insource Proof Verification & Form 16) (Taget 100%)', 'Drive Improvement on Input Adherance (Target > 85%)\r\nImprove Payroll TAT (Target 100%)\r\nQuality of deliverables (Target 100%)\r\nTimely Query handling (Target 100%)\r\nTax Related (Insource Proof Verification & Form 16) Target 100%', 'Monitor the Team\'s ability to track the Input delays of your Clients & take remedial action to improve their timely adherence through proactive mails, regular concalls, etc. Jump to action when Client is not adhereing to timelines.\r\nConduct regular calls with Clients & understand their pain areas. Take remedial action & improve upon. Records the minutes & circulate with action plan.\r\nEnsure friction free delivery by completing the task within TAT by regularly monitoring through AICP Tracker.\r\nCultivate First time Right culture amongst Team members\r\nMonitor & ensure Queries of consultants / clients / employees are handled within TAT with appropriate & relevant response.\r\nInsource Tax Proof verification & Form 16 activity. Ensure timely issual of Form 16 for employees with ZERO defect & NIL cost concerns (+ve tax)', 'Daily', 'TAT : 100%\r\nQuality : 100%\r\nTax Proof  : 100%', 'Input Adherence : 95%\r\n\r\nTAT : 100%\r\nQuality : 100%', 'System / Manual', '25%', '1', 'HR Augustin', '2022-07-14 18:07:51', '2022-07-14 18:07:51'),
(75, 'Process', 'No Rework in processing (Target <1%)\r\nCI - Project - Reimbursement Automation & CSSL Reimbursement Automation\r\n100% of staff lean trained', 'Awareness and Adherence to Quality Processes without compromising on Compliance (Target 100%)\r\nPerformance & Cross Functional activities\r\nNo Rework in processing (Target <1%)\r\nProcess Improvement ( Implemented Ideas)\r\nAutomation of Reimbursement Process', 'Acheive & sustain 100% in Quality of deliverables (Measured through Internal & external trackers)\r\nSupport within process (not individuals) at the time of crisis.\r\nArrest the gap which results in re-work & discuss with Team members / Consultants for further action.\r\nImprovement in the existing process is very vital. Ensure Team members contribute more ideas which ideally converts into reduction of FTE\'s / improve the Quality of deliverable.', 'Daily', 'Quality : 100%\r\nRe-work : 1%', 'Quality : 100%\r\nRe-work : 1%', 'Measured through Internal & external trackers', '20%', '1', 'HR Augustin', '2022-07-14 18:07:51', '2022-07-14 18:07:51'),
(76, 'Best People', 'Team Motivation & Proactiveness ,Share knowledge with colleagues  (training to regional CET)\r\nDevelop succession planning and backup following 5:3:1 model\r\nSelf Development,Late Attendance hindering deliverables\r\nAvoiding Unplanned leaves ,Ensuring Work place ethics', 'Appropriate back up plan should be documented / training provided.\r\nRegularly conduct team meetings understand their grievances & take corrective action.\r\nBe a Mentor. Encourage Buddy Processing & train the New / Low perfomers to acheive higher standards.\r\nTrain the Leaders to become better Leaders & ensure Team members are growing.\r\nEncourging the Team members for all Cross functional activites & drive it for their improvement', 'Ensure Team members are punctual to office & adheres to Company policies & regulations.\r\nRegularly conduct team meetings understand their grievances & take corrective action.\r\nAim to acheive more & move up in the ladder by taking more responsibilites as is required for your next role.\r\nPlan my leaves with prior intimation to my reporting Manager.\r\nEnsure to maintain a clear desk by your Team members and avoid chits chats during office hours.\r\nBe a Mentor. Encourage Buddy Processing & train the New / Low perfomers to acheive higher standards.\r\nTrain the Leaders to become better Leaders & ensure Team members are growing.', 'Daily', 'Adhere to Company Policies & regulations\r\n10% increase in GPS Scores vs last year / above treshold for Randstad India\r\nSuccession planning for self and TMs', '> 90 % GPS scores in all dimensions', 'Manual', '20%', '1', 'HR Augustin', '2022-07-14 18:07:51', '2022-07-14 18:07:51'),
(77, '202020', 'wdhkjwhjd', 'wdhkjwhjd', 'wdhkjwhjd', 'wdhkjwhjd', 'wdhkjwhjd', 'wdhkjwhjd', 'wdhkjwhjd', '100', '1', 'HR Augustin', '2022-07-16 12:08:23', '2022-07-16 12:08:23'),
(78, 'Shared Goals', 'Lead system enhancement in Paybill ensuring 100% compliance \r\nMonitor & adhere to 100% Accurate, On time statutory remittance and issual of Form 16', 'Ensure to dig deep & arrest the deviations.Remove unwanted reports from Paybill which will help in friction free process.\r\nForm 16  & 24Q from Paybill, Investment portal enhancement should be carried out.On time generation, validation & reconcilation of Statutory reports to ensure NIL deviation from Statutory guidelines\r\nEnsuring the KCF guidelines are adhered on day to day basis with a strignent control.\r\nBetter Team Control which will in turn help in overall development\r\nEncourging the Team members for all Cross functional activites & drive it for their improvement\r\nAscertain the Time study of the process & have optimal resources required.', 'Reduction in > 45 days onboarding - by  25% by Q2 , progressively to reach 90% by Q4 \r\nReduction in rework\r\nF&F end to end completion and payout within 30 days from LWD / Date of intimation                             Payment of Bonus Act , Payment of Wages Act.', 'Monthly', '0.95', '> 95 %', 'System / Manual', '20%', '1', 'HR Augustin', '2022-07-17 03:04:02', '2022-07-17 03:04:02'),
(79, 'Finance', 'Ensuring Timely payout to employees (Target > 95%)\r\nAdherence to Statutory & Compliance regulations \r\nZero KCF in < 3 rating                                                                                                                                     10% FTE Efficiency on the budgeted FTEs for 2018', 'Adherence to Statutory & Compliance regulations \r\nKCF/RR: reduce 0-1-2 ratings in KCF by Q4 assessment                                                                                                   \r\nBottom line impact', 'Rollover by 5th of everymonth\r\nFollow a comprehensive checklist & ensure NIL deviations to Statutory & compliance norms.\r\nTimely reports to Finance Team as per the requirement.\r\nConcerns raised on KCF to be ascertained & gaps in the process to be arrested. Aim to have all KCF points under 4 or 5 category by Q4', 'Monthly', '100% Compliance', '> 10% FTE efficiency', 'System / Manual', '15%', '1', 'HR Augustin', '2022-07-17 03:04:02', '2022-07-17 03:04:02'),
(80, 'Customer', 'Improve Payroll TAT  - raise the bar from 24 hours to 8 hours (Target 100%)                          Improve F n F TAT - Raise the bar from 4 days to 2 days ( Target 100%)\r\nQuality of deliverables  -- Reduction in error rates to less than 0.1% (Target 100%)\r\nTimely Query handling  - REsponse to queries in 24 hours both to EWs and Internal (Target 100%)\r\nTax Related (Insource Proof Verification & Form 16) (Taget 100%)', 'Drive Improvement on Input Adherance (Target > 85%)\r\nImprove Payroll TAT (Target 100%)\r\nQuality of deliverables (Target 100%)\r\nTimely Query handling (Target 100%)\r\nTax Related (Insource Proof Verification & Form 16) Target 100%', 'Monitor the Team\'s ability to track the Input delays of your Clients & take remedial action to improve their timely adherence through proactive mails, regular concalls, etc. Jump to action when Client is not adhereing to timelines.\r\nConduct regular calls with Clients & understand their pain areas. Take remedial action & improve upon. Records the minutes & circulate with action plan.\r\nEnsure friction free delivery by completing the task within TAT by regularly monitoring through AICP Tracker.\r\nCultivate First time Right culture amongst Team members\r\nMonitor & ensure Queries of consultants / clients / employees are handled within TAT with appropriate & relevant response.\r\nInsource Tax Proof verification & Form 16 activity. Ensure timely issual of Form 16 for employees with ZERO defect & NIL cost concerns (+ve tax)', 'Daily', 'TAT : 100%\r\nQuality : 100%\r\nTax Proof  : 100%', 'Input Adherence : 95%\r\n\r\nTAT : 100%\r\nQuality : 100%', 'System / Manual', '25%', '1', 'HR Augustin', '2022-07-17 03:04:02', '2022-07-17 03:04:02'),
(81, 'Process', 'No Rework in processing (Target <1%)\r\nCI - Project - Reimbursement Automation & CSSL Reimbursement Automation\r\n100% of staff lean trained', 'Awareness and Adherence to Quality Processes without compromising on Compliance (Target 100%)\r\nPerformance & Cross Functional activities\r\nNo Rework in processing (Target <1%)\r\nProcess Improvement ( Implemented Ideas)\r\nAutomation of Reimbursement Process', 'Acheive & sustain 100% in Quality of deliverables (Measured through Internal & external trackers)\r\nSupport within process (not individuals) at the time of crisis.\r\nArrest the gap which results in re-work & discuss with Team members / Consultants for further action.\r\nImprovement in the existing process is very vital. Ensure Team members contribute more ideas which ideally converts into reduction of FTE\'s / improve the Quality of deliverable.', 'Daily', 'Quality : 100%\r\nRe-work : 1%', 'Quality : 100%\r\nRe-work : 1%', 'Measured through Internal & external trackers', '20%', '1', 'HR Augustin', '2022-07-17 03:04:02', '2022-07-17 03:04:02'),
(82, 'Best People', 'Team Motivation & Proactiveness ,Share knowledge with colleagues  (training to regional CET)\r\nDevelop succession planning and backup following 5:3:1 model\r\nSelf Development,Late Attendance hindering deliverables\r\nAvoiding Unplanned leaves ,Ensuring Work place ethics', 'Appropriate back up plan should be documented / training provided.\r\nRegularly conduct team meetings understand their grievances & take corrective action.\r\nBe a Mentor. Encourage Buddy Processing & train the New / Low perfomers to acheive higher standards.\r\nTrain the Leaders to become better Leaders & ensure Team members are growing.\r\nEncourging the Team members for all Cross functional activites & drive it for their improvement', 'Ensure Team members are punctual to office & adheres to Company policies & regulations.\r\nRegularly conduct team meetings understand their grievances & take corrective action.\r\nAim to acheive more & move up in the ladder by taking more responsibilites as is required for your next role.\r\nPlan my leaves with prior intimation to my reporting Manager.\r\nEnsure to maintain a clear desk by your Team members and avoid chits chats during office hours.\r\nBe a Mentor. Encourage Buddy Processing & train the New / Low perfomers to acheive higher standards.\r\nTrain the Leaders to become better Leaders & ensure Team members are growing.', 'Daily', 'Adhere to Company Policies & regulations\r\n10% increase in GPS Scores vs last year / above treshold for Randstad India\r\nSuccession planning for self and TMs', '> 90 % GPS scores in all dimensions', 'Manual', '20%', '1', 'HR Augustin', '2022-07-17 03:04:02', '2022-07-17 03:04:02'),
(83, 'Process', 'Awareness and Adherence to Quality Processes without compromising on Compliance (Target 100%)\r\nPerformance & Cross Functional activities\r\nNo Rework in processing (Target <1%)\r\nProcess Improvement ( Implemented Ideas)\r\nAutomation of Reimbursement Process, Payroll and Quality Check                                                       CI - Minimum 1 improvement project per TL', 'Awareness and Adherence to Quality Processes without compromising on Compliance (Target 100%)\r\nPerformance & Cross Functional activities\r\nNo Rework in processing (Target <1%)\r\nProcess Improvement ( Implemented Ideas)\r\nAutomation of Reimbursement Process', 'Acheive & sustain 100% in Quality of deliverables (Measured through Internal & external trackers)\r\nSupport within process (not individuals) at the time of crisis.\r\nArrest the gap which results in re-work & discuss with Team members / Consultants for further action.\r\nImprovement in the existing process is very vital. Ensure Team members contribute more ideas which ideally converts into reduction of FTE\'s / improve the Quality of deliverable.', 'Daily', 'Quality : 100%\r\nRe-work : 1%\r\nTAT (Reim) - 1 day                                                                                                                                                     Payroll - 4 Hrs', '\"Quality : 100%\r\nRe-work : 1%', '\" Measured through Internal & external trackers', '20%', '4', 'Emp Praveen', '2022-07-18 07:00:21', '2022-07-18 07:00:21'),
(84, 'Best People', '(Shared Goal) Lead system enhancement in Paybill ensuring 100% compliance \r\nMonitor & adhere to 100% Accurate, On time statutory remittance and issual of Form 16', 'Ensure to dig deep & arrest the deviations.Remove unwanted reports from Paybill which will help in friction free process.\r\nForm 16  & 24Q from Paybill, Investment portal enhancement should be carried out.On time generation, validation & reconcilation of Statutory reports to ensure NIL deviation from Statutory guidelines\r\nEnsuring the KCF guidelines are adhered on day to day basis with a strignent control.', '(Shared Goal) Ensure to dig deep & arrest the deviations.Remove unwanted reports from Paybill which will help in friction free process.\r\nForm 16  & 24Q from Paybill, Investment portal enhancement should be carried out.On time generation, validation & reconcilation of Statutory reports to ensure NIL deviation from Statutory guidelines\r\nEnsuring the KCF guidelines are adhered on day to day basis with a strignent control.\r\nBetter Team Control which will in turn help in overall development\r\nEncourging the Team members for all Cross functional activites & drive it for their improvement\r\nAscertain the Time study of the process & have optimal resources required.', 'Monthly', 'Reduction in > 45 days onboarding - by  25% by Q2 , progressively to reach 90% by Q4 \r\nReduction in rework\r\n F&F end to end completion and payout within 30 days from LWD / Date of intimation', '> 90 %', '\"System / Manual', '20%', '4', 'Emp Praveen', '2022-07-18 07:00:21', '2022-07-18 07:00:21'),
(85, 'null', 'Retention, Succession Plan for the Leader and his directs, and Improvement in GPS score', 'Appropriate back up plan should be documented / training provided.\r\nRegularly conduct team meetings understand their grievances & take corrective action.\r\nBe a Mentor. Encourage Buddy Processing & train the New / Low perfomers to acheive higher standards.\r\nTrain the Leaders to become better Leaders & ensure Team members are growing.\r\nEncourging the Team members for all Cross functional activites & drive it for their improvement', 'Applicable for all:\r\nImproved knowledge on processes, to back-up in case of absence of POC. \r\nImproves motivation and encourages a spirit of healthy competition in the group\r\nHelps is Business Continuity. Reduced impact on service deliverable and escalations\r\nImproves Work-Life Balance and engagement levels within the Organization\r\nBetter Team & Self Control which will in turn help in overall development\r\nL4-G4 & above\r\nAppropriate back up plan should be documented / training provided.\r\nRegularly conduct team meetings understand their grievances & take corrective action.\r\nBe a Mentor. Encourage Buddy Processing & train the New / Low perfomers to acheive higher standards.\r\nTrain the Leaders to become better Leaders & ensure Team members are growing.\r\nEncourging the Team members for all Cross functional activites & drive it for their improvement', 'Weekly', 'Adhere to Company Policies & regulations', '\"Adhere to Company Policies & regulations', 'Manual', '20%', '4', 'Emp Praveen', '2022-07-18 07:00:21', '2022-07-18 07:00:21'),
(86, 'END', 'null', 'null', 'null', 'null', 'null', 'null', 'null', '40%', '4', 'Emp Praveen', '2022-07-18 07:00:21', '2022-07-18 07:00:21'),
(87, 'Shared Goals', 'Lead system enhancement in Paybill ensuring 100% compliance \r\nMonitor & adhere to 100% Accurate, On time statutory remittance and issual of Form 16', 'Ensure to dig deep & arrest the deviations.Remove unwanted reports from Paybill which will help in friction free process.\r\nForm 16  & 24Q from Paybill, Investment portal enhancement should be carried out.On time generation, validation & reconcilation of Statutory reports to ensure NIL deviation from Statutory guidelines\r\nEnsuring the KCF guidelines are adhered on day to day basis with a strignent control.\r\nBetter Team Control which will in turn help in overall development\r\nEncourging the Team members for all Cross functional activites & drive it for their improvement\r\nAscertain the Time study of the process & have optimal resources required.', 'Reduction in > 45 days onboarding - by  25% by Q2 , progressively to reach 90% by Q4 \r\nReduction in rework\r\nF&F end to end completion and payout within 30 days from LWD / Date of intimation                             Payment of Bonus Act , Payment of Wages Act.', 'Monthly', '0.95', '> 95 %', 'System / Manual', '20%', '1', 'HR Augustin', '2022-08-02 13:21:03', '2022-08-02 13:21:03'),
(88, 'Finance', 'Ensuring Timely payout to employees (Target > 95%)\r\nAdherence to Statutory & Compliance regulations \r\nZero KCF in < 3 rating                                                                                                                                     10% FTE Efficiency on the budgeted FTEs for 2018', 'Adherence to Statutory & Compliance regulations \r\nKCF/RR: reduce 0-1-2 ratings in KCF by Q4 assessment                                                                                                   \r\nBottom line impact', 'Rollover by 5th of everymonth\r\nFollow a comprehensive checklist & ensure NIL deviations to Statutory & compliance norms.\r\nTimely reports to Finance Team as per the requirement.\r\nConcerns raised on KCF to be ascertained & gaps in the process to be arrested. Aim to have all KCF points under 4 or 5 category by Q4', 'Monthly', '100% Compliance', '> 10% FTE efficiency', 'System / Manual', '15%', '1', 'HR Augustin', '2022-08-02 13:21:03', '2022-08-02 13:21:03'),
(89, 'Customer', 'Improve Payroll TAT  - raise the bar from 24 hours to 8 hours (Target 100%)                          Improve F n F TAT - Raise the bar from 4 days to 2 days ( Target 100%)\r\nQuality of deliverables  -- Reduction in error rates to less than 0.1% (Target 100%)\r\nTimely Query handling  - REsponse to queries in 24 hours both to EWs and Internal (Target 100%)\r\nTax Related (Insource Proof Verification & Form 16) (Taget 100%)', 'Drive Improvement on Input Adherance (Target > 85%)\r\nImprove Payroll TAT (Target 100%)\r\nQuality of deliverables (Target 100%)\r\nTimely Query handling (Target 100%)\r\nTax Related (Insource Proof Verification & Form 16) Target 100%', 'Monitor the Team\'s ability to track the Input delays of your Clients & take remedial action to improve their timely adherence through proactive mails, regular concalls, etc. Jump to action when Client is not adhereing to timelines.\r\nConduct regular calls with Clients & understand their pain areas. Take remedial action & improve upon. Records the minutes & circulate with action plan.\r\nEnsure friction free delivery by completing the task within TAT by regularly monitoring through AICP Tracker.\r\nCultivate First time Right culture amongst Team members\r\nMonitor & ensure Queries of consultants / clients / employees are handled within TAT with appropriate & relevant response.\r\nInsource Tax Proof verification & Form 16 activity. Ensure timely issual of Form 16 for employees with ZERO defect & NIL cost concerns (+ve tax)', 'Daily', 'TAT : 100%\r\nQuality : 100%\r\nTax Proof  : 100%', 'Input Adherence : 95%\r\n\r\nTAT : 100%\r\nQuality : 100%', 'System / Manual', '25%', '1', 'HR Augustin', '2022-08-02 13:21:03', '2022-08-02 13:21:03'),
(90, 'Process', 'No Rework in processing (Target <1%)\r\nCI - Project - Reimbursement Automation & CSSL Reimbursement Automation\r\n100% of staff lean trained', 'Awareness and Adherence to Quality Processes without compromising on Compliance (Target 100%)\r\nPerformance & Cross Functional activities\r\nNo Rework in processing (Target <1%)\r\nProcess Improvement ( Implemented Ideas)\r\nAutomation of Reimbursement Process', 'Acheive & sustain 100% in Quality of deliverables (Measured through Internal & external trackers)\r\nSupport within process (not individuals) at the time of crisis.\r\nArrest the gap which results in re-work & discuss with Team members / Consultants for further action.\r\nImprovement in the existing process is very vital. Ensure Team members contribute more ideas which ideally converts into reduction of FTE\'s / improve the Quality of deliverable.', 'Daily', 'Quality : 100%\r\nRe-work : 1%', 'Quality : 100%\r\nRe-work : 1%', 'Measured through Internal & external trackers', '20%', '1', 'HR Augustin', '2022-08-02 13:21:03', '2022-08-02 13:21:03');
INSERT INTO `vmt_performance_apraisal_questions` (`id`, `dimension`, `kpi`, `operational_definition`, `measure`, `frequency`, `target`, `stretch_target`, `source`, `kpi_weightage`, `author_id`, `author_name`, `created_at`, `updated_at`) VALUES
(91, 'Best People', 'Team Motivation & Proactiveness ,Share knowledge with colleagues  (training to regional CET)\r\nDevelop succession planning and backup following 5:3:1 model\r\nSelf Development,Late Attendance hindering deliverables\r\nAvoiding Unplanned leaves ,Ensuring Work place ethics', 'Appropriate back up plan should be documented / training provided.\r\nRegularly conduct team meetings understand their grievances & take corrective action.\r\nBe a Mentor. Encourage Buddy Processing & train the New / Low perfomers to acheive higher standards.\r\nTrain the Leaders to become better Leaders & ensure Team members are growing.\r\nEncourging the Team members for all Cross functional activites & drive it for their improvement', 'Ensure Team members are punctual to office & adheres to Company policies & regulations.\r\nRegularly conduct team meetings understand their grievances & take corrective action.\r\nAim to acheive more & move up in the ladder by taking more responsibilites as is required for your next role.\r\nPlan my leaves with prior intimation to my reporting Manager.\r\nEnsure to maintain a clear desk by your Team members and avoid chits chats during office hours.\r\nBe a Mentor. Encourage Buddy Processing & train the New / Low perfomers to acheive higher standards.\r\nTrain the Leaders to become better Leaders & ensure Team members are growing.', 'Daily', 'Adhere to Company Policies & regulations\r\n10% increase in GPS Scores vs last year / above treshold for Randstad India\r\nSuccession planning for self and TMs', '> 90 % GPS scores in all dimensions', 'Manual', '20%', '1', 'HR Augustin', '2022-08-02 13:21:03', '2022-08-02 13:21:03'),
(92, 'Shared Goals', 'Lead system enhancement in Paybill ensuring 100% compliance \r\nMonitor & adhere to 100% Accurate, On time statutory remittance and issual of Form 16', 'Ensure to dig deep & arrest the deviations.Remove unwanted reports from Paybill which will help in friction free process.\r\nForm 16  & 24Q from Paybill, Investment portal enhancement should be carried out.On time generation, validation & reconcilation of Statutory reports to ensure NIL deviation from Statutory guidelines\r\nEnsuring the KCF guidelines are adhered on day to day basis with a strignent control.\r\nBetter Team Control which will in turn help in overall development\r\nEncourging the Team members for all Cross functional activites & drive it for their improvement\r\nAscertain the Time study of the process & have optimal resources required.', 'Reduction in > 45 days onboarding - by  25% by Q2 , progressively to reach 90% by Q4 \r\nReduction in rework\r\nF&F end to end completion and payout within 30 days from LWD / Date of intimation                             Payment of Bonus Act , Payment of Wages Act.', 'Monthly', '0.95', '> 95 %', 'System / Manual', '20%', '1', 'HR Augustin', '2022-08-02 13:21:41', '2022-08-02 13:21:41'),
(93, 'Finance', 'Ensuring Timely payout to employees (Target > 95%)\r\nAdherence to Statutory & Compliance regulations \r\nZero KCF in < 3 rating                                                                                                                                     10% FTE Efficiency on the budgeted FTEs for 2018', 'Adherence to Statutory & Compliance regulations \r\nKCF/RR: reduce 0-1-2 ratings in KCF by Q4 assessment                                                                                                   \r\nBottom line impact', 'Rollover by 5th of everymonth\r\nFollow a comprehensive checklist & ensure NIL deviations to Statutory & compliance norms.\r\nTimely reports to Finance Team as per the requirement.\r\nConcerns raised on KCF to be ascertained & gaps in the process to be arrested. Aim to have all KCF points under 4 or 5 category by Q4', 'Monthly', '100% Compliance', '> 10% FTE efficiency', 'System / Manual', '15%', '1', 'HR Augustin', '2022-08-02 13:21:41', '2022-08-02 13:21:41'),
(94, 'Customer', 'Improve Payroll TAT  - raise the bar from 24 hours to 8 hours (Target 100%)                          Improve F n F TAT - Raise the bar from 4 days to 2 days ( Target 100%)\r\nQuality of deliverables  -- Reduction in error rates to less than 0.1% (Target 100%)\r\nTimely Query handling  - REsponse to queries in 24 hours both to EWs and Internal (Target 100%)\r\nTax Related (Insource Proof Verification & Form 16) (Taget 100%)', 'Drive Improvement on Input Adherance (Target > 85%)\r\nImprove Payroll TAT (Target 100%)\r\nQuality of deliverables (Target 100%)\r\nTimely Query handling (Target 100%)\r\nTax Related (Insource Proof Verification & Form 16) Target 100%', 'Monitor the Team\'s ability to track the Input delays of your Clients & take remedial action to improve their timely adherence through proactive mails, regular concalls, etc. Jump to action when Client is not adhereing to timelines.\r\nConduct regular calls with Clients & understand their pain areas. Take remedial action & improve upon. Records the minutes & circulate with action plan.\r\nEnsure friction free delivery by completing the task within TAT by regularly monitoring through AICP Tracker.\r\nCultivate First time Right culture amongst Team members\r\nMonitor & ensure Queries of consultants / clients / employees are handled within TAT with appropriate & relevant response.\r\nInsource Tax Proof verification & Form 16 activity. Ensure timely issual of Form 16 for employees with ZERO defect & NIL cost concerns (+ve tax)', 'Daily', 'TAT : 100%\r\nQuality : 100%\r\nTax Proof  : 100%', 'Input Adherence : 95%\r\n\r\nTAT : 100%\r\nQuality : 100%', 'System / Manual', '25%', '1', 'HR Augustin', '2022-08-02 13:21:41', '2022-08-02 13:21:41'),
(95, 'Process', 'No Rework in processing (Target <1%)\r\nCI - Project - Reimbursement Automation & CSSL Reimbursement Automation\r\n100% of staff lean trained', 'Awareness and Adherence to Quality Processes without compromising on Compliance (Target 100%)\r\nPerformance & Cross Functional activities\r\nNo Rework in processing (Target <1%)\r\nProcess Improvement ( Implemented Ideas)\r\nAutomation of Reimbursement Process', 'Acheive & sustain 100% in Quality of deliverables (Measured through Internal & external trackers)\r\nSupport within process (not individuals) at the time of crisis.\r\nArrest the gap which results in re-work & discuss with Team members / Consultants for further action.\r\nImprovement in the existing process is very vital. Ensure Team members contribute more ideas which ideally converts into reduction of FTE\'s / improve the Quality of deliverable.', 'Daily', 'Quality : 100%\r\nRe-work : 1%', 'Quality : 100%\r\nRe-work : 1%', 'Measured through Internal & external trackers', '20%', '1', 'HR Augustin', '2022-08-02 13:21:41', '2022-08-02 13:21:41'),
(96, 'Best People', 'Team Motivation & Proactiveness ,Share knowledge with colleagues  (training to regional CET)\r\nDevelop succession planning and backup following 5:3:1 model\r\nSelf Development,Late Attendance hindering deliverables\r\nAvoiding Unplanned leaves ,Ensuring Work place ethics', 'Appropriate back up plan should be documented / training provided.\r\nRegularly conduct team meetings understand their grievances & take corrective action.\r\nBe a Mentor. Encourage Buddy Processing & train the New / Low perfomers to acheive higher standards.\r\nTrain the Leaders to become better Leaders & ensure Team members are growing.\r\nEncourging the Team members for all Cross functional activites & drive it for their improvement', 'Ensure Team members are punctual to office & adheres to Company policies & regulations.\r\nRegularly conduct team meetings understand their grievances & take corrective action.\r\nAim to acheive more & move up in the ladder by taking more responsibilites as is required for your next role.\r\nPlan my leaves with prior intimation to my reporting Manager.\r\nEnsure to maintain a clear desk by your Team members and avoid chits chats during office hours.\r\nBe a Mentor. Encourage Buddy Processing & train the New / Low perfomers to acheive higher standards.\r\nTrain the Leaders to become better Leaders & ensure Team members are growing.', 'Daily', 'Adhere to Company Policies & regulations\r\n10% increase in GPS Scores vs last year / above treshold for Randstad India\r\nSuccession planning for self and TMs', '> 90 % GPS scores in all dimensions', 'Manual', '20%', '1', 'HR Augustin', '2022-08-02 13:21:41', '2022-08-02 13:21:41'),
(97, 'Shared Goals', 'Lead system enhancement in Paybill ensuring 100% compliance \r\nMonitor & adhere to 100% Accurate, On time statutory remittance and issual of Form 16', 'Ensure to dig deep & arrest the deviations.Remove unwanted reports from Paybill which will help in friction free process.\r\nForm 16  & 24Q from Paybill, Investment portal enhancement should be carried out.On time generation, validation & reconcilation of Statutory reports to ensure NIL deviation from Statutory guidelines\r\nEnsuring the KCF guidelines are adhered on day to day basis with a strignent control.\r\nBetter Team Control which will in turn help in overall development\r\nEncourging the Team members for all Cross functional activites & drive it for their improvement\r\nAscertain the Time study of the process & have optimal resources required.', 'Reduction in > 45 days onboarding - by  25% by Q2 , progressively to reach 90% by Q4 \r\nReduction in rework\r\nF&F end to end completion and payout within 30 days from LWD / Date of intimation                             Payment of Bonus Act , Payment of Wages Act.', 'Monthly', '0.95', '> 95 %', 'System / Manual', '20%', '1', 'HR Augustin', '2022-08-04 14:05:28', '2022-08-04 14:05:28'),
(98, 'Finance', 'Ensuring Timely payout to employees (Target > 95%)\r\nAdherence to Statutory & Compliance regulations \r\nZero KCF in < 3 rating                                                                                                                                     10% FTE Efficiency on the budgeted FTEs for 2018', 'Adherence to Statutory & Compliance regulations \r\nKCF/RR: reduce 0-1-2 ratings in KCF by Q4 assessment                                                                                                   \r\nBottom line impact', 'Rollover by 5th of everymonth\r\nFollow a comprehensive checklist & ensure NIL deviations to Statutory & compliance norms.\r\nTimely reports to Finance Team as per the requirement.\r\nConcerns raised on KCF to be ascertained & gaps in the process to be arrested. Aim to have all KCF points under 4 or 5 category by Q4', 'Monthly', '100% Compliance', '> 10% FTE efficiency', 'System / Manual', '15%', '1', 'HR Augustin', '2022-08-04 14:05:28', '2022-08-04 14:05:28'),
(99, 'Customer', 'Improve Payroll TAT  - raise the bar from 24 hours to 8 hours (Target 100%)                          Improve F n F TAT - Raise the bar from 4 days to 2 days ( Target 100%)\r\nQuality of deliverables  -- Reduction in error rates to less than 0.1% (Target 100%)\r\nTimely Query handling  - REsponse to queries in 24 hours both to EWs and Internal (Target 100%)\r\nTax Related (Insource Proof Verification & Form 16) (Taget 100%)', 'Drive Improvement on Input Adherance (Target > 85%)\r\nImprove Payroll TAT (Target 100%)\r\nQuality of deliverables (Target 100%)\r\nTimely Query handling (Target 100%)\r\nTax Related (Insource Proof Verification & Form 16) Target 100%', 'Monitor the Team\'s ability to track the Input delays of your Clients & take remedial action to improve their timely adherence through proactive mails, regular concalls, etc. Jump to action when Client is not adhereing to timelines.\r\nConduct regular calls with Clients & understand their pain areas. Take remedial action & improve upon. Records the minutes & circulate with action plan.\r\nEnsure friction free delivery by completing the task within TAT by regularly monitoring through AICP Tracker.\r\nCultivate First time Right culture amongst Team members\r\nMonitor & ensure Queries of consultants / clients / employees are handled within TAT with appropriate & relevant response.\r\nInsource Tax Proof verification & Form 16 activity. Ensure timely issual of Form 16 for employees with ZERO defect & NIL cost concerns (+ve tax)', 'Daily', 'TAT : 100%\r\nQuality : 100%\r\nTax Proof  : 100%', 'Input Adherence : 95%\r\n\r\nTAT : 100%\r\nQuality : 100%', 'System / Manual', '25%', '1', 'HR Augustin', '2022-08-04 14:05:28', '2022-08-04 14:05:28'),
(100, 'Process', 'No Rework in processing (Target <1%)\r\nCI - Project - Reimbursement Automation & CSSL Reimbursement Automation\r\n100% of staff lean trained', 'Awareness and Adherence to Quality Processes without compromising on Compliance (Target 100%)\r\nPerformance & Cross Functional activities\r\nNo Rework in processing (Target <1%)\r\nProcess Improvement ( Implemented Ideas)\r\nAutomation of Reimbursement Process', 'Acheive & sustain 100% in Quality of deliverables (Measured through Internal & external trackers)\r\nSupport within process (not individuals) at the time of crisis.\r\nArrest the gap which results in re-work & discuss with Team members / Consultants for further action.\r\nImprovement in the existing process is very vital. Ensure Team members contribute more ideas which ideally converts into reduction of FTE\'s / improve the Quality of deliverable.', 'Daily', 'Quality : 100%\r\nRe-work : 1%', 'Quality : 100%\r\nRe-work : 1%', 'Measured through Internal & external trackers', '20%', '1', 'HR Augustin', '2022-08-04 14:05:28', '2022-08-04 14:05:28'),
(101, 'Best People', 'Team Motivation & Proactiveness ,Share knowledge with colleagues  (training to regional CET)\r\nDevelop succession planning and backup following 5:3:1 model\r\nSelf Development,Late Attendance hindering deliverables\r\nAvoiding Unplanned leaves ,Ensuring Work place ethics', 'Appropriate back up plan should be documented / training provided.\r\nRegularly conduct team meetings understand their grievances & take corrective action.\r\nBe a Mentor. Encourage Buddy Processing & train the New / Low perfomers to acheive higher standards.\r\nTrain the Leaders to become better Leaders & ensure Team members are growing.\r\nEncourging the Team members for all Cross functional activites & drive it for their improvement', 'Ensure Team members are punctual to office & adheres to Company policies & regulations.\r\nRegularly conduct team meetings understand their grievances & take corrective action.\r\nAim to acheive more & move up in the ladder by taking more responsibilites as is required for your next role.\r\nPlan my leaves with prior intimation to my reporting Manager.\r\nEnsure to maintain a clear desk by your Team members and avoid chits chats during office hours.\r\nBe a Mentor. Encourage Buddy Processing & train the New / Low perfomers to acheive higher standards.\r\nTrain the Leaders to become better Leaders & ensure Team members are growing.', 'Daily', 'Adhere to Company Policies & regulations\r\n10% increase in GPS Scores vs last year / above treshold for Randstad India\r\nSuccession planning for self and TMs', '> 90 % GPS scores in all dimensions', 'Manual', '20%', '1', 'HR Augustin', '2022-08-04 14:05:28', '2022-08-04 14:05:28'),
(102, 'Shared Goals', 'Lead system enhancement in Paybill ensuring 100% compliance \r\nMonitor & adhere to 100% Accurate, On time statutory remittance and issual of Form 16', 'Ensure to dig deep & arrest the deviations.Remove unwanted reports from Paybill which will help in friction free process.\r\nForm 16  & 24Q from Paybill, Investment portal enhancement should be carried out.On time generation, validation & reconcilation of Statutory reports to ensure NIL deviation from Statutory guidelines\r\nEnsuring the KCF guidelines are adhered on day to day basis with a strignent control.\r\nBetter Team Control which will in turn help in overall development\r\nEncourging the Team members for all Cross functional activites & drive it for their improvement\r\nAscertain the Time study of the process & have optimal resources required.', 'Reduction in > 45 days onboarding - by  25% by Q2 , progressively to reach 90% by Q4 \r\nReduction in rework\r\nF&F end to end completion and payout within 30 days from LWD / Date of intimation                             Payment of Bonus Act , Payment of Wages Act.', 'Monthly', '0.95', '> 95 %', 'System / Manual', '20%', '1', 'HR Augustin', '2022-08-04 14:06:30', '2022-08-04 14:06:30'),
(103, 'Finance', 'Ensuring Timely payout to employees (Target > 95%)\r\nAdherence to Statutory & Compliance regulations \r\nZero KCF in < 3 rating                                                                                                                                     10% FTE Efficiency on the budgeted FTEs for 2018', 'Adherence to Statutory & Compliance regulations \r\nKCF/RR: reduce 0-1-2 ratings in KCF by Q4 assessment                                                                                                   \r\nBottom line impact', 'Rollover by 5th of everymonth\r\nFollow a comprehensive checklist & ensure NIL deviations to Statutory & compliance norms.\r\nTimely reports to Finance Team as per the requirement.\r\nConcerns raised on KCF to be ascertained & gaps in the process to be arrested. Aim to have all KCF points under 4 or 5 category by Q4', 'Monthly', '100% Compliance', '> 10% FTE efficiency', 'System / Manual', '15%', '1', 'HR Augustin', '2022-08-04 14:06:30', '2022-08-04 14:06:30'),
(104, 'Customer', 'Improve Payroll TAT  - raise the bar from 24 hours to 8 hours (Target 100%)                          Improve F n F TAT - Raise the bar from 4 days to 2 days ( Target 100%)\r\nQuality of deliverables  -- Reduction in error rates to less than 0.1% (Target 100%)\r\nTimely Query handling  - REsponse to queries in 24 hours both to EWs and Internal (Target 100%)\r\nTax Related (Insource Proof Verification & Form 16) (Taget 100%)', 'Drive Improvement on Input Adherance (Target > 85%)\r\nImprove Payroll TAT (Target 100%)\r\nQuality of deliverables (Target 100%)\r\nTimely Query handling (Target 100%)\r\nTax Related (Insource Proof Verification & Form 16) Target 100%', 'Monitor the Team\'s ability to track the Input delays of your Clients & take remedial action to improve their timely adherence through proactive mails, regular concalls, etc. Jump to action when Client is not adhereing to timelines.\r\nConduct regular calls with Clients & understand their pain areas. Take remedial action & improve upon. Records the minutes & circulate with action plan.\r\nEnsure friction free delivery by completing the task within TAT by regularly monitoring through AICP Tracker.\r\nCultivate First time Right culture amongst Team members\r\nMonitor & ensure Queries of consultants / clients / employees are handled within TAT with appropriate & relevant response.\r\nInsource Tax Proof verification & Form 16 activity. Ensure timely issual of Form 16 for employees with ZERO defect & NIL cost concerns (+ve tax)', 'Daily', 'TAT : 100%\r\nQuality : 100%\r\nTax Proof  : 100%', 'Input Adherence : 95%\r\n\r\nTAT : 100%\r\nQuality : 100%', 'System / Manual', '25%', '1', 'HR Augustin', '2022-08-04 14:06:30', '2022-08-04 14:06:30'),
(105, 'Process', 'No Rework in processing (Target <1%)\r\nCI - Project - Reimbursement Automation & CSSL Reimbursement Automation\r\n100% of staff lean trained', 'Awareness and Adherence to Quality Processes without compromising on Compliance (Target 100%)\r\nPerformance & Cross Functional activities\r\nNo Rework in processing (Target <1%)\r\nProcess Improvement ( Implemented Ideas)\r\nAutomation of Reimbursement Process', 'Acheive & sustain 100% in Quality of deliverables (Measured through Internal & external trackers)\r\nSupport within process (not individuals) at the time of crisis.\r\nArrest the gap which results in re-work & discuss with Team members / Consultants for further action.\r\nImprovement in the existing process is very vital. Ensure Team members contribute more ideas which ideally converts into reduction of FTE\'s / improve the Quality of deliverable.', 'Daily', 'Quality : 100%\r\nRe-work : 1%', 'Quality : 100%\r\nRe-work : 1%', 'Measured through Internal & external trackers', '20%', '1', 'HR Augustin', '2022-08-04 14:06:30', '2022-08-04 14:06:30'),
(106, 'Best People', 'Team Motivation & Proactiveness ,Share knowledge with colleagues  (training to regional CET)\r\nDevelop succession planning and backup following 5:3:1 model\r\nSelf Development,Late Attendance hindering deliverables\r\nAvoiding Unplanned leaves ,Ensuring Work place ethics', 'Appropriate back up plan should be documented / training provided.\r\nRegularly conduct team meetings understand their grievances & take corrective action.\r\nBe a Mentor. Encourage Buddy Processing & train the New / Low perfomers to acheive higher standards.\r\nTrain the Leaders to become better Leaders & ensure Team members are growing.\r\nEncourging the Team members for all Cross functional activites & drive it for their improvement', 'Ensure Team members are punctual to office & adheres to Company policies & regulations.\r\nRegularly conduct team meetings understand their grievances & take corrective action.\r\nAim to acheive more & move up in the ladder by taking more responsibilites as is required for your next role.\r\nPlan my leaves with prior intimation to my reporting Manager.\r\nEnsure to maintain a clear desk by your Team members and avoid chits chats during office hours.\r\nBe a Mentor. Encourage Buddy Processing & train the New / Low perfomers to acheive higher standards.\r\nTrain the Leaders to become better Leaders & ensure Team members are growing.', 'Daily', 'Adhere to Company Policies & regulations\r\n10% increase in GPS Scores vs last year / above treshold for Randstad India\r\nSuccession planning for self and TMs', '> 90 % GPS scores in all dimensions', 'Manual', '20%', '1', 'HR Augustin', '2022-08-04 14:06:30', '2022-08-04 14:06:30');

-- --------------------------------------------------------

--
-- Table structure for table `vmt_pms_kpiform`
--

CREATE TABLE `vmt_pms_kpiform` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `available_columns` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vmt_pms_kpiform_assigned`
--

CREATE TABLE `vmt_pms_kpiform_assigned` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vmt_pms_kpiform_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `assignee_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `reviewer_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `assigner_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `calendar_type` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `frequency` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `assignment_period` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vmt_pms_kpiform_details`
--

CREATE TABLE `vmt_pms_kpiform_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vmt_pms_kpiform_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dimension` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kpi` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operational_definition` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `measure` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `frequency` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stretch_target` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kpi_weightage` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vmt_pms_kpiform_reviews`
--

CREATE TABLE `vmt_pms_kpiform_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vmt_pms_kpiform_assigned_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `assignee_kpi_review` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `assignee_kpi_percentage` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `assignee_kpi_comments` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `reviewer_kpi_review` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `reviewer_kpi_percentage` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `reviewer_kpi_comments` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `reviewer_appraisal_comments` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `assigner_kpi_review` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `assigner_kpi_percentage` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `assigner_kpi_comments` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `assignee_kpi_status` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_assignee_submitted` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_assignee_accepted` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `reviewer_kpi_status` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_reviewer_submitted` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_reviewer_accepted` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `assignee_rejection_comments` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `reviewer_rejection_comments` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `overall_score` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vmt_reviewforms`
--

CREATE TABLE `vmt_reviewforms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `questions` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` int(11) NOT NULL,
  `author_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vmt_reviewforms`
--

INSERT INTO `vmt_reviewforms` (`id`, `name`, `questions`, `author_id`, `author_name`, `created_at`, `updated_at`) VALUES
(1, 'Form 1', '1,2,3', 2, 'praveen', '2022-05-20 07:00:37', '2022-05-22 02:02:38'),
(2, 'Form 2', '2', 1, 'admin', '2022-05-23 10:13:44', '2022-05-23 10:14:08');

-- --------------------------------------------------------

--
-- Table structure for table `vmt_reviewquestions`
--

CREATE TABLE `vmt_reviewquestions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_1` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `option_3` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `option_4` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `option_5` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` int(11) NOT NULL,
  `author_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vmt_reviewquestions`
--

INSERT INTO `vmt_reviewquestions` (`id`, `question`, `option_1`, `option_2`, `option_3`, `option_4`, `option_5`, `answer`, `author_id`, `author_name`, `created_at`, `updated_at`) VALUES
(1, '1THis is a test question', 'op1', 'op2', 'op3', 'op4', 'op5', 'op12345', 1, 'admin', '2022-05-18 03:53:25', '2022-05-19 00:15:44'),
(2, 'This is question 2222', 'op11', 'op22', 'op33', 'op44', 'op55', 'op33', 1, 'admin', '2022-05-18 03:53:57', '2022-05-18 03:54:13'),
(3, 'Q 3', '111', '222', '333', '444', '555', '444', 2, 'praveen', '2022-05-22 02:00:48', '2022-05-22 02:00:48');

-- --------------------------------------------------------

--
-- Table structure for table `vmt_reviewuserforms`
--

CREATE TABLE `vmt_reviewuserforms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vmt_reviewuserforms`
--

INSERT INTO `vmt_reviewuserforms` (`id`, `form_id`, `user_id`, `created_at`, `updated_at`) VALUES
(11, 1, 1, '2022-05-31 12:17:33', '2022-05-31 12:17:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_list`
--
ALTER TABLE `bank_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries_list`
--
ALTER TABLE `countries_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `polling_questions`
--
ALTER TABLE `polling_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poll_voting_details`
--
ALTER TABLE `poll_voting_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vmt_announcement`
--
ALTER TABLE `vmt_announcement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_asset_inventories`
--
ALTER TABLE `vmt_asset_inventories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_client_master`
--
ALTER TABLE `vmt_client_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_config_master`
--
ALTER TABLE `vmt_config_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_config_pms`
--
ALTER TABLE `vmt_config_pms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_dashboard_posts`
--
ALTER TABLE `vmt_dashboard_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_department`
--
ALTER TABLE `vmt_department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_employee_actions`
--
ALTER TABLE `vmt_employee_actions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_employee_attendance`
--
ALTER TABLE `vmt_employee_attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_employee_compensatory_details`
--
ALTER TABLE `vmt_employee_compensatory_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_employee_details`
--
ALTER TABLE `vmt_employee_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_employee_experiences`
--
ALTER TABLE `vmt_employee_experiences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_employee_hierarchies`
--
ALTER TABLE `vmt_employee_hierarchies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_employee_office_details`
--
ALTER TABLE `vmt_employee_office_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_employee_payslip`
--
ALTER TABLE `vmt_employee_payslip`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_employee_pms_goals_table`
--
ALTER TABLE `vmt_employee_pms_goals_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_client_master`
--
ALTER TABLE `vmt_client_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_general_settings`
--
ALTER TABLE `vmt_general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_holidays`
--
ALTER TABLE `vmt_holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_kpi_form_table`
--
ALTER TABLE `vmt_kpi_form_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_kpi_table`
--
ALTER TABLE `vmt_kpi_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_leaves`
--
ALTER TABLE `vmt_leaves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_performance_apraisal_questions`
--
ALTER TABLE `vmt_performance_apraisal_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_pms_kpiform`
--
ALTER TABLE `vmt_pms_kpiform`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_pms_kpiform_assigned`
--
ALTER TABLE `vmt_pms_kpiform_assigned`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_pms_kpiform_details`
--
ALTER TABLE `vmt_pms_kpiform_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_pms_kpiform_reviews`
--
ALTER TABLE `vmt_pms_kpiform_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_reviewforms`
--
ALTER TABLE `vmt_reviewforms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_reviewquestions`
--
ALTER TABLE `vmt_reviewquestions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmt_reviewuserforms`
--
ALTER TABLE `vmt_reviewuserforms`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_list`
--
ALTER TABLE `bank_list`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `countries_list`
--
ALTER TABLE `countries_list`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=497;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `polling_questions`
--
ALTER TABLE `polling_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `poll_voting_details`
--
ALTER TABLE `poll_voting_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `vmt_announcement`
--
ALTER TABLE `vmt_announcement`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vmt_asset_inventories`
--
ALTER TABLE `vmt_asset_inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vmt_client_master`
--
ALTER TABLE `vmt_client_master`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `vmt_config_master`
--
ALTER TABLE `vmt_config_master`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vmt_config_pms`
--
ALTER TABLE `vmt_config_pms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vmt_dashboard_posts`
--
ALTER TABLE `vmt_dashboard_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `vmt_department`
--
ALTER TABLE `vmt_department`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vmt_employee_actions`
--
ALTER TABLE `vmt_employee_actions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vmt_employee_attendance`
--
ALTER TABLE `vmt_employee_attendance`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `vmt_employee_compensatory_details`
--
ALTER TABLE `vmt_employee_compensatory_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `vmt_employee_details`
--
ALTER TABLE `vmt_employee_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `vmt_employee_experiences`
--
ALTER TABLE `vmt_employee_experiences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vmt_employee_hierarchies`
--
ALTER TABLE `vmt_employee_hierarchies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `vmt_employee_office_details`
--
ALTER TABLE `vmt_employee_office_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `vmt_employee_payslip`
--
ALTER TABLE `vmt_employee_payslip`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vmt_employee_pms_goals_table`
--
ALTER TABLE `vmt_employee_pms_goals_table`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `vmt_client_master`
--
ALTER TABLE `vmt_client_master`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vmt_general_settings`
--
ALTER TABLE `vmt_general_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vmt_holidays`
--
ALTER TABLE `vmt_holidays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vmt_kpi_form_table`
--
ALTER TABLE `vmt_kpi_form_table`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vmt_kpi_table`
--
ALTER TABLE `vmt_kpi_table`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `vmt_leaves`
--
ALTER TABLE `vmt_leaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vmt_performance_apraisal_questions`
--
ALTER TABLE `vmt_performance_apraisal_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `vmt_pms_kpiform`
--
ALTER TABLE `vmt_pms_kpiform`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vmt_pms_kpiform_assigned`
--
ALTER TABLE `vmt_pms_kpiform_assigned`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vmt_pms_kpiform_details`
--
ALTER TABLE `vmt_pms_kpiform_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vmt_pms_kpiform_reviews`
--
ALTER TABLE `vmt_pms_kpiform_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vmt_reviewforms`
--
ALTER TABLE `vmt_reviewforms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vmt_reviewquestions`
--
ALTER TABLE `vmt_reviewquestions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vmt_reviewuserforms`
--
ALTER TABLE `vmt_reviewuserforms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
