<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Siswa extends CI_Model {

    public function dt_siswa($post)
    {
        $from = 'admin a';
        // untuk sort
        $columns = array(
            'nisn',
            'nama_siswa',
            'no_hp',
        );

        // untuk search
        $columnsSearch = array(
            'nisn',
            'nama_siswa',
            'no_hp',
        );


        // custom SQL
        $sql = "SELECT * FROM  data_siswa a left join dt_class dc on a.id_kelas=dc.id_class";


        $where = "";
        // if(isset($post['kategori']) && $post['kategori'] != 'SEMUA') $where .= " (kategori='".$post['kategori']."')";

        $whereTemp = "";
        if (isset($post['date']) && $post['date'] != '') {
            $date = explode(' / ', $post['date']);
            if (count($date) == 1) {
                $whereTemp .= "(created_at LIKE '%" . $post['date'] . "%')";
            } else {
                // $whereTemp .= "(created_at BETWEEN '".$date[0]."' AND '".$date[1]."')";
                $whereTemp .= "(date_format(created_at, \"%Y-%m-%d\") >='$date[0]' AND date_format(created_at, \"%Y-%m-%d\") <= '$date[1]')";
            }
        }
        if ($whereTemp != '' && $where != '') $where .= " AND (" . $whereTemp . ")";
        else if ($whereTemp != '') $where .= $whereTemp;

        // search
        if (isset($post['search']['value']) && $post['search']['value'] != '') {
            $search = $post['search']['value'];
            // create parameter pencarian kesemua kolom yang tertulis
            // di $columns
            $whereTemp = "";
            for ($i = 0; $i < count($columnsSearch); $i++) {
                $whereTemp .= $columnsSearch[$i] . ' LIKE "%' . $search . '%"';

                // agar tidak menambahkan 'OR' diakhir Looping
                if ($i < count($columnsSearch) - 1) {
                    $whereTemp .= ' OR ';
                }
            }
            if ($where != '') $where .= " AND (" . $whereTemp . ")";
            else $where .= $whereTemp;
        }
        if ($where != '') $sql .= ' WHERE (' . $where . ')';


        //SORT Kolom
        $sortColumn = isset($post['order'][0]['column']) ? $post['order'][0]['column'] : 1;
        $sortDir    = isset($post['order'][0]['dir']) ? $post['order'][0]['dir'] : 'asc';

        $sortColumn = $columns[$sortColumn - 1];

        $sql .= " ORDER BY {$sortColumn} {$sortDir}";

        $count = $this->db->query($sql);
        // hitung semua data
        $totaldata = $count->num_rows();

        // memberi Limit
        $start  = isset($post['start']) ? $post['start'] : 0;
        $length = isset($post['length']) ? $post['length'] : 10;


        $sql .= " LIMIT {$start}, {$length}";


        $data  = $this->db->query($sql);

        return array(
            'totalData' => $totaldata,
            'data' => $data,
        );
    }
    public function cari_nisn($nisn)
    {
        $this->db->where('nisn', $nisn);
        return $this->db->get('data_siswa')->num_rows();
        // var_dump($lastquery);die;
    }
    public function tambah_siswa($in)
    {

        if ($this->db->insert('data_siswa', $in)) {
            $status =  true;
        } else {
            var_dump($this->db->error());
            die();
            $status = false;
        }
        return $status;
    }

}