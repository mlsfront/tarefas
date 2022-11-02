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
    <title>Editar Tarefa</title>
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
            <h2 class="text-titulo mt-3 mb-3">Editar Tarefa</h2>
            <?php
                //Salvar as informações do usuário no banco de dados 
                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

                if (!empty($dados['SendUpTarefa'])) {
                    try {
                        $query_up_tarefa = "UPDATE tarefas SET nome=:nome, tarefa=:tarefa, sists_tarefa_id=:sists_tarefa_id, modalidade_id=:modalidade_id, modified = NOW() WHERE id=:id";
                        $up_tarefa = $conn->prepare($query_up_tarefa);
                        $up_tarefa->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
                        $up_tarefa->bindParam(':tarefa', $dados['tarefa'], PDO::PARAM_STR);
                        $up_tarefa->bindParam(':sists_tarefa_id', $dados['sists_tarefa_id'], PDO::PARAM_INT);
                        $up_tarefa->bindParam(':modalidade_id', $dados['modalidade_id'], PDO::PARAM_INT);
                        $up_tarefa->bindParam(':id', $dados['id'], PDO::PARAM_INT);

                        if ($up_tarefa->execute()) {
                            $_SESSION['msg'] = "<p style='color: green;'>Tarefa editada com sucesso!</p>";
                            header("Location: index.php");
                        } else {
                            echo "<p style='color: #f00;'>Erro: Tarefa não editada com sucesso!</p>";
                        }
                    } catch (PDOException $erro) {
                        echo "<p style='color: #f00;'>Erro: Tarefa não editada com sucesso!</p>";
                        //echo "Erro: Tarefa não editada com sucesso. Erro gerando: " . $erro->getMessage() . " <br>";
                    }
                }

                $id = filter_input(INPUT_GET, "id_usuario", FILTER_SANITIZE_NUMBER_INT);

                try {
                    //Pesquisar as informações do usuário no banco de dados
                    $query_tarefa = "SELECT id, nome, tarefa, sists_tarefa_id, modalidade_id FROM tarefas WHERE id=:id LIMIT 1";
                    $result_tarefa = $conn->prepare($query_tarefa);
                    $result_tarefa->bindParam(':id', $id, PDO::PARAM_INT);
                    $result_tarefa->execute();

                    $row_tarefa = $result_tarefa->fetch(PDO::FETCH_ASSOC);

                } catch (PDOException $erro) {
                    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Tarefa não encontrada!</p>";
                    //echo "Erro: Tarefa não encontrada. Erro gerando: " . $erro->getMessage() . " <br>";
                    header("Location: index.php");
                }
            ?>

            <form method="POST" action="">
                <!--id-->
                <?php
                    $id = "";
                    if (isset($row_tarefa['id'])) {
                        $id = $row_tarefa['id'];
                    }
                ?>
                <input type="hidden" name="id" value="<?php echo $id; ?>" required>

                <!--nomeTarefa-->
                <?php
                    $nome = "";
                    if (isset($row_tarefa['nome'])) {
                        $nome = $row_tarefa['nome'];
                    }
                ?>

                <!--tarefa-->
                <label>Nome da Tarefa: </label>
                <input type="text" name="nome" placeholder="Digite nome da tarefa" value="<?php echo $nome; ?>" required><br><br>
                <?php
                    $tarefa = "";
                    if (isset($row_tarefa['tarefa'])) {
                        $tarefa = $row_tarefa['tarefa'];
                    }
                ?>
                <label>Tarefa: </label>
                <textarea name="tarefa" placeholder="Digite sua terefa" value="" required><?php echo $tarefa; ?></textarea><br><br>

                <!--situacaoTarefa-->
                <?php
                    $query_sists_tarefas = "SELECT id, nome FROM sists_tarefas ORDER BY nome ASC";
                    $result_sists_tarefas = $conn->prepare($query_sists_tarefas);
                    $result_sists_tarefas->execute();
                ?>
                <label>Situação: </label>
                <select name="sists_tarefa_id">
                    <option value="">Selecione</option>
                    <?php
                    while ($row_sist_tarefa = $result_sists_tarefas->fetch(PDO::FETCH_ASSOC)) {
                        extract($row_sist_tarefa);

                        $select_sist_usuario = "";
                        if (isset($dados['sists_tarefa_id']) and ($dados['sists_tarefa_id'] == $id)) {
                            $select_sist_usuario = "selected";
                        } elseif (((!isset($dados['sists_tarefa_id'])) and (isset($row_tarefa['sists_tarefa_id']))) and ($row_tarefa['sists_tarefa_id'] == $id)) {
                            $select_sist_usuario = "selected";
                        }

                        echo "<option value='$id' $select_sist_usuario>$nome</option>";
                    }
                    ?>
                </select><br><br>
                
                <!--modalidades-->
                <?php
                    $query_modalidades = "SELECT id, nome FROM modalidades ORDER BY nome ASC";
                    $result_modalidades = $conn->prepare($query_modalidades);
                    $result_modalidades->execute();
                ?>
                <label>Nível de Acesso: </label>
                <select name="modalidade_id">
                    <option value="">Selecione</option>
                    <?php
                    while ($row_nivel_acesso = $result_modalidades->fetch(PDO::FETCH_ASSOC)) {
                        extract($row_nivel_acesso);

                        $select_niv_tarefa = "";
                        if (isset($dados['modalidade_id']) and ($dados['modalidade_id'] == $id)) {
                            $select_niv_tarefa = "selected";
                        } elseif (((!isset($dados['modalidade_id'])) and (isset($row_tarefa['modalidade_id']))) and ($row_tarefa['modalidade_id'] == $id)) {
                            $select_niv_tarefa = "selected";
                        }

                        echo "<option value='$id' $select_niv_tarefa>$nome</option>";
                    }
                    ?>
                </select><br><br>

                <input type="submit" value="Salvar" name="SendUpTarefa"><br><br>
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