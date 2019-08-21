<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<title>Invoice Print</title>
	<link rel="stylesheet" type="text/css"  href="<?php echo asset_url();?>css/style2.css" />
  </head>
  <body>
	<header class="clearfix">
		<div id="logo" >
				<img src="<?php echo asset_url().'images/web-req/logo1.png'?>">
				<h2>StockHUB</h2>
	  	</div>
	  <h1>INVOICE</h1>
	  <div id="company" class="clearfix">
		<div>StockHUB</div>
		<div>Christ University,<br /> Hosur Road</div>
		<div>Bengaluru - 560029</div>
		<div>Karnataka</div>
		<div><a href="mailto:stockhub.christ@gmail.com">stockhub.christ@gmail.com</a></div>
	  </div>
	</header>
	<main>
			  <div id="project">
				<div>TENDER DETAILS</div>
				<br>
				<div><span>TENDER ID</span>#<?php echo $tender['tender_id']?></div>
				<div><span>MATERIAL</span><?php echo $tender['rm_name']?></div>
				<div><span>MATERIAL CATEGORY</span><?php echo $tender['subcat_name']?></div>
				<div><span>QUANTITY</span><?php echo $transaction['quantity']." ".$transaction['quantity_unit']?></div>
				<div><span>PRICE</span><?php echo $transaction['quoted_price']?></div>
				<div><span>DELIVERY LOCATION</span><?php echo ($address_arr['building_no'].", ".$address_arr['street'].", ".$address_arr['city'].", ".$address_arr['state'].", ".$address_arr['country'].". Pincode : ".$address_arr['pincode'].". Landmark : ".$address_arr['land_mark']); ?></div>
				<div><span>EXTRA INFO</span><?php echo $tender['extra_info']?></div>
				<div><span>DATE OF SUBMISSION</span><?php echo $tender['date_of_submission']?></div>
				<div><span>TIME OF SUBMISSION</span><?php echo $tender['time_submission']?></div>
				<div><span>DATE OF EXPIRY</span><?php echo $tender['date_expire']?></div>
				<div><span>TIME OF EXPIRY</span><?php echo $tender['time_expire']?></div>
			  </div>
			  <br>
			  <div id="project">
				<div>TRANSACTION DETAILS</div>
				<br>
				<div><span>TRANSACTION ID</span>#<?php echo $transaction['trans_id']?></div>
				<div><span>DELAY TIME</span><?php echo $transaction['trans_delay_time']." ".$transaction['trans_delay_unit']?></div>
				<div><span>DELIVERY DATE</span><?php echo $transaction['delivery_date']?></div>
			  </div>
			  <br>
			  <div id="project">
				<div>MANUFACTURER DETAILS</div>
				<br>
				<div><span>NAME</span><?php echo $tender['m_firstname']." ".$tender['m_lastname']?></div>
				<div><span>MANUFACTURER ID</span><?php echo $tender['m_id']?></div>
				<div><span>USERNAME</span><?php echo $tender['m_username']?></div>
				<div><span>EMAIL</span><?php echo $tender['m_email']?></div>
			  </div>
			  <br>
			  <div id="project">
				<div>VENDOR DETAILS</div>
				<br>
				<?php foreach($DiffVendorRequests as $DiffVendorRequest):?>
					<?php if($DiffVendorRequest['req_status'] === "accepted"):?>
						<div><span>NAME</span><?php echo $DiffVendorRequest['v_firstname']." ".$DiffVendorRequest['v_lastname']?></div>
						<div><span>VENDOR ID</span><?php echo $DiffVendorRequest['vendor_id']?></div>
						<div><span>EMAIL</span><?php echo $DiffVendorRequest['v_email']?></div>
						<div><span>USERNAME</span><?php echo $DiffVendorRequest['v_username']?></div>
						<div><span>ORGANISATION NAME</span><?php echo $DiffVendorRequest['v_org_name']?></div>
						<div><span>WEBSITE</span><?php echo $DiffVendorRequest['v_website']?></div>
					<?php endif;?>
				<?php endforeach;?>
			  </div>
	  <br>
	  
	</main>
	<footer>
	  Invoice was created on a computer and is valid without the signature and seal.
	</footer>

	<script type="text/javascript">
	window.print();
	</script>
  </body>
</html>