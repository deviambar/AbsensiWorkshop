<!DOCTYPE html>
<html lang="en">
<head>
	<?php $this->load->view("admin/_partials/head.php") ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
	<?php $this->load->view("admin/_partials/navbar.php") ?>
	<?php $this->load->view("admin/_partials/sidebar.php") ?>
	<div class="content-wrapper">
		<div class="container-fluid">
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Absensi</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <?php echo anchor('laporanpdf', 'Generate PDF Report'); ?>
              <table id="mytable" class="table table-striped table-bordered">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Event</th>
                  <th>Nama Peserta</th>
                  <th>NRP</th>
                  <th>Jurusan</th>
                  <th>Kehadiran</th>
                </tr>
                </thead>
                <?php $i = 1 ; 
                foreach ($data as $row) 
                { ?>
                <tbody>
                  <th> <?php echo $i ; ?></th>
                  <th><?php echo $row->nama_event; ?></th>
                  <th><?php echo $row->nama_siswa; ?></th>
                  <th><?php echo $row->nrp_siswa; ?></th>
                  <th><?php echo $row->nama_jurusan; ?></th>
                  <th><?php echo $row->ket_kehadiran; ?></th>
                </tbody>
                <?php $i++; } ?>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
		</div>
	</div>
</div>
<?php $this->load->view("admin/_partials/footer.php") ?>
<!-- /#wrapper -->
<?php $this->load->view("admin/_partials/js.php") ?>
    
</body>
</html>
