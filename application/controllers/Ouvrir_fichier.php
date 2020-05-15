<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ouvrir_fichier extends CI_Controller {

	
	public function index()
	{
		userIsLogin(3);

		/*--==Varibles Générale==--*/
		$data['pageTitle'] = 'Ouvrir_fichier';
		$data['titre'] = 'Ouvrir_fichier';

			
		if(isset($_GET['file'])):
			$filename = $_GET['file'];
			$data['filename'] = $filename;

			if(isset($_GET['type'])):
				$type = $_GET['type'];
				$data['path'] = $path = '/'.$type.'/'.$filename;
			else:
				$data['path'] = $path = '/documents/'.$filename;
			endif;

		endif;


		 $file = realpath("assets"). $path;


		if(file_exists($file)) :
			//Effacer le contenu html avant le chargeement du fichier
			if (ob_get_level()):
				ob_end_clean();
			endif;

			//Copier le contenu du fichier
			$data = file_get_contents($file);

			//Evectuer le telechargement
			force_download ('pdf.pdf', $data);
		else:

			echo "Auccun fichier trouvé.";
			exit();

		endif;

		

		/*--==Chargement du template==--*/
		//$this->template->loadTemplate('spw_template', 'default_view', True, 'generals/ouvrir_fichier_view', $data);
	}

}