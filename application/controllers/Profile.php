<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model(['workspace_model', 'notifications_model', 'projects_model']);
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);
		$this->load->library('session');
	}

	public function index()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth', 'refresh');
		} else {
			$data['user'] = $user = ($this->ion_auth->logged_in()) ? $this->ion_auth->user()->row() : array();

			$product_ids = explode(',', $user->workspace_id);

			$section = array_map('trim', $product_ids);

			$product_ids = $section;

			$data['workspace'] = $workspace = $this->workspace_model->get_workspace($product_ids);
			if (!empty($workspace)) {
				if (!$this->session->has_userdata('workspace_id')) {
					$this->session->set_userdata('workspace_id', $workspace[0]->id);
				}
			}
			$workspace_id = $this->session->userdata('workspace_id');
			$projects = $this->projects_model->get_projects($this->session->userdata('workspace_id'));
                $data['projects'] = $projects;
			$data['notifications'] = $this->notifications_model->get_notifications($this->session->userdata['user_id'], $workspace_id);
			$data['is_admin'] =  $this->ion_auth->is_admin();
			$this->load->view('profile', $data);
		}
	}
}
