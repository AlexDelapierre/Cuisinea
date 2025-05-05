--
-- Base de données : `cuisinea`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Entrée'),
(2, 'Plat'),
(3, 'Dessert');

-- --------------------------------------------------------

--
-- Structure de la table `recipes`
--

DROP TABLE IF EXISTS `recipes`;
CREATE TABLE IF NOT EXISTS `recipes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `ingredients` text NOT NULL,
  `instructions` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`users_id`)
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `recipes`
--

INSERT INTO `recipes` (`id`, `category_id`, `title`, `description`, `ingredients`, `instructions`, `image`) VALUES
(1, 1, 'Salade de chèvre', 'La salade de chèvre est une préparation fraîche et légère, idéale pour les repas d\'été. Elle se compose de feuilles de salade, de tranches de poire et d\'émietté de chèvre frais, le tout assaisonné avec une vinaigrette légère à base d\'huile d\'olive et de vinaigre de vin.', '1 boule de chèvre frais\r\n1 botte de salade (laitue, roquette, mâche, etc.)\r\n1 poignée de noix (noisettes, amandes, noix de cajou, etc.)\r\n1 poire\r\nQuelques feuilles de menthe\r\n1 cuillère à soupe de vinaigrette (huile d\'olive, vinaigre de vin, moutarde, sel et poivre)', 'Commencez par laver et essorer votre salade. Découpez-la en fines lamelles et répartissez-la dans les assiettes.\r\nCoupez la poire en fines tranches et répartissez-les sur la salade.\r\nÉmiettez le chèvre et répartissez-le sur la salade.\r\nParsemez la salade de noix concassées et de feuilles de menthe ciselées.\r\nPréparez la vinaigrette en mélangeant une cuillère à soupe d\'huile d\'olive, une cuillère à soupe de vinaigre de vin, une pincée de moutarde, du sel et du poivre. Versez-la sur la salade et mélangez bien.\r\nServez la salade de chèvre fraîche, accompagnée d\'un pain croustillant.', '3-salade.jpg');
(2, 2, 'Gratin dauphinois', 'Le gratin dauphinois est une recette traditionnelle de la région de Dauphiné, située dans les Alpes françaises. Il se compose de fines tranches de pommes de terre cuites dans du lait et du beurre, le tout gratiné au four jusqu\'à ce qu\'il soit doré et croustillant.', '1 kg de pommes de terre à chair ferme\r\n1 litre de lait entier\r\n3 gousses d\'ail\r\n50 g de beurre\r\nSel et poivre', 'Préchauffez le four à 180°C (th. 6). Pelez et rincez les pommes de terre. Coupez-les en fines tranches à l\'aide d\'une mandoline ou d\'un couteau bien aiguisé.\r\nDans une grande casserole, faites chauffer le lait avec les gousses d\'ail épluchées et pressées. Ajoutez une pincée de sel et une poignée de poivre.\r\nQuand le lait commence à frémir, ajoutez les tranches de pommes de terre en les disposant en couches bien serrées. Laissez cuire à feu doux pendant environ 10 minutes, jusqu\'à ce que les pommes de terre soient tendres.\r\nÉgouttez les pommes de terre en conservant le lait chaud. Disposez les tranches de pommes de terre dans un plat à gratin beurré.\r\nVersez le lait chaud sur les pommes de terre en veillant à ce qu\'il recouvre entièrement les tranches. Parsemez le dessus de quelques noisettes de beurre.\r\nEnfournez le gratin pendant 30 à 40 minutes, jusqu\'à ce qu\'il soit doré et bien gratiné. Servez chaud, accompagné d\'une salade verte ou d\'une viande grillée.', '2-gratin-dauphinois.jpg'),
(3, 3, 'Mousse au chocolat', 'La mousse au chocolat est une véritable gourmandise qui plaira à tous les amateurs de chocolat. Cette recette est très simple à réaliser et ne nécessite que quelques ingrédients de base.', '200g de chocolat noir à pâtisser\r\n4 oeufs\r\n30g de sucre en poudre\r\n1 pincée de sel\r\n', 'Faites fondre le chocolat au bain-marie ou au micro-ondes, puis laissez-le refroidir légèrement.\r\nSéparez les blancs des jaunes d\'oeufs. Mettez les blancs dans un saladier et réservez.\r\nDans un autre saladier, fouettez les jaunes d\'oeufs avec le sucre et le sel jusqu\'à ce que le mélange blanchisse.\r\nAjoutez le chocolat fondu aux jaunes d\'oeufs et mélangez bien.\r\nMontez les blancs en neige ferme et incorporez-les délicatement à la préparation au chocolat en prenant soin de ne pas casser les blancs.\r\nVersez la mousse dans des verrines ou dans un grand bol et réfrigérez pendant au moins 2 heures avant de déguster.', '1-chocolate-au-mousse.jpg'),

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

