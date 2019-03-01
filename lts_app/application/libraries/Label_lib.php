<?php
Class Label_lib {

    private $CI;

    public function __construct()
    {
        $this->CI = get_instance();
    }

    public function get_label_img($order_id, $trucking_number, $url){

        $file_info = $this->get_file_name($order_id, $trucking_number);

        $new_url = $file_info['patch'];

        if(!copy($url, $new_url)){
            return false;
        }

        return  $file_info;

    }

    private function get_file_name($order_id, $trucking_number){

        $patch = FCPATH.'uploaded_documents/orders_files';

        if(!is_dir($patch)){
            mkdir($patch,0775, TRUE);
        }

        $patch = $patch.'/'.$order_id;

        if(!is_dir($patch)){
            mkdir($patch,0775, TRUE);
        }

        $name = $order_id.'_'.$trucking_number.'.png';

        $patch = $patch.'/'.$name;

        $url = base_url('uploaded_documents/orders_files/'.$order_id.'/'.$name);

        $return = [
            'name'  => $name,
            'patch' => $patch,
            'url'   => $url
        ];

        return $return;

    }

    public function set_watermark($img, $w_img, $cur = Null){

        if(!empty($cur)){
            $cur = strtolower($cur);
        }

        $this->CI->load->library('image_lib');
        $config['image_library'] = 'GD2';
        $config['source_image'] = $img;
        $config['new_image'] = $img;
        $config['wm_overlay_path'] = $w_img;
        $config['wm_type'] = 'overlay';
        $config['wm_opacity'] = '100';
        $config['wm_vrt_alignment'] = 'bottom';
        $config['wm_hor_alignment'] = 'center';
        $config['wm_hor_offset'] = '0';
        $config['wm_vrt_offset'] = '25';

        if(stripos($cur, 'fedex') !== FALSE){

            $config['wm_vrt_alignment'] = 'top';
            $config['wm_hor_alignment'] = 'right';
            $config['wm_vrt_offset'] = '300';
            $config['wm_hor_offset'] = '35';
        }

        $this->CI->image_lib->initialize($config);

        if (!$result = $this->CI->image_lib->watermark()) {
            echo $this->CI->image_lib->display_errors();
        }

        $this->CI->image_lib->clear();

    }
}
?>