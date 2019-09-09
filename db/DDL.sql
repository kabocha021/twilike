SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `COMMENT` (
  `comment_id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `send_date` datetime NOT NULL,
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `delete_flg` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `COMMENT` (`comment_id`, `user_id`, `comment`, `img`, `send_date`, `update_date`, `delete_flg`) VALUES
(1, '3', 'password_hash() は、 アルゴリズムやコスト、ソルトといった情報もハッシュに含めて返すことに注意しましょう。 したがって、ハッシュの検証に必要な情報はすべてそこに含まれていることになります。 これで、検証関数がハッシュの検証をするときに、ソルトやアルゴリズム情報を別の場所から取得する必要がなくなります。', NULL, '2019-08-01 21:45:56', '2019-09-01 07:04:57', 0),
(2, '3', 'atin2 エンコーディングの組み込みのフォントの場合は 1, 2, 3, 4, 5 のいずれか (数字が大きなほうが、より大きいフォントに対応します)、 あるいは imageloadfont() で登録したフォントの識別子のいずれか。', NULL, '2019-08-01 21:45:56', '2019-09-01 10:08:28', 0),
(3, '4\r\n', '　米Appleは8月30日（現地時間）、「Apple Watch」のSeries 2およびSeries 3のアルミニウムモデルを対象とする画面交換プログラムを開始したと発表した。「非常にまれな状況下で」画面に亀裂が発生する可能性があると判断したとしている。', NULL, '2019-08-01 21:45:56', '2019-09-01 10:09:26', 0),
(4, '10', 'iPhone Xよりはもちろん大きいわけですが、普通に手に持って移動できるし、十分｢モバイル｣と呼べるバッテリーです。これならバックパックにも入るし、ポーチや肩掛けバックにも入ります。基本は持ち運ぶこと前提なので、このサイズ感はありがたい。', NULL, '1800-08-01 21:45:56', '2019-09-01 10:46:01', 0),
(5, '10', '8月上旬、太平洋を航行中の漁船が世にも奇妙な光景に出くわしました。\r\n\r\n青い海に突如現れた茶色。それは陸のようでもありますが、カラコロ音を立てて蠢き、近くに寄ると鼻が曲がるような異臭を漂わせています。よく見ると軽石の集合体で、1個1個は人間の頭ほどの大きさ。それがサンフランシスコ1個ぶん余りの面積を覆っていたのであります！', NULL, '1995-08-01 21:45:56', '2019-09-01 10:09:26', 0),
(6, '10', 'SADas', NULL, '2019-09-01 19:45:24', '2019-09-01 10:45:24', 0),
(7, '10', 'asdfasdfasd', NULL, '2019-09-01 19:45:28', '2019-09-01 10:45:28', 0),
(8, '10', '拝啓\r\n\r\n春陽の候、皆様お変わりなくお過ごしでしょうか。 さて、突然でございますが、貴方に折り入ってご相談したいことがありましてお手紙を差し上げます。\r\n\r\n実は貴方様に、天皇になって欲しいのです。', NULL, '2019-09-01 19:46:57', '2019-09-01 10:46:57', 0),
(9, '10', '拝啓\r\n\r\n春陽の候、皆様お変わりなくお過ごしでしょうか。 さて、突然でございますが、貴方に折り入ってご相談したいことがありましてお手紙を差し上げます。\r\n\r\n実は貴方様に、天皇になって欲しいのです。', NULL, '2019-09-01 19:47:01', '2019-09-01 10:47:01', 0),
(10, '10', '拝啓\r\n\r\n春陽の候、皆様お変わりなくお過ごしでしょうか。 さて、突然でございますが、貴方に折り入ってご相談したいことがありましてお手紙を差し上げます。\r\n\r\n実は貴方様に、天皇になって欲しいのです。', NULL, '2019-09-01 19:49:00', '2019-09-01 10:49:00', 0),
(11, '10', '拝啓\r\n\r\n春陽の候、皆様お変わりなくお過ごしでしょうか。 さて、突然でございますが、貴方に折り入ってご相談したいことがありましてお手紙を差し上げます。\r\n\r\n実は貴方様に、天皇になって欲しいのです。', NULL, '2019-09-01 19:50:10', '2019-09-01 10:50:10', 0),
(12, '10', '拝啓\r\n\r\n春陽の候、皆様お変わりなくお過ごしでしょうか。 さて、突然でございますが、貴方に折り入ってご相談したいことがありましてお手紙を差し上げます。\r\n\r\n実は貴方様に、天皇になって欲しいのです。', NULL, '2019-09-01 19:50:57', '2019-09-01 10:50:57', 0),
(13, '10', '拝啓\r\n\r\n春陽の候、皆様お変わりなくお過ごしでしょうか。 さて、突然でございますが、貴方に折り入ってご相談したいことがありましてお手紙を差し上げます。\r\n\r\n実は貴方様に、天皇になって欲しいのです。', NULL, '2019-09-01 19:52:16', '2019-09-01 10:52:16', 0),
(14, '11', '5000兆円欲しい！！！！', NULL, '2019-09-01 20:08:44', '2019-09-01 11:08:44', 0),
(20, '3', 'テスト', NULL, '2019-09-01 20:28:16', '2019-09-01 11:28:16', 0),
(21, '3', 'あああああ', NULL, '2019-09-01 20:28:18', '2019-09-01 11:28:18', 0),
(22, '10', 'ああああ', NULL, '2019-09-01 20:28:21', '2019-09-01 11:28:21', 0),
(23, '10', 'aaa\r\n', NULL, '2019-09-07 10:18:50', '2019-09-07 01:18:50', 0),
(24, '10', 'asdfasd', NULL, '2019-09-07 10:23:06', '2019-09-07 01:23:06', 0),
(25, '10', 'sdfasdfsdfsdddddddddddd', NULL, '2019-09-07 10:23:12', '2019-09-07 01:23:12', 0),
(26, '10', '<div> aiueo </div>', NULL, '2019-09-07 16:06:13', '2019-09-07 07:06:13', 0),
(27, '10', 'aiueo', NULL, '2019-09-07 16:06:26', '2019-09-07 07:06:26', 0),
(28, '10', '</body></html>', NULL, '2019-09-07 16:07:30', '2019-09-07 07:07:30', 0),
(30, '10', 'あいうえお', NULL, '2019-09-08 01:29:53', '2019-09-07 16:29:53', 0),
(31, '15', 'あいうえお', NULL, '2019-09-08 17:01:10', '2019-09-08 08:01:10', 0),
(32, '15', 'あああ', NULL, '2019-09-08 17:20:31', '2019-09-08 08:20:31', 0);

CREATE TABLE `FAVORITE` (
  `user_id` varchar(255) NOT NULL,
  `comment_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `USERS` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `delete_flg` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `USERS` (`user_id`, `name`, `email`, `pass`, `avatar`, `create_date`, `update_date`, `delete_flg`) VALUES
(3, 'admin', 'test@admin', '$2y$10$xjuPaWPSdbpwR2xogud35uSAwcy9G11t78ACyk6vYVpj/reBZTwCy', 'img/avator/defult1.jpg', '2019-08-31 11:18:46', '2019-09-07 16:31:21', 0),
(4, 'test', 'test@test2aaa', '$2y$10$c2TJ50RtHWJEnJbWcGGdy.17Oox9UIIlyymx2OgkxqhbyfxvWayUC', 'img/avator/defult2.png', '2019-09-01 01:33:50', '2019-09-07 16:31:25', 0),
(9, 'test', 'test@test2', '$2y$10$c2TJ50RtHWJEnJbWcGGdy.17Oox9UIIlyymx2OgkxqhbyfxvWayUC', 'img/avator/defult3.png', '2019-09-01 01:57:43', '2019-09-07 16:31:28', 0),
(10, 'admin', 'admin@admin', '$2y$10$Q8FOgSs1RJi0rbcb5jHDVObcKvn.c4GEWPPKKwnufM8V5vhb8dYfe', 'img/avatar/77bda1a426335d2e8023f3ca971fe95174903f6f.png', '2019-09-01 11:24:28', '2019-09-08 12:10:43', 0),
(11, 'admin', 'test@admin1', '$2y$10$c2TJ50RtHWJEnJbWcGGdy.17Oox9UIIlyymx2OgkxqhbyfxvWayUC', 'img/avator/defult2.png', '2019-09-01 11:24:28', '2019-09-07 16:31:30', 0),
(12, 'test', 'takaku.genki021@gmail.com', '$2y$10$eFRxU.994em5v3QHYbYDk.3yeL69sZgaK6xQtQE7fTYe9dD0pNnRe', NULL, '2019-09-08 09:39:30', '2019-09-08 01:18:46', 1),
(13, 'admin', 'test@admin', '$2y$10$xjuPaWPSdbpwR2xogud35uSAwcy9G11t78ACyk6vYVpj/reBZTwCy', 'img/avator/defult1.jpg', '2019-08-31 11:18:46', '2019-09-07 16:31:21', 0),
(14, 'test', 'takaku.genki021@gmail.com', '$2y$10$vkVtu5sIQLlXejZLNNAO6egk741WTWzJc0./KVCOYI9CnwYIjdUKS', NULL, '2019-09-08 10:42:01', '2019-09-08 01:43:15', 1),
(15, 'test', 'takaku.genki021@gmail.com', '$2y$10$C2P32hzzpcF7JoxvUOeakuNAmY3kwIrst7AqMNan2IMFfW5woSht6', 'img/avatar/bfe8ab323532c734f48143ca5d75e1a198930f2b.png', '2019-09-08 10:43:27', '2019-09-08 08:03:09', 0);


ALTER TABLE `COMMENT`
  ADD PRIMARY KEY (`comment_id`);

ALTER TABLE `FAVORITE`
  ADD PRIMARY KEY (`user_id`,`comment_id`);

ALTER TABLE `USERS`
  ADD PRIMARY KEY (`user_id`);


ALTER TABLE `COMMENT`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

ALTER TABLE `USERS`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
