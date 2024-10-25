<?php 

class UsuarioDao{

	private $db;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	function alterarSenha(Usuario $usuario){
		$sql = "UPDATE bf2usuarios SET Senha = ? WHERE Usuario = ?";
		
		$query = $this->db->prepare($sql);
		$pSenha =  preg_replace('#[^\pL\pN./\' -]+# ', '', $usuario->Senha);
		$pUsuario =  preg_replace('#[^\pL\pN./\' -]+# ', '', $usuario->Usuario);
		
		return $this->db->execute($query,array($pSenha,$pUsuario));
	}
	
	function criarUsuario(Usuario $usuario){
		
		$sql = "INSERT INTO bf2usuarios (Cpf, Senha, Pessoa) values (?,?,?) ";	

		$query = $this->db->prepare($sql);

		$pCpf = preg_replace('#[^\pL\pN./\' -]+# ', '', $usuario->Cpf);
		$pSenha = preg_replace('#[^\pL\pN./\' -]+# ', '', $usuario->Senha);
		$pPessoa = preg_replace('#[^\pL\pN./\' -]+# ', '', $usuario->Pessoa);
										
		return $this->db->execute($query,array($pCpf,$pSenha,$pPessoa));			
	}
	
	function buscarUsuarioPorCpf($cpf) {
		$sql = " SELECT * FROM bf2usuarios ";
		$sql .= " INNER JOIN rhpessoas ON (rhpessoas.Pessoa = bf2usuarios.Pessoa) ";
		$sql .= " WHERE bf2usuarios.Cpf = ?";
		
        $query = $this->db->prepare($sql);	
		$pCpf = preg_replace('#[^\pL\pN./\' -]+# ', '',$cpf);
		
		return $this->db->execute($query,$pCpf);
	}
	
	function buscarUsuarioPorParametros(Pessoa $pessoa) {        
        $sql = "select * from bf2usuarios ";
		$sql .= " where ";
        $sql .= " bf2usuarios.pessoa = ?";
		
		$query = $this->db->prepare($sql);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa->Pessoa);
		
        return $this->db->Execute($query,$pPessoa);
	}
}
?>