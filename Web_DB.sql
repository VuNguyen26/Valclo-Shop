DROP SCHEMA IF EXISTS `Web_DB`;
CREATE SCHEMA `Web_DB`;
USE `Web_DB`;

CREATE TABLE `PRODUCT`(
    `ID` BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,-- 4 số 
    `NAME` VARCHAR(100) COLLATE utf8_unicode_ci,
    `PRICE` INT,
    `IMG_URL` VARCHAR(250),
    `NUMBER` INT,
    `DECS` TEXT COLLATE utf8_unicode_ci,
    `CATEGORY` VARCHAR(100) COLLATE utf8_unicode_ci,
    `TOP_PRODUCT` INT
);
CREATE TABLE `SUB_IMG_URL` (
    `ID` BIGINT PRIMARY KEY AUTO_INCREMENT,
    `PID` BIGINT NOT NULL,
    `IMG_URL` VARCHAR(250),
    FOREIGN KEY (`PID`) REFERENCES `PRODUCT`(`ID`)
);
CREATE TABLE `ACCOUNT` (
    `ID` BIGINT PRIMARY KEY AUTO_INCREMENT,
    `CMND` VARCHAR(10),
    `FNAME` VARCHAR(50) COLLATE utf8_unicode_ci,
    `PHONE` VARCHAR(10),
    `ADDRESS` TEXT COLLATE utf8_unicode_ci,
    `USERNAME` VARCHAR(50) COLLATE utf8_unicode_ci,
    `EMAIL`  VARCHAR(250) COLLATE utf8_unicode_ci,
    `PWD` VARCHAR(50) COLLATE utf8_unicode_ci,
    `IMG_URL`  VARCHAR(250),
    `RANK` INT

);
CREATE TABLE `CART`(
    `ID` BIGINT PRIMARY KEY AUTO_INCREMENT,
    `UID` BIGINT NOT NULL,
    `TIME` DATE,
    `STATE` tinyint DEFAULT 0,
    FOREIGN KEY (`UID`) REFERENCES `ACCOUNT`(`ID`)
);
CREATE TABLE `PRODUCT_IN_CART`(
    `ID` BIGINT PRIMARY KEY AUTO_INCREMENT,
    `PID` BIGINT NOT NULL,
    `OID` BIGINT NOT NULL,
    `QUANTITY` INT DEFAULT 1,
    `SIZE` VARCHAR(5) DEFAULT "L",
    FOREIGN KEY (`PID`) REFERENCES `PRODUCT`(`ID`),
    FOREIGN KEY (`OID`) REFERENCES `CART`(`ID`)
);
CREATE TABLE `COMMENT`(
    `ID` BIGINT PRIMARY KEY AUTO_INCREMENT,
    `PID` BIGINT NOT NULL,
    `UID` BIGINT NOT NULL,
    `STAR` INT DEFAULT 5,
    `CONTENT` TEXT COLLATE utf8_unicode_ci,
    `TIME` DATE,
    FOREIGN KEY (`UID`) REFERENCES `ACCOUNT`(`ID`)
);
CREATE TABLE `NEWS`(
    `ID` BIGINT PRIMARY KEY AUTO_INCREMENT,
    `CID` BIGINT,
    `KEY` VARCHAR(50),
    `TIME` DATE,
    `TITLE` VARCHAR(70) COLLATE utf8_unicode_ci,
    `CONTENT` TEXT COLLATE utf8_unicode_ci,
    `IMG_URL` VARCHAR(50),
    `SHORT_CONTENT` VARCHAR(300) COLLATE utf8_unicode_ci
);
CREATE TABLE `COMMENT_NEWS`(
    `ID` BIGINT PRIMARY KEY AUTO_INCREMENT,
    `NID` BIGINT NOT NULL,
    `CID` BIGINT NOT NULL,
    `CONTENT` TEXT COLLATE utf8_unicode_ci,
    `TIME` DATE,
    FOREIGN KEY (`CID`) REFERENCES `ACCOUNT`(`ID`) ON DELETE CASCADE,
    FOREIGN KEY (`NID`) REFERENCES `NEWS`(`ID`) ON DELETE CASCADE 
);
CREATE TABLE `CYCLE`(
    `ID` INT PRIMARY KEY AUTO_INCREMENT,
    `CYCLE` VARCHAR(10)
);
CREATE TABLE `COMBO`(
    `ID` INT PRIMARY KEY AUTO_INCREMENT,
    `NAME` VARCHAR(50) COLLATE utf8_unicode_ci,
    `COST` INT DEFAULT 0
);
CREATE TABLE `PRODUCT_IN_COMBO`(
    `ID` INT PRIMARY KEY AUTO_INCREMENT,
    `CBID` INT NOT NULL,
    `PID` BIGINT NOT NULL,
    FOREIGN KEY (`PID`) REFERENCES `PRODUCT`(`ID`),
    FOREIGN KEY (`CBID`) REFERENCES `COMBO`(`ID`)
);
CREATE TABLE `MESSAGE`(
    `ID` INT PRIMARY KEY AUTO_INCREMENT,
    `FNAME` VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci,
    `EMAIL` VARCHAR(250),
    `PHONE` VARCHAR(10),
    `SUBJECT` VARCHAR(250) COLLATE utf8_unicode_ci,
    `CONTENT` TEXT COLLATE utf8_unicode_ci,
    `CHECK` TINYINT DEFAULT 0
);
CREATE TABLE `ORDER_COMBO`(
    `ID` INT PRIMARY KEY AUTO_INCREMENT,
    `UID` BIGINT,
    `CBID` INT NOT NULL,
    `TIME` DATE,
    `CYCLE` INT,
    `SIZE` VARCHAR(10),
    `STATE` tinyint DEFAULT 0,
    FOREIGN KEY (`CBID`) REFERENCES `COMBO`(`ID`),
    FOREIGN KEY (`UID`) REFERENCES `ACCOUNT`(`ID`),
    FOREIGN KEY (`CYCLE`) REFERENCES `cycle`(`ID`)
);
CREATE TABLE `BAN_ACCOUNT`(
    `ID` INT PRIMARY KEY AUTO_INCREMENT,
    `CMND` VARCHAR(10)
);


