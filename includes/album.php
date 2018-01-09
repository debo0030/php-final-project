<?php

class Album extends DB_object
{
        protected static $db_table = "Album";
        protected static $db_table_fields = array('album_id', 'title', 'description', 'date_updated', 'owner_id', 'accessibility_code');
        public $album_id; 
        public $title;
        public $description;
        public $date_updated;
        public $owner_id;
        public $accessibility_code;
        
        
}