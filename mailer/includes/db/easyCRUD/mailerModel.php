<?php 
	require_once("easyCRUD.class.php");

	class Mailer  Extends Crud {
		
			# Your Table name 
			protected $table = 'subscriptions';
			
			# Primary Key of the Table
			protected $pk	 = 'id';
	}

?>