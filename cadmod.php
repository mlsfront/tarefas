<?php
session_start();
include_once "conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <title>Cadastra Modalidade</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
    <!-- Incluir os icones do font-awesome da CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<body class="container-fluid">
    <?php include "nav.php" ?>
    
    <div class="container text-center">
      <div class="row justify-content-md-center">
        <!--conteudoEsquerda
        <div class="col col-lg-2">
          1 of 3
        </div>-->

        <!--conteudoCentral-->
        <div class="col-md-auto">

            <h2 class="text-titulo mt-3 mb-3">Cadastrar Modalidade</h2>
            <?php

            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if (!empty($dados['SendCadModalidade'])) {
                try {
                    $query_modalidade = "INSERT INTO modalidades (nome, created) VALUES (:nome, NOW())";
                    $cad_modalidade = $conn->prepare($query_modalidade);
                    $cad_modalidade->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);

                    $cad_modalidade->execute();
                    if ($cad_modalidade->rowCount()) {
                        $_SESSION['msg'] = "<p style='color: green;'>Modalidade cadastrada com sucesso!</p>";
                        unset($dados);
                        header("Location: modalidade.php");
                    } else {
                        echo "<p style='color: #f00;'>Erro: Modalidade não cadastrada com sucesso!</p>";
                    }
                } catch (PDOException $erro) {
                    echo "<p style='color: #f00;'>Erro: Modalidade não cadastrada com sucesso!</p>";
                    //echo "Erro: Modalidade não cadastrada com sucesso. Erro gerado: " . $erro->getMessage() . " <br>";
                }
            }

            ?>
            <form method="POST" action="">
                <!--nomeModalidade-->
                <label>Nome da Modalidade: </label>
                <?php
                    $nome = "";
                    if (isset($dados['nome'])) {
                        $nome = $dados['nome'];
                    }
                ?>
                <input type="text" name="nome" placeholder="Digite o nome da modalidade" value="<?php echo $nome; ?>" required /><br><br>

                <input type="submit" value="Cadastra" name="SendCadModalidade" />
            </form>
        </div>
        <!--conteudoEsquerda
        <div class="col col-lg-2">
          3 of 3
        </div>-->
      </div>
    </div>

    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
</body>

</html>