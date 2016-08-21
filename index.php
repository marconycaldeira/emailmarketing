<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Email Marketing - CREA-JR</title>
	<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/js/materialize.min.js"></script>
</head>
<body>
	 <nav>
    <div class="nav-wrapper  blue darken-2">
      <a href="#" class="brand-logo center">ENVIO DE CERTIFICADOS/COMPROVANTE</a>
      
      <ul class="right hide-on-med-and-down">
      <li><a href="http://github.com/marconycaldeira/emailmarketing">v. 1.0</a></li>
    </ul>
    </div>
  </nav>
  <div class="container">
  <?php 	
  	session_start();
  	if(empty($_SESSION['usuario'])){
  		?><br>	

       	   <nav>
		    <div class="nav-wrapper  blue darken-1">
		      <a href="#" class="brand-logo center">Realize seu Login</a>
		      
		    </div>
		  </nav>
		  	<div class="row">	
		  	<form action="?lg=check" method="post" enctype="multipart/form-data">
				<div class="col offset-s1 s10">
					
					 <div class="row">
					    <div class="input-field col s6">
					    Usuário
					      <input  name="usuario" required type="text" class="validate">
					     
					    </div>
					    <div class="input-field col s6">
					   Senha
	  				 <input  name="senha" required type="password" class="validate">
   

					    </div>
					    </div>
				</div>
				
          </div>
        <center>		
        <input type="submit" class="blue  btn-large" value="login">
				</center></div>
				</form>
		  	</div>
  	   </div>
  		
  	<?php }
  	if(!empty($_SESSION['usuario'])){
   ?>
       <br>	
       <div class="col s6 offset-s3  grey lighten-5">
       	   <nav>
		    <div class="nav-wrapper   orange darken-2">
		      <a href="#" class="brand-logo center">ORIENTAÇÕES IMPORTANTES</a>
		      
		    </div>
		  </nav>
		  <div class="row">	
			<div class="col offset-s1 s10  deep-orange-text accent-3-text"><br>
			- Preencha todos os campos;<br>	
			- Certifique que a planilha esteja no seguinte formato: 2 colunas sem cabeçalho sendo a primeira contendo o email do destinatario e na segunda coluna o nome do arquivo que deverá ser anexado. <br>
			- O formato da planilha deverá ser CSV separado por PONTO E VÍRGULA (Caso use o Microsoft Excel utilize a opção de salvar separado por vírgulas); <br>
			- Abra o arquivo no bloco de notas para ter certeza que ele está separado por ponto e vírgula; <br>
			- O arquivo contendo os comprovantes/certificados deverá estar compactado no formato ZIP; <br>
			- Os arquivos PDF deveram estar na raiz do arquivo ZIP. <br>
			- Aguarde até que o procedimento seja concluído;
			</div>
		</div>
       	   <nav>
		    <div class="nav-wrapper  blue darken-1">
		      <a href="#" class="brand-logo center">Preencha os dados do evento</a>
		      
		    </div>
		  </nav>
		  	<div class="row">	
		  	<form action="" method="post" enctype="multipart/form-data">
				<div class="col offset-s1 s10">
					
					 <div class="row">
					    <div class="input-field col s6">
					    Nome do Evento
					      <input  name="nome_evento" required type="text" class="validate">
					     
					    </div>
					    <div class="input-field col s6">
					    O que você deseja enviar?
	     <p>
      <input name="tipo_arquivo" type="radio" id="test1" checked="" value="1"/>
      <label for="test1">Certificado</label>
    
      <input name="tipo_arquivo" type="radio" id="test2" value="2"/>
      <label for="test2">Comprovante</label>
    </p>
   

					    </div>
					  </div>
				</div>
				<div class="col offset-s1 s10">
			  <div class="row">
          <div class="input-field col s12">
           Mensagem
            <textarea id="textarea1" class="materialize-textarea" name="texto" length="120"></textarea>
           
          </div>
        </div>
				</div>
				<div class="col offset-s1 s10">
		<div class="row">
          <div class="input-field col s6">
          Lista CSV
          <div class="file-field input-field">
      <div class="btn">
        <span>Procurar arquivo</span>
        <input type="file" name="lista">
      </div>
      <div class="file-path-wrapper">
        <input class="file-path validate" type="text">
      </div>
    </div>
          </div> <div class="input-field col s6">
         Certificados
          <div class="file-field input-field">
      <div class="btn">
        <span>Procurar arquivo</span>
        <input type="file" name="arquivos">
      </div>
      <div class="file-path-wrapper">
        <input class="file-path validate" type="text">
      </div>
    </div>
           
          </div>
        </div>
        <center>		
        <input type="submit" class="blue  btn-large" value="Enviar email">
				</center></div>
				</form>
		  	</div>
  	   </div>
  	  <?php } ?>
   </div>
</body>
</html>
<?php

