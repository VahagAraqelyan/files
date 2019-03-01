<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Csv_lib {

    private $CI;
    private $config;

    public function __construct()
    {

        $this->CI=get_instance();
        $this->CI->load->model('Manage_price_model');
        $this->init_config();

    }

    public function init_config() {

        $this->config = [

            'International_outbound_inbound' => [
                'table_suffix'     => '_international_price',
                'external_row'    => 2,
                'insert_from_row' => 3,
                'checking_array'  => ['AF','AL','DZ','AS','AD','AO','AI','AQ','AG','AR','AM','AW','AU','AT','AZ','AP','BS','BH','BD','BB','BY','BE','BZ','BJ','BM','BT','BO','BQ','BA','BW','BR','VG','BN','BG','BF','BI','MM','KH','CM','CA','CE','CV','KY','CF','TD','CB','CL','CN','CO','KM','CG','CD','CK','CR','HR','CU','CW','CY','CZ','DK','DJ','DM','DO','TL','EC','EG','SV','GQ','ER','EE','ET','FK','FO','FJ','FI','FR','GF','PF','GA','GM','GE','DE','GH','GI','GR','GL','GD','GP','GU','GT','GG','GN','GW','GY','HT','HN','HK','HU','IS','IN','ID','IR','IQ','IE','IL','IT','CI','JM','JP','JE','JO','KZ','KE','KI','KP','KR','KV','KW','KG','LA','LV','LB','LS','LR','LY','LI','LT','LU','MO','MK','MG','MW','MY','MV','ML','MT','MH','MQ','MR','MU','YT','MX','FM','MD','MC','MN','ME','MS','MA','MZ','NA','NR','NP','NL','XN','NC','NZ','NI','NE','NG','NU','MP','NO','OM','PK','PW','PS','PA','PG','PY','PE','PH','PL','PT','PR','QA','RE','RO','RU','RW','SH','NS','BL','EU','KN','LC','SX','PM','VC','SP','WS','SM','ST','SA','SN','RS','SC','SL','SG','SK','SI','SB','SO','JS','ZA','ES','LK','SD','SR','SJ','SZ','SE','CH','SY','TY','TW','TJ','TZ','TH','TG','TK','TO','TT','TN','TR','TM','TC','TV','EN','TE','AB','WA','UG','UA','AE','US','UY','UZ','VU','VA','VE','VN','VI','WF','YE','ZM','ZW']
            ],

            'International_delivery_time' => [
                'table_suffix'     => '_international_delivery_time',
                'external_row'    => 2,
                'insert_from_row' => 3,
                'checking_array'  => ['AF','AL','DZ','AS','AD','AO','AI','AQ','AG','AR','AM','AW','AU','AT','AZ','AP','BS','BH','BD','BB','BY','BE','BZ','BJ','BM','BT','BO','BQ','BA','BW','BR','VG','BN','BG','BF','BI','MM','KH','CM','CA','CE','CV','KY','CF','TD','CB','CL','CN','CO','KM','CG','CD','CK','CR','HR','CU','CW','CY','CZ','DK','DJ','DM','DO','TL','EC','EG','SV','GQ','ER','EE','ET','FK','FO','FJ','FI','FR','GF','PF','GA','GM','GE','DE','GH','GI','GR','GL','GD','GP','GU','GT','GG','GN','GW','GY','HT','HN','HK','HU','IS','IN','ID','IR','IQ','IE','IL','IT','CI','JM','JP','JE','JO','KZ','KE','KI','KP','KR','KV','KW','KG','LA','LV','LB','LS','LR','LY','LI','LT','LU','MO','MK','MG','MW','MY','MV','ML','MT','MH','MQ','MR','MU','YT','MX','FM','MD','MC','MN','ME','MS','MA','MZ','NA','NR','NP','NL','XN','NC','NZ','NI','NE','NG','NU','MP','NO','OM','PK','PW','PS','PA','PG','PY','PE','PH','PL','PT','PR','QA','RE','RO','RU','RW','SH','NS','BL','EU','KN','LC','SX','PM','VC','SP','WS','SM','ST','SA','SN','RS','SC','SL','SG','SK','SI','SB','SO','JS','ZA','ES','LK','SD','SR','SJ','SZ','SE','CH','SY','TY','TW','TJ','TZ','TH','TG','TK','TO','TT','TN','TR','TM','TC','TV','EN','TE','AB','WA','UG','UA','AE','US','UY','UZ','VU','VA','VE','VN','VI','WF','YE','ZM','ZW']
            ],

            'Country_profile' => [
                'table_suffix'        => 'country_profile',
                'external_row'        => 2,
                'insert_from_row'     => 3,
                'currier_count'       => 3,
                'currier_field_count' => 10,
                'checking_array'      => ['AF','AL','DZ','AS','AD','AO','AI','AQ','AG','AR','AM','AW','AU','AT','AZ','AP','BS','BH','BD','BB','BY','BE','BZ','BJ','BM','BT','BO','BQ','BA','BW','BR','VG','BN','BG','BF','BI','MM','KH','CM','CA','CE','CV','KY','CF','TD','CB','CL','CN','CO','KM','CG','CD','CK','CR','HR','CU','CW','CY','CZ','DK','DJ','DM','DO','TL','EC','EG','SV','GQ','ER','EE','ET','FK','FO','FJ','FI','FR','GF','PF','GA','GM','GE','DE','GH','GI','GR','GL','GD','GP','GU','GT','GG','GN','GW','GY','HT','HN','HK','HU','IS','IN','ID','IR','IQ','IE','IL','IT','CI','JM','JP','JE','JO','KZ','KE','KI','KP','KR','KV','KW','KG','LA','LV','LB','LS','LR','LY','LI','LT','LU','MO','MK','MG','MW','MY','MV','ML','MT','MH','MQ','MR','MU','YT','MX','FM','MD','MC','MN','ME','MS','MA','MZ','NA','NR','NP','NL','XN','NC','NZ','NI','NE','NG','NU','MP','NO','OM','PK','PW','PS','PA','PG','PY','PE','PH','PL','PT','PR','QA','RE','RO','RU','RW','SH','NS','BL','EU','KN','LC','SX','PM','VC','SP','WS','SM','ST','SA','SN','RS','SC','SL','SG','SK','SI','SB','SO','JS','ZA','ES','LK','SD','SR','SJ','SZ','SE','CH','SY','TY','TW','TJ','TZ','TH','TG','TK','TO','TT','TN','TR','TM','TC','TV','EN','TE','AB','WA','UG','UA','AE','US','UY','UZ','VU','VA','VE','VN','VI','WF','YE','ZM','ZW','all']
            ],

            'Domestic' => [
                'table_suffix'     => '_domestic',
                'external_row'     => 2,
                'insert_from_row'  => 3,
                'zone_row'         => 1,
                'zone_count'       => 15,
                'zone_field_count' => 6,
                'checking_array'   => ['Express_1_Day_morning','Express_1_Day_afternoon','Priority_2_Days_morning','Priority_2_Days_afternoon','Standard_3_Days','Basic_*_Days']
            ],

            'Domestic_delivery_time' => [
                'table_suffix'       => 'domestic_distance_zone',
                'external_row'       => 1,
                'insert_from_row'    => 2,
                'checking_array'     => ['Distant_From_(mile)','Distant_to_(mile)','Zone','Ground_Delivery_Time_(business day)']
            ],


        ];

    }


    /*
   * @access public
   * @param  string $country_code, int $currier_id, int $type, string $file_url
   * $type = 1 (outband) | 2 (inband)
   * @return bool
   */
    public function insert_international_price($country_code, $currier_id, $type, $file_url){

        if(empty($country_code) || empty($currier_id) || empty($type)){
            return false;
        }

        $data['error'] = '';
        $data['success'] = '';

        if (!file_exists($file_url)) {
            $data['error'] = 'The file does not exist.';
            return $data;
        }

        $this->CI->load->model("Home_model");
        $config = $this->config['International_outbound_inbound'];

        $external_array = $this->take_data_from_csv($file_url, ',', $config['external_row']);

        if(empty($external_array)){
            $data['error'] = 'No external row on this csv';
            return $data;
        }

        array_shift($external_array);

        if(!$this->check_diff_array($config['checking_array'], $external_array)){
            $data['error'] = 'Invalid external row.';
            return $data;
        }

        $batch_insert_array=[];
        $all_data = $this->take_data_from_csv($file_url);
        $country_colums = $config['checking_array'];
        array_unshift($country_colums,'weight_lb');

        for($i=$config['insert_from_row']; $i<=count($all_data); $i++){

            $data_part1= [
                    'currier_id' => $currier_id,
                    'type' => $type,
                ];

            $original_count = count($country_colums);
            $isset_count = count($all_data[$i]);

            if($original_count != $isset_count){
                $data['error'] = 'Incorrect csv file on row '.$i.' must be '.$original_count.' colums, but isset '.$isset_count;
                return $data;
            }

            if(!is_numeric($all_data[$i][0]) && $all_data[$i][0]!='PLUS'){
                $data['error'] = 'Incorrect csv file on row '.$i.' weight must be numeric or `PLUS`';
                return $data;
            }

            $data_part2 = array_combine($country_colums, $all_data[$i]);

            $batch_insert_array[] = array_merge($data_part1,$data_part2);

        }

        if(empty($batch_insert_array)){
            $data['error'] = 'No data for inserting.';
            return $data;
        }


        $table_name = strtolower($country_code.$config['table_suffix']);

        if(!$this->CI->Home_model->table_exists($table_name)){

            array_unshift($country_colums, 'currier_id','type');

            if(!$this->CI->Manage_price_model->create_international_price_table($table_name,$country_colums)){
                $data['error'] = 'Error creating table.';
                return $data;
            }

        }else{

            $crt=[
                'currier_id' => $currier_id,
                'type'       => $type
            ];

            $this->CI->Manage_price_model->delete_batch_data($table_name, $crt);

        }

        $result = $this->CI->Manage_price_model->data_batch_insert($table_name, $batch_insert_array);

        if(!$result){

            $data['error'] = 'Error inserting data.';

        }else{

            $data['success'] = 'Data successfully inserted.';
            
        }

        return $data;

    }

    public function insert_international_delivery_time($file_url, $iso){

        if(empty($file_url)){
            return false;
        }

        $data['error'] = '';
        $data['success'] = '';

        if (!file_exists($file_url)) {
            $data['error'] = 'The file does not exist.';
            return $data;
        }

        $this->CI->load->model("Home_model");
        $config = $this->config['International_delivery_time'];

        $table_name = strtolower($iso.$config['table_suffix']);

        $external_array = $this->take_data_from_csv($file_url, ',', $config['external_row']);

        if(empty($external_array)){
            $data['error'] = 'No external row on this csv';
            return $data;
        }

        array_shift($external_array);

        if(!$this->check_diff_array($config['checking_array'], $external_array)){
            $data['error'] = 'Invalid external row.';
            return $data;
        }

        $batch_insert_array=[];
        $all_data = $this->take_data_from_csv($file_url);
        $country_colums = $config['checking_array'];
        array_unshift($country_colums,'sending_type');

        for($i=$config['insert_from_row']; $i<=count($all_data); $i++){

            $original_count = count($country_colums);
            $isset_count = count($all_data[$i]);

            if($original_count != $isset_count){
                $data['error'] = 'Incorrect csv file on row '.$i.' must be '.$original_count.' colums, but isset '.$isset_count;
                return $data;
            }

            $batch_insert_array[] = array_combine($country_colums, $all_data[$i]);

        }

        if(empty($batch_insert_array)){
            $data['error'] = 'No data for inserting.';
            return $data;
        }


        if(!$this->CI->Home_model->table_exists($table_name)){

            if(!$this->CI->Manage_price_model->create_international_delivery_time_table($table_name,$country_colums)){
                $data['error'] = 'Error creating table.';
                return $data;
            }

        }else{

            $this->CI->Manage_price_model->delete_batch_data($table_name);

        }

        $result = $this->CI->Manage_price_model->data_batch_insert($table_name, $batch_insert_array);

        if(!$result){

            $data['error'] = 'Error inserting data.';

        }else{

            $data['success'] = 'Data successfully inserted.';

        }

        return $data;


    }

    public function insert_country_profile_csv($url){

        if(empty($url)){
            return false;
        }

        $data['error'] = '';
        $data['success'] = '';

        if (!file_exists($url)) {
            $data['error'] = 'The file does not exist.';
            return $data;
        }

        $config = $this->config['Country_profile'];

        $full_array = $this->take_data_from_csv($url);
        $external_row = $full_array[$config['external_row']];
        array_splice($full_array, 0, $config['insert_from_row']-1);

        $check_count = $config['currier_count'] * $config['currier_field_count']+3;

        if(count($external_row) != $check_count){
            $data['error'] = 'Invalid currier count on this csv.';
            return $data;
        }

        foreach($full_array as $row){
            $currier_count = $config['currier_count'];
            $start = 3;

            $row_count = count($row);
            if($row_count != $check_count){
                $data['error'] = 'Values on row '.$row[0].' must be '.$check_count.' but isset '.$row_count;
                return $data;
            }

            if(!in_array($row[1], $config['checking_array'])){
                $data['error'] = 'undefined ISO for '.$row[0];
                return $data;
            }

            while($currier_count > 0){

                $custom_value = $row[2];
                if(stripos($custom_value, 'n/a') !== false){
                    $custom_value = floatval(-1);
                }

                $insert_array[] = [
                    'currier_id'   => $external_row[$start],
                    'country_iso'  => $row[1],
                    'domestic'     => $row[$start],
                    'intern_out'   => $row[$start+1],
                    'intern_in'    => $row[$start+2],
                    'hotline'      => $row[$start+3],
                    'website'      => $row[$start+4],
                    'user_name'    => $row[$start+5],
                    'password'     => $row[$start+6],
                    'partner_web'  => $row[$start+7],
                    'user_name_p'  => $row[$start+8],
                    'password_p'   => $row[$start+9],
                    'custom_value' => $custom_value
                ];

                $currier_count--;
                $start+=$config['currier_field_count'];

            }

        }

        if(empty($insert_array)){
            $data['error'] = 'No data for inserting.';
            return $data;
        }

        $this->CI->Manage_price_model->delete_country_profile();

        if(!$this->CI->Manage_price_model->insert_country_profile_batch($insert_array)){
            $data['error'] = 'Error filling data to database.';
        }else{
            $data['success'] = 'Data successfully inserted.';
        }

        return $data;

    }

    public function upload_domestic($country_code, $currier_id, $file_url){

        if(empty($country_code) || empty($currier_id)){
            return false;
        }

        $data['error'] = '';
        $data['success'] = '';

        if (!file_exists($file_url)) {
            $data['error'] = 'The file does not exist.';
            return $data;
        }

        $this->CI->load->model("Home_model");
        $config = $this->config['Domestic'];


        $external_array = $this->take_data_from_csv($file_url, ',', $config['external_row']);

        if(empty($external_array)){
            $data['error'] = 'No external row on this csv';
            return $data;
        }

        array_shift($external_array);
        $isset_count = count($external_array);
        if($isset_count != $config['zone_field_count']*$config['zone_count']){
            $data['error'] = 'Incorrect column count of external row.';
            return $data;
        }

        foreach($external_array as $column){

            if(!in_array($column, $config['checking_array'])){
                $data['error'] = 'Undefined column '.$column.' of external row.';
                return $data;
            }

        }

        $full_array = $this->take_data_from_csv($file_url, ',');

        $zones = $full_array[$config['zone_row']];

        array_shift($zones);

        if(count($zones) != $config['zone_count']*$config['zone_field_count']){
            $data['error'] = 'Invalid zones count.';
            return $data;
        }


        array_splice($full_array, 0, $config['insert_from_row']-1);

        $insert_array = [];

        $zones = array_unique($zones);

        $zones = array_values($zones);

        foreach($full_array as $row){

            $row_count = count($row);
            $mus_be = count($external_array)+1;

            if($row_count != $mus_be){
                $data['error'] = 'On row '.$row[0].'lb incorrect column count isset '.$row_count.' must be '.$mus_be;
                return $data;
            }

            $lb = $row[0];

            if(!is_numeric($lb) && $lb!='PLUS'){
                $data['error'] = 'Incorrect csv file on row '.$lb.' weight must be numeric or `PLUS`';
                return $data;
            }

            $zone_index = 0;

            array_shift($row);
            $temp_exter = $external_array;

            while(!empty($row)){

                $row_part = array_slice($row, 0, $config['zone_field_count']);
                $key_part = array_slice($temp_exter, 0, $config['zone_field_count']);
                array_splice($row, 0, $config['zone_field_count']);
                array_splice($temp_exter, 0, $config['zone_field_count']);

                $single_insert = [
                    'weight'     => $lb,
                    'currier_id' => $currier_id,
                    'zone'       => $zones[$zone_index]
                ];

                $insert_array[] =  array_merge($single_insert, array_combine($key_part,$row_part));;
                $zone_index++;

            }

        }

        if(empty($insert_array)){
            $data['error'] = 'No data for inserting.';
            return $data;
        }

        $table_name = strtolower($country_code.$config['table_suffix']);
        $colums = array_merge(['weight','currier_id','zone'], $config['checking_array']);
        $crt = ['currier_id' => $currier_id];
        if($this->CI->Home_model->table_exists($table_name)){
            $result = $this->CI->Manage_price_model->delete_batch_data($table_name, $crt);
            if(!$result){
                $data['error'] = 'Can`t remove data from table '.$table_name;
                return $data;
            }
        }else {
            if (!$this->CI->Manage_price_model->create_domestic_price($table_name, $colums)) {
                $data['error'] = 'Can`t create table ' . $table_name;
                return $data;
            }
        }

        if(!$this->CI->Manage_price_model->data_batch_insert($table_name, $insert_array)){
            $data['error'] = 'Can`t fill data to database.';
            return $data;
        }

        $data['success'] = 'All data successfully inserted to db.';

        return $data;

    }

    public function insert_domestic_delivery_time($file_url, $country_id){

        if(empty($country_id)){
            return false;
        }

        $data['error'] = '';
        $data['success'] = '';

        if (!file_exists($file_url)) {
            $data['error'] = 'The file does not exist.';
            return $data;
        }

        $config = $this->config['Domestic_delivery_time'];

        $external_array = $this->take_data_from_csv($file_url, ',', $config['external_row']);

        if(empty($external_array)){
            $data['error'] = 'No external row on this csv';
            return $data;
        }

        if(!$this->check_diff_array($config['checking_array'], $external_array)){
            $data['error'] = 'Invalid external row.';
            return $data;
        }

        $table_name = $config['table_suffix'];

        $all_data = $this->take_data_from_csv($file_url);
        array_shift($all_data);

        $insert_array = [];

        foreach($all_data as $index => $single) {

            $count = count($single);
            $count_check = count($external_array);
            if ($count != $count_check) {
                $data['error'] = 'Error on row ' .$index. ' must be ' . $count_check . ' columns but isset ' . $count;
                return $data;
            }

            $single['1'] = ($single['1']== '+') ? PHP_INT_MAX : $single['1'];

            $insert_array[] = [
                'country_id'          => $country_id,
                'distance_from'       => $single['0'],
                'distance_to'         => $single['1'],
                'zone'                => $single['2'],
                'basic_delivery_days' => $single['3']
            ];

        }

        if(empty($insert_array)){
            $data['error'] = 'No data for inserting.';
            return $data;
        }

        $this->CI->Manage_price_model->delete_batch_data($table_name, ['country_id' => $country_id]);

        if(!$this->CI->Manage_price_model->data_batch_insert($table_name, $insert_array)){
            $data['error'] = 'Error filling data to Database.';
            return $data;
        }

        $data['success'] = 'All data successfully inserted.';
        return $data;

    }

    public function take_data_from_csv($file_url, $delimiter=',', $row = NULL){

        $row_num = 1;

        if (($handle = fopen($file_url, "r")) === FALSE) {
            return false;
        }

        if(!empty($row)){
            while (($data = fgetcsv($handle, 0, $delimiter)) !== FALSE) {
                if($row_num == $row){
                    return $data;
                }
                $row_num++;
            }
            return false;
        }

        $full_array = [];

        while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
            $full_array[$row_num]=$data;
            $row_num++;
        }

        if(empty($full_array)){
            return false;
        }

        return $full_array;

    }

    public function check_diff_array($checking_array, $array){

        if(empty($checking_array) || empty($array) || !is_array($checking_array) || !is_array($array)){
            return false;
        }

        if(count($checking_array) != count($array)){
            return false;
        }

        for($i=0; $i<count($checking_array); $i++){
            if($checking_array[$i] != $array[$i]){
                return false;
            }
        }

        return true;

    }

    public function get_config($config_name){

        if(empty($this->config[$config_name])){
            return false;
        }

        return $this->config[$config_name];
    }



}
?>