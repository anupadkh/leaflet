<?php  
class person_exp{
			protected static $db_fields = array('id', 'person_id', 'org', 'address', 'phone', 'email', 'website', 'position', 'from_date', 'to_date', 'duty');
			protected static $table_name = "person_exp";
		public $id;
		public $person_id;
		public $org;
		public $address;
		public $phone;
		public $email;
		public $website;
		public $position;
		public $from_date;
		public $to_date;
		public $duty;
			} 
 ?>