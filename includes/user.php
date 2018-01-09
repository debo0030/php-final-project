<?php
    class User extends DB_object {
        protected static $db_table = "User";
        protected static $db_table_fields = array('user_id', 'name', 'phone', 'password');
        public $user_id;
        public $name;
        public $phone;
        public $password;

        public static function verify_user($user_id, $password) {
            global $database;
            $user_id = $database->escape_string($user_id);
            $password = $database->escape_string($password);

            $sql = "SELECT * FROM  " . self::$db_table . "  WHERE ";
            $sql .= "user_id = '{$user_id}'";
            $sql .= "AND password = '{$password}'";
            $sql .= "LIMIT 1";

            $the_result_array = self::find_by_query($sql);
            return !empty($the_result_array) ? array_shift($the_result_array) : false;        
        }
        
        public static function check_user_id($user_id) {
            global $database;
            $user_id = $database->escape_string($user_id);
            $sql = "SELECT * FROM  " . self::$db_table . "  WHERE ";
            $sql .= "user_id = '{$user_id}'";
            $sql .= "LIMIT 1";
            $the_result_array = self::find_by_query($sql);
            return $the_result_array;       
        }        
        
        public static function get_all_albums($user_id)
        {
            
        }
    }