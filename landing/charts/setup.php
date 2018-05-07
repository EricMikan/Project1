<?php
error_reporting(0);

$driver_id = $_SESSION['driver_id'];
$driver_fname = $_SESSION['firstname'];
$driver_lname = $_SESSION['lastname'];
$su_ex_email = $_SESSION['su_ex_email'];
$email = $_SESSION['email'];

$defaultedate = date("Y-m-d");
$defaultsdate = strtotime ( '-30 day' , strtotime ( $defaultedate ) ) ;
$defaultsdate = date ( 'Y-m-j' , $defaultsdate );
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$date_start = explode('/',$startDate); //12/08/2016
$date_end = explode('/',$endDate);

$week = $_POST['selectWeeks'];

$sdate = '';
$edate = '';

if($week){
  if($week == 'Last 4 Weeks'){
        $sdate = date('Y-m-d', strtotime("-4 week"));
        $edate = $defaultedate;
  }else if($week == 'Last 6 Weeks'){
        $sdate = date('Y-m-d', strtotime("-6 week"));
        $edate = $defaultedate;
  }else if($week == 'Last 12 Weeks'){
        $sdate = date('Y-m-d', strtotime("-12 week"));
        $edate = $defaultedate;
  }else if($week == 'Last 24 Weeks'){
        $sdate = date('Y-m-d', strtotime("-24 week"));
        $edate = $defaultedate;
  }
}else if(($startDate != '') && ($endDate != '')){
        $sdate = $date_start[2].'-'.$date_start[0].'-'.$date_start[1];
        $edate = $date_end[2].'-'.$date_end[0].'-'.$date_end[1];
}else{
        $sdate = $defaultsdate;
        $edate = $defaultedate;
}  

$date1=date_create("$sdate");
$date2=date_create("$edate");
$diff=date_diff($date1,$date2);
$diff->format("%a");
$diff_days = $diff->format("%a")+1;

