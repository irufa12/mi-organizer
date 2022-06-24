<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {
	function __construct(){
	 parent::__construct();
	 	//validasi jika user belum login
     $this->data['CI'] =& get_instance();
     $this->load->helper(array('form', 'url'));
     $this->load->model('M_Admin');
		if($this->session->userdata('masuk_login') != TRUE){
				$url=base_url('login');
				redirect($url);
		}
	}

	public function index()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');
		$this->data['tenant'] =  $this->db->query("SELECT * FROM tbl_tenant ORDER BY id_tenant DESC");
        $this->data['title_web'] = 'Data Tenant';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('tenant/tenant_view',$this->data);
        $this->load->view('footer_view',$this->data);
	}

	public function tenantdetail()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');
		$count = $this->M_Admin->CountTableId('tbl_tenant','id_tenant',$this->uri->segment('3'));
		if($count > 0)
		{
			$this->data['tenant'] = $this->M_Admin->get_tableid_edit('tbl_tenant','id_tenant',$this->uri->segment('3'));
			$this->data['kats'] =  $this->db->query("SELECT * FROM tbl_kategori ORDER BY id_kategori DESC")->result_array();
			$this->data['lokasi'] =  $this->db->query("SELECT * FROM tbl_lokasi ORDER BY id_lokasi DESC")->result_array();

		}else{
			echo '<script>alert("tenant TIDAK DITEMUKAN");window.location="'.base_url('data').'"</script>';
		}

		$this->data['title_web'] = 'Data Tenant Detail';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('tenant/detail',$this->data);
        $this->load->view('footer_view',$this->data);
	}

	public function tenantedit()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');
		$count = $this->M_Admin->CountTableId('tbl_tenant','id_tenant',$this->uri->segment('3'));
		if($count > 0)
		{
			
			$this->data['tenant'] = $this->M_Admin->get_tableid_edit('tbl_tenant','id_tenant',$this->uri->segment('3'));
	   
			$this->data['kats'] =  $this->db->query("SELECT * FROM tbl_kategori ORDER BY id_kategori DESC")->result_array();
			$this->data['lokasitenant'] =  $this->db->query("SELECT * FROM tbl_lokasi ORDER BY id_lokasi DESC")->result_array();

		}else{
			echo '<script>alert("tenant TIDAK DITEMUKAN");window.location="'.base_url('data').'"</script>';
		}

		$this->data['title_web'] = 'Data tenant Edit';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('tenant/edit_view',$this->data);
        $this->load->view('footer_view',$this->data);
	}

	public function tenanttambah()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');

		$this->data['kats'] =  $this->db->query("SELECT * FROM tbl_kategori ORDER BY id_kategori DESC")->result_array();
		$this->data['lokasitenant'] =  $this->db->query("SELECT * FROM tbl_lokasi ORDER BY id_lokasi DESC")->result_array();


        $this->data['title_web'] = 'Tambah tenant';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('tenant/tambah_view',$this->data);
        $this->load->view('footer_view',$this->data);
	}


	public function prosestenant()
	{
		if($this->session->userdata('masuk_login') != TRUE){
			$url=base_url('login');
			redirect($url);
		}

		// hapus aksi form proses tenant
		if(!empty($this->input->get('tenant_id')))
		{
        
			$tenant = $this->M_Admin->get_tableid_edit('tbl_tenant','id_tenant',htmlentities($this->input->get('tenant_id')));
			
			$logo = './assets/image/tenant/'.$tenant->logo;
			if(file_exists($logo))
			{
				unlink($logo);
			}
			
			$lampiran = './assets/image/tenant/'.$tenant->lampiran;
			if(file_exists($lampiran))
			{
				unlink($lampiran);
			}
			
			$this->M_Admin->delete_table('tbl_tenant','id_tenant',$this->input->get('tenant_id'));
			
			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-warning">
					<p> Berhasil Hapus tenant !</p>
				</div></div>');
			redirect(base_url('data'));  
		}

		// tambah aksi form proses tenant
		if(!empty($this->input->post('tambah')))
		{
			$post= $this->input->post();
			$tenant_id = $this->M_Admin->buat_kode('tbl_tenant','T','id_tenant','ORDER BY id_tenant DESC LIMIT 1'); 
			$data = array(
				'tenant_id'=>$tenant_id,
				'id_kategori'=>htmlentities($post['kategori']), 
				'id_lokasi' => htmlentities($post['lokasi']), 
				'no_telephone' => htmlentities($post['no_telephone']), 
				'nama_tenant'  => htmlentities($post['nama_tenant']), 
				'penanggung_jawab'=> htmlentities($post['penanggung_jawab']), 
				'perusahaan'=> htmlentities($post['perusahaan']),    
				'thn_tenant' => htmlentities($post['thn']), 
				'isi' => $this->input->post('ket'), 
				'jml'=> htmlentities($post['jml']),  
				'tgl_masuk' => date('Y-m-d H:i:s')
			);

			$this->load->library('upload');
			if(!empty($_FILES['gambar']['name']))
			{
				// setting konfigurasi upload
				$config['upload_path'] = './assets_style/image/tenant/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png'; 
				$config['encrypt_name'] = TRUE; //nama yang terupload nantinya
				// load library upload
				$this->load->library('upload',$config);
				$this->upload->initialize($config);

				if ($this->upload->do_upload('gambar')) {
					$this->upload->data();
					$file1 = array('upload_data' => $this->upload->data());
					$this->db->set('logo', $file1['upload_data']['file_name']);
				}else{
					$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
							<p> Edit tenant Gagal !</p>
						</div></div>');
					redirect(base_url('data')); 
				}
			}

			if(!empty($_FILES['lampiran']['name']))
			{
				// setting konfigurasi upload
				$config['upload_path'] = './assets_style/image/tenant/';
				$config['allowed_types'] = 'pdf'; 
				$config['encrypt_name'] = TRUE; //nama yang terupload nantinya
				// load library upload
				$this->load->library('upload',$config);
				$this->upload->initialize($config);
				// script upload file kedua
				if ($this->upload->do_upload('lampiran')) {
					$this->upload->data();
					$file2 = array('upload_data' => $this->upload->data());
					$this->db->set('lampiran', $file2['upload_data']['file_name']);
				}else{

					$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
							<p> Edit tenant Gagal !</p>
						</div></div>');
					redirect(base_url('data')); 
				}
			}

			$this->db->insert('tbl_tenant', $data);

			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Tambah tenant Sukses !</p>
			</div></div>');
			redirect(base_url('data')); 
		}

		// edit aksi form proses tenant
		if(!empty($this->input->post('edit')))
		{
			$post = $this->input->post();
			$data = array(
				'id_kategori'=>htmlentities($post['kategori']), 
				'id_lokasi' => htmlentities($post['lokasi']), 
				'no_telephone' => htmlentities($post['no_telephone']), 
				'title'  => htmlentities($post['title']),
				'penanggung_jawab'=> htmlentities($post['penanggung_jawab']), 
				'perusahaan'=> htmlentities($post['perusahaan']),  
				'thn_tenant' => htmlentities($post['thn']), 
				'isi' => $this->input->post('ket'), 
				'jml'=> htmlentities($post['jml']),  
				'tgl_masuk' => date('Y-m-d H:i:s')
			);

			if(!empty($_FILES['gambar']['name']))
			{
				// setting konfigurasi upload
				$config['upload_path'] = '../assets_style/image/tenant/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png'; 
				$config['encrypt_name'] = TRUE; //nama yang terupload nantinya
				// load library upload
				$this->load->library('upload',$config);
				$this->upload->initialize($config);

				if ($this->upload->do_upload('gambar')) {
					$this->upload->data();
					$gambar = './assets/image/tenant/'.htmlentities($post['gmbr']);
					if(file_exists($gambar)) {
						unlink($gambar);
					}
					$file1 = array('upload_data' => $this->upload->data());
					$this->db->set('logo', $file1['upload_data']['file_name']);
				}else{
					$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
							<p> Edit tenant Gagal !</p>
						</div></div>');
					redirect(base_url('data')); 
				}
			}

			if(!empty($_FILES['lampiran']['name']))
			{
				// setting konfigurasi upload
				$config['upload_path'] = './assets_style/image/tenant/';
				$config['allowed_types'] = 'pdf'; 
				$config['encrypt_name'] = TRUE; //nama yang terupload nantinya
				// load library upload
				$this->load->library('upload',$config);
				$this->upload->initialize($config);
				// script uplaod file kedua
				if ($this->upload->do_upload('lampiran')) {
					$this->upload->data();
					$lampiran = './assets_style/image/tenant/'.htmlentities($post['lamp']);
					if(file_exists($lampiran)) {
						unlink($lampiran);
					}
					$file2 = array('upload_data' => $this->upload->data());
					$this->db->set('lampiran', $file2['upload_data']['file_name']);
				}else{

					$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
							<p> Edit tenant Gagal !</p>
						</div></div>');
					redirect(base_url('data')); 
				}
			}

			$this->db->where('id_tenant',htmlentities($post['edit']));
			$this->db->update('tbl_tenant', $data);

			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
					<p> Edit tenant Sukses !</p>
				</div></div>');
			redirect(base_url('data/tenantedit/'.$post['edit'])); 
		}
	}

	public function kategori()
	{
		
        $this->data['idbo'] = $this->session->userdata('ses_id');
		$this->data['kategori'] =  $this->db->query("SELECT * FROM tbl_kategori ORDER BY id_kategori DESC");

		if(!empty($this->input->get('id'))){
			$id = $this->input->get('id');
			$count = $this->M_Admin->CountTableId('tbl_kategori','id_kategori',$id);
			if($count > 0)
			{			
				$this->data['kat'] = $this->db->query("SELECT *FROM tbl_kategori WHERE id_kategori='$id'")->row();
			}else{
				echo '<script>alert("KATEGORI TIDAK DITEMUKAN");window.location="'.base_url('data/kategori').'"</script>';
			}
		}

        $this->data['title_web'] = 'Data Kategori ';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('kategori/kat_view',$this->data);
        $this->load->view('footer_view',$this->data);
	}

	public function katproses()
	{
		if(!empty($this->input->post('tambah')))
		{
			$post= $this->input->post();
			$data = array(
				'nama_kategori'=>htmlentities($post['kategori']),
			);

			$this->db->insert('tbl_kategori', $data);

			
			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Tambah Kategori Sukses !</p>
			</div></div>');
			redirect(base_url('data/kategori'));  
		}

		if(!empty($this->input->post('edit')))
		{
			$post= $this->input->post();
			$data = array(
				'nama_kategori'=>htmlentities($post['kategori']),
			);
			$this->db->where('id_kategori',htmlentities($post['edit']));
			$this->db->update('tbl_kategori', $data);


			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Edit Kategori Sukses !</p>
			</div></div>');
			redirect(base_url('data/kategori')); 		
		}

		if(!empty($this->input->get('kat_id')))
		{
			$this->db->where('id_kategori',$this->input->get('kat_id'));
			$this->db->delete('tbl_kategori');

			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-warning">
			<p> Hapus Kategori Sukses !</p>
			</div></div>');
			redirect(base_url('data/kategori')); 
		}
	}

	public function lokasi()
	{
		
        $this->data['idbo'] = $this->session->userdata('ses_id');
		$this->data['lokasitenant'] =  $this->db->query("SELECT * FROM tbl_lokasi ORDER BY id_lokasi DESC");

		if(!empty($this->input->get('id'))){
			$id = $this->input->get('id');
			$count = $this->M_Admin->CountTableId('tbl_lokasi','id_lokasi',$id);
			if($count > 0)
			{	
				$this->data['lokasi'] = $this->db->query("SELECT *FROM tbl_lokasi WHERE id_lokasi='$id'")->row();
			}else{
				echo '<script>alert("KATEGORI TIDAK DITEMUKAN");window.location="'.base_url('data/lokasi').'"</script>';
			}
		}

        $this->data['title_web'] = 'Data lokasi tenant ';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('lokasi/lokasi_view',$this->data);
        $this->load->view('footer_view',$this->data);
	}

	public function lokasiproses()
	{
		if(!empty($this->input->post('tambah')))
		{
			$post= $this->input->post();
			$data = array(
				'nama_lokasi'=>htmlentities($post['lokasi']),
			);

			$this->db->insert('tbl_lokasi', $data);

			
			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Tambah lokasi tenant Sukses !</p>
			</div></div>');
			redirect(base_url('data/lokasi'));  
		}

		if(!empty($this->input->post('edit')))
		{
			$post= $this->input->post();
			$data = array(
				'nama_lokasi'=>htmlentities($post['lokasi']),
			);
			$this->db->where('id_lokasi',htmlentities($post['edit']));
			$this->db->update('tbl_lokasi', $data);


			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Edit lokasi Sukses !</p>
			</div></div>');
			redirect(base_url('data/lokasi')); 		
		}

		if(!empty($this->input->get('lokasi_id')))
		{
			$this->db->where('id_lokasi',$this->input->get('lokasi_id'));
			$this->db->delete('tbl_lokasi');

			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-warning">
			<p> Hapus lokasi tenant Sukses !</p>
			</div></div>');
			redirect(base_url('data/lokasi')); 
		}
	}
}
