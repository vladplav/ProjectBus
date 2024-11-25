<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Services\BusService;

class EditRouteTest extends TestCase
{
    private $busService;

    protected function setUp(): void
    {
        $this->busService = new BusService();
    }
    // Тест для успешного редактирования маршрута
    public function testEditRouteSuccess()
    {
        // Создаем ID маршрута, который будем редактировать
        $routeId = 1;

        // Создаем массив новых остановок для маршрута
        $newStops = [1, 2, 3]; // Предположим, что это ID существующих остановок

        // Вызываем метод editRoute
        $response = $this->busService->editRoute($routeId, $newStops);

        // Проверяем, что ответ успешный
        $this->assertTrue($response['success']);
        $this->assertEquals('Маршрут успешно отредактирован.', $response['message']);
    }
	// Тест для случая, когда одна из остановок не существует
    public function testEditRouteWithInvalidStop()
    {
        // Создаем ID маршрута
        $routeId = 1;

        // Создаем массив новых остановок, одна из которых не существует (например, ID 999)
        $newStops = [1, 999, 3];

        // Вызываем метод editRoute
        $response = $this->busService->editRoute($routeId, $newStops);

        // Проверяем, что операция не прошла успешно
        $this->assertFalse($response['success']);
        $this->assertEquals('Остановка с ID 999 не найдена.', $response['message']);
    }

    // Тест для случая, когда маршрут не существует
    public function testEditRouteWithNonExistentRoute()
    {
        // Создаем несуществующий ID маршрута
        $routeId = 999;

        // Создаем массив новых остановок
        $newStops = [1, 2, 3];

        // Вызываем метод editRoute
        $response = $this->busService->editRoute($routeId, $newStops);

        // Проверяем, что маршрут не найден
        $this->assertFalse($response['success']);
        $this->assertEquals('Маршрут не найден.', $response['message']);
    }
}
