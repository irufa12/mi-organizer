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
							<td style="width:20%">no_tlp</td>
							<td><?= $tenant->no_tlp;?></td>
						</tr>
						<tr>
							<td>Logo tenant</td>
							<td><?php if(!empty($tenant->logo !== "0")){?>
									<a href="<?= base_url('assets_style/image/tenant/'.$tenant->logo);?>" target="_blank">
										<img src="<?= base_url('assets_style/image/tenant/'.$tenant->logo);?>" style="width:170px;height:170px;" class="img-responsive">
									</a>
									<?php }else{ echo '<br/><p style="color:red">* Tidak ada logo</p>';}?>
								</td>
						</tr>
						<tr>
							<td>Judul tenant</td>
							<td><?= $tenant->nama_tenant;?></td>
						</tr>
						<tr>
							<td>Kategori</td>
							<td><?= $kat->nama_kategori;?></td>
						</tr>
						<tr>
							<td>Penerbit</td>
							<td><?= $tenant->penerbit;?></td>
						</tr>
						<tr>
							<td>Pengarang</td>
							<td><?= $tenant->pengarang;?></td>
						</tr>
						<tr>
							<td>Tahun Terbit</td>
							<td><?= $tenant->thn_tenant;?></td>
						</tr>
						<tr>
							<td>Jumlah tenant</td>
							<td><?= $tenant->jml;?></td>
						</tr>
						<tr>
							<td>Jumlah Pinjam</td>
							<td>
								<?php
									$id = $tenant->tenant_id;
									$dd = $this->db->query("SELECT * FROM tbl_pinjam WHERE tenant_id= '$id' AND status = 'Dipinjam'");
									if($dd->num_rows() > 0 )
									{
										echo $dd->num_rows();
									}else{
										echo '0';
									}
								?> 
								<a data-toggle="modal" data-target="#TableAnggota" class="btn btn-primary btn-xs" style="margin-left:1pc;">
									<i class="fa fa-sign-in"></i> Detail Pinjam</a>
							</td>
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
			<th>Jenkel</th>
			<th>Telepon</th>
			<th>Tgl Pinjam</th>
			<th>Lama Pinjam</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$no = 1;
	$tenantid = $tenant->tenant_id;
	$pin = $this->db->query("SELECT * FROM tbl_pinjam WHERE tenant_id ='$tenantid' AND status = 'Dipinjam'")->result_array();
	foreach($pin as $si)
	{
		$isi = $this->M_Admin->get_tableid_edit('tbl_login','anggota_id',$si['anggota_id']);
		if($isi->level == 'Anggota'){
		?>
		<tr>
			<td><?= $no;?></td>
			<td><?= $isi->anggota_id;?></td>
			<td><?= $isi->nama;?></td>
			<td><?= $isi->jenkel;?></td>
			<td><?= $isi->telepon;?></td>
			<td><?= $si['tgl_pinjam'];?></td>
			<td><?= $si['lama_pinjam'];?> Hari</td>
		</tr>
	<?php $no++;}}?>
	</tbody>
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
