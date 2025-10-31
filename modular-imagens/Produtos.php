<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/produtos.css">
    <title>Produtos</title>
</head>
<body>
    <section>
       <?php
        require 'classes/Produto.class.php';
        $p = new Produto();
        $dadosProduto = $p->buscarProdutos();
        if(empty($dadosProduto)){
            echo "<script>alert('Ainda não há produtos cadastrados!!!')</script>";
        }else{
            foreach($dadosProduto as $value){
               ?> <a href="exibir_produtos.php?id=<?php echo $value['id_produto'];?>">
                    <div>
                        <img src="imagens/<?php echo $value['foto_capa'];?>" alt="teste">
                        <h2><?php echo $value['nome_produto'];?></h2>
                    </div>

                </a>
                <?php
            }
        }
        ?>

        
    </section>

</body>
</html>

