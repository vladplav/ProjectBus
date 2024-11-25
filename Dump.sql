-- Создание таблиц
CREATE TABLE IF NOT EXISTS stops (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE UNIQUE INDEX IF NOT EXISTS stops_name_idx ON stops(name);

CREATE TABLE IF NOT EXISTS routes (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    direction VARCHAR(255) NOT NULL
);

CREATE UNIQUE INDEX routes_name_unique_idx ON routes(name);

CREATE TABLE IF NOT EXISTS route_stops (
    id SERIAL PRIMARY KEY,
    route_id INTEGER REFERENCES routes(id),
    stop_id INTEGER REFERENCES stops(id),
    stop_order INTEGER NOT NULL
);

CREATE UNIQUE INDEX IF NOT EXISTS route_stops_unique_idx ON route_stops(route_id, stop_id);

CREATE TABLE IF NOT EXISTS arrivals (
    id SERIAL PRIMARY KEY,
    route_id INTEGER REFERENCES routes(id),
    stop_id INTEGER REFERENCES stops(id),
    arrival_time TIME NOT NULL
);

CREATE UNIQUE INDEX arrivals_route_stop_unique ON arrivals (route_id, stop_id, arrival_time);

-- Добавление данных
INSERT INTO stops (name) 
VALUES ('ул. Пушкина'), ('ул. Ленина'), ('ул. Попова')
ON CONFLICT (name) DO NOTHING;

INSERT INTO routes (name, direction) 
VALUES 
    ('Автобус №11', 'в сторону ост. Попова'), 
    ('Автобус №21', 'в сторону ост. Ленина')
ON CONFLICT (name) DO NOTHING;

INSERT INTO route_stops (route_id, stop_id, stop_order) 
VALUES
-- Маршрут 1
(1, 1, 1), -- ост. Пушкина
(1, 2, 2), -- ост. Ленина
(1, 3, 2), -- ост. Попова
-- Маршрут 2
(2, 1, 1), -- ост. Пушкина
(2, 2, 2)  -- ост. Ленина
ON CONFLICT (route_id, stop_id) DO NOTHING;

INSERT INTO arrivals (route_id, stop_id, arrival_time) 
VALUES
-- Времена прибытия для маршрута №11
(1, 1, '08:15'), (1, 1, '08:40'), (1, 1, '09:15'),
(1, 2, '08:20'), (1, 2, '08:50'), (1, 2, '09:25'),
(1, 3, '08:30'), (1, 3, '09:00'), (1, 3, '09:30'),
-- Времена прибытия для маршрута №21
(2, 1, '08:30'), (2, 1, '09:04'), (2, 1, '09:30'),
(2, 2, '08:45'), (2, 2, '09:10'), (2, 2, '09:45')
ON CONFLICT (route_id, stop_id, arrival_time) DO NOTHING;
