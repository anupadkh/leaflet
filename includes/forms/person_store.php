<?php  
class person_store{
			protected static $db_fields = array('id', 'person_id', 'belongings', 'detail');
			protected static $table_name = "person_store";
		public $id;
		public $person_id;
		public $belongings;
		public $detail;
			} 
 ?>