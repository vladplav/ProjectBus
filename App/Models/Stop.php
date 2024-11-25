<?php

namespace App\Models;

use PDO;

class Stop
{
    public static function findStopById($id)
    {
        $db = \App\Core\Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM stops WHERE id = :id");
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
