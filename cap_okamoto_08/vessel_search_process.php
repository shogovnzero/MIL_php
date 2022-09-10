<?php
session_start();
include_once("funcs.php");
sschk();
$pdo = db_conn();

$cnt_vessel_name_jp = $_POST["cnt_vessel_name_jp"];
$cnt_vessel_name_en = $_POST["cnt_vessel_name_en"];
$cnt_manager = $_POST["cnt_manager"];
$cnt_operator = $_POST["cnt_operator"];
$cnt_vessel_reg_port = $_POST["cnt_vessel_reg_port"];
$cnt_vessel_trade_pref = $_POST["cnt_vessel_trade_pref"];
$cnt_vessel_trade_port = $_POST["cnt_vessel_trade_port"];

$cnt_vessel_type = $_POST["cnt_vessel_type"];
$cnt_vessel_gt = $_POST["cnt_vessel_gt"];
$cnt_vessel_nt = $_POST["cnt_vessel_nt"];
$cnt_vessel_dwt = $_POST["cnt_vessel_dwt"];
$cnt_vessel_tank = $_POST["cnt_vessel_tank"];
$cnt_vessel_teu = $_POST["cnt_vessel_teu"];
$cnt_vessel_loa = $_POST["cnt_vessel_loa"];
$cnt_vessel_beam = $_POST["cnt_vessel_beam"];
$cnt_vessel_depth = $_POST["cnt_vessel_depth"];
$cnt_vessel_draft = $_POST["cnt_vessel_draft"];
$cnt_vessel_crew = $_POST["cnt_vessel_crew"];

$cnt_vessel_sy = $_POST["cnt_vessel_sy"];
$cnt_vessel_built = $_POST["cnt_vessel_built"];
$cnt_vessel_me = $_POST["cnt_vessel_me"];
$cnt_vessel_fuel = $_POST["cnt_vessel_fuel"];

$cnt_owner_name = $_POST["cnt_owner_name"];
$cnt_p_region = $_POST["cnt_p_region"];
$cnt_owner_foundation = $_POST["cnt_owner_foundation"];
$cnt_owner_capital = $_POST["cnt_owner_capital"];
$cnt_owner_employee = $_POST["cnt_owner_employee"];
$cnt_owner_vessel = $_POST["cnt_owner_vessel"];
$cnt_owner_cost = $_POST["cnt_owner_cost"];
$cnt_owner_crew_mng = $_POST["cnt_owner_crew_mng"];
$cnt_owner_group = $_POST["cnt_owner_group"];
$cnt_owner_decarbon = $_POST["cnt_owner_decarbon"];

// 運航情報
$vessel_name_jp = "";
$i = 1;
$j = 1;
while($i <= $cnt_vessel_name_jp){
  if(isset($_POST["vessel_name_jp_".$i])){
    if($j==1){
      $vessel_name_jp .= " AND (";
      $j += 1;
    } else {
      $vessel_name_jp .= " OR ";
    };
    if($_POST["op_vessel_name_jp_".$i]=="含む"){
      $vessel_name_jp .= "vessel_name_jp LIKE :vessel_name_jp_".$i;
    } else {
      $vessel_name_jp .= "vessel_name_jp NOT LIKE :vessel_name_jp_".$i;
    };
  };
  $i += 1;
};
if(!empty($vessel_name_jp)){
  $vessel_name_jp .= ")";
};

$vessel_name_en = "";
$i = 1;
$j = 1;
while($i <= $cnt_vessel_name_en){
  if(isset($_POST["vessel_name_en_".$i])){
    if($j==1){
      $vessel_name_en .= " AND (";
      $j += 1;
    } else {
      $vessel_name_en .= " OR ";
    };
    if($_POST["op_vessel_name_en_".$i]=="含む"){
      $vessel_name_en .= "vessel_name_en LIKE :vessel_name_en_".$i;
    } else {
      $vessel_name_en .= "vessel_name_en NOT LIKE :vessel_name_en_".$i;
    };
  };
  $i += 1;
};
if(!empty($vessel_name_en)){
  $vessel_name_en .= ")";
};

$manager = "";
$i = 1;
$j = 1;
while($i <= $manager){
  if(isset($_POST["manager_".$i])){
    if($j==1){
      $manager .= " AND (";
      $j += 1;
    } else {
      $manager .= " OR ";
    };
    if($_POST["op_manager_".$i]=="含む"){
      $manager .= "manager LIKE :manager_".$i;
    } else {
      $manager .= "manager NOT LIKE :manager_".$i;
    };
  };
  $i += 1;
};
if(!empty($manager)){
  $manager .= ")";
};

