<?php

namespace App\Models;

use PDO;

class Arrival
{
	public static function findNextArrivals($routeId, $from)
	{
		$sql = "
			SELECT TO_CHAR(a.arrival_time, 'HH24:MI') AS arrival_time
			FROM arrivals a
			JOIN stops s ON a.stop_id = s.id
			WHERE a.route_id = :route_id AND s.name = :from
			ORDER BY a.arrival_time
			LIMIT 5;
		";

		$stmt = \App\Core\Database::getConnection()->prepare($sql);
		$stmt->bindParam(':route_id', $routeId);
		$stmt->bindParam(':from', $from);
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_COLUMN);
	}
}
