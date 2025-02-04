CREATE TABLE
    `posts` (
        `id` int (11) NOT NULL,
        `user_id` int (11) NOT NULL,
        `title` varchar(50) NOT NULL,
        `content` text NOT NULL,
        `is_deleted` tinyint (4) DEFAULT 0,
        `create_at` datetime DEFAULT current_timestamp(),
        `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;