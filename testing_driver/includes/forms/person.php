<?php  
class person{
			protected static $db_fields = array('id', 'fname', 'mname', 'lname', 'sex', 'dob', 'maritalStatus', 'nationality', 'religion_id', 'caste_id', 'recruitment_date', 'darbandi_id', 'retire_date');
			protected static $table_name = "person";
		public $id;
		public $fname;
		public $mname;
		public $lname;
		public $sex;
		public $dob;
		public $maritalStatus;
		public $nationality;
		public $religion_id;
		public $caste_id;
		public $recruitment_date;
		public $darbandi_id;
		public $retire_date;
			} 
 ?>