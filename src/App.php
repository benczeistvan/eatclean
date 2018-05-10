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
        $data = $this->loadData();

        $page = include __DIR__ . '/../template/html.php';

        print $page;
    }
}
