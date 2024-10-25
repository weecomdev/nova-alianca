<?php
class MostraImagem{
	private $db;
	private $acao;
	function __construct($db, $acao){
		$this->db = $db;
		$this->acao = $acao;
		$this->getImagem();
	}
	private function getImagem(){
		switch ($this->acao) {
			case "pessoa":
				$this->getImagemPessoa();
				break;
			default:
				$this->getImagemPessoa();
			break;
		}
	}
	private function getImagemPessoa(){
		global $configObj;
		$ValorDiretrizFoto = $configObj->getValorDiretriz("localPessoaFoto");
		header("Content-type: image/jpeg");
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		if(LoginController::isUsuarioLogado()){
			if ($ValorDiretrizFoto == 2){
				$conteudo = $this->getConteudoImagemArquivo();
			}
			else{	
				$conteudo = $this->getConteudoImagemBanco();
			}	
			if($conteudo != ""){
				echo $conteudo;
			}
			else{
				header("location: http://$host$uri/images/user.png");
			}
		}else{
			header("location: http://$host$uri/images/user.png");
		}
	}
	private function getConteudoImagemBanco(){
		$pessoaFotoDao = new PessoaFotoDao($this->db);
		return $pessoaFotoDao->buscarFotoDaPessoa(LoginModel::getEmpresaLogada(), LoginModel::getPessoaLogada());
	}
	private function getConteudoImagemArquivo(){
		$tipo='.jpg';
		$tmpName = MostraImagem::getNomeArquivoFotoUsuarioLogado($tipo);
		if(file_exists($tmpName)){
			$fp      = fopen($tmpName, 'rb');
			$content = fread($fp, filesize($tmpName));
			fclose($fp);
			return $content;
		}
		return "";
	}
	public static function getNomeArquivoFotoUsuarioLogado($tipo){
		if(LoginController::isUsuarioLogado()){
			return MostraImagem::getNomeArquivoFotoPessoa(LoginModel::getEmpresaLogada(), LoginModel::getPessoaLogada(), $tipo);
		}
		return "";
	}
	public static function getDiretorioFotoPessoa(){
		return 'Upload/Fotos/';
	}
	public static function getNomeArquivoFotoPessoa($empresa, $pessoa, $tipo){
		return  MostraImagem::getDiretorioFotoPessoa().$empresa.$pessoa.$tipo;
	}
}
?>