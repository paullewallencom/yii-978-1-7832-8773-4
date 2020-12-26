INSERT INTO `roles` (`id`, `name`, `created`, `updated`) VALUES
(1, 'Regular User', 1394920186, 1394920186);


INSERT INTO `users` (`id`, `email`, `password`, `name`, `role_id`, `created`, `updated`) VALUES
(1, 'user1@example.com', '$2y$13$SjAJFTNr/EFKSuf7Y7UZgu8ViyySLQsICBt/PryluxqfwIP9j9ox2', 'User 1', 1, 1394920423, 1394920423),
(2, 'user2@example.com', '$2y$13$0jZE/pPTct.8dg6a8wA5COAEDxBBDatQSb6drui/h.VAUvhr6Af8C', 'User 2', 1, 1395009793, 1395009793);
