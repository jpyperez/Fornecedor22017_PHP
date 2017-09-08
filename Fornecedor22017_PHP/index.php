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
    <!--[if lt IE 9]>
        <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<body>

	<div class="container">
                
		<header class="masthead">
			<h1 class="muted">les_php</h1>
			<nav class="navbar">
				<div class="navbar-inner">
					<div class="container">
						<ul class="nav">
                            <li class="active"><a href="index.php">Página Inicial</a></li>
                            <li class=""><a href="fornecedores.php">Fornecedores</a></li>                        
						</ul>
					</div>
				</div>
			</nav>
		</header>

        <br />
        <br />
        <br />
        <h1 style="text-align: center">Trabalho de LES do 2º semestre de 2017</h1>
        <h1 style="text-align: center">feito em PHP</h1>

    </div>

<script src="js/jQuery.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>