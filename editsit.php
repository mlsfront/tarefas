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
    <title>Editar Situação</title>
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
            <h2 class="text-titulo mt-3 mb-3">Editar Situação</h2>
            <?php
                //Salvar as informações do usuário no banco de dados 
                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

                if (!empty($dados['SendUpSituacao'])) {
                    try {
                        $query_up_situacao = "UPDATE sists_tarefas SET nome=:nome, ordem=:ordem, modified = NOW() WHERE id=:id";
                        $up_situacao = $conn->prepare($query_up_situacao);
                        $up_situacao->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
                        $up_situacao->bindParam(':ordem', $dados['ordem'], PDO::PARAM_STR);
                        $up_situacao->bindParam(':id', $dados['id'], PDO::PARAM_INT);

                        if ($up_situacao->execute()) {
                            $_SESSION['msg'] = "<p style='color: green;'>Situação editada com sucesso!</p>";
                            header("Location: situacao.php");
                        } else {
                            echo "<p style='color: #f00;'>Erro: Situação não editada com sucesso!</p>";
                        }
                    } catch (PDOException $erro) {
                        //echo "<p style='color: #f00;'>Erro: Situação não editada com sucesso!</p>";
                        echo "Erro: Situação não editada com sucesso. Erro gerando: " . $erro->getMessage() . " <br>";
                    }
                }

                $id = filter_input(INPUT_GET, "id_usuario", FILTER_SANITIZE_NUMBER_INT);

                try {
                    //Pesquisar as informações do usuário no banco de dados
                    $query_situacao = "SELECT id, nome, ordem FROM sists_tarefas WHERE id=:id LIMIT 1";
                    $result_situacao = $conn->prepare($query_situacao);
                    $result_situacao->bindParam(':id', $id, PDO::PARAM_INT);
                    $result_situacao->execute();

                    $row_situacao = $result_situacao->fetch(PDO::FETCH_ASSOC);

                } catch (PDOException $erro) {
                    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Situação não encontrado!</p>";
                    //echo "Erro: Situação não encontrado. Erro gerando: " . $erro->getMessage() . " <br>";
                    header("Location: situacao.php");
                }
            ?>

            <form method="POST" action="">
                <!--id-->
                <?php
                    $id = "";
                    if (isset($row_situacao['id'])) {
                        $id = $row_situacao['id'];
                    }
                ?>
                <input type="hidden" name="id" value="<?php echo $id; ?>" required>

                <!--nomeSituacao-->
                <?php
                    $nome = "";
                    if (isset($row_situacao['nome'])) {
                        $nome = $row_situacao['nome'];
                    }
                ?>
                <label>Nome da Situação: </label>
                <input type="text" name="nome" placeholder="Digite situação da tarefa" value="<?php echo $nome; ?>" required><br><br>

                <!--ordemSituacao-->
                <?php
                    $ordem = "";
                    if (isset($row_situacao['ordem'])) {
                        $ordem = $row_situacao['ordem'];
                    }
                ?>
                <label>Número da Ordem: </label>
                <input type="number" name="ordem" placeholder="Digite número da ordem" value="<?php echo $ordem; ?>" required><br><br>

                <input type="submit" value="Salvar" name="SendUpSituacao"><br><br>
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