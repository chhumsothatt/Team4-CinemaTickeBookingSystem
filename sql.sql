
-- 1. Categories Table (Category CRUD module)
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Movies Table (Movie CRUD, Filter, Search with AJAX, Poster Upload modules)
CREATE TABLE movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    poster_url VARCHAR(500), -- Stores the uploaded file path from your upload module
    duration_minutes INT NOT NULL,
    release_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT,
    FULLTEXT INDEX idx_movie_title (title) -- Built-in index for high performance AJAX Search
);

-- 3. Cinema Rooms Table (Cinema Room CRUD module)
CREATE TABLE cinema_rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_name VARCHAR(100) NOT NULL UNIQUE,
    total_seats INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Showtimes Table (Showtime CRUD module)
CREATE TABLE showtimes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    movie_id INT NOT NULL,
    room_id INT NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    ticket_price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    FOREIGN KEY (room_id) REFERENCES cinema_rooms(id) ON DELETE CASCADE
);

-- 5. Seats Table (Physical blueprint of each hall)
CREATE TABLE seats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_id INT NOT NULL,
    row_number VARCHAR(5) NOT NULL, -- e.g., 'A', 'B', 'VIP'
    seat_number INT NOT NULL,      -- e.g., 1, 2, 3
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (room_id) REFERENCES cinema_rooms(id) ON DELETE CASCADE,
    UNIQUE KEY unique_room_seat (room_id, row_number, seat_number) -- Prevents duplicated positions in the same hall
);

-- 6. Users Table (Authentication & Roles module)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'customer') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 7. Bookings Table (Seat Booking, Booking History & Dashboard metrics)
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    showtime_id INT NOT NULL,
    seat_id INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'paid', 'cancelled') DEFAULT 'pending',
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (showtime_id) REFERENCES showtimes(id) ON DELETE RESTRICT,
    FOREIGN KEY (seat_id) REFERENCES seats(id) ON DELETE RESTRICT,
    -- CRITICAL BUSINESS LOGIC RULE: 
    -- This constraint guarantees that the same seat cannot be booked twice for the same showtime!
    UNIQUE KEY unique_showtime_seat (showtime_id, seat_id) 
);
