<?php
	/*#### Security For Login ####*/
	if(!function_exists('login_session_check')) {
        function login_session_check(){
            $CI =& get_instance();

            $controller = $CI->router->fetch_class();
            // $current_url = uri_string();

            if ($controller == 'auth' && $CI->session->has_userdata("userid")) {
                return redirect(base_url('customer'), 'refresh');
            }

            $exclude = array(
                'auth', 'cronjob'
            );

            if (!$CI->session->has_userdata("userid") && !in_array($controller, $exclude)) {
                return redirect(base_url('auth'), 'refresh');
            }
            
        }
    }
?>