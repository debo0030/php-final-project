<?php

class Album extends DB_object
{
        protected static $db_table = "Album";
        protected static $db_table_fields = array('album_id', 'title', 'description', 'date_updated', 'owner_id', 'accessibility_code');
        public $album_id; //db autoincrement
        public $title;
        public $description;
        public $date_updated;
        public $owner_id;
        public $accessibility_code;
        
        public static function deleteAlbum($albumId) {
             global $database;        
            $sql = "DELETE FROM  " . static::$db_table . "  ";
             $sql .= "WHERE album_id= '" . $database->escape_string($albumId) . "'";
            $sql .= " LIMIT 1";
            $database->query($sql);
            return (mysqli_affected_rows($database->connection) == 1) ? true : false; 

            
        }
}