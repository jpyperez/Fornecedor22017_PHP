<?php

require_once 'DB.php';

abstract class Crud extends DB {
    protected $table;
    protected $criado_em;
    abstract public function insert();
    abstract public function update($id);

    public function find($id){
        $sql = "select * from $this->table where id_$this->table = :id and status = 1";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function findAll() {
        $sql = "select * from $this->table where status = 1";
        $stmt = DB::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();        
    }

    public function delete($id) {
        $sql = "update $this->table set status = 0 where id_$this->table = :id";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}