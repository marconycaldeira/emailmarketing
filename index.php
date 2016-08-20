<?php 	
$zip = new ZipArchive;
if ($zip->open('teste.zip') === TRUE) {
    for ($i = 0; $i < $zip->numFiles; $i++) {
		
		$stat = $zip->statIndex($i);
		$nome = $zip->getNameIndex($i);
		//$stat['name'].PHP_EOL;        // Nome do elemento
        if(substr($nome, -4) != '.ico'){
        	echo "Existe um arquivo que nao e pdf";
        }
        else{

    		
    		 $zip->extractTo(getcwd()."\certificados\\");
    		 $row=0;
    		 if (($handle = fopen("teste.csv", "r")) !== FALSE) {
			     while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			     	
			         $num = count($data); 
			         if($num != 2){
			         	echo "A tabela esta em um formato indevido";
			         }
			         else{
				         $row++;
				         $email = $data[0];
				         $arquivo = "certificados\\".$data[1];


				         if(file_exists($arquivo)){
				         	//envia email
				         }
				         if(!file_exists($arquivo)){
				         	//mensagem de erro
				         }
			     	}
			     }
			    fclose ($handle);
			 }
        }
    }
    $zip->close();
} 
else {
    echo 'failed';
} 

function EnviarEmail($destino, $arquivo){
 	
require_once 'phpmailer/PHPMailerAutoload.php';
 
$results_messages = array();
 
$mail = new PHPMailer(true);
$mail->CharSet = 'utf-8';
ini_set('default_charset', 'UTF-8');
 
class phpmailerAppException extends phpmailerException {}
 
try {
$to = $destino;//DESTINATARIO
if(!PHPMailer::validateAddress($to)) {
  throw new phpmailerAppException("Email address " . $to . " is invalid -- aborting!");
}
$mail->isSMTP();
$mail->SMTPDebug  = 0;
$mail->Host       = "mx1.hostinger.com.br";
$mail->Port       = "587";
$mail->SMTPSecure = "tls";
$mail->SMTPAuth   = true;
$mail->Username   = "forum@crea-mgjrmoc.com.br"; //COLOQUE AQUI O ENDERECO DE EMAIL DO REMETENTE
$mail->Password   = "inline"; //COLOQUE A SENHA DO EMAIL DO REMETENTE
$mail->addReplyTo("forum@crea-mgjrmoc.com.br", "Erro ao enviar o certificado - ".$_POST['nome_evento']); //COLOQUE O ENDERECO DE EMAIL DO REMETENTE (ESSA FUNCAO ENVIA MSG DE ERRO QUANDO O DESTINATARIO É INVALIDO)
$mail->setFrom("forum@crea-mgjrmoc.com.br", "CREA-MG JR NUCLEO MONTES CLAROS"); //COLOQUE O ENDERECO DO REMETENTE
$mail->addAddress($destino, "Inscrito"); //COLOQUE O ENDERECO DE EMAIL DO DESTINATARIO
$mail->Subject  = "Certificado - ".$_POST['nome_evento']; //COLOQUE O ASSUNTO
$body = $_POST['texto'];
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

}

