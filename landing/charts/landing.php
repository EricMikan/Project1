<?php
	
	require_once "./code/db.php";

	$GLOBALS['SPECS']->title = "DASHBOARD"; 
	
	$GLOBALS['RENDER']->renderHeader(false);
?>

<?php
$pgrpby = "week";
$pgrpby1 = "week";
$sgrpby = "week";
$sgrpby1 = "week";
$ptgrpby = "week";
$svtc_grpby = "status";
$svtc_grpby1 = "status";
//include('header.php');
include('setup.php');


$mileage_data['title'] = 'Mileage';
$mileage_data['xname'] = '<b>'.'Week start date'.'</b>';
$mileage_data['yname'] = '<b>'.'Mileage'.'</b>';   
$mileage_goal_name = '<b>'.'Mileage goal'.'</b>';
$mileage_score = 0;

$fuel_data['title'] = 'Fuel Economy';
$fuel_data['xname'] = '<b>'.'Week start date'.'</b>';
$fuel_data['yname'] = '<b>'.'Miles per Gallon'.'</b>';   
$fuel_goal_name = '<b>'.'Fuel goal'.'</b>';
$fuel_score = 0;

$idling_data['title'] = 'Idling';
$idling_data['xname'] = '<b>'.'Week start date'.'</b>';
$idling_data['yname'] = '<b>'.'Avg.Idling %'.'</b>';   
$idling_goal_name = '<b>'.'Idling goal %'.'</b>';
$idling_score = 0;

$cruise_data['title'] = 'Cruise Control';
$cruise_data['xname'] = '<b>'.'Week start date'.'</b>';
$cruise_data['yname'] = '<b>'.'Avg.Cruise Control %'.'</b>';  
$cruise_goal_name = '<b>'.'Cruise Control goal %'.'</b>';
$cruise_score = 0;

$top_gear_data['title'] = 'Top Gear';
$top_gear_data['xname'] = '<b>'.'Week start date'.'</b>';
$top_gear_data['yname'] = '<b>'.'Avg.Top Gear %'.'</b>';
$top_gear_goal_name = '<b>'.'Top Gear goal %'.'</b>';
$top_gear_score = 0;

$speed_data['title'] = 'Speed Profile';
$speed_data['xname'] = '<b>'.'Week start date'.'</b>';
$speed_data['yname'] = '<b>'.'Avg.Over speed %'.'</b>';  
$speed_goal_name = '<b>'.'Speed goal %'.'</b>';
$speed_score = 0;

