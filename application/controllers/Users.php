<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model(['users_model', 'workspace_model', 'notifications_model', 'projects_model', 'permissions_model']);
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);
		$this->load->library('session');
        $this->config->load('taskhub');
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');
	}

	public function detail($rm_code = null, $user_id = null, $workspace_id = null)
	{
		//Lấy thông tin người dùng
		$data['user'] = $user = ($this->ion_auth->logged_in()) ? $this->ion_auth->user()->row() : array();
		$workspace_ids = explode(',', $user->workspace_id);

		// Truy vấn thông tin chi tiết khách hàng dựa trên MaKH
		$data['rm_detail'] = $this->users_model->get_user_by_id($rm_code);

		// Kiểm tra nếu không tìm thấy khách hàng
		if (!$data['rm_detail']) {
			show_404(); // Hiển thị lỗi nếu không tìm thấy khách hàng
		}

		// Truyền thông tin user_id và workspace_id vào view
		$data['user_id'] = $user_id;
		$data['workspace_id'] = $workspace_id;

		// Tải view với dữ liệu chi tiết khách hàng và thông tin người dùng
		$this->load->view('user-detail', $data);
	}

	function deactive($id = '')
	{
		if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) {
			$this->session->set_flashdata('message', 'This operation not allowed in demo version.');
			$this->session->set_flashdata('message_type', 'error');
			redirect('home', 'refresh');
			return false;
			exit();
		}
		$id = !empty($id) ? $id : $this->uri->segment(3);

		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin() && !empty($id) && is_numeric($id)) {
			$activation = $this->ion_auth->deactivate($id);

			if ($activation) {
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->session->set_flashdata('message_type', 'success');

				$response['error'] = false;
				$response['message'] = $this->ion_auth->messages();
				$response['csrfName'] = $this->security->get_csrf_token_name();
				$response['csrfHash'] = $this->security->get_csrf_hash();
				echo json_encode($response);
			} else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				$this->session->set_flashdata('message_type', 'error');

				$response['error'] = true;
				$response['message'] = $this->ion_auth->errors();
				$response['csrfName'] = $this->security->get_csrf_token_name();
				$response['csrfHash'] = $this->security->get_csrf_hash();
				echo json_encode($response);
			}
		} else {

			$response['error'] = true;
			$response['message'] = $this->ion_auth->errors();
			$response['csrfName'] = $this->security->get_csrf_token_name();
			$response['csrfHash'] = $this->security->get_csrf_hash();
			echo json_encode($response);
		}
	}

	function activate($id = '')
	{
		$id = !empty($id) ? $id : $this->uri->segment(3);

		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin() && !empty($id) && is_numeric($id)) {
			$activation = $this->ion_auth->activate($id);

			if ($activation) {
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->session->set_flashdata('message_type', 'success');

				$response['error'] = false;
				$response['message'] = $this->ion_auth->messages();
				$response['csrfName'] = $this->security->get_csrf_token_name();
				$response['csrfHash'] = $this->security->get_csrf_hash();
				echo json_encode($response);
			} else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				$this->session->set_flashdata('message_type', 'error');

				$response['error'] = true;
				$response['message'] = $this->ion_auth->errors();
				$response['csrfName'] = $this->security->get_csrf_token_name();
				$response['csrfHash'] = $this->security->get_csrf_hash();
				echo json_encode($response);
			}
		} else {

			$response['error'] = true;
			$response['message'] = $this->ion_auth->errors();
			$response['csrfName'] = $this->security->get_csrf_token_name();
			$response['csrfHash'] = $this->security->get_csrf_hash();
			echo json_encode($response);
		}
	}


	public function get_users_list()
	{
		if (!$this->ion_auth->logged_in()) redirect('auth', 'refresh');

		$user = $this->ion_auth->user()->row();
		$role = $this->ion_auth->get_users_groups($user->id)->row()->name;
		// Lấy workspace_id từ session
		$workspace_id = $this->session->userdata('workspace_id');
		$data = $this->users_model->get_rms_list($user, $role, $workspace_id);
	
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	public function view_assign_history() {
		// Lấy giá trị rm_code từ POST request
		$rm_code = $this->input->post('rm_code');  
	
		if (empty($rm_code)) {
			echo "Mã RM không hợp lệ.";
			return;
		}
	
		// Truy vấn lịch sử phân giao từ bảng LSPG_KHHH
		$history = $this->users_model->get_assign_history($rm_code);
	
		// Kiểm tra xem có dữ liệu không
		if (empty($history)) {
			echo "Không có lịch sử phân giao cho RM này.";
			return;
		}
	
		// Tạo HTML cần thiết để hiển thị trong modal
		$output = '';
		foreach ($history as $key => $item) {
			$output .= '<tr>';
			$output .= '<td>' . ($key + 1) . '</td>';
			$output .= '<td>' . htmlspecialchars($item['MaKH']) . '</td>';
			$output .= '<td>' . htmlspecialchars($item['TenKH']) . '</td>';
			$output .= '<td>' . htmlspecialchars($item['NgayPFG']) . '</td>';
			$output .= '<td>' . htmlspecialchars($item['NgayKFG']) . '</td>';
			$output .= '<td>' . htmlspecialchars($item['NguoiPFG']) . '</td>';
			$output .= '<td>' . htmlspecialchars($item['NguoiPFG']) . '</td>';
			$output .= '<td>' . htmlspecialchars($item['NgayCậpNhật']) . '</td>';
			$output .= '</tr>';
		}
	
		// Trả về HTML cho AJAX
		echo $output;
	}
	
	
	
	
	
	
	

/* 	public function detail($id)
{
    if (!$this->ion_auth->logged_in()) redirect('auth', 'refresh');

    // Lấy thông tin người dùng từ database
    $user_details = $this->users_model->get_user_details($id);

    // Hiển thị thông tin người dùng (có thể sử dụng view để hiển thị)
    $data['user_details'] = $user_details;
    $this->load->view('user-detail', $data);
} */


	public function import()
	{
		if (!empty($_FILES['rm_file']['name'])) {
			$file_ext = pathinfo($_FILES['rm_file']['name'], PATHINFO_EXTENSION);
			if ($file_ext !== 'xlsx') {
				$this->session->set_flashdata('error', 'Định dạng file không hợp lệ. Chỉ hỗ trợ .xlsx');
				redirect('rm');
			}
	
			$file_path = $_FILES['rm_file']['tmp_name'];
			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_path);
			$sheetData = $spreadsheet->getActiveSheet()->toArray();
	
			$valid = [];
			$errors = [];
			$rowCount = 0;
	
			foreach ($sheetData as $index => $row) {
				if ($index === 0) continue; // bỏ header
	
				$ma_hris = trim($row[0] ?? '');
				$ten_rm = trim($row[1] ?? '');
	
				if (empty($ma_hris) || empty($ten_rm)) {
					$errors[] = ['row' => $index + 1, 'error' => 'Thiếu mã HRIS hoặc tên RM'];
					continue;
				}
	
				if (++$rowCount > 1000) {
					$this->session->set_flashdata('error', 'Số lượng bản ghi vượt định mức (1000)');
					redirect('rm');
				}
	
				$valid[] = [
					'ma_hris' => $ma_hris,
					'ten_rm' => $ten_rm,
					'ma_rm' => uniqid('RM'),
					'created_at' => date('Y-m-d'),
				];
			}
	
			foreach ($valid as $item) {
				$this->your_model->insert_rm($item); // thay bằng model thật của bạn
			}
	
			$this->session->set_flashdata('success', 'Đã thêm ' . count($valid) . ' RM. Lỗi: ' . count($errors));
			redirect('rm');
		}
	}
	
	public function index()
	{
		if (!check_permissions("users", "read", "", true)) {
			return redirect(base_url(), 'refresh');
		}
		if (!$this->ion_auth->logged_in()) {
			redirect('auth', 'refresh');
		} else {

			$data['user'] = $user = ($this->ion_auth->logged_in()) ? $this->ion_auth->user()->row() : array();

			$workspace_ids = explode(',', $user->workspace_id);

			$section = array_map('trim', $workspace_ids);

			$workspace_ids = $section;

			$data['workspace'] = $workspace = $this->workspace_model->get_workspace($workspace_ids);
			if (!empty($workspace)) {
				if (!$this->session->has_userdata('workspace_id')) {
					$this->session->set_userdata('workspace_id', $workspace[0]->id);
				}
				$data['is_admin'] =  $this->ion_auth->is_admin();

				$current_workspace_id = $this->workspace_model->get_workspace($this->session->userdata('workspace_id'));
				$user_ids = explode(',', $current_workspace_id[0]->user_id);
				$section = array_map('trim', $user_ids);
				$user_ids = $section;

				$data['all_user'] = $this->users_model->get_user($user_ids);
				$data['not_in_workspace_user'] = $this->users_model->get_user_not_in_workspace($user_ids);

				$admin_ids = explode(',', $current_workspace_id[0]->admin_id);
				$section = array_map('trim', $admin_ids);
				$data['admin_ids'] = $admin_ids = $section;

				$super_admin_ids = $this->users_model->get_all_super_admins_id(1);
				
				$data['system_modules'] = $this->config->item('system_modules');
                $data['modules'] = $this->users_model->modules();

    

				foreach ($super_admin_ids as $super_admin_id) {
					$temp_ids[] = $super_admin_id['user_id'];
				}
				$data['super_admin_ids'] = $temp_ids;
				$projects = $this->projects_model->get_projects($this->session->userdata('workspace_id'));
                $data['projects'] = $projects;
				$data['notifications'] = $this->notifications_model->get_notifications($this->session->userdata['user_id'], $workspace[0]->id);
				$this->load->view('users', $data);
			} else {
				redirect('home', 'refresh');
			}
		}
	}

	function search_user_by_email($email = '')
	{
		if ($this->ion_auth->logged_in() && !empty(trim($email))) {
			$data = $this->users_model->get_users_by_email($email);
			if (!empty($data) && isset($data[0]['password'])) {
				unset($data[0]['password']);

				$data[0]['csrfName'] = $this->security->get_csrf_token_name();
				$data[0]['csrfHash'] = $this->security->get_csrf_hash();

				print_r(json_encode($data));
			} else {

				$data[0]['csrfName'] = $this->security->get_csrf_token_name();
				$data[0]['csrfHash'] = $this->security->get_csrf_hash();

				print_r(json_encode($data));
			}
		} else {
			return false;
		}
	}

	function get_user_by_id($id = '')
	{
		
		if ($this->ion_auth->logged_in() && !empty($id) && is_numeric($id)) {
			$data = $this->users_model->get_user_by_id($id);
			if (!empty($data) && isset($data[0]['password'])) {
				unset($data[0]['password']);

				$data[0]['csrfName'] = $this->security->get_csrf_token_name();
				$data[0]['csrfHash'] = $this->security->get_csrf_hash();
				$data[0]['name'] = $data[0]['first_name'] . ' ' . $data[0]['last_name'];

				print_r(json_encode($data));
			} else {

				$data[0]['csrfName'] = $this->security->get_csrf_token_name();
				$data[0]['csrfHash'] = $this->security->get_csrf_hash();
				$data[0]['name'] = $data[0]['first_name'] . ' ' . $data[0]['last_name'];

				print_r(json_encode($data));
			}
		} else {


			$data[0]['email'] = '';
			$data[0]['csrfName'] = $this->security->get_csrf_token_name();
			$data[0]['csrfHash'] = $this->security->get_csrf_hash();

			print_r(json_encode($data));
		}
	}

	function get_user_by_email($email = '')
	{
		
		if ($this->ion_auth->logged_in() && !empty($email)) {
			$data = $this->users_model->get_user_by_email($email);
			if (!empty($data) && isset($data[0]['password'])) {
				unset($data[0]['password']);

				$data[0]['csrfName'] = $this->security->get_csrf_token_name();
				$data[0]['csrfHash'] = $this->security->get_csrf_hash();
				print_r(json_encode($data));
			} else {
				$data[0]['csrfName'] = $this->security->get_csrf_token_name();
				$data[0]['csrfHash'] = $this->security->get_csrf_hash();
				$data[0]['email'] = '';
				print_r(json_encode($data));
			}
		} else {


			$data[0]['email'] = '';
			$data[0]['csrfName'] = $this->security->get_csrf_token_name();
			$data[0]['csrfHash'] = $this->security->get_csrf_hash();

			print_r(json_encode($data));
		}
	}

	function make_user_admin($id = '')
	{
		if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) {
			$this->session->set_flashdata('message', 'This operation not allowed in demo version.');
			$this->session->set_flashdata('message_type', 'error');
			redirect('home', 'refresh');
			return false;
			exit();
		}
		$id = !empty($id) ? $id : $this->uri->segment(3);
		$workspace_id = $this->session->userdata('workspace_id');
		if ($this->ion_auth->logged_in() && !empty($id) && is_numeric($id)) {
			if ($this->users_model->make_user_admin($workspace_id, $id)) {
				$this->session->set_flashdata('message', 'Member Added as a Admin.');
				$this->session->set_flashdata('message_type', 'success');

				$response['error'] = false;
				$response['message'] = 'Successful';
				$response['csrfName'] = $this->security->get_csrf_token_name();
				$response['csrfHash'] = $this->security->get_csrf_hash();
				echo json_encode($response);
			} else {
				$this->session->set_flashdata('message', 'Admin Added as a Member.');
				$this->session->set_flashdata('message_type', 'error');

				$response['error'] = true;
				$response['message'] = 'Successful';
				$response['csrfName'] = $this->security->get_csrf_token_name();
				$response['csrfHash'] = $this->security->get_csrf_hash();
				echo json_encode($response);
			}
		} else {

			$response['error'] = true;
			$response['message'] = 'Successful';
			$response['csrfName'] = $this->security->get_csrf_token_name();
			$response['csrfHash'] = $this->security->get_csrf_hash();
			echo json_encode($response);
		}
	}
	public function addRM()
	{
		// Lấy dữ liệu dropdown từ DB hoặc định nghĩa sẵn
		$data['department_options'] = $this->common_model->get_dropdown('departments', 'id', 'name');
		$data['position_options'] = $this->common_model->get_dropdown('positions', 'id', 'name');
		$data['title_options'] = $this->common_model->get_dropdown('titles', 'id', 'name');
		$data['hris_block_options'] = $this->common_model->get_dropdown('hris_blocks', 'id', 'name');
		$data['block_options'] = $this->common_model->get_dropdown('blocks', 'id', 'name');
		$data['rm_level_options'] = $this->common_model->get_dropdown('rm_levels', 'id', 'name');
	
		// Lấy thông tin user đang đăng nhập để set mặc định các trường hệ thống
		$user = $this->session->userdata('user_logged_in');
		$data['user_branch'] = $user['branch_name'] ?? '';
		$data['upload_unit'] = $user['unit_name'] ?? '';
	
		// Load view modal (hoặc trả về modal nếu đang xử lý bằng AJAX)
		$this->load->view('rm/modal_add_rm', $data);
	}
	
	function make_user_super_admin($id = '')
	{
		if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) {
			$this->session->set_flashdata('message', 'This operation not allowed in demo version.');
			$this->session->set_flashdata('message_type', 'error');
			redirect('home', 'refresh');
			return false;
			exit();
		}
		$id = !empty($id) ? $id : $this->uri->segment(3);
		$workspace_id = $this->session->userdata('workspace_id');
		if ($this->ion_auth->logged_in() && !empty($id) && is_numeric($id)) {
			if ($this->users_model->make_user_admin($workspace_id, $id)) {

				$this->users_model->make_user_super_admin($id);

				$this->session->set_flashdata('message', 'Member Added as a Super Admin.');
				$this->session->set_flashdata('message_type', 'success');

				$response['error'] = false;
				$response['message'] = 'Successful';
				$response['csrfName'] = $this->security->get_csrf_token_name();
				$response['csrfHash'] = $this->security->get_csrf_hash();
				echo json_encode($response);
			} else {
				$this->session->set_flashdata('message', 'Super Admin Added as a Member.');
				$this->session->set_flashdata('message_type', 'error');

				$response['error'] = true;
				$response['message'] = 'Successful';
				$response['csrfName'] = $this->security->get_csrf_token_name();
				$response['csrfHash'] = $this->security->get_csrf_hash();
				echo json_encode($response);
			}
		} else {

			$response['error'] = true;
			$response['message'] = 'Successful';
			$response['csrfName'] = $this->security->get_csrf_token_name();
			$response['csrfHash'] = $this->security->get_csrf_hash();
			echo json_encode($response);
		}
	}
	function remove_user_from_admin($id = '')
	{
		if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) {
			$this->session->set_flashdata('message', 'This operation not allowed in demo version.');
			$this->session->set_flashdata('message_type', 'error');
			redirect('home', 'refresh');
			return false;
			exit();
		}

		$id = !empty($id) ? $id : $this->uri->segment(3);
		$workspace_id = $this->session->userdata('workspace_id');
		if ($this->ion_auth->logged_in() && !empty($id) && is_numeric($id)) {
			$is_admin = ($this->ion_auth->is_admin()) ? true : '';
			if ($this->users_model->remove_user_from_admin($workspace_id, $id, $is_admin)) {
				$this->session->set_flashdata('message', 'Member removed from Admin.');
				$this->session->set_flashdata('message_type', 'success');

				$response['error'] = false;
				$response['message'] = 'Successful';
				$response['csrfName'] = $this->security->get_csrf_token_name();
				$response['csrfHash'] = $this->security->get_csrf_hash();
				echo json_encode($response);
			} else {
				$this->session->set_flashdata('message', 'Member Added as an Admin.');
				$this->session->set_flashdata('message_type', 'error');

				$response['error'] = true;
				$response['message'] = 'Successful';
				$response['csrfName'] = $this->security->get_csrf_token_name();
				$response['csrfHash'] = $this->security->get_csrf_hash();
				echo json_encode($response);
			}
		} else {

			$response['error'] = true;
			$response['message'] = 'Successful';
			$response['csrfName'] = $this->security->get_csrf_token_name();
			$response['csrfHash'] = $this->security->get_csrf_hash();
			echo json_encode($response);
		}
	}

	function remove_user_from_workspace($id = '')
	{

		if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) {
			$this->session->set_flashdata('message', 'This operation not allowed in demo version.');
			$this->session->set_flashdata('message_type', 'error');
			redirect('home', 'refresh');
			return false;
			exit();
		}
		$id = !empty($id) ? $id : $this->uri->segment(3);
		$workspace_id = $this->session->userdata('workspace_id');
		if ($this->ion_auth->logged_in() && !empty($id) && is_numeric($id)) {
			if ($this->users_model->remove_user_from_workspace($workspace_id, $id, 'remove')) {
				$this->session->set_flashdata('message', 'Member removed from Workspace.');
				$this->session->set_flashdata('message_type', 'success');
				if ($id == $this->session->userdata('user_id')) {
					$this->session->unset_userdata('workspace_id');
					redirect('home', 'refresh');
				} else {
					redirect('users', 'refresh');
				}
				return true;
			} else {
				$this->session->set_flashdata('message', 'Not Successful.');
				$this->session->set_flashdata('message_type', 'error');
				return false;
			}
		} else {
			return false;
		}
		redirect('home', 'refresh');
	}

	public function edit_profile()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth', 'refresh');
		} else {
			if (!is_admin()) {
				$this->session->set_flashdata('message', 'You are not authorized to access this page!');
				$this->session->set_flashdata('message_type', 'error');
				redirect('home', 'refresh');
				return false;
				exit();
			}
			if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) {
				$this->session->set_flashdata('message', 'This operation not allowed in demo version.');
				$this->session->set_flashdata('message_type', 'error');
				redirect('home', 'refresh');
				return false;
				exit();
			}
			$user_id = $this->uri->segment(3);
			if (!empty($user_id) && is_numeric($user_id)  || $user_id < 1) {
				$data['user'] = $user = $this->users_model->get_user_by_id($user_id, true);
				$product_ids = explode(',', $user->workspace_id);

				$section = array_map('trim', $product_ids);

				$product_ids = $section;

				$data['workspace'] = $workspace = $this->workspace_model->get_workspace($product_ids);
				if (!empty($workspace)) {
					if (!$this->session->has_userdata('workspace_id')) {
						$this->session->set_userdata('workspace_id', $workspace[0]->id);
					}
					$projects = $this->projects_model->get_projects($this->session->userdata('workspace_id'));
                $data['projects'] = $projects;
					$data['notifications'] = $this->notifications_model->get_notifications($this->session->userdata['user_id'], $workspace[0]->id);
					$data['is_admin'] =  $this->ion_auth->is_admin();
					$this->load->view('edit-profile', $data);
				} else {
					redirect('home', 'refresh');
				}
			} else {
				$this->session->set_flashdata('message', 'Invalid access detected!');
				$this->session->set_flashdata('message_type', 'error');
				redirect('home', 'refresh');
				return false;
				exit();
			}
		}
	}
	public function get_user_data()
	{
		if ($this->ion_auth->logged_in() && !empty($id) && is_numeric($id)) {
			$workspace_id = $this->session->userdata('workspace_id');
			$data = $this->users_model->get_user_data($workspace_id);
			if (!empty($data)) {
				$data[0]['csrfName'] = $this->security->get_csrf_token_name();
				$data[0]['csrfHash'] = $this->security->get_csrf_hash();
				echo json_encode($data[0]);
			} else {
				$data[0]['csrfName'] = $this->security->get_csrf_token_name();
				$data[0]['csrfHash'] = $this->security->get_csrf_hash();
				echo json_encode($data[0]);
			}
		} else {
			$data[0]['csrfName'] = $this->security->get_csrf_token_name();
			$data[0]['csrfHash'] = $this->security->get_csrf_hash();
			echo json_encode($data[0]);
		}
	}

	public function get_user_permissions()
    {
        if ($this->ion_auth->logged_in()) {
            $workspace_id = $this->session->userdata('workspace_id');
            $id = $_POST['id'];
            $user_data = $this->users_model->get_user($id);
           
            $permissions = $this->permissions_model->get_permissions($workspace_id, $id);

            if (!empty($permissions)) {
                $data = [
                    'user' => $user_data,
                    'permissions' => $permissions[0]['permissions'],
                ];
                $response['error'] = false;
                $response['message'] = 'Successful';
                $response['type'] = '1';
                $response['data'] = $data;
                $response['csrfName'] = $this->security->get_csrf_token_name();
                $response['csrfHash'] = $this->security->get_csrf_hash();
                echo json_encode($response);
                die();
            } else {
                $permission = $this->users_model->modules($this->session->userdata('user_id'));

                $data = [
                    'user' => $user_data,
                    'permissions' => $permission,
                ];
                $response['error'] = false;
                $response['message'] = 'Successful';
                $response['type'] = '0';
                $response['user_type'] = is_member($id) ? "member" : "client";
                $response['data'] = $data;
                $response['csrfName'] = $this->security->get_csrf_token_name();
                $response['csrfHash'] = $this->security->get_csrf_hash();
                echo json_encode($response);
                die();
            }

        } else {
            $data[0]['csrfName'] = $this->security->get_csrf_token_name();
            $data[0]['csrfHash'] = $this->security->get_csrf_hash();
            echo json_encode($data[0]);
        }
    }

	public function set_user_permission()
    {
       
        $workspace_id = $this->session->userdata('workspace_id');
        
        $id = $this->input->post('id');

        $permissions = $this->input->post('permissions');
        $has_permission = $this->permissions_model->get_permissions($workspace_id, $id);

        $data = [
            'user_id' => $id,
            'workspace_id' => $workspace_id,
            'permissions' => json_encode($permissions),
        ];

        $set = '';

        if (!empty($has_permission)) {
            $set = $this->permissions_model->update_permissions($id, $workspace_id, $data);
        } else {
            $set = $this->permissions_model->add_permissions($data);
        }
		
		
        if ($set) {
            $response['error'] = false;
            $response['message'] = 'Successful';
            $response['csrfName'] = $this->security->get_csrf_token_name();
            $response['csrfHash'] = $this->security->get_csrf_hash();
            echo json_encode($response);
            die();
        } else {
            $response['error'] = true;
            $response['message'] = 'Unable to Set Permission';
            $response['csrfName'] = $this->security->get_csrf_token_name();
            $response['csrfHash'] = $this->security->get_csrf_hash();
            echo json_encode($response);
            die();
        }

    }

    public function get_user_for_assign()
    {
        if (!$this->ion_auth->logged_in()) redirect('auth', 'refresh');

        $user = $this->ion_auth->user()->row();
        $role = $this->ion_auth->get_users_groups($user->id)->row()->name;
        // Lấy workspace_id từ session
        $workspace_id = $this->session->userdata('workspace_id');
        $data = $this->users_model->get_user_for_assign([]);

        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
