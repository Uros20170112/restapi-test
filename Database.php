<?php
class Database{
    private $hostname = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname;
    private $dblink;
    private $result;
    private $affected;
    private $records;

    function __construct($par_dbname){
        $this->dbname = $par_dbname;
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
        if($this->result = $this->dblink->query($query)){
            if(isset($this->result->num_rows)){
                $this->records = $this->result->num_rows;
            }
            if(isset($this->result->affected_rows)){
                $this->records = $this->result->affected_rows;
            }
        }
    }

    function getResult() {
        return $this->result;
    }

    function select($table="novosti",$rows="*",$join_table="kategorije",$join_key1="kategorija_id",$join_key2="id", $where =null, $order=null){
        $q = "SELECT ".$rows." FROM ".$table;
        //SELECT * FROM kategorije JOIN novosti ON novosti.kategorija_id = kategorije.id
        if($join_table != null) {
            $q.=' JOIN '.$join_table.' ON '.$table.'.'.$join_key1.'='.$join_table.'.'.$join_key2;
            //SELECT * FROM novosti JOIN kategorije ON novosti.kategorija_id = kategorije.id
            echo $q;
        }
        if($where!=null) {
            $q.=" WHERE ".$where;
        }
        if($order!=null) {
            $q.=" ORDER BY ".$order;
        }
        $this->ExecuteQuery($q)->getResult;
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
    
    function update($table, $id, $keys, $values){
        $query_values ="";
        $set_query = array();
        //echo $values[0];
        for($i =0; $i<sizeof($keys); $i++){
           $set_query[$i] = "$keys[$i] = $values[$i]";
        }
        $query_values = implode(",", $set_query);  
        $q = "UPDATE $table SET $query_values WHERE id=$id";
        if($this->ExecuteQuery($q) && $this->affected>0){
            return true;
        }else{
            return false;
        }
    }

    function delete($table, $id, $id_value){
        $q = "DELETE FROM $table WHERE $id=$id_value";
        if($this->ExecuteQuery($q)){
            return true;
        }else{
            return false;
        }
    }
}
?>