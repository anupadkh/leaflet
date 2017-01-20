<?php  
class training{
			protected static $db_fields = array('id', 'person_id', 'title', 'institute', 'train_type', 'course_type', 'from_date', 'to_date', 'score', 'org_belong');
			protected static $table_name = "training";
		public $id;
		public $person_id;
		public $title;
		public $institute;
		public $train_type;
		public $course_type;
		public $from_date;
		public $to_date;
		public $score;
		public $org_belong;
			} 
 ?>