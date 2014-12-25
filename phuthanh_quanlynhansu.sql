-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 25, 2014 at 11:12 AM
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
-- Table structure for table `tlb_bangcap`
--

CREATE TABLE IF NOT EXISTS `tlb_bangcap` (
  `bang_cap_id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten_bang_cap` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tlb_bangcap`
--

INSERT INTO `tlb_bangcap` (`bang_cap_id`, `ten_bang_cap`) VALUES
('BTVH', 'Bổ túc văn hóa'),
('CD001', 'Cao đẳng'),
('DH003', 'Đại học'),
('LDPT', 'Lao động phổ thông'),
('TC003', 'Trung cấp'),
('THCS01', 'Trung học cơ sở'),
('THPT01', 'Trung học phổ thông');

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
(0, 'PT01', '112021342014', '2014-06-10', 'Nam Phong, Phú Xuyên, Hà Nội', '112031342014', '2014-05-17', 'Bệnh Viện Bạch Mai, Q. Hai Bà Trưng, Hà Nội');

-- --------------------------------------------------------

--
-- Table structure for table `tlb_chucvu`
--

CREATE TABLE IF NOT EXISTS `tlb_chucvu` (
  `chuc_vu_id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten_chuc_vu` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tlb_chucvu`
--

INSERT INTO `tlb_chucvu` (`chuc_vu_id`, `ten_chuc_vu`) VALUES
('BGD001', 'Giám đốc'),
('BGD002', 'Phó giám đốc'),
('DT001', 'Đội trưởng'),
('NV001', 'Nhân viên'),
('TK001', 'Thư ký'),
('TP001', 'Trưởng phòng'),
('TPP001', 'Phó trưởng phòng');

-- --------------------------------------------------------

--
-- Table structure for table `tlb_congviec`
--

CREATE TABLE IF NOT EXISTS `tlb_congviec` (
  `ma_nhan_vien` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `ngay_vao_lam` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `phong_ban_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `cong_viec_id` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chuc_vu_id` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `muc_luong_cb` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `he_so` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phu_cap` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `so_sld` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ngay_cap` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `noi_cap` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tknh` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ngan_hang` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hoc_van_id` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bang_cap_id` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ngoai_ngu_id` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tin_hoc_id` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dan_toc_id` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quoc_tich_id` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ton_giao_id` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tinh_thanh_id` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `tlb_ctcongviec`
--

CREATE TABLE IF NOT EXISTS `tlb_ctcongviec` (
  `cong_viec_id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten_cong_viec` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tlb_ctcongviec`
--

INSERT INTO `tlb_ctcongviec` (`cong_viec_id`, `ten_cong_viec`) VALUES
('BV001', 'Bảo vệ'),
('CNTT', 'Công nghệ thông tin'),
('KTT001', 'Kế toán trưởng'),
('KTV001', 'Kế toán viên'),
('LT001', 'Lập trình viên'),
('TX001', 'Tài xế'),
('VT001', 'Văn thư');

-- --------------------------------------------------------

--
-- Table structure for table `tlb_dantoc`
--

CREATE TABLE IF NOT EXISTS `tlb_dantoc` (
  `dan_toc_id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten_dan_toc` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tlb_dantoc`
--

INSERT INTO `tlb_dantoc` (`dan_toc_id`, `ten_dan_toc`) VALUES
('DT001', 'Kinh');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tlb_hinhanh`
--

INSERT INTO `tlb_hinhanh` (`id`, `filename`, `type`, `size`, `caption`, `ma_nhan_vien`) VALUES
(2, '1415062787.jpg', 'image/jpeg', 5567, NULL, 'PT03'),
(7, '1415062787.jpg', 'image/jpeg', 5567, NULL, 'PT02'),
(8, '1415062786.jpg', 'image/jpeg', 10733, NULL, 'PT01');

-- --------------------------------------------------------

--
-- Table structure for table `tlb_hocvan`
--

CREATE TABLE IF NOT EXISTS `tlb_hocvan` (
  `hoc_van_id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten_hoc_van` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tlb_hocvan`
--

INSERT INTO `tlb_hocvan` (`hoc_van_id`, `ten_hoc_van`) VALUES
('HV002', 'Lớp 7'),
('HV003', 'Lớp 8'),
('HV004', 'Lớp 9'),
('HV005', 'Lớp 12');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=28 ;

--
-- Dumping data for table `tlb_hopdong`
--

INSERT INTO `tlb_hopdong` (`id`, `ma_nhan_vien`, `so_quyet_dinh`, `tu_ngay`, `den_ngay`, `loai_hop_dong`, `ghi_chu`) VALUES
(27, 'PT01', 'QTCP-12/2013', '2012-06-05', '2014-12-19', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tlb_ngoaingu`
--

CREATE TABLE IF NOT EXISTS `tlb_ngoaingu` (
  `ngoai_ngu_id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten_ngoai_ngu` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tlb_ngoaingu`
--

INSERT INTO `tlb_ngoaingu` (`ngoai_ngu_id`, `ten_ngoai_ngu`) VALUES
('AV000', 'Không'),
('AV001', 'Bằng A anh văn'),
('AV002', 'Bằng B anh văn'),
('AV003', 'Bằng C anh văn'),
('FRE', 'Tiếng Pháp'),
('RUS', 'Tiếng Nga');

-- --------------------------------------------------------

--
-- Table structure for table `tlb_nguoidung`
--

CREATE TABLE IF NOT EXISTS `tlb_nguoidung` (
`id` int(10) NOT NULL,
  `ten_dang_nhap` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mat_khau` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quyen_them` int(1) DEFAULT '0',
  `quyen_sua` int(1) DEFAULT '0',
  `quyen_xoa` int(1) DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tlb_nguoidung`
--

INSERT INTO `tlb_nguoidung` (`id`, `ten_dang_nhap`, `mat_khau`, `quyen_them`, `quyen_sua`, `quyen_xoa`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, 1, 1);

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
  `ngay_sinh` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `noi_sinh` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tinh_thanh` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cmnd` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ngay_cap` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `noi_cap` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `que_quan` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dia_chi` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tam_tru` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nghi_viec` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tlb_nhanvien`
--

INSERT INTO `tlb_nhanvien` (`ma_nhan_vien`, `ho_ten`, `gioi_tinh`, `gia_dinh`, `dt_di_dong`, `dt_nha`, `email`, `ngay_sinh`, `noi_sinh`, `tinh_thanh`, `cmnd`, `ngay_cap`, `noi_cap`, `que_quan`, `dia_chi`, `tam_tru`, `nghi_viec`) VALUES
('PT01', 'Nguyễn Ngọc Tuyền', 1, 0, '0973874453', '0433857805', 'thinghost76@gmail.com', '24/02/1989', 'Phú Xuyên - Hà Nội', 'Hà Nội', '112389842', '07/02/2007', 'CA Hà Tây', 'Xã Nam Phong, Huyện Phú Xuyên, TP Hà Nội', 'Xã Nam Phong, Huyện Phú Xuyên, TP Hà Nội', '62D Ngõ 192, Hạ Đình, Thanh Xuân, Hà Nội', 0),
('PT02', 'Đào Quang Hoan', 1, 1, '0978923444', '0466755499', 'huutrivc27@yahoo.com', '26/11/2014', NULL, 'Hà Nội', NULL, '11/11/2014', NULL, 'Xã Nam Phong, Huyện Phú Xuyên, TP Hà Nội', 'Xã Nam Phong, Huyện Phú Xuyên, TP Hà Nội', 'Khâm Thiên, Đống Đa, Hà Nội', 1),
('PT03', 'Hà Tiến Thành', 1, 1, '0973874324', '', 'pumpkin_3492@gmail.com.vn', '30/06/1989', 'Phú Xuyên - Hà Nội', 'Hà Nội', '112389123', '12/11/2014', 'CA Hà Tây', 'Xã Nam Phong, Huyện Phú Xuyên, TP Hà Nội', 'Xã Nam Phong, Huyện Phú Xuyên, TP Hà Nội', '62D Ngõ 192, Hạ Đình, Thanh Xuân, Hà Nội', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tlb_phongban`
--

CREATE TABLE IF NOT EXISTS `tlb_phongban` (
  `phong_ban_id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten_phong_ban` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tlb_phongban`
--

INSERT INTO `tlb_phongban` (`phong_ban_id`, `ten_phong_ban`) VALUES
('PGĐ', 'Phòng Giám Đốc'),
('PHDQT', 'Phòng Hội đồng quản trị'),
('PKDXNK', 'Phòng Kinh Doanh Xuất Nhập Khẩu'),
('PKT', 'Phòng Kỹ Thuật'),
('PPGĐKD', 'Phòng Phó Giám Đốc Kinh Doanh'),
('PPGĐKT', 'Phòng Phó Giám Đốc Kỹ Thuật'),
('PTCKT', 'Phòng Tài Chính Kế Toán'),
('XCKCT', 'Xưởng Cơ Khí Chế Tạo');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `tlb_quanhegiadinh`
--

INSERT INTO `tlb_quanhegiadinh` (`id`, `ma_nhan_vien`, `ten_nguoi_than`, `nam_sinh`, `moi_quan_he`, `nghe_nghiep`, `dia_chi`, `dtll`, `ghi_chu`) VALUES
(16, 'PT01', 'Nguyễn Khánh Linh', 1995, 'Em gái', 'Sinh viên', 'Thị trấn Phú Xuyên, Phú Xuyên, Hà Nội', '0973888431', NULL),
(18, 'PT01', 'Vũ Thị Lý', 1961, 'Mẹ đẻ', 'Nông dân', 'Xã Nam Phong, Huyện Phú Xuyên, TP Hà Nội', '0973888123', NULL),
(19, 'PT01', 'Nguyễn Hồng Tiên', 1964, 'Bố đẻ', 'Nông dân', 'Xã Nam Phong, Huyện Phú Xuyên, TP Hà Nội', '0973888888', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `tlb_quatrinhcongtac`
--

INSERT INTO `tlb_quatrinhcongtac` (`id`, `ma_nhan_vien`, `so_quyet_dinh`, `ngay_ky`, `ngay_hieu_luc`, `cong_viec`, `ghi_chu`) VALUES
(19, 'PT01', 'QTCP-12/2013', '2014-10-15', '2020-08-11', 'Nhân viên phụ trách kỹ thuật IT', NULL);

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
  `ghi_chu` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=18 ;

--
-- Dumping data for table `tlb_quatrinhluong`
--

INSERT INTO `tlb_quatrinhluong` (`id`, `ma_nhan_vien`, `so_quyet_dinh`, `ngay_chuyen`, `muc_luong`, `ghi_chu`) VALUES
(13, 'PT01', 'QTCP-11/2013', '2014-12-09', '15000000', NULL),
(17, 'PT01', 'QTCP-11/2013', '2013-12-12', '7000000', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tlb_quoctich`
--

CREATE TABLE IF NOT EXISTS `tlb_quoctich` (
  `quoc_tich_id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten_quoc_tich` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tlb_quoctich`
--

INSERT INTO `tlb_quoctich` (`quoc_tich_id`, `ten_quoc_tich`) VALUES
('QT001', 'Việt Nam'),
('QT002', 'Anh'),
('QT003', 'Mỹ');

-- --------------------------------------------------------

--
-- Table structure for table `tlb_tinhoc`
--

CREATE TABLE IF NOT EXISTS `tlb_tinhoc` (
  `tin_hoc_id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten_tin_hoc` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tlb_tinhoc`
--

INSERT INTO `tlb_tinhoc` (`tin_hoc_id`, `ten_tin_hoc`) VALUES
('TH000', 'Không'),
('TH001', 'Tin học A'),
('TH002', 'Tin học B'),
('TH003', 'Trung cấp');

-- --------------------------------------------------------

--
-- Table structure for table `tlb_tinhthanh`
--

CREATE TABLE IF NOT EXISTS `tlb_tinhthanh` (
  `tinh_thanh_id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten_tinh_thanh` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tlb_tinhthanh`
--

INSERT INTO `tlb_tinhthanh` (`tinh_thanh_id`, `ten_tinh_thanh`) VALUES
('TT006', 'Hà Nội');

-- --------------------------------------------------------

--
-- Table structure for table `tlb_tongiao`
--

CREATE TABLE IF NOT EXISTS `tlb_tongiao` (
  `ton_giao_id` int(10) NOT NULL,
  `ten_ton_giao` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tlb_tongiao`
--

INSERT INTO `tlb_tongiao` (`ton_giao_id`, `ten_ton_giao`) VALUES
(1, 'Không'),
(3, 'Thiên Chúa'),
(4, 'Đạo Phật');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tlb_bangcap`
--
ALTER TABLE `tlb_bangcap`
 ADD PRIMARY KEY (`bang_cap_id`);

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
 ADD PRIMARY KEY (`ma_nhan_vien`,`phong_ban_id`);

--
-- Indexes for table `tlb_ctcongviec`
--
ALTER TABLE `tlb_ctcongviec`
 ADD PRIMARY KEY (`cong_viec_id`);

--
-- Indexes for table `tlb_dantoc`
--
ALTER TABLE `tlb_dantoc`
 ADD PRIMARY KEY (`dan_toc_id`);

--
-- Indexes for table `tlb_hinhanh`
--
ALTER TABLE `tlb_hinhanh`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tlb_hocvan`
--
ALTER TABLE `tlb_hocvan`
 ADD PRIMARY KEY (`hoc_van_id`);

--
-- Indexes for table `tlb_hopdong`
--
ALTER TABLE `tlb_hopdong`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tlb_ngoaingu`
--
ALTER TABLE `tlb_ngoaingu`
 ADD PRIMARY KEY (`ngoai_ngu_id`);

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
-- Indexes for table `tlb_quoctich`
--
ALTER TABLE `tlb_quoctich`
 ADD PRIMARY KEY (`quoc_tich_id`);

--
-- Indexes for table `tlb_tinhoc`
--
ALTER TABLE `tlb_tinhoc`
 ADD PRIMARY KEY (`tin_hoc_id`);

--
-- Indexes for table `tlb_tinhthanh`
--
ALTER TABLE `tlb_tinhthanh`
 ADD PRIMARY KEY (`tinh_thanh_id`);

--
-- Indexes for table `tlb_tongiao`
--
ALTER TABLE `tlb_tongiao`
 ADD PRIMARY KEY (`ton_giao_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tlb_hinhanh`
--
ALTER TABLE `tlb_hinhanh`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tlb_hopdong`
--
ALTER TABLE `tlb_hopdong`
MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `tlb_nguoidung`
--
ALTER TABLE `tlb_nguoidung`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tlb_quanhegiadinh`
--
ALTER TABLE `tlb_quanhegiadinh`
MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `tlb_quatrinhcongtac`
--
ALTER TABLE `tlb_quatrinhcongtac`
MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `tlb_quatrinhluong`
--
ALTER TABLE `tlb_quatrinhluong`
MODIFY `id` mediumint(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
