<?php


Class Consulta {

private $_conn;
private $_bind;
private $_where;
private $_my_conn;
private $__html;


    public function __construct() {

        $this->__html = new Basica;
    }

    /**
     * Método para iniciar a conexão do banco de dados e PDO
     */
    private function DB_Connect() {

        $this->_my_conn = mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['pass'], $_SESSION['db']);

        try {

            $this->_conn = new PDO("mysql:host={$_SESSION['host']};dbname={$_SESSION['db']}", $_SESSION['user'], $_SESSION['pass']);
            $this->_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {

            echo ("ERRO CONEXAO PDO");

        }
    }

    /**
     * Fechar conexão com o banco
     */
    private function DB_Close() {

        $this->_conn = null;
        mysqli_close($this->_my_conn);

        return true;
    }

    /**
     * Método para setar as binds
     * @param string $_valor
     * @param string $_nome
     * @param string $_campo
     * @param string $_operador
     */
    private function PDOMontaBind($_valor, $_nome, $_campo = '', $_operador = '=')
    {

        if ($_campo == '') {
            $_campo = $_nome;
        }

        if (($_valor <> '')and($_valor <> '%')) {

            if ($_operador == 'like'){
                $this->_where[] = "{$_campo} {$_operador} :{$_nome}";
                $this->_bind[$_nome] = "%{$_valor}%";
            } else if ($_operador == 'between'){
                $this->_where[] = "{$_campo} {$_operador} :{$_nome}_v1 AND :{$_nome}_v2";
                $this->_bind["{$_nome}_v1"] = $_valor[0];
                $this->_bind["{$_nome}_v2"] = $_valor[1];
            } else if ($_operador == 'in') {
                $this->_where[] = "{$_campo} {$_operador}(:{$_nome})";
                $this->_bind[$_nome] = $_valor;
            } else {
                $this->_where[] = "{$_campo} {$_operador} :{$_nome}";
                $this->_bind[$_nome] = $_valor;
            }

        }
    }

    /**
     * Método para setar o where
     */
    private function PDOMontaWhere()
    {
        if (count($this->_where) > 0) {
            $this->_where = "WHERE " . implode(' AND ', $this->_where);
        }
    }

    /**
     * Limpar valores do PDO
     */
    private function PDOClear()
    {
        unset($this->_bind);
        unset($this->_where);
    }

    /**
     * Método executar o SQL via PDO
     * @param string $_sql
     * @param string $_bind
     * @param string $_action
     * @return mixed
     */
    public function Query_SQL($_sql, $_bind = '', $_action = 'QUERY') {

        $this->DB_Connect();

        if (($_bind == '') and (isset($this->_bind))){
            $_bind = $this->_bind;
        }

        $_query = $this->_conn->prepare($_sql);

        foreach ($_bind as $key => $value) {
            $_query->bindValue(":{$key}", $value);
        }

        $_query->execute();

        if ($_action == 'QUERY') {

            $rows = $_query->fetchAll(PDO::FETCH_ASSOC);
            $a = 0;
            foreach ($rows as $key => $value) {

                $_retorno[$key] = $value;
                $a++;
            }
            $_retorno['contador'] = $a;

            return $_retorno;
        } else if ($_action == 'INSERT') {
            return $this->_conn->lastInsertId();

        } else if ($_action == 'UPDATE') {
            return $_query->rowCount();

        } else if ($_action == 'DELETE') {
            return $_query->rowCount();

        }
    }

    /**
     * Método para cadastrar usuário
     * @param string $_dados
     * @return mixed
     */
    public function CadastraUser($_dados) {

        $this->PDOClear();

        $this->_bind['b_nome']      = "{$_dados['nome']}";
        $this->_bind['b_id_perfil'] = "{$_dados['id_perfil']}";
        $this->_bind['b_email']     = "{$_dados['email']}";
        $this->_bind['b_senha']     = "{$_dados['senha']}";
        $this->_bind['b_cpf']       = "{$_dados['cpf']}";
        $this->_bind['b_telefone']  = "{$_dados['telefone']}";
        $this->_bind['b_cep']       = "{$_dados['cep']}";
        $this->_bind['b_data_mod']  = "{$_dados['data_mod']}";


        $_sql = "
                INSERT INTO
                    tab_user
                SET
                nome = :b_nome,
                id_perfil = :b_id_perfil,
                email = :b_email,
                senha = :b_senha,
                cpf = :b_cpf,
                telefone = :b_telefone,
                cep = :b_cep,
                data_mod = :b_data_mod;
                ";

        $_res = $this->Query_SQL($_sql, '', $_action = 'INSERT');

        return $_res;

    }

    /**
     * Método logar o cliente
     * @param string $_dados
     * @return boolean
     */
    public function LoginCliente($_dados) {

        $this->PDOClear();

        $this->PDOMontaBind($_dados['email'], 'b_email', 'email');
        $this->PDOMontaBind($_dados['senha'], 'b_senha', 'senha');

        $this->PDOMontaWhere();

        $_sql = "
                SELECT * FROM
                    tab_user
                $this->_where
                ;";

        $_res = $this->Query_SQL($_sql);

        if ($_res['contador'] == '1') {
            session_start();

            $nome_tmp = explode(' ', $_res[0]['nome']);

            $_SESSION['email']          = $_res[0]['email'];
            $_SESSION['nome_completo']  = $_res[0]['nome'];
            $_SESSION['nome']           = array_shift($nome_tmp) . ' ' . array_pop($nome_tmp);
            $_SESSION['id_user']        = $_res[0]['id'];
            $_SESSION['id_perfil']      = $_res[0]['id_perfil'];

            return true;
        } else {
            return false;
        }
    }

    /**
     * Método para deslogar o usuário
     */
    public function Deslogar() {
        session_destroy();

        if ($_SESSION['id'] == '') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Método para consultar clientes
     * @param string $_dados
     * @return mixed
     */
    public function ConsultaCliente($_dados) {

        $this->PDOClear();

        if($_dados['id_user'] <> '') {
            $this->PDOMontaBind($_dados['id_user'], 'id_user', 'id');
        }

        $this->PDOMontaWhere();

        $_sql = "
                SELECT
                    nome, email, cpf, endereco, telefone, estado, cep
                FROM
                    tab_user
                $this->_where
         ;";

        $_res = $this->Query_SQL($_sql);

        return $_res;
    }

    /**
     * Método para consultar pedidos
     * @param string $_dados
     * @return mixed
     */
    public function ConsultaPedidos($_dados) {

        $this->PDOClear();

        if($_dados['id_user'] <> '') {
            $this->PDOMontaBind($_dados['id_user'], 'bid_user', 'id_user');
        }

        $this->PDOMontaWhere();

        $_sql = "
                SELECT
                    id, id_user, id_carrinho, data_mod,
                    CASE
                        WHEN status = 0 THEN 'AGUARDANDO CONCLUSÃO'
                        WHEN status = 1 THEN 'AGUARDANDO PAGAMENTO'
                        WHEN status = 2 THEN 'PEDIDO APROVADO'
                    END as 'status'
                FROM
                    tab_pedido
                $this->_where
         ;";

        $_res = $this->Query_SQL($_sql);


        $a = 0;
        while ($a < $_res['contador']) {

            $linhas .= $this->__html->addHtml('tr', array('class' => 'text-dark font-century-title'), array(
                $this->__html->addHtml('td', array('class' => 'text-dark px-3'), $_res[$a]['id']),
                $this->__html->addHtml('td', array('class' => 'text-dark px-3'), $_res[$a]['status']),
                $this->__html->addHtml('td', array('class' => 'text-dark px-3'), $_res[$a]['data_mod']),
                $this->__html->addHtml('td', array('class' => 'text-dark px-3'), $this->__html->addHtml('i', array('class' => 'fas fa-search', 'onclick' => "VisualizarPedido({$_res[$a]['id']})", 'style' => 'cursor: pointer;'), '')),
            ));
            $a++;
        }

        $tabela = $this->__html->addHtml('table', array('class' => 'table table-hover table-dark bg-light'), array(
            $this->__html->addHtml('tr', array('class' => 'text-dark texto-grande titulo-prod'), array(
                $this->__html->addHtml('td', array('class' => 'text-dark px-5'), 'Número do pedido'),
                $this->__html->addHtml('td', array('class' => 'text-dark px-5'), 'Status'),
                $this->__html->addHtml('td', array('class' => 'text-dark px-5'), 'Realizado em'),
                $this->__html->addHtml('td', array('class' => 'text-dark px-5'), 'Detalhes'),
            )),
                $linhas,
        ));

        return $tabela;

    }

    /**
     * Método para consultar e gerar boletos
     * @param string $_dados
     * @return mixed
     */
    public function ConsultaBoleto($_dados) {

        $this->PDOClear();

        if($_dados['id_user'] <> '') {
            $this->PDOMontaBind($_dados['id_pedido'], 'id_pedido', 'b.id_pedido');
        }

        $this->PDOMontaWhere();

        $_sql = "
                SELECT
                    b.id, b.id_pedido, b.valor, b.itens, b.data_gerado, p.id_user, p.status, p.id_carrinho, u.nome, u.email, u.endereco, u.cpf, u.telefone, u.cep, u.estado
                FROM
                    tab_boleto b
                INNER JOIN tab_pedido p ON b.id_pedido = p.id
                INNER JOIN tab_user u ON p.id_user = u.id
                $this->_where
         ;";

        $_res = $this->Query_SQL($_sql);

        $a = 0;
        while ($a < $_res['contador']) {

            $_where['id_carrinho'] = substr($_res[$a]['id_carrinho'], 0, -1);

            $_res['produtos'] = $this->ConsultaCarrinho($_where);


            $a++;
        }

        return $_res;

    }

    /**
     * Método fazer a consulta
     * @param string $_dados
     * @param string $_table
     * @param string $_where
     * @return mixed
     */
    public function QueryPDO($_table, $_where = '', $_order_by = '')
    {
        $this->PDOClear();
        if ($_where <> '') {
            foreach ($_where as $key => $value) {
                $this->PDOMontaBind($value, "b_$key", $key);
            }
            $this->PDOMontaWhere();

        }

        $_sql = "
          SELECT
            *
          FROM
            {$_table}
          $this->_where
          {$_order_by}";

        return $this->Query_SQL($_sql,'', 'QUERY');

    }

    /**
     * Método fazer o UPDATE Genericamente
     * @param string $_dados
     * @param string $_table
     * @param string $_where
     * @return mixed
     */
    public function UpdatePDO($_dados, $_table, $_where)
    {
        foreach ($_dados as $key => $value) {
            $set[] = "{$key} = :{$key}";
            $_bind[$key] = $value;
        }
        $set_final = implode(',', $set);

        foreach ($_where as $key => $value) {
            $where[] = "{$key} = :where_{$key}";
            $_bind['where_'.$key] = $value;
        }
        $where_final = implode(' and ', $where);

        $_sql = "
          UPDATE
            {$_table}
          SET
            {$set_final}
          WHERE
            {$where_final}";

        return $this->Query_SQL($_sql, $_bind, 'UPDATE');

    }

    /**
     * Metodo de inserção de dados
     * @param array $_dados
     * @param string $_table
     * @param bool $_nokey
     * @return mixed
     */
    public function InsertPDO($_dados, $_table, $_nokey = false)
    {
        foreach ($_dados as $key => $value) {
            $set[] = "{$key} = :{$key}";
            $_bind[$key] = $value;
        }
        $set_final = implode(',', $set);

        $_sql = "
            INSERT INTO
                {$_table}
            SET
                {$set_final}";

        return $this->Query_SQL($_sql, $_bind, 'INSERT');
    }

    /**
     * Método para consultar carrinho
     * @param string $_dados
     * @return mixed
     */
    public function ConsultaCarrinho($_dados) {

        //$_dados['id_avulso'] ="158920801650866";

        $this->PDOClear();

        if($_dados['id_user'] <> '') {
            $this->PDOMontaBind($_dados['id_user'], 'b_id_user', 'id_user');
        }
        if($_dados['id_avulso'] <> '') {
            $this->PDOMontaBind($_dados['id_avulso'], 'id_avulso', 'c.id_avulso');
        }
        if($_dados['processado'] <> '') {
            $this->PDOMontaBind($_dados['processado'], 'b_processado', 'processado');
        }
        if($_dados['id_carrinho'] <> '') {
            $in = ' WHERE id in('.$_dados['id_carrinho'].')';
        } else {
            $in = '';
        }

        $this->PDOMontaWhere();

        $_sql = "
                SELECT
                    c.id, c.descricao, c.preco, c.unidades, c.id_avulso, c.processado
                FROM
                    tab_carrinho c
                $this->_where
                $in
         ;";

        $_res = $this->Query_SQL($_sql);

        $a = 0;
        while ($a < $_res['contador']) {

            $_res[$a]['soma'] = $_res[$a]['preco'] * $_res[$a]['unidades'];
            $_res['total'] += $_res[$a]['soma'];

            $a++;
        }

        return $_res;
    }

    public function AdicionaCarrinho($_dados) {

        $this->PDOClear();

        if($_dados['id_avulso'] <> '') {
            if($_SESSION['id_avulso'] <> '') {
                $this->PDOMontaBind($_dados['id_avulso'], 'b_id_avulso', 'id_avulso');
            } else {
                session_start();
                $_SESSION['id_avulso'] = $_dados['id_avulso'];
                $this->PDOMontaBind($_dados['id_avulso'], 'b_id_avulso', 'id_avulso');
            }
        }
        if($_dados['id_user'] <> '') {
            $this->PDOMontaBind($_dados['id_user'], 'b_id_user', 'id_user');
        }
        $this->PDOMontaBind($_dados['preco'], 'b_preco', 'preco');
        $this->PDOMontaBind($_dados['descricao'], 'b_descricao', 'descricao');
        $this->PDOMontaBind($_dados['unidades'], 'b_unidades', 'unidades');
        $this->PDOMontaBind($_dados['processado'], 'b_processado', 'processado');
        $this->PDOMontaBind($_dados['id_produto'], 'b_id_produto', 'id_produto');

        $this->_where = "SET " . implode(' , ', $this->_where);

        $_sql = "
                INSERT INTO tab_carrinho
                $this->_where;
                ";

        $_res = $this->Query_SQL($_sql, '', 'INSERT');

        return $_res;

    }
}


?>
