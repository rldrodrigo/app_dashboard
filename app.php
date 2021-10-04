<?php

//classe dashboard
class Dashboard
{
    public $data_inicio;
    public $data_fim;
    public $numeroVendas;
    public $totalVendas;

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
        return $this;
    }
}

//Classe de conexão com o bd
class Conexao
{
    private $host = 'localhost';
    private $dbname = 'dashboard';
    private $user = 'root';
    private $pass = '';

    public function conectar()
    {
        try {

            $conexao = new PDO("mysql:host = $this->host;dbname=$this->dbname", "$this->user", "$this->pass");

            //
            $conexao->exec('set charset set utf8');

            return $conexao;
        } catch (PDOException $e) {
            echo '<p>' . $e->getMessage() . '</p>';
        }
    }
}


//Classe (model)  
class Bd
{
    private $conexao;
    private $dashboard;

    public function __construct(Conexao $conexao, Dashboard $dashboard)
    {
        $this->conexao = $conexao->conectar();
        $this->dashboard = $dashboard;
    }

    public function getNumeroVendas()
    {
        $query = "SELECT COUNT(*) AS numero_vendas FROM tb_vendas WHERE data_venda BETWEEN :data_inicio AND :data_fim";

        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':data_inicio', $this->dashboard->__get('data_inicio'));
        $stmt->bindValue(':data_fim', $this->dashboard->__get('data_fim'));
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ)->numero_vendas;
    }

    public function getTotalVendas()
    {
        $query = "SELECT SUM(total) AS total_vendas FROM tb_vendas WHERE data_venda BETWEEN :data_inicio AND :data_fim";

        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':data_inicio', $this->dashboard->__get('data_inicio'));
        $stmt->bindValue(':data_fim', $this->dashboard->__get('data_fim'));
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ)->total_vendas;
    }
}


// Lógica do script
$dashboard = new Dashboard();

$conexao = new Conexao();

$dashboard->__set('data_inicio', '2018-08-01');
$dashboard->__set('data_fim', '2018-08-31');

$bd = new Bd($conexao, $dashboard);
$dashboard->__set('numeroVendas', $bd->getNumeroVendas());
$dashboard->__set('totalVendas', $bd->getTotalVendas());
