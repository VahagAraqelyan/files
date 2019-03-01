<div class="content">
    <div class="container">
        <?php
        if(!empty($data['posts'])){
            foreach ($data['posts'] as $index =>$val){ ?>
                <div class="card posts">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $val['name']?></h5>
                        <p class="card-text"><?php echo $val['description']?></p>
                        <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#colapse_<?php echo $val['id']?>">comment</button>
                        <div class="collapse" id="colapse_<?php echo $val['id']?>">
                           <?php
                               if(!empty($val['comment'])){

                                   foreach ($val['comment'] as $single){  ?>

                                       <p style="margin: 5px"><?php echo $single['comment'];?></p>
                                  <?php } } ?>
                            <?php
                            if($data['login_bool']){ ?>
                                <form method="post" class="add_comment_form">
                                    <input type="hidden" name="post_id" value="<?php echo $val['id']?>">
                                    <textarea name="comment" cols="20" rows="3"></textarea>
                                    <button type="button" class="btn btn-primary add_comment" id="">Add comment</button>
                                </form>
                           <?php } ?>

                        </div>

                    </div>
                </div>
            <?php } } ?>
    </div>
</div>