// if($_SESSION['level'] != 2){
  $performance_row_cnt = mysqli_num_rows($performance);
  while ($performance_row = mysqli_fetch_assoc($performance)) {
     $performance_data['date1'][] = $performance_row['date1'];
     $performance_data['distance'][] = $performance_row['distance'];
     $performance_data['ful_mpg'][] = $performance_row['ful_mpg'];
     $performance_data['tot_idl_per'][] = $performance_row['tot_idl_per'];
     $performance_data['cruise_ctrl_per'][] = $performance_row['cruise_ctrl_per'];
     $performance_data['top_gear_per'][] = $performance_row['top_gear_per'];
     $performance_data['over_speed_per'][] = $performance_row['over_speed_per'];
     $performance_data['count_of_driver'][] = $performance_row['count_of_driver'];

     if($performance_row['mil_goal'] == NULL || $performance_row['mil_goal'] == 0){
        $tbl_goal_mgt = mysqli_query($conn,"SELECT * FROM goal_management");
        $tbl_goal_mgt_res = mysqli_fetch_assoc($tbl_goal_mgt);
        $performance_data['mil_goal'][] = $tbl_goal_mgt_res['mil_goal'] * $performance_row['count_of_driver'];
        $mg = $tbl_goal_mgt_res['mil_goal'] * $performance_row['count_of_driver'];
     }else{
        $performance_data['mil_goal'][] = $performance_row['mil_goal'];
        $mg = $performance_row['mil_goal'];
     }
     
    
     
     $mileage_score += ROUND((($performance_row['distance']/$mg)*100)/$performance_row_cnt);
     
     
     

     if($performance_row['fuel_goal'] == NULL || $performance_row['fuel_goal'] == 0){
        $tbl_goal_mgt = mysqli_query($conn,"SELECT * FROM goal_management");
        $tbl_goal_mgt_res = mysqli_fetch_assoc($tbl_goal_mgt);
        $performance_data['fuel_goal'][] = $tbl_goal_mgt_res['fuel_goal'];
        $fg = $tbl_goal_mgt_res['fuel_goal'];
     }else{
        $performance_data['fuel_goal'][] = $performance_row['fuel_goal'];
        $fg = $performance_row['fuel_goal'];
     }
     $fuel_score += ROUND((($performance_row['ful_mpg']/$fg)*100)/$performance_row_cnt);

      if($performance_row['idling_goal'] == NULL || $performance_row['idling_goal'] == 0){
          $tbl_goal_mgt = mysqli_query($conn,"SELECT * FROM goal_management");
          $tbl_goal_mgt_res = mysqli_fetch_assoc($tbl_goal_mgt);
          $performance_data['idling_goal'][] = $tbl_goal_mgt_res['idling_goal'];
          $ig = $tbl_goal_mgt_res['idling_goal'];
       }else{
          $performance_data['idling_goal'][] = $performance_row['idling_goal'];
          $ig = $performance_row['idling_goal'];
       }
       $idling_score += ROUND((($performance_row['tot_idl_per']/$ig)*100)/$performance_row_cnt);

       if($performance_row['cruise_goal'] == NULL || $performance_row['cruise_goal'] == 0){
          $tbl_goal_mgt = mysqli_query($conn,"SELECT * FROM goal_management");
          $tbl_goal_mgt_res = mysqli_fetch_assoc($tbl_goal_mgt);
          $performance_data['cruise_goal'][] = $tbl_goal_mgt_res['cruise_goal'];
          $cg = $tbl_goal_mgt_res['cruise_goal'];
       }else{
          $performance_data['cruise_goal'][] = $performance_row['cruise_goal'];
          $cg = $performance_row['cruise_goal'];
       }
       $cruise_score += ROUND((($performance_row['cruise_ctrl_per']/$cg)*100)/$performance_row_cnt);

       if($performance_row['top_gear_goal'] == NULL || $performance_row['top_gear_goal'] == 0){
          $tbl_goal_mgt = mysqli_query($conn,"SELECT * FROM goal_management");
          $tbl_goal_mgt_res = mysqli_fetch_assoc($tbl_goal_mgt);
          $performance_data['top_gear_goal'][] = $tbl_goal_mgt_res['top_gear_goal'];
          $tg = $tbl_goal_mgt_res['top_gear_goal'];
       }else{
          $performance_data['top_gear_goal'][] = $performance_row['top_gear_goal'];
          $tg = $performance_row['top_gear_goal'];
       }
       $top_gear_score += ROUND((($performance_row['top_gear_per']/$tg)*100)/$performance_row_cnt);

       if($performance_row['speed_goal'] == NULL || $performance_row['speed_goal'] == 0){
          $tbl_goal_mgt = mysqli_query($conn,"SELECT * FROM goal_management");
          $tbl_goal_mgt_res = mysqli_fetch_assoc($tbl_goal_mgt);
          $performance_data['speed_goal'][] = $tbl_goal_mgt_res['speed_goal'];
          $sg = $tbl_goal_mgt_res['speed_goal'];
       }else{
       
       
          $performance_data['speed_goal'][] = $performance_row['speed_goal'];
          $sg = $performance_row['speed_goal'];
       }
       $speed_score += ROUND((($performance_row['over_speed_per']/$sg)*100)/$performance_row_cnt);
  }
  

   $following_data['title'] = 'Following Too Close';
   $following_data['xname'] = '<b>'.'Week start date'.'</b>';
   $following_data['yname'] = '<b>'.'Count'.'</b>';  
   $following_goal_name = '<b>'.'Goal'.'</b>';
   $following_score = 0;

   $lc_data['title'] = 'Lane Compliance/ Traffic Violation';
   $lc_data['xname'] = '<b>'.'Week start date'.'</b>';
   $lc_data['yname'] = '<b>'.'Count'.'</b>';  
   $lc_goal_name = '<b>'.'Goal'.'</b>';
   $lc_score = 0;  

   $hb_data['title'] = 'Braking/Cornering Trigger';
   $hb_data['xname'] = '<b>'.'Week start date'.'</b>';
   $hb_data['yname'] = '<b>'.'Count'.'</b>';  
   $hb_goal_name = '<b>'.'Goal'.'</b>';
   $hb_score = 0; 

   $unbelted_data['title'] = 'Unbelt/Asleep/Others';
   $unbelted_data['xname'] = '<b>'.'Week start date'.'</b>';
   $unbelted_data['yname'] = '<b>'.'Count'.'</b>';  
   $unbelted_goal_name = '<b>'.'Goal'.'</b>';
   $unbelted_score = 0; 

   $cell_distraction_data['title'] = 'Cell Phone/Other Distraction';
   $cell_distraction_data['xname'] = '<b>'.'Week start date'.'</b>';
   $cell_distraction_data['yname'] = '<b>'.'Count'.'</b>';  
   $cell_distraction_goal_name = '<b>'.'Goal'.'</b>';
   $cell_distraction_score = 0;  



    $safety_row_cnt = mysqli_num_rows($safety);
    while ($safety_row = mysqli_fetch_assoc($safety)) {
       $safety_data['date1'][] = $safety_row['date1'];
       $safety_data['Following_too_close'][] = $safety_row['Following_too_close'];
       $safety_data['Lane_compliance_traffic_violation'][] = $safety_row['Lane_compliance_traffic_violation'];
       $safety_data['Braking_Cornering_Trigger'][] = $safety_row['Braking_Cornering_Trigger'];
       $safety_data['Unbelt_asleep_others'][] = $safety_row['Unbelt_asleep_others'];
       $safety_data['Cell_phone_other_Distraction'][] = $safety_row['Cell_phone_other_Distraction'];
       $safety_data['count_of_driver'][] = $safety_row['count_of_driver'];
       if($safety_row['goal'] == NULL || $safety_row['goal'] == 0){
          $tbl_goal_mgt = mysqli_query($conn,"SELECT * FROM goal_management");
          $tbl_goal_mgt_res = mysqli_fetch_assoc($tbl_goal_mgt);
          $safety_data['goal'][] = $tbl_goal_mgt_res['safety_goal'] * $safety_row['count_of_driver'];
          $sg = $tbl_goal_mgt_res['safety_goal'] * $safety_row['count_of_driver'];
       }else{
          $safety_data['goal'][] = $safety_row['goal'];
          $sg = $safety_row['goal'];
       }
       $following_score += ROUND((($safety_row['Following_too_close']/$sg))/$safety_row_cnt);

       $lc_score += ROUND((($safety_row['Lane_compliance_traffic_violation']/$sg))/$safety_row_cnt);

       $hb_score += ROUND((($safety_row['Braking_Cornering_Trigger']/$sg))/$safety_row_cnt);




       $unbelted_score += ROUND((($safety_row['Unbelt_asleep_others']/$sg))/$safety_row_cnt);

       $cell_distraction_score += ROUND((($safety_row['Cell_phone_other_Distraction']/$sg))/$safety_row_cnt);
    }
?>

<style type="text/css">
  #hard_brake{
    position: relative;
    overflow: hidden;
    width: 1017px;
    height: 400px;
    text-align: left;
    line-height: normal;
    z-index: 0;
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
}


#cell_distraction,#pretrip,#svtc,#unbelted,#following,#lane_complaint{
    position: relative;
    overflow: hidden;
    width: 492px;
    height: 400px;
    text-align: left;
    line-height: normal;
    z-index: 0;
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
}
</style>

<div class="tab-content responsive">
  <!-- <div class="tab-pane active" id="home"> --><div role="tabpanel" class="tab-pane fade in active" id="performance" aria-labelledby="performance-tab">
    <div class="ch-container">
    <div class="row">
        <div id="content" class="col-lg-12 col-sm-12">
            <!-- content starts -->

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2>Mileage vs Plan</h2>
            </div>
            <div class="box-content row">
                <div class="col-lg-12 col-md-12" id="mileage" style="min-width: 310px; height: 400px; margin: 0 auto">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
<div class="col-md-6">
    <div class="box">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2>Fuel Economy</h2>
            </div>
            <div class="box-content" id="fuel_economy">
            </div>
        </div>
    </div>
</div>
    <!--/span-->
<div class="col-md-6">
    <div class="box">

        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2>Idling</h2>
            </div>
            <div class="box-content" id="idling">
            </div>
        </div>
    </div>
    <!--/span-->
</div>
</div><!--/row-->

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2>Cruise Control</h2>
            </div>
            <div class="box-content row">
                <div class="col-lg-12 col-md-12" id="cruise" style="min-width: 310px; height: 400px; margin: 0 auto">
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-6">
    <div class="box">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2>Top Gear</h2>
            </div>
            <div class="box-content" id="top_gear">
            </div>
        </div>
    </div>
</div>
    <!--/span-->
<div class="col-md-6">
    <div class="box">

        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2>Speed Profile </h2>
            </div>
            <div class="box-content" id="speed">
            </div>
            </div>
        </div>
    </div>
    <!--/span-->
</div><!--/row-->
    <!-- content ends -->
    </div><!--/#content.col-md-0-->
