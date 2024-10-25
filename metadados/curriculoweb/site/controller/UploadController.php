<?php
class ErrosUpload{
	var $erros=array();
	public function adicionaErro($cod, $desc){
		$this->erros[$cod] = $desc;
	}
	public function getNroErros(){
		if(is_array($this->erros)){
			return count($this->erros);
		}
		else{
			return 0;
		}
	}
	public function getErrosHTML(){
		$ret="";
		if($this->getNroErros() > 0){
			$ret .= "Erros:<br/>";
			foreach($this->erros as $cod=>$val){
				$ret .= $cod." - ".$val."<br/>";
			}
		}
		return "<Font color= red>".$ret."</font>";
	}
	static function getMensagemErroUploadPHP($error_code) {
		switch ($error_code) {
			case UPLOAD_ERR_INI_SIZE:
				return 'O tamanho do arquivo é maior que a diretiva upload_max_filesize do arquivo php.ini.';
			case UPLOAD_ERR_FORM_SIZE:
				return 'O tamanho do arquivo é maior que a diretiva MAX_FILE_SIZE do formulário.';
			case UPLOAD_ERR_PARTIAL:
				return 'O arquivo foi enviado parcialmente.';
			case UPLOAD_ERR_NO_FILE:
				return 'Nenhum arquivo foi enviado.';
			case UPLOAD_ERR_NO_TMP_DIR:
				return 'Não foi encontrado o diretório temporário.';
			case UPLOAD_ERR_CANT_WRITE:
				return 'Não foi possível escrever o arquivo no disco.';
			case UPLOAD_ERR_EXTENSION:
				return 'O arquivo enviado foi bloqueado por uma extensão.';
			default:
				return 'Erro não conhecido.';
		}
	}
}

class UploadController{
	var $db;
	var $acao;
	public function __construct($db, $acao) {
		$this->db = $db;
		$this->acao = $acao;
		$this->webpage();
	}
	private function webpage(){
		switch ($this->acao) {
			case "formFoto":
				$this->formUploadFoto(new ErrosUpload());
				break;
			case "uploadFoto":
				$this->salvaUploadFoto();
				break;
			case "formAnexo":
				$this->formUploadAnexo(new ErrosUpload());
				break;                
			case "uploadAnexo":
				$this->salvaUploadAnexo();
				break;   
			case "removerAnexo":
				$this->removerAnexo();
				break;  
            case "baixarAnexo":
				$this->baixarAnexo();
				break;                                  
            case "nomeAnexo":
				$this->nomeAnexo();
				break;
            case "ValidaFezUploadFoto":
				$this->ValidaFezUploadFoto();
				break;                                    
			default:
				$this->formUploadFoto(new ErrosUpload());
			break;
		}
	}
    
	private function formUploadFoto(ErrosUpload $erros){
		include_once 'uploadFoto.php';
	}   

    private function ValidaFezUploadFoto()
    {

    $pessoaFotoDao = new PessoaFotoDao($this->db);
	$pessoaFoto = new PessoaFoto();
	$pessoaFoto->Empresa = LoginModel::getEmpresaLogada();
	$pessoaFoto->Pessoa = LoginModel::getPessoaLogada();

	if ($pessoaFotoDao->existePessoaFoto($pessoaFoto->Empresa, $pessoaFoto->Pessoa))
        echo json_encode(true);
    else
        echo json_encode(false); 
    
    }
    
