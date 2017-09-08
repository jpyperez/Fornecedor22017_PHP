<?php

require_once 'Crud.php';

class Categoria extends Crud {
    protected $table = 'categoria';
    private $id = 0;
    private $nome = "";
    
    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function insert() { }

    public function update($id) { }
}