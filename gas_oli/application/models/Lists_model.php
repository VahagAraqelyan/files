<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @package	  LTS
 * @category  Models
 * @link	  http://luggage2ship.com
 *
 * @name Lists model
 *
 * Long description
 * Manage Lists and lists data in database.
 *
 **/
class Lists_model extends CI_Model
{
    /**
     * @access protected
     * @var string
     */
    protected $table = 'lists';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_data_by_list_id($list_id, $active = 1) {

        return $this->db->query(
            "select * from
					lists_data
						  where
						  	id_list = " . $this->db->escape($list_id) . "
						  	AND isActive = " . $this->db->escape($active) . "

						  	order by position"
        )->result();
    }

    public function get_data_by_list_key($key, $active = 1) {
        $sql = "select `lists_data`.`id` as id, `lists_data`.`title` as title from

					`lists`

					LEFT JOIN

					 `lists_data`

					 	ON

					 (`lists`.`id` = `lists_data`.`id_list`)

						  WHERE

						  	`lists`.`title` = " . $this->db->escape($key) . "

						  	AND `lists_data`.`isActive` = " . $this->db->escape($active) . "

						  	order by `lists_data`.`position` ";

        return $this->db->query($sql)->result();

    } // End func get_data_by_list_key

    public function get_titles_by_id_comma($ids) {
        $sql = "SELECT
				   GROUP_CONCAT(
					`lists_data`.`title` SEPARATOR ', '
					) AS titles
				FROM
				  `lists_data`

				WHERE FIND_IN_SET(`lists_data`.`id`, '".$ids."')";

        $result =  $this->db->query($sql)->result()[0]->titles;

        return $result;

    } // End func get_data_by_list_key

    public function get_title_by_id($id) {

        $sql = "SELECT
					*
				FROM
				  `lists_data`

				WHERE `lists_data`.`id` = ".$this->db->escape($id);

        $query = $this->db->query($sql);
        $result = $query->result_object();

        if($query->num_rows() > 0) {
            return $result[0]->title;
        } else {
            return false;
        }
    } // End func get_data_by_list_key

    public function get_list_data_by_title($title) {

        $sql = "SELECT
					*
				FROM
				  `lists_data`

				WHERE `lists_data`.`title` = ".$this->db->escape($title);

        $query = $this->db->query($sql);
        $result = $query->row_object();

        if($query->num_rows() > 0) {
            return $result;
        } else {
            return false;
        }
    } // End func get_data_by_list_key
}
