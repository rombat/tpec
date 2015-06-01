-- phpMyAdmin SQL Dump
-- version 4.3.12
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jun 08, 2015 at 07:13 AM
-- Server version: 10.0.17-MariaDB
-- PHP Version: 5.6.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tpec`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `maxminmoy_duree_commandes`(
	out jmax int,
	out jmin int,
	out jmoy float(8,2))
BEGIN
	select max(tri.diff) into jmax from (SELECT id_commande as idCom, abs(datediff((SELECT date from suivi_commande where id_etat = 1 and id_commande = idCom), (SELECT date from suivi_commande where id_etat = 2 and id_commande = idCom))) as diff from suivi_commande) as tri;
	select min(tri.diff) into jmin from (SELECT id_commande as idCom, abs(datediff((SELECT date from suivi_commande where id_etat = 1 and id_commande = idCom), (SELECT date from suivi_commande where id_etat = 2 and id_commande = idCom))) as diff from suivi_commande) as tri;
	select round(avg(tri.diff),2) into jmoy from (SELECT id_commande as idCom, abs(datediff((SELECT date from suivi_commande where id_etat = 1 and id_commande = idCom), (SELECT date from suivi_commande where id_etat = 2 and id_commande = idCom))) as diff from suivi_commande) as tri;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `maxminmoy_montant_commandes`(
	OUT cmax FLOAT(8,2),
	OUT cmin FLOAT(8,2),
	OUT cmoy FLOAT(8,2))
BEGIN
	select max(total) into cmax from commandes;
	select min(total) into cmin from commandes;
	select round(avg(total),2) into cmoy from commandes;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `nom`, `description`, `active`, `image`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Entrées', 'Retrouvez nos meilleures entrées, idéales pour se mettre en appétit!', 1, 'entrees.jpg', NULL, '2015-05-27 16:32:47', '2015-05-27 16:32:47'),
(2, 'Plats', 'Retrouvez notre sélection de recettes de plats qui flatteront vos papilles!', 1, 'plats.jpg', NULL, '2015-05-27 16:36:43', '2015-05-27 16:36:43'),
(3, 'Plats italiens', 'Les meilleures recettes venues d''Italie et spécialement sélectionnées pour vous!', 1, 'plats-italiens.jpg', 2, '2015-05-27 16:38:03', '2015-05-27 16:38:03'),
(4, 'Desserts', 'Découvrez nos gâteaux, tartes et autres desserts délicieux!', 1, 'desserts.jpg', NULL, '2015-05-27 16:46:07', '2015-05-27 16:46:07');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `prenom`) VALUES
(1, 'Lan', 'Fab'),
(2, 'Mag', 'Sab'),
(3, 'Bat', 'Rom');

-- --------------------------------------------------------

--
-- Table structure for table `commandes`
--

CREATE TABLE IF NOT EXISTS `commandes` (
  `id` int(10) NOT NULL,
  `total` float NOT NULL,
  `client_id` int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `commandes`
--

INSERT INTO `commandes` (`id`, `total`, `client_id`) VALUES
(1, 250, 1),
(2, 1, 2),
(3, 15, 1),
(4, 90, 2),
(5, 35, 1),
(7, 30, 3);

--
-- Triggers `commandes`
--
DELIMITER $$
CREATE TRIGGER `before_delete_commande` BEFORE DELETE ON `commandes`
 FOR EACH ROW begin
# Si l id de la commande avant de la delete n a pas un etat = 2 (càd expédié) dans la table suivi commande, alors message d erreur
	if old.id not in(select id_commande from suivi_commande where id_etat = 2)
    then
    	signal sqlstate '45000' set message_text = "Il est impossible de supprimer une commande qui n a pas encore été expédiée";
    end if;
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_insert_commandes` BEFORE INSERT ON `commandes`
 FOR EACH ROW BEGIN
	if (select count(suivi_commande.id_etat) from suivi_commande left join commandes on id_commande = commandes.id where client_id = new.client_id and id_commande not in(select id_commande from suivi_commande where id_etat = 2)) >= 2
	THEN
		SIGNAL SQLSTATE '45000' set MESSAGE_TEXT = "Ce client a deja 2 commandes en attente d etre expediees, il ne peut pas passer de commande";
	end if;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `conditionnements`
