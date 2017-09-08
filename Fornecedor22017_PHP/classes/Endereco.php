<?php

require_once 'Crud.php';
require_once 'Historico.php';

class Endereco extends Crud {
    protected $table = 'endereco';
    private $id;
    private $rua;
    private $num;
    private $cidade;
    private $estado;
    private $pais;
    private $cep;
    private $obs;
    private $status;
    
    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setRua($rua) {
        $this->rua = $rua;
    }

    public function getRua() {
        return $this->rua;
    }

    public function setNum($num) {
        $this->num = $num;
    }

    public function getNum() {
        return $this->num;
    }

    public function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    public function getCidade() {
        return $this->cidade;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setPais($pais) {
        $this->pais = $pais;
    }

    public function getPais() {
        return $this->pais;
    }

    public function setCep($cep) {
        $this->cep = $cep;
    }

    public function getCep() {
        return $this->cep;
    }

    public function setObs($obs) {
        $this->obs = $obs;
    }

    public function getObs() {
        return $this->obs;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getStatus() {
        return $this->status;
    }

    public function insert(){}        

    public function insertSpecial($id) {     
        $sql = "insert into $this->table (rua, num, cidade, estado, pais, cep, obs, criado_em, fornecedor_id, status) " .
            "values (:rua, :num, :cidade, :estado, :pais, :cep, :obs, '" . date("Y-m-d H:i:s") . "', :fornecedor_id, '1')";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':rua', $this->rua);
        $stmt->bindParam(':num', $this->num);
        $stmt->bindParam(':cidade', $this->cidade);
        $stmt->bindParam(':estado', $this->estado);
        $stmt->bindParam(':pais', $this->pais);
        $stmt->bindParam(':cep', $this->cep);
        $stmt->bindParam(':obs', $this->obs);
        $stmt->bindParam(':fornecedor_id', $id, PDO::PARAM_INT);    
        return $stmt->execute();
    }

    public function update($id) {
        $historico = new Historico();
        $historico->insertHistoricEndereco($id);

        $sql = "update $this->table set rua = :rua, num = :num, cidade = :cidade, estado = :estado, pais = :pais, cep = :cep, " .
            "obs = :obs, status = :status where id_$this->table = :id";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':rua', $this->rua);
        $stmt->bindParam(':num', $this->num);
        $stmt->bindParam(':cidade', $this->cidade);
        $stmt->bindParam(':estado', $this->estado);
        $stmt->bindParam(':pais', $this->pais);
        $stmt->bindParam(':cep', $this->cep);
        $stmt->bindParam(':obs', $this->obs);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}