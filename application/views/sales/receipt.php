<?php $this->load->view("partial/header_receipt"); ?>

<a href=<?php echo site_url("home"); ?>><?php echo $this->lang->line("module_home"); ?></a>
<?php
if (isset($error_message))
{
	echo '<h1 style="text-align: center;">'.$error_message.'</h1>';
	exit;
}
?>
<div id="receipt_wrapper">
	<div id="receipt_header">
		<div id="company_name"><?php echo $this->config->item('company'); ?></div>
		<div id="company_phone"><?php echo $this->config->item('phone'); ?></div>
		<div id="sale_receipt"><?php echo $receipt_title; ?></div>
		<div id="sale_time"><?php echo $transaction_time ?></div>
	</div>
	<div id="receipt_general_info">
		<?php if(isset($customer))
		{
		?>
			<div id="customer"><?php echo $this->lang->line('customers_customer').": ".$customer; ?></div>
		<?php
		}
		?>
		<div id="sale_id"><?php echo $this->lang->line('sales_id').": ".$sale_id; ?></div>
		<div id="employee"><?php echo $this->lang->line('employees_employee').": ".$employee; ?></div>
	</div>

	<table id="receipt_items">
	<tr>
	<th style="width:50%;"><?php echo $this->lang->line('items_item'); ?></th>
	<th style="width:20%;"><?php echo $this->lang->line('common_price'); ?></th>
	<th style="width:10%;text-align:center;"><?php echo $this->lang->line('sales_discount'); ?></th>
	<th style="width:20%;text-align:right;"><?php echo $this->lang->line('sales_total'); ?></th>
	</tr>
	<?php
	foreach(array_reverse($cart, true) as $line=>$item)
	{
	?>
		<tr>
		
		<td><span class='long_name'><?php echo $item['name']; ?></span><span class='short_name'><?php echo character_limiter($item['name'],30); ?></span></td>
		<td><?php echo to_currency($item['price']); ?></td>
		<td style='text-align:center;'><?php echo $item['discount']; ?></td>
		<td style='text-align:right;'><?php echo to_currency($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100); ?></td>
		</tr>

	    <tr>
	    <td colspan="2" align="center"><?php echo $item['description']; ?></td>
		<td colspan="2" ><?php echo $item['serialnumber']; ?></td>
		<td colspan="2"><?php echo '&nbsp;'; ?></td>
	    </tr>

	<?php
	}
	?>

	<tr>
	<td colspan="2" style='text-align:right;border-top:2px solid #000000;'><?php echo $this->lang->line('sales_change_due'); ?></td>
		<td colspan="1" style='text-align:right;border-top:2px solid #000000;'><?php echo  $amount_change; ?></td>
	<td colspan="2" style='text-align:right;border-top:2px solid #000000;'><?php echo $this->lang->line('sales_total'); ?></td>
	<td colspan="1" style='text-align:right;border-top:2px solid #000000;'><?php echo to_currency($total); ?></td>
	</tr>

  <!--  <tr><td colspan="6">&nbsp;</td></tr> -->

	
	<?php
		foreach($payments as $payment_id=>$payment)
	{ ?>
		<tr>
		<td colspan="2" style="text-align:right;"><?php echo $this->lang->line('sales_payment'); ?></td>
		<td colspan="2" style="text-align:right;"><?php $splitpayment=explode(':',$payment['payment_type']); echo $splitpayment[0]; ?> </td>
		<td colspan="2" style="text-align:right"><?php echo to_currency( $payment['payment_amount'] * -1 ); ?>  </td>
	    </tr>
	<?php
	}
	?>

   <!-- <tr><td colspan="6">&nbsp;</td></tr> -->

	</table>

</div>
<?php $this->load->view("partial/footer"); ?>

<?php if ($this->Appconfig->get('print_after_sale'))
{
?>
<script type="text/javascript">
$(window).load(function()
{
	window.print();
});
</script>
<?php
}
?>