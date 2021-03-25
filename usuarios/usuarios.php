<?php
    session_start();

    if(!isset($_SESSION['usuario'])){
        header('Location: ../index.php?erro=1');
    }

    $erro_email = isset($_GET['erro_email']) ? $_GET['erro_email'] : 0;
    $erro_usuario = isset($_GET['erro_usuario']) ? $_GET['erro_usuario'] : 0;

    include('../funcoes/tempo_sessao.php');
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Usuários</title>

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
          $.post('get_usuarios.php', dados, function(data){
                $('#lista_usuario').html(data);
            });
        }

        $(document).ready( function(){
          $('#pesquisar').click( function(){
            $.post('get_usuarios.php', dados, function(data){
                  $('#lista_usuario').html(data);
            });
          });
        });

        $(document).ready( function(){
          $('#btn_add').click( function(){
              $('#list_usuarios').addClass("invisivel");
              $('#btn_add').addClass("invisivel");
              $('#create_user').addClass("visivel");
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
          <span class="mdl-layout-title">ADM - Usuários</span>
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
          <a class="mdl-navigation__link menu_ativo" href="usuarios.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">people</i>Usuários</a>
          <a class="mdl-navigation__link" href="../logs/logs.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">analytics</i>Log</a>
        </nav>

        <span id="versao"></span>
      </div>
      <main class="mdl-layout__content mdl-color--grey-100">

        <div class="list-group" id="list_usuarios">
          <div id="lista_usuario">

          </div>
        </div>

        <div class="invisivel container_eusuario demo-card-square mdl-card mdl-shadow--2dp" id="edit_user">
            <form id="editar_usuario" method="POST" action="edicao/editar_usuario.php">
                <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <label class="select_tipo" for="permissao_editar">Permissão</label><br>
                    <select class="select_tipo" name="permissao_editar" id="permissao_editar">
                        <option value="1">Administrador</option>
                        <option value="2">Proprietario</option>
                        <option value="3">Gerente</option>
                        <option value="4">Vendedor</option>
                    </select>
                </div>
                <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <label class="select_tipo" for="ativo">Ativo</label><br>
                    <select class="select_tipo" name="ativo" id="ativo">
                        <option value="S">Sim</option>
                        <option value="N">Não</option>
                    </select>
                </div>

                <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <label class="label_input" for="id">Cód.: Usuário</label>
                    <input class="input_style" type="text" id="id" name="id">
                </div>
                <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <label class="label_input" for="senha_editar">Senha</label>
                    <input class="input_style" type="password" id="senha_editar" name="senha_editar">
                </div>

                <div class="mdl-card__actions">
                <button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                    Alterar
                </button>
                </div>
            </form>
        </div>

        <div class="invisivel container_cusuario demo-card-square mdl-card mdl-shadow--2dp" id="create_user">
            <form id="cadastrar_usuario" method="POST" action="cadastro/cadastro_usuario.php">


                <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label class="select_tipo" for="permissao">Permissão</label><br>
                  <select class="select_tipo" name="permissao" id="permissao">
                    <option value="1">Administrador</option>
                    <option value="2">Proprietario</option>
                    <option value="3">Gerente</option>
                    <option value="4">Vendedor</option>
                  </select>
                </div>
                <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <label class="label_input" for="nome">Nome</label>
                  <input class="input_style" type="text" id="nome" name="nome" required>
                </div>
                <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <?php 
                    if($erro_email){
                      echo "<p style='color:red';>E-mail já existe!</p>";
                    }        
                  ?>
                  <label class="label_input" for="email">E-mail</label>
                  <input class="input_style" type="email" id="email" name="email" required>              
                </div>
                <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <label class="label_input" for="fone">Fone</label>         
                  <input class="input_style" type="text" id="fone" name="fone">
                </div>
                <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <?php 
                    if($erro_usuario){
                      echo "<p style='color:red';>Usuário já existe!</p>";
                    }
                  ?>
                  <label class="label_input" for="user">Usuário</label>
                  <input class="input_style" type="text" id="user" name="user" required>                  
                </div>
                <div class="campos_perfil mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <label class="label_input" for="senha">Senha</label>
                  <input class="input_style" type="password" id="senha" name="senha" required>                    
                </div>

                <div class="mdl-card__actions">
                <button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                    Cadastrar
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

