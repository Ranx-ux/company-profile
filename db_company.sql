-- ============================================================
-- DATABASE: db_companyprofile
-- PT Jaya Makmur - Company Profile + E-Commerce System
-- ============================================================

-- ============================================================
-- DROP existing tables (reverse dependency order)
-- ============================================================
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `payments`;
DROP TABLE IF EXISTS `order_items`;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `cart_items`;
DROP TABLE IF EXISTS `carts`;
DROP TABLE IF EXISTS `product_images`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `ci_sessions`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `gallery`;
DROP TABLE IF EXISTS `services`;
DROP TABLE IF EXISTS `profile`;
SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- Table: profile
-- ============================================================
CREATE TABLE `profile` (
  `id`               INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_perusahaan`  VARCHAR(255)     NOT NULL,
  `logo`             VARCHAR(255)     DEFAULT NULL,
  `deskripsi`        TEXT             DEFAULT NULL,
  `visi`             TEXT             DEFAULT NULL,
  `misi`             TEXT             DEFAULT NULL,
  `alamat`           TEXT             DEFAULT NULL,
  `email`            VARCHAR(100)     DEFAULT NULL,
  `telepon`          VARCHAR(20)      DEFAULT NULL,
  `website`          VARCHAR(100)     DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: services
-- ============================================================
CREATE TABLE `services` (
  `id`          INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama`        VARCHAR(255)     NOT NULL,
  `deskripsi`   TEXT             DEFAULT NULL,
  `icon`        VARCHAR(100)     DEFAULT NULL,
  `gambar`      VARCHAR(255)     DEFAULT NULL,
  `kategori`    VARCHAR(100)     DEFAULT NULL,
  `status`      ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at`  DATETIME         DEFAULT NULL,
  `updated_at`  DATETIME         DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: gallery
-- ============================================================
CREATE TABLE `gallery` (
  `id`          INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `judul`       VARCHAR(255)     NOT NULL,
  `deskripsi`   TEXT             DEFAULT NULL,
  `gambar`      VARCHAR(255)     DEFAULT NULL,
  `kategori`    VARCHAR(100)     DEFAULT NULL,
  `status`      ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at`  DATETIME         DEFAULT NULL,
  `updated_at`  DATETIME         DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: users (MODIFIED - added google_id, avatar, customer role)
-- ============================================================
CREATE TABLE `users` (
  `id`          INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama`        VARCHAR(100)     NOT NULL,
  `email`       VARCHAR(100)     NOT NULL,
  `google_id`   VARCHAR(100)     DEFAULT NULL,
  `avatar`      VARCHAR(255)     DEFAULT NULL,
  `password`    VARCHAR(255)     DEFAULT NULL,
  `role`        ENUM('superadmin','admin','customer') NOT NULL DEFAULT 'admin',
  `foto`        VARCHAR(255)     DEFAULT NULL,
  `status`      ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at`  DATETIME         DEFAULT NULL,
  `updated_at`  DATETIME         DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: categories
-- ============================================================
CREATE TABLE `categories` (
  `id`          INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(255)     NOT NULL,
  `slug`        VARCHAR(255)     NOT NULL,
  `created_at`  DATETIME         DEFAULT NULL,
  `updated_at`  DATETIME         DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: products
-- ============================================================
CREATE TABLE `products` (
  `id`          INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` INT(11) UNSIGNED NOT NULL,
  `name`        VARCHAR(255)     NOT NULL,
  `slug`        VARCHAR(255)     NOT NULL,
  `description` TEXT             DEFAULT NULL,
  `price`       DECIMAL(12,2)    NOT NULL,
  `stock`       INT(11)          NOT NULL DEFAULT 0,
  `thumbnail`   VARCHAR(255)     DEFAULT NULL,
  `created_at`  DATETIME         DEFAULT NULL,
  `updated_at`  DATETIME         DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: product_images
-- ============================================================
CREATE TABLE `product_images` (
  `id`          INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id`  INT(11) UNSIGNED NOT NULL,
  `image`       VARCHAR(255)     NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `fk_product_images_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: carts
-- ============================================================
CREATE TABLE `carts` (
  `id`          INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`     INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_carts_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: cart_items
-- ============================================================
CREATE TABLE `cart_items` (
  `id`          INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cart_id`     INT(11) UNSIGNED NOT NULL,
  `product_id`  INT(11) UNSIGNED NOT NULL,
  `qty`         INT(11)          NOT NULL DEFAULT 1,
  `price`       DECIMAL(12,2)    NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_id` (`cart_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `fk_cart_items_cart` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_cart_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: orders
-- ============================================================
CREATE TABLE `orders` (
  `id`              INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`         INT(11) UNSIGNED NOT NULL,
  `order_number`    VARCHAR(50)      NOT NULL,
  `total_amount`    DECIMAL(12,2)    NOT NULL,
  `payment_status`  ENUM('pending','paid','failed','expired','cancelled') NOT NULL DEFAULT 'pending',
  `order_status`    ENUM('pending','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `snap_token`      VARCHAR(255)     DEFAULT NULL,
  `receiver_name`   VARCHAR(255)     NOT NULL,
  `phone`           VARCHAR(20)      NOT NULL,
  `email`           VARCHAR(100)     NOT NULL,
  `address`         TEXT             NOT NULL,
  `city`            VARCHAR(100)     NOT NULL,
  `province`        VARCHAR(100)     NOT NULL,
  `postal_code`     VARCHAR(10)      NOT NULL,
  `notes`           TEXT             DEFAULT NULL,
  `created_at`      DATETIME         DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_number` (`order_number`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: order_items
-- ============================================================
CREATE TABLE `order_items` (
  `id`          INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id`    INT(11) UNSIGNED NOT NULL,
  `product_id`  INT(11) UNSIGNED NOT NULL,
  `qty`         INT(11)          NOT NULL,
  `price`       DECIMAL(12,2)    NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_order_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: payments
-- ============================================================
CREATE TABLE `payments` (
  `id`                  INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id`            INT(11) UNSIGNED NOT NULL,
  `transaction_id`      VARCHAR(255)     DEFAULT NULL,
  `payment_type`        VARCHAR(50)      DEFAULT NULL,
  `gross_amount`        DECIMAL(12,2)    DEFAULT NULL,
  `transaction_status`  VARCHAR(50)      DEFAULT NULL,
  `raw_response`        TEXT             DEFAULT NULL,
  `created_at`          DATETIME         DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `fk_payments_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: ci_sessions (CodeIgniter session handler)
-- ============================================================
CREATE TABLE `ci_sessions` (
  `id`         VARCHAR(128) NOT NULL,
  `ip_address` VARCHAR(45)  NOT NULL,
  `timestamp`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `data`       BLOB         NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- DATA: profile
-- ============================================================
INSERT INTO `profile` (`nama_perusahaan`, `logo`, `deskripsi`, `visi`, `misi`, `alamat`, `email`, `telepon`, `website`) VALUES
(
  'Jaya Makmur',
  NULL,
  'PT Jaya Makmur adalah perusahaan terkemuka yang berkomitmen memberikan produk dan layanan berkualitas tinggi untuk kepuasan pelanggan dan kemajuan bisnis. Dengan pengalaman lebih dari 15 tahun, kami telah melayani ratusan klien dari berbagai industri di seluruh Indonesia.',
  'Menjadi perusahaan terdepan dan terpercaya di tingkat nasional maupun internasional pada tahun 2030.',
  '1. Memberikan produk dan layanan berkualitas tinggi\n2. Mengembangkan inovasi berkelanjutan\n3. Membangun kemitraan strategis yang saling menguntungkan\n4. Berkontribusi pada pertumbuhan ekonomi nasional',
  'Jl. Jaya Makmur No. 1, Jakarta Selatan, Indonesia 12345',
  'info@jayamakmur.co.id',
  '(021) 1234-5678',
  'www.jayamakmur.co.id'
);

-- ============================================================
-- DATA: services
-- ============================================================
INSERT INTO `services` (`nama`, `deskripsi`, `icon`, `gambar`, `kategori`, `status`, `created_at`, `updated_at`) VALUES
('Konsultasi Bisnis',   'Layanan konsultasi bisnis profesional untuk membantu perusahaan Anda berkembang dan mencapai target yang diinginkan.',                          'fas fa-briefcase',       NULL, 'Konsultasi', 'aktif', NOW(), NOW()),
('Pengembangan IT',     'Solusi teknologi informasi terpadu mulai dari pengembangan sistem, aplikasi web, mobile, hingga infrastruktur digital.',                       'fas fa-laptop-code',     NULL, 'Teknologi',  'aktif', NOW(), NOW()),
('Manajemen Proyek',    'Pengelolaan proyek secara profesional dengan metodologi terkini untuk memastikan hasil yang optimal dan tepat waktu.',                         'fas fa-project-diagram', NULL, 'Manajemen',  'aktif', NOW(), NOW()),
('Pemasaran Digital',   'Strategi pemasaran digital komprehensif meliputi SEO, media sosial, dan iklan digital untuk meningkatkan brand awareness dan penjualan.',      'fas fa-chart-line',      NULL, 'Pemasaran',  'aktif', NOW(), NOW()),
('Solusi Keuangan',     'Layanan perencanaan dan pengelolaan keuangan bisnis yang akurat, transparan, dan terpercaya untuk pertumbuhan bisnis Anda.',                   'fas fa-coins',           NULL, 'Keuangan',   'aktif', NOW(), NOW()),
('Pelatihan SDM',       'Program pelatihan dan pengembangan sumber daya manusia untuk meningkatkan kompetensi dan produktivitas tim Anda.',                             'fas fa-users',           NULL, 'SDM',        'aktif', NOW(), NOW());

-- ============================================================
-- DATA: gallery
-- ============================================================
INSERT INTO `gallery` (`judul`, `deskripsi`, `gambar`, `kategori`, `status`, `created_at`, `updated_at`) VALUES
('Peresmian Kantor Baru',  'Peresmian kantor pusat PT Jaya Makmur yang baru di Jakarta Selatan', NULL, 'Event',     'aktif', NOW(), NOW()),
('Workshop Tim 2024',      'Workshop pengembangan tim tahunan untuk meningkatkan sinergi kerja',  NULL, 'Kegiatan',  'aktif', NOW(), NOW()),
('Penghargaan Nasional',   'Penerimaan penghargaan perusahaan terbaik tingkat nasional 2024',     NULL, 'Prestasi',  'aktif', NOW(), NOW()),
('Fasilitas Kantor',       'Fasilitas kantor modern dan nyaman untuk mendukung produktivitas',    NULL, 'Fasilitas', 'aktif', NOW(), NOW());

-- ============================================================
-- DATA: users
-- Password: admin123 (bcrypt hash)
-- ============================================================
INSERT INTO `users` (`nama`, `email`, `password`, `role`, `foto`, `status`, `created_at`, `updated_at`) VALUES
(
  'Super Admin',
  'admin@jayamakmur.co.id',
  '$2y$10$T37NuC.WSxKOCwWNDno0jOenf2scflKt1EfJt2j9WYg6IZrfMIuDa',
  'superadmin',
  NULL,
  'aktif',
  NOW(),
  NOW()
);

-- ============================================================
-- DATA: categories
-- ============================================================
INSERT INTO `categories` (`name`, `slug`, `created_at`, `updated_at`) VALUES
('Elektronik',          'elektronik',          NOW(), NOW()),
('Fashion',             'fashion',             NOW(), NOW()),
('Makanan & Minuman',   'makanan-minuman',     NOW(), NOW()),
('Kesehatan',           'kesehatan',           NOW(), NOW()),
('Rumah Tangga',        'rumah-tangga',        NOW(), NOW());

-- ============================================================
-- DATA: products (sample)
-- ============================================================
INSERT INTO `products` (`category_id`, `name`, `slug`, `description`, `price`, `stock`, `thumbnail`, `created_at`, `updated_at`) VALUES
(1, 'Laptop Bisnis Pro X1',     'laptop-bisnis-pro-x1',     'Laptop bisnis berkualitas tinggi dengan prosesor terbaru, RAM 16GB, dan SSD 512GB. Cocok untuk kebutuhan profesional dan multitasking.',    15000000, 25,  NULL, NOW(), NOW()),
(1, 'Smartphone Flagship Z9',   'smartphone-flagship-z9',   'Smartphone flagship dengan kamera 108MP, layar AMOLED 6.7 inci, dan baterai 5000mAh. Performa terbaik di kelasnya.',                       8500000,  50,  NULL, NOW(), NOW()),
(2, 'Kemeja Premium Katun',     'kemeja-premium-katun',     'Kemeja premium berbahan katun berkualitas tinggi. Nyaman dipakai seharian, tersedia dalam berbagai ukuran.',                                 350000,   100, NULL, NOW(), NOW()),
(3, 'Paket Kopi Nusantara',     'paket-kopi-nusantara',     'Paket kopi premium dari berbagai daerah di Indonesia. Termasuk kopi Gayo, Toraja, dan Kintamani.',                                           250000,   200, NULL, NOW(), NOW()),
(4, 'Vitamin C 1000mg',         'vitamin-c-1000mg',         'Suplemen vitamin C 1000mg untuk menjaga daya tahan tubuh. Isi 60 tablet, aman dikonsumsi harian.',                                           150000,   300, NULL, NOW(), NOW()),
(5, 'Set Peralatan Dapur Modern','set-peralatan-dapur-modern','Set peralatan dapur lengkap dengan bahan stainless steel anti karat. Termasuk panci, wajan, dan spatula.',                                   750000,   40,  NULL, NOW(), NOW());
