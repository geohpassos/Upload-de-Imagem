<?php
require 'Produto.class.php';

$p = new Produto();

$con = $p-> conecta();
if($con){
    echo "<h1>Conectado</h1>";
}else{
    echo "<h1>Erro ao conectar</h1>";
}
?>