<?php


class Home extends Controller {

    public function __construct(){

        parent:: __construct();

    }

    public function index(){

       $this->home();
    }

    public function home(){

        $data['content'] = 'home';

        $home_model = $this->model->render_model('home_model');
        $post_model = $this->model->render_model('post_model');

        $login_bool = false;
        $login_info = [];

        if(!empty($_COOKIE['user_info'])){

            $cookie_inf = json_decode($_COOKIE['user_info']);

            $login_info = $home_model->get_login_info($cookie_inf->email);
            $login_info = $login_info[0];

            $mixinf = $login_info['first_name'].$login_info['last_name'].$login_info['email'].$login_info['pass'].SALT;
            $mixinf = $this->encrypt_pass($mixinf);
            $login_bool = $this->check_login($mixinf);
        }



        $data['login_info'] = $login_info;
        $data['login_bool'] = $login_bool;
        $data['posts']      = $post_model->get_posts();

        foreach ($data['posts'] as $index => $val){

            $where = "WHERE post_id='".$val['id']."'";

            $data['posts'][$index]['comment'] = $post_model->get_comment($where);
        }

        $this->view->render_view('site_main_template',$data);
    }

    public function registration(){

        $data['content'] = 'user/registration';

        $this->view->render_view('site_main_template',$data);
    }

    public function ax_check_registration(){

        if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {

            echo json_encode(false);
            return false;
        }

        if(empty($_POST['first_name']) ||empty($_POST['last_name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['retype_password'])){

            echo json_encode(false);
            return false;
        }

        if($_POST['password'] != $_POST['retype_password']){

            echo json_encode(false);
            return false;
        }

        $home_model = $this->model->render_model('home_model');

        $check_email = $home_model->check_email($_POST['email']);

        if(!$check_email){
            echo json_encode(false);
            return false;
        }

        $password = $this->encrypt_pass($_POST['password']);

        $insert_data = [
            'first_name' => $_POST['first_name'],
            'last_name'  => $_POST['last_name'],
            'email'      => $_POST['email'],
            'pass'       => $password
        ];

        $result = $home_model->insert_data('users', $insert_data);

        if(!$result){

            echo json_encode(false);
            return false;
        }

        echo json_encode(true);
    }

    public function login(){

        $data['content'] = 'user/login';

        $this->view->render_view('site_main_template',$data);
    }

    public function ax_check_login(){

        if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {

            echo json_encode(false);
            return false;
        }

        if(empty($_POST['email']) || empty($_POST['password'])){

            echo json_encode(false);
            return false;
        }

        $home_model = $this->model->render_model('home_model');

        $password = $this->encrypt_pass($_POST['password']);
        $email = $_POST['email'];

        $login_info = $home_model->get_login_info($email,$password,true);
        $login_info = $login_info[0];
        if(empty($login_info)){

            echo json_encode(false);
            return false;
        }

        $mixinf = $login_info['first_name'].$login_info['last_name'].$login_info['email'].$password.SALT;
        $mixinf = $this->encrypt_pass($mixinf);

        $user_info = [
            'first_name' => $login_info['first_name'],
            'last_name'  => $login_info['last_name'],
            'email'      => $login_info['email'],
            'mixinf'     => $mixinf
        ];

        $time = 0;

        if(!empty($_POST['remember'])){

            $time =  time()+(86400*30);
        }

        setcookie('user_info', json_encode($user_info), $time,"/", "localhost", false, true);

        echo json_encode(true);

    }

    private function check_login($salt){

        if(empty($salt) || empty($_COOKIE['user_info'])){

            return false;
        }

        $cookie_inf = json_decode($_COOKIE['user_info']);

        if($cookie_inf->mixinf != $salt){

            return false;
        }

        return true;
    }

    public function logout(){

        setcookie('user_info', '', time()-3600,"/", "localhost", false, true);
        $this->login();
    }

    private function encrypt_pass($pass) {

        $pass = sha1($pass.SALT);

        return $pass;
    } // End of function encrypt_admin_pass

}