$operator = "";
$i = 1;
$j = 1;
while($i <= $operator){
  if(isset($_POST["operator_".$i])){
    if($j==1){
      $operator .= " AND (";
      $j += 1;
    } else {
      $operator .= " OR ";
    };
    if($_POST["op_operator_".$i]=="含む"){
      $operator .= "operator LIKE :operator_".$i;
    } else {
      $operator .= "operator NOT LIKE :operator_".$i;
    };
  };
  $i += 1;
};
if(!empty($operator)){
  $operator .= ")";
};

$vessel_reg_port = "";
$i = 1;
$j = 1;
while($i <= $cnt_vessel_reg_port){
  if(isset($_POST["vessel_reg_port_".$i])){
    if($j==1){
      $vessel_reg_port .= " AND (";
      $j += 1;
    } else {
      $vessel_reg_port .= " OR ";
    };
    if($_POST["op_vessel_name_en_".$i]=="含む"){
      $vessel_reg_port .= "vessel_reg_port LIKE :vessel_reg_port_".$i;
    } else {
      $vessel_reg_port .= "vessel_reg_port NOT LIKE :vessel_reg_port_".$i;
    };
  };
  $i += 1;
};
if(!empty($vessel_reg_port)){
  $vessel_reg_port .= ")";
};

$vessel_trade_pref = "";
$i = 1;
$j = 1;
while($i <= $cnt_vessel_trade_pref){
  if(isset($_POST["vessel_trade_pref_".$i])){
    if($j==1){
      $vessel_trade_pref .= " AND (";
      $j += 1;
    } else {
      $vessel_trade_pref .= " OR ";
    };
    if($_POST["op_vessel_name_en_".$i]=="含む"){
      $vessel_trade_pref .= "vessel_trade_pref LIKE :vessel_trade_pref_".$i;
    } else {
      $vessel_trade_pref .= "vessel_trade_pref NOT LIKE :vessel_trade_pref_".$i;
    };
  };
  $i += 1;
};
if(!empty($vessel_trade_pref)){
  $vessel_trade_pref .= ")";
};

$vessel_trade_port = "";
$i = 1;
$j = 1;
while($i <= $cnt_vessel_trade_port){
  if(isset($_POST["vessel_trade_port_".$i])){
    if($j==1){
      $vessel_trade_port .= " AND (";
      $j += 1;
    } else {
      $vessel_trade_port .= " OR ";
    };
    if($_POST["op_vessel_name_en_".$i]=="含む"){
      $vessel_trade_port .= "vessel_trade_port LIKE :vessel_trade_port_".$i;
    } else {
      $vessel_trade_port .= "vessel_trade_port NOT LIKE :vessel_trade_port_".$i;
    };
  };
  $i += 1;
};
if(!empty($vessel_trade_port)){
  $vessel_trade_port .= ")";
};

// 船種・船型
$vessel_type = "";
$i = 1;
$j = 1;
while($i <= $cnt_vessel_type){
  if(isset($_POST["vessel_type_".$i])){
    if($j==1){
      $vessel_type .= " AND (";
      $j += 1;
    } else {
      $vessel_type .= " OR ";
    };
    if($_POST["op_vessel_type_".$i]=="含む"){
      $vessel_type .= "vessel_type LIKE :vessel_type_".$i;
    } else {
      $vessel_type .= "vessel_type NOT LIKE :vessel_type_".$i;
    };
  };
  $i += 1;
};
if(!empty($vessel_type)){
  $vessel_type .= ")";
};

$vessel_gt = "";
$i = 1;
$j = 1;
while($i <= $cnt_vessel_gt){
  if(isset($_POST["vessel_gt_".$i])){
    if($j==1){
      $vessel_gt .= " AND (";
      $j += 1;
    } else {
      $vessel_gt .= " OR ";
    };
    $vessel_gt .= "vessel_gt ";
    if($_POST["op_vessel_gt_".$i]=="<"){
      $vessel_gt .= "<";
    } elseif($_POST["op_vessel_gt_".$i]=="<="){
      $vessel_gt .= "<=";
    } elseif($_POST["op_vessel_gt_".$i]=="="){
      $vessel_gt .= "=";
    } elseif($_POST["op_vessel_gt_".$i]==">="){
      $vessel_gt .= ">=";
    } else {
      $vessel_gt .= ">";
    };
    $vessel_gt .= " :vessel_gt_".$i;
  };
  $i += 1;
};
if(!empty($vessel_gt)){
  $vessel_gt .= ")";
};

$vessel_nt = "";
$i = 1;
$j = 1;
while($i <= $cnt_vessel_nt){
  if(isset($_POST["vessel_nt_".$i])){
    if($j==1){
      $vessel_nt .= " AND (";
      $j += 1;
    } else {
      $vessel_nt .= " OR ";
    };
    $vessel_nt .= "vessel_nt ";
    if($_POST["op_vessel_nt_".$i]=="<"){
      $vessel_nt .= "<";
    } elseif($_POST["op_vessel_nt_".$i]=="<="){
      $vessel_nt .= "<=";
    } elseif($_POST["op_vessel_nt_".$i]=="="){
      $vessel_nt .= "=";
    } elseif($_POST["op_vessel_nt_".$i]==">="){
      $vessel_nt .= ">=";
    } else {
      $vessel_nt .= ">";
    };
    $vessel_nt .= " :vessel_nt_".$i;
  };
  $i += 1;
};
if(!empty($vessel_nt)){
  $vessel_nt .= ")";
};

