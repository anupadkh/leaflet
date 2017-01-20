<?php  
class person_contact{
			protected static $db_fields = array('id', 'person_id', 'contact', 'contact_type');
			protected static $table_name = "person_contact";
		public $id;
		public $person_id;
		public $contact;
		public $contact_type;
			} 
 ?>