<?php
	function getBD(){
		$bdd = new PDO('mysql:host=localhost;dbname=Orga;charset=utf8','root','root');
		return $bdd;
	}
?>