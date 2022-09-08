<?php
include_once("funcs.php");
$pdo = db_conn();

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
    if($_POST["op_owner_foundation_".$i]=="<"){
      $owner_foundation .= "DATE_FORMAT(owner_foundation, '%Y') < :owner_foundation_".$i;
    } elseif($_POST["op_owner_foundation_".$i]=="<="){
      $owner_foundation .= "DATE_FORMAT(owner_foundation, '%Y') <= :owner_foundation_".$i;
    } elseif($_POST["op_owner_foundation_".$i]=="="){
      $owner_foundation .= "DATE_FORMAT(owner_foundation, '%Y') = :owner_foundation_".$i;
    } elseif($_POST["op_owner_foundation_".$i]==">="){
      $owner_foundation .= "DATE_FORMAT(owner_foundation, '%Y') >= :owner_foundation_".$i;
    } else {
      $owner_foundation .= "DATE_FORMAT(owner_foundation, '%Y') > :owner_foundation_".$i;
    };
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

$where = $owner_name.$p_region.$owner_foundation.$owner_capital.$owner_employee.$owner_vessel.$owner_cost.$owner_crew_mng.$owner_group.$owner_decarbon;

$stmt = $pdo->prepare("SELECT * FROM cap_owner INNER JOIN (SELECT count(owner_id) AS owner_vessel, owner_id FROM cap_vessel GROUP BY owner_id HAVING owner_vessel>0) AS xxx ON id=xxx.owner_id WHERE (id > :id)".$where);
$stmt->bindValue(':id', "0", PDO::PARAM_INT);

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

$status = $stmt->execute();

$view="";
if($status==false) {
  sql_error($stmt);
}else{
  $view .= '<table>';
  $view .= '<tr>';
  $view .= '<th rowspan="2">船主</th>';
  $view .= '<th rowspan="2">所在地</th>';
  $view .= '<th rowspan="2">資本金<br>(百万円)</th>';
  $view .= '<th rowspan="2">従業員数<br>(人)</th>';
  $view .= '<th rowspan="2">保有隻数</th>';
  $view .= '<th colspan="4">関心事項</th>';
  $view .= '</tr>';
  $view .= '<tr>';
  $view .= '<th>運航コスト</th>';
  $view .= '<th>船員・<br>安全運航</th>';
  $view .= '<th>船主グループ化</th>';
  $view .= '<th>脱炭素化</th>';
  $view .= '</tr>';  
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<tr>';
    $view .= '<td>'.'<a href="owner_page.php?id='.h($r["id"]).'">'.h($r["owner_name"]).'</a>'.'</td>';
    $view .= '<td>'.h($r["p_region"]).h($r["p_locality"]).'</td>';
    $view .= '<td>'.number_format(h($r["owner_capital"])/1000000).'</td>';
    $view .= '<td>'.number_format(h($r["owner_employee"])).'</td>';
    $stmt2 = $pdo->prepare("SELECT COUNT(*) as cnt_number FROM cap_vessel WHERE owner_id=?");
    $stmt2->execute(array($r["id"]));
    $record = $stmt2->fetch();
    $view .= '<td>'.number_format(h($record["cnt_number"])).'</td>';
    $view .= '<td>'.h($r["owner_cost"]).'</td>';
    $view .= '<td>'.h($r["owner_crew_mng"]).'</td>';
    $view .= '<td>'.h($r["owner_group"]).'</td>';
    $view .= '<td>'.h($r["owner_decarbon"]).'</td>';
    $view .= '</tr>'; 
  }
  $view .= '</table>';
}
$view .= '</table>';

echo $view;
?>