    private function salvaUploadFoto(){
		$erros = new ErrosUpload();
		global $configObj;
		$valorDiretrizFoto = $configObj->getValorDiretriz('localPessoaFoto');
		$tmpName  = $_FILES['arquivo']['tmp_name'];
		$fileSize = $_FILES['arquivo']['size'];
		$fileType = $_FILES['arquivo']['type'];
		if(!LoginController::isUsuarioLogado()){
			$erros->adicionaErro(9, "O usuário não está logado.");
		}
		if(!isset($_POST['fezUpload'])){
			$erros->adicionaErro(10, "O arquivo não foi enviado.");
		}
		if($fileSize > 409600){
			$erros->adicionaErro(11, 'Tamanho do tamanho do arquivo inválido, máximo de 4MB.');
		}
		if($_FILES['arquivo']['error'] !== UPLOAD_ERR_OK){
			$erros->adicionaErro($_FILES['arquivo']['error'], ErrosUpload::getMensagemErroUploadPHP($_FILES['arquivo']['error']));
		}
		$tipo = ".jpg";
		if($fileType != 'image/jpeg' && $fileType != 'image/pjpeg' ){
            $erros->adicionaErro(12, 'Tipo de arquivo inválido, somente .jpg é suportado.');
		}
		if($erros->getNroErros() == 0){
			if($valorDiretrizFoto == 1){ 
				//Carrega do Banco
				$content = file_get_contents($tmpName, FILE_BINARY);
				
				$pessoaFotoDao = new PessoaFotoDao($this->db);
				$pessoaFoto = new PessoaFoto();
				$pessoaFoto->Empresa = LoginModel::getEmpresaLogada();
				$pessoaFoto->Pessoa = LoginModel::getPessoaLogada();
				$pessoaFoto->Foto = $content;
				if($pessoaFotoDao->existePessoaFoto($pessoaFoto->Empresa, $pessoaFoto->Pessoa)){
					$pessoaFotoDao->alterarPessoaFoto($pessoaFoto);
				}else{
					$pessoaFotoDao->criarPessoaFoto($pessoaFoto);
				}
				
				$pessoaDao = new PessoaDao($this->db);
				$pessoa = new Pessoa();
				$pessoa->Empresa = LoginModel::getEmpresaLogada();
				$pessoa->Pessoa = LoginModel::getPessoaLogada();
				$pessoa->UltAlteracao = date("Y-m-d H:i:s");
				$pessoaDao->salvar($pessoa);
			}
			else{	
				//Carrega do Arquivo
				move_uploaded_file($tmpName, MostraImagem::getNomeArquivoFotoUsuarioLogado($tipo));
				
                $pessoaFotoDao = new PessoaFotoDao($this->db);
				$pessoaFoto = new PessoaFoto();
				$pessoaFoto->Empresa = LoginModel::getEmpresaLogada();
				$pessoaFoto->Pessoa = LoginModel::getPessoaLogada();
				if($pessoaFotoDao->existePessoaFoto($pessoaFoto->Empresa, $pessoaFoto->Pessoa)){
					$pessoaFotoDao->alterarPessoaFoto($pessoaFoto);
				}else{
					$pessoaFotoDao->criarPessoaFoto($pessoaFoto);
				}				
				
				$pessoaDao = new PessoaDao($this->db);
				$pessoa = new Pessoa();
				$pessoa->Empresa = LoginModel::getEmpresaLogada();
				$pessoa->Pessoa = LoginModel::getPessoaLogada();
				$pessoa->UltAlteracao = date("Y-m-d H:i:s");
				$pessoaDao->salvar($pessoa);
			}	
		}        
		$this->formUploadFoto($erros);
	}
    
    private function formUploadAnexo(ErrosUpload $erros){
		include_once 'uploadAnexo.php';
	}    
    
    private function removerAnexo(){
		$pessoaAnexoDao = new PessoaAnexoDao($this->db);
        $pessoaAnexo = new PessoaAnexo();
        $pessoaAnexo->Empresa = LoginModel::getEmpresaLogada();
        $pessoaAnexo->Pessoa = LoginModel::getPessoaLogada();        
        $pessoaAnexoDao->excluirPessoaAnexo($pessoaAnexo);                      
        
        $pessoaDao = new PessoaDao($this->db);
        $pessoa = new Pessoa();
        $pessoa->Empresa = LoginModel::getEmpresaLogada();
        $pessoa->Pessoa = LoginModel::getPessoaLogada();
        $pessoa->UltAlteracao = date("Y-m-d H:i:s");
        $pessoaDao->salvar($pessoa);
	}    
    
