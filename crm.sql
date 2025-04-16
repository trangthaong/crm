-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 16, 2025 lúc 11:05 AM
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
-- Cơ sở dữ liệu: `crm`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(512) NOT NULL,
  `type` varchar(128) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `project_title` varchar(1024) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `task_title` varchar(1024) DEFAULT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  `file_name` varchar(1024) DEFAULT NULL,
  `milestone_id` int(11) DEFAULT NULL,
  `milestone` varchar(1024) DEFAULT NULL,
  `activity` varchar(28) NOT NULL,
  `message` varchar(1024) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `allowance`
--

CREATE TABLE `allowance` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `name` varchar(512) NOT NULL,
  `amount` double NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(256) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `pinned` tinyint(4) NOT NULL DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `title` text NOT NULL,
  `description` longtext NOT NULL,
  `slug` mediumtext NOT NULL,
  `date_published` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `article_group`
--

CREATE TABLE `article_group` (
  `id` int(11) NOT NULL,
  `title` mediumtext NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `campaigns`
--

CREATE TABLE `campaigns` (
  `Machiendich` varchar(50) NOT NULL,
  `Nguoitao` varchar(100) DEFAULT NULL,
  `Trangthai` varchar(50) DEFAULT NULL,
  `Tenchiendich` varchar(100) DEFAULT NULL,
  `Mucdich` enum('Xúc tiến kinh doanh bên ngoài','Hội nghị khách hàng','Chương trình thi đua','Chương trình khuyến mại','Chiến dịch bán hàng','Quảng cáo sản phẩm','Phát triển khách hàng') DEFAULT NULL,
  `Hinhthuc` enum('Gặp trực tiếp','Gọi điện','Hội thảo','Roadshow') DEFAULT NULL,
  `Doituongkhach_hang` enum('KHCN') DEFAULT NULL,
  `Khoi` enum('Khách hàng cá nhân') DEFAULT NULL,
  `Kenhban` enum('APP CHAT') DEFAULT NULL,
  `LoaiSP` varchar(100) DEFAULT NULL,
  `Quytrinh` enum('Quy trình bán') DEFAULT NULL,
  `Nguondulieu` enum('Chiến dịch từ HO','Chiến dịch từ chi nhánh','App MB/Fanpage','Telesale','247','Referral','Khác') DEFAULT NULL,
  `Ngaybd` date DEFAULT NULL,
  `Ngaykt` date DEFAULT NULL,
  `Quymo` enum('Toàn hàng','Vùng miền') DEFAULT NULL,
  `Anh` varchar(255) DEFAULT NULL,
  `ND` varchar(255) DEFAULT NULL,
  `ChoRMthemKH` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `campaigns`
--

INSERT INTO `campaigns` (`Machiendich`, `Nguoitao`, `Trangthai`, `Tenchiendich`, `Mucdich`, `Hinhthuc`, `Doituongkhach_hang`, `Khoi`, `Kenhban`, `LoaiSP`, `Quytrinh`, `Nguondulieu`, `Ngaybd`, `Ngaykt`, `Quymo`, `Anh`, `ND`, `ChoRMthemKH`) VALUES
('CD001', 'RM001', 'Đã kích hoạt', 'Chiến dịch bán hàng tháng 1', 'Xúc tiến kinh doanh bên ngoài', 'Gặp trực tiếp', 'KHCN', 'Khách hàng cá nhân', 'APP CHAT', 'Bảo lãnh', 'Quy trình bán', 'Chiến dịch từ HO', '2025-04-01', '2025-04-30', 'Toàn hàng', 'image1.jpg', 'Nội dung chiến dịch 1', 1),
('CD002', 'RM002', 'Đang soạn thảo', 'Hội nghị khách hàng miền Bắc', 'Hội nghị khách hàng', 'Hội thảo', 'KHCN', 'Khách hàng cá nhân', 'APP CHAT', 'Tiết kiệm', 'Quy trình bán', 'Telesale', '2025-03-10', '2025-03-12', 'Vùng miền', 'image2.jpg', 'Nội dung chiến dịch 2', 0),
('CD003', 'RM003', 'Đã kết thúc', 'Chương trình khuyến mại tháng 4', 'Chương trình khuyến mại', 'Roadshow', 'KHCN', 'Khách hàng cá nhân', 'APP CHAT', 'Bảo lãnh', 'Quy trình bán', 'App MB/Fanpage', '2025-04-05', '2025-04-25', 'Toàn hàng', 'image3.jpg', 'Nội dung chiến dịch 3', 1),
('CD004', 'RM004', 'Đã kích hoạt', 'Chương trình thi đua nhân viên', 'Chương trình thi đua', 'Gọi điện', 'KHCN', 'Khách hàng cá nhân', 'APP CHAT', 'Tiết kiệm', 'Quy trình bán', 'Chiến dịch từ chi nhánh', '2025-04-01', '2025-04-15', 'Vùng miền', 'image4.jpg', 'Nội dung chiến dịch 4', 1),
('CD005', 'RM005', 'Đang soạn thảo', 'Quảng cáo sản phẩm mới', 'Quảng cáo sản phẩm', 'Hội thảo', 'KHCN', 'Khách hàng cá nhân', 'APP CHAT', 'Bảo lãnh', 'Quy trình bán', 'Chiến dịch từ HO', '2025-03-20', '2025-03-30', 'Toàn hàng', 'image5.jpg', 'Nội dung chiến dịch 5', 0),
('CD006', 'RM006', 'Đã kết thúc', 'Phát triển khách hàng VIP', 'Phát triển khách hàng', 'Gặp trực tiếp', 'KHCN', 'Khách hàng cá nhân', 'APP CHAT', 'Tiết kiệm', 'Quy trình bán', 'Referral', '2025-04-10', '2025-04-20', 'Vùng miền', 'image6.jpg', 'Nội dung chiến dịch 6', 1),
('CD007', 'RM007', 'Đã kích hoạt', 'Chiến dịch bán hàng online', 'Chiến dịch bán hàng', 'Roadshow', 'KHCN', 'Khách hàng cá nhân', 'APP CHAT', 'Bảo lãnh', 'Quy trình bán', 'Telesale', '2025-03-01', '2025-03-15', 'Toàn hàng', 'image7.jpg', 'Nội dung chiến dịch 7', 1),
('CD008', 'RM008', 'Đang soạn thảo', 'Hội nghị khách hàng miền Nam', 'Hội nghị khách hàng', 'Hội thảo', 'KHCN', 'Khách hàng cá nhân', 'APP CHAT', 'Tiết kiệm', 'Quy trình bán', 'Chiến dịch từ chi nhánh', '2025-04-01', '2025-04-05', 'Vùng miền', 'image8.jpg', 'Nội dung chiến dịch 8', 0),
('CD009', 'RM009', 'Đã kết thúc', 'Chương trình thi đua sản phẩm', 'Chương trình thi đua', 'Gọi điện', 'KHCN', 'Khách hàng cá nhân', 'APP CHAT', 'Bảo lãnh', 'Quy trình bán', 'App MB/Fanpage', '2025-03-15', '2025-03-25', 'Toàn hàng', 'image9.jpg', 'Nội dung chiến dịch 9', 1),
('CD010', 'RM010', 'Đã kích hoạt', 'Chiến dịch khuyến mại mùa hè', 'Chương trình khuyến mại', 'Roadshow', 'KHCN', 'Khách hàng cá nhân', 'APP CHAT', 'Tiết kiệm', 'Quy trình bán', 'Chiến dịch từ HO', '2025-04-10', '2025-04-30', 'Vùng miền', 'image10.jpg', 'Nội dung chiến dịch 10', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cd_khhh`
--

CREATE TABLE `cd_khhh` (
  `MatiepcanKHHH` varchar(50) NOT NULL,
  `Tgiantiepcan` datetime DEFAULT NULL,
  `Machiendich` varchar(50) NOT NULL,
  `MaKHHH` varchar(50) NOT NULL,
  `NgaythemvaoCD` date DEFAULT NULL,
  `Ketquatiepcan` enum('Không liên lạc được','Liên hệ lại','Đồng ý hẹn gặp','Đang chăm sóc','Đang thu thập hồ sơ','Chốt bán','Tạm dừng','Từ chối') DEFAULT NULL,
  `RMtiepcan` varchar(50) DEFAULT NULL,
  `Ghichu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cd_khhh`
--

INSERT INTO `cd_khhh` (`MatiepcanKHHH`, `Tgiantiepcan`, `Machiendich`, `MaKHHH`, `NgaythemvaoCD`, `Ketquatiepcan`, `RMtiepcan`, `Ghichu`) VALUES
('TC-HH001', '2025-04-01 10:00:00', 'CD001', 'KHHH001', '2025-04-01', 'Không liên lạc được', 'RM001', 'Ghi chú 1'),
('TC-HH002', '2025-04-01 11:00:00', 'CD002', 'KHHH002', '2025-04-02', 'Liên hệ lại', 'RM002', 'Ghi chú 2'),
('TC-HH003', '2025-04-01 12:00:00', 'CD003', 'KHHH003', '2025-04-03', 'Đồng ý hẹn gặp', 'RM003', 'Ghi chú 3'),
('TC-HH004', '2025-04-02 14:00:00', 'CD004', 'KHHH004', '2025-04-04', 'Đang chăm sóc', 'RM004', 'Ghi chú 4'),
('TC-HH005', '2025-04-02 15:00:00', 'CD005', 'KHHH005', '2025-04-05', 'Đang thu thập hồ sơ', 'RM005', 'Ghi chú 5'),
('TC-HH006', '2025-04-02 16:00:00', 'CD006', 'KHHH006', '2025-04-06', 'Chốt bán', 'RM006', 'Ghi chú 6'),
('TC-HH007', '2025-04-03 09:00:00', 'CD007', 'KHHH007', '2025-04-07', 'Tạm dừng', 'RM007', 'Ghi chú 7'),
('TC-HH008', '2025-04-03 10:00:00', 'CD008', 'KHHH008', '2025-04-08', 'Từ chối', 'RM008', 'Ghi chú 8'),
('TC-HH009', '2025-04-03 11:00:00', 'CD009', 'KHHH009', '2025-04-09', 'Không liên lạc được', 'RM009', 'Ghi chú 9'),
('TC-HH010', '2025-04-03 12:00:00', 'CD010', 'KHHH010', '2025-04-10', 'Liên hệ lại', 'RM010', 'Ghi chú 10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cd_khtn`
--

CREATE TABLE `cd_khtn` (
  `MatiepcanKHTN` varchar(50) NOT NULL,
  `Tgiantiepcan` datetime DEFAULT NULL,
  `Machiendich` varchar(50) NOT NULL,
  `MaKHTN` varchar(50) NOT NULL,
  `NgaythemvaoCD` date DEFAULT NULL,
  `Ketquatiepcan` enum('Không liên lạc được','Liên hệ lại','Đồng ý hẹn gặp','Đang chăm sóc','Đang thu thập hồ sơ','Chốt bán','Tạm dừng','Từ chối') DEFAULT NULL,
  `RMtiepcan` varchar(50) DEFAULT NULL,
  `Ghichu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cd_khtn`
--

INSERT INTO `cd_khtn` (`MatiepcanKHTN`, `Tgiantiepcan`, `Machiendich`, `MaKHTN`, `NgaythemvaoCD`, `Ketquatiepcan`, `RMtiepcan`, `Ghichu`) VALUES
('TC-TN001', '2025-04-01 10:00:00', 'CD001', 'KHTN001', '2025-04-01', 'Không liên lạc được', 'RM001', 'Ghi chú 1'),
('TC-TN002', '2025-04-01 11:00:00', 'CD002', 'KHTN002', '2025-04-02', 'Liên hệ lại', 'RM002', 'Ghi chú 2'),
('TC-TN003', '2025-04-01 12:00:00', 'CD003', 'KHTN003', '2025-04-03', 'Đồng ý hẹn gặp', 'RM003', 'Ghi chú 3'),
('TC-TN004', '2025-04-02 14:00:00', 'CD004', 'KHTN004', '2025-04-04', 'Đang chăm sóc', 'RM004', 'Ghi chú 4'),
('TC-TN005', '2025-04-02 15:00:00', 'CD005', 'KHTN005', '2025-04-05', 'Đang thu thập hồ sơ', 'RM005', 'Ghi chú 5'),
('TC-TN006', '2025-04-02 16:00:00', 'CD006', 'KHTN006', '2025-04-06', 'Chốt bán', 'RM006', 'Ghi chú 6'),
('TC-TN007', '2025-04-03 09:00:00', 'CD007', 'KHTN007', '2025-04-07', 'Tạm dừng', 'RM007', 'Ghi chú 7'),
('TC-TN008', '2025-04-03 10:00:00', 'CD008', 'KHTN008', '2025-04-08', 'Từ chối', 'RM008', 'Ghi chú 8'),
('TC-TN009', '2025-04-03 11:00:00', 'CD009', 'KHTN009', '2025-04-09', 'Không liên lạc được', 'RM009', 'Ghi chú 9'),
('TC-TN010', '2025-04-03 12:00:00', 'CD010', 'KHTN010', '2025-04-10', 'Liên hệ lại', 'RM010', 'Ghi chú 10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chat_groups`
--

CREATE TABLE `chat_groups` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `no_of_members` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chat_group_members`
--

CREATE TABLE `chat_group_members` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_read` int(11) NOT NULL DEFAULT 1,
  `is_admin` int(11) NOT NULL DEFAULT 0,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chat_media`
--

CREATE TABLE `chat_media` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `original_file_name` text NOT NULL,
  `file_name` text NOT NULL,
  `file_extension` varchar(64) NOT NULL,
  `file_size` varchar(256) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `client`
--

CREATE TABLE `client` (
  `MaKH` varchar(50) NOT NULL,
  `TenKH` varchar(100) NOT NULL,
  `CMT_Hochieu` varchar(20) NOT NULL,
  `Ngaycap` date NOT NULL,
  `Noicap` varchar(100) NOT NULL,
  `Quoctich` varchar(50) NOT NULL,
  `Ngaysinh` date NOT NULL,
  `Diachi` varchar(255) NOT NULL,
  `SDT` varchar(15) NOT NULL,
  `Nghenghiep` int(11) NOT NULL,
  `Thunhap` decimal(10,2) NOT NULL,
  `Trangthai` enum('Active','Inactive','Dormant','Chưa xác định') NOT NULL,
  `Tansuatgiaodich` enum('Chưa phân nhóm','Không hoạt động','Giao dịch ít','Giao dịch thường xuyên','Giao dịch lớn') NOT NULL,
  `RMquanly` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Khoi` enum('Khách hàng cá nhân') NOT NULL,
  `Ngayupload` date NOT NULL,
  `workspace_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `client`
--

INSERT INTO `client` (`MaKH`, `TenKH`, `CMT_Hochieu`, `Ngaycap`, `Noicap`, `Quoctich`, `Ngaysinh`, `Diachi`, `SDT`, `Nghenghiep`, `Thunhap`, `Trangthai`, `Tansuatgiaodich`, `RMquanly`, `Email`, `Khoi`, `Ngayupload`, `workspace_id`) VALUES
('KHHH001', 'Nguyễn Văn A', '123456789', '1985-03-15', 'Hà Nội', 'Việt Nam', '1985-03-15', 'Số 10, Phố ABC, Hà Nội', '0912345678', 0, 15000000.00, 'Active', 'Giao dịch thường xuyên', 'RM001', 'nguyenvana@example.com', 'Khách hàng cá nhân', '2025-04-09', '1'),
('KHHH002', 'Trần Thị B', '987654321', '1990-07-22', 'TP. Hồ Chí Minh', 'Việt Nam', '1990-07-22', 'Số 20, Đường XYZ, TP. Hồ Chí Minh', '0987654321', 0, 12000000.00, 'Inactive', 'Giao dịch ít', 'RM002', 'tranb@example.com', 'Khách hàng cá nhân', '2025-04-09', '1'),
('KHHH003', 'Lê Minh C', '112233445', '1982-12-05', 'Đà Nẵng', 'Việt Nam', '1982-12-05', 'Số 30, Khu vực ABC, Đà Nẵng', '0912233445', 0, 18000000.00, 'Dormant', 'Giao dịch thường xuyên', 'RM003', 'leminhc@example.com', 'Khách hàng cá nhân', '2025-04-09', '1'),
('KHHH004', 'Phạm Thị D', '223344556', '1995-01-01', 'Hải Phòng', 'Việt Nam', '1995-01-01', 'Số 40, Đường DEF, Hải Phòng', '0945678899', 0, 22000000.00, 'Active', 'Giao dịch lớn', 'RM004', 'phamtd@example.com', 'Khách hàng cá nhân', '2025-04-09', '1'),
('KHHH005', 'Ngô Tuấn E', '334455667', '1992-06-11', 'Cần Thơ', 'Việt Nam', '1992-06-11', 'Số 50, Phố GHI, Cần Thơ', '0913344556', 0, 11000000.00, 'Inactive', 'Không hoạt động', 'RM005', 'ngotuan@example.com', 'Khách hàng cá nhân', '2025-04-09', '1'),
('KHHH006', 'Bùi Lan F', '445566778', '1998-09-30', 'Quảng Ninh', 'Việt Nam', '1998-09-30', 'Số 60, Đường HIJ, Quảng Ninh', '0935678901', 0, 25000000.00, 'Chưa xác định', 'Giao dịch ít', 'RM006', 'builan@example.com', 'Khách hàng cá nhân', '2025-04-09', '1'),
('KHHH007', 'Vũ Đức G', '556677889', '1988-03-10', 'Hà Nội', 'Việt Nam', '1988-03-10', 'Số 70, Đường KLM, Hà Nội', '0946789012', 0, 16000000.00, 'Active', 'Giao dịch thường xuyên', 'RM007', 'vuducg@example.com', 'Khách hàng cá nhân', '2025-04-09', '1'),
('KHHH008', 'Đỗ Ngọc H', '667788990', '1993-02-20', 'TP. Hồ Chí Minh', 'Việt Nam', '1993-02-20', 'Số 80, Đường NOP, TP. Hồ Chí Minh', '0977890123', 0, 13000000.00, 'Inactive', 'Giao dịch ít', 'RM008', 'dongoch@example.com', 'Khách hàng cá nhân', '2025-04-09', '1'),
('KHHH009', 'Lương Minh I', '778899001', '1984-08-15', 'Đà Nẵng', 'Việt Nam', '1984-08-15', 'Số 90, Đường QRS, Đà Nẵng', '0912345678', 0, 21000000.00, 'Dormant', 'Giao dịch thường xuyên', 'RM009', 'luongm@example.com', 'Khách hàng cá nhân', '2025-04-09', '1'),
('KHHH010', 'Hoàng Thị J', '889900112', '1991-05-25', 'Hải Phòng', 'Việt Nam', '1991-05-25', 'Số 100, Phố TUV, Hải Phòng', '0923456789', 0, 20000000.00, 'Active', 'Giao dịch lớn', 'RM010', 'hoangtj@example.com', 'Khách hàng cá nhân', '2025-04-09', '1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 1,
  `comment` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contracts`
--

CREATE TABLE `contracts` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `contract_type_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `description` longtext NOT NULL,
  `value` double NOT NULL,
  `provider_first_name` varchar(64) NOT NULL,
  `provider_last_name` varchar(64) NOT NULL,
  `client_first_name` varchar(64) NOT NULL,
  `client_last_name` varchar(64) NOT NULL,
  `provider_sign` text NOT NULL,
  `client_sign` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contracts_type`
--

CREATE TABLE `contracts_type` (
  `id` int(11) NOT NULL,
  `type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `deductions`
--

CREATE TABLE `deductions` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `name` varchar(512) NOT NULL,
  `deduction_type` varchar(512) NOT NULL,
  `percentage` double NOT NULL,
  `amount` double NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `emails`
--

CREATE TABLE `emails` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `to` text NOT NULL,
  `attachments` text DEFAULT NULL,
  `status` varchar(28) DEFAULT NULL,
  `date_sent` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `email_templates`
--

CREATE TABLE `email_templates` (
  `id` int(11) NOT NULL,
  `type` varchar(64) DEFAULT NULL,
  `subject` varchar(1024) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `date_sent` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `estimates`
--

CREATE TABLE `estimates` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `address` varchar(1024) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `state` varchar(128) DEFAULT NULL,
  `country` varchar(128) DEFAULT NULL,
  `zip_code` varchar(28) DEFAULT NULL,
  `contact` varchar(28) DEFAULT NULL,
  `estimate_items_ids` text DEFAULT NULL,
  `note` text DEFAULT NULL,
  `personal_note` text DEFAULT NULL,
  `amount` double NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `estimate_date` datetime DEFAULT NULL,
  `valid_upto_date` datetime DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `estimate_items`
--

CREATE TABLE `estimate_items` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `estimate_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `unit_id` int(11) NOT NULL DEFAULT 0,
  `rate` double NOT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `text_color` varchar(128) NOT NULL,
  `bg_color` varchar(128) NOT NULL,
  `from_date` timestamp NULL DEFAULT NULL,
  `to_date` timestamp NULL DEFAULT NULL,
  `is_public` tinyint(4) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expense_type_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `note` text DEFAULT NULL,
  `amount` double NOT NULL,
  `expense_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `expense_types`
--

CREATE TABLE `expense_types` (
  `id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `favourite_projects`
--

CREATE TABLE `favourite_projects` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  `permissions` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`, `permissions`) VALUES
(1, 'admin', 'Administrator', NULL),
(2, 'members', 'General User', NULL),
(3, 'clients', 'It is used for clients ', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `address` varchar(1024) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `state` varchar(128) DEFAULT NULL,
  `country` varchar(128) DEFAULT NULL,
  `zip_code` varchar(28) DEFAULT NULL,
  `contact` varchar(28) DEFAULT NULL,
  `invoice_items_ids` varchar(256) NOT NULL,
  `note` text DEFAULT NULL,
  `personal_note` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `amount` double NOT NULL,
  `invoice_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `due_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL DEFAULT 0,
  `rate` double NOT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `title` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `language` varchar(64) NOT NULL,
  `code` varchar(8) NOT NULL,
  `is_rtl` int(11) DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `languages`
--

INSERT INTO `languages` (`id`, `language`, `code`, `is_rtl`, `date_created`) VALUES
(1, 'english', 'en', 0, '2020-04-25 07:33:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `leads`
--

CREATE TABLE `leads` (
  `MaKH` varchar(50) NOT NULL,
  `TenKH` varchar(100) NOT NULL,
  `Diachi` varchar(255) DEFAULT NULL,
  `SDT` varchar(15) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Ngaysinh` date DEFAULT NULL,
  `MucdoTN` varchar(50) DEFAULT NULL,
  `Nghenghiep` varchar(100) DEFAULT NULL,
  `Thunhapthang` decimal(10,2) DEFAULT NULL,
  `NguonKH` varchar(100) DEFAULT NULL,
  `MaRM` varchar(50) NOT NULL,
  `workspace_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `leads`
--

INSERT INTO `leads` (`MaKH`, `TenKH`, `Diachi`, `SDT`, `Email`, `Ngaysinh`, `MucdoTN`, `Nghenghiep`, `Thunhapthang`, `NguonKH`, `MaRM`, `workspace_id`) VALUES
('KHTN001', 'Nguyễn Văn A', 'Hà Nội, Việt Nam', '0123456789', 'nguyenvana@example.com', '1990-01-01', 'Cao', 'Kỹ sư', 15000000.00, 'Từ giới thiệu', 'RM001', 1),
('KHTN002', 'Trần Thị B', 'TP. Hồ Chí Minh, Việt Nam', '0987654321', 'tranthib@example.com', '1985-05-10', 'Trung bình', 'Giáo viên', 12000000.00, 'Từ quảng cáo', 'RM002', 1),
('KHTN003', 'Lê Quang C', 'Đà Nẵng, Việt Nam', '0912345678', 'lequangc@example.com', '1992-11-20', 'Thấp', 'Nhân viên văn phòng', 8000000.00, 'Từ mạng xã hội', 'RM003', 1),
('KHTN004', 'Phạm Minh D', 'Hải Phòng, Việt Nam', '0934567890', 'phaminhd@example.com', '1990-08-15', 'Cao', 'Bác sĩ', 25000000.00, 'Từ bạn bè', 'RM004', 1),
('KHTN005', 'Hoàng Thị E', 'Hà Nội, Việt Nam', '0945678901', 'hoangthie@example.com', '1988-03-22', 'Trung bình', 'Nội trợ', 5000000.00, 'Từ sự kiện', 'RM005', 1),
('KHTN006', 'Ngô Văn F', 'TP. Hồ Chí Minh, Việt Nam', '0912123456', 'ngovanf@example.com', '1995-07-30', 'Cao', 'Kỹ sư phần mềm', 20000000.00, 'Từ giới thiệu', 'RM006', 1),
('KHTN007', 'Phan Thị G', 'Cần Thơ, Việt Nam', '0967876543', 'phanthig@example.com', '1987-10-10', 'Thấp', 'Nhân viên bán hàng', 7000000.00, 'Từ quảng cáo', 'RM007', 1),
('KHTN008', 'Trương Minh H', 'Bình Dương, Việt Nam', '0903456789', 'truongminhh@example.com', '1994-12-01', 'Trung bình', 'Tư vấn viên', 11000000.00, 'Từ bạn bè', 'RM008', 1),
('KHTN009', 'Vũ Thị I', 'Đà Nẵng, Việt Nam', '0916789234', 'vuthii@example.com', '1989-06-18', 'Cao', 'Giám đốc', 30000000.00, 'Từ mạng xã hội', 'RM009', 1),
('KHTN010', 'Đoàn Minh J', 'Hà Nội, Việt Nam', '0922345678', 'doanminhj@example.com', '1991-09-05', 'Trung bình', 'Kỹ sư xây dựng', 18000000.00, 'Từ sự kiện', 'RM010', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `leaves`
--

CREATE TABLE `leaves` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `leave_days` int(11) NOT NULL,
  `leave_from` date NOT NULL,
  `leave_to` date NOT NULL,
  `reason` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `action_by` int(11) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) DEFAULT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lspg_khhh`
--

CREATE TABLE `lspg_khhh` (
  `MaPG` varchar(50) NOT NULL,
  `MaKH` varchar(50) DEFAULT NULL,
  `MaRM` varchar(50) DEFAULT NULL,
  `NguoiPFG` varchar(100) DEFAULT NULL,
  `NgayPFG` date DEFAULT NULL,
  `Ghichu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lspg_khhh`
--

INSERT INTO `lspg_khhh` (`MaPG`, `MaKH`, `MaRM`, `NguoiPFG`, `NgayPFG`, `Ghichu`) VALUES
('PG001', 'KHHH001', 'RM001', 'RM001', '2025-04-09', 'Phân giao từ RM001'),
('PG002', 'KHHH002', 'RM002', 'RM001', '2025-04-09', 'Phân giao từ RM002'),
('PG003', 'KHHH003', 'RM003', 'RM001', '2025-04-09', 'Phân giao từ RM003'),
('PG004', 'KHHH004', 'RM004', 'RM001', '2025-04-09', 'Phân giao từ RM004'),
('PG005', 'KHHH005', 'RM005', 'RM001', '2025-04-09', 'Phân giao từ RM005'),
('PG006', 'KHHH006', 'RM006', 'RM001', '2025-04-09', 'Phân giao từ RM006'),
('PG007', 'KHHH007', 'RM007', 'RM001', '2025-04-09', 'Phân giao từ RM007'),
('PG008', 'KHHH008', 'RM008', 'RM001', '2025-04-09', 'Phân giao từ RM008'),
('PG009', 'KHHH009', 'RM009', 'RM001', '2025-04-09', 'Phân giao từ RM009'),
('PG010', 'KHHH010', 'RM010', 'RM001', '2025-04-09', 'Phân giao từ RM010');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `meetings`
--

CREATE TABLE `meetings` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `slug` varchar(256) NOT NULL,
  `type` varchar(64) NOT NULL,
  `platform` varchar(64) NOT NULL,
  `link` text NOT NULL,
  `venue` text NOT NULL,
  `user_ids` text DEFAULT NULL,
  `client_ids` text DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `is_read` int(11) NOT NULL DEFAULT 1,
  `message` text NOT NULL,
  `type` varchar(128) NOT NULL,
  `media` varchar(256) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`version`) VALUES
(19);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `milestones`
--

CREATE TABLE `milestones` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `cost` varchar(128) NOT NULL,
  `status` varchar(128) NOT NULL,
  `class` varchar(64) NOT NULL DEFAULT 'danger',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `class` varchar(64) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_ids` varchar(1024) NOT NULL,
  `type` varchar(128) NOT NULL,
  `type_id` int(11) NOT NULL,
  `title` varchar(512) DEFAULT NULL,
  `notification` text DEFAULT NULL,
  `read_by` varchar(512) DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `payment_mode_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_mode`
--

CREATE TABLE `payment_mode` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payslips`
--

CREATE TABLE `payslips` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `allowance_item_ids` text NOT NULL,
  `deduction_item_ids` text NOT NULL,
  `payslip_month` datetime NOT NULL,
  `working_days` double NOT NULL,
  `lop_days` double NOT NULL,
  `paid_days` double NOT NULL,
  `basic_salary` double NOT NULL,
  `leave_deduction` double NOT NULL,
  `ot_hours` double NOT NULL,
  `ot_rate` double NOT NULL,
  `ot_payment` double NOT NULL,
  `total_allowance` double NOT NULL,
  `incentives` double NOT NULL,
  `bonus` double NOT NULL,
  `total_earnings` double NOT NULL,
  `total_deductions` double NOT NULL,
  `net_pay` double NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `payment_method` varchar(512) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `signature` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payslip_allowance`
--

CREATE TABLE `payslip_allowance` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `allowance_id` int(11) NOT NULL,
  `allowance_name` varchar(512) NOT NULL,
  `payslip_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payslip_deductions`
--

CREATE TABLE `payslip_deductions` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `payslip_id` int(11) NOT NULL,
  `allowance_id` int(11) NOT NULL,
  `deduction_id` int(11) NOT NULL,
  `deduction_name` varchar(512) NOT NULL,
  `deduction_type` varchar(512) NOT NULL,
  `percentage` double NOT NULL,
  `amount` double NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `workspace_id` int(10) UNSIGNED NOT NULL,
  `permissions` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `MaSP` varchar(50) NOT NULL,
  `MaKH` varchar(50) NOT NULL,
  `LoaiSP` enum('Tài khoản thanh toán','Tiết kiệm','Tín dụng','Bảo lãnh','Trái phiếu','Tài trợ thương mại','Thẻ','Ebanking','SMS') NOT NULL,
  `SoHD` varchar(50) NOT NULL,
  `Ngaymo` date DEFAULT NULL,
  `Ngaydaohan` date DEFAULT NULL,
  `Sodu` decimal(10,2) DEFAULT NULL,
  `Loaitien` varchar(50) DEFAULT NULL,
  `Tygia` decimal(10,2) DEFAULT NULL,
  `MaCN` varchar(50) DEFAULT NULL,
  `MaRMquanly` varchar(50) DEFAULT NULL,
  `MaRMchotHD` varchar(50) DEFAULT NULL,
  `chitiet` varchar(255) DEFAULT NULL,
  `Ngayupload` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`MaSP`, `MaKH`, `LoaiSP`, `SoHD`, `Ngaymo`, `Ngaydaohan`, `Sodu`, `Loaitien`, `Tygia`, `MaCN`, `MaRMquanly`, `MaRMchotHD`, `chitiet`, `Ngayupload`) VALUES
('SP001', 'KHHH001', 'Tài khoản thanh toán', 'HD001', '2025-01-01', '2026-01-01', 1000000.00, 'VND', 1.00, 'CN001', 'RM001', 'RM001', 'Chi tiết sản phẩm 1', '2025-04-09'),
('SP002', 'KHHH002', 'Tài khoản thanh toán', 'HD002', '2025-02-01', '2026-02-01', 1500000.00, 'VND', 1.20, 'CN002', 'RM002', 'RM002', 'Chi tiết sản phẩm 2', '2025-04-09'),
('SP003', 'KHHH003', 'Tài khoản thanh toán', 'HD003', '2025-03-01', '2026-03-01', 2000000.00, 'USD', 23000.00, 'CN003', 'RM003', 'RM003', 'Chi tiết sản phẩm 3', '2025-04-09'),
('SP004', 'KHHH004', 'Tài khoản thanh toán', 'HD004', '2025-04-01', '2026-04-01', 2500000.00, 'USD', 23050.00, 'CN004', 'RM004', 'RM004', 'Chi tiết sản phẩm 4', '2025-04-09'),
('SP005', 'KHHH005', 'Tài khoản thanh toán', 'HD005', '2025-05-01', '2026-05-01', 3000000.00, 'VND', 1.10, 'CN005', 'RM005', 'RM005', 'Chi tiết sản phẩm 5', '2025-04-09'),
('SP006', 'KHHH006', 'Tài khoản thanh toán', 'HD006', '2025-06-01', '2026-06-01', 3500000.00, 'USD', 23040.00, 'CN006', 'RM006', 'RM006', 'Chi tiết sản phẩm 6', '2025-04-09'),
('SP007', 'KHHH007', 'Tài khoản thanh toán', 'HD007', '2025-07-01', '2026-07-01', 4000000.00, 'VND', 1.30, 'CN007', 'RM007', 'RM007', 'Chi tiết sản phẩm 7', '2025-04-09'),
('SP008', 'KHHH008', 'Tài khoản thanh toán', 'HD008', '2025-08-01', '2026-08-01', 4500000.00, 'USD', 23100.00, 'CN008', 'RM008', 'RM008', 'Chi tiết sản phẩm 8', '2025-04-09'),
('SP009', 'KHHH009', 'Tài khoản thanh toán', 'HD009', '2025-09-01', '2026-09-01', 5000000.00, 'VND', 1.20, 'CN009', 'RM009', 'RM009', 'Chi tiết sản phẩm 9', '2025-04-09'),
('SP010', 'KHHH010', 'Tài khoản thanh toán', 'HD010', '2025-10-01', '2026-10-01', 5500000.00, 'VND', 1.10, 'CN010', 'RM010', 'RM010', 'Chi tiết sản phẩm 10', '2025-04-09'),
('SP011', 'KHHH001', 'Tiết kiệm', 'HD011', '2025-01-01', '2026-01-01', 6000000.00, 'VND', 1.00, 'CN001', 'RM001', 'RM001', 'Chi tiết sản phẩm 11', '2025-04-09'),
('SP012', 'KHHH002', 'Tiết kiệm', 'HD012', '2025-02-01', '2026-02-01', 6500000.00, 'USD', 23050.00, 'CN002', 'RM002', 'RM002', 'Chi tiết sản phẩm 12', '2025-04-09'),
('SP013', 'KHHH003', 'Tiết kiệm', 'HD013', '2025-03-01', '2026-03-01', 7000000.00, 'VND', 1.10, 'CN003', 'RM003', 'RM003', 'Chi tiết sản phẩm 13', '2025-04-09'),
('SP014', 'KHHH004', 'Tiết kiệm', 'HD014', '2025-04-01', '2026-04-01', 7500000.00, 'USD', 23080.00, 'CN004', 'RM004', 'RM004', 'Chi tiết sản phẩm 14', '2025-04-09'),
('SP015', 'KHHH005', 'Tiết kiệm', 'HD015', '2025-05-01', '2026-05-01', 8000000.00, 'VND', 1.30, 'CN005', 'RM005', 'RM005', 'Chi tiết sản phẩm 15', '2025-04-09'),
('SP016', 'KHHH006', 'Tiết kiệm', 'HD016', '2025-06-01', '2026-06-01', 8500000.00, 'USD', 23100.00, 'CN006', 'RM006', 'RM006', 'Chi tiết sản phẩm 16', '2025-04-09'),
('SP017', 'KHHH007', 'Tiết kiệm', 'HD017', '2025-07-01', '2026-07-01', 9000000.00, 'VND', 1.20, 'CN007', 'RM007', 'RM007', 'Chi tiết sản phẩm 17', '2025-04-09'),
('SP018', 'KHHH008', 'Tiết kiệm', 'HD018', '2025-08-01', '2026-08-01', 9500000.00, 'USD', 23090.00, 'CN008', 'RM008', 'RM008', 'Chi tiết sản phẩm 18', '2025-04-09'),
('SP019', 'KHHH009', 'Tiết kiệm', 'HD019', '2025-09-01', '2026-09-01', 10000000.00, 'VND', 1.10, 'CN009', 'RM009', 'RM009', 'Chi tiết sản phẩm 19', '2025-04-09'),
('SP020', 'KHHH010', 'Tiết kiệm', 'HD020', '2025-10-01', '2026-10-01', 10500000.00, 'VND', 1.20, 'CN010', 'RM010', 'RM010', 'Chi tiết sản phẩm 20', '2025-04-09'),
('SP021', 'KHHH001', 'Tín dụng', 'HD021', '2025-01-05', '2026-01-05', 11000000.00, 'VND', 1.20, 'CN001', 'RM001', 'RM001', 'Chi tiết sản phẩm 21', '2025-04-09'),
('SP022', 'KHHH002', 'Tín dụng', 'HD022', '2025-02-05', '2026-02-05', 11500000.00, 'USD', 23060.00, 'CN002', 'RM002', 'RM002', 'Chi tiết sản phẩm 22', '2025-04-09'),
('SP023', 'KHHH003', 'Tín dụng', 'HD023', '2025-03-05', '2026-03-05', 12000000.00, 'VND', 1.30, 'CN003', 'RM003', 'RM003', 'Chi tiết sản phẩm 23', '2025-04-09'),
('SP024', 'KHHH004', 'Tín dụng', 'HD024', '2025-04-05', '2026-04-05', 12500000.00, 'USD', 23100.00, 'CN004', 'RM004', 'RM004', 'Chi tiết sản phẩm 24', '2025-04-09'),
('SP025', 'KHHH005', 'Tín dụng', 'HD025', '2025-05-05', '2026-05-05', 13000000.00, 'VND', 1.10, 'CN005', 'RM005', 'RM005', 'Chi tiết sản phẩm 25', '2025-04-09'),
('SP026', 'KHHH006', 'Tín dụng', 'HD026', '2025-06-05', '2026-06-05', 13500000.00, 'USD', 23090.00, 'CN006', 'RM006', 'RM006', 'Chi tiết sản phẩm 26', '2025-04-09'),
('SP027', 'KHHH007', 'Tín dụng', 'HD027', '2025-07-05', '2026-07-05', 14000000.00, 'VND', 1.20, 'CN007', 'RM007', 'RM007', 'Chi tiết sản phẩm 27', '2025-04-09'),
('SP028', 'KHHH008', 'Tín dụng', 'HD028', '2025-08-05', '2026-08-05', 14500000.00, 'USD', 23110.00, 'CN008', 'RM008', 'RM008', 'Chi tiết sản phẩm 28', '2025-04-09'),
('SP029', 'KHHH009', 'Tín dụng', 'HD029', '2025-09-05', '2026-09-05', 15000000.00, 'VND', 1.30, 'CN009', 'RM009', 'RM009', 'Chi tiết sản phẩm 29', '2025-04-09'),
('SP030', 'KHHH010', 'Tín dụng', 'HD030', '2025-10-05', '2026-10-05', 15500000.00, 'VND', 1.20, 'CN010', 'RM010', 'RM010', 'Chi tiết sản phẩm 30', '2025-04-09'),
('SP031', 'KHHH001', 'Bảo lãnh', 'HD031', '2025-01-07', '2026-01-07', 16000000.00, 'VND', 1.20, 'CN001', 'RM001', 'RM001', 'Chi tiết sản phẩm 31', '2025-04-09'),
('SP032', 'KHHH002', 'Bảo lãnh', 'HD032', '2025-02-07', '2026-02-07', 16500000.00, 'USD', 23080.00, 'CN002', 'RM002', 'RM002', 'Chi tiết sản phẩm 32', '2025-04-09'),
('SP033', 'KHHH003', 'Bảo lãnh', 'HD033', '2025-03-07', '2026-03-07', 17000000.00, 'VND', 1.10, 'CN003', 'RM003', 'RM003', 'Chi tiết sản phẩm 33', '2025-04-09'),
('SP034', 'KHHH004', 'Bảo lãnh', 'HD034', '2025-04-07', '2026-04-07', 17500000.00, 'USD', 23100.00, 'CN004', 'RM004', 'RM004', 'Chi tiết sản phẩm 34', '2025-04-09'),
('SP035', 'KHHH005', 'Bảo lãnh', 'HD035', '2025-05-07', '2026-05-07', 18000000.00, 'VND', 1.20, 'CN005', 'RM005', 'RM005', 'Chi tiết sản phẩm 35', '2025-04-09'),
('SP036', 'KHHH006', 'Bảo lãnh', 'HD036', '2025-06-07', '2026-06-07', 18500000.00, 'USD', 23090.00, 'CN006', 'RM006', 'RM006', 'Chi tiết sản phẩm 36', '2025-04-09'),
('SP037', 'KHHH007', 'Bảo lãnh', 'HD037', '2025-07-07', '2026-07-07', 19000000.00, 'VND', 1.30, 'CN007', 'RM007', 'RM007', 'Chi tiết sản phẩm 37', '2025-04-09'),
('SP038', 'KHHH008', 'Bảo lãnh', 'HD038', '2025-08-07', '2026-08-07', 19500000.00, 'USD', 23110.00, 'CN008', 'RM008', 'RM008', 'Chi tiết sản phẩm 38', '2025-04-09'),
('SP039', 'KHHH009', 'Bảo lãnh', 'HD039', '2025-09-07', '2026-09-07', 20000000.00, 'VND', 1.20, 'CN009', 'RM009', 'RM009', 'Chi tiết sản phẩm 39', '2025-04-09'),
('SP040', 'KHHH010', 'Bảo lãnh', 'HD040', '2025-10-07', '2026-10-07', 20500000.00, 'VND', 1.10, 'CN010', 'RM010', 'RM010', 'Chi tiết sản phẩm 40', '2025-04-09');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `user_id` varchar(256) NOT NULL,
  `client_id` varchar(256) DEFAULT NULL,
  `title` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(32) NOT NULL DEFAULT 'ongoing',
  `budget` varchar(128) NOT NULL,
  `class` varchar(64) NOT NULL DEFAULT 'info',
  `priority` varchar(64) DEFAULT NULL,
  `task_count` int(11) NOT NULL DEFAULT 0,
  `comment_count` int(11) NOT NULL DEFAULT 0,
  `is_favorite` tinyint(1) DEFAULT 0,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `project_media`
--

CREATE TABLE `project_media` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(64) NOT NULL,
  `original_file_name` text NOT NULL,
  `file_name` text NOT NULL,
  `file_extension` varchar(64) NOT NULL,
  `file_size` varchar(256) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rms`
--

CREATE TABLE `rms` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rm_code` varchar(50) NOT NULL,
  `hris_code` varchar(50) DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `branch_lv2_code` varchar(50) DEFAULT NULL,
  `branch_lv2_name` varchar(100) DEFAULT NULL,
  `branch_lv1_code` varchar(50) DEFAULT NULL,
  `branch_lv1_name` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rms`
--

INSERT INTO `rms` (`id`, `user_id`, `rm_code`, `hris_code`, `full_name`, `phone`, `email`, `position`, `branch_lv2_code`, `branch_lv2_name`, `branch_lv1_code`, `branch_lv1_name`, `created_at`, `updated_at`) VALUES
(3, 1, 'RM003', 'HRIS003', 'Lê Thị C', '0909345678', 'c.le@example.com', 'Trưởng phòng', 'CN01', 'Chi nhánh Hà Nội', 'KV1', 'Miền Bắc', '2025-04-08 09:43:25', '2025-04-08 09:43:25'),
(4, 2, 'RM004', 'HRIS004', 'Nguyễn Thị D', '0909456789', 'd.nguyen@example.com', 'Chuyên viên', 'CN02', 'Chi nhánh Hà Nội', 'KV1', 'Miền Bắc', '2025-04-08 09:43:25', '2025-04-08 09:43:25'),
(5, 3, 'RM005', 'HRIS005', 'Trần Minh E', '0909567890', 'e.tran@example.com', 'Trưởng phòng', 'CN03', 'Chi nhánh Hồ Chí Minh', 'KV2', 'Miền Nam', '2025-04-08 09:43:25', '2025-04-08 09:43:25'),
(6, 4, 'RM006', 'HRIS006', 'Phan Quang F', '0909678901', 'f.phan@example.com', 'Chuyên viên', 'CN04', 'Chi nhánh Đà Nẵng', 'KV3', 'Miền Trung', '2025-04-08 09:43:25', '2025-04-08 09:43:25'),
(7, 5, 'RM007', 'HRIS007', 'Vũ Mai G', '0909789012', 'g.vu@example.com', 'Chuyên viên', 'CN02', 'Chi nhánh Hà Nội', 'KV1', 'Miền Bắc', '2025-04-08 09:43:25', '2025-04-08 09:43:25'),
(8, 6, 'RM008', 'HRIS008', 'Bùi An H', '0909890123', 'h.bui@example.com', 'Trưởng phòng', 'CN03', 'Chi nhánh Hồ Chí Minh', 'KV2', 'Miền Nam', '2025-04-08 09:43:25', '2025-04-08 09:43:25'),
(9, 7, 'RM009', 'HRIS009', 'Nguyễn Thanh I', '0909901234', 'i.nguyen@example.com', 'Chuyên viên', 'CN01', 'Chi nhánh Hà Nội', 'KV1', 'Miền Bắc', '2025-04-08 09:43:25', '2025-04-08 09:43:25'),
(10, 8, 'RM010', 'HRIS010', 'Đặng Lê J', '0909123456', 'j.dang@example.com', 'Trưởng phòng', 'CN04', 'Chi nhánh Đà Nẵng', 'KV3', 'Miền Trung', '2025-04-08 09:43:25', '2025-04-08 09:43:25'),
(11, 9, 'RM011', 'HRIS011', 'Lâm Minh K', '0909234567', 'k.lam@example.com', 'Chuyên viên', 'CN02', 'Chi nhánh Hà Nội', 'KV1', 'Miền Bắc', '2025-04-08 09:43:25', '2025-04-08 09:43:25'),
(12, 10, 'RM012', 'HRIS012', 'Trần Thu L', '0909345678', 'l.tran@example.com', 'Chuyên viên', 'CN03', 'Chi nhánh Hồ Chí Minh', 'KV2', 'Miền Nam', '2025-04-08 09:43:25', '2025-04-08 09:43:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `type` text NOT NULL,
  `data` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `settings`
--

INSERT INTO `settings` (`id`, `type`, `data`, `date_created`) VALUES
(1, 'web_fcm_settings', '', '2020-03-27 11:21:34'),
(2, 'general', '{\"company_title\":\"TaskHub - Your Project Manager\"}', '2022-11-11 10:47:54'),
(3, 'email', '', '2023-05-17 05:28:34');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `statuses`
--

CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `type` text NOT NULL,
  `text_color` varchar(128) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` varchar(256) DEFAULT NULL,
  `milestone_id` int(11) DEFAULT NULL,
  `title` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `priority` varchar(32) NOT NULL,
  `due_date` date NOT NULL,
  `status` varchar(64) NOT NULL DEFAULT 'todo',
  `class` varchar(64) NOT NULL DEFAULT 'success',
  `comment_count` int(11) NOT NULL DEFAULT 0,
  `start_date` date NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `taxes`
--

CREATE TABLE `taxes` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `percentage` double NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `time_tracker_sheet`
--

CREATE TABLE `time_tracker_sheet` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `duration` time DEFAULT NULL,
  `message` mediumtext DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `time_tracker_sheet`
--

INSERT INTO `time_tracker_sheet` (`id`, `user_id`, `workspace_id`, `project_id`, `start_time`, `end_time`, `duration`, `message`, `date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, '09:33:10', '09:33:13', '00:00:03', '', '2025-04-06', '2025-04-06 16:03:10', '2025-04-06 16:03:13');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `todos`
--

CREATE TABLE `todos` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 - pending | 1 - done',
  `position` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `updates`
--

CREATE TABLE `updates` (
  `id` int(11) UNSIGNED NOT NULL,
  `version` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `updates`
--

INSERT INTO `updates` (`id`, `version`) VALUES
(1, '1'),
(2, '1.1'),
(3, '1.2'),
(4, '1.3'),
(5, '2'),
(6, '2.1'),
(7, '2.2'),
(8, '2.3'),
(9, '2.4'),
(10, '2.5'),
(11, '2.5.1'),
(12, '2.5.2'),
(13, '2.6.0'),
(14, '2.7.0'),
(15, '2.8.0'),
(16, '2.8.1'),
(17, '2.8.2'),
(18, '2.8.3'),
(19, '2.8.4'),
(20, '2.8.5'),
(21, '2.8.6'),
(22, '2.8.7'),
(23, '2.8.8'),
(24, '2.8.9'),
(25, '3.0.0'),
(26, '3.0.1'),
(27, '3.0.2'),
(28, '3.0.3'),
(29, '3.0.4');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `workspace_id` varchar(256) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `date_of_joining` date DEFAULT NULL,
  `gender` varchar(64) DEFAULT NULL,
  `designation` varchar(256) DEFAULT NULL,
  `city` varchar(256) DEFAULT NULL,
  `state` varchar(256) DEFAULT NULL,
  `zip_code` varchar(56) DEFAULT NULL,
  `country` varchar(256) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `web_fcm` text NOT NULL,
  `last_online` int(11) UNSIGNED NOT NULL,
  `lang` varchar(128) NOT NULL DEFAULT 'english',
  `chat_theme` varchar(256) NOT NULL DEFAULT 'chat-theme-light',
  `profile` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `workspace_id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `address`, `date_of_birth`, `date_of_joining`, `gender`, `designation`, `city`, `state`, `zip_code`, `country`, `company`, `phone`, `web_fcm`, `last_online`, `lang`, `chat_theme`, `profile`) VALUES
(1, '1', '103.250.163.214', 'administrator', '$2y$12$UQNYo3xzrq.1FV6JtcaXbO6./jp.o.XQOemsxC4B2AAMTD12sn0Pm', 'tranvy3000@gmail.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1744779758, 1, 'Main', 'Admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 1714473532, 'english', 'chat-theme-dark', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users_groups`
--

CREATE TABLE `users_groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `user_id` mediumint(8) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL,
  `member_permissions` mediumtext DEFAULT NULL,
  `client_permissions` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`, `member_permissions`, `client_permissions`) VALUES
(1, 1, 1, '{\"leads\":{\"create\":\"on\",\"read\":\"on\"}}', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `workspace`
--

CREATE TABLE `workspace` (
  `id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `user_id` varchar(256) NOT NULL,
  `admin_id` varchar(256) NOT NULL,
  `leave_editors` varchar(256) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `status` int(11) DEFAULT 1,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `workspace`
--

INSERT INTO `workspace` (`id`, `title`, `user_id`, `admin_id`, `leave_editors`, `created_by`, `status`, `date_created`) VALUES
(1, 'Main Workspace', '1', '1', NULL, 1, 1, '2023-04-29 12:02:07');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`,`user_id`,`task_id`,`comment_id`,`file_id`,`milestone_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Chỉ mục cho bảng `allowance`
--
ALTER TABLE `allowance`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`,`user_id`);

--
-- Chỉ mục cho bảng `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`workspace_id`,`group_id`);

--
-- Chỉ mục cho bảng `article_group`
--
ALTER TABLE `article_group`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`Machiendich`);

--
-- Chỉ mục cho bảng `cd_khhh`
--
ALTER TABLE `cd_khhh`
  ADD PRIMARY KEY (`MatiepcanKHHH`);

--
-- Chỉ mục cho bảng `cd_khtn`
--
ALTER TABLE `cd_khtn`
  ADD PRIMARY KEY (`MatiepcanKHTN`);

--
-- Chỉ mục cho bảng `chat_groups`
--
ALTER TABLE `chat_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`);

--
-- Chỉ mục cho bảng `chat_group_members`
--
ALTER TABLE `chat_group_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `chat_media`
--
ALTER TABLE `chat_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `message_id` (`message_id`);

--
-- Chỉ mục cho bảng `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`MaKH`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`,`project_id`,`task_id`,`user_id`);

--
-- Chỉ mục cho bảng `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`,`workspace_id`,`project_id`,`contract_type_id`);

--
-- Chỉ mục cho bảng `contracts_type`
--
ALTER TABLE `contracts_type`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`);

--
-- Chỉ mục cho bảng `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `estimates`
--
ALTER TABLE `estimates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Chỉ mục cho bảng `estimate_items`
--
ALTER TABLE `estimate_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`,`estimate_id`,`item_id`,`unit_id`,`tax_id`);

--
-- Chỉ mục cho bảng `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`,`user_id`);

--
-- Chỉ mục cho bảng `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`,`user_id`,`expense_type_id`);

--
-- Chỉ mục cho bảng `expense_types`
--
ALTER TABLE `expense_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`);

--
-- Chỉ mục cho bảng `favourite_projects`
--
ALTER TABLE `favourite_projects`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`,`client_id`,`project_id`);

--
-- Chỉ mục cho bảng `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`,`invoice_id`,`item_id`),
  ADD KEY `unit_id` (`unit_id`,`tax_id`);

--
-- Chỉ mục cho bảng `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`,`unit_id`);

--
-- Chỉ mục cho bảng `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`MaKH`);

--
-- Chỉ mục cho bảng `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`workspace_id`);

--
-- Chỉ mục cho bảng `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `lspg_khhh`
--
ALTER TABLE `lspg_khhh`
  ADD PRIMARY KEY (`MaPG`);

--
-- Chỉ mục cho bảng `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`,`workspace_id`);

