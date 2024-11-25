<?php
namespace App\Models;
use PDO;

class EditRoute
{
    /**
     * Находит маршрут по его ID.
     *
     * @param int $routeId Идентификатор маршрута
     * @return object|null Объект маршрута или null, если не найден
     */
    public static function findById($routeId)
    {
        $db = \App\Core\Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM routes WHERE id = :route_id");
        $stmt->execute(['route_id' => $routeId]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Удаляет все остановки для маршрута по его ID.
     *
     * @param int $routeId Идентификатор маршрута
     */
    public static function deleteStopsByRouteId($routeId)
    {
        $db = \App\Core\Database::getConnection();
        $stmt = $db->prepare("DELETE FROM route_stops WHERE route_id = :route_id");
        $stmt->execute(['route_id' => $routeId]);
    }

    /**
     * Добавляет остановку в маршрут с указанием порядка.
     *
     * @param int $routeId Идентификатор маршрута
     * @param int $stopId Идентификатор остановки
     * @param int $stopOrder Порядковый номер остановки
     */
    public static function addStopToRoute($routeId, $stopId, $stopOrder)
    {
        $db = \App\Core\Database::getConnection();
        $stmt = $db->prepare("INSERT INTO route_stops (route_id, stop_id, stop_order) VALUES (:route_id, :stop_id, :stop_order)");
        $stmt->execute([
            'route_id' => $routeId,
            'stop_id' => $stopId,
            'stop_order' => $stopOrder
        ]);
    }
}