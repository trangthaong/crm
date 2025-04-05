-- ============================================================
-- 1. QUẢN LÝ ĐƠN VỊ VÀ NHÂN VIÊN (RM) / NGƯỜI DÙNG
-- ============================================================

CREATE TABLE DonVi (
    MaDonVi VARCHAR(50) PRIMARY KEY,
    TenDonVi NVARCHAR(255) NOT NULL
);

CREATE TABLE NguoiDung (
    MaRM VARCHAR(50) PRIMARY KEY,
    TenDangNhap VARCHAR(50) UNIQUE,
    MaHris VARCHAR(50) UNIQUE NULL,
    TenNguoiDung NVARCHAR(255) NOT NULL,
    MatKhau VARCHAR(255) NOT NULL,
    Email VARCHAR(100) UNIQUE NULL,
    SoDienThoai VARCHAR(20) NULL,
    Phong NVARCHAR(255) NULL,
    ViTri NVARCHAR(255) NULL,
    ChucDanh NVARCHAR(255) NULL,
    KhoiTrenHRIS NVARCHAR(100) NULL,
    NgayVaoMB DATE NULL,
    GioiTinh ENUM('Nam', 'Nữ', 'Khác') NULL,
    CapDoRM NVARCHAR(50) NULL,
    MaDonVi VARCHAR(50),
    TrangThai ENUM('Hiệu lực', 'Không hiệu lực') DEFAULT 'Hiệu lực' NOT NULL,
    PhanQuyen ENUM('RM', 'CBQL', 'Admin') NOT NULL,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT FK_NguoiDung_DonVi FOREIGN KEY (MaDonVi) REFERENCES DonVi(MaDonVi)
);

-- ============================================================
-- 2. QUẢN LÝ KHÁCH HÀNG HIỆN HỮU
-- ============================================================

CREATE TABLE KhachHang (
    MaKH VARCHAR(50) PRIMARY KEY,
    TenKH NVARCHAR(200) NOT NULL,
    SoCMT_HoChieu VARCHAR(50) NOT NULL UNIQUE,
    NgayCap DATE,
    NoiCap NVARCHAR(1000),
    QuocTich NVARCHAR(100),
    NgaySinh DATE,
    DiaChi NVARCHAR(1000),
    SoDienThoai VARCHAR(15),
    Email VARCHAR(100) NULL,
    Khoi NVARCHAR(50) DEFAULT 'KHCN',
    TrangThai ENUM('Tất cả','Active','Inactive','Dormant','Chưa xác định') DEFAULT 'Active',
    ChiNhanhQuanLy VARCHAR(50) NOT NULL,
    RMQuanLy VARCHAR(50) NULL,
    DonViUpload VARCHAR(50) NOT NULL,
    NguoiUpload VARCHAR(50) NOT NULL,
    NgayUpload DATETIME DEFAULT CURRENT_TIMESTAMP,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT FK_KH_ChiNhanh FOREIGN KEY (ChiNhanhQuanLy) REFERENCES DonVi(MaDonVi),
    CONSTRAINT FK_KH_RM FOREIGN KEY (RMQuanLy) REFERENCES NguoiDung(MaRM),
    CONSTRAINT FK_KH_DonViUpload FOREIGN KEY (DonViUpload) REFERENCES DonVi(MaDonVi),
    CONSTRAINT FK_KH_NguoiUpload FOREIGN KEY (NguoiUpload) REFERENCES NguoiDung(MaRM)
);

-- ============================================================
-- 3. QUẢN LÝ KHÁCH HÀNG TIỀM NĂNG
-- ============================================================

