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
    var $db, $id, $firstname, $insertion, $lastname, $password, $email, $year, $admin;
    var $exists;
    
    function __construct($db, $id, $password = "") {
        $this->db = $db;
        $sql = "";
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
            $this->admin = $fields['admin'];
            $this->exists = true;
        } else {
            $this->exists = false;
        }
    }

    function getProject() {
        return $this->db->doQuery("
            SELECT `projects`.name as `name`
            FROM `projects`, `studenten`
            AND `projects`.llnr = `studenten`.id
            AND `studenten`.id = '" . $this->id . "';
        ");
    }

    function getTeams() {
        return $this->db->doQuery("
            SELECT `teams`.teamname as `name`, `teams`.projectid as `projectid`
            FROM `teams`, `teamleden`, `studenten`
            AND `teamleden`.llnr = `studenten`.id
            AND `studenten`.id = '" . $this->id . "';
        ");
    }

    function getFullName() {
        return $this->firstname . ' ' . $this->insertion . ' ' . $this->lastname;
    }
}

?>
