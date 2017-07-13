<?php $this->load->view("partial/header"); ?>
<div id="panel">
				<div class="lefticon"><a href=<?php echo site_url("customers"); ?>><span class="linkspan"></span></a><img src=<?php echo base_url().'images/menubar/patient.jpg';?> alt="customers" /> Customers - Add, Update, Delete Customers </div>
				
				<div class="middleicon"><a href=<?php echo site_url("items"); ?> ><span class="linkspan"></span></a><img src=<?php echo base_url().'images/menubar/labtest.jpg';?> alt="items" /> Test List - Add, Update, Delete, and Search Tests </div>
			
				<div class="righticon"><a href=<?php echo site_url("employees"); ?> ><span class="linkspan"></span></a><img src=<?php echo base_url().'images/menubar/employee.jpg';?> alt="employees" />Employees - Add, Update, Delete Employees </div>
			
				<div class="lefticon"><a href=<?php echo site_url("sales"); ?> ><span class="linkspan"></span></a><img src=<?php echo base_url().'images/menubar/sales.png';?> alt="sales" width="48" height="48" /> Sales - Process sales and print receipt </div>

<div class="middleicon"><a href=<?php echo site_url("suppliers"); ?> ><span class="linkspan"></span></a><img src=<?php echo base_url().'images/menubar/doctor.jpg';?> alt="item_kits" /> Referring Doctors - Add, Update, Delete and Search Doctors </div>
				
				
					
				<div class=" righticon"><a href=<?php echo site_url("giftcards"); ?> ><span class="linkspan"></span></a><img src=<?php echo base_url().'images/menubar/results.jpg';?> alt="Test Results" />Test Results - View and generate Test Results </div>
				
				
				
				
				<div class="lefticon"><a href=<?php echo site_url("reports"); ?> ><span class="linkspan"></span></a><img src=<?php echo base_url().'images/menubar/reports.jpg';?> alt="reports" /> Reports - View and generate reports </div>
			
			
			
			<div class="middleicon"><a href=<?php echo site_url("item_kits"); ?>><span class="linkspan"></span></a><img src=<?php echo base_url().'images/menubar/temp.jpg';?> alt="Test Results" />Templates  - Add, Update, and Delete Result Template   </div>
               	
				<div class="righticon"><a href=<?php echo site_url("config"); ?> ><span class="linkspan"></span></a><img src=<?php echo base_url().'images/menubar/config.png';?> alt="config" />Configurations - Change the System's configuration </div>
				
			</div>
            
<?php $this->load->view("partial/footer"); ?>