<html>
	<head>
		<title>SDI Check Out</title>
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
						<img src="images/coe-branded-logo.png" alt="COE Logo" style="width:300px;height:50px;padding-left:3%;">
						<h1 style="font-family:Helvetica Neue; font-weight: 100; letter-spacing: 2px;"><a href="index.php">Service Desk Inventory Application</a>
						<small style="font-family:Helvetica Neue; font-weight: 100; letter-spacing: 2px; font-size: 10px;">by ITO Helpdesk</small></h1>
					</div>
					<div class="panel-body" style="height: calc(50vh + 100px);">
						<div>
							<table>
								<tr>
									<div style="display:inline-block; vertical-align: middle;">
										<td class="center" style="text-align: center;"><form action="checkin.php">
											<input type="submit" value="Check In" class="utbutton">
										</form></td>
										<td class="center"style="text-align: center;"><form action="index.php">
											<input type="submit" value="Main" class="utbutton">
										</form></td>
										<td class="center"style="text-align: center;"><form action="reservation.php">
											<input type="submit" value="Deliver/Reserve" class="utbutton">
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
					<h2>Enter Check Out Information</h2>
						<div class="buttonHolder">
							<form method="post">
								<select name="staff" class="utselect" data-placeholder="Select which Staff Member you are">
									<option></option>
									<?php 
									$sql = mysql_query("SELECT `Name` FROM `Staff`");
									while ($row = mysql_fetch_array($sql)){
									echo "<option value = \"" .$row['Name']. "\">" . $row['Name'] . "</option>";
									}
									?>
								</select>
								<select name="checkoutitem" class="utselect" data-placeholder="Select an Item to Check Out">
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
								</br>
								</br>
								<input type="submit" name="checkout" value="Check Out" class="btn btn-warning active"/>
							</form>
						</div>
					</div>
					<div class="panel-footer">
					<h5>
					<a href="checkin.php"> Check In </a>-
					<a href="index.php"> Main </a>-
					<a href="equipment.php"> Inventory </a>-
					<a href="reservation.php"> Reservations </a>-
					<a href="log.php"> Check In/Out Log </a>
					</h5>
					© College of Education at the University of Texas at Austin 2016
					</div>
				</div>
			</div>	
		</div>
	</body>
</html>