<?php
    session_start();

    if(!isset($_SESSION['usuario'])){
        header('Location: ../index.php?erro=1');
    }

    include('../funcoes/tempo_sessao.php');

    $editado = isset($_GET['editado']) ? $_GET['editado'] : 0;
    $cadastrado = isset($_GET['cadastrado']) ? $_GET['cadastrado'] : 0;

?>

<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Categoria - Cadastre suas Categorias</title>

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
          $.post('get_categorias.php', dados, function(data){
                $('#lista_categoria').html(data);
            });
        }

      $(document).ready( function(){
        $('#btn_add').click( function(){
            $('#lista_categoria').addClass("invisivel");
            $('#btn_add').addClass("invisivel");
            $('#create_categoria').addClass("visivel");
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
          <span class="mdl-layout-title">Categoria</span>
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
          <div>
          <?= "<p>Usuário " . $_SESSION['usuario_id'] . ' <br> ' . $_SESSION['usuario_nome'] . '<br>' . $_SESSION['permissao_descricao'] . "(a)</p>" ?>
          </div>
        </header>

        <nav class="demo-navigation mdl-navigation mdl-color--blue-grey-800">
          <a class="mdl-navigation__link" href="../home/home.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">leaderboard</i>Dashboard</a>
          <a class="mdl-navigation__link menu_ativo" href="categoria.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">category</i>Categoria</a>
          <a class="mdl-navigation__link" href="../produtos/produtos.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">list</i>Produtos</a>
          <a class="mdl-navigation__link" href="../estoque/estoque.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">view_in_ar</i>Mov. de Estoque</a>
          <a class="mdl-navigation__link" href="../perfil/perfil.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">person</i>Perfil</a>
          <a class="mdl-navigation__link" href="../empresas/empresa.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>Empresa</a>
        </nav>

        <span id="versao"></span>
      </div>

      <main class="mdl-layout__content mdl-color--grey-100">
        <?php 
          if($editado == 1){
            echo '<p style="color:green; text-align:center;">Categoria <b>alterada</b> com Sucesso!</p>';
          } elseif($cadastrado == 1){
            echo '<p style="color:green; text-align:center;">Categoria <b>cadastrada</b> com Sucesso!</p>';
          } 
        ?>
        <div id="lista_categoria" class="list-group">

        </div>

        <div class="invisivel container_ccategoria demo-card-square mdl-card mdl-shadow--2dp" id="create_categoria">
          <form id="cadastrar_categoria" method="POST" action="cadastro_categoria.php">
            <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <label class="label_input" for="categoria_descricao">Descrição da Categoria</label>
              <input class="input_style" type="text" id="categoria_descricao" name="categoria_descricao" required>              
            </div>
            <div class="mdl-card__actions">
              <button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" id="btn_inclui">
                Inserir
              </button>
            </div>
          </form>
        </div>
        <div class="invisivel container_acategoria demo-card-square mdl-card mdl-shadow--2dp" id="edit_categoria">
          <form id="editar_categoria" method="POST" action="editar_categoria.php">
            <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <label class="label_input" for="id">Identificação da Categoria</label>
              <input class="input_style" type="text" id="id" name="id" readonly=“true”>
            </div>
            <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <label class="label_input" for="categoria_adescricao">Descrição da Categoria</label>
              <input class="input_style" type="text" id="categoria_adescricao" name="categoria_adescricao" required>              
            </div>
            <div class="mdl-card__actions">
              <button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" id="btn_altera">
                Alterar
              </button>
            </div>
          </form>
        </div>
        <button class="btn_add" id="btn_add"><i class="material-icons">add</i></button>
      </main>
    </div> 
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
  </body>
</html>
