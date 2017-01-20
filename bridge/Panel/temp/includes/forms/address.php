<?php  
class address{
			protected static $db_fields = array('id', 'off_person', 'perm_temp', 'type_id', 'country', 'zone_state', 'dist', 'mun_vdc', 'ward', 'tole', 'street', 'houseNo');
			protected static $table_name = "address";
		public $id;
		public $off_person;
		public $perm_temp;
		public $type_id;
		public $country;
		public $zone_state;
		public $dist;
		public $mun_vdc;
		public $ward;
		public $tole;
		public $street;
		public $houseNo;
			} 
 ?>