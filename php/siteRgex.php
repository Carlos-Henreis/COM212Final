<?php
//Supondo que o portal de noticias seja http://localhost/gif/html/
$url = "http://localhost/gif/html/";

//Supondo que todas as noticas tem aquele padrao então
//Pegamos o codigo fonte e tratamos ele com expressões regulares
//Veja que Massa!

$fonte = utf8_encode(file_get_contents($url));

//Expressão título da noticia
$exrgt = "/<h1>(.+?)</";
//Expressão da noticia
$exrgn = "/<h2>(.+?)</";

//Expressão imagem
$exrgi = "/<img src=\"(.+?)\">/";

//Pesquisa no código-fonte todas as substrings reconhecidas pela expressão regular .
preg_match_all($exrgt, $fonte, $matches1);//Titulo
preg_match_all($exrgn, $fonte, $matches2);//Noticia em si
preg_match_all($exrgi, $fonte, $matches3);//Quantidade de imagens