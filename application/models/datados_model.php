<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Datados_model extends CI_Model
{
    protected $table = 'dosen';
    protected $column_order = [null, 'id_dosen', 'NIDN', 'nama_dos', 'gelar', null];
    protected $column_search = ['id_dosen', 'NIDN', 'nama_dos', 'gelar'];

    protected $order = ['id_dosen' => 'asc'];

    private function _get_datatables_query()
    {
        $this->db->select('id_dosen, NIDN, nama_dos, gelar');
        $this->db->from($this->table);

        if (!empty($_POST['search']['value'])) {
            $this->db->group_start();
            foreach ($this->column_search as $item) {
                $this->db->or_like($item, $_POST['search']['value']);
            }
            $this->db->group_end();
        }

        if (isset($_POST['order'])) {
            $colIdx = (int) $_POST['order'][0]['column'];
            $dir = $_POST['order'][0]['dir'] === 'asc' ? 'asc' : 'desc';
            $column = $this->column_order[$colIdx] ?? key($this->order);
            if ($column) {
                $this->db->order_by($column, $dir);
            }
        } else {
            $this->db->order_by(key($this->order), $this->order[key($this->order)]);
        }
    }

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if (isset($_POST['length']) && $_POST['length'] != -1) {
            $this->db->limit((int) $_POST['length'], (int) $_POST['start']);
        }
        $query = $this->db->get();
        // Debug: Log the query
        error_log('SQL Query: ' . $this->db->last_query());
        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        return $this->db->get()->num_rows();
    }

    public function count_all()
    {
        return $this->db->count_all($this->table);
    }

    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }
}
