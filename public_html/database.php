<?php
    $server = mysql_connect("mysql.edb.utexas.edu", "ltc_sdi", "mpk-4283$");
    $db = mysql_select_db("ltc_sdi", $server);
    date_default_timezone_set('CST');

    function days_until($date){
        return (isset($date)) ? floor((strtotime($date) - time())/60/60/24) : FALSE;
    }

    function draw_calendar($month,$year,$events = array()){

        /* draw table */
        $calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

        /* table headings */
        $headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
        $calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

        /* days and weeks vars now ... */
        $running_day = date('w',mktime(0,0,0,$month,1,$year));
        $days_in_month = date('t',mktime(0,0,0,$month,1,$year));
        $days_in_this_week = 1;
        $day_counter = 0;
        $dates_array = array();

        /* row for week one */
        $calendar.= '<tr class="calendar-row">';

        /* print "blank" days until the first of the current week */
        for($x = 0; $x < $running_day; $x++):
            $calendar.= '<td class="calendar-day-np">&nbsp;</td>';
            $days_in_this_week++;
        endfor;

        /* keep going with days.... */
        for($list_day = 1; $list_day <= $days_in_month; $list_day++):
            if($list_day == date('j')){
                $calendar.= '<td class="calendar-day today"><div style="position:relative;height:calc(20vh);">';
            }
            else{
                $calendar.= '<td class="calendar-day"><div style="position:relative;height:calc(20vh);">';
            }
                /* add in the day number */

                if($list_day < 10) {
                    $list_day = str_pad($list_day, 2, '0', STR_PAD_LEFT);
                }

                $calendar.= '<div class="day-number">'.$list_day.'</div>';
                $month = str_pad($month,2,"0", STR_PAD_LEFT);
                $event_day = $year.'-'.$month.'-'.$list_day;
                if(isset($events[$event_day])) {
                    foreach($events[$event_day] as $event) {
                        $calendar.= '<div class="event">'.$event['title'].'</div>';
                    }
                }
                else {
                    $calendar.= str_repeat('<p>&nbsp;</p>',2);
                }
            $calendar.= '</div></td>';
            if($running_day == 6):
                $calendar.= '</tr>';
                if(($day_counter+1) != $days_in_month):
                    $calendar.= '<tr class="calendar-row">';
                endif;
                $running_day = -1;
                $days_in_this_week = 0;
            endif;
            $days_in_this_week++; $running_day++; $day_counter++;
        endfor;

        /* finish the rest of the days in the week */
        if($days_in_this_week < 8):
            for($x = 1; $x <= (8 - $days_in_this_week); $x++):
                $calendar.= '<td class="calendar-day-np">&nbsp;</td>';
            endfor;
        endif;

        /* final row */
        $calendar.= '</tr>';
        

        /* end the table */
        $calendar.= '</table>';

        /** DEBUG **/
        $calendar = str_replace('</td>','</td>'."\n",$calendar);
        $calendar = str_replace('</tr>','</tr>'."\n",$calendar);
        
        /* all done, return result */
        return $calendar;
    }

    /* date settings */
    $month = (int) ($_GET['month'] ? $_GET['month'] : date('m'));
    $year = (int)  ($_GET['year'] ? $_GET['year'] : date('Y'));

    /* select month control */
    $select_month_control = '<select name="month" id="month" class="utselect">';
    for($x = 1; $x <= 12; $x++) {
        $select_month_control.= '<option value="'.$x.'"'.($x != $month ? '' : ' selected="selected"').'>'.date('F',mktime(0,0,0,$x,1,$year)).'</option>';
    }
    $select_month_control.= '</select>';

    /* select year control */
    $year_range = 7;
    $select_year_control = '<select name="year" id="year" class="utselect">';
    for($x = ($year-floor($year_range/2)); $x <= ($year+floor($year_range/2)); $x++) {
        $select_year_control.= '<option value="'.$x.'"'.($x != $year ? '' : ' selected="selected"').'>'.$x.'</option>';
    }
    $select_year_control.= '</select>';

    /* "next month" control */
    $next_month_link = '<a href="?month='.($month != 12 ? $month + 1 : 1).'&year='.($month != 12 ? $year : $year + 1).'" class="control">Next Month &gt;&gt;</a>';

    /* "previous month" control */
    $previous_month_link = '<a href="?month='.($month != 1 ? $month - 1 : 12).'&year='.($month != 1 ? $year : $year - 1).'" class="control">&lt;&lt;    Previous Month</a>';


    /* bringing the controls together */
    $controls = '<form method="get">'.$select_month_control.$select_year_control.'&nbsp;<input type="submit" name="submit" value="Go" class="btn btn-warning active" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$previous_month_link.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$next_month_link.' </form>';

    /* get all events for the given month */
    $month = str_pad($month,2,"0", STR_PAD_LEFT);
    $events = array();
    $query = "SELECT title, DATE_FORMAT(event_date,'%Y-%m-%d') AS ev FROM events";
    $result = mysql_query($query) or die('cannot get results!');
    while($row = mysql_fetch_assoc($result)) {
        $events[$row['ev']][] = $row;
    }

    if(isset($_POST['addequipment']))
    {
        $name = $_POST['name'];
        $uttag = $_POST['uttag'];
        $deliverable = $_POST['deliverable'];
        if($name == "" || $uttag == "")
        {
            echo '<script language="javascript">';
            echo 'alert("Fill in all fields!")';
            echo '</script>';
            header("Refresh:0");
            break;
        }
        if($uttag == "")
        {$uttag = "N/A";}
        $days = $_POST['days'];
        $SQL = "INSERT INTO `Equipment`(`Name`, `Checked In/Out`, `Reserved`, `UT Tag`, `Time`, `Deliverable`) VALUES ('$name','0','0','$uttag', '$days', '$deliverable')";
        $result = mysql_query($SQL);
        echo '<script language="javascript">';
        echo 'alert("The equipment was succesfully added!")';
        echo '</script>';
        header("Refresh:0");
    }
    if(isset($_POST['addstaff']))
    {
        $name = $_POST['name'];
        if($name == "")
        {
            echo '<script language="javascript">';
            echo 'alert("Fill in all fields!")';
            echo '</script>';
            header("Refresh:0");
            break;
        }
        $SQL = "INSERT INTO `Staff`(`Name`) VALUES ('$name')";
        $result = mysql_query($SQL);
        echo '<script language="javascript">';
        echo 'alert("The staff member was succesfully added!")';
        echo '</script>';
        header("Refresh:0");
    }
    if(isset($_POST['adddepartment']))
    {
        $name = $_POST['department'];
        if($name == "")
        {
            echo '<script language="javascript">';
            echo 'alert("Fill in all fields!")';
            echo '</script>';
            header("Refresh:0");
            break;
        }
        $SQL = "INSERT INTO `Departments`(`Name`) VALUES ('$name')";
        $result = mysql_query($SQL);
        echo '<script language="javascript">';
        echo 'alert("The department was succesfully added!")';
        echo '</script>';
        header("Refresh:0");
    }
    if(isset($_POST['deliver']))
    {
        $clientname = $_POST['clientname'];
        $clienteid = $_POST['clienteid'];
        $deliveritem = $_POST['deliveritem'];
        $department = $_POST['department'];
        $clientemail = $_POST['clientemail'];
        $clientphone = $_POST['clientphone'];
        $staff = $_POST['staff'];
        $yearb = $_POST['yearb'];
        $monthb = $_POST['monthb'];
        $dayb = $_POST['dayb'];
        $yeare = $_POST['yeare'];
        $monthe = $_POST['monthe'];
        $daye = $_POST['daye'];
        $timeb = $_POST['timeb'];
        $timee = $_POST['timee'];
        $datebegin = date('Y-m-d',strtotime($yearb."/".$monthb."/".$dayb));
        $dateend = date('Y-m-d',strtotime($yeare."/".$monthe."/".$daye));
        if($clientname == "" || $clienteid == "" || $deliveritem == "" || $department == "" || $clientemail == "" || $clientphone == "" || $yearb == "" || $monthb == "" || $dayb == "" || $yeare == "" || $monthe == "" || $daye == "" || $timeb == "" || $timee == "")
        {
            echo '<script language="javascript">';
            echo 'alert("Fill in all fields!")';
            echo '</script>';
            header("Refresh:0");
            break;
        }
        $SQL = "UPDATE `Equipment` SET `Reserved`='1' WHERE `Name`='$deliveritem'";
        $result = mysql_query($SQL);
        $today = date("F j, Y, g:i a");
        $SQL = "INSERT INTO `Reservations`(`Date/Time`, `Equipment`, `Department`, `Client`, `EID`, `Email`, `Phone`, `Deliverable`) VALUES ('$today','$deliveritem','$department','$clientname', '$clienteid', '$clientemail', '$clientphone', '1')";
        $result = mysql_query($SQL);
        $textb = $deliveritem." begins at ".$timeb;
        $texte = $deliveritem." ends at ".$timee;
        $SQL = "INSERT INTO `events`(`title`, `event_date`, `name`) VALUES ('$textb','$datebegin', '$deliveritem')";
        $result = mysql_query($SQL);
        $SQL = "INSERT INTO `events`(`title`, `event_date`, `name`) VALUES ('$texte','$dateend', '$deliveritem')";
        $result = mysql_query($SQL);
        echo '<script language="javascript">';
        echo 'alert("The reservation was succesfully made!")';
        echo '</script>';
        header("Refresh:0");
    }
    if(isset($_POST['cancelreserve']))
    {
        $name = $_POST['cancelreserveitem'];
        if($name == "")
        {
            echo '<script language="javascript">';
            echo 'alert("Choose the item you would like to cancel the reservation for!")';
            echo '</script>';
            header("Refresh:0");
            break;
        }
        $SQL = "UPDATE `Equipment` SET `Reserved`='0' WHERE `Name`='$name'";
        $result = mysql_query($SQL);
        $SQL = "DELETE FROM `Reservations` WHERE `Equipment` = '$name'";
        $result = mysql_query($SQL);
        $SQL = "DELETE FROM `events` WHERE `name` = '$name'";
        $result = mysql_query($SQL);
        echo '<script language="javascript">';
        echo 'alert("The reservation was succesfully canceled!")';
        echo '</script>';
        header("Refresh:0");
    }
    if(isset($_POST['checkout']))
    {
        $staff = $_POST['staff'];
        $clientname = $_POST['clientname'];
        $clienteid = $_POST['clienteid'];
        $checkoutitem = $_POST['checkoutitem'];
        $phone = $_POST['clientphone'];
        $email = $_POST['clientemail'];
        $department = $_POST['department'];
        if($staff == "" || $clientname == "" || $clienteid == "" || $checkoutitem == "" || $phone == "" || $email == "" || $department == "")
        {
            echo '<script language="javascript">';
            echo 'alert("Fill in all fields!")';
            echo '</script>';
            header("Refresh:0");
            break;
        }

        $daysquery = mysql_query("SELECT `Time` FROM `Equipment` WHERE `Name` = '$checkoutitem'");
        $daysarray = mysql_fetch_array($daysquery);
        $days = $daysarray['Time'];
        $today = date("F j, Y, g:i a");
        $daysresult = date('F j, Y, g:i a', strtotime($today.' +' . $days . ' days'));
        $SQL = "INSERT INTO `Log`(`Date/Time`, `Checked In/Out`, `Staff`, `Equipment`, `Client`, `EID`, `Until`, `Current`, `Phone`, `Email`, `Department`) VALUES ('$today','1','$staff','$checkoutitem', '$clientname', '$clienteid', '$daysresult', '1', '$phone', '$email', '$department')";
        $result = mysql_query($SQL);
        $SQL = "UPDATE `Equipment` SET `Checked In/Out`='1' WHERE `Name`='$checkoutitem'";
        $result = mysql_query($SQL);
        echo '<script language="javascript">';
        echo 'alert("The equipment was succesfully checked out!")';
        echo '</script>';
        header("Refresh:0");
    }
    if(isset($_POST['checkin']))
    {
        $staff = $_POST['staff'];
        $checkinitem = $_POST['checkinitem'];
        if($staff == "" || $checkinitem == "")
        {
            echo '<script language="javascript">';
            echo 'alert("Fill in all fields!")';
            echo '</script>';
            header("Refresh:0");
            break;
        }
        $repeatclientquery = mysql_fetch_array(mysql_query("SELECT `Client` FROM `Log` WHERE `Equipment` = '$checkinitem' ORDER BY `Date/Time` DESC LIMIT 1"));
        $repeatclient = $repeatclientquery['Client'];
        $repeatclienteidquery = mysql_fetch_array(mysql_query("SELECT `EID` FROM `Log` WHERE `Equipment` = '$checkinitem' ORDER BY `Date/Time` DESC LIMIT 1"));
        $repeatclienteid = $repeatclienteidquery['EID'];
        $repeatphonequery = mysql_fetch_array(mysql_query("SELECT `Phone` FROM `Log` WHERE `Equipment` = '$checkinitem' ORDER BY `Date/Time` DESC LIMIT 1"));
        $repeatphone = $repeatphonequery['Phone'];
        $repeatemailquery = mysql_fetch_array(mysql_query("SELECT `Email` FROM `Log` WHERE `Equipment` = '$checkinitem' ORDER BY `Date/Time` DESC LIMIT 1"));
        $repeatemail = $repeatemailquery['Email'];
        $repeatdepartmentquery = mysql_fetch_array(mysql_query("SELECT `Department` FROM `Log` WHERE `Equipment` = '$checkinitem' ORDER BY `Date/Time` DESC LIMIT 1"));
        $repeatdepartment = $repeatdepartmentquery['Department'];


        $today = date("F j, Y, g:i a");
        $SQL = "INSERT INTO `Log`(`Date/Time`, `Checked In/Out`, `Staff`, `Equipment`, `Client`, `EID`, `Current`, `Phone`, `Email`, `Department`) VALUES ('$today','0','$staff','$checkinitem', '$repeatclient', '$repeatclienteid', '0', '$repeatphone', '$repeatemail', '$repeatdepartment')";
        $result = mysql_query($SQL);
        $SQL = "UPDATE `Equipment` SET `Checked In/Out`='0' WHERE `Name`='$checkinitem'";
        $result = mysql_query($SQL);
        $SQL = "UPDATE `Log` SET `Current`='0' WHERE `Equipment`='$checkinitem'";
        $result = mysql_query($SQL);
        echo '<script language="javascript">';
        echo 'alert("The equipment was succesfully checked in!")';
        echo '</script>';
        header("Refresh:0");
    }
    if(isset($_POST['checkoutreserve']))
    {
        $clientname = $_POST['clientname'];
        $clienteid = $_POST['clienteid'];
        $reserveitem = $_POST['reserveitem'];
        $clientphone = $_POST['clientphone'];
        $clientemail = $_POST['clientemail'];
        $department = $_POST['department'];
        $staff = $_POST['staff'];
        $today = date("F j, Y, g:i a");
        if($clientname == "" || $clienteid == "" || $reserveitem == "" || $department == "" || $clientemail == "" || $clientphone == "" || $staff == "")
        {
            echo '<script language="javascript">';
            echo 'alert("Fill in all fields!")';
            echo '</script>';
            header("Refresh:0");
            break;
        }
        $SQL = "UPDATE `Equipment` SET `Reserved`='1' WHERE `Name`='$reserveitem'";
        $result = mysql_query($SQL);
        $SQL = "INSERT INTO `Reservations`(`Date/Time`, `Equipment`, `Department`, `Client`, `EID`, `Email`, `Phone`, `Deliverable`) VALUES ('$today','$reserveitem','$department','$clientname', '$clienteid', '$clientemail', '$clientphone', '0')";
        $result = mysql_query($SQL);
        echo '<script language="javascript">';
        echo 'alert("The reservation was succesfully made!")';
        echo '</script>';
        header("Refresh:0");
    }
?>