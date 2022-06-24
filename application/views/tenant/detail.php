<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<?php
	$idkat = $tenant->id_kategori;
	$idlokasi = $tenant->id_lokasi;

	$kat = $this->M_Admin->get_tableid_edit('tbl_kategori','id_kategori',$idkat);
	$lokasi = $this->M_Admin->get_tableid_edit('tbl_lokasi','id_lokasi',$idlokasi);
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <i class="fa fa-book" style="color:green"> </i>  <?= $title_web;?>
    </h1>
    <ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
			<li class="active"><i class="fa fa-book"></i>&nbsp;  <?= $title_web;?></li>
    </ol>
  </section>
  <section class="content">
	<div class="row">
	    <div class="col-md-12">
	        <div class="box box-primary">
                <div class="box-header with-border">
					<h4><?= $tenant->nama_tenant;?></h4>
                </div>
			    <!-- /.box-header -->
			    <div class="box-body">
					<table class="table table-striped table-bordered">
						<tr>
							<td>Judul tenant</td>
							<td><?= $tenant->nama_tenant;?></td>
						</tr>
						<tr>
							<td style="width:20%">No Telephone</td>
							<td><?= $tenant->no_telephone;?></td>
						</tr>
						<tr>
							<td>Logo Tenant</td>
							<td><?php if(!empty($tenant->logo !== "0")){?>
									<a href="<?= base_url('assets_style/image/tenant/'.$tenant->logo);?>" target="_blank">
										<img src="<?= base_url('assets_style/image/tenant/'.$tenant->logo);?>" style="width:170px;height:170px;" class="img-responsive">
									</a>
									<?php }else{ echo '<br/><p style="color:red">* Tidak ada logo</p>';}?>
								</td>
						</tr>
						<tr>
							<td>Kategori</td>
							<td><?= $kat->nama_kategori;?></td>
						</tr>
						<tr>
							<td>Perusahaan</td>
							<td><?= $tenant->perusahaan;?></td>
						</tr>
						<tr>
							<td>Penanggung Jawab</td>
							<td><?= $tenant->penanggung_jawab;?></td>
						</tr>
						<tr>
							<td>Jumlah tenant</td>
							<td><?= $tenant->jml;?></td>
						</tr>
						<tr>
							<td>Lokasi</td>
							<td><?= $lokasi->nama_lokasi;?></td>
						</tr>
						<tr>
							<td>Tanggal Masuk</td>
							<td><?= $tenant->tgl_masuk;?></td>
						</tr>
					</table>
		        </div>
	        </div>
	    </div>
    </div>
</section>
</div>

 <!--modal import -->
<div class="modal fade" id="TableAnggota">
<div class="modal-dialog" style="width:70%">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span></button>
<h4 class="modal-title"> Anggota Yang Sedang Pinjam</h4>
</div>
<div id="modal_body" class="modal-body fileSelection1">
	<table id="example1" class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>No</th>
				<th>ID</th>
				<th>Nama</th>
				<th>Jenis Kelamin</th>
				<th>Telephone</th>
			</tr>
		</thead>
	</table>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
