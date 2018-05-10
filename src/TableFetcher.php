<?php

class TableFetcher {

    /**
     * @var \mysqli
     */
    private $dbConnection;

    /**
     * TableFetcher constructor.
     *
     * @param \mysqli $dbConnection
     */
    public function __construct() {
        $this->dbConnection = Connection::getConnection();
    }

    private function query() {
        $query = "SELECT id, Nev, telefonszam, email, cim, testmagassag, szuletesi_datum, kivant_testsuly, varhato_idotartam from ugyfelek ";

        if(isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"]))
        {
            $query .= 'WHERE Nev LIKE "%'.$_POST["search"]["value"].'%" OR telefonszam LIKE "%'.$_POST["search"]["value"].'%"';
        }

        if(isset($_POST["kliensid"]) && !empty($_POST["kliensid"]))
        {
            $ideje = $_POST["kliensid"];
            $query .= "WHERE id = $ideje";
        }

        return $query;
    }

    public function getTableData() {
        $query = $this->query();
        $number_filter_row = mysqli_num_rows(mysqli_query($this->dbConnection, $query));
        $result = mysqli_query($this->dbConnection, $query);

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

        $output = array(
            "draw"    => intval($_POST["draw"]),
            "recordsTotal"  =>  $this->get_all_data($this->dbConnection),
            "recordsFiltered" => $number_filter_row,
            "data"    => $data
        );

        return \json_encode($output);
    }

    private function get_all_data($connect)
    {
        $query = "SELECT id, telefonszam, email, cim, testmagassag, szuletesi_datum, kivant_testsuly, varhato_idotartam from ugyfelek";
        $result = mysqli_query($connect, $query);
        return mysqli_num_rows($result);
    }

}
