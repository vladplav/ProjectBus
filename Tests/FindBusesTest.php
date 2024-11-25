<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Services\BusService;

class FindBusesTest extends TestCase
{
    private $busService;

    protected function setUp(): void
    {
        $this->busService = new BusService();
    }

    public function testFindBuses()
    {
		// Ожидаемый результат
		$expected = [
			'from' => 'ул. Пушкина',
			'to' => 'ул. Ленина',
			'buses' => [
				[
					'route' => 'Автобус №11 в сторону ост. Попова',
					'next_arrivals' => ['08:15', '08:40', '09:15'],
				],
				[
					'route' => 'Автобус №21 в сторону ост. Ленина',
					'next_arrivals' => ['08:30', '09:04', '09:30'],
				],
			],
		];


        // Получение реального результата
        $result = $this->busService->findBuses("ул. Пушкина", "ул. Ленина");

        // Проверка, что результат соответствует ожидаемому
        $this->assertEquals($expected, $result);
    }
}
