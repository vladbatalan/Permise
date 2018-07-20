-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 20 Iul 2018 la 18:41
-- Versiune server: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `permisedb`
--

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `administratori`
--

CREATE TABLE `administratori` (
  `id_admin` int(11) NOT NULL,
  `username_admin` varchar(50) NOT NULL,
  `parola_admin` varchar(50) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `salt_parola` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `administratori`
--

INSERT INTO `administratori` (`id_admin`, `username_admin`, `parola_admin`, `id_rol`, `salt_parola`) VALUES
(1, 'administrator', '$1$ef42168a$M6s06504ncNJiqEDUSQtB1', 1, 'ef42168aea02023e32e439113536b8b0'),
(5, 'new_admin', '$1$0f7e978b$69fyiK/meglabQmiJOJA50', 2, '0f7e978be4a8b0597b3641dff033ce59');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `proceduri`
--

CREATE TABLE `proceduri` (
  `id_procedura` int(11) NOT NULL,
  `nume_procedura` varchar(50) NOT NULL,
  `descriere_procedura` varchar(50) NOT NULL,
  `timp_procedura` int(11) NOT NULL,
  `tip_procedura` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `proceduri`
--

INSERT INTO `proceduri` (`id_procedura`, `nume_procedura`, `descriere_procedura`, `timp_procedura`, `tip_procedura`) VALUES
(1, 'inmatriculare_definitiva', 'Inmatriculare definitiva', 10, 1),
(3, 'preschimbare_permise', 'Preschimbare permise', 10, 2),
(4, 'examinare_dosare', 'Examinare dosare', 10, 2),
(5, 'inmatriculare_provizorie', 'Inmatriculare provizorie', 10, 1),
(6, 'radiere', 'Radiere', 10, 1),
(7, 'duplicare_certificat', 'Duplicare certificat', 10, 1),
(8, 'placute_pierdute', 'Placute pierdute', 10, 1);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `programari`
--

CREATE TABLE `programari` (
  `id_programare` int(11) NOT NULL,
  `tip_persoana` varchar(20) NOT NULL,
  `nume_realizator` varchar(100) NOT NULL,
  `cod_unic` varchar(100) NOT NULL,
  `email_realizator` varchar(100) NOT NULL,
  `serie_sasiu` varchar(100) NOT NULL,
  `data_programare` date NOT NULL,
  `ora_programare` int(11) NOT NULL,
  `tip_procedura` int(11) NOT NULL,
  `id_procedura` int(11) NOT NULL,
  `cheie_cryptare` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `programari`
--

INSERT INTO `programari` (`id_programare`, `tip_persoana`, `nume_realizator`, `cod_unic`, `email_realizator`, `serie_sasiu`, `data_programare`, `ora_programare`, `tip_procedura`, `id_procedura`, `cheie_cryptare`) VALUES
(27, 'fizica', 'Rambo', 'hCFz4Jm/VsavQRMy3wSCNPDHGUiJ8kaMYCJrVytyqdQ=', 'rambo@distrugatorii.net', 'eOUnnSWSd5nvCzYmRjNOk4moYEoKKhnV27XG4bWzEzU=', '2018-08-07', 480, 1, 6, '16c3cd563f4b3e781bc26c7f68f4ecbc'),
(28, 'fizica', 'Jimme', 'BDm6SxAiHgH9/vCN2bOa/dQ7L5yTbrkhkWycTGsfjtw=', 'jimechan@vals.now', '/k5eHFSy7QVS2pmkKMwsAsMrWZPXIbDvucABpgNr/3I=', '2018-08-07', 480, 2, 4, 'e98e06c80af57dd45b5128237a8f3b8b'),
(29, 'fizica', 'Sofian', '+QQGq/Pg/3oh6qk42JjdqOhhxhvXw9+vBrSBXQBdQC8=', 'ciocan@dasd.23s', 'QKlA1tYdbKkMzlUOpEf0oDXS8SZOflZ9xxnFcoZj/fw=', '2018-08-07', 490, 1, 1, '5172bdbc2dbde2435500561488d2d314'),
(30, 'fizica', '&amp;lt;script&amp;gt;alert(&amp;quot;Ai belit capra bejetu!&amp;quot;);&amp;lt;/script&amp;gt;', 'efMniNobKPkYNEwqbr74Cm0sH4Gjqz24jyNmCL1wPMY=', '', 'RUs5x2FBw86UjBfrd/C8fZXPqj7Fd+b740r5d5FnVQA=', '2018-07-16', 480, 1, 1, '94a76c60461ba571fcd34f7f8dd25b6f');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `program_zilnic`
--

CREATE TABLE `program_zilnic` (
  `id_zi` int(11) NOT NULL,
  `nume_zi` varchar(20) NOT NULL,
  `indice_zi` int(11) NOT NULL,
  `de_la_ora` int(11) NOT NULL,
  `pana_la_ora` int(11) NOT NULL,
  `tip_procedura` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `program_zilnic`
--

INSERT INTO `program_zilnic` (`id_zi`, `nume_zi`, `indice_zi`, `de_la_ora`, `pana_la_ora`, `tip_procedura`) VALUES
(2, 'Luni', 1, 480, 900, 1),
(3, 'Marti', 2, 480, 900, 1),
(4, 'Mercuri', 3, 480, 1020, 1),
(5, 'Joi', 4, 480, 900, 1),
(6, 'Vineri', 5, 480, 660, 1),
(8, 'Marti', 2, 480, 720, 2),
(9, 'Joi', 4, 480, 720, 2);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `rol_administrator`
--

CREATE TABLE `rol_administrator` (
  `id_rol` int(11) NOT NULL,
  `rol_admin` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `rol_administrator`
--

INSERT INTO `rol_administrator` (`id_rol`, `rol_admin`) VALUES
(1, 'suprem'),
(2, 'vizitator');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `sarbatori_legale`
--

CREATE TABLE `sarbatori_legale` (
  `id_sarbatoare` int(11) NOT NULL,
  `data_sarbatoare` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administratori`
--
ALTER TABLE `administratori`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indexes for table `proceduri`
--
ALTER TABLE `proceduri`
  ADD PRIMARY KEY (`id_procedura`);

--
-- Indexes for table `programari`
--
ALTER TABLE `programari`
  ADD PRIMARY KEY (`id_programare`),
  ADD KEY `id_pocedura` (`id_procedura`);

--
-- Indexes for table `program_zilnic`
--
ALTER TABLE `program_zilnic`
  ADD PRIMARY KEY (`id_zi`);

--
-- Indexes for table `rol_administrator`
--
ALTER TABLE `rol_administrator`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indexes for table `sarbatori_legale`
--
ALTER TABLE `sarbatori_legale`
  ADD PRIMARY KEY (`id_sarbatoare`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administratori`
--
ALTER TABLE `administratori`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `proceduri`
--
ALTER TABLE `proceduri`
  MODIFY `id_procedura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `programari`
--
ALTER TABLE `programari`
  MODIFY `id_programare` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `program_zilnic`
--
ALTER TABLE `program_zilnic`
  MODIFY `id_zi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `rol_administrator`
--
ALTER TABLE `rol_administrator`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sarbatori_legale`
--
ALTER TABLE `sarbatori_legale`
  MODIFY `id_sarbatoare` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restrictii pentru tabele sterse
--

--
-- Restrictii pentru tabele `administratori`
--
ALTER TABLE `administratori`
  ADD CONSTRAINT `administratori_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol_administrator` (`id_rol`) ON UPDATE CASCADE;

--
-- Restrictii pentru tabele `programari`
--
ALTER TABLE `programari`
  ADD CONSTRAINT `programari_ibfk_1` FOREIGN KEY (`id_procedura`) REFERENCES `proceduri` (`id_procedura`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
