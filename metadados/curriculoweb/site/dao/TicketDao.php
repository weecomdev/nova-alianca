<?php
class TicketDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	function buscarTicketPorParametros($ticket) {
		$sql = "select * from bf2ticket ";
		
		if (!is_null($ticket)){
			$sql .= " WHERE Ticket = ".$this->db->qstr($ticket)."";
		}
		
		$query = $this->db->prepare($sql);
		
		return $this->db->Execute($sql);
	}

	function criarTicket($ticket) {
		$sql = "INSERT IGNORE INTO bf2ticket (";
		$sql .= "Ticket,DataCadastro) VALUES (";
		$sql .= "?,now())";
		
		$query = $this->db->prepare($sql);
		$pTicket =  $ticket;
		
		return $this->db->Execute($query,$pTicket);
	}

	function excluirTicket($ticket = null) {
		$sql = "delete from bf2ticket ";
		if (!is_null($ticket)){
			$sql .= " WHERE Ticket = ".$this->db->qstr($ticket)."";
		}
		
		$query = $this->db->prepare($sql);
		
		return $this->db->Execute($sql);
	}
}
?>