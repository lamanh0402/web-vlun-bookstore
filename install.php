<?php
/**
 * install.php
 * Project: bookstore 
 * Aug 1, 2014 
 * @author khoidv1
 */
#detroy cookie and session
session_start();
if(isset($_SESSION['account'])){
    session_destroy();
}
if (isset($_COOKIE['account']))
    setcookie('account', '', time() - 3600);
require_once 'config.php';
require_once 'model/database.php';
$conn = db_connect();
#drop tables
echo "#############################DROP TABLE#############################<br/>";
$tables = array("comments", "users", "books");
foreach ($tables as $value) {
    $sql = "DROP TABLE IF EXISTS `{$value}`;";
    $status = (mysql_query($sql, $conn)) ? "OK" : "NOK";
    echo "Drop table `{$value}`........................{$status}<br />";
}
echo "<br/>";
echo "#############################CREATE TABLE#############################<br/>";

#Table structure for table `books`
$sql = <<<EOD
CREATE TABLE IF NOT EXISTS `books` (
  `bookid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8_unicode_ci,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`bookid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;
EOD;
$status = (mysql_query($sql, $conn)) ? "OK" : "NOK";
echo "Create table `books`........................{$status}<br />";

##insert data table `books`
$sql = <<<EOD
INSERT INTO `books` (`bookid`, `title`, `price`, `description`, `image`) VALUES
(5, 'Truyện Ngắn Nam Cao', 72000, 'Nam Cao (1917-1951) là nhà văn thuộc dòng văn học hiện thực phê phán. Các tác phẩm của Nam Cao đã đặt được nhiều vấn đề sâu sắc, quy tụ được nhiều giá trị của thời đại, khai thác được nhiều tài liệu của thế kỷ văn minh và man dại, nhân hậu và tàn nhẫn, nhiều công lao và cũng lắm lầm lỗi. Qua những tác phẩm ở cả hai thời kỳ trước và sau cách mạng Nam Cao đã đặt vấn đề nông dân một cách sâu sắc. Có lẽ chưa có một ngòi bút nào lại biết khơi dậy và miêu tả đến đáy sự đau khổ của những kiếp người đang mất dần nhân tính, và luôn khát khao được sống, được quyền làm người. Nam Cao đã có những đóng góp quan trọng cho nghệ thuật sáng tạo của chủ nghĩa hiện thực, như khả năng miêu tả và tạo dựng hoàn cảnh, nghệ thuật phân tích tâm lý...', 'ebb574e70c28dfcb25bd0fa496db903ftruyenngannamcao.jpg'),
(6, 'Truyện Trạng Lợn & Truyện Xiển Bột', 17500, 'Trạng Lợn, Xiển Bột là những nhân vật chính trong hệ thống truyện cười dân gian đặc sắc của Việt Nam.\r\n\r\nNhững nhân vật sáng tạo ra tiếng cười là đại diện cho khát vọng tư tưởng của nhân dân. Vua chúa, quan lại, sau tiếng cười hả hê ở cuối truyện, hiện lên là những kẻ mất nhân cách, dốt nát, xảo quyệt, gian tham, tàn ác, vào luồn ra cúi. Những thói hư tật xấu của của con người cũng được mang ra chế giễu, cười cợt. Bên cạnh tiếng cười đả kích còn có tiếng cười dí dỏm nhẹ nhàng khi tự trào, khi đùa cợt, chế giễu bạn bè, người thân.\r\n\r\nHệ thống truyện Trạng Lợn, Xiển Bột là một bức tranh châm biếm đả kích sắc sảo, chân thực xã hội phong kiến. Những nhân vật này đã thay mặt nhân dân lao động làm một cuộc "khởi nghĩa" bằng tiếng cười để từ giã chế độ phong kiến suy tàn một cách hài hước nhất.', 'da31c5e8c0698587f3a4d43bdbef8a68P58677Mbt.jpg'),
(7, 'Truyện Ngắn Hay', 40000, 'Truyện Ngắn Hay 2010 - 2011 là tập 16 truyện ngắn của 16 tác giả, 16 phong cách khác nhau. Dù là câu chuyện về một tình yêu đằm thắm và vị tha kết tinh từ một cuộc sống chật vật với cơm áo gạo tiền, dù là những ký ức cả đẹp cả buồn về những người đồng đội thời cùng vào sinh ra tử, hay thậm chí là một sự phơi bày những hiện thực gây phẫn uất và làm đau lòng của cuộc sống... tất cả đều được viết bởi những câu chữ nuột nà nhưng ấm áp, tứ văn sắc sảo nhưng dung dị với những cái kết đầy tính nhân văn, có hậu nhưng không khuôn sáo.\r\n\r\nNgười đọc gặp ở đây những tác giả, có thể đã rất quen: Ma Văn Kháng, Nguyễn Thị Thu Huệ, Tâm An, Đỗ Tiến Thụy, Đỗ Thị Hồng Vân...cả những người chưa quen tên lắm.Thế nhưng, theo đánh giá của những người tuyển chọn, với những truyện ngắn này, họ đều đã dâng cho bạn đọc những bông hoa đẹp mà họ đã ươm mầm, vun trồng và cắt tỉa.', 'f7d96f63c7420936487efacf8494841cP58584Mbt.jpg'),
(8, 'Truyện Trạng Quỳnh', 30000, 'Tiếng cười nảy sinh từ những trò nghịch ngợm, chọc ngoáy của Quỳnh với những điều trái tai gai mắt trong xã hội. Mà đối tượng chủ yếu để Quỳnh đem ra làm trò ấy là bọn quan lại, vua chúa, những kẻ thống trị trong xã hội với những thói tham lam, nịnh thần hay thậm chí Trạng còn khinh miệt cái chế độ trường quy thời đó, nên mấy lần đi thi mà cố làm cho mình trượt. Trạng còn giễu cợt cả những nhân vật linh thiêng cấm kị của làng xã. Đó là tiếng nói bài trừ mê tín dị đoan. Có điều lạ là trong những truyện kiểu ấy, những nhân vật bà chúa Liễu hay tượng thần tượng thánh đều hiện lên như những con người với thói tham lam và dục vọng như một con người bình thường. Chỉ khác là họ là những người thống trị về mặt tinh thần, nhưng rốt cuộc đều bị Trạng hạ bệ, giải thiêng và trở nên tầm thường.\r\n\r\nTrạng còn nổi tiếng với những câu chuyện đối đáp thông minh với sứ thần Trung Quốc hay với cả triều đình phương Bắc, thể hiện một tinh thần yêu nước, tự chủ đáng tự hào.Có thể nói, Trạng Quỳnh chính là một nhân vật trí thức được người dân gửi gắm khát vọng về trí tuệ khôn ngoan và cái tâm với quần chúng nhân dân.', 'b6c8bee0cc72f2a8ebef7b39d4a6a3eaP58047Mxx611.jpg'),
(9, 'Truyện Tiếu Lâm Việt Nam', 17000, 'Truyện Tiếu Lâm Việt Nam là tập hợp những truyện cười đặc sắc trong kho tàng dân gian đã được truyền miệng từ bao đời nay. Cuốn sách tấu lên biết bao cung bậc cười, cái cười đến từ khắp các ngóc ngách của đời sống xã hội Việt Nam xưa.\r\n\r\nTừng trang sách ém những nụ cười vui tươi, ý vị, chỉ chờ bạn đọc lật tới là bung nở từ giọng hì, giọng hĩ đến giọng hi ha...', '1b57c1355992871b50413d93a66f7111P57909Mxx852.jpg'),
(10, 'Thám Tử Lừng Danh Conan - Tập 81', 14000, 'Giữa lúc cuộc điều tra vụ án kẻ móc túi thuộc băng Kurobee đang diễn ra, những hồi ức về Akai chợt hiện lên sống động trong tâm trí Jodie... Ẩn sau vụ án, hoạt động bí mật gì đang được thực hiện!? Cũng trong tập này, mời các bạn cùng khám phá vụ án cây phi tiêu cứng với sự trở lại của thám tử Kogoro sau một thời gian vắng bóng, vụ điều tra ngoại tình dần làm sáng tỏ bí mật của Sera, và vụ án chết đuối trong nhà vệ sinh di động dẫn tới cuộc chạm trán giữa Sera và Kyogoku nhé!!', '21de1f9513395aaa70baa3961a587e39P58878Mconan___81.jpg'),
(11, 'Thám Tử Lừng Danh Conan - Tập 78', 17000, 'Hình ảnh Haibara trong bộ dạng người lớn sau khi uống thuốc giải độc đã bị ghi lại!? Conan, Haibara, Bourbon, và các thành viên của tổ chức Áo Đen... đã lần theo từng dấu vết và tới được ga cuối của sự thật...!!\r\n\r\nTrong tập truyện này, bên cạnh vụ án mạng trên tàu tốc hành Bell Tree gây xôn xao dư luận toàn Nhật Bản, các bạn cũng sẽ được theo dõi vụ án về chiếc chìa khóa của căn phòng kín biến mất, và vụ án Xích Diện Nhân Ngư!!', 'fb9836e77007d9bace48f91a3c6a5d2153871.jpg'),
(12, 'Doraemon - Tâp 3', 16000, 'Một chú mèo máy sinh ngày 3 tháng 9 năm 2112. Đôrêmon đã cưỡi cỗ máy thời gian đi ngược từ thế kỷ 22 về thế kỷ 20 để làm bạn với Nôbita. Chiếc túi 4 chiều trước bụng Đôrêmon chứa đủ loại bảo bối thần kỳ, có thể cứu nguy cho Nôbita mỗi khi cậu bạn hậu đậu này gặp rắc rối.\r\nMời bạn đón đọc.', 'a44517e33d693cb1eba1719ae842033054814.jpg'),
(13, 'Doraemon - Tập 20', 19000, 'Một chú mèo máy sinh ngày 3 tháng 9 năm 2112. Đôrêmon đã cưỡi cỗ máy thời gian đi ngược từ thế kỷ 22 về thế kỷ 20 để làm bạn với Nôbita. Chiếc túi 4 chiều trước bụng Đôrêmon chứa đủ loại bảo bối thần kỳ, có thể cứu nguy cho Nôbita mỗi khi cậu bạn hậu đậu này gặp rắc rối.', '76cb271f21970d8b1795babd26c09cb652846.jpg'),
(14, 'Doraemon  - Tập 26', 19000, 'Một chú mèo máy sinh ngày 3 tháng 9 năm 2112. Đôrêmon đã cưỡi cỗ máy thời gian đi ngược từ thế kỷ 22 về thế kỷ 20 để làm bạn với Nôbita. Chiếc túi 4 chiều trước bụng Đôrêmon chứa đủ loại bảo bối thần kỳ, có thể cứu nguy cho Nôbita mỗi khi cậu bạn hậu đậu này gặp rắc rối.', '50361cf892f05b602e6bf48129b9be4852847.jpg'),
(15, 'Hành Trình Về Phương Đông', 243000, 'Baird T. Spalding, cái tên đã trở thành huyền thoại trong giới lý thuyết siêu hình và chân lý trong suốt nửa đầu thế kỷ 20, đóng một vai trò quan trọng trong việc giới thiệu với thế giới phương Tây rằng có những bậc Chân sư, hay những người anh cả, đã trợ giúp và định hướng cho số phận của nhân loại. Có rất nhiều người trên khắp thế giới đã gửi thư đến trong nhiều năm qua để chứng thực sự giúp đỡ lớn lao mà họ nhận được từ những thông điệp mà họ nhận được trong các tập sách này.\r\n\r\nNhững miêu tả của Baird T. Spalding về những chuyến đi đến vùng Viễn Đông đóng một vai trò quan trọng trong việc giới thiệu đến thế giới phương Tây rằng, có những bậc Chân sư đang trợ giúp và dẫn dắt vận mệnh của nhân loại.\r\n\r\nNhững cuộc gặp gỡ giữa ông và các bậc Chân sư đã đem đến một sự bộc lộ ấn tượng về những giáo lý tâm linh và những sự kiện quan trọng chưa từng có trong văn học phương Tây.\r\n\r\n"Không có gì phải nghi ngờ, những con người này đã mang đến Ánh sáng trong suốt nhiều thời kỳ, bằng cuộc sống thường ngày và những tác phẩm của mình, họ đã chứng minh rằng Ánh sáng này thật sự tồn tại và nó đã tồn tại cách đây hàng ngàn năm trước." ', '3d18d3348de9601b628af8631b3537c5P59091Mbia_truoc.jpg'),
(16, 'Đắc Nhân Tâm', 54000, 'Đắc nhân tâm – How to win friends and Influence People của Dale Carnegie là quyển sách nổi tiếng nhất, bán chạy nhất và có tầm ảnh hưởng nhất của mọi thời đại. Tác phẩm đã được chuyển ngữ sang hầu hết các thứ tiếng trên thế giới và có mặt ở hàng trăm quốc gia. Đây là quyển sách duy nhất về thể loại self-help liên tục đứng đầu danh mục sách bán chạy nhất (best-selling Books) do báo The New York Times bình chọn suốt 10 năm liền. Riêng bản tiếng Anh của sách đã bán được hơn 15 triệu bản trên thế giới. Tác phẩm có sức lan toả vô cùng rộng lớn – dù bạn đi đến bất cứ đâu, bất kỳ quốc gia nào cũng đều có thể nhìn thấy. Tác phẩm được đánh giá là quyển sách đầu tiên và hay nhất, có ảnh hưởng làm thay đổi cuộc đời của hàng triệu người trên thế giới.\r\n\r\nKhông còn nữa khái niệm giới hạn Đắc Nhân Tâm là nghệ thuật thu phục lòng người, là làm cho tất cả mọi người yêu mến mình. Đắc nhân tâm và cái Tài trong mỗi người chúng ta. Đắc Nhân Tâm trong ý nghĩa đó cần được thụ đắc bằng sự hiểu rõ bản thân, thành thật với chính mình, hiểu biết và quan tâm đến những người xung quanh để nhìn ra và khơi gợi những tiềm năng ẩn khuất nơi họ, giúp họ phát triển lên một tầm cao mới. Đây chính là nghệ thuật cao nhất về con người và chính là ý nghĩa sâu sắc nhất đúc kết từ những nguyên tắc vàng của Dale Carnegie.\r\n\r\nQuyển sách Đắc nhân tâm “Đầu tiên và hay nhất mọi thời đại về nghệ thuật giao tiếp và ứng xử”, quyển sách đã từng mang đến thành công và hạnh phúc cho hàng triệu người trên khắp thế giới.', '3f27c84c5793d5eec3a3f895e2b8f465P29988M30159.png');
EOD;
$status = (mysql_query($sql, $conn)) ? "OK" : "NOK";
echo "Insert table `books`........................{$status}<br />";


#Table structure for table `comments`
$sql = <<<EOD
CREATE TABLE IF NOT EXISTS `comments` (
  `commentid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `bookid` int(11) NOT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`commentid`),
  KEY `fk_comments_books_idx` (`bookid`),
  KEY `fk_comments_users_idx` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
EOD;
$status = (mysql_query($sql, $conn)) ? "OK" : "NOK";
echo "Create table `comments`........................{$status}<br />";

#Table structure for table `users`
$sql = <<<EOD
CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fullname` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `isadmin` tinyint(1) NOT NULL DEFAULT '0',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
EOD;
$status = (mysql_query($sql, $conn)) ? "OK" : "NOK";
echo "Create table `users`........................{$status}<br />";

echo "<br/>";
echo "#############################INSERT TABLE#############################<br/>";
#Dumping data for table `users`
$sql = <<<EOD
INSERT INTO `users` (`username`, `password`, `email`, `fullname`, `avatar`, `isadmin`, `time`) VALUES
('admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin@sach.vn', 'BookStore Admin', NULL, 1, '2014-08-01 10:17:35');
EOD;
$status = (mysql_query($sql, $conn)) ? "OK" : "NOK";
echo "Insert table `users`........................{$status}<br />";

echo "<br/>";
echo "#############################OTHER#############################<br/>";
#Constraints for table `comments`
$sql = <<<EOD
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_books` FOREIGN KEY (`bookid`) REFERENCES `books` (`bookid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comments_users` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION;
EOD;
$status = (mysql_query($sql, $conn)) ? "OK" : "NOK";
echo "Alter table `comments`........................{$status}<br />";

db_closed($conn);
?>
<a href="index.php">Click here!</a>
