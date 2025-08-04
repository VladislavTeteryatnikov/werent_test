CREATE TABLE statistics (
    id SERIAL PRIMARY KEY,
    category_id INT NOT NULL REFERENCES categories(id) ON DELETE RESTRICT,
    items_sold INT NOT NULL DEFAULT 0,
    orders_count INT NOT NULL DEFAULT 0,
    report_date DATE NOT NULL,
    UNIQUE (category_id, report_date)
);

CREATE INDEX idx_statistics_category_date ON statistics(category_id, report_date);