if($_POST['submit']) {
  $mil_goal = $_POST['mil_goal'];
  $fuel_goal = $_POST['fuel_goal'];
  $goal = $_POST['goal'];
  $idling_goal = $_POST['idling_goal'];
  $cruise_goal = $_POST['cruise_goal'];
  $top_gear_goal = $_POST['top_gear_goal'];
  $speed_goal = $_POST['speed_goal'];
  $company = $_POST['selectCompany'];

if($company == 'BONDZINC'){
    $cname = "AND company_name = 'BONDZINC'";
    $pcname = "AND p.company_name = 'BONDZINC'";
    $scname = "AND s.company_name = 'BONDZINC'";
    $ptcname = "AND pt.company_name = 'BONDZINC'";
    $tccname = "AND tc.company_name = 'BONDZINC'";
  } else if($company == 'RAVEN'){
    $cname = "AND company_name = 'RAVEN'";
    $pcname = "AND p.company_name = 'RAVEN'";
    $scname = "AND s.company_name = 'RAVEN'";
    $ptcname = "AND pt.company_name = 'RAVEN'";
    $tccname = "AND tc.company_name = 'RAVEN'";
  } else if($company == 'J & J'){
    $cname = "AND company_name = 'J & J'";
    $pcname = "AND p.company_name = 'J & J'";
    $scname = "AND s.company_name = 'J & J'";
    $ptcname = "AND pt.company_name = 'J & J'";
    $tccname = "AND tc.company_name = 'J & J'";
  } else {
    $cname = "";
    $pcname = "";
    $scname = "";
    $ptcname = "";
    $tccname = "";
  }

  $dlist = $_POST['selectDriver'];
if($dlist != NULL){
  $pd_list = "p.driver_id = '$dlist' AND";
  $sd_list = "s.Driver_ID = '$dlist' AND";
  $ptd_list = "pt.driver_id = '$dlist' AND";
  $tc_list = "tc.user_name = '$dlist' AND";
} else {
  $pd_list = " ";
  $sd_list = " ";
  $ptd_list = " ";
  $tc_list = " ";
}

  $dnum = $_POST['selectManager'];
  if($dnum != NULL){
    $exe_email = "AND su_ex_email IN ($mlist)";
  }
  else{
    $exe_email = " ";
  }

  // $weeks = $_POST['selectWeeks'];
  $date1 = $sdate;
  $date2 = $edate;

if($_SESSION['level'] == 1){
  if($mil_goal != ''){
    $update_performance1 = mysqli_query($conn,"UPDATE performance AS p SET mil_goal=$mil_goal WHERE EXISTS (SELECT u.driver_id FROM users AS u WHERE u.driver_id = p.driver_id AND su_ex_email = '$email') AND $pd_list p.start_date BETWEEN '$sdate' AND '$edate' AND p.end_date BETWEEN '$sdate' AND '$edate' $pcname");
  }
  if($fuel_goal != ''){
    $update_performance2 = mysqli_query($conn,"UPDATE performance AS p SET fuel_goal=$fuel_goal WHERE EXISTS (SELECT u.driver_id FROM users AS u WHERE u.driver_id = p.driver_id AND su_ex_email = '$email') AND $pd_list p.start_date BETWEEN '$sdate' AND '$edate' AND p.end_date BETWEEN '$sdate' AND '$edate' $pcname");
  }
  if($goal != ''){
    $update_safety = mysqli_query($conn,"UPDATE safety AS s SET goal=$goal WHERE EXISTS (SELECT u.driver_id FROM users AS u WHERE u.driver_id = s.Driver_ID AND su_ex_email = '$email') AND $sd_list s.record_date BETWEEN '$date1' AND '$date2' $scname");
  }
  if($idling_goal!= ''){
    $update_performance3 = mysqli_query($conn,"UPDATE performance AS p SET idling_goal=$idling_goal WHERE EXISTS (SELECT u.driver_id FROM users AS u WHERE u.driver_id = p.driver_id AND su_ex_email = '$email') AND $pd_list p.start_date BETWEEN '$sdate' AND '$edate' AND p.end_date BETWEEN '$sdate' AND '$edate' $pcname");
  }
  if($cruise_goal != ''){
    $update_performance4 = mysqli_query($conn,"UPDATE performance AS p SET cruise_goal=$cruise_goal WHERE EXISTS (SELECT u.driver_id FROM users AS u WHERE u.driver_id = p.driver_id AND su_ex_email = '$email') AND $pd_list p.start_date BETWEEN '$sdate' AND '$edate' AND p.end_date BETWEEN '$sdate' AND '$edate' $pcname");
  }
  if($top_gear_goal != ''){
    $update_performance5 = mysqli_query($conn,"UPDATE performance AS p SET top_gear_goal=$top_gear_goal WHERE EXISTS (SELECT u.driver_id FROM users AS u WHERE u.driver_id = p.driver_id AND su_ex_email = '$email') AND $pd_list p.start_date BETWEEN '$sdate' AND '$edate' AND p.end_date BETWEEN '$sdate' AND '$edate' $pcname");
  }
  if($speed_goal != ''){
    $update_performance6 = mysqli_query($conn,"UPDATE performance AS p SET speed_goal=$speed_goal WHERE EXISTS (SELECT u.driver_id FROM users AS u WHERE u.driver_id = p.driver_id AND su_ex_email = '$email') AND $pd_list p.start_date BETWEEN '$sdate' AND '$edate' AND p.end_date BETWEEN '$sdate' AND '$edate' $pcname");
  }
} else if($_SESSION['level'] == 3){

  $getmdrivers = mysqli_query($conn,"SELECT u.email FROM users AS u WHERE u.su_ex_email = '$email'");
  while ($getmdrivers_row = mysqli_fetch_assoc($getmdrivers)) {
    $getmdrivers_data['email'][] = $getmdrivers_row['email'];
  }

  $mlist = '"' . join($getmdrivers_data['email'],'","') . '"';

  $getm_email = mysqli_query($conn,"SELECT u.email FROM users AS u WHERE u.driver_id = $dnum");
  while ($getm_email_row = mysqli_fetch_assoc($getm_email)) {
    $getm_email_data['email'][] = $getm_email_row['email'];
  }

  $mlist = '"' . implode(' ',$getm_email_data['email']) . '"';
  // echo $mlist;

  if($dnum != NULL){
    $mlist = $mlist;
    $exe_email = "AND su_ex_email IN ($mlist)";
  }
  else {
    $mlist = '"' . join($getmdrivers_data['email'],'","') . '"';
    $exe_email = " ";
  }

  if($mil_goal != ''){
    $update_performance1 = mysqli_query($conn,"UPDATE performance AS p SET mil_goal=$mil_goal WHERE EXISTS (SELECT u.driver_id FROM users AS u WHERE u.driver_id = p.driver_id $exe_email) AND p.start_date BETWEEN '$sdate' AND '$edate' AND p.end_date BETWEEN '$sdate' AND '$edate' $pcname");
  }
  if($fuel_goal != ''){
    $update_performance2 = mysqli_query($conn,"UPDATE performance AS p SET fuel_goal=$fuel_goal WHERE EXISTS (SELECT u.driver_id FROM users AS u WHERE u.driver_id = p.driver_id $exe_email) AND p.start_date BETWEEN '$sdate' AND '$edate' AND p.end_date BETWEEN '$sdate' AND '$edate' $pcname");
  }
  if($goal != ''){
    $update_safety = mysqli_query($conn,"UPDATE safety AS s SET goal=$goal WHERE EXISTS (SELECT u.driver_id FROM users AS u WHERE u.driver_id = s.Driver_ID $exe_email) AND s.record_date BETWEEN '$date1' AND '$date2' $scname");
  }
  if($idling_goal!= ''){
    $update_performance3 = mysqli_query($conn,"UPDATE performance AS p SET idling_goal=$idling_goal WHERE EXISTS (SELECT u.driver_id FROM users AS u WHERE u.driver_id = p.driver_id $exe_email) AND p.start_date BETWEEN '$sdate' AND '$edate' AND p.end_date BETWEEN '$sdate' AND '$edate' $pcname");
    
  }
  if($cruise_goal != ''){
    $update_performance4 = mysqli_query($conn,"UPDATE performance AS p SET cruise_goal=$cruise_goal WHERE EXISTS (SELECT u.driver_id FROM users AS u WHERE u.driver_id = p.driver_id $exe_email) AND p.start_date BETWEEN '$sdate' AND '$edate' AND p.end_date BETWEEN '$sdate' AND '$edate' $pcname");
  }
  if($top_gear_goal != ''){
    $update_performance5 = mysqli_query($conn,"UPDATE performance AS p SET top_gear_goal=$top_gear_goal WHERE EXISTS (SELECT u.driver_id FROM users AS u WHERE u.driver_id = p.driver_id $exe_email) AND p.start_date BETWEEN '$sdate' AND '$edate' AND p.end_date BETWEEN '$sdate' AND '$edate' $pcname");
  }
  if($speed_goal != ''){
    $update_performance6 = mysqli_query($conn,"UPDATE performance AS p SET speed_goal=$speed_goal WHERE EXISTS (SELECT u.driver_id FROM users AS u WHERE u.driver_id = p.driver_id $exe_email) AND p.start_date BETWEEN '$sdate' AND '$edate' AND p.end_date BETWEEN '$sdate' AND '$edate' $pcname");
  }
}
  // if (mysqli_query($conn, $update_safety)) {
  //     echo "Record updated successfully";
  // } else {
  //     echo "Error updating record: " . mysqli_error($conn);
  // }
}

// echo $mlist;





if($company == 'BONDZINC'){
    $cname = "AND company_name = 'BONDZINC'";
    $pcname = "AND p.company_name = 'BONDZINC'";
    $scname = "AND s.company_name = 'BONDZINC'";
    $ptcname = "AND pt.company_name = 'BONDZINC'";
    $tccname = "AND tc.company_name = 'BONDZINC'";
  } else if($company == 'RAVEN'){
    $cname = "AND company_name = 'RAVEN'";
    $pcname = "AND p.company_name = 'RAVEN'";
    $scname = "AND s.company_name = 'RAVEN'";
    $ptcname = "AND pt.company_name = 'RAVEN'";
    $tccname = "AND tc.company_name = 'RAVEN'";
  } else if($company == 'J & J'){
    $cname = "AND company_name = 'J & J'";
    $pcname = "AND p.company_name = 'J & J'";
    $scname = "AND s.company_name = 'J & J'";
    $ptcname = "AND pt.company_name = 'J & J'";
    $tccname = "AND tc.company_name = 'J & J'";
  } else {
    $cname = "";
    $pcname = "";
    $scname = "";
    $ptcname = "";
    $tccname = "";
  }

  $dlist = $_POST['selectDriver'];
  
if($dlist != NULL){
  $pd_list = "p.driver_id = '$dlist' AND";
  $sd_list = "s.Driver_ID = '$dlist' AND";
  $ptd_list = "pt.driver_id = '$dlist' AND";
  $tc_list = "tc.user_name = '$dlist' AND";
} else {
  $pd_list = " ";
  $sd_list = " ";
  $ptd_list = " ";
  $tc_list = " ";
}

$dnum = $_POST['selectManager'];
  if($dnum != NULL){
    $exe_email = "AND su_ex_email IN ($mlist)";
  }
  else{
    $exe_email = " ";
  }

