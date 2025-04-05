<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model(['workspace_model', 'settings_model', 'projects_model', 'notifications_model']);
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper(['url', 'language', 'file', 'form']);
        $this->load->library('session');
    }

    public function create_fonts()
    {
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        } else {

            $this->form_validation->set_rules('fonts', str_replace(':', '', 'Fonts is empty.'), 'trim|required|xss_clean');
            if ($this->form_validation->run() === FALSE) {

                $this->session->set_flashdata('message', validation_errors());
                $this->session->set_flashdata('message_type', 'success');
                $response['error'] = true;
                $response['csrfName'] = $this->security->get_csrf_token_name();
                $response['csrfHash'] = $this->security->get_csrf_hash();
                $response['message'] = validation_errors();
                echo json_encode($response);
                return false;
            }
            $fonts = strip_tags($this->input->post('fonts', true));
            if (write_file('assets/fonts/my-fonts.json', $fonts)) {
                $response['error'] = false;
                $response['csrfName'] = $this->security->get_csrf_token_name();
                $response['csrfHash'] = $this->security->get_csrf_hash();
                $response['message'] = "Fonts Created Successful";
                echo json_encode($response);
            } else {
                $response['error'] = true;
                $response['csrfName'] = $this->security->get_csrf_token_name();
                $response['csrfHash'] = $this->security->get_csrf_hash();
                $response['message'] = "Fonts Created Successful";
                echo json_encode($response);
            }
        }
    }
    public function index()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        } else {

            if (!is_admin()) {
                redirect('home', 'refresh');
            }

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
            $data['is_admin'] = $this->ion_auth->is_admin();
            $this->load->view('settings', $data);
        }
    }

    public function save_settings()
    {

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        } else {

            if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) {
                $response['error'] = true;
                $response['is_reload'] = 1;
                $this->session->set_flashdata('message', ERR_ALLOW_MODIFICATION);
                $this->session->set_flashdata('message_type', 'error');
                echo json_encode($response);
                return false;
                exit();
            }
            $setting_type = strip_tags($this->input->post('setting_type', true));

            if ($setting_type == 'general') {
                $this->form_validation->set_rules('company_title', str_replace(':', '', 'Title is empty.'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('footer_url', str_replace(':', '', 'Footer url is empty.'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('currency_shortcode', str_replace(':', '', 'Currency Shortcode is empty.'), 'trim|required|xss_clean');

                $this->form_validation->set_rules('currency_full_form', str_replace(':', '', 'Currency Full Form is empty.'), 'trim|required|xss_clean');
                if ($this->form_validation->run() === FALSE) {

                    $this->session->set_flashdata('message', validation_errors());
                    $this->session->set_flashdata('message_type', 'success');
                    $response['error'] = true;
                    $response['csrfName'] = $this->security->get_csrf_token_name();
                    $response['csrfHash'] = $this->security->get_csrf_hash();
                    $response['message'] = validation_errors();
                    echo json_encode($response);
                    return false;
                }

                $company_title = strip_tags((string) $this->input->post('company_title', true));
                $company_title = $this->db->escape_str($company_title);
                $currency_full_form = strip_tags((string) $this->input->post('currency_full_form', true));
                $currency_full_form = $this->db->escape_str($currency_full_form);
                $currency_symbol = strip_tags((string) $this->input->post('currency_symbol', true));
                $currency_symbol = $this->db->escape_str($currency_symbol);
                $currency_shortcode = strip_tags((string) $this->input->post('currency_shortcode', true));
                $currency_shortcode = $this->db->escape_str($currency_shortcode);
                $default_package = strip_tags((string) $this->input->post('default_package', true));
                $default_package = $this->db->escape_str($default_package);
                $default_tenure = strip_tags((string) $this->input->post('default_tenure', true));
                $default_tenure = $this->db->escape_str($default_tenure);
                $primary_color = strip_tags((string) $this->input->post('primary_color', true));
                $primary_color = $this->db->escape_str($primary_color);
                $secondary_color = strip_tags((string) $this->input->post('secondary_color', true));
                $secondary_color = $this->db->escape_str($secondary_color);
                if ($this->input->post('hide_budget') && $this->input->post('hide_budget') == 'on') {
                    $hide_budget = 1;
                } else {
                    $hide_budget = 0;
                }

                if (!empty($_FILES['full_logo']['name'])) {

                    $config['upload_path'] = './assets/icons/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
                    $config['overwrite'] = TRUE;
                    $config['max_size'] = 10000;
                    $config['max_width'] = 0;
                    $config['max_height'] = 0;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('full_logo')) {
                        $full_logo = $this->upload->data();
                    } else {
                        $this->session->set_flashdata('message', 'Full logo could not Edited! Try again!');
                        $this->session->set_flashdata('message_type', 'error');

                        $response['error'] = True;
                        $response['message'] = 'Not Successful' . $this->upload->display_errors();
                        echo json_encode($response);
                        return false;
                    }
                } else {
                    $full_logo = strip_tags((string) $this->input->post('full_logo_old', true));
                }

                if (!empty($_FILES['half_logo']['name'])) {

                    $config['upload_path'] = './assets/icons/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
                    $config['overwrite'] = TRUE;
                    $config['max_size'] = 10000;
                    $config['max_width'] = 0;
                    $config['max_height'] = 0;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('half_logo')) {
                        $half_logo = $this->upload->data();
                    } else {
                        $this->session->set_flashdata('message', 'Half logo could not Edited! Try again!');
                        $this->session->set_flashdata('message_type', 'error');

                        $response['error'] = True;
                        $response['message'] = 'Not Successful' . $this->upload->display_errors();
                        echo json_encode($response);
                        return false;
                    }
                } else {
                    $half_logo = strip_tags((string) $this->input->post('half_logo_old', true));
                }

                if (!empty($_FILES['favicon']['name'])) {

                    $config['upload_path'] = './assets/icons/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
                    $config['overwrite'] = TRUE;
                    $config['max_size'] = 10000;
                    $config['max_width'] = 0;
                    $config['max_height'] = 0;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('favicon')) {
                        $favicon = $this->upload->data();
                    } else {
                        $this->session->set_flashdata('message', 'Favicon could not Edited! Try again!');
                        $this->session->set_flashdata('message_type', 'error');

                        $response['error'] = True;
                        $response['message'] = 'Not Successful' . $this->upload->display_errors();
                        echo json_encode($response);
                        return false;
                    }
                } else {
                    $favicon = strip_tags((string) $this->input->post('favicon_old', true));
                }

                $timezone = !empty($this->input->post('mysql_timezone') && trim($this->input->post('mysql_timezone')) == '00:00') ? '+' . trim(strip_tags($this->input->post('mysql_timezone', true))) : strip_tags($this->input->post('mysql_timezone', true));
                $footer_url = !empty($this->input->post('footer_url')) ? strip_tags((string) $this->input->post('footer_url', true)) : '';
                $data_json = array(
                    'footer_url' => $this->db->escape_str($footer_url),
                    'company_title' => !empty($company_title) ? $company_title : '',
                    'full_logo' => !empty($full_logo['file_name']) ? $full_logo['file_name'] : $full_logo,
                    'half_logo' => !empty($half_logo['file_name']) ? $half_logo['file_name'] : $half_logo,
                    'favicon' => !empty($favicon['file_name']) ? $favicon['file_name'] : $favicon,
                    'php_timezone' => !empty($this->input->post('php_timezone')) ? strip_tags((string) $this->input->post('php_timezone', true)) : '',
                    'mysql_timezone' => $timezone,
                    'currency_full_form' => $currency_full_form,
                    'currency_symbol' => $currency_symbol,
                    'currency_shortcode' => $currency_shortcode,
                    'default_package' => $default_package,
                    'default_tenure' => $default_tenure,
                    'primary_color' => $primary_color,
                    'secondary_color' => $secondary_color,
                    'hide_budget' => $hide_budget,
                    'system_font' => !empty($this->input->post('system_fonts')) ? strip_tags((string) $this->input->post('system_fonts', true)) : 'default',
                );
                $data = array(
                    'data' => json_encode($data_json)
                );
            } elseif ($setting_type == 'email') {

                $this->form_validation->set_rules('email', str_replace(':', '', 'email is empty.'), 'trim|required|valid_email|xss_clean');
                $this->form_validation->set_rules('password', str_replace(':', '', 'password is empty.'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('smtp_host', str_replace(':', '', 'smtp host is empty.'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('smtp_port', str_replace(':', '', 'smtp port is empty.'), 'trim|required|integer|xss_clean');

                if ($this->form_validation->run() === TRUE) {

                    $email = strip_tags($this->input->post('email', true));
                    $password = strip_tags($this->input->post('password', true));
                    $smtp_host = strip_tags($this->input->post('smtp_host', true));
                    $smtp_port = strip_tags($this->input->post('smtp_port', true));
                    $mail_content_type = strip_tags($this->input->post('mail_content_type', true));
                    $smtp_encryption = strip_tags($this->input->post('smtp_encryption', true));

                    $data_json = array(
                        'email' => !empty($email) ? $email : '',
                        'password' => !empty($password) ? $password : '',
                        'smtp_host' => !empty($smtp_host) ? $smtp_host : '',
                        'smtp_port' => !empty($smtp_port) ? $smtp_port : '',
                        'mail_content_type' => !empty($mail_content_type) ? $mail_content_type : '',
                        'smtp_encryption' => !empty($smtp_encryption) ? $smtp_encryption : ''
                    );

                    $data = array(
                        'data' => json_encode($data_json)
                    );
                } else {
                    $response['error'] = true;
                    $response['csrfName'] = $this->security->get_csrf_token_name();
                    $response['csrfHash'] = $this->security->get_csrf_hash();
                    $response['message'] = validation_errors();
                    echo json_encode($response);
                    return false;
                }
                // } elseif ($setting_type == 'screenshot_set_interval') {
                //     $screenshot = strip_tags($this->input->post('data')) ? strip_tags($this->input->post('data')) : '';
                //     $data = array(
                //         'data' => $screenshot,
                //     );
            } elseif ($setting_type == 'system') {

                $setting_type = 'web_fcm_settings';

                $this->form_validation->set_rules('fcm_server_key', str_replace(':', '', 'fcm server key is empty.'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('apiKey', str_replace(':', '', 'Web api Key is empty.'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('projectId', str_replace(':', '', 'Project Id is empty.'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('appId', str_replace(':', '', 'App Id is empty.'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('messagingSenderId', str_replace(':', '', 'Sender Id is empty.'), 'trim|required|integer|xss_clean');
                $this->form_validation->set_rules('vapidKey', str_replace(':', '', 'VapidKey is empty.'), 'trim|required|xss_clean');
                // $this->form_validation->set_rules('service_account_file', str_replace(':', '', 'Service Account File is empty.'), 'trim|required|xss_clean');

                if ($this->form_validation->run() === TRUE) {

                    $file_name = '';

                    if (isset($_FILES['service_account_file']) && !empty($_FILES['service_account_file']['name'])) {
                        // Check if file was uploaded without errors
                        if ($_FILES['service_account_file']['error'] === UPLOAD_ERR_OK) {
                            // Get file details
                            $fileTmpPath = $_FILES['service_account_file']['tmp_name'];
                            $fileName = $_FILES['service_account_file']['name'];
                            $fileSize = $_FILES['service_account_file']['size'];
                            $fileType = $_FILES['service_account_file']['type'];
                            $fileNameCmps = explode(".", $fileName);
                            $fileExtension = strtolower(end($fileNameCmps));

                            // Check if the file has a JSON extension
                            if ($fileExtension === 'json') {
                                // Move the uploaded file to a directory on the server
                                $uploadFileDir = FIREBASE_PATH;
                                $dest_path = $uploadFileDir . $fileName;

                                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                                    $this->response['message'] = "File is successfully uploaded.";

                                    // Read and process the JSON file
                                    $jsonData = file_get_contents($dest_path);
                                    $data = json_decode($jsonData, true);
                                    $file_name = $_FILES['service_account_file']['name'];
                                    if (json_last_error() !== JSON_ERROR_NONE) {
                                        $this->response['message'] = "Error decoding JSON file.";
                                    }
                                } else {
                                    $this->response['message'] = "Error moving the uploaded file.";
                                }
                            } else {
                                $this->response['message'] = "Uploaded file is not a valid JSON file.";
                            }
                        } else {
                            $this->response['message'] = "Error during file upload: " . $_FILES['service_account_file']['error'];
                        }
                    } else {
                        $file_name = $this->input->post('service_account_file', true);
                        $this->response['message'] = "No file uploaded.";
                    }

                    $fcm_server_key = strip_tags($this->input->post('fcm_server_key', true));
                    $apiKey = strip_tags($this->input->post('apiKey', true));
                    $projectId = strip_tags($this->input->post('projectId', true));
                    $messagingSenderId = strip_tags($this->input->post('messagingSenderId', true));
                    $appId = strip_tags($this->input->post('appId', true));
                    $vapidKey = strip_tags($this->input->post('vapidKey', true));


                    $data_json = array(
                        'fcm_server_key' => !empty($fcm_server_key) ? $fcm_server_key : '',
                        'apiKey' => !empty($apiKey) ? $apiKey : '',
                        'projectId' => !empty($projectId) ? $projectId : '',
                        'authDomain' => !empty($projectId) ? $projectId . '.firebaseapp.com' : '',
                        'databaseURL' => !empty($projectId) ? 'https://' . $projectId . '.firebaseio.com' : '',
                        'storageBucket' => !empty($projectId) ? $projectId . '.appspot.com' : '',
                        'messagingSenderId' => !empty($messagingSenderId) ? $messagingSenderId : '',
                        'appId' => !empty($appId) ? $appId : '',
                        'vapidKey' => !empty($vapidKey) ? $vapidKey : '',
                        'service_account_file' => !empty($file_name) ? $file_name : ''
                    );
                    $data = array(
                        'data' => json_encode($data_json)
                    );
                    $apiKey = !empty($apiKey) ? $apiKey : '';
                    $projectId = !empty($projectId) ? $projectId : '';
                    $authDomain = !empty($projectId) ? $projectId . '.firebaseapp.com' : '';
                    $databaseURL = !empty($projectId) ? 'https://' . $projectId . '.firebaseio.com' : '';
                    $storageBucket = !empty($projectId) ? $projectId . '.appspot.com' : '';
                    $messagingSenderId = !empty($messagingSenderId) ? $messagingSenderId : '';
                    $appId = !empty($appId) ? $appId : '';

                    $template_path = 'assets/js/fcmsettings.js';
                    $template_path2 = 'assets/js/fcm_config.js';

                    $output_path = 'firebase-messaging-sw.js';
                    $output_path2 = 'firebase-config.js';

                    $database_file = file_get_contents($template_path);

                    $new = str_replace("%APIKEY%", $apiKey, $database_file);
                    $new = str_replace("%AUTHDOMAIN%", $authDomain, $new);
                    $new = str_replace("%DATABASEURL%", $databaseURL, $new);
                    $new = str_replace("%PROJECTID%", $projectId, $new);
                    $new = str_replace("%STRORAGEBUCKET%", $storageBucket, $new);
                    $new = str_replace("%MESSAGINGSENDERID%", $messagingSenderId, $new);
                    $new = str_replace("%APPID%", $appId, $new);

                    write_file($output_path, $new);
                    $database_file2 = file_get_contents($template_path2);

                    $new = str_replace("%APIKEY%", $apiKey, $database_file2);
                    $new = str_replace("%AUTHDOMAIN%", $authDomain, $new);
                    $new = str_replace("%DATABASEURL%", $databaseURL, $new);
                    $new = str_replace("%PROJECTID%", $projectId, $new);
                    $new = str_replace("%STRORAGEBUCKET%", $storageBucket, $new);
                    $new = str_replace("%MESSAGINGSENDERID%", $messagingSenderId, $new);
                    $new = str_replace("%APPID%", $appId, $new);
                    write_file($output_path2, $new);
                } else {
                    $response['error'] = true;
                    $response['csrfName'] = $this->security->get_csrf_token_name();
                    $response['csrfHash'] = $this->security->get_csrf_hash();
                    $response['message'] = validation_errors();
                    echo json_encode($response);
                    return false;
                }
            }

            if ($this->settings_model->save_settings($setting_type, $data)) {

                $this->session->set_flashdata('message', 'Setting Updated successfully.');
                $this->session->set_flashdata('message_type', 'success');

                $response['error'] = false;

                $response['csrfName'] = $this->security->get_csrf_token_name();
                $response['csrfHash'] = $this->security->get_csrf_hash();
                $response['message'] = 'Successful';
                echo json_encode($response);
            } else {
                $this->session->set_flashdata('message', 'Setting could not Updated! Try again!');
                $this->session->set_flashdata('message_type', 'error');

                $response['error'] = true;

                $response['csrfName'] = $this->security->get_csrf_token_name();
                $response['csrfHash'] = $this->security->get_csrf_hash();
                $response['message'] = 'Not Successful';
                echo json_encode($response);
            }
        }
    }

    public function setting_detail()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        } else {

            if (!is_admin()) {
                redirect('home', 'refresh');
            }

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
            $data['my_fonts'] = file_get_contents("assets/fonts/my-fonts.json");
            $data['is_admin'] = $this->ion_auth->is_admin();
            $workspace_id = $this->session->userdata('workspace_id');
            $projects = $this->projects_model->get_projects($this->session->userdata('workspace_id'));
            $data['projects'] = $projects;
            $data['notifications'] = $this->notifications_model->get_notifications($this->session->userdata['user_id'], $workspace_id);
            $this->load->view('setting-detail', $data);
        }
    }

    public function smtp_test_mail()
    {
        $this->email->clear(TRUE);
        //Load email library
        $this->load->library('email');
        $config = $this->config->item('ion_auth')['email_config'];
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");

        $to_email = $this->input->post('email');
        $from_email = get_admin_email();
        $this->email->from($from_email, get_compnay_title());
        $this->email->to($to_email);

        $this->email->subject('Send SMTP Test Email');
        $this->email->message('SMTP Test Mail');

        //Send mail
        if ($this->email->send()) {
            $response['error'] = false;
            $this->session->set_flashdata('message', 'SMTP Test Mail Sent successfully.');
            $this->session->set_flashdata('message_type', 'success');
        } else {
            $response['error'] = true;
            $this->session->set_flashdata('message', 'SMTP Test Mail could not sent! Try again!.');
            $this->session->set_flashdata('message_type', 'error');
            $errors = $this->email->print_debugger();
            $response['data'] = $errors;
            echo json_encode($response);
        }
    }
}
