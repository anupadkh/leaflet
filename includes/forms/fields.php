<?php  
class fields{
			protected static $db_fields = array('id', 'tablename', 'field', 'type', 'eng_name', 'descrip', 'priority');
			protected static $table_name = "fields";
		public $id;
		public $tablename;
		public $field;
		public $type;
		public $eng_name;
		public $descrip;
		public $priority;
			} 
 ?>