-- product value
INSERT INTO `product`(`product`.`ID`, `product`.`NAME`, `product`.`PRICE`, `product`.`IMG_URL`, `product`.`NUMBER`, `product`.`DECS`, `product`.`CATEGORY`, `product`.`TOP_PRODUCT`) VALUES
(1, "ÁO BÓNG ĐÁ CHÍNH HÃNG INTER MILAN SÂN KHÁCH 2024/25 FN8793-123", 850000, "https://product.hstatic.net/1000061481/product/75a9d828e17944cab4d6294c0208c0b9_7744531afefd4e2095543e43ae0e4b9e_1024x1024.jpg", 20, "Làm từ 100% chất liệu tái chế, sản phẩm này đại diện cho một trong số rất nhiều các giải pháp của chúng tôi hướng tới chấm dứt rác thải nhựa.", "Shirt", 1),
(2, "ÁO BÓNG ĐÁ CHÍNH HÃNG REAL MADRID SÂN NHÀ 2024/25 IU5011", 1200000, "https://product.hstatic.net/1000061481/product/c6b06feb89854621bea4f54279057437_e680a04d2a04480d946c73073f8d6858_1024x1024.jpg", 20, "Sản phẩm này làm từ sợi dệt có chứa 50% chất liệu Parley Ocean Plastic — rác thải nhựa tái chế thu gom từ các vùng đảo xa, bãi biển, khu dân cư ven biển và đường bờ biển, nhằm ngăn chặn ô nhiễm đại dương. Sản phẩm này có chứa tổng cộng ít nhất 40% thành phần tái chế.", "Shirt", 0),
(3, "ÁO BÓNG ĐÁ CHÍNH HÃNG BARCELONA THỨ 3 2024/25 FQ2022-702", 1100000, "https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg", 20, "Sản phẩm này làm từ sợi dệt có chứa 50% chất liệu Parley Ocean Plastic — rác thải nhựa tái chế thu gom từ các vùng đảo xa, bãi biển, khu dân cư ven biển và đường bờ biển, nhằm ngăn chặn ô nhiễm đại dương. Sản phẩm này có chứa tổng cộng tối thiểu 40% thành phần tái chế.", "Trousers", 1),
(4, "ÁO BÓNG ĐÁ CHÍNH HÃNG NIKE PARIS SAINT-GERMAIN SÂN KHÁCH 2024/25 FN8781-101", 1250000, "https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg", 20, "Làm từ một nhóm chất liệu tái chế và có chứa ít nhất 60% thành phần tái chế, sản phẩm này đại diện cho một trong số rất nhiều các giải pháp của chúng tôi hướng tới chấm dứt rác thải nhựa.", "Trousers", 0),
(5, "BỌC ỐNG ĐỒNG NMS CREATOR 365 MÀU NGẪU NHIÊN", 1500000, "https://product.hstatic.net/1000061481/product/040bb1c326c44ad4bc6ea8bd703aba55_f3586483b6c7491d91efe12fb65cbe49_1024x1024.jpg", 20, "Bạn sẽ có rất nhiều lựa chọn với chiếc quần adidas này. Giữ ấm hay làm mát cơ thể, chiếc quần này làm được hết. Chỉ cần rảo bước dạo quanh phố phường — vì chẳng có gì tuyệt hơn chất vải dệt kim đôi mềm mại, giúp bạn luôn cảm thấy dễ chịu suốt ngày dài. Phải chăng bạn đang relax hơi nhiều, nhưng nếu đúng như thế thì chiếc quần này cũng đáp ứng được luôn. Vì đó chính là nhiệm vụ của nó. Tập luyện. Thư giãn. Mọi tốc độ, mọi địa điểm. Tất cả đều được hết!", "Trousers", 2),
(6, "GIÀY PAN PERFORMAX 8 ĐẾ TF", 950000, "https://bizweb.dktcdn.net/thumb/1024x1024/100/348/425/products/giay-pan-performax-8-tf-1-1686399301128.png?v=1695644397207",20,"Được làm bằng một loạt các vật liệu tái chế và ít nhất 60% hàm lượng tái chế, sản phẩm này chỉ đại diện cho một trong những giải pháp của chúng tôi để giúp chấm dứt rác thải nhựa.","Accessories", 0),
(7, "TÚI DUFFEL 4ATHLTS CỠ NHỎ", 950000, "https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/9954f98b2be94704834bae770031f5b8_9366/4ATHLTS_Duffel_Bag_Small_Green_HM9130_01_standard.jpg", 20, "Được tạo ra một phần với nội dung tái chế được tạo ra từ chất thải sản xuất, ví dụ: cắt phế liệu và rác thải sinh hoạt sau khi tiêu dùng để tránh tác động môi trường lớn hơn do sản xuất hàm lượng nguyên chất.", "Accessories", 1),
(8, "TÚI LƯỚI ĐỰNG BÓNG", 700000, "https://thethaonamviet.vn/wp-content/uploads/2023/09/tui-luoi-dung-bong.jpg", 20, "Độ bám gậy chắc chắn làm nên cú vung gậy tự tin. Chiếc găng tay golf adidas này có phần lòng bàn tay mềm mại cho độ bám chắc chắn. Chất vải dệt kim co giãn giữa các ngón tay và trên mu bàn tay đảm bảo sự linh hoạt. Miếng dán giúp bạn tùy chỉnh độ ôm.", "Accessories", 2),
(9, "BÓNG PRO VOID UCL", 3300000, "https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/a4cb579ff54647039f07ae3f012bdfaa_9366/Bong_Pro_Void_UCL_trang_HE3777_02_standard_hover.jpg", 20, "Trong màn đêm tối đen như mực, các ngôi sao càng tỏa sáng hơn. Lấy cảm hứng từ vũ trụ sâu thăm thẳm, trái bóng adidas UCL Pro Void này làm nền để các cầu thủ xuất sắc nhất châu Âu tỏa sáng trên sân cỏ. Họa tiết graphic rực rỡ phủ ngoài bề mặt không đường may nối ghép bằng nhiệt, cùng ruột bóng làm bằng cao su butyl cao cấp. Tem chứng nhận chất lượng chuẩn FIFA đảm bảo hiệu năng xuất chúng.", "Accessories", 3),
(10, "GĂNG TAY THỦ MÔN KAIWIN PLATINUM - TRẮNG XANH DA",900000, "https://bizweb.dktcdn.net/100/017/070/products/gunner-bich.jpg?v=1695002923217", 20, 'Chiếc áo thun này làm từ chất liệu tự nhiên và có thể tái tạo, là một phần trong hành trình của chúng tôi hướng tới chấm dứt sử dụng tài nguyên hữu hạn và góp phần loại bỏ rác thải nhựa.', "Shirt", 2);


