<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <i class="fa fa-edit" style="color:green"> </i>  <?= $title_web;?>
    </h1>
    <ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
			<li class="active"><i class="fa fa-file-text"></i>&nbsp; <?= $title_web;?></li>
    </ol>
  </section>
  <section class="content">
	<?php if(!empty($this->session->flashdata())){ echo $this->session->flashdata('pesan');}?>
	<div class="row">
	    <div class="col-md-12">
	        <div class="box box-primary">
                <div class="box-header with-border">
					<?php if($this->session->userdata('level') == 'Petugas'){?>
                    <a href="data/tenanttambah"><button class="btn btn-primary">
						<i class="fa fa-plus"> </i> Tambah Tenant</button></a>
					<?php }?>
                </div>
				<!-- /.box-header -->
				<div class="box-body">
                    <br/>
					<div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped table" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>logo</th>
                                <!-- <th>no_tlp</th> -->
                                <th>Nama Tenant</th>
                                <th>Penerbit</th>
                                <th>Tahun tenant</th>
                                <th>Stok tenant</th>
                                <th>Dipinjam</th>
                                <th>Tanggal Masuk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=1;foreach($tenant->result_array() as $isi){?>
                            <tr>
                                <td><?= $no;?></td>
                                <td>
                                    <center>
                                        <?php if(!empty($isi['logo'] !== "0")){?>
                                        <img src="<?php echo base_url();?>assets_style/image/tenant/<?php echo $isi['logo'];?>" alt="#" 
                                        class="img-responsive" style="height:auto;width:100px;"/>
                                        <?php }else{?>
                                            <!--<img src="" alt="#" class="user-image" style="border:2px solid #fff;"/>-->
											<i class="fa fa-book fa-3x" style="color:#333;"></i> <br/><br/>
											Tidak Ada logo
                                        <?php }?>
                                    </center>
                                </td>
                                <!-- <td><?= $isi['no_tlp'];?></td> -->
                                <td><?= $isi['nama_tenant'];?></td>
                                <td><?= $isi['penerbit'];?></td>
                                <td><?= $isi['thn_tenant'];?></td>
                                <td><?= $isi['jml'];?></td>
								<td>
									<?php
										$id = $isi['tenant_id'];
										$dd = $this->db->query("SELECT * FROM tbl_pinjam WHERE tenant_id= '$id' AND status = 'Dipinjam'");
										if($dd->num_rows() > 0 )
										{
											echo $dd->num_rows();
										}else{
											echo '0';
										}
									?>
								</td>
                                <td><?= $isi['tgl_masuk'];?></td>
									<td <?php if($this->session->userdata('level') == 'Petugas'){?>style="width:17%;"<?php }?>>
								
									<?php if($this->session->userdata('level') == 'Petugas'){?>
									<a href="<?= base_url('data/tenantedit/'.$isi['id_tenant']);?>"><button class="btn btn-success"><i class="fa fa-edit"></i></button></a>
									<a href="<?= base_url('data/tenantdetail/'.$isi['id_tenant']);?>">
									<button class="btn btn-primary"><i class="fa fa-sign-in"></i> Detail</button></a>
                                    <a href="<?= base_url('data/prosestenant?tenant_id='.$isi['id_tenant']);?>" onclick="return confirm('Anda yakin tenant ini akan dihapus ?');">
									<button class="btn btn-danger"><i class="fa fa-trash"></i></button></a>
									<?php }else{?>
										<a href="<?= base_url('data/tenantdetail/'.$isi['id_tenant']);?>">
										<button class="btn btn-primary"><i class="fa fa-sign-in"></i> Detail</button></a>
									<?php }?>
                                </td>
                            </tr>
                        <?php $no++;}?>
                        </tbody>
                    </table>
			    </div>
			    </div>
	        </div>
    	</div>
    </div>
</section>
</div>
