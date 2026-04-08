    <?php
defined('BASEPATH') or exit('No direct script access allowed');

class Verifikasi_model extends CI_Model
{
    protected $table = 'pengajuan_proposal';
    // Sesuaikan urutan ini dengan urutan <th> di tabel HTML kamu!
    protected $column_order = [null, 'p.nim', 'm.nama', 'p.judul', 'p.link', 'p.tanggal', 'p.status'];
    protected $column_search = ['p.nim', 'm.nama', 'p.judul', 'p.status'];

    protected $order = ['p.id' => 'desc']; // Biasanya yang terbaru di atas

    private function _get_datatables_query()
    {
        $this->db->select('p.id, p.nim, m.nama, p.judul, p.link, p.status, p.tanggal');
        $this->db->from('pengajuan_proposal p');
        $this->db->join('mahasiswa m', 'm.nim = p.nim', 'left');

        $i = 0;
        foreach ($this->column_search as $item) {
            if (!empty($_POST['search']['value'])) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        // Menggunakan count_all_results lebih efisien daripada get()->num_rows()
        return $this->db->count_all_results();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
}
