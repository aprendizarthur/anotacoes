<?php
namespace app\classes;
use app\classes\Database;

class User extends Database
{
    private string $name;
    private string $email;
    private string $pass;
    private string $passConfirmation;

    //trait para validar dados login
    use \app\traits\AuthUser;

    public function __construct(){
        
    }

    //método que realiza o registro do usuário
    public function Register() : void{
        //pegando dados do post e sanitizando
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){
            $this->name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $this->email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
            $this->pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
            $this->passConfirmation = filter_input(INPUT_POST, 'passConfirmation', FILTER_SANITIZE_STRING);
            
            //validando email
            if(!$this->AuthEmail($this->email)){
                throw new \Exception("E-mail inválido");
            }

            //verificando se esse e-mail já foi cadastrado
            if($this->VerificaDisponibilidadeEmail()){
                throw new \Exception("E-mail já registrado em outra conta");
            }

            //validando nome
            if(!$this->AuthName($this->name)){
                throw new \Exception("Nome inválido");
            }

            //validando requisitos senha
            if(!$this->AuthPass($this->pass)){
                throw new \Exception("Senha muito curta");
            }

            //validando se a confirmação e a senha conferem 
            if(!$this->AuthPassRegister($this->pass, $this->passConfirmation)){
                throw new \Exception("As senhas não coincidem");
            }

            //salvando usuário no db
            $this->registrarUsuarioDB();

            //encaminhando dados do usuário para a session e enviando usuário para o panel
            $this->conectarUsuario();
        }
    }

    //método que realiza o login
    public function Login() : void{
        //pegando dados do POST e sanitizando
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){
            $this->email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
            $this->pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
        
            //validando email
            if(!$this->AuthEmail($this->email)){
                throw new \Exception("Email inválido");
            }

            //validando tamanho senha
            if(!$this->AuthPass($this->pass)){
                throw new \Exception("Senha muito curta");
            }

            //verificando se existe o usuário
            if(!$this->verificarExisteUsuario()){
                throw new \Exception("E-mail não está cadastrado");
            }

            //verificando se a senha do usuário está correta
            if(!$this->verificarSenhaCorretaUsuario()){
                throw new \Exception("Senha incorreta");
            }

            //encaminhando os dados para a session e enviando usuario para o panel
            $this->conectarUsuario();
        }
    }

    //método que realiza o logout do usuário pelo POST
    public function Logout() : void{
        if(isset($_POST['submit-logout'])){ 
            if(session_status() === PHP_SESSION_NONE){
                session_start();
            }

            session_unset();
            session_destroy();
            
            header("Location: index.php");
            exit();
        }
    }

    //método privado que verifica se o usuário existe no banco de dados
    private function verificarExisteUsuario() : bool{
        try{
            $PDO = Database::$PDO;
            $res = $PDO->prepare("SELECT COUNT(*) AS total FROM usuarios WHERE email = :e");
            $res->bindValue(":e", $this->email);
            $res->execute();
            $resultado = $res->fetchAll(\PDO::FETCH_ASSOC);    
        }catch(PDOException $e){
            echo '<div class="col-12 text-center">'.$e->getMessage().'</div>';
        }    
            
        //se não houver ninguem com este email retorna exception
        if($resultado[0]['total'] < 1){
            return false;
        }

        return true;
    }

    //método privado que verifica se a senha da tentativa de login está correta
    private function verificarSenhaCorretaUsuario() : bool{
        try{
            $PDO = Database::$PDO;
            $res = $PDO->prepare("SELECT senha FROM usuarios WHERE email = :e");
            $res->bindValue(":e", $this->email);
            $res->execute();
            $resultado = $res->fetchAll(\PDO::FETCH_ASSOC);    
        }catch(PDOException $e){
            echo '<div class="col-12 text-center">'.$e->getMessage().'</div>';
        }
        
        $passDB = $resultado[0]['senha'];
        if(!password_verify($this->pass, $passDB)){
            return false;
        }

        return true;
    }

    //método que passa os dados do usuário que logou para a sessão e encaminha ele para o panel
    private function conectarUsuario() : void{
        try{
            $PDO = Database::$PDO;
            $res = $PDO->prepare("SELECT id, nome, email FROM usuarios WHERE email = :e");
            $res->bindValue(":e", $this->email);
            $res->execute();
            $resultado = $res->fetchAll(\PDO::FETCH_ASSOC);    
        }catch(PDOException $e){
            echo '<div class="col-12 text-center">'.$e->getMessage().'</div>';
        }
        
        $_SESSION['id-usuario'] = $resultado[0]['id'];
        $_SESSION['nome-usuario'] = $resultado[0]['nome'];
        $_SESSION['email-usuario'] = $resultado[0]['email'];

        header("Location: panel.php");
        exit();
    }

    //método que verifica se o email de registro já está cadastrado
    private function VerificaDisponibilidadeEmail(){
        try{
            $PDO = Database::$PDO;
            $res = $PDO->prepare("SELECT COUNT(*) AS total FROM usuarios WHERE email = :e");
            $res->bindValue(":e", $this->email);
            $res->execute();
            $resultado = $res->fetchAll(\PDO::FETCH_ASSOC);
        } catch(PDOException $e){
            echo '<div class="col-12 text-center">'.$e->getMessage().'</div>';
        }

        if($resultado[0]['total'] != 0){
            return true;
        }

        return false;
    }

    //método que registra o usuário no db pós passar por verificação
    private function registrarUsuarioDB() : void{
        try{
            $PDO = Database::$PDO;
            $res = $PDO->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (:n, :e, :s)");
            $res->bindValue(":n", $this->name);
            $res->bindValue(":e", $this->email);
            $res->bindValue(":s", password_hash($this->pass, PASSWORD_DEFAULT));
            $res->execute();
        }catch(PDOException $e){
            echo '<div class="col-12 text-center">'.$e->getMessage().'</div>';
        }
    }
}