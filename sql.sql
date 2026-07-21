-- 1. Categories Table
CREATE TABLE tbl_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Movies Table
CREATE TABLE tbl_movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    poster VARCHAR(200), ~
    duration_minutes INT NOT NULL,
    release_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES tbl_categories(id) ON DELETE RESTRICT
);

-- 3. Cinema Rooms Table
CREATE TABLE tbl_cinema_rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_name VARCHAR(200) NOT NULL UNIQUE,
    total_seats INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Showtimes Table
CREATE TABLE tbl_showtimes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    movie_id INT NOT NULL,
    room_id INT NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    ticket_price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES tbl_movies(id) ON DELETE CASCADE,
    FOREIGN KEY (room_id) REFERENCES tbl_cinema_rooms(id) ON DELETE CASCADE
);

-- 5. Seats Table
CREATE TABLE tbl_seats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_id INT NOT NULL,
    seat_row VARCHAR(200) NOT NULL,
    seat_number INT NOT NULL,      
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (room_id) REFERENCES tbl_cinema_rooms(id) ON DELETE CASCADE,
    CONSTRAINT uq_room_seat UNIQUE (room_id, seat_row, seat_number)
);

-- 6. Users Table
CREATE TABLE tbl_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(200) NOT NULL,
    role ENUM('admin', 'customer') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

);

-- 7. Bookings Table
CREATE TABLE tbl_bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    showtime_id INT NOT NULL,
    seat_id INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'paid', 'cancelled') DEFAULT 'pending',
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES tbl_users(id) ON DELETE CASCADE,
    FOREIGN KEY (showtime_id) REFERENCES tbl_showtimes(id) ON DELETE RESTRICT,
    FOREIGN KEY (seat_id) REFERENCES tbl_seats(id) ON DELETE RESTRICT
);