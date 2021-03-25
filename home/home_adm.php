<?php
    session_start();

    if(!isset($_SESSION['usuario'])){
        header('Location: ../index.php?erro=1');
    }

    include('../funcoes/tempo_sessao.php');

?>

<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Dashboard - ADM</title>

    <!-- <link rel="shortcut icon" href="images/favicon.png"> -->
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.cyan-light_blue.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <style>#versao{margin: auto;} #versao p{font-size: 12px;}</style>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    
    <script type="text/javascript">
        function listainformacao(){
            $.ajax({
                url: "get_informacoes.php",
                success: function(data){
                $('#lista_informacoes').html(data);
                }
            });
        }
        listainformacao();

        function listacountlog(){
            $.ajax({
                url: "get_countlog.php",
                success: function(data){
                $('#lista_usuariolog').html(data);
                }
            });
        }
        listacountlog();

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
          <span class="mdl-layout-title">ADM - Dashboard</span>
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
          <a class="mdl-navigation__link menu_ativo" href="home_adm.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">leaderboard</i>Dashboard</a>
          <a class="mdl-navigation__link" href="../usuarios/usuarios.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">people</i>Usuários</a>
          <a class="mdl-navigation__link" href="../logs/logs.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">analytics</i>Log</a>
        </nav>
        <span id="versao"></span>
      </div>
      <main class="mdl-layout__content mdl-color--grey-100">
      <div class="list-group">
          <table class="mdl-data-table mdl-data-table-info mdl-shadow--2dp">
            <thead>
              <tr>
                <th>Info</th>
                <th>Quantidade</th>
              </tr>
            </thead>
            <tbody id="lista_informacoes">

            </tbody>
          </table>
          <table class="mdl-data-table mdl-data-table-info mdl-shadow--2dp">
          <thead>
              <tr>
                <th>Usuário</th>
                <th>Count Log</th>
              </tr>
            </thead>
            <tbody id="lista_usuariolog">
            
            </tbody>
          </table>
        </div>
      </main>

    </div>
      
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
  </body>
</html>