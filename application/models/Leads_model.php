<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Leads_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper(['url', 'language']);
    }
    function create_leads($data)
    {
        if ($this->db->insert('leads', $data))
            return true;
        else
            return false;
    }

    function edit_leads($data, $id)
    {
        $this->db->where('id', $id);
        if ($this->db->update('leads', $data))
            return true;
        else
            return false;
    }
    function lead_status_update($data, $id)
    {
        $this->db->where('id', $id);
        if ($this->db->update('leads', $data))
            return true;
        else
            return false;
    }
    function get_leads($workspace_id)
    {
        $query = $this->db->query('SELECT * FROM leads ORDER BY MaKH desc');
        return $query->result();
    }
    function get_leads_list($workspace_id, $user_id)
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

        // Truy vấn tổng số bản ghi
        $query = $this->db->query("SELECT COUNT(MaKH) as total FROM leads WHERE 1=1 " . $where);
        $res = $query->result_array();
        $total = $res[0]['total'];

        // Truy vấn danh sách clients
        $query = $this->db->query("SELECT MaKH, TenKH, SDT, Email, MucdoTN, NguonKH, MaRM FROM leads WHERE 1=1 " . $where . "
                                ORDER BY " . $sort . " " . $order . " 
                                LIMIT " . $offset . ", " . $limit);
        $res = $query->result_array();

        // Chuẩn bị dữ liệu trả về
        $bulkData = array();
        $bulkData['total'] = $total;
        $bulkData['rows'] = array();

        /* foreach ($res as $row) {

            // Gắn liên kết vào Mã KH và truyền MaKH, user_id, workspace_id vào trang detail theo pretty URL
            $row['MaKH'] = '<a href="' . base_url('index.php/clients/detail/' . $row['MaKH'] . '/' . $user_id . '/' . $workspace_id) . '" target="_blank">' . $row['MaKH'] . '</a>';
            $bulkData['rows'][] = $row;
        } */
        
            
        return $bulkData;
    }
    public function get_all_leads()
    {
        $query = $this->db->get('leads'); // Lấy tất cả dữ liệu từ bảng `client`
        return $query->result_array();
    }

    function get_leads_by_id($lead_id)
    {
        $query = $this->db->query('SELECT * FROM leads WHERE MaKH=' . $lead_id . ' ');
        return $query->result_array();
    }

    function convert_to_client_id($lead_id)
    {
        $query = $this->db->query('SELECT * FROM leads WHERE MaKH=' . $lead_id . ' ');
        return $query->result_array();
    }

    function delete_leads($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('leads'))
            return true;
        else
            return false;
    }

    function fetch_leads($workspace_id, $user_id, $user_type)
    {
        if ($user_type != 'normal') {
            $query = $this->db->query('SELECT * FROM leads WHERE FIND_IN_SET(' . $user_id . ',`client_id`) AND workspace_id=' . $workspace_id);
        } else {
            $query = $this->db->query('SELECT * FROM leads WHERE FIND_IN_SET(' . $user_id . ',`user_id`) AND workspace_id=' . $workspace_id);
        }
        return $query->result_array();
    }
}
