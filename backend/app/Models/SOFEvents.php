<?php


namespace App\Models;

use Mvc\Model;

class SOFEvents extends Model
{
    public static function getByIdWithSTDEvents($id)
    {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT * FROM sof_events INNER JOIN std_events ON sof_events.STD_EVENT_CODE = std_events.STD_EVENT_CODE WHERE sof_events.SOF_ID=:id ORDER BY sof_events.DATE_TIME ASC");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