$vessel_dwt = "";
$i = 1;
$j = 1;
while($i <= $cnt_vessel_dwt){
  if(isset($_POST["vessel_dwt_".$i])){
    if($j==1){
      $vessel_dwt .= " AND (";
      $j += 1;
    } else {
      $vessel_dwt .= " OR ";
    };
    $vessel_dwt .= "vessel_dwt ";
    if($_POST["op_vessel_dwt_".$i]=="<"){
      $vessel_dwt .= "<";
    } elseif($_POST["op_vessel_dwt_".$i]=="<="){
      $vessel_dwt .= "<=";
    } elseif($_POST["op_vessel_dwt_".$i]=="="){
      $vessel_dwt .= "=";
    } elseif($_POST["op_vessel_dwt_".$i]==">="){
      $vessel_dwt .= ">=";
    } else {
      $vessel_dwt .= ">";
    };
    $vessel_dwt .= " :vessel_dwt_".$i;
  };
  $i += 1;
};
if(!empty($vessel_dwt)){
  $vessel_dwt .= ")";
};

$vessel_tank = "";
$i = 1;
$j = 1;
while($i <= $cnt_vessel_tank){
  if(isset($_POST["vessel_tank_".$i])){
    if($j==1){
      $vessel_tank .= " AND (";
      $j += 1;
    } else {
      $vessel_tank .= " OR ";
    };
    $vessel_tank .= "vessel_tank ";
    if($_POST["op_vessel_tank_".$i]=="<"){
      $vessel_tank .= "<";
    } elseif($_POST["op_vessel_tank_".$i]=="<="){
      $vessel_tank .= "<=";
    } elseif($_POST["op_vessel_tank_".$i]=="="){
      $vessel_tank .= "=";
    } elseif($_POST["op_vessel_tank_".$i]==">="){
      $vessel_tank .= ">=";
    } else {
      $vessel_tank .= ">";
    };
    $vessel_tank .= " :vessel_tank_".$i;
  };
  $i += 1;
};
if(!empty($vessel_tank)){
  $vessel_tank .= ")";
};

$vessel_teu = "";
$i = 1;
$j = 1;
while($i <= $cnt_vessel_teu){
  if(isset($_POST["vessel_teu_".$i])){
    if($j==1){
      $vessel_teu .= " AND (";
      $j += 1;
    } else {
      $vessel_teu .= " OR ";
    };
    $vessel_teu .= "vessel_teu ";
    if($_POST["op_vessel_teu_".$i]=="<"){
      $vessel_teu .= "<";
    } elseif($_POST["op_vessel_teu_".$i]=="<="){
      $vessel_teu .= "<=";
    } elseif($_POST["op_vessel_teu_".$i]=="="){
      $vessel_teu .= "=";
    } elseif($_POST["op_vessel_teu_".$i]==">="){
      $vessel_teu .= ">=";
    } else {
      $vessel_teu .= ">";
    };
    $vessel_teu .= " :vessel_teu_".$i;
  };
  $i += 1;
};
if(!empty($vessel_teu)){
  $vessel_teu .= ")";
};

$vessel_loa = "";
$i = 1;
$j = 1;
while($i <= $cnt_vessel_loa){
  if(isset($_POST["vessel_loa_".$i])){
    if($j==1){
      $vessel_loa .= " AND (";
      $j += 1;
    } else {
      $vessel_loa .= " OR ";
    };
    $vessel_loa .= "vessel_loa ";
    if($_POST["op_vessel_loa_".$i]=="<"){
      $vessel_loa .= "<";
    } elseif($_POST["op_vessel_loa_".$i]=="<="){
      $vessel_loa .= "<=";
    } elseif($_POST["op_vessel_loa_".$i]=="="){
      $vessel_loa .= "=";
    } elseif($_POST["op_vessel_loa_".$i]==">="){
      $vessel_loa .= ">=";
    } else {
      $vessel_loa .= ">";
    };
    $vessel_loa .= " :vessel_loa_".$i;
  };
  $i += 1;
};
if(!empty($vessel_loa)){
  $vessel_loa .= ")";
};

