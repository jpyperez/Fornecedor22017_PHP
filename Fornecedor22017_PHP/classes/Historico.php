<?php

require_once 'Crud.php';
require_once 'Fornecedor.php';
require_once 'Endereco.php';

class Historico{

    public function insertHistoricFornecedor($id) {
        $fornecedor = new Fornecedor();
        $resultado = $fornecedor->find($id);
        $sql = "insert into fornecedor_historico (nome, cnpj, ie, ci, categoria_id, dt_fund, criado_em, atualizado_em, status, funcionario_id, fornecedor_id) " .
            "values (:nome, :cnpj, :ie, :ci, :categoria_for, :dt_fund, :criado_em, :atualizado_em, :status, :funcionario_id, :fornecedor_id)";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':nome', $resultado->nome);
        $stmt->bindParam(':cnpj', $resultado->cnpj);
        $stmt->bindParam(':ie', $resultado->ie);
        $stmt->bindParam(':ci', $resultado->ci);
        $stmt->bindParam(':categoria_for', $resultado->categoria_id);
        $stmt->bindParam(':dt_fund', $resultado->dt_fund);
        $stmt->bindParam(':criado_em', $resultado->dt_fund);
        $stmt->bindParam(':atualizado_em', $resultado->atualizado_em);
        $stmt->bindParam(':status', $resultado->status);
        $stmt->bindParam(':funcionario_id', $resultado->funcionario_id);
        $stmt->bindParam(':fornecedor_id', $id);
        return $stmt->execute();
    }

    public function insertHistoricEndereco($id) {
        $endereco = new Endereco();
        $resultado = $endereco->find($id);
        
        $sql = "insert into endereco_historico (rua, num, cidade, estado, pais, cep, obs, criado_em, fornecedor_id, status, endereco_id) " .
            "values (:rua, :num, :cidade, :estado, :pais, :cep, :obs, '" . date("Y-m-d H:i:s") . "', :fornecedor_id, '1', :endereco_id)";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':rua', $resultado->rua);
        $stmt->bindParam(':num', $resultado->num);
        $stmt->bindParam(':cidade', $resultado->cidade);
        $stmt->bindParam(':estado', $resultado->estado);
        $stmt->bindParam(':pais', $resultado->pais);
        $stmt->bindParam(':cep', $resultado->cep);
        $stmt->bindParam(':obs', $resultado->obs);
        $stmt->bindParam(':fornecedor_id', $resultado->fornecedor_id);    
        $stmt->bindParam(':endereco_id', $id);    
        return $stmt->execute();
    }
    
}



        