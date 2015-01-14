-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2015 at 05:09 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `phuthanh_quanlynhansu`
--

-- --------------------------------------------------------

--
-- Table structure for table `tlb_baohiem`
--

CREATE TABLE IF NOT EXISTS `tlb_baohiem` (
  `id` int(9) NOT NULL,
  `ma_nhan_vien` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `so_bhxh` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngay_cap_bhxh` date NOT NULL,
  `noi_cap_bhxh` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `so_bhyt` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngay_cap_bhyt` date NOT NULL,
  `noi_cap_bhyt` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tlb_baohiem`
--

INSERT INTO `tlb_baohiem` (`id`, `ma_nhan_vien`, `so_bhxh`, `ngay_cap_bhxh`, `noi_cap_bhxh`, `so_bhyt`, `ngay_cap_bhyt`, `noi_cap_bhyt`) VALUES
(0, 'PT01', '112021342014', '2014-06-10', 'Nam Phong, Phú Xuyên, Hà Nội', '112031342014', '2014-05-17', 'Bệnh Viện Bạch Mai, Q. Hai Bà Trưng, Hà Nội'),
(1, 'PT01', '112021342014', '2014-06-10', 'Nam Phong, Phú Xuyên, Hà Nội', '112031342014', '2014-05-17', 'Bệnh Viện Bạch Mai, Q. Hai Bà Trưng, Hà Nội');

-- --------------------------------------------------------

--
-- Table structure for table `tlb_chucvu`
--

CREATE TABLE IF NOT EXISTS `tlb_chucvu` (
  `chuc_vu_id` int(2) NOT NULL,
  `ma_chuc_vu` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten_chuc_vu` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngay_tao` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tlb_chucvu`
--

INSERT INTO `tlb_chucvu` (`chuc_vu_id`, `ma_chuc_vu`, `ten_chuc_vu`, `ngay_tao`) VALUES
(0, 'TTV', 'Thực tập viên', '0000-00-00'),
(1, 'BGD001', 'Giám đốc', '0000-00-00'),
(2, 'BGD002', 'Phó giám đốc', '0000-00-00'),
(3, 'DT001', 'Đội trưởng', '0000-00-00'),
(4, 'NV001', 'Nhân viên', '0000-00-00'),
(6, 'TP001', 'Trưởng phòng', '0000-00-00'),
(7, 'TPP001', 'Phó trưởng phòng', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `tlb_congviec`
--

CREATE TABLE IF NOT EXISTS `tlb_congviec` (
  `ma_nhan_vien` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `ngay_vao_lam` date NOT NULL,
  `ma_phong_ban` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `ma_cong_viec` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ma_chuc_vu` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `muc_luong_cb` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `he_so` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phu_cap` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tong_luong` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tknh` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ngan_hang` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ghi_chu` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `ngay_sua` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tlb_congviec`
--

INSERT INTO `tlb_congviec` (`ma_nhan_vien`, `ngay_vao_lam`, `ma_phong_ban`, `ma_cong_viec`, `ma_chuc_vu`, `muc_luong_cb`, `he_so`, `phu_cap`, `tong_luong`, `tknh`, `ngan_hang`, `ghi_chu`, `ngay_sua`) VALUES
('PT01', '2015-01-01', 'PKT', 'CNTT', 'NV001', '10000000', '1.2', '400000', '12400000', '112389843', 'Techcombank', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `tlb_ctcongviec`
--

CREATE TABLE IF NOT EXISTS `tlb_ctcongviec` (
  `cong_viec_id` int(2) NOT NULL,
  `ma_cong_viec` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten_cong_viec` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngay_tao` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tlb_ctcongviec`
--

INSERT INTO `tlb_ctcongviec` (`cong_viec_id`, `ma_cong_viec`, `ten_cong_viec`, `ngay_tao`) VALUES
(0, 'OTHER', 'Khác', '0000-00-00'),
(1, 'BVAN', 'Bảo vệ - An ninh', '0000-00-00'),
(2, 'CNTT', 'Công nghệ thông tin', '0000-00-00'),
(3, 'KTTN', 'Kế toán - Thu ngân', '0000-00-00'),
(4, 'TXVC', 'Tài xế - Vận chuyển', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `tlb_hinhanh`
--

CREATE TABLE IF NOT EXISTS `tlb_hinhanh` (
`id` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` int(11) NOT NULL,
  `caption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ma_nhan_vien` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tlb_hinhanh`
--

INSERT INTO `tlb_hinhanh` (`id`, `filename`, `type`, `size`, `caption`, `ma_nhan_vien`) VALUES
(1, '1415062786.jpg', 'image/jpeg', 10733, NULL, 'PT01'),
(2, '1401876_617574461687425_5570022990421885478_o.jpg', 'image/jpeg', 39267, NULL, 'PT03');

-- --------------------------------------------------------

--
-- Table structure for table `tlb_hopdong`
--

CREATE TABLE IF NOT EXISTS `tlb_hopdong` (
`id` mediumint(9) NOT NULL,
  `ma_nhan_vien` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `so_quyet_dinh` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tu_ngay` date DEFAULT NULL,
  `den_ngay` date DEFAULT NULL,
  `loai_hop_dong` int(1) DEFAULT NULL,
  `ghi_chu` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=29 ;

--
-- Dumping data for table `tlb_hopdong`
--

INSERT INTO `tlb_hopdong` (`id`, `ma_nhan_vien`, `so_quyet_dinh`, `tu_ngay`, `den_ngay`, `loai_hop_dong`, `ghi_chu`) VALUES
(27, 'PT01', 'QTCP-12/2013', '2012-06-05', '2014-12-19', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tlb_log`
--

CREATE TABLE IF NOT EXISTS `tlb_log` (
`log_id` int(11) NOT NULL,
  `remote_addr` varchar(255) NOT NULL DEFAULT '',
  `request_uri` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tlb_nguoidung`
--

CREATE TABLE IF NOT EXISTS `tlb_nguoidung` (
`id` int(10) NOT NULL,
  `ten_dang_nhap` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mat_khau` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quyen_them` tinyint(1) DEFAULT '0',
  `quyen_sua` tinyint(1) DEFAULT '0',
  `quyen_xoa` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `tlb_nguoidung`
--

INSERT INTO `tlb_nguoidung` (`id`, `ten_dang_nhap`, `mat_khau`, `quyen_them`, `quyen_sua`, `quyen_xoa`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, 1, 1),
(5, 'tuyen76', 'e10adc3949ba59abbe56e057f20f883e', 0, 1, 0),
(11, 'test1', 'e10adc3949ba59abbe56e057f20f883e', 0, 0, 0),
(12, 'test2', 'e10adc3949ba59abbe56e057f20f883e', 1, 1, 0),
(13, 'test3', 'e10adc3949ba59abbe56e057f20f883e', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tlb_nhanvien`
--

CREATE TABLE IF NOT EXISTS `tlb_nhanvien` (
  `ma_nhan_vien` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `ho_ten` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `gioi_tinh` tinyint(1) NOT NULL,
  `gia_dinh` tinyint(1) NOT NULL,
  `dt_di_dong` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dt_nha` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ngay_sinh` date DEFAULT NULL,
  `noi_sinh` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cmnd` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ngay_cap` date DEFAULT NULL,
  `noi_cap` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `que_quan` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dia_chi` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tam_tru` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nghi_viec` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tlb_nhanvien`
--

INSERT INTO `tlb_nhanvien` (`ma_nhan_vien`, `ho_ten`, `gioi_tinh`, `gia_dinh`, `dt_di_dong`, `dt_nha`, `email`, `ngay_sinh`, `noi_sinh`, `cmnd`, `ngay_cap`, `noi_cap`, `que_quan`, `dia_chi`, `tam_tru`, `nghi_viec`) VALUES
('PT01', 'Nguyễn Ngọc Tuyền', 1, 0, '0973874453', '0433857805', 'thinghost76@gmail.com', '1989-02-27', 'Phú Xuyên - Hà Nội', '112389842', '2007-02-07', 'CA Hà Tây', 'Xã Nam Phong, Huyện Phú Xuyên, TP Hà Nội', 'Xã Nam Phong, Huyện Phú Xuyên, TP Hà Nội', '62D Ngõ 192, Hạ Đình, Thanh Xuân, Hà Nội', 0),
('PT03', 'Đào Quang Hoan', 1, 1, '0973874324', NULL, 'daoquanghoan92@yahoo.com', '1970-01-01', 'Phú Xuyên - Hà Nội', '112389123', '1970-01-01', 'CA Hà Tây', 'Xã Nam Phong, Huyện Phú Xuyên, TP Hà Nội', 'Thị trấn Phú Xuyên, Phú Xuyên, Hà Nội', '62D Ngõ 192, Hạ Đình, Thanh Xuân, Hà Nội', 1),
('PT05', 'Hà Tiến Thành', 1, 0, '0973874327', NULL, 'minhduc_dhtm89@yahoo.com', '1970-01-01', 'Phú Xuyên - Hà Nội', '112389123', '1970-01-01', 'CA Hà Tây', 'Xã Nam Phong, Huyện Phú Xuyên, TP Hà Nội', 'Xã Nam Phong, Huyện Phú Xuyên, TP Hà Nội', '62D Ngõ 192, Hạ Đình, Thanh Xuân, Hà Nội', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tlb_phongban`
--

CREATE TABLE IF NOT EXISTS `tlb_phongban` (
  `phong_ban_id` int(2) NOT NULL,
  `ma_phong_ban` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten_phong_ban` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngay_tao` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tlb_phongban`
--

INSERT INTO `tlb_phongban` (`phong_ban_id`, `ma_phong_ban`, `ten_phong_ban`, `ngay_tao`) VALUES
(1, 'PGD', 'Phòng Giám Đốc', '0000-00-00'),
(2, 'PHDQT', 'Phòng Hội đồng quản trị', '0000-00-00'),
(3, 'PKDXNK', 'Phòng Kinh Doanh Xuất Nhập Khẩu', '0000-00-00'),
(4, 'PKT', 'Phòng Kỹ Thuật', '0000-00-00'),
(5, 'PPGDKD', 'Phòng Phó Giám Đốc Kinh Doanh', '0000-00-00'),
(6, 'PPGDKT', 'Phòng Phó Giám Đốc Kỹ Thuật', '0000-00-00'),
(7, 'PTCKT', 'Phòng Tài Chính Kế Toán', '0000-00-00'),
(8, 'XCKCT', 'Xưởng Cơ Khí Chế Tạo', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `tlb_quanhegiadinh`
--

CREATE TABLE IF NOT EXISTS `tlb_quanhegiadinh` (
`id` mediumint(9) NOT NULL,
  `ma_nhan_vien` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten_nguoi_than` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nam_sinh` int(4) NOT NULL,
  `moi_quan_he` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nghe_nghiep` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dia_chi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dtll` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ghi_chu` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=22 ;

--
-- Dumping data for table `tlb_quanhegiadinh`
--

INSERT INTO `tlb_quanhegiadinh` (`id`, `ma_nhan_vien`, `ten_nguoi_than`, `nam_sinh`, `moi_quan_he`, `nghe_nghiep`, `dia_chi`, `dtll`, `ghi_chu`) VALUES
(16, 'PT01', 'Nguyễn Khánh Linh', 1995, 'Em gái', 'Sinh viên', 'Xã Nam Phong, Huyện Phú Xuyên, TP Hà Nội', '0973888431', NULL),
(21, 'PT01', 'Vũ Thị Lý', 1961, 'Mẹ đẻ', 'Nông dân', 'Xã Nam Phong, Huyện Phú Xuyên, TP Hà Nội', '0973888432', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tlb_quatrinhcongtac`
--

CREATE TABLE IF NOT EXISTS `tlb_quatrinhcongtac` (
`id` mediumint(9) NOT NULL,
  `ma_nhan_vien` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `so_quyet_dinh` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_ky` date DEFAULT NULL,
  `ngay_hieu_luc` date DEFAULT NULL,
  `cong_viec` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ghi_chu` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=22 ;

--
-- Dumping data for table `tlb_quatrinhcongtac`
--

INSERT INTO `tlb_quatrinhcongtac` (`id`, `ma_nhan_vien`, `so_quyet_dinh`, `ngay_ky`, `ngay_hieu_luc`, `cong_viec`, `ghi_chu`) VALUES
(19, 'PT01', 'QTCP-12/2013', '2014-10-15', '2020-08-11', 'Nhân viên phụ trách kỹ thuật IT', NULL),
(20, 'PT01', 'QTCP-01/2015', '2015-01-01', '2015-01-03', 'Quản lý phụ trách kỹ thuật IT', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tlb_quatrinhluong`
--

CREATE TABLE IF NOT EXISTS `tlb_quatrinhluong` (
`id` mediumint(11) NOT NULL,
  `ma_nhan_vien` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_quyet_dinh` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_chuyen` date NOT NULL,
  `muc_luong` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_sua` date NOT NULL,
  `ghi_chu` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `tlb_quatrinhluong`
--

INSERT INTO `tlb_quatrinhluong` (`id`, `ma_nhan_vien`, `so_quyet_dinh`, `ngay_chuyen`, `muc_luong`, `ngay_sua`, `ghi_chu`) VALUES
(13, 'PT01', 'QTCP-11/2013', '2014-12-09', '8000000', '2015-01-14', NULL),
(18, 'PT01', 'QTCP-11/2012', '2014-12-18', '10000000', '2015-01-01', NULL),
(19, 'PT01', 'QTCP-01/2015', '2015-01-04', '21000000', '2015-01-14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tlb_tailieu`
--

CREATE TABLE IF NOT EXISTS `tlb_tailieu` (
`id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `filename` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `type` varchar(100) NOT NULL,
  `size` int(11) NOT NULL,
  `ngay_tao` date NOT NULL,
  `ngay_sua` date NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tlb_tailieu`
--

INSERT INTO `tlb_tailieu` (`id`, `title`, `filename`, `type`, `size`, `ngay_tao`, `ngay_sua`) VALUES
(1, 'Tài liệu cơ sở tháng 9/2014', 'win_fetch_cacerts.rb', 'application/octet-stream', 797, '2015-01-02', '2015-01-03'),
(2, 'Tài liệu mật thứ 2', '10741096_1001200373227304_1965417887_n.xls', 'application/vnd.ms-excel', 34816, '2014-12-24', '2014-12-31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tlb_baohiem`
--
ALTER TABLE `tlb_baohiem`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tlb_chucvu`
--
ALTER TABLE `tlb_chucvu`
 ADD PRIMARY KEY (`chuc_vu_id`);

--
-- Indexes for table `tlb_congviec`
--
ALTER TABLE `tlb_congviec`
 ADD PRIMARY KEY (`ma_nhan_vien`,`ma_phong_ban`);

--
-- Indexes for table `tlb_ctcongviec`
--
ALTER TABLE `tlb_ctcongviec`
 ADD PRIMARY KEY (`cong_viec_id`);

--
-- Indexes for table `tlb_hinhanh`
--
ALTER TABLE `tlb_hinhanh`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tlb_hopdong`
--
ALTER TABLE `tlb_hopdong`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tlb_log`
--
ALTER TABLE `tlb_log`
 ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `tlb_nguoidung`
--
ALTER TABLE `tlb_nguoidung`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tlb_nhanvien`
--
ALTER TABLE `tlb_nhanvien`
 ADD PRIMARY KEY (`ma_nhan_vien`);

--
-- Indexes for table `tlb_phongban`
--
ALTER TABLE `tlb_phongban`
 ADD PRIMARY KEY (`phong_ban_id`);

--
-- Indexes for table `tlb_quanhegiadinh`
--
ALTER TABLE `tlb_quanhegiadinh`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tlb_quatrinhcongtac`
--
ALTER TABLE `tlb_quatrinhcongtac`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tlb_quatrinhluong`
--
ALTER TABLE `tlb_quatrinhluong`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tlb_tailieu`
--
ALTER TABLE `tlb_tailieu`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tlb_hinhanh`
--
ALTER TABLE `tlb_hinhanh`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tlb_hopdong`
--
ALTER TABLE `tlb_hopdong`
MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `tlb_log`
--
ALTER TABLE `tlb_log`
MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tlb_nguoidung`
--
ALTER TABLE `tlb_nguoidung`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `tlb_quanhegiadinh`
--
ALTER TABLE `tlb_quanhegiadinh`
MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `tlb_quatrinhcongtac`
--
ALTER TABLE `tlb_quatrinhcongtac`
MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `tlb_quatrinhluong`
--
ALTER TABLE `tlb_quatrinhluong`
MODIFY `id` mediumint(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `tlb_tailieu`
--
ALTER TABLE `tlb_tailieu`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
