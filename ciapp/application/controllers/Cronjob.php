<?php
class Cronjob extends G_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function promo_disable() {
        $today = strtotime(date('Y-m-d'));

        $list_promo = $this->db->select('id, expired')->from('m_promo')->where('status', 'yes')->get()->result();

        $arr_update_status = [];
        foreach ($list_promo as $v_promo) {
            $expired = strtotime($v_promo->expired);
            if ($today >= $expired) {
                $data_update = [
                    'id' => $v_promo->id,
                    'status' => 'no'
                ];

                $arr_update_status[] = $data_update;
            }
        }

        $q_update = $this->db->update_batch('m_promo', $arr_update_status, 'id');

        if ($q_update) {
            echo json_encode(['status' => TRUE, 'message' => 'Berhasil Mematikan Promo']);
        }
    }
}