</div><!--/fluid-row-->

 </div><!--/.fluid-container--></div>

  <!-- <div class="tab-pane" id="profile"> --><div role="tabpanel" class="tab-pane fade" id="safety" aria-labelledby="safety-tab">
    <div class="ch-container">
    <div class="row">
        <div id="content" class="col-lg-12 col-sm-12">
          <?php
          // if($_SESSION['level'] == 2){
          $safety_row_cnt = mysqli_num_rows($safety);
          if($safety_row_cnt == 0){
          ?>
            <center><p><b>NOTE:</b> No data for safety hence full credit is given for score.</p></center>
          <?php
          }
          // }
          ?>
            <!-- content starts -->
  <div class="row">
    <div class="col-md-6">
    <div class="box">

        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2>Following Too Close</h2>
            </div>
            <div class="box-content" id="following">
            </div>
        </div>
    </div>
</div>
    <!--/span-->
<div class="col-md-6">
    <div class="box">

        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2>Lane Compliance/ Traffic Violation</h2>
            </div>
            <div class="box-content" id="lane_complaint">
            </div>
        </div>
    </div>
    </div>
    <!--/span-->
</div><!--/row-->


<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2>Braking/Cornering Trigger</h2>
            </div>
            <div class="box-content row">
                <div class="col-lg-12 col-md-12" id="hard_brake" >
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
    <div class="box">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2>Unbelt/Asleep/Others</h2>
            </div>
            <div class="box-content" id="unbelted">
            </div>
        </div>
    </div>
</div>
    <!--/span-->
<div class="col-md-6">
    <div class="box">

        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2>Cell Phone/Other Distraction</h2>
            </div>
            <div class="box-content" id="cell_distraction">
            </div>
            </div>
        </div>
    </div>
    <!--/span-->
</div><!--/row-->

<div class="row">
    <div class="col-md-6">
    <div class="box">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2>Pre Trip Inspection</h2>
            </div>
                <?php 
                 $pretrip_data['title'] = 'Pre Trip Inspection';
                 $pretrip_data['xname'] = '<b>'.'Week start date'.'</b>';
                 $pretrip_data['yname'] = '<b>'.'Count'.'</b>';  
                 $pretrip_score = '';
                 $pretrip_row_cnt = mysqli_num_rows($pretrip);
                      while ($pretrip_row = mysqli_fetch_assoc($pretrip)) {
                        $pretrip_data['date1'][] = $pretrip_row['date1'];
                        $pretrip_data['pretrip_cnt'][] = $pretrip_row['pretrip_cnt'];
                        $pretrip_data['count_of_driver'][] = $pretrip_row['count_of_driver'];
                        $pretrip_score += ROUND(($pretrip_row['pretrip_cnt']/$pretrip_row['count_of_driver'])/$pretrip_row_cnt);
                  }
                ?>
            <div class="box-content" id="pretrip">
            </div>
        </div>
    </div>
</div>
    <!--/span-->
<div class="col-md-6">
    <div class="box">

        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2>Safety Video Training Compliance</h2>
            </div>
               <?php 
                 $svtc_data['title'] = 'Safety Video Training Compliance';
                 $svtc_score = '';  
                        $svtc_row_cnt = mysqli_num_rows($svtc);
                        if ($svtc_row_cnt == 0) {
                          $svtc_score = 10;
                        }
                            while ($svtc_row = mysqli_fetch_assoc($svtc)) {
                               $svtc_data['status'][] = $svtc_row['status'];
                               $svtc_data['cnt_of_status'][] = $svtc_row['cnt_of_status'];
                               $svtc_combined_data[] = "[".'"'.$svtc_row['status'].'"'. ',' . $svtc_row['cnt_of_status']."],";
                               $combined_data = $svtc_combined_data;
                               if(in_array("Incomplete", $svtc_data['status'])){
                                  $svtc_score = 0;
                               }else{
                                  $svtc_score = 10;
                               }
                        }
                       
                ?>
            <div class="box-content" id="svtc">
 </div>
            </div>
        </div>
    </div>
    <!--/span-->
</div><!--/row-->
    <!-- content ends -->
    </div><!--/#content.col-md-0-->
</div><!--/fluid-row-->

 </div><!--/.fluid-container-->
</div>

</div>
<!-- /. top inner menu -->
<!-- </div>
</div> -->
<!-- </div> -->
</div><!-- /.container -->
</div>
</div>
</div>

