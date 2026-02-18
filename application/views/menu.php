<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!isset($_SESSION["id"])) { //jika tidak ada id
   $this->session->set_flashdata('type', 'alert-danger');
   $this->session->set_flashdata('pesan', '<strong>Error!</strong> Anda harus login terlebih dahulu');
   redirect();
   exit;
}

?>
        <!-- untuk daftar menu dst, cek header.php-->

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">
                        <img src="img/kanisius.png">
                    </ul>
                </nav>

                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Daftar Menu atau Tabel</h1>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <?php if(isset($_SESSION["pesan"])){ ?>
                            <div class="alert <?= $_SESSION['type']?> alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?= $_SESSION['pesan']?>

                            </div>
                            <?php unset($_SESSION['pesan']); } ?>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="nama" class="col-sm-2 col-form-label">Tanggal: <label style="color:red">*</label></label>
                        <div class="col-sm-2">
                            <input type="date" class="form-control" id="tanggal" name="tanggal">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-primary" onclick="getContoh2()" id="tombolCari"><i class="fas fa-search"></i> Cari</button>
                        </div>
                        <div class="col-sm-1">
                           <a href="tambah"><button type="button" class="btn btn-primary"> Tambah </button></a> 
                        </div>
                    </div>

                    

                    <div class="row">
                        <div class="col">
                            <table id="tabel" class="display nowrap" style="width:100%">
                                <thead style="color: black;">
                                    <tr>
                                        <th style="width:10px">Nomor</th>
                                        <th>Judul Buku</th>
                                        <th>Penulis</th>
                                        <th>Penerbit</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody" name="tbody" style="color: black;">
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                </div>

            </div>
            
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>© <?php echo date("Y"); ?> PT Kanisius.</span>
                    </div>
                </div>
            </footer>

        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.js"></script>
    
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="vendor/datatables/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="vendor/datatables/dataTables.select.min.js"></script>
    
    <!-- CKEditor -->
    <script src="vendor/ckeditor/ckeditor.js"></script>
    <script src="vendor/ckeditor/translations/id.js"></script>
    
    <!-- xlsx -->
    <script type="text/javascript" src="vendor/xlsx/xlsx.fix.js"></script>
    
    <script>
        // gunakan Javascript dan jQuery
        // bisa cek untuk contoh membuat form: https://getbootstrap.com/docs/4.0/components/forms/
		
        $(document).ready(function() { // jika jalaman web selesai diload, maka jalankan script ini
            $('#menuMenu').trigger('click'); //buka "Contoh Menu" (id: menuMenu) pada header
            
            getContoh1();
            
            $('#tabel').DataTable({ //https://datatables.net/reference/option/
                "scrollX": true,
                "select": true,
                "bSort": false
            });
        });
        
        // menggunakan AJAX untuk membuat tabel dari data tabel
        // AJAX (View) -> Controller -> Model -> dapat hasil
        function getContoh1(){
            var html = '';
            var no = 1;
            
            $.ajax({
                url: "<?php echo base_url('Select/contoh1'); ?>", //Controller Select.php, function contoh1()
                method: "POST",
                dataType: "JSON",
                async : false,
                success: function(data) {
                    for (var i = 0; i < data.length; i++) {
                        
                        html += '<tr>';
                        html += '<td>'+no+'</td>';
                        html += '<td>'+data[i].nama_buku+'</td>';
                        html += '<td>'+data[i].penulis+'</td>';
                        html += '<td>'+data[i].penerbit+'</td>';
                        html += '<td>'+data[i].tanggal+'</td>';
                         // KOLOM AKSI
                        html += '<td>';
                        html += '<a href="<?= base_url('edit?id=') ?>'+data[i].id_buku+'"><button class="btn btn-warning btn-sm">Edit</button></a>';
                        html += '<button class="btn btn-danger btn-sm delete" data-id="'+data[i].id_buku+'">Delete</button>';
                        html += '</td>';
                        html += '</tr>';
                        
                        no++;
                    }
                    $("#tbody").html(html);
                }
            });
        }
		
        // kalau butuh input dari user
        function getContoh2(){
            var test = 'inputtan dari user';
            var test = $('#tanggal').val();

            $('#tabel').DataTable().destroy();
            var url = "<?php echo base_url('Select/contoh2?'); ?>"; //Controller Insert.php, function contoh2()
            var urlBaru = url + "inputAjax="+test;

            var html = '';
            var no = 1;
			
            $.ajax({
                url: urlBaru,
                method: "POST",
                dataType: "JSON",
                async : false,
                success: function(data) {
                    for (var i = 0; i < data.length; i++) {
                        
                        html += '<tr>';
                        html += '<td>'+no+'</td>';
                        html += '<td>'+data[i].nama_buku+'</td>';
                        html += '<td>'+data[i].penulis+'</td>';
                        html += '<td>'+data[i].penerbit+'</td>';
                        html += '<td>'+data[i].tanggal+'</td>';
                        html += '<td>';
                        html += '<a href="<?= base_url('edit?id=') ?>'+data[i].id_buku+'"><button class="btn btn-warning btn-sm">Edit</button></a>';
                        html += '<button class="btn btn-danger btn-sm delete" data-id="'+data[i].id_buku+'">Delete</button>';
                        html += '</td>';
                        html += '</tr>';

                        no++;
                    }
                    $("#tbody").html(html);
                }
            });

            $('#tabel').DataTable({ //https://datatables.net/reference/option/
                "scrollX": true,
                "select": true,
                "bSort": false
            });
        }

        // DELETE DATA
        $(document).on('click', '.delete', function(){
            var id = $(this).data('id');

            if(confirm("Yakin ingin menghapus data ini?")){
                $.ajax({
                    url: "<?php echo base_url('Insert/delete'); ?>",
                    method: "POST",
                    data: {id_buku: id},
                    success: function(response){
                        alert("Data berhasil dihapus");
                        location.reload(); // reload halaman
                    }
                });
            }
        });

    </script>

</body>

</html>