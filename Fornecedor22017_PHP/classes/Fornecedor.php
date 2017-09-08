<?php

require_once 'Crud.php';
require_once 'Historico.php';
require_once 'Funcionario.php';
require_once 'Categoria.php';

class Fornecedor extends Crud {
    protected $table = 'fornecedor';
    private $nome;
    private $cnpj;
    private $ie;
    private $ci;
    private $categoria_for;
    private $dt_fund;
    private $status;
    private $endereco;
    private $funcionario;
    
    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    public function getCnpj() {
        return $this->cnpj;
    }

    public function setIe($ie) {
        $this->ie = $ie;
    }

    public function getIe() {
        return $this->ie;
    }

    public function setCi($ci) {
        $this->ci = $ci;
    }

    public function getCi() {
        return $this->ci;
    }

    public function setCategoria_for(Categoria $categoria_for) {
        $this->categoria_for = $categoria_for;
    }

    public function getCategoria_for() {
        return $this->categoria_for;
    }

    public function setDt_fund($dt_fund) {
        $this->dt_fund = date("Y-m-d", strtotime($dt_fund));
    }

    public function getDt_fund() {
        return date("d/m/Y", strtotime($this->dt_fund));
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setEndereco(Endereco $endereco){
        $this->endereco = $endereco;
    }
    
    public function setFuncionario(Funcionario $funcionario){
        $this->funcionario = $funcionario;
    }

    public function insert() {     
        $sql = "insert into $this->table (nome, cnpj, ie, ci, categoria_id, dt_fund, criado_em, status, funcionario_id) " .
            "values (:nome, :cnpj, :ie, :ci, :categoria_for, :dt_fund, '" . date("Y-m-d H:i:s") . "', '1', :funcionario_id)";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':cnpj', $this->cnpj);
        $stmt->bindParam(':ie', $this->ie);
        $stmt->bindParam(':ci', $this->ci);
        $categoria_id = $this->categoria_for->getId();
        $stmt->bindParam(':categoria_for', $categoria_id);
        $stmt->bindParam(':dt_fund', $this->dt_fund);
        $funcionario_id = $this->funcionario->getId();
        $stmt->bindParam(':funcionario_id', $funcionario_id);
        $stmt->execute();
        
        $sql = "select id_fornecedor from fornecedor order by id_fornecedor desc limit 1";
        $stmt = DB::prepare($sql);
        $stmt->execute();
        $last_id = $stmt->fetch();
        return $this->endereco->insertSpecial($last_id->id_fornecedor);
    }

    public function update($id) {
        $historico = new Historico();
        $historico->insertHistoricFornecedor($id);

        $sql = "update $this->table set nome = :nome, cnpj = :cnpj, ie = :ie, ci = :ci, categoria_id = :categoria_for, " .
            "dt_fund = :dt_fund, atualizado_em = '" . date("Y-m-d H:i:s") . "', status = :status, funcionario_id = :funcionario_id where id_$this->table = :id";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':cnpj', $this->cnpj);
        $stmt->bindParam(':ie', $this->ie);
        $stmt->bindParam(':ci', $this->ci);
        $categoria_id = $this->categoria_for->getId();        
        $stmt->bindParam(':categoria_for', $categoria_id);
        $stmt->bindParam(':dt_fund', $this->dt_fund);
        $stmt->bindParam(':status', $this->status);
        $funcionario_id = $this->funcionario->getId();
        $stmt->bindParam(':funcionario_id', $funcionario_id);
        $stmt->bindParam(':id', $id);
        $stmt->execute();        
        return $this->endereco->update($this->endereco->getId());
    }

    public function findList(){
        $sql = "select fornecedor.id_fornecedor id_fornecedor, fornecedor.nome nome, categoria.nome categoria, cnpj, ie, ci, endereco.id_endereco id_endereco, cidade " .
            "from fornecedor left join endereco on id_fornecedor = fornecedor_id " .  
            "inner join categoria on id_categoria = categoria_id where fornecedor.status = 1";
        $stmt = DB::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function specialFind(){

        $flgNome = $flgCnpj = $flgIe = $flgCategoria = $flgCidade = false;

        $sql = "select fornecedor.id_fornecedor id_fornecedor, fornecedor.nome nome, categoria.nome categoria, cnpj, ie, ci, endereco.id_endereco id_endereco, cidade " .
        "from fornecedor left join endereco on id_fornecedor = fornecedor_id " .  
        "inner join categoria on id_categoria = categoria_id where fornecedor.status = 1 and  ";
        if(!empty($this->nome)){
            $sql = $sql . "fornecedor.nome like :nome and  ";
            $flgNome = true;
        }
        if(!empty($this->cnpj)){
            $sql = $sql . "cnpj like :cnpj and  ";
            $flgCnpj = true;
        }
        if(!empty($this->ie)){
            $sql = $sql . "ie like :ie and  ";
            $flgIe = true;
        }
        if(!empty($this->categoria_for->getId()) && $this->categoria_for->getId() > 0){
            $sql = $sql . "categoria_id = :categoria and  ";
            $flgCategoria = true;
        }
        if(!empty($this->endereco->getCidade())){
            $sql = $sql . "cidade like :cidade and  ";
            $flgCidade = true;
        }
        $sql = substr($sql, 0, strlen($sql) - 6);
        $stmt = DB::prepare($sql);
        if($flgNome){
            $this->nome = "%" . $this->nome . "%";
            $stmt->bindParam(':nome', $this->nome);
        }
        if($flgCnpj){
            $this->cnpj = "%" . $this->cnpj . "%";
            $stmt->bindParam(':cnpj', $this->cnpj);
        }
        if($flgIe){
            $this->ie = "%" . $this->ie . "%";
            $stmt->bindParam(':ie', $this->ie);    
        }
        if($flgCidade){
            $cidade = "%" . $this->endereco->getCidade() . "%";
            $stmt->bindParam(':cidade', $cidade);    
        }
        if($flgCategoria){
            $categoria_id = $this->categoria_for->getId();
            $stmt->bindParam(':categoria', $categoria_id);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findInner($id){
        $sql = "select fornecedor.nome nome, categoria.nome categoria, cnpj, ie, ci, dt_fund, rua, num, cidade, estado, " .
        "pais, cep, funcionario.nome nome_func, obs " .
        "from fornecedor left join endereco on id_fornecedor = fornecedor_id " .
        "inner join categoria on id_categoria = categoria_id " . 
        "inner join funcionario on id_funcionario = funcionario_id where id_fornecedor = :id and fornecedor.status = 1";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
}