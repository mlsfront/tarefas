<?php
    session_start();
    include_once "conexao.php";
    /*if ($_SESSION["voltar"] == ""){
        $_SESSION["voltar"] = $_SERVER['HTTP_REFERER'];
    }*/
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <title>Editar Modalidade</title>
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
            <h2 class="text-titulo mt-3 mb-3">Editar Modalidade</h2>
            <?php
                //Salvar as informações do usuário no banco de dados 
                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

                if (!empty($dados['SendUpModalidade'])) {
                    try {
                        $query_up_modalidade = "UPDATE modalidades SET nome=:nome, modified = NOW() WHERE id=:id";
                        $up_modalidade = $conn->prepare($query_up_modalidade);
                        $up_modalidade->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
                        $up_modalidade->bindParam(':id', $dados['id'], PDO::PARAM_INT);

                        if ($up_modalidade->execute()) {
                            $_SESSION['msg'] = "<p style='color: green;'>Modalidade editada com sucesso!</p>";
                            header("Location: modalidade.php");
                        } else {
                            echo "<p style='color: #f00;'>Erro: Modalidade não editada com sucesso!</p>";
                        }
                    } catch (PDOException $erro) {
                        //echo "<p style='color: #f00;'>Erro: Modalidade não editada com sucesso!</p>";
                        echo "Erro: Modalidade não editada com sucesso. Erro gerando: " . $erro->getMessage() . " <br>";
                    }
                }

                $id = filter_input(INPUT_GET, "id_usuario", FILTER_SANITIZE_NUMBER_INT);

                try {
                    //Pesquisar as informações do usuário no banco de dados
                    $query_modalidade = "SELECT id, nome FROM modalidades WHERE id=:id LIMIT 1";
                    $result_modalidade = $conn->prepare($query_modalidade);
                    $result_modalidade->bindParam(':id', $id, PDO::PARAM_INT);
                    $result_modalidade->execute();

                    $row_modalidade = $result_modalidade->fetch(PDO::FETCH_ASSOC);

                } catch (PDOException $erro) {
                    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Modalidade não encontrado!</p>";
                    //echo "Erro: Modalidade não encontrado. Erro gerando: " . $erro->getMessage() . " <br>";
                    header("Location: modalidade.php");
                }
            ?>

            <form method="POST" action="">
                <!--id-->
                <?php
                    $id = "";
                    if (isset($row_modalidade['id'])) {
                        $id = $row_modalidade['id'];
                    }
                ?>
                <input type="hidden" name="id" value="<?php echo $id; ?>" required>

                <!--nomeModalidade-->
                <?php
                    $nome = "";
                    if (isset($row_modalidade['nome'])) {
                        $nome = $row_modalidade['nome'];
                    }
                ?>
                <label>Nome da Modalidade: </label>
                <input type="text" name="nome" placeholder="Digite situação da tarefa" value="<?php echo $nome; ?>" required><br><br>

                <input type="submit" value="Salvar" name="SendUpModalidade"><br><br>
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