if($driver_id != NULL){
  $cond1 = "((Driver_ID = $driver_id) OR ((Driver_First_Name = '$driver_fname') AND (Driver_Last_Name = '$driver_lname'))) AND";
}else {
  $cond1 = "((Driver_First_Name = '$driver_fname') AND (Driver_Last_Name = '$driver_lname')) AND";
}

    if($_SESSION['level'] == 1){

      // echo "SELECT DISTINCT u.driver_id, u.first_name, u.last_name, u.company_name, u.su_ex_email, p.driver_id, DATE_ADD( p.start_date, INTERVAL( 1 - DAYOFWEEK( p.start_date ) ) DAY ) AS date1, DATE_ADD( p.end_date, INTERVAL( 7 - DAYOFWEEK( p.end_date ) ) DAY ) AS date2, WEEK(p.start_date) AS week, COUNT( DISTINCT p.driver_id ) AS count_of_driver, ROUND(SUM(p.distance)) AS distance, (p.mil_goal * COUNT( DISTINCT p.driver_id )) AS mil_goal, ROUND((AVG(p.ful_mpg)),2) AS ful_mpg, p.fuel_goal AS fuel_goal, ROUND(AVG(p.tot_idl_per)) AS tot_idl_per, p.idling_goal AS idling_goal, ROUND(AVG(p.cruise_ctrl_per)) AS cruise_ctrl_per, p.cruise_goal AS cruise_goal, ROUND(AVG(p.top_gear_per)) AS top_gear_per, p.top_gear_goal AS top_gear_goal, ROUND(AVG(p.over_speed_per)) AS over_speed_per, p.speed_goal AS speed_goal FROM performance AS p, users AS u WHERE EXISTS (SELECT u.driver_id FROM users AS u WHERE su_ex_email = '$email') AND u.driver_id = p.driver_id AND $pd_list p.start_date BETWEEN '$sdate' AND '$edate' AND p.end_date BETWEEN '$sdate' AND '$edate' $pcname group by $pgrpby1 ORDER BY week ASC";

      $performance = mysqli_query($conn, "SELECT DISTINCT u.driver_id, u.first_name, u.last_name, u.company_name, u.su_ex_email, p.driver_id, DATE_ADD( p.start_date, INTERVAL( 1 - DAYOFWEEK( p.start_date ) ) DAY ) AS date1, DATE_ADD( p.end_date, INTERVAL( 7 - DAYOFWEEK( p.end_date ) ) DAY ) AS date2, WEEK(p.start_date) AS week, COUNT( DISTINCT p.driver_id ) AS count_of_driver, ROUND(SUM(p.distance)) AS distance, SUM(p.mil_goal) AS mil_goal, ROUND((AVG(p.ful_mpg)),2) AS ful_mpg, p.fuel_goal AS fuel_goal, ROUND(AVG(p.tot_idl_per)) AS tot_idl_per, p.idling_goal AS idling_goal, ROUND(AVG(p.cruise_ctrl_per)) AS cruise_ctrl_per, p.cruise_goal AS cruise_goal, ROUND(AVG(p.top_gear_per)) AS top_gear_per, p.top_gear_goal AS top_gear_goal, ROUND(AVG(p.over_speed_per)) AS over_speed_per, p.speed_goal AS speed_goal FROM performance AS p, users AS u WHERE EXISTS (SELECT u.driver_id FROM users AS u WHERE u.driver_id = p.driver_id AND su_ex_email = '$email') AND u.driver_id = p.driver_id AND $pd_list p.start_date BETWEEN '$sdate' AND '$edate' AND p.end_date BETWEEN '$sdate' AND '$edate' $pcname group by $pgrpby1 ORDER BY week ASC");

  $safety = mysqli_query($conn,"SELECT DISTINCT u.driver_id, u.first_name, u.last_name, u.company_name, u.su_ex_email, s.Event_ID, s.Vehicle_Description, s.Driver_ID, DATE_ADD( DATE(s.record_date), INTERVAL( 1 - DAYOFWEEK( DATE(s.record_date) ) ) 
  DAY ) AS date1, WEEK(s.record_date) AS week, COUNT( DISTINCT s.Driver_ID ) AS count_of_driver, s.Following_too_close, ROUND(SUM(s.Following_too_close)) AS Following_too_close, s.Lane_compliance_traffic_violation, ROUND(SUM(s.Lane_compliance_traffic_violation)) AS Lane_compliance_traffic_violation, s.Braking_Cornering_Trigger, ROUND(SUM(s.Braking_Cornering_Trigger)) AS Braking_Cornering_Trigger, s.Unbelt_asleep_others, ROUND(SUM(s.Unbelt_asleep_others)) AS Unbelt_asleep_others, s.Cell_phone_other_Distraction, ROUND(SUM(s.Cell_phone_other_Distraction)) AS Cell_phone_other_Distraction, (s.goal * COUNT( DISTINCT s.Driver_ID )) AS goal FROM safety AS s, users AS u WHERE EXISTS (SELECT u.driver_id, u.first_name, u.last_name FROM users AS u WHERE ((u.driver_id = s.Driver_ID) OR ((u.first_name = s.Driver_First_Name) AND (u.last_name = s.Driver_Last_Name))) AND su_ex_email = '$email') AND u.driver_id = s.Driver_ID AND $sd_list DATE(s.record_date) BETWEEN '$sdate' AND '$edate' $scname group by $sgrpby1 ORDER BY week ASC");

  // pretrip
  $pretrip = mysqli_query($conn,"SELECT DISTINCT u.driver_id, u.first_name, u.last_name, u.company_name, u.su_ex_email, pt.driver_id, DATE_ADD( pt.VIR_last_reported, INTERVAL( 1 - DAYOFWEEK( pt.VIR_last_reported ) ) DAY ) AS date1, WEEK(pt.VIR_last_reported) AS week, COUNT( DISTINCT pt.driver_id ) AS count_of_driver, COUNT(*) AS pretrip_cnt FROM pre_trip_inspection AS pt, users AS u WHERE EXISTS (SELECT u.driver_id FROM users AS u WHERE u.driver_id = pt.driver_id AND su_ex_email = '$email') AND u.driver_id = pt.driver_id AND $ptd_list DATE(pt.VIR_last_reported) BETWEEN '$sdate' AND '$edate' $ptcname group by $ptgrpby ORDER BY week ASC");

  $svtc = mysqli_query($conn,"SELECT DISTINCT u.driver_id, u.first_name, u.last_name, u.company_name, u.su_ex_email, tc.user_name, tc.last_name, tc.first_name, DATE_FORMAT(DATE_ADD( tc.start_date, INTERVAL( 1 - DAYOFMONTH( tc.start_date ) ) DAY ), '%b %Y') AS date1, DATE_FORMAT(DATE_ADD( tc.end_date, INTERVAL( 1 - DAYOFMONTH( tc.end_date ) ) DAY ), '%b %Y') AS date2, MONTH(tc.start_date) AS month, COUNT( DISTINCT tc.user_name ) AS count_of_driver, tc.status, COUNT(tc.status) AS cnt_of_status FROM svtc AS tc, users AS u WHERE EXISTS (SELECT u.driver_id, u.first_name, u.last_name FROM users AS u WHERE ((u.driver_id = tc.user_name) OR ((u.first_name = tc.first_name) AND (u.last_name = tc.last_name))) AND su_ex_email = '$email') AND u.driver_id = tc.user_name AND $tc_list tc.start_date BETWEEN '$sdate' AND '$edate' AND tc.end_date BETWEEN '$sdate' AND '$edate' $tccname GROUP BY $svtc_grpby1 ORDER BY month ASC");
  }
  else if($_SESSION['level'] == 2){

  //   echo "SELECT DISTINCT driver_id, DATE_ADD( start_date, INTERVAL( 1 - DAYOFWEEK( start_date ) ) 
  // DAY ) AS date1, DATE_ADD( end_date, INTERVAL( 7 - DAYOFWEEK( end_date ) ) 
  // DAY ) AS date2, WEEK(start_date) AS week, COUNT( DISTINCT `driver_id` ) AS count_of_driver, ROUND(SUM(distance)) AS distance, mil_goal, ROUND(AVG(ful_mpg),2) AS ful_mpg, fuel_goal, ROUND(AVG(tot_idl_per)) AS tot_idl_per, idling_goal, ROUND(AVG(cruise_ctrl_per)) AS cruise_ctrl_per, cruise_goal, ROUND(AVG(top_gear_per)) AS top_gear_per, top_gear_goal, ROUND(AVG(over_speed_per)) AS over_speed_per, speed_goal FROM `performance` WHERE driver_id = $driver_id AND start_date BETWEEN '$sdate' AND '$edate' AND end_date BETWEEN '$sdate' AND '$edate' $cname group by $pgrpby ORDER BY week ASC";
 
  $performance = mysqli_query($conn,"SELECT DISTINCT driver_id, DATE_ADD( start_date, INTERVAL( 1 - DAYOFWEEK( start_date ) ) 
  DAY ) AS date1, DATE_ADD( end_date, INTERVAL( 7 - DAYOFWEEK( end_date ) ) 
  DAY ) AS date2, WEEK(start_date) AS week, COUNT( DISTINCT `driver_id` ) AS count_of_driver, ROUND(SUM(distance)) AS distance, mil_goal, ROUND(AVG(ful_mpg),2) AS ful_mpg, fuel_goal, ROUND(AVG(tot_idl_per)) AS tot_idl_per, idling_goal, ROUND(AVG(cruise_ctrl_per)) AS cruise_ctrl_per, cruise_goal, ROUND(AVG(top_gear_per)) AS top_gear_per, top_gear_goal, ROUND(AVG(over_speed_per)) AS over_speed_per, speed_goal FROM `performance` WHERE driver_id = $driver_id AND start_date BETWEEN '$sdate' AND '$edate' AND end_date BETWEEN '$sdate' AND '$edate' $cname group by $pgrpby ORDER BY week ASC");
  
  echo "SELECT DISTINCT driver_id, DATE_ADD( start_date, INTERVAL( 1 - DAYOFWEEK( start_date ) ) 
  DAY ) AS date1, DATE_ADD( end_date, INTERVAL( 7 - DAYOFWEEK( end_date ) ) 
  DAY ) AS date2, WEEK(start_date) AS week, COUNT( DISTINCT `driver_id` ) AS count_of_driver, ROUND(SUM(distance)) AS distance, mil_goal, ROUND(AVG(ful_mpg),2) AS ful_mpg, fuel_goal, ROUND(AVG(tot_idl_per)) AS tot_idl_per, idling_goal, ROUND(AVG(cruise_ctrl_per)) AS cruise_ctrl_per, cruise_goal, ROUND(AVG(top_gear_per)) AS top_gear_per, top_gear_goal, ROUND(AVG(over_speed_per)) AS over_speed_per, speed_goal FROM `performance` WHERE driver_id = $driver_id AND start_date BETWEEN '$sdate' AND '$edate' AND end_date BETWEEN '$sdate' AND '$edate' $cname group by $pgrpby ORDER BY week ASC";
  
  $safety = mysqli_query($conn,"SELECT DISTINCT Event_ID, Vehicle_Description, Driver_ID, DATE_ADD( DATE(record_date), INTERVAL( 1 - DAYOFWEEK( DATE(record_date) ) ) 
  DAY ) AS date1, WEEK(record_date) AS week, COUNT( DISTINCT Driver_ID ) AS count_of_driver, Following_too_close, ROUND(SUM(Following_too_close)) AS Following_too_close, Lane_compliance_traffic_violation, ROUND(SUM(`Lane_compliance_traffic_violation`)) AS Lane_compliance_traffic_violation, Braking_Cornering_Trigger, ROUND(SUM(Braking_Cornering_Trigger)) AS Braking_Cornering_Trigger, Unbelt_asleep_others, ROUND(SUM(`Unbelt_asleep_others`)) AS Unbelt_asleep_others, Cell_phone_other_Distraction, ROUND(SUM(`Cell_phone_other_Distraction`)) AS Cell_phone_other_Distraction, goal, Driver_First_Name, Driver_Last_Name 
  FROM safety
  WHERE $cond1 DATE(record_date) BETWEEN '$sdate' AND '$edate' $cname
  group by $sgrpby
  ORDER BY week ASC");

  // pretrip
  $pretrip = mysqli_query($conn,"SELECT DISTINCT driver_id, DATE_ADD( VIR_last_reported, INTERVAL( 1 - DAYOFWEEK( VIR_last_reported ) ) 
  DAY ) AS date1, WEEK(VIR_last_reported) AS week, COUNT( DISTINCT driver_id ) AS count_of_driver, COUNT(*) AS pretrip_cnt FROM pre_trip_inspection WHERE driver_id = $driver_id AND DATE(VIR_last_reported) BETWEEN '$sdate' AND '$edate' $cname group by $pgrpby ORDER BY week ASC");
  // $pretrip_res = mysqli_fetch_row($pretrip);

    //safety video training_compliance
   $svtc = mysqli_query($conn,"SELECT DISTINCT user_name, last_name, first_name, DATE_FORMAT(DATE_ADD( start_date, INTERVAL( 1 - DAYOFMONTH( start_date ) ) DAY ), '%b %Y') AS date1, DATE_FORMAT(DATE_ADD( end_date, INTERVAL( 1 - DAYOFMONTH( end_date ) ) DAY ), '%b %Y') AS date2, MONTH(start_date) AS month, COUNT( DISTINCT user_name ) AS count_of_driver, status, COUNT(status) AS cnt_of_status FROM svtc WHERE user_name = $driver_id AND start_date BETWEEN '$sdate' AND '$edate' AND end_date BETWEEN '$sdate' AND '$edate' $cname group by $svtc_grpby ORDER BY month ASC");
  // $svtc_res = mysqli_fetch_row($svtc);
  } else if($_SESSION['level'] == 3){

    $performance = mysqli_query($conn,"SELECT DISTINCT u.driver_id, u.first_name, u.last_name, u.company_name, u.su_ex_email, p.driver_id, DATE_ADD( p.start_date, INTERVAL( 1 - DAYOFWEEK( p.start_date ) ) 
  DAY ) AS date1, DATE_ADD( p.end_date, INTERVAL( 7 - DAYOFWEEK( p.end_date ) ) 
  DAY ) AS date2, WEEK(p.start_date) AS week, COUNT( DISTINCT p.driver_id ) AS count_of_driver, ROUND(SUM(p.distance)) AS distance, SUM(p.mil_goal) AS mil_goal, ROUND((AVG(p.ful_mpg)),2) AS ful_mpg, p.fuel_goal AS fuel_goal, ROUND(AVG(p.tot_idl_per)) AS tot_idl_per, p.idling_goal AS idling_goal, ROUND(AVG(p.cruise_ctrl_per)) AS cruise_ctrl_per, p.cruise_goal AS cruise_goal, ROUND(AVG(p.top_gear_per)) AS top_gear_per, p.top_gear_goal AS top_gear_goal, ROUND(AVG(p.over_speed_per)) AS over_speed_per, p.speed_goal AS speed_goal FROM performance AS p, users AS u WHERE EXISTS (SELECT u.driver_id FROM users AS u WHERE u.driver_id = p.driver_id $exe_email) AND u.driver_id = p.driver_id AND $pd_list p.start_date BETWEEN '$sdate' AND '$edate' AND p.end_date BETWEEN '$sdate' AND '$edate' $pcname group by $pgrpby1 ORDER BY week ASC");
  
 
 

  $safety = mysqli_query($conn,"SELECT DISTINCT u.driver_id, u.first_name, u.last_name, u.company_name, u.su_ex_email, s.Event_ID, s.Vehicle_Description, s.Driver_ID, DATE_ADD( DATE(s.record_date), INTERVAL( 1 - DAYOFWEEK( DATE(s.record_date) ) ) 
  DAY ) AS date1, WEEK(s.record_date) AS week, COUNT( DISTINCT s.Driver_ID ) AS count_of_driver, s.Following_too_close, ROUND(SUM(s.Following_too_close)) AS Following_too_close, s.Lane_compliance_traffic_violation, ROUND(SUM(s.Lane_compliance_traffic_violation)) AS Lane_compliance_traffic_violation, s.Braking_Cornering_Trigger, ROUND(SUM(s.Braking_Cornering_Trigger)) AS Braking_Cornering_Trigger, s.Unbelt_asleep_others, ROUND(SUM(s.Unbelt_asleep_others)) AS Unbelt_asleep_others, s.Cell_phone_other_Distraction, ROUND(SUM(s.Cell_phone_other_Distraction)) AS Cell_phone_other_Distraction, (s.goal * COUNT( DISTINCT s.Driver_ID )) AS goal FROM safety AS s, users AS u WHERE EXISTS (SELECT u.driver_id, u.first_name, u.last_name FROM users AS u WHERE ((u.driver_id = s.Driver_ID) OR ((u.first_name = s.Driver_First_Name) AND (u.last_name = s.Driver_Last_Name))) $exe_email) AND u.driver_id = s.Driver_ID AND $sd_list DATE(s.record_date) BETWEEN '$sdate' AND '$edate' $scname group by $sgrpby1 ORDER BY week ASC");
  
  

  $pretrip = mysqli_query($conn,"SELECT DISTINCT u.driver_id, u.first_name, u.last_name, u.company_name, u.su_ex_email, pt.driver_id, DATE_ADD( pt.VIR_last_reported, INTERVAL( 1 - DAYOFWEEK( pt.VIR_last_reported ) ) DAY ) AS date1, WEEK(pt.VIR_last_reported) AS week, COUNT( DISTINCT pt.driver_id ) AS count_of_driver, COUNT(*) AS pretrip_cnt FROM pre_trip_inspection AS pt, users AS u WHERE EXISTS (SELECT u.driver_id FROM users AS u WHERE u.driver_id = pt.driver_id $exe_email) AND u.driver_id = pt.driver_id AND $ptd_list DATE(pt.VIR_last_reported) BETWEEN '$sdate' AND '$edate' $ptcname group by $ptgrpby ORDER BY week ASC");

 
  $svtc = mysqli_query($conn,"SELECT DISTINCT u.driver_id, u.first_name, u.last_name, u.company_name, u.su_ex_email, tc.user_name, tc.last_name, tc.first_name, DATE_FORMAT(DATE_ADD( tc.start_date, INTERVAL( 1 - DAYOFMONTH( tc.start_date ) ) DAY ), '%b %Y') AS date1, DATE_FORMAT(DATE_ADD( tc.end_date, INTERVAL( 1 - DAYOFMONTH( tc.end_date ) ) DAY ), '%b %Y') AS date2, MONTH(tc.start_date) AS month, COUNT( DISTINCT tc.user_name ) AS count_of_driver, tc.status, COUNT(tc.status) AS cnt_of_status FROM svtc AS tc, users AS u WHERE EXISTS (SELECT u.driver_id, u.first_name, u.last_name FROM users AS u WHERE ((u.driver_id = tc.user_name) OR ((u.first_name = tc.first_name) AND (u.last_name = tc.last_name))) $exe_email) AND tc.start_date BETWEEN '$sdate' AND '$edate' AND u.driver_id = tc.user_name AND $tc_list tc.end_date BETWEEN '$sdate' AND '$edate' $tccname GROUP BY $svtc_grpby1 ORDER BY month ASC");
  
 
  
  
  }
