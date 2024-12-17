-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 17 déc. 2024 à 22:44
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `libraryafpa_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `is_available` tinyint(1) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `summary` longtext DEFAULT NULL,
  `category_id_list` varchar(255) DEFAULT NULL,
  `category_name_list` longtext DEFAULT NULL,
  `custom_id` int(11) NOT NULL,
  `book_condition` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `book`
--

INSERT INTO `book` (`id`, `status_id`, `title`, `author`, `is_available`, `image`, `summary`, `category_id_list`, `category_name_list`, `custom_id`, `book_condition`) VALUES
(8, 1, 'One Piece', 'Eichiro Oda', 1, '/uploads/book_images/675c894b6c920.jpg', 'Nous sommes à l\'ère des pirates ! Luffy, un garçon espiègle, rêve de devenir le roi des pirates en trouvant le “One Piece”, un fabuleux trésor. Seulement, Luffy a avalé un fruit du démon qui l\'a transformé en homme élastique. Depuis, il est capable de contorsionner son corps dans tous les sens, mais il a perdu la faculté de nager.', NULL, NULL, 1, NULL),
(11, 2, 'Harry Potter et la chambre des secrets', 'J.K. Rowling', 1, '/uploads/book_images/675cc18473f73.jpg', 'Harry Potter fait une deuxième rentrée fracassante en voiture volante à l\'école des sorciers. Cette deuxième année ne s\'annonce pas de tout repos… surtout depuis qu\'une étrange malédiction s\'est abattue sur les élèves. Entre les cours de potion magique, les matchs de quidditch et les combats de mauvais sorts, Harry trouvera-t-il le temps de percer le mystère de la Chambre des Secrets ? Un livre magique pour sorciers et sorcières confirmés !', NULL, NULL, 3, NULL),
(16, 1, 'Naruto Tome 1', 'Masashi Kishimito', 1, '/uploads/book_images/675cd49554211.jpg', 'Naruto est un garçon un peu spécial. Il est toujours tout seul et son caractère fougueux ne l\'aide pas vraiment à se faire apprécier dans son village. Malgré cela, il garde au fond de lui une ambition: celle de devenir un maître Hokage, la plus haute distinction dans l\'ordre des ninjas, et ainsi obtenir la reconnaissance de ses pairs.', NULL, NULL, 2, NULL),
(18, 2, 'Naruto Tome 2', 'Masashi Kishimito', 1, '/uploads/book_images/675cd534164c6.jpg', 'Sasuke, Sakura et Naruto passent un test dont le but est de s\'emparer de clochettes que détient le professeur Kakashi. Il leur fait bien réaliser leur infériorité et leur manque d\'expérience et finit par leur annoncer qu\'ils n\'ont aucune chance de devenir ninjas', NULL, NULL, 4, NULL),
(19, 2, 'Vinland Saga Tome 1', 'Makoto Yukimura', 1, '/uploads/book_images/675d6a63775a7.jpg', 'Suivez les aventures de Thorfin, jeune Viking embarqué malgré lui avec une bande de mercenaires sans pitié.Depuis qu\'Askeladd, un chef de guerre fourbe et sans honneur, a tué son père lorsqu\'il était enfant, Thorfinn le suit partout dans le but de se venger. Mais bien qu\'il soit devenu un guerrier redoutable, il ne parvient toujours pas à vaincre son ennemi. Au fil des ans, enchaînant missions périlleuses et combats afin d\'obtenir des duels contre l\'homme qu\'il hait plus que tout, le gentil Thorfinn est devenu froid et...', NULL, NULL, 5, NULL),
(20, 2, 'Vinland Saga Tome 2', 'Makoto Yukimura', 1, '/uploads/book_images/675d6ac162a7c.jpg', 'Suivez les aventures de Thorfin, jeune Viking embarqué malgré lui avec une bande de mercenaires sans pitié.Thors et sa famille menaient une vie paisible dans un petit village d\'Islande... Jusqu\'à ce jour terrible où un navire des Vikings de Jom entra dans le port. À leur tête, le redoutable Floki, oiseau de mauvais augure porteur d\'un message sans équivoque pour Thors, le \"Troll de Jom\". Si celui accepte de rejoindre les rangs de Jomsvikings dans leur campagne contre l\'Angleterre, sa désertion de quinze ans plus tôt sera...', NULL, NULL, 6, NULL),
(21, 2, 'Vinland Saga Tome 3', 'Makoto Yukimura', 1, '/uploads/book_images/675d6b0ae03f0.jpg', 'Suivez les aventures de Thorfin, jeune Viking embarqué malgré lui avec une bande de mercenaires sans pitié.Août 1013, suite au massacre des camps Vikings de Northumbrie, l\'armée Danoise se fait de plus en plus violente en Angleterre. D\'expédition en expédition, l\'armée dirigée par Floki, rejointe par celle d\'Askeladd, arrive enfin à Londres. Mais après des décennies d\'attaques, Londres est plus que parée contre les attaques de Vikings. Pour l\'armée Danoise, le combat s\'annonce d\'autant plus rude que Torkell, le frère cadet.', NULL, NULL, 7, NULL),
(23, 2, 'Harry Potter à l\'école des sorciers', 'J.K. Rowling', 1, '/uploads/book_images/675d8cbfe912f.jpg', 'Le jour de ses onze ans, Harry Potter, un orphelin élevé par un oncle et une tante qui le détestent, voit son existence bouleversée. Un géant vient le chercher pour l\'emmener à Poudlard, une école de sorcellerie! Voler en balai, jeter des sorts, combattre les trolls: Harry révèle de grands talents. Mais un mystère entoure sa naissance et l\'effroyable Voldemort, le mage des ténèbres dont personne n\'ose prononcer le nom', NULL, NULL, 8, NULL),
(25, 1, 'Vinland Saga Tome 4', 'Makoto Yukimura', 1, '/uploads/book_images/675f68a6257f8.jpg', 'Suivez les aventures de Thorfin, jeune Viking embarqué malgré lui avec une bande de mercenaires sans pitié.Angleterre 1013, l\'armée danoise du roi Sven à la Barbe Fourchue continue sa campagne d\'invasion. Malgré la supériorité de l\'armée de Sven, sa progression se retrouve bloquée à Londres, ville imprenable protégée par Thorkell le Grand, un Viking passé à l\'Anglais par pur ennui. Sven décide alors de confier le siège à son fils Knut, à la tête d\'une armée de quatre mille hommes.', NULL, NULL, 9, NULL),
(26, 2, 'Les annales de la Compagnie noire - L\'intégrale Tome 1', 'Glen Cook', 1, '/uploads/book_images/675f7613e136e.jpg', 'On dit que les mercenaires n\'ont pas d\'âme, mais ils ont une mémoire. La nôtre, celle de la dernière des compagnies franches de Khatovar, vous la tenez entre vos mains. Ce sont nos entrailles, chaudes et puantes, étalées là devant vous. Vous qui lisez ces annales, ne perdez pas votre temps à nous maudire, car nous le sommes déjà...', NULL, NULL, 10, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `book_book_category`
--

CREATE TABLE `book_book_category` (
  `book_id` int(11) NOT NULL,
  `book_category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `book_book_category`
