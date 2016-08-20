<?php 	
require_once 'PHPMailerAutoload.php';
 
$results_messages = array();
 
$mail = new PHPMailer(true);
$mail->CharSet = 'utf-8';
ini_set('default_charset', 'UTF-8');
 
class phpmailerAppException extends phpmailerException {}
 
try {
$to = 'marconycaldeira@gmail.com';//DESTINATARIO
if(!PHPMailer::validateAddress($to)) {
  throw new phpmailerAppException("Email address " . $to . " is invalid -- aborting!");
}
$mail->isSMTP();
$mail->SMTPDebug  = 2;
$mail->Host       = "mx1.hostinger.com.br";
$mail->Port       = "587";
$mail->SMTPSecure = "tls";
$mail->SMTPAuth   = true;
$mail->Username   = "forum@crea-mgjrmoc.com.br"; //COLOQUE AQUI O ENDERECO DE EMAIL DO REMETENTE
$mail->Password   = "inline"; //COLOQUE A SENHA DO EMAIL DO REMETENTE
$mail->addReplyTo("forum@crea-mgjrmoc.com.br", "Fórum das Engenharias"); //COLOQUE O ENDERECO DE EMAIL DO REMETENTE (ESSA FUNCAO ENVIA MSG DE ERRO QUANDO O DESTINATARIO É INVALIDO)
$mail->setFrom("forum@crea-mgjrmoc.com.br", "Fórum das Engenharias"); //COLOQUE O ENDERECO DO REMETENTE
$mail->addAddress("marconycaldeira@gmail.com", "Marcony"); //COLOQUE O ENDERECO DE EMAIL DO DESTINATARIO
$mail->Subject  = "Fórum das Engenharias"; //COLOQUE O ASSUNTO
$body = "AQUI FICARA O CONTEUDO DA MENSAGEM";
$mail->WordWrap = 78;
$mail->msgHTML($body, dirname(__FILE__), true); 
try {
  $mail->send();
  //$results_messages[] = " A MENSAGEM FOI ENVIADA";
}
catch (phpmailerException $e) {
  throw new phpmailerAppException('A MENSAGEM NAO FOI ENVIADA' . $to. ': '.$e->getMessage());
}
}
catch (phpmailerAppException $e) {
//  $results_messages[] = $e->errorMessage();
}
 
if (count($results_messages) > 0) {
  //echo "<h2>Run results</h2>\n";
  //echo "<ul>\n";
foreach ($results_messages as $result) {
  //echo "<li>$result</li>\n";
}
//echo "</ul>\n";
}
 ?>