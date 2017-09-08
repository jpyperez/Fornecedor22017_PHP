<?php
	function __autoload($class_name){
		require_once 'classes/' . $class_name . '.php';
	}
?>

<!DOCTYPE HTML>
<html land="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>les_php</title>
    <link rel="stylesheet" href="css/bootstrap.css" />

    <script type="text/javascript">       
        function formatar(mascara, documento){
            var i = documento.value.length;
            var saida = mascara.substring(0,1);
            var texto = mascara.substring(i);
            if (texto.substring(0,1) != saida){
                documento.value += texto.substring(0,1);
            }
        }
        
        function isImportacao(){
            if($("select[name=categoria_for] option:selected").text() == "Importação"){
                $('input[name=cnpj]').hide();
                $('input[name=ie]').hide();
                $('input[name=ci]').show();
            } else {
                $('input[name=cnpj]').show();
                $('input[name=ie]').show();
                $('input[name=ci]').hide();
            }
        }

        
    </script>
    <!--[if lt IE 9]>
        <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<body>

	<div class="container">

        <!-- Inserir Forncedor -->
        <?php
            $fornecedor = new Fornecedor();
            $endereco = new Endereco();
            $categoria = new Categoria();
            $funcionario = new Funcionario();

            if(isset($_POST['cadastrar'])){
                $nome = $_POST['nome'];
                $categoria_for = $_POST['categoria_for'];                
                $cnpj = $_POST['cnpj'];
                $ie = $_POST['ie'];
                $ci = $_POST['ci'];
                $dt_fund = $_POST['dt_fund'];
                $rua = $_POST['rua'];
                $num = $_POST['num'];
                $cidade = $_POST['cidade'];
                $estado = $_POST['estado'];
                $pais = $_POST['pais'];
                $cep = $_POST['cep'];
                $obs = $_POST['obs'];
                $funcionario_id =  $_POST['funcionario'];
                $transacionar = true;
                $erro = "";

                // Validações para campos obrigatórios
                if(empty($nome)){
                    $erro = $erro . 'Digite um nome! / ';
                    $transacionar = false;
                }

                if($categoria_for == "Selecione"){
                    $erro = $erro . "Digite uma categoria de fornecimento / ";
                }
                
                if($categoria_for == "1"){
                    if(empty($ci)){
                        $erro = $erro . 'Digite um CI! / ';
                        $transacionar = false;                        
                    }
                    $cnpj = $ie = "";
                } else {
                    if(empty($cnpj)){
                        $erro = $erro . 'Digite um CNPJ! / ';
                        $transacionar = false;                        
                    }
                    if(empty($ie)){
                        $erro = $erro . 'Digite um IE! / ';
                        $transacionar = false;                        
                    }
                    $ci = "";
                }

                if(!empty($dt_fund)) {
                    $OldDate = new DateTime(date("Y-m-d", strtotime($dt_fund)));
                    $now = new DateTime(Date('Y-m-d'));
                    $interval = $OldDate->diff($now);
                    
                    if($interval->format('%y') <= 0){
                        $erro = $erro . 'Data de fundação deve ser maior que 1 ano / ';
                        $transacionar = false;
                    }
                }

                if($funcionario_id == "0") {
                    $erro = $erro  . 'Funcionário deve ser selecionado / ';
                    $transacionar = false;
                }
                
                if($transacionar){
                    $fornecedor->setNome($nome);
                    $fornecedor->setCnpj($cnpj);
                    $fornecedor->setIe($ie);
                    $fornecedor->setCi($ci);
                    $categoria->setId($categoria_for);
                    $fornecedor->setCategoria_for($categoria);
                    $fornecedor->setDt_fund($dt_fund);
                    $endereco->setRua($rua);
                    $endereco->setNum($num);
                    $endereco->setCidade($cidade);
                    $endereco->setEstado($estado);
                    $endereco->setPais($pais);
                    $endereco->setCep($cep);
                    $endereco->setObs($obs);
                    $funcionario->setId($funcionario_id);
                    $fornecedor->setFuncionario($funcionario);
                    $fornecedor->setEndereco($endereco);
                    if($fornecedor->insert()){
                        echo '<div class="alert alert-success">Inserido com sucesso!</div>';                        
                    }    
                } else {
                    echo '<div class="alert alert-danger">' . substr($erro, 0, strlen($erro) - 3) . '</div>';                    
                }
            }
        ?>
               
        <header class="masthead">
            <h1 class="muted">les_php</h1>
            <nav class="navbar">
                <div class="navbar-inner">
                    <ul class="nav">
                        <li class=""><a href="index.php">Página Inicial</a></li>
                        <li class="active"><a href="fornecedores.php">Fornecedores</a></li>                        
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Atualizar Fornecedor -->
        <?php
            if(isset($_POST['atualizar'])){
                $id_fornecedor = $_POST['id_fornecedor'];
                $id_endereco = $_POST['id_endereco'];
                $nome = $_POST['nome'];
                $categoria_for = $_POST['categoria_for'];
                $cnpj = $_POST['cnpj'];
                $ie = $_POST['ie'];
                $ci = $_POST['ci'];
                $dt_fund = $_POST['dt_fund'];
                $rua = $_POST['rua'];
                $num = $_POST['num'];
                $cidade = $_POST['cidade'];
                $estado = $_POST['estado'];
                $pais = $_POST['pais'];
                $cep = $_POST['cep'];
                $obs = $_POST['obs'];
                $funcionario_id =  $_POST['funcionario'];
                $transacionar = true;
                $erro = "";

                // Validações para campos obrigatórios
                if(empty($nome)){
                    $erro = $erro . 'Digite um nome! / ';
                    $transacionar = false;
                }

                if($categoria_for == "Selecione"){
                    $erro = $erro . "Digite uma categoria de fornecimento / ";
                }
                
                if($categoria_for == "Importacao"){
                    if(empty($ci)){
                        $erro = $erro . 'Digite um CI! / ';
                        $transacionar = false;                        
                    }
                    $cnpj = $ie = "";
                } else {
                    if(empty($cnpj)){
                        $erro = $erro . 'Digite um CNPJ! / ';
                        $transacionar = false;                        
                    }
                    if(empty($ie)){
                        $erro = $erro . 'Digite um IE! / ';
                        $transacionar = false;                        
                    }
                    $ci = "";
                }

                if(!empty($dt_fund)) {
                    $OldDate = new DateTime(date("Y-m-d", strtotime($dt_fund)));
                    $now = new DateTime(Date('Y-m-d'));
                    $interval = $OldDate->diff($now);
                    
                    if($interval->format('%y') <= 0){
                        $erro = $erro . 'Data de fundação deve ser maior que 1 ano / ';
                        $transacionar = false;
                    }
                }

                if($funcionario_id == "0") {
                    $erro = $erro  . 'Funcionário deve ser selecionado / ';
                    $transacionar = false;
                }
                
                if($transacionar){
                    $fornecedor->setNome($nome);
                    $fornecedor->setCnpj($cnpj);
                    $fornecedor->setIe($ie);
                    $fornecedor->setCi($ci);
                    $categoria->setId($categoria_for);
                    $fornecedor->setCategoria_for($categoria);
                    $fornecedor->setDt_fund($dt_fund);
                    $endereco->setId($id_endereco);
                    $endereco->setRua($rua);
                    $endereco->setNum($num);
                    $endereco->setCidade($cidade);
                    $endereco->setEstado($estado);
                    $endereco->setPais($pais);
                    $endereco->setCep($cep);
                    $endereco->setObs($obs);
                    $endereco->setStatus("1");
                    $funcionario->setId($funcionario_id);
                    $fornecedor->setFuncionario($funcionario);
                    $fornecedor->setEndereco($endereco);
                    $fornecedor->setStatus("1");
                    
                    if($fornecedor->update($id_fornecedor)){
                        echo '<div class="alert alert-success">Atualizado com sucesso!</div>';
                    }    

                } else {
                    echo '<div class="alert alert-danger">' . substr($erro, 0, strlen($erro) - 3) . '</div>';
                }
            }

        ?>
        
        <?php
            if(isset($_GET['acao']) && $_GET['acao'] == 'editar'){
                $id = (int)$_GET['id'];
                $resultado = $fornecedor->findInner($id);
        ?>
        
        <form method="post" action="">  
            <input type="text" name="nome" required="required" placeholder="Nome" value="<?php echo $resultado->nome ?>" class="form-control col-md-4" />
            <select name="categoria_for" class="form-control col-md-4" onchange="isImportacao();">
                <option value="0">Categoria de fornecimento</option>
                <?php foreach($categoria->findAll() as $key => $value): ?>
                    <option <?php if($resultado->categoria_id == $value->id_categoria) echo "selected" ?> value="<?php echo $value->id_categoria; ?>"><?php echo $value->nome; ?></option>
                <?php endforeach ?>             
            </select>
            <input name="cnpj"  placeholder="CNPJ" class="form-control col-md-4 input-md" value="<?php echo $resultado->cnpj ?>" type="text" maxlength="18" OnKeyPress="formatar('##.###.###/####-##', this)">
            <input type="text" name="ie" placeholder="IE" value="<?php echo $resultado->ie ?>" class="form-control col-md-4" maxlength="15" />
            <input type="text" name="ci" placeholder="CI" value="<?php echo $resultado->ci ?>" style="display: none;" class="form-control col-md-4" />
            <input name="dt_fund" placeholder="Data de fundação" value="<?php echo date("d/m/Y", strtotime($resultado->dt_fund)) ?>" class="form-control col-md-4 input-md" type="text" maxlength="10" OnKeyPress="formatar('##/##/####', this)">
            <input type="text" name="rua" value="<?php echo $resultado->rua ?>" placeholder="Rua" class="form-control col-md-4" />            
            <input type="text" name="num" value="<?php echo $resultado->num ?>" placeholder="Número" class="form-control col-md-4" />            
            <input type="text" name="cidade" value="<?php echo $resultado->cidade ?>" required="required" placeholder="Cidade" class="form-control col-md-4" />            
            <input type="text" name="estado" value="<?php echo $resultado->estado ?>" placeholder="Estado" class="form-control col-md-4" />            
            <input type="text" name="pais" value="<?php echo $resultado->pais ?>" placeholder="País" class="form-control col-md-4" />            
            <input type="text" name="cep" value="<?php echo $resultado->cep ?>" maxlength="9" placeholder="CEP" class="form-control col-md-4" OnKeyPress="formatar('#####-###', this)"/>
            <select name="funcionario" class="form-control">
                <option value="0">Funcionário</option>
                <?php foreach($funcionario->findAll() as $key => $value): ?>
                    <option <?php if($resultado->funcionario_id == $value->id_funcionario) echo "selected" ?> value="<?php echo $value->id_funcionario; ?>"><?php echo $value->nome; ?></option>
                <?php endforeach ?>
            </select>            
            <div>
                <textarea name="obs" maxlength="1000" value="<?php echo $resultado->obs ?>" placeholder="Observações" class="form-control" rows="3" maxlength="1000"></textarea>            
            </div>
            <input type="hidden" name="id_fornecedor" value="<?php echo $id; ?>">
            <input type="hidden" name="id_endereco" value="<?php echo $resultado->id_endereco; ?>">
            <br />
            <input type="submit" name="atualizar" class="btn btn-primary" value="Atualizar dados" onclick='return confirm("Deseja realmente atualizar?")'>
            <a href="fornecedores.php" class="btn btn-primary">Voltar</a>					
        </form>
        
        <?php
            } else if(isset($_GET['acao']) && $_GET['acao'] == 'detalhes'){
                $id = (int)$_GET['id'];
                $resultado = $fornecedor->findInner($id);
        ?>
        
        <form method="post" action="">  
            <div class="form-group">
                <label class="control-label"><strong>Nome: </strong><?php echo $resultado->nome ?></label>
            </div>
            <div class="form-group">
                <label class="control-label"><strong>Categoria: </strong><?php echo $resultado->categoria ?></label>
            </div>
            <?php 
                if($resultado->categoria == "Importação"){ ?>
                    <div class="form-group">
                        <label class="control-label"><strong>CI: </strong><?php echo $resultado->ci ?></label>
                    </div>
                <?php } else { ?>
                    <div class="form-group">
                        <label class="control-label"><strong>CNPJ: </strong><?php echo $resultado->cnpj ?></label>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><strong>IE: </strong><?php echo $resultado->ie ?></label>
                    </div>                        
                <?php }
            ?>
            <div class="form-group">
                <label class="control-label"><strong>Data de fundação: </strong><?php echo $resultado->dt_fund ?></label>
            </div>
            <div class="form-group">
                <label class="control-label"><strong>Rua: </strong><?php echo $resultado->rua ?></label>
            </div>
            <div class="form-group">
                <label class="control-label"><strong>Número: </strong><?php echo $resultado->num ?></label>
            </div>
            <div class="form-group">
                <label class="control-label"><strong>Cidade: </strong><?php echo $resultado->cidade ?></label>
            </div>
            <div class="form-group">
                <label class="control-label"><strong>Estado: </strong><?php echo $resultado->estado ?></label>
            </div>
            <div class="form-group">
                <label class="control-label"><strong>País: </strong><?php echo $resultado->pais ?></label>
            </div>
            <div class="form-group">
                <label class="control-label"><strong>CEP: </strong><?php echo $resultado->cep ?></label>
            </div>
            <div class="form-group">
                <label class="control-label"><strong>Observação: </strong><?php echo $resultado->obs ?></label>
            </div>
            <div class="form-group">
                <label class="control-label"><strong>Funcionário: </strong><?php echo $resultado->nome_func ?></label>
            </div>
            <br />
            <a href="fornecedores.php" class="btn btn-primary">Voltar</a>					
        </form>

        <!-- Cadastrar -->
        <?php } else { ?> 
            

		<form method="post" action="">  
            <input type="text" name="nome" required="required" placeholder="Nome" class="form-control col-md-4" />
            <select name="categoria_for" class="form-control col-md-4" onchange="isImportacao();">
            <option value="0">Categoria de fornecimento</option>
                <?php foreach($categoria->findAll() as $key => $value): ?>
                    <option value="<?php echo $value->id_categoria; ?>"><?php echo $value->nome; ?></option>
                <?php endforeach ?>             
            </select>
            <input name="cnpj" placeholder="CNPJ" class="form-control col-md-4 input-md" type="text" maxlength="18" OnKeyPress="formatar('##.###.###/####-##', this)">
            <input type="text" name="ie" placeholder="IE" class="form-control col-md-4" maxlength="15" />
            <input type="text" name="ci" placeholder="CI" style="display: none;" class="form-control col-md-4" />
            <input name="dt_fund" placeholder="Data de fundação" class="form-control col-md-4 input-md" type="text" maxlength="10" OnKeyPress="formatar('##/##/####', this)">
            <input type="text" name="rua" placeholder="Rua" class="form-control col-md-4" />            
            <input type="text" name="num" placeholder="Número" class="form-control col-md-4" />            
            <input type="text" name="cidade" required="required" placeholder="Cidade" class="form-control col-md-4" />            
            <input type="text" name="estado" placeholder="Estado" class="form-control col-md-4" />            
            <input type="text" name="pais" placeholder="País" class="form-control col-md-4" />            
            <input type="text" name="cep" maxlength="9" placeholder="CEP" class="form-control col-md-4" OnKeyPress="formatar('#####-###', this)" />
            <select name="funcionario" class="form-control">
            <option value="0">Funcionário</option>
            <?php foreach($funcionario->findAll() as $key => $value): ?>
                    <option value="<?php echo $value->id_funcionario; ?>"><?php echo $value->nome; ?></option>
                <?php endforeach ?>
            </select>            
            <div>
                <textarea name="obs" maxlength="1000" placeholder="Observações" class="form-control" rows="3" maxlength="1000"></textarea>            
            </div>
            <br />
			<input type="submit" name="cadastrar" class="btn btn-primary" value="Cadastrar dados" onclick='return confirm("Deseja realmente inserir?")'>					
            <a href="fornecedores.php" class="btn btn-primary">Voltar</a>
        </form>
        
        <?php } ?>

<script src="js/jQuery.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>