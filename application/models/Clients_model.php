<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Clients_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model(['projects_model']);
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper(['url', 'language']);
    }

    function get_role_by_user_id($id)
    {
        $query = $this->db->query("SELECT g.`name` as role FROM `groups` g LEFT JOIN users_groups ug ON ug.`group_id`=g.`id` WHERE ug.`user_id`=" . $id);
        $result = $query->result_array();
        return $result[0]['role'];
    }

    public function get_clients_list($workspace_id, $user_id = '')
    {
        $offset = 0;
        $limit = 10;
        $sort = 'MaKH';
        $order = 'ASC';
        $where = '';
        $get = $this->input->get();

        // Xử lý các tham số GET
        if (isset($get['sort']))
            $sort = strip_tags($get['sort']);
        if (isset($get['offset']))
            $offset = strip_tags($get['offset']);
        if (isset($get['limit']))
            $limit = strip_tags($get['limit']);
        if (isset($get['order']))
            $order = strip_tags($get['order']);
        /* if (isset($get['search']) && !empty($get['search'])) {
            $search = strip_tags($get['search']);
            $where = " AND (client_code LIKE '%" . $search . "%' 
                            OR client_name LIKE '%" . $search . "%' 
                            OR phone LIKE '%" . $search . "%' 
                            OR email LIKE '%" . $search . "%')";
        } */
        if (isset($get['rmQuanLy'])) {
            if ($get['rmQuanLy'] == 'IS NULL') {
                $where .= " AND RMquanly IS NULL";
            } else {
                $where .= " AND RMquanly = '" . $get['rmQuanLy'] . "'";
            }
        }

        // Truy vấn tổng số bản ghi
        $query = $this->db->query("SELECT COUNT(MaKH) as total FROM client WHERE 1=1 " . $where);
        $res = $query->result_array();
        $total = $res[0]['total'];

        // Truy vấn danh sách clients
        $query = $this->db->query("SELECT MaKH, TenKH, Khoi, SDT, RMquanly
                                FROM client
                                WHERE 1=1 " . $where . " 
                                ORDER BY " . $sort . " " . $order . " 
                                LIMIT " . $offset . ", " . $limit);
        $res = $query->result_array();

        // Chuẩn bị dữ liệu trả về
        $bulkData = array();
        $bulkData['total'] = $total;
        $bulkData['rows'] = array();

        foreach ($res as $row) {

            // Gắn liên kết vào Mã KH và truyền MaKH, user_id, workspace_id vào trang detail theo pretty URL
            $row['MaKH_raw'] = $row['MaKH'];
            $row['MaKH'] = '<a href="' . base_url('index.php/clients/detail/' . $row['MaKH'] . '/' . $user_id . '/' . $workspace_id) . '" target="_blank">' . $row['MaKH'] . '</a>';
            $bulkData['rows'][] = $row;
        }


        return $bulkData;
    }

    public function get_all_clients()
    {
        $query = $this->db->get('client'); // Lấy tất cả dữ liệu từ bảng `client`
        return $query->result_array();
    }

    public function get_client_by_id($id)
    {
        $query = $this->db->get_where('client', ['MaKH' => $id]);
        return $query->row_array();
    }

    function update_user_lang($workspace_id, $user_id, $lang)
    {

        if ($this->db->query('UPDATE users SET lang="' . $lang . '" WHERE FIND_IN_SET(' . $workspace_id . ',workspace_id) AND id=' . $user_id . ' '))
            return true;
        else
            return false;
    }

    function add_users_ids_to_workspace($workspace_id, $user_id)
    {

        // in this func we are adding users id in the workspace - data format 1,2,3 

        $query = $this->db->query('SELECT user_id FROM workspace WHERE id=' . $workspace_id . ' ');

        if (!empty($query)) {
            foreach ($query->result_array() as $row) {
                $product_ids = $row['user_id'];
            }
            $user_id = $product_ids . ',' . $user_id;
        }

        if ($this->db->query('UPDATE workspace SET user_id="' . $user_id . '" WHERE id=' . $workspace_id . ' '))
            return true;
        else
            return false;
    }

    function make_user_admin($workspace_id, $user_id)
    {

        // in this func we are adding users id in the workspace - data format 1,2,3 

        $query = $this->db->query('SELECT admin_id FROM workspace WHERE id=' . $workspace_id . ' ');

        if (!empty($query)) {
            foreach ($query->result_array() as $row) {
                $product_ids = $row['admin_id'];
            }
            $admin_id = $product_ids . ',' . $user_id;
        }

        if ($this->db->query('UPDATE workspace SET admin_id="' . $admin_id . '" WHERE id=' . $workspace_id . ' '))
            return true;
        else
            return false;
    }

    function make_user_super_admin($user_id)
    {

        if ($this->db->query('UPDATE users_groups SET group_id=1 WHERE user_id=' . $user_id . ' '))
            return true;
        else
            return false;
    }

    function get_all_super_admins_id($group_id)
    {

        $query = $this->db->query('SELECT user_id FROM users_groups WHERE group_id=' . $group_id . ' ');

        return $query->result_array();
    }

    function remove_user_from_admin($workspace_id, $user_id, $superadmin = '')
    {

        if (!empty($superadmin)) {
            $this->db->query('UPDATE users_groups SET group_id=2 WHERE user_id=' . $user_id . ' ');
        }

        $query = $this->db->query('SELECT admin_id FROM workspace WHERE FIND_IN_SET(' . $user_id . ',`admin_id`) and id =' . $workspace_id . ' ');
        $result = $query->result_array();
        if (!empty($result)) {
            $admin_id = $result[0]['admin_id'];
            $admin_id = preg_replace('\s+/', '', $admin_id);
            $admin_ids = explode(",", $admin_id);
            if (($key = array_search($user_id, $admin_ids)) !== false) {
                unset($admin_ids[$key]);
            }
            $admin_id = implode(",", $admin_ids);
            if ($this->db->query('UPDATE workspace SET admin_id="' . $admin_id . '" WHERE id=' . $workspace_id . ' '))
                return true;
            else
                return false;
        } else {
            return false;
        }
    }

    // function remove_user_from_workspace($workspace_id, $user_id)
    // {
    //     $this->remove_user_from_admin($workspace_id, $user_id);
    //     $query = $this->db->query('SELECT user_id FROM workspace WHERE FIND_IN_SET(' . $user_id . ',`user_id`) and id =' . $workspace_id . ' ');
    //     // print_r($this->db->last_query());
    //     // return false;
    //     $result = $query->result_array();
    //     if (!empty($result)) {
    //         $admin_id = $result[0]['user_id'];
    //         // $admin_id = preg_replace('\s+/', '', $admin_id);
    //         $admin_ids = explode(",", $admin_id);
    //         if (($key = array_search($user_id, $admin_ids)) !== false) {
    //             unset($admin_ids[$key]);
    //         }
    //         $admin_id = implode(",", $admin_ids);
    //         if ($this->db->query('UPDATE workspace SET user_id="' . $admin_id . '" WHERE id=' . $workspace_id . ' ')) {

    //             $query = $this->db->query('SELECT workspace_id FROM users WHERE FIND_IN_SET(' . $workspace_id . ',`workspace_id`) and id =' . $user_id . ' ');
    //             $result = $query->result_array();
    //             if (!empty($result)) {
    //                 $admin_id = $result[0]['workspace_id'];
    //                 // $admin_id = preg_replace('\s+/', '', $admin_id);
    //                 $admin_ids = explode(",", $admin_id);
    //                 if (($key = array_search($workspace_id, $admin_ids)) !== false) {
    //                     unset($admin_ids[$key]);
    //                 }
    //                 $admin_id = implode(",", $admin_ids);
    //                 $this->db->query('UPDATE users SET workspace_id="' . $admin_id . '" WHERE id=' . $user_id . ' ');

    //                 if ($this->db->query('UPDATE users SET workspace_id="' . $admin_id . '" WHERE id=' . $user_id . ' ')) {

    //                     $query = $this->db->query('SELECT id,user_id FROM projects WHERE FIND_IN_SET(' . $user_id . ',`user_id`) and workspace_id =' . $workspace_id . ' ');
    //                     $results = $query->result_array();
    //                     if (!empty($results)) {
    //                         foreach ($results as $result) {
    //                             $admin_id = $result['user_id'];
    //                             $id = $result['id'];
    //                             $admin_id = preg_replace('\s+/', '', $admin_id);
    //                             $admin_ids = explode(",", $admin_id);
    //                             if (($key = array_search($user_id, $admin_ids)) !== false) {
    //                                 unset($admin_ids[$key]);
    //                             }
    //                             $admin_id = implode(",", $admin_ids);
    //                             $this->db->query('UPDATE projects SET user_id="' . $admin_id . '" WHERE id=' . $id . ' ');
    //                         }
    //                     }
    //                     return true;
    //                 } else {
    //                     return false;
    //                 }
    //             }
    //         } else {
    //             return false;
    //         }
    //     } else {
    //         return false;
    //     }
    // }

    function get_user($user_id, $groups = [])
    {

        // $user_id is array of users ids 
        $this->db->select('u.*,ug.group_id');
        $this->db->from('users u');
        $this->db->where_in('u.id', $user_id);
        $this->db->join('users_groups ug', 'ug.user_id = u.id', 'left');
        if (!empty($groups)) {
            $this->db->group_start();
            foreach ($groups as $group) {
                $this->db->or_where('ug.group_id', $group);
            }
            $this->db->group_end();
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_user_array_responce($user_id)
    {

        // $user_id is array of users ids 

        $this->db->from('users');
        $this->db->where_in('id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_user_not_in_workspace($user_id)
    {

        // $user_id is array of users ids 

        $this->db->from('users');
        $this->db->where_not_in('id', $user_id);
        $query = $this->db->get();
        return $query->result();
    }

    function get_user_in_workspace($user_id, $workspace_id)
    {
        $sql = "SELECT `id` FROM `users` where id != $user_id AND FIND_IN_SET($workspace_id, workspace_id)";
        $query = $this->db->query($sql);
        $array1 = $query->result_array();
        $arr = array_map(function ($value) {
            return $value['id'];
        }, $array1);
        return $arr;
    }

    function get_users_by_email($email)
    {

        $this->db->from('users');
        $this->db->where('`email` like "%' . $email . '%" or `first_name` like "%' . $email . '%" or `last_name` like "%' . $email . '%" ');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_users_by_email_for_add($email)
    {

        $this->db->from('users');
        $this->db->where('email', $email);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_user_by_id($user_id, $row = false)
    {

        $this->db->from('users');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        if ($row) {
            return $query->row();
        } else {
            return $query->result_array();
        }
    }
    function get_user_by_email($email)
    {

        $this->db->from('users');
        $this->db->where('email', $email);
        // $this->db->where('email', $email);
        $query = $this->db->get();
        return $query->result_array();
    }


    function get_all_client_ids($group_id)
    {
        $sql = "SELECT user_id FROM users_groups WHERE group_id=" . $group_id;

        $query = $this->db->query($sql);
        $array1 = $query->result_array();
        $arr = array_map(function ($value) {
            return $value['user_id'];
        }, $array1);
        return $arr;
    }

    function get_user_emails($workspace_id)
    {
        $query = $this->db->query("SELECT email FROM users WHERE workspace_id=" . $workspace_id);
        $result = $query->result_array();
        return $result;
    }

    function get_workspcae_admin_ids($workspace_id)
    {
        $query = $this->db->query("SELECT admin_id FROM workspace WHERE id=" . $workspace_id);
        $result = $query->result_array();
        return $result[0]['admin_id'];
    }

    public function modules($user_id = '')
    {
        $this->db->select('ug.*');
        $this->db->from('users_groups ug');
        if (!empty($user_id)) {
            $this->db->where('ug.user_id', $user_id);
        }

        $query = $this->db->get();
        $module = $query->result_array();
        return $module;
    }

    public function validate_forgot_password_link($code)
    {
        $this->db->select('id');
        $this->db->where('forgotten_password_code', $code);
        $query = $this->db->get('users');
        $num = $query->num_rows();
        if ($num === 0) {
            return 0;
        } else {
            return 1;
        }
    }
    function get_user_by_forgot_password_code($code)
    {
        $this->db->select('id,email,first_name,last_name');
        $this->db->where('forgotten_password_code', $code);
        $query = $this->db->get('users');
        return $query->result_array();
    }
    public function update_password($id, $password)
    {
        $ar = array(
            'password' => $password,
            'forgotten_password_code' => '',
        );
        $this->db->where('id', $id);
        return $this->db->update('users', $ar);
    }
    public function get_user_names()
    {
        $this->db->select('first_name');
        $this->db->select('last_name');
        $query = $this->db->get('users');
        return $query->result_array();
    }

    public function search_users($customer_code, $customer_name, $phone, $identity, $block, $frequency, $unit, $rm_manager)
{
    // Building the query to search users with optional parameters
    $this->db->select('*');
    $this->db->from('client'); // Replace 'users' with your actual table name

    if ($customer_code) {
        $this->db->where('MaKH', $customer_code);
    }
    if ($customer_name) {
        $this->db->like('TenKH', $customer_name); // Using LIKE for partial search
    }
    if ($phone) {
        $this->db->where('SDT', $phone);
    }
    if ($identity) {
        $this->db->where('CMT_Hochieu', $identity);
    }
    if ($block) {
        $this->db->where('Khoi', $block);
    }
    if ($frequency) {
        $this->db->where('Tansuatgiaodich', $frequency);
    }
    if ($unit) {
        $this->db->where('workspace_id', $unit);
    }
    if ($rm_manager) {
        $this->db->where('RMquanly', $rm_manager);
    }

    $query = $this->db->get();

    return $query->result(); // Return the query result
}

    public function update_client($maKH, $data)
    {
        // Update the client data in the database
        $this->db->where('MaKH', $maKH);
        return $this->db->update('client', $data);
    }

}
