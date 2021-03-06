<?php

Class database {

    var $connection;
    var $database;
    var $logger;

    function __construct($logger) {
        $this->logger = $logger;
        $this->makeConnection(true);
    }

    function makeConnection($new) {
        require "configs/config.php";
        $this->connection = @mysql_connect($db_host, $db_username, $db_password, $new);
        if ($this->connection) {
            $this->database = @mysql_select_db($db_name);
            if ($this->database) {
                return true;
            } else {
                $this->logger->writeToLog("Couldn't connect to database: $db_name.");
                return false;
            }
        } else {
            $this->logger->writeToLog("Couldn't connect to mysql:\nhost: $db_host\nusername:$db_username\npassword:$db_password");
            return false;
        }
    }

    function doQuery($sql) {
        if ($this->makeConnection(false)) {
            $result = @mysql_query($sql) or $this->logger->writeToLog("Query failure:$sql.");
            if ($result && @mysql_num_rows($result) > 0) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function getRowCount($sql) {
        if ($this->makeConnection(false)) {
            $result = @mysql_query($sql) or $this->logger->writeToLog("Query failure:$sql.");
            if ($result) {
                return @mysql_num_rows($result);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}

?>