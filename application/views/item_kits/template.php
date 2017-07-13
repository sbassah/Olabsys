<?php
$this->load->view("partial/header");
?>
<script type="text/javascript" src="<?php echo site_url('asset/ckeditor/ckeditor.js'); ?>"></script>
<script type="text/javascript" src="<?php echo site_url('asset/ckfinder/ckfinder.js'); ?>"></script>
<div id="page_title" style="margin-bottom:8px;"><?php echo $title ?></div>
<div id="page_subtitle" style="margin-bottom:8px;"><?php echo 'Create a Template for a Test' ?></div>
<ul id="error_message_box"></ul>

<?php
echo form_open('item_kits/temp_created',array('id' => 'myform'));
echo '<fieldset>';
echo'<div class="field_row clearfix">';	
echo form_label('Test Name:' . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
$data_name = array(
'name' => 'test_name',
'id' => 'receipt_no',
'class' => 'input_box',
'placeholder' => 'Enter Name of Test.',
'required' =>'required',
'value' => $temp->name 

);
echo form_input($data_name);
echo '</div>';

echo $this->ckeditor->editor("info", $temp->content);
echo '<input type="hidden" name="temp_id" value="'.$temp->id.'" />';
echo "</div>";
?>
<input type="hidden" name="post_id" value="23453">
<button name="temp_button" type="submit" onclick="return confirm('Are you sure you want to continue')"  class="btnsub">Save</button>

</div>

<?php echo form_close(); ?>

</fieldset>



<?php
$this->load->view("partial/footer"); 
?>