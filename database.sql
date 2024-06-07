-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 04, 2024 at 02:32 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clear_template`
--

-- --------------------------------------------------------

--
-- Table structure for table `localizations`
--

CREATE TABLE `localizations` (
  `id` tinyint UNSIGNED NOT NULL,
  `code` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `removed` tinyint UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `localizations`
--

INSERT INTO `localizations` (`id`, `code`, `name`, `title`, `active`, `removed`) VALUES
(1, 'cs_CZ', 'čeština', 'česky', 1, 0),
(2, 'en_GB', 'angličtina', 'english', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` smallint UNSIGNED NOT NULL,
  `user_id` smallint UNSIGNED DEFAULT NULL,
  `parent_page_id` smallint UNSIGNED DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uri_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gallery_id` smallint UNSIGNED DEFAULT NULL,
  `image_uri` char(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rank` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `icon_class` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_page` tinyint(1) NOT NULL DEFAULT '0',
  `is_parent_page` tinyint(1) NOT NULL DEFAULT '0',
  `is_account_page` tinyint(1) NOT NULL DEFAULT '0',
  `nav_top` tinyint(1) NOT NULL DEFAULT '0',
  `nav_bottom` tinyint(1) NOT NULL DEFAULT '0',
  `nav_user` tinyint(1) NOT NULL DEFAULT '0',
  `nav_important` tinyint(1) DEFAULT '0',
  `in_sitemap` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `top` tinyint(1) NOT NULL DEFAULT '0',
  `seo_page` tinyint(1) DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `removed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `user_id`, `parent_page_id`, `name`, `uri_name`, `admin_name`, `gallery_id`, `image_uri`, `template`, `rank`, `icon_class`, `is_page`, `is_parent_page`, `is_account_page`, `nav_top`, `nav_bottom`, `nav_user`, `nav_important`, `in_sitemap`, `active`, `top`, `seo_page`, `create_time`, `update_time`, `note`, `removed`) VALUES
