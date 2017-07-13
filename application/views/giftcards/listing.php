
<?php $this->load->view("partial/header"); ?>
<div id="page_title" style="margin-bottom:8px;"><?php echo $this->lang->line('reports_reports'); ?></div>
<div id="welcome_message"><?php echo $this->lang->line('reports_welcome_message'); ?>
<ul id="report_toggle">
	 
	 
	
	<li><h3><?php echo $this->lang->line('reports_summary_reports'); ?></h3>
		<ul>
			<li><a href="<?php echo site_url('giftcards/lab_result');?>"><?php echo $this->lang->line('giftcards_lab_report'); ?></a></li> <br/>
			<li><a href="<?php echo site_url('reports/summary_categories');?>"><?php echo $this->lang->line('giftcards_xray_report'); ?></a></li>  <br/>
			<li><a href="<?php echo site_url('reports/summary_customers');?>"><?php echo $this->lang->line('giftcards_scan_report'); ?></a></li>  <br/>
			<li><a href="<?php echo site_url('reports/summary_customers');?>"><?php echo $this->lang->line('giftcards_chemistry_report'); ?></a></li>  <br/>
		</ul>
	</li>
	
	
</ul>

<?php echo form_input(array('name'=>'item','id'=>'item','size'=>'40'));?>
<?php
if(isset($error))
{
	echo "<div class='error_message'>".$error."</div>";
}
?>
<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{
});
</script>
