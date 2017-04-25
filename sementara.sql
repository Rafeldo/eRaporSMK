hehe
INSERT INTO `users`(`id`, `data_sekolah_id`, `username`, `password`, `email`, ) 
VALUES 
(2,1,'tu','$2y$07$8T57oe/6LakPLiAcjQWDueu.S/DPaNrAX6SIBoaG3EcA6XtvVBTrS','tu@gmail.com'),
(3,1,'guru','$2y$07$8T57oe/6LakPLiAcjQWDueu.S/DPaNrAX6SIBoaG3EcA6XtvVBTrS','guru@gmail.com'),
(4,1,'siswa','$2y$07$8T57oe/6LakPLiAcjQWDueu.S/DPaNrAX6SIBoaG3EcA6XtvVBTrS','siswa@gmail.com'),
(5,1,'user','$2y$07$8T57oe/6LakPLiAcjQWDueu.S/DPaNrAX6SIBoaG3EcA6XtvVBTrS','user@gmail.com'),
(6,1,'waka','$2y$07$8T57oe/6LakPLiAcjQWDueu.S/DPaNrAX6SIBoaG3EcA6XtvVBTrS','waka@gmail.com')

INSERT INTO `users` 
(`id`, `data_sekolah_id`, `nisn`, `nipd`, `nuptk`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `phone`, `photo`, `id_petugas`, `data_siswa_id`, `data_guru_id`, `login_status`) VALUES 
(NULL, '1', NULL, NULL, NULL, '', 'tu', '$2y$07$8T57oe/6LakPLiAcjQWDueu.S/DPaNrAX6SIBoaG3EcA6XtvVBTrS', '', 'tu@gmail.com', NULL, NULL, NULL, NULL, CURRENT_TIMESTAMP, NULL, '1', NULL, '', '', '', '', '0'),
(NULL, '1', NULL, NULL, NULL, '', 'guru', '$2y$07$8T57oe/6LakPLiAcjQWDueu.S/DPaNrAX6SIBoaG3EcA6XtvVBTrS', '', 'guru@gmail.com', NULL, NULL, NULL, NULL, CURRENT_TIMESTAMP, NULL, '1', NULL, '', '', '', '', '0'),
(NULL, '1', NULL, NULL, NULL, '', 'siswa', '$2y$07$8T57oe/6LakPLiAcjQWDueu.S/DPaNrAX6SIBoaG3EcA6XtvVBTrS', '', 'siswa@gmail.com', NULL, NULL, NULL, NULL, CURRENT_TIMESTAMP, NULL, '1', NULL, '', '', '', '', '0'),
(NULL, '1', NULL, NULL, NULL, '', 'user', '$2y$07$8T57oe/6LakPLiAcjQWDueu.S/DPaNrAX6SIBoaG3EcA6XtvVBTrS', '', 'user@gmail.com', NULL, NULL, NULL, NULL, CURRENT_TIMESTAMP, NULL, '1', NULL, '', '', '', '', '0'),
(NULL, '1', NULL, NULL, NULL, '', 'waka', '$2y$07$8T57oe/6LakPLiAcjQWDueu.S/DPaNrAX6SIBoaG3EcA6XtvVBTrS', '', 'waka@gmail.com', NULL, NULL, NULL, NULL, CURRENT_TIMESTAMP, NULL, '1', NULL, '', '', '', '', '0');
(NULL, '1', NULL, NULL, NULL, '', 'waka', '$2y$07$8T57oe/6LakPLiAcjQWDueu.S/DPaNrAX6SIBoaG3EcA6XtvVBTrS', '', 'waka@gmail.com', NULL, NULL, NULL, NULL, CURRENT_TIMESTAMP, NULL, '1', NULL, '', '', '', '', '0');


password admin semua
INSERT INTO `users`(`id`, `data_sekolah_id`, `username`,  `email`, ) 
VALUES 
(2,1,`tu`,`tu@gmail.com`),
(3,1,`guru`,`guru@gmail.com`),
(4,1,`siswa`,`siswa@gmail.com`),
(5,1,`user`,`user@gmail.com`),
(6,1,`waka`,`waka@gmail.com`)

INSERT INTO `users_groups`(`user_id`, `group_id`) 
VALUES 
('2','2'),
('3','3'),
('4','4'),
('5','5'),
('6','6');

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'tu', 'Tata Usaha'),
(3, 'guru', 'Guru'),
(4, 'siswa', 'Siswa'),
(5, 'user', 'General User'),
(6, 'waka', 'Waka Kurikulum');
(7, 'kasir', 'Penerimaan Keuangan');

INSERT INTO `a_bulan`(`bulan`) 
VALUES (`Januari`),
 (`Februari`),
 (`Maret`),
 (`April`),
 (`Mei`),
 (`Juni`),
 (`Juli`),
 (`Agustus),
 (`September`),
 (`Oktober`),
 (`November`),
 (`Desember`),