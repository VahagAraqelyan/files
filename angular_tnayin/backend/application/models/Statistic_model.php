<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Statistic_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_orders($date){

        if(empty($date)){

            return false;
        }

        $query = "
            SELECT 
             DATE(a.created_date) AS sdate,
               (SELECT 
                 COUNT(MONTH(b.created_date)) 
               FROM
                 `order_shipping` b 
               WHERE DATE(b.created_date) = DATE(a.created_date) 
                 AND shipping_type = '1' 
               GROUP BY DATE(b.created_date)) AS cnt_iner,
               (SELECT 
                 COUNT(MONTH(c.created_date)) 
               FROM
                 `order_shipping` c 
               WHERE DATE(c.created_date) = DATE(a.created_date) 
                 AND shipping_type = '2' 
               GROUP BY DATE(c.created_date)) AS cnt_dom 
             FROM
               `order_shipping` a 
             WHERE MONTH(a.created_date) = '$date[1]' 
               AND YEAR(a.created_date) = '$date[0]' 
             GROUP BY DATE(a.created_date)
        ";

        $result = $this->db->query($query)->result_array();

        return $result;

    }

}