--
-- Chỉ mục cho bảng `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`),
  ADD KEY `from_id` (`from_id`),
  ADD KEY `to_id` (`to_id`);

--
-- Chỉ mục cho bảng `milestones`
--
ALTER TABLE `milestones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`,`project_id`);

--
-- Chỉ mục cho bảng `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`,`user_id`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`,`user_id`,`type_id`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`,`invoice_id`,`user_id`,`payment_mode_id`);

--
-- Chỉ mục cho bảng `payment_mode`
--
ALTER TABLE `payment_mode`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`);

--
-- Chỉ mục cho bảng `payslips`
--
ALTER TABLE `payslips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`workspace_id`);

--
-- Chỉ mục cho bảng `payslip_allowance`
--
ALTER TABLE `payslip_allowance`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `payslip_deductions`
--
ALTER TABLE `payslip_deductions`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`workspace_id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`MaSP`);

--
-- Chỉ mục cho bảng `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`,`user_id`,`client_id`);

--
-- Chỉ mục cho bảng `project_media`
--
ALTER TABLE `project_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`,`type_id`,`user_id`);

--
-- Chỉ mục cho bảng `rms`
--
ALTER TABLE `rms`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`,`project_id`,`user_id`,`milestone_id`);

--
-- Chỉ mục cho bảng `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`);

