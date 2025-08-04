-- Пишу триггер перед вставкой тестовых данных в заказы, чтобы он сработал
-- Не использую лишний запрос для получения категории товара, так как категория дублируется в orders
-- ON CONFLICT использует индекс
-- Триггер срабатывает после INSERT, чтобы убедиться что заказ записан в БД

CREATE OR REPLACE FUNCTION update_statistics_on_order()
RETURNS TRIGGER AS $$
BEGIN
-- Вставляем или обновляем статистику
INSERT INTO statistics (
    category_id,
    items_sold,
    orders_count,
    report_date
) VALUES (
    NEW.category_id,
    NEW.quantity,
    1,
    NEW.date_order::DATE
)
ON CONFLICT (category_id, report_date)
DO UPDATE SET
    items_sold = statistics.items_sold + NEW.quantity,
    orders_count = statistics.orders_count + 1;

RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Создаём триггер
CREATE TRIGGER trigger_update_statistics
    AFTER INSERT ON orders
    FOR EACH ROW
    EXECUTE FUNCTION update_statistics_on_order();