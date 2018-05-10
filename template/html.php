

<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Adatlap</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="../assets/css/index.css" type="text/css"/>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <style>
        body
        {
            margin:0;
            padding:0;
            background-color:#f1f1f1;
        }
        .box
        {
            width:1270px;
            padding:20px;
            background-color:#fff;
            border:1px solid #ccc;
            border-radius:5px;
            margin-top:25px;
            box-sizing:border-box;
        }
    </style>
</head>
<body>
<!-- Navigation Bar-->
<div class="container box">
    <script type="text/javascript">

    </script>

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
</body>
<script src="../assets/js/bootstrap.min.js"></script>


</html>

<script type="text/javascript">

</script>




<script type="text/javascript" language="javascript" >
  $(document).ready(function(){

    function selectkliensfunction(kliensid)
    {
      $.ajax({
        url:"fetch.php",
        type:"POST",
        data:{kliensid:kliensid},
        success:function(data)
        {
          console.log(data);
          $('#user_data').DataTable().destroy();
          $('#user_data tbody').empty();
          fetch_data();
        }
      });
      setInterval(function(){
        $('#alert_message').html('');
      }, 5000);
    }

    $('#kliensselect').change('draw.user_data', function(){
      var kliensselect = document.getElementById('kliensselect').value;
      selectkliensfunction(kliensselect);
    });

    fetch_data();

    function fetch_data()
    {
      var dataTable = $('#user_data').DataTable({
        "processing" : true,
        "serverSide" : true,
        "order" : [],
        "ajax" : {
          url:"fetch.php",
          type:"POST"
        }
      });
    }


    function update_data(id, column_name, value)
    {
      $.ajax({
        url:"update.php",
        method:"POST",
        data:{id:id, column_name:column_name, value:value},
        success:function(data)
        {
          $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
          $('#user_data').DataTable().destroy();
          fetch_data();
        }
      });
      setInterval(function(){
        $('#alert_message').html('');
      }, 5000);
    }


    $(document).on('blur', '.update', function(){
      var id = $(this).data("id");
      console.log(id);
      var column_name = $(this).data("column");
      console.log(column_name);
      var value = $(this).text();
      if(confirm("Biztosan módosítod?")){
        update_data(id, column_name, value);
      }
    });

    $('#add').click(function(){
      var html = '<tr>';
      html += '<td contenteditable id="data1"></td>';
      html += '<td contenteditable id="data2"></td>';
      html += '<td contenteditable id="data3"></td>';
      html += '<td contenteditable id="data4"></td>';
      html += '<td contenteditable id="data5"></td>';
      html += '<td contenteditable id="data6"></td>';
      html += '<td contenteditable id="data7"></td>';
      html += '<td contenteditable id="data8"></td>';
      html += '<td><button type="button" name="insert" id="insert" class="btn btn-success btn-xs">Beszúr</button></td>';
      html += '</tr>';
      $('#user_data tbody').prepend(html);
    });

    $(document).on('click', '#insert', function(){
      var Nev = $('#data1').text();
      var telefonszam = $('#data2').text();
      var email = $('#data3').text();
      var cim = $('#data4').text();
      var testmagassag = $('#data5').text();
      var szuletesi_datum = $('#data6').text();
      var kivant_testsuly = $('#data7').text();
      var varhato_idotartam = $('#data8').text();

      if(Nev != '')
      {
        $.ajax({
          url:"insert.php",
          method:"POST",
          data:{Nev:Nev, telefonszam:telefonszam, email:email, cim:cim, testmagassag:testmagassag, szuletesi_datum:szuletesi_datum, kivant_testsuly:kivant_testsuly, varhato_idotartam:varhato_idotartam},
          success:function(data)
          {
            alert(data);
            if (data == 't') {
              $('#alert_message').html('<div class="alert alert-success">"Az adatot rögzítettük az adatbázisba!"</div>');
              $('#user_data').DataTable().destroy();
            }else{
              alert("Sikertelen adat rögzítés");
              $('#user_data').DataTable().destroy();
            }
            fetch_data();
          }
        });
        setInterval(function(){
          $('#alert_message').html('');
        }, 5000);
      }
      else
      {
        alert("Both Fields is required");
      }
    });

    $(document).on('click', '.delete', function(){
      var id = $(this).attr("id");
      console.log(id);
      if(confirm("Biztosan Törölni szeretnéd?"))
      {
        $.ajax({
          url:"delete.php",
          method:"POST",
          data:{id:id},
          success:function(data){
            $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
            $('#user_data').DataTable().destroy();
            fetch_data();
          }
        });
        setInterval(function(){
          $('#alert_message').html('');
        }, 5000);
      }
    });


  });

  //ez
</script>
