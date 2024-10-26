-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 22, 2024 at 03:16 PM
-- Server version: 10.11.8-MariaDB-0ubuntu0.24.04.1
-- PHP Version: 8.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nutricalc`
--

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `ingredient_id` int(11) NOT NULL,
  `upc` char(11) NOT NULL,
  `brand` char(64) NOT NULL,
  `identity` char(64) NOT NULL,
  `ingredients` tinytext NOT NULL,
  `allergens` set('milk','eggs','fish','shellfish','tree nuts','peanuts','wheat','soy','sesame') NOT NULL,
  `unit_size` float NOT NULL DEFAULT 0,
  `serving_size` float NOT NULL DEFAULT 0,
  `calories` float NOT NULL DEFAULT 0,
  `fat` float NOT NULL DEFAULT 0,
  `s_fat` float NOT NULL DEFAULT 0,
  `t_fat` float NOT NULL DEFAULT 0,
  `cholest` float NOT NULL DEFAULT 0,
  `na` float NOT NULL DEFAULT 0,
  `carb` float NOT NULL DEFAULT 0,
  `fiber` float NOT NULL DEFAULT 0,
  `sugar` float NOT NULL DEFAULT 0,
  `add_sugar` float NOT NULL DEFAULT 0,
  `protein` float NOT NULL DEFAULT 0,
  `d3` float NOT NULL DEFAULT 0,
  `ca` float NOT NULL DEFAULT 0,
  `fe` float NOT NULL DEFAULT 0,
  `k` float NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`ingredient_id`, `upc`, `brand`, `identity`, `ingredients`, `allergens`, `unit_size`, `serving_size`, `calories`, `fat`, `s_fat`, `t_fat`, `cholest`, `na`, `carb`, `fiber`, `sugar`, `add_sugar`, `protein`, `d3`, `ca`, `fe`, `k`) VALUES
(1, '', 'Nuts.com', 'Glazed Red Cherries', 'Cherries, Glucose Syrup, Sucrose, Citric Acid, FD&C Red #3, Potassium Sorbate, Sulfur Dioxide', '', 454, 40, 119, 0, 0, 0, 0, 19, 30, 1, 25, 25, 0, 0, 30, 0.36, 0),
(2, '', 'Nuts.com', 'Glazed Green Cherries', 'Cherries, Glucose-Fructose Syrup, Sucrose, Citric Acid, FD&C Yellow #5, Blue #1, Potassium Sorbate, Sulfur Dioxide', '', 454, 40, 118, 0, 0, 0, 0, 39, 30, 1, 25, 25, 0, 0, 30, 0.0666667, 0),
(3, '', 'Nuts.com', 'Raisin Medley', 'Sorbet Raisins, Crimson Raisins, Thomson Jumbo Raisins, Jumbo Flame Raisins, Sunflower Oil, Sulfur Dioxide', '', 454, 40, 121, 0, 0, 0, 0, 7, 28, 1, 22, 0, 1, 0, 26, 0.54, 0),
(4, '', 'Nuts.com', 'Diced Pineapple', 'Pineapple, Sugar, Citric Acid, Sodium Metabisulphite, Sulfur Dioxide', '', 454, 28, 99, 0, 0, 0, 0, 42, 25, 1, 22, 13, 0, 0, 4, 1, 0),
(5, '', 'Nuts.com', 'Diced Apricots', 'Apricots, Rice Flour, SO2', '', 454, 45, 100, 0, 0, 0, 0, 2, 28, 3, 24, 0, 1, 0, 25, 1.2, 523),
(6, '', 'Nuts.com', 'Glazed Orange Peel', 'Orange Peel, Corn Syrup, High Fructose Corn Syrup, Citric Acid, Preserved with 1/10 of 1% Benzoate of Soda, Sorbic Acid, Sulfur Dioxide', '', 454, 30, 90, 0, 0, 0, 0, 25, 23, 2, 13, 0, 0, 0, 91, 0.54, 0),
(7, '', 'Nuts.com', 'Glazed Lemon Peel', 'Lemon Peel, Glucose Syrup, Sugar, Citric Acid', '', 454, 40, 120, 0, 0, 0, 0, 8, 30, 0.28, 22, 14, 0, 0, 6, 0, 10),
(8, '70690-01456', 'Fisher Chef\'s Naturals', 'Chopped Pecans', '', 'tree nuts', 680, 28, 190, 20, 1.5, 0, 0, 0, 4, 3, 1, 0, 3, 0, 20, 0.7, 110),
(9, '71012-01330', 'King Arthur', 'Flour', 'Unbleached Soft Wheat Flour, Leavening (baking soda, sodium acid pyrophosphate, monocalcium phosphate), Salt', 'wheat', 2270, 30, 110, 0, 0, 0, 0, 0, 23, -1, 0, 0, 0, 0, 0, 0, 0),
(10, '74503-00126', 'Billington’s', 'Light Muscovado Sugar', '', '', 454, 4, 15, 0, 0, 0, 0, 4, 4, 0, 4, 0, 0, 0, 0, 0, 0),
(11, '51857-00052', 'Waterford', 'Irish Butter', 'Pasteurized Cream, Salt', '', 454, 14.1875, 100, 11, 8, 0, 25, 105, 0, 0, 0, 0, 0, 0, 3, 0, 0),
(12, '13372-00011', 'S & R', 'Cage Free Extra Large Eggs', '', 'eggs', 680.389, 56.6991, 79.4, 5.7, 1.7, 0, 209.8, 79.4, 0, 0, 0, 0, 6.8, 0, 22.7, 0.4, 0),
(13, '', 'Simply Orange', 'Orange Juice', '', '', 1680, 240, 120, 0.5, 0, 0, 0, 0, 26, 0, 23, 0, 2, 0, 0, 20, 0),
(14, '', 'Oberweis', 'Milk', 'Whole Milk, Vitamin D3', 'milk', 1892.7, 236.587, 150, 8, 5, 0, 35, 120, 11, 0, 11, 0, 8, 1.25, 0.0230769, 0, 0),
(15, '', 'Sailor Jerry', 'Spiced Rum', '46% ABV (Flavoring and Preservative)', '', 750, 44.3602, 98, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(16, '', 'Simply Organic', 'Organic Cinnamon', '', '', 59, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(17, '', 'Great Value', 'Organic Allspice', '', '', 45, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(18, '', 'Simply Organic', 'Organic Cloves', '', '', 80, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(19, '', 'BulkFoods.com', 'Natural Diced Apricots', 'Sun Dried Diced Apricots, Rice Flour', '', 454, 45, 110, 0, 0, 0, 0, 0, 28, 3, 24, 0, 1, 0, 30, 0, 2),
(20, '', 'BulkFoods.com', 'Zante Currants', 'Dried Black Corinthian Grapes, Sunflower Oil', '', 454, 40, 120, 0, 0, 0, 0, 0, 30, 3, 27, 0, 2, 0, 34, 1.3, 357),
(21, '', 'BulkFoods.com', 'Golden Raisins', 'Thomson Raisins, Sulfur Dioxide', '', 454, 40, 120, 0, 0, 0, 0, 5, 32, 2, 24, 0, 1, 0, 21, 0.7, 298),
(22, '', 'Billington\'s', 'Dark Brown Molasses Sugar', '', '', 454, 8, 30, 0, 0, 0, 0, 0, 8, 0, 8, 8, 0, 0, 0, 0, 0),
(23, '', 'Nuts.com', 'Chopped Almonds', '', 'tree nuts', 454, 28, 162, 14, 1, 0, 0, 0, 6, 4, 1, 0, 6, 0, 75, 1, 205),
(24, '', 'Bob\'s Red Mill', 'Organic Unbleached Flour', '', 'wheat', 2270, 34, 120, 0.5, 0, 0, 0, 0, 25, 1, 0, 0, 4, 0, 0, 0, 0),
(25, '', 'Schwartz', 'Mixed Spice', 'Cinnamon, Coriander, Caraway Seed, Nutmeg, Ginger, Cloves', '', 28, 3.75, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(26, '', 'Spice Island', 'Nutmeg', '', '', 0, 1.25, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(27, '', '', 'Lemon Zest', '', '', 0, 7, 4, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0),
(28, '', '', 'Orange Zest', '', '', 0, 5, 5, 0, 0, 0, 0, 0, 1, 0.3, 0, 0, 0, 0, 0, 0, 10),
(29, '', 'Tate & Lyle', 'Black Treacle', 'Cane Molasses', '', 454, 100, 0, 0, 0, 0, 0, 0.13, 64, 0, 64, 0, 1.7, 0, 500, 14, 0),
(30, '', 'S & R', 'Extra Large Eggs', '', 'eggs', 56, 56, 80, 5, 2, 0, 210, 80, 0, 0, 0, 0, 7, 12, 26, 1.08, 0),
(31, '', 'E & J', 'VSOP Brandy', '', '', 750, 44.3, 100, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(32, '', 'Martinelli\'s', 'Pure Apple Juice', '', '', 296, 296, 180, 0, 0, 0, 0, 0, 43, 0, 39, 0, 1, 0, 0, 0, 0),
(33, '74503-00146', 'Billington\'s', 'Dark Brown Molasses Sugar', '', '', 0, 8, 30, 0, 0, 0, 0, 0, 8, 0, 8, 0, 0, 0, 0, 0, 0),
(34, '15141-51493', 'Egg-Land\'s Best', 'Pasture Raised Eggs', '', 'eggs', 680, 50, 60, 4, 1, 0, 170, 65, 0, 0, 0, 0, 6, 6, 30, 0.9, 70);

-- --------------------------------------------------------

--
-- Table structure for table `producer`
--

CREATE TABLE `producer` (
  `name` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `cityst` varchar(50) NOT NULL,
  `zip` varchar(50) NOT NULL,
  `tel` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `producer`
--

INSERT INTO `producer` (`name`, `address`, `cityst`, `zip`, `tel`) VALUES
('John Doe', '123 Main Street', 'Anytown US', '01234-5678', '(901) 234-5678');

-- --------------------------------------------------------

--
-- Table structure for table `rda`
--

CREATE TABLE `rda` (
  `id` tinyint(1) NOT NULL,
  `k` char(16) NOT NULL,
  `item` char(32) NOT NULL,
  `unit` enum('c','g','mg','mcg') NOT NULL,
  `dv` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=ascii COLLATE=ascii_general_ci COMMENT='Reference Values for Nutrition Labeling';

--
-- Dumping data for table `rda`
--

INSERT INTO `rda` (`id`, `k`, `item`, `unit`, `dv`) VALUES
(1, 'calories', 'Calories', 'c', 2000),
(2, 'fat', 'Total Fat', 'g', 78),
(3, 's_fat', 'Saturated Fat', 'g', 20),
(4, 't_fat', 'Trans Fat', 'g', 0),
(5, 'cholest', 'Cholesterol', 'mg', 300),
(6, 'na', 'Sodium', 'mg', 2300),
(7, 'carb', 'Total Carbohydrate', 'g', 275),
(8, 'fiber', 'Dietary Fiber', 'g', 28),
(9, 'sugar', 'Sugars', 'g', 40),
(10, 'add_sugar', 'Added Sugars', 'g', 50),
(11, 'protein', 'Protein', 'g', 50),
(16, 'd3', 'Vitamin D', 'mcg', 20),
(19, 'ca', 'Calcium', 'mg', 1300),
(22, 'fe', 'Iron', 'mg', 18),
(28, 'k', 'Potassium', 'mg', 4700);

-- --------------------------------------------------------

--
-- Table structure for table `rda_complete`
--

CREATE TABLE `rda_complete` (
  `id` tinyint(1) NOT NULL,
  `k` char(16) NOT NULL,
  `item` char(32) NOT NULL,
  `unit` enum('c','g','mg','mcg') NOT NULL,
  `dv` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=ascii COLLATE=ascii_general_ci COMMENT='Reference Values for Nutrition Labeling';

--
-- Dumping data for table `rda_complete`
--

INSERT INTO `rda_complete` (`id`, `k`, `item`, `unit`, `dv`) VALUES
(1, 'calories', 'Calories', 'c', 2000),
(2, 'fat', 'Total Fat', 'g', 78),
(3, 's_fat', 'Saturated Fat', 'g', 20),
(4, 't_fat', 'Trans Fat', 'g', 0),
(5, 'cholest', 'Cholesterol', 'mg', 300),
(6, 'na', 'Sodium', 'mg', 2300),
(7, 'carb', 'Total Carbohydrate', 'g', 275),
(8, 'fiber', 'Dietary Fiber', 'g', 28),
(9, 'sugar', 'Sugars', 'g', 40),
(10, 'add_sugar', 'Added Sugars', 'g', 50),
(11, 'protein', 'Protein', 'g', 50),
(12, 'a', 'Vitamin A', 'mcg', 900),
(13, 'b6', 'Vitamin B6', 'mg', 2),
(14, 'b12', 'Vitamin B12', 'mcg', 2),
(15, 'c', 'Vitamin C', 'mg', 90),
(16, 'd3', 'Vitamin D', 'mcg', 20),
(17, 'e', 'Vitamin E', 'mg', 15),
(18, 'vk', 'Vitamin K', 'mcg', 120),
(19, 'ca', 'Calcium', 'mg', 1300),
(20, 'cu', 'Copper', 'mg', 1),
(21, 'cr', 'Chromium', 'mcg', 35),
(22, 'fe', 'Iron', 'mg', 18),
(23, 'i', 'Iodine', 'mcg', 150),
(24, 'mg', 'Magnesium', 'mg', 420),
(25, 'mn', 'Manganese', 'mg', 2),
(26, 'mo', 'Molybdenum', 'mcg', 45),
(27, 'p', 'Phosphorus', 'mg', 1250),
(28, 'k', 'Potassium', 'mg', 4700),
(29, 'se', 'Selenium', 'mcg', 55),
(30, 'zn', 'Zinc', 'mg', 11),
(31, 'thiam', 'Thiamine', 'mg', 1),
(32, 'ribo', 'Riboflavin', 'mg', 1),
(33, 'niac', 'Niacin', 'mg', 16),
(34, 'folate', 'Folate', 'mcg', 400),
(35, 'bio', 'Biotin', 'mcg', 30),
(36, 'panto', 'Pantothenic acid', 'mg', 5),
(37, 'chlor', 'Chloride', 'mg', 2300),
(38, 'choline', 'Choline', 'mg', 550);

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `recipe_id` tinyint(3) UNSIGNED NOT NULL,
  `ingredient_id` tinyint(3) UNSIGNED NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`recipe_id`, `ingredient_id`, `amount`) VALUES
(1, 1, 74),
(1, 3, 127),
(1, 6, 26),
(1, 7, 24),
(1, 11, 175),
(1, 19, 84),
(1, 20, 197),
(1, 21, 113),
(1, 22, 175),
(1, 23, 57),
(1, 24, 175),
(1, 25, 3.75),
(1, 26, 1.25),
(1, 27, 7),
(1, 28, 5),
(1, 29, 10),
(1, 30, 168),
(1, 31, 160),
(3, 0, 0),
(3, 1, 74),
(3, 3, 127),
(3, 6, 26),
(3, 7, 24),
(3, 11, 175),
(3, 19, 84),
(3, 20, 197),
(3, 21, 113),
(3, 22, 175),
(3, 23, 57),
(3, 24, 175),
(3, 25, 3.75),
(3, 26, 1.25),
(3, 27, 7),
(3, 28, 5),
(3, 29, 10),
(3, 30, 168),
(3, 32, 100);

-- --------------------------------------------------------

--
-- Table structure for table `recipes_tx`
--

CREATE TABLE `recipes_tx` (
  `recipe_id` tinyint(3) UNSIGNED NOT NULL,
  `recipe_name` varchar(255) NOT NULL,
  `recipe_font` varchar(255) NOT NULL,
  `servings` tinyint(3) UNSIGNED NOT NULL,
  `serving_unit` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes_tx`
--

INSERT INTO `recipes_tx` (`recipe_id`, `recipe_name`, `recipe_font`, `servings`, `serving_unit`) VALUES
(0, 'New Recipe', 'Helvetica Black', 0, ''),
(1, 'Christmas Cake', 'Berkshire Swash', 19, '1 slice'),
(2, 'fred', 'Berkshire Swash', 2, 'mary'),
(3, 'Christmas Cake [Non-Alcoholic]', 'Berkshire Swash', 19, '1 slice');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`ingredient_id`);

--
-- Indexes for table `producer`
--
ALTER TABLE `producer`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `rda`
--
ALTER TABLE `rda`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `rda_complete`
--
ALTER TABLE `rda_complete`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`recipe_id`,`ingredient_id`);

--
-- Indexes for table `recipes_tx`
--
ALTER TABLE `recipes_tx`
  ADD PRIMARY KEY (`recipe_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rda`
--
ALTER TABLE `rda`
  MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `rda_complete`
--
ALTER TABLE `rda_complete`
  MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