--

CREATE TABLE IF NOT EXISTS `conditionnements` (
  `id` int(10) unsigned NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `conditionnements`
--

INSERT INTO `conditionnements` (`id`, `nom`, `created_at`, `updated_at`) VALUES
(1, 'Sachet de 250g', '2015-05-27 16:02:45', '2015-05-27 16:02:45'),
(2, 'Sachet de 1kg', '2015-05-27 16:02:55', '2015-05-27 16:02:55'),
(3, 'Bouteille d''1L', '2015-05-27 16:30:23', '2015-05-27 16:30:23'),
(4, 'Conserve de 250g', '2015-05-27 16:58:52', '2015-05-27 16:59:56'),
(5, 'Rouleau', '2015-05-27 16:58:59', '2015-05-27 16:58:59'),
(6, 'Barquette de 125g', '2015-05-27 16:59:28', '2015-05-27 16:59:28'),
(7, 'Barquette de 250g', '2015-05-28 12:42:02', '2015-05-28 12:42:02'),
(8, 'Unité', '2015-05-28 12:44:54', '2015-05-28 12:44:54'),
(9, 'Bouteille de 75cL', '2015-05-28 13:12:28', '2015-05-28 13:12:28'),
(10, 'Plaquette de 125g', '2015-05-28 13:17:32', '2015-05-28 13:17:32');

-- --------------------------------------------------------

--
-- Table structure for table `conditionnement_ingredient`
--

CREATE TABLE IF NOT EXISTS `conditionnement_ingredient` (
  `id` int(10) unsigned NOT NULL,
  `conditionnement_id` int(10) unsigned DEFAULT NULL,
  `ingredient_id` int(10) unsigned DEFAULT NULL,
  `prix` float(8,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `conditionnement_ingredient`
--

INSERT INTO `conditionnement_ingredient` (`id`, `conditionnement_id`, `ingredient_id`, `prix`) VALUES
(1, 1, 1, 1.50),
(2, 2, 1, 2.75),
(3, 3, 2, 1.00),
(4, 5, 3, 1.05),
(5, 4, 4, 2.50),
(6, 6, 5, 1.15),
(7, 4, 6, 2.50),
(8, 1, 7, 0.75),
(9, 7, 8, 5.99),
(10, 6, 8, 3.50),
(11, 8, 9, 0.30),
(12, 7, 10, 1.00),
(13, 9, 11, 7.50),
(14, 10, 12, 2.50),
(15, 2, 13, 3.50),
(16, 2, 14, 3.50),
(17, 8, 15, 6.70),
(18, 1, 16, 2.50),
(19, 2, 17, 3.50),
(20, 1, 18, 3.50),
(21, 3, 19, 4.50);

-- --------------------------------------------------------

--
-- Table structure for table `etat`
--

CREATE TABLE IF NOT EXISTS `etat` (
  `id` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `etat`
--

INSERT INTO `etat` (`id`, `libelle`) VALUES
(1, 'en attente'),
(2, 'expédiée');

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE IF NOT EXISTS `ingredients` (
  `id` int(10) unsigned NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`id`, `nom`, `description`, `active`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Farine de blé', 'Note farine est moulue dans les meilleurs moulins, avec du blé issu de l''agriculture biologique d''origine française.', 1, 'farine-de-ble.jpg', '2015-05-27 16:14:54', '2015-05-27 16:14:54'),
(2, 'Lait', 'Notre lait vient des meilleures vaches laitières, nourries exclusivement au fourrage.', 1, 'lait.jpg', '2015-05-27 16:30:43', '2015-05-27 16:30:43'),
(3, 'Pâte à pizza', 'Pâte à pizza des plus délicieuses, 100% garantie pur beurre.', 1, 'pate-a-pizza.jpg', '2015-05-27 17:02:26', '2015-05-27 17:02:26'),
(4, 'Concentré de tomate', 'Concentré de tomate classique, élaboré à partir de tomates vraiment trop bonnes.', 1, 'concentre-de-tomate.JPG', '2015-05-27 17:05:38', '2015-05-27 17:05:38'),
(5, 'Lardons', 'Viande de porc 100% origine France.', 1, 'lardons.jpg', '2015-05-27 17:11:10', '2015-05-27 17:11:10'),
(6, 'Champignons de Paris', 'Délicieux et fondants', 1, 'champignons-de-paris.jpg', '2015-05-27 17:13:07', '2015-05-27 17:13:07'),
(7, 'Gruyère rapé', 'Idéal pour vos pâtes, etc.', 1, 'gruyere-rape.jpg', '2015-05-27 17:15:24', '2015-05-27 17:15:24'),
(8, 'Pièce de boeuf à fondue', 'Idéal pour un bon bœuf bourguignon.', 1, 'piece-de-boeuf-a-fondue.jpg', '2015-05-28 12:42:35', '2015-05-28 12:42:35'),
(9, 'Oignons', 'Oignon doux des Cévennes.', 1, 'oignon.jpg', '2015-05-28 12:45:06', '2015-05-28 13:40:48'),
(10, 'Carottes', 'Des carottes.', 1, 'carottes.jpg', '2015-05-28 13:10:11', '2015-05-28 13:10:11'),
(11, 'Vin rouge', 'Bouteille de St Emilion Chateau Machin de 2014', 1, 'vin-rouge.jpg', '2015-05-28 13:12:57', '2015-05-28 13:12:57'),
(12, 'Beurre', 'Beurre de Normandie, moulé à la louche', 1, 'beurre.jpg', '2015-05-28 13:17:41', '2015-05-28 13:17:41'),
(13, 'Sel', 'Sel de Guérande', 1, 'sel.jpg', '2015-05-28 13:19:20', '2015-05-28 13:19:20'),
(14, 'Poivre', 'Poivre noir', 1, 'poivre.jpg', '2015-05-28 13:20:56', '2015-05-28 13:20:56'),
(15, 'Truite', 'Truite saumonée d''élevage, ~300g la truite.', 0, 'truite.jpg', '2015-06-01 08:03:27', '2015-06-01 08:03:27'),
(16, 'Echalotes', 'Echalotes du sud ouest.', 1, 'echalotes.jpg', '2015-06-01 08:04:28', '2015-06-01 08:13:43'),
(17, 'Citron', 'Citron jaune', 0, 'citron.jpg', '2015-06-01 08:06:05', '2015-06-01 08:06:05'),
(18, 'Ciboulette', 'Fraiche', 0, 'ciboulette.jpg', '2015-06-01 08:08:02', '2015-06-01 08:08:02'),
(19, 'Huile d''olive', 'de Provence, pressée à froid', 0, 'huile-dolive.jpg', '2015-06-01 08:09:23', '2015-06-01 08:09:23');

-- --------------------------------------------------------

--
-- Table structure for table `ingredient_recette`
--

CREATE TABLE IF NOT EXISTS `ingredient_recette` (
  `id` int(10) unsigned NOT NULL,
  `ingredient_id` int(10) unsigned DEFAULT NULL,
  `recette_id` int(10) unsigned DEFAULT NULL,
  `quantite` int(11) NOT NULL,
  `unite` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ingredient_recette`
--

INSERT INTO `ingredient_recette` (`id`, `ingredient_id`, `recette_id`, `quantite`, `unite`) VALUES
(1, 3, 1, 1, 'rouleau'),
(2, 4, 1, 1, 'boite'),
(3, 5, 1, 1, 'barquette de 125g'),
(4, 6, 1, 1, 'petite boite'),
(5, 7, 1, 2, 'poignées'),
(6, 8, 2, 700, 'g'),
(7, 9, 2, 5, ''),
(8, 10, 2, 5, ''),
(9, 11, 2, 1, 'bouteille'),
(10, 12, 2, 100, 'g'),
(11, 13, 2, 2, 'pincées'),
(12, 14, 2, 1, 'pincée'),
(13, 15, 3, 500, 'g'),
(14, 16, 3, 2, ''),
(15, 17, 3, 1, ''),
(16, 18, 3, 1, 'botte'),
(17, 19, 3, 2, 'cuillères à soupe'),
(18, 13, 3, 1, 'pincée'),
(19, 14, 3, 1, 'pincée');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2015_05_22_111207_create_recettes_table', 1),
('2015_05_22_111445_create_ingredients_table', 1),
('2015_05_22_111632_create_categories_table', 1),
('2015_05_22_111851_create_conditionnements_table', 1),
('2015_05_22_112046_pivot_ingredient_recette_table', 1),
('2015_05_22_112301_pivot_conditionnement_ingredient_table', 1),
('2015_05_22_112750_add_foreign_key_to_recettes_table', 1),
('2015_05_22_113129_add_foreign_key_to_categories_table', 1),
('2015_05_27_152122_add_conditionnement_ingredient_table_prix', 1);

-- --------------------------------------------------------

--
-- Table structure for table `recettes`
--

CREATE TABLE IF NOT EXISTS `recettes` (
  `id` int(10) unsigned NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `resume` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `temps_preparation` time NOT NULL,
  `temps_cuisson` time DEFAULT NULL,
  `difficulte` tinyint(4) NOT NULL,
  `nb_personnes` tinyint(4) NOT NULL,
  `prix` float(8,2) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `categorie_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `recettes`
--

INSERT INTO `recettes` (`id`, `nom`, `resume`, `description`, `temps_preparation`, `temps_cuisson`, `difficulte`, `nb_personnes`, `prix`, `active`, `image`, `categorie_id`, `created_at`, `updated_at`) VALUES
(1, 'Pizza', 'Une recette simple, rapide et qui ravira tous les amateurs de cuisine italienne!\r\nVous pouvez également faire la pâte vous même mais cela prend un peu plus de temps.\r\nPour commencer, il vous faut...', 'Faire cuire dans une poêle les lardons et les champignons.\r\n\r\nDans un bol, verser la boîte de concentré de tomate, y ajouter un demi verre d''eau, ensuite mettre un carré de sucre (pour enlever l''acidité de la tomate) une pincée de sel, de poivre, et une pincée d''herbe de Provence.\r\n\r\nDérouler la pâte à pizza sur la lèche frite de votre four et la piquer.\r\n\r\nAvec une cuillère à soupe, étaler délicatement la sauce tomate, ensuite y ajouter les lardons et les champignons bien dorer. Parsemer de fromage râpée.\r\n\r\nMettre au four à 220°, thermostat 7-8, pendant 20 min (ou lorsque le dessus de la pizza est doré).', '00:15:00', '00:30:00', 1, 5, 1.05, 1, 'pizza.jpg', 3, '2015-05-27 17:21:44', '2015-05-29 06:52:56'),
(2, 'Bœuf bourguignon', 'Le traditionnel et indémodable boeuf bourguignon, à faire longtemps mijoter et à accompagner d''un Bourgogne, forcément.', 'Détailler la viande en cubes de 3 cm de côté, enlever les gros morceaux de gras.\r\n\r\nCouper l''oignon en morceaux. Le faire revenir dans une poêle au beurre. Une fois transparent, versez le dans une cocotte en fonte de préférence.\r\n\r\nProcéder de même avec la viande mais en plusieurs fois, jusqu''à ce que tous les morceaux soient cuits. Les ajouter au fur et à mesure dans la cocotte. Ne pas avoir peur de rajouter du beurre entre chaque fournée. Quand toute la viande est dans la cocotte, déglacer la poêle avec de l''eau ou du vin et faire bouillir en raclant pour récupérer le suc. Saler, poivrer, ajouter au reste.\r\n\r\nRecouvrir le tout avec une partie du vin et faire mijoter quelques heures avec le bouquet garni et les carottes en rondelles.\r\n\r\nLe lendemain, faire mijoter au moins 2 heures en plusieurs fois, ajouter du vin ou de l''eau si nécessaire.', '01:00:00', '05:00:00', 4, 4, 2.50, 1, 'boeuf-bourguignon.jpg', 2, '2015-05-28 13:25:15', '2015-05-28 13:25:15'),
(3, 'Tartare de truite', 'Facile, frais et délicieux, une entrée qui ravira tous vos convives.', 'Réservez les filets de truite pendant environ 15 min au congélateur pour les raffermir. Refroidissez aussi les assiettes de service en les plaçant au frigo.\r\n\r\nPendant ce temps, lavez soigneusement la salade, essorez-la et réservez-la. Hachez finement les filets de truite à l''aide d''un couteau à large lame dès la sortie du congélateur.\r\n\r\nPressez le citron, pelez et hachez les échalotes. Ajoutez-les à la chair du poisson avec la ciboulette ciselée, le jus de citron et l''huile d''olive.\r\n\r\nSalez et poivrez. Moulez la préparation obtenue en forme de quenelles en vous aidant de deux c. à soupe.\r\n\r\nDisposez ce tartare sur les assiettes très froides que vous aurez garnies de salade. Accompagnez de tranches de pain grillé. Servez très frais sans attendre.', '00:20:00', '00:00:00', 1, 4, 1.20, 1, 'tartare-de-truite.jpg', 1, '2015-06-01 08:12:15', '2015-06-01 08:12:15');

-- --------------------------------------------------------

--
-- Table structure for table `suivi_commande`
--

CREATE TABLE IF NOT EXISTS `suivi_commande` (
  `id_etat` int(10) NOT NULL DEFAULT '0',
  `id_commande` int(10) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `suivi_commande`
--

INSERT INTO `suivi_commande` (`id_etat`, `id_commande`, `date`) VALUES
(1, 1, '2015-05-18 00:00:00'),
(1, 2, '2015-05-19 00:00:00'),
(1, 3, '2015-05-19 14:57:48'),
(1, 4, '2015-05-19 14:54:59'),
(1, 5, '2015-05-19 00:00:00'),
(1, 7, '2015-05-29 15:56:11'),
(2, 4, '2015-05-29 09:16:13'),
(2, 5, '2015-05-19 15:06:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `nom` (`nom`), ADD KEY `categories_parent_id_index` (`parent_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`), ADD KEY `commandes_foreign_client_id` (`client_id`);

--
-- Indexes for table `conditionnements`
--
ALTER TABLE `conditionnements`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `nom` (`nom`);

--
-- Indexes for table `conditionnement_ingredient`
--
ALTER TABLE `conditionnement_ingredient`
  ADD PRIMARY KEY (`id`), ADD KEY `conditionnement_ingredient_conditionnement_id_index` (`conditionnement_id`), ADD KEY `conditionnement_ingredient_ingredient_id_index` (`ingredient_id`);

--
-- Indexes for table `etat`
--
ALTER TABLE `etat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `nom` (`nom`);

--
-- Indexes for table `ingredient_recette`
--
ALTER TABLE `ingredient_recette`
  ADD PRIMARY KEY (`id`), ADD KEY `ingredient_recette_ingredient_id_index` (`ingredient_id`), ADD KEY `ingredient_recette_recette_id_index` (`recette_id`);

--
-- Indexes for table `recettes`
--
ALTER TABLE `recettes`
  ADD PRIMARY KEY (`id`), ADD KEY `recettes_categorie_id_index` (`categorie_id`);

--
-- Indexes for table `suivi_commande`
--
ALTER TABLE `suivi_commande`
  ADD PRIMARY KEY (`id_etat`,`id_commande`), ADD KEY `id_etat` (`id_etat`), ADD KEY `id_commande` (`id_commande`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `conditionnements`
--
ALTER TABLE `conditionnements`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `conditionnement_ingredient`
--
ALTER TABLE `conditionnement_ingredient`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `etat`
--
ALTER TABLE `etat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `ingredient_recette`
--
ALTER TABLE `ingredient_recette`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `recettes`
--
ALTER TABLE `recettes`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `commandes`
--
ALTER TABLE `commandes`
ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `conditionnement_ingredient`
--
ALTER TABLE `conditionnement_ingredient`
ADD CONSTRAINT `conditionnement_ingredient_conditionnement_id_foreign` FOREIGN KEY (`conditionnement_id`) REFERENCES `conditionnements` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT `conditionnement_ingredient_ingredient_id_foreign` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ingredient_recette`
--
ALTER TABLE `ingredient_recette`
ADD CONSTRAINT `ingredient_recette_ingredient_id_foreign` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT `ingredient_recette_recette_id_foreign` FOREIGN KEY (`recette_id`) REFERENCES `recettes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `recettes`
--
ALTER TABLE `recettes`
ADD CONSTRAINT `recettes_categorie_id_foreign` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `suivi_commande`
--
ALTER TABLE `suivi_commande`
ADD CONSTRAINT `suivi_commande_ibfk_1` FOREIGN KEY (`id_etat`) REFERENCES `etat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `suivi_commande_ibfk_2` FOREIGN KEY (`id_commande`) REFERENCES `commandes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
