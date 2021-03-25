<?php
    $erro = isset($_GET['erro']) ? $_GET['erro'] : 0;
    $tempo_esgotado = isset($_GET['tempo_esgotado']) ? $_GET['tempo_esgotado'] : 0;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Tela de Login - Entrando na aplicação de Controle de Estoque</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="login">
    <div class="login-container">
        <form method="POST" action="funcoes/validar_acesso.php" id="login">
            <h2>Controle de Estoque</h2>

            <div class="input-container">
                <input type="text" name="usuario" id="usuario" required>
                <label for="usuario">Usuário</label>
            </div>

            <div class="input-container">
                <input type="password" name="senha" id="senha" required>
                <label for="senha">Senha</label>
            </div>

            <button id="enviar" name="enviar" type="submit" class="btn">Entrar</button>
        </form>
        <?php 
            if($erro == 1){
                echo '<p style="color:red; text-align:center;">Usuário e ou senha inválido(s)</p>';
            } elseif($erro == 2){
                echo '<p style="color:red; text-align:center;">Usuário não ativo</p>';
            } elseif($tempo_esgotado == 1){
                echo '<p style="color:red; text-align:center;">Tempo esgotado</p>';
            }
        ?>
    </div>
</body>
</html>