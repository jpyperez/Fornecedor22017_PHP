<?php

require_once 'Crud.php';

class Funcionario extends Crud {
    protected $table = 'funcionario';
    private $id = 0;
    private $nome = "";
    
    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getNome() {
        return $this->nome;
    }

    public function insert() { }

    public function update($id) { }
}