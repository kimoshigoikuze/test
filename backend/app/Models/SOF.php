<?php


namespace App\Models;

use Mvc\Model;

class SOF extends Model
{
 public static function all() {
     $db = static::getDB();
     $stmt = $db->query("SELECT id, DAD_DA_Reference FROM sofs");
     return $stmt->fetchAll(\PDO::FETCH_ASSOC);
 }
}