-- account
INSERT INTO `account`(`account`.`CMND`, `account`.`FNAME`, `account`.`PHONE`, `account`.`ADDRESS`, `account`.`USERNAME`, `account`.`PWD`, `account`.`IMG_URL`, `account`.`RANK`, `account`.`EMAIL`)VALUES
("051204001795", "Nguyễn Minh Vũ", "0968830591", "Quảng Ngãi", "minhvu", "valcloshop", "./Views/images/vu.jpeg", 100, "nguyenminhvu591@gmail.com");


-- comment
INSERT INTO `comment`(`comment`.`PID`, `comment`.`UID`, `comment`.`STAR`, `comment`.`CONTENT`, `comment`.`TIME`) VALUES
(1, 1, 5, "Rất tốt ạ", "2022-06-18"),
(1, 1, 3, "Bình thường", "2022-06-16"),
(1, 1, 1, "Không thích :v", "2022-06-10"),
(1, 2, 5, "Tuyệt vời", "20212-05-25"),
(2, 1, 3, "Hơi tệ tí nhe", "2022-05-20"),
(3, 1, 4, "Tạm ổn", "2022-05-19");

-- combo
INSERT INTO `combo` (`combo`.`ID`, `combo`.`NAME`, `combo`.`COST`)VALUES 
(1, "Combo 1", 1399000),
(2, "Combo 2", 1499000),
(3, "Combo 3", 1599000),
(4, "Combo 4", 1699000),
(5, "Combo 5", 1799000),
(6, "Combo 6", 1999000);

-- product in combo
INSERT INTO `product_in_combo`(`product_in_combo`.`ID`, `product_in_combo`.`CBID`, `product_in_combo`.`PID`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),

(4, 2, 1),
(5, 2, 3),
(6, 2, 4),

(7, 3, 2),
(8, 3, 4),
(9, 3, 3),

(10, 4, 2),
(11, 4, 3),
(12, 4, 4),

(13, 5, 1),
(14, 5, 4),
(15, 5, 3),

(16, 6, 1),
(17, 6, 3),
(18, 6, 2);


