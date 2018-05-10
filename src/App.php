<?php

class App {

    private function loadData() {
        $conn = Connection::getConnection();
        $result = $conn->query("select id, Nev from ugyfelek");
        $data = $result->fetch_all();

        Connection::closeConnection();

        return $data;
    }

    public function renderPage() {
        if ($_SERVER['REQUEST_URI'] === '/fetchTable') {
            $fetcher = new TableFetcher();
            echo $fetcher->getTableData();
        }
        else {
            $data = $this->loadData();

            $page = include __DIR__ . '/../template/html.php';

            print $page;
        }
    }
}
