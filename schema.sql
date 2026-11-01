CREATE TABLE IF NOT EXISTS enquiries (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  phone VARCHAR(25) NOT NULL,
  email VARCHAR(150) NULL,
  service VARCHAR(100) NOT NULL,
  location VARCHAR(150) NULL,
  message TEXT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_enquiries_created_at (created_at),
  INDEX idx_enquiries_service (service)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
