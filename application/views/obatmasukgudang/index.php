<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  </head>
  <body>
  <section class="section">
    <div class="container">
        <div class="month">
            <select name="BulanMasuk" id="BulanMasuk">
                <option value="Januari">Januari</option>
                <option value="Februari">Februari</option>
                <option value="Maret">Maret</option>
                <option value="April">April</option>
                <option value="Mei">Mei</option>
            </select>
            <select name="TahunMasuk" id="TahunMasuk">
                <option value="2021">2021</option>
            </select>
            <div class="col-sm-4">
                <button type="button" id="btn-filter" class="btn btn-primary">Filter</button>
                <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="table-siswa">
            <thead>
                <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Jenis Kelamin</th>
                <th>Dinkes</th>
                <th>Bulan Masuk</th>
                <th>Tahun Masuk</th>
                </tr>
            </thead>
            <tbody></tbody>
            </table>
        </div>
    </div>
  </section>
  </body>
  <script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript">
    var tableobat;
    $(document).ready(function() {
        tableobat = $('#table-siswa').DataTable({
                "processing": true,
                "serverSide": true,
                "order" : [],
                "ajax": {
                    "url": "<?= base_url('dataobat/obatmasuk/getobatmasukgudang') ?>",
                    "type": "POST",
                    "dataType" : "JSON",
                    "data" : function(data){
                        data.BulanMasuk = $("#BulanMasuk").val();
                        data.TahunMasuk = $("#TahunMasuk").val();
                    },
                }
        });

        $('#btn-filter').click(function(){
            tableobat.ajax.reload();
        })
            
  });
  </script>
</html>