<html>
	<head>
		<title>SDI Main</title>
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
					<div class="page-header">
						<img src="images/coe-branded-logo.png" alt="College of Education Logo" style="width:300px;height:50px;padding-left:3%;">
						<h1 style="font-family:Helvetica Neue; font-weight: 100; letter-spacing: 2px;">Service Desk Inventory Application
						<small style="font-family:Helvetica Neue; font-weight: 100; letter-spacing: 2px;">by ITO Helpdesk</small></h1>
					</div>
					<div class="panel-body" style="height:200%">
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
						<section>
							<h2>Upcoming Returns</h2>
							<div class="tbl-header">
								<table cellpadding="0" cellspacing="0" border="0">
									<thead>
										<tr>
											<th>Date/Time of Check Out</th>
											<th>Date Due</th>
											<th>Client's Name</th>
											<th>Client's EID</th>
											<th>Staff Name</th>
											<th>Equipment Name</th>
										</tr>
									</thead>
								</table>
							</div>
							<div class="tbl-content" style="height:30%">
								<table cellpadding="0" cellspacing="0" border="0">
									<tbody>
										<?php

										$sql = mysql_query("SELECT * FROM `Log` WHERE `Current` = '1' ORDER BY `Until` DESC");
										while ($row = mysql_fetch_array($sql)) {?>
										<tr>
										<td><?php echo $row['Date/Time'];?></td>
										<td><?php echo $row['Until'];?></td>
										<td><?php echo $row['Client'];?></td>
										<td><?php echo $row['EID'];?></td>
										<td><?php echo $row['Staff'];?></td>
										<td><?php echo $row['Equipment'];?></td>
										</tr>
										<?php  } ?>
									</tbody>
								</table>
							</div>
						</section>
					<div class="buttonHolder">
						<?php
						echo '<h2 style="float:center;">'.date('F',mktime(0,0,0,$month,1,$year)).' '.$year.'</h2>';
						echo '</br>';
						echo '<div style="float:center;">'.$controls.'</div>';
						echo '<div style="clear:both;"></div>';
						echo draw_calendar($month,$year,$events);
						echo '<br /><br />';
						?>
					</div>
					</div>
					<div class="panel-footer">
					<h5>
					<a href="checkin.php"> Check In </a>-
					<a href="checkout.php"> Check Out </a>-
					<a href="equipment.php"> Inventory </a>-
					<a href="reservation.php"> Reservations </a>-
					<a href="log.php"> Check Out Log </a>
					</h5>
					© College of Education at the University of Texas at Austin 2016
					</div>
				</div>
			</div>
		</div>
	</br>
	</body>
</html>