-- Таблица с заказами. Здесь дублирую category_id, это не очень логично, но позволяет получить сразу нужную категорию для записи в статистику без доп запроса
CREATE TABLE orders (
    id SERIAL PRIMARY KEY,
    product_id INT NOT NULL REFERENCES products(id) ON DELETE CASCADE,
    category_id INT NOT NULL REFERENCES categories(id) ON DELETE RESTRICT,
    quantity INT NOT NULL CHECK (quantity > 0),
    date_order TIMESTAMP NOT NULL DEFAULT NOW()
);
