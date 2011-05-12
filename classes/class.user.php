<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author Dark
 */
class user {
    var $db, $id, $firstname, $insertion, $lastname, $password, $email, $year;
    var $exists;
    
    function __construct($db, $id, $password = "") {
        $this->db = $db;
        if ($password == "") {
            $sql = "SELECT * FROM `studenten` WHERE `id` = '$id';";
        } else {
            $sql = "SELECT * FROM `studenten` WHERE `id` = '$id' AND `password` = '$password';";
        }

        $query = $this->db->doQuery($sql);
        if ($query != false) {
            $fields = mysql_fetch_assoc($query);

            $this->id = $id;
            $this->firstname = ucfirst($fields['firstname']);
            $this->insertion = $fields['insertion'];
            $this->lastname = ucfirst($fields['lastname']);
            $this->password = $fields['password'];
            $this->email = $fields['email'];
            $this->year = $fields['year'];
            $this->exists = true;
        } else {
            $this->exists = false;
        }
    }
}

?>
