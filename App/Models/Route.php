<?php

namespace App\Models;

use PDO;

class Route
{
    public static function findRoutesBetweenStops($from, $to)
    {
        $db = \App\Core\Database::getConnection();
        $stmt = $db->prepare("
            SELECT r.id, r.name, r.direction, s2.name AS end_stop
            FROM routes r
            JOIN route_stops rs1 ON r.id = rs1.route_id
            JOIN stops s1 ON rs1.stop_id = s1.id
            JOIN route_stops rs2 ON r.id = rs2.route_id
            JOIN stops s2 ON rs2.stop_id = s2.id
            WHERE s1.name = :from AND s2.name = :to
        ");
        
        // Выполняем запрос с параметрами
        $stmt->execute(['from' => $from, 'to' => $to]);

        // Извлекаем маршруты
        $routes = $stmt->fetchAll(PDO::FETCH_OBJ);

        // Формируем правильное имя маршрута на основе поля name и direction
        foreach ($routes as &$route) {
            // Теперь мы используем name и direction для формирования полного названия маршрута
            $route->name = "{$route->name} {$route->direction}";
        }

        return $routes;
    }
}
