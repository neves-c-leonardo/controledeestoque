<?php
    session_start();

    if(!isset($_SESSION['usuario'])){
        header('Location: ../index.php?erro=1');
    }

    include('../funcoes/tempo_sessao.php');

    $movimentacao = isset($_GET['movimentacao']) ? $_GET['movimentacao'] : 0;
    $movimentacao_erro = isset($_GET['movimentacao_erro']) ? $_GET['movimentacao_erro'] : 0;
    $movimentacao_erro2 = isset($_GET['movimentacao_erro2']) ? $_GET['movimentacao_erro2'] : 0;
    $movimentacao_erro3 = isset($_GET['movimentacao_erro3']) ? $_GET['movimentacao_erro3'] : 0;
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Estoque - Controle seu Estoque Agora</title>

    <!-- <link rel="shortcut icon" href="images/favicon.png"> -->

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.cyan-light_blue.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <style>#versao{margin: auto;} #versao p{font-size: 12px;}</style>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script type="text/javascript">
      $(document).ready( function(){
        $.ajax({
          url: "get_mov_prod.php",
          success: function(data){
            $('#lista_prod').html(data);
          }
        });
      });

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
          <span class="mdl-layout-title">Movimentação de Estoque</span>
          <div class="mdl-layout-spacer"></div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
            <div class="mdl-textfield__expandable-holder">
              <input class="mdl-textfield__input" type="text" id="search">
              <label class="mdl-textfield__label" for="search">Pesquise aqui...</label>
            </div>
          </div>
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
          <div>
          <?= "<p>Usuário " . $_SESSION['usuario_id'] . ' <br> ' . $_SESSION['usuario_nome'] . '<br>' . $_SESSION['permissao_descricao'] . "(a)</p>" ?>
          </div>
        </header>

        <nav class="demo-navigation mdl-navigation mdl-color--blue-grey-800">
          <a class="mdl-navigation__link" href="../home/home.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">leaderboard</i>Dashboard</a>
          <a class="mdl-navigation__link" href="../categorias/categoria.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">category</i>Categoria</a>
          <a class="mdl-navigation__link" href="../produtos/produtos.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">list</i>Produtos</a>
          <a class="mdl-navigation__link menu_ativo" href="estoque.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">view_in_ar</i>Mov. de Estoque</a>
          <a class="mdl-navigation__link" href="../perfil/perfil.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">person</i>Perfil</a>
          <a class="mdl-navigation__link" href="../empresas/empresa.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>Empresa</a>
        </nav>

        <span id="versao"></span>
      </div>

      <main class="mdl-layout__content mdl-color--grey-100">
          <?php 
              if($movimentacao){
                echo "<p style='color:green; text-align:center;';>Movimentação Realizada!</p>";
              }elseif($movimentacao_erro){
                echo "<p style='color:red; text-align:center;';>Não foi possivel realizar a movimentação, produto ficara negativo!</p>";
              } elseif($movimentacao_erro2){
                echo "<p style='color:red; text-align:center;';>Provavelmente esse produto não existe! Tente Novamente!</p>";
              } elseif($movimentacao_erro3){
                echo "<p style='color:red; text-align:center;';>Não foi digitado uma quantidade válida!</p>";
              } 
          ?>
        <div class="container_estoque demo-card-square mdl-card mdl-shadow--2dp">
          <form id="movimentacao" method="POST" action="movimentar_estoque.php">
            <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label class="select_tipo" for="estoque_tipo">Tipo</label><br>
                <select class="select_tipo" name="estoque_tipo" id="estoque_tipo">
                    <option value="E">Entrada</option>
                    <option value="S">Saida</option>
                </select>
            </div>
            <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <label class="select_tipo" for="lista_prod">Produto</label><br>
              <select class="select_tipo" name="lista_prod" id="lista_prod">
                    
              </select>          
            </div>
            <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <label class="label_input" for="quantidade">Quantidade</label>
              <input class="input_style" type="numeric" id="quantidade" name="quantidade">              
            </div>
            
            <div class="mdl-card__actions">
              <button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                Movimentar
            </button>
            </div>
          </form>
        </div>
      </main>
    </div>
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
  </body>
</html>
