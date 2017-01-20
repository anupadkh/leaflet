<?php 
require_once 'includes/initialize.php';
// echo json_encode( fields::find_all());
/**
* To retrieve values from fields and provide the necessary description
*/
class androidForms
{
	public $name;
	public $description;
	public $fields=array();
	

}
/**
* 
*/
class fieldNames
{
	public $label;
	public $type;
	// public $values=array();
	// public $keys=array();
	public $key_value ;
}
$all =fields::find_by_sql('SELECT DISTINCT tablename from fields WHERE 1');
$output_objects_array = array( );

foreach ($all as $one) {
	$formSaved = new androidForms();
	$formSaved->name = $one->tablename;
	$descrip = (mytables::find_table($one->tablename))->header;
	if ($descrip!="") {
		$formSaved->description = strtoupper($descrip);
	}else{
		$formSaved->description = strtoupper($one->tablename);
	}

	$form_fields = fields::find_by_sql("SELECT * FROM fields WHERE tablename='{$one->tablename}'");
	for ($i=0; $i < count($form_fields); $i++) { 
		$one_field = new fieldNames();
		if ($form_fields[$i]->type == 'radio') {
			$one_field->type = 'spinner';
		} else{
			$one_field->type = 'edittext';
		}
		/*  */
			$one_field->label = $form_fields[$i]->field;
		// }
		$result = load_arrays($form_fields[$i]);
		
		// $one_field->keys = $result[1];
		// $one_field->values = $result[0];
		// keys and values separated by tab stops
		$one_field->key_value = implode(";;", $result[2]);
		// print_r($result);
		$formSaved->fields[$i]=$one_field;
		unset($one_field);

	}
	echo json_encode($formSaved);
	echo "\n";
	array_push($output_objects_array, $formSaved);

}
// print_r(json_decode(json_encode($output_objects_array)));
function load_arrays($col1)
{
	// print_r($col1);
	$to_throw = array();
	$to_throw_key_values = array();
	if ($col1->type=='radio') {
	    
	    if (!is_null($col1->descrip)){
	        $field_array =  array();
	        $field_values =  array();
	        $constraints = explode(",",$col1->descrip);
	        $conditions = array();
	        foreach ($constraints as $const1){
	            $m1 = explode("=",$const1);
	            $conditions[($m1[0])] = $m1[1];
	        }
	        $table = $conditions['table'];
	        $nepl = $conditions['nepl'];
	        $eng = $conditions['eng'];
	        
	        $table_fields = $table::find_all();
	        foreach ($table_fields as $newoption){
	            array_push($field_array,$newoption->id);
	            array_push($field_values,$newoption->$eng,$newoption->$nepl);
	        }
	    }else{
	        $field_array = explode(",", $col1->mykeys);
	        $field_values = explode(",", $col1->myvalues);
	    }
	        $i = 0;
	        foreach ($field_array as $myoption) {
	        	array_push($to_throw, $field_values[$i*2]."(".$field_values[$i*2+1] . ")");
	        	array_push($to_throw_key_values, $field_values[$i*2]."(".$field_values[$i*2+1] . ")"."\t".$myoption);
	            $i++;
	        }
	}
	// if (count($to_throw) != 0) {
	// 	print_r($to_throw);
	// }
	return array($to_throw,$field_array, $to_throw_key_values);
}
 ?>