<?php //if($_SESSION['level'] == 2){ 

  if(($mileage_score >= 0) && ($mileage_score <= 15)){
     $mileage_score1 = 0*(10/100);
  }else if (($mileage_score >= 16) && ($mileage_score <= 40)){
    $mileage_score1 = 0*(10/100);
  }else if (($mileage_score >= 41) && ($mileage_score <= 65)){
    $mileage_score1 = 5*(10/100);
  }else if (($mileage_score >= 66) && ($mileage_score <= 90)){
    $mileage_score1 = 15*(10/100);
  }else if (($mileage_score >= 91) && ($mileage_score <= 99)){
    $mileage_score1 = 80*(10/100);
  }else if($mileage_score >= 100){
    $mileage_score1 = 100*(10/100);
  }

  if(($fuel_score >= 0) && ($fuel_score <= 15)){
     $fuel_score1 = 0*(10/100);
  }else if (($fuel_score >= 16) && ($fuel_score <= 40)){
    $fuel_score1 = 0*(10/100);
  }else if (($fuel_score >= 41) && ($fuel_score <= 65)){
    $fuel_score1 = 5*(10/100);
  }else if (($fuel_score >= 66) && ($fuel_score <= 90)){
    $fuel_score1 = 15*(10/100);
  }else if (($fuel_score >= 91) && ($fuel_score <= 99)){
    $fuel_score1 = 80*(10/100);
  }else if($fuel_score >= 100){
    $fuel_score1 = 100*(10/100);
  }

    if(($idling_score >= 0) && ($idling_score <= 15)){
    $idling_score1 = 100*(5/100);
  }else if (($idling_score >= 16) && ($idling_score <= 40)){
    $idling_score1 = 80*(5/100);
  }else if (($idling_score >= 41) && ($idling_score <= 65)){
    $idling_score1 = 15*(5/100);
  }else if (($idling_score >= 66) && ($idling_score <= 90)){
    $idling_score1 = 5*(5/100);
  }else if (($idling_score >= 91) && ($idling_score <= 99)){
    $idling_score1 = 0*(5/100);
  }else if ($idling_score >= 100){
    $idling_score1 = 0*(5/100);
  }

  if(($cruise_score >= 0) && ($cruise_score <= 15)){
    $cruise_score1 = 0*(5/100);
  }else if (($cruise_score >= 16) && ($cruise_score <= 40)){
    $cruise_score1 = 5*(5/100);
  }else if (($cruise_score >= 41) && ($cruise_score <= 65)){
    $cruise_score1 = 10*(5/100);
  }else if (($cruise_score >= 66) && ($cruise_score <= 90)){
    $cruise_score1 = 15*(5/100);
  }else if (($cruise_score >= 91) && ($cruise_score <= 99)){
    $cruise_score1 = 80*(5/100);
  }else if ($cruise_score >= 100){
    $cruise_score1 = 100*(5/100);
  }

  if(($top_gear_score >= 0) && ($top_gear_score <= 15)){
    $top_gear_score1 = 0*(5/100);
  }else if (($top_gear_score >= 16) && ($top_gear_score <= 40)){
    $top_gear_score1 = 5*(5/100);
  }else if (($top_gear_score >= 41) && ($top_gear_score <= 65)){
    $top_gear_score1 = 10*(5/100);
  }else if (($top_gear_score >= 66) && ($top_gear_score <= 90)){
    $top_gear_score1 = 15*(5/100);
  }else if (($top_gear_score >= 91) && ($top_gear_score <= 99)){
    $top_gear_score1 = 80*(5/100);
  }else if ($top_gear_score >= 100){
    $top_gear_score1 = 100*(5/100);
  }

  if(($speed_score >= 0) && ($speed_score <= 15)){
    $speed_score1 = 100*(10/100);
  }else if (($speed_score >= 16) && ($speed_score <= 40)){
    $speed_score1 = 80*(10/100);
  }else if (($speed_score >= 41) && ($speed_score <= 65)){
    $speed_score1 = 15*(10/100);
  }else if (($speed_score >= 66) && ($speed_score <= 90)){
    $speed_score1 = 5*(10/100);
  }else if (($speed_score >= 91) && ($speed_score <= 99)){
    $speed_score1 = 0*(10/100);
  }else if ($speed_score >= 100){
    $speed_score1 = 0*(10/100);
  }

  if(($following_score == NULL) || ($following_score == 0)){
    $following_score1 = 100*(10/100);
  }else if(($following_score >= 1) && ($following_score <= 30)){
    $following_score1 = 60*(10/100);
  }else if(($following_score >= 31) && ($following_score <= 60)){
    $following_score1 = 10*(10/100);
  }else if($following_score > 60){
    $following_score1 = 0*(10/100);
  }

  if(($lc_score == NULL) || ($lc_score == 0)){
    $lc_score1 = 100*(10/100);
  }else if(($lc_score >= 1) && ($lc_score <= 30)){
    $lc_score1 = 60*(10/100);
  }else if(($lc_score >= 31) && ($lc_score <= 60)){
    $lc_score1 = 10*(10/100);
  }else if($lc_score > 60){
    $lc_score1 = 0*(10/100);
  }

  if(($hb_score == NULL) || ($hb_score == 0)){
    $hb_score1 = 100*(5/100);
  }else if(($hb_score >= 1) && ($hb_score <= 30)){
    $hb_score1 = 60*(5/100);
  }else if(($hb_score >= 31) && ($hb_score <= 60)){
    $hb_score1 = 10*(5/100);
  }else if($hb_score > 60){
    $hb_score1 = 0*(5/100);
  }

  if(($unbelted_score == NULL) || ($unbelted_score == 0)){
    $unbelted_score1 = 100*(5/100);
  }else if(($unbelted_score >= 1) && ($unbelted_score <= 30)){
    $unbelted_score1 = 60*(5/100);
  }else if(($unbelted_score >= 31) && ($unbelted_score <= 60)){
    $unbelted_score1 = 10*(5/100);
  }else if($unbelted_score > 60){
    $unbelted_score1 = 0*(5/100);
  }

  if(($cell_distraction_score == NULL) || ($cell_distraction_score == 0)){
    $cell_distraction_score1 = 100*(5/100);
  }else if(($cell_distraction_score >= 1) && ($cell_distraction_score <= 30)){
    $cell_distraction_score1 = 60*(5/100);
  }else if(($cell_distraction_score >= 31) && ($cell_distraction_score <= 60)){
    $cell_distraction_score1 = 10*(5/100);
  }else if($cell_distraction_score > 60){
    $cell_distraction_score1 = 0*(5/100);
  }

  if(($pretrip_score == NULL) || ($pretrip_score == 0)){
    $pretrip_score1 = 0*(10/100);
  }
  else if($pretrip_score > 0){
    $pretrip_score1 = 100*(10/100);
    }
  
  
  /*else if(($pretrip_score >= 1) && ($pretrip_score <= 30)){
    $pretrip_score1 = 10*(10/100);
  }else if(($pretrip_score >= 31) && ($pretrip_score <= 60)){
    $pretrip_score1 = 60*(10/100);
  }else if($pretrip_score > 60){
    $pretrip_score1 = 100*(10/100);
  }
*/


if(($svtc_score == NULL) || ($svtc_score == 0)){
    $svtc_score1 = 0*(10/100);
  }
  else if($pretrip_score > 0){
    $svtc_score1 = 100*(10/100);
    }

    // if(($mileage_row_cnt == NULL) && ($fuel_row_cnt == NULL) && ($idling_row_cnt == NULL) && ($cruise_row_cnt == NULL) && ($top_gear_row_cnt == NULL) && ($speed_row_cnt == NULL) && ($following_row_cnt == NULL) && ($lc_row_cnt == NULL) && ($hb_row_cnt == NULL) && ($unbelted_row_cnt == NULL) && ($cell_distraction_row_cnt == NULL) && ($pretrip_row_cnt == NULL) && ($svtc_row_cnt == NULL)){
    //     $score = '';
    // } else {

    $score = $mileage_score1+$fuel_score1+$idling_score1+$cruise_score1+$top_gear_score1+$speed_score1+$following_score1+$lc_score1+$hb_score1+$unbelted_score1+$cell_distraction_score1+$pretrip_score1+$svtc_score1; 
    // }

// echo $score.'=';
// echo $mileage_score.'+';
// echo $fuel_score.'+';
// echo $idling_score.'+';
// echo $cruise_score.'+';
// echo $top_gear_score.'+';
// echo $speed_score.'+';
// echo $following_score.'+'; 
// echo $lc_score.'+';
// echo $hb_score.'+';
// echo $unbelted_score.'+';
// echo $cell_distraction_score.'+';
// echo $pretrip_score.'+';
// echo $svtc_score;

?>

