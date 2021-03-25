<?php
    class db{
        // host
        private $host = 'localhost';

        // usuario
        private $user = 'root';

        // senha
        private $password = '';

        // banco de dados
        private $database = 'db_estoque';


        public function conecta_mysql(){

            // criar a conexão
            $conexao = mysqli_connect($this->host, $this->user, $this->password, $this->database);

            // Ajustar o charset de comunicação entre a aplicação eo Banco de Dados
            mysqli_set_charset($conexao,'UTF-8');

            // Verificar erro de conexão
            if(mysqli_connect_errno()){
                echo 'Houve um erro de conexão com o banco de dados <br>Erro: <br>' . mysqli_connect_error();
            }

            return $conexao;
        }
    }
?>