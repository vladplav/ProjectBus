<?php
namespace App\Models;
use PDO;

class EditStop
{
    /**
     * Находит остановку по ее ID.
     *
     * @param int $id Идентификатор остановки
     * @return object|null Объект остановки или null, если не найдена
     */
    public static function findStopById($id)
    {
        $db = \App\Core\Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM stops WHERE id = :id");
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