$vessel_beam = "";
$i = 1;
$j = 1;
while($i <= $cnt_vessel_beam){
  if(isset($_POST["vessel_beam_".$i])){
    if($j==1){
      $vessel_beam .= " AND (";
      $j += 1;
    } else {
      $vessel_beam .= " OR ";
    };
    $vessel_beam .= "vessel_beam ";
    if($_POST["op_vessel_beam_".$i]=="<"){
      $vessel_beam .= "<";
    } elseif($_POST["op_vessel_beam_".$i]=="<="){
      $vessel_beam .= "<=";
    } elseif($_POST["op_vessel_beam_".$i]=="="){
      $vessel_beam .= "=";
    } elseif($_POST["op_vessel_beam_".$i]==">="){
      $vessel_beam .= ">=";
    } else {
      $vessel_beam .= ">";
    };
    $vessel_beam .= " :vessel_beam_".$i;
  };
  $i += 1;
};
if(!empty($vessel_beam)){
  $vessel_beam .= ")";
};

$vessel_depth = "";
$i = 1;
$j = 1;
while($i <= $cnt_vessel_depth){
  if(isset($_POST["vessel_depth_".$i])){
    if($j==1){
      $vessel_depth .= " AND (";
      $j += 1;
    } else {
      $vessel_depth .= " OR ";
    };
    $vessel_depth .= "vessel_depth ";
    if($_POST["op_vessel_depth_".$i]=="<"){
      $vessel_depth .= "<";
    } elseif($_POST["op_vessel_depth_".$i]=="<="){
      $vessel_depth .= "<=";
    } elseif($_POST["op_vessel_depth_".$i]=="="){
      $vessel_depth .= "=";
    } elseif($_POST["op_vessel_depth_".$i]==">="){
      $vessel_depth .= ">=";
    } else {
      $vessel_depth .= ">";
    };
    $vessel_depth .= " :vessel_depth_".$i;
  };
  $i += 1;
};
if(!empty($vessel_depth)){
  $vessel_depth .= ")";
};

$vessel_draft = "";
$i = 1;
$j = 1;
while($i <= $cnt_vessel_draft){
  if(isset($_POST["vessel_draft_".$i])){
    if($j==1){
      $vessel_draft .= " AND (";
      $j += 1;
    } else {
      $vessel_draft .= " OR ";
    };
    $vessel_draft .= "vessel_draft ";
    if($_POST["op_vessel_draft_".$i]=="<"){
      $vessel_draft .= "<";
    } elseif($_POST["op_vessel_draft_".$i]=="<="){
      $vessel_draft .= "<=";
    } elseif($_POST["op_vessel_draft_".$i]=="="){
      $vessel_draft .= "=";
    } elseif($_POST["op_vessel_draft_".$i]==">="){
      $vessel_draft .= ">=";
    } else {
      $vessel_draft .= ">";
    };
    $vessel_draft .= " :vessel_draft_".$i;
  };
  $i += 1;
};
if(!empty($vessel_draft)){
  $vessel_draft .= ")";
};

$vessel_crew = "";
$i = 1;
$j = 1;
while($i <= $cnt_vessel_crew){
  if(isset($_POST["vessel_crew_".$i])){
    if($j==1){
      $vessel_crew .= " AND (";
      $j += 1;
    } else {
      $vessel_crew .= " OR ";
    };
    $vessel_crew .= "vessel_crew ";
    if($_POST["op_vessel_crew_".$i]=="<"){
      $vessel_crew .= "<";
    } elseif($_POST["op_vessel_crew_".$i]=="<="){
      $vessel_crew .= "<=";
    } elseif($_POST["op_vessel_crew_".$i]=="="){
      $vessel_crew .= "=";
    } elseif($_POST["op_vessel_crew_".$i]==">="){
      $vessel_crew .= ">=";
    } else {
      $vessel_crew .= ">";
    };
    $vessel_crew .= " :vessel_crew_".$i;
  };
  $i += 1;
};
if(!empty($vessel_crew)){
  $vessel_crew .= ")";
};

// 技術情報
$vessel_sy = "";
$i = 1;
$j = 1;
while($i <= $cnt_vessel_sy){
  if(isset($_POST["vessel_sy_".$i])){
    if($j==1){
      $vessel_sy .= " AND (";
      $j += 1;
    } else {
      $vessel_sy .= " OR ";
    };
    if($_POST["op_vessel_sy_".$i]=="含む"){
      $vessel_sy .= "vessel_sy LIKE :vessel_sy_".$i;
    } else {
      $vessel_sy .= "vessel_sy NOT LIKE :vessel_sy_".$i;
    };
  };
  $i += 1;
};
if(!empty($vessel_sy)){
  $vessel_sy .= ")";
};

$vessel_built = "";
$i = 1;
$j = 1;
while($i <= $cnt_vessel_built){
  if(isset($_POST["vessel_built_".$i])){
    if($j==1){
      $vessel_built .= " AND (";
      $j += 1;
    } else {
      $vessel_built .= " OR ";
    };
    $vessel_built .= "DATE_FORMAT(vessel_built, '%Y') ".$_POST["op_vessel_built_".$i]." :vessel_built_".$i;
  };
  $i += 1;
};
if(!empty($vessel_built)){
  $vessel_built .= ")";
};

