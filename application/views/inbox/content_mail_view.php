 
    <div class="modal-dialog" style="width:800px; ">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Mail</h4>
        </div>
		<form role="form" id="mail_form_content_1" onsubmit="return app.answerMail(this);" >
			<input type="hidden" name="h_mail_id" id="h_mail_id" value="<?php echo $row->id ?>" />
			<input type="hidden" name="h_mail_g" id="h_mail_g" value="<?php echo $row->group_id ?>" />
			<input type="hidden" name="h_mail_sg" id="h_mail_sg" value="<?php echo $row->subgroup_id ?>" />
			<input type="hidden" name="h_mail_option" id="h_mail_option" value="" />
			<input type="hidden" name="h_mail_centerid" id="h_mail_centerid" value="<?php echo $row->center_id ?>" />
			<input type="hidden" name="h_mail_centername" id="h_mail_centername" value="<?php echo $row->centername ?>" />
			
			<div class="modal-body"> 
				<div class="btn-group">
					<button type="button" class="btn btn-default" id="btn_reply" onclick="app.optionsEnable('reply', 'mail_form_content_1', this)">Reply to Center</button>
					<button type="button" class="btn btn-default" id="btn_forward" onclick="app.optionsEnable('forward', 'mail_form_content_1', this)">Forward</button>
					<button type="button" class="btn btn-default" id="btn_post" onclick="app.optionsEnable('post', 'mail_form_content_1', this)">Post to FAQ</button>
				</div>
				<hr />
				<div class="row">
					 <div class="col-md-6">From: <?php echo $row->mail_from_firstname.' '.$row->mail_from_lastname; ?></div>	
					 <div class="col-md-6">Avaya: <?php echo $row->avaya; ?></div>	 
				</div>
				<div class="row">
					 <div class="col-md-6">Center: <?php echo $row->centername; ?></div>	
					 <div class="col-md-6">Date: <?php echo date('M j Y h:iA',strtotime($row->created_date)); ?></div>	 
				</div>
				<div class="row" id="forward_option" style="display: none">
					<hr />
					<label class="col-lg-2 control-label pull-left" style="line-height: 31px">Forward To: </label>
					<select id="selectGroup" name="selectGroup" class="form-control pull-left" style="width: 180px !important" onchange="app.onSelGroup(this, <?php echo $row->subgroup_id; ?> );">
					<?php 
						$firstkey = '';	
						
						foreach($this->inboxes as $key=>$value): 
							if( $firstkey == '' ) $firstkey = $key;
					?>
						<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
					<?php endforeach; ?>	
					</select>
					<select id="selectSubGroup" name="selectSubGroup" class="form-control pull-left"  style="width: 180px !important" >
					<?php  
						$categories = $this->categories[$firstkey];
						unset($categories[$row->subgroup_id]);
					?>
					<?php foreach( $categories as $key=>$value ): ?>
						<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
					<?php endforeach; ?>	
					</select>					
				</div>
				
				<div class="row" style="padding: 10px 1px; margin:1px; font-size: 12px !important; background-color: #eee" id="div_txt_mail_body" >
				<?php echo stripslashes($row->mail_body); ?>
				</div>
				
				<div style="display:none">
					<br />
					Question:
					<textarea class="form-control" rows="8" name="txt_mail_body" id="txt_mail_body"  style="font-size: 12px !important"><?php echo stripslashes($row->mail_body); ?></textarea>
				</div>
				
				<div style="display:none">
					<br />
					Answer: 
					<textarea class="form-control" rows="7" name="txt_mail_answer" id="txt_mail_answer"  style=""></textarea>				
				</div> 
				
				<div class="checkbox" style="display:none">
					<label>
						<input type="checkbox" name="sendtocenter" id="sendtocenter" value="1">
						Send also to Center
					</label>
				</div>
				
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  <button type="submit" class="btn btn-primary" id="btn_send" style="display:none">Send</button>
			</div>
		</form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  