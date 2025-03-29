-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:8889
-- Thời gian đã tạo: Th5 11, 2021 lúc 05:32 AM
-- Phiên bản máy phục vụ: 5.7.30
-- Phiên bản PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Cơ sở dữ liệu: `CuaHang`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `ID` varchar(5) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Passwd` varchar(255) NOT NULL,
  `Image` text NOT NULL,
  `Contact` varchar(255) NOT NULL,
  `Address` text NOT NULL,
  `Position` varchar(255) NOT NULL,
  `About` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`ID`, `Name`, `Email`, `Passwd`, `Image`, `Contact`, `Address`, `Position`, `About`) VALUES
('adm12', 'Yves', 'test@abc.com', 'admin', 'yves.jpg', '012345678', '255 An Duong Vuong Str D5 HCMC', 'Kế Toán Bán Hàng', 'Nhân Viên Mới'),
('adm15', 'Hắc Tún', 'admin@admin.com', 'admin', 'irene.jpeg', '0586128566', '80 79Str. Tan Quy D7', 'RedVelvet Irene', 'Test                                                        '),
('test1', 'test', 'chu@chu.com', 'admin', '98489932_973836263052754_3130673838979809280_n.jpg', 'test', 'test', 'test', 'test                                                                                    ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `CT_HOADON`
--

CREATE TABLE `CT_HOADON` (
  `MA_HD` int(10) NOT NULL,
  `MA_SP` varchar(10) NOT NULL,
  `SOLUONG` int(11) NOT NULL,
  `TONGTIEN` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `CT_HOADON`
--

INSERT INTO `CT_HOADON` (`MA_HD`, `MA_SP`, `SOLUONG`, `TONGTIEN`) VALUES
(1111, 'balo01', 3, 870000),
(1111, 'SP007', 3, 6600000),
(1112, 'balo01', 2, 600000),
(1113, 'tee02', 2, 380000),
(1114, 'tee01', 3, 570000),
(1115, 'balo01', 1, 300000),
(1115, 'balo02', 1, 290000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `HANGSX`
--

CREATE TABLE `HANGSX` (
  `MA_HANGSX` varchar(10) NOT NULL,
  `TEN_HANGSX` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `HANGSX`
--

INSERT INTO `HANGSX` (`MA_HANGSX`, `TEN_HANGSX`) VALUES
('H001', 'NIKE'),
('H002', 'ADIDAS'),
('H003', 'VIỆT TIẾN'),
('H004', 'YAME'),
('H005', 'ADAM STORE'),
('H006', 'BOO');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `HOADON`
--

CREATE TABLE `HOADON` (
  `MA_HD` int(10) NOT NULL,
  `MA_KH` int(11) NOT NULL,
  `TONGTIEN` int(11) NOT NULL,
  `TRANGTHAI` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `HOADON`
--

INSERT INTO `HOADON` (`MA_HD`, `MA_KH`, `TONGTIEN`, `TRANGTHAI`) VALUES
(1111, 2, 6690000, 'Đã Thanh Toán'),
(1112, 4, 650000, 'Đã Thanh Toán'),
(1113, 5, 1100000, 'Chưa Thanh Toán'),
(1114, 1, 500000, 'Chưa Thanh Toán'),
(1115, 3, 900000, 'Đã Thanh Toán');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `KH`
--

CREATE TABLE `KH` (
  `MA_KH` int(11) NOT NULL,
  `TEN_KH` varchar(50) NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `MATKHAU` varchar(255) NOT NULL,
  `DIACHI` varchar(100) DEFAULT NULL,
  `DIENTHOAI` varchar(10) DEFAULT NULL,
  `AVATAR` varchar(500) DEFAULT NULL,
  `TRANGTHAI` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `KH`
--

INSERT INTO `KH` (`MA_KH`, `TEN_KH`, `EMAIL`, `MATKHAU`, `DIACHI`, `DIENTHOAI`, `AVATAR`, `TRANGTHAI`) VALUES
(1, 'TRẦN VĂN A', 'test@test.c1m', '123456', 'VIỆT TRÌ, PHÚ THỌ', '0909XXX001', 'kh001.jpeg', ''),
(2, 'NGUYỄN VĂN A', 'NVB@YAHOO.COM', '123456', 'NAM TỪ LIÊM, HÀ NỘI', '0909XXX002', 'kh002.jpeg', ''),
(3, 'TRẦN THỊ A', 'C.TT@YAHOO.COM', '123456', 'HẢI CHÂU, ĐÀ NẴNG', '0909XXX003', 'kh003.jpeg', ''),
(4, 'PHẠM LÊ VĂN D', 'PDV@GMAIL.COM', '123456', 'QUẬN BÌNH THẠNH, TP. HCM', '0909XXX004', 'kh004.jpeg', 'LOCKED'),
(5, 'NGUYỄN LÊ TƯỜNG E', 'NTE@GMAIL.COM', '123456', 'VIỆT TRÌ, PHÚ THỌ', '0909XXX005', 'kh005.jpeg', ''),
(10, 'admin', 'admin@admin.com', 'admin', 'admin', 'admin', NULL, 'LOCKED'),
(13, 'Hắc Tún', 'tun@tun.com', 'tun', '80 79Str D7 HCMC', '0123456789', 'kh001.jpeg', NULL),
(14, 'tuan', 'tuan@tuan.com', 'tuan', 'tuan', 'tuan', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `LOAISP`
--

CREATE TABLE `LOAISP` (
  `MA_LOAISP` varchar(10) NOT NULL,
  `TEN_LOAISP` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `LOAISP`
--

INSERT INTO `LOAISP` (`MA_LOAISP`, `TEN_LOAISP`) VALUES
('L001', 'GIÀY DÉP'),
('L002', 'ÁO'),
('L003', 'QUẦN'),
('L004', 'PHỤ KIỆN');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `SP`
--

CREATE TABLE `SP` (
  `MA_SP` varchar(10) NOT NULL,
  `TEN_SP` varchar(50) NOT NULL,
  `MA_LOAISP` varchar(10) NOT NULL,
  `MA_HANGSX` varchar(10) NOT NULL,
  `MIEUTA_SP` text,
  `HINHANH_SP` text,
  `GIA` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `SP`
--

INSERT INTO `SP` (`MA_SP`, `TEN_SP`, `MA_LOAISP`, `MA_HANGSX`, `MIEUTA_SP`, `HINHANH_SP`, `GIA`) VALUES
('balo01', 'Balo 01', 'L004', 'H004', 'Chất liệu: được làm từ chất liệu vải bố bền bỉ, độc đáo và bắt mắt. Kích thước lớn 45x35cm, đựng được tài liệu size A4 lớn, LAPTOP thích hợp cho học sinh, sinh viên thậm chí là người trẻ trung, năng động đang đi làm. Mút quai, mút lưng và đáy balo giúp balo cứng cáp. Ngoài ra, balo có ngăn đựng laptop nên rất phù hợp để đi học, đi làm, đi du lịch.', 'balo0.png', 300000),
('balo02', 'Balo 02', 'L004', 'H006', 'Chất liệu: được làm từ chất liệu vải bố bền bỉ, độc đáo và bắt mắt. Kích thước lớn 45x35cm, đựng được tài liệu size A4 lớn, LAPTOP thích hợp cho học sinh, sinh viên thậm chí là người trẻ trung, năng động đang đi làm. Mút quai, mút lưng và đáy balo giúp balo cứng cáp. Ngoài ra, balo có ngăn đựng laptop nên rất phù hợp để đi học, đi làm, đi du lịch.', 'balo2.png', 290000),
('pant01', 'Pant 01', 'L003', 'H004', 'Chất liệu: Thun cao cấp mềm mịn, ít xù lông. Kích thước: Freesize từ 40- 55kg, cao dưới từ 1m50 đến 1m65. Phù hợp mặc nhà, đi dạo, đi học , đi chơi.', 'pant1.jpg', 390000),
('pant02', 'Pant 02', 'L003', 'H004', 'Chất liệu: Thun cao cấp mềm mịn, ít xù lông. Kích thước: Freesize từ 40- 55kg, cao dưới từ 1m50 đến 1m65. Phù hợp mặc nhà, đi dạo, đi học , đi chơi.', 'pant9.png', 390000),
('short01', 'Short 01', 'L003', 'H003', 'Chất liệu: Thun cao cấp mềm mịn, ít xù lông. Kích thước: Freesize từ 40- 55kg, cao dưới từ 1m50 đến 1m65. Phù hợp mặc nhà, đi dạo, đi học , đi chơi.', 'short5.jpg', 250000),
('short02', 'Short 02 ', 'L003', 'H004', 'Chất liệu: Thun cao cấp mềm mịn, ít xù lông. Kích thước: Freesize từ 40- 55kg, cao dưới từ 1m50 đến 1m65. Phù hợp mặc nhà, đi dạo, đi học , đi chơi.', 'short0.jpg', 150000),
('SP001', 'NIKE AIR JORDAN 1 MID CARBON FIBER - NAM', 'L001', 'H001', 'CỠ GIÀY TỪ 42 TRỞ LÊN \r\n                            ', 'tep-005-5-.jpeg', 525000),
('SP002', 'ÁO SƠ MI - NAM, NỮ', 'L002', 'H003', 'Mẫu đồng phục áo sơ mi nữ  dài tay  màu đỏ cổ đức không phối  màu dành cho dân công sở', 'be9cb90dcda22afc73b3.jpeg', 300000),
('SP004', 'ÁO PHÔNG MICKEY MOUSE', 'L002', 'H005', 'Mẫu đồng phục áo sơ mi nữ  dài tay  màu đỏ cổ đức không phối  màu dành cho dân công sở', 'tải xuống.jpeg', 250000),
('SP005', 'ÁO THUN PIKACHU - NAM, NỮ', 'L002', 'H006', 'LIÊN HỆ NẾU MUA SỐ LƯỢNG LỚN \r\n                            ', 'ae72260bdc1206adeffd93dba04285b2.jpeg', 425000),
('SP007', 'ADIDAS STAN SMITH ORIGINAL', 'L001', 'H002', 'Giày Mới \r\n                             \r\n                             \r\n                            ', 'das_stan_smith.jpeg', 2200000),
('SP009', 'THẮT LƯNG DA MÀU NÂU', 'L004', 'H005', 'DÀI 45CM \r\n                            ', '855a17b8bb9d684de0fb49d4c6d9ee88.jpeg', 100000),
('SP012', 'NÓN JORDAN ĐỎ ĐEN', 'L004', 'H001', ' \r\n                            ', '1_9bcb6178c8c3494ba098826cdd715e54_master.jpeg', 550000),
('SP013', 'ÁO PHÔNG MARVEL', 'L002', 'H002', 'Áo phông Marvel x Adidas', 'tải xuống (1).jpeg', 400000),
('tee01', 'Tee 01', 'L002', 'H006', 'Chất liệu thun mềm mại co giãn tốt , thoáng mát. Thiết kế thời trang phù hợp xu hướng hiện nay. Kiểu dáng đa phong cách, Đường may tinh tế sắc sảo. Size XS cho người từ 25-35 kg', 'tee1.jpg', 190000),
('tee02', 'Tee 02', 'L002', 'H006', 'Chất liệu thun mềm mại co giãn tốt , thoáng mát. Thiết kế thời trang phù hợp xu hướng hiện nay. Kiểu dáng đa phong cách, Đường may tinh tế sắc sảo. Size XS cho người từ 25-35 kg', 'tee3.jpg', 190000),
('tee03', 'Tee 03 ', 'L002', 'H006', 'Chất liệu thun mềm mại co giãn tốt , thoáng mát. Thiết kế thời trang phù hợp xu hướng hiện nay. Kiểu dáng đa phong cách, Đường may tinh tế sắc sảo. Size XS cho người từ 25-35 kg', 'tee25.jpg', 150000);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `CT_HOADON`
--
ALTER TABLE `CT_HOADON`
  ADD PRIMARY KEY (`MA_HD`,`MA_SP`),
  ADD KEY `FK_SP` (`MA_SP`);

--
-- Chỉ mục cho bảng `HANGSX`
--
ALTER TABLE `HANGSX`
  ADD PRIMARY KEY (`MA_HANGSX`);

--
-- Chỉ mục cho bảng `HOADON`
--
ALTER TABLE `HOADON`
  ADD PRIMARY KEY (`MA_HD`);

--
-- Chỉ mục cho bảng `KH`
--
ALTER TABLE `KH`
  ADD PRIMARY KEY (`MA_KH`);

--
-- Chỉ mục cho bảng `LOAISP`
--
ALTER TABLE `LOAISP`
  ADD PRIMARY KEY (`MA_LOAISP`);

--
-- Chỉ mục cho bảng `SP`
--
ALTER TABLE `SP`
  ADD PRIMARY KEY (`MA_SP`),
  ADD KEY `MA_LOAISP` (`MA_LOAISP`),
  ADD KEY `MA_HANGSX` (`MA_HANGSX`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `HOADON`
--
ALTER TABLE `HOADON`
  MODIFY `MA_HD` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1116;

--
-- AUTO_INCREMENT cho bảng `KH`
--
ALTER TABLE `KH`
  MODIFY `MA_KH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `CT_HOADON`
--
ALTER TABLE `CT_HOADON`
  ADD CONSTRAINT `FK_HD` FOREIGN KEY (`MA_HD`) REFERENCES `HOADON` (`MA_HD`),
  ADD CONSTRAINT `FK_SP` FOREIGN KEY (`MA_SP`) REFERENCES `SP` (`MA_SP`);

--
-- Các ràng buộc cho bảng `SP`
--
ALTER TABLE `SP`
  ADD CONSTRAINT `sp_ibfk_1` FOREIGN KEY (`MA_LOAISP`) REFERENCES `LOAISP` (`MA_LOAISP`),
  ADD CONSTRAINT `sp_ibfk_2` FOREIGN KEY (`MA_HANGSX`) REFERENCES `HANGSX` (`MA_HANGSX`);
