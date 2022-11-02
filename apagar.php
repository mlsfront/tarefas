<?php
session_start();

include_once "conexao.php";

$id_usuario = filter_input(INPUT_GET, "id_usuario", FILTER_SANITIZE_NUMBER_INT);

if ($id_usuario) {
    try {
        $query_tarefa = "DELETE FROM tarefas WHERE id=:id LIMIT 1";
        $apagar_tarefa = $conn->prepare($query_tarefa);
        $apagar_tarefa->bindParam(':id', $id_usuario, PDO::PARAM_INT);
        if ($apagar_tarefa->execute()) {
            $_SESSION['msg'] = "<p style='color: green;'>Tarefa apagada com sucesso!</p>";
            header("Location: index.php");
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Tarefa não apagada com sucesso!</p>";
            header("Location: index.php");
        }
    } catch (PDOException $erro) {
        $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Tarefa não apagada com sucesso!</p>";
        //$_SESSION['msg'] = "<p style='color: #f00;'>Erro: Tarefa não apagada com sucesso. Erro gerado: " . $erro->getMessage() . " </p>";
        header("Location: index.php");
    }
} else {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Tarefa não encontrado!</p>";
    header("Location: index.php");
}
