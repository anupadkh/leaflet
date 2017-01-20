<?php  
class employee{
			protected static $db_fields = array('id', 'name', 'parent_id', 'date_create', 'parishad');
			protected static $table_name = "employee";
		public $id;
		public $name;
		public $parent_id;
		public $date_create;
		public $parishad;
			} 
 ?>