$vessel_me = "";
$i = 1;
$j = 1;
while($i <= $cnt_vessel_me){
  if(isset($_POST["vessel_me_".$i])){
    if($j==1){
      $vessel_me .= " AND (";
      $j += 1;
    } else {
      $vessel_me .= " OR ";
    };
    if($_POST["op_vessel_me_".$i]=="含む"){
      $vessel_me .= "vessel_me LIKE :vessel_me_".$i;
    } else {
      $vessel_me .= "vessel_me NOT LIKE :vessel_me_".$i;
    };
  };
  $i += 1;
};
if(!empty($vessel_me)){
  $vessel_me .= ")";
};

$vessel_fuel = "";
$i = 1;
$j = 1;
while($i <= $cnt_vessel_fuel){
  if(isset($_POST["vessel_fuel_".$i])){
    if($j==1){
      $vessel_fuel .= " AND (";
      $j += 1;
    } else {
      $vessel_fuel .= " OR ";
    };
    if($_POST["op_vessel_fuel_".$i]=="含む"){
      $vessel_fuel .= "vessel_fuel LIKE :vessel_fuel_".$i;
    } else {
      $vessel_fuel .= "vessel_fuel NOT LIKE :vessel_fuel_".$i;
    };
  };
  $i += 1;
};
if(!empty($vessel_fuel)){
  $vessel_fuel .= ")";
};

// 船主情報
$owner_name = "";
$i = 1;
$j = 1;
while($i <= $cnt_owner_name){
  if(isset($_POST["owner_name_".$i])){
    if($j==1){
      $owner_name .= " AND (";
      $j += 1;
    } else {
      $owner_name .= " OR ";
    };
    if($_POST["op_owner_name_".$i]=="含む"){
      $owner_name .= "owner_name LIKE :owner_name_".$i;
    } else {
      $owner_name .= "owner_name NOT LIKE :owner_name_".$i;
    };
  };
  $i += 1;
};
if(!empty($owner_name)){
  $owner_name .= ")";
};

$p_region = "";
$i = 1;
$j = 1;
while($i <= $cnt_p_region){
  if(isset($_POST["p_region_".$i])){
    if($j==1){
      $p_region .= " AND (";
      $j += 1;
    } else {
      $p_region .= " OR ";
    };
    if($_POST["op_p_region_".$i]=="含む"){
      $p_region .= "p_region LIKE :p_region_".$i;
    } else {
      $p_region .= "p_region NOT LIKE :p_region_".$i;
    };
  };
  $i += 1;
};
if(!empty($p_region)){
  $p_region .= ")";
};

$owner_foundation = "";
$i = 1;
$j = 1;
while($i <= $cnt_owner_foundation){
  if(isset($_POST["owner_foundation_".$i])){
    if($j==1){
      $owner_foundation .= " AND (";
      $j += 1;
    } else {
      $owner_foundation .= " OR ";
    };
    $owner_foundation .= "DATE_FORMAT(owner_foundation, '%Y') ".$_POST["op_owner_foundation_".$i]." :owner_foundation_".$i;
  };
  $i += 1;
};
if(!empty($owner_foundation)){
  $owner_foundation .= ")";
};

$owner_capital = "";
$i = 1;
$j = 1;
while($i <= $cnt_owner_capital){
  if(isset($_POST["owner_capital_".$i])){
    $_POST["owner_capital_".$i] = $_POST["owner_capital_".$i]*1000000;
    if($j==1){
      $owner_capital .= " AND (";
      $j += 1;
    } else {
      $owner_capital .= " OR ";
    };
    if($_POST["op_owner_capital_".$i]=="<"){
      $owner_capital .= "owner_capital < :owner_capital_".$i;
    } elseif($_POST["op_owner_capital_".$i]=="<="){
      $owner_capital .= "owner_capital <= :owner_capital_".$i;
    } elseif($_POST["op_owner_capital_".$i]=="="){
      $owner_capital .= "owner_capital = :owner_capital_".$i;
    } elseif($_POST["op_owner_capital_".$i]==">="){
      $owner_capital .= "owner_capital >= :owner_capital_".$i;
    } else {
      $owner_capital .= "owner_capital > :owner_capital_".$i;
    };
  };
  $i += 1;
};
if(!empty($owner_capital)){
  $owner_capital .= ")";
};

$owner_employee = "";
$i = 1;
$j = 1;
while($i <= $cnt_owner_employee){
  if(isset($_POST["owner_employee_".$i])){
    if($j==1){
      $owner_employee .= " AND (";
      $j += 1;
    } else {
      $owner_employee .= " OR ";
    };
    if($_POST["op_owner_employee_".$i]=="<"){
      $owner_employee .= "owner_employee < :owner_employee_".$i;
    } elseif($_POST["op_owner_employee_".$i]=="<="){
      $owner_employee .= "owner_employee <= :owner_employee_".$i;
    } elseif($_POST["op_owner_employee_".$i]=="="){
      $owner_employee .= "owner_employee = :owner_employee_".$i;
    } elseif($_POST["op_owner_employee_".$i]==">="){
      $owner_employee .= "owner_employee >= :owner_employee_".$i;
    } else {
      $owner_employee .= "owner_employee > :owner_employee_".$i;
    };
  };
  $i += 1;
};
if(!empty($owner_employee)){
  $owner_employee .= ")";
};

