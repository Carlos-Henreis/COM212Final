<?php
// Carregar imagem já existente no servidor

$imagem = imagecreatefromjpeg($matches3[1][0]);//Pega a primeira imagem para colocar  notica e o titulo
/* @Parametros
 * "foto.jpg" - Caminho relativo ou absoluto da imagem a ser carregada.
 */
 
// Cor de saída
$cor = imagecolorallocate( $imagem, 255, 255, 255 );
/* @Parametros
 * $imagem - Imagem previamente criada Usei imagecreatefromjpeg
 * 255 - Cor vermelha ( RGB )
 * 255 - Cor verde ( RGB )
 * 255 - Cor azul ( RGB )
 * -- No caso acima é branco
 */
 
// Texto que será escrito na imagem
$nome = $matches1[1][0]." ".$matches2[1][0];

 
// Escrever nome
imagestring( $imagem, 5, 133, 12, $nome, $cor );
/* @Parametros
 * $imagem - Imagem previamente criada Usei imagecreatefromjpeg
 * 5 - tamanho da fonte. Valores de 1 a 5
 * 15 - Posição X do texto na imagem
 * 515 - Posição Y do texto na imagem
 * $nome - Texto que será escrito
 * $cor - Cor criada pelo imagecolorallocate
 */