-- cycle
INSERT INTO `cycle`(`cycle`.`ID`, `cycle`.`CYCLE`) VALUES
(1, "15 ngày"),
(2, "30 ngày"),
(3, "45 ngày");
-- cart
INSERT INTO `cart`(`cart`.`UID`, `cart`.`TIME`) VALUES
(1, "2022/06/18"),
(1, "2021/06/17"), 
(1, "2021/06/17");
-- product_in_cart
INSERT INTO `product_in_cart` (`product_in_cart`.`PID`, `product_in_cart`.`OID`) VALUES
(1, 1),
(2, 1),
(3, 1);
-- order combo
-- sub_img_url
INSERT INTO `sub_img_url`(`sub_img_url`.`ID`, `sub_img_url`.`PID`, `sub_img_url`.`IMG_URL`) VALUES
(1, 1, "https://bizweb.dktcdn.net/thumb/1024x1024/100/348/425/products/ao-bong-da-mu-manchester-united-2023-24-2.jpg?v=1717473781560"),
(2, 1, "https://product.hstatic.net/1000061481/product/anh_sb_1-01-0-02-212414124222-2_15b8e22d693445e2ad157600732cf110_1024x1024.jpg"),
(3, 1, "https://product.hstatic.net/1000061481/product/nh_sp_add_web_4-02-02-078971-01-01-01-01-02-02-02-02-02-02-01-01-02-01_814d1d1ee52b466d84306ea697ae1d32_1024x1024.jpg"),
(4, 1, "https://product.hstatic.net/1000061481/product/anh_sp_add_web_3-02-02-01-01-01-1-0-1-01-2_f9b704df047640729fb5cc7b00bded77_1024x1024.jpg"),
(5, 2, "https://product.hstatic.net/1000061481/product/anh_sb_1-01-0-02-212414124122-2_1bd4f919ddf74867929ffd87845a0a2c_1024x1024.jpg"),
(6, 2, "https://product.hstatic.net/1000061481/product/dd_web_ballak02-01-01-01-01-02-02-02-02-02-02-02-02-01-01-02-02-02-2-2_9e8f67e3af7d4de599728c86242e130f_1024x1024.jpg"),
(7, 2, "https://product.hstatic.net/1000061481/product/anh_sp_add_web_bal_-02-02-02-02-02-02-02-02-02-01-01-01-02-02-02-2-2-2_388b306e9785476284efce5f211e9c7b_1024x1024.jpg"),
(8, 2, "https://product.hstatic.net/1000061481/product/anh_sp_add-01-01-01-04-203-1-2_b107084e943d453894dd477f408730cb_1024x1024.jpg"),
(9, 3, "https://product.hstatic.net/1000061481/product/myach-adidas-jm4205-800x800_d620bd6b53fc4a44b0e28e3849745962_1024x1024.jpg"),
(10, 3, "https://product.hstatic.net/1000061481/product/nk_pl_heritage_seitiro_-_sp25_71125c10271b49bfbc64206f76db1037_1024x1024.jpg"),
(11, 3, "https://product.hstatic.net/1000061481/product/pl_nk_heritage_ordem_3_-_sp25_53976b21e66149a9a4760a997f980afb_1024x1024.jpg"),
(12, 3, "https://product.hstatic.net/1000061481/product/remove-bg.ai_1737339911241_629e125de33042c082aee78a0a56813a_1024x1024.jpg"),
(13, 4, "https://product.hstatic.net/1000061481/product/anh_sp_add_weballb_4-02-02-01-01-01-_3e17197c4186488bacf43d3e372919b7_1024x1024.jpg"),
(14, 4, "https://product.hstatic.net/1000061481/product/040bb1c326c44ad4bc6ea8bd703aba55_f3586483b6c7491d91efe12fb65cbe49_1024x1024.jpg"),
(15, 4, "https://product.hstatic.net/1000061481/product/remove-bg.ai_1735781008586_3374e609ac6549d19fece2f38ec1b12d_1024x1024.png"),
(16, 4, "https://product.hstatic.net/1000061481/product/5aa2feadc2c24de58349fe5d6f03ecf1_a3eaa93dcc6e47f99c9cb2f9b062a041_1024x1024.jpg"),
(17, 5, "https://product.hstatic.net/1000061481/product/remove-bg.ai_1736928416755_f4416b8350e84b988ac6474436858d37_1024x1024.png"),
(18, 5, "https://product.hstatic.net/1000061481/product/nms03114_863d243d54474495b9cac9e5b41e48ef_1024x1024.jpg"),
(19, 5, "https://product.hstatic.net/1000061481/product/dbbd2a87c4ba4e189b9670ba97f854b8_53f4965f4af3437baa5cce2f6393fdcc_1024x1024.jpg"),
(20, 5, "https://product.hstatic.net/1000061481/product/c6b06feb89854621bea4f54279057437_e680a04d2a04480d946c73073f8d6858_1024x1024.jpg"),
(21, 6, "https://product.hstatic.net/1000061481/product/e141af4a71a94c3284f04763f9022577_1f4113a8cce449a09333200715440ec7_1024x1024.jpg"),
(22, 6, "https://product.hstatic.net/1000061481/product/3a9ab2b213744404a5eefc7da624d812_a809ad64e4834c0bacb36604ba522576_1024x1024.jpg"),
(23, 6, "https://product.hstatic.net/1000061481/product/9d8b241444824369ba28d2af8b8924a3_1a79d56c102c4778987bd66617e4815f_1024x1024.jpg"),
(24, 6, "https://product.hstatic.net/1000061481/product/ff0119ea5b814468b32e4540c027c552_287aeadcf7734657b55951e969144118_1024x1024.jpg"),
(25, 7, "https://product.hstatic.net/1000061481/product/nms02836-11_0817e5bc556f48c9be3de099f3e79628_1024x1024.jpg"),
(26, 7, "https://product.hstatic.net/1000061481/product/nms03785collection_5a6988e1751d4deabc6ef08a0fb32a23_1024x1024.jpg"),
(27, 7, "https://product.hstatic.net/1000061481/product/nms06893avatar-2_fbe758e27292402d953dbd005a9c7c52_1024x1024.jpg"),
(28, 7, "https://product.hstatic.net/1000061481/product/screenshot_108_cfbf92ad1cee4442a0ad80dff5eebc51_1024x1024.jpg`  "),
(29, 8, "https://product.hstatic.net/1000061481/product/5016c8c312884d4796b95bcb5974ea7e_4ed2609cdd5b485cb04a465ede799cca_1024x1024.jpg"),
(30, 8, "https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/9b7fcd1c279f4d76a32aad900018207d_9366/Gang_Tay_Multifit_360_Mot_Chiec_trang_HA5872_42_detail.jpg"),
(31, 8, "https://assets.adidas.com/images/w_600,f_auto,q_auto/cfe81fed73164e1d9d75ad90001781cd_9366/Gang_Tay_Multifit_360_Mot_Chiec_trang_HA5872.jpg"),
(32, 8, "https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/bdb4ca309de245ad9a41ad900016c411_9366/Gang_Tay_Multifit_360_Mot_Chiec_trang_HA5872_01_standard.jpg"),
(33, 9, "https://product.hstatic.net/1000061481/product/anh_sp_add-01-01-5787873222-2-2_c60441ab5eac4de4acd29f41ab149111_1024x1024.jpg"),
(34, 9, "https://product.hstatic.net/1000061481/product/anh_sp_add-01-01-578787322-2_8bff1b224c1d46318b8e16c031100be0_1024x1024.jpg"),
(35, 9, "https://assets.adidas.com/images/w_600,f_auto,q_auto/a4cb579ff54647039f07ae3f012bdfaa_9366/Bong_Pro_Void_UCL_trang_HE3777.jpg"),
(36, 9, "https://product.hstatic.net/1000061481/product/anh_sp_add-01-01-5773-2_593d3529223641448e78cda455e6b28b_1024x1024.jpg"),
(37, 10, "https://product.hstatic.net/1000061481/product/anh_sp_add_web_3-02-02-01-01-01-01-02_8bab1853087c460bb31a04d2477c8eba_1024x1024.jpg"),
(38, 10, "https://product.hstatic.net/1000061481/product/anh_sp_add_web_4-02-02-01-01-01-01_0c842858171046849b29c83f86e3995f_1024x1024.jpg"),
(39, 10, "https://product.hstatic.net/1000061481/product/_sp_add_web_3-02-02-01-01-01-01-01-01-01-01-01-01-01-01-01-01-01-01-01_9be438b22de0478a8e6044a21858e474_1024x1024.jpg"),
(40, 10, "https://product.hstatic.net/1000061481/product/d99021b7be2c_15c91129cd9c4da7a8cc46c81c490ac8_1024x1024.jpeg");

