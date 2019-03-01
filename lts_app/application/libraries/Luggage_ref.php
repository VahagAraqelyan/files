<?php
class luggage_ref {

    private $luggages_array = [];

    public function __construct(){

        $this->CI=get_instance();
        $this->CI->load->model('Luggage_model');
        $this->init_luggage_array();

    }

    private function init_luggage_array(){

        $types = $this->CI->Luggage_model->get_luggage_types();

        if(empty($types)){
            return false;
        }

        $luggage_data = [];

        foreach($types as $single_type){

            $luggages = $this->CI->Luggage_model->get_luggages_by_type($single_type['id']);
            if(empty($luggages)){ continue; }

            $row = [
                "type_name"       => $single_type['type_name'],
                "type_icon_class" => $single_type['type_icon_class'],
                "ul_class"        => $single_type['ul_class'],
                "img_box_class"   => $single_type['img_box_class'],
                "luggages"        => []
            ];

            foreach($luggages as $single){

                $row['luggages'][$single['product_id']] = array(
                    "luggage_id"                =>$single['product_id'],
                    "luggage_name"              =>$single['luggage_name'],
                    "short_name"                =>$single['short_name'],
                    "luggage_max_count"         =>$single['max_count'],
                    "luggage_size"              =>$single['width'].'x'.$single['height'].'x'.$single['length'],
                    "luggage_max_weight_kg"     =>floor(floatval($single['weight']*0.453)),
                    "luggage_max_weight_lbs"    =>$single['weight'],
                    "li_class"                  =>$single['li_class'],
                    "image_class"               =>$single['image_class'],
                    "sizes_image"               =>$single['sizes_image'],
                );

            }


            $luggage_data[$single_type['id']] = $row;
        }

        if(!empty($luggage_data)){
            $this->luggages_array = $luggage_data;
        }



    }

    public function get_ref_data() {

        return  $this->luggages_array;

    }

}
?>