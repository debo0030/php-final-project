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
      
        public static function find_by_owner_id($id) {
            $the_result_array = static::find_by_query("SELECT * FROM  " . static::$db_table . "  WHERE owner_id = '$id'");
            return !empty($the_result_array) ? ($the_result_array) : false;
        }
        
        public static function find_album_by_id($id, $owner_id) {
            $the_result_array = static::find_by_query("SELECT * FROM  " . static::$db_table . "  WHERE album_id = '$id' AND owner_id = '$owner_id' LIMIT 1");
            return !empty($the_result_array) ? array_shift($the_result_array) : false;
        }
        
}