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
    </script>
    <!--[if lt IE 9]>
        <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<body>

	<div class="container">

        <?php
            $fornecedor = new Fornecedor();
            $historico = new Historico();
            $endereco = new Endereco();
            $funcionario = new Funcionario();
            $categoria = new Categoria();
            
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

        <form method="post" action="">  
            <input type="text" name="nome" placeholder="Nome" class="form-control col-md-4" />
            <select name="categoria_for" class="form-control col-md-4">
                <option value="0">Categoria de fornecimento</option>
                <?php foreach($categoria->findAll() as $key => $value): ?>
                    <option value="<?php echo $value->id_categoria; ?>"><?php echo $value->nome; ?></option>
                <?php endforeach ?>             
            </select>
            <input name="cnpj" placeholder="CNPJ" class="form-control col-md-4 input-md" type="text" maxlength="18" OnKeyPress="formatar('##.###.###/####-##', this)">
            <input type="text" name="ie" placeholder="IE" class="form-control col-md-4" />
            <input type="text" name="cidade" placeholder="Cidade" class="form-control col-md-4" />
            <br />
			<input type="submit" name="pesquisar" class="btn btn-primary" value="Pesquisar" >
        </form>
            
        <?php 
            if(isset($_GET['acao']) && $_GET['acao'] == 'deletar'){
                $id = (int)$_GET['id'];
                $historico->insertHistoric($id);
                $fornecedor->delete($id);
            }
        ?>

		<table class="table table-hover">
			
			<thead>
				<tr>
					<th># Fornecedor</th>
                    <th>Nome</th>
                    <th>Categoria fornecimento</th>
					<th>CNPJ</th>
                    <th>IE</th>
                    <th>CI</th>
                    <th># Endereco</th>
                    <th>Cidade</th>
                    <th>Ação</th>
				</tr>
			</thead>
            
            <?php 
                if(isset($_POST['pesquisar'])){
                    $nome = $_POST['nome'];
                    $cnpj = $_POST['cnpj'];
                    $ie = $_POST['ie'];
                    $cidade = $_POST['cidade'];
                    $categoria_for = $_POST['categoria_for'];

                    $fornecedor->setNome($nome);
                    $fornecedor->setCnpj($cnpj);
                    $fornecedor->setIe($ie);
                    $categoria->setId($categoria_for);
                    $fornecedor->setCategoria_for($categoria);                    
                    $endereco->setCidade($cidade);
                    $fornecedor->setEndereco($endereco);
                    foreach($fornecedor->specialFind() as $key => $value){                    
            ?>

            <tbody>
                <tr>
                    <td><?php echo $value->id_fornecedor; ?></td>
                    <td><?php echo $value->nome; ?></td>
                    <td><?php echo $value->categoria; ?></td>
                    <td><?php echo $value->cnpj; ?></td>
                    <td><?php echo $value->ie; ?></td>
                    <td><?php echo $value->ci; ?></td>
                    <td><?php echo $value->id_endereco; ?></td>                    
                    <td><?php echo $value->cidade; ?></td>
                    <td>
                        <?php echo "<a href='fornecedor_alter.php?acao=detalhes&id=" . $value->id_fornecedor . "'>Detalhes</a>"; ?>
                        <?php echo "<a href='fornecedor_alter.php?acao=editar&id=" . $value->id_fornecedor . "'>Editar</a>"; ?>
                        <?php echo "<a href='fornecedores.php?acao=deletar&id=" . $value->id_fornecedor . "'onclick='return confirm(\"Deseja realmente deletar?\")'>Deletar</a>"; ?>
                    </td>
                </tr>
            </tbody>
            
            <?php   
                    }     
                } else {
                    foreach($fornecedor->findList() as $key => $value){
            ?>

            <tbody>
                <tr>
                    <td><?php echo $value->id_fornecedor; ?></td>
                    <td><?php echo $value->nome; ?></td>
                    <td><?php echo $value->categoria; ?></td>
                    <td><?php echo $value->cnpj; ?></td>
                    <td><?php echo $value->ie; ?></td>
                    <td><?php echo $value->ci; ?></td>
                    <td><?php echo $value->id_endereco; ?></td>
                    <td><?php echo $value->cidade; ?></td>
                    <td>
                        <?php echo "<a href='fornecedor_alter.php?acao=detalhes&id=" . $value->id_fornecedor . "'>Detalhes</a>"; ?>
                        <?php echo "<a href='fornecedor_alter.php?acao=editar&id=" . $value->id_fornecedor . "'>Editar</a>"; ?>
                        <?php echo "<a href='fornecedores.php?acao=deletar&id=" . $value->id_fornecedor . "'onclick='return confirm(\"Deseja realmente deletar?\")'>Deletar</a>"; ?>
                    </td>
                </tr>
            </tbody>
            
            <?php
                    }                    
                }
            ?>

        </table>
        
        <a href="fornecedor_alter.php" class="btn btn-primary">Adicionar Fornecedor</a><br /><br /><br />

	</div>

<script src="js/jQuery.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>