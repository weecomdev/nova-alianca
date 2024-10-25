<?php
class VersaoCVWebDao{
	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	function buscarUltimoScript() {	
		$sql = "SELECT Date_Format( ultimoscript, '%Y-%m-%d %H:%i:%s' ) Data FROM rhversaocvweb ";
	 	return $this->db->Execute($sql)->fields['Data'];
	}
	function atualizaUltimoScript($data) {
		$sql = "UPDATE rhversaocvweb set ultimoscript = '$data' ";
		return $this->db->Execute($sql);
	}
	function buscaRegistroVersaoCVWeb(){
		$sql = "SELECT VersaoSistema, DataVersao, UltimoScript FROM rhversaocvweb ";
		return $this->db->Execute($sql);
	}
}
?>