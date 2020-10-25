<?php
class Database{
    private $hostname = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname;
    private $dblink;
    private $results;
    private $affected;
    private $records;

    function __construct($dbname){
        $this->dbname = $dbname;
        $this->Connect();
    }

    function Connect() {
        $this->dblink = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);
        if($this->dblink->connect_errno) {
            printf("Konekcija neuspesna %s", $this->dblink->connect_errno);
            exit();
        }
        $this->dblink->set_charset("utf8");
    }
    function ExecuteQuery($query){
        if($this->results = $this->dblink->query($query)){
            if(isset($this->results->num_rows)){
                $this->records = $this->results->num_rows;
            }
            if(isset($this->results->affected_rows)){
                $this->records = $this->results->affected_rows;
            }
        }
    }

    function getResults() {
        return $this->results;
    }

    function select($table="novosti", $rows="*", $join_table="kategorije", $join_key1="kategorija_id", $where=null, $order=null){
        $q = "SELECT ".$rows."FROM ".$table;
        if($join_table != null) {
            $q.=" JOIN ".$join_table." ON ".$table.".".$join_key1." = ".$join_key2;
        }
        if($where!=null) {
            $q.=" WHERE ".$where;
        }
        if($order!=null) {
            $q.=" ORDER BY ".$order;
        }
        $this->ExecuteQuery($q);
    }

    function insert($table="novosti", $rows="naslov, tekst, kategorija_id, datumvreme", $values){
        $query_values = implode(",", $values);
        $q = "INSERT INTO ".$table;
        if($rows != null) {
            $q.="(".$rows.")";
        }
        $q.=" VALUES (".$query_values.")";
        if($this->ExecuteQuery($q)) {
            return true;
        } else {
            return false;
        }
    }
}
?>