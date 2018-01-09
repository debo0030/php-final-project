<?php
    function ValidateStudentID($FieldName) {
        $StudentID = trim($FieldName);
        if (strlen($StudentID) == 0) {
            $errorStudentID = "Student ID field can not be blank.";
        } elseif (!empty (User::check_user_id($FieldName))) {
            $errorStudentID = "A student with this ID is already exist in the database.";
        } else {
            $errorStudentID = "";
        }
        return $errorStudentID;    
    }
    
    function ValidateID($FieldName) {
        $StudentID = trim($FieldName);
        if (strlen($StudentID) == 0) {
            $errorStudentID = "Student ID field can not be blank.";
        } else {
            $errorStudentID = "";
        }
        return $errorStudentID;    
    }

    function ValidateStudentName($FieldName) {
        $StudentName = trim($FieldName);
        if (strlen($StudentName) == 0) {
            $errorStudentName = "Name field can not be blank.";
        } else {
            $errorStudentName = "";
        }
        return $errorStudentName;    
    }

    function ValidatePhoneNumber($FieldName) {
        $PhoneNumber = trim($FieldName);
        if (strlen($PhoneNumber) == 0) {
            $errorPhoneNumber = "Phone Number field can not be blank.";
        } elseif (!preg_match("#[2-9][0-9][0-9]-[2-9][0-9][0-9]-[0-9][0-9][0-9][0-9]$#", $PhoneNumber)) {
            $errorPhoneNumber = "Phone Number is not valid.";
        } else {
            $errorPhoneNumber = "";
        }
        return $errorPhoneNumber;
    }

    function ValidatePassword($FieldName) {
        $Password = trim($FieldName);
        if (strlen($Password) == 0) {
            $errorPassword = "Password field can not be blank.";
        } elseif (!preg_match("#(?=.*[a-z])(?=.*[A-Z])[a-zA-Z\d]{6,}$#", $Password)) {
            $errorPassword = "Password is not valid.";
        } else {
            $errorPassword = "";
        }
        return $errorPassword;
    }

    function ValidatePasswordAgain($FieldName1, $FieldName2) {
        $PasswordAgain = trim($FieldName1);
        $Password = trim($FieldName2);
        if (strlen($PasswordAgain) == 0) {
            $errorPasswordAgain = "Password Again field can not be blank.";
        } elseif (!preg_match("#(?=.*[a-z])(?=.*[A-Z])[a-zA-Z\d]{6,}$#", $PasswordAgain)) {
            $errorPasswordAgain = "Password Again is not valid.";
        } elseif ($PasswordAgain != $Password) {
            $errorPasswordAgain = "Password and Password Again must be the same.";
        } else {
            $errorPasswordAgain = "";
        }
        return $errorPasswordAgain;
    }
    
    function ValidateStudentPassword($FieldName) {
        $StudentPassword = trim($FieldName);
        if (strlen($StudentPassword) == 0) {
            $errorStudentPassword = "Password field can not be blank.";
        } else {
            $errorStudentPassword = "";
        }
        return $errorStudentPassword;    
    }
    
    function classAutoLoader($class) {
        $class = strtolower($class);
        $the_path = "includes/{$class}.php";
        if (is_file($the_path) && !class_exists($class)) {
            include $the_path;
        }
    }

    spl_autoload_register('classAutoLoader');

    function redirect($location) {
        header("Location: {$location}");
    }
    
    function ValidateTitle($title)
    {

        if (empty($title))
        {
            $errorTitle = "Enter a title.";
        }
        else
        {
            $errorTitle = "";
        }
        return $errorTitle;
    }
    
    function ValidateAccess($accessibilty)
    {
        if ($accessibilty == NULL)
        {
          $errorAccess = "Must select one";
        }
        else
        {
            $errorAccess = "";
        }
        return $errorAccess;
    }
