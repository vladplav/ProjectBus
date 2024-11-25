<?php

namespace App\Services;

use App\Models\Route;
use App\Models\Arrival;
use App\Models\EditRoute;
use App\Models\EditStop;

class BusService
{
    public function findBuses($from, $to)
    {
        $routes = Route::findRoutesBetweenStops($from, $to);
        $buses = [];

        foreach ($routes as $route) {
            $arrivals = Arrival::findNextArrivals($route->id, $from);
            $buses[] = [
                'route' => $route->name,
                'next_arrivals' => $arrivals
            ];
        }

        return [
            'from' => $from,
            'to' => $to,
            'buses' => $buses
        ];
    }
    /**
     * Редактирует маршрут, заменяя старые остановки новыми с учетом их порядка.
     *
     * @param int $routeId Идентификатор маршрута
     * @param array $newStops Массив ID новых остановок
     * @return array Ответ с подтверждением успешности операции
     */
    public function editRoute($routeId, $newStops)
    {
        // Шаг 1: Найти маршрут по ID
        $route = EditRoute::findById($routeId);
        
        if (!$route) {
            return [
                'success' => false,
                'message' => 'Маршрут не найден.'
            ];
        }

        // Шаг 2: Удалить старые остановки маршрута
        EditRoute::deleteStopsByRouteId($routeId);

        // Шаг 3: Добавить новые остановки с учетом их порядка
        $stopOrder = 1;
        foreach ($newStops as $stopId) {
            // Проверим, существует ли остановка с таким ID
            $stop = EditStop::findStopById($stopId);
            if ($stop) {
                EditRoute::addStopToRoute($routeId, $stopId, $stopOrder);
                $stopOrder++;
            } else {
                return [
                    'success' => false,
                    'message' => "Остановка с ID {$stopId} не найдена."
                ];
            }
        }

        return [
            'success' => true,
            'message' => 'Маршрут успешно отредактирован.'
        ];
    }
}