<?php

class Produto{

    private $pdo;
    
    function __construct(){
        $dns = "mysql:dbname=modularProduto;host = localhost";
        $user = "root";
        $pass = "";

        try{
           $this->pdo = new PDO($dns,$user,$pass);
            return true;
        }catch(\Throwable $th){
            return false;
        }
    }

    public function enviarProduto( $nome, $descricao, $fotos=array()){
        //inserir produto na tabela produto
        $sql = "INSERT INTO produtos SET descricao = :d, nome_produto = :n";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":d", $descricao);
        $sql->bindValue(":n", $nome);

        $sql->execute();
        $id_produto = $this->pdo -> LastInsertId();
        //inserir imagem na tabela imagens

        if(count($fotos) > 0){
            for($i =0; $i<count($fotos); $i++){
                $nome_foto = $fotos[$i];

                $sql = "INSERT INTO imagens (nome_imagem, fk_id_produto) values (:n, :fk)";
                $sql = $this->pdo->prepare($sql);
                $sql->bindValue(":n", $nome_foto);
                $sql->bindValue(":fk", $id_produto);

                $sql->execute();
            } 
        }
    }

    public function buscarProduto($id){
        $sql = "SELECT * FROM produtos WHERE id_produto = :i";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":i",$id);
        $sql->execute();
        if($sql->rowCount()>0){
            $dados = $sql->fetch();
        }else{
            $dados = array();
        }
        return $dados;
    }

     public function buscarProdutos(){
        $sql = "SELECT *, (SELECT nome_imagem FROM imagens WHERE fk_id_produto = produtos.id_produto LIMIT 1) as foto_capa FROM produtos";
        $sql = $this->pdo->prepare($sql);
        $sql->execute();
        if($sql->rowCount()>0){
            $dados = $sql->fetchAll();
        }else{
            $dados = array();
        }
        return $dados;
    }
}


?>