-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2025 at 09:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
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
-- Dumping data for table `account`
--

INSERT INTO `account` (`ID`, `CMND`, `FNAME`, `PHONE`, `ADDRESS`, `USERNAME`, `EMAIL`, `PWD`, `IMG_URL`, `RANK`, `STATUS`, `REASON_BANNED`) VALUES
(1, '0512040017', 'Nguyễn Minh Vũ', '0968830591', '20/2, Xã Đức Lân, Huyện Mộ Đức, Tỉnh Quảng Ngãi', 'minhvu', 'nguyenminhvu591@gmail.com', 'valcloshop', './Views/images/mv.png', 0, 'Hoạt động', NULL),
(2, '0512040017', 'Nguyễn Minh Hiếu', '0965279041', 'Quảng Ngãi', 'subway99', 'nguyenhieu3105@gmail.com', '12345678', './Views/images/mv.png', 1000, 'Hoạt động', NULL),
(3, '1234567899', 'vunguyen', '0123456789', '20/2, Phường Hiệp Bình Phước, Thành phố Thủ Đức, Thành phố Hồ Chí Minh', 'vu', 'vunguyen@gmail.com', '123456', './Views/images/np.png', 0, 'Hoạt động', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `USERNAME` varchar(15) DEFAULT NULL,
  `PASSWORD` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`USERNAME`, `PASSWORD`) VALUES
('admin', '123');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `ID` bigint(20) NOT NULL,
  `UID` bigint(20) NOT NULL,
  `PID` bigint(20) NOT NULL,
  `SIZE` varchar(5) DEFAULT 'L',
  `QUANTITY` int(11) DEFAULT 1,
  `STATE` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name_category` varchar(255) NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: ẩn, 1 : hiện'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name_category`, `state`) VALUES
(1, 'Áo', 1),
(2, 'Quần', 1),
(3, 'Giày', 1),
(4, 'Găng tay', 1),
(5, 'Phụ kiện khác', 1),
(6, 'Tất, vớ', 1),
(7, 'Túi đựng', 1),
(8, 'Băng quấn', 1),
(9, 'Lót giày', 1),
(10, 'Mặt nạ', 1),
(11, 'Bọc giày', 1);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
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
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`ID`, `PID`, `UID`, `STAR`, `CONTENT`, `TIME`) VALUES
(1, 1, 1, 5, 'Rất tốt ạ', '2025-03-18'),
(2, 1, 1, 3, 'Bình thường', '2025-03-16'),
(3, 1, 1, 1, 'Không thích :v', '2025-03-10'),
(4, 1, 1, 5, 'Tuyệt vời', '2025-04-25'),
(5, 2, 1, 3, 'Hơi tệ tí nhe', '2025-04-20'),
(6, 3, 1, 4, 'Tạm ổn', '2025-04-19'),
(7, 1, 1, 5, '', '2025-04-19'),
(8, 1, 1, 5, 'đẹp', '2025-04-19'),
(9, 2, 1, 4, 'đẹp', '2025-04-25'),
(10, 2, 1, 3, 'tạm ổn', '2025-04-25'),
(11, 2, 1, 5, 'good', '2025-04-25'),
(12, 3, 1, 5, 'good', '2025-04-25'),
(13, 4, 1, 4, 'good', '2025-04-25');

-- --------------------------------------------------------

--
-- Table structure for table `comment_news`
--