--

INSERT INTO `book_book_category` (`book_id`, `book_category_id`) VALUES
(8, 1),
(8, 2),
(8, 4),
(11, 4),
(11, 5),
(16, 1),
(16, 2),
(18, 1),
(18, 2),
(19, 1),
(19, 3),
(20, 1),
(20, 3),
(21, 1),
(21, 3),
(23, 4),
(23, 5),
(25, 1),
(25, 3),
(26, 4),
(26, 8);

-- --------------------------------------------------------

--
-- Structure de la table `book_borrowed_book`
--

CREATE TABLE `book_borrowed_book` (
  `book_id` int(11) NOT NULL,
  `borrowed_book_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `book_category`
--

CREATE TABLE `book_category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `book_category`
--

INSERT INTO `book_category` (`id`, `category_name`) VALUES
(1, 'Manga'),
(2, 'Shonen'),
(3, 'Seinen'),
(4, 'Fantasy'),
(5, 'Jeunesse'),
(6, 'Romance'),
(7, 'Aventure'),
(8, 'Dark-Fantasy');

-- --------------------------------------------------------

--
-- Structure de la table `book_status`
--

CREATE TABLE `book_status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `book_status`
--

INSERT INTO `book_status` (`id`, `name`) VALUES
(1, 'Excellent'),
(2, 'Bon'),
(3, 'Passable'),
(4, 'Mauvais');

-- --------------------------------------------------------

--
-- Structure de la table `borrowed_book`
--

CREATE TABLE `borrowed_book` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `book_name` varchar(255) NOT NULL,
  `borrow_date` datetime NOT NULL,
  `return_date` datetime NOT NULL,
  `borrowed_condition` varchar(255) NOT NULL,
  `returned_condition` varchar(255) DEFAULT NULL,
  `borrower_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `borrow_history`
--

CREATE TABLE `borrow_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `borrowed_at` datetime NOT NULL,
  `returned_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `borrow_history_book`
--

CREATE TABLE `borrow_history_book` (
  `borrow_history_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `comment` longtext NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `book_id`, `comment`, `user_id`) VALUES
(4, 21, 'Super manga !', 1),
(7, 23, 'C\'est un très bon livre !', 1),
(8, 20, 'Très bon manga !', 1),
(10, 8, 'C\'est le manga de mon enfance ! J\'adore', 1),
(11, 18, 'J\'ai beaucoup aimé ce manga ! Que de bons souvenirs !', 2),
(12, 11, 'Super bouquin !', 1);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20241213005925', NULL, NULL),
('DoctrineMigrations\\Version20241213010520', NULL, NULL),
('DoctrineMigrations\\Version20241213011017', NULL, NULL),
('DoctrineMigrations\\Version20241213022208', NULL, NULL),
('DoctrineMigrations\\Version20241213145558', NULL, NULL),
('DoctrineMigrations\\Version20241213150757', NULL, NULL),
('DoctrineMigrations\\Version20241213184723', NULL, NULL),
('DoctrineMigrations\\Version20241213190657', NULL, NULL),
('DoctrineMigrations\\Version20241214011245', NULL, NULL),
('DoctrineMigrations\\Version20241214170859', NULL, NULL),
('DoctrineMigrations\\Version20241214172347', NULL, NULL),
('DoctrineMigrations\\Version20241214191424', NULL, NULL),
('DoctrineMigrations\\Version20241215012054', NULL, NULL),
('DoctrineMigrations\\Version20241215024319', NULL, NULL),
('DoctrineMigrations\\Version20241215174606', NULL, NULL),
('DoctrineMigrations\\Version20241215181102', NULL, NULL),
('DoctrineMigrations\\Version20241215181415', NULL, NULL),
('DoctrineMigrations\\Version20241216000314', '2024-12-16 01:03:21', 219),
('DoctrineMigrations\\Version20241216004927', '2024-12-16 01:49:33', 8),
('DoctrineMigrations\\Version20241216005749', '2024-12-16 01:57:51', 10),
('DoctrineMigrations\\Version20241216012021', '2024-12-16 02:20:30', 8),
('DoctrineMigrations\\Version20241216014234', '2024-12-16 02:42:37', 13),
('DoctrineMigrations\\Version20241216031209', '2024-12-16 04:12:15', 116),
('DoctrineMigrations\\Version20241216031648', '2024-12-16 04:16:50', 7),
('DoctrineMigrations\\Version20241216033255', '2024-12-16 04:32:58', 60),
('DoctrineMigrations\\Version20241216035912', '2024-12-16 04:59:18', 9),
('DoctrineMigrations\\Version20241217180749', '2024-12-17 19:07:52', 123),
('DoctrineMigrations\\Version20241217201358', '2024-12-17 21:14:02', 7),
('DoctrineMigrations\\Version20241217203251', '2024-12-17 21:33:22', 65);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `modified_profile_image`
--

CREATE TABLE `modified_profile_image` (
  `id` int(11) NOT NULL,
  `modify_user_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `uploaded_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `modify_user`
--

CREATE TABLE `modify_user` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `code_postal` varchar(10) DEFAULT NULL,
  `new_password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `work_room_id` int(11) NOT NULL,
  `reservation_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `user_id` int(11) NOT NULL,
  `number_of_people` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `work_room_id`, `reservation_date`, `start_time`, `end_time`, `user_id`, `number_of_people`) VALUES
(4, 18, '2024-12-17', '10:00:00', '13:00:00', 1, 2),
(5, 20, '2024-12-19', '10:00:00', '12:00:00', 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `reserved_room`
--

CREATE TABLE `reserved_room` (
  `user_id` int(11) NOT NULL,
  `work_room_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(2, 'Admin'),
(1, 'User');

-- --------------------------------------------------------

--
-- Structure de la table `subscription`
--

CREATE TABLE `subscription` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `subscription`
--

INSERT INTO `subscription` (`id`, `name`, `price`, `type`) VALUES
(1, 'Abonnement Mensuel', 23.99, 'Mensuel'),
(2, 'Abonnement Annuel', 259.09, 'Annuel');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `date_naissance` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `code_postal` varchar(10) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `image_profil` varchar(255) DEFAULT NULL,
  `rolename` varchar(50) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `date_naissance`, `email`, `password`, `adresse`, `code_postal`, `ville`, `telephone`, `image_profil`, `rolename`, `role_id`) VALUES
(1, 'Jackie', 'Clément', '1995-03-21', 'clementmiermontei@outlook.com', '$2y$13$7ipdVVwgCbJL9dNHbi6oEOi2M3sEFWaGsJV/Boz1FBaF3Q/IZXYvG', '39 Rue de Hesques', '59300', 'Arras', '0661297835', '6761e89b40ef8.png', 'Admin', 2),
(2, 'Marsh', 'Stan', '1995-03-21', 'Marsh@outlook.com', '$2y$13$vImhVyp/1xV6JoVKBLWhb.D.YcC8P6oSJp3qx2SJxSyEvUuDhfmCe', 'South Park Street', '15129', 'South Park', '066124578', 'Stan-675cad824ecd7.png', 'Utilisateur', 2),
(3, 'Admin', 'Super', '1990-01-20', 'Admin@outlook.com', '$2y$13$2ocIcaXZMSRGTJ1j.QZxG.OQ1nxRFmUhRqV1fYS5dLhRWp2ykad.W', '40 rue de l\'administration', '59100', 'Belleville', '0660257631', 'Big-Brother-67605b96481cf.jpg', 'Admin', 1),
(4, 'Bonisseur de La Bath', 'Hubert', '1949-03-21', 'UnMillionLarmina@hotmail.fr', '$2y$13$e8m88scpEzpbqU2GHberdeKmYMjWy2I0WxxkyJZ4jKQtd/N0RPLWS', 'Quai d\'Orsay', '57 Quai d\'', 'PARIS', '117117117', 'Hubert-67605eff0d878.png', 'User', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users_subscription`
--

CREATE TABLE `users_subscription` (
  `user_id` int(11) NOT NULL,
  `subscription_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users_subscription`
--

INSERT INTO `users_subscription` (`user_id`, `subscription_id`) VALUES
(1, 1),
(2, 2),
(3, 2);

-- --------------------------------------------------------

--
-- Structure de la table `work_rooms`
--

CREATE TABLE `work_rooms` (
  `id` int(11) NOT NULL,
  `max_capacity` int(11) NOT NULL,
  `equipment` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`equipment`)),
  `min_reservation_time` time NOT NULL,
  `max_reservation_time` time NOT NULL,
  `start_reservation_date` date NOT NULL,
  `end_reservation_date` date NOT NULL,
  `excluded_days` longtext DEFAULT NULL COMMENT '(DC2Type:simple_array)',
  `custom_id` int(11) DEFAULT NULL,
  `available` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `work_rooms`
--

INSERT INTO `work_rooms` (`id`, `max_capacity`, `equipment`, `min_reservation_time`, `max_reservation_time`, `start_reservation_date`, `end_reservation_date`, `excluded_days`, `custom_id`, `available`) VALUES
(18, 5, '[\"Wi-Fi\",\"Projecteur\",\"Tableau blanc\",\"Prises \\u00e9lectriques\",\"TV\",\"Air conditionn\\u00e9\"]', '10:00:00', '17:00:00', '2024-12-16', '2025-09-16', 'Dimanche', 1, 1),
(20, 2, '[\"Wi-Fi\",\"Projecteur\",\"Tableau blanc\",\"Prises \\u00e9lectriques\",\"TV\",\"Air conditionn\\u00e9\"]', '10:00:00', '17:00:00', '2024-12-18', '2024-12-20', 'Dimanche,Samedi', 2, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_CBE5A331614A603A` (`custom_id`),
  ADD KEY `IDX_CBE5A3316BF700BD` (`status_id`);

--
-- Index pour la table `book_book_category`
--
ALTER TABLE `book_book_category`
  ADD PRIMARY KEY (`book_id`,`book_category_id`),
  ADD KEY `IDX_7A5A379416A2B381` (`book_id`),
  ADD KEY `IDX_7A5A379440B1D29E` (`book_category_id`);

--
-- Index pour la table `book_borrowed_book`
--
ALTER TABLE `book_borrowed_book`
  ADD PRIMARY KEY (`book_id`,`borrowed_book_id`),
  ADD KEY `IDX_354080B016A2B381` (`book_id`),
  ADD KEY `IDX_354080B02913FDE8` (`borrowed_book_id`);

--
-- Index pour la table `book_category`
--
ALTER TABLE `book_category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `book_status`
--
ALTER TABLE `book_status`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `borrowed_book`
--
ALTER TABLE `borrowed_book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_50A9B8BC16A2B381` (`book_id`);

--
-- Index pour la table `borrow_history`
--
ALTER TABLE `borrow_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_794A76CFA76ED395` (`user_id`);

--
-- Index pour la table `borrow_history_book`
--
ALTER TABLE `borrow_history_book`
  ADD PRIMARY KEY (`borrow_history_id`,`book_id`),
  ADD KEY `IDX_302199C913DE62CA` (`borrow_history_id`),
  ADD KEY `IDX_302199C916A2B381` (`book_id`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9474526C16A2B381` (`book_id`),
  ADD KEY `IDX_9474526CA76ED395` (`user_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `modified_profile_image`
--
ALTER TABLE `modified_profile_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DF945FF5F52F9A2C` (`modify_user_id`);

--
-- Index pour la table `modify_user`
--
ALTER TABLE `modify_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CCDF2A8FA76ED395` (`user_id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4DA23981DCC8B1` (`work_room_id`),
  ADD KEY `IDX_4DA239A76ED395` (`user_id`);

--
-- Index pour la table `reserved_room`
--
ALTER TABLE `reserved_room`
  ADD PRIMARY KEY (`user_id`,`work_room_id`),
  ADD KEY `IDX_223AE444A76ED395` (`user_id`),
  ADD KEY `IDX_223AE44481DCC8B1` (`work_room_id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `UNIQ_57698A6AE09C0C92` (`role_name`);

--
-- Index pour la table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`);

--
-- Index pour la table `users_subscription`
--
ALTER TABLE `users_subscription`
  ADD PRIMARY KEY (`user_id`,`subscription_id`),
  ADD KEY `IDX_F08242DFA76ED395` (`user_id`),
  ADD KEY `IDX_F08242DF9A1887DC` (`subscription_id`);

--
-- Index pour la table `work_rooms`
--
ALTER TABLE `work_rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_545A61B9614A603A` (`custom_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `book_category`
--
ALTER TABLE `book_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `book_status`
--
ALTER TABLE `book_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `borrowed_book`
--
ALTER TABLE `borrowed_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `borrow_history`
--
ALTER TABLE `borrow_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `modified_profile_image`
--
ALTER TABLE `modified_profile_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `modify_user`
--
ALTER TABLE `modify_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `work_rooms`
--
ALTER TABLE `work_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `FK_CBE5A3316BF700BD` FOREIGN KEY (`status_id`) REFERENCES `book_status` (`id`);

--
-- Contraintes pour la table `book_book_category`
--
ALTER TABLE `book_book_category`
  ADD CONSTRAINT `FK_7A5A379416A2B381` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_7A5A379440B1D29E` FOREIGN KEY (`book_category_id`) REFERENCES `book_category` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `book_borrowed_book`
--
ALTER TABLE `book_borrowed_book`
  ADD CONSTRAINT `FK_354080B016A2B381` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_354080B02913FDE8` FOREIGN KEY (`borrowed_book_id`) REFERENCES `borrowed_book` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `borrowed_book`
--
ALTER TABLE `borrowed_book`
  ADD CONSTRAINT `FK_50A9B8BC16A2B381` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`);

--
-- Contraintes pour la table `borrow_history`
--
ALTER TABLE `borrow_history`
  ADD CONSTRAINT `FK_794A76CFA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `borrow_history_book`
--
ALTER TABLE `borrow_history_book`
  ADD CONSTRAINT `FK_302199C913DE62CA` FOREIGN KEY (`borrow_history_id`) REFERENCES `borrow_history` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_302199C916A2B381` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526C16A2B381` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`),
  ADD CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `modified_profile_image`
--
ALTER TABLE `modified_profile_image`
  ADD CONSTRAINT `FK_DF945FF5F52F9A2C` FOREIGN KEY (`modify_user_id`) REFERENCES `modify_user` (`id`);

--
-- Contraintes pour la table `modify_user`
--
ALTER TABLE `modify_user`
  ADD CONSTRAINT `FK_CCDF2A8FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `FK_4DA23981DCC8B1` FOREIGN KEY (`work_room_id`) REFERENCES `work_rooms` (`id`),
  ADD CONSTRAINT `FK_4DA239A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `reserved_room`
--
ALTER TABLE `reserved_room`
  ADD CONSTRAINT `FK_223AE44481DCC8B1` FOREIGN KEY (`work_room_id`) REFERENCES `work_rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_223AE444A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `users_subscription`
--
ALTER TABLE `users_subscription`
  ADD CONSTRAINT `FK_F08242DF9A1887DC` FOREIGN KEY (`subscription_id`) REFERENCES `subscription` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_F08242DFA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
