<?php
//fetch.php
$connect = mysqli_connect("localhost", "root", "root", "eatclean");
$columns = array('Nev', 'telefonszam', 'email','cim','testmagassag', 'szuletesi_datum', 'kivant_testsuly', 'varhato_idotartam');



$query = "SELECT id, Nev, telefonszam, email, cim, testmagassag, szuletesi_datum, kivant_testsuly, varhato_idotartam from ugyfelek ";


if(isset($_POST["search"]["value"]))
{
 $query .= '
 WHERE Nev LIKE "%'.$_POST["search"]["value"].'%" 
 OR telefonszam LIKE "%'.$_POST["search"]["value"].'%"
 ';
}

 if(isset($_POST["kliensid"]))
 {
  $ideje = $_POST["kliensid"];
  $query .= "
  WHERE id = $ideje
  ";
 }


$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));
$result = mysqli_query($connect, $query);

$data = array();

while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="Nev">' . $row["Nev"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="telefonszam">' . $row["telefonszam"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="email">' . $row["email"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="cim">' . $row["cim"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="testmagassag">' . $row["testmagassag"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="szuletesi_datum">' . $row["szuletesi_datum"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="kivant_testsuly">' . $row["kivant_testsuly"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="varhato_idotartam">' . $row["varhato_idotartam"] . '</div>';
 $sub_array[] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["id"].'">Törlés</button>';
 $data[] = $sub_array;
}

function get_all_data($connect)
{
 $query = "SELECT id, telefonszam, email, cim, testmagassag, szuletesi_datum, kivant_testsuly, varhato_idotartam from ugyfelek";
 $result = mysqli_query($connect, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($connect),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);

?>