$(document).ready(function () {
  fetch_data();

  /**
   * Ujrafesti a tablazatot select change-en.
   */
  $('#kliensselect').change('draw.user_data', function () {
    var kliensselect = document.getElementById('kliensselect').value;
    fetch_data(kliensselect);
  });

  /**
   * Ajax call-t vegez a server-hez.
   *
   * A DataTable fuggveny elvegzi az AJAX-ot, nincs szukseg kulon AJAX call-ra.
   *
   * @param kliensid
   *   Ha letezik kliens ID akkor azt jelenti hogy .change fuggvenybol indul a
   *   fuggveny call.
   *   Ha nem letezik akkor az altalanos call ami a file elejen van es akkor kliensid = undefined.
   */
  function fetch_data(kliensid) {
    var dataTableObject = {
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        url: "/fetchTable",
        type: "POST",
      }
    };
    if (kliensid) {
      // Muszaj megsemmisiteni a letezo DataTable objektumot, ahhoz, hogy ujat rajzoljon.
      $('#user_data').DataTable().destroy();
      $('#user_data tbody').empty();
      dataTableObject.ajax.data = {kliensid: kliensid};
    }

    // Itt tortenik a rajzolas.
    var dataTable = $('#user_data').DataTable(dataTableObject);
  }

  function update_data(id, column_name, value) {
    $.ajax({
      url: "update.php",
      method: "POST",
      data: {id: id, column_name: column_name, value: value},
      success: function (data) {
        $('#alert_message').html('<div class="alert alert-success">' + data + '</div>');
        $('#user_data').DataTable().destroy();
        fetch_data();
      }
    });
    setInterval(function () {
      $('#alert_message').html('');
    }, 5000);
  }


  $(document).on('blur', '.update', function () {
    var id = $(this).data("id");
    console.log(id);
    var column_name = $(this).data("column");
    console.log(column_name);
    var value = $(this).text();
    if (confirm("Biztosan módosítod?")) {
      update_data(id, column_name, value);
    }
  });

  $('#add').click(function () {
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

  $(document).on('click', '#insert', function () {
    var Nev = $('#data1').text();
    var telefonszam = $('#data2').text();
    var email = $('#data3').text();
    var cim = $('#data4').text();
    var testmagassag = $('#data5').text();
    var szuletesi_datum = $('#data6').text();
    var kivant_testsuly = $('#data7').text();
    var varhato_idotartam = $('#data8').text();

    if (Nev != '') {
      $.ajax({
        url: "insert.php",
        method: "POST",
        data: {
          Nev: Nev,
          telefonszam: telefonszam,
          email: email,
          cim: cim,
          testmagassag: testmagassag,
          szuletesi_datum: szuletesi_datum,
          kivant_testsuly: kivant_testsuly,
          varhato_idotartam: varhato_idotartam
        },
        success: function (data) {
          alert(data);
          if (data == 't') {
            $('#alert_message').html('<div class="alert alert-success">"Az adatot rögzítettük az adatbázisba!"</div>');
            $('#user_data').DataTable().destroy();
          } else {
            alert("Sikertelen adat rögzítés");
            $('#user_data').DataTable().destroy();
          }
          fetch_data();
        }
      });
      setInterval(function () {
        $('#alert_message').html('');
      }, 5000);
    }
    else {
      alert("Both Fields is required");
    }
  });

  $(document).on('click', '.delete', function () {
    var id = $(this).attr("id");
    console.log(id);
    if (confirm("Biztosan Törölni szeretnéd?")) {
      $.ajax({
        url: "delete.php",
        method: "POST",
        data: {id: id},
        success: function (data) {
          $('#alert_message').html('<div class="alert alert-success">' + data + '</div>');
          $('#user_data').DataTable().destroy();
          fetch_data();
        }
      });
      setInterval(function () {
        $('#alert_message').html('');
      }, 5000);
    }
  });
});
