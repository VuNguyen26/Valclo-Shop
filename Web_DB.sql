-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 12, 2025 lúc 07:52 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `web_db`
--

-- --------------------------------------------------------


CREATE TABLE `ADMIN`(
    `USERNAME` VARCHAR(15), 
    `PASSWORD` VARCHAR(15)
);
INSERT INTO `admin` (`admin`.`USERNAME`, `admin`.`PASSWORD`) VALUE ("admin",123);

CREATE TABLE `EMPLOYEE_ACCOUNT`(
    `ID` BIGINT PRIMARY KEY AUTO_INCREMENT,
    `NAME` VARCHAR(50),
    `USERNAME` VARCHAR(15),
    `PASSWORD` VARCHAR(15)
);
INSERT INTO `employee_account` (`employee_account`.`NAME`,`employee_account`.`USERNAME`,`employee_account`.`PASSWORD`) VALUES
("Nguyễn Văn A", "nva",123),
("Nguyễn Văn B", "nvb",123);

--
-- Cấu trúc bảng cho bảng `account`
--
CREATE TABLE `account` (
  `ID` bigint(20) NOT NULL,
  `CMND` varchar(10) DEFAULT NULL,
  `FNAME` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `PHONE` varchar(10) DEFAULT NULL,
  `ADDRESS` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `USERNAME` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `EMAIL` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `PWD` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `IMG_URL` varchar(250) DEFAULT NULL,
  `RANK` int(11) DEFAULT NULL,
  `STATUS` enum('Hoạt động','Bị ban','','') NOT NULL DEFAULT 'Hoạt động',
  `REASON_BANNED` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`ID`, `CMND`, `FNAME`, `PHONE`, `ADDRESS`, `USERNAME`, `EMAIL`, `PWD`, `IMG_URL`, `RANK`, `STATUS`, `REASON_BANNED`) VALUES