$owner_vessel = "";
$i = 1;
$j = 1;
while($i <= $cnt_owner_vessel){
  if(isset($_POST["owner_vessel_".$i])){
    if($j==1){
      $owner_vessel .= " AND (";
      $j += 1;
    } else {
      $owner_vessel .= " OR ";
    };
    if($_POST["op_owner_vessel_".$i]=="<"){
      $owner_vessel .= "owner_vessel < :owner_vessel_".$i;
    } elseif($_POST["op_owner_vessel_".$i]=="<="){
      $owner_vessel .= "owner_vessel <= :owner_vessel_".$i;
    } elseif($_POST["op_owner_vessel_".$i]=="="){
      $owner_vessel .= "owner_vessel = :owner_vessel_".$i;
    } elseif($_POST["op_owner_vessel_".$i]==">="){
      $owner_vessel .= "owner_vessel >= :owner_vessel_".$i;
    } else {
      $owner_vessel .= "owner_vessel > :owner_vessel_".$i;
    };
  };
  $i += 1;
};
if(!empty($owner_vessel)){
  $owner_vessel .= ")";
};

$owner_cost = "";
$i = 1;
$j = 1;
while($i <= $cnt_owner_cost){
  if(isset($_POST["owner_cost_".$i])){
    if($j==1){
      $owner_cost .= " AND (";
      $j += 1;
    } else {
      $owner_cost .= " OR ";
    };
    if($_POST["op_owner_cost_".$i]=="含む"){
      $owner_cost .= "owner_cost LIKE :owner_cost_".$i;
    } else {
      $owner_cost .= "owner_cost NOT LIKE :owner_cost_".$i;
    };
  };
  $i += 1;
};
if(!empty($owner_cost)){
  $owner_cost .= ")";
};

$owner_crew_mng = "";
$i = 1;
$j = 1;
while($i <= $cnt_owner_crew_mng){
  if(isset($_POST["owner_crew_mng_".$i])){
    if($j==1){
      $owner_crew_mng .= " AND (";
      $j += 1;
    } else {
      $owner_crew_mng .= " OR ";
    };
    if($_POST["op_owner_crew_mng_".$i]=="含む"){
      $owner_crew_mng .= "owner_crew_mng LIKE :owner_crew_mng_".$i;
    } else {
      $owner_crew_mng .= "owner_crew_mng NOT LIKE :owner_crew_mng_".$i;
    };
  };
  $i += 1;
};
if(!empty($owner_crew_mng)){
  $owner_crew_mng .= ")";
};

$owner_group = "";
$i = 1;
$j = 1;
while($i <= $cnt_owner_group){
  if(isset($_POST["owner_group_".$i])){
    if($j==1){
      $owner_group .= " AND (";
      $j += 1;
    } else {
      $owner_group .= " OR ";
    };
    if($_POST["op_owner_group_".$i]=="含む"){
      $owner_group .= "owner_group LIKE :owner_group_".$i;
    } else {
      $owner_group .= "owner_group NOT LIKE :owner_group_".$i;
    };
  };
  $i += 1;
};
if(!empty($owner_group)){
  $owner_group .= ")";
};

$owner_decarbon = "";
$i = 1;
$j = 1;
while($i <= $cnt_owner_decarbon){
  if(isset($_POST["owner_decarbon_".$i])){
    if($j==1){
      $owner_decarbon .= " AND (";
      $j += 1;
    } else {
      $owner_decarbon .= " OR ";
    };
    if($_POST["op_owner_decarbon_".$i]=="含む"){
      $owner_decarbon .= "owner_decarbon LIKE :owner_decarbon_".$i;
    } else {
      $owner_decarbon .= "owner_decarbon NOT LIKE :owner_decarbon_".$i;
    };
  };
  $i += 1;
};
if(!empty($owner_decarbon)){
  $owner_decarbon .= ")";
};

$where = "";
$where .= $vessel_name_jp.$vessel_name_en.$manager.$operator.$vessel_reg_port.$vessel_trade_pref.$vessel_trade_port;
$where .= $vessel_type.$vessel_gt.$vessel_nt.$vessel_dwt.$vessel_tank.$vessel_teu.$vessel_loa.$vessel_beam.$vessel_depth.$vessel_draft.$vessel_crew;
$where .= $vessel_sy.$vessel_built.$vessel_me.$vessel_fuel;
$where .= $owner_name.$p_region.$owner_foundation.$owner_capital.$owner_employee.$owner_vessel.$owner_cost.$owner_crew_mng.$owner_group.$owner_decarbon;