--
-- Chỉ mục cho bảng `time_tracker_sheet`
--
ALTER TABLE `time_tracker_sheet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`workspace_id`);

--
-- Chỉ mục cho bảng `todos`
--
ALTER TABLE `todos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`,`user_id`);

--
-- Chỉ mục cho bảng `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`);

--
-- Chỉ mục cho bảng `updates`
--
ALTER TABLE `updates`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `activation_selector` (`activation_selector`),
  ADD UNIQUE KEY `forgotten_password_selector` (`forgotten_password_selector`),
  ADD UNIQUE KEY `remember_selector` (`remember_selector`),
  ADD KEY `workspace_id` (`workspace_id`);

--
-- Chỉ mục cho bảng `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`group_id`);

--
-- Chỉ mục cho bảng `workspace`
--
ALTER TABLE `workspace`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`admin_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `allowance`
--
ALTER TABLE `allowance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `article_group`
--
ALTER TABLE `article_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `chat_groups`
--
ALTER TABLE `chat_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `chat_group_members`
--
ALTER TABLE `chat_group_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `chat_media`
--
ALTER TABLE `chat_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `contracts_type`
--
ALTER TABLE `contracts_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `emails`
--
ALTER TABLE `emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `estimates`
--
ALTER TABLE `estimates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `estimate_items`
--
ALTER TABLE `estimate_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `expense_types`
--
ALTER TABLE `expense_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `favourite_projects`
--
ALTER TABLE `favourite_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `milestones`
--
ALTER TABLE `milestones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `payment_mode`
--
ALTER TABLE `payment_mode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `payslips`
--
ALTER TABLE `payslips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `payslip_allowance`
--
ALTER TABLE `payslip_allowance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `payslip_deductions`
--
ALTER TABLE `payslip_deductions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `project_media`
--
ALTER TABLE `project_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `rms`
--
ALTER TABLE `rms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `time_tracker_sheet`
--
ALTER TABLE `time_tracker_sheet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `todos`
--
ALTER TABLE `todos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `updates`
--
ALTER TABLE `updates`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `workspace`
--
ALTER TABLE `workspace`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
