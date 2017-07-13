<?php
$this->load->view("partial/header");
?>
<script type="text/javascript" src="<?php echo site_url('asset/ckeditor/ckeditor.js'); ?>"></script>
<script type="text/javascript" src="<?php echo site_url('asset/ckfinder/ckfinder.js'); ?>"></script>
<div id="page_title" style="margin-bottom:8px;"><?php echo $title ?></div>
<div id="page_subtitle" style="margin-bottom:8px;"><?php echo $temp->name ?></div>
<ul id="error_message_box"></ul>




<?php


echo form_open('giftcards/data_submitted',array('id' => 'myform'));
echo '<fieldset>';
echo'<div class="field_row clearfix">';	
if($receiptstat=='true')

{
echo form_label('Payment Receipt No:' . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'. $secretword);


echo '</div>


<input type="hidden" name="receipt_details" value="'.$secretword.'" />

<input type="hidden" name="type" value="'.$temp->name.'" />';

echo $this->ckeditor->editor("info", $temp->content);

echo "</div>";
?>
<button type="submit" class="btnsub" name="btnprint" onclick="print('info')">Print</button>
<p></p>
<?php 
echo'<div class="result_lab clearfix">';	
echo form_label('   EDIT TEMPLATE NAME(IF NEEDED):' );
$sales = array(
'name' => 'test_name',
'id' => 'test_name',
'class' => 'input_box',
 'size'        => '40',
'value' => $temp->name 
);
echo'<br/>';
echo form_input($sales);
echo '</div>';

?>

<button type="submit" class="btnsub" name="btnprintsave" onclick="print('info')">Save & Print</button>
<?php } ?>
<script>
    function print(editorName) {
	
		 if(!confirm('Are you sure you want print? You cannot undo it after clicking Ok.')){event.preventDefault();}
		
		else{
	    var editor = CKEDITOR.instances[editorName];           
        editor.execCommand('print');
		
		document.myform.submit();
		
	}

    }
</script>
</div>

<?php echo form_close(); ?>

</fieldset>


<?php
$this->load->view("partial/footer"); 
?>

