<?php
session_start();
include_once "conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <title>Modalidade</title>
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
            <h2 class="text-titulo mt-3 mb-3">Modalidades<a class="nav-link" href="cadmod.php"><i class="fa-solid fa-list"></i></a></h2>
            <table class='table table-dark table-striped"'>
                <thead class='list-head'>
                    <tr>
                        <th class='list-head-content'>ID</th>
                        <th class='list-head-content'>Nome</th>
                        <th class='list-head-content'>Data</th>
                        <th class='list-head-content table-lg-none'>Açôes</th>
                    </tr>
                </thead>
                <?php
                    if(isset($_SESSION['msg'])){
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }

                    $query_modalidades = "SELECT id, nome, created FROM modalidades ORDER BY nome ASC LIMIT 40";
                    $result_modalidades = $conn->prepare($query_modalidades);
                    $result_modalidades->execute();

                    while($row_modalidades = $result_modalidades->fetch(PDO::FETCH_ASSOC)){
                        //var_dump($row_modalidades);
                        extract($row_modalidades);
                    echo "<tbody class='list-tarefa'>";
                        echo "<tr>";
                            echo "<td name='id_usuario' style='text-align: center'>$id</td>";
                            echo "<td Nome do usuário: >$nome </td>";
                            echo "<td class='table-sm-none'>". date('d/m/Y', strtotime($created)) . "</td>";
                            echo "<td class='list-body-content'>";
                                echo "<a href='editmod.php?id_usuario=$id'><button type='button' class='btn-warning'><i class='fa-solid fa-pen-to-square'></i></button></a>";
                                echo "<a href='apagarmod.php?id_usuario=$id'><button type='button' class='btn-danger'><i class='fa-solid fa-trash-can'></i></button></a>";
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