$stmt = $pdo->prepare("SELECT * FROM cap_vessel INNER JOIN (SELECT id,owner_name,owner_foundation,owner_capital,owner_employee,p_region,owner_cost,owner_crew_mng,owner_group,owner_decarbon,owner_vessel FROM cap_owner INNER JOIN (SELECT count(owner_id) AS owner_vessel, owner_id FROM cap_vessel GROUP BY owner_id HAVING owner_vessel>0) AS xxx ON id=xxx.owner_id) AS yyy ON cap_vessel.owner_id = yyy.id WHERE (id > :id)".$where);
$stmt->bindValue(':id', "0", PDO::PARAM_INT);

// 運航情報
$i = 1;
while($i <= $cnt_vessel_name_jp){
  if(isset($_POST["vessel_name_jp_".$i])){
    $stmt->bindValue(':vessel_name_jp_'.$i, "%".$_POST["vessel_name_jp_".$i]."%", PDO::PARAM_STR);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_vessel_name_en){
  if(isset($_POST["vessel_name_en_".$i])){
    $stmt->bindValue(':vessel_name_en_'.$i, "%".$_POST["vessel_name_en_".$i]."%", PDO::PARAM_STR);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_manager){
  if(isset($_POST["manager_".$i])){
    $stmt->bindValue(':manager_'.$i, "%".$_POST["manager_".$i]."%", PDO::PARAM_STR);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_operator){
  if(isset($_POST["operator_".$i])){
    $stmt->bindValue(':operator_'.$i, "%".$_POST["operator_".$i]."%", PDO::PARAM_STR);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_vessel_reg_port){
  if(isset($_POST["vessel_reg_port_".$i])){
    $stmt->bindValue(':vessel_reg_port_'.$i, "%".$_POST["vessel_reg_port_".$i]."%", PDO::PARAM_STR);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_vessel_trade_pref){
  if(isset($_POST["vessel_trade_pref_".$i])){
    $stmt->bindValue(':vessel_trade_pref_'.$i, "%".$_POST["vessel_trade_pref_".$i]."%", PDO::PARAM_STR);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_vessel_trade_port){
  if(isset($_POST["vessel_trade_port_".$i])){
    $stmt->bindValue(':vessel_trade_port_'.$i, "%".$_POST["vessel_trade_port_".$i]."%", PDO::PARAM_STR);
  };
  $i += 1;
};

// 船種・船型
$i = 1;
while($i <= $cnt_vessel_type){
  if(isset($_POST["vessel_type_".$i])){
    $stmt->bindValue(':vessel_type_'.$i, "%".$_POST["vessel_type_".$i]."%", PDO::PARAM_STR);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_vessel_gt){
  if(isset($_POST["vessel_gt_".$i])){
    $stmt->bindValue(':vessel_gt_'.$i, $_POST["vessel_gt_".$i], PDO::PARAM_INT);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_vessel_nt){
  if(isset($_POST["vessel_nt_".$i])){
    $stmt->bindValue(':vessel_nt_'.$i, $_POST["vessel_nt_".$i], PDO::PARAM_INT);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_vessel_dwt){
  if(isset($_POST["vessel_dwt_".$i])){
    $stmt->bindValue(':vessel_dwt_'.$i, $_POST["vessel_dwt_".$i], PDO::PARAM_INT);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_vessel_tank){
  if(isset($_POST["vessel_tank_".$i])){
    $stmt->bindValue(':vessel_tank_'.$i, $_POST["vessel_tank_".$i], PDO::PARAM_INT);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_vessel_teu){
  if(isset($_POST["vessel_teu_".$i])){
    $stmt->bindValue(':vessel_teu_'.$i, $_POST["vessel_teu_".$i], PDO::PARAM_INT);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_vessel_loa){
  if(isset($_POST["vessel_loa_".$i])){
    $stmt->bindValue(':vessel_loa_'.$i, $_POST["vessel_loa_".$i], PDO::PARAM_INT);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_vessel_beam){
  if(isset($_POST["vessel_beam_".$i])){
    $stmt->bindValue(':vessel_beam_'.$i, $_POST["vessel_beam_".$i], PDO::PARAM_INT);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_vessel_depth){
  if(isset($_POST["vessel_depth_".$i])){
    $stmt->bindValue(':vessel_depth_'.$i, $_POST["vessel_depth_".$i], PDO::PARAM_INT);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_vessel_draft){
  if(isset($_POST["vessel_draft_".$i])){
    $stmt->bindValue(':vessel_draft_'.$i, $_POST["vessel_draft_".$i], PDO::PARAM_INT);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_vessel_crew){
  if(isset($_POST["vessel_crew_".$i])){
    $stmt->bindValue(':vessel_crew_'.$i, $_POST["vessel_crew_".$i], PDO::PARAM_INT);
  };
  $i += 1;
};

// 技術情報
$i = 1;
while($i <= $cnt_vessel_sy){
  if(isset($_POST["vessel_sy_".$i])){
    $stmt->bindValue(':vessel_sy_'.$i, "%".$_POST["vessel_sy_".$i]."%", PDO::PARAM_STR);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_vessel_built){
  if(isset($_POST["vessel_built_".$i])){
    $stmt->bindValue(':vessel_built_'.$i, $_POST["vessel_built_".$i], PDO::PARAM_INT);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_vessel_me){
  if(isset($_POST["vessel_me_".$i])){
    $stmt->bindValue(':vessel_me_'.$i, "%".$_POST["vessel_me_".$i]."%", PDO::PARAM_STR);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_vessel_fuel){
  if(isset($_POST["vessel_fuel_".$i])){
    $stmt->bindValue(':vessel_fuel_'.$i, "%".$_POST["vessel_fuel_".$i]."%", PDO::PARAM_STR);
  };
  $i += 1;
};

// 船主情報
$i = 1;
while($i <= $cnt_owner_name){
  if(isset($_POST["owner_name_".$i])){
    $stmt->bindValue(':owner_name_'.$i, "%".$_POST["owner_name_".$i]."%", PDO::PARAM_STR);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_p_region){
  if(isset($_POST["p_region_".$i])){
    $stmt->bindValue(':p_region_'.$i, "%".$_POST["p_region_".$i]."%", PDO::PARAM_STR);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_owner_foundation){
  if(isset($_POST["owner_foundation_".$i])){
    $stmt->bindValue(':owner_foundation_'.$i, $_POST["owner_foundation_".$i], PDO::PARAM_INT);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_owner_capital){
  if(isset($_POST["owner_capital_".$i])){
    $stmt->bindValue(':owner_capital_'.$i, $_POST["owner_capital_".$i], PDO::PARAM_INT);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_owner_employee){
  if(isset($_POST["owner_employee_".$i])){
    $stmt->bindValue(':owner_employee_'.$i, $_POST["owner_employee_".$i], PDO::PARAM_INT);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_owner_vessel){
  if(isset($_POST["owner_vessel_".$i])){
    $stmt->bindValue(':owner_vessel_'.$i, $_POST["owner_vessel_".$i], PDO::PARAM_INT);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_owner_cost){
  if(isset($_POST["owner_cost_".$i])){
    $stmt->bindValue(':owner_cost_'.$i, "%".$_POST["owner_cost_".$i]."%", PDO::PARAM_STR);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_owner_crew_mng){
  if(isset($_POST["owner_crew_mng_".$i])){
    $stmt->bindValue(':owner_crew_mng_'.$i, "%".$_POST["owner_crew_mng_".$i]."%", PDO::PARAM_STR);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_owner_group){
  if(isset($_POST["owner_group_".$i])){
    $stmt->bindValue(':owner_group_'.$i, "%".$_POST["owner_group_".$i]."%", PDO::PARAM_STR);
  };
  $i += 1;
};

$i = 1;
while($i <= $cnt_owner_decarbon){
  if(isset($_POST["owner_decarbon_".$i])){
    $stmt->bindValue(':owner_decarbon_'.$i, "%".$_POST["owner_decarbon_".$i]."%", PDO::PARAM_STR);
  };
  $i += 1;
};

$view="";
$status = $stmt->execute();
if($status==false) {
  sql_error($stmt);
}else{
  $view .= '<table>';
  $view .= '<tr>';
  $view .= '<th>船名</th>';
  $view .= '<th>船種</th>';
  $view .= '<th>DWT [t]</th>';
  $view .= '<th>LOA [m]</th>';
  $view .= '<th>造船所</th>';
  $view .= '<th>建造年</th>';
  $view .= '<th>燃料</th>';
  $view .= '<th>船主</th>';
  $view .= '</tr>';  
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<tr>';
    $view .= '<td>'.'<a href="vessel_page.php?id='.h($r["vessel_id"]).'">'.h($r["vessel_name_jp"]).'</a>'.'</td>';
    $view .= '<td>'.h($r["vessel_type"]).'</td>';
    $view .= '<td>'.number_format(h($r["vessel_dwt"])).'</td>';
    $view .= '<td>'.number_format(h($r["vessel_loa"]),1).'</td>';
    $view .= '<td>'.h($r["vessel_sy"]).'</td>';
    $view .= '<td>'.substr(h($r["vessel_built"]),0,4).'年</td>';
    $view .= '<td>'.h($r["vessel_fuel"]).'</td>';
    $view .= '<td>'.'<a href="owner_page.php?id='.h($r["id"]).'">'.h($r["owner_name"]).'</a>'.'</td>';
    $view .= '</tr>';
  }
  $view .= '</table>';
}
echo $view;
?>