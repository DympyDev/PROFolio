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
    var $exists = false;

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
            $this->year = $fields['year'] . ' - ' . ($fields['year'] + 1);
            $this->admin = $fields['admin'];
            $this->exists = true;
        }
    }

    function getProjects() {
        $projects = array();
        $i = 0;
        $result = $this->db->doQuery("
            SELECT `projects`.name as `name` FROM `teamleden`, `teams`, `projects`
            WHERE `teamleden`.llnr = '" . $this->id . "'
            AND `teams`.teamnr = `teamleden`.teamnr
            AND `projects`.projectid = `teams`.projectid;
        ");
        $result2 = $this->db->doQuery("
            SELECT `name` FROM `projects` WHERE `llnr` = '" . $this->id . "';
        ");
        if ($result != false) {
            while ($fields = mysql_fetch_assoc($result)) {
                if (!in_array($fields['name'], $projects)) {
                    $projects[$i] = $fields['name'];
                    $i++;
                }
            }
        }
        if ($result2 != false) {
            while ($fields = mysql_fetch_assoc($result2)) {
                if (!in_array($fields['name'], $projects)) {
                    $projects[$i] = $fields['name'];
                    $i++;
                }
            }
        }
        return $projects;
    }

    function getTeams() {
        return $this->db->doQuery("
            SELECT `teams`.teamname as `name`, `teams`.projectid as `projectid`
            FROM `teams`, `teamleden`, `studenten`
            WHERE `teamleden`.llnr = `studenten`.id
            AND `studenten`.id = '" . $this->id . "';
        ");
    }

    function getFullName() {
        return $this->firstname . ' ' . $this->insertion . ' ' . $this->lastname;
    }

}

?>