	private function salvaUploadAnexo(){
		$erros = new ErrosUpload();
		global $configObj;	
		$tmpName  = $_FILES['arquivoAnexo']['tmp_name'];
		$fileSize = $_FILES['arquivoAnexo']['size'];
		$fileType = $_FILES['arquivoAnexo']['type'];
        $name = $_FILES['arquivoAnexo']['name'];
		if(!LoginController::isUsuarioLogado()){
			$erros->adicionaErro(9, "O usuário não está logado.");
		}
		if(!isset($_POST['fezUploadAnexo'])){
			$erros->adicionaErro(10, "O arquivo não foi enviado.");
		}        
		if($fileSize > 409600){
			$erros->adicionaErro(11, 'Tamanho do tamanho do arquivo inválido, máximo de 4MB.');
		}
		if($_FILES['arquivoAnexo']['error'] !== UPLOAD_ERR_OK){
			$erros->adicionaErro($_FILES['arquivoAnexo']['error'], ErrosUpload::getMensagemErroUploadPHP($_FILES['arquivoAnexo']['error']));
		}
		if($erros->getNroErros() == 0){
			//Carrega do Banco
			$content = file_get_contents($tmpName, FILE_BINARY);				
            //lemos o  conteudo do arquivo usando afunção do PHP  file_get_contents
            //$binario = file_get_contents($file_tmp);
            // evitamos erro de sintaxe do MySQL			
            //$binario = mysql_real_escape_string($binario);
            
            	            
            $pessoaAnexoDao = new PessoaAnexoDao($this->db);
            $pessoaAnexo = new PessoaAnexo();
            $pessoaAnexo->Empresa = LoginModel::getEmpresaLogada();
            $pessoaAnexo->Pessoa = LoginModel::getPessoaLogada();
            $pessoaAnexo->ArquivoBlob = $content;
            $pessoaAnexo->NomeArquivo = $name;
            $pessoaAnexo->TipoArquivo = $fileType;
            $pessoaAnexo->Tamanho = $fileSize;
            if($pessoaAnexoDao->existePessoaAnexo($pessoaAnexo->Empresa, $pessoaAnexo->Pessoa)){
                $pessoaAnexoDao->excluirPessoaAnexo($pessoaAnexo);
            }
                
            $pessoaAnexoDao->criarPessoaAnexo($pessoaAnexo);    
                
            $pessoaDao = new PessoaDao($this->db);
            $pessoa = new Pessoa();
            $pessoa->Empresa = LoginModel::getEmpresaLogada();
            $pessoa->Pessoa = LoginModel::getPessoaLogada();
            $pessoa->UltAlteracao = date("Y-m-d H:i:s");
            $pessoaDao->salvar($pessoa);	                		
		}                  
        $this->formUploadAnexo($erros);
	}
    
    private function baixarAnexo(){
        $pessoaAnexoDao = new PessoaAnexoDao($this->db); 
        $pessoaAnexo = new PessoaAnexo();
        $pessoaAnexo->Empresa = LoginModel::getEmpresaLogada();
        $pessoaAnexo->Pessoa = LoginModel::getPessoaLogada();
        if($pessoaAnexoDao->existePessoaAnexo($pessoaAnexo->Empresa, $pessoaAnexo->Pessoa)){
            $arquivo = $pessoaAnexoDao->buscarAnexoDaPessoa($pessoaAnexo->Empresa, $pessoaAnexo->Pessoa);
            $conteudo = $arquivo->fields['ArquivoBlob'];
            $tipo = $arquivo->fields['TipoArquivo'];
            $nome = $arquivo->fields['NomeArquivo'];           
            
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename=".$nome."');
            echo $conteudo;
        }              
    }
    
    private function nomeAnexo(){
        $pessoaAnexoDao = new PessoaAnexoDao($this->db);         
        $arquivo = $pessoaAnexoDao->buscarAnexoDaPessoa(LoginModel::getEmpresaLogada(), LoginModel::getPessoaLogada());
        $teste = $arquivo->fields['NomeArquivo'];
        echo $teste;
    }    
}
?>