if(!empty($_POST['usuario'])){
	if(($_POST['usuario'] == '') && ($_POST['senha'] == '')){

		$_SESSION['usuario']='s';
		
		header('location: index.php');
	}
	
	else{
		echo "<script>alert('Login e/ou senha incorretos');</script>";
	}
}
if(!empty($_POST['nome_evento']) && !empty($_SESSION['usuario'])){
	$arquivos_inexistentes='';
	if((pathinfo($_FILES["lista"]["name"], PATHINFO_EXTENSION)!='csv' || (pathinfo($_FILES["arquivos"]["name"], PATHINFO_EXTENSION)!='zip'))){
		echo "<script>alert('Formato de arquivos não aceito. A lista deverá estar em CSV SEPARADO POR VÍRGULA e OS COMPROVANTES/CERTIFICADOS EM ZIP');</script>";
	}
	else{
	require_once 'phpmailer/PHPMailerAutoload.php';
	$mail          = new PHPMailer(true);
	$mail->CharSet = 'utf-8';
	ini_set('default_charset', 'UTF-8');
	class phpmailerAppException extends phpmailerException {
	}

	if($_POST['tipo_arquivo'] == 1) {
		$diretorio = "certificados/";
	}
	if($_POST['tipo_arquivo'] == 2) {
		$diretorio = "comprovantes/";
	}
	$local_lista    = basename($_FILES["lista"]["name"]);
	$local_arquivos = basename($_FILES["arquivos"]["name"]);
	if(!move_uploaded_file($_FILES['lista']['tmp_name'], $local_lista) || !move_uploaded_file($_FILES['arquivos']['tmp_name'], $local_arquivos)){
		echo "Os arquivos não foram enviados para o servidor"; 
	}
	else{
	
	$lista    = $_FILES['lista']['name'];
	$arquivos = $_FILES['arquivos']['name'];
	$zip      = new ZipArchive;
	if($zip->open($arquivos) === FALSE) {
	echo 'Não foi possível ler o arquivo CSV';
	}
	if($zip->open($arquivos) === TRUE) {
		for($i = 0; $i < $zip->numFiles; $i++) {
			$stat = $zip->statIndex($i);
			$nome = $zip->getNameIndex($i);
			//$stat['name'].PHP_EOL;        // Nome do elemento
			if(substr($nome, -4) != '.pdf') {
				echo "Existe um arquivo que nao é pdf";
			} 
			if(!substr($nome, -4) != '.pdf') {
				$zip->extractTo(getcwd() . "\\" . $diretorio);
			
		}
	$zip->close();
	
$row = 0;

if(($handle = fopen($lista, "r")) !== FALSE) {
	while(($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
		$num = count($data);
		if($num != 2) {
			echo "A tabela esta em um formato indevido";
			break;
		} 
		else {
			$row++;
			$email   = $data[0];
			$arquivo = $diretorio . $data[1];
			if(file_exists($arquivo)) {
				EnviaEmail($email, $arquivo, $mail);
			}
			if(!file_exists($arquivo)) {
			$arquivos_inexistentes =$arquivos_inexistentes.','.$arquivo;
			}
		}
		
	}
fclose($handle);

}}}
}}echo $arquivos_inexistentes;/*unlink($local_lista);unlink($local_arquivos);*/ echo "<script>alert('Emails enviados');</script>";}

function EnviaEmail($email, $arquivo, $mail){
				$mail->ClearAddresses();
	   			$mail->ClearAttachments();
				$results_messages = array();
				
				
				try {
				$to = $email; //DESTINATARIO
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
				$mail->addReplyTo("forum@crea-mgjrmoc.com.br", "Erro ao enviar o certificado - " . $_POST['nome_evento']); //COLOQUE O ENDERECO DE EMAIL DO REMETENTE (ESSA FUNCAO ENVIA MSG DE ERRO QUANDO O DESTINATARIO É INVALIDO)
				$mail->setFrom("forum@crea-mgjrmoc.com.br", "CREA-MG JR NUCLEO MONTES CLAROS"); //COLOQUE O ENDERECO DO REMETENTE
				$mail->addAddress($email, "Inscrito"); //COLOQUE O ENDERECO DE EMAIL DO DESTINATARIO
				$mail->Subject  = "Certificado - " . $_POST['nome_evento']; //COLOQUE O ASSUNTO
				$body           = $_POST['texto'];
				$mail->WordWrap = 120;
				$mail->IsHTML(true);
				$mail->msgHTML($body, dirname(__FILE__), true);
				$mail->AddAttachment($arquivo, 'Comprovante		');
				try {
				$mail->send();
				//$results_messages[] = " A MENSAGEM FOI ENVIADA";
				}
				catch(phpmailerException $e) {
				throw new phpmailerAppException('A MENSAGEM NAO FOI ENVIADA' . $to . ': ' . $e->getMessage());
				}
				}
				catch(phpmailerAppException $e) {
				//  $results_messages[] = $e->errorMessage();
				}
				if(count($results_messages) > 0) {
				//echo "<h2>Run results</h2>\n";
				//echo "<ul>\n";
				foreach($results_messages as $result) {
				//echo "<li>$result</li>\n";
				}
				//echo "</ul>\n";
				}
}

?>