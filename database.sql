-- Create the users table
CREATE TABLE IF NOT EXISTS users (
                                   id INT AUTO_INCREMENT PRIMARY KEY,
                                   username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  category ENUM('admin', 'student', 'lecturer') NOT NULL,
  status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  );

-- Insert sample users with plain text passwords (password is 'password123')
INSERT INTO users (username, password, category, status) VALUES
                                                           ('admin', 'password123', 'admin', 'active'),
                                                           ('student1', 'password123', 'student', 'active'),
                                                           ('lecturer1', 'password123', 'lecturer', 'active');
