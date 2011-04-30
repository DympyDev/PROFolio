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
    var $id, $username, $firstname, $insertion, $lastname, $password, $email, $year;
    
    function __construct($id) {
        $query = "SELECT * FROM `studenten` WHERE `id` = '" . $id . "';";
        $fields = mysql_fetch_assoc(mysql_query($query));
        
        $this->id = $id;
        $this->username = ucfirst($fields['username']);
        $this->firstname = ucfirst($fields['firstname']);
        $this->insertion = $fields['insertion'];
        $this->lastname = ucfirst($fields['lastname']);
        $this->password = $fields['password'];
        $this->email = $fields['email'];
        $this->year = $fields['year'];
    }
}

?>