CREATE TABLE KhachHangTiemNang (
    MaKHTN VARCHAR(50) PRIMARY KEY,
    TenKH NVARCHAR(255) NOT NULL,
    SoDienThoai VARCHAR(50) UNIQUE NULL,
    Email VARCHAR(100) UNIQUE NULL,
    DiaChi NVARCHAR(1000),
    NgaySinh DATE NULL,
    NgheNghiep NVARCHAR(255),
    ThuNhapThang VARCHAR(50),
    MucDoTiemNang ENUM('Cao', 'Trung bình', 'Thấp') NULL,
    NguonKH ENUM('Tự phát triển', 'Tích hợp từ social', 'Dữ liệu đấu thầu', 'Khác') NULL,
    TrangThai ENUM('Mới', 'Đã chuyển KHHH', 'Đã liên lạc', 'Cần khai thác sâu', 'Tiềm năng', 'Không cần liên lạc') DEFAULT 'Mới',
    MaChienDich VARCHAR(100) NULL,
    MaDonVi VARCHAR(50) NULL,
    MaRM VARCHAR(50) NULL,
    NguoiTao VARCHAR(50) NOT NULL,
    NgayTao DATETIME DEFAULT CURRENT_TIMESTAMP,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT FK_KHTN_DonVi FOREIGN KEY (MaDonVi) REFERENCES DonVi(MaDonVi),
    CONSTRAINT FK_KHTN_RM FOREIGN KEY (MaRM) REFERENCES NguoiDung(MaRM),
    CONSTRAINT FK_KHTN_ChienDich FOREIGN KEY (MaChienDich) REFERENCES ChienDich(MaChienDich),
    CONSTRAINT FK_KHTN_NguoiTao FOREIGN KEY (NguoiTao) REFERENCES NguoiDung(MaRM)
);

-- ============================================================
-- 4. QUẢN LÝ NHẬP FILE KHÁCH HÀNG
-- ============================================================

CREATE TABLE ImportFile_KhachHang (
    ImportID INT PRIMARY KEY AUTO_INCREMENT,
    LoaiImport ENUM('KH_HienHuu', 'KH_TiemNang') NOT NULL,
    TenFile NVARCHAR(255) NOT NULL,
    NgayImport DATETIME DEFAULT CURRENT_TIMESTAMP,
    NguoiImport VARCHAR(50) NOT NULL,
    SoLuongBanGhi INT NOT NULL,
    SoLuongThanhCong INT DEFAULT 0,
    SoLuongThatBai INT DEFAULT 0,
    DanhSachLoi JSON,
    DanhSachThanhCong JSON,
    CONSTRAINT FK_ImportKH_NguoiImport FOREIGN KEY (NguoiImport) REFERENCES NguoiDung(MaRM)
);

-- ============================================================
-- 5. QUẢN LÝ SẢN PHẨM DỊCH VỤ
-- ============================================================