<div class="modal fade" id="myModalforscore" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" id="score">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                  <div class="col-md-2">
                  </div>
                  <div class="col-md-8">
                    <center><h4>Score Distribution</h4></center>
                      <table class="table table-inverse table-bordered">
                          <tr style="background-color: #254758; color: #dddddd;">
                            <th>Parameters</th>
                             <th>Score Value</th>
                            <th>Score in percentage</th>
                          </tr>
                          <tr>
                            <td>Mileage Score</td>
                            <td><?php echo $mileage_score;?></td>
                            <td><?php echo $mileage_score1 . "%";?></td>
                          </tr>
                          <tr>
                            <td>Fuel Score</td>
                             <td><?php echo $fuel_score;?></td>
                            <td><?php echo $fuel_score1 . "%";?></td>
                          </tr>
                          <tr>
                            <td>Idling Score</td>
                            <td><?php echo $idling_score;?></td>
                            <td><?php echo $idling_score1 . "%";?></td>
                          </tr>
                          <tr>
                            <td>Cruise Control Score</td>
                             <td><?php echo $cruise_score;?></td>
                            <td><?php echo $cruise_score1. "%";?></td>
                          </tr>
                          <tr>
                            <td>Top Gear Score</td>
                             <td><?php echo $top_gear_score;?></td>
                            <td><?php echo $top_gear_score1. "%";?></td>
                          </tr>
                          <tr>
                            <td>Speed Score</td>
                            <td><?php echo $speed_score;?></td>
                            <td><?php echo $speed_score1 . "%";?></td>
                          </tr>
                          <tr>
                            <td>Following Too Close Score</td>
                              <td><?php echo $following_score ;?></td>
                            <td><?php echo $following_score1 . "%";?></td>
                          </tr>
                          <tr>
                            <td>Lane Compliance/ Traffic Violation Score</td>
                              <td><?php echo $lc_score;?></td>
                            <td><?php echo $lc_score1 . "%";?></td>
                          </tr>
                          <tr>
                            <td>Braking/Cornering Score</td>
                             <td><?php echo $hb_score ;?></td>
                            <td><?php echo $hb_score1 . "%";?></td>
                          </tr>
                          <tr>
                            <td>Unbelt/Asleep/Others Score</td>
                             <td><?php echo $unbelted_score ;?></td>
                            <td><?php echo $unbelted_score1 . "%";?></td>
                          </tr>
                          <tr>
                            <td>Cell Phone/Other Distraction Score</td>
                            <td><?php echo $cell_distraction_score ;?></td>
                            <td><?php echo $cell_distraction_score1 . "%";?></td>
                          </tr>
                          <tr>
                            <td>Pre Trip Inspection Score</td>
                             <td><?php echo $pretrip_score ;?></td>
                            <td><?php echo $pretrip_score1 . "%";?></td>
                          </tr>
                          <tr>
                            <td>Safety Video Training Compliance Score</td>
                            <td><?php echo $svtc_score;?></td>
                            <td><?php echo $svtc_score1 . "%";?></td>
                          </tr>
                          <tr style="background-color: #254758; color: #dddddd;">
                            <th>Total Score</th>
                            <th><?php echo $mileage_score1+$fuel_score1+$idling_score1+$cruise_score1+$top_gear_score1+$speed_score1+$following_score1+$lc_score1+$hb_score1+$unbelted_score1+$cell_distraction_score1+$pretrip_score1+$svtc_score1 . "%";?></th>
                          </tr>
                      </table>
                  </div>
                  <div class="col-md-2">
                    <a href="score_table.php" target="_blank">See How?</a>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scoreboard -->
<div class="container" style="display: none;">
  <div class="col-md-8"></div>
  <div class="col-md-4">
    <div class="col-md-8">
      <h3 style="float: right; padding-top: 3px;">Score</h3>
    </div>
    <div class="col-md-4">
      <div class="scoreboard">
        <a href="#" data-toggle="modal" data-target="#myModalforscore" class="myModalforscore"><p class="score" style="cursor: pointer;">
        <?php 
            echo $score.'%';
        ?>
        </p></a> 
      </div>
    </div>
  </div>
</div>
<!-- /.Scoreboard -->

<?php
include('footer.php');
?>

<script type="text/javascript">
$(document).ready(function () {
    var score = "<?php echo $score.'%'; ?>" ;
    $(".score").text(score);
});

// $(document).on("submit","#date_filter",function(){
//     //$("#submit").attr("disabled",true);
//     $comp = $.trim($("#selectCompany").val());
//     $wee = $.trim($("#selectWeeks").val());
//     $sdat = $.trim($("#startDate").val());
//     $edat = $.trim($("#endDate").val());
//     $mil = $.trim($("#mil_goal").val());
//     $fuel = $.trim($("#fuel_goal").val());
//     $sgoal = $.trim($("#goal").val());
//     $obj = {
//       comp: $comp,
//       wee: $wee,
//       sdat: $sdat,
//       edat: $edat,
//       mil: $mil,
//       fuel: $fuel,
//       sgoal: $sgoal
//     };
    
//       var xhr;

//       xhr = $.ajax({
//         url:'update.php',
//         data:$obj,
//         type:'post',
//         contentType: 'application/json',
//         dataType:'json',
//         async:false,
//         success:function(data){
//         }
//        });
   
//       if(xhr && xhr.readyState > 0 && xhr.readyState < 1){
//        xhr.abort();
//       };
// });
</script>