CREATE TABLE `comment_news` (
  `ID` bigint(20) NOT NULL,
  `NID` bigint(20) NOT NULL,
  `CID` bigint(20) NOT NULL,
  `CONTENT` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `TIME` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment_news`
--

INSERT INTO `comment_news` (`ID`, `NID`, `CID`, `CONTENT`, `TIME`) VALUES
(1, 1, 1, 'Bài viết tuyệt vời!', '2025-05-01'),
(2, 5, 1, 'hay', '2025-04-25'),
(3, 6, 1, 'tuyệt', '2025-04-25'),
(4, 2, 1, 'đẹp', '2025-04-25'),
(5, 2, 1, 'hay', '2025-04-25');

-- --------------------------------------------------------

--
-- Table structure for table `employee_account`
--

CREATE TABLE `employee_account` (
  `ID` bigint(20) NOT NULL,
  `NAME` varchar(50) DEFAULT NULL,
  `USERNAME` varchar(15) DEFAULT NULL,
  `PASSWORD` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_account`
--

INSERT INTO `employee_account` (`ID`, `NAME`, `USERNAME`, `PASSWORD`) VALUES
(1, 'Nguyễn Văn A', 'nva', '123'),
(2, 'Nguyễn Văn B', 'nvb', '123');

-- --------------------------------------------------------

--
-- Table structure for table `message`
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
-- Dumping data for table `message`
--

INSERT INTO `message` (`ID`, `FNAME`, `EMAIL`, `PHONE`, `SUBJECT`, `CONTENT`, `CHECK`) VALUES
(1, 'Nguyễn Minh Vũ', 'nguyenminhvu591@gmail.com', '0968830591', 'last test', 'Sản phẩm rất đẹp <3', 0);

-- --------------------------------------------------------

--
-- Table structure for table `news`
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
-- Dumping data for table `news`
--

INSERT INTO `news` (`ID`, `CID`, `KEY`, `TIME`, `TITLE`, `CONTENT`, `IMG_URL`, `SHORT_CONTENT`) VALUES
(1, 1, 'FootballShirt', '2025-03-18', 'Áo đấu Real Madrid sân nhà 2024/25 – Biểu tượng của sự tinh tế và đẳng', '<h1>Áo Đấu Real Madrid Sân Nhà 2024/25 – Biểu Tượng Của Sự Tinh Tế Và Đẳng Cấp Hoàng Gia</h1>\r\n\r\n<p><strong>Real Madrid</strong> – đội bóng vĩ đại nhất châu Âu – không chỉ nổi tiếng vì số danh hiệu kỷ lục mà còn là biểu tượng cho phong cách thi đấu đỉnh cao và thời trang sân cỏ sang trọng. Mỗi mùa giải, mẫu áo đấu sân nhà luôn là tâm điểm chú ý của giới mộ điệu và fan hâm mộ. Mùa giải 2024/25, thương hiệu Adidas đã mang đến một thiết kế mới mang đậm tinh thần hoàng gia, nhưng vẫn giữ được nét truyền thống lịch sử đầy tự hào.</p>\r\n\r\n<p><img src=\"https://assets.adidas.com/images/w_600,f_auto,q_auto/4d2aba30dea24adb8300bceb8f0650f7_9366/Ao_DJau_San_Nha_Authentic_Real_Madrid_24-25_trang_IX8095_DM1.jpg\" alt=\"Áo đấu Real Madrid sân nhà 2024/25\" style=\"max-width:100%;border-radius:12px; margin: 20px 0;\"></p>\r\n\r\n<h2>Thiết kế thanh lịch – Đậm chất hoàng gia</h2>\r\n<p>Mẫu áo sân nhà Real Madrid 2024/25 vẫn giữ màu trắng chủ đạo – biểu tượng bất diệt của “Los Blancos”. Nhưng điều đặc biệt năm nay là sự xuất hiện của các chi tiết <strong style=\"color:gold;\">viền vàng kim</strong> chạy dọc cổ áo và tay áo, mang lại cảm giác vương giả và quyền uy. Thiết kế lấy cảm hứng từ những chi tiết kiến trúc của cung điện hoàng gia Tây Ban Nha – biểu trưng cho quyền lực và sự thống trị.</p>\r\n\r\n<p>Logo CLB và Adidas được in nổi phản quang sắc nét, tạo điểm nhấn mạnh mẽ trên nền trắng. Phía sau gáy áo còn được in dòng chữ “<em>Hala Madrid y Nada Más</em>” như một tuyên ngôn thiêng liêng dành cho các Madridistas.</p>\r\n\r\n<h2>Trang bị công nghệ AEROREADY hiện đại</h2>\r\n<p>Để phù hợp với cường độ thi đấu khắc nghiệt, Adidas đã tích hợp công nghệ <strong>AEROREADY</strong> vào chất liệu vải. Công nghệ này giúp thấm hút mồ hôi vượt trội, giữ cho cơ thể luôn khô ráo và thoáng mát. Các lỗ thoáng khí được phân bố chiến lược phía sau lưng và hai bên sườn giúp luồng khí lưu thông liên tục, cải thiện hiệu suất vận động.</p>\r\n\r\n<p>Cầu thủ trẻ <strong>Jude Bellingham</strong> chia sẻ: “Tôi cảm thấy như không mặc gì – chiếc áo nhẹ, thoáng, ôm vừa vặn và không gây cản trở trong các pha xử lý tốc độ cao.”</p>\r\n\r\n<h2>Chất liệu thân thiện – Thiết kế cho mọi hoàn cảnh</h2>\r\n<p>Chiếc áo được làm từ sợi polyester tái chế, thể hiện cam kết của Real Madrid và Adidas trong việc bảo vệ môi trường. Bề mặt mịn, không nhăn, đàn hồi tốt và dễ giặt, rất lý tưởng không chỉ để thi đấu mà còn để mặc hàng ngày. Bạn hoàn toàn có thể phối áo cùng quần jeans trắng, quần short thể thao, giày sneaker để tạo thành một outfit street style đầy chất bóng đá.</p>\r\n\r\n<p><img src=\"https://file.hstatic.net/200000293662/file/realhome01.jpg\" alt=\"Chi tiết áo Real 2024/25\" style=\"max-width:100%;border-radius:12px; margin: 20px 0;\"></p>\r\n\r\n<h2>Valclo-Shop – Nơi hội tụ đam mê bóng đá</h2>\r\n<p><strong><a href=\"http://localhost/?url=Home/Home_page/\">Valclo-Shop</a></strong> hiện đang phân phối mẫu áo đấu Real Madrid sân nhà 2024/25 chính hãng với đầy đủ size từ S đến XXL, dành cho cả nam và nữ. Sản phẩm đi kèm <strong>túi đựng cao cấp</strong>, <strong>tem kiểm định chính hãng</strong>, và đặc biệt có hỗ trợ in số & tên cầu thủ yêu thích miễn phí.</p>\r\n\r\n<p><img src=\"https://cdn1585.cdn4s4.io.vn/media/icon/landing/se0gt.svg\" alt=\"icon quà tặng\" style=\"width: 20px; height: 20px; vertical-align: middle; margin-right: 2px; margin-bottom: 2px;\"><strong>Ưu đãi đặc biệt:</strong> Giảm 10% cho đơn hàng đầu tiên – Tặng móc khoá Real Madrid cho 100 khách hàng đầu tiên.</p>\r\n<p><a href=\"http://localhost/?url=Home/Contact_us/\"><strong><img src=\"https://theme.hstatic.net/1000096703/1000836887/14/envelopes.png?v=384\" alt=\"icon liên hệ\" style=\"width: 20px; height: 20px; vertical-align: middle; margin-right: 6px;\">Liên hệ ngay</strong></a> để được tư vấn và giữ size trước khi cháy hàng!</p>', './Views/images/real.png', 'Áo đấu Real Madrid sân nhà 2024/25 – Tinh tế, đẳng cấp, hoàng gia'),
(2, 1, 'Tips', '2025-03-20', 'Top 5 mẫu áo đá banh hot nhất dành cho fan cuồng mùa hè này', '<h1>Top 5 Mẫu Áo Đá Banh Hot Nhất Dành Cho Fan Cuồng Mùa Hè 2025</h1>\r\n\r\n<p>Mùa hè không chỉ là thời điểm bùng nổ các giải đấu phong trào mà còn là lúc giới trẻ thể hiện phong cách cá nhân qua những bộ đồ thể thao mang đậm dấu ấn cá tính. Với xu hướng “sporty fashion” đang lên ngôi, việc chọn một chiếc <strong>áo đá banh không chỉ để chơi thể thao mà còn để phối đồ hàng ngày</strong> trở thành mối quan tâm của rất nhiều bạn trẻ.</p>\r\n\r\n<p><strong><a href=\"http://localhost/?url=Home/Home_page/\">Valclo-Shop</a></strong> xin giới thiệu đến bạn danh sách <strong>Top 5 mẫu áo đá banh hot nhất mùa hè 2025</strong> – vừa thời trang, vừa chất lượng thi đấu đỉnh cao.</p>\r\n\r\n<h2>1. Áo Inter Milan sân khách 2024/25 – Sự thanh lịch từ nước Ý</h2>\r\n<p>Thiết kế phối màu <strong>trắng ngà và xanh biển đậm</strong> mang hơi thở cổ điển nhưng vẫn rất hiện đại. Cổ áo tròn tối giản cùng chất vải mịn, thoáng khí phù hợp cả thi đấu lẫn đi dạo. Đường viền xanh làm nổi bật phần vai và tay áo, tạo sự mạnh mẽ nhưng không kém phần thanh thoát.</p>\r\n<p><img src=\"https://footdealer.co/wp-content/uploads/2023/07/Maillot-Match-Inter-Milan-Domicile-2023-2024-1.jpg\" alt=\"Áo Inter Milan 2024/25\" style=\"width:60%;display:block;margin:10px auto;border-radius:12px;\"></p>\r\n\r\n<h2>2. Áo PSG sân nhà – Phong cách Paris đầy tự tin</h2>\r\n<p>Không thể bỏ qua chiếc áo xanh navy kinh điển của Paris Saint-Germain. Đường sọc <strong>đỏ-trắng chạy dọc giữa thân áo</strong> tượng trưng cho trái tim mạnh mẽ, bền bỉ và cá tính của người Paris. Đây là mẫu áo cực hot được Neymar và Mbappé mặc thi đấu, nay bạn cũng có thể sở hữu tại <strong><a href=\"http://localhost/?url=Home/Home_page/\">Valclo-Shop</a></strong>.</p>\r\n<p><img src=\"https://media.foot-store.pt/catalog/product/cache/image/1800x/9df78eab33525d08d6e5fb8d27136e95/t/_/t_l_chargement_45_3.jpg\" alt=\"Áo PSG sân nhà\" style=\"width:60%;display:block;margin:10px auto;border-radius:12px;\"></p>\r\n\r\n<h2>3. Áo MU sân khách 2024/25 – Cổ điển và huyền thoại</h2>\r\n<p>Màu kem phối đỏ rượu vang mang đến cảm giác hoài cổ, gợi nhớ đến thời kỳ hoàng kim của Manchester United. Thiết kế nhẹ nhàng nhưng đầy khí chất, thích hợp cho cả fan MU lâu năm và người yêu thích phong cách retro thể thao.</p>\r\n<p><img src=\"https://media.vov.vn/sites/default/files/styles/large/public/2024-07/ao-dau-mu-2024-25.jpg\" alt=\"Áo MU sân khách\" style=\"width:60%;display:block;margin:10px auto;border-radius:12px;\"></p>\r\n\r\n<h2>4. Áo Argentina World Cup bản giới hạn – Di sản từ Messi</h2>\r\n<p>Đây là mẫu áo đặc biệt kỷ niệm hành trình vô địch World Cup 2022, được tái bản số lượng giới hạn trong năm 2025. Màu xanh trắng truyền thống kết hợp cùng <strong>chi tiết vinh danh Messi</strong> ở mặt sau cổ áo làm nên một món quà không thể thiếu với mọi fan của bóng đá Argentina.</p>\r\n<p><img src=\"https://cdnmedia.baotintuc.vn/Upload/OND64xLJqhpDJlQ2Gd1dpw/files/2024/03/ao-16324.jpg\" alt=\"Áo Argentina World Cup\" style=\"width:60%;display:block;margin:10px auto;border-radius:12px;\"></p>\r\n\r\n<h2>5. Áo tập luyện Nike Pro – Tối giản, hiệu năng cao</h2>\r\n<p>Dành cho những người thích mặc đơn giản nhưng chất lượng. Dòng Nike Pro sử dụng chất liệu co giãn 4 chiều, thoáng khí cực cao và thấm hút mồ hôi nhanh chóng. Áo có kiểu dáng bodyfit, dễ phối với short hoặc quần thể thao. Rất thích hợp cho đá phủi hoặc tập gym.</p>\r\n<p><img src=\"https://thegioigiaythethao.vn/images/attachment/5793Ao%20the%20thao%20Nam%20NIKE%20Pro%20Warm%20Compression%20LS%20Top%20Mens%20Athletic%20838045%20010%20(2).jpg\" alt=\"Áo tập Nike Pro\" style=\"width:60%;display:block;margin:10px auto;border-radius:12px;\"></p>\r\n\r\n<h2>Tư vấn chọn mẫu phù hợp với phong cách cá nhân</h2>\r\n<p>Nếu bạn yêu sự cổ điển, hãy chọn áo MU hoặc Argentina. Nếu yêu thích sự hiện đại, khỏe khoắn – PSG hoặc Inter là lựa chọn sáng giá. Còn nếu bạn cần sự thoải mái toàn diện để tập luyện, không gì phù hợp hơn <strong>Nike Pro</strong>.</p>\r\n\r\n<h2>Mua ngay tại Valclo-Shop – Chính hãng, đủ size, nhiều ưu đãi</h2>\r\n<p><strong><a href=\"http://localhost/?url=Home/Home_page/\">Valclo-Shop</a></strong> là đơn vị phân phối chính hãng các mẫu áo trên, đảm bảo chất lượng vải, độ bền màu và có tem kiểm định. Sản phẩm có sẵn size từ S đến XXL, dành cho cả nam và nữ.</p>\r\n\r\n<p><img src=\"https://cdn1585.cdn4s4.io.vn/media/icon/landing/se0gt.svg\" alt=\"icon quà tặng\" style=\"width: 20px; height: 20px; vertical-align: middle; margin-right: 2px; margin-bottom: 2px;\"><strong>Ưu đãi:</strong> Giảm 10% cho đơn đầu tiên – Freeship toàn quốc – Tặng kèm túi đựng thể thao với mỗi đơn hàng.</p>\r\n\r\n<p><a href=\"http://localhost/?url=Home/Contact_us/\"><strong><img src=\"https://theme.hstatic.net/1000096703/1000836887/14/envelopes.png?v=384\" alt=\"icon liên hệ\" style=\"width: 20px; height: 20px; vertical-align: middle; margin-right: 6px;\">Liên hệ ngay</strong></a> để giữ size trước khi cháy hàng nhé!</p>', './Views/images/5ao2.png', '5 mẫu áo đá banh cực hot cho mùa hè 2025'),
(3, 1, 'Guide', '2025-03-21', 'Cách chọn size áo đấu phù hợp cho nam và nữ: Hướng dẫn chi tiết', '<h1>Cách Chọn Size Áo Đấu Phù Hợp Cho Nam Và Nữ: Hướng Dẫn Chi Tiết</h1>\r\n\r\n<p>Việc chọn đúng size áo đá banh không chỉ giúp bạn thi đấu thoải mái mà còn đảm bảo phong cách thời trang và sự tự tin trên sân. Một chiếc áo quá chật sẽ gây khó chịu, còn quá rộng thì làm mất đi form dáng thể thao. Đặc biệt, với áo chính hãng đến từ các thương hiệu như <strong>Adidas</strong> hay <strong>Nike</strong>, kích thước thường theo chuẩn châu Âu – lớn hơn size thông thường của người Việt.</p>\r\n\r\n<p><img src=\"https://mcdn.coolmate.me/image/August2024/size-ao-da-bong-4265_590.jpg\" alt=\"Bảng size áo đá banh\" style=\"max-width:100%;border-radius:12px;margin:20px 0;\"></p>\r\n\r\n<h2>1. Gợi ý chọn size theo chiều cao và cân nặng</h2>\r\n<p><strong>Nam giới:</strong></p>\r\n<ul>\r\n<li>Chiều cao từ 1m60 – 1m70, nặng 55–65kg: <strong>Size M</strong></li>\r\n<li>Chiều cao từ 1m70 – 1m80, nặng 65–75kg: <strong>Size L</strong></li>\r\n<li>Trên 1m80 hoặc từ 75kg trở lên: <strong>Size XL</strong></li>\r\n</ul>\r\n\r\n<p><strong>Nữ giới:</strong></p>\r\n<ul>\r\n<li>Dưới 50kg, chiều cao từ 1m50 – 1m60: <strong>Size S</strong></li>\r\n<li>Từ 50–60kg: <strong>Size M</strong></li>\r\n<li>Trên 60kg hoặc thích mặc rộng: <strong>Size L</strong></li>\r\n</ul>\r\n  \r\n<p><em>Lưu ý:</em> Với các bạn thích phong cách oversize (mặc rộng), hãy chọn lớn hơn 1 size so với thông thường. Nếu dùng để thi đấu chuyên nghiệp, nên chọn vừa vặn để tối ưu cử động.</p>\r\n\r\n<h2>2. Phân biệt size của Adidas, Nike và Puma</h2>\r\n<p>Adidas thường có form hơi rộng ở phần vai, thích hợp với người thể hình hoặc vai rộng. Nike có form ôm hơn, hiện đại hơn – phù hợp với người gầy. Còn Puma thường có chiều dài thân áo ngắn hơn, thích hợp cho các bạn thấp.</p>\r\n\r\n<h2>3. Trải nghiệm tại Valclo-Shop: Chọn đúng size dễ như chơi bóng</h2>\r\n<p><strong><a href=\"http://localhost/?url=Home/Home_page/\">Valclo-Shop</a></strong> hỗ trợ khách hàng chọn size cực kỳ tiện lợi. Bạn chỉ cần inbox chiều cao, cân nặng – shop sẽ gửi size gợi ý kèm hình thật. Ngoài ra:</p>\r\n<p>\r\n✔️ Có sẵn bảng size chi tiết theo từng mẫu áo<br>\r\n✔️ Được <strong>đổi size miễn phí</strong> nếu mặc không vừa<br>\r\n✔️ Tư vấn tận tình qua Messenger hoặc Zalo\r\n</p>\r\n\r\n<p>Vì mỗi cơ thể có cấu trúc khác nhau, cách tốt nhất là thử áo trực tiếp hoặc <strong>đặt hàng online với chính sách đổi trả rõ ràng</strong>. Valclo-Shop cam kết bạn sẽ chọn được chiếc áo phù hợp nhất với vóc dáng và phong cách của mình.</p>\r\n\r\n<p><a href=\"http://localhost/?url=Home/Contact_us/\"><strong><img src=\"https://theme.hstatic.net/1000096703/1000836887/14/envelopes.png?v=384\" alt=\"icon liên hệ\" style=\"width: 20px; height: 20px; vertical-align: middle; margin-right: 6px;\">Liên hệ ngay</strong></a> để được tư vấn chọn size miễn phí từ đội ngũ hỗ trợ của chúng tôi.</p>', './Views/images/size.png', 'Chọn size áo đá banh chính xác – không lo mặc sai'),
(4, 1, 'Product', '2025-03-22', 'Găng tay thủ môn: Cách chọn theo độ tuổi và vị trí thi đấu', '<h1>Găng Tay Thủ Môn: Cách Chọn Theo Độ Tuổi Và Vị Trí Thi Đấu</h1>\r\n\r\n<p>Trong bóng đá, thủ môn được xem là người gác đền – chốt chặn cuối cùng của đội hình. Và để hoàn thành tốt vai trò này, một yếu tố không thể thiếu chính là <strong>găng tay thủ môn</strong>. Đây không đơn thuần là phụ kiện, mà là trang bị bảo vệ, hỗ trợ và nâng cao khả năng phản xạ cũng như bắt bóng.</p>\r\n\r\n<p><img src=\"https://aobongda.net/pic/News/chon-gang-tay-thu-mon_HasThumb.jpg\" alt=\"Găng tay thủ môn\" style=\"max-width:100%;border-radius:12px;margin:20px 0;\"></p>\r\n\r\n<h2>Tại sao chọn đúng găng tay lại quan trọng?</h2>\r\n<p>Một đôi găng không vừa tay hoặc không phù hợp với mặt sân, điều kiện thi đấu có thể khiến thủ môn mất tự tin, bắt bóng không chắc và dễ chấn thương. Đặc biệt, các loại găng chất lượng thấp thường dễ bong keo, trơn trượt hoặc rách sau vài trận đấu. Do đó, <strong>chọn đúng găng tay theo độ tuổi, phong cách thi đấu và mục đích sử dụng</strong> là rất cần thiết.</p>\r\n\r\n<h2>Gợi ý chọn găng tay theo từng đối tượng</h2>\r\n\r\n<ul>\r\n<li><strong> Trẻ em, người mới tập chơi:</strong> Ưu tiên loại găng tay nhẹ, mềm, độ dính vừa phải, dễ tháo và không quá bó. <br> Gợi ý: <em>Adidas Predator Junior</em>, <em>Nike Match Jr</em>.</li>\r\n\r\n<li><strong> Thủ môn phong trào, đá phủi:</strong> Nên chọn loại có <strong>lòng găng làm từ latex</strong>, có đệm lót ở mu bàn tay và cổ tay co giãn tốt. Độ bám cần đủ để bắt bóng chắc mà vẫn linh hoạt.<br> Gợi ý: <em>Puma Ultra Grip 1 Hybrid</em>, <em>Adidas Predator Training</em>.</li>\r\n\r\n<li><strong> Thủ môn chuyên nghiệp:</strong> Chọn các dòng cao cấp, có công nghệ chống sốc, bảo vệ ngón tay (finger save), độ bám siêu dính và thiết kế ôm tay. Những dòng này phù hợp với cường độ luyện tập và thi đấu cao.<br> Gợi ý: <em>Nike Vapor Grip 3</em>, <em>Puma Future Grip 1 Hybrid</em>.</li>\r\n</ul>\r\n\r\n<h2>Chất liệu và thiết kế cần lưu ý</h2>\r\n<p><strong>Lòng găng:</strong> Nên là latex hoặc foam cao cấp để tăng độ bám bóng, nhất là trong điều kiện trời mưa hoặc sân cỏ nhân tạo trơn.</p>\r\n<p><strong>Mu bàn tay:</strong> Ưu tiên găng có đệm dày và chống va đập khi đấm bóng. Một số dòng có thêm gù cao su hỗ trợ đá phạt góc.</p>\r\n<p><strong>Thiết kế ngón tay:</strong> Có loại flat (ngón thẳng), roll finger (ôm ngón), negative cut (ôm sát) – mỗi kiểu có ưu và nhược riêng, nên thử trước khi mua.</p>\r\n\r\n<h2>Combo chuyên dụng từ Valclo-Shop</h2>\r\n<p><strong><a href=\"http://localhost/?url=Home/Home_page/\">Valclo-Shop</a></strong> hiện cung cấp đầy đủ các mẫu găng tay từ cơ bản đến cao cấp, phục vụ nhu cầu từ học sinh, sinh viên cho đến thủ môn chuyên nghiệp. Đặc biệt:</p>\r\n\r\n<p>\r\n✔️ Combo găng tay + khăn lau + túi đựng cao cấp<br>\r\n✔️ Chính sách đổi size nếu không vừa<br>\r\n✔️ Tư vấn chọn găng theo vị trí và mặt sân (sân cỏ nhân tạo, tự nhiên...)\r\n</p>\r\n\r\n<p>>> Găng tay có đủ size cho trẻ em từ 8 tuổi đến người lớn tay to. Hàng chính hãng, nhập khẩu trực tiếp từ Nike, Adidas, Puma.</p>\r\n\r\n<p><a href=\"http://localhost/?url=Home/Contact_us/\"><strong><img src=\"https://theme.hstatic.net/1000096703/1000836887/14/envelopes.png?v=384\" alt=\"icon liên hệ\" style=\"width: 20px; height: 20px; vertical-align: middle; margin-right: 6px;\">Liên hệ ngay</strong></a> để nhận tư vấn chọn găng miễn phí và ưu đãi riêng dành cho các đội bóng học sinh – sinh viên!</p>', './Views/images/gt1.png', 'Hướng dẫn chọn găng tay thủ môn đúng chuẩn'),
(5, 1, 'Football', '2025-03-23', 'Tin chuyển nhượng mùa hè 2025: Những cái tên gây bất ngờ', '<h1>Tin Chuyển Nhượng Mùa Hè 2025: Những Cái Tên Gây Bất Ngờ</h1>\r\n\r\n<p>Thị trường chuyển nhượng mùa hè 2025 đang bước vào giai đoạn sôi động nhất với hàng loạt tin đồn, xác nhận và cả những thương vụ gây sốc. Từ những bom tấn đã nổ đến các thương thảo âm thầm, thế giới bóng đá đang dõi theo từng bước đi của các ông lớn châu Âu.</p>\r\n\r\n<p><img src=\"https://media.bongda.com.vn/editor-upload/2025-2-24/tran_vu_minh_khoi/liv_23.jpg\" alt=\"Chuyển nhượng bóng đá hè 2025\" style=\"max-width:100%;border-radius:12px;margin:20px 0;\"></p>\r\n\r\n<h2>1. Kylian Mbappé – Không còn là trung tâm tại Real?</h2>\r\n<p>Sau khi gia nhập Real Madrid vào năm 2024 với mức phí khổng lồ, Mbappé hiện đang được đồn đoán sẽ ra đi chỉ sau một mùa giải. Dưới triều đại HLV mới – người ưu tiên lối chơi tập thể và pressing toàn diện – Mbappé không còn phù hợp với hệ thống. Một số nguồn tin từ Tây Ban Nha cho rằng Paris SG sẵn sàng mở cửa đón anh trở lại, hoặc Man City sẽ nhập cuộc nếu có cơ hội.</p>\r\n\r\n<h2>2. Haaland và lời mời 120 triệu euro từ Bayern Munich</h2>\r\n<p><strong>Erling Haaland</strong>, cây săn bàn người Na Uy của Man City, đang lọt vào tầm ngắm của Bayern Munich. Đội bóng nước Đức sẵn sàng chi ra hơn 120 triệu euro để đưa tiền đạo này trở về Bundesliga. Đây được xem là một thương vụ “đổi màu áo gây sốc” nếu thành công, bởi trước đó Haaland từng khoác áo Dortmund – đại kình địch của Bayern.</p>\r\n\r\n<h2>3. Ronaldo chuẩn bị khép lại sự nghiệp tại Sporting Lisbon?</h2>\r\n<p>Trong những chia sẻ gần đây, Cristiano Ronaldo đã không giấu giếm mong muốn được <strong>trở về Bồ Đào Nha và khoác áo Sporting Lisbon</strong> – nơi anh bắt đầu sự nghiệp chuyên nghiệp. Nếu thương vụ thành hiện thực, đây sẽ là màn khép lại sự nghiệp đầy cảm xúc cho một trong những huyền thoại lớn nhất lịch sử bóng đá hiện đại.</p>\r\n\r\n<h2>4. Arsenal ký hợp đồng với Felipe Oliveira – “Neymar mới”</h2>\r\n<p>Một trong những thương vụ đã được xác nhận là Arsenal chiêu mộ thành công ngôi sao trẻ người Brazil – <strong>Felipe Oliveira</strong>. Mới 19 tuổi nhưng cầu thủ chạy cánh này đã gây ấn tượng mạnh tại giải U20 Nam Mỹ và được ví như “Neymar mới” nhờ kỹ thuật điêu luyện và khả năng đột phá. HLV Arteta kỳ vọng Felipe sẽ là nhân tố bùng nổ ở mùa giải mới.</p>\r\n\r\n<h2>Những thương vụ đáng chú ý khác</h2>\r\n<ul>\r\n<li><strong>João Félix</strong> được Barca liên hệ gia hạn hợp đồng sau màn trình diễn ấn tượng đầu năm 2025.</li>\r\n<li><strong>Harry Kane</strong> có thể trở lại Premier League sau một mùa bóng không mấy thành công tại Bayern.</li>\r\n<li><strong>Victor Osimhen</strong> được PSG và Chelsea theo sát sau khi Napoli bật đèn xanh.</li>\r\n</ul>\r\n\r\n<h2>Valclo-Shop – Đồng hành cùng người yêu bóng đá</h2>\r\n<p><strong><a href=\"http://localhost/?url=Home/Home_page/\">Valclo-Shop</a></strong> không chỉ là nơi cung cấp áo đấu chính hãng mà còn là nơi bạn có thể cập nhật các tin tức bóng đá nóng hổi hàng tuần.</p>\r\n\r\n<p>Từ những tin chuyển nhượng mới nhất, các phân tích chiến thuật, cho đến bộ sưu tập <strong>áo đấu phiên bản mới nhất</strong> của các CLB nổi tiếng như Real Madrid, MU, PSG, Barcelona... tất cả đều có tại Valclo-Shop.</p>\r\n\r\n<p><a href=\"http://localhost/?url=Home/Contact_us/\"><strong><img src=\"https://theme.hstatic.net/1000096703/1000836887/14/envelopes.png?v=384\" alt=\"icon liên hệ\" style=\"width: 20px; height: 20px; vertical-align: middle; margin-right: 6px;\">Liên hệ ngay</strong></a> để được tư vấn chọn áo đấu theo cầu thủ yêu thích hoặc cập nhật BST mới nhất mùa 2025/26!</p>', './Views/images/cn.png', 'Chuyển nhượng hè 2025 – Nhiều bất ngờ cực sốc'),
(6, 1, 'Comparison', '2025-03-25', 'Nike vs Adidas: So găng hai ông lớn áo đấu năm 2025', '<h1>Nike vs Adidas: So Găng Hai Ông Lớn Áo Đấu Năm 2025</h1>\r\n\r\n<p>Trong thế giới thời trang thể thao và bóng đá, <strong>Nike</strong> và <strong>Adidas</strong> không chỉ là hai thương hiệu dẫn đầu, mà còn là biểu tượng văn hóa đại diện cho hai trường phái thiết kế và công nghệ đối lập. Mỗi hãng đều có lượng fan trung thành và triết lý riêng trong từng đường kim mũi chỉ.</p>\r\n\r\n<p><img src=\"https://file.hstatic.net/200000581855/article/wp2324680_0613191ae33c4895b1cb09ecf672ba90.jpg\" alt=\"Nike vs Adidas 2025\" style=\"max-width:100%;border-radius:12px;margin:20px 0;\"></p>\r\n\r\n<h2>1. Công nghệ vải – Cuộc đua về độ thoáng khí và hiệu suất thi đấu</h2>\r\n<p><strong>Adidas</strong> trong năm 2025 tiếp tục sử dụng công nghệ <strong>HEAT.RDY</strong> – loại vải siêu nhẹ, thoáng khí, giúp cầu thủ thi đấu dưới thời tiết nóng nực mà vẫn cảm thấy mát mẻ. Đây là công nghệ xuất hiện trên các mẫu áo của Real Madrid, Arsenal, và Argentina.</p>\r\n\r\n<p>Trong khi đó, <strong>Nike</strong> không chịu kém cạnh khi đưa vào công nghệ <strong>Dri-FIT ADV</strong> – sự kết hợp giữa sợi vải microfiber và công nghệ chống mồ hôi giúp <strong>hấp thụ - tản nhiệt - làm khô siêu nhanh</strong>. Manchester United, Barcelona, và PSG đều tin dùng công nghệ này trong áo đấu mới nhất của họ.</p>\r\n\r\n<h2>2. Phong cách thiết kế – Tối giản vs táo bạo</h2>\r\n<p><strong>Adidas</strong> thiên về thiết kế <strong>tối giản, thanh lịch và tinh tế</strong>, nhấn mạnh vào tính truyền thống và bản sắc CLB. Những chiếc áo của Real Madrid sân nhà 2024/25 là ví dụ điển hình: trắng tinh khiết, viền vàng ánh kim nhẹ nhàng – sang trọng nhưng không khoa trương.</p>\r\n\r\n<p><strong>Nike</strong> lại thường xuyên tạo ra các thiết kế <strong>phá cách, năng động và trẻ trung</strong>. Từ gam màu tím – đỏ rượu của áo MU sân khách, đến đường kẻ chéo mạnh mẽ trên áo PSG sân nhà, Nike luôn đẩy giới hạn thẩm mỹ thể thao sang hướng mới.</p>\r\n\r\n<h2>3. Cảm giác mặc – Form ôm body vs co giãn thoải mái</h2>\r\n<p><strong>Áo Adidas</strong> thường có form <strong>body fit</strong>, ôm nhẹ vào thân, nhấn vai và eo – thích hợp cho người chơi thể thao hoặc có vóc dáng cân đối.</p>\r\n\r\n<p><strong>Áo Nike</strong> thường có form <strong>co giãn linh hoạt</strong> và rộng hơn ở phần bụng – dễ mặc với nhiều dáng người, đặc biệt phù hợp cả cho nam và nữ sử dụng hằng ngày.</p>\r\n\r\n<h2>4. Giá thành và trải nghiệm thực tế tại Valclo-Shop</h2>\r\n<p>Thông thường, <strong>giá áo đấu chính hãng của Adidas và Nike không chênh lệch quá nhiều</strong> (khoảng 900.000đ – 1.250.000đ/chiếc), tùy theo mẫu và mùa giải. Tuy nhiên, cảm nhận mặc thực tế mới là yếu tố quyết định!</p>\r\n\r\n<p>Tại <strong><a href=\"http://localhost/?url=Home/Home_page/\">Valclo-Shop</a></strong>, bạn có thể:</p>\r\n<p>\r\n✔️ Thử trực tiếp cả áo Adidas và Nike để chọn form áo phù hợp<br>\r\n✔️ Nhận tư vấn chọn theo phong cách (lịch lãm – cá tính – basic – sporty)<br>\r\n✔️ Đổi trả size miễn phí nếu đặt online không vừa\r\n</p>\r\n\r\n<h2>Nên chọn Adidas hay Nike? – Tùy vào “gu” cá nhân của bạn!</h2>\r\n<p>>> Nếu bạn thích vẻ ngoài thanh lịch, nhẹ nhàng – hãy chọn Adidas.</p>\r\n<p>>> Nếu bạn là người năng động, thích nổi bật giữa sân – Nike là lựa chọn lý tưởng.</p>\r\n\r\n<p><strong><a href=\"http://localhost/?url=Home/Home_page/\">Valclo-Shop</a></strong> hiện đang trưng bày nhiều mẫu áo đấu hot nhất mùa giải 2024/25 của cả hai thương hiệu. Mua hàng tại đây, bạn được đảm bảo về chất lượng, xuất xứ và quyền lợi đổi/trả rõ ràng.</p>\r\n\r\n<p><a href=\"http://localhost/?url=Home/Contact_us/\"><strong><img src=\"https://theme.hstatic.net/1000096703/1000836887/14/envelopes.png?v=384\" alt=\"icon liên hệ\" style=\"width: 20px; height: 20px; vertical-align: middle; margin-right: 6px;\">Liên hệ ngay</strong></a> để được tư vấn chọn mẫu áo phù hợp nhất với cá tính và vóc dáng của bạn!</p>', './Views/images/addvsnike.png', 'Nike và Adidas – đâu là áo đấu phù hợp với bạn?');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `ID` bigint(20) NOT NULL,
  `UID` bigint(20) NOT NULL,
  `TIME` date DEFAULT NULL,
  `STATUS` enum('Chờ xác nhận','Đã xác nhận','Đang giao','Đã giao','Khách hàng hủy','Cửa hàng hủy') DEFAULT 'Chờ xác nhận',
  `TOTAL_PRICE` int(11) DEFAULT NULL,
  `METHOD` enum('Momo','Paypal','COD') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`ID`, `UID`, `TIME`, `STATUS`, `TOTAL_PRICE`, `METHOD`) VALUES
