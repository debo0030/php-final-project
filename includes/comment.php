<?php

class Comment extends DB_object
{
        protected static $db_table = "Comment";
        protected static $db_table_fields = array('comment_id', 'author_id', 'picture_id', 'comment_text', 'date');
        public $comment_id; //db autoincrement
        public $author_id;
        public $picture_id;
        public $comment_text;
        public $date;
        
        public static function get_photo_comments($id)
        {
            $the_result_array = static::find_by_query("SELECT * FROM  " . static::$db_table . "  WHERE picture_id = '$id'");
            return !empty($the_result_array) ? $the_result_array : false;
        }
}