<script type="text/javascript">
    $(function () {
        $('#mileage').highcharts({
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: <?php echo '"' . $mileage_data['title'] . '"'; ?>
            },
            // subtitle: {
            //     text: 'DNFB'
            // },
            colors: ['#E86850','#58e26f'],
            xAxis: [{
                title: {
                    text: <?php echo '"' . $mileage_data['xname'] . '"'; ?>,
                    y: -7
                },
                categories: [<?php echo '"' . join($performance_data['date1'],'","') . '"'; ?>],
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: <?php echo '"' . $mileage_data['yname'] . '"'; ?>,
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text : <?php echo '"' . $mileage_goal_name . '"'; ?>,
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                //x: 120,
                horizontalAlign: 'bottom',
                y: 20,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
            },
            series: [{
                name: <?php echo '"' . $mileage_data['yname'] . '"'; ?>,
                type: 'spline',
                // yAxis: 1,
                data: [<?php echo join($performance_data['distance'], ',') ?>],
                tooltip: {
                    valueSuffix: ''
                }

            }, {
                name: <?php echo '"' . $mileage_goal_name . '"'; ?>,
                type: 'spline',
                // yAxis: 1,
                data: [<?php echo join($performance_data['mil_goal'], ',') ?>],
                tooltip: {
                    valueSuffix: ''
                }
            }]
        });
    });

    $(function () {
        $('#fuel_economy').highcharts({
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: <?php echo '"' . $fuel_data['title'] . '"'; ?>
            },
            // subtitle: {
            //     text: 'DNFB'
            // },
            colors: ['#E86850','#58e26f'],
            xAxis: [{
                title: {
                    text: <?php echo '"' . $fuel_data['xname'] . '"'; ?>,
                     y: -7
                },
                categories: [<?php echo '"' . join($performance_data['date1'],'","') . '"'; ?>],
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: <?php echo '"' . $fuel_data['yname'] . '"'; ?>,
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text : <?php echo '"' . $fuel_goal_name . '"'; ?>,
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                //x: 120,
                horizontalAlign: 'bottom',
                y: 20,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
            },
            series: [{
                name: <?php echo '"' . $fuel_data['yname'] . '"'; ?>,
                type: 'spline',
                // yAxis: 1,
                data: [<?php echo join($performance_data['ful_mpg'], ',') ?>],
                tooltip: {
                    valueSuffix: ''
                }

            }, {
                name: <?php echo '"' . $fuel_goal_name . '"'; ?>,
                type: 'spline',
                // yAxis: 1,
                data: [<?php echo join($performance_data['fuel_goal'], ',') ?>],
                tooltip: {
                    valueSuffix: ''
                }
            }]
        });
    });

    $(function () {
        $('#idling').highcharts({
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: <?php echo '"' . $idling_data['title'] . '"'; ?>
            },
            // subtitle: {
            //     text: 'DNFB'
            // },
            colors: ['#8E4585','#DAA520'],
            xAxis: [{
                title: {
                    text: <?php echo '"' . $idling_data['xname'] . '"'; ?>,
                     y: -7
                },
                categories: [<?php echo '"' . join($performance_data['date1'],'","') . '"'; ?>],
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: <?php echo '"' . $idling_data['yname'] . '"'; ?>,
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text : <?php echo '"' . $idling_goal_name . '"'; ?>,
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                //x: 120,
                horizontalAlign: 'bottom',
                y: 20,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
            },
            series: [{
                name: <?php echo '"' . $idling_data['yname'] . '"'; ?>,
                type: 'column',
                // yAxis: 1,
                data: [<?php echo join($performance_data['tot_idl_per'], ',') ?>],
                tooltip: {
                valueSuffix: ''
                }
            }, {
                name: <?php echo '"' . $idling_goal_name . '"'; ?>,
                type: 'spline',
                // yAxis: 1,
                data: [<?php echo join($performance_data['idling_goal'], ',') ?>],
                tooltip: {
                valueSuffix: ''
                }
            }]
        });
    });

    $(function () {
        $('#cruise').highcharts({
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: <?php echo '"' . $cruise_data['title'] . '"'; ?>
            },
            // subtitle: {
            //     text: 'DNFB'
            // },
            colors: ['#8E4585','#DAA520'],
            xAxis: [{
                title: {
                    text: <?php echo '"' . $cruise_data['xname'] . '"'; ?>,
                     y: -7
                },
                categories: [<?php echo '"' . join($performance_data['date1'],'","') . '"'; ?>],
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: <?php echo '"' . $cruise_data['yname'] . '"'; ?>,
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text : <?php echo '"' . $cruise_goal_name . '"'; ?>,
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                //x: 120,
                horizontalAlign: 'bottom',
                y: 20,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
            },
            series: [{
                name: <?php echo '"' . $cruise_data['yname'] . '"'; ?>,
                type: 'column',
                // yAxis: 1,
                data: [<?php echo join($performance_data['cruise_ctrl_per'], ',') ?>],
                tooltip: {
                    valueSuffix: ''
                }
            }, {
                name: <?php echo '"' . $cruise_goal_name . '"'; ?>,
                type: 'spline',
                // yAxis: 1,
                data: [<?php echo join($performance_data['cruise_goal'], ',') ?>],
                tooltip: {
                valueSuffix: ''
                }
            }]
        });
    });

    $(function () {
        $('#top_gear').highcharts({
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: <?php echo '"' . $top_gear_data['title'] . '"'; ?>
            },
            // subtitle: {
            //     text: 'DNFB'
            // },
            colors: ['#8E4585','#DAA520'],
            xAxis: [{
                title: {
                    text: <?php echo '"' . $top_gear_data['xname'] . '"'; ?>,
                     y: -7
                },
                categories: [<?php echo '"' . join($performance_data['date1'],'","') . '"'; ?>],
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: <?php echo '"' . $top_gear_data['yname'] . '"'; ?>,
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text : <?php echo '"' . $top_gear_goal_name . '"'; ?>,
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                // tickInterval: 5,
                // min: 0,
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                //x: 120,
                horizontalAlign: 'bottom',
                y: 20,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
            },
            series: [{
                name: <?php echo '"' . $top_gear_data['yname'] . '"'; ?>,
                type: 'column',
                // yAxis: 1,
                data: [<?php echo join($performance_data['top_gear_per'], ',') ?>],
                tooltip: {
                    valueSuffix: ''
                }
            }, {
                name: <?php echo '"' . $top_gear_goal_name . '"'; ?>,
                type: 'spline',
                // yAxis: 1,
                data: [<?php echo join($performance_data['top_gear_goal'], ',') ?>],
                tooltip: {
                valueSuffix: ''
                }
            }]
        });
    });
    
    $(function () {
        $('#speed').highcharts({
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: <?php echo '"' . $speed_data['title'] . '"'; ?>
            },
            // subtitle: {
            //     text: 'DNFB'
            // },
            colors: ['#8E4585','#DAA520'],
            xAxis: [{
                title: {
                    text: <?php echo '"' . $speed_data['xname'] . '"'; ?>,
                     y: -7
                },
                categories: [<?php echo '"' . join($performance_data['date1'],'","') . '"'; ?>],
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: <?php echo '"' . $speed_data['yname'] . '"'; ?>,
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text : <?php echo '"' . $speed_goal_name . '"'; ?>,
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                //x: 120,
                horizontalAlign: 'bottom',
                y: 20,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
            },
            series: [{
                name: <?php echo '"' . $speed_data['yname'] . '"'; ?>,
                type: 'column',
                // yAxis: 1,
                data: [<?php echo join($performance_data['over_speed_per'], ',') ?>],
                tooltip: {
                    valueSuffix: ''
                }
            }, {
                name: <?php echo '"' . $speed_goal_name . '"'; ?>,
                type: 'spline',
                // yAxis: 1,
                data: [<?php echo join($performance_data['speed_goal'], ',') ?>],
                tooltip: {
                valueSuffix: ''
                }
            }]
        });
    });

