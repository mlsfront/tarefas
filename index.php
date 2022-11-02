<?php
session_start();
include_once "conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <title>Tarefas</title>
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
            <h2 class="text-titulo mt-3 mb-3">Tarefas<a class="nav-link" href="cadastrar.php"><i class="fa-regular fa-address-card"></i></a></h2>
            <table class='table table-dark table-striped"'>
                <thead class='list-head'>
                    <tr>
                        <th class='list-head-content'>ID</th>
                        <th class='list-head-content'>Nome</th>
                        <th class='list-head-content'>Tarefa</th>
                        <!--<th class='list-head-content'>ID</th>-->
                        <th class='list-head-content'>Situação</th>
                        <!--<th class='list-head-content'>ID</th>-->
                        <th class='list-head-content'>Modalidade</th>
                        <th class='list-head-content'>Data</th>
                        <th class='list-head-content table-lg-none'>Açôes</th>
                    </tr>
                </thead>
                <?php
                    if(isset($_SESSION['msg'])){
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }

                    $query_tarefas = "SELECT tar.id AS id_tar, tar.nome AS nome_tar, tar.tarefa, tar.created, sit.id AS id_sit, sit.nome AS nome_sit, moda.id AS id_moda, moda.nome AS nome_moda FROM tarefas AS tar INNER JOIN sists_tarefas AS sit ON sit.id=tar.sists_tarefa_id AND sit.id!=4 INNER JOIN modalidades AS moda ON moda.id=tar.modalidade_id  ORDER BY sit.nome ASC LIMIT 40";
                    $result_tarefas = $conn->prepare($query_tarefas);
                    $result_tarefas->execute();

                    while($row_tarefa = $result_tarefas->fetch(PDO::FETCH_ASSOC)){
                        //var_dump($row_tarefa);
                        extract($row_tarefa);
                    echo "<tbody class='list-tarefa'>";
                        echo "<tr>";
                            echo "<td name='id_usuario' style='text-align: center'>$id_tar</td>";
                            echo "<td Nome do usuário: >$nome_tar </td>";
                            echo "<td E-mail do usuário: >$tarefa </td>";
                            //echo "<td Id da situação do usuário: >$id_sit </td>";
                            echo "<td Nome do situação do usuário: >$nome_sit</td>";
                            //echo "<td Id do nível de acesso do usuário: >$id_moda </td>";
                            echo "<td Nome do nível de acesso do usuário: >$nome_moda </td>";
                            echo "<td class='table-sm-none'>". date('d/m/Y', strtotime($created)) . "</td>";
                            echo "<td class='list-body-content'>";
                                echo "<a href='editar.php?id_usuario=$id_tar'><button type='button' class='btn-warning'><i class='fa-solid fa-pen-to-square'></i></button></a>";
                                echo "<a href='apagar.php?id_usuario=$id_tar'><button type='button' class='btn-danger'><i class='fa-solid fa-trash-can'></i></button></a>";
                                //echo "<a href='pesquisa-completa.php?id_usuario=$id_tar'><button type='button' class='btn-danger'><i class='fa-solid fa-magnifying-glass'></i></button></a>";
                            echo "</td>";
                        echo "</tr>";
                    echo "</tbody>";
                    }
                ?>
            </table>

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