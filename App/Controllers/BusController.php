<?php

namespace App\Controllers;

use App\Services\BusService;

class BusController
{
    private $busService;

    public function __construct()
    {
        $this->busService = new BusService();
    }

    // Метод для поиска автобусов по маршруту
    public function findBus($from, $to)
    {
        $buses = $this->busService->findBuses($from, $to);
        header('Content-Type: application/json');
        echo json_encode($buses);
    }

    // Метод для редактирования маршрутов
    public function editRoute($routeId, $newStops)
    {
        $result = $this->busService->editRoute($routeId, $newStops);
        header('Content-Type: application/json');
        echo json_encode($result);
    }
}
