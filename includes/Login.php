<?php

/**
 * Classe para efetuar um login
 * Ela implementa a interface SplSubject
 */
class Login implements SplSubject {

    const IN = 'in';
    const OUT = 'out';

    /**
     * ArrayObject de observadores
     * @var ArrayObject
     */
    private $observers;

    /**
     * Conexao para pesquisar o usuario
     * @var mysqli
     */
    private $conn;

    /**
     * Dados enviados pelo usuario
     * @var array
     */
    private $data = array();

    /**
     * Tipo usuario
     * @var User
     */
    private $user;

    /**
     * Retorna o tipo de operação
     * @return string Operacao
     */
    public function getOperation() {
        return $this->operation;
    }

    /**
     * Indica uma operação a ser executada.
     * @param String $operation Operação a ser executada
     */
    public function setOperation($operation) {
        $this->operation = $operation;
    }

    private $operation;

    /**
     * Construtor da classe, inicia-se com uma conexao ao banco de dados, e inicializa o arrayobject;
     * @param mysqli $conn Conexao ao banco
     */
    public function __construct(mysqli $conn) {
        $this->conn = $conn;
        $this->observers = new ArrayObject();
    }

    /**
     * Entra com os dados do usuario
     * @param array $data Dados do usuario
     */
    public function setData(array $data) {
        $this->data = $data;
    }

    /**
     * Agrega um observador para este sujeito
     * @param SplObserver $observer Observador que ira manipular os dados deste sujeito
     */
    public function attach(SplObserver $observer) {
        $this->observers->append($observer);
    }

    /**
     * Remove um observador deste sujeito
     * @param SplObserver $observer Observador que sera removido
     */
    public function detach(SplObserver $observer) {
        $count = $this->observers->count();
        for ($i = 0; $i < $count; $i++) {
            if ($this->observers->offsetGet($i) == $observer) {
                $this->observers->offsetUnset($i);
            }
        }
    }

    /**
     * Indica um tipo de usuario
     * @param User $u Usuario
     */
    public function setUser(User $u) {
        $this->user = $u;
    }

    /**
     * Retorna um usuario
     * @return User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Pesquisa pelo usuario em questao e notifica os observadores.
     */
    public function notify() {

        switch ($this->getOperation()) {
            case self::IN:
                $data = array_filter($this->data, 'trim');
                $data = array_filter($data, 'htmlentities');
                $data = array_filter($data, 'addslashes');
                $pre = $this->conn->prepare("SELECT nome,senha,idusers,niveis_fk FROM users where login=?");

                $pre->bind_param('s', $login);
                $login = $data['login'];
               
                if ($pre->execute()) {
                    $pre->bind_result($nome, $senha,$idusers,$nivel);
                    $pre->fetch();                     
                    if (getPasswdSalt($data['senha'], $senha)) {
                        $this->getUser()->setName($nome);                      
                        $this->getUser()->setId($idusers);
                        $this->getUser()->setNivel($nivel);
                        $iterator = $this->observers->getIterator();
                        while ($iterator->valid()) {
                            $iterator->current()->update($this);
                            $iterator->next();
                        }
                    }
                }
                break;
            case self::OUT:
                $iterator = $this->observers->getIterator();
                while ($iterator->valid()) {
                    $iterator->current()->update($this);
                    $iterator->next();
                }
                break;
        }
    }

}
