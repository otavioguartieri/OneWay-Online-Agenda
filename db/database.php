<?php
    $conn->query("CREATE TABLE IF NOT EXISTS `notes` (
        `id` int NOT NULL AUTO_INCREMENT,
        `title` longtext DEFAULT NULL,
        `data` longtext DEFAULT NULL,
        `active` int DEFAULT 1,
        `created` int DEFAULT NULL,
        PRIMARY KEY (`id`))");
?>
    