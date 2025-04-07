-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 07, 2025 lúc 04:57 PM
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
('CD001', 'RM001', 'Đã kích hoạt', 'Chiến dịch bán hàng tháng 1', 'Xúc tiến kinh doanh bên ngoài', 'Gặp trực tiếp', 'KHCN', 'Khách hàng cá nhân', 'APP CHAT', 'SP01', 'Quy trình bán', 'Chiến dịch từ HO', '2025-04-01', '2025-04-30', 'Toàn hàng', 'image1.jpg', 'Nội dung chiến dịch 1', 1),
('CD002', 'RM002', 'Đang soạn thảo', 'Hội nghị khách hàng miền Bắc', 'Hội nghị khách hàng', 'Hội thảo', 'KHCN', 'Khách hàng cá nhân', 'APP CHAT', 'SP02', 'Quy trình bán', 'Telesale', '2025-03-10', '2025-03-12', 'Vùng miền', 'image2.jpg', 'Nội dung chiến dịch 2', 0),
('CD003', 'RM003', 'Đã kết thúc', 'Chương trình khuyến mại tháng 4', 'Chương trình khuyến mại', 'Roadshow', 'KHCN', 'Khách hàng cá nhân', 'APP CHAT', 'SP01', 'Quy trình bán', 'App MB/Fanpage', '2025-04-05', '2025-04-25', 'Toàn hàng', 'image3.jpg', 'Nội dung chiến dịch 3', 1),
('CD004', 'RM004', 'Đã kích hoạt', 'Chương trình thi đua nhân viên', 'Chương trình thi đua', 'Gọi điện', 'KHCN', 'Khách hàng cá nhân', 'APP CHAT', 'SP02', 'Quy trình bán', 'Chiến dịch từ chi nhánh', '2025-04-01', '2025-04-15', 'Vùng miền', 'image4.jpg', 'Nội dung chiến dịch 4', 1),
('CD005', 'RM005', 'Đang soạn thảo', 'Quảng cáo sản phẩm mới', 'Quảng cáo sản phẩm', 'Hội thảo', 'KHCN', 'Khách hàng cá nhân', 'APP CHAT', 'SP01', 'Quy trình bán', 'Chiến dịch từ HO', '2025-03-20', '2025-03-30', 'Toàn hàng', 'image5.jpg', 'Nội dung chiến dịch 5', 0),
('CD006', 'RM006', 'Đã kết thúc', 'Phát triển khách hàng VIP', 'Phát triển khách hàng', 'Gặp trực tiếp', 'KHCN', 'Khách hàng cá nhân', 'APP CHAT', 'SP02', 'Quy trình bán', 'Referral', '2025-04-10', '2025-04-20', 'Vùng miền', 'image6.jpg', 'Nội dung chiến dịch 6', 1),
('CD007', 'RM007', 'Đã kích hoạt', 'Chiến dịch bán hàng online', 'Chiến dịch bán hàng', 'Roadshow', 'KHCN', 'Khách hàng cá nhân', 'APP CHAT', 'SP01', 'Quy trình bán', 'Telesale', '2025-03-01', '2025-03-15', 'Toàn hàng', 'image7.jpg', 'Nội dung chiến dịch 7', 1),
('CD008', 'RM008', 'Đang soạn thảo', 'Hội nghị khách hàng miền Nam', 'Hội nghị khách hàng', 'Hội thảo', 'KHCN', 'Khách hàng cá nhân', 'APP CHAT', 'SP02', 'Quy trình bán', 'Chiến dịch từ chi nhánh', '2025-04-01', '2025-04-05', 'Vùng miền', 'image8.jpg', 'Nội dung chiến dịch 8', 0),
('CD009', 'RM009', 'Đã kết thúc', 'Chương trình thi đua sản phẩm', 'Chương trình thi đua', 'Gọi điện', 'KHCN', 'Khách hàng cá nhân', 'APP CHAT', 'SP01', 'Quy trình bán', 'App MB/Fanpage', '2025-03-15', '2025-03-25', 'Toàn hàng', 'image9.jpg', 'Nội dung chiến dịch 9', 1),
('CD010', 'RM010', 'Đã kích hoạt', 'Chiến dịch khuyến mại mùa hè', 'Chương trình khuyến mại', 'Roadshow', 'KHCN', 'Khách hàng cá nhân', 'APP CHAT', 'SP02', 'Quy trình bán', 'Chiến dịch từ HO', '2025-04-10', '2025-04-30', 'Vùng miền', 'image10.jpg', 'Nội dung chiến dịch 10', 1);

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
  `CMT/Hochieu` varchar(20) NOT NULL,
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

