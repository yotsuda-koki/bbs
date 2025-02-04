CREATE TABLE
    `users` (
        `id` int (11) NOT NULL,
        `account_id` varchar(50) NOT NULL,
        `name` varchar(50) NOT NULL,
        `pass` varchar(255) NOT NULL,
        `email` varchar(100) NOT NULL,
        `is_admin` tinyint (4) DEFAULT 0,
        `is_deleted` tinyint (4) DEFAULT 0,
        `create_at` datetime DEFAULT current_timestamp(),
        `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;