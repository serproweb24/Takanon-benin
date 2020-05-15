<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spw_model extends CI_Model {

/*
|--------------------------------------------------------------------------
| Get rows
|--------------------------------------------------------------------------
|
*/

function get_rows($table,$array)
{
	$this->db->where($array);
	$query = $this->db->get($table);
	return $query->result();
}
function get_rows_order($table,$array,$column,$order)
{
	$this->db->order_by($column,$order);
	$this->db->where($array);
	$query = $this->db->get($table);
	return $query->result();
}

function get_rows_limit($table,$array,$limit)
{
	$this->db->limit($limit);
	$this->db->where($array);
	$query = $this->db->get($table);
	return $query->result();
}
function get_rows_limit_order($table,$array,$limit,$column,$order)
{
	$this->db->order_by($column,$order);
	$this->db->limit($limit);
	$this->db->where($array);
	$query = $this->db->get($table);
	return $query->result();
}

function get_Double_Table($fistTable,$secondTable,$as,$lien,$array,$column,$order)
{
	$this->db->select($as);
	$this->db->from($fistTable);
	$this->db->join($secondTable, $lien);
	$this->db->order_by($column,$order);
	$this->db->where($array);
	$query = $this->db->get();
	return $query->result();
}
function get_two_Tables_limit($fistTable,$secondTable,$as,$lien,$array,$column,$order,$limit)
{
	$this->db->select($as);
	$this->db->from($fistTable);
	$this->db->join($secondTable, $lien);
	$this->db->order_by($column,$order);
	$this->db->limit($limit);
	$this->db->where($array);
	$query = $this->db->get();
	return $query->result();
}
function get_two_Tables_join_limit($fistTable,$secondTable,$as,$lien,$array,$count=false,$limit,$offset,$join,$column,$order)
{
	$this->db->select($as);
	$this->db->from($fistTable);
	$this->db->join($secondTable, $lien, $join);
	$this->db->order_by($column,$order);
	if($count):$this->db->limit($limit,$offset);endif;
	$this->db->where($array);
	$query = $this->db->get();
	return $query->result();
}
function get_two_Tables_whereNotIn_limit($fistTable,$secondTable,$as,$lien,$array,$indice,$arrayNotIn,$column,$order,$limit)
{
	$this->db->select($as);
	$this->db->from($fistTable);
	$this->db->join($secondTable, $lien);
	$this->db->order_by($column,$order);
	$this->db->limit($limit);
	$this->db->where($array);
	$this->db->where_not_in($indice,$arrayNotIn);
	$query = $this->db->get();
	return $query->result();
}
function get_tree_Table($fistTable,$secondTable,$thirdTable,$as,$lien,$lienSecond,$array,$column,$order)
{
	$this->db->select($as);
	$this->db->from($fistTable);
	$this->db->join($secondTable, $lien);
	$this->db->join($thirdTable, $lienSecond);
	$this->db->order_by($column,$order);
	$this->db->where($array);
	$query = $this->db->get();
	return $query->result();
}

function get_tree_Table_limit($fistTable,$secondTable,$thirdTable,$as,$lien,$lienSecond,$array,$column,$order,$limit)
{
	$this->db->select($as);
	$this->db->from($fistTable);
	$this->db->join($secondTable, $lien);
	$this->db->join($thirdTable, $lienSecond);
	$this->db->order_by($column,$order);
	$this->db->limit($limit);
	$this->db->where($array);
	$query = $this->db->get();
	return $query->result();
}

function get_four_Table($fistTable,$secondTable,$thirdTable,$fourthTable,$as,$lien,$lienSecond,$lienThird,$array,$column,$order)
{
	$this->db->select($as);
	$this->db->from($fistTable);
	$this->db->join($secondTable, $lien);
	$this->db->join($thirdTable, $lienSecond);
	$this->db->join($fourthTable, $lienThird);
	$this->db->order_by($column,$order);
	$this->db->where($array);
	$query = $this->db->get();
	return $query->result();
}
function get_four_Table_limit($fistTable,$secondTable,$thirdTable,$fourthTable,$as,$lien,$lienSecond,$lienThird,$array,$column,$order,$limit)
{
	$this->db->select($as);
	$this->db->from($fistTable);
	$this->db->join($secondTable, $lien);
	$this->db->join($thirdTable, $lienSecond);
	$this->db->join($fourthTable, $lienThird);
	$this->db->order_by($column,$order);
	$this->db->limit($limit);
	$this->db->where($array);
	$query = $this->db->get();
	return $query->result();
}

function get_five_Table($fistTable,$secondTable,$thirdTable,$fourthTable,$fifthTable,$as,$lien,$lienSecond,$lienThird,$lienFourth,$array,$column,$order)
{
	$this->db->select($as);
	$this->db->from($fistTable);
	$this->db->join($secondTable, $lien);
	$this->db->join($thirdTable, $lienSecond);
	$this->db->join($fourthTable, $lienThird);
	$this->db->join($fifthTable, $lienFourth);
	$this->db->order_by($column,$order);
	$this->db->where($array);
	$query = $this->db->get();
	return $query->result();
}

function get_Six_Table($fistTable,$secondTable,$thirdTable,$fourthTable,$fifthTable,$sixthTable,$as,$lien,$lienSecond,$lienThird,$lienFourth,$lienFifth,$array,$column,$order)
{
	$this->db->select($as);
	$this->db->from($fistTable);
	$this->db->join($secondTable, $lien);
	$this->db->join($thirdTable, $lienSecond);
	$this->db->join($fourthTable, $lienThird);
	$this->db->join($fifthTable, $lienFourth);
	$this->db->join($sixthTable, $lienFifth);
	$this->db->order_by($column,$order);
	$this->db->where($array);
	$query = $this->db->get();
	return $query->result();
}


function get_rows_GrpBY($table,$array,$column,$group_by)
{
	$this->db->select($column);
	$this->db->where($array);
	$this->db->group_by($group_by);
	$query = $this->db->get($table);
	return $query->result();
}

function get_rows_distinct($table,$array,$column)
{
	$this->db->distinct();
	$this->db->select($column);
	$this->db->where($array);
	$query = $this->db->get($table);
	return $query->result();
}


function get_Double_Table_GrpBY($fistTable,$secondTable,$as,$lien,$array,$group_by,$column,$order)
{
	$this->db->select($as);
	$this->db->from($fistTable);
	$this->db->join($secondTable, $lien);
	$this->db->order_by($column,$order);
	$this->db->where($array);
	$this->db->group_by($group_by);
	$query = $this->db->get();
	return $query->result();
}


function get_Count($table,$array)
{
	$this->db->where($array);
	$this->db->from($table);
	return $this->db->count_all_results();
}



function get_id_last_rows($table,$id)
{
	$this->db->limit(1);
	$this->db->order_by($id,'Desc');
	$this->db->where($array);
	$query = $this->db->get($table);
	$resultats = $query->result();
	if($resultats){
		foreach($resultats as $resultat):
			return $resultat->$id;
		endforeach;
	}else{
		return 0;
	}

}

function get_limit_offset_like_order($table,$array=array(),$limit,$offset,$like=array(),$column,$order)
{
	$this->db->order_by($column,$order);
	$this->db->limit($limit,$offset);
	$this->db->like($like);
	$this->db->where($array);
	$query = $this->db->get($table);
	return $query->result();
}


function get_rows_between($table,$first_id,$last_id)
{
  $this->db->where('id BETWEEN "'. $first_id. '" and "'. $last_id.'"');
  $query = $this->db->get($table);
  return $query->result();
}

function get_last_row($table,$array,$id)
{
  $this->db->order_by($id,'Desc');
  $this->db->limit('1');
  $this->db->where($array);
  $query = $this->db->get($table);
  return $query->result();
}


/*
|--------------------------------------------------------------------------
| Get for pagination
|--------------------------------------------------------------------------
|
*/

function get_countAll_for_pagination($table,$array=array(),$like=array())
{
	$this->db->like($like);
	$this->db->where($array);
	$query = $this->db->get($table);
	return count($query->result());
}


function get_limit_for_pagination($table,$array=array(),$limit,$offset,$like=array(),$column,$order,$count=false)
{
	$this->db->order_by($column,$order);
	if($count):$this->db->limit($limit,$offset);endif;
	$this->db->like($like);
	$this->db->where($array);
	$query = $this->db->get($table);
	return $query->result();
}

function get_DoubleTables_limit_for_pagination($fistTable,$secondTable,$as,$lien,$array,$limit,$offset,$like=array(),$column,$order,$count=false)
{
	$this->db->select($as);
	$this->db->from($fistTable);
	$this->db->join($secondTable, $lien);
	$this->db->order_by($column,$order);
	if($count):$this->db->limit($limit,$offset);endif;
	$this->db->like($like);
	$this->db->where($array);
	$query = $this->db->get();
	return $query->result();
}
function get_DoubleTable_GrpBY_limit_for_pagination($fistTable,$secondTable,$as,$lien,$array,$group_by,$limit,$offset,$like,$column,$order,$count=false)
{
	$this->db->select($as);
	$this->db->from($fistTable);
	$this->db->join($secondTable, $lien);
	$this->db->order_by($column,$order);
	if($count):$this->db->limit($limit,$offset);endif;
	$this->db->like($like);
	$this->db->where($array);
	$this->db->group_by($group_by);
	$query = $this->db->get();
	return $query->result();
}
function get_treeTables_limit_for_pagination($fistTable,$secondTable,$thirdTable,$as,$lien,$lienSecond,$limit,$offset,$array=array(),$like=array(),$column,$order,$count=false)
{
  if($count):$this->db->limit($limit,$offset);endif;
  $this->db->select($as);
  $this->db->like($like);
  $this->db->from($fistTable);
  $this->db->join($secondTable, $lien);
  $this->db->join($thirdTable, $lienSecond);
  $this->db->order_by($column,$order);
  $this->db->where($array);
  $query = $this->db->get();
  return $query->result();
}
function get_fourTables_limit_for_pagination($fistTable,$secondTable,$thirdTable,$fourthTable,$as,$lien,$lienSecond,$lienThird,$limit,$offset,$array=array(),$like=array(),$column,$order)
{
  $this->db->limit($limit,$offset);
  $this->db->select($as);
  $this->db->like($like);
  $this->db->from($fistTable);
  $this->db->join($secondTable, $lien);
  $this->db->join($thirdTable, $lienSecond);
  $this->db->join($fourthTable, $lienThird);
  $this->db->order_by($column,$order);
  $this->db->where($array);
  $query = $this->db->get();
  return $query->result();
}


function get_fiveTables_limit_for_pagination($fistTable,$secondTable,$thirdTable,$fourthTable,$fifthTable,$as,$lien,$lienSecond,$lienThird,$lienFourth,$limit,$offset,$array=array(),$like=array(),$column,$order)
{
	$this->db->limit($limit,$offset);
	$this->db->select($as);
	$this->db->like($like);
	$this->db->from($fistTable);
	$this->db->join($secondTable, $lien);
	$this->db->join($thirdTable, $lienSecond);
	$this->db->join($fourthTable, $lienThird);
	$this->db->join($fifthTable, $lienFourth);
	$this->db->order_by($column,$order);
	$this->db->where($array);
	$query = $this->db->get();
	return $query->result();
}



/*
|--------------------------------------------------------------------------
| Add in table
|--------------------------------------------------------------------------
|
*/
function add_item($table,$dataAdd)
{
	$this->db->insert($table,$dataAdd);
}



/*
|--------------------------------------------------------------------------
| Update in table
|--------------------------------------------------------------------------
|
*/
function update_item($table,$dataItem,$array)
{
	$this->db->where($array);
	$this->db->update($table,$dataItem);
}



/*
|--------------------------------------------------------------------------
| Delate in table
|--------------------------------------------------------------------------
|
*/

function delate_item($table,$array)
{
	$this->db->where($array);
	$this->db->delete($table);
}

/*
|--------------------------------------------------------------------------
| Get sum columns
|--------------------------------------------------------------------------
|
| Cette fonction récupere la somme des element d'une colonne donnée en 
| respectant les conditiondes définies.
| Elle requiere deux parametres
|
*/
function sum_columns($table,$array,$column)
{
	$this->db->select("*");
	$this->db->select_sum($column);
	$this->db->where($array);
	$query = $this->db->get($table);
	$results = $query->result();

	if($results){
		foreach($results as $result):
			$totale = $result->$column;
		endforeach;
		if($totale)
		{
			return $totale;
		}else{
			return 0;
		}
	}else{
		return 0;
	}

}

function sum_columns_Double_Table($fistTable,$secondTable,$as,$lien,$array,$column)
{
	$this->db->select($as);
	$this->db->from($fistTable);
	$this->db->join($secondTable, $lien);
	$this->db->select_sum($fistTable.'.'.$column);
	$this->db->where($array);
	$query = $this->db->get();
	$results = $query->result();

	if($results){
		$totale = 0;
		foreach($results as $result):
			$totale = $result->$column;
		endforeach;
		if($totale)
		{
			return $totale;
		}else{
			return 0;
		}
	}else{
		return 0;
	}

}

/*
|--------------------------------------------------------------------------
| Get Max columns
|--------------------------------------------------------------------------
|
*/
function max_columns($table,$array,$column)
{
	$this->db->select_max($column);
	$this->db->where($array);
	$query = $this->db->get($table);
	$results = $query->result();

	if($results){
		foreach($results as $result):
			$totale = $result->$column;
		endforeach;
		if($totale)
		{
			return $totale;
		}else{
			return 0;
		}
	}else{
		return 0;
	}
}

/*
|--------------------------------------------------------------------------
| Las id insert
|--------------------------------------------------------------------------
|
*/
//Last id insert
function last_id_insert($table)
{
	return  $this->db->insert_id($table);
}



/*
|--------------------------------------------------------------------------
| New column in table
|--------------------------------------------------------------------------
|
*/

function new_column_in_table($table,$fields)
{
	$this->dbforge->add_column($table, $fields);
}



/*
|--------------------------------------------------------------------------
| uploadFiles
|--------------------------------------------------------------------------
|
*/
function uploadFiles($destination,$userfile,$typefile='')
{
  $config['upload_path']          = $destination;
  if(isset($typefile)&&!empty($typefile)):
    $config['allowed_types']        =  $typefile;
  else:
    $config['allowed_types']        = 'pdf|csv|docx|gif|jpg|png|jpeg';
  endif;
  $config['max_size']             = 2000;
  $config['max_width']            = 2000;
  $config['max_height']           = 2000;
  $config['remove_spaces']           = TRUE;
  $config['encrypt_name']           = TRUE;
  
  //charger la biblioteque et lui passer les paramettres
  $this->load->library('upload', $config);

  //effectuer le chargement
  if(!isset($userfile)){$userfile='userfile';}
  if($this->upload->do_upload($userfile))
  {
    $NewImg = $this->upload->data();
    $nameNewImg  = $NewImg['file_name'];
  }else{
    $nameNewImg  = "error";
  }
  return $nameNewImg;
}











}//End Model