(1, NULL, NULL, 'Neexistující stránka', NULL, NULL, NULL, NULL, '', 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, '0000-00-00 00:00:00', '2022-11-21 08:00:00', '', 0),
(2, NULL, NULL, 'Úvod', NULL, NULL, NULL, NULL, '', 0, NULL, 0, 0, 0, 1, 1, 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', '2023-03-01 10:51:56', '', 0),
(3, NULL, NULL, 'Mapa webu', NULL, NULL, NULL, NULL, '', 0, NULL, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', '2022-11-21 08:00:00', '', 0),
(4, NULL, NULL, 'Obchodní podmínky', NULL, NULL, NULL, NULL, '', 10, NULL, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', '2022-11-21 08:00:00', '', 0),
(5, NULL, NULL, 'Zpracování osobních údajů', NULL, NULL, NULL, NULL, '', 0, NULL, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', '2022-11-21 08:00:00', '', 0),
(6, NULL, NULL, 'O nás', NULL, NULL, NULL, NULL, '', 20, NULL, 0, 0, 0, 1, 0, 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', '2022-11-21 08:00:00', '', 0),
(7, NULL, NULL, 'Kontakt', NULL, NULL, NULL, NULL, '', 99, NULL, 0, 0, 0, 1, 0, 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', '2022-11-21 08:00:00', '', 0),
(8, NULL, NULL, 'Služby', NULL, NULL, NULL, NULL, '', 30, NULL, 0, 1, 0, 1, 0, 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', '2022-11-21 08:00:00', '', 0),
(9, NULL, 8, 'Bytový design', '', NULL, NULL, NULL, '', 1, NULL, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', '2023-03-01 10:07:13', '', 0),
(10, NULL, 8, 'Komerční design', NULL, NULL, NULL, NULL, '', 5, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '2022-11-21 08:00:00', '', 0),
(11, NULL, 8, 'Řemeslné práce', NULL, NULL, NULL, NULL, '', 15, NULL, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', '2022-11-21 08:00:00', '', 0),
(12, NULL, 8, 'Truhlářské práce', NULL, NULL, NULL, NULL, '', 10, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, '0000-00-00 00:00:00', '2022-11-21 08:00:00', '', 0),
(13, NULL, 11, 'Elektrikářské práce', NULL, NULL, NULL, NULL, '', 0, NULL, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', '2022-11-21 08:00:00', '&lt;p&gt;zz&lt;/p&gt;', 0),
(14, NULL, 11, 'Instalatérské práce', NULL, NULL, NULL, NULL, '', 0, NULL, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', '2022-11-21 08:00:00', '', 0),
(15, NULL, 11, 'Zednické práce', NULL, NULL, NULL, NULL, '', 0, NULL, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', '2022-11-21 08:00:00', '', 0),
(16, NULL, 11, 'Kominické práce', NULL, NULL, NULL, NULL, '', 0, NULL, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', '2022-11-21 08:00:00', '', 0),
(17, NULL, NULL, 'Realizace', NULL, NULL, NULL, NULL, '', 50, NULL, 0, 0, 0, 1, 1, 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', '2022-11-21 08:00:00', '', 0),
(18, NULL, NULL, 'Detail realizace', NULL, NULL, NULL, NULL, '', 0, NULL, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', '2022-11-21 08:00:00', '', 0),
(19, NULL, NULL, 'Poptávka', NULL, NULL, NULL, NULL, '', 80, NULL, 0, 0, 0, 1, 1, 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', '2022-11-21 08:00:00', '', 0),
(20, NULL, 11, 'Malíři', NULL, NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, '2023-09-07 12:43:19', '0000-00-00 00:00:00', '', 0),
(21, NULL, 11, 'Sádrokarton', NULL, NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, '2023-09-07 12:43:19', '0000-00-00 00:00:00', '', 0),
(22, NULL, NULL, 'Typy realizací', NULL, NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-10-03 10:46:50', '0000-00-00 00:00:00', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pages_translations`
--

CREATE TABLE `pages_translations` (
  `id` smallint UNSIGNED NOT NULL,
  `page_id` smallint UNSIGNED DEFAULT NULL,
  `localization` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `btn` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `meta_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `pages_translations`
--

INSERT INTO `pages_translations` (`id`, `page_id`, `localization`, `name`, `title`, `subtitle`, `btn`, `content`, `meta_title`, `meta_description`, `uri`) VALUES
(1, 1, 'cs_CZ', 'Neexistující stránka', 'Neexistující stránka', '', '', '', '', '', NULL),
(2, 2, 'cs_CZ', 'Úvod', 'Úvod', '', '', '', '', '', NULL),
(3, 3, 'cs_CZ', 'Mapa webu', 'Mapa webu', '', '', '', '', '', 'mapa-webu'),
(4, 4, 'cs_CZ', 'Obchodní podmínky', 'Obchodní podmínky', '', '', '', '', '', 'obchodni-podminky'),
(5, 5, 'cs_CZ', 'Zpracování osobních údajů', 'Zpracování osobních údajů', '', '', '', '', '', 'zpracovani-os-udaju'),
(6, 6, 'cs_CZ', 'O nás', 'O nás', 'Kdo jsme', '', '<p>Jsme parta lidí sdílející stejné nadšení a zápal. Každý je mistrem ve svém oboru, a proto dohromady tvoříme tým, který se dokáže postarat o celý proces od vizualizace, výroby nábytku, přes novou podlahu, výměnu kotle, až po předání na klíč.  Začínali jsme jako firma zabývající se realizací truhlářských prací. Vyrábíme od malých kusů nábytků, až po vybavení celých komerčních prostor. Za ty roky jsme dokázali projít různými výzvami, a proto si troufáme tvrdit, že dokážeme vyrobit vše co potřebujete.</p><p>Postupem času jsme k truhlářským službám začali vytvářet i vizualizace a následně realizovat i přidružené řemeslné činnosti. A nyní, jak už jsme zmínili, zajišťujeme celý proces. Ale vy si můžete vybrat.</p>', '', '', 'o-nas'),
(7, 7, 'cs_CZ', 'Kontakt', 'Kontakt', '', '', '', '', '', 'kontakt'),
(8, 8, 'cs_CZ', 'Služby', 'Služby', '', '', '', '', '', 'sluzby'),
(9, 9, 'cs_CZ', 'Bytový design', 'Bytový design', '', '', '<p>Navrhování domova je vzrušující cesta, při níž se mísí estetika, funkčnost a osobní preference, aby vznikl prostor, který skutečně odráží podstatu jeho obyvatel. V tomto komplexním průvodci moderním designem domů prozkoumáme klíčové zásady, trendy a úvahy, které přispívají k vytvoření dokonalého domova pro současné bydlení.</p>\r\n\r\n<h2>I. Porozumění vašemu životnímu stylu a potřebám</h2>\r\n<h3 class=\"title-part\">Posouzení životního stylu</h3>\r\n<p>Začněte zhodnocením svého životního stylu a zvažte faktory, jako jsou pracovní návyky, rodinná dynamika a volnočasové aktivity. Toto posouzení tvoří základ pro přizpůsobení návrhu vašeho domova konkrétním potřebám.\r\n</p>\r\n<h3 class=\"title-part\">Zajištění budoucnosti</h3>\r\n<p>\r\nPředvídejte budoucí změny a zvažte návrhy, které se mohou přizpůsobit vyvíjejícím se potřebám, aby váš domov zůstal funkční a relevantní i v příštích letech.\r\n</p>\r\n\r\n<h2>II. Využití moderních principů designu</h2>\r\n<h3 class=\"title-part\">Otevřený koncept bydlení</h3>\r\n<p>\r\nModerní domy často využívají otevřené půdorysy, které vytvářejí plynulé přechody mezi obytnými prostory. Tento design podporuje pocit prostornosti, podporuje sociální interakci a maximalizuje přirozené světlo.\r\n</p>\r\n<h3 class=\"title-part\">Čisté linie a minimalismus</h3>\r\n<p>\r\nZačlenění čistých linií a minimalistické estetiky vytváří prostředí bez nepořádku. Minimalistický design nejen zvyšuje vizuální přitažlivost, ale také podporuje pocit klidu a pořádku.\r\n</p>\r\n<h3 class=\"title-part\">Integrace technologií</h3>\r\n<p>\r\nVyužijte technologie inteligentní domácnosti pro zvýšení pohodlí a energetické účinnosti. Od automatizovaných systémů osvětlení až po inteligentní termostaty - technologie se mohou hladce integrovat do moderních návrhů domů.\r\n</p>\r\n\r\n<h2>III. Prvky interiérového designu</h2>\r\n<h3 class=\"title-part\">Barevná paleta</h3>\r\n<p>Zvolte soudržnou barevnou paletu, která odráží váš osobní styl a doplňuje celkový design. Neutrální tóny s akcentními barvami jsou oblíbenou volbou pro dosažení moderního a nadčasového vzhledu.</p>\r\n<h3 class=\"title-part\">Výběr nábytku</h3>\r\n<p>Vybírejte nábytek, který vyvažuje pohodlí a styl. Zvažte multifunkční kusy a upřednostněte kvalitu před kvantitou, abyste vytvořili sofistikovanou a příjemnou atmosféru.</p>\r\n<h3 class=\"title-part\">Design osvětlení</h3>\r\n<p>Promyšlený návrh osvětlení je zásadní pro navození atmosféry a zvýšení funkčnosti. Kombinujte ambientní, pracovní a akcentové osvětlení, abyste vytvořili dobře osvětlený a vizuálně dynamický prostor.</p>\r\n\r\n<h3>VI. Sestavování rozpočtu a řízení projektů</h3>\r\n<h3 class=\"title-part\">Sestavení rozpočtu</h3>\r\n<p>\r\nVymezte jasně svůj rozpočet a zvažte náklady na stavbu, vybavení a nepředvídané výdaje. Počítejte s určitou rezervou, jelikož se mohou v průběhu rekonstrukce a výroby měnit různé elementy projektu. \r\n</p>\r\n<h3 class=\"title-part\">Časový plán projektu</h3>\r\n<p>\r\nVymezte priority a výdaje: Vypracovat realistický časový plán pro fázi návrhu a výstavby vám pomůže náš schopný tým lidí. Spolupracujte s odborníky, včetně designérů a dodavatelů, abyste zajistili hladký a efektivní průběh projektu.\r\n</p>\r\n\r\n<h4>Závěr</h4>\r\n<p>\r\nVytvoření dokonalého domova zahrnuje křehkou rovnováhu mezi zásadami designu, funkčností a osobním vyjádřením. Pochopením svého životního stylu, přijetím moderních designových trendů, začleněním udržitelných postupů a efektivním řízením projektu můžete vytvořit domov, který bude nejen splňovat vaše potřeby, ale také odrážet váš jedinečný styl a vizi současného bydlení.\r\n</p>', '', '', 'sluzby/bytovy-design'),
(10, 10, 'cs_CZ', 'Komerční design', 'Komerční design', '', '', '', '', '', 'sluzby/komercni-design'),
(11, 11, 'cs_CZ', 'Řemeslné práce', 'Řemeslné práce, poctivost a kvalita', '', '', '<p>V rámci realizací na klíč, či rekonstrukcí, zařizujeme veškeré potřebné manuální práce. A ty vám také dokážeme nabídnout zvlášť. Protože taková výměna odpadu, nová výmalba do pokoje, či rozbitá baterie jsou běžně potřebné činnosti, která vám rádi pomůžeme vyřešit. A proto se nás nebojte oslovit. Jsme tu pro vás, abychom společně tvořili spokojené domovy kolem nás.</p><p>Zde si jen vyberte, s čím potřebujete pomoci právě vy a pak už nám stačí jen napsat nebo zavolat.</p>', '', '', 'sluzby/remeslne-prace'),
(12, 12, 'cs_CZ', 'Truhlářské práce', 'Truhlářské práce', '', '', '<p>Díky dlouholeté  praxi v oboru jsme získali zkušenosti se všemi různými materiály. Osobně zpracováváme dřevo, ocel, lamino, umělý kámen (Corian) a další. Materiály, které používáme si pečlivě vybíráme.</p><h3>Materiály</h3><p>Díky dlouholeté  praxi v oboru ( více než 15 let ) jsme získali zkušenosti se všemi různými materiály. Osobně zpracováváme dřevo, ocel, lamino, umělý kámen (Corian) a další. Materiály, které používáme si pečlivě vybíráme.</p><p>Dokážeme  vyrobit vše včas a bez výmluv. O kvalitě naší práce jsme pevně přesvědčení a proto za ní také ručíme a zároveň poskytujeme bezplatný servis. To vše po dobu pěti let od montáže!</p>', '', '', 'sluzby/truhlarske-prace'),
(13, 13, 'cs_CZ', 'Elektrikářské práce', 'Elektrikářské práce', '', '', '<p>Kompletní elektroinstalace do bytových prostor i komerčních a k tomu dodané revize.</p>\r\n<ul>\r\n<li>zjištění a odstranění závad, montáž a úprava okolí</li>\r\n<li>nové zásuvkové rozvody i rozvodové skříně</li>\r\n<li>výměna zásuvek, světel i vypínačů</li>\r\n<li>LED světla, zapojení systémů do chytrých domácností</li>\r\n<li>revize nových i stávajících okruhů</li>\r\n<li>úpravy elektroinstalace</li>\r\n</ul>\r\n', '', '', 'sluzby/elektrikarske-prace'),
(14, 14, 'cs_CZ', 'Instalatérské práce', 'Instalatérské práce', '', '', '<p>Nabízíme kompletní servis instalatérských prací - voda, topení a plyn. Rozvod vody, montáž a zapojení. A samozřejmostí jsou i konečné revize.\r\nŘešíme i  opravy, ucpaný odpad, výměny baterií, sifonů a vše, co můžete od instalatéra potřebovat.\r\n</p>', '', '', 'sluzby/instalaterske-prace'),
(15, 15, 'cs_CZ', 'Zednické práce', 'Zednické práce', '', '', '<p>V našem portfóliu služeb samozřejmě nechybí ani ty zednické, které jsou součásti všech rekonstrukcí.</p>\r\n<p>Nové obklady do kuchyní, či koupelen. Bourací práce , zapravení zdí, dorovnání nebo postavit zcela novou zeď pro nás není žádný problém. Štukování nebo nahození omítky hravě zvládneme.</p>\r\n<p>Máme zkušenosti s rekonstrukcemi koupelen, bytů, domů, zahrad, garáží, sklepů i půdních vestaveb a přestavbou bytových jader.</p>\r\n<p>Mezi další nabízené patří : betonáž podlah + schodů, betonová stěrka, nivelace podlah, výstavba kamenných stěn, kamínkový koberec, výstavba plotů, zateplení fasád, usazení oken + dveří, pokládka zámkové dlažby, renovace zahrad + terénů, výkopové práce, betonáž základů + desek.</p>', '', '', 'sluzby/zednicke-prace'),
(16, 16, 'cs_CZ', 'Kominické práce', 'Kominické práce', '', '', '<p>Potřebujete revizi komínu nebo jen vyčistit komín? Zavolejte nám a my vám kominíka pro štěstí zařídíme.</p><p>\r\nNaši kominíci zvládnou, ale i komín postavit a se vším vám poradit.</p>', '', '', 'sluzby/kominicke-prace'),
(17, 17, 'cs_CZ', 'Realizace', 'Realizace', '', '', '', '', '', 'realizace'),
(18, 18, 'cs_CZ', 'Detail realizace', 'Detail realizace', '', '', '', '', '', 'realizace/projekt/(:any)'),
(19, 19, 'cs_CZ', 'Poptávka', 'Poptávka', '', '', '', '', '', 'poptavka'),
(20, 20, 'cs_CZ', 'Malíři', 'Malíři', '', '', '<p>Kompletní malování, štukování, stěrkování a přidružené zednické práce. Netrapte se s malováním sami, zavolejte si odborníka a nechte, ať udělá práci za vás.</p>', '', '', 'sluzby/maliri'),
(21, 21, 'cs_CZ', 'Sádrokarton', 'Sádrokarton', '', '', '<p>Montáž sádrokartonových stěn i stropů do jakýkoliv prostorů. Zakomponování světel i elektroinstalace.</p>\r\n<ul>\r\n<li>podhledy</li>\r\n<li>příčky</li>\r\n<li>předstěny</li>\r\n<li>půdní vestavby</li>\r\n<li>zakufrování</li>\r\n<li>nepřímé osvětlení</li>\r\n</ul>', '', '', 'sluzby/sadrokarton'),
(22, 22, 'cs_CZ', 'Typy realizací', 'Typy realizací', '', '', '', '', '', 'typy-realizaci');

-- --------------------------------------------------------

--
-- Table structure for table `sent_forms`
--

CREATE TABLE `sent_forms` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(9) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` tinyint UNSIGNED NOT NULL,
  `data` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `data`) VALUES
(1, '{\"contact_email\": \"vyroba@es2.cz\", \"contact_phone\": \"+420 608 457 000\", \"office_address\": \"Libčická 1, Tursko\"}');

-- --------------------------------------------------------

--
-- Table structure for table `texts`
--

CREATE TABLE `texts` (
  `id` smallint UNSIGNED NOT NULL,
  `user_id` smallint UNSIGNED DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `removed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `texts`
--

INSERT INTO `texts` (`id`, `user_id`, `name`, `create_time`, `update_time`, `note`, `removed`) VALUES
(1, NULL, 'Úvod. nadpis', '2023-09-11 13:01:45', '0000-00-00 00:00:00', '', 0),
(2, NULL, 'Představení firmy (str. Úvod)', '2023-09-11 13:01:45', '0000-00-00 00:00:00', '', 0),
(3, NULL, 'Průběh spolupráce (str. Úvod)', '2023-09-20 13:43:30', '0000-00-00 00:00:00', '', 0),
(4, NULL, 'Napište nám', '2023-09-20 14:03:24', '0000-00-00 00:00:00', '', 0),
(5, NULL, 'Kontaktujte nás', '2023-09-20 14:05:40', '0000-00-00 00:00:00', '', 0),
(6, NULL, 'Představení firmy 2 (str. Úvod)', '2024-02-11 17:01:09', '0000-00-00 00:00:00', '', 0),
(7, NULL, 'CTA text', '2024-02-11 17:04:10', '0000-00-00 00:00:00', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `texts_translations`
--

CREATE TABLE `texts_translations` (
  `id` smallint UNSIGNED NOT NULL,
  `text_id` smallint UNSIGNED DEFAULT NULL,
  `localization` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `btn` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `texts_translations`
--

INSERT INTO `texts_translations` (`id`, `text_id`, `localization`, `title`, `subtitle`, `content`, `btn`) VALUES
(1, 1, 'cs_CZ', 'Návrh a realizace interierového designu', 'Jsme ES2', '', ''),
(2, 2, 'cs_CZ', 'Čím se zabýváme', '', '<p>Jsme česká firma s dlouholetou tradicí. Naše firma  je založena na základních principech osobního přístupu, spolehlivosti a kvality. Díky tomu jsme na trhu více než 15 let.</p><p>\r\nNaším hlavním pilířem byli vždy truhlářské práce, ale postupem času jsme naše služby rozšiřovali, až po realizace interiéru na klíč.</p>', ''),
(3, 3, 'cs_CZ', 'Průběh spolupráce', 'Jak budeme postupovat', '<p>Nyní vás provedeme celým procesem od poradenství, volby vhodných barvy, materiálů, konstrukcí a připravíme 3D vizualizaci nebo  zhotovíme nábytek dle vašich návrhů. Následná doprava po celé ČR, montáž a servis jsou samozřejmostí.</p>', ''),
(4, 4, 'cs_CZ', 'Napište nám', '', '<p>Potřebujete spolehlivého řemeslníka na realizaci vašich přání? Pro bezplatnou konzultaci nám napište nebo zavolejte a my vám rádi pomůžeme.</p><p>Máme tým spolehlivých truhlářů, ale pro kompletní realizace interiéru máme k dispozici i zedníky, instalatéry a elektrikáře.</p>', ''),
(5, 5, 'cs_CZ', 'Kontaktujte nás', '', '<p>Ozvat se nám můžete kdykoliv. Klidně i o víkendu.</p>', ''),
(6, 6, 'cs_CZ', 'a co děláme', '', '<p>Navrhujeme a realizujeme veškeré typy interiéru. Rezidenční i komerční.\r\nVybrat si můžete, ale třeba jen určité řemeslné činnosti. Pomůžeme s kompletní realizací nebo si u nás můžete jenom nechat vyrobit vestavěnou skříň, vymalovat pokoj, vyměnit WC a další běžně potřebné práce.\r\n</p>', ''),
(7, 7, 'cs_CZ', 'A s čím potřebujete pomoci zrovna vy?', 'Stačí jedno kliknutí a o zbytek už se postaráme my.', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `localizations`
--
ALTER TABLE `localizations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_page_id` (`parent_page_id`);

--
-- Indexes for table `pages_translations`
--
ALTER TABLE `pages_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `localization` (`localization`),
  ADD KEY `page_id` (`page_id`);

--
-- Indexes for table `sent_forms`
--
ALTER TABLE `sent_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `texts`
--
ALTER TABLE `texts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `texts_translations`
--
ALTER TABLE `texts_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `localization` (`localization`),
  ADD KEY `text_id` (`text_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `localizations`
--
ALTER TABLE `localizations`
  MODIFY `id` tinyint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `pages_translations`
--
ALTER TABLE `pages_translations`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `sent_forms`
--
ALTER TABLE `sent_forms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` tinyint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `texts`
--
ALTER TABLE `texts`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `texts_translations`
--
ALTER TABLE `texts_translations`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_ibfk_1` FOREIGN KEY (`parent_page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pages_translations`
--
ALTER TABLE `pages_translations`
  ADD CONSTRAINT `pages_translations_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pages_translations_ibfk_2` FOREIGN KEY (`localization`) REFERENCES `localizations` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `texts_translations`
--
ALTER TABLE `texts_translations`
  ADD CONSTRAINT `texts_translations_ibfk_1` FOREIGN KEY (`text_id`) REFERENCES `texts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `texts_translations_ibfk_2` FOREIGN KEY (`localization`) REFERENCES `localizations` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
