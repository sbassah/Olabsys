<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
$(document).ready(function()
{
    init_table_sorting();
   
    enable_search('<?php echo site_url("$controller_name/suggest")?>','<?php echo $this->lang->line("common_confirm_search")?>');
   
});

function init_table_sorting()
{
	//Only init if there is more than one row
	if($('.tablesorter tbody tr').length >1)
	{
		$("#sortable_table").tablesorter(
		{
			sortList: [[1,0]],
			headers:
			{
				0: { sorter: false},
				3: { sorter: false}
			}
		});
	}
}

function post_giftcard_form_submit(response)
{
	if(!response.success)
	{
		set_feedback(response.message,'error_message',true);
	}
	else
	{
		//This is an update, just update one row
		if(jQuery.inArray(response.name,get_visible_checkbox_ids()) != -1)
		{
			update_row(response.name,'<?php echo site_url("$controller_name/get_row")?>');
			set_feedback(response.message,'success_message',false);

		}
		else //refresh entire table
		{
			do_search(true,function()
			{
				//highlight new row
				hightlight_row(response.name);
				set_feedback(response.message,'success_message',false);
			});
		}
	}
}

</script>

<?php




if(count($comb_value)!=0 || $secretword !=NULL)
{	
	$str_explode = explode("~", $secretword);
			$receipt_idses = $str_explode[0]; 
			$cust_name = $str_explode[1]; 
			
	echo'<div class="field_row1 clearfix">';	
echo form_label('Payment Receipt No:' . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $receipt_id . $receipt_idses);
echo '<br/>';
echo form_label('Customer Name:' . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'  . $customer_name . $cust_name );


echo '</div>';
?>

<div id="title_bar">
	<div id="title" class="float_left"><?php echo $this->lang->line('Template_List'); ?></div>
	<div id="new_button">
		
	</div>
</div>
<?php echo $this->pagination->create_links();?>
<div id="table_action_header">
	<ul>
		<li class="float_right">
		<img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner' />
		<?php echo form_open("$controller_name/search",array('id'=>'search_form')); ?>
		<input type="text" name ='search' id='search'/>
		</form>
		</li>
	</ul>
</div>

<div id="table_holder">
<?php echo $manage_table; ?>
</div>
<div id="feedback_bar"></div>


<?php }
	else{
	echo  form_label('Please Enter a Valid Receipt Details' );}
 $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{

    $("#receipt_no").autocomplete('<?php echo site_url("giftcards/customer_search"); ?>',
    {
    	minChars:0,
    	delay:10,
    	max:100,
    	formatItem: function(row) {
			return row[1];
		}
    });
	
});
	
	</script>