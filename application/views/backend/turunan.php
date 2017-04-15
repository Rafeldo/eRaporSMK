<?php
$nama_table = str_replace('_id','s',$query);
foreach($tables as $table){
	$fields = $this->db->list_fields($table);
	foreach ($fields as $field){
		if($query == $field){// && $table == $nama_table){
	   		echo $field.'=>'.$table;
			test($fields);
		}
	} 
}
?>