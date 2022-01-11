<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Template_argon
{
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    function plugin_frontend($use = array()) {
        $arr_plugin_frontend = array(
            'bootstrap-datepicker' => array(
                'css' => array(base_url('/assets/plugins/datetimepicker/jquery.datetimepicker')),
                'js' => array(base_url('/assets/plugins/datetimepicker/jquery.datetimepicker.full'))
            ),
            'mask-money' => array(
                'js' => array(
                    base_url('/assets/plugins/mask-money/jquery.maskMoney.min'), 
                ),
            ),
            'chart' => array(
                'js' => array(
                    base_url('/assets/argon/vendor/chart.js/dist/Chart.min'), 
                    base_url('/assets/argon/vendor/chart.js/dist/Chart.extension')
                ),
            ),
            'select2' => array(
                'css' => array(base_url('/assets/argon/vendor/select2/dist/css/select2.min')),
                'js' => array(base_url('/assets/argon/vendor/select2/dist/js/select2.min')),
            ),
            'sweetalert2' => array(
                'css' => array(base_url('/assets/argon/vendor/sweetalert2/dist/sweetalert2.min')),
                'js' => array(base_url('/assets/argon/vendor/sweetalert2/dist/sweetalert2.min')),
            ),
            'pdfmake' => array(
                'js' => array(
                    'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min', 
                    'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts',
                ),
            ),
            'datatable' => array(
                'css' => array(
                    base_url('/assets/argon/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min')
                ),
                'js' => array(
                    base_url('assets/argon/vendor/datatables.net/js/jquery.dataTables.min'),
                    base_url('assets/argon/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min')
                )
            ),
            'datepicker' => [
                'js' => [
                    base_url('assets/argon/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min')
                ]
            ],
            'animate' => [
                'css' => [
                    base_url('assets/argon/vendor/animate.css/animate.min')
                ]
            ],
            'bootstrap-notify' => [
                'js' => [
                    base_url('assets/argon/vendor/bootstrap-notify/bootstrap-notify.min')
                ]
            ]
        );

        $arr_css = array();
        $arr_js = array();

        // $default = ['animate', 'bootstrap-notify'];
        $default = ['sweetalert2'];
        foreach ($default as $v_default) {
            $arr_css = isset($arr_plugin_frontend[$v_default]['css']) ? array_merge($arr_css, $arr_plugin_frontend[$v_default]['css']) : $arr_css;
            $arr_js = isset($arr_plugin_frontend[$v_default]['js']) ? array_merge($arr_js, $arr_plugin_frontend[$v_default]['js']) : $arr_js;
        }

        foreach ($use as $v_use) {
            $arr_css = isset($arr_plugin_frontend[$v_use]['css']) ? array_merge($arr_css, $arr_plugin_frontend[$v_use]['css']) : $arr_css;
            $arr_js = isset($arr_plugin_frontend[$v_use]['js']) ? array_merge($arr_js, $arr_plugin_frontend[$v_use]['js']) : $arr_js;
        }

        return array('css' => $arr_css, 'js' => $arr_js);
    }

    public function generate($content = '', $plugin_frontend = array()) {
        $data['content'] = $content;

        $plugin_frontend = $this->plugin_frontend($plugin_frontend);
        $data = array_merge($data, $plugin_frontend);

        $this->CI->load->view('argon_template', $data);
    }
}
