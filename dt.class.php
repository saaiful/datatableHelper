<?php

/**
* 
*/

namespace saiful\datatable;
class DThelper
{
	public $sql;
	public $param;
	public $order = array(0,'asc');
	public $limit = array(0,10);
	public $db;
	public $columns;
	public $search;
	public $where;
	public $table;


	public function show()
	{
		$orderBy = "ORDER BY ". $this->columns[$this->order[0]]." ".$this->order[1]; 
		$limitBy = 'LIMIT '. implode(',',$this->limit);
		$w = ' WHERE ';
		if(!empty($this->where))
		{
			$where_q = ' WHERE '. implode(' AND ',$this->where);
			$this->sql = $this->sql. $where_q;
			$w = ' AND ';
		}
		// implementing search
		if($this->search=='')
		{
			$sql_query = $this->sql." ".$orderBy." ".$limitBy;
			$query = $this->db -> prepare("SELECT COUNT(id) FROM ".$this->table);
			$query -> execute();
			$total = $query -> fetchColumn();
		}
		else
		{
			foreach ($this->columns as $key => $wh) 
			{
				$this->where_col[] = "$wh LIKE '%".$this->search."%'";
			}
			$sql_query1 = "SELECT COUNT(id) FROM ".$this->table."$w".implode(' OR ',$this->where_col)." ".$orderBy;
			$sql_query = $this->sql."$w".implode(' OR ',$this->where_col)." ".$orderBy." ".$limitBy;
			$query = $this->db -> prepare($sql_query1);
			$query -> execute($this->param);
			$total = $query -> fetchColumn();;
		}

		// main query
		$data = '';
		//var_dump($sql_query);die();
		$query = $this->db -> prepare($sql_query);
		$query -> execute($this->param);
		$count = $query -> rowCount();
		foreach ($query as $key => $value) 
		{
			foreach ($this->columns as $key => $col) 
			{
				$cols[] = $value[$col];
			}
			$data[] = $cols;
			$cols='';
		}
		return array(
			"draw"            => intval( $_REQUEST['draw'] ),
			"recordsTotal"    => intval( $total ),
			"recordsFiltered" => intval( $total ),
			"data"            => $data,
			"loading-time"	  => '123'
		);
	}
}
?>