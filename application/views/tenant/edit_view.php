<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <i class="fa fa-edit" style="color:green"> </i>  <?= $title_web;?>
    </h1>
    <ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
			<li class="active"><i class="fa fa-edit"></i>&nbsp;  <?= $title_web;?></li>
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
									<label>Kategori</label>
									<select class="form-control select2" required="required"  name="kategori">
										<option disabled selected value> -- Pilih Kategori -- </option>
										<?php foreach($kats as $isi){?>
											<option value="<?= $isi['id_kategori'];?>" <?php if($isi['id_kategori'] == $tenant->id_kategori){ echo 'selected';}?>><?= $isi['nama_kategori'];?></option>
										<?php }?>
									</select>
								</div>
                                <div class="form-group">
                                    <label>Lokasi</label>
                                    <select name="lokasi" class="form-control select2" required="required">
										<option disabled selected value> -- Pilih Lokasi -- </option>
										<?php foreach($lokasitenant as $isi){?>
											<option value="<?= $isi['id_lokasi'];?>" <?php if($isi['id_lokasi'] == $tenant->id_lokasi){ echo 'selected';}?>><?= $isi['nama_lokasi'];?></option>
										<?php }?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>No Telephone</label>
                                    <input type="text" class="form-control" value="<?= $tenant->no_telephone;?>" name="no_telephone"  placeholder="Contoh no_telephone : 978-602-8123-35-8">
                                </div>
                                <div class="form-group">
                                    <label>Nama Tenant</label>
                                    <input type="text" class="form-control" value="<?= $tenant->nama_tenant;?>" name="nama_tenant" placeholder="Contoh : Cara Cepat Belajar Pemrograman Web">
                                </div>
                                <div class="form-group">
                                    <label>Nama Penanggung Jawab</label>
                                    <input type="text" class="form-control" value="<?= $tenant->penanggung_jawab;?>" name="penanggung_jawab" placeholder="Nama penanggung_jawab">
                                </div>
                                <div class="form-group">
                                    <label>Perusahaan</label>
                                    <input type="text" class="form-control" value="<?= $tenant->perusahaan;?>" name="perusahaan" placeholder="Nama perusahaan">
                                </div>
                            </div>
                            <div class="col-sm-6">
								
								<div class="form-group">
                                    <label>Jumlah tenant</label>
                                    <input type="number" class="form-control" value="<?= $tenant->jml;?>" name="jml" placeholder="Jumlah tenant : 12">
								</div>
                                <div class="form-group">
								<label>logo <small style="color:green">(gambar) * opsional</small></label>
									<input type="file" accept="image/*" name="gambar">

									<?php if(!empty($tenant->logo !== "0")){?>
									<br/>
									<a href="<?= base_url('assets_style/image/tenant/'.$tenant->logo);?>" target="_blank">
										<img src="<?= base_url('assets_style/image/tenant/'.$tenant->logo);?>" style="width:70px;height:70px;" class="img-responsive">
									</a>
									<?php }else{ echo '<br/><p style="color:red">* Tidak ada logo</p>';}?>
								</div>
                            </div>
                        </div>
                        <div class="pull-right">
							<input type="hidden" name="gmbr" value="<?= $tenant->logo;?>">
							<input type="hidden" name="edit" value="<?= $tenant->id_tenant;?>">
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