(1, 1, '2025-04-10', 'Chờ xác nhận', 1700000, 'COD'),
(2, 2, '2025-04-11', 'Đã xác nhận', 1300000, 'Momo'),
(3, 2, '2025-04-12', 'Đang giao', 1200000, 'COD'),
(4, 1, '2025-04-13', 'Đã giao', 2200000, 'Paypal'),
(54, 1, '2025-04-25', 'Chờ xác nhận', 1100000, 'COD'),
(55, 1, '2025-04-25', 'Chờ xác nhận', 1800000, 'COD'),
(56, 3, '2025-04-25', 'Chờ xác nhận', 1100000, 'Momo'),
(57, 3, '2025-04-25', 'Chờ xác nhận', 3900000, 'COD');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `ID` int(1) NOT NULL,
  `ORDER_ID` bigint(20) NOT NULL,
  `PID` bigint(20) NOT NULL,
  `SIZE` varchar(5) DEFAULT 'L',
  `QUANTITY` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`ID`, `ORDER_ID`, `PID`, `SIZE`, `QUANTITY`) VALUES
(1, 1, 1, 'M', 2),
(2, 1, 2, 'L', 1),
(3, 2, 1, 'S', 1),
(4, 2, 3, 'XL', 1),
(5, 54, 1, 'S', 1),
(6, 54, 1, 'M', 1),
(7, 55, 2, 'L', 1),
(8, 55, 2, 'XXL', 1),
(9, 55, 2, 'XL', 1),
(10, 56, 1, 'XL', 1),
(11, 56, 1, 'M', 1),
(13, 57, 3, 'XXL', 3),
(14, 57, 3, 'M', 3);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ID` bigint(20) NOT NULL,
  `NAME` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `PRICE` int(11) DEFAULT NULL,
  `IMG_URL` varchar(250) DEFAULT NULL,
  `NUMBER` int(11) DEFAULT NULL,
  `DECS` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CATEGORY` int(1) DEFAULT 1,
  `TOP_PRODUCT` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ID`, `NAME`, `PRICE`, `IMG_URL`, `NUMBER`, `DECS`, `CATEGORY`, `TOP_PRODUCT`) VALUES
(1, 'Áo Real Madrid chính hãng', 1000000, 'https://i.pinimg.com/736x/c2/bd/3a/c2bd3a8e1f97a51c41f20b202e6336d0.jpg', 20, 'Áo có công nghệ làm mát tiên tiến, giữ cơ thể luôn khô thoáng.', 1, 1),
(2, 'Áo Real Madrid chính hãng', 120000, 'https://i.pinimg.com/736x/d4/0d/2f/d40d2f4b8d4bdf0948f7cff5e284d35a.jpg', 20, 'Phiên bản áo đấu mùa giải mới, hỗ trợ vận động tối đa.', 1, 2),
(3, 'Áo Inter Milan chính hãng', 130000, 'https://i.pinimg.com/736x/53/1c/86/531c8616986b2d981bfbe5455f7dbb5e.jpg', 20, 'Phiên bản áo đấu mùa giải mới, hỗ trợ vận động tối đa.', 1, 3),
(4, 'Áo Liverpool chính hãng', 300000, 'https://i.pinimg.com/736x/3d/fb/db/3dfbdba09aa66c0454ccd698e33db1fa.jpg', 20, 'Chất vải thoáng khí, thích hợp sử dụng trong thi đấu và luyện tập.', 1, 0),
(5, 'Áo Bayern Munich chính hãng', 100000, 'https://i.pinimg.com/736x/f1/48/7c/f1487c1fdb83dd11691518987824f68c.jpg', 20, 'Phiên bản áo đấu mùa giải mới, hỗ trợ vận động tối đa.', 1, 1),
(6, 'Áo Inter Milan chính hãng', 140000, 'https://i.pinimg.com/736x/df/70/77/df7077297911b48d911023306f579858.jpg', 20, 'Thiết kế chuẩn form châu Âu, logo thêu sắc nét.', 1, 2),
(7, 'Áo Arsenal chính hãng', 150000, 'https://i.pinimg.com/736x/f2/e0/7f/f2e07f4ff543f1e60c47cd5d333e506f.jpg', 20, 'Chất vải thoáng khí, thích hợp sử dụng trong thi đấu và luyện tập.', 1, 3),
(8, 'Áo AC Milan chính hãng', 160000, 'https://i.pinimg.com/736x/6e/c1/0f/6ec10f477867bc83ccffdffac5e5e550.jpg', 20, 'Áo có công nghệ làm mát tiên tiến, giữ cơ thể luôn khô thoáng.', 1, 0),
(9, 'Áo Barcelona chính hãng', 200000, 'https://i.pinimg.com/736x/21/4a/f6/214af68ab0b6ddef545524b7f1fe7385.jpg', 20, 'Chất vải thoáng khí, thích hợp sử dụng trong thi đấu và luyện tập.', 1, 1),
(10, 'Áo Manchester United chính hãng', 250000, 'https://i.pinimg.com/736x/18/00/a1/1800a1eb3142b5387a6d4607e25470d1.jpg', 20, 'Chất vải thoáng khí, thích hợp sử dụng trong thi đấu và luyện tập.', 1, 2),
(11, 'Áo Liverpool chính hãng', 350000, 'https://i.pinimg.com/736x/6c/1e/74/6c1e7459637163089b135cc71252c90f.jpg', 20, 'Áo có công nghệ làm mát tiên tiến, giữ cơ thể luôn khô thoáng.', 1, 3),
(12, 'Áo Real Madrid chính hãng', 240000, 'https://i.pinimg.com/736x/2f/bf/45/2fbf45c44d91b8a36af7c56fb5b79b1d.jpg', 20, 'Phiên bản áo đấu mùa giải mới, hỗ trợ vận động tối đa.', 1, 0),
(13, 'Áo Inter Milan chính hãng', 180000, 'https://i.pinimg.com/736x/f4/0e/1e/f40e1ec2ecec8cbf4f53880ccce914c9.jpg', 20, 'Thiết kế chuẩn form châu Âu, logo thêu sắc nét.', 1, 1),
(14, 'Áo Bayern Munich chính hãng', 320000, 'https://i.pinimg.com/736x/fd/c2/49/fdc249d554e0f152da482b97b50a06e9.jpg', 20, 'Áo thi đấu chính hãng với chất liệu co giãn, thấm hút mồ hôi tốt.', 1, 2),
(15, 'Áo Arsenal chính hãng', 230000, 'https://i.pinimg.com/736x/3a/d6/4f/3ad64f8ff2a0f58b800dbd08febc3b8b.jpg', 20, 'Phiên bản áo đấu mùa giải mới, hỗ trợ vận động tối đa.', 1, 3),
(16, 'Áo Real Madrid chính hãng', 220000, 'https://i.pinimg.com/736x/aa/9b/14/aa9b14c14608562ef7d317f23b25271e.jpg', 20, 'Áo thi đấu chính hãng với chất liệu co giãn, thấm hút mồ hôi tốt.', 1, 0),
(17, 'Áo Paris Saint-Germain chính hãng', 410000, 'https://i.pinimg.com/736x/55/ef/a7/55efa76e5133f8501d6aecf332d53bee.jpg', 20, 'Chất vải thoáng khí, thích hợp sử dụng trong thi đấu và luyện tập.', 1, 1),
(18, 'Áo Manchester United chính hãng', 460000, 'https://i.pinimg.com/736x/8c/68/4a/8c684a96c27ac50c4801716df9969d4a.jpg', 20, 'Chất vải thoáng khí, thích hợp sử dụng trong thi đấu và luyện tập.', 1, 2),
(19, 'Áo Bayern Munich chính hãng', 450000, 'https://i.pinimg.com/736x/f8/3b/fd/f83bfdb285ba3b50e0427c84a173a776.jpg', 20, 'Áo thi đấu chính hãng với chất liệu co giãn, thấm hút mồ hôi tốt.', 1, 3),
(20, 'Áo Liverpool chính hãng', 290000, 'https://i.pinimg.com/736x/84/54/d5/8454d5a4ab5503b32629bc7d90a6312d.jpg', 20, 'Áo có công nghệ làm mát tiên tiến, giữ cơ thể luôn khô thoáng.', 1, 0),
(21, 'Áo Inter Milan chính hãng', 310000, 'https://i.pinimg.com/736x/f4/0e/1e/f40e1ec2ecec8cbf4f53880ccce914c9.jpg', 20, 'Áo thi đấu chính hãng với chất liệu co giãn, thấm hút mồ hôi tốt.', 1, 1),
(22, 'Áo Bayern Munich chính hãng', 170000, 'https://i.pinimg.com/736x/05/a4/83/05a483cc828d23bf67dfd82d88006298.jpg', 20, 'Áo có công nghệ làm mát tiên tiến, giữ cơ thể luôn khô thoáng.', 1, 2),
(23, 'Áo Bayern Munich chính hãng', 180000, 'https://i.pinimg.com/736x/16/7c/54/167c54ccffb6e619787cdbf1956c0b50.jpg', 20, 'Chất vải thoáng khí, thích hợp sử dụng trong thi đấu và luyện tập.', 1, 3),
(24, 'Áo Arsenal chính hãng', 260000, 'https://i.pinimg.com/736x/61/71/89/61718928716fb90899b3766871b4cf17.jpg', 20, 'Áo có công nghệ làm mát tiên tiến, giữ cơ thể luôn khô thoáng.', 1, 0),
(25, 'Áo Manchester United chính hãng', 390000, 'https://i.pinimg.com/736x/bf/af/5e/bfaf5e39a59325697089ccd47f0369e1.jpg', 20, 'Chất vải thoáng khí, thích hợp sử dụng trong thi đấu và luyện tập.', 1, 1),
(26, 'Áo Chelsea chính hãng', 420000, 'https://i.pinimg.com/736x/9d/0e/87/9d0e875baf14c58d11f63a4c7eadb437.jpg', 20, 'Thiết kế chuẩn form châu Âu, logo thêu sắc nét.', 1, 2),
(27, 'Áo Chelsea chính hãng', 390000, 'https://i.pinimg.com/736x/1d/fb/f3/1dfbf3f428b00155ff0a6fd20a5af9af.jpg', 20, 'Áo thi đấu chính hãng với chất liệu co giãn, thấm hút mồ hôi tốt.', 1, 3),
(28, 'Áo Real Madrid chính hãng', 510000, 'https://i.pinimg.com/736x/9f/40/8a/9f408af47cb6a3a8e58b667fe722841c.jpg', 20, 'Áo có công nghệ làm mát tiên tiến, giữ cơ thể luôn khô thoáng.', 1, 0),
(29, 'Áo Paris Saint-Germain chính hãng', 390000, 'https://i.pinimg.com/736x/1d/3b/cc/1d3bccd067bdc1dfc9976e4aaca2d659.jpg', 20, 'Thiết kế chuẩn form châu Âu, logo thêu sắc nét.', 1, 1),
(30, 'Áo Paris Saint-Germain chính hãng', 470000, 'https://i.pinimg.com/736x/e1/82/ca/e182ca6d8fda8162725bc9c3bd3d9f7e.jpg', 20, 'Áo thi đấu chính hãng với chất liệu co giãn, thấm hút mồ hôi tốt.', 1, 2),
(31, 'Áo Manchester United chính hãng', 280000, 'https://i.pinimg.com/736x/18/00/a1/1800a1eb3142b5387a6d4607e25470d1.jpg', 20, 'Chất vải thoáng khí, thích hợp sử dụng trong thi đấu và luyện tập.', 1, 3),
(32, 'Áo AC Milan chính hãng', 480000, 'https://i.pinimg.com/736x/30/e0/50/30e050584627053631912bd954350f5b.jpg', 20, 'Chất vải thoáng khí, thích hợp sử dụng trong thi đấu và luyện tập.', 1, 0),
(33, 'Áo Paris Saint-Germain chính hãng', 190000, 'https://i.pinimg.com/736x/55/ef/a7/55efa76e5133f8501d6aecf332d53bee.jpg', 20, 'Áo thi đấu chính hãng với chất liệu co giãn, thấm hút mồ hôi tốt.', 1, 1),
(34, 'Áo Bayern Munich chính hãng', 160000, 'https://i.pinimg.com/736x/98/81/8c/98818cf9d1f117d2dc7512c718af49a8.jpg', 20, 'Áo thi đấu chính hãng với chất liệu co giãn, thấm hút mồ hôi tốt.', 1, 2),
(35, 'Áo Arsenal chính hãng', 310000, 'https://i.pinimg.com/736x/1b/16/cf/1b16cf7a7fa49c9dbe3c8736669cc570.jpg', 20, 'Áo thi đấu chính hãng với chất liệu co giãn, thấm hút mồ hôi tốt.', 1, 3),
(36, 'Áo Real Madrid chính hãng', 430000, 'https://i.pinimg.com/736x/2f/bf/45/2fbf45c44d91b8a36af7c56fb5b79b1d.jpg', 20, 'Chất vải thoáng khí, thích hợp sử dụng trong thi đấu và luyện tập.', 1, 0),
(37, 'Áo AC Milan chính hãng', 190000, 'https://i.pinimg.com/736x/1e/a1/80/1ea180e82e343ea110d6dbadb9d3ee8d.jpg', 20, 'Thiết kế chuẩn form châu Âu, logo thêu sắc nét.', 1, 1),
(38, 'Áo Arsenal chính hãng', 440000, 'https://i.pinimg.com/736x/3a/d6/4f/3ad64f8ff2a0f58b800dbd08febc3b8b.jpg', 20, 'Áo thi đấu chính hãng với chất liệu co giãn, thấm hút mồ hôi tốt.', 1, 2),
(39, 'Áo Real Madrid chính hãng', 350000, 'https://i.pinimg.com/736x/c2/bd/3a/c2bd3a8e1f97a51c41f20b202e6336d0.jpg', 20, 'Phiên bản áo đấu mùa giải mới, hỗ trợ vận động tối đa.', 1, 3),
(40, 'Áo Bayern Munich chính hãng', 240000, 'https://i.pinimg.com/736x/f8/3b/fd/f83bfdb285ba3b50e0427c84a173a776.jpg', 20, 'Áo thi đấu chính hãng với chất liệu co giãn, thấm hút mồ hôi tốt.', 1, 0),
(41, 'Giày bóng đá mẫu 41', 550000, 'https://i.pinimg.com/736x/55/89/cb/5589cb07ebcdba9725c60e32e083399b.jpg', 20, 'Giày nhẹ, có lớp lót mềm tạo cảm giác êm ái khi di chuyển.', 3, 1),
(42, 'Giày bóng đá mẫu 42', 600000, 'https://i.pinimg.com/736x/03/33/32/033332c0cf7047d1ea417e78a3694f03.jpg', 20, 'Giày đinh TF bám sân tốt, thích hợp cho sân cỏ nhân tạo.', 3, 2),
(43, 'Giày bóng đá mẫu 43', 650000, 'https://i.pinimg.com/736x/46/46/ea/4646ea605d7f193d30e2ade2fa1f4271.jpg', 20, 'Mặt giày sần hỗ trợ sút bóng mạnh và chính xác.', 3, 3),
(44, 'Giày bóng đá mẫu 44', 700000, 'https://i.pinimg.com/736x/b5/f6/69/b5f66951ad0e780b82554e2543521bd9.jpg', 20, 'Thiết kế ôm chân, hỗ trợ kiểm soát bóng linh hoạt.', 3, 0),
(45, 'Giày bóng đá mẫu 45', 750000, 'https://i.pinimg.com/736x/60/12/b8/6012b8b2d26ce65a3c0630a6dc027848.jpg', 20, 'Giày đinh TF bám sân tốt, thích hợp cho sân cỏ nhân tạo.', 3, 1),
(46, 'Giày bóng đá mẫu 46', 800000, 'https://i.pinimg.com/736x/b2/19/9d/b2199df0033b5f8c770ce619c3b00a24.jpg', 20, 'Đế giày cao su non chống trượt, giảm chấn tốt.', 3, 2),
(47, 'Giày bóng đá mẫu 47', 850000, 'https://i.pinimg.com/736x/e7/6f/fe/e76ffefa68f8bb990f9aa1469d593a1a.jpg', 20, 'Giày nhẹ, có lớp lót mềm tạo cảm giác êm ái khi di chuyển.', 3, 3),
(48, 'Giày bóng đá mẫu 48', 900000, 'https://i.pinimg.com/736x/a3/35/08/a33508de0e42b8f142cb42d7647d8e41.jpg', 20, 'Đế giày cao su non chống trượt, giảm chấn tốt.', 3, 0),
(49, 'Giày bóng đá mẫu 49', 950000, 'https://i.pinimg.com/736x/52/ac/a4/52aca4c369a919311d3253de46f11e93.jpg', 20, 'Mặt giày sần hỗ trợ sút bóng mạnh và chính xác.', 3, 1),
(50, 'Giày bóng đá mẫu 50', 500000, 'https://i.pinimg.com/736x/46/68/8d/46688dc44fd2f1acd5a12574b4348f94.jpg', 20, 'Giày nhẹ, có lớp lót mềm tạo cảm giác êm ái khi di chuyển.', 3, 2),
(51, 'Giày bóng đá mẫu 51', 550000, 'https://i.pinimg.com/736x/e3/32/15/e332158eb2e1f2bfe5199267ee2b5ef5.jpg', 20, 'Giày đinh TF bám sân tốt, thích hợp cho sân cỏ nhân tạo.', 3, 3),
(52, 'Giày bóng đá mẫu 52', 800000, 'https://i.pinimg.com/736x/7e/e1/77/7ee1776e321a648292ec084a4f6e6076.jpg', 20, 'Đế giày cao su non chống trượt, giảm chấn tốt.', 3, 0),
(53, 'Giày bóng đá mẫu 53', 650000, 'https://i.pinimg.com/736x/51/49/f6/5149f6d94e684682bd2af69663848649.jpg', 20, 'Giày nhẹ, có lớp lót mềm tạo cảm giác êm ái khi di chuyển.', 3, 1),
(54, 'Giày bóng đá mẫu 54', 700000, 'https://i.pinimg.com/736x/b8/0d/9a/b80d9a3029fdb984d099c29f777852c5.jpg', 20, 'Giày đinh TF bám sân tốt, thích hợp cho sân cỏ nhân tạo.', 3, 2),
(55, 'Giày bóng đá mẫu 55', 750000, 'https://i.pinimg.com/736x/40/5d/54/405d54a870f1c4676a5fa3f0ce8ce2b3.jpg', 20, 'Mặt giày sần hỗ trợ sút bóng mạnh và chính xác.', 3, 3),
(56, 'Giày bóng đá mẫu 56', 800000, 'https://i.pinimg.com/736x/51/7e/4f/517e4fc66f8cf75a39e996ed101d9d16.jpg', 20, 'Thiết kế ôm chân, hỗ trợ kiểm soát bóng linh hoạt.', 3, 0),
(57, 'Giày bóng đá mẫu 57', 850000, 'https://i.pinimg.com/736x/07/b9/af/07b9afeb4a4b2c00d215c3454f882682.jpg', 20, 'Giày đinh TF bám sân tốt, thích hợp cho sân cỏ nhân tạo.', 3, 1),
(58, 'Giày bóng đá mẫu 58', 900000, 'https://i.pinimg.com/736x/0b/9b/e1/0b9be1eb54eefd5ed26d8efce77d423b.jpg', 20, 'Mặt giày sần hỗ trợ sút bóng mạnh và chính xác.', 3, 2),
(59, 'Giày bóng đá mẫu 59', 950000, 'https://i.pinimg.com/736x/0a/08/65/0a086531cc4c8f35bfec162e8bc3202f.jpg', 20, 'Giày đinh TF bám sân tốt, thích hợp cho sân cỏ nhân tạo.', 3, 3),
(60, 'Giày bóng đá mẫu 60', 500000, 'https://i.pinimg.com/736x/b0/13/8a/b0138ae3bcf1d8b212a19b3c3c83f22f.jpg', 20, 'Giày đinh TF bám sân tốt, thích hợp cho sân cỏ nhân tạo.', 3, 0),
(61, 'Bọc giày', 55000, 'https://bizweb.dktcdn.net/100/245/600/files/bao-boc-giay-phong-sach-vai-khong-det-dung-1-lan-2.jpg?v=1601633489329', 20, 'Bọc giày nilon dùng trong điều kiện ẩm ướt.', 11, 1),
(62, 'Tất dài', 60000, 'https://bizweb.dktcdn.net/thumb/large/100/296/016/products/tat-vo-bong-da-bulbal-combi-3-xanh-ngoc-1.jpg?v=1713153787557', 20, 'Tất cao cấp, giữ ấm và bảo vệ cổ chân.', 6, 2),
(63, 'Băng trán', 65000, 'https://down-vn.img.susercontent.com/file/vn-11134207-7ras8-m2991qqiih0y66', 20, 'Băng thun co giãn, thấm mồ hôi hiệu quả.', 8, 3),
(64, 'Túi tập luyện', 70000, 'https://i.pinimg.com/736x/cf/a8/bb/cfa8bb1b19afc8eff66fb103c77048ea.jpg', 20, 'Túi thể thao cỡ nhỏ, đựng vừa quần áo và phụ kiện.', 7, 0),
(65, 'Bọc giày', 75000, 'https://bizweb.dktcdn.net/thumb/large/100/245/600/products/8584542268-1507603279.jpg?v=1533370387927', 20, 'Bọc giày nilon dùng trong điều kiện ẩm ướt.', 11, 1),
(66, 'Túi đựng giày', 80000, 'https://i.pinimg.com/736x/62/cc/6a/62cc6aa5d74eaee746e03a7fd853933d.jpg', 20, 'Túi riêng đựng giày, chống ẩm và dễ vệ sinh.', 7, 2),
(67, 'Tất dài', 85000, 'https://cf.shopee.vn/file/8617cd84ec50f24fbc24ca5e6862d792', 20, 'Tất cao cấp, giữ ấm và bảo vệ cổ chân.', 6, 3),
(68, 'Băng trán', 90000, 'https://down-vn.img.susercontent.com/file/f9bbe95124b861597e3855773d7ab07a', 20, 'Băng thun co giãn, thấm mồ hôi hiệu quả.', 8, 0),
(69, 'Bọc giày', 95000, 'https://isafevn.com/wp-content/uploads/2022/10/boc-giay-phong-sach-vai-khong-det-300x300.jpg', 20, 'Bọc giày nilon dùng trong điều kiện ẩm ướt.', 11, 1),
(70, 'Mặt nạ chắn bóng', 50000, 'https://down-vn.img.susercontent.com/file/sg-11134201-7rbk1-lls437zz4rix6e', 20, 'Bảo vệ mặt khi va chạm, dùng cho thủ môn.', 10, 2),
(71, 'Găng tay thủ môn', 55000, 'https://bizweb.dktcdn.net/thumb/large/100/296/016/products/vgs-giga-xanh.jpg?v=1659425485910', 20, 'Găng tay có độ bám cao, phù hợp mọi thời tiết.', 4, 3),
(72, 'Áo thể thao', 60000, 'https://product.hstatic.net/1000397797/product/pro3_eba1daeafab44a2c96518e6fa55b2b26_master.jpg', 20, 'Áo thể thao, chất liệu nhẹ, khô nhanh.', 1, 0),
(73, 'Lót giày', 65000, 'https://product.hstatic.net/200000641225/product/20240120_85sc1qg6fp-2_9105ef2ac5624c7ab221be1cacc3a729_master.jpeg', 20, 'Lót giày êm ái, khử mùi, giảm áp lực khi chạy.', 9, 1),
(74, 'Mặt nạ chắn bóng', 70000, 'https://down-vn.img.susercontent.com/file/sg-11134201-22110-uxx4z7hn31jv16', 20, 'Bảo vệ mặt khi va chạm, dùng cho thủ môn.', 10, 2),
(75, 'Băng đầu', 75000, 'https://down-vn.img.susercontent.com/file/2da0c123bcf684d26aa5de3d5fb467af', 20, 'Băng đầu co giãn, thấm mồ hôi khi chơi thể thao.', 8, 3),
(76, 'Bọc giày', 80000, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT3tBa6J1fiYT-0XdToQQkQPQft5wngXwUv2NUOXHQZbGceH5QUPm6SsA0w8B9-fqVMJ5A&usqp=CAU', 20, 'Bọc giày nilon dùng trong điều kiện ẩm ướt.', 11, 0),
(77, 'Găng tay thủ môn', 85000, 'https://product.hstatic.net/200000365171/product/8_b45e122e007b45be8287f10003284861.png', 20, 'Găng tay có độ bám cao, phù hợp mọi thời tiết.', 4, 1),
(78, 'Mặt nạ chắn bóng', 90000, 'https://cdn.abphotos.link/photos/resized/1024x/2024/11/15/1731629210_frd5S0Fj6H8XcPlx_1731634116-php5ba5vd.png', 20, 'Bảo vệ mặt khi va chạm, dùng cho thủ môn.', 10, 2),
(79, 'Túi đựng bóng', 95000, 'https://pos.nvncdn.com/822bfa-13829/ps/20220407_ebEm7Ms1uF9Cc7uE9PpAV2jW.jpg', 20, 'Túi lưới rộng rãi, dễ mang theo nhiều bóng.', 7, 3),
(80, 'Túi lưới mini', 50000, 'https://product.hstatic.net/1000061481/product/76efbbe736634ad4960c6047ec63fc87_66d0993665be49a789f8d8092a1c5805_1024x1024.jpg', 20, 'Túi lưới nhỏ gọn, thoáng khí.', 7, 0),
(81, 'Giá treo bóng', 55000, 'https://thethaotruonggiang.vn/wp-content/uploads/2018/08/khung-treo-bong-phan-xa.jpg', 20, 'Giá treo gọn nhẹ, giúp bảo quản bóng tốt hơn.', 5, 1),
(82, 'Túi xách thể thao', 60000, 'https://i.pinimg.com/736x/66/73/bf/6673bf174a395d47492e14379f9151d1.jpg', 20, 'Túi thể thao đa năng, nhiều ngăn tiện lợi.', 7, 2),
(83, 'Lót giày', 65000, 'https://bizweb.dktcdn.net/100/422/613/products/lot-giay-the-thao-adidas-em-chan-khu-mui-thoang-khi-lgtt24-1.jpg?v=1621399216840', 20, 'Lót giày êm ái, khử mùi, giảm áp lực khi chạy.', 9, 3),
(84, 'Vớ thể thao', 70000, 'https://i.pinimg.com/736x/1c/a3/8f/1ca38f1ae8539d7c4479f89b89f3fbe5.jpg', 20, 'Vớ chất liệu cotton co giãn, thấm hút tốt.', 6, 0),
(85, 'Vớ chống trơn', 75000, 'https://i.pinimg.com/736x/1d/87/fe/1d87fef4b41b0a25e016c766abc94e49.jpg', 20, 'Vớ đế cao su chống trượt, hỗ trợ tăng tốc.', 6, 1),
(86, 'Mặt nạ chắn bóng', 80000, 'https://product.hstatic.net/1000269337/product/kinh_can_the_thao_freebee_040__16__6a6e305a9cc545bebf01b9f9f9764944_grande.jpg', 20, 'Bảo vệ mặt khi va chạm, dùng cho thủ môn.', 10, 2),
(87, 'Túi tập luyện', 85000, 'https://i.pinimg.com/736x/dc/49/ce/dc49ceef6af544a79b19bd7068b9f15e.jpg', 20, 'Túi thể thao cỡ nhỏ, đựng vừa quần áo và phụ kiện.', 7, 3),
(88, 'Vớ chống trơn', 90000, 'https://i.pinimg.com/736x/7d/ca/66/7dca66a3409ad5885009603eb743fda8.jpg', 20, 'Vớ đế cao su chống trượt, hỗ trợ tăng tốc.', 6, 0),
(89, 'Dây đeo huấn luyện', 95000, 'https://bizweb.dktcdn.net/100/411/892/products/exhibition-lanyards.jpg?v=1618282857737', 20, 'Dây đeo giúp huấn luyện viên mang theo thiết bị.', 5, 1),
(90, 'Băng trán', 50000, 'https://contents.mediadecathlon.com/p1538349/k$fa3676572c85bb7a38b2d396d20eed87/b%C4%83ng-tr%C3%A1n-th%E1%BB%83-thao-%C4%91en-artengo-8166945.jpg', 20, 'Băng thun co giãn, thấm mồ hôi hiệu quả.', 8, 2),
(91, 'Quần short thể thao nam', 150000, 'https://product.hstatic.net/200000886795/product/quan-short-the-thao-nam-insidemen-iso036s3__1__50b66cb7c26d48a6a2d9e92d73ea071e.jpg', 20, 'Chất liệu thoáng khí, thích hợp luyện tập và thi đấu.', 2, 0),
(92, 'Quần thể thao nam tập gym', 180000, 'https://cdn.gumic.vn/storage/gumicvn/45717/conversions/eofhoemd-album.jpg', 20, 'Form ôm gọn, thấm hút mồ hôi tốt.', 2, 1),
(93, 'Quần thể thao chạy bộ', 200000, 'https://product.hstatic.net/1000369857/product/z3042642035399_1dd30f44c35648901847cbc0f836a5c5_3a6e24e3902348a6be50383057a51d50.jpg', 20, 'Thiết kế nhẹ nhàng, không gây cản trở vận động.', 2, 2),
(94, 'Quần jogger thể thao nam', 220000, 'https://product.hstatic.net/1000369857/product/quan_ni_jgn01_den_1_24b6e4b4248444a0ae81210b3ff4183c.jpg', 20, 'Quần jogger năng động, bo gấu ôm chân.', 2, 3),
(95, 'Quần short đá banh nam', 250000, 'https://supersports.com.vn/cdn/shop/files/IQ0494-1_1200x1200.jpg?v=1710213744', 20, 'Chất vải mát, nhanh khô.', 2, 0),
(96, 'Quần short gym 2 lớp', 280000, 'https://gymfit.vn/wp-content/uploads/2022/10/Quan-short-nu-2-lop-DK224-255k-14.jpg', 20, 'Tích hợp túi đựng điện thoại, khóa kéo tiện lợi.', 2, 1),
(97, 'Quần thể thao nam vải gió', 300000, 'https://pos.nvncdn.com/8f7207-62506/ps/20221008_GpIRjsQwcUywxeqHzIxlXrBc.jpg', 20, 'Chống gió nhẹ, phù hợp thời tiết mát.', 2, 2),
(98, 'Quần dài thể thao tập gym', 320000, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR14UB6V3rE0J6JFtDWgf3P3yyyo9udsIsDJQ&s', 20, 'Thiết kế ôm gọn, giữ ấm cơ bắp khi tập.', 2, 3),
(99, 'Quần short thể thao quick-dry', 350000, 'https://product.hstatic.net/1000150581/product/152445305__1__197678ac81e74197aca7dfd63be2e3f3_master.jpg', 20, 'Khô nhanh, phù hợp tập luyện ngoài trời.', 2, 0),
(100, 'Quần thể thao nam ống rộng', 400000, 'https://down-vn.img.susercontent.com/file/4dcfa55cb7782ce9bdefc6b39ffda15b', 20, 'Phong cách thoải mái, không bó sát.', 2, 1),
(101, 'Quần short training nam', 450000, 'https://product.hstatic.net/200000174405/product/3_0c015796480544f69ce569688b0e2e3b_master.jpg', 20, 'Dành cho luyện tập đa năng, có dây rút.', 2, 2),
(102, 'Quần jogger 2 lớp thể thao', 500000, 'https://pos.nvncdn.com/822bfa-13829/ps/20190723_DsFf7VQnxcamQFMMrblF3gQi.jpg', 20, 'Lớp trong thoáng khí, lớp ngoài chắn gió nhẹ.', 2, 3),
(103, 'Quần thể thao bo gấu nam', 600000, 'https://cbu01.alicdn.com/img/ibank/O1CN01E80MF12Luvj5ihJbo_!!2209125889753-0-cib.jpg', 20, 'Dễ di chuyển, phong cách thể thao trẻ trung.', 2, 0),
(104, 'Quần thể thao unisex vải co giãn', 700000, 'https://product.hstatic.net/1000369857/product/fp02_xam_3_3c3f9c059763477c87b1a1c54b4eb0a1.jpg', 20, 'Dùng được cho cả nam và nữ, co giãn bốn chiều.', 2, 1),
(105, 'Quần short đá banh 2 lớp nam', 800000, 'https://down-vn.img.susercontent.com/file/vn-11134207-7r98o-lpfy5fna9jymee', 20, 'Lót trong giúp cố định vị trí, không bị xô lệch.', 2, 2);
-- --------------------------------------------------------

--
-- Table structure for table `sub_img_url`
--

CREATE TABLE `sub_img_url` (
  `ID` bigint(20) NOT NULL,
  `PID` bigint(20) NOT NULL,
  `IMG_URL` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `PID` (`PID`),
  ADD KEY `UID` (`UID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UID` (`UID`);

--
-- Indexes for table `comment_news`
--
ALTER TABLE `comment_news`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `CID` (`CID`),
  ADD KEY `NID` (`NID`);

--
-- Indexes for table `employee_account`
--
ALTER TABLE `employee_account`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UID` (`UID`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `PID` (`PID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_category_product` (`CATEGORY`);

--
-- Indexes for table `sub_img_url`
--
ALTER TABLE `sub_img_url`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `PID` (`PID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `comment_news`
--
ALTER TABLE `comment_news`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee_account`
--
ALTER TABLE `employee_account`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `ID` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `sub_img_url`
--
ALTER TABLE `sub_img_url`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`PID`) REFERENCES `product` (`ID`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`UID`) REFERENCES `account` (`ID`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `account` (`ID`);

--
-- Constraints for table `comment_news`
--
ALTER TABLE `comment_news`
  ADD CONSTRAINT `comment_news_ibfk_1` FOREIGN KEY (`CID`) REFERENCES `account` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_news_ibfk_2` FOREIGN KEY (`NID`) REFERENCES `news` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `account` (`ID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_category_product` FOREIGN KEY (`CATEGORY`) REFERENCES `category` (`id`);

--
-- Constraints for table `sub_img_url`
--
ALTER TABLE `sub_img_url`
  ADD CONSTRAINT `sub_img_url_ibfk_1` FOREIGN KEY (`PID`) REFERENCES `product` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
