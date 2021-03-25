<?php
    session_start();

    if(!isset($_SESSION['usuario'])){
        header('Location: index.php?erro=1');
    }

    $perfil_editado = isset($_GET['perfil_editado']) ? $_GET['perfil_editado'] : 0;
    $erro_email = isset($_GET['erro_email']) ? $_GET['erro_email'] : 0;

    include('../funcoes/tempo_sessao.php');
 
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Perfil - Edite seu Perfil</title>

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
          url: "get_perfil.php",
          success: function(data){
            $('#lista_perfil').html(data);
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
          <span class="mdl-layout-title">Perfil</span>
          <div class="mdl-layout-spacer"></div>
          <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="hdrbtn">
            <i class="material-icons">more_vert</i>
          </button>
          <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="hdrbtn">
            <a href="funcoes/sair.php"><li class="mdl-menu__item">Sair</li></a>
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
          <a class="mdl-navigation__link" href="../estoque/estoque.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">view_in_ar</i>Mov. de Estoque</a>
          <a class="mdl-navigation__link menu_ativo" href="perfil.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">person</i>Perfil</a>
          <a class="mdl-navigation__link" href="../empresas/empresa.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>Empresa</a>
        </nav>

        <span id="versao"></span>
      </div>

      <main class="mdl-layout__content mdl-color--grey-100">
        <div id="lista_perfil" class="list-group">

        </div>

        <div class="invisivel container_perfil demo-card-square mdl-card mdl-shadow--2dp" id="edit_perfil">
          <form id="editar_perfil" method="POST" action="editar_perfil.php">
            <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <label class="label_input" for="usuario_nome">Nome</label>
              <input class="input_style" type="text" id="usuario_nome" name="usuario_nome" value="<?=$_SESSION['usuario_nome'];?>" required>
            </div>
            <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <label class="label_input" for="usuario_email">E-mail</label>
              <input class="input_style" type="email" id="usuario_email" name="usuario_email" value="<?=$_SESSION['usuario_email'];?>" required>        
            </div>
            <?php if($erro_email){echo "<p style='color:red';>Esse e-mail já existe em nossa base!</p>";}  ?>
            <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <label class="label_input" for="usuario_fone">Fone</label>
              <input class="input_style" type="fone" id="usuario_fone" name="usuario_fone" value="<?=$_SESSION['usuario_fone'];?>">  
            </div>
            <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <label class="label_input" for="usuario_senha">Senha</label>
              <input class="input_style" type="password" id="usuario_senha" name="usuario_senha"> 
            </div>
            <div class="mdl-card__actions">
              <button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                Alterar
            </button>
            </div>
          </form>
        </div>
      </main>
    </div>
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
  </body>
</html>
