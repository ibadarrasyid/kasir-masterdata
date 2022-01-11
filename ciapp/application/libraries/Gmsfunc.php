<?php

class Gmsfunc {

    var $db;
    var $CI;
    var $daftar_bulan = array(
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    );
    var $jenis_jabatan = array("Jabatan Struktural", "Jabatan Fungsional Umum", "Jabatan Fungsional Tertentu");
    var $eselon = array("IA", "IB", "IIA", "IIB", "IIIA", "IIIB", "IVA", "IVB", "VA");

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->database();
    }

    function headerData($page = 'home', $title = '') {
        $yMadeit = 2014;
        $yearMade = (date('Y') > $yMadeit) ? "$yMadeit - " . date('Y') : $yMadeit;
        $minified = ($this->CI->input->cookie('minified') == 'ok') ? 'minified' : '';
        $bdyhdnMenu = ($this->CI->input->cookie('hdnmenu') == 'ok') ? 'hidden-menu' : '';
        $infodaerah = $this->getInfoDaerah();
        $subleft = 'Sebagai ';
        if ($this->CI->session->userdata('tsk_type') < 2) {
            $spanlogin = $this->CI->session->userdata('tsk_username');
            $subleft .= ($this->CI->session->userdata('tsk_type') == 0) ? 'Admin' : 'Sub Admin';
        } else {
            $spanlogin = $this->CI->session->userdata('tsk_username');
            $subleft .= 'Pegawai';
        }
        $imglogin = $this->CI->session->userdata('tsk_usrfoto'); //config_item('img') . 'default.jpg';
        $dtHeader = array(
            'no_main_header' => true,
            'page_title' => ucfirst($title),
            'page_css' => array(),
            'page_body_prop' => array("class" => "no-skin"),
            // 'info' => $infodaerah,
            'yearMade' => $yearMade,
            'spanlogin' => $spanlogin,
            'subLeftTitle' => $subleft,
            'imglogin' => $imglogin,
//            'page_nav' => $this->navlist($page, 0, 1),
            'page_nav' => $this->navlist($page, 0, $this->CI->session->userdata('tsk_type')),
//            'isLogin' => ($this->CI->session->has_userdata('skp_user')) ? TRUE : FALSE,
            'hdr_name' => $this->CI->session->userdata('tsk_username'),
            'version' => $this->CI->config->item('version'),
//            'hdrlogo' => $headerLogo
        );
        return $dtHeader;
    }

    function selectYear($selected = '', $data = array(name => 'periode', id => 'periode', 'class' => 'form-control')) {
        $select = "<select " . implode(' ', array_map(function($attr, $value) {
                            return $attr . '="' . $value . '"';
                        }, array_keys($data), $data)) . ">";
        $year = 2014;
        for ($i = date('Y'); $i >= $year; $i--) {
            $val = $i;
            $sel = ($selected == $val) ? 'selected' : '';
            $select .= "<option value='$val' $sel>$val</option>";
        }
        $select .= '</select>';
        return $select;
    }

    function getYearPeriod($bulan, $periode) {
        $prd = explode('/', $periode);
        $info = $this->getInfoDaerah();
        $blnAwal = explode('-', $info['awalperiode']);
        if ($bulan <= 12 AND $bulan >= $blnAwal[0]) {
            return $prd[0];
        } else {
            return $prd[1];
        }
    }

    function useCurl($url, $isPost = false, $data = array(), $header = array(), $verbose = false) {
        if ($verbose) {
            ob_start();
            $out = fopen('php://output', 'w');
        }
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
        ));
        if (count($header) > 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        if ($isPost) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        if ($verbose) {
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_STDERR, $out);
        }
        $return = curl_exec($ch);        
        if ($verbose) {
            fclose($out);
            $debug = ob_get_clean();
            echo $debug;
        }
        curl_close($ch);
        return $return;
    }

    /**
     * List icon font-Awesome
     * @return array with index label and data contains icon's of name ex : fa-home, fa-archive
     */
    function listIcon() {
        $icon = array();

        $icon[] = array('label' => 'General Icon',
            'data' => array('fa-500px', 'fa-address', 'fa-adjust', 'fa-adn', 'fa-align', 'fa-amazon', 'fa-ambulance', 'fa-american', 'fa-anchor', 'fa-android', 'fa-angellist', 'fa-angle', 'fa-apple', 'fa-archive', 'fa-area', 'fa-arrow', 'fa-arrows', 'fa-asl', 'fa-assistive', 'fa-asterisk', 'fa-at', 'fa-audio', 'fa-automobile', 'fa-backward', 'fa-balance', 'fa-ban', 'fa-bandcamp', 'fa-bank', 'fa-bar', 'fa-barcode', 'fa-bars', 'fa-bath', 'fa-bathtub', 'fa-battery', 'fa-bed', 'fa-beer', 'fa-behance', 'fa-bell', 'fa-bicycle', 'fa-binoculars', 'fa-birthday', 'fa-bitbucket', 'fa-bitcoin', 'fa-black', 'fa-blind', 'fa-bluetooth', 'fa-bold', 'fa-bolt', 'fa-bomb', 'fa-book', 'fa-bookmark', 'fa-braille', 'fa-briefcase', 'fa-btc', 'fa-bug', 'fa-building', 'fa-bullhorn', 'fa-bullseye', 'fa-bus', 'fa-buysellads', 'fa-cab', 'fa-calculator', 'fa-calendar', 'fa-camera', 'fa-car', 'fa-caret', 'fa-cart', 'fa-cc', 'fa-certificate', 'fa-chain', 'fa-check', 'fa-chevron', 'fa-child', 'fa-chrome', 'fa-circle', 'fa-clipboard', 'fa-clock', 'fa-clone', 'fa-close', 'fa-cloud', 'fa-cny', 'fa-code', 'fa-codepen', 'fa-codiepie', 'fa-coffee', 'fa-cog', 'fa-cogs', 'fa-columns', 'fa-comment', 'fa-commenting', 'fa-comments', 'fa-compass', 'fa-compress', 'fa-connectdevelop', 'fa-contao', 'fa-copy', 'fa-copyright', 'fa-creative', 'fa-credit', 'fa-crop', 'fa-crosshairs', 'fa-css3', 'fa-cube', 'fa-cubes', 'fa-cut', 'fa-cutlery', 'fa-dashboard', 'fa-dashcube', 'fa-database', 'fa-deaf', 'fa-deafness', 'fa-dedent', 'fa-delicious', 'fa-desktop', 'fa-deviantart', 'fa-diamond', 'fa-digg', 'fa-dollar', 'fa-dot', 'fa-download', 'fa-dribbble', 'fa-drivers', 'fa-dropbox', 'fa-drupal', 'fa-edge', 'fa-edit', 'fa-eercast', 'fa-eject', 'fa-ellipsis', 'fa-empire', 'fa-envelope', 'fa-envira', 'fa-eraser', 'fa-etsy', 'fa-eur', 'fa-euro', 'fa-exchange', 'fa-exclamation', 'fa-expand', 'fa-expeditedssl', 'fa-external', 'fa-eye', 'fa-eyedropper', 'fa-fa', 'fa-facebook', 'fa-fast', 'fa-fax', 'fa-feed', 'fa-female', 'fa-fighter', 'fa-file', 'fa-files', 'fa-film', 'fa-filter', 'fa-fire', 'fa-firefox', 'fa-first', 'fa-flag', 'fa-flash', 'fa-flask', 'fa-flickr', 'fa-floppy', 'fa-folder', 'fa-font', 'fa-fonticons', 'fa-fort', 'fa-forumbee', 'fa-forward', 'fa-foursquare', 'fa-free', 'fa-frown', 'fa-futbol', 'fa-gamepad', 'fa-gavel', 'fa-gbp', 'fa-ge', 'fa-gear', 'fa-gears', 'fa-genderless', 'fa-get', 'fa-gg', 'fa-gift', 'fa-git', 'fa-github', 'fa-gitlab', 'fa-gittip', 'fa-glass', 'fa-glide', 'fa-globe', 'fa-google', 'fa-graduation', 'fa-gratipay', 'fa-grav', 'fa-group', 'fa-h', 'fa-hacker', 'fa-hand', 'fa-handshake', 'fa-hard', 'fa-hashtag', 'fa-hdd', 'fa-header', 'fa-headphones', 'fa-heart', 'fa-heartbeat', 'fa-history', 'fa-home', 'fa-hospital', 'fa-hotel', 'fa-hourglass', 'fa-houzz', 'fa-html5', 'fa-i', 'fa-id', 'fa-ils', 'fa-image', 'fa-imdb', 'fa-inbox', 'fa-indent', 'fa-industry', 'fa-info', 'fa-inr', 'fa-instagram', 'fa-institution', 'fa-internet', 'fa-intersex', 'fa-ioxhost', 'fa-italic', 'fa-joomla', 'fa-jpy', 'fa-jsfiddle', 'fa-key', 'fa-keyboard', 'fa-krw', 'fa-language', 'fa-laptop', 'fa-lastfm', 'fa-leaf', 'fa-leanpub', 'fa-legal', 'fa-lemon', 'fa-level', 'fa-life', 'fa-lightbulb', 'fa-line', 'fa-link', 'fa-linkedin', 'fa-linode', 'fa-linux', 'fa-list', 'fa-location', 'fa-lock', 'fa-long', 'fa-low', 'fa-magic', 'fa-magnet', 'fa-mail', 'fa-male', 'fa-map', 'fa-mars', 'fa-maxcdn', 'fa-meanpath', 'fa-medium', 'fa-medkit', 'fa-meetup', 'fa-meh', 'fa-mercury', 'fa-microchip', 'fa-microphone', 'fa-minus', 'fa-mixcloud', 'fa-mobile', 'fa-modx', 'fa-money', 'fa-moon', 'fa-mortar', 'fa-motorcycle', 'fa-mouse', 'fa-music', 'fa-navicon', 'fa-neuter', 'fa-newspaper', 'fa-object', 'fa-odnoklassniki', 'fa-opencart', 'fa-openid', 'fa-opera', 'fa-optin', 'fa-outdent', 'fa-pagelines', 'fa-paint', 'fa-paper', 'fa-paperclip', 'fa-paragraph', 'fa-paste', 'fa-pause', 'fa-paw', 'fa-paypal', 'fa-pencil', 'fa-percent', 'fa-phone', 'fa-photo', 'fa-picture', 'fa-pie', 'fa-pied', 'fa-pinterest', 'fa-plane', 'fa-play', 'fa-plug', 'fa-plus', 'fa-podcast', 'fa-power', 'fa-print', 'fa-product', 'fa-puzzle', 'fa-qq', 'fa-qrcode', 'fa-question', 'fa-quora', 'fa-quote', 'fa-ra', 'fa-random', 'fa-ravelry', 'fa-rebel', 'fa-recycle', 'fa-reddit', 'fa-refresh', 'fa-registered', 'fa-remove', 'fa-renren', 'fa-reorder', 'fa-repeat', 'fa-reply', 'fa-resistance', 'fa-retweet', 'fa-rmb', 'fa-road', 'fa-rocket', 'fa-rotate', 'fa-rouble', 'fa-rss', 'fa-rub', 'fa-ruble', 'fa-rupee', 'fa-s15', 'fa-safari', 'fa-save', 'fa-scissors', 'fa-scribd', 'fa-search', 'fa-sellsy', 'fa-send', 'fa-server', 'fa-share', 'fa-shekel', 'fa-sheqel', 'fa-shield', 'fa-ship', 'fa-shirtsinbulk', 'fa-shopping', 'fa-shower', 'fa-sign', 'fa-signal', 'fa-signing', 'fa-simplybuilt', 'fa-sitemap', 'fa-skyatlas', 'fa-skype', 'fa-slack', 'fa-sliders', 'fa-slideshare', 'fa-smile', 'fa-snapchat', 'fa-snowflake', 'fa-soccer', 'fa-sort', 'fa-soundcloud', 'fa-space', 'fa-spinner', 'fa-spoon', 'fa-spotify', 'fa-square', 'fa-stack', 'fa-star', 'fa-steam', 'fa-step', 'fa-stethoscope', 'fa-sticky', 'fa-stop', 'fa-street', 'fa-strikethrough', 'fa-stumbleupon', 'fa-subscript', 'fa-subway', 'fa-suitcase', 'fa-sun', 'fa-superpowers', 'fa-superscript', 'fa-support', 'fa-table', 'fa-tablet', 'fa-tachometer', 'fa-tag', 'fa-tags', 'fa-tasks', 'fa-taxi', 'fa-telegram', 'fa-television', 'fa-tencent', 'fa-terminal', 'fa-text', 'fa-th', 'fa-themeisle', 'fa-thermometer', 'fa-thumb', 'fa-thumbs', 'fa-ticket', 'fa-times', 'fa-tint', 'fa-toggle', 'fa-trademark', 'fa-train', 'fa-transgender', 'fa-trash', 'fa-tree', 'fa-trello', 'fa-tripadvisor', 'fa-trophy', 'fa-truck', 'fa-try', 'fa-tty', 'fa-tumblr', 'fa-turkish', 'fa-tv', 'fa-twitch', 'fa-twitter', 'fa-umbrella', 'fa-underline', 'fa-undo', 'fa-universal', 'fa-university', 'fa-unlink', 'fa-unlock', 'fa-unsorted', 'fa-upload', 'fa-usb', 'fa-usd', 'fa-user', 'fa-users', 'fa-vcard', 'fa-venus', 'fa-viacoin', 'fa-viadeo', 'fa-video', 'fa-vimeo', 'fa-vine', 'fa-vk', 'fa-volume', 'fa-warning', 'fa-wechat', 'fa-weibo', 'fa-weixin', 'fa-whatsapp', 'fa-wheelchair', 'fa-wifi', 'fa-wikipedia', 'fa-window', 'fa-windows', 'fa-won', 'fa-wordpress', 'fa-wpbeginner', 'fa-wpexplorer', 'fa-wpforms', 'fa-wrench', 'fa-xing', 'fa-y', 'fa-yahoo', 'fa-yc', 'fa-yelp', 'fa-yen', 'fa-yoast', 'fa-youtube')
        );
        $icon[] = array('label' => 'Currency Icons',
            'data' => array('fa-bitcoin', 'fa-btc', 'fa-cny', 'fa-dollar', 'fa-eur', 'fa-euro', 'fa-gbp', 'fa-inr', 'fa-jpy', 'fa-krw', 'fa-money', 'fa-rmb', 'fa-rouble', 'fa-rub', 'fa-ruble', 'fa-rupee', 'fa-try', 'fa-turkish-lira', 'fa-usd', 'fa-won', 'fa-yen')
        );
        $icon[] = array('label' => 'Text Editor Icons',
            'data' => array('fa-align-center', 'fa-align-justify', 'fa-align-left', 'fa-align-right', 'fa-bold', 'fa-chain', 'fa-chain-broken', 'fa-clipboard', 'fa-columns', 'fa-copy', 'fa-cut', 'fa-dedent', 'fa-eraser', 'fa-file', 'fa-file-o', 'fa-file-text', 'fa-file-text-o', 'fa-files-o', 'fa-floppy-o', 'fa-font', 'fa-indent', 'fa-italic', 'fa-link', 'fa-list', 'fa-list-alt', 'fa-list-ol', 'fa-list-ul', 'fa-outdent', 'fa-paperclip', 'fa-paste', 'fa-repeat', 'fa-rotate-left', 'fa-rotate-right', 'fa-save', 'fa-scissors', 'fa-strikethrough', 'fa-table', 'fa-text-height', 'fa-text-width', 'fa-th', 'fa-th-large', 'fa-th-list', 'fa-underline', 'fa-undo', 'fa-unlink')
        );
        $icon[] = array('label' => 'Directional icons',
            'data' => array('fa-angle-double-down', 'fa-angle-double-left', 'fa-angle-double-right', 'fa-angle-double-up', 'fa-angle-down', 'fa-angle-left', 'fa-angle-right', 'fa-angle-up', 'fa-arrow-circle-down', 'fa-arrow-circle-left', 'fa-arrow-circle-o-down', 'fa-arrow-circle-o-left', 'fa-arrow-circle-o-right', 'fa-arrow-circle-o-up', 'fa-arrow-circle-right', 'fa-arrow-circle-up', 'fa-arrow-down', 'fa-arrow-left', 'fa-arrow-right', 'fa-arrow-up', 'fa-caret-down', 'fa-caret-left', 'fa-caret-right', 'fa-caret-square-o-down', 'fa-caret-square-o-left', 'fa-caret-square-o-right', 'fa-caret-square-o-up', 'fa-caret-up', 'fa-chevron-circle-down', 'fa-chevron-circle-left', 'fa-chevron-circle-right', 'fa-chevron-circle-up', 'fa-chevron-down', 'fa-chevron-left', 'fa-chevron-right', 'fa-chevron-up', 'fa-hand-o-down', 'fa-hand-o-left', 'fa-hand-o-right', 'fa-hand-o-up', 'fa-long-arrow-down', 'fa-long-arrow-left', 'fa-long-arrow-right', 'fa-long-arrow-up', 'fa-toggle-down', 'fa-toggle-left', 'fa-toggle-right', 'fa-toggle-up')
        );
        $icon[] = array('label' => 'Video Player icons',
            'data' => array('fa-backward', 'fa-eject', 'fa-fast-backward', 'fa-fast-forward', 'fa-forward', 'fa-arrows-alt', 'fa-pause', 'fa-play', 'fa-play-circle', 'fa-play-circle-o', 'fa-expand', 'fa-compress', 'fa-step-backward', 'fa-step-forward', 'fa-stop', 'fa-youtube-play')
        );
        $icon[] = array('label' => 'Brands icons',
            'data' => array('fa-adn', 'fa-android', 'fa-apple', 'fa-bitbucket', 'fa-bitbucket-square', 'fa-bitcoin', '(alias)', 'fa-btc', 'fa-css3', 'fa-dribbble', 'fa-dropbox', 'fa-facebook', 'fa-facebook-square', 'fa-flickr', 'fa-foursquare', 'fa-github', 'fa-github-alt', 'fa-github-square', 'fa-gittip', 'fa-google-plus', 'fa-google-plus-square', 'fa-html5', 'fa-instagram', 'fa-linkedin', 'fa-linkedin-square', 'fa-linux', 'fa-maxcdn', 'fa-pagelines', 'fa-pinterest', 'fa-pinterest-square', 'fa-renren', 'fa-skype', 'fa-stack-exchange', 'fa-stack-overflow', 'fa-trello', 'fa-tumblr', 'fa-tumblr-square', 'fa-twitter', 'fa-twitter-square', 'fa-vimeo-square', 'fa-vk', 'fa-weibo', 'fa-windows', 'fa-xing', 'fa-xing-square', 'fa-youtube', 'fa-youtube-play', 'fa-youtube-square')
        );
        $icon[] = array('label' => 'Medical icons',
            'data' => array('fa-ambulance', 'fa-h-square', 'fa-hospital-o', 'fa-medkit', 'fa-plus-square', 'fa-stethoscope', 'fa-user-md', 'fa-wheelchair')
        );
        return $icon;
    }

    /**
     * Untuk mendapatkan info daerah Seperti nama kepala daerah, nama daerah
     * @return array index dari table eva_sys kolom sys_id dengan menghilangkan prefix inf_
     */
    function getInfoDaerah() {
        $info = $this->CI->db->get_where("tsk_sys", array('sys_what' => 'info'));
        $infoo = array();
        foreach ($info->result() as $value) {
            $index = str_replace('inf_', '', $value->sys_id);
            $infoo[$index] = $value->sys_value;
        }
        return $infoo;
    }

    function getSystemInfo() {
        $info = $this->CI->db->get_where("tsk_sys", array('sys_what' => 'system'));
        $infoo = array();
        foreach ($info->result() as $value) {
            $index = $value->sys_id;
            $infoo[$index] = $value->sys_value;
        }
        return $infoo;
    }

    function getNewID($namatable, $column) {
        $this->CI->db->select_max($column);
        $max = $this->CI->db->get($namatable);
        if ($max->num_rows() > 0) {
            $row = $max->row_array();
            return $row[$column] + 1;
        } else {
            return 1;
        }
    }

    /**
     * Create thumbnail inside folder $updir
     * @param type $updir
     * @param type $img nama file image asli
     */
    function makeThumbnails($updir, $img) {
        $thumbnail_width = 150; //134;
        $thumbnail_height = 150; //189;
        $arr_image_details = getimagesize("$updir" . "$img"); // pass id to thumb name
        $original_width = $arr_image_details[0];
        $original_height = $arr_image_details[1];
        if ($original_width > $original_height) {
            $new_width = $thumbnail_width;
            $new_height = intval($original_height * $new_width / $original_width);
        } else {
            $new_height = $thumbnail_height;
            $new_width = intval($original_width * $new_height / $original_height);
        }
        $dest_x = intval(($thumbnail_width - $new_width) / 2);
        $dest_y = intval(($thumbnail_height - $new_height) / 2);
        if ($arr_image_details[2] == 1) {
            $imgt = "ImageGIF";
            $imgcreatefrom = "ImageCreateFromGIF";
        }
        if ($arr_image_details[2] == 2) {
            $imgt = "ImageJPEG";
            $imgcreatefrom = "ImageCreateFromJPEG";
        }
        if ($arr_image_details[2] == 3) {
            $imgt = "ImagePNG";
            $imgcreatefrom = "ImageCreateFromPNG";
        }
        if ($imgt) {
            $old_image = $imgcreatefrom("$updir" . '/' . "$img");
            $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
            imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
            if (!file_exists("$updir" . "/thumb/")) {
                mkdir("$updir" . "/thumb/");
            }
            $imgt($new_image, "$updir" . "/thumb/$img");
        }
    }

    function romawiToNumeric($angkaromawi) {
        $romans = array(
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1,
        );
        $roman = strtoupper($angkaromawi);
        $result = 0;

        foreach ($romans as $key => $value) {
            while (strpos($roman, $key) === 0) {
                $result += $value;
                $roman = substr($roman, strlen($key));
            }
        }
        return $result;
    }

    /**
     * Mendapatkan list jenis jabatan berdasarkan modul.
     * @param String $modul default '', diisi detail atau non detail diambil dari tsk_sys
     * @return array indeks 
     * modul = modul aktif <br/> 
     * data = jika <strong>modul<strong>nondetail</strong> : index => id jnsjab, value => alias</br>
     * modul <strong>detail</strong> : index=> id_detailjnsjab, value array[nama,jnsid,eselon,alias,kelompok,kodeKelompok]
     */
    function getJnsJab($modul = '') {
        $arrRet = array();
        if ($modul == '') {
            $data = $this->getSystemInfo();
            $modul = $data['jenis_jabatan'];
        }
        if ($modul == 'detail') {
            $det = $this->CI->db->order_by('jnsdetail_id')->get('spg_jenisjabdetail');
            foreach ($det->result() as $det_) {
                $arrRet[$det_->jnsdetail_id] = array('nama' => $det_->jnsdetail_nama,
                    'jnsid' => $det_->jns_id,
                    'eselon' => $det_->jnsdetail_eselon,
                    'alias' => $det_->jnsdetail_alias,
                    'kelompok' => $det_->kelompokjabatan,
                    'kodeKelompok' => $det_->kode_kelompokjab);
            }
        } else {
            $det = $this->CI->db->order_by('jns_alias')->get('spg_jenisjab');
            foreach ($det->result() as $det_) {
                $arrRet[$det_->jns_id] = $det_->jns_alias;
            }
        }
        return array('modul' => $modul, 'data' => $arrRet);
    }

    function startsWith($haystack, $needle) {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }

    function endsWith($haystack, $needle) {
        // search forward starting from end minus needle length characters
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    function splitNjoin($string, $split = '.', $glue = '') {
        $exp = explode($split, $string);
        return implode($glue, $exp);
    }

    function nbsp($str) {
        if ($str == '' or $str == '0' or ( strlen($str) < 1))
            return '&nbsp;';
        return $str;
    }

    function removeNewline($string) {
        $string = str_replace("\n", "", $string);
        $string = str_replace("\r", "", $string);
        return $string;
    }

    /**
     * Data list Urusan Data
     * @return Array xx = Non Urusan ; 1 = Urusan wajib ; 2 = Urusan Pilihan; 3 = Belanja Tidak Langsung
     */
    function getUrusanData() {
        return array(
            "xx" => "Non Urusan",
            "1" => "Urusan Wajib",
            "2" => "Urusan Pilihan",
            "3" => "Belanja Tidak Langsung"
        );
    }

    /**
     * Show Month's Names in Indonesian
     * @param Integer $index Start from 1 it's mean Januari
     * @return String  nama bulan in Indonesian
     */
    function getBulan($index) {
        return $this->daftar_bulan[$index - 1];
    }

    /**
     * Get number of month in a year, ex 1 for Januari.
     * @param String Month's name with first letter in uppercase, Month's name in indonesian ex: Januari
     * @return mixed if the word is found return number of The month, False Otherwise
     */
    function getBulanInNumber($namaBulan) {
        $nama = ucfirst($namaBulan);
        $s = array_search($nama, $this->daftar_bulan);
        $blnKe = ($s) ? $s + 1 : $s;
        return $blnKe;
    }

    /**
     * Fungsi untuk mencari data dari array multidimensi 2 dimensi / level, Ex : array dari fungsi get_datas,<br/>
     * Jika kolom NUll maka array dianggap 1 level
     * @param Array $array
     * @param String $kolom
     * @param String $stringToFind
     * @return boolean TRUE jika data ditemukan, FALSE otherwise
     */
    function searchArrayValue($array, $stringToFind, $kolom = NULL) {
        $return = FALSE;
        foreach ($array as $value) {
            echo "tes : " . $value . "<br/>";
            if (is_null($kolom) OR empty($kolom)) {
                if ($value == $stringToFind) {
                    $return = TRUE;
                    break;
                }
            } else {
                if ($value[$kolom] == $stringToFind) {
                    $return = TRUE;
                    break;
                }
            }
        }
        return $return;
    }

    /**
     *
     * @param integer $num
     * @param Character $mime ex:&nbsp;
     * @param boolean $print True, jika inigin meng-echo character, flase otherwise
     * @return String Character
     */
    function spaceIter($num = 0, $mime = '&nbsp;', $print = false) {
        for ($loop = 0; $loop < $num; $loop++)
            $space.=$mime;
        if ($print)
            echo $space;
        else
            return $space;
    }

    /**
     * Mengembalikan string format tanggal.
     * @param type $date input tanggal type string dgn format dd mm yyyy Atau yyyy mm dd
     * @param type $splitChar karakter pemisah di tanggal
     * @param type $flip boolean, true untuk format dd mm yyyy -> yyyy mm dd (toDb) , false untuk format yyyy mm dd -> dd mm yyyy (from db)
     * @return string Tanggal
     */
    function format_tglSimpan($date, $splitChar = '-', $flip = TRUE) {
        $tt = '';
        if ($flip) {
            $tgl = explode($splitChar, $date);
            $tt = $tgl[2] . '-' . $tgl[1] . '-' . $tgl[0];
        } else {
            $tgl = explode('-', $date);
            $tt = $tgl[2] . $splitChar . $tgl[1] . $splitChar . $tgl[0];
        }
        return $tt;
    }

    function stripIfEmpty($var, $rp = null, $ext = NULL) {
        if (empty($var) OR $var == "" OR $var == '0') {
            return "-";
        } else {
            return $rp . "&nbsp;" . $var . $ext;
        }
    }

    function noquots($str) {
        $str = str_replace("'", '&#39;', $str);
        $str = str_replace('"', '&#34;', $str);
        $str = $this->removeNewline($str);
        $sstr = htmlentities($str);
        $ssstr = htmlspecialchars($sstr);
        return trim($ssstr);
    }

    function removeQuote($var) {
        $varchar = str_replace("'", '', $var);
        $varMid = str_replace('"', '', $varchar);
        $str = $this->removeNewline($varMid);
        $varEnd = htmlentities($str);
        return trim($varEnd);
    }

    /**
     * Menghilangkan spasi dengan trim function dan karakter ' ' (spasi) dan karakter nbsp;
     * @param String $var String kata
     * @return String
     */
    function removeSpace($var) {
        $va = trim($var);
        $vva = str_replace(" ", '', $va);
        $vvv = str_replace("&nbsp;", '', $vva);
        return $vvv;
    }

    function jikaKosong($String, $char = '-') {
        $kata = (empty($String) OR ( $String == '')) ? $char : $String;
        return $kata;
    }

    function persencapaian($target, $capaian) {
        if ($target > 0) {
            $hasil = ($capaian * 100) / $target;
            return $hasil;
        } else {
            return 0;
        }
    }

    function PotonganMenit($ttp, $menit) {
        return $ttp / $menit;
    }

    function Bulan2Menit($thn, $bln, $harikerja) {
        $M = $bln;
        $Y = $thn;
        $hk = $harikerja;
        if (!isset($GLOBALS['DAYS'])) {
            // can load from db or manual
            $Days['5hk'] = array(
                'Sun' => 0,
                'Mon' => 8,
                'Tue' => 8,
                'Wed' => 8,
                'Thu' => 8,
                'Fri' => 5.5,
                'Sat' => 0
            );
            $Days['6hk'] = array(
                'Sun' => 0,
                'Mon' => 7,
                'Tue' => 7,
                'Wed' => 7,
                'Thu' => 7,
                'Fri' => 4,
                'Sat' => 5.5
            );
            $GLOBALS['DAYS'] = $Days;
        }
        $libur = $this->Liburs($Y, $M);
        $liburs = explode(',', $libur);
        $Days = $GLOBALS['DAYS'];
        $jam = 0;

        $nmonth = cal_days_in_month(CAL_GREGORIAN, $M, $Y);
        if (strlen($M) == 1)
            $M = '0' . $M;
        $xxx = 1;
        for ($x = 1; $x <= $nmonth; $x++) {
            $xx = $x;
            if (strlen($xx) == 1)
                $xx = '0' . $xx;

            $s = "$xx/$M/$Y";
            $t = strtotime("$Y-$M-$xx");
            $d = date('D', $t);
            if (!in_array($s, $liburs)) {
                $jam += $Days[$hk][$d];
                $xxx++;
            }
        }
        $tot = $jam * 60; // jam * 60 menit
        return $tot;
    }

    /**
     * Fungsi untuk mendapatkan urutan hari dalam angka
     * @param String $date input data tanggal dengan format YYYY-MM-dd ex : 2012-5-25
     * @return Integer hari dalam angka dimulai hari Minggu = 0 sabtu = 6
     */
    function getDayonWeek($date) {
        $ddate = explode('-', $date);
        $time = mktime(0, 0, 0, abs($ddate[1]), abs($ddate[2]), abs($ddate[0]));
        return date('w', $time);
    }

    /**
     * Untuk ngecek apakah tanggal yang dimasukkan termasuk dari tanggal merah yang telah disetting di database.
     * @param String $listRed String list tanggal merah yang telah ditentukan pada setting menu hari libur, dengan format dd/mm/yyyy,dd/mm/yyyy .
     * Setiap tanggal merah harus dipisahkan dengan ',' (koma)
     * @param int $currentDate tanggal sekarang, hanya tanggal. dd
     * @return boolean TRUE if currentDate include from redDate, FALSE otherwise
     */
    function isRedDate($listRed, $currentDate) {
        $merah = FALSE;
//        echo $listRed;
        if (!empty($listRed)) {
            $redlist = (strpos(",", $listRed)) ? $listRed . "," : $listRed;
            $list = explode(",", $redlist);
            $tglMrh = array();
            for ($i = 0; $i < count($list); $i++) {
                $mrh = explode("/", $list[$i]);
                $tglMrh [$i] = $mrh[0];
            }

            $mrh = (array_search($currentDate, $tglMrh)) ? TRUE : $merah;
        }
        return $merah;
    }

    /**
     * Untuk mendapatkan jenis nama kepala daerah ex : Menteri (Kementrian), Walikota (Kota), Gubernur (Propinsi)
     * @param String $daerah Nama Daerah, default nya ''
     * @return String Jenis Nama Kepala daerah, mengembalikan nilai nbsp jika tidak ada parameter
     */
    function namaKepalaDaerah($daerah = '') {
        switch (strtolower($daerah)) {
            case 'kementrian':
                return 'menteri';
                break;
            case 'kota':
                return 'walikota';
                break;
            case 'propinsi':
                return 'gubernur';
                break;
            case 'kabupaten':
                return 'bupati';
                break;
            default:
                return '&nbsp;';
                break;
        }
    }

    /**
     * Fungsi ini hampir sama dengan fungsi dari php array_search(). Tapi dalam beberapa keadaan jika menggunakan fungsi tersebut beberapa data tidak tidak berfungsi.
     * @param String $text NIlai yang akan dicari di dalam array
     * @param Array $arr array satu dimensi
     * @return boolean Mengembalikan nilai TRUE jika data ditemukan. FALSE otherwise
     */
    function arr_search($text, $arr) {
        $rtn = false;
        foreach ($arr as $value) {
            if ($value == $text) {
                $rtn = true;
                break;
            }
        }
        return $rtn;
    }

    /**
     * Pastikan untuk memanggil fungsi openDb
     * Fungsi untuk menampilkan menu.<br/>
     *  array $explv 'name','parent','href','class','title','id','base','idm'
     * @global integer $explc Index global
     * @global array $explv
     * @param integer $parent Induk Menu, untuk list menu di awali dengan 0
     * @param integer $idakses id akses dari account 1 : admin; 2 : subadmin
     * @param integer $base Untuk melihat level dari child
     */
    function navlist($page, $parent = 0, $idakses = 0, $isChild = false) {
        $explv = array();
        $query = $this->CI->db->query("SELECT mnu_id,mnu_parent,mnu_nama,mnu_title,mnu_class,mnu_idtag,mnu_href
           FROM tsk_menu, tsk_menuakses WHERE mnu_id = mks_id_menu and mnu_parent =$parent and mks_akses = $idakses ORDER BY mnu_urut  ");
        if ($idakses == 1) {
            $iduser = $this->CI->session->userdata('tsk_userid');
            $cek = $this->CI->db->select('m.mnu_id,mnu_parent,mnu_nama,mnu_title,mnu_class,mnu_idtag,mnu_href')
                            ->from('tsk_menu m')->join("tsk_menusubadmin ms", 'ms.mnu_id = m.mnu_id')
                            ->where(array('ms.as_user_id' => $iduser, 'mnu_parent' => $parent))
                            ->order_by('mnu_urut')->get();
            if ($cek->num_rows() > 0) {
                $query = $cek;
            }
        }
        foreach ($query->result_array() as $key => $value) {
            $arrProp = array(
                "name" => $value['mnu_nama'],
                "title" => $value['mnu_title'],
                "url" => base_url($value['mnu_href']),
                "id" => $value['mnu_idtag'],
                "icon" => $value['mnu_class'],
                "idm" => $value['mnu_id']
            );
            if (strtolower($value['mnu_href']) == strtolower($this->CI->uri->segment(1)) ||
                    ($page == strtolower($value['mnu_href'])) ||
                    (($this->CI->input->get('jns')) && (strtolower($value['mnu_href']) == strtolower(
                            $this->CI->uri->segment(1) . '?jns=' . $this->CI->input->get('jns'))))) {
                $arrProp['active'] = 'class = "active parentSelected"';
                if ($isChild) {
                    $arrProp['parentSelected'] = 'class = "active open chSelected"';
                }
            }


            if (!$isChild) {
                $arrProp["sub"] = $this->navlist($page, $value['mnu_id'], $idakses, true);
            } else { // ngecek jika arra adalah child.. cara ini hanya berlaku sampe child level 1
                $navch = $this->navlist($page, $value['mnu_id'], $idakses, true);
                if (isset($navch['parentSelected'])) {
                    $arrProp['active'] = $navch['parentSelected'];
                }
                $arrProp['sub'] = $navch;
            }
            if (empty($value['mnu_class'])) {
                unset($arrProp['icon']);
            }
            if (empty($value['mnu_idtag'])) {
                unset($arrProp['id']);
            }
            if (empty($value['mnu_href'])) {
                unset($arrProp['url']);
            }
            if (count($arrProp['sub']) == 0) {
                unset($arrProp['sub']);
            }

            $explv[$value['mnu_nama']] = $arrProp;
        }
        return $explv;
    }

    /**
     * List jabatan per OPD. Mengembalikan data berupa assosiative array. Dengan default kolom
     * <strong>kode_jabatan,nama_jabatan,parent_jabatan,jns_id,jns_alias as jenisjab,eselon,id_uniteselon,nama_unit,kode_alias,is_sekretaris,kodeja_parent</strong>
     * @param integer $idskpd id OPD
     * @param array $where array untuk fungsi where di sql.
     * @param boolean $showSubUnit menampilkan sub unit atau tidak. Default FALSE
     * @param array $newColumn kolom baru yang akan ditampilkan. array('colA','colB'=>'tesCol', 'colC') akan menampilkan 'colA,colB as tesCol, colC'
     * @return array 
     */
    function listJab($idskpd, $where = array(), $showSubUnit = false, $newColumn = array()) {
        $colDefault = 'j.nama_jabatan, j.kode_jabatan, j.parent_jabatan, v.jns_id, 
v.jnsdetail_nama as jenisjab, v.eselon, v.id_uniteselon, v.split_kodejab, 
v.nama_unit, v.is_sekretaris';
        $colNewStr = array();
        foreach ($newColumn as $in => $col) {
            $colNewStr [] = (is_string($in)) ? $in . ' as ' . $col : $col;
        }
        $colDefault .= ',' . implode(',', $colNewStr);

        $this->CI->db->select($colDefault)
                ->from('jabatan_v v')->join('spg_jabatan j', 'v.kode_jabatan = j.kode_jabatan')->where('v.id_opd', $idskpd);
        if (count($where) > 0) {
            $this->CI->db->where($where);
        }
        $query = $this->CI->db->get();
        global $arrOri;
        global $scnArr;
        global $remArr;
        $arrOri = $scnArr = $remArr = array();
        $no = 0;
        $parent = array();
        foreach ($query->result_array() as $vq) {
            $arrOri[$no]['nama'] = $vq['nama_jabatan'];
            $arrOri[$no]['kode'] = $vq['kode_jabatan'];
            $arrOri[$no]['parent'] = $vq['parent_jabatan'];
            $arrOri[$no]['alias'] = $vq['kode_alias'];
            $arrOri[$no]['sekretaris'] = $vq['is_sekretaris'];
            $arrOri[$no]['jnsjab'] = $vq['jenisjab'];
            $arrOri[$no]['jns'] = $vq['jns_id'];
            $arrOri[$no]['eselon'] = $vq['eselon'];
            $arrOri[$no]['idunit'] = $vq['id_uniteselon'];
            $arrOri[$no]['split'] = $vq['split_kodejab'];
            $arrOri[$no]['unit'] = $vq['nama_unit'];
            foreach ($newColumn as $in => $c) {
                $idx = $c;
                $c = strpos($c, '.') ? substr($c, strpos($c, '.') + 1) : $c;
                if (!is_string($in)) {
                    $idx = $c;
                }
                $arrOri[$no][$idx] = $vq[$c];
            }
            $no++;
        }
        if ($showSubUnit) {
            $this->CI->db->select($colDefault)
                    ->from('jabatan_v v')->join('spg_jabatan j', 'v.kode_jabatan = j.kode_jabatan')->join('spg_unitkerja u', 'u.id_unitkerja = v.id_unitkerja')->where('u.sub_unitkerja', $idskpd);
            if (count($where) > 0) {
                $this->CI->db->where($where);
            }
            $query = $this->CI->db->get();
            foreach ($query->result_array() as $vq) {
                $arrOri[$no]['nama'] = $vq['nama_jabatan'];
                $arrOri[$no]['kode'] = $vq['kode_jabatan'];
                $arrOri[$no]['parent'] = $vq['parent_jabatan'];
                $arrOri[$no]['alias'] = $vq['kode_alias'];
                $arrOri[$no]['sekretaris'] = $vq['is_sekretaris'];
                $arrOri[$no]['jnsjab'] = $vq['jenisjab'];
                $arrOri[$no]['jns'] = $vq['jns_id'];
                $arrOri[$no]['eselon'] = $vq['eselon'];
                $arrOri[$no]['idunit'] = $vq['id_uniteselon'];
                $arrOri[$no]['unit'] = $vq['nama_unit'];
                $arrOri[$no]['split'] = $vq['split_kodejab'];
                $arrOri[$no]['subunit'] = $showSubUnit;
                if ($vq['parent_jabatan'] == 0) {
                    $arrOri[$no]['parent'] = $vq['kodeja_parent'];
                }
                foreach ($newColumn as $in => $c) {
                    $idx = $c;
                    $c = strpos($c, '.') ? substr($c, strpos($c, '.') + 1) : $c;
                    if (!is_string($in)) {
                        $idx = $c;
                    }
                    $arrOri[$no][$idx] = $vq[$c];
                }
                $no++;
            }
        }
        $cekParent = array();
        foreach ($arrOri as $vp) { // perulanangan untuk mengambil data parent
            if (!in_array($vp['parent'], $cekParent)) {
                array_push($cekParent, $vp['parent']);
            }
        }
        // inisialisasi data parent sebelum pengurutan
        foreach ($cekParent as $cekParent_) {
            $key_find = array_search($cekParent_, array_column($arrOri, 'kode')); // search array multidimensi by value
            $vp = $arrOri[$key_find];
            if (!empty($vp['split'])) {
                $_ex = explode('-', $vp['split']);
                $u = end($_ex); // get KIJ jika split kodejab sudah disetting
            } else {
                $u = $vp['parent'];
            }
            $arrParent_ = array('kode' => $vp['parent'], 'u' => $u);
            array_push($parent, $arrParent_);
        }
        $u_ = array_column($parent, 'u');
        array_multisort($u_, SORT_ASC, $parent);
        $base = 0;
        foreach ($parent as $vpar) {
            $this->findJab($vpar['kode'], $base);
            $base++;
            break;
        }
        foreach ($remArr as $vr) {
            unset($arrOri[$vr]);
        }
        if (count($arrOri) > 0) {
            foreach ($arrOri as $vor) {
                $vor['base'] = 0;
                array_push($scnArr, $vor);
            }
        }
        return $scnArr;
    }

    function findJab($parent, $base) {
        global $arrOri;
        global $scnArr;
        global $remArr;
        $childArr = array();
        foreach ($arrOri as $kk => $vor) {
            if ($vor['parent'] == $parent && $parent != $vor['kode']) {
                if (!empty($vor['split'])) {
                    $_ex = explode('-', $vor['split']);
                    $u = end($_ex); // get KIJ jika split kodejab sudah disetting
                } else {
                    $u = $vor['kode'];
                }
                $vor['u_child'] = $u;
                $childArr[] = $vor;
                $remArr[] = $kk;
            }
        }

        if (count($childArr) > 0) {
            $u_child = array_column($childArr, 'u_child');
            array_multisort($u_child, SORT_ASC, $childArr);
            foreach ($childArr as $vChild) {
                $vChild['base'] = $base;
                array_push($scnArr, $vChild);
                $base++;
                $this->findJab($vChild['kode'], $base);
                $base--;
            }
        }
    }

    // Perhitungan ABK
    var $EFEKTIF = 5; //BKN 
    var $EFEKTIF_MEN = 5.5; //Permendagri 

    function standar($periode, $rule = 'BKN') {
        $efektif = ($rule == 'BKN') ? $this->EFEKTIF : $this->EFEKTIF_MEN;
        $ts = 0;
        if ($periode == 'hari') {
            $ts = $efektif * 60;      // waktu efektif * 60 menit
        } else if ($periode == 'minggu') {
            $ts = $efektif * 60 * 5;  //  waktu efektif * 60 menit * 5 hari
        } else if ($periode == 'bulan') {
            $ts = $efektif * 60 * 5 * 4;  //  waktu efektif * 60 menit * 5 hari * 4 minggu
        } else if ($periode == 'tahun') {
            $ts = $efektif * 60 * 5 * 4 * 12;  //  waktu efektif * 60 menit * 5 hari * 4 minggu * 12 bulan
        } else {
            return null;
        }
        return number_format($ts, 0, ',', '.');
    }

    // Fungsi Untuk Bezzeting Kebutuhan
    function bk($normawaktu, $volumekerja, $periode, $rule = 'BKN') {
        $ts = $this->getJamKerjaEfektif($periode, $rule);
        return round(($normawaktu * $volumekerja) / $ts, 4);
    }

    function getJamKerjaEfektif($periode, $rule = 'BKN') {
        $efektif = ($rule == 'BKN') ? $this->EFEKTIF : $this->EFEKTIF_MEN;
        $ts = 0;
        $conv = ($rule == 'BKN') ? 60 : 1;
        if ($periode == 'hari') {
            $ts = $efektif * $conv;      // waktu efektif * 60 menit
        } else if ($periode == 'minggu') {
            $ts = $efektif * $conv * 5;  //  waktu efektif * 60 menit * 5 hari
        } else if ($periode == 'bulan') {
            $ts = $efektif * $conv * 5 * 4;  //  waktu efektif * 60 menit * 5 hari * 4 minggu
        } else if ($periode == 'tahun') {
            $ts = $efektif * $conv * 5 * 4 * 12;  //  waktu efektif * 60 menit * 5 hari * 4 minggu * 12 bulan
        } else {
            return 0;
        }
        return $ts;
    }

    function volStandar($n, $periode) {
        $t = 0;
        if ($periode == 'hari') {
            $t = $n * 5 * 4 * 12; // 5 hari, 4 minggu, 12 bulan  => 240 hari efektif
        } else if ($periode == 'minggu') {
            $t = $n * 12 * 4; //* 12 bulan * 4 minggu
        } else if ($periode == 'bulan') {
            $t = $n * 12;     //* 12 bulan
        } else if ($periode == 'tahun') {
            $t = $n;
        } else {
            $t = NULL;
        }
        return $t;
    }

    function m2hy($m, $periode) {
        $h = 0;
        if ($periode == 'hari') {
            $h = ($m * 12 * 4 * 5) / 60; //* 12 bulan * 4 minggu * 5 hari
        } else if ($periode == 'minggu') {
            $h = ($m * 12 * 4) / 60;   //* 12 bulan * 4 minggu
        } else if ($periode == 'bulan') {
            $h = ($m * 12) / 60;     //* 12 bulan
        } else if ($periode == 'tahun') {
            $h = $m / 60;          //stahun
        } else {
            return null;
        }
        return $h;
    }

    function tomenit($num, $sat, $rule = 'BKN') {
        $efektif = ($rule == 'BKN') ? $this->EFEKTIF : $this->EFEKTIF_MEN;
        $out = '';
        if ($sat == 'menit') {
            $out = $num;
        } else if ($sat == 'jam') {
            $out = $num * 60;
        } else if ($sat == 'hari') {
            $out = $num * 60 * $efektif;
        } else if ($sat == 'minggu') {
            $out = $num * 60 * $efektif * 5;
        } else if ($sat == 'bulan') {
            $out = $num * 60 * $efektif * 5 * 4;
        } else {
            return null;
        }
        return $out;
    }

    //norma waktu 
    function menittostandar($n, $sat, $rule = 'BKN') {
        $efektif = ($rule == 'BKN') ? $this->EFEKTIF : $this->EFEKTIF_MEN;
        $out = '';
        if ($sat == 'menit') {
            $out = $n;
        } else if ($sat == 'jam') {
            $out = $n / 60;
        } else if ($sat == 'hari') {
            $out = $n / (60 * $efektif);
        } else if ($sat == 'minggu') {
            $out = $n / (60 * $efektif * 5);
        } else if ($sat == 'bulan') {
            $out = $n / (60 * $efektif * 5 * 4);
        } else {
            return null;
        }
        return $out;
    }

    function analisa($kodeja) {
        $result = array();
        $abk = $this->CI->db->from('spg_abk')
                ->where(array('kode_jabatan' => $kodeja))
                ->get()
                ->row_array();
        $uraian = $this->CI->db->from('spg_uraian')
                ->where(array('kode_jabatan' => $kodeja))
                ->get()
                ->result_array();
        $valbk = $valkebutuhan = $valbkmen = $valkebutuhanmen = 0;
        foreach ($uraian as $vu) {
            //bkn
            $volume = $this->volStandar($vu['volume_kerja'], $vu['volume_periode']);
            $normabkn = $this->tomenit($vu['norma_waktu'], $vu['norma_periode']);
            $bk = $this->jabatan($normabkn, $volume);
//            $bk = $this->bk($normabkn, $volume, $vu['voume_periode']);
            $valbk += $bk['bk'];
            $valkebutuhan += $bk['kebutuhan'];
            //mendagri 
            $normaMdg = $this->menittostandar($this->tomenit($vu['norma_waktu'], $vu['norma_periode'], 'MEN'), 'jam', 'MEN');
            $bkmen = $this->jabatan($normaMdg, $volume);
            $kebutuhan = $this->bk($normaMdg, $vu['volume_kerja'], $vu['volume_periode'], 'MEN');
            $valbkmen += $bkmen['bk'];
            $valkebutuhanmen += $kebutuhan;
        }
        //bkn
        $result['abk'] = round($valbk);
        $result['butuh'] = round($valkebutuhan);
        $result['selisih'] = $abk['jumlah_pns'] - $result['butuh'];
        //mendagri
        $result['abk_men'] = round($valbkmen);
        $result['butuh_men'] = round($valkebutuhanmen);
        $result['selisih_men'] = $abk['jumlah_pns'] - $result['butuh_men'];

        $jmlpns = $abk['jumlah_pns'];
        $result['pegawai_asli'] = $jmlpns;
        if ($jmlpns == 0) {
            $jmlpns = 1;
        }
        //bkn
        $pembagiBkn = $this->getJamKerjaEfektif('tahun');
        $result['ej'] = round($result['abk'] / ($jmlpns * $pembagiBkn), 2);
        $result['pj'] = $this->convpj($result['ej']);
        //mendagri
        $pembagiMen = $this->getJamKerjaEfektif('tahun', 'MEN');
        $result['ej_men'] = round($result['abk_men'] / ($jmlpns * $pembagiMen), 2);
        $result['pj_men'] = $this->convpj($result['ej_men']);

        return $result;
    }

    function convpj($ej) {
        if ($ej > 1.0) {
            $pj = "A (Sangat Baik)";
        } else if ($ej > 0.90 && $ej <= 1.0) {
            $pj = "B (Baik)";
        } else if ($ej > 0.70 && $ej <= 0.89) {
            $pj = "C (Cukup)";
        } else if ($ej >= 0.50 && $ej <= 0.69) {
            $pj = "D (Sedang)";
        } else if ($ej < 0.50) {
            $pj = "E (kurang)";
        } else {
            $pj = '';
        }
        return $pj;
    }

    function jabatan($normawaktu, $volumekerja) {
        $result = array();
        //untukk sementara normawaktu (jam) dan volumekerja (jumlahkegiatan/tahun)
        $result['bk'] = $normawaktu * $volumekerja;
        //jam kerja 7.5 jam -> $pembagi = 1440;
        //jam kerja 5.5 jam -> $pembagi = 1300;
        //jam kerja 5 jam -> $pembagi = 1200; satuannya jam
        $pembagi = 1300;
        $result['kebutuhan'] = $result['bk'] / $pembagi;
        return $result;
    }

    function analisaperunit($bk, $adapeg) {
        $out = array();
        if ($adapeg == 0) {
            $adapeg = 1;
        }
        $pembagi = 1320;
        $out['eu'] = round($bk / ($adapeg * $pembagi), 2);
        $out['pu'] = '';
        if ($out['eu'] >= 1.0) {
            $out['pu'] = "A (Sangat Baik)";
        } else if ($out['eu'] >= 0.90 && $out['eu'] <= 1.0) {
            $out['pu'] = "B (Baik)";
        } else if ($out['eu'] >= 0.70 && $out['eu'] <= 0.89) {
            $out['pu'] = "C (Cukup)";
        } else if ($out['eu'] >= 0.50 && $out['eu'] <= 0.69) {
            $out['pu'] = "D (Sedang)";
        } else if ($out['eu'] < 0.50) {
            $out['pu'] = "E (kurang)";
        }

        return $out;
    }

}
