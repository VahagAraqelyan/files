<?php
$add_class = '';
$add_activ = '';
$add_block = '';
if(empty($selected_country)){
    $add_class = 'dis_none';
    $add_activ = 'active';
    $add_block = 'dis_block';
}

?>

<!-- Modal upload-->
<div class="modal fade" id="upload_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="upload_modal_div">
                <div id="answer_upload">
                    <span id="show_upload_error_img"></span>
                    <span id="show_error_my_profile"></span>
                </div>
            </div>

        </div>

    </div>
</div>

<div class="content dashboard">
    <div class="container">

        <div class="panel panel-default designed-panel">
            <div class="row">
                <form method="post" class="form-horizontal" action="<?php echo base_url()?>admin/price_page/csv_file" enctype="multipart/form-data" >
                    <div class="col-md-3">
                        <select class="form-control selectpicker select-country price_manage_country" id="price_manage_country" name="select_country">
                            <option value= 'all_0' <?php echo ($selected_country==='0')?'selected="selected"':''; ?>>ALL Country`s</option>
                           <?php
                            foreach ($countries as $country){
                                $k=($selected_country==$country['id'])?'selected="selected"':'';
                                ?>
                               <option value="<?php echo $country['iso2'].'_'.$country['id']; ?>" <?php echo $k; $sel; ?> ><?php echo $country['country']; ?></option>
                           <?php } ?>
                        </select>
                    </div>
                    <div id="select_file" class="<?php echo $add_block; ?>">
                        <div class="col-md-3 col-md-push-4">
                            <label class="btn btn-default btn-file select-doc-file">
                                Select File <input type="file" id="county_profile_file" name="convert_file" class="form-control" style="display: none;">
                            </label>
                        </div>
                        <div class="col-md-1 col-md-push-4">
                            <?php
                            $url = FCPATH.'uploaded_documents/countries_profiles/Country-Profile.csv';
                            if(file_exists($url)){
                                $date = filemtime($url);
                                ?>
                                <div class="doc-file-place">
                                    <div class="image_div price_page_image">
                                        <img class='admin_delete_img remove_country_profile' data-blok='Country-Profile.csv'src='<?php echo base_url(); ?>assets/images/x_document.png'>
                                        <a href="<?php echo base_url('admin/price_page/country_profile_file/Country-Profile.csv'); ?>" target="_blank"> <img class="main_img" src='<?php echo base_url(); ?>assets/images/file_uploaded.png'></a>
                                        <span><?php echo date("Y-m-d H:i:s", $date);  ?></span>
                                    </div>
                                </div>
                                    <?php
                            }
                            ?>
                        </div>
                        <div class="col-md-1 col-md-push-4">
                            <button type="button" id="all_country_butt" name="save_butt" class="btn btn-default btn-login-orange adm-btn">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="designed-tabs all_tabs">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="my_accoutn_tabs">
                <li class="active <?php echo $add_class; ?>"><a href="#price" data-toggle="tab">Price<i class="fa fa-angle-down tab-down" aria-hidden="true"></i></a></li>
                <li class="country_profile <?php echo $add_activ; ?>"><a href="#country_profile" data-toggle="tab">Country Profile<i class="fa fa-angle-down tab-down" aria-hidden="true"></i></a></li>
                <li class="tabs_pane extra_charges"><a href="#extra_charges" data-toggle="tab">Extra Charges<i class="fa fa-angle-down tab-down" aria-hidden="true"></i></a></li>
                <li class="tabs_pane product"><a href="#product" data-toggle="tab">Product<i class="fa fa-angle-down tab-down" aria-hidden="true"></i></a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content tab-profile">
                <div class="tab-pane  active <?php echo $add_class; ?>" id="price">
                    <div class="row">
                        <div class="col-md-6 international-shipment">
                            <h2 class="text-center">International Shipment</h2>
                            <form method="post" class="form-horizontal" action="">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <div class="col-sm-12 col-xs-12">
                                                <label class="btn btn-default btn-file select-doc-file">
                                                    Select File <input type="file" id="input_file" name="input_file" class="form-control inter_doc_file" style="display: none;">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-md-push-1">
                                        <div class="form-group">
                                            <div class="doc-file-place">
                                                <?php
                                                echo $documents_block;
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-9">
                                        <textarea class="form-control inter_comment" placeholder="Please be advised the custom delay cannot be controlled for international luggage shipment. Custom delay in China in Chinese New Year, allow 3-5 more business days for clearance."><?php echo $comment[0]['comment']; ?></textarea>
                                    </div>
                                    <div class="col-md-3 text-left">
                                        <button type="button" id="save_inter_comments" class="btn btn-default btn-login-orange adm-btn">Save</button>
                                        <div>
                                            <span class="form-small-font display-inline"><?php echo $comment_date; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <p class="border-bottom"></p>

                            <form method="post" class="form-horizontal form-small-font form-display-span" action="">
                                <div class="rounded-noborder">
                                    <div class="form-group">
                                        <div class="col-md-3 text-center">
                                            <strong>Country<br />
                                                Delivery Time</strong>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="btn btn-default btn-file select-doc-file">
                                                    Select File <input type="file" name="" id="int_del_time" class="form-control" style="display: none;">
                                                </label>
                                            </div>
                                        </div>
                                        <?php if(!empty($delivery_time['inter'])){ ?>
                                        <div class="col-md-2 col-md-push-1">
                                            <div class="image_div price_page_image">
                                                <img class=' admin_delete_img delivery_time'
                                                    data-block = "Delivery Time" data-name = '<?php echo $delivery_time['inter'][0]['file_name']; ?>'
                                                     src='<?php echo base_url(); ?>assets/images/x_document.png'>
                                                <a href="<?php echo base_url('admin/price_page/currier_file/' . $iso . '/' .$delivery_time['inter'][0]['file_name']); ?>"
                                                   target="_blank"> <img class="main_img"
                                                                         src='<?php echo base_url(); ?>assets/images/file_uploaded.png'></a>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <span><?php echo $delivery_time['inter'][0]['file_name']; ?></span>
                                            <span><?php echo$delivery_time['inter'][0]['date']; ?></span>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </form>
                           <?php
                           if(!empty($curriers)) {
                               foreach ($curriers as $single) {
                                   ?>
                                   <form method="post" class="form-horizontal form-small-font form-display-span"
                                         action="" id="inter_currier_form_<?php echo $single['id'];?>" >
                                       <div class="rounded-border">
                                           <div class="form-group">
                                               <div class="col-md-3 text-left">
                                                   <h5 class="red-text bold"><?php echo $single['name']; ?></h5>
                                                   <input type="hidden" name="currier_id" class="currier_id"
                                                          value="<?php echo $single['id']; ?>">
                                               </div>
                                           </div>
                                           <div class="form-group">
                                               <?php if($single['intern_out'] > 0) { ?>
                                               <div class="col-md-3 text-center">
                                                   <strong>Outbound<br/>
                                                       Express</strong>
                                               </div>
                                               <div class="col-md-3">
                                                   <div class="form-group">
                                                       <label class="btn btn-default btn-file select-doc-file">
                                                           Select File <input type="file" class="outband_exp"
                                                                              name="outbound_express"
                                                                              class="form-control"
                                                                              style="display: none;">
                                                       </label>
                                                   </div>
                                               </div>
                                               <?php if (!empty($single['outbound_express'])) { ?>
                                                   <div class="col-md-2 col-md-push-1">
                                                       <div class="image_div price_page_image">
                                                           <img class=' admin_delete_img admin_delete_process'
                                                                data-name='outbound_express'
                                                                src='<?php echo base_url(); ?>assets/images/x_document.png'>
                                                           <a href="<?php echo base_url('admin/price_page/currier_file/' . $iso . '/' . $single['outbound_express']); ?>"
                                                              target="_blank"> <img class="main_img"
                                                                                    src='<?php echo base_url(); ?>assets/images/file_uploaded.png'></a>
                                                       </div>

                                                   </div>
                                                   <div class="col-md-4 text-center">
                                                       <span><?php echo $single['outbound_express']; ?></span>
                                                       <span><?php echo $single['outbound_express_date'] ?></span>
                                                   </div>
                                               <?php } ?>
                                           </div>
                                           <div class="form-group">
                                               <div class="col-md-3 text-center">
                                                   <strong>Outbound<br/>
                                                       Economy</strong>
                                               </div>
                                               <div class="col-md-3">
                                                   <div class="form-group">
                                                       <label class="btn btn-default btn-file select-doc-file">
                                                           Select File <input type="file" class="outband_exp"
                                                                              name="outbound_economy"
                                                                              class="form-control"
                                                                              style="display: none;">
                                                       </label>
                                                   </div>
                                               </div>
                                               <?php if (!empty($single['outbound_economy'])) { ?>
                                                   <div class="col-md-2 col-md-push-1">
                                                       <div class="image_div price_page_image">
                                                           <img class=' admin_delete_img admin_delete_process'
                                                                data-name='outbound_economy'
                                                                src='<?php echo base_url(); ?>assets/images/x_document.png'>
                                                           <a href="<?php echo base_url('admin/price_page/currier_file/' . $iso . '/' . $single['outbound_economy']); ?>"
                                                              target="_blank"> <img class="main_img"
                                                                                    src='<?php echo base_url(); ?>assets/images/file_uploaded.png'></a>
                                                       </div>
                                                   </div>
                                                   <div class="col-md-4 text-center">
                                                       <span><?php echo $single['outbound_economy']; ?></span>
                                                       <span><?php echo $single['outbound_economy_date']; ?></span>
                                                   </div>
                                               <?php }
                                               }?>
                                           </div>
                                           <div class="form-group">
                                           <?php if($single['intern_in'] > 0) { ?>
                                               <div class="col-md-3 text-center">
                                                   <strong>Inbound<br/>
                                                       Express</strong>
                                               </div>
                                               <div class="col-md-3">
                                                   <div class="form-group">
                                                       <label class="btn btn-default btn-file select-doc-file">
                                                           Select File <input type="file" class="outband_exp"
                                                                              name="inbound_express"
                                                                              class="form-control"
                                                                              style="display: none;">
                                                       </label>
                                                   </div>
                                               </div>
                                               <?php if (!empty($single['inbound_express'])) { ?>
                                                   <div class="col-md-2 col-md-push-1">
                                                       <div class="image_div price_page_image">
                                                           <img class=' admin_delete_img admin_delete_process'
                                                                data-name='inbound_express'
                                                                src='<?php echo base_url(); ?>assets/images/x_document.png'>
                                                           <a href="<?php echo base_url('admin/price_page/currier_file/' . $iso . '/' . $single['inbound_express']); ?>"
                                                              target="_blank"> <img class="main_img"
                                                                                    src='<?php echo base_url(); ?>assets/images/file_uploaded.png'></a>
                                                       </div>


                                                   </div>
                                                   <div class="col-md-4 text-center">
                                                       <span><?php echo $single['inbound_express']; ?></span>
                                                       <span><?php echo $single['inbound_express_date']; ?></span>
                                                   </div>
                                               <?php } ?>
                                           </div>
                                           <div class="form-group">
                                               <div class="col-md-3 text-center">
                                                   <strong>Inbound<br/>
                                                       Economy</strong>
                                               </div>
                                               <div class="col-md-3">
                                                   <div class="form-group">
                                                       <label class="btn btn-default btn-file select-doc-file">
                                                           Select File <input type="file" class="outband_exp"
                                                                              name="inbound_economy"
                                                                              class="form-control"
                                                                              style="display: none;">
                                                       </label>
                                                   </div>
                                               </div>
                                               <?php if (!empty($single['inbound_economy'])) { ?>
                                                   <div class="col-md-2 col-md-push-1">
                                                       <div class="image_div price_page_image">
                                                           <img class=' admin_delete_img admin_delete_process'
                                                                data-name='inbound_economy'
                                                                src='<?php echo base_url(); ?>assets/images/x_document.png'>
                                                           <a href="<?php echo base_url('admin/price_page/currier_file/' . $iso . '/' . $single['inbound_economy']); ?>"
                                                              target="_blank"> <img class="main_img"
                                                                                    src='<?php echo base_url(); ?>assets/images/file_uploaded.png'></a>
                                                       </div>
                                                   </div>
                                                   <div class="col-md-4 text-center">
                                                       <span><?php echo $single['inbound_economy']; ?></span>
                                                       <span><?php echo $single['inbound_economy_date']; ?></span>
                                                   </div>
                                               <?php }
                                               }
                                               ?>
                                           </div>

                                           <div class="remote-area">
                                               <div class="row">
                                                   <div class="col-md-4 text-center">
                                                       <h5><strong>Remote Area Surcharge</strong></h5>
                                                       <div class="form-inline some-margin">
                                                           <div class="col-md-6">
                                                               <label for="">Per LBS</label>
                                                               <input type="text" name="per_lbs" class="form-control small-input not_string"
                                                                      placeholder="" value="<?php show_price((!empty($single['per_lbs'])?$single['per_lbs']:'')); ?>">
                                                           </div>
                                                           <div class="col-md-6">
                                                               <label for="">Min</label>
                                                               <input type="text" name="min" class="form-control small-input not_string"
                                                                      placeholder="" value="<?php show_price((!empty($single['min'])?$single['min']:'')); ?>">
                                                           </div>
                                                       </div>
                                                   </div>
                                                   <div class="col-md-5 text-center">
                                                       <h5><strong>Over Size Surcharge</strong></h5>
                                                       <div class="row">
                                                           <div class="form-inline">
                                                               <div class="col-md-4">

                                                                   <label for="">Max Length</label>
                                                                   <input type="text" name="max_length" class="form-control small-input not_string"
                                                                          placeholder="" value="<?php  show_price((!empty($single['max_length'])?$single['max_length']:'')); ?>">
                                                               </div>
                                                               <div class="col-md-4">
                                                                   <label for="">Max Weight</label>
                                                                   <input type="text" name="max_weight" class="form-control small-input not_string"
                                                                          placeholder="" value="<?php  show_price((!empty($single['max_weight'])?$single['max_weight']:'')); ?>">
                                                               </div>
                                                               <div class="col-md-4">
                                                                   <label for="">Sur Charge</label>
                                                                   <input type="text" name="sur_charge" class="form-control small-input not_string"
                                                                          placeholder="" value="<?php   show_price((!empty($single['sur_charge'])?$single['sur_charge']:'')); ?>" >
                                                               </div>
                                                           </div>
                                                       </div>
                                                   </div>
                                                   <div class="col-md-3 text-left">
                                                       <div class="remt-area-btn">
                                                           <span class="form-small-font display-inline">11-30-16 13:45pm</span>
                                                       </div>
                                                       <button type="button"
                                                               class="btn btn-default btn-login-orange adm-btn save_curriers">Save
                                                       </button>
                                                   </div>
                                               </div>

                                           </div>
                                       </div>

                                   </form>

                                   <?php
                               }
                           }
                           ?>
                        </div>

                        <div class="col-md-6 domestic-shipment">
                            <h2 class="text-center">Domestic Shipment</h2>
                            <form method="post" class="form-horizontal" action="">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <div class="col-sm-12 col-xs-12">
                                                <select class="form-control selectpicker document_name" name="" id="domestic_file_name">
                                                    <option value="">Select File Name</option>
                                                    <?php
                                                    foreach($document_select as $object){
                                                        ?>
                                                        <option value="<?php echo $object->id; ?>"><?php echo $object->title; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12 col-xs-12">
                                                <label class="btn btn-default btn-file select-doc-file">
                                                    Select File <input type="file" class="form-control domestic_doc_file" style="display: none;">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-md-push-1">
                                        <div class="form-group">
                                            <div class="doc-file-place">
                                               <?php
                                               echo $dom_documents_block;
                                               ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-9">
                                        <textarea class="form-control dom_comment"  placeholder="Note"><?php echo (!empty($dom_comment))?$dom_comment[0]['comment']:''; ?></textarea>
                                    </div>

                                    <div class="col-md-3 text-left">
                                        <button type="button" id="save_dom_comments" class="btn btn-default btn-login-orange adm-btn">Save</button>
                                        <div>
                                            <span class="form-small-font display-inline">11-30-16 13:45pm</span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <p class="border-bottom"></p>
                            <form method="post" class="form-horizontal form-small-font form-display-span" action="">
                                <div class="rounded-noborder">
                                    <div class="form-group">
                                        <div class="col-md-3 text-center">
                                            <strong>Distance &<br />
                                                Delivery Time</strong>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="btn btn-default btn-file select-doc-file">
                                                    Select File <input type="file" id="domestic_delivery_time" name="" class="form-control" style="display: none;">
                                                </label>
                                            </div>
                                        </div>

                                        <?php if(!empty($delivery_time['domes'])){ ?>
                                        <div class="col-md-2 col-md-push-1">
                                            <div class="image_div price_page_image">
                                                <img class=' admin_delete_img delete_domestic_delivery_time'
                                                     data-name='<?php echo $delivery_time['domes'][0]['file_name']; ?>'
                                                     src='<?php echo base_url(); ?>assets/images/x_document.png'>
                                                <a href="<?php echo base_url('admin/price_page/currier_file/' . $iso . '/' .$delivery_time['domes'][0]['file_name']); ?>"
                                                   target="_blank"> <img class="main_img"
                                                                         src='<?php echo base_url(); ?>assets/images/file_uploaded.png'></a>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <span><?php echo $delivery_time['domes'][0]['file_name']; ?></span>
                                            <span><?php echo$delivery_time['domes'][0]['date']; ?></span>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </form>
                            <?php
                            if(!empty($dom_curriers)) {
                            foreach ($dom_curriers as $single) {
                                if ($single['domestic'] > 0) {
                                    ?>
                                    <form method="post" class="form-horizontal form-small-font form-display-span"
                                          action="" id="dom_currier_<?php echo $single['id']; ?>">
                                        <input type="hidden" name="currier_id" class="currier_id"
                                               value="<?php echo $single['id']; ?>">
                                        <div class="rounded-border">
                                            <div class="form-group">
                                                <div class="col-md-3 text-left">
                                                    <h5 class="red-text bold"><?php echo $single['name']; ?></h5>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-3 text-center">
                                                    <strong><?php echo $single['name']; ?><br/>
                                                        Domestic</strong>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="btn btn-default btn-file select-doc-file">
                                                            Select File <input type="file"  name="Domestic" class="form-control domestic_upload_file"
                                                                               style="display: none;">
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php if(!empty($single['Domestic'])){  ?>
                                                    <div class="col-md-2 col-md-push-1">
                                                        <div class="image_div price_page_image">
                                                            <img class=' admin_delete_img delete_domestic_currier'
                                                                 data-name='<?php echo  $single['Domestic']; ?>' data-block = 'Domestic' data_currier = '<?php echo $single['id']; ?>'
                                                                 src='<?php echo base_url(); ?>assets/images/x_document.png'>
                                                            <a href="<?php echo base_url('admin/price_page/currier_file/' . $iso . '/' . $single['Domestic']); ?>"
                                                               target="_blank"> <img class="main_img"
                                                                                     src='<?php echo base_url(); ?>assets/images/file_uploaded.png'></a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 text-center">
                                                        <span><?php echo $single['Domestic']; ?></span>
                                                        <span><?php echo $single['Domestic_date']; ?></span>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="remote-area">
                                                <div class="row">
                                                    <div class="col-md-4 text-center">
                                                        <h5><strong>Remote Area Surcharge</strong></h5>
                                                        <div class="form-inline some-margin">
                                                            <div class="col-md-6">
                                                                <label for="">Per LBS</label>
                                                                <input type="text" name="per_lbs" class="form-control small-input not_string"
                                                                       placeholder="" value="<?php  show_price((!empty($single['per_lbs'])?$single['per_lbs']:'')); ?>">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="">Min</label>
                                                                <input type="text" name="min" class="form-control small-input not_string"
                                                                       placeholder="" value="<?php  show_price((!empty($single['min'])?$single['min']:'')); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5 text-center">
                                                        <h5><strong>Over Size Surcharge</strong></h5>
                                                        <div class="row">
                                                            <div class="form-inline">
                                                                <div class="col-md-4">

                                                                    <label for="">Max Length</label>
                                                                    <input type="text" name="max_length" class="form-control small-input not_string"
                                                                           placeholder="" value="<?php  show_price((!empty($single['max_length'])?$single['max_length']:'')); ?>">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="">Max Weight</label>
                                                                    <input type="text" name="max_weight" class="form-control small-input not_string"
                                                                           placeholder="" value="<?php  show_price((!empty($single['max_weight'])?$single['max_weight']:'')); ?>">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="">Sur Charge</label>
                                                                    <input type="text" name="sur_charge" class="form-control small-input not_string"
                                                                           placeholder="" value="<?php show_price((!empty($single['sur_charge'])?$single['sur_charge']:'')); ?>" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 text-left">
                                                        <div class="remt-area-btn">
                                                            <span class="form-small-font display-inline">141-30-16 13:45pm</span>
                                                        </div>
                                                        <button type="button"
                                                                class="btn btn-default btn-login-orange adm-btn save_curriers_dom">Save
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </form>
                                <?php }
                            }
                            }?>

                            <form method="post" class="form-horizontal form-small-font form-display-span" action="">

                                <div class="rounded-border">
                                    <div class="form-group">
                                        <div class="col-md-6 text-left">
                                            <table>
                                                <tr>
                                                    <td> <h5 class="red-text bold"><?php echo $iso; ?> Calendar </h5></td>
                                                    <td><i class="fa fa-calendar click_calendar" aria-hidden="true"></i></td>
                                                </tr>
                                            </table>

                                        </div>
                                    </div>
                                    <table class="table table-bordered designed-table" id="date_table">
                                        <thead>

                                        <?php
                                        $hol_value = '';
                                        $colspan = '';
                                        if(!empty($holidays)){
                                            $colspan = count($holidays);
                                            foreach ($holidays as $holiday_inp){

                                                $hol_value .= $holiday_inp['day'].',';

                                            }
                                            $hol_value = substr($hol_value,0,-1);
                                        }
                                        ?>
                                        <tr>
                                            <th class="text-left" colspan="<?php echo $colspan; ?>">
                                                <input type="text" class="form-control extra-date hidden_date" name="extra_date" id="extra_date" placeholder="Select date" value="<?php echo $hol_value; ?>">
                                                <small>EXTRA DATE</small>
                                            </th>
                                        </tr>
                                        </thead>
                                    </table>
                                        <div class="extra_calendar">
                                            <?php if(!empty($holidays)){
                                                foreach ($holidays as $num => $holiday){ ?>
                                                    <div class="extra_calendar_child"><span><?php echo $holiday['day']; ?></span></div>
                                               <?php } } else{ ?>
                                            <td></td>
                                            <?php } ?>
                                          <br class="clear">
                                        </div>

                                    <div>
                                        <button type="button"
                                                class="btn btn-default btn-login-orange adm-btn save_holidays_calendar ">Save
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <form method="post" class="form-horizontal form-small-font form-display-span" action="">

                                <div class="rounded-border">
                                    <div class="form-group">
                                        <div class="col-md-6 text-left">
                                            <table>
                                                <tr>
                                                    <td> <h5 class="red-text bold"><?php echo $iso; ?>  Calendar </h5></td>
                                                    <td><i class="fa fa-calendar click_dinamic_calendar" aria-hidden="true"></i></td>
                                                </tr>
                                            </table>

                                        </div>
                                    </div>
                                    <table class="table table-bordered designed-table" id="dinamic_table">
                                        <thead>

                                     <?php
                                        $din_value = '';
                                        $colspan = '';
                                        if(!empty($dinamic_day)){
                                            $colspan = count($dinamic_day);
                                            foreach ($dinamic_day as $dinamic){

                                                $din_value .= $dinamic['day'].',';

                                            }
                                            $din_value = substr($din_value,0,-1);
                                        }

                                     ?>
                                        <tr>
                                            <th class="text-left" colspan="<?php echo $colspan; ?>">
                                                <input type="text" class="form-control hidden_dinamic_date" name="dinamic_date" id="dinamic_date" placeholder="Select date" value="<?php echo $din_value; ?>">
                                                <small>DINAMIC DATE</small>
                                            </th>
                                        </tr>
                                        </thead>
                                    </table>
                                    <div class="dinamic_calendar">
                                        <?php if(!empty($dinamic_day)){
                                            foreach ($dinamic_day as $num => $dinamic){  ?>
                                                <div class="dinamic_calendar_child"><span><?php echo $dinamic['day']; ?></span></div>
                                            <?php } } else{ ?>
                                            <td></td>
                                            <?php } ?>
                                        <br class="clear">
                                    </div>

                                    <div>
                                        <button type="button"
                                                class="btn btn-default btn-login-orange adm-btn save_dinamic_holidays_calendar ">Save
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <form method="post" class="form-horizontal form-small-font form-display-span" action="">
                                <div class="rounded-border">
                                    <div class="form-group">
                                        <div class="col-md-3 text-left">
                                            <h5 class="red-text bold"><?php echo $iso; ?>  Calendar</h5>
                                        </div>
                                    </div>
                                    <table class="table table-bordered designed-table">
                                        <thead>

                                        <tr>
                                           <th>Mon.</th>
                                           <th>Tue.</th>
                                           <th>Wed.</th>
                                           <th>Thu.</th>
                                           <th>Fri.</th>
                                           <th>Sat</th>
                                           <th>Sun.</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><input type="checkbox" name="mon" value="1"  <?php echo (!empty($weekend[0]['mon']))?'checked = "checked" ':''; ?> ></td>
                                            <td><input type="checkbox" name="tue" value="1"  <?php echo (!empty($weekend[0]['tue']))?'checked = "checked" ':''; ?>></td>
                                            <td><input type="checkbox" name="wed" value="1"  <?php echo (!empty($weekend[0]['wed']))?'checked = "checked" ':''; ?>></td>
                                            <td><input type="checkbox" name="thu" value="1"  <?php echo (!empty($weekend[0]['thu']))?'checked = "checked" ':''; ?>></td>
                                            <td><input type="checkbox" name="fri" value="1"  <?php echo (!empty($weekend[0]['fri']))?'checked = "checked" ':''; ?>></td>
                                            <td><input type="checkbox" name="sat" value="1"  <?php echo (!empty($weekend[0]['sat']))?'checked = "checked" ':''; ?>></td>
                                            <td><input type="checkbox" name="sun" value="1"  <?php echo (!empty($weekend[0]['sun']))?'checked = "checked" ':''; ?>></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <button type="button"
                                            class="btn btn-default btn-login-orange adm-btn save_weekend_calendar ">Save
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="tab-pane account-info <?php echo $add_activ; ?>" id="country_profile">

                </div>
                <div class="tab-pane" id="extra_charges">

                </div>
                <div class="tab-pane" id="product">

                </div>
            </div>
        </div>

    </div>
</div>
