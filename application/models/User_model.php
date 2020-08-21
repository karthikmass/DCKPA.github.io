<?php


class User_model extends CI_Model
{
		public $title;
        public $content;
        public $date;   
		
    public function select_data($sql)
	{
		$this->load->database();
		$query_s = $this->db->query($sql);//die;
		return $query_s->result_array();
	}
    public function delete_data($tbl,$id)
	{
		$this->load->database();
		$query_s = $this->db->query("delete from ".$tbl." where id = ".$id );//die;
		return "deleted";
	}
    public function insert_data($postdata,$tb_name){
		$this->load->database();
		$fields = array_keys($postdata);
		$fields_tr = implode(',',$fields);
		
		$values = array_values($postdata);
		foreach($values as $k=>$v)
		{
			$values_fr[] = "'".str_replace("'",'',str_replace('\n',' ',str_replace('-','/',$v)))."'";
		}
		$values_tr =  implode(',',$values_fr);//echo 'insert into '.$tb_name.' ('.$fields_tr.') values ('.$values_tr.')'; die;
		if ($this->db->query('insert into '.$tb_name.' ('.$fields_tr.') values ('.$values_tr.')'))
		{
				return "Success!";
		}
		else
		{
				return "Query failed!";
		}
   }
    public function update_data($postdata,$tb_name,$id)
	{
		$this->load->database();
		foreach($postdata as $k=>$v)
		{
			$values_fr[]=$k."="."'".$v."'";
		}
		$values_tr = implode(',',$values_fr);//echo 'UPDATE '.$tb_name.' SET '.$values_tr.' WHERE id = "'.$id.'"'; die;
		if ($this->db->query('UPDATE '.$tb_name.' SET '.$values_tr.' WHERE id = "'.$id.'"'))
		{
				return "Success!";
		}
		else
		{
				return "Query failed!";
		}
   }
   
}