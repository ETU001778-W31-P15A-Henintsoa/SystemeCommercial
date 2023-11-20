<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
	public function index()
	{
		$this->load->view('index');
	}

	public function versAcceuil()
	{
		$this->load->view('header');
		$this->load->view('acceuil');
	}

	public function versListeRegroupement()
	{
		$data['regroupement'] = $this->Generalisation->avoirTableConditionnee("v_detailregroupement where etat=1");
		$this->load->view('header');
		$this->load->view('listeRegroupement', $data);
	}

	public function versListeRegroupementEnvoyer()
	{
		$data['regroupement'] = $this->Generalisation->avoirTableConditionnee("v_detailregroupement where etat=11");
		$this->load->view('header');
		$this->load->view('listeRegroupementEnvoyer', $data);
	}
}
