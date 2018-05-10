<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Adatlap</title>
    <link rel="stylesheet" href="../assets/css/index.css" type="text/css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
    <link rel="stylesheet" href="/css/main.css"/>
    <script
      src="https://code.jquery.com/jquery-2.2.4.min.js"
      integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
      crossorigin="anonymous">
    </script>
</head>
<body>
<!-- Navigation Bar-->
<div class="container box">
    <h1 align="center">Kliensek adatlapja</h1>
    <br />
    <!-- Kliensek kivalasztasa -->
    <h5>
        Kliens kiválasztása:
        <select id="kliensselect">
            <option disabled selected>Kliensek</option>
            <?php
                foreach ($data as $kliens) {
                    print "<option value='$kliens[0]'>$kliens[1]</option>";
                }
        ?>
        </select>
    </h5>

    <div class="table-responsive">
        <br />
        <div align="right">
            <button type="button" name="add" id="add" class="btn btn-info">Hozzáadás</button>
        </div>
        <br />
        <div id="alert_message"></div>
        <table id="user_data" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Ügyfél neve</th>
                <th>Telefonszám</th>
                <th>email</th>
                <th>Cím</th>
                <th>Testmagasság</th>
                <th>Születési Dátum</th>
                <th>Kívánt testsúly</th>
                <th>Várható időtartam</th>
                <th></th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<script src="/js/table.js"></script>
</body>
</html>
