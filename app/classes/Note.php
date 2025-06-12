<?php
namespace app\classes;
use app\classes\Database;

//classe que instancia uma nota do usuário e extende databse
class Note extends Database
{
    private int $id;
    private int $idUser;
    private string $title;
    private string $content;
    private string $color;
    
    //usando trait que valida dados da nota
    use \app\traits\AuthNote;
    
    public function __construct(){

    }

    //método que retorna todas as notas do usuário num array associativo
    public function All() : array{
        $this->idUser = (int)htmlspecialchars($_SESSION['id-usuario']);
        $dados = $this->todasNotas();
        return $dados;
    }

    //método que retorna dados da nota no arquivo note.php (pegando id GET)
    public function show(){
        //pegando id do get e sanitizando
        $id = $_GET['id'];
        $this->id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        //verificando se a nota existe, se existe passa dados, se não passa false
        if(!$this->existeNota($this->id)){
            throw new \Exception("Link aponta para nota que não existe ou não é de sua autoria");
        }

        $dados = $this->existeNota($this->id);
        return $dados;
    }

    //método que atualiza uma nota
    public function Update() : void {
        //pegando dados do post, id do get e sanitizando
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){
            $this->id = (int)htmlspecialchars($_GET['id']);
            $this->title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
            $this->content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);
            $this->color = filter_input(INPUT_POST, 'color', FILTER_SANITIZE_STRING);
            $this->idUser = htmlspecialchars($_SESSION['id-usuario']);

            //atualizando nota no db
            $this->atualizarDB();

            //enviando usuário para o panel
            header("Location: panel.php");
        }
    }

    //método que deleta uma nota
    public function Delete() : void {
        //pegando id do get
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit-delete'])){
            $this->id = (int)htmlspecialchars($_GET['id']);

            //deletando a nota do db
            $this->deletarDB($this->id);

            //encaminhando usuário para o panel
            header("Location: panel.php");
        }
    }

    //método que adiciona uma nota no db
    public function Add() : void{
        //esperando dados post e sanitizando
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){
            $this->title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
            $this->content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);
            $this->color = filter_input(INPUT_POST, 'color', FILTER_SANITIZE_STRING);
            $this->idUser = htmlspecialchars($_SESSION['id-usuario']);

            //validando título
            if(!$this->AuthTitle($this->title)){
                throw new \Exception("Título inválido (Use apenas caracteres entre a-z e 0-9)");
            }
    
            //validando conteúdo
            if(!$this->AuthContent($this->content)){
                throw new \Exception("Conteúdo inválido (Use apenas caracteres entre a-z e 0-9)");
            }
    
            //adicionando nota no banco
            $this->adicionarDB();

            //redirecionando usuário ao panel
            header("Location: panel.php");
        }
    }
    
    //método privado que adiciona a nota ao DB pós validação
    public function adicionarDB(){
        try{
            $PDO = Database::$PDO;
            $res = $PDO->prepare("INSERT INTO notas (id_usuario, titulo, conteudo, cor) VALUES (:i, :t, :c, :l)");
            $res->bindValue(":i", $this->idUser);
            $res->bindValue(":t", $this->title);
            $res->bindValue(":c", $this->content);
            $res->bindValue(":l", $this->color);
            $res->execute();
        }catch(PDOException $e){
            echo '<div class="col-12 text-center">'.$e->getMessage().'</div>';
        } 
    }

    //método privado que pega todas as notas do usuário e retorna um array com elas
    private function todasNotas() : array{
        try{
            $PDO = Database::$PDO;
            $res = $PDO->prepare("SELECT * FROM notas WHERE id_usuario = :i ORDER BY data_edicao DESC");
            $res->bindValue(":i", $this->idUser);
            $res->execute();
            $resultado = $res->fetchAll(\PDO::FETCH_ASSOC);
            return $resultado;
        }catch(\PDOException $e){
            echo '<div class="col-12 text-center">'.$e->getMessage().'</div>';
        }
    }

    //método privado que recebe um id de nota e verifica se ela existe no db
    private function existeNota(int $id) : array|bool{
        try {
            $idUser = $_SESSION['id-usuario'];
            $PDO = Database::$PDO;
            $res = $PDO->prepare("SELECT * FROM notas WHERE id = :i AND id_usuario = :j");
            $res->bindValue(":i", $id);
            $res->bindValue(":j", $idUser);
            $res->execute();
            $resultado = $res->fetch(\PDO::FETCH_ASSOC);

            return $resultado !== false ? $resultado : false;
        } catch (\PDOException $e) {
            echo '<div class="col-12 text-center">'.$e->getMessage().'</div>';
        }
    }

    //método privado que atualiza os dados de uma nota no db
    private function atualizarDB() : void{
        try {
            $PDO = Database::$PDO;
            $res = $PDO->prepare("UPDATE notas SET titulo = :t, conteudo = :c, cor = :l WHERE id = :i");
            $res->bindValue(":i", $this->id);
            $res->bindValue(":t", $this->title);
            $res->bindValue(":c", $this->content);
            $res->bindValue(":l", $this->color);
            $res->execute();
        } catch (\PDOException $e) {
            echo '<div class="col-12 text-center">'.$e->getMessage().'</div>';
        }
    }

    //método privado que deleta a nota do db
    private function deletarDB(int $id) : void{
        try {
            $PDO = Database::$PDO;
            $res = $PDO->prepare("DELETE from notas WHERE id = :i");
            $res->bindValue(":i", $id);
            $res->execute();
        } catch (\PDOException $e) {
            echo '<div class="col-12 text-center">'.$e->getMessage().'</div>';
        }
    }
}