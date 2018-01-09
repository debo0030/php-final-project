<?php

    class Photo extends DB_object {
        protected static $db_table = "Picture";
        protected static $db_table_fields = array('picture_id', 'album_id', 'i', 'title', 'description', 'date_added');
        public $picture_id;
        public $album_id;
        public $file_name;
        public $title;
        public $description;
        public $date_added;
        
        public $tmp_path;
        public $upload_directory = "images";
        public $errors = array();
        public $upload_errors_array = array(
            UPLOAD_ERR_OK           =>  "There is no error, the file uploaded with success.",
            UPLOAD_ERR_INI_SIZE     =>  "The uploaded file exceeds the upload_max_filesize directive in php.ini.",
            UPLOAD_ERR_FORM_SIZE    =>  "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.",
            UPLOAD_ERR_PARTIAL      =>  "The uploaded file was only partially uploaded.",
            UPLOAD_ERR_NO_FILE      =>  "No file was uploaded.",
            UPLOAD_ERR_NO_TMP_DIR   =>  "Missing a temporary folder.",
            UPLOAD_ERR_CANT_WRITE   =>  "Failed to write file to disk.",
            UPLOAD_ERR_EXTENSION    =>  "A PHP extension stopped the file upload."
        );

	public function set_file($file) {
            if (empty($file) || !$file || !is_array($file)) {
                $this->errors[] = "No file was uploaded.";
                return false;
            } elseif ($file['error'] !=0) {
                $this->errors[] = $this->upload_errors_array[$file['error']];
                return false;
            } else {
                $this->file_name = basename($file['name']);
                $this->tmp_path = $file['tmp_name'];
            }        
        }

	public function save() {
            if ($this->picture_id) {
                $this->update();
            } else {
                if (!empty($this->errors)) {
                    return false;
                }
                if (empty($this->file_name) || empty($this->tmp_path)) {
                    $this->errors[] = "The file is not available.";
                    return false;
                }
                $target_path = SITE_ROOT.DS.'admin'.DS.$this->upload_directory.DS.$this->file_name;
                if (file_exists($target_path)) {
                    $this->errors[] = "The file {$this->file_name} already exists.";
                    return false;
                }
                if (move_uploaded_file($this->tmp_path, $target_path)) {
                    if ($this->create()) {
                        unset($this->tmp_path);
                        return true;
                    }
                } else {
                    $this->errors[] = "The destination directory does not have permission to write the file.";
                    return false;
                }                
            }
        }
        
        
        public static function getPictures() 
        {
        $pictures = array();
        $files = scandir(THUMBNAIL_DIR);
        $numFiles = count($files);
        
        if ($numFiles > 2) {
            for ($i = 2; $i < $numFiles; $i++) {
                $ind = strrpos($files[$i], "/");
                $file_name = substr($files[$i], $ind); //returns just the picture name, not directory
                $picture = new Picture ($file_name, $i); //calls constructor
                $pictures["$i"] = $picture; //adds to array
            }
        }
        return $pictures; //returns array
        }

        public static function getPictureById($id = "") {
            $pictures = self::getPictures();
            foreach($pictures as $pic)
            {
                if($pic->getId() == $id)
                {
                    return $pic;
                }
            }

            return false;
        }

        public function getId() {
            return $this->picture_id;
        }
    
        public function getName () {
            $ind = strrpos($this->file_name, ".");
            $name = substr($this->file_name, 0, $ind);
            return $name;
        }

        public static function get_all_photos($album_id)
        {
            global $database;
            $album_id = $database->escape_string($album_id);

            $sql = "SELECT * FROM  " . self::$db_table . " ";
            $sql .= "WHERE album_id = '{$album_id}'";

            $the_result_array = self::find_by_query($sql);
            return !empty($the_result_array) ? array_shift($the_result_array) : false;        
        }
        
        public function getAlbumFilePath() {
        return ALBUM_PICTURES_DIR."/".$this->file_name;
        }

        public function getThumbnailFilePath() {
            return THUMBNAIL_DIR."/".$this->file_name;
        }

        public function getOriginalFilePath() {
            return ORIGINAL_PICTURES_DIR."/".$this->file_name;
        }
        
        function save_uploaded_file ($destinationPath, $j=0) {
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath); 
            }

            $tempFilePath = $_FILES['txtUpload']['tmp_name'][$j]; //variable to temporary file
            $filePath = $destinationPath."/".$_FILES['txtUpload']['name'][$j];

            $pathInfo = pathinfo($filePath);
            $dir = $pathInfo['dirname'];
            $fileName = $pathInfo['filename'];
            $ext = $pathInfo['extension']; //JPEG, GIF, PNG

            //adds int to file name to not overwrite existing files
            $i="";
            while (file_exists($filePath)) {
                $i++;
                $filePath = $dir."/".$fileName."_".$i.".".$ext;
            }
            move_uploaded_file($tempFilePath, $filePath);

            return $filePath;
        }
        
        function resamplePicture($filePath, $destinationPath, $maxWidth, $maxHeight) {
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath);
            }

            $imageDetails = getimagesize($filePath);
            $originalFile = null;

            //create a new image from file
            if ($imageDetails[2] == IMAGETYPE_JPEG) {
                $originalFile = imagecreatefromjpeg($filePath);
            }
            elseif ($imageDetails[2] == IMAGETYPE_PNG) {
                $originalFile = imagecreatefrompng($filePath);
            }
            elseif ($imageDetails[2] == IMAGETYPE_GIF) {
                $originalFile = imagecreatefromgif($filePath);
            }

            $widthRatio = $imageDetails[0] / $maxWidth;
            $heightRatio = $imageDetails[1]/ $maxHeight;
            $ratio = max($widthRatio, $heightRatio);

            $newWidth = $imageDetails[0] / $ratio;
            $newHeight = $imageDetails[1] / $ratio;

            $newImage = imagecreatetruecolor($newWidth, $newHeight);

            $success = imagecopyresampled($newImage, $originalFile, 0, 0, 0, 0, $newWidth, $newHeight, $imageDetails[0], $imageDetails[1]);

            if (!success) {
                imagedestroy($newImage);
                imagedestroy($originalFile);
                return "";
            }

            $pathinfo = pathinfo($filePath);
            $newFilePath = $destinationPath."/".$pathinfo['filename'];

            if ($imageDetails[2] == IMAGETYPE_JPEG) {
                $newFilePath .=".jpg";
                $success = imagejpeg($newImage, $newFilePath, 100);
            }
            elseif ($imageDetails[2] == IMAGETYPE_PNG) {
                $newFilePath .=".png";
                $success = imagepng($newImage, $newFilePath, 0);
            }
            elseif ($imageDetails[2] == IMAGETYPE_GIF) {
                $newFilePath .=".gif";
                $success = imagegif($newImage, $newFilePath);
            }

            imagedestroy($newImage);
            imagedestroy($originalFile);

            if (!$success) {
                return "";
            }
            else {
               return $newFilePath;    
             }
        }

    function rotateImage($filePath, $degrees) {

        $imageDetails = getimagesize($filePath);

        $originalFile = null;

        if ($imageDetails[2] == IMAGETYPE_JPEG) {
            $originalFile = imagecreatefromjpeg($filePath);
        }
        elseif ($imageDetails[2] == IMAGETYPE_PNG) {
            $originalFile = imagecreatefrompng($filePath);
        }
        elseif ($imageDetails[2] == IMAGETYPE_GIF) {
            $originalFile = imagecreatefromgif($filePath);
        }

        $rotatedFile = imagerotate($originalFile, $degrees, 0);

        if ($imageDetails[2] == IMAGETYPE_JPEG) {
            $success = imagejpeg($rotatedFile, $filePath, 100);
        }
        elseif ($imageDetails[2] == IMAGETYPE_PNG) {
            $success = imagepng($rotatedFile, $filePath, 0);
        }
        elseif ($imageDetails[2] == IMAGETYPE_GIF) {
            $success = imagegif($rotatedFile, $filePath);
        }

        imagedestroy($rotatedFile);
        imagedestroy($originalFile);
    }
    }