$("#safety-tab").click(function(){
    $(function () {
        $('#following').highcharts({
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: <?php echo '"' . $following_data['title'] . '"'; ?>
            },
            // subtitle: {
            //     text: 'DNFB'
            // },
            colors: ['#42f4cb','#d16e73'],
            xAxis: [{
                title: {
                    text: <?php echo '"' . $following_data['xname'] . '"'; ?>,
                     y: -7
                },
                categories: [<?php echo '"' . join($safety_data['date1'],'","') . '"'; ?>],
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: <?php echo '"' . $following_data['yname'] . '"'; ?>,
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text : <?php echo '"' . $following_goal_name . '"'; ?>,
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                //x: 120,
                horizontalAlign: 'bottom',
                y: 20,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
            },
            series: [{
                name: <?php echo '"' . $following_data['yname'] . '"'; ?>,
                type: 'spline',
                // yAxis: 1,
                data: [<?php echo join($safety_data['Following_too_close'], ',') ?>],
                tooltip: {
                    valueSuffix: ''
                }

            }, {
                name: <?php echo '"' . $following_goal_name . '"'; ?>,
                type: 'spline',
                // yAxis: 1,
                data: [<?php echo join($safety_data['goal'], ',') ?>],
                tooltip: {
                    valueSuffix: ''
                }
            }]
        });
    });

    $(function () {
        $('#lane_complaint').highcharts({
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: <?php echo '"' . $lc_data['title'] . '"'; ?>
            },
            // subtitle: {
            //     text: 'DNFB'
            // },
            colors: ['#42f4cb','#d16e73'],
            xAxis: [{
                title: {
                    text: <?php echo '"' . $lc_data['xname'] . '"'; ?>,
                     y: -7
                },
                categories: [<?php echo '"' . join($safety_data['date1'],'","') . '"'; ?>],
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: <?php echo '"' . $lc_data['yname'] . '"'; ?>,
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text : <?php echo '"' . $lc_goal_name . '"'; ?>,
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                //x: 120,
                horizontalAlign: 'bottom',
                y: 20,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
            },
            series: [{
                name: <?php echo '"' . $lc_data['yname'] . '"'; ?>,
                type: 'spline',
                // yAxis: 1,
                data: [<?php echo join($safety_data['Lane_compliance_traffic_violation'], ',') ?>],
                tooltip: {
                valueSuffix: ''
                }

            }, {
                name: <?php echo '"' . $lc_goal_name . '"'; ?>,
                type: 'spline',
                // yAxis: 1,
                data: [<?php echo join($safety_data['goal'], ',') ?>],
                tooltip: {
                valueSuffix: ''
                }
            }]
        });
    });

    $(function () {
        $('#hard_brake').highcharts({
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: <?php echo '"' . $hb_data['title'] . '"'; ?>
            },
            // subtitle: {
            //     text: 'DNFB'
            // },
            colors: ['#42f4cb','#d16e73'],
            xAxis: [{
                title: {
                    text: <?php echo '"' . $hb_data['xname'] . '"'; ?>,
                     y: -7
                },
                categories: [<?php echo '"' . join($safety_data['date1'],'","') . '"'; ?>],
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: <?php echo '"' . $hb_data['yname'] . '"'; ?>,
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text : <?php echo '"' . $hb_goal_name . '"'; ?>,
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                //x: 120,
                horizontalAlign: 'bottom',
                y: 20,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
            },
            series: [{
                name: <?php echo '"' . $hb_data['yname'] . '"'; ?>,
                type: 'spline',
                // yAxis: 1,
                data: [<?php echo join($safety_data['Braking_Cornering_Trigger'], ',') ?>],
                tooltip: {
                    valueSuffix: ''
                }

            }, {
                name: <?php echo '"' . $hb_goal_name . '"'; ?>,
                type: 'spline',
                // yAxis: 1,
                data: [<?php echo join($safety_data['goal'], ',') ?>],
                tooltip: {
                    valueSuffix: ''
                }
            }]
        });
    });

    $(function () {
        $('#unbelted').highcharts({
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: <?php echo '"' . $unbelted_data['title'] . '"'; ?>
            },
            // subtitle: {
            //     text: 'DNFB'
            // },
            colors: ['#42f4cb','#d16e73'],
            xAxis: [{
                title: {
                    text: <?php echo '"' . $unbelted_data['xname'] . '"'; ?>,
                     y: -7
                },
                categories: [<?php echo '"' . join($safety_data['date1'],'","') . '"'; ?>],
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: <?php echo '"' . $unbelted_data['yname'] . '"'; ?>,
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text : <?php echo '"' . $unbelted_goal_name . '"'; ?>,
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                //x: 120,
                horizontalAlign: 'bottom',
                y: 20,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
            },
            series: [{
                name: <?php echo '"' . $unbelted_data['yname'] . '"'; ?>,
                type: 'spline',
                // yAxis: 1,
                data: [<?php echo join($safety_data['Unbelt_asleep_others'], ',') ?>],
                tooltip: {
                    valueSuffix: ''
                }

            }, {
                name: <?php echo '"' . $unbelted_goal_name . '"'; ?>,
                type: 'spline',
                // yAxis: 1,
                data: [<?php echo join($safety_data['goal'], ',') ?>],
                tooltip: {
                    valueSuffix: ''
                }
            }]
        });
    });

    $(function () {
        $('#cell_distraction').highcharts({
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: <?php echo '"' . $cell_distraction_data['title'] . '"'; ?>
            },
            // subtitle: {
            //     text: 'DNFB'
            // },
            colors: ['#42f4cb','#d16e73'],
            xAxis: [{
                title: {
                    text: <?php echo '"' . $cell_distraction_data['xname'] . '"'; ?>,
                     y: -7
                },
                categories: [<?php echo '"' . join($safety_data['date1'],'","') . '"'; ?>],
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: <?php echo '"' . $cell_distraction_data['yname'] . '"'; ?>,
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text : <?php echo '"' . $cell_distraction_goal_name . '"'; ?>,
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                //x: 120,
                horizontalAlign: 'bottom',
                y: 20,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
            },
            series: [{
                name: <?php echo '"' . $cell_distraction_data['yname'] . '"'; ?>,
                type: 'spline',
                // yAxis: 1,
                data: [<?php echo join($safety_data['Cell_phone_other_Distraction'], ',') ?>],
                tooltip: {
                    valueSuffix: ''
                }

            }, {
                name: <?php echo '"' . $cell_distraction_goal_name . '"'; ?>,
                type: 'spline',
                // yAxis: 1,
                data: [<?php echo join($safety_data['goal'], ',') ?>],
                tooltip: {
                    valueSuffix: ''
                }
            }]
        });
    });

    $(function () {
        $('#pretrip').highcharts({
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: <?php echo '"' . $pretrip_data['title'] . '"'; ?>
            },
            colors: ['#fff44f'],
            xAxis: [{
                title: {
                    text: <?php echo '"' . $pretrip_data['xname'] . '"'; ?>,
                     y: -7
                },
                categories: [<?php echo '"' . join($pretrip_data['date1'],'","') . '"'; ?>],
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: <?php echo '"' . $pretrip_data['yname'] . '"'; ?>,
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }],
            tooltip: {
                shared: true
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                //x: 120,
                horizontalAlign: 'bottom',
                y: 20,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
            },
            series: [{
                name: <?php echo '"' . $pretrip_data['yname'] . '"'; ?>,
                type: 'column',
                // yAxis: 1,
                data: [<?php echo join($pretrip_data['pretrip_cnt'], ',') ?>],
                tooltip: {
                    valueSuffix: ''
                }

            }]
        });
    });

   $(function () {
      $('#svtc').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: <?php echo '"' . $svtc_data['title'] . '"'; ?>
        },
        colors: ['#B2FF66','#FF9933'],
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: <?php echo '"' . $svtc_data['title'] . '"'; ?>,
            data: [
                <?php foreach ($combined_data as $key => $value) {
                          echo $value;
                        } ?>
            ]
        }]
      });
    });
});
</script>