?>

    <!-- The styles -->
    <link id="bs-css" href="css/bootstrap-cerulean.min.css" rel="stylesheet">
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="css/dashboard-app.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">  
    <link rel="stylesheet" type="text/css" href="css/jquery-ui-timepicker-addon.css">

    <!-- The fav icon -->
    <!-- <link rel="shortcut icon" href="img/favicon.ico"> -->
    <style>
    .form_elements{ width:100% !important;}
    .labels{width:100% !important; }
    .cascade{width:100% !important;}
    
    .anchor-btns{
    
    float: right;
    font-size: 14px;
    padding-right: 6px;
    background: #dacfcf;
    border-radius: 10px;
    padding-left: 5px;
    cursor: pointer;
    
    }
    
    </style>
    <script>
     function show_goal(){
     $(".collapsed-div").hide();
     $('.enlarged-div').show();
     }
     
     function hide_goal(){
     
     $('.enlarged-div').hide();
     $(".collapsed-div").show();
     }
     
    
    </script>
</head>

<body>
    <!-- topbar starts -->
    <div class="container navbar navbar-default" role="navigation"   style="position: fixed;z-index: 3;">
    <div class="navbar-inner">
      <div class="col-md-3">
        <!-- <a class="navbar-brand" href="index.php"> <img class="img-responsive" alt="ATG-DASHBOARD logo" src="img/logoatg.png" /></a> -->
        <a href="charts.php" class=""> 
          <img class="img-responsive img_logo" alt="ATG-DASHBOARD logo" src="images/logoatg.png" style="">
        </a>
      </div>

          <div class="col-md-4 atg_namedash">
        <?php if($_SESSION['level'] == 1){ ?>
          <h3>ATG MANAGER DASHBOARD</h3>
        <?php } else if($_SESSION['level'] == 3){?>
          <h3>ATG EXECUTIVE DASHBOARD</h3>
        <?php } else if($_SESSION['level'] == 2){?>
          <h3>ATG DRIVER DASHBOARD</h3>
        <?php } ?>
      </div>

            <div class="col-md-1" id="sr">
              <h3 style="padding-top: 3px;text-align: center; color: #dddddd;">Score</h3>
            </div>
            <div class="col-md-1" id="sr" style="padding-left: 0px !important;">
              <center><div class="scoreboard">
                <a href="#" data-toggle="modal" data-target="#myModalforscore" class="myModalforscore"><p class="score" style="cursor: pointer;">
                <?php 
                    echo $score.'%';
                ?>
                </p></a>
              </div></center>
            </div>

           <div class="col-md-3">
            <!-- user dropdown starts -->
            <div class="btn-group pull-right">
            <?php if($_SESSION['level'] == 1 || $_SESSION['level'] == 3 ){
              echo'  <a href="manager/add.php" class="btn btn-md btn-default">
                 <img src="img/add_user.png" class="img-responsive" alt="Add User" style="display:initial;"/>
                </a>';}?>

                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i><span class="hidden-sm hidden-xs"> <?php echo "Hello, ".$_SESSION['firstname']; ?></span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="manager/profile.php">Profile</a></li>
                    <li class="divider"></li>
                    <?php //if($_SESSION['level'] != 2){ ?>
                    <li><a href="data_table.php">Data Table</a></li>
                    <li class="divider"></li>
                    <?php// } ?>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
              </div>
              <!-- user dropdown ends -->
            </div>
        </div>
    </div>
    <!-- topbar ends -->

<?php
// if($_SESSION['level'] == 2){
// $safety_row_cnt = mysqli_num_rows($safety);
// if($safety_row_cnt == 0){
?>

<!-- <div class="container" style="padding-top: 8%;">
  <div class="row">
    <div class="col-md-3">
    </div>
    <div class="col-md-6">
      <center><p><b>NOTE:</b> No data for safety hence full credit is given for score.</p></center>
    </div> 
    <div class="col-md-3">
    </div>
  </div>
</div> -->

<?php
// }
// }
?>

<div class="container">
<div class="row">
  <div class="col-md-2 left_col" style="border:5px solid rgba(58,135,173,0.67);background-color:white;margin-top: 6.7%;height:65%;overflow-y: scroll;position: fixed;">
  <?php if($_SESSION['level'] == 2){ ?>

  <div class="filter" style="margin-top: 10%;">
    <form id="date_filter" method="post" action="/charts/" style="margin-bottom: 0px;"> 
      <div class="dropdown cascade" id="">
       <label class="lables">WEEKS:</label>
        <select id="selectWeeks" name="selectWeeks" class="form_elements" >    
            <option value="" <?php if($_POST['selectWeeks'] == ''){$select = 'selected="selected"'; echo $select;}else{$select = '';};?>>Select</option>  
            <option value="Last 4 Weeks" <?php if($_POST['selectWeeks'] == 'Last 4 Weeks'){$select = 'selected="selected"'; echo $select;}else{$select = '';};?>>Last 4 Weeks</option>
            <option value="Last 6 Weeks" <?php if($_POST['selectWeeks'] == 'Last 6 Weeks'){$select = 'selected="selected"'; echo $select;}else{$select = '';};?>>Last 6 Weeks</option>
            <option value="Last 12 Weeks" <?php if($_POST['selectWeeks'] == 'Last 12 Weeks'){$select = 'selected="selected"'; echo $select;}else{$select = '';};?>>Last 12 Weeks</option>
            <option value="Last 24 Weeks" <?php if($_POST['selectWeeks'] == 'Last 24 Weeks'){$select = 'selected="selected"'; echo $select;}else{$select = '';};?>>Last 24 Weeks</option>
           
           
           
            <option value="Date Range" <?php if($_POST['selectWeeks'] == 'Date Range'){$select = 'selected="selected"'; echo $select;}else{$select = '';};?>> Date Range</option>
        </select>
        
     
      </div>
      <br/>
    <!-- </div> -->
    <div class="dropdown cascade" id="">
      <labelclass="lables" >START DATE:</label>
      <input type="text" class="form_elements" id="startDate" name="startDate" value="<?php echo $D = date("m/d/Y", strtotime($sdate)); ?>" readonly />
    </div>
    <br/>
    <div class="dropdown cascade" id="">
      <label class="lables" >END DATE:</label>
      <input class="form_elements"  type="text" id="endDate" name="endDate" value="<?php echo $D = date("m/d/Y", strtotime($edate)); ?>" readonly />
    </div>
    <br/>
    <div class="dropdown cascade" id="">
      <!-- <input type="hidden" id="hidden" name="tab-selected" /> -->
      <input style="background-color: #254758; color: white; border: 1px solid #ffffff; padding: 10%;" type="submit" id="submit" name="submit" value="submit">
    </div>
    </form>
  </div>
  <!-- /.Scoreboard -->
  <?php } ?>


  <?php if($_SESSION['level'] != 2){ ?>

  <div class="filter" style="margin-top: 5%;">
    <form id="date_filter" method="post" action="/charts/" style="margin-bottom: 0px;"> 
    <div id="dropdowns">
      <div class="dropdown cascade" id="company">
        <label class="lables">COMPANY:</label>
        <select id="selectCompany" name="selectCompany" class="form_elements">
           <option value="" <?php if($_POST['selectCompany'] == ''){$select = 'selected="selected"'; echo $select;}else{$select = '';};?>>Select</option>  
           <option value="BONDZINC" <?php if($_POST['selectCompany'] == 'BONDZINC'){$select = 'selected="selected"'; echo $select;}else{$select = '';};?>>BONDZINC</option>
           <option value="RAVEN" <?php if($_POST['selectCompany'] == 'RAVEN'){$select = 'selected="selected"'; echo $select;}else{$select = '';};?>>RAVEN</option>
           <option value="J & J" <?php if($_POST['selectCompany'] == 'J & J'){$select = 'selected="selected"'; echo $select;}else{$select = '';};?>>J & J</option>
        </select>
      </div>
      <br/>
      <?php
      
      $driver_list = mysqli_query($conn, "SELECT u.driver_id, u.first_name, u.last_name FROM users AS u WHERE su_ex_email = '$email' $cname ORDER BY u.first_name ASC");
     
      if($_SESSION['level'] == 3){
        $manager_list = mysqli_query($conn, "SELECT u.driver_id, u.first_name, u.last_name FROM users AS u WHERE su_ex_email = '$email' ORDER BY u.first_name ASC");

        $driver_list = mysqli_query($conn, "SELECT u.driver_id, u.first_name, u.last_name FROM users AS u WHERE su_ex_email = (SELECT email FROM users WHERE driver_id = '$dnum') $cname ORDER BY u.first_name ASC");
        
      ?>
      <div class="dropdown" id="manager">
        <label class="lables" >MANAGER: </label>
          <select id="selectManager" name="selectManager" class="form_elements">
             <option value="" <?php if($_POST['selectManager'] == ''){$select = 'selected="selected"'; echo $select;}else{$select = '';};?>>Select</option>  
              <?php while($man_res = mysqli_fetch_assoc($manager_list)){ ?>
             <option value="<?php echo $man_res['driver_id']; ?>" <?php if($_POST['selectManager'] == $man_res['driver_id']){$select = 'selected="selected"'; echo $select;}else{$select = '';};?>>
                <?php
                 echo $man_res['first_name'].', '.$man_res['last_name']; 
                ?>
             </option>
              <?php } ?>
          </select>
      </div>
      <br/>
      <?php } ?>
      <div class="dropdown cascade" id="driver">
        <label class="lables" >DRIVER: </label>
        <select id="selectDriver" name="selectDriver" class="form_elements">
           <option value="" <?php if($_POST['selectDriver'] == ''){$select = 'selected="selected"'; echo $select;}else{$select = '';};?>>Select</option>  
            <?php while($res = mysqli_fetch_assoc($driver_list)){ ?>
           <option value="<?php echo $res['driver_id']; ?>" <?php if($_POST['selectDriver'] == $res['driver_id']){$select = 'selected="selected"'; echo $select;}else{$select = '';};?>>
              <?php
                echo $res['first_name'].', '.$res['last_name']; 
              ?>
           </option>
            <?php } ?>
        </select>
      </div>
      </div>
      <br/>
      <div class="dropdown cascade" id="">
       <label class="lables" >WEEKS:</label>
        <select id="selectWeeks" name="selectWeeks" class="form_elements">    
            <option value="" <?php if($_POST['selectWeeks'] == ''){$select = 'selected="selected"'; echo $select;}else{$select = '';};?>>Select</option>  
            <option value="Last 4 Weeks" <?php if($_POST['selectWeeks'] == 'Last 4 Weeks'){$select = 'selected="selected"'; echo $select;}else{$select = '';};?>>Last 4 Weeks</option>
            <option value="Last 6 Weeks" <?php if($_POST['selectWeeks'] == 'Last 6 Weeks'){$select = 'selected="selected"'; echo $select;}else{$select = '';};?>>Last 6 Weeks</option>
            <option value="Last 12 Weeks" <?php if($_POST['selectWeeks'] == 'Last 12 Weeks'){$select = 'selected="selected"'; echo $select;}else{$select = '';};?>>Last 12 Weeks</option>
            <option value="Last 24 Weeks" <?php if($_POST['selectWeeks'] == 'Last 24 Weeks'){$select = 'selected="selected"'; echo $select;}else{$select = '';};?>>Last 24 Weeks</option>
            <option value="Date Range" <?php if($_POST['selectWeeks'] == 'Date Range'){$select = 'selected="selected"'; echo $select;}else{$select = '';};?>>Date  Range</option>
        </select>
      </div>
      <br/>
    <!-- </div> -->
    <div class="dropdown cascade" id="">
      <label class="lables" >START DATE:</label>
      <input type="text" id="startDate"  class="form_elements" name="startDate" value="<?php echo $D = date("m/d/Y", strtotime($sdate)); ?>" readonly />
    </div>
    <br/>
    <div class="dropdown cascade" id="">
      <label  class="lables">END DATE:</label>
      <input type="text" id="endDate"  class="form_elements" name="endDate" value="<?php echo $D = date("m/d/Y", strtotime($edate)); 
  
      ?>" readonly />
    </div>
    <br/>
    <?php                  $sDate = date('Y-m-d', strtotime($edate));
                          $eDate = date('Y-m-d', strtotime('-30 days', strtotime($edate)));
      
    $GoalValues = mysqli_query($conn,"SELECT  COUNT( DISTINCT p.driver_id ) AS count_of_driver, ROUND(SUM(p.distance)) AS distance, (p.mil_goal ) AS mil_goal, ROUND((AVG(p.ful_mpg)),2) AS ful_mpg, p.fuel_goal AS fuel_goal, ROUND(AVG(p.tot_idl_per)) AS tot_idl_per, p.idling_goal AS idling_goal, ROUND(AVG(p.cruise_ctrl_per)) AS cruise_ctrl_per, p.cruise_goal AS cruise_goal, ROUND(AVG(p.top_gear_per)) AS top_gear_per, p.top_gear_goal AS top_gear_goal, ROUND(AVG(p.over_speed_per)) AS over_speed_per, p.speed_goal AS speed_goal FROM performance AS p, users AS u WHERE EXISTS (SELECT u.driver_id FROM users AS u WHERE u.driver_id = p.driver_id ) AND u.driver_id = p.driver_id AND  $pd_list  p.start_date BETWEEN '$sdate' AND '$edate' AND p.end_date BETWEEN '$sdate' AND '$edate' ");
    
    
    
 
$defaultgoal = mysqli_query($conn,"SELECT * FROM goal_management");
$deafultresult=mysqli_fetch_assoc($defaultgoal );
 $result=mysqli_fetch_assoc($GoalValues);
 
          if($result['mil_goal'] == NULL || $result['mil_goal'] == 0)
       {
                    $result['mil_goal']=$deafultresult['mil_goal'];
        }
     
     if($result['fuel_goal'] == NULL || $result['fuel_goal'] == 0)
     {
     
     $result['fuel_goal']=$deafultresult['fuel_goal'];
     }
     
     if($result['idling_goal'] == NULL || $result['idling_goal'] == 0)
     {
     
     $result['idling_goal']=$deafultresult['idling_goal'];
     }
     
      if($result['cruise_goal'] == NULL || $result['cruise_goal'] == 0)
     {
     
     $result['cruise_goal']=$deafultresult['cruise_goal'];
     }
      if($result['top_gear_goal'] == NULL || $result['top_gear_goal'] == 0)
     {
     
     $result['top_gear_goal']=$deafultresult['top_gear_goal'];
     }
     
      if($result['speed_goal'] == NULL || $result['speed_goal'] == 0)
     {
     
     $result['speed_goal']=$deafultresult['speed_goal'];
     }
     
    
  $safetyDefault = mysqli_query($conn,"SELECT ROUND(AVG(s.goal )) AS goal FROM safety AS s, users AS u WHERE EXISTS (SELECT u.driver_id, u.first_name, u.last_name FROM users AS u WHERE (u.driver_id = s.Driver_ID) $exe_email) AND u.driver_id = s.Driver_ID AND $sd_list DATE(s.record_date) BETWEEN '$sdate' AND '$edate' $scname group by s.Driver_ID");  
    
    
   
      
   $safetyresult=mysqli_fetch_assoc($safetyDefault);   
      
      if( $safetyresult['goal'] == NULL ||  $safetyresult['goal'] == 0)
     {
     $safetyresult['goal']=$deafultresult['safety_goal'];
     }
      
        
    
      ?>
      </br>
      <div class="goalList">
      <div class="collapsed-div">
      <label class="lables" style="width:100%">GOALS: <a onClick="show_goal()" style="float:right;" class="anchor-btns">&#43;</a> </label>
      
      </div>
      <div class="enlarged-div" style="display:none">
       <label class="lables" style="width:100%" >GOALS: <a onClick="hide_goal()" style="float:right" class="anchor-btns">&#45;</a> </label>
      <div class="dropdown" id="">
        <label class="lables">Avg. Mileage Goal:</label>
        <input type="input"  class="form_elements" name="mil_goal" id="mil_goal" placeholder="<?php if($_POST['mil_goal']){echo $_POST['mil_goal'];}else{echo $result['mil_goal']; } ?>">
    </div>
    <br/>
    <div class="dropdown" id="">
        <label class="lables" >Avg. Fuel Goal:</label>
        <input type="input"  class="form_elements" name="fuel_goal" id="fuel_goal" placeholder="<?php if($_POST['fuel_goal']){echo $_POST['fuel_goal'];} else{echo $result['fuel_goal']; } ?>">
    </div>
    <br/>
    <div class="dropdown" id="">
        <label class="lables" >Avg. Idling Goal:</label>
        <input type="input"  class="form_elements" name="idling_goal" id="idling_goal" placeholder="<?php if($_POST['idling_goal']){echo $_POST['idling_goal'];} else{echo $result['idling_goal']; } ?>">
    </div>
    <br/>
    <div class="dropdown" id="">
        <label class="lables">Avg. Cruise Control Goal:</label>
        <input type="input" class="form_elements"  name="cruise_goal" id="cruise_goal" placeholder="<?php if($_POST['cruise_goal']){echo $_POST['cruise_goal'];}  else{ echo
         $result['cruise_goal']; } ?>">
    </div>
   
    <br/>
    <div class="dropdown" id="">
         <label class="lables">Avg. Top Gear Goal:</label>
         <input type="input" class="form_elements"  name="top_gear_goal" id="top_gear_goal" placeholder="<?php if($_POST['top_gear_goal']){echo $_POST['top_gear_goal'];} else{ echo
         $result['top_gear_goal']; }?>">
    </div>
    <br/>
    <div class="dropdown" id="">
         <label class="lables">Avg. Speed Goal:</label>
         <input type="input"  class="form_elements" name="speed_goal" id="speed_goal" placeholder="<?php if($_POST['speed_goal']){echo $_POST['speed_goal'];}else{echo $result['speed_goal'];}?>">
    </div>
    <br/>
    <div class="dropdown" id="">
         <label class="lables" >Avg. Safety Goal:</label>
         <input type="input" class="form_elements" name="goal" id="goal" placeholder="<?php if($_POST['goal']){echo $_POST['goal'];}else{echo $safetyresult['goal'];}?>">
    </div>
    
    
    </div> 
    </div>
    <!-- end of group -->
    
    <br/>
    <div class="dropdown" id="">
      <!-- <input type="hidden" id="hidden" name="tab-selected" /> -->
      <input style="background-color: #254758; color: white; border: 1px solid #ffffff; padding: 10%;" type="submit" id="submit" name="submit" value="submit">
    </div>
    </form>
  </div>

  <?php } ?>
</div>
<div class="col-md-10" style="float:right;margin-top: 5%;">
 <!--<div class="row">
<div class="col-md-12"> -->
<div id="topbox">
    <!-- top inner menu -->
<!-- <div id="tabs"> -->
<div class="topinner_menuhead">
 <ul id="myTab" class="nav nav-tabs nav-tabs-responsive" role="tablist">
        <li role="presentation" class="active">
          <a href="#performance" id="performance-tab" role="tab" data-toggle="tab" aria-controls="performance" aria-expanded="true">
            <span class="text">PERFORMANCE</span>
          </a>
        </li>
        <li role="presentation" class="next">
          <a href="#safety" role="tab" id="safety-tab" data-toggle="tab" aria-controls="safety">
            <span class="text">SAFETY</span>
          </a>
        </li>
        <div style="float: right; padding-right: 2%;">
        <div class="dropdown" id="form_menu">
         <li class=""><a onclick="myprintFunction()" href=""><span class="glyphicon glyphicon-print" id="printgly"></span></a></li>
        </div>
        <!-- <div class="dropdown" id="form_menu">
         <li class=""><a href=""><span class="glyphicon glyphicon-download-alt" id="printdown"></span></a></li>
        </div> -->
        </div>
 </ul>
</div>
