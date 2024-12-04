<?php
class MySQLCN 
{
    function MySQLCN() {
        $user = DB_USERNAME;
        $pass = DB_PASSWORD;
        $server = DB_SERVER;
        $dbase = DB_DATABASE;
        $conn = mysql_connect($server, $user, $pass);
		
		
		mysql_query("set names 'utf8'",$conn)or die(mysql_error());
		mysql_query("SET character_set_client=utf8", $conn)or die(mysql_error());
		mysql_query("SET character_set_connection=utf8", $conn)or die(mysql_error());
		
        if (!$conn) {
            $this->error("Connection attempt failed");
        }if (!mysql_select_db($dbase, $conn)) {
            $this->error("Dbase Select failed");
        }
        $this->CONN = $conn;
        return true;
    }

    function close() {
        $conn = $this->CONN;
        $close = mysql_close($conn);
        if (!$close) {
            $this->error("Connection close failed");
        }
        return true;
    }

    function error($text) {
        $no = mysql_errno();
        $msg = mysql_error();
        exit;
    }

    function select($sql = "") {
        if (empty($sql)) {
            return false;
        }
        if (empty($this->CONN)) {
            return false;
        }
        $conn = $this->CONN;
        $results = @mysql_query($sql, $conn);

        if ((!$results) or (empty($results))) {
            return false;
        }
        $count = 0;
        $data = array();
        while ($row = mysql_fetch_array($results)) {
            foreach ($row as $key => $value) {
                if (!is_array($value)) {
                    $row[$key] = htmlspecialchars_decode($value, ENT_QUOTES);
                }
            }
            $data[$count] = $row;
            $count++;
        }
        /* echo "<br/>Full Data<pre>";
          print_r($data);
          echo "</pre>"; */
        mysql_free_result($results);
        return $data;
    }

    function selectForJson($sql = "") {
        if (empty($sql)) {
            return false;
        }if (empty($this->CONN)) {
            return false;
        }
        $conn = $this->CONN;
        $data = array();
        $results = @mysql_query($sql, $conn);
        if ((!$results) or (empty($results))) {
            return $data;
        }
        $count = 0;
        while ($row = mysql_fetch_assoc($results)) {
            foreach ($row as $key => $value) {
                if (!is_array($value)) {
                    $row[$key] = htmlspecialchars_decode($value, ENT_QUOTES);
                }
            }
            $data[$count] = $row;
            $count++;
        }
        /* echo "<br/>Full Data<pre>";
          print_r($data);
          echo "</pre>"; */

        mysql_free_result($results);
        return $data;
    }

    function insert($sql = "") {
        if (empty($sql)) {
            return false;
        }if (empty($this->CONN)) {
            return false;
        }
        $conn = $this->CONN;
        $results = mysql_query($sql, $conn);

        if (!$results) {
            echo "Insert Operation Failed..<hr>" . mysql_error();
            $this->error("Insert Operation Failed..");
            $this->error("<H2>No results!</H2>\n");
            return false;
        }
        $id = mysql_insert_id($this->CONN);
        mysql_free_result($results);
        return $id;
    }

    function update_query($sql = "") {
        if (empty($sql)) {
            return false;
        }if (empty($this->CONN)) {
            return false;
        }
        $conn = $this->CONN;
        $results = mysql_query($sql, $conn);

        if (!$results) {
            echo "Update Operation Failed..<hr>" . mysql_error();
            $this->error("Update Operation Failed..");
            $this->error("<H2>No results!</H2>\n");
            return false;
        }
        return mysql_affected_rows($this->CONN);
    }
    
    function delete_query($sql = "") {
        if (empty($sql)) {
            return false;
        }if (empty($this->CONN)) {
            return false;
        }
        $conn = $this->CONN;
        $results = mysql_query($sql, $conn);

        if (!$results) {
            echo "Delete Operation Failed..<hr>" . mysql_error();
            $this->error("Delete Operation Failed..");
            $this->error("<H2>No results!</H2>\n");
            return false;
        }
//        mysql_free_result($results);
        return $results;
    }

    function sql_query($sql = "") {
        if (empty($sql)) {
            return false;
        }if (empty($this->CONN)) {
            return false;
        }
        $conn = $this->CONN;

        $results = mysql_query($sql, $conn) or die("Query Failed..<hr>" . mysql_error());
        if (!$results) {
            $message = "Query went bad!";
            $this->error($message);
            return false;
        }
        $count = 0;
        $data = array();
        while ($row = mysql_fetch_array($results)) {
            $data[$count] = $row;
            $count++;
        }
        mysql_free_result($results);
        return $data;
    }

//ends the class over here
}

?>