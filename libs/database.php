<?php

class database extends PDO {

    public function __construct($DBTYPE, $DBHOST, $DBNAME, $DBUSER, $DBPASS) {
        parent::__construct($DBTYPE . ':host=' . $DBHOST . ';dbname=' . $DBNAME, $DBUSER, $DBPASS);
//        parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * 
     * @param type $table Table name to get data
     * @param type $data Data want to get. Default : '*'
     * @param type $where WHERE condition. Default : NULL. Example : 'id = '$id'
     * @param type $fetch Fetch method. Default : 'fetchAll'
     * @param type $fetchMode Fetching data mode. Default : 'PDO::FETCH_ASSOC'
     * @return type Array data format
     */
    public function select($table, $data = "*", $where = NULL, $fetch = "fetchAll", $fetchMode = PDO::FETCH_ASSOC) {

        if ($where != NULL) {
            $where = "WHERE $where";
        }
        

        $sth = $this->prepare("SELECT $data FROM $table $where");
        $sth->execute();
        $data = $sth->$fetch($fetchMode);

        return $data;
    }

    public function count($table, $where = NULL) {
        if ($where != NULL) {
            $where = "WHERE $where";
        }

        $sth = $this->prepare("SELECT * FROM $table $where");
        $sth->execute();
        $data = $sth->rowCount();

        return $data;
    }

    /**
     * Insert
     * @param type $table Table name to insert data
     * @param type $data An associative array data
     */
    public function insert($table, $data) {
        ksort($data);

        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));

        $sth = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        return $sth->execute();
    }

    /**
     * 
     * @param type $table Table name to insert data
     * @param type $data An associative array data
     * @param type $where WHERE query part
     */
    public function update($table, $data, $where) {
        ksort($data);

        $fieldDetails = NULL;

        foreach ($data as $key => $value) {
            $fieldDetails .= "`$key` = :$key, ";
        }

        $fieldDetails = rtrim($fieldDetails, ', ');

        $sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        return $sth->execute();
    }

    /**
     * 
     * @param type $table Table that contain data to delete
     * @param type $where Condition select to delete
     */
    public function delete($table, $where, $limit = 1) {
        return $this->exec("DELETE FROM $table WHERE $where LIMIT $limit");
    }

}
