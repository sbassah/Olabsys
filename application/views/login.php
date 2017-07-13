<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/login.css" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>OLABSYS <?php echo $this->lang->line('login_login'); ?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>/images/favicon.ico">
	<script src="<?php echo base_url();?>js/jquery-1.8.3.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script type="text/javascript">
		$(document).ready(function()
		{
			$("#login_form input:first").focus();
		});
	</script>
</head>

<body>

<div id="login">
<h1 style="color: #FFFFFF;"><?php echo $this->config->item('company'); ?> </h1>
<?php
if ($_SERVER['HTTP_HOST'] == 'ospos.pappastech.com')
{
?>
<?php
}
?>
	
<?php echo form_open('login') ?>
<div id="container">
<?php echo validation_errors(); ?>
	<div id="top">

	</div>
	<div id="login_form">
		<div id="welcome_message">
		<?php echo $this->lang->line('login_welcome_message'); ?>
		</div>
		<br/>
		<div class="form_field_label"><?php echo $this->lang->line('login_username'); ?>: </div>
		<div class="form_field">
		<?php echo form_input(array(
		'name'=>'username', 
		'value'=> $_SERVER['HTTP_HOST'] == 'ospos.pappastech.com' ? 'admin' : '',
		'size'=>'20')); ?>
		</div>

		<div class="form_field_label"><?php echo $this->lang->line('login_password'); ?>: </div>
		<div class="form_field">
		<?php echo form_password(array(
		'name'=>'password', 
		'value'=>$_SERVER['HTTP_HOST'] == 'ospos.pappastech.com' ? 'pointofsale' : '',
		'size'=>'20')); ?>
		
		</div>
		
		<div id="submit_button">
		<?php echo form_submit('loginButton','Login'); ?>
		</div>
	</div>
	</div>

<?php echo form_close(); ?>
<div id="footer">Product of <a href="http://www.ozyplusmedia.com" target="_blank">Ozyplus Media</a></div>
</div>
</body>
</html>
