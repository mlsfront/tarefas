<?php
    session_start();
    include_once "conexao.php";
    if ($_SESSION["voltar"]==""){
        $_SESSION["voltar"]=$_SERVER['HTTP_REFERER'];
    }
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <title>Situação</title>
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
            <h2>Situação de Tarefa</h2>
            <table class='table table-success table-striped"'>
                <thead class='list-head'>
                    <tr>
                        <th class='list-head-content'>ID</th>
                        <th class='list-head-content'>Nome</th>
                        <th class='list-head-content'>Tarefa</th>
                        <th class='list-head-content'>ID</th>
                        <th class='list-head-content table-lg-none'>Açôes</th>
                    </tr>
                </thead>


            <!-- RECEBE DADOS NA TABELA -->    
            <?php
                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            ?>
            <form method="POST" action="">
                <label>Marque uma ou mais situação:</label><br><br>
                <?php
                    //Pesquisa os níveis de acesso no BD
                    $query_sists_tarefas = "SELECT id, nome FROM sists_tarefas WHERE id<=4 ORDER BY ordem ASC";
                    $result_sists_tarefas = $conn->prepare($query_sists_tarefas);
                    $result_sists_tarefas->execute();
                    
                    // DEIXAR EM BRANCO SE AINDA NÃO FOI PESQUISADO
                    $valor_pesq_list = "";
                    // DEIXAR PREENCHIDO SE JA FOI PESQUISADO
                    if(!empty($dados['situacao'])){
                        foreach($dados['situacao'] as $sists_tarefa_id){
                            $valor_pesq_list .= "$sists_tarefa_id, ";
                        }
                    }

                    while ($row_situacao = $result_sists_tarefas->fetch(PDO::FETCH_ASSOC)) {
                        extract($row_situacao);
                        // mb_strpos VERIFICAR SE DENTRO DA STRING ESXITE O VALOR ESPECIFICO
                        $result_valor = mb_strpos($valor_pesq_list, $id);
                        if($result_valor === false){
                            $checked = "";
                        }else{
                            $checked = "checked";
                        }
                        echo "<input class='check-box' type='checkbox' name='situacao[]' value='$id' $checked requerid>$nome<br>";
                        //echo "<input class='check-box' type='checkbox' name='situacao[]' value='$id' checked>$nome<br>";

                    }
                        //echo "<br>";
                        //echo "Escolha uma opção";
                        echo "<br>";
                        
                ?>
                <input type="submit" value="Pesquisar" name="PesqUsuario"><br><br>
            </form>

            <?php
                if (!empty($dados['PesqUsuario'])) {
                    $valor_pesq = "";
                    $controle = 1;
                    foreach ($dados['situacao'] as $sists_tarefa_id) {
                        if ($controle == 1) {
                            $valor_pesq = $sists_tarefa_id;
                        } else {
                            $valor_pesq .= ", $sists_tarefa_id";
                        }
                        $controle++;
                    }

                    $query_tarefas = "SELECT id, nome, tarefa, sists_tarefa_id FROM tarefas WHERE sists_tarefa_id IN ($valor_pesq) ORDER BY id DESC";
                    $result_tarefas = $conn->prepare($query_tarefas);
                    $result_tarefas->execute();

                    while ($row_usuario = $result_tarefas->fetch(PDO::FETCH_ASSOC)) {
                        extract($row_usuario);
                    echo "<tbody class='list-tarefa'>";
                        echo "<tr>";
                            echo "<td name='id_usuario' style='text-align: center'>$id</td>";
                            echo "<td Nome do usuário: >$nome </td>";
                            echo "<td E-mail do usuário: >$tarefa </td>";
                            echo "<td Id da situação do usuário: >$sists_tarefa_id </td>";
                            echo "<td class='list-body-content'>";
                                echo "<a href='editar.php?id_usuario=$id'><button type='button' class='btn-warning'><i class='fa-solid fa-pen-to-square'></i></button></a>";
                                echo "<a href='apagar.php?id_usuario=$id'><button type='button' class='btn-danger'><i class='fa-solid fa-trash-can'></i></button></a>";
                                //echo "<a href='pesquisa-completa.php?id_usuario=$id_tar'><button type='button' class='btn-danger'><i class='fa-solid fa-magnifying-glass'></i></button></a>";
                            echo "</td>";
                        echo "</tr>";
                    echo "</tbody>";
                    }
                }
            ?>
      </div>
    </div>    

    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
</body>
</html>