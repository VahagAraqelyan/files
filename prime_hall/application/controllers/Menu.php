<?php
class Menu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_model');

    }

    public function index()
    {
        $this->menu();
    }

    public  function  menu(){

        $this->check_admin_login();

       $data['menu'] =  $this->Menu_model->get_menu_type();

       $data['content'] = 'admin/menu/menu_type';

       $this->load->view('admin/back_template',$data);
    }

    public function create_menu($id){

        $this->check_admin_login();

        $food_type = $this->Menu_model->get_food_type($id);

        $return_data = [];

        foreach ($food_type as $index => $single){

            $food_type[$index]['children'] = $this->Menu_model->get_menu_by_food_id($single['id'],$id);
        }

        $data['type_id'] = $id;

        $return_data = $food_type;

        if(empty($return_data)){
            $data['menus'] =  json_encode(array());
        }else{
            $data['menus'] = json_encode($return_data, JSON_HEX_APOS|JSON_HEX_QUOT);
        }

        $data['content'] = 'admin/menu/create_menu';

        $this->load->view('admin/back_template',$data);

    }

    public function ax_save_menu(){

        $this->check_admin_login(true);

        $json = $this->security->xss_clean($this->input->post('json_data'));
        $type_id = $this->security->xss_clean($this->input->post('type_id'));

        $data = [
            'status' => '',
            'errors' => []
        ];
        $ser_data = json_decode($json);
        foreach ($ser_data as $index => $single){

            foreach ($single->children as $index2 => $item){

                if(empty($item->children)){

                    unset($ser_data[$index]->children[$index2]->children);
                    unset($item->children);
                }

                if(array_key_exists('children',$item)){
                    $data['errors'][] = 'Տվյալները չեն պահպանվել։ Ճաշատեսակի մեջ ոչինչ լինել չի կարող';
                    echo json_encode($data);
                    return false;
                }
            }
        }

        $this->Menu_model->delete_menu(['type_id' => $type_id]);
        $this->Menu_model->delete_food_type(['menu_type_id' => $type_id]);


        $menu_data = [];

        foreach ($ser_data as $single){

            $id = $this->Menu_model->insert_food_type(['name_am' => $single->name_am,'name_ru' => $single->name_ru,'name_en' => $single->name_en, 'menu_type_id' => $type_id]);

         foreach ($single->children as $item){
             $item->food_type_id = $id;
             $menu_data[] = $item;
         }
     }

     foreach ($menu_data as $index => $val){

         $val = get_object_vars($val);
         unset($val['id']);

         if(array_key_exists('menu_type_id',$val)){

             $val['type_id'] = $val['menu_type_id'];
             unset($val['menu_type_id']);
         }

         $this->Menu_model->add_menu($val);
     }

    }

    public function ax_add_or_edit_menu(){

        $this->check_admin_login(true);

        $type_id       = $this->security->xss_clean($this->input->post('type_id'));
        $food_type_id  = $this->security->xss_clean($this->input->post('child_id'));
        $menu_id       = $this->security->xss_clean($this->input->post('menu_id'));
        $price         = $this->security->xss_clean($this->input->post('price'));
        $name_am       = $this->security->xss_clean($this->input->post('name_am'));
        $name_ru       = $this->security->xss_clean($this->input->post('name_ru'));
        $name_en       = $this->security->xss_clean($this->input->post('name_en'));
        $upd_type      = $this->security->xss_clean($this->input->post('data_food_type'));

        $add = true;

        $data = [
            'success' => '',
            'errors' => []
        ];

        if(empty($type_id)){
            $data['errors'][]  = 'Տվյալները չեն պահմանվել խնդրում ենք փորձել կրկին';
            echo json_encode($data);
            return false;
        }

        if(!empty($menu_id)){
            $add = false;
        }

        $inser_or_update_data = [
            'type_id'      => $type_id,
            'food_type_id' => $food_type_id,
            'price'        => $price,
            'name_am'      => $name_am,
            'name_ru'      => $name_ru,
            'name_en'      => $name_en,
        ];

        if($upd_type === 'ok'){

            $add_upd_data = [
                'menu_type_id' => $type_id,
                'name_am'      => $name_am,
                'name_ru'      => $name_ru,
                'name_en'      => $name_en,
            ];

            if(empty($menu_id) && empty($food_type_id)){
                $result =  $this->Menu_model->insert_food_type($add_upd_data);
            }else{
                $result =  $this->Menu_model->update_menu_type($add_upd_data,$food_type_id);
            }

            if($result){

                $data['success'] = 'Տվյալները հաջողությամբ պահպանվեցին';

            }else{
                $data['errors'][]  = 'Տվյալները չեն պահմանվել խնդրում ենք փորձել կրկին';
            }

            echo json_encode($data);
            return false;
        }

        if($price == ''){
            $data['errors'][]  = 'Գնի Դաշտը պարտադիր է';
            echo json_encode($data);
            return false;
        }

        if($add){
            $result = $this->Menu_model->add_menu($inser_or_update_data);
        }else{
            $result = $this->Menu_model->update_menu($inser_or_update_data,$menu_id);
        }

        if($result){

            $data['success'] = 'Տվյալները հաջողությամբ պահպանվեցին';

        }else{
            $data['errors'][]  = 'Տվյալները չեն պահմանվել խնդրում ենք փորձել կրկին';
        }

        echo json_encode($data);
    }

    public function ax_remove_menu(){

        $this->check_admin_login(true);

        $type_id       = $this->security->xss_clean($this->input->post('type_id'));
        $food_type_id  = $this->security->xss_clean($this->input->post('food_type_id'));
        $menu_id       = $this->security->xss_clean($this->input->post('menu_id'));

        $data = [
            'success' => '',
            'errors' => []
        ];

        if(empty($type_id)){
            $data['errors'][]  = 'Չհաջողվեց ջնջել, խնդրում ենք փորձել կրկին';
            echo json_encode($data);
            return false;
        }

        if(empty($food_type_id) && empty($menu_id)){
            $data['errors'][]  = 'Չհաջողվեց ջնջել, խնդրում ենք փորձել կրկին';
            echo json_encode($data);
            return false;
        }

        if(empty($menu_id)){

            $this->Menu_model->delete_food_type(['id' => $food_type_id]);
            $this->Menu_model->delete_menu(['type_id' => $type_id,'food_type_id' =>$food_type_id]);

        }else{

            $this->Menu_model->delete_menu(['type_id' => $type_id,'id' => $menu_id]);
        }

        $data['success'] = 'Տվյալները հաջողությամբ ջնվջեցին';

        echo json_encode($data);
    }

    private function check_admin_login($ajax = false) {

        if($ajax){

            if(!$this->input->is_ajax_request()){
                show_404();
                return false;
            }
        }

        if(!$this->admin_security->is_admin()) {
            redirect(base_url('admin-panel'), 'refresh');
            exit;
        }

    }
}