CREATE TABLE `g22_game2_answer` (
  `id_game` int NOT NULL,
  `answer` int NOT NULL,
  `link` varchar(150) NOT NULL
);

INSERT INTO `g22_game2_answer` (`id_game`, `answer`, `link`) VALUES
(3, 1, 'https://www.youtube.com/embed/-oG3hv8K3xs'),
(4, 1, 'https://www.youtube.com/embed/aT0ozccdEYg'),
(5, 0, 'https://www.youtube.com/embed/4pN5KD96QNc'),
(6, 1, 'https://www.youtube.com/embed/ZvTCkoS09uo'),
(7, 1, 'https://www.youtube.com/embed/rA9xUpHlw58'),
(8, 0, 'https://www.youtube.com/embed/h3fT9HOgmp0'),
(9, 0, 'https://www.youtube.com/embed/230j_czVRoU'),
(10, 1, 'https://www.youtube.com/embed/yUC6QOOsj5c'),
(11, 1, 'https://www.youtube.com/embed/xnU-oFF4sHg'),
(12, 0, 'https://www.youtube.com/embed/Z4JO04bhINQ'),
(13, 1, 'https://www.youtube.com/embed/dxOOCXJ3y2I'),
(14, 1, 'https://www.youtube.com/embed/pkoeZgFsNCA');

CREATE TABLE `g22_game_event` (
  `id_event` int NOT NULL,
  `id_user` int NOT NULL,
  `id_game` int NOT NULL,
  `score` int NOT NULL,
  `time_end` int NOT NULL,
  `time_start` int DEFAULT NULL
);

CREATE TABLE `g22_game_list` (
  `id_game` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(150) DEFAULT NULL,
  `type` int NOT NULL,
  `link` varchar(150) NOT NULL,
  `status` varchar(15) NOT NULL,
  `img` varchar(150) NOT NULL
);

INSERT INTO `g22_game_list` (`id_game`, `name`, `description`, `type`, `link`, `status`, `img`) VALUES
(1, 'Подводное Party', 'Подводное Party', 1, 'game1/indexGame1.php', 'active', 'cartin.jpg'),
(2, 'Верю - Не верю', 'Верю - Не верю', 2, 'youtube', 'active', 'cartin.jpg'),
(3, 'game2.1', '', 2, 'https://www.youtube.com/embed/Bs10lQDVPA0', 'no', 'img'),
(4, 'game2.2', '', 2, 'https://www.youtube.com/embed/Cx-wk9mRzI8', 'no', 'img'),
(5, 'game2.3', '', 2, 'https://www.youtube.com/embed/wEvfmd3jRJg', 'no', 'img'),
(6, 'game2.4', '', 2, 'https://www.youtube.com/embed/fXyr2WxjHcY', 'no', 'img'),
(7, 'game2.5', '', 2, 'https://www.youtube.com/embed/Q20J1P3IFeA', 'no', 'img'),
(8, 'game2.6', '', 2, 'https://www.youtube.com/embed/Spt3-HBvTSE', 'no', 'img'),
(9, 'game2.7', '', 2, 'https://www.youtube.com/embed/RdCbrSf91RE', 'no', 'img'),
(10, 'game2.8', '', 2, 'https://www.youtube.com/embed/AV6R6eODa7Q', 'no', 'img'),
(11, 'game2.9', '', 2, 'https://www.youtube.com/embed/MJZKLMLSUuA', 'no', 'img'),
(12, 'game2.10', '', 2, 'https://www.youtube.com/embed/5tp6Ejr2mZA', 'no', 'img'),
(13, 'game2.11', '', 2, 'https://www.youtube.com/embed/eDPWYgD6fjk', 'no', 'img'),
(14, 'game2.12', '', 2, 'https://www.youtube.com/embed/YPp7bqPFgpc', 'no', 'img'),
(15, 'Пароль на рыбьем языке', 'Пароль на рыбьем языке', 3, 'game3/indexGame3.php', 'active', 'cartin.jpg'),
(16, 'game3.1', '', 2, 'osoto elano na imato', 'no', 'img'),
(17, 'game3.2', '', 2, 'asa alano na atere na itere', 'no', 'img'),
(18, 'Найди отличия', 'Найди отличия', 4, 'game4/indexGame4.php', 'active', 'cartin.jpg');

CREATE TABLE `g22_rating` (
  `id_user` int NOT NULL,
  `id_game` int NOT NULL,
  `score` int NOT NULL,
  `time` int DEFAULT NULL
);

CREATE TABLE `g22_user` (
  `id_user` int NOT NULL,
  `login` varchar(50) NOT NULL,
  `id_department` int NOT NULL
);

INSERT INTO `g22_user` (`id_user`, `login`, `id_department`) VALUES
(1, 'Lemza_S_A', 0);

ALTER TABLE `g22_game_event`
  ADD PRIMARY KEY (`id_event`),
  ADD KEY `id_game` (`id_game`),
  ADD KEY `id_user` (`id_user`);

ALTER TABLE `g22_game_list`
  ADD PRIMARY KEY (`id_game`);

ALTER TABLE `g22_rating`
  ADD KEY `id_game` (`id_game`),
  ADD KEY `id_user` (`id_user`);

ALTER TABLE `g22_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `login` (`login`);


ALTER TABLE `g22_game_event`
  MODIFY `id_event` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `g22_game_list`
  MODIFY `id_game` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

ALTER TABLE `g22_user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `g22_game_event`
  ADD CONSTRAINT `g22_game_event_ibfk_1` FOREIGN KEY (`id_game`) REFERENCES `g22_game_list` (`id_game`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `g22_game_event_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `g22_user` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `g22_rating`
  ADD CONSTRAINT `g22_rating_ibfk_1` FOREIGN KEY (`id_game`) REFERENCES `g22_game_list` (`id_game`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `g22_rating_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `g22_user` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT;