INSERT INTO `news`(`news`.`ID`, `news`.`CID`, `news`.`KEY`, `news`.`TIME`, `news`.`TITLE`, `news`.`CONTENT`, `news`.`IMG_URL`, `news`.`SHORT_CONTENT`) VALUES
(1, 1, "Localbrand", "2022/06/18", "Phá tan sự nhàm chán bằng loạt kiểu phối đồ Streetwear Style", "'Street Style chính là một cụm từ khá quen thuộc. Nhưng bạn có thực sự hiểu rõ được ý nghĩa là thật sự của Street Style là gì? Và xu hướng của thời trang này tại Việt Nam chưa? Hôm nay, Chipi sẽ chia sẻ giúp bạn hiểu rõ hơn về phong cách thời trang này, cùng tham khảo nhé!\n\n\nStreet Style hay còn gọi là phong cách thời trang đường phố, cũng giống như tên gọi của nó. Đây chính là phong cách thời trang không phải phát triển từ những bộ sưu tập của nhà thiết kế mà từ đường phố.\n\nHiện nay bạn có thể dễ dàng thấy được Street Style ở bất cứ đâu trong giới trẻ trên đường phố. Chắc chắn phong cách thời trang này sẽ được giới trẻ ưa chuộng trong năm nay. Không giống như những phong cách thời trang khác, Street Style giống một cốc sinh tố hỗn hợp của rất nhiều phong cách khác nhau.\n\nKhó có thể chỉ ra được đặc điểm cụ thể của một Street Style. Bởi lẽ chúng được kết hợp từ khá nhiều phong cách khác nhau, nó dựa trên những gu thẩm mỹ của mỗi người. Vô cùng biến hoá và năng động với nhiều thiết kế trang phục khác nhau. Cùng với đó là phụ kiện đi kèm khá đa dạng và phong phú. \n\nChính bởi sự ngẫu hứng và năng động này mà Street Style đã trở thành một nguồn cảm hứng bất tận dành cho giới trẻ hiện nay. Đem tới sự tự do thoải mái trong việc chọn lựa những bộ trang phục thể hiện cá tính của mình.", "./Views/images/news_4.png", "Gợi ý những set đồ street style cực chất từ các local brand giúp các bạn thay vì mua riêng…"),
(2, 1, "Localbrand", "2022/06/18", "BST SS21 Nonnative brand phân lớp theo mùa cao điểm", "BST SS21 từ Nonnative brand sử dụng những gam màu cơ bản cùng thiết kế đơn giản dễ dàng mix & match theo phong cách quân đội và các mặt hàng chủ lực thông thường. Cụ thể về bộ sưu tập sẽ được bật mí qua bài viết sau đây. \n\n\n <h6>Phương pháp thiết kế đặc trưng của Nonnative brand thể hiện trong từng BST</h6> \n Mang đến sự tiếp cận thông minh đối với thiết kế hàng may mặc hướng đến sự đơn giản tinh tế thay vì thời trang dạo phố lấy biểu tượng làm trung tâm.\n\n<h6>Nonnative brand đơn giản nhưng độc đáo</h6>\nGiám đốc sáng tạo Takayuki Fujii đã không giám sát Nonnative brand kể từ khi thành lập, nhưng dưới tầm nhìn của ông, thương hiệu đã phát triển thành một thế lực đáng nể trong thời trang Nhật Bản; Mùa xuân / mùa hè năm 2021, “South” là mùa thứ 39 của thương hiệu, chắt lọc những nét đặc trưng của hãng thành một dòng sản phẩm đơn giản \n\n <h6>Nguồn cảm hứng trong thiết kế từ Nonnative brand</h6>\nVới BST trước từ Nonnative brand “Winter & Spring”, “South” được tự do sử dụng phong cách mùa hè và mùa thu, lấy cảm hứng từ New Zealand. Nguồn cảm hứng New Zealand cũng xuất hiện nhờ đồ họa lấy cảm hứng từ hãng thu âm cổ điển, những chiếc áo phông và áo len chui đầu thoải mái.\n\nMàu đất và tông màu xanh nước biển lấy cảm hứng từ bầu trời đêm trong vắt tạo nên sự đa dạng cho nhiều loại áo khoác dã chiến, áo khoác dạ, áo khoác dạ và áo len của quân đội hay họa tiết đậm có nguồn gốc từ Liberty London.\n\nCác loại vải kỹ thuật tiên tiến, bao gồm GORE-TEX INFINIUM, Pliantex và polyester tăng độ bóng dễ nhận biết. Một số loại giày bao gồm từ giày thể thao vải chống thấm nước đến giày bốt da của Ý, tất cả đều lý tưởng để xếp chồng những đường cắt ống quần Dweller mới hoặc hoàn thiện outfit với quần short và tất rộng.", "./Views/images/news_3.jpg", "BST SS21 từ Nonnative brand sử dụng những gam màu cơ bản cùng thiết kế đơn giản dễ dàng mix…"),
(3, 1, "Retro", "2022/06/17", "Giày Ananas chiến binh thầm lặng", "Giày Ananas là một trong những local brand về giày đang được giới trẻ quan tâm trong thời gian gần đây.Chúng ta cùng đi tìm hiểu về xuất xứ của thương hiệu giày nổi tiếng này, xem nó có phải là thương hiệu chuẩn Local Brand Việt Nam hay không?\n\n\n<h6>Cái tên Ananas</h6>\nAnanas là một thương hiệu có đăng kí tại Việt Nam, và đồng thời cũng có nhà máy sản xuất trực tiếp trong nước. Mặc dù là một thương hiệu đã tồn tại từ 2012 nhưng Ananas chỉ mới được biết đến gần đây bằng chính những nỗ lực cố gắng vươn lên không ngừng nghỉ của mình khi liên tục cho ra mắt những sản phẩm bắt nhịp xu hướng và sáng tạo hơn..\n\nKhông chỉ có vậy, thương hiệu này còn được các bạn trẻ lựa chọn mua sắm vì các sản phẩm đều sở hữu mức giá mềm, phù hợp với mọi tầng lớp cũng như các hoạt động.\n\nMặc dù là một thương hiệu mới, nhưng tính cho đến thời điểm hiện tại, Ananas  Việt Nam đã sở hữu rất nhiều store tại TP. HCM. Thương hiệu giày thời trang này vẫn đang tiếp tục mở rộng và phát triển chuỗi cửa hàng trên toàn quốc, để đông đảo người tiêu dùng có thể biết đến sản phẩm của thương hiệu này.\n\n<h6>Giày Sneaker Ananas</h6>\nMột trong những dòng sản phẩm nổi bật của Ananas phải kể đến dòng Sneaker đang hot hit trên thị trường hiện nay. Những đôi giày Sneaker dây buộc khá linh hoạt, thuận tiện cho người sử dụng. Ngoài ra, đế giày được thiết kế không dày như những sản phẩm của thương hiệu khác, khiến cho bạn cảm thấy gọn nhẹ hơn. Lớp lót giày cũng được thiết kế êm ái, đem lại cho bạn cảm giác thoải mái khi sử dụng sản phẩm.\n\nKhông chỉ có vậy, những đôi giày Sneaker được thiết kế đa dạng về mẫu mã cũng như màu sắc mà còn sở hữu mức giá khá hấp dẫn. Vì vậy, bạn sẽ không phải chi quá nhiều tiền cho niềm đam mê giày sneaker của mình, khi sắm cho mình một đôi hiệu Ananas đâu nhé!","./Views/images/news_5.jpg", "Giày Ananas là một trong những local brand về giày đang được giới trẻ quan tâm trong thời gian gần…"),
(4, 1, "Retro", "2022/06/17", "Giày Ananas chiến binh thầm lặng", "Giày Ananas là một trong những local brand về giày đang được giới trẻ quan tâm trong thời gian gần đây.Chúng ta cùng đi tìm hiểu về xuất xứ của thương hiệu giày nổi tiếng này, xem nó có phải là thương hiệu chuẩn Local Brand Việt Nam hay không?\n\n\n<h6>Cái tên Ananas</h6>\nAnanas là một thương hiệu có đăng kí tại Việt Nam, và đồng thời cũng có nhà máy sản xuất trực tiếp trong nước. Mặc dù là một thương hiệu đã tồn tại từ 2012 nhưng Ananas chỉ mới được biết đến gần đây bằng chính những nỗ lực cố gắng vươn lên không ngừng nghỉ của mình khi liên tục cho ra mắt những sản phẩm bắt nhịp xu hướng và sáng tạo hơn..\n\nKhông chỉ có vậy, thương hiệu này còn được các bạn trẻ lựa chọn mua sắm vì các sản phẩm đều sở hữu mức giá mềm, phù hợp với mọi tầng lớp cũng như các hoạt động.\n\nMặc dù là một thương hiệu mới, nhưng tính cho đến thời điểm hiện tại, Ananas  Việt Nam đã sở hữu rất nhiều store tại TP. HCM. Thương hiệu giày thời trang này vẫn đang tiếp tục mở rộng và phát triển chuỗi cửa hàng trên toàn quốc, để đông đảo người tiêu dùng có thể biết đến sản phẩm của thương hiệu này.\n\n<h6>Giày Sneaker Ananas</h6>\nMột trong những dòng sản phẩm nổi bật của Ananas phải kể đến dòng Sneaker đang hot hit trên thị trường hiện nay. Những đôi giày Sneaker dây buộc khá linh hoạt, thuận tiện cho người sử dụng. Ngoài ra, đế giày được thiết kế không dày như những sản phẩm của thương hiệu khác, khiến cho bạn cảm thấy gọn nhẹ hơn. Lớp lót giày cũng được thiết kế êm ái, đem lại cho bạn cảm giác thoải mái khi sử dụng sản phẩm.\n\nKhông chỉ có vậy, những đôi giày Sneaker được thiết kế đa dạng về mẫu mã cũng như màu sắc mà còn sở hữu mức giá khá hấp dẫn. Vì vậy, bạn sẽ không phải chi quá nhiều tiền cho niềm đam mê giày sneaker của mình, khi sắm cho mình một đôi hiệu Ananas đâu nhé!","./Views/images/news_5.jpg", "Giày Ananas là một trong những local brand về giày đang được giới trẻ quan tâm trong thời gian gần…"),
(5, 1, "Coolmate", "2022/06/16", "Review của BP-Guide về trải nghiệm mua sắm tại Coolmate", 'Trên thị trường Việt Nam đã tồn tại rất nhiều website thời trang online uy tín dành cho nữ giới, tuy nhiên mảng thời trang nam dường như vẫn còn đang bỏ ngỏ. Nắm bắt được nhu cầu mua sắm thời trang online của phái mạnh, Coolmate đã ra đời để cung cấp cho cánh mày râu những sản phẩm chất lượng với một phong cách mua sắm tiện lợi và an tâm nhất. Mời bạn cùng Bp-guide theo dõi câu chuyện kinh doanh thú vị của doanh nghiệp này qua bài phỏng vấn dưới đây nhé! \n\n\n <h5 class="text-warning">"Cool" + "Mate" = người bạn Coolmate trẻ trung năng động</h5> \nThị trường thương mại điện tử Việt Nam không có quá nhiều lựa chọn chuyên sâu cho nam giới, điều đó đồng nghĩa với việc nam giới Việt Nam vẫn đang có những nhu cầu mong muốn được đáp ứng. Hiểu được tâm lý đó, thương hiệu Coolmate ra đời với mục đích đem đến cho khách hàng thêm một lựa chọn tuyệt vời để việc mua sắm những món đồ mặc thật tiện lợi và an tâm. Coolmate mong muốn mang lại cho khách hàng sự tự tin và thoải mái với những sản phẩm chất lượng và trải nghiệm mua sắm hài lòng.\n\n <div class=\"w-75 mx-auto mt-3 mb-5\"><img src="https://ds393qgzrxwzn.cloudfront.net/resize/m720x480/cat1/img/images/0/uL9IkDIY9V.jpg" class=\"rounded img-fluid\"> </div><h5 class="text-warning">Thương hiệu ra đời nhờ sự thấu hiểu tâm lý khách hàng</h5>\nBao giờ cũng vậy, những bước đầu tiên của hành trình kinh doanh luôn chất đầy sự khó khăn, vất vả. Tuy nhiên, bằng sự nỗ lực học hỏi và không ngừng tiến về phía trước cùng tinh thần đoàn kết, đồng lòng của đội ngũ nhân sự, Coolmate đã cố gắng hết sức để mang đến cho người tiêu dùng những sản phẩm tốt nhất cũng như tiếp tục kiên trì đưa doanh nghiệp vượt qua khoảng thời gian nhiều thử thách. Sự nghiêm túc và tận tâm với công việc của mình đã khiến Coolmate đạt được thành quả như ngày hôm nay với sự yêu mến, tin tưởng và nhiều phản hồi tích cực của khách hàng. Vậy nên chẳng có lý do gì mà chúng ta lại không nhiệt tình đón nhận những sản phẩm chất lượng của Coolmate đúng không nào?<div class=\"w-75 mx-auto mt-3 mb-5\"><img src="	https://mcdn.coolmate.me/image/February2021/DSC09632.jpg" class=\"rounded img-fluid\"> </div><h5 class="text-warning">Chất liệu vải độc đáo và quy trình sản xuất tiêu chuẩn của Coolmate</h5>\nQuy trình sản xuất của Coolmate sẽ đi từ sợi. Mặc dù biết rằng quần sịp chất liệu cotton sẽ khiến người mặc thoải mái, dễ chịu nhưng khi có thông tin về chất liệu bamboo, modal mát hơn, thấm hút mồ hôi tốt hơn... thì Coolmate sẽ đi tìm nhà cung cấp về sợi, về vải để đặt hàng loại vải đáp ứng được những tính năng mà khách hàng mong muốn, mặc như không mặc, mặc vào sẽ thoáng mát, không bị những vết hằn... Nói cách khác, Coolmate luôn lắng nghe mong muốn của khách hàng để từ đó tìm nguồn sợi và vải phù hợp. Sau đó, chính các thành viên của Coolmate sẽ là người mặc thử để trải nghiệm sản phẩm, đóng góp ý kiến để hoàn thiện sản phẩm mẫu trước khi đưa vào sản xuất đại trà. Chính vì vậy, hầu như mọi sản phẩm của Coolmate đều có sự hoàn thiện về chất lượng trước khi đến tay khách hàng.\n\nKhông chỉ tập trung vào việc phát triển kinh doanh, thương hiệu Coolmate còn mong muốn đóng góp cho xã hội bằng những hành động thiện nguyện vô cùng thiết thực, thể hiện cái tâm và tinh thần trách nhiệm của đội ngũ nhân sự đối với cộng đồng - đây quả thực là điều vô cùng đáng hoan nghênh và trân trọng.',"./Views/images/news_8.jpg", "Coolmate - Website mua sắm online của cánh mày râu thời hiện đại"),
(6, 1, "Sneaker", "2022/06/16", "Top 03 màu giày sneaker phối đồ cực đỉnh cho nam", " Trong những đôi giày thường xuyên xuất hiện trong các outfit của các chàng trai thì không thể nào không nhắc đến sneaker - đôi giày với sự thoải mái tuyệt đối cùng với sự dễ dàng trong phong cách phối đồ. Chính vì vậy mà trong bài viết này, Coolmate sẽ hướng dẫn các bạn top 05 màu giày sneaker cực đỉnh để phối đồ cho nam nhé. Chiến thôi nào! \n\n\n <h6>1. Màu đen cá tính </h6>\nMột gam màu giày sneaker được lựa chọn rất nhiều vì sự phổ biến cũng như không có dấu hiệu lỗi thời, màu đen luôn là sự lựa chọn hàng đầu của nam giới đối với bất kỳ outfit nào. Một chiếc quần jeans xanh kết hợp với áo thun trắng sẽ rất thích hợp với giày sneaker đen. Nếu bạn chưa biết thì một trong những lợi thế lớn nhất của màu giày sneaker đen đó là làm “nổi bần bật” những gam màu khác đấy. \n\nNgoài ra, bạn nên tận dụng sắc đen của sneaker để chọn những đôi giày cho mục đích tập luyện thể thao, đặc biệt là đối với môi trường có nhiều nước hoặc bùn đất vì đôi giày sẽ không bị lấm lem quá mức cũng như biến đổi màu sắc. Những trang phục đi kèm hợp lý sẽ là áo hoodie, áo khoác da, quần short và quần kaki. Bên cạnh đó, khéo léo phối hợp thêm những phụ kiện như đồng hồ, dây chuyền hay mũ lưỡi trai sẽ giúp tăng phần “ngầu lòi”.\n\n <h6>2. Màu trắng thuần khiết</h6>\nKhông cần phải bàn về màu trắng khi đây không chỉ là một phối màu giày sneaker rất được ưa chuộng mà còn là một màu sắc biểu tượng của ngành thời trang. Nếu lựa chọn những đôi giày sneaker có màu trắng, hãy lưu ý rằng outfit của bạn phải có một màu sắc nổi bật hoặc trái màu để tạo nên sự kết hợp hoàn hảo nhất chứ đừng chọn những chiếc áo hoặc quần màu trắng luôn nhé, nó sẽ khiến cho tổng thể bị chìm đấy. \n\nNgoài ra, màu giày sneaker này sẽ phù hợp với những phong cách công sở hoặc đi bộ nhẹ nhàng hơn là những lúc cần vận động nhiều vì màu trắng sẽ rất dễ bám màu và rất khó để tẩy rửa. Ngoài ra, tình hình thời tiết cũng góp một vai trò rất lớn đến quyết định sở hữu một đôi giày sneaker màu trắng, do đó hãy lưu ý vấn đề này để không chọn sai bạn nhé. \n\n<h6>3. Màu đỏ chất chơi </h6>\nNghe đến màu giày sneaker này là bạn đã cảm giác \'rực lửa\' rồi phải không nào? Đúng như vậy, một đôi sneaker màu đỏ sẽ giúp bạn trở nên cực kỳ nổi bật ở bất kỳ nơi nào bạn đến, tuy nhiên, làm thế nào để kết hợp một cách hài hoà bộ trang phục của bạn với màu sắc này? Rất đơn giản, hãy ghi nhớ nguyên tắc này nhé: \n\nVì màu đỏ rất thu hút sự chú ý, do đó mà hãy khéo léo diện những trang phục màu đen hoặc trắng để tôn lên sự hiện diện của đôi giày sneaker vì đây sẽ là điểm nhấn chính của bạn\n\nThường thì bạn sẽ thấy màu đỏ hay đi kèm màu xanh lá trong những dịp Giáng sinh, thế nhưng sự kết hợp này ở ngoài đời sẽ khiến người đối diện bạn cảm thấy rối mắt, vì vậy hãy hạn chế hoặc không nên diện những trang phục màu xanh lá để đi kèm với màu giày sneaker đỏ\n\nTốt nhất không nên sử dụng gam màu này trong môi trường công sở hoặc những nơi yêu cầu sự nghiêm túc vì màu giày sneaker này hoàn toàn không phù hợp\n\n<h5>Tổng kết</h5>\nTrên đây là top 05 màu giày sneaker để phối đồ cực đỉnh cho nam và những tips chọn giày sneaker tùy theo nhu cầu của các chàng trai. Hãy tham khảo kỹ tủ đồ của mình để chọn được một đôi giày phù hợp với bản thân nhất.","./Views/images/news_6.jpg", "Giày sneaker vốn đã không còn quá xa lạ với những tín đồ yêu mến thời trang. Thế nhưng bạn đã biết đến những màu giày sneaker phối màu cực đỉnh cho nam chưa?");


INSERT INTO `comment_news`(`comment_news`.`ID`, `comment_news`.`NID`, `comment_news`.`CID`, `comment_news`.`CONTENT`, `comment_news`.`TIME`) VALUES
(1, 1, 1, "Bài viết tuyệt vời!", "2021-10-20");

-- message
INSERT INTO `message` (`message`.`FNAME`, `message`.`EMAIL`, `message`.`PHONE`, `message`.`SUBJECT`, `message`.`CONTENT`) VALUES
("Nguyễn Minh Vũ", "nguyenminhvu591@gmail.com", "0968830591", "last test", "Sản phẩm rất đẹp <3");