CREATE TABLE SanPham (
    MaSP VARCHAR(50) PRIMARY KEY,
    TenSP NVARCHAR(255) NOT NULL,
    LoaiSanPham ENUM('CASA', 'TietKiem', 'TinDung', 'BaoLanh', 'TraiPhieu', 'TaiTroThuongMai', 'The', 'Ebanking', 'SMS'),
    MoTa TEXT,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ============================================================
CREATE TABLE KhachHang_SanPham (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    MaKH VARCHAR(50) NOT NULL,
    MaSP VARCHAR(50) NOT NULL,
    SoHopDong VARCHAR(50) UNIQUE NULL,
    NgayMo DATE,
    NgayDaoHan DATE,
    SoDu DECIMAL(18,2) DEFAULT 0.00,
    LoaiTien VARCHAR(10) DEFAULT 'VND',
    TyGia DECIMAL(18,4) NULL,
    MaChiNhanhPhatHanh VARCHAR(50) NULL,
    MaRMQuanLySP VARCHAR(50) NULL,
    MaRMChotSP VARCHAR(50) NULL,
    ChiTiet JSON,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT FK_KHSP_KH FOREIGN KEY (MaKH) REFERENCES KhachHang(MaKH) ON DELETE CASCADE,
    CONSTRAINT FK_KHSP_SP FOREIGN KEY (MaSP) REFERENCES SanPham(MaSP),
    CONSTRAINT FK_KHSP_CNPhatHanh FOREIGN KEY (MaChiNhanhPhatHanh) REFERENCES DonVi(MaDonVi),
    CONSTRAINT FK_KHSP_RMQuanLySP FOREIGN KEY (MaRMQuanLySP) REFERENCES NguoiDung(MaRM),
    CONSTRAINT FK_KHSP_RMChotSP FOREIGN KEY (MaRMChotSP) REFERENCES NguoiDung(MaRM)
);

-- ============================================================
-- 6. LỊCH SỬ PHÂN GIAO KHÁCH HÀNG
-- ============================================================

CREATE TABLE LichSuPhanGiao (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    MaKH VARCHAR(50) NOT NULL,
    MaRM_DuocPhanGiao VARCHAR(50) NOT NULL,
    NgayBatDau DATE NOT NULL,
    NgayKetThuc DATE NULL,
    NguoiPhanGiao VARCHAR(50) NOT NULL,
    GhiChu NVARCHAR(1000),
    ThoiGianPhanGiao DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT FK_LSPG_KH FOREIGN KEY (MaKH) REFERENCES KhachHang(MaKH),
    CONSTRAINT FK_LSPG_RM FOREIGN KEY (MaRM_DuocPhanGiao) REFERENCES NguoiDung(MaRM),
    CONSTRAINT FK_LSPG_NguoiPhanGiao FOREIGN KEY (NguoiPhanGiao) REFERENCES NguoiDung(MaRM)
);

-- ============================================================
-- 7. LỊCH SỬ PHÂN GIAO KHÁCH HÀNG TIỀM NĂNG
-- ============================================================

CREATE TABLE LichSuPhanGiao_KHTN (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    MaKHTN VARCHAR(50) NOT NULL,
    MaRM_DuocPhanGiao VARCHAR(50) NULL,
    MaDonVi_DuocPhanGiao VARCHAR(50) NOT NULL,
    NgayPhanGiao DATE DEFAULT CURRENT_DATE,
    NguoiPhanGiao VARCHAR(50) NOT NULL,
    GhiChu NVARCHAR(1000),
    ThoiGianPhanGiao DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT FK_LSPGKHTN_KHTN FOREIGN KEY (MaKHTN) REFERENCES KhachHangTiemNang(MaKHTN),
    CONSTRAINT FK_LSPGKHTN_DonVi FOREIGN KEY (MaDonVi_DuocPhanGiao) REFERENCES DonVi(MaDonVi),
    CONSTRAINT FK_LSPGKHTN_RM FOREIGN KEY (MaRM_DuocPhanGiao) REFERENCES NguoiDung(MaRM),
    CONSTRAINT FK_LSPGKHTN_NguoiPhanGiao FOREIGN KEY (NguoiPhanGiao) REFERENCES NguoiDung(MaRM)
);

-- ============================================================
-- 8. QUẢN LÝ CHIẾN DỊCH
-- ============================================================

CREATE TABLE ChienDich (
    MaChienDich VARCHAR(100) PRIMARY KEY,
    NguoiTao VARCHAR(50) NOT NULL,
    DonViQuanLy VARCHAR(50) NOT NULL,
    TrangThai ENUM('Đang soạn thảo', 'Đã kích hoạt', 'Đang triển khai', 'Đã kết thúc', 'Tạm dừng') DEFAULT 'Đang soạn thảo',
    TenChienDich NVARCHAR(100) NOT NULL,
    MucDich NVARCHAR(50),
    HinhThuc ENUM('Tất cả','Gặp trực tiếp','Gọi điện','Hội thảo','Roadshow'),
    DoiTuongKhachHang NVARCHAR(50) DEFAULT 'KHCN',
    KhoiKhaiThac NVARCHAR(50) DEFAULT 'KHCN',
    KenhBan NVARCHAR(50),
    MaSP_LienQuan VARCHAR(50) NULL,
    QuyTrinhThucHien NVARCHAR(50),
    NguonDuLieu NVARCHAR(50),
    NgayBatDau DATE NOT NULL,
    NgayKetThuc DATE NULL,
    QuyMoChienDich ENUM('Toàn hàng','Vùng miền') DEFAULT 'Toàn hàng',
    Anh JSON,
    NoiDung NVARCHAR(1000),
    ChoPhepRMThemMoiKH BIT DEFAULT 0,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT FK_CD_DonViQL FOREIGN KEY (DonViQuanLy) REFERENCES DonVi(MaDonVi),
    CONSTRAINT FK_CD_NguoiTao FOREIGN KEY (NguoiTao) REFERENCES NguoiDung(MaRM),
    CONSTRAINT FK_CD_SanPham FOREIGN KEY (MaSP_LienQuan) REFERENCES SanPham(MaSP)
);

-- ============================================================
-- 9. IMPORT FILE KHÁCH HÀNG VÀO CHIẾN DỊCH
-- ============================================================

CREATE TABLE ImportFile_ChienDich_KH (
    ImportID INT PRIMARY KEY AUTO_INCREMENT,
    MaChienDich VARCHAR(100) NOT NULL,
    TenFile NVARCHAR(255) NOT NULL,
    NgayImport DATETIME DEFAULT CURRENT_TIMESTAMP,
    NguoiImport VARCHAR(50) NOT NULL,
    SoLuongBanGhi INT NOT NULL,
    SoLuongThanhCong INT DEFAULT 0,
    SoLuongThatBai INT DEFAULT 0,
    DanhSachLoi JSON,
    CONSTRAINT FK_IFCD_CD FOREIGN KEY (MaChienDich) REFERENCES ChienDich(MaChienDich),
    CONSTRAINT FK_IFCD_NguoiImport FOREIGN KEY (NguoiImport) REFERENCES NguoiDung(MaRM)
);

-- ============================================================
-- 10. KHÁCH HÀNG THAM GIA CHIẾN DỊCH
-- ============================================================

CREATE TABLE ChienDich_KhachHang (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    MaChienDich VARCHAR(100) NOT NULL,
    MaKH VARCHAR(50) NOT NULL,
    NgayThamGia DATE DEFAULT CURRENT_DATE,
    TrangThaiTiepCan ENUM('Chưa tiếp cận', 'Không liên lạc được', 'Liên hệ lại', 'Đồng ý hẹn gặp', 'Đang chăm sóc', 'Đang thu thập hồ sơ', 'Chốt bán', 'Tạm dừng', 'Từ chối') DEFAULT 'Chưa tiếp cận',
    GhiChuTiepCan TEXT NULL,
    RMTiepCan VARCHAR(50) NULL,
    NgayTiepCanCuoi DATETIME NULL,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT FK_CDKH_CD FOREIGN KEY (MaChienDich) REFERENCES ChienDich(MaChienDich) ON DELETE CASCADE,
    CONSTRAINT FK_CDKH_KH FOREIGN KEY (MaKH) REFERENCES KhachHang(MaKH) ON DELETE CASCADE,
    CONSTRAINT FK_CDKH_RMTiepCan FOREIGN KEY (RMTiepCan) REFERENCES NguoiDung(MaRM),
    CONSTRAINT UQ_CDKH UNIQUE (MaChienDich, MaKH)
);

-- ============================================================
-- 11. NHẬT KÝ HOẠT ĐỘNG
-- ============================================================

CREATE TABLE NhatKyHoatDong (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    ThoiGian DATETIME DEFAULT CURRENT_TIMESTAMP,
    NguoiThucHien VARCHAR(50) NOT NULL,
    HanhDong NVARCHAR(255) NOT NULL,
    DoiTuong NVARCHAR(50) NULL,
    MaDoiTuong VARCHAR(100) NULL,
    MoTaChiTiet TEXT,
    IP_Address VARCHAR(45) NULL,
    CONSTRAINT FK_NKHD_NguoiThucHien FOREIGN KEY (NguoiThucHien) REFERENCES NguoiDung(MaRM),
    INDEX IDX_NKHD_ThoiGian (ThoiGian),
    INDEX IDX_NKHD_DoiTuong (DoiTuong, MaDoiTuong)
);