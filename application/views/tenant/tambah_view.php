<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <i class="fa fa-plus" style="color:green"> </i>  <?= $title_web;?>
    </h1>
    <ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
			<li class="active"><i class="fa fa-plus"></i>&nbsp;  <?= $title_web;?></li>
    </ol>
  </section>
  <section class="content">
	<div class="row">
	    <div class="col-md-12">
	        <div class="box box-primary">
                <div class="box-header with-border">
                </div>
			    <!-- /.box-header -->
			    <div class="box-body">
                    <form action="<?php echo base_url('data/prosestenant');?>" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-6">
								<div class="form-group">
                                    <div class="form-group">
                                        <label>Nama Tenant</label>
                                        <input type="text" class="form-control" name="nama_tenant" placeholder="Contoh : Electronic Solution">
                                    </div>
									<label>Kategori</label>
									<select class="form-control select2" required="required"  name="kategori">
										<option disabled selected value> -- Pilih Kategori -- </option>
										<?php foreach($kats as $isi){?>
											<option value="<?= $isi['id_kategori'];?>"><?= $isi['nama_kategori'];?></option>
										<?php }?>
									</select>
								</div>
                                <div class="form-group">
                                    <label>Lokasi</label>
                                    <select name="lokasi" class="form-control select2" required="required">
										<option disabled selected value> -- Pilih lokasi -- </option>
										<?php foreach($lokasitenant as $isi){?>
											<option value="<?= $isi['id_lokasi'];?>"><?= $isi['nama_lokasi'];?></option>
										<?php }?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>No Telephone</label>
                                    <input type="text" class="form-control" name="no_telephone"  placeholder="Contoh No Telephone : 08123456789">
                                </div>
                                <div class="form-group">
                                    <label>Nama Penanggung Jawab</label>
                                    <input type="text" class="form-control" name="penanggung_jawab" placeholder="Nama Penanggung Jawab">
                                </div>
                                <div class="form-group">
                                    <label>Perusahaan</label>
                                    <input type="text" class="form-control" name="perusahaan" placeholder="Nama Perusahaan">
                                </div>
                                <div class="form-group">
                                    <label>Tahun tenant</label>
                                    <input type="number" class="form-control" name="thn" placeholder="Tahun tenant : 2019">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Jumlah tenant</label>
                                    <input type="number" class="form-control" name="jml" placeholder="Jumlah tenant : 12">
                                </div>
								
                                <div class="form-group">
                                    <label>Logo tenant <small style="color:green">(gambar) * opsional</small></label>
                                    <input type="file" accept="image/*" name="gambar">
                                </div>
                            </div>
                        </div>
                        <div class="pull-right">
							<input type="hidden" name="tambah" value="tambah">
                            <button type="submit" class="btn btn-primary btn-md">Submit</button> 
                    </form>
                            <a href="<?= base_url('data');?>" class="btn btn-danger btn-md">Kembali</a>
                        </div>
		        </div>
	        </div>
	    </div>
    </div>
</section>
</div>
