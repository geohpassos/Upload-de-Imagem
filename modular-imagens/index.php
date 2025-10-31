<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Imagens</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <section>
        <a href="produtos.php" class = "sombra" >Ver todos os produtos</a>
        <form action="" method = "post" enctype = "multipart/form-data">
            <h1>ENVIO DE IMAGENS</h1>
            <label for="nome">Nome do Produto</label>
            <input type="text" name = "nome" id = "nome" class = "sombra">

            <label for="des">Descrição</label>
            <textarea name="desc" id="desc" class = "sombra"></textarea>

            <input type="file" name="foto[]" multiple id="foto" class ="sombra meuInput">
            <input type="submit" id = "botao">
        </form>
    </section>    
</body>

<?php

//checa se o usuario preencheu ao menos o nome e clicou no botao enviar
if(isset($_POST['nome']) && !empty( $_POST['nome'] ) ){
    $nome = addslashes( $_POST['nome'] );
    $descricao = addslashes( $_POST['desc'] );
    
    //cria um vetor vazio para guardar os nomes das imagens caso tenha escolhido
    $fotos = array();

    //checa se foi enviada uma imagem
    if( isset( $_FILES['foto']) ){
        $tipo = '';
        
        // echo"<pre>";
        // var_dump($_FILES);
        //exit;
        //enquanto houver fotos
        for( $i = 0; $i < count($_FILES['foto']['name']); $i++){
            if($_FILES['foto']['type'][$i] == "image/png"){
                $tipo = ".png";
            }elseif($_FILES['foto']['type'][$i] == "image/jpeg"){
                $tipo = ".jpg";
            }else{
                $tipo = 'outro';
            }

            if( $tipo == "outro"){
                echo "<script>alert('Só é possível enviar arquivos JPG e PNG')</script>";
            }else{
                $nome_arquivo = md5($_FILES['foto']['name'][$i]).rand(1,999).$tipo;

                move_uploaded_file($_FILES['foto']['tmp_name'][$i],'imagens/'.$nome_arquivo);
               
                array_push($fotos, $nome_arquivo);
            }
        }


        if( !empty($nome) && !empty($descricao) ){
            require 'classes/Produto.class.php';
            $p = new Produto();
            $p->enviarProduto($nome, $descricao, $fotos);
        }else{
            echo "<script>alert('Preencha todos os campos obrigatorios!'</script>";
        }

    } 

}else{
    echo "<script> alert('Voce tem que preencher o nome do produto')</script>";
}
?>

</html>