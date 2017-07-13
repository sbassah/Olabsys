<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<base href="<?php echo base_url();?>" />
<link href="<?php echo base_url();?>css/poschief.css" rel="stylesheet" type="text/css" rev="stylesheet" />

<title>OLAB</title>

<script>BASE_URL = '<?php echo site_url(); ?>';</script>
	<script src="<?php echo base_url();?>js/jquery-1.2.6.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.color.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.metadata.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.form.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.tablesorter.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.ajax_queue.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.bgiframe.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.autocomplete.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.validate.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.jkey-1.1.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/thickbox.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/common.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/manage_tables.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/swfobject.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/date.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/datepicker.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	
</head>

<body>
<div id="main">
	<div id="level0">
    <p id="header1"><?php echo $this->config->item('company'); ?> <?php echo $this->lang->line("common_pos_software");?> </p>
	  
	    <div id="logstrip"><ul>
							<li><a href=<?php echo site_url("home"); ?>><?php echo $this->lang->line("module_home"); ?></a>							
							</li>  |
							<li><a href=<?php echo site_url("customers"); ?> ><?php echo $this->lang->line("module_customers"); ?></a> </li> |
							<li><a href=<?php echo site_url("employees"); ?>><?php echo $this->lang->line("module_employees"); ?></a> </li> |
							<li><a href=<?php echo site_url("items"); ?>><?php echo $this->lang->line("module_items"); ?></a>	</li> |
							<li><a href=<?php echo site_url("sales"); ?>><?php echo $this->lang->line("module_sales_register"); ?></a></li> |
							<li><a href=<?php echo site_url("giftcards"); ?>><?php echo $this->lang->line("module_results"); ?></a> </li> |
				
							<li><a href=<?php echo site_url("suppliers"); ?>><?php echo $this->lang->line("module_suppliers"); ?></a></li> |
							<li><a href=<?php echo site_url("item_kits"); ?>><?php echo $this->lang->line("module_item_kits"); ?></a></li> |
                           <li><a href=<?php echo site_url("reports"); ?>><?php echo $this->lang->line("module_reports"); ?></a></li> |
						   <li><a href=<?php echo site_url("config"); ?>><?php echo $this->lang->line("module_config"); ?></a></li> 
							
												
							
	    </ul><font><?php echo $this->lang->line('common_welcome')." $user_info->first_name $user_info->last_name! |"; ?><?php echo anchor("home/logout",$this->lang->line("common_logout")); ?> </font>		</div>				
	  
		<div id="mainArea">
                    
                    <script>
                        $(document).ready(function(){
                            $("#logstrip li li a").hide();
                            $("div#logstrip").mouseout(function(){
                                $("#logstrip li li a").hide();
                            });
                            $("#people_btn").mouseover(function(){
                                $("#logstrip li li a").hide();
                                $("li#people_btn a").show();                                
                            });
                            $("#inv_btn").mouseover(function(){
                                $("#logstrip li li a").hide();
                                $("li#inv_btn a").show(); 
                            });
                            $("#set_btn").mouseover(function(){
                                $("#logstrip li li a").hide();
                                $("li#set_btn a").show(); 
                            });
                        } );
                        
                    </script>