INSERT INTO `client` (`MaKH`, `TenKH`, `CMT/Hochieu`, `Ngaycap`, `Noicap`, `Quoctich`, `Ngaysinh`, `Diachi`, `SDT`, `Nghenghiep`, `Thunhap`, `Trangthai`, `Tansuatgiaodich`, `RMquanly`, `Email`, `Khoi`, `Ngayupload`, `workspace_id`) VALUES
('KHHH001', 'Nguyễn Văn A', '123456789', '2010-01-01', 'Hà Nội', 'Việt Nam', '1985-03-15', '123 Phố X, Hà Nội', '0912345678', 0, 10000000.00, '', '', 'Active', 'Giao dịch ít', 'Khách hàng cá nhân', '2025-04-01', '1'),
('KHHH002', 'Trần Thị B', '987654321', '2012-02-15', 'TP. Hồ Chí Minh', 'Việt Nam', '1990-07-20', '456 Đường Y, TP.HCM', '0987654321', 0, 8000000.00, '', '', 'Inactive', 'Giao dịch thường xuyên', 'Khách hàng cá nhân', '2025-04-01', '1'),
('KHHH003', 'Lê Minh C', '456789123', '2011-03-25', 'Hà Nội', 'Việt Nam', '1992-10-10', '789 Phố Z, Hà Nội', '0901234567', 0, 15000000.00, '', '', 'Dormant', 'Giao dịch ít', 'Khách hàng cá nhân', '2025-04-01', '1'),
('KHHH004', 'Phạm Minh D', '112233445', '2015-07-03', 'Hải Phòng', 'Việt Nam', '1988-09-12', '123 Đường Q, Hải Phòng', '0913456789', 0, 20000000.00, '', '', 'Chưa xác định', 'Giao dịch thường xuyên', 'Khách hàng cá nhân', '2025-04-01', '1'),
('KHHH005', 'Nguyễn Thị E', '223344556', '2010-11-20', 'Đà Nẵng', 'Việt Nam', '1980-05-05', '987 Đường S, Đà Nẵng', '0986123456', 0, 12000000.00, '', '', 'Active', 'Giao dịch lớn', 'Khách hàng cá nhân', '2025-04-01', '1'),
('KHHH006', 'Hồ Minh F', '667788990', '2016-09-28', 'Hà Nội', 'Việt Nam', '1983-03-15', '321 Đường A, Hà Nội', '0915566778', 0, 5000000.00, '', '', 'Inactive', 'Không hoạt động', 'Khách hàng cá nhân', '2025-04-01', '1'),
('KHHH007', 'Vũ Thị G', '334455667', '2014-10-12', 'TP. Hồ Chí Minh', 'Việt Nam', '1995-04-18', '654 Đường B, TP.HCM', '0933445566', 0, 2000000.00, '', '', 'Active', 'Giao dịch ít', 'Khách hàng cá nhân', '2025-04-01', '1'),
('KHHH008', 'Đỗ Minh H', '778899001', '2013-01-05', 'Hà Nội', 'Việt Nam', '1986-08-30', '321 Đường C, Hà Nội', '0944556677', 0, 25000000.00, '', '', 'Dormant', 'Giao dịch thường xuyên', 'Khách hàng cá nhân', '2025-04-01', '1'),
('KHHH009', 'Nguyễn Xuân I', '223355778', '2017-06-12', 'Bình Dương', 'Việt Nam', '1990-11-22', '888 Đường D, Bình Dương', '0988776655', 0, 18000000.00, '', '', 'Active', 'Giao dịch lớn', 'Khách hàng cá nhân', '2025-04-01', '1'),
('KHHH010', 'Lê Thị J', '556677889', '2018-08-14', 'Hà Nội', 'Việt Nam', '1993-01-11', '555 Đường E, Hà Nội', '0902345678', 0, 30000000.00, '', '', 'Inactive', 'Giao dịch ít', 'Khách hàng cá nhân', '2025-04-01', '1');

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
  `id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `user_id` text DEFAULT NULL,
  `description` text NOT NULL,
  `status` varchar(64) NOT NULL,
  `assigned_date` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
(1, '1', '103.250.163.214', 'administrator', '$2y$12$UQNYo3xzrq.1FV6JtcaXbO6./jp.o.XQOemsxC4B2AAMTD12sn0Pm', 'tranvy3000@gmail.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1744031070, 1, 'Main', 'Admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 1714473532, 'english', 'chat-theme-dark', NULL);

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
(1, 1, 1, NULL, NULL);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `workspace_id` (`workspace_id`);

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
-- AUTO_INCREMENT cho bảng `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
