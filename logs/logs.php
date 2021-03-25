<?php
    session_start();

    if(!isset($_SESSION['usuario'])){
        header('Location: ../index.php?erro=1');
    }

    $erro_email = isset($_GET['erro_email']) ? $_GET['erro_email'] : 0;
    $erro_usuario = isset($_GET['erro_usuario']) ? $_GET['erro_usuario'] : 0;
    $usuario_cadastrado = isset($_GET['usuario_cadastrado']) ? $_GET['usuario_cadastrado'] : 0;

    include('../funcoes/tempo_sessao.php');
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Logs</title>

    <!-- <link rel="shortcut icon" href="images/favicon.png"> -->
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.cyan-light_blue.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <style>#versao{margin: auto;} #versao p{font-size: 12px;}</style>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    
    <script type="text/javascript">

        var qtd_registro = 10; // quantidade de registro por página
        var pagina = 1;

        $(document).ready(function (){
          paginacao(pagina, qtd_registro);
        });

        function paginacao(pagina, qtd_registro){
          var dados = {
            pagina: pagina,
            qtd_registro: qtd_registro
          }
          $.post('get_log.php', dados, function(data){
                $('#lista_log').html(data);
            });
        }

        function listaversao(){
          $.ajax({
                url: "../funcoes/get_versao.php",
                success: function(data){
                $('#versao').html(data);
                }
            });
        }
        listaversao();
    </script>
  </head>
  <body>
    <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">

      <header class="demo-header mdl-layout__header mdl-color--grey-100 mdl-color-text--grey-600">
        <div class="mdl-layout__header-row">
          <span class="mdl-layout-title">ADM - Logs</span>
          <div class="mdl-layout-spacer"></div>
          <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="hdrbtn">
            <i class="material-icons">more_vert</i>
          </button>
          <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="hdrbtn">
            <a href="../funcoes/sair.php"><li class="mdl-menu__item">Sair</li></a>
          </ul>
        </div>
      </header>

      <div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
        <header class="demo-drawer-header">
            <div class="menu_usuario">
                <?= "<p>Usuário " . $_SESSION['usuario_id'] . ' <br> ' . $_SESSION['usuario_nome'] . "</p>" ?>
            </div>
        </header>

        <nav class="demo-navigation mdl-navigation mdl-color--blue-grey-800">
          <a class="mdl-navigation__link" href="../home/home_adm.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">leaderboard</i>Dashboard</a>
          <a class="mdl-navigation__link" href="../usuarios/usuarios.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">people</i>Usuários</a>
          <a class="mdl-navigation__link menu_ativo" href="logs.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">analytics</i>Log</a>
        </nav>

        <span id="versao"></span>
      </div>
      <main class="mdl-layout__content mdl-color--grey-100">
        <div id="lista_log" class="list-group">
        
        </div>
      </main>

    </div>
      
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
  </body>
</html>