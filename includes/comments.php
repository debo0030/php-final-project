<?php

class Comments extends DB_object
{
        protected static $db_table = "Comments";
        protected static $db_table_fields = array('comment_id', 'author_id', 'picture_id', 'comment_text', 'date');
        public $comment_id; //db autoincrement
        public $author_id;
        public $picture_id;
        public $comment_text;
        public $date;
}
