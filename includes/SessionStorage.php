<?php

/**
 * Classe para armazenar dados na sessao, implementa a interface SplObserver
 */
class SessionStorage implements SplObserver {

    /**
     * Construtor da classe, inicia a sessao
     */
    public function __construct($name=null) {
       
            session_start();
        
    }

    /**
     * Cria uma pseudo propriedade 
     * @param mixed $key Nome o indice do array da sessao
     * @param mixed $value Valor do indice do array da sessao
     */
    public function __set($key, $value) {
        $_SESSION[$key] = serialize($value);
    }

    /**
     * Recupera um valor da sessao
     * @param String $key indice do array a ser recuperado 
     * @return mixed
     */
    public function __get($key) {
        
        return isset($_SESSION[$key]) ? unserialize($_SESSION[$key]) : null;
    }

    /**
     * Atualiza um sujeito ou varios.
     * @param SplSubject $subject Sujeito a ser atualizado
     */
    public function update(SplSubject $subject) {
        switch ($subject->getOperation()) {
            case 'in':
                $_SESSION['user'] = serialize($subject->getUser());
                
               header("location:index.php");
                break;
            case 'out':
                unset($_SESSION['user']);
                echo '<script>window.location="login.php"</script>';
                break;
        }
    }
}