<script type="text/javascript">
$(document).ready(function(){
    $('[id^=mil_goal]').keypress(validateNumber);
    $('[id^=fuel_goal]').keypress(validateNumber);
    $('[id^=goal]').keypress(validateNumber);
    $('[id^=idling_goal]').keypress(validateNumber);
    $('[id^=cruise_goal]').keypress(validateNumber);
    $('[id^=top_gear_goal]').keypress(validateNumber);
    $('[id^=speed_goal]').keypress(validateNumber);
});

function validateNumber(event) {
    var key = window.event ? event.keyCode : event.which;
    if (event.keyCode === 8 || event.keyCode === 46) {
        return true;
    } else if ( key < 48 || key > 57 ) {
        return false;
    } else {
        return true;
    }
};
    
</script>

<!-- jQuery -->
    <!-- <script src="js/jquery.min.js"></script> -->

    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

<!-- external javascript -->

<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="js/jquery-ui-sliderAccess.js"></script>
<script src="js/highcharts.js"></script>
<script src="js/highcharts-3d.js"></script>
<script src="js/modules/exporting.js"></script>
<!-- <script src="js/modules/data.js"></script>
<script src="js/modules/drilldown.js"></script> -->
<script src="js/export-csv.js"></script>

<?php if($_SESSION['level'] == 3){
echo '<script>
     //   $("#selectCompany").change(function(){
          $("#selectManager").change(function(){
            var company_id = $("#selectCompany").val();
            var manager_id = $("#selectManager").val();
            
            $("#selectDriver").html("");
             if (company_id.length > 0 ) {
              if (manager_id.length > 0 ) {
                 $.ajax({
                     type: "POST",
                     url: "fetch.php",
                     data: {company_id: company_id, manager_id: manager_id},
                     cache: false,
                     
                     success: function(html) {
                        
                        $("#selectDriver").html( html );
                     }
                 });
             }
             }
        //  });
        });
</script>';
} else if($_SESSION['level'] == 1) {
  echo '<script>
        $("#selectCompany").change(function(){
            var company_id = $("#selectCompany").val();
             if (company_id.length > 0 ) {
                 $.ajax({
                     type: "POST",
                     url: "fetch.php",
                     data: {company_id: company_id},
                     cache: false,
                     
                     success: function(html) {
                         
                        $("#selectDriver").html( html );
                     }
                 });
             }
        });
  </script>';
} ?>

<script type="text/javascript">

// $(document).on("click","#myTab a",function() {
//     var sel = $(this).attr("href");
//     $("#hidden").val(sel);
// });

  function myprintFunction() {
    window.print();
  }
  
  (function($) {

  'use strict';

  $(document).on('show.bs.tab', '.nav-tabs-responsive [data-toggle="tab"]', function(e) {
    var $target = $(e.target);
    var $tabs = $target.closest('.nav-tabs-responsive');
    var $current = $target.closest('li');
    var $parent = $current.closest('li.dropdown');
    $current = $parent.length > 0 ? $parent : $current;
    var $next = $current.next();
    var $prev = $current.prev();
    var updateDropdownMenu = function($el, position){
      $el
        .find('.dropdown-menu')
        .removeClass('pull-xs-left pull-xs-center pull-xs-right')
        .addClass( 'pull-xs-' + position );
    };

    $tabs.find('>li').removeClass('next prev');
    $prev.addClass('prev');
    $next.addClass('next');
    
    updateDropdownMenu( $prev, 'left' );
    updateDropdownMenu( $current, 'center' );
    updateDropdownMenu( $next, 'right' );
  });

})(jQuery);

$(document).ready(function(){
    $('#startDate').datepicker({
        changeMonth: true,
        maxDate: $("#endDate").val() != ''?$("#endDate").val():'today',
        changeYear: true,
        yearRange: '1900:+0',
        dateFormat: 'mm/dd/yy',
        onSelect:function(selected){
            $("#endDate").datepicker("option","minDate", selected);
            // var startDate = $('#startDate').val();
            // var endDate = $('#endDate').val();
            // $('#date_filter').submit();
            //showCharts(1);
        }
    });
    $( "#endDate" ).datepicker({
        changeMonth: true,
        minDate:$("#startDate").val(),
        
        changeYear: true,
        
        dateFormat: 'mm/dd/yy',
        setDate: "+0",
        onSelect:function(selected){
            $("#startDate").datepicker("option","maxDate", selected);
            // var startDate = $('#startDate').val();
            // var endDate = $('#endDate').val();
            // $('#date_filter').submit();
            //showCharts(1);
        }
    });

    // var startDate = $('#startDate').val();
    // var endDate = $('#endDate').val();
    // if(startDate > endDate){
    //     alert('Start Date should be less than End Date!!')
    // }
    
}); 
</script>

<script type="text/javascript">
    $(document).ready(function() {
    $('#startDate').attr('disabled','disabled');   
    $('#endDate').attr('disabled','disabled');      
    $('select[name="selectWeeks"]').on('change',function(){
    var others = $(this).val();
        if(others == "Date Range"){           
        $('#startDate').removeAttr('disabled'); 
        $('#endDate').removeAttr('disabled');    
        $('#selectWeeks').attr('disabled','disabled');       
         }else{
         $('#startDate').attr('disabled','disabled');
         $('#endDate').attr('disabled','disabled'); 
         $('#selectWeeks').removeAttr('disabled'); 
        }  
      });
    });
</script>

<script type="text/javascript">
    Highcharts.Chart.prototype.viewData = function () {
        if (!this.insertedTable) {
            var div = document.createElement('div');
            div.className = 'highcharts-data-table';
            // Insert after the chart container
            this.renderTo.parentNode.insertBefore(div, this.renderTo.nextSibling);
            div.innerHTML = this.getTable();
            this.insertedTable = true;
            var date_str = new Date().getTime().toString();
            var rand_str = Math.floor(Math.random() * (1000000)).toString();
            this.insertedTableID = 'div_' + date_str + rand_str
            div.id = this.insertedTableID;
        }
        else {
            $('#' + this.insertedTableID).toggle();
        }
    };
</script>


<?php
	$GLOBALS['RENDER']->renderFooter();
?>