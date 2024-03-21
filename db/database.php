<?php
    $conn->query("CREATE TABLE IF NOT EXISTS `notes` (
        `id` int NOT NULL AUTO_INCREMENT,
        `title` longtext DEFAULT NULL,
        `dados` longtext DEFAULT NULL,
        `ativo` int DEFAULT 1,
        `inclusao` int DEFAULT NULL,
        PRIMARY KEY (`id`))");
?>
    