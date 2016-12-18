<html>
	<head>
		<title>SDI Deliver/Reserve</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<script type="text/javascript">
		function setImage(select){
		    var image = document.getElementsByName("image-swap")[0];
		    image.src = "images/"+select.options[select.selectedIndex].value+".png";
		    image.style.height = '100%';
		    image.style.width = '100%';
		}
		</script>
		<script type="text/javascript">
		$(document).ready(function() {
		  $(".utselect").select2();
		});
		</script>
	</head>
	<body>
		<?php
		include '../private_html/database.php';
		?>
		</br>
		<div class="container" style="width:80%">
			<div class="row">
				<div class="panel panel-default" style="width:100%">
					<div class="page-header" >
						<tr><img src="images/coe-branded-logo.png" alt="COE Logo" style="width:300px;height:50px;padding-left:3%">
						<h1 style="font-family:Helvetica Neue; font-weight: 100; letter-spacing: 2px;"><a href="index.php">Service Desk Inventory Application</a>
						<small style="font-family:Helvetica Neue; font-weight: 100; letter-spacing: 2px; font-size: 10px;">by ITO Helpdesk</small></h1>
					</div>
					<div class="panel-body" style="height: calc(260vh + 100px);">
						<div>
							<table>
								<tr>
									<div style="display:inline-block; vertical-align: middle;">
										<td class="center" style="text-align: center;"><form action="checkin.php">
											<input type="submit" value="Check In" class="utbutton">
										</form></td>
										<td class="center"style="text-align: center;"><form action="checkout.php">
											<input type="submit" value="Check Out" class="utbutton">
										</form></td>
										<td class="center"style="text-align: center;"><form action="index.php">
											<input type="submit" value="Main" class="utbutton">
										</form></td>
										<td class="center"style="text-align: center;"><form action="equipment.php">
											<input type="submit" value="Inventory" class="utbutton">
										</form></td>
										<td class="center"style="text-align: center;"><form action="log.php">
											<input type="submit" value="In/Out Log" class="utbutton">
										</form></td>
									</div>
								</tr>
							</table>
							</br>
						</div>
						<section>
							<div class="buttonHolder">
								<h2>Create a Delivery or Reserve an Item</h2>
								<form method="post">
									<label>Client's Name:</label>
									<input name="clientname" type="text"/>
									<label>Client's EID:</label>
									<input name="clienteid" type="text"/>
									</br>
									</br>
									<label>Client's E-Mail:</label>
									<input name="clientemail" type="text"/>
									<label>Client's Phone Number:</label>
									<input name="clientphone" type="text"/>
									</br>
									</br>
									<select name="department" class="utselect" data-placeholder="Select a Department">
										<option></option>
										<?php 
										$sql = mysql_query("SELECT * FROM `Departments`");
										while ($row = mysql_fetch_array($sql)){
										echo "<option value = \"" .$row['Name']. "\">" . $row['Name'] .  "</option>";
										}
										?>
									</select>
									<select name="staff" class="utselect" data-placeholder="Select which Staff Member you are">
										<option></option>
										<?php 
										$sql = mysql_query("SELECT `Name` FROM `Staff`");
										while ($row = mysql_fetch_array($sql)){
										echo "<option value = \"" .$row['Name']. "\">" . $row['Name'] . "</option>";
										}
										?>
									</select>
									</br>
									</br>
									<select name="reserveitem" class="utselect" id="item" onchange="setImage(this);" data-placeholder="Select an Item to Reserve">
										<option></option>
										<?php 
										$sql = mysql_query("SELECT `Name` FROM `Equipment` WHERE `Checked In/Out` = '0' && `Reserved` = '0'");
										while ($row = mysql_fetch_array($sql)){
										echo "<option value = \"" .$row['Name']. "\">" . $row['Name'] . "</option>";
										}
										?>
									</select>
									</br>
									</br>
							    	<input type="submit" name="checkoutreserve" value="Reserve" class="btn btn-warning active" />
									</br>
									</br>
									<label>Deliver from this Day:</label>
									<?php
									    $now = date('Y');
									    echo '<select name="yearb" class="utselect" data-placeholder="Year"><option></option>' . PHP_EOL;
									    for ($y=$now; $y<=$now+2; $y++) {
									        echo '  <option value="' . $y . '">' . $y . '</option>' . PHP_EOL;
									    }
									    echo '</select>' . PHP_EOL;
									    echo '<select name="monthb" class="utselect" data-placeholder="Month"><option></option>' . PHP_EOL;
									    for ($m=1; $m<=12; $m++) {
									        echo '  <option value="' . $m . '">' . date('M', mktime(0,0,0,$m)) . '</option>' . PHP_EOL;
									    }
									    echo '</select>' . PHP_EOL;
									    echo '<select name="dayb" class="utselect" data-placeholder="Day"><option></option>' . PHP_EOL;

									    for ($d=1; $d<=31; $d++) {
									        echo '  <option value="' . $d . '">' . $d . '</option>' . PHP_EOL;
									    }
									    echo '</select>' . PHP_EOL;
									?>
									</br>
									</br>
									<label>Till this Day:</label>
									<?php
									    $now = date('Y');
									    echo '<select name="yeare" class="utselect" data-placeholder="Year"><option></option>' . PHP_EOL;
									    for ($y=$now; $y<=$now+2; $y++) {
									        echo '  <option value="' . $y . '">' . $y . '</option>' . PHP_EOL;
									    }
									    echo '</select>' . PHP_EOL;
									    echo '<select name="monthe" class="utselect" data-placeholder="Month"><option></option>' . PHP_EOL;
									    for ($m=1; $m<=12; $m++) {
									        echo '  <option value="' . $m . '">' . date('M', mktime(0,0,0,$m)) . '</option>' . PHP_EOL;
									    }
									    echo '</select>' . PHP_EOL;
									    echo '<select name="daye" class="utselect" data-placeholder="Day"><option></option>' . PHP_EOL;

									    for ($d=1; $d<=31; $d++) {
									        echo '  <option value="' . $d . '">' . $d . '</option>' . PHP_EOL;
									    }
									    echo '</select>' . PHP_EOL;
									?>
									</br>
									</br>
									<select name="timeb" class="utselect" data-placeholder="Deliver from this Time">
										<option></option>
										<option value="8:00 AM">8:00 AM</option>
										<option value="8:15 AM">8:15 AM</option>
										<option value="8:30 AM">8:30 AM</option>
										<option value="8:45 AM">8:45 AM</option>
										
										<option value="9:00 AM">9:00 AM</option>
										<option value="9:15 AM">9:15 AM</option>
										<option value="9:30 AM">9:30 AM</option>
										<option value="9:45 AM">9:45 AM</option>
										
										<option value="10:00 AM">10:00 AM</option>
										<option value="10:15 AM">10:15 AM</option>
										<option value="10:30 AM">10:30 AM</option>
										<option value="10:45 AM">10:45 AM</option>
										
										<option value="11:00 AM">11:00 AM</option>
										<option value="11:15 AM">11:15 AM</option>
										<option value="11:30 AM">11:30 AM</option>
										<option value="11:45 AM">11:45 AM</option>
										
										<option value="12:00 PM">12:00 PM</option>
										<option value="12:15 PM">12:15 PM</option>
										<option value="12:30 PM">12:30 PM</option>
										<option value="12:45 PM">12:45 PM</option>
										
										<option value="1:00 PM">1:00 PM</option>
										<option value="1:15 PM">1:15 PM</option>
										<option value="1:30 PM">1:30 PM</option>
										<option value="1:45 PM">1:45 PM</option>
										
										<option value="2:00 PM">2:00 PM</option>
										<option value="2:15 PM">2:15 PM</option>
										<option value="2:30 PM">2:30 PM</option>
										<option value="2:45 PM">2:45 PM</option>
										
										<option value="3:00 PM">3:00 PM</option>
										<option value="3:15 PM">3:15 PM</option>
										<option value="3:30 PM">3:30 PM</option>
										<option value="3:45 PM">3:45 PM</option>
										
										<option value="4:00 PM">4:00 PM</option>
										<option value="4:15 PM">4:15 PM</option>
										<option value="4:30 PM">4:30 PM</option>
										<option value="4:45 PM">4:45 PM</option>
										
										<option value="5:00 PM">5:00 PM</option>
										<option value="5:15 PM">5:15 PM</option>
										<option value="5:30 PM">5:30 PM</option>
										<option value="5:45 PM">5:45 PM</option>
										
										<option value="6:00 PM">6:00 PM</option>
										<option value="6:15 PM">6:15 PM</option>
										<option value="6:30 PM">6:30 PM</option>
										<option value="6:45 PM">6:45 PM</option>
										<option value="7:00 PM">7:00 PM</option>
									</select>
									<select name="timee" class="utselect" data-placeholder="Till this Time">
										<option></option>
										<option value="8:00 AM">8:00 AM</option>
										<option value="8:15 AM">8:15 AM</option>
										<option value="8:30 AM">8:30 AM</option>
										<option value="8:45 AM">8:45 AM</option>
										
										<option value="9:00 AM">9:00 AM</option>
										<option value="9:15 AM">9:15 AM</option>
										<option value="9:30 AM">9:30 AM</option>
										<option value="9:45 AM">9:45 AM</option>
										
										<option value="10:00 AM">10:00 AM</option>
										<option value="10:15 AM">10:15 AM</option>
										<option value="10:30 AM">10:30 AM</option>
										<option value="10:45 AM">10:45 AM</option>
										
										<option value="11:00 AM">11:00 AM</option>
										<option value="11:15 AM">11:15 AM</option>
										<option value="11:30 AM">11:30 AM</option>
										<option value="11:45 AM">11:45 AM</option>
										
										<option value="12:00 PM">12:00 PM</option>
										<option value="12:15 PM">12:15 PM</option>
										<option value="12:30 PM">12:30 PM</option>
										<option value="12:45 PM">12:45 PM</option>
										
										<option value="1:00 PM">1:00 PM</option>
										<option value="1:15 PM">1:15 PM</option>
										<option value="1:30 PM">1:30 PM</option>
										<option value="1:45 PM">1:45 PM</option>
										
										<option value="2:00 PM">2:00 PM</option>
										<option value="2:15 PM">2:15 PM</option>
										<option value="2:30 PM">2:30 PM</option>
										<option value="2:45 PM">2:45 PM</option>
										
										<option value="3:00 PM">3:00 PM</option>
										<option value="3:15 PM">3:15 PM</option>
										<option value="3:30 PM">3:30 PM</option>
										<option value="3:45 PM">3:45 PM</option>
										
										<option value="4:00 PM">4:00 PM</option>
										<option value="4:15 PM">4:15 PM</option>
										<option value="4:30 PM">4:30 PM</option>
										<option value="4:45 PM">4:45 PM</option>
										
										<option value="5:00 PM">5:00 PM</option>
										<option value="5:15 PM">5:15 PM</option>
										<option value="5:30 PM">5:30 PM</option>
										<option value="5:45 PM">5:45 PM</option>
										
										<option value="6:00 PM">6:00 PM</option>
										<option value="6:15 PM">6:15 PM</option>
										<option value="6:30 PM">6:30 PM</option>
										<option value="6:45 PM">6:45 PM</option>
										<option value="7:00 PM">7:00 PM</option>
									</select>
									<select name="deliveritem" class="utselect" data-placeholder="Select an Item to Deliver">
										<option></option>
										<?php 
										$sql = mysql_query("SELECT * FROM `Equipment` WHERE `Checked In/Out` = '0' && `Reserved` = '0' && `Deliverable` = 1");
										while ($row = mysql_fetch_array($sql)){
										echo "<option value = \"" .$row['Name']. "\">" . $row['Name'] . "	Max Checkout Time in Days - " . $row['Time'] . "</option>";
										}
										?>
									</select>
									</br>
									</br>
									<input type="submit" name="deliver" value="Create Delivery" class="btn btn-warning active" />
									</br>
									</br>
									<select name="cancelreserveitem" class="utselect" data-placeholder="Select a Reservation to Cancel">
										<option></option>
										<?php 
										$sql = mysql_query("SELECT * FROM `Equipment` WHERE `Checked In/Out` = '0' && `Reserved` = '1'");
										while ($row = mysql_fetch_array($sql)){
										echo "<option value = \"" .$row['Name']. "\">" . $row['Name'] . "	Max Checkout Time in Days - " . $row['Time'] . "</option>";
										}
										?>
									</select>
									</br>
									</br>
									<input type="submit" name="cancelreserve" value="Cancel Reservation or Delivery" class="btn btn-warning active" />
								</form>
							</div>
							<table>
								<tr>
									<td style="text-align:center;">
										<h3>Selected Item Shown Below</h3>
									</td>
									<td style="text-align:center;">
										<h3>Selected Item's Info</h3>
									</td>
								</tr>
								<tr>
									<td>
									<img src="" name="image-swap"/>
									</td>
									<td>
									</td>
								</tr>
							</table>
							</br>
							<h2>Reservations</h2>
							<div class="tbl-header">
								<table cellpadding="0" cellspacing="0" border="0">
									<thead>
										<tr>
											<th>Date and Time of Entry</th>
											<th>Name</th>
											<th>EID</th>
											<th>E-Mail</th>
											<th>Phone Number </th>
											<th>Department</th>
											<th>Equipment Name</th>
											<th>Delivery or Check Out Reservation?</th>
										</tr>
									</thead>
								</table>
							</div>
							<div class="tbl-content">
								<table cellpadding="0" cellspacing="0" border="0">
									<tbody>
										<?php
										$sql = mysql_query("SELECT * FROM `Reservations`");
										while ($row = mysql_fetch_array($sql)) {?>
										<tr>
										<td><?php echo $row['Date/Time'];?></td>
										<td><?php echo $row['Client'];?></td>
										<td><?php echo $row['EID'];?></td>
										<td><?php echo $row['Email'];?></td>
										<td><?php echo $row['Phone'];?></td>
										<td><?php echo $row['Department'];?></td>
										<td><?php echo $row['Equipment'];?></td>
										<td><?php echo $row['Deliverable'] ? 'Delivery Reservation' : 'Check Out Reservation';?></td>
										</tr>
										<?php  } ?>
									</tbody>
								</table>
							</div>
						</section>
					</div>
					</br>
					</br>
					</br>
					</br>
					<div class="panel-footer">
					<h5>
					<a href="checkin.php"> Check In </a>-
					<a href="checkout.php"> Check Out </a>-
					<a href="equipment.php"> Inventory </a>-
					<a href="index.php"> Main </a>-
					<a href="log.php"> Check In/Out Log </a>
					</h5>
					© College of Education at the University of Texas at Austin 2016
					</div>
				</div>
			</div>
		</div>
	</body>
</html>