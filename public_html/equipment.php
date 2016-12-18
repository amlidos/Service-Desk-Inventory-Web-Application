<html>
    <head>
        <title>SDI Inventory</title>
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
                        <img src="images/coe-branded-logo.png" alt="COE Logo" style="width:300px;height:50px;padding-left:3%">
                        <h1 style="font-family:Helvetica Neue; font-weight: 100; letter-spacing: 2px;"><a href="index.php">Service Desk Inventory Application</a>
                        <small style="font-family:Helvetica Neue; font-weight: 100; letter-spacing: 2px; font-size: 10px;">by ITO Helpdesk</small></h1>
                    </div>
                    <div class="panel-body">
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
                                        <td class="center"style="text-align: center;"><form action="index.php">
                                            <input type="submit" value="Main" class="utbutton">
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
                                <div class="form-group">
                                    <h2>Add New Equipment</h2>
                                    <form method="post" class="form-inline" role="form">
                                        <label for="equipmentname">Name:</label>
                                        <input name="name" type="text"/>
                                        <label for="uttag">UT Tag:</label>
                                        <input name="uttag" type="text"/>
                                        </br>
                                        </br>
                                        <label for="uttag">Max Checkout Days:</label>
                                        <input name="days" type="text"/>
                                        <select name="deliverable" class="utselect" data-placeholder="Is this a Delivery Item?">
                                            <option></option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        </br>
                                        </br>
                                        <input type="submit" name="addequipment" value="Add" class="btn btn-warning active"/>
                                    </form>
                                </div>
                                <div class="form-group">
                                    <h2>Add Staff Member</h2>
                                    <form method="post" class="form-inline" role="form">
                                        <label for="staff">Name:</label>
                                        <input name="name" type="text"/>
                                        <input type="submit" name="addstaff" value="Add" class="btn btn-warning active"/>
                                    </form>
                                </div>
                                <div class="form-group">
                                    <h2>Add Department</h2>
                                    <form method="post" class="form-inline" role="form">
                                        <label for="department">Name:</label>
                                        <input name="department" type="text"/>
                                        <input type="submit" name="adddepartment" value="Add" class="btn btn-warning active"/>
                                    </form>
                                </div>
                            </div>
                            </br>
                            <h2>Inventory</h2>
                            <div class="tbl-header">
                                <table cellpadding="0" cellspacing="0" border="0">
                                    <thead>
                                        <tr>
                                            <th>Equipment Name</th>
                                            <th>Checked In/Out</th>
                                            <th>Reservation Status</th>
                                            <th>UT Tag</th>
                                            <th>Max Checkout Time (in Days)</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="tbl-content">
                                <table cellpadding="0" cellspacing="0" border="0">
                                    <tbody>
                                        <?php
                                            $sql = mysql_query("SELECT * FROM `Equipment`");
                                            while ($row = mysql_fetch_array($sql)) {?>
                                            <tr>
                                                <td><?php echo $row['Name'];?></td>
                                                <td><?php echo $row['Checked In/Out'] ? 'Checked Out' : 'Checked In';?></td>
                                                <td><?php echo $row['Reserved'] ? 'Currently Reserved' : 'Not Reserved';?></td>
                                                <td><?php echo $row['UT Tag'];?></td>
                                                <td><?php echo $row['Time'];?></td>
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
                    </br>
                    </br>
                    </br>
                    <div class="panel-footer">
                    <h5>
                    <a href="checkin.php"> Check In </a>-
                    <a href="checkout.php"> Check Out </a>-
                    <a href="index.php"> Main </a>-
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