(1, '0512040017', 'Nguyễn Minh Vũ', '0968830591', 'Quảng Ngãi', 'minhvu', 'nguyenminhvu591@gmail.com', 'valcloshop', './Views/images/mv.png', 100, 'Hoạt động', NULL),
(2, '0512040017', 'Nguyễn Minh Hiếu', '0965279041', 'Quảng Ngãi', 'subway99', 'nguyenhieu3105@gmail.com', '12345678', './Views/images/mv.png', 1000, 'Hoạt động', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `ID` bigint(20) NOT NULL,
  `UID` bigint(20) NOT NULL,
  `PID` bigint(20) NOT NULL,
  `SIZE` varchar(5) DEFAULT 'L',
  `QUANTITY` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment`
--

CREATE TABLE `comment` (
  `ID` bigint(20) NOT NULL,
  `PID` bigint(20) NOT NULL,
  `UID` bigint(20) NOT NULL,
  `STAR` int(11) DEFAULT 5,
  `CONTENT` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `TIME` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `comment`
--

INSERT INTO `comment` (`ID`, `PID`, `UID`, `STAR`, `CONTENT`, `TIME`) VALUES
(1, 1, 1, 5, 'Rất tốt ạ', '2025-03-18'),
(2, 1, 1, 3, 'Bình thường', '2025-03-16'),
(3, 1, 1, 1, 'Không thích :v', '2025-03-10'),
(4, 1, 1, 5, 'Tuyệt vời', '2025-04-25'),
(5, 2, 1, 3, 'Hơi tệ tí nhe', '2025-04-20'),
(6, 3, 1, 4, 'Tạm ổn', '2025-04-19');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment_news`
--

CREATE TABLE `comment_news` (
  `ID` bigint(20) NOT NULL,
  `NID` bigint(20) NOT NULL,
  `CID` bigint(20) NOT NULL,
  `CONTENT` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `TIME` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `comment_news`
--

INSERT INTO `comment_news` (`ID`, `NID`, `CID`, `CONTENT`, `TIME`) VALUES
(1, 1, 1, 'Bài viết tuyệt vời!', '2025-05-01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `message`
--

CREATE TABLE `message` (
  `ID` int(11) NOT NULL,
  `FNAME` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EMAIL` varchar(250) DEFAULT NULL,
  `PHONE` varchar(10) DEFAULT NULL,
  `SUBJECT` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CONTENT` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CHECK` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `message`
--

INSERT INTO `message` (`ID`, `FNAME`, `EMAIL`, `PHONE`, `SUBJECT`, `CONTENT`, `CHECK`) VALUES
(1, 'Nguyễn Minh Vũ', 'nguyenminhvu591@gmail.com', '0968830591', 'last test', 'Sản phẩm rất đẹp <3', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `ID` bigint(20) NOT NULL,
  `CID` bigint(20) DEFAULT NULL,
  `KEY` varchar(50) DEFAULT NULL,
  `TIME` date DEFAULT NULL,
  `TITLE` varchar(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CONTENT` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `IMG_URL` varchar(50) DEFAULT NULL,
  `SHORT_CONTENT` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (`ID`, `CID`, `KEY`, `TIME`, `TITLE`, `CONTENT`, `IMG_URL`, `SHORT_CONTENT`) VALUES
(1, 1, 'FootballShirt', '2025-03-18', 'Áo đấu Real Madrid sân nhà 2024/25 – Biểu tượng của sự tinh tế và đẳng', '<h1>Áo Đấu Real Madrid Sân Nhà 2024/25 – Biểu Tượng Của Sự Tinh Tế Và Đẳng Cấp Hoàng Gia</h1>\r\n\r\n<p><strong>Real Madrid</strong> – đội bóng vĩ đại nhất châu Âu – không chỉ nổi tiếng vì số danh hiệu kỷ lục mà còn là biểu tượng cho phong cách thi đấu đỉnh cao và thời trang sân cỏ sang trọng. Mỗi mùa giải, mẫu áo đấu sân nhà luôn là tâm điểm chú ý của giới mộ điệu và fan hâm mộ. Mùa giải 2024/25, thương hiệu Adidas đã mang đến một thiết kế mới mang đậm tinh thần hoàng gia, nhưng vẫn giữ được nét truyền thống lịch sử đầy tự hào.</p>\r\n\r\n<p><img src=\"https://assets.adidas.com/images/w_600,f_auto,q_auto/4d2aba30dea24adb8300bceb8f0650f7_9366/Ao_DJau_San_Nha_Authentic_Real_Madrid_24-25_trang_IX8095_DM1.jpg\" alt=\"Áo đấu Real Madrid sân nhà 2024/25\" style=\"max-width:100%;border-radius:12px; margin: 20px 0;\"></p>\r\n\r\n<h2>Thiết kế thanh lịch – Đậm chất hoàng gia</h2>\r\n<p>Mẫu áo sân nhà Real Madrid 2024/25 vẫn giữ màu trắng chủ đạo – biểu tượng bất diệt của “Los Blancos”. Nhưng điều đặc biệt năm nay là sự xuất hiện của các chi tiết <strong style=\"color:gold;\">viền vàng kim</strong> chạy dọc cổ áo và tay áo, mang lại cảm giác vương giả và quyền uy. Thiết kế lấy cảm hứng từ những chi tiết kiến trúc của cung điện hoàng gia Tây Ban Nha – biểu trưng cho quyền lực và sự thống trị.</p>\r\n\r\n<p>Logo CLB và Adidas được in nổi phản quang sắc nét, tạo điểm nhấn mạnh mẽ trên nền trắng. Phía sau gáy áo còn được in dòng chữ “<em>Hala Madrid y Nada Más</em>” như một tuyên ngôn thiêng liêng dành cho các Madridistas.</p>\r\n\r\n<h2>Trang bị công nghệ AEROREADY hiện đại</h2>\r\n<p>Để phù hợp với cường độ thi đấu khắc nghiệt, Adidas đã tích hợp công nghệ <strong>AEROREADY</strong> vào chất liệu vải. Công nghệ này giúp thấm hút mồ hôi vượt trội, giữ cho cơ thể luôn khô ráo và thoáng mát. Các lỗ thoáng khí được phân bố chiến lược phía sau lưng và hai bên sườn giúp luồng khí lưu thông liên tục, cải thiện hiệu suất vận động.</p>\r\n\r\n<p>Cầu thủ trẻ <strong>Jude Bellingham</strong> chia sẻ: “Tôi cảm thấy như không mặc gì – chiếc áo nhẹ, thoáng, ôm vừa vặn và không gây cản trở trong các pha xử lý tốc độ cao.”</p>\r\n\r\n<h2>Chất liệu thân thiện – Thiết kế cho mọi hoàn cảnh</h2>\r\n<p>Chiếc áo được làm từ sợi polyester tái chế, thể hiện cam kết của Real Madrid và Adidas trong việc bảo vệ môi trường. Bề mặt mịn, không nhăn, đàn hồi tốt và dễ giặt, rất lý tưởng không chỉ để thi đấu mà còn để mặc hàng ngày. Bạn hoàn toàn có thể phối áo cùng quần jeans trắng, quần short thể thao, giày sneaker để tạo thành một outfit street style đầy chất bóng đá.</p>\r\n\r\n<p><img src=\"https://file.hstatic.net/200000293662/file/realhome01.jpg\" alt=\"Chi tiết áo Real 2024/25\" style=\"max-width:100%;border-radius:12px; margin: 20px 0;\"></p>\r\n\r\n<h2>Valclo-Shop – Nơi hội tụ đam mê bóng đá</h2>\r\n<p><strong><a href=\"http://localhost/Valclo_shop/Valclo-Shop/index.php\">Valclo-Shop</a></strong> hiện đang phân phối mẫu áo đấu Real Madrid sân nhà 2024/25 chính hãng với đầy đủ size từ S đến XXL, dành cho cả nam và nữ. Sản phẩm đi kèm <strong>túi đựng cao cấp</strong>, <strong>tem kiểm định chính hãng</strong>, và đặc biệt có hỗ trợ in số & tên cầu thủ yêu thích miễn phí.</p>\r\n\r\n<p><img src=\"https://cdn1585.cdn4s4.io.vn/media/icon/landing/se0gt.svg\" alt=\"icon quà tặng\" style=\"width: 20px; height: 20px; vertical-align: middle; margin-right: 2px; margin-bottom: 2px;\"><strong>Ưu đãi đặc biệt:</strong> Giảm 10% cho đơn hàng đầu tiên – Tặng móc khoá Real Madrid cho 100 khách hàng đầu tiên.</p>\r\n<p><a href=\"http://localhost/Valclo_shop/Valclo-Shop/index.php?url=Home/Contact_us/\"><strong><img src=\"https://theme.hstatic.net/1000096703/1000836887/14/envelopes.png?v=384\" alt=\"icon liên hệ\" style=\"width: 20px; height: 20px; vertical-align: middle; margin-right: 6px;\">Liên hệ ngay</strong></a> để được tư vấn và giữ size trước khi cháy hàng!</p>', './Views/images/real.png', 'Áo đấu Real Madrid sân nhà 2024/25 – Tinh tế, đẳng cấp, hoàng gia'),
(2, 1, 'Tips', '2025-03-20', 'Top 5 mẫu áo đá banh hot nhất dành cho fan cuồng mùa hè này', '<h1>Top 5 Mẫu Áo Đá Banh Hot Nhất Dành Cho Fan Cuồng Mùa Hè 2025</h1>\r\n\r\n<p>Mùa hè không chỉ là thời điểm bùng nổ các giải đấu phong trào mà còn là lúc giới trẻ thể hiện phong cách cá nhân qua những bộ đồ thể thao mang đậm dấu ấn cá tính. Với xu hướng “sporty fashion” đang lên ngôi, việc chọn một chiếc <strong>áo đá banh không chỉ để chơi thể thao mà còn để phối đồ hàng ngày</strong> trở thành mối quan tâm của rất nhiều bạn trẻ.</p>\r\n\r\n<p><strong><a href=\"http://localhost/Valclo_shop/Valclo-Shop/index.php\">Valclo-Shop</a></strong> xin giới thiệu đến bạn danh sách <strong>Top 5 mẫu áo đá banh hot nhất mùa hè 2025</strong> – vừa thời trang, vừa chất lượng thi đấu đỉnh cao.</p>\r\n\r\n<h2>1. Áo Inter Milan sân khách 2024/25 – Sự thanh lịch từ nước Ý</h2>\r\n<p>Thiết kế phối màu <strong>trắng ngà và xanh biển đậm</strong> mang hơi thở cổ điển nhưng vẫn rất hiện đại. Cổ áo tròn tối giản cùng chất vải mịn, thoáng khí phù hợp cả thi đấu lẫn đi dạo. Đường viền xanh làm nổi bật phần vai và tay áo, tạo sự mạnh mẽ nhưng không kém phần thanh thoát.</p>\r\n<p><img src=\"https://footdealer.co/wp-content/uploads/2023/07/Maillot-Match-Inter-Milan-Domicile-2023-2024-1.jpg\" alt=\"Áo Inter Milan 2024/25\" style=\"width:60%;display:block;margin:10px auto;border-radius:12px;\"></p>\r\n\r\n<h2>2. Áo PSG sân nhà – Phong cách Paris đầy tự tin</h2>\r\n<p>Không thể bỏ qua chiếc áo xanh navy kinh điển của Paris Saint-Germain. Đường sọc <strong>đỏ-trắng chạy dọc giữa thân áo</strong> tượng trưng cho trái tim mạnh mẽ, bền bỉ và cá tính của người Paris. Đây là mẫu áo cực hot được Neymar và Mbappé mặc thi đấu, nay bạn cũng có thể sở hữu tại <strong><a href=\"http://localhost/Valclo_shop/Valclo-Shop/index.php\">Valclo-Shop</a></strong>.</p>\r\n<p><img src=\"https://media.foot-store.pt/catalog/product/cache/image/1800x/9df78eab33525d08d6e5fb8d27136e95/t/_/t_l_chargement_45_3.jpg\" alt=\"Áo PSG sân nhà\" style=\"width:60%;display:block;margin:10px auto;border-radius:12px;\"></p>\r\n\r\n<h2>3. Áo MU sân khách 2024/25 – Cổ điển và huyền thoại</h2>\r\n<p>Màu kem phối đỏ rượu vang mang đến cảm giác hoài cổ, gợi nhớ đến thời kỳ hoàng kim của Manchester United. Thiết kế nhẹ nhàng nhưng đầy khí chất, thích hợp cho cả fan MU lâu năm và người yêu thích phong cách retro thể thao.</p>\r\n<p><img src=\"https://media.vov.vn/sites/default/files/styles/large/public/2024-07/ao-dau-mu-2024-25.jpg\" alt=\"Áo MU sân khách\" style=\"width:60%;display:block;margin:10px auto;border-radius:12px;\"></p>\r\n\r\n<h2>4. Áo Argentina World Cup bản giới hạn – Di sản từ Messi</h2>\r\n<p>Đây là mẫu áo đặc biệt kỷ niệm hành trình vô địch World Cup 2022, được tái bản số lượng giới hạn trong năm 2025. Màu xanh trắng truyền thống kết hợp cùng <strong>chi tiết vinh danh Messi</strong> ở mặt sau cổ áo làm nên một món quà không thể thiếu với mọi fan của bóng đá Argentina.</p>\r\n<p><img src=\"https://cdnmedia.baotintuc.vn/Upload/OND64xLJqhpDJlQ2Gd1dpw/files/2024/03/ao-16324.jpg\" alt=\"Áo Argentina World Cup\" style=\"width:60%;display:block;margin:10px auto;border-radius:12px;\"></p>\r\n\r\n<h2>5. Áo tập luyện Nike Pro – Tối giản, hiệu năng cao</h2>\r\n<p>Dành cho những người thích mặc đơn giản nhưng chất lượng. Dòng Nike Pro sử dụng chất liệu co giãn 4 chiều, thoáng khí cực cao và thấm hút mồ hôi nhanh chóng. Áo có kiểu dáng bodyfit, dễ phối với short hoặc quần thể thao. Rất thích hợp cho đá phủi hoặc tập gym.</p>\r\n<p><img src=\"https://thegioigiaythethao.vn/images/attachment/5793Ao%20the%20thao%20Nam%20NIKE%20Pro%20Warm%20Compression%20LS%20Top%20Mens%20Athletic%20838045%20010%20(2).jpg\" alt=\"Áo tập Nike Pro\" style=\"width:60%;display:block;margin:10px auto;border-radius:12px;\"></p>\r\n\r\n<h2>Tư vấn chọn mẫu phù hợp với phong cách cá nhân</h2>\r\n<p>Nếu bạn yêu sự cổ điển, hãy chọn áo MU hoặc Argentina. Nếu yêu thích sự hiện đại, khỏe khoắn – PSG hoặc Inter là lựa chọn sáng giá. Còn nếu bạn cần sự thoải mái toàn diện để tập luyện, không gì phù hợp hơn <strong>Nike Pro</strong>.</p>\r\n\r\n<h2>Mua ngay tại Valclo-Shop – Chính hãng, đủ size, nhiều ưu đãi</h2>\r\n<p><strong><a href=\"http://localhost/Valclo_shop/Valclo-Shop/index.php\">Valclo-Shop</a></strong> là đơn vị phân phối chính hãng các mẫu áo trên, đảm bảo chất lượng vải, độ bền màu và có tem kiểm định. Sản phẩm có sẵn size từ S đến XXL, dành cho cả nam và nữ.</p>\r\n\r\n<p><img src=\"https://cdn1585.cdn4s4.io.vn/media/icon/landing/se0gt.svg\" alt=\"icon quà tặng\" style=\"width: 20px; height: 20px; vertical-align: middle; margin-right: 2px; margin-bottom: 2px;\"><strong>Ưu đãi:</strong> Giảm 10% cho đơn đầu tiên – Freeship toàn quốc – Tặng kèm túi đựng thể thao với mỗi đơn hàng.</p>\r\n\r\n<p><a href=\"http://localhost/Valclo_shop/Valclo-Shop/index.php?url=Home/Contact_us/\"><strong><img src=\"https://theme.hstatic.net/1000096703/1000836887/14/envelopes.png?v=384\" alt=\"icon liên hệ\" style=\"width: 20px; height: 20px; vertical-align: middle; margin-right: 6px;\">Liên hệ ngay</strong></a> để giữ size trước khi cháy hàng nhé!</p>', './Views/images/5ao2.png', '5 mẫu áo đá banh cực hot cho mùa hè 2025'),
(3, 1, 'Guide', '2025-03-21', 'Cách chọn size áo đấu phù hợp cho nam và nữ: Hướng dẫn chi tiết', '<h1>Cách Chọn Size Áo Đấu Phù Hợp Cho Nam Và Nữ: Hướng Dẫn Chi Tiết</h1>\r\n\r\n<p>Việc chọn đúng size áo đá banh không chỉ giúp bạn thi đấu thoải mái mà còn đảm bảo phong cách thời trang và sự tự tin trên sân. Một chiếc áo quá chật sẽ gây khó chịu, còn quá rộng thì làm mất đi form dáng thể thao. Đặc biệt, với áo chính hãng đến từ các thương hiệu như <strong>Adidas</strong> hay <strong>Nike</strong>, kích thước thường theo chuẩn châu Âu – lớn hơn size thông thường của người Việt.</p>\r\n\r\n<p><img src=\"https://mcdn.coolmate.me/image/August2024/size-ao-da-bong-4265_590.jpg\" alt=\"Bảng size áo đá banh\" style=\"max-width:100%;border-radius:12px;margin:20px 0;\"></p>\r\n\r\n<h2>1. Gợi ý chọn size theo chiều cao và cân nặng</h2>\r\n<p><strong>Nam giới:</strong></p>\r\n<ul>\r\n<li>Chiều cao từ 1m60 – 1m70, nặng 55–65kg: <strong>Size M</strong></li>\r\n<li>Chiều cao từ 1m70 – 1m80, nặng 65–75kg: <strong>Size L</strong></li>\r\n<li>Trên 1m80 hoặc từ 75kg trở lên: <strong>Size XL</strong></li>\r\n</ul>\r\n\r\n<p><strong>Nữ giới:</strong></p>\r\n<ul>\r\n<li>Dưới 50kg, chiều cao từ 1m50 – 1m60: <strong>Size S</strong></li>\r\n<li>Từ 50–60kg: <strong>Size M</strong></li>\r\n<li>Trên 60kg hoặc thích mặc rộng: <strong>Size L</strong></li>\r\n</ul>\r\n  \r\n<p><em>Lưu ý:</em> Với các bạn thích phong cách oversize (mặc rộng), hãy chọn lớn hơn 1 size so với thông thường. Nếu dùng để thi đấu chuyên nghiệp, nên chọn vừa vặn để tối ưu cử động.</p>\r\n\r\n<h2>2. Phân biệt size của Adidas, Nike và Puma</h2>\r\n<p>Adidas thường có form hơi rộng ở phần vai, thích hợp với người thể hình hoặc vai rộng. Nike có form ôm hơn, hiện đại hơn – phù hợp với người gầy. Còn Puma thường có chiều dài thân áo ngắn hơn, thích hợp cho các bạn thấp.</p>\r\n\r\n<h2>3. Trải nghiệm tại Valclo-Shop: Chọn đúng size dễ như chơi bóng</h2>\r\n<p><strong><a href=\"http://localhost/Valclo_shop/Valclo-Shop/index.php\">Valclo-Shop</a></strong> hỗ trợ khách hàng chọn size cực kỳ tiện lợi. Bạn chỉ cần inbox chiều cao, cân nặng – shop sẽ gửi size gợi ý kèm hình thật. Ngoài ra:</p>\r\n<p>\r\n✔️ Có sẵn bảng size chi tiết theo từng mẫu áo<br>\r\n✔️ Được <strong>đổi size miễn phí</strong> nếu mặc không vừa<br>\r\n✔️ Tư vấn tận tình qua Messenger hoặc Zalo\r\n</p>\r\n\r\n<p>Vì mỗi cơ thể có cấu trúc khác nhau, cách tốt nhất là thử áo trực tiếp hoặc <strong>đặt hàng online với chính sách đổi trả rõ ràng</strong>. Valclo-Shop cam kết bạn sẽ chọn được chiếc áo phù hợp nhất với vóc dáng và phong cách của mình.</p>\r\n\r\n<p><a href=\"http://localhost/Valclo_shop/Valclo-Shop/index.php?url=Home/Contact_us/\"><strong><img src=\"https://theme.hstatic.net/1000096703/1000836887/14/envelopes.png?v=384\" alt=\"icon liên hệ\" style=\"width: 20px; height: 20px; vertical-align: middle; margin-right: 6px;\">Liên hệ ngay</strong></a> để được tư vấn chọn size miễn phí từ đội ngũ hỗ trợ của chúng tôi.</p>', './Views/images/size.png', 'Chọn size áo đá banh chính xác – không lo mặc sai'),
(4, 1, 'Product', '2025-03-22', 'Găng tay thủ môn: Cách chọn theo độ tuổi và vị trí thi đấu', '<h1>Găng Tay Thủ Môn: Cách Chọn Theo Độ Tuổi Và Vị Trí Thi Đấu</h1>\r\n\r\n<p>Trong bóng đá, thủ môn được xem là người gác đền – chốt chặn cuối cùng của đội hình. Và để hoàn thành tốt vai trò này, một yếu tố không thể thiếu chính là <strong>găng tay thủ môn</strong>. Đây không đơn thuần là phụ kiện, mà là trang bị bảo vệ, hỗ trợ và nâng cao khả năng phản xạ cũng như bắt bóng.</p>\r\n\r\n<p><img src=\"https://aobongda.net/pic/News/chon-gang-tay-thu-mon_HasThumb.jpg\" alt=\"Găng tay thủ môn\" style=\"max-width:100%;border-radius:12px;margin:20px 0;\"></p>\r\n\r\n<h2>Tại sao chọn đúng găng tay lại quan trọng?</h2>\r\n<p>Một đôi găng không vừa tay hoặc không phù hợp với mặt sân, điều kiện thi đấu có thể khiến thủ môn mất tự tin, bắt bóng không chắc và dễ chấn thương. Đặc biệt, các loại găng chất lượng thấp thường dễ bong keo, trơn trượt hoặc rách sau vài trận đấu. Do đó, <strong>chọn đúng găng tay theo độ tuổi, phong cách thi đấu và mục đích sử dụng</strong> là rất cần thiết.</p>\r\n\r\n<h2>Gợi ý chọn găng tay theo từng đối tượng</h2>\r\n\r\n<ul>\r\n<li><strong> Trẻ em, người mới tập chơi:</strong> Ưu tiên loại găng tay nhẹ, mềm, độ dính vừa phải, dễ tháo và không quá bó. <br> Gợi ý: <em>Adidas Predator Junior</em>, <em>Nike Match Jr</em>.</li>\r\n\r\n<li><strong> Thủ môn phong trào, đá phủi:</strong> Nên chọn loại có <strong>lòng găng làm từ latex</strong>, có đệm lót ở mu bàn tay và cổ tay co giãn tốt. Độ bám cần đủ để bắt bóng chắc mà vẫn linh hoạt.<br> Gợi ý: <em>Puma Ultra Grip 1 Hybrid</em>, <em>Adidas Predator Training</em>.</li>\r\n\r\n<li><strong> Thủ môn chuyên nghiệp:</strong> Chọn các dòng cao cấp, có công nghệ chống sốc, bảo vệ ngón tay (finger save), độ bám siêu dính và thiết kế ôm tay. Những dòng này phù hợp với cường độ luyện tập và thi đấu cao.<br> Gợi ý: <em>Nike Vapor Grip 3</em>, <em>Puma Future Grip 1 Hybrid</em>.</li>\r\n</ul>\r\n\r\n<h2>Chất liệu và thiết kế cần lưu ý</h2>\r\n<p><strong>Lòng găng:</strong> Nên là latex hoặc foam cao cấp để tăng độ bám bóng, nhất là trong điều kiện trời mưa hoặc sân cỏ nhân tạo trơn.</p>\r\n<p><strong>Mu bàn tay:</strong> Ưu tiên găng có đệm dày và chống va đập khi đấm bóng. Một số dòng có thêm gù cao su hỗ trợ đá phạt góc.</p>\r\n<p><strong>Thiết kế ngón tay:</strong> Có loại flat (ngón thẳng), roll finger (ôm ngón), negative cut (ôm sát) – mỗi kiểu có ưu và nhược riêng, nên thử trước khi mua.</p>\r\n\r\n<h2>Combo chuyên dụng từ Valclo-Shop</h2>\r\n<p><strong><a href=\"http://localhost/Valclo_shop/Valclo-Shop/index.php\">Valclo-Shop</a></strong> hiện cung cấp đầy đủ các mẫu găng tay từ cơ bản đến cao cấp, phục vụ nhu cầu từ học sinh, sinh viên cho đến thủ môn chuyên nghiệp. Đặc biệt:</p>\r\n\r\n<p>\r\n✔️ Combo găng tay + khăn lau + túi đựng cao cấp<br>\r\n✔️ Chính sách đổi size nếu không vừa<br>\r\n✔️ Tư vấn chọn găng theo vị trí và mặt sân (sân cỏ nhân tạo, tự nhiên...)\r\n</p>\r\n\r\n<p>>> Găng tay có đủ size cho trẻ em từ 8 tuổi đến người lớn tay to. Hàng chính hãng, nhập khẩu trực tiếp từ Nike, Adidas, Puma.</p>\r\n\r\n<p><a href=\"http://localhost/Valclo_shop/Valclo-Shop/index.php?url=Home/Contact_us/\"><strong><img src=\"https://theme.hstatic.net/1000096703/1000836887/14/envelopes.png?v=384\" alt=\"icon liên hệ\" style=\"width: 20px; height: 20px; vertical-align: middle; margin-right: 6px;\">Liên hệ ngay</strong></a> để nhận tư vấn chọn găng miễn phí và ưu đãi riêng dành cho các đội bóng học sinh – sinh viên!</p>', './Views/images/gt1.png', 'Hướng dẫn chọn găng tay thủ môn đúng chuẩn'),
(5, 1, 'Football', '2025-03-23', 'Tin chuyển nhượng mùa hè 2025: Những cái tên gây bất ngờ', '<h1>Tin Chuyển Nhượng Mùa Hè 2025: Những Cái Tên Gây Bất Ngờ</h1>\r\n\r\n<p>Thị trường chuyển nhượng mùa hè 2025 đang bước vào giai đoạn sôi động nhất với hàng loạt tin đồn, xác nhận và cả những thương vụ gây sốc. Từ những bom tấn đã nổ đến các thương thảo âm thầm, thế giới bóng đá đang dõi theo từng bước đi của các ông lớn châu Âu.</p>\r\n\r\n<p><img src=\"https://media.bongda.com.vn/editor-upload/2025-2-24/tran_vu_minh_khoi/liv_23.jpg\" alt=\"Chuyển nhượng bóng đá hè 2025\" style=\"max-width:100%;border-radius:12px;margin:20px 0;\"></p>\r\n\r\n<h2>1. Kylian Mbappé – Không còn là trung tâm tại Real?</h2>\r\n<p>Sau khi gia nhập Real Madrid vào năm 2024 với mức phí khổng lồ, Mbappé hiện đang được đồn đoán sẽ ra đi chỉ sau một mùa giải. Dưới triều đại HLV mới – người ưu tiên lối chơi tập thể và pressing toàn diện – Mbappé không còn phù hợp với hệ thống. Một số nguồn tin từ Tây Ban Nha cho rằng Paris SG sẵn sàng mở cửa đón anh trở lại, hoặc Man City sẽ nhập cuộc nếu có cơ hội.</p>\r\n\r\n<h2>2. Haaland và lời mời 120 triệu euro từ Bayern Munich</h2>\r\n<p><strong>Erling Haaland</strong>, cây săn bàn người Na Uy của Man City, đang lọt vào tầm ngắm của Bayern Munich. Đội bóng nước Đức sẵn sàng chi ra hơn 120 triệu euro để đưa tiền đạo này trở về Bundesliga. Đây được xem là một thương vụ “đổi màu áo gây sốc” nếu thành công, bởi trước đó Haaland từng khoác áo Dortmund – đại kình địch của Bayern.</p>\r\n\r\n<h2>3. Ronaldo chuẩn bị khép lại sự nghiệp tại Sporting Lisbon?</h2>\r\n<p>Trong những chia sẻ gần đây, Cristiano Ronaldo đã không giấu giếm mong muốn được <strong>trở về Bồ Đào Nha và khoác áo Sporting Lisbon</strong> – nơi anh bắt đầu sự nghiệp chuyên nghiệp. Nếu thương vụ thành hiện thực, đây sẽ là màn khép lại sự nghiệp đầy cảm xúc cho một trong những huyền thoại lớn nhất lịch sử bóng đá hiện đại.</p>\r\n\r\n<h2>4. Arsenal ký hợp đồng với Felipe Oliveira – “Neymar mới”</h2>\r\n<p>Một trong những thương vụ đã được xác nhận là Arsenal chiêu mộ thành công ngôi sao trẻ người Brazil – <strong>Felipe Oliveira</strong>. Mới 19 tuổi nhưng cầu thủ chạy cánh này đã gây ấn tượng mạnh tại giải U20 Nam Mỹ và được ví như “Neymar mới” nhờ kỹ thuật điêu luyện và khả năng đột phá. HLV Arteta kỳ vọng Felipe sẽ là nhân tố bùng nổ ở mùa giải mới.</p>\r\n\r\n<h2>Những thương vụ đáng chú ý khác</h2>\r\n<ul>\r\n<li><strong>João Félix</strong> được Barca liên hệ gia hạn hợp đồng sau màn trình diễn ấn tượng đầu năm 2025.</li>\r\n<li><strong>Harry Kane</strong> có thể trở lại Premier League sau một mùa bóng không mấy thành công tại Bayern.</li>\r\n<li><strong>Victor Osimhen</strong> được PSG và Chelsea theo sát sau khi Napoli bật đèn xanh.</li>\r\n</ul>\r\n\r\n<h2>Valclo-Shop – Đồng hành cùng người yêu bóng đá</h2>\r\n<p><strong><a href=\"http://localhost/Valclo_shop/Valclo-Shop/index.php\">Valclo-Shop</a></strong> không chỉ là nơi cung cấp áo đấu chính hãng mà còn là nơi bạn có thể cập nhật các tin tức bóng đá nóng hổi hàng tuần.</p>\r\n\r\n<p>Từ những tin chuyển nhượng mới nhất, các phân tích chiến thuật, cho đến bộ sưu tập <strong>áo đấu phiên bản mới nhất</strong> của các CLB nổi tiếng như Real Madrid, MU, PSG, Barcelona... tất cả đều có tại Valclo-Shop.</p>\r\n\r\n<p><a href=\"http://localhost/Valclo_shop/Valclo-Shop/index.php?url=Home/Contact_us/\"><strong><img src=\"https://theme.hstatic.net/1000096703/1000836887/14/envelopes.png?v=384\" alt=\"icon liên hệ\" style=\"width: 20px; height: 20px; vertical-align: middle; margin-right: 6px;\">Liên hệ ngay</strong></a> để được tư vấn chọn áo đấu theo cầu thủ yêu thích hoặc cập nhật BST mới nhất mùa 2025/26!</p>', './Views/images/cn.png', 'Chuyển nhượng hè 2025 – Nhiều bất ngờ cực sốc'),
(6, 1, 'Comparison', '2025-03-25', 'Nike vs Adidas: So găng hai ông lớn áo đấu năm 2025', '<h1>Nike vs Adidas: So Găng Hai Ông Lớn Áo Đấu Năm 2025</h1>\r\n\r\n<p>Trong thế giới thời trang thể thao và bóng đá, <strong>Nike</strong> và <strong>Adidas</strong> không chỉ là hai thương hiệu dẫn đầu, mà còn là biểu tượng văn hóa đại diện cho hai trường phái thiết kế và công nghệ đối lập. Mỗi hãng đều có lượng fan trung thành và triết lý riêng trong từng đường kim mũi chỉ.</p>\r\n\r\n<p><img src=\"https://file.hstatic.net/200000581855/article/wp2324680_0613191ae33c4895b1cb09ecf672ba90.jpg\" alt=\"Nike vs Adidas 2025\" style=\"max-width:100%;border-radius:12px;margin:20px 0;\"></p>\r\n\r\n<h2>1. Công nghệ vải – Cuộc đua về độ thoáng khí và hiệu suất thi đấu</h2>\r\n<p><strong>Adidas</strong> trong năm 2025 tiếp tục sử dụng công nghệ <strong>HEAT.RDY</strong> – loại vải siêu nhẹ, thoáng khí, giúp cầu thủ thi đấu dưới thời tiết nóng nực mà vẫn cảm thấy mát mẻ. Đây là công nghệ xuất hiện trên các mẫu áo của Real Madrid, Arsenal, và Argentina.</p>\r\n\r\n<p>Trong khi đó, <strong>Nike</strong> không chịu kém cạnh khi đưa vào công nghệ <strong>Dri-FIT ADV</strong> – sự kết hợp giữa sợi vải microfiber và công nghệ chống mồ hôi giúp <strong>hấp thụ - tản nhiệt - làm khô siêu nhanh</strong>. Manchester United, Barcelona, và PSG đều tin dùng công nghệ này trong áo đấu mới nhất của họ.</p>\r\n\r\n<h2>2. Phong cách thiết kế – Tối giản vs táo bạo</h2>\r\n<p><strong>Adidas</strong> thiên về thiết kế <strong>tối giản, thanh lịch và tinh tế</strong>, nhấn mạnh vào tính truyền thống và bản sắc CLB. Những chiếc áo của Real Madrid sân nhà 2024/25 là ví dụ điển hình: trắng tinh khiết, viền vàng ánh kim nhẹ nhàng – sang trọng nhưng không khoa trương.</p>\r\n\r\n<p><strong>Nike</strong> lại thường xuyên tạo ra các thiết kế <strong>phá cách, năng động và trẻ trung</strong>. Từ gam màu tím – đỏ rượu của áo MU sân khách, đến đường kẻ chéo mạnh mẽ trên áo PSG sân nhà, Nike luôn đẩy giới hạn thẩm mỹ thể thao sang hướng mới.</p>\r\n\r\n<h2>3. Cảm giác mặc – Form ôm body vs co giãn thoải mái</h2>\r\n<p><strong>Áo Adidas</strong> thường có form <strong>body fit</strong>, ôm nhẹ vào thân, nhấn vai và eo – thích hợp cho người chơi thể thao hoặc có vóc dáng cân đối.</p>\r\n\r\n<p><strong>Áo Nike</strong> thường có form <strong>co giãn linh hoạt</strong> và rộng hơn ở phần bụng – dễ mặc với nhiều dáng người, đặc biệt phù hợp cả cho nam và nữ sử dụng hằng ngày.</p>\r\n\r\n<h2>4. Giá thành và trải nghiệm thực tế tại Valclo-Shop</h2>\r\n<p>Thông thường, <strong>giá áo đấu chính hãng của Adidas và Nike không chênh lệch quá nhiều</strong> (khoảng 900.000đ – 1.250.000đ/chiếc), tùy theo mẫu và mùa giải. Tuy nhiên, cảm nhận mặc thực tế mới là yếu tố quyết định!</p>\r\n\r\n<p>Tại <strong><a href=\"http://localhost/Valclo_shop/Valclo-Shop/index.php\">Valclo-Shop</a></strong>, bạn có thể:</p>\r\n<p>\r\n✔️ Thử trực tiếp cả áo Adidas và Nike để chọn form áo phù hợp<br>\r\n✔️ Nhận tư vấn chọn theo phong cách (lịch lãm – cá tính – basic – sporty)<br>\r\n✔️ Đổi trả size miễn phí nếu đặt online không vừa\r\n</p>\r\n\r\n<h2>Nên chọn Adidas hay Nike? – Tùy vào “gu” cá nhân của bạn!</h2>\r\n<p>>> Nếu bạn thích vẻ ngoài thanh lịch, nhẹ nhàng – hãy chọn Adidas.</p>\r\n<p>>> Nếu bạn là người năng động, thích nổi bật giữa sân – Nike là lựa chọn lý tưởng.</p>\r\n\r\n<p><strong><a href=\"http://localhost/Valclo_shop/Valclo-Shop/index.php\">Valclo-Shop</a></strong> hiện đang trưng bày nhiều mẫu áo đấu hot nhất mùa giải 2024/25 của cả hai thương hiệu. Mua hàng tại đây, bạn được đảm bảo về chất lượng, xuất xứ và quyền lợi đổi/trả rõ ràng.</p>\r\n\r\n<p><a href=\"http://localhost/Valclo_shop/Valclo-Shop/index.php?url=Home/Contact_us/\"><strong><img src=\"https://theme.hstatic.net/1000096703/1000836887/14/envelopes.png?v=384\" alt=\"icon liên hệ\" style=\"width: 20px; height: 20px; vertical-align: middle; margin-right: 6px;\">Liên hệ ngay</strong></a> để được tư vấn chọn mẫu áo phù hợp nhất với cá tính và vóc dáng của bạn!</p>', './Views/images/addvsnike.png', 'Nike và Adidas – đâu là áo đấu phù hợp với bạn?');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order`
--

CREATE TABLE `order` (
  `ID` bigint(20) NOT NULL,
  `UID` bigint(20) NOT NULL,
  `TIME` date DEFAULT NULL,
  `STATUS` enum('Chờ xác nhận','Đã xác nhận','Đang giao','Đã giao','Khách hàng hủy','Cửa hàng hủy') DEFAULT 'Chờ xác nhận',
  `TOTAL_PRICE` int(11)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `ORDER` (`ID`, `UID`, `TIME`, `STATUS`, `TOTAL_PRICE`) VALUES
(1, 1, '2025-04-10', 'Chờ xác nhận', 2900000),
(2, 2, '2025-04-11', 'Đã xác nhận', 1950000),
(3, 2, '2025-04-12', 'Đang giao', 2400000),
(4, 1, '2025-04-13', 'Đã giao', 4250000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_detail`
--

CREATE TABLE `order_detail` (
  `ORDER_ID` bigint(20) NOT NULL,
  `PID` bigint(20) NOT NULL,
  `SIZE` varchar(5) DEFAULT 'L',
  `QUANTITY` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `ORDER_DETAIL` (`ORDER_ID`, `PID`, `SIZE`, `QUANTITY`) VALUES
-- Chi tiết cho đơn hàng 1 (ID=1)
(1, 1, 'M', 2),
(1, 2, 'L', 1),

-- Chi tiết cho đơn hàng 2 (ID=2)
(2, 1, 'S', 1),
(2, 3, 'XL', 1),

-- Chi tiết cho đơn hàng 3 (ID=3)
(3, 2, 'L', 2),

-- Chi tiết cho đơn hàng 4 (ID=4)
(4, 4, 'M', 1),
(4, 5, 'S', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `ID` bigint(20) NOT NULL,
  `NAME` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `PRICE` int(11) DEFAULT NULL,
  `IMG_URL` varchar(250) DEFAULT NULL,
  `NUMBER` int(11) DEFAULT NULL,
  `DECS` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CATEGORY` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `TOP_PRODUCT` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`ID`, `NAME`, `PRICE`, `IMG_URL`, `NUMBER`, `DECS`, `CATEGORY`, `TOP_PRODUCT`) VALUES
(1, 'ÁO BÓNG ĐÁ CHÍNH HÃNG INTER MILAN SÂN KHÁCH 2024/25 FN8793-123', 850000, 'https://product.hstatic.net/1000061481/product/75a9d828e17944cab4d6294c0208c0b9_7744531afefd4e2095543e43ae0e4b9e_1024x1024.jpg', 20, 'Làm từ 100% chất liệu tái chế, sản phẩm này đại diện cho một trong số rất nhiều các giải pháp của chúng tôi hướng tới chấm dứt rác thải nhựa.', 'Shirt', 1),
(2, 'ÁO BÓNG ĐÁ CHÍNH HÃNG REAL MADRID SÂN NHÀ 2024/25 IU5011', 1200000, 'https://product.hstatic.net/1000061481/product/c6b06feb89854621bea4f54279057437_e680a04d2a04480d946c73073f8d6858_1024x1024.jpg', 20, 'Sản phẩm này làm từ sợi dệt có chứa 50% chất liệu Parley Ocean Plastic — rác thải nhựa tái chế thu gom từ các vùng đảo xa, bãi biển, khu dân cư ven biển và đường bờ biển, nhằm ngăn chặn ô nhiễm đại dương. Sản phẩm này có chứa tổng cộng ít nhất 40% thành phần tái chế.', 'Shirt', 0),
(3, 'ÁO BÓNG ĐÁ CHÍNH HÃNG BARCELONA THỨ 3 2024/25 FQ2022-702', 1100000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Sản phẩm này làm từ sợi dệt có chứa 50% chất liệu Parley Ocean Plastic — rác thải nhựa tái chế thu gom từ các vùng đảo xa, bãi biển, khu dân cư ven biển và đường bờ biển, nhằm ngăn chặn ô nhiễm đại dương. Sản phẩm này có chứa tổng cộng tối thiểu 40% thành phần tái chế.', 'Trousers', 1),
(4, 'ÁO BÓNG ĐÁ CHÍNH HÃNG NIKE PARIS SAINT-GERMAIN SÂN KHÁCH 2024/25 FN8781-101', 1250000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Làm từ một nhóm chất liệu tái chế và có chứa ít nhất 60% thành phần tái chế, sản phẩm này đại diện cho một trong số rất nhiều các giải pháp của chúng tôi hướng tới chấm dứt rác thải nhựa.', 'Trousers', 0),
(5, 'BỌC ỐNG ĐỒNG NMS CREATOR 365 MÀU NGẪU NHIÊN', 1500000, 'https://product.hstatic.net/1000061481/product/040bb1c326c44ad4bc6ea8bd703aba55_f3586483b6c7491d91efe12fb65cbe49_1024x1024.jpg', 20, 'Bạn sẽ có rất nhiều lựa chọn với chiếc quần adidas này. Giữ ấm hay làm mát cơ thể, chiếc quần này làm được hết. Chỉ cần rảo bước dạo quanh phố phường — vì chẳng có gì tuyệt hơn chất vải dệt kim đôi mềm mại, giúp bạn luôn cảm thấy dễ chịu suốt ngày dài.', 'Trousers', 2),
(6, 'GIÀY PAN PERFORMAX 8 ĐẾ TF', 950000, 'https://bizweb.dktcdn.net/thumb/1024x1024/100/348/425/products/giay-pan-performax-8-tf-1-1686399301128.png?v=1695644397207', 20, 'Được làm bằng một loạt các vật liệu tái chế và ít nhất 60% hàm lượng tái chế, sản phẩm này chỉ đại diện cho một trong những giải pháp của chúng tôi để giúp chấm dứt rác thải nhựa.', 'Accessories', 0),
(7, 'TÚI DUFFEL 4ATHLTS CỠ NHỎ', 950000, 'https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/9954f98b2be94704834bae770031f5b8_9366/4ATHLTS_Duffel_Bag_Small_Green_HM9130_01_standard.jpg', 20, 'Được tạo ra một phần với nội dung tái chế từ chất thải sản xuất để giảm tác động môi trường.', 'Accessories', 1),
(8, 'TÚI LƯỚI ĐỰNG BÓNG', 700000, 'https://thethaonamviet.vn/wp-content/uploads/2023/09/tui-luoi-dung-bong.jpg', 20, 'Túi lưới chắc chắn, thoáng khí, dùng để đựng bóng trong các buổi tập hoặc thi đấu.', 'Accessories', 2),
(9, 'BÓNG PRO VOID UCL', 3300000, 'https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/a4cb579ff54647039f07ae3f012bdfaa_9366/Bong_Pro_Void_UCL_trang_HE3777_02_standard_hover.jpg', 20, 'Bóng đạt chuẩn FIFA, bền chắc, dùng cho giải đấu chuyên nghiệp và bán chuyên.', 'Accessories', 3),
(10, 'GĂNG TAY THỦ MÔN KAIWIN PLATINUM - TRẮNG XANH DA', 900000, 'https://bizweb.dktcdn.net/100/017/070/products/gunner-bich.jpg?v=1695002923217', 20, 'Găng tay thủ môn cao cấp, độ bám tốt, hỗ trợ bắt bóng hiệu quả.', 'Shirt', 2),
(11, 'SẢN PHẨM BÓNG ĐÁ MẪU 11', 700000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Mô tả sản phẩm bóng đá mẫu số 11.', 'Accessories', 2),
(12, 'SẢN PHẨM BÓNG ĐÁ MẪU 12', 950000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Mô tả sản phẩm bóng đá mẫu số 12.', 'Trousers', 3),
(13, 'SẢN PHẨM BÓNG ĐÁ MẪU 13', 1250000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Mô tả sản phẩm bóng đá mẫu số 13.', 'Trousers', 0),
(14, 'SẢN PHẨM BÓNG ĐÁ MẪU 14', 1500000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Mô tả sản phẩm bóng đá mẫu số 14.', 'Trousers', 1),
(15, 'SẢN PHẨM BÓNG ĐÁ MẪU 15', 850000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Mô tả sản phẩm bóng đá mẫu số 15.', 'Shirt', 1),
(16, 'SẢN PHẨM BÓNG ĐÁ MẪU 16', 1250000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Mô tả sản phẩm bóng đá mẫu số 16.', 'Shirt', 3),
(17, 'SẢN PHẨM BÓNG ĐÁ MẪU 17', 1100000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Mô tả sản phẩm bóng đá mẫu số 17.', 'Accessories', 0),
(18, 'SẢN PHẨM BÓNG ĐÁ MẪU 18', 850000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Mô tả sản phẩm bóng đá mẫu số 18.', 'Accessories', 2),
(19, 'SẢN PHẨM BÓNG ĐÁ MẪU 19', 700000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Mô tả sản phẩm bóng đá mẫu số 19.', 'Trousers', 1),
(20, 'SẢN PHẨM BÓNG ĐÁ MẪU 20', 950000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Mô tả sản phẩm bóng đá mẫu số 20.', 'Shirt', 0),
(21, 'GĂNG TAY THỦ MÔN CHUYÊN NGHIỆP MẪU 21', 990000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Găng tay thủ môn chuyên nghiệp, độ bám cao.', 'Accessories', 2),
(22, 'ÁO GIỮ NHIỆT BÓNG ĐÁ MẪU 22', 550000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Áo giữ nhiệt thoáng khí cho mùa lạnh.', 'Shirt', 1),
(23, 'GIÀY ĐÁ BANH MẪU 23 ĐẾ ĐINH TF', 1050000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Thiết kế cho sân cỏ nhân tạo, êm ái.', 'Accessories', 3),
(24, 'TÚI XÁCH TẬP LUYỆN MẪU 24', 650000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Túi vải dù chống thấm, đựng đồ thi đấu.', 'Accessories', 0),
(25, 'ÁO THUN FANCLUB ĐỘI TUYỂN MẪU 25', 400000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Áo fanclub in logo đội tuyển.', 'Shirt', 0),
(26, 'QUẦN SHORT ĐÁ BANH MẪU 26', 300000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Quần short co giãn tốt, thoải mái.', 'Trousers', 1),
(27, 'BĂNG CỔ TAY CẦU THỦ MẪU 27', 120000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Băng cổ tay thấm hút mồ hôi tốt.', 'Accessories', 2),
(28, 'VỚ ĐÁ BANH CỔ CAO MẪU 28', 180000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Vớ cao bảo vệ chân khi thi đấu.', 'Accessories', 1),
(29, 'BÓNG TẬP LUYỆN SÂN CỎ MẪU 29', 600000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Bóng tập luyện chất liệu cao su bền.', 'Accessories', 0),
(30, 'BÓNG THI ĐẤU FIFA QUALITY MẪU 30', 1500000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Bóng thi đấu đạt chuẩn FIFA.', 'Accessories', 3),
(31, 'Áo bóng đá mẫu 1', 900000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Mô tả áo bóng đá mẫu 1, chất liệu tốt, thoải mái.', 'Shirt', 1),
(32, 'Áo bóng đá mẫu 2', 1300000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Mô tả áo bóng đá mẫu 2, chất liệu tốt, thoải mái.', 'Shirt', 3),
(33, 'Áo bóng đá mẫu 3', 900000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Mô tả áo bóng đá mẫu 3, chất liệu tốt, thoải mái.', 'Shirt', 0),
(34, 'Áo bóng đá mẫu 4', 1300000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Mô tả áo bóng đá mẫu 4, chất liệu tốt, thoải mái.', 'Shirt', 1),
(35, 'Áo bóng đá mẫu 5', 1300000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Mô tả áo bóng đá mẫu 5, chất liệu tốt, thoải mái.', 'Shirt', 2),
(36, 'Áo bóng đá mẫu 6', 900000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Mô tả áo bóng đá mẫu 6, chất liệu tốt, thoải mái.', 'Shirt', 3),
(37, 'Áo bóng đá mẫu 7', 900000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Mô tả áo bóng đá mẫu 7, chất liệu tốt, thoải mái.', 'Shirt', 2),
(38, 'Áo bóng đá mẫu 8', 1300000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Mô tả áo bóng đá mẫu 8, chất liệu tốt, thoải mái.', 'Shirt', 0),
(39, 'Áo bóng đá mẫu 9', 1300000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Mô tả áo bóng đá mẫu 9, chất liệu tốt, thoải mái.', 'Shirt', 3),
(40, 'Áo bóng đá mẫu 10', 1300000, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg', 20, 'Mô tả áo bóng đá mẫu 10, chất liệu tốt, thoải mái.', 'Shirt', 1),
(41, 'Quần bóng đá mẫu 1', 400000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả quần bóng đá mẫu 1, vải co giãn, thoáng khí.', 'Trousers', 0),
(42, 'Quần bóng đá mẫu 2', 450000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả quần bóng đá mẫu 2, vải co giãn, thoáng khí.', 'Trousers', 1),
(43, 'Quần bóng đá mẫu 3', 500000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả quần bóng đá mẫu 3, vải co giãn, thoáng khí.', 'Trousers', 2),
(44, 'Quần bóng đá mẫu 4', 550000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả quần bóng đá mẫu 4, vải co giãn, thoáng khí.', 'Trousers', 3),
(45, 'Quần bóng đá mẫu 5', 600000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả quần bóng đá mẫu 5, vải co giãn, thoáng khí.', 'Trousers', 0),
(46, 'Quần bóng đá mẫu 6', 650000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả quần bóng đá mẫu 6, vải co giãn, thoáng khí.', 'Trousers', 1),
(47, 'Quần bóng đá mẫu 7', 700000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả quần bóng đá mẫu 7, vải co giãn, thoáng khí.', 'Trousers', 2),
(48, 'Quần bóng đá mẫu 8', 750000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả quần bóng đá mẫu 8, vải co giãn, thoáng khí.', 'Trousers', 3),
(49, 'Quần bóng đá mẫu 9', 800000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả quần bóng đá mẫu 9, vải co giãn, thoáng khí.', 'Trousers', 1),
(50, 'Quần bóng đá mẫu 10', 850000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả quần bóng đá mẫu 10, vải co giãn, thoáng khí.', 'Trousers', 2),
(51, 'Phụ kiện bóng đá mẫu 1', 200000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả phụ kiện bóng đá mẫu 1: băng cổ tay.', 'Accessories', 0),
(52, 'Phụ kiện bóng đá mẫu 2', 250000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả phụ kiện bóng đá mẫu 2: găng tay thủ môn.', 'Accessories', 1),
(53, 'Phụ kiện bóng đá mẫu 3', 300000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả phụ kiện bóng đá mẫu 3: túi đựng giày.', 'Accessories', 2),
(54, 'Phụ kiện bóng đá mẫu 4', 350000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả phụ kiện bóng đá mẫu 4: băng đầu.', 'Accessories', 3),
(55, 'Phụ kiện bóng đá mẫu 5', 400000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả phụ kiện bóng đá mẫu 5: túi lưới đựng bóng.', 'Accessories', 0),
(56, 'Phụ kiện bóng đá mẫu 6', 450000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả phụ kiện bóng đá mẫu 6: túi duffel.', 'Accessories', 1),
(57, 'Phụ kiện bóng đá mẫu 7', 500000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả phụ kiện bóng đá mẫu 7: túi đeo chéo thể thao.', 'Accessories', 2),
(58, 'Phụ kiện bóng đá mẫu 8', 550000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả phụ kiện bóng đá mẫu 8: mũ lưỡi trai fanclub.', 'Accessories', 3),
(59, 'Phụ kiện bóng đá mẫu 9', 600000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả phụ kiện bóng đá mẫu 9: tất chống trượt.', 'Accessories', 0),
(60, 'Phụ kiện bóng đá mẫu 10', 650000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả phụ kiện bóng đá mẫu 10: ống đồng bảo vệ chân.', 'Accessories', 1),
(61, 'Phụ kiện bóng đá mẫu 11', 700000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả phụ kiện bóng đá mẫu 11: áo choàng cầu thủ.', 'Accessories', 2),
(62, 'Phụ kiện bóng đá mẫu 12', 750000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả phụ kiện bóng đá mẫu 12: túi tập luyện nhỏ gọn.', 'Accessories', 3),
(63, 'Phụ kiện bóng đá mẫu 13', 800000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả phụ kiện bóng đá mẫu 13: bộ thun co giãn.', 'Accessories', 1),
(64, 'Phụ kiện bóng đá mẫu 14', 850000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả phụ kiện bóng đá mẫu 14: áo gió.', 'Accessories', 2),
(65, 'Phụ kiện bóng đá mẫu 15', 900000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả phụ kiện bóng đá mẫu 15: túi xách có ngăn đựng giày.', 'Accessories', 3),
(66, 'Phụ kiện bóng đá mẫu 16', 950000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả phụ kiện bóng đá mẫu 16: bình nước thể thao.', 'Accessories', 0),
(67, 'Phụ kiện bóng đá mẫu 17', 1000000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả phụ kiện bóng đá mẫu 17: lưới cầu môn mini.', 'Accessories', 2),
(68, 'Phụ kiện bóng đá mẫu 18', 1050000, 'hhttps://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả phụ kiện bóng đá mẫu 18: ghế gấp cầu thủ.', 'Accessories', 1),
(69, 'Phụ kiện bóng đá mẫu 19', 1100000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả phụ kiện bóng đá mẫu 19: áo bib tập luyện.', 'Accessories', 0),
(70, 'Phụ kiện bóng đá mẫu 20', 1150000, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg', 20, 'Mô tả phụ kiện bóng đá mẫu 20: bảng chiến thuật huấn luyện viên.', 'Accessories', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sub_img_url`
--

CREATE TABLE `sub_img_url` (
  `ID` bigint(20) NOT NULL,
  `PID` bigint(20) NOT NULL,
  `IMG_URL` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sub_img_url`
--

INSERT INTO `sub_img_url` (`ID`, `PID`, `IMG_URL`) VALUES
(1, 1, 'https://bizweb.dktcdn.net/thumb/1024x1024/100/348/425/products/ao-bong-da-mu-manchester-united-2023-24-2.jpg?v=1717473781560'),
(2, 1, 'https://product.hstatic.net/1000061481/product/anh_sb_1-01-0-02-212414124222-2_15b8e22d693445e2ad157600732cf110_1024x1024.jpg'),
(3, 1, 'https://product.hstatic.net/1000061481/product/nh_sp_add_web_4-02-02-078971-01-01-01-01-02-02-02-02-02-02-01-01-02-01_814d1d1ee52b466d84306ea697ae1d32_1024x1024.jpg'),
(4, 1, 'https://product.hstatic.net/1000061481/product/anh_sp_add_web_3-02-02-01-01-01-1-0-1-01-2_f9b704df047640729fb5cc7b00bded77_1024x1024.jpg'),
(5, 2, 'https://product.hstatic.net/1000061481/product/anh_sb_1-01-0-02-212414124122-2_1bd4f919ddf74867929ffd87845a0a2c_1024x1024.jpg'),
(6, 2, 'https://product.hstatic.net/1000061481/product/dd_web_ballak02-01-01-01-01-02-02-02-02-02-02-02-02-01-01-02-02-02-2-2_9e8f67e3af7d4de599728c86242e130f_1024x1024.jpg'),
(7, 2, 'https://product.hstatic.net/1000061481/product/anh_sp_add_web_bal_-02-02-02-02-02-02-02-02-02-01-01-01-02-02-02-2-2-2_388b306e9785476284efce5f211e9c7b_1024x1024.jpg'),
(8, 2, 'https://product.hstatic.net/1000061481/product/anh_sp_add-01-01-01-04-203-1-2_b107084e943d453894dd477f408730cb_1024x1024.jpg'),
(9, 3, 'https://product.hstatic.net/1000061481/product/myach-adidas-jm4205-800x800_d620bd6b53fc4a44b0e28e3849745962_1024x1024.jpg'),
(10, 3, 'https://product.hstatic.net/1000061481/product/nk_pl_heritage_seitiro_-_sp25_71125c10271b49bfbc64206f76db1037_1024x1024.jpg'),
(11, 3, 'https://product.hstatic.net/1000061481/product/pl_nk_heritage_ordem_3_-_sp25_53976b21e66149a9a4760a997f980afb_1024x1024.jpg'),
(12, 3, 'https://product.hstatic.net/1000061481/product/remove-bg.ai_1737339911241_629e125de33042c082aee78a0a56813a_1024x1024.jpg'),
(13, 4, 'https://product.hstatic.net/1000061481/product/anh_sp_add_weballb_4-02-02-01-01-01-_3e17197c4186488bacf43d3e372919b7_1024x1024.jpg'),
(14, 4, 'https://product.hstatic.net/1000061481/product/040bb1c326c44ad4bc6ea8bd703aba55_f3586483b6c7491d91efe12fb65cbe49_1024x1024.jpg'),
(15, 4, 'https://product.hstatic.net/1000061481/product/remove-bg.ai_1735781008586_3374e609ac6549d19fece2f38ec1b12d_1024x1024.png'),
(16, 4, 'https://product.hstatic.net/1000061481/product/5aa2feadc2c24de58349fe5d6f03ecf1_a3eaa93dcc6e47f99c9cb2f9b062a041_1024x1024.jpg'),
(17, 5, 'https://product.hstatic.net/1000061481/product/remove-bg.ai_1736928416755_f4416b8350e84b988ac6474436858d37_1024x1024.png'),
(18, 5, 'https://product.hstatic.net/1000061481/product/nms03114_863d243d54474495b9cac9e5b41e48ef_1024x1024.jpg'),
(19, 5, 'https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg'),
(20, 5, 'https://product.hstatic.net/1000061481/product/c6b06feb89854621bea4f54279057437_e680a04d2a04480d946c73073f8d6858_1024x1024.jpg'),
(21, 6, 'https://product.hstatic.net/1000061481/product/e141af4a71a94c3284f04763f9022577_1f4113a8cce449a09333200715440ec7_1024x1024.jpg'),
(22, 6, 'https://product.hstatic.net/1000061481/product/3a9ab2b213744404a5eefc7da624d812_a809ad64e4834c0bacb36604ba522576_1024x1024.jpg'),
(23, 6, 'https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg'),
(24, 6, 'https://product.hstatic.net/1000061481/product/ff0119ea5b814468b32e4540c027c552_287aeadcf7734657b55951e969144118_1024x1024.jpg'),
(25, 7, 'https://product.hstatic.net/1000061481/product/nms02836-11_0817e5bc556f48c9be3de099f3e79628_1024x1024.jpg'),
(26, 7, 'https://product.hstatic.net/1000061481/product/nms03785collection_5a6988e1751d4deabc6ef08a0fb32a23_1024x1024.jpg'),
(27, 7, 'https://product.hstatic.net/1000061481/product/nms06893avatar-2_fbe758e27292402d953dbd005a9c7c52_1024x1024.jpg'),
(28, 7, 'https://product.hstatic.net/1000061481/product/screenshot_108_cfbf92ad1cee4442a0ad80dff5eebc51_1024x1024.jpg`  '),
(29, 8, 'https://product.hstatic.net/1000061481/product/5016c8c312884d4796b95bcb5974ea7e_4ed2609cdd5b485cb04a465ede799cca_1024x1024.jpg'),
(30, 8, 'https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/9b7fcd1c279f4d76a32aad900018207d_9366/Gang_Tay_Multifit_360_Mot_Chiec_trang_HA5872_42_detail.jpg'),
(31, 8, 'https://assets.adidas.com/images/w_600,f_auto,q_auto/cfe81fed73164e1d9d75ad90001781cd_9366/Gang_Tay_Multifit_360_Mot_Chiec_trang_HA5872.jpg'),
(32, 8, 'https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/bdb4ca309de245ad9a41ad900016c411_9366/Gang_Tay_Multifit_360_Mot_Chiec_trang_HA5872_01_standard.jpg'),
(33, 9, 'https://product.hstatic.net/1000061481/product/anh_sp_add-01-01-5787873222-2-2_c60441ab5eac4de4acd29f41ab149111_1024x1024.jpg'),
(34, 9, 'https://product.hstatic.net/1000061481/product/anh_sp_add-01-01-578787322-2_8bff1b224c1d46318b8e16c031100be0_1024x1024.jpg'),
(35, 9, 'https://assets.adidas.com/images/w_600,f_auto,q_auto/a4cb579ff54647039f07ae3f012bdfaa_9366/Bong_Pro_Void_UCL_trang_HE3777.jpg'),
(36, 9, 'https://product.hstatic.net/1000061481/product/anh_sp_add-01-01-5773-2_593d3529223641448e78cda455e6b28b_1024x1024.jpg'),
(37, 10, 'https://product.hstatic.net/1000061481/product/anh_sp_add_web_3-02-02-01-01-01-01-02_8bab1853087c460bb31a04d2477c8eba_1024x1024.jpg'),
(38, 10, 'https://product.hstatic.net/1000061481/product/anh_sp_add_web_4-02-02-01-01-01-01_0c842858171046849b29c83f86e3995f_1024x1024.jpg'),
(39, 10, 'https://product.hstatic.net/1000061481/product/_sp_add_web_3-02-02-01-01-01-01-01-01-01-01-01-01-01-01-01-01-01-01-01_9be438b22de0478a8e6044a21858e474_1024x1024.jpg'),
(40, 10, 'https://product.hstatic.net/1000061481/product/d99021b7be2c_15c91129cd9c4da7a8cc46c81c490ac8_1024x1024.jpeg');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `PID` (`PID`),
  ADD KEY `UID` (`UID`);

--
-- Chỉ mục cho bảng `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UID` (`UID`);

--
-- Chỉ mục cho bảng `comment_news`
--
ALTER TABLE `comment_news`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `CID` (`CID`),
  ADD KEY `NID` (`NID`);

--
-- Chỉ mục cho bảng `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UID` (`UID`);

--
-- Chỉ mục cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`ORDER_ID`,`PID`),
  ADD KEY `PID` (`PID`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `sub_img_url`
--
ALTER TABLE `sub_img_url`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `PID` (`PID`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `account`
--
ALTER TABLE `account`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `comment`
--
ALTER TABLE `comment`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `comment_news`
--
ALTER TABLE `comment_news`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `message`
--
ALTER TABLE `message`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `order`
--
ALTER TABLE `order`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT cho bảng `sub_img_url`
--
ALTER TABLE `sub_img_url`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`PID`) REFERENCES `product` (`ID`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`UID`) REFERENCES `account` (`ID`);

--
-- Các ràng buộc cho bảng `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `account` (`ID`);

--
-- Các ràng buộc cho bảng `comment_news`
--
ALTER TABLE `comment_news`
  ADD CONSTRAINT `comment_news_ibfk_1` FOREIGN KEY (`CID`) REFERENCES `account` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_news_ibfk_2` FOREIGN KEY (`NID`) REFERENCES `news` (`ID`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `account` (`ID`);

--
-- Các ràng buộc cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`ORDER_ID`) REFERENCES `order` (`ID`),
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`PID`) REFERENCES `product` (`ID`);

--
-- Các ràng buộc cho bảng `sub_img_url`
--
ALTER TABLE `sub_img_url`
  ADD CONSTRAINT `sub_img_url_ibfk_1` FOREIGN KEY (`PID`) REFERENCES `product` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
