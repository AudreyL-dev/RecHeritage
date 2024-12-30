CREATE DATABASE IF NOT EXISTS `partage_de_recettes`;
USE `partage_de_recettes`;

-- Création de la table recipes
CREATE TABLE IF NOT EXISTS `recipes` (
    `recipe_id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(128) NOT NULL,
    `recipe` TEXT NOT NULL,
    `author` varchar(255) NOT NULL,
    `is_enabled` BOOLEAN NOT NULL,
    PRIMARY KEY (`recipe_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Création de la table users
CREATE TABLE IF NOT EXISTS `users` (
    `user_id` int(11) NOT NULL AUTO_INCREMENT,
    `pseudo` varchar(64) NOT NULL,
    `email` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `age` INT NOT NULL,
    PRIMARY KEY (`user_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

delete from `users`;
insert into `users` (`age`, `email`, `pseudo`, `password`, `user_id`) values (36, 'tata@exemple.com', 'Tata', 'tatalours', 1);
insert into `users` (`age`, `email`, `pseudo`, `password`, `user_id`) values (45, 'maman@exemple.com', 'Maman', 'mamanChou', 2);
insert into `users` (`age`, `email`, `pseudo`, `password`, `user_id`) values (18, 'AliAyashi@exemple.com', 'Les Frérots', 'LesBGdu80', 3);

delete from `recipes`;
insert into `recipes` (`author`, `is_enabled`, `recipe`, `recipe_id`, `title`) values ('tata@exemple.com', 0, "Coupez la courge butternut en deux dans le sens de la longueur puis videz-là de ses graines. À l’aide d’une cuillère à pomme parisienne, retirez un peu de la chair à l’intérieur de chaque moitié; suffisamment pour pouvoir les farcir. Coupez la chair prélevée en petits dés.", 1, 'Butternut farci à la bolognaise');
insert into `recipes` (`author`, `is_enabled`, `recipe`, `recipe_id`, `title`) values ('AliAyashi@exemple.com', 1, "Ramollissez le beurre en pommade et mélangez-le avec le sucre vanillé et le sucre en poudre.Ajoutez les oeufs battus. Puis incorporez la farine et la levure mélangées, en fouettant pour éviter les grumeaux.Pelez les pommes et coupez-les en cubes, mélangez-les à la pâte et versez dans un moule à manqué beurré ou tapissé de papier cuisson (environ 24 cm de diamètre).Faites cuire le gâteau aux pommes 30 à 40 min dans le four préchauffé à 180°C.", 2, 'Galette aux pommes');
insert into `recipes` (`author`, `is_enabled`, `recipe`, `recipe_id`, `title`) values ('laurene.castor@exemple.com', 1, "Verser l’huile d’olive dans le multicuiseur. Ajouter les 500 g de chou-fleur,les 250 g de mozzarella (égouttée),1 /4 c. à c. de curry et ajouter Sel et Poivre noir.Faire cuire en mode BAKING/DESSERT (FOUR/DESSERT) pendant 45 minutes. ", 3, 'Gratin de chou-fleur au fromage et au curry');
insert into `recipes` (`author`, `is_enabled`, `recipe`, `recipe_id`, `title`) values ('maman@exemple.com', 1, "Porter de l'eau à ébullition sans oublier de mettre le sel.
Faire revenir l'ail haché dans le beurre ajouter les poissons, assaisonner et rajouter le persil finement coupé.
Insérer les sachets de riz dans l'eau
Retourner les filets délicatement sans les couper afin qu'ils soient cuits à l' intérieur.
Verser la crème sur les poissons et laisser épaissir.
Pendant ce temps, retirer les sachets de riz les couper, puis les verser sur une assiette avec une noisette de beurre.
Retirer le poisson du feu, disposer le filet de poisson à coté du riz et verser la crème.
Pour le plaisir des yeux entreposer une feuille de persil sur le riz !", 4, 'Poisson Panga');