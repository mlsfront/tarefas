<?php
session_start();
include_once "conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <title>Cadastra Tarefa</title>
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

            <h2 class="text-titulo mt-3 mb-3">Cadastrar Tarefa</h2>
            <?php

            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if (!empty($dados['SendCadUsuario'])) {
                try {
                    $query_usuario = "INSERT INTO tarefas (nome, tarefa, sists_tarefa_id, modalidade_id, created) VALUES (:nome, :tarefa, :sists_tarefa_id, :modalidade_id, NOW())";
                    $cad_usuario = $conn->prepare($query_usuario);
                    $cad_usuario->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
                    $cad_usuario->bindParam(':tarefa', $dados['tarefa']);
                    $cad_usuario->bindParam(':sists_tarefa_id', $dados['sists_tarefa_id'], PDO::PARAM_INT);
                    $cad_usuario->bindParam(':modalidade_id', $dados['modalidade_id'], PDO::PARAM_INT);

                    $cad_usuario->execute();
                    if ($cad_usuario->rowCount()) {
                        $_SESSION['msg'] = "<p style='color: green;'>Tarefa cadastrada com sucesso!</p>";
                        unset($dados);
                        header("Location: index.php");
                    } else {
                        echo "<p style='color: #f00;'>Erro: Tarefa não cadastrada com sucesso!</p>";
                    }
                } catch (PDOException $erro) {
                    echo "<p style='color: #f00;'>Erro: Tarefa não cadastrada com sucesso!</p>";
                    //echo "Erro: Tarefa não cadastrada com sucesso. Erro gerado: " . $erro->getMessage() . " <br>";
                }
            }

            ?>
            <form method="POST" action="">
                <!--nomeTarefa-->
                <label>Nome da Tarefa: </label>
                <?php
                    $nome = "";
                    if (isset($dados['nome'])) {
                        $nome = $dados['nome'];
                    }
                ?>
                <input type="text" name="nome" placeholder="Digite o nome da tarefa" value="<?php echo $nome; ?>" required /><br><br>

                <!--tarefa-->
                <?php
                    $tarefa = "";
                    if (isset($dados['tarefa'])) {
                        $tarefa = $dados['tarefa'];
                    }
                ?>
                <label>Tarefa: </label>
                <textarea type="text" name="tarefa" placeholder="Digite sua terefa" value="<?php echo $tarefa; ?>" required /></textarea><br><br>

                <!--situacaoTarefa-->
                <?php
                    $query_sists_tarefas = "SELECT id, nome FROM sists_tarefas ORDER BY nome ASC";
                    $result_sists_tarefas = $conn->prepare($query_sists_tarefas);
                    $result_sists_tarefas->execute();
                ?>
                <label>Situação da Tarefa: </label>
                <select name="sists_tarefa_id" required>
                    <option value="">Selecione</option>
                    <?php
                        while ($row_sist_tarefa = $result_sists_tarefas->fetch(PDO::FETCH_ASSOC)) {
                            $select_sit_usuario = "";

                            if (isset($dados['sists_tarefa_id']) and ($dados['sists_tarefa_id'] == $row_sist_tarefa['id'])) {
                                $select_sit_usuario = "selected";
                            }
                            echo "<option value='" . $row_sist_tarefa['id'] . "' $select_sit_usuario>" . $row_sist_tarefa['nome'] . "</option>";
                        }
                    ?>
                </select>
                <br><br>

                <!--modalidade-->
                <?php
                    $query_modalidades = "SELECT id, nome FROM modalidades ORDER BY nome ASC";
                    $result_modalidades = $conn->prepare($query_modalidades);
                    $result_modalidades->execute();
                ?>
                <label>Modalidade da Tarefa: </label>
                <select name="modalidade_id" required>
                    <option value="">Selecione</option>
                    <?php
                    while ($row_nivel_acesso = $result_modalidades->fetch(PDO::FETCH_ASSOC)) {
                        $select_nivel_acesso = "";

                        if (isset($dados['modalidade_id']) and ($dados['modalidade_id'] == $row_nivel_acesso['id'])) {
                            $select_nivel_acesso = "selected";
                        }

                        echo "<option value='" . $row_nivel_acesso['id'] . "' $select_nivel_acesso>" . $row_nivel_acesso['nome'] . "</option>";
                    }
                    ?>
                </select>
                <br><br>

                <input type="submit" value="Cadastra" name="SendCadUsuario" />
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