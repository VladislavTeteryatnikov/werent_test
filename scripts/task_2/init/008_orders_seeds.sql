-- Тестовые данные для заказов
INSERT INTO orders (product_id, category_id, quantity, date_order) VALUES
-- Заказы iPhone 16 (product_id = 1, category_id = 1)
(1, 1, 2, '2025-08-01 10:30:00'),
(1, 1, 1, '2025-08-01 14:15:00'),
(1, 1, 3, '2025-08-02 09:45:00'),

-- Заказы iPad Air (product_id = 3, category_id = 2)
(3, 2, 1, '2025-08-01 11:20:00'),
(3, 2, 2, '2025-08-02 16:00:00'),

-- Заказы LG Телевизор (product_id = 4, category_id = 3)
(4, 3, 1, '2025-08-02 18:30:00'),

-- Заказы Samsung Телевизор (product_id = 5, category_id = 3)
(5, 3, 1, '2025-08-01 20:15:00'),
(5, 3, 2, '2025-08-02 12:00:00');