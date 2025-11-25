-- Database schema generated for inventory & sales system
-- Date: 2025-11-17

CREATE DATABASE IF NOT EXISTS inventory_system;
USE inventory_system;

-- 1. Managers
CREATE TABLE Managers (
  manager_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  full_name VARCHAR(100),
  phone_number VARCHAR(15),
  email VARCHAR(100),
  role VARCHAR(50),
  status VARCHAR(50),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE Manager_Logs (
  log_id INT AUTO_INCREMENT PRIMARY KEY,
  manager_id INT NOT NULL,
  action_type VARCHAR(50),
  description TEXT,
  action_time DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (manager_id) REFERENCES Managers(manager_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 2. Employees & Roles
CREATE TABLE Employees (
  employee_id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(100),
  position VARCHAR(50),
  phone_number VARCHAR(15),
  email VARCHAR(100),
  address VARCHAR(255),
  hire_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  salary DECIMAL(12,2),
  manager_id INT,
  FOREIGN KEY (manager_id) REFERENCES Managers(manager_id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE Roles (
  role_id INT AUTO_INCREMENT PRIMARY KEY,
  role_name VARCHAR(50) UNIQUE,
  description TEXT
) ENGINE=InnoDB;

CREATE TABLE Employee_Roles (
  employee_id INT NOT NULL,
  role_id INT NOT NULL,
  assigned_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (employee_id, role_id),
  FOREIGN KEY (employee_id) REFERENCES Employees(employee_id) ON DELETE CASCADE,
  FOREIGN KEY (role_id) REFERENCES Roles(role_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 3. Categories, Suppliers, Products, Product_Variants
CREATE TABLE Categories (
  category_id INT AUTO_INCREMENT PRIMARY KEY,
  category_name VARCHAR(100),
  description TEXT
) ENGINE=InnoDB;

CREATE TABLE Suppliers (
  supplier_id INT AUTO_INCREMENT PRIMARY KEY,
  supplier_name VARCHAR(100),
  phone_number VARCHAR(15),
  email VARCHAR(100),
  address VARCHAR(255),
  description TEXT
) ENGINE=InnoDB;

CREATE TABLE Products (
  product_id INT AUTO_INCREMENT PRIMARY KEY,
  product_name VARCHAR(100) NOT NULL,
  brand VARCHAR(50),
  description TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  category_id INT,
  supplier_id INT,
  FOREIGN KEY (category_id) REFERENCES Categories(category_id) ON DELETE SET NULL,
  FOREIGN KEY (supplier_id) REFERENCES Suppliers(supplier_id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE Product_Variants (
  variant_id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT NOT NULL,
  variant_name VARCHAR(100),
  color VARCHAR(50),
  storage VARCHAR(50),
  price DECIMAL(12,2),
  stock_quantity INT DEFAULT 0,
  warranty_months INT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (product_id) REFERENCES Products(product_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 4. Warehouses, Inventory Receipts, Receipt Details, Stock Logs
CREATE TABLE Warehouses (
  warehouse_id INT AUTO_INCREMENT PRIMARY KEY,
  warehouse_name VARCHAR(100),
  location VARCHAR(255),
  manager_id INT,
  FOREIGN KEY (manager_id) REFERENCES Employees(employee_id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE Inventory_Receipts (
  receipt_id INT AUTO_INCREMENT PRIMARY KEY,
  supplier_id INT,
  employee_id INT,
  receipt_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  total_value DECIMAL(12,2),
  FOREIGN KEY (supplier_id) REFERENCES Suppliers(supplier_id) ON DELETE SET NULL,
  FOREIGN KEY (employee_id) REFERENCES Employees(employee_id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE Receipt_Details (
  receipt_detail_id INT AUTO_INCREMENT PRIMARY KEY,
  receipt_id INT NOT NULL,
  variant_id INT NOT NULL,
  quantity INT,
  unit_cost DECIMAL(12,2),
  total_cost DECIMAL(12,2),
  FOREIGN KEY (receipt_id) REFERENCES Inventory_Receipts(receipt_id) ON DELETE CASCADE,
  FOREIGN KEY (variant_id) REFERENCES Product_Variants(variant_id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE Stock_Logs (
  log_id INT AUTO_INCREMENT PRIMARY KEY,
  variant_id INT NOT NULL,
  warehouse_id INT,
  change_type VARCHAR(50),
  quantity INT,
  log_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  reference_id INT,
  FOREIGN KEY (variant_id) REFERENCES Product_Variants(variant_id) ON DELETE CASCADE,
  FOREIGN KEY (warehouse_id) REFERENCES Warehouses(warehouse_id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 5. Customers & Orders
CREATE TABLE Customers (
  customer_id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(100),
  phone_number VARCHAR(15),
  email VARCHAR(100),
  address VARCHAR(255),
  gender VARCHAR(10),
  date_of_birth DATE,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE Order_Status (
  order_status_id INT AUTO_INCREMENT PRIMARY KEY,
  status_name VARCHAR(50),
  description TEXT
) ENGINE=InnoDB;

CREATE TABLE Orders (
  order_id INT AUTO_INCREMENT PRIMARY KEY,
  customer_id INT,
  employee_id INT,
  order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  total_amount DECIMAL(12,2),
  order_status_id INT,
  payment_method VARCHAR(50),
  note TEXT,
  FOREIGN KEY (customer_id) REFERENCES Customers(customer_id) ON DELETE SET NULL,
  FOREIGN KEY (employee_id) REFERENCES Employees(employee_id) ON DELETE SET NULL,
  FOREIGN KEY (order_status_id) REFERENCES Order_Status(order_status_id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE Order_Details (
  order_detail_id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  variant_id INT NOT NULL,
  quantity INT,
  unit_price DECIMAL(12,2),
  discount DECIMAL(5,2),
  subtotal DECIMAL(12,2),
  FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE CASCADE,
  FOREIGN KEY (variant_id) REFERENCES Product_Variants(variant_id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE Warranty_Cards (
  warranty_id INT AUTO_INCREMENT PRIMARY KEY,
  order_detail_id INT,
  start_date DATE,
  end_date DATE,
  status VARCHAR(50),
  note TEXT,
  FOREIGN KEY (order_detail_id) REFERENCES Order_Details(order_detail_id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 6. Payments
CREATE TABLE Payment_Status (
  payment_status_id INT AUTO_INCREMENT PRIMARY KEY,
  status_name VARCHAR(50),
  description TEXT
) ENGINE=InnoDB;

CREATE TABLE Payments (
  payment_id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  payment_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  amount DECIMAL(12,2),
  payment_method VARCHAR(50),
  payment_status_id INT,
  transaction_code VARCHAR(50),
  note TEXT,
  FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE CASCADE,
  FOREIGN KEY (payment_status_id) REFERENCES Payment_Status(payment_status_id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 7. Promotions & Feedback
CREATE TABLE Promotions (
  promotion_id INT AUTO_INCREMENT PRIMARY KEY,
  promotion_name VARCHAR(100),
  discount_percent DECIMAL(5,2),
  start_date DATE,
  end_date DATE,
  description TEXT
) ENGINE=InnoDB;

CREATE TABLE Promotion_Details (
  promotion_detail_id INT AUTO_INCREMENT PRIMARY KEY,
  promotion_id INT,
  variant_id INT,
  note TEXT,
  FOREIGN KEY (promotion_id) REFERENCES Promotions(promotion_id) ON DELETE CASCADE,
  FOREIGN KEY (variant_id) REFERENCES Product_Variants(variant_id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE Customer_Feedback (
  feedback_id INT AUTO_INCREMENT PRIMARY KEY,
  customer_id INT,
  variant_id INT,
  rating INT,
  comment TEXT,
  feedback_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (customer_id) REFERENCES Customers(customer_id) ON DELETE SET NULL,
  FOREIGN KEY (variant_id) REFERENCES Product_Variants(variant_id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 8. Product Logs
CREATE TABLE Product_Logs (
  log_id INT AUTO_INCREMENT PRIMARY KEY,
  variant_id INT,
  employee_id INT,
  action_type VARCHAR(20),
  old_data TEXT,
  new_data TEXT,
  action_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  note TEXT,
  FOREIGN KEY (variant_id) REFERENCES Product_Variants(variant_id) ON DELETE SET NULL,
  FOREIGN KEY (employee_id) REFERENCES Employees(employee_id) ON DELETE SET NULL
) ENGINE=InnoDB;