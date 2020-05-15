<?php
class Template {
  //ci instance
  private $CI;
  //template Data
  var $template_data = array();
  
  public function __construct() 
  {
    $this->CI =& get_instance();
  }
 

  function set($content_area, $value)
  {
    $this->template_data[$content_area] = $value;
  }
  
  function load($template = '', $name ='', $view = '' , $view_data = array(), $return = FALSE)
  {
    $this->set($name , $this->CI->load->view($view, $view_data, TRUE));
    
    $this->CI->load->view($template, $this->template_data);
  }



  /*-------------------------------*\
  |===========Spw-Template==========|
  \*-------------------------------*/
  //=>1: le nom du template à charcher
  //=>2: la racine du template à charger
  //=>3: Chargement du sibebar (True/False)
  //=>4: Le couloir charger (site/Admin/Client) corridor
  //=>5: Le chemin de la view à chargée
  //=>6: Les variables relatives à la page chargée 
  function loadTemplate($templateName = '', $templateRoot = '', $sidebar = FALSE, $corridor='',  $templatePathView = '',  $data = array(), $return = FALSE){
    $templateData = array_merge(["contents"=>$templateName."/laoud/".$templatePathView, "sidebar"=>($sidebar)? $sidebar:FALSE, 'corridor'=>$corridor], $data);
    $this->CI->load->view($templateName.'/'.$templateRoot, $templateData);
  }
  
}
?>