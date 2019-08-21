<div class="container">
    <div class="col-md-6 col-md-offset-3  col-sm-5 col-sm-offset-3 col-xs-10 col-xs-offset-1">

        <?php if($toID[0] === 'V'): ?>
            <h1 class="text-center"><?= $title; ?> with <?php echo($id1['v_firstname']." ".$id1['v_lastname'])?> </h1>
        <?php else:?>
            <h1 class="text-center"><?= $title; ?> with <?php echo($id1['m_firstname']." ".$id1['m_lastname'])?> </h1>
        <?php endif;?>

            <?php foreach($messages as $message): ?>

                <?php if($message['from_id'] === ucfirst($this->session->userdata('user_id')) ) : ?>

                    <div class="chat_style_receive">
                        <h3 class="h3-margin-top-change h3-margin-bottom-change"><?php echo($message['message_body'])?></h3>
                        <small class="chat_style_send_sub"><em>Sent - <?php echo($message['message_time'])?></em></small>
                    </div>

                <?php else:?>

                    <div class="chat_style_send">
                        <h3 class="h3-margin-top-change h3-margin-bottom-change"><?php echo($message['message_body'])?></h3>
                        <small class="chat_style_send_sub"><em>Recieved - <?php echo($message['message_time'])?></em></small>
                    </div>

                <?php endif;?>

            <?php endforeach; ?>

    <br>
        <!-- ==================== sent message =============================== -->
            
        <?php echo form_open('users/sendMessage/'.($toID)); ?>
            <div class="row">

                <div class="form-group">
                    <div class="input-group"> 
                        <span class="input-group-addon"><i class="glyphicon glyphicon-comment"></i></span>
                        <textarea class="form-control" rows="8" id="message" placeholder="Max 300 characters" maxlength="300" name="message" required></textarea>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6">
                        <a class="btn btn-default btn-block"  href="<?php echo base_url(); ?>userdashboard">Go Back</a>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success btn-block">Submit</button>
                    </div>
                </div>

            </div>
            
        <?php echo form_close(); ?>
    </div>
</div>