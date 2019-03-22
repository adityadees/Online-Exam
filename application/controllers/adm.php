<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Adm extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->db->query("SET time_zone='+7:00'");
		$waktu_sql = $this->db->query("SELECT NOW() AS waktu")->row_array();
		$this->waktu_sql = $waktu_sql['waktu'];
		$this->opsi = array("a","b","c","d","e");
	}
	
	public function get_servertime() {
		$now = new DateTime(); 
		$dt = $now->format("M j, Y H:i:s O"); 

		j($dt);
	}

	public function cek_aktif() {
		if ($this->session->userdata('admin_valid') == false && $this->session->userdata('admin_id') == "") {
			redirect('adm/login');
		} 
	}
	
	public function index() {
		$this->cek_aktif();
		
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');
		
		$a['p']			= "v_main";
		
		$this->load->view('home', $a);
	}
	
	public function siswa() {
		$this->cek_aktif();
		cek_hakakses(array("admin"), $this->session->userdata('admin_level'));
		
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');


		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		
		$p = json_decode(file_get_contents('php://input'));
		$jeson = array();
		
		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM siswa WHERE id = '$uri4'")->row();
			j($a);
			exit();
		} else if ($uri3 == "simpan") {
			$ket 	= "";
			if ($p->id != 0) {
				$this->db->query("UPDATE siswa SET nama = '".bersih($p,"nama")."', nim = '".bersih($p,"nim")."', jurusan = '".bersih($p,"jurusan")."'	WHERE id = '".bersih($p,"id")."'");
				$ket = "edit";
			} else {
				$ket = "tambah";
				$this->db->query("INSERT INTO siswa VALUES (null, '".bersih($p,"nama")."', '".bersih($p,"nim")."', '".bersih($p,"jurusan")."')");
			}
			
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket." sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM siswa WHERE id = '".$uri4."'");
			$this->db->query("DELETE FROM user WHERE level = 'siswa' AND kon_id = '".$uri4."'");			
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "user") {
			$det_user = $this->db->query("SELECT id, nim FROM siswa WHERE id = '$uri4'")->row();

			if (!empty($det_user)) {
				$q_cek_username = $this->db->query("SELECT id FROM user WHERE username = '".$det_user->nim."' AND level = 'siswa'")->num_rows();

				if ($q_cek_username < 1) {

					$this->db->query("INSERT INTO user VALUES (null, '".$det_user->nim."', md5('".$det_user->nim."'), 'siswa', '".$det_user->id."')");
					$ret_arr['status'] 	= "ok";
					$ret_arr['caption']	= "tambah user sukses";
					j($ret_arr);
				} else {
					$ret_arr['status'] 	= "gagal";
					$ret_arr['caption']	= "Username telah digunakan";
					j($ret_arr);					
				}
			} else {
				$ret_arr['status'] 	= "gagal";
				$ret_arr['caption']	= "tambah user gagal";
				j($ret_arr);
			}
			exit();
		} else if ($uri3 == "user_reset") {
			$det_user = $this->db->query("SELECT id, nim FROM siswa WHERE id = '$uri4'")->row();

			$this->db->query("UPDATE user SET password = md5('".$det_user->nim."') WHERE level = 'siswa' AND kon_id = '".$det_user->id."'");

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "Update password sukses";
			j($ret_arr);

			exit();
		} else if ($uri3 == "ambil_matkul") {
			$matkul = $this->db->query("SELECT mata_pelajaran.*,
				(SELECT COUNT(id) FROM tr_siswa_mapel WHERE id_siswa = ".$uri4." AND id_mapel = mata_pelajaran.id) AS ok
				FROM mata_pelajaran
				")->result();
			$ret_arr['status'] = "ok";
			$ret_arr['data'] = $matkul;
			j($ret_arr);
			exit;
		} else if ($uri3 == "simpan_matkul") {
			$ket 	= "";
			$ambil_matkul = $this->db->query("SELECT id FROM mata_pelajaran ORDER BY id ASC")->result();
			if (!empty($ambil_matkul)) {
				foreach ($ambil_matkul as $a) {
					$p_sub = "id_mapel_".$a->id;
					if (!empty($p->$p_sub)) {
						
						$cek_sudah_ada = $this->db->query("SELECT id FROM tr_siswa_mapel WHERE  id_siswa = '".$p->id_mhs."' AND id_mapel = '".$a->id."'")->num_rows();
						
						if ($cek_sudah_ada < 1) {
							$this->db->query("INSERT INTO tr_siswa_mapel VALUES (null, '".$p->id_mhs."', '".$a->id."')");
						} else {
							$this->db->query("UPDATE tr_siswa_mapel SET id_mapel = '".$p->$p_sub."' WHERE id_siswa = '".$p->id_mhs."' AND id_mapel = '".$a->id."'");
						}
					} else {
						$this->db->query("DELETE FROM tr_siswa_mapel WHERE id_siswa = '".$p->id_mhs."' AND id_mapel = '".$a->id."'");
					}
				}
			}
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket." sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "data") {
			$start = $this->input->post('start');
			$length = $this->input->post('length');
			$draw = $this->input->post('draw');
			$search = $this->input->post('search');

			$d_total_row = $this->db->query("SELECT id FROM siswa a WHERE a.nama LIKE '%".$search['value']."%'")->num_rows();

			$q_datanya = $this->db->query("SELECT a.*,
				(SELECT COUNT(id) FROM user WHERE level = 'siswa' AND kon_id = a.id) AS ada
				FROM siswa a
				WHERE a.nama LIKE '%".$search['value']."%' ORDER BY a.id DESC LIMIT ".$start.", ".$length."")->result_array();
			$data = array();
			$no = ($start+1);

			foreach ($q_datanya as $d) {
				$data_ok = array();
				$data_ok[] = $no++;
				$data_ok[] = $d['nama'];
				$data_ok[] = $d['nim'];
				$data_ok[] = $d['jurusan'];



				$data_ok[] = '<div class="btn-group">
				<a href="#" onclick="return siswa_e('.$d['id'].');" class="btn btn-info btn-xs" title="Edit Siswa"><i class="fa fa-pencil" style="margin-left: 0px; color: #fff"></i></a>
				<a href="#" onclick="return siswa_h('.$d['id'].');" class="btn btn-danger btn-xs" title="Hapus Siswa"><i class="fa fa-trash" style="margin-left: 0px; color: #fff"></i></a>
				';

				if ($d['ada'] == "0") {
					$data_ok[4] .= '<a href="#" onclick="return siswa_u('.$d['id'].');" class="btn btn-success btn-xs"  title="Aktifkan Siswa"><i class="fa fa-check-circle-o" style="margin-left: 0px; color: #fff"></i></a>';
				} else {
					$data_ok[4] .= '<a href="#" onclick="return siswa_ur('.$d['id'].');" class="btn btn-warning btn-xs" title="Reset Password"><i class="fa fa-key" style="margin-left: 0px; color: #fff"></i></a>';
				}

				$data[] = $data_ok;
			}

			$json_data = array(
				"draw" => $draw,
				"iTotalRecords" => $d_total_row,
				"iTotalDisplayRecords" => $d_total_row,
				"data" => $data
			);
			j($json_data);
			exit;
		} else if ($uri3 == "import") {
			$a['p']	= "f_siswa_import";
		} else if ($uri3 == "aktifkan_semua") {
			$q_get_user = $this->db->query("select 
				a.id, a.nama, a.nim, ifnull(b.username,'N') usernya
				from siswa a 
				left join user b on concat(b.level,b.kon_id) = concat('siswa',a.id)")->result_array();
			$jml_aktif = 0;
			if (!empty($q_get_user)) {
				foreach ($q_get_user as $j) {
					if ($j['usernya'] == "N") {
						$this->db->query("INSERT INTO user VALUES (null, '".$j['nim']."', md5('".$j['nim']."'), 'siswa', '".$j['id']."')");
						$jml_aktif++;
					}
				}
			}

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $jml_aktif." user diaktifkan";
			j($ret_arr);
			exit();

		} else {
			$a['p']	= "siswa";
		}
		$this->load->view('home', $a);
	}
	public function guru() {
		$this->cek_aktif();
		cek_hakakses(array("admin"), $this->session->userdata('admin_level'));
		
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$p = json_decode(file_get_contents('php://input'));
		$jeson = array();

		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM guru WHERE id = '$uri4'")->row();
			j($a);
			exit();
		} else if ($uri3 == "simpan") {
			$ket 	= "";
			if ($p->id != 0) {
				$this->db->query("UPDATE guru SET nama = '".bersih($p,"nama")."', nip = '".bersih($p,"nip")."' WHERE id = '".bersih($p,"id")."'");
				$ket = "edit";
			} else {
				$ket = "tambah";
				$this->db->query("INSERT INTO guru VALUES (null, '".bersih($p,"nip")."', '".bersih($p,"nama")."')");
			}

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket." sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM guru WHERE id = '".$uri4."'");
			$this->db->query("DELETE FROM user WHERE level = 'guru' AND kon_id = '".$uri4."'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "user") {
			$det_user = $this->db->query("SELECT id, nip FROM guru WHERE id = '$uri4'")->row();

			if (!empty($det_user)) {
				$q_cek_username = $this->db->query("SELECT id FROM user WHERE username = '".$det_user->nip."' AND level = 'guru'")->num_rows();

				if ($q_cek_username < 1) {

					$this->db->query("INSERT INTO user VALUES (null, '".$det_user->nip."', md5('".$det_user->nip."'), 'guru', '".$det_user->id."')");
					$ret_arr['status'] 	= "ok";
					$ret_arr['caption']	= "tambah user sukses";
					j($ret_arr);
				} else {
					$ret_arr['status'] 	= "gagal";
					$ret_arr['caption']	= "Username telah digunakan";
					j($ret_arr);					
				}
			} else {
				$ret_arr['status'] 	= "gagal";
				$ret_arr['caption']	= "tambah user gagal";
				j($ret_arr);
			}
			exit();
		} else if ($uri3 == "user_reset") {
			$det_user = $this->db->query("SELECT id, nip FROM guru WHERE id = '$uri4'")->row();

			$this->db->query("UPDATE user SET password = md5('".$det_user->nip."') WHERE level = 'guru' AND kon_id = '".$det_user->id."'");

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "Update password sukses";
			j($ret_arr);

			exit();
		} else if ($uri3 == "ambil_matkul") {
			$matkul = $this->db->query("SELECT mata_pelajaran.*,
				(SELECT COUNT(id) FROM guru_mp WHERE id_guru = ".$uri4." AND id_mapel = mata_pelajaran.id) AS ok
				FROM mata_pelajaran
				")->result();
			$ret_arr['status'] = "ok";
			$ret_arr['data'] = $matkul;
			j($ret_arr);
			exit;
		} else if ($uri3 == "simpan_matkul") {
			$ket 	= "";
			$ambil_matkul = $this->db->query("SELECT id FROM mata_pelajaran ORDER BY id ASC")->result();
			if (!empty($ambil_matkul)) {
				foreach ($ambil_matkul as $a) {
					$p_sub = "id_mapel_".$a->id;
					if (!empty($p->$p_sub)) {

						$cek_sudah_ada = $this->db->query("SELECT id FROM guru_mp WHERE  id_guru = '".$p->id_mhs."' AND id_mapel = '".$a->id."'")->num_rows();

						if ($cek_sudah_ada < 1) {
							$this->db->query("INSERT INTO guru_mp VALUES (null, '".$p->id_mhs."', '".$a->id."')");
						} else {
							$this->db->query("UPDATE guru_mp SET id_mapel = '".$p->$p_sub."' WHERE id_guru = '".$p->id_mhs."' AND id_mapel = '".$a->id."'");
						}
					} else {
						$this->db->query("DELETE FROM guru_mp WHERE id_guru = '".$p->id_mhs."' AND id_mapel = '".$a->id."'");
					}
				}
			}
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket." sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "data") {
			$start = $this->input->post('start');
			$length = $this->input->post('length');
			$draw = $this->input->post('draw');
			$search = $this->input->post('search');

			$d_total_row = $this->db->query("SELECT id FROM guru a WHERE a.nama LIKE '%".$search['value']."%'")->num_rows();

			$q_datanya = $this->db->query("SELECT a.*,
				(SELECT COUNT(id) FROM user WHERE level = 'guru' AND kon_id = a.id) AS ada
				FROM guru a
				WHERE a.nama LIKE '%".$search['value']."%' ORDER BY a.id DESC LIMIT ".$start.", ".$length."")->result_array();
			$data = array();
			$no = ($start+1);

			foreach ($q_datanya as $d) {
				$data_ok = array();
				$data_ok[0] = $no++;
				$data_ok[1] = $d['nama'];
				$data_ok[2] = $d['nip'];
				$data_ok[3] = '<div class="btn-group">
				<a href="#" onclick="return guru_e('.$d['id'].');" class="btn btn-info btn-xs" title="Edit Guru"><i class="fa fa-pencil" style="margin-left: 0px; color: #fff"></i></a>
				<a href="#" onclick="return guru_h('.$d['id'].');" class="btn btn-danger btn-xs" title="Hapus Guru"><i class="fa fa-trash" style="margin-left: 0px; color: #fff"></i></a>
				<a href="#" onclick="return guru_matkul('.$d['id'].');" class="btn btn-primary btn-xs" title="Mata Kuliah"><i class="fa fa-book" style="margin-left: 0px; color: #fff"></i></a>
				';

				if ($d['ada'] == "0") {
					$data_ok[3] .= '<a href="#" onclick="return guru_u('.$d['id'].');" class="btn btn-success btn-xs" title="Aktifkan Guru"><i class="fa fa-check-circle-o" style="margin-left: 0px; color: #fff"></i></a>';
				} else {
					$data_ok[3] .= '<a href="#" onclick="return guru_ur('.$d['id'].');" class="btn btn-warning btn-xs" title="Reset Password"><i class="fa fa-key" style="margin-left: 0px; color: #fff"></i></a>';
				}


				$data[] = $data_ok;
			}

			$json_data = array(
				"draw" => $draw,
				"iTotalRecords" => $d_total_row,
				"iTotalDisplayRecords" => $d_total_row,
				"data" => $data
			);
			j($json_data);
			exit;
		} else if ($uri3 == "import") {
			$a['p']	= "f_guru_import";
		} else if ($uri3 == "aktifkan_semua") {
			$q_get_user = $this->db->query("select 
				a.id, a.nama, a.nip, ifnull(b.username,'N') usernya
				from guru a 
				left join user b on concat(b.level,b.kon_id) = concat('guru',a.id)")->result_array();
			$jml_aktif = 0;
			if (!empty($q_get_user)) {
				foreach ($q_get_user as $j) {
					if ($j['usernya'] == "N") {
						$this->db->query("INSERT INTO user VALUES (null, '".$j['nip']."', md5('".$j['nip']."'), 'guru', '".$j['id']."')");
						$jml_aktif++;
					}
				}
			}

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $jml_aktif." user diaktifkan";
			j($ret_arr);
			exit();

		} else {
			$a['p']	= "guru";
		}
		$this->load->view('home', $a);
	}
	public function mata_pelajaran() {
		$this->cek_aktif();
		cek_hakakses(array("admin"), $this->session->userdata('admin_level'));

		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$p = json_decode(file_get_contents('php://input'));
		$jeson = array();
		$a['data'] = $this->db->query("SELECT mata_pelajaran.* FROM mata_pelajaran")->result();
		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM mata_pelajaran WHERE id = '$uri4'")->row();
			j($a);
			exit();
		} else if ($uri3 == "simpan") {
			$ket 	= "";
			if ($p->id != 0) {
				$this->db->query("UPDATE mata_pelajaran SET nama = '".bersih($p,"nama")."'
					WHERE id = '".bersih($p,"id")."'");
				$ket = "edit";
			} else {
				$ket = "tambah";
				$this->db->query("INSERT INTO mata_pelajaran VALUES (null, '".bersih($p,"nama")."')");
			}

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket." sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM mata_pelajaran WHERE id = '".$uri4."'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "data") {
			$start = $this->input->post('start');
			$length = $this->input->post('length');
			$draw = $this->input->post('draw');
			$search = $this->input->post('search');

			$d_total_row = $this->db->query("SELECT id FROM mata_pelajaran a WHERE a.nama LIKE '%".$search['value']."%'")->num_rows();

			$q_datanya = $this->db->query("SELECT a.*
				FROM mata_pelajaran a
				WHERE a.nama LIKE '%".$search['value']."%' ORDER BY a.id DESC LIMIT ".$start.", ".$length."")->result_array();
			$data = array();
			$no = ($start+1);

			foreach ($q_datanya as $d) {
				$data_ok = array();
				$data_ok[0] = $no++;
				$data_ok[1] = $d['nama'];
				$data_ok[2] = '<div class="btn-group">
				<a href="#" onclick="return mata_pelajaran_e('.$d['id'].');" class="btn btn-info btn-xs"><i class="fa fa-pencil" style="margin-left: 0px; color: #fff"></i></a>
				<a href="#" onclick="return mata_pelajaran_h('.$d['id'].');" class="btn btn-danger btn-xs"><i class="fa fa-trash" style="margin-left: 0px; color: #fff"></i></a>
				';

				$data[] = $data_ok;
			}

			$json_data = array(
				"draw" => $draw,
				"iTotalRecords" => $d_total_row,
				"iTotalDisplayRecords" => $d_total_row,
				"data" => $data
			);
			j($json_data);
			exit;
		} else {
			$a['p']	= "mata_pelajaran";
		}
		$this->load->view('home', $a);
	}
	public function soal_ujian() {
		$this->cek_aktif();
		cek_hakakses(array("admin", "guru"), $this->session->userdata('admin_level'));
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		$a['huruf_opsi'] = array("a","b","c","d","e");
		$a['jml_opsi'] = $this->config->item('jml_opsi');

		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$uri5 = $this->uri->segment(5);
		$p = json_decode(file_get_contents('php://input'));
		$jeson = array();

		if ($a['sess_level'] == "guru") {
			$a['p_guru'] = obj_to_array($this->db->query("SELECT * FROM guru WHERE id = '".$a['sess_konid']."'")->result(), "id,nama");
			$a['p_mapel'] = obj_to_array($this->db->query("SELECT 
				b.id, b.nama
				FROM guru_mp a
				INNER JOIN mata_pelajaran b ON a.id_mapel = b.id
				WHERE a.id_guru = '".$a['sess_konid']."'")->result(), "id,nama");
		} else {
			$a['p_guru'] = obj_to_array($this->db->query("SELECT * FROM guru")->result(), "id,nama");
			$a['p_mapel'] = obj_to_array($this->db->query("SELECT 
				b.id, b.nama
				FROM guru_mp a
				INNER JOIN mata_pelajaran b ON a.id_mapel = b.id")->result(), "id,nama");
		}

		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM soal_ujian WHERE id = '$uri4' ORDER BY id DESC")->row();
			j($a);
			exit();
		} else if ($uri3 == "import") {
			$a['p']	= "f_soal_import";
		} else if ($uri3 == "hapus_gambar") {
			$nama_gambar = $this->db->query("SELECT file FROM soal_ujian WHERE id = '".$uri5."'")->row();
			$this->db->query("UPDATE soal_ujian SET file = '', tipe_file = '' WHERE id = '".$uri5."'");
			@unlink("./upload/gambar_soal/".$nama_gambar->file);
			redirect('adm/soal_ujian/pilih_mapel/'.$uri4);
		} else if ($uri3 == "pilih_mapel") {
			if ($a['sess_level'] == "guru") {
				$a['data'] = $this->db->query("SELECT soal_ujian.*, guru.nama AS nama_guru FROM soal_ujian INNER JOIN guru ON soal_ujian.id_guru = guru.id WHERE soal_ujian.id_guru = '".$a['sess_konid']."' AND soal_ujian.id_mapel = '$uri4' ORDER BY id DESC")->result();
			} else {
				$a['data'] = $this->db->query("SELECT soal_ujian.*, guru.nama AS nama_guru FROM soal_ujian INNER JOIN guru ON soal_ujian.id_guru = guru.id WHERE soal_ujian.id_mapel = '$uri4' ORDER BY id DESC")->result();
			}
			$a['p']	= "soal_ujian";
		} else if ($uri3 == "simpan") {
			$p = $this->input->post();
			$pembuat_soal = ($a['sess_level'] == "admin") ? $p['id_guru'] : $a['sess_konid'];
			$pembuat_soal_u = ($a['sess_level'] == "admin") ? ", id_guru = '".$p['id_guru']."'" : "";
			$folder_gb_soal = "./upload/gambar_soal/";
			$folder_gb_opsi = "./upload/gambar_opsi/";

			$buat_folder_gb_soal = !is_dir($folder_gb_soal) ? @mkdir("./upload/gambar_soal/") : false;
			$buat_folder_gb_opsi = !is_dir($folder_gb_opsi) ? @mkdir("./upload/gambar_opsi/") : false;

			$allowed_type 	= array("image/jpeg", "image/png", "image/gif", 
				"audio/mpeg", "audio/mpg", "audio/mpeg3", "audio/mp3", "audio/x-wav", "audio/wave", "audio/wav",
				"video/mp4", "application/octet-stream");

			$gagal 		= array();
			$nama_file 	= array();
			$tipe_file 	= array();

			$__mode = $p['mode'];
			$__id_soal = 0;
			$pdata = array(
				"id_guru"=>$p['id_guru'],
				"id_mapel"=>$p['id_mapel'],
				"bobot"=>$p['bobot'],
				"soal"=>$p['soal'],
				"jawaban"=>$p['jawaban'],
			);

			if ($__mode == "edit") {
				$this->db->where("id", $p['id']);
				$this->db->update("soal_ujian", $pdata);
				$__id_soal = $p['id'];
			} else {
				$this->db->insert("soal_ujian", $pdata);
				$get_id_akhir = $this->db->query("SELECT MAX(id) maks FROM soal_ujian LIMIT 1")->row_array();
				$__id_soal = $get_id_akhir['maks'];
			}


			foreach ($_FILES as $k => $v) {
				$file_name 		= $_FILES[$k]['name'];
				$file_type		= $_FILES[$k]['type'];
				$file_tmp		= $_FILES[$k]['tmp_name'];
				$file_error		= $_FILES[$k]['error'];
				$file_size		= $_FILES[$k]['size'];
				$kode_file_error = array("File berhasil diupload", "Ukuran file terlalu besar", "Ukuran file terlalu besar", "File upload error", "Tidak ada file yang diupload", "File upload error");

				//echo $file_error."<br>".$file_type;
				//exit;
				//echo var_dump($file_error == 0 || in_array($file_type, $allowed_type) || $file_name != "");
				//exit;
				if ($file_error != 0) {
					$gagal[$k] = $kode_file_error[$file_error];
					$nama_file[$k]	= "";
					$tipe_file[$k]	= "";
				} else if (!in_array($file_type, $allowed_type)) {
					$gagal[$k] = "Tipe file ini tidak diperbolehkan..";
					$nama_file[$k]	= "";
					$tipe_file[$k]	= "";
				} else if ($file_name == "") {
					$gagal[$k] = "Tidak ada file yang diupload";
					$nama_file[$k]	= "";
					$tipe_file[$k]	= "";					
				} else {
					$ekstensi = explode(".", $file_name);

					$file_name = $k."_".$__id_soal.".".$ekstensi[1];

					if ($k == "gambar_soal") {
						@move_uploaded_file($file_tmp, $folder_gb_soal.$file_name);
					} else {
						@move_uploaded_file($file_tmp, $folder_gb_opsi.$file_name);
					}

					$gagal[$k]	 	= $kode_file_error[$file_error]; 
					$nama_file[$k]	= $file_name; 
					$tipe_file[$k]	= $file_type; 
				}
			}


			$get_opsi_awal = $this->db->query("SELECT opsi_a, opsi_b, opsi_c, opsi_d, opsi_e FROM soal_ujian WHERE id = '".$__id_soal."'")->row_array();

			$data_simpan = array();

			if (!empty($nama_file['gambar_soal'])) {
				$data_simpan = array(
					"file"=>$nama_file['gambar_soal'],
					"tipe_file"=>$tipe_file['gambar_soal'],
				);
			}

			for ($t = 0; $t < $a['jml_opsi']; $t++) {
				$idx 	= "opsi_".$a['huruf_opsi'][$t];
				$idx2 	= "gj".$a['huruf_opsi'][$t];


				$pc_opsi_awal = explode("#####", $get_opsi_awal[$idx]);
				$nama_file_opsi = empty($nama_file[$idx2]) ? $pc_opsi_awal[0] : $nama_file[$idx2];

				$data_simpan[$idx] = $nama_file_opsi."#####".$p[$idx];
			}

			$this->db->where("id", $__id_soal);
			$this->db->update("soal_ujian", $data_simpan);

			$teks_gagal = "";
			foreach ($gagal as $k => $v) {
				$arr_nama_file_upload = array("gambar_soal"=>"File Soal ", "gja"=>"File opsi A ", "gjb"=>"File opsi B ", "gjc"=>"File opsi C ", "gjd"=>"File opsi D ", "gje"=>"File opsi E ");
				$teks_gagal .= $arr_nama_file_upload[$k].': '.$v.'<br>';
			}
			$this->session->set_flashdata('k', '<div class="alert alert-info">'.$teks_gagal.'</div>');
			
			redirect('adm/soal_ujian/pilih_mapel/'.$p['id_mapel']);
		} else if ($uri3 == "edit") {
			$a['opsij'] = array(""=>"Jawaban","A"=>"A","B"=>"B","C"=>"C","D"=>"D","E"=>"E");
			
			$id_guru = $this->session->userdata('admin_level') == "guru" ? "WHERE a.id_guru = '".$a['sess_konid']."'" : "";

			$a['p_mapel'] = obj_to_array($this->db->query("SELECT b.id, b.nama FROM guru_mp a INNER JOIN mata_pelajaran b ON a.id_mapel = b.id $id_guru")->result(),"id,nama");

			if ($uri4 == 0) {
				$a['d'] = array("mode"=>"add","id"=>"0","id_guru"=>$id_guru,"id_mapel"=>"","bobot"=>"1","file"=>"","soal"=>"","opsi_a"=>"#####","opsi_b"=>"#####","opsi_c"=>"#####","opsi_d"=>"#####","opsi_e"=>"#####","jawaban"=>"","tgl_input"=>"");
			} else {
				$a['d'] = $this->db->query("SELECT soal_ujian.*, 'edit' AS mode FROM soal_ujian WHERE id = '$uri4'")->row_array();

			}

			$data = array();

			for ($e = 0; $e < $a['jml_opsi']; $e++) {
				$iidata = array();
				$idx = "opsi_".$a['huruf_opsi'][$e];
				$idx2 = $a['huruf_opsi'][$e];

				$pc_opsi_edit = explode("#####", $a['d'][$idx]);
				$iidata['opsi'] = $pc_opsi_edit[1];
				$iidata['gambar'] = $pc_opsi_edit[0];
				$data[$idx2] = $iidata;
			}


			$a['data_pc'] = $data;
			$a['p'] = "f_soal";

		} else if ($uri3 == "hapus") {
			$nama_gambar = $this->db->query("SELECT id_mapel, file, opsi_a, opsi_b, opsi_c, opsi_d, opsi_e FROM soal_ujian WHERE id = '".$uri4."'")->row();
			$pc_opsi_a = explode("#####", $nama_gambar->opsi_a);
			$pc_opsi_b = explode("#####", $nama_gambar->opsi_b);
			$pc_opsi_c = explode("#####", $nama_gambar->opsi_c);
			$pc_opsi_d = explode("#####", $nama_gambar->opsi_d);
			$pc_opsi_e = explode("#####", $nama_gambar->opsi_e);
			$this->db->query("DELETE FROM soal_ujian WHERE id = '".$uri4."'");
			@unlink("./upload/gambar_soal/".$nama_gambar->file);
			@unlink("./upload/gambar_soal/".$pc_opsi_a[0]);
			@unlink("./upload/gambar_soal/".$pc_opsi_b[0]);
			@unlink("./upload/gambar_soal/".$pc_opsi_c[0]);
			@unlink("./upload/gambar_soal/".$pc_opsi_d[0]);
			@unlink("./upload/gambar_soal/".$pc_opsi_e[0]);
			
			redirect('adm/soal_ujian/pilih_mapel/'.$nama_gambar->id_mapel);
		} else if ($uri3 == "cetak") {
			$html = "<link href='".base_url()."assets/resources/css/style_print.css' rel='stylesheet' media='' type='text/css'/>";
			if ($a['sess_level'] == "admin") {
				$data = $this->db->query("SELECT * FROM soal_ujian")->result();
			} else {
				$data = $this->db->query("SELECT * FROM soal_ujian WHERE id_guru = '".$a['sess_konid']."'")->result();
			}

			$mapel = $this->db->query("SELECT nama FROM mata_pelajaran WHERE id = '".$uri4."'")->row();
			if (!empty($data)) {
				
				$no = 1;
				$jawaban = array("A","B","C","D","E");
				foreach ($data as $d) {
					
					$arr_tipe_media = array(""=>"none","image/jpeg"=>"gambar","image/png"=>"gambar","image/gif"=>"gambar",
						"audio/mpeg"=>"audio","audio/mpg"=>"audio","audio/mpeg3"=>"audio","audio/mp3"=>"audio","audio/x-wav"=>"audio","audio/wave"=>"audio","audio/wav"=>"audio",
						"video/mp4"=>"video", "application/octet-stream"=>"video");
					$tipe_media = $arr_tipe_media[$d->tipe_file];
					$file_ada = file_exists("./upload/gambar_soal/".$d->file) ? "ada" : "tidak_ada";
					$tampil_media = "";
					if ($file_ada == "ada" && $tipe_media == "audio") {
						$tampil_media = '<<< Ada media Audionya >>>';
					} else if ($file_ada == "ada" && $tipe_media == "video") {
						$tampil_media = '<<< Ada media Videonya >>>';
					} else if ($file_ada == "ada" && $tipe_media == "gambar") {
						$tampil_media = '<p><img src="'.base_url().'upload/gambar_soal/'.$d->file.'" class="thumbnail" style="width: 300px; height: 280px; display: inline; float: left"></p>';
					} else {
						$tampil_media = '';
					}
					$html .= '<table>
					<tr><td>'.$no.'.</td><td colspan="2">'.$d->soal.'<br>'.$tampil_media.'</td></tr>';
					for ($j=0; $j<($this->config->item('jml_opsi'));$j++) {
						$opsi = "opsi_".strtolower($jawaban[$j]);
						$pc_pilihan_opsi = explode("#####", $d->$opsi);
						$tampil_media_opsi = (file_exists('./upload/gambar_soal/'.$pc_pilihan_opsi[0]) AND $pc_pilihan_opsi[0] != "") ? '<img src="'.base_url().'upload/gambar_soal/'.$pc_pilihan_opsi[0].'" style="width: 100px; height: 100px; margin-right: 20px">' : '';
						if ($jawaban[$j] == $d->jawaban) {
							$html .= '<tr><td width="2%" style="font-weight: bold">'.$jawaban[$j].'</td><td style="font-weight: bold">'.$tampil_media_opsi.$pc_pilihan_opsi[1].'</td></label></tr>';
						} else {
							$html .= '<tr><td width="2%">'.$jawaban[$j].'</td><td>'.$tampil_media_opsi.$pc_pilihan_opsi[1].'</td></label></tr>';
						}
					}
					$html .= '</table></div>';
					$no++;
				}
			}

			echo $html;
			exit;
		} else if ($uri3 == "data") {
			$start = $this->input->post('start');
			$length = $this->input->post('length');
			$draw = $this->input->post('draw');
			$search = $this->input->post('search');

			$wh = '';

			if ($a['sess_level'] == "guru") {
				$wh = "a.id_guru = '".$a['sess_konid']."' AND ";
			} else if ($a['sess_level'] == "admin") {
				$wh = "";
			}


			$d_total_row = $this->db->query("SELECT a.*
				FROM soal_ujian a
				INNER JOIN guru b ON a.id_guru = b.id
				INNER JOIN mata_pelajaran c ON a.id_mapel = c.id
				WHERE ".$wh." (a.soal LIKE '%".$search['value']."%' 
				OR b.nama LIKE '%".$search['value']."%' 
				OR c.nama LIKE '%".$search['value']."%')")->num_rows();

			$q_datanya = $this->db->query("SELECT a.*, b.nama nmguru, c.nama nmmapel
				FROM soal_ujian a
				INNER JOIN guru b ON a.id_guru = b.id
				INNER JOIN mata_pelajaran c ON a.id_mapel = c.id
				WHERE ".$wh." (a.soal LIKE '%".$search['value']."%' 
				OR b.nama LIKE '%".$search['value']."%' 
				OR c.nama LIKE '%".$search['value']."%')
				ORDER BY a.id DESC LIMIT ".$start.", ".$length."")->result_array();

			$data = array();
			$no = ($start+1);

			foreach ($q_datanya as $d) {
				$jml_benar = empty($d['jml_benar']) ? 0 : intval($d['jml_benar']);
				$jml_salah = empty($d['jml_salah']) ? 0 : intval($d['jml_salah']);
				$total = ($jml_benar + $jml_salah);
				$persen_benar = $total > 0 ? (($jml_benar / $total) * 100) : 0; 

				$data_ok = array();
				$data_ok[0] = $no++;
				$data_ok[1] = substr($d['soal'], 0, 300);
				$data_ok[2] = $d['nmmapel'].'<br>'.$d['nmguru'];
				$data_ok[3] = "Jml dipakai : ".($total)."<br>Benar: ".$jml_salah.", Salah: ".$jml_salah."<br>Persentase benar : ".number_format($persen_benar)." %";
				$data_ok[4] = '<div class="btn-group">
				<a href="'.base_url().'adm/soal_ujian/edit/'.$d['id'].'" class="btn btn-info btn-xs"><i class="fa fa-edit" title="Edit" style="margin-left: 0px; color: #fff"></i></a>
				<a href="'.base_url().'adm/soal_ujian/hapus/'.$d['id'].'" class="btn btn-danger btn-xs"><i class="fa fa-trash" title="Hapus" style="margin-left: 0px; color: #fff"></i></a>
				';

				$data[] = $data_ok;
			}

			$json_data = array(
				"draw" => $draw,
				"iTotalRecords" => $d_total_row,
				"iTotalDisplayRecords" => $d_total_row,
				"data" => $data
			);
			j($json_data);
			exit;
		} else {
			$a['p']	= "soal_ujian";
		}
		$this->load->view('home', $a);
	}
	public function m_ujian() {
		$this->cek_aktif();
		cek_hakakses(array("guru","admin"), $this->session->userdata('admin_level'));

		
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$p = json_decode(file_get_contents('php://input'));
		$jeson = array();
		
		$a['pola_tes'] = array(""=>"Pengacakan Soal", "acak"=>"Soal Diacak", "set"=>"Soal Diurutkan");

		$a['p_mapel'] = obj_to_array($this->db->query("SELECT * FROM mata_pelajaran WHERE id IN (SELECT id_mapel FROM guru_mp WHERE id_guru = '".$a['sess_konid']."')")->result(), "id,nama");
		
		if ($uri3 == "det") {
			$are = array();

			$a = $this->db->query("SELECT * FROM guru_ujian WHERE id = '$uri4'")->row();
			
			if (!empty($a)) {
				$pc_waktu = explode(" ", $a->tgl_mulai);
				$pc_tgl = explode("-", $pc_waktu[0]);

				$pc_terlambat = explode(" ", $a->terlambat);

				$are['id'] = $a->id;
				$are['id_guru'] = $a->id_guru;
				$are['id_mapel'] = $a->id_mapel;
				$are['nama_ujian'] = $a->nama_ujian;
				$are['jumlah_soal'] = $a->jumlah_soal;
				$are['waktu'] = $a->waktu;
				$are['terlambat'] = $pc_terlambat[0];
				$are['terlambat2'] = substr($pc_terlambat[1],0,5);
				$are['jenis'] = $a->jenis;
				$are['detil_jenis'] = $a->detil_jenis;
				$are['tgl_mulai'] = $pc_waktu[0];
				$are['wkt_mulai'] = substr($pc_waktu[1],0,5);
				$are['token'] = $a->token;
			} else {
				$are['id'] = "";
				$are['id_guru'] = "";
				$are['id_mapel'] = "";
				$are['nama_ujian'] = "";
				$are['jumlah_soal'] = "";
				$are['waktu'] = "";
				$are['terlambat'] = "";
				$are['terlambat2'] = "";
				$are['jenis'] = "";
				$are['detil_jenis'] = "";
				$are['tgl_mulai'] = "";
				$are['wkt_mulai'] = "";
				$are['token'] = "";
			}

			j($are);
			exit();
		} else if ($uri3 == "simpan") {
			$ket 	= "";

			$ambil_data = $this->db->query("SELECT id FROM soal_ujian WHERE id_mapel = '".bersih($p, "mapel")."' AND id_guru = '".$a['sess_konid']."'")->num_rows();


			$jml_soal_diminta = intval(bersih($p, "jumlah_soal"));
			
			if ($ambil_data < $jml_soal_diminta) {
				$ret_arr['status'] 	= "gagal";
				$ret_arr['caption']	= "Jumlah soal diinput, melebihi jumlah soal yang ada: ".$ambil_data;
			} else {
				if ($p->id != 0) {
					$this->db->query("UPDATE guru_ujian SET 
						id_mapel = '".bersih($p,"mapel")."', 
						nama_ujian = '".bersih($p,"nama_ujian")."', 
						jumlah_soal = '".bersih($p,"jumlah_soal")."', 
						waktu = '".bersih($p,"waktu")."', 
						terlambat = '".bersih($p,"terlambat")." ".bersih($p,"terlambat2")."', 
						tgl_mulai = '".bersih($p,"tgl_mulai")." ".bersih($p,"wkt_mulai")."', 
						jenis = '".bersih($p,"acak")."'
						WHERE id = '".bersih($p,"id")."'");
					$ket = "edit";
				} else {
					$ket = "tambah";
					$token = strtoupper(random_string('alpha', 5));

					$this->db->query("INSERT INTO guru_ujian VALUES (
						null, 
						'".$a['sess_konid']."', 
						'".bersih($p,"mapel")."',
						'".bersih($p,"nama_ujian")."', 
						'".bersih($p,"jumlah_soal")."', 
						'".bersih($p,"waktu")."', 
						'".bersih($p,"acak")."', 
						'', 
						'".bersih($p,"tgl_mulai")." ".bersih($p,"wkt_mulai")."', 
						'".bersih($p,"terlambat")." ".bersih($p,"terlambat2")."', 
						'$token')");
				}


				$ret_arr['status'] 	= "ok";
				$ret_arr['caption']	= $ket." sukses";
			}
			j($ret_arr);
			exit();
		} else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM guru_ujian WHERE id = '".$uri4."'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "data") {
			$start = $this->input->post('start');
			$length = $this->input->post('length');
			$draw = $this->input->post('draw');
			$search = $this->input->post('search');

			$d_total_row = $this->db->query("SELECT a.id
				FROM guru_ujian a
				INNER JOIN mata_pelajaran b ON a.id_mapel = b.id 
				WHERE a.id_guru = '".$a['sess_konid']."' 
				AND (a.nama_ujian LIKE '%".$search['value']."%' 
				OR b.nama LIKE '%".$search['value']."%')")->num_rows();

			$q_datanya = $this->db->query("SELECT a.*, b.nama AS mapel
				FROM guru_ujian a
				INNER JOIN mata_pelajaran b ON a.id_mapel = b.id 
				WHERE a.id_guru = '".$a['sess_konid']."'
				AND (a.nama_ujian LIKE '%".$search['value']."%'
				OR b.nama LIKE '%".$search['value']."%') 
				ORDER BY a.id DESC LIMIT ".$start.", ".$length."")->result_array();
			$data = array();
			$no = ($start+1);

			foreach ($q_datanya as $d) {
				$jenis_soal = $d['jenis'] == "acak" ? "Soal diacak" : "Soal urut";

				$data_ok = array();
				$data_ok[0] = $no++;
				$data_ok[1] = $d['nama_ujian']."<br>Token : <b>".$d['token']."</b> &nbsp;&nbsp; <a href='#' onclick='return refresh_token(".$d['id'].")' title='Perbarui Token'><i class='fa fa-refresh'></i></a>";
				$data_ok[2] = $d['mapel'];
				$data_ok[3] = $d['jumlah_soal'];
				$data_ok[4] = tjs($d['tgl_mulai'],"s")."<br>(".$d['waktu']." menit)";
				$data_ok[5] = $jenis_soal;
				$data_ok[6] = '
				<div class="btn-group">
				<a href="#" onclick="return m_ujian_e('.$d['id'].');" class="btn btn-info btn-xs"><i class="fa fa-edit" title="Edit" style="margin-left: 0px; color: #fff"></i></a>
				<a href="#" onclick="return m_ujian_h('.$d['id'].');" class="btn btn-danger btn-xs"><i class="fa fa-trash" title="Hapus" style="margin-left: 0px; color: #fff"></i></a>
				</div>
				';

				$data[] = $data_ok;
			}

			$json_data = array(
				"draw" => $draw,
				"iTotalRecords" => $d_total_row,
				"iTotalDisplayRecords" => $d_total_row,
				"data" => $data
			);
			j($json_data);
			exit;
		} else if ($uri3 == "refresh_token") {
			$token = strtoupper(random_string('alpha', 5));

			$this->db->query("UPDATE guru_ujian SET token = '$token' WHERE id = '$uri4'");

			$ret_arr['status'] = "ok";
			j($ret_arr);
			exit();
		} else {
			$a['p']	= "guru_tes";
		}
		$this->load->view('home', $a);
	}
	public function h_ujian() {
		$this->cek_aktif();
		cek_hakakses(array("guru","admin"), $this->session->userdata('admin_level'));
		
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$uri5 = $this->uri->segment(5);
		$p = json_decode(file_get_contents('php://input'));
		$jeson = array();

		$wh_1 = $a['sess_level'] == "admin" ? "" : " AND a.id_guru = '".$a['sess_konid']."'";

		$a['p_mapel'] = obj_to_array($this->db->query("SELECT * FROM mata_pelajaran")->result(), "id,nama");
		
		if ($uri3 == "det") {
			$a['detil_tes'] = $this->db->query("SELECT mata_pelajaran.nama AS namaMapel, guru.nama AS nama_guru, 
				guru_ujian.* 
				FROM guru_ujian 
				INNER JOIN mata_pelajaran ON guru_ujian.id_mapel = mata_pelajaran.id
				INNER JOIN guru ON guru_ujian.id_guru = guru.id
				WHERE guru_ujian.id = '$uri4'")->row();
			$a['statistik'] = $this->db->query("SELECT MAX(nilai) AS max_, MIN(nilai) AS min_, AVG(nilai) AS avg_ 
				FROM hasil_ujian
				WHERE hasil_ujian.id_tes = '$uri4'")->row();

			$a['p'] = "guru_tes_hasil_detil";
		} else if ($uri3 == "data_det") {
			$start = $this->input->post('start');
			$length = $this->input->post('length');
			$draw = $this->input->post('draw');
			$search = $this->input->post('search');

			$d_total_row = $this->db->query("
				SELECT a.id
				FROM hasil_ujian a
				INNER JOIN siswa b ON a.id_user = b.id
				WHERE a.id_tes = '$uri4' 
				AND b.nama LIKE '%".$search['value']."%'")->num_rows();

			$q_datanya = $this->db->query("
				SELECT a.id, b.nama, a.nilai, a.jml_benar, a.nilai_bobot
				FROM hasil_ujian a
				INNER JOIN siswa b ON a.id_user = b.id
				WHERE a.id_tes = '$uri4' 
				AND b.nama LIKE '%".$search['value']."%' ORDER BY a.id DESC LIMIT ".$start.", ".$length."")->result_array();

			$data = array();
			$no = ($start+1);


			foreach ($q_datanya as $d) {
				$data_ok = array();
				$data_ok[0] = $no++;
				$data_ok[1] = $d['nama'];
				$data_ok[2] = $d['jml_benar'];
				$data_ok[3] = $d['nilai'];
				$data_ok[4] = $d['nilai_bobot'];
				$data_ok[5] = '<a href="'.base_url().'adm/h_ujian/batalkan_ujian/'.$d['id'].'/'.$this->uri->segment(4).'" class="btn btn-danger btn-xs" onclick="return confirm(\'Anda yakin...?\');"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Batalkan Ujian</a>';

				$data[] = $data_ok;
			}

			$json_data = array(
				"draw" => $draw,
				"iTotalRecords" => $d_total_row,
				"iTotalDisplayRecords" => $d_total_row,
				"data" => $data
			);
			j($json_data);
			exit;
		} else if ($uri3 == "batalkan_ujian") {
			$this->db->query("DELETE FROM hasil_ujian WHERE id = '$uri4'");
			redirect('adm/h_ujian/det/'.$uri5);
		} else if ($uri3 == "data") {
			$start = $this->input->post('start');
			$length = $this->input->post('length');
			$draw = $this->input->post('draw');
			$search = $this->input->post('search');

			$d_total_row = $this->db->query("SELECT a.id FROM guru_ujian a
				INNER JOIN mata_pelajaran b ON a.id_mapel = b.id 
				INNER JOIN guru c ON a.id_guru = c.id
				WHERE (a.nama_ujian LIKE '%".$search['value']."%' OR b.nama LIKE '%".$search['value']."%' OR c.nama LIKE '%".$search['value']."%') ".$wh_1."")->num_rows();

			$q_datanya = $this->db->query("SELECT a.*, b.nama AS mapel, c.nama AS nama_guru FROM guru_ujian a
				INNER JOIN mata_pelajaran b ON a.id_mapel = b.id 
				INNER JOIN guru c ON a.id_guru = c.id
				WHERE (a.nama_ujian LIKE '%".$search['value']."%' OR b.nama LIKE '%".$search['value']."%' OR c.nama LIKE '%".$search['value']."%') ".$wh_1." ORDER BY a.id DESC LIMIT ".$start.", ".$length."")->result_array();

			$data = array();
			$no = ($start+1);


			foreach ($q_datanya as $d) {
				$data_ok = array();
				$data_ok[0] = $no++;
				$data_ok[1] = $d['nama_ujian'];
				$data_ok[2] = $d['nama_guru'];
				$data_ok[3] = $d['mapel'];
				$data_ok[4] = $d['jumlah_soal'];
				$data_ok[5] = $d['waktu']." menit";
				$data_ok[6] = '<a href="'.base_url().'adm/h_ujian/det/'.$d['id'].'" class="btn btn-info btn-xs" title="Lihat Hasil"><i class="fa fa-search" style="margin-left: 0px; color: #fff"></i></a>
				';

				$data[] = $data_ok;
			}

			$json_data = array(
				"draw" => $draw,
				"iTotalRecords" => $d_total_row,
				"iTotalDisplayRecords" => $d_total_row,
				"data" => $data
			);
			j($json_data);
			exit;
		} else {
			$a['p']	= "guru_tes_hasil";
		}


		$this->load->view('home', $a);
	}
	public function hasil_ujian_cetak() {
		$this->cek_aktif();
		
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$a['detil_tes'] = $this->db->query("SELECT mata_pelajaran.nama AS namaMapel, guru.nama AS nama_guru, 
			guru_ujian.* 
			FROM guru_ujian 
			INNER JOIN mata_pelajaran ON guru_ujian.id_mapel = mata_pelajaran.id
			INNER JOIN guru ON guru_ujian.id_guru = guru.id
			WHERE guru_ujian.id = '$uri3'")->row();
		
		$a['statistik'] = $this->db->query("SELECT MAX(nilai) AS max_, MIN(nilai) AS min_, AVG(nilai) AS avg_ 
			FROM hasil_ujian
			WHERE hasil_ujian.id_tes = '$uri3'")->row();
		$a['hasil'] = $this->db->query("SELECT siswa.nama, hasil_ujian.nilai, hasil_ujian.jml_benar, hasil_ujian.nilai_bobot
			FROM hasil_ujian
			INNER JOIN siswa ON hasil_ujian.id_user = siswa.id
			WHERE hasil_ujian.id_tes = '$uri3'")->result();
		$this->load->view("guru_tes_hasil_detil_cetak", $a);
	}
	public function ikuti_ujian() {
		$this->cek_aktif();
		cek_hakakses(array("siswa"), $this->session->userdata('admin_level'));
		
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$p = json_decode(file_get_contents('php://input'));
		$jeson = array();
		$a['data'] = $this->db->query("SELECT 
			a.id, a.nama_ujian, a.jumlah_soal, a.waktu,
			b.nama nmmapel,
			c.nama nmguru,
			IF((d.status='Y' AND NOW() BETWEEN d.tgl_mulai AND d.tgl_selesai),'Sedang Tes',
			IF(d.status='Y' AND NOW() NOT BETWEEN d.tgl_mulai AND d.tgl_selesai,'Waktu Habis',
			IF(d.status='N','Selesai','Belum Ikut'))) status 
			FROM guru_ujian a
			INNER JOIN mata_pelajaran b ON a.id_mapel = b.id
			INNER JOIN guru c ON a.id_guru = c.id
			LEFT JOIN hasil_ujian d ON CONCAT('".$a['sess_konid']."',a.id) = CONCAT(d.id_user,d.id_tes)
			ORDER BY a.id ASC")->result();
		$a['p']	= "m_list_ujian_siswa";
		$this->load->view('home', $a);
	}
	public function ikut_ujian() {
		$this->cek_aktif();
		cek_hakakses(array("siswa"), $this->session->userdata('admin_level'));
		
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$p = json_decode(file_get_contents('php://input'));
		$a['detil_user'] = $this->db->query("SELECT * FROM siswa WHERE id = '".$a['sess_konid']."'")->row();
		if ($uri3 == "simpan_satu") {
			$p			= json_decode(file_get_contents('php://input'));
			
			$update_ 	= "";
			for ($i = 1; $i < $p->jml_soal; $i++) {
				$_tjawab 	= "opsi_".$i;
				$_tidsoal 	= "id_soal_".$i;
				$_ragu 		= "rg_".$i;
				$jawaban_ 	= empty($p->$_tjawab) ? "" : $p->$_tjawab;
				$update_	.= "".$p->$_tidsoal.":".$jawaban_.":".$p->$_ragu.",";
			}
			$update_		= substr($update_, 0, -1);
			$this->db->query("UPDATE hasil_ujian SET list_jawaban = '".$update_."' WHERE id_tes = '$uri4' AND id_user = '".$a['sess_konid']."'");

			$q_ret_urn 	= $this->db->query("SELECT list_jawaban FROM hasil_ujian WHERE id_tes = '$uri4' AND id_user = '".$a['sess_konid']."'");
			
			$d_ret_urn 	= $q_ret_urn->row_array();
			$ret_urn 	= explode(",", $d_ret_urn['list_jawaban']);
			$hasil 		= array();
			foreach ($ret_urn as $key => $value) {
				$pc_ret_urn = explode(":", $value);
				$idx 		= $pc_ret_urn[0];
				$val 		= $pc_ret_urn[1].'_'.$pc_ret_urn[2];
				$hasil[]= $val;
			}

			$d['data'] = $hasil;
			$d['status'] = "ok";

			j($d);
			exit;		

		} else if ($uri3 == "simpan_akhir") {
			$id_tes = abs($uri4);

			$get_jawaban = $this->db->query("SELECT list_jawaban FROM hasil_ujian WHERE id_tes = '$uri4' AND id_user = '".$a['sess_konid']."'")->row_array();
			$pc_jawaban = explode(",", $get_jawaban['list_jawaban']);

			$jumlah_benar 	= 0;
			$jumlah_salah 	= 0;
			$jumlah_ragu  	= 0;
			$nilai_bobot 	= 0;
			$total_bobot	= 0;
			$jumlah_soal	= sizeof($pc_jawaban);

			for ($x = 0; $x < $jumlah_soal; $x++) {
				$pc_dt = explode(":", $pc_jawaban[$x]);
				$id_soal 	= $pc_dt[0];
				$jawaban 	= $pc_dt[1];
				$ragu 		= $pc_dt[2];

				$cek_jwb 	= $this->db->query("SELECT bobot, jawaban FROM soal_ujian WHERE id = '".$id_soal."'")->row();
				$total_bobot = $total_bobot + $cek_jwb->bobot;
				
				if (($cek_jwb->jawaban == $jawaban)) {
					$jumlah_benar++;
					$nilai_bobot = $nilai_bobot + $cek_jwb->bobot;
					$q_update_jwb = "UPDATE soal_ujian SET jml_benar = jml_benar + 1 WHERE id = '".$id_soal."'";
				} else {
					$jumlah_salah++;
					$q_update_jwb = "UPDATE soal_ujian SET jml_salah = jml_salah + 1 WHERE id = '".$id_soal."'";
				}
				$this->db->query($q_update_jwb);
			}

			$nilai = ($jumlah_benar / $jumlah_soal)  * 100;
			$nilai_bobot = ($nilai_bobot / $total_bobot)  * 100;

			$this->db->query("UPDATE hasil_ujian SET jml_benar = ".$jumlah_benar.", nilai = ".$nilai.", nilai_bobot = ".$nilai_bobot.", status = 'N' WHERE id_tes = '$id_tes' AND id_user = '".$a['sess_konid']."'");
			$a['status'] = "ok";
			j($a);
			exit;		
		} else if ($uri3 == "token") {
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			
			$a['du'] = $this->db->query("SELECT a.id, a.tgl_mulai, a.terlambat, 
				a.token, a.nama_ujian, a.jumlah_soal, a.waktu,
				b.nama nmguru, c.nama nmmapel,
				(case
				when (now() < a.tgl_mulai) then 0
				when (now() >= a.tgl_mulai and now() <= a.terlambat) then 1
				else 2
				end) statuse
				FROM guru_ujian a 
				INNER JOIN guru b ON a.id_guru = b.id
				INNER JOIN mata_pelajaran c ON a.id_mapel = c.id 
				WHERE a.id = '$uri4'")->row_array();

			$a['dp'] = $this->db->query("SELECT * FROM siswa WHERE id = '".$a['sess_konid']."'")->row_array();

			if (!empty($a['du']) || !empty($a['dp'])) {
				$tgl_selesai = $a['du']['tgl_mulai'];

				$tgl_terlambat_baru = $a['du']['terlambat'];

				$a['tgl_mulai'] = $tgl_selesai;
				$a['terlambat'] = $tgl_terlambat_baru;

				$a['p']	= "m_token";
				$this->load->view('home', $a);
			} else {
				redirect('adm/ikuti_ujian');
			}
		} else {
			
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			
			
			$cek_sdh_selesai= $this->db->query("SELECT id FROM hasil_ujian WHERE id_tes = '$uri4' AND id_user = '".$a['sess_konid']."' AND status = 'N'")->num_rows();
			
			if ($cek_sdh_selesai < 1) {
				$cek_detil_tes = $this->db->query("SELECT * FROM guru_ujian WHERE id = '$uri4'")->row();
				$q_cek_sdh_ujian= $this->db->query("SELECT id FROM hasil_ujian WHERE id_tes = '$uri4' AND id_user = '".$a['sess_konid']."'");
				$d_cek_sdh_ujian= $q_cek_sdh_ujian->row();
				$cek_sdh_ujian	= $q_cek_sdh_ujian->num_rows();
				$acakan = $cek_detil_tes->jenis == "acak" ? "ORDER BY RAND()" : "ORDER BY id ASC";

				if ($cek_sdh_ujian < 1)	{		
					$soal_urut_ok = array();
					$q_soal			= $this->db->query("SELECT id, file, tipe_file, soal, opsi_a, opsi_b, opsi_c, opsi_d, opsi_e, '' AS jawaban FROM soal_ujian WHERE id_mapel = '".$cek_detil_tes->id_mapel."' AND id_guru = '".$cek_detil_tes->id_guru."' ".$acakan." LIMIT ".$cek_detil_tes->jumlah_soal)->result();
					$i = 0;
					foreach ($q_soal as $s) {
						$soal_per = new stdClass();
						$soal_per->id = $s->id;
						$soal_per->soal = $s->soal;
						$soal_per->file = $s->file;
						$soal_per->tipe_file = $s->tipe_file;
						$soal_per->opsi_a = $s->opsi_a;
						$soal_per->opsi_b = $s->opsi_b;
						$soal_per->opsi_c = $s->opsi_c;
						$soal_per->opsi_d = $s->opsi_d;
						$soal_per->opsi_e = $s->opsi_e;
						$soal_per->jawaban = $s->jawaban;
						$soal_urut_ok[$i] = $soal_per;
						$i++;
					}
					$soal_urut_ok = $soal_urut_ok;
					$list_id_soal	= "";
					$list_jw_soal 	= "";
					if (!empty($q_soal)) {
						foreach ($q_soal as $d) {
							$list_id_soal .= $d->id.",";
							$list_jw_soal .= $d->id."::N,";
						}
					}
					$list_id_soal = substr($list_id_soal, 0, -1);
					$list_jw_soal = substr($list_jw_soal, 0, -1);
					$waktu_selesai = tambah_jam_sql($cek_detil_tes->waktu);
					$time_mulai		= date('Y-m-d H:i:s');
					$this->db->query("INSERT INTO hasil_ujian VALUES (null, '$uri4', '".$a['sess_konid']."', '$list_id_soal', '$list_jw_soal', 0, 0, 0, '$time_mulai', ADDTIME('$time_mulai', '$waktu_selesai'), 'Y')");
					
					$detil_tes = $this->db->query("SELECT * FROM hasil_ujian WHERE id_tes = '$uri4' AND id_user = '".$a['sess_konid']."'")->row();

					$soal_urut_ok= $soal_urut_ok;
				} else {
					$q_ambil_soal 	= $this->db->query("SELECT * FROM hasil_ujian WHERE id_tes = '$uri4' AND id_user = '".$a['sess_konid']."'")->row();

					$urut_soal 		= explode(",", $q_ambil_soal->list_jawaban);
					$soal_urut_ok	= array();
					for ($i = 0; $i < sizeof($urut_soal); $i++) {
						$pc_urut_soal = explode(":",$urut_soal[$i]);
						$pc_urut_soal1 = empty($pc_urut_soal[1]) ? "''" : "'".$pc_urut_soal[1]."'";
						$ambil_soal = $this->db->query("SELECT *, $pc_urut_soal1 AS jawaban FROM soal_ujian WHERE id = '".$pc_urut_soal[0]."'")->row();
						$soal_urut_ok[] = $ambil_soal; 
					}
					
					$detil_tes = $q_ambil_soal;

					$soal_urut_ok = $soal_urut_ok;
				}

				$pc_list_jawaban = explode(",", $detil_tes->list_jawaban);

				$arr_jawab = array();
				foreach ($pc_list_jawaban as $v) {
					$pc_v = explode(":", $v);
					$idx = $pc_v[0];
					$val = $pc_v[1];
					$rg = $pc_v[2];

					$arr_jawab[$idx] = array("j"=>$val,"r"=>$rg);
				}

				$html = '';
				$no = 1;
				if (!empty($soal_urut_ok)) {
					foreach ($soal_urut_ok as $d) { 
						$tampil_media = tampil_media("./upload/gambar_soal/".$d->file, 'auto','auto');
						$vrg = $arr_jawab[$d->id]["r"] == "" ? "N" : $arr_jawab[$d->id]["r"];

						$html .= '<input type="hidden" name="id_soal_'.$no.'" value="'.$d->id.'">';
						$html .= '<input type="hidden" name="rg_'.$no.'" id="rg_'.$no.'" value="'.$vrg.'">';
						$html .= '<div class="step" id="widget_'.$no.'">';

						$html .= $d->soal.'<br>'.$tampil_media.'<div class="funkyradio">';

						for ($j = 0; $j < $this->config->item('jml_opsi'); $j++) {
							$opsi = "opsi_".$this->opsi[$j];

							$checked = $arr_jawab[$d->id]["j"] == strtoupper($this->opsi[$j]) ? "checked" : "";

							$pc_pilihan_opsi = explode("#####", $d->$opsi);

							$tampil_media_opsi = (is_file('./upload/gambar_soal/'.$pc_pilihan_opsi[0]) || $pc_pilihan_opsi[0] != "") ? tampil_media('./upload/gambar_opsi/'.$pc_pilihan_opsi[0],'auto','auto') : '';

							$pilihan_opsi = empty($pc_pilihan_opsi[1]) ? "-" : $pc_pilihan_opsi[1];

							$html .= '<div class="funkyradio-success" onclick="return simpan_sementara();">
							<fieldset class="radio">
							<span class="text-primary">'.$this->opsi[$j].'.</span>
							<input type="radio" id="opsi_'.strtoupper($this->opsi[$j]).'_'.$d->id.'" name="opsi_'.$no.'" value="'.strtoupper($this->opsi[$j]).'" '.$checked.'> <label for="opsi_'.strtoupper($this->opsi[$j]).'_'.$d->id.'">'.$pilihan_opsi.$tampil_media_opsi.'</label> </fieldset></div>';
						}
						$html .= '</div></div>';
						$no++;
					}
				}



				$a['jam_mulai'] = $detil_tes->tgl_mulai;
				$a['jam_selesai'] = $detil_tes->tgl_selesai;
				$a['id_tes'] = $cek_detil_tes->id;
				$a['no'] = $no;
				$a['html'] = $html;

				$this->load->view('v_ujian', $a);
			} else {
				redirect('adm/sudah_selesai_ujian/'.$uri4);
			}
		}

	}
	public function jvs() {
		$this->cek_aktif();
		
		$data_soal 		= $this->db->query("SELECT id, gambar, soal, opsi_a, opsi_b, opsi_c, opsi_d, opsi_e FROM soal_ujian ORDER BY RAND()")->result();
		
		j($data_soal);
		exit;
	}
	public function rubah_password() {
		$this->cek_aktif();
		
		$a['sess_admin_id'] = $this->session->userdata('admin_id');
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$p = json_decode(file_get_contents('php://input'));
		$ret = array();
		if ($uri3 == "simpan") {
			$p1_md5 = md5($p->p1);
			$p2_md5 = md5($p->p2);
			$p3_md5 = md5($p->p3);
			$cek_pass_lama = $this->db->query("SELECT password FROM user WHERE id = '".$a['sess_admin_id']."'")->row();
			if ($cek_pass_lama->password != $p1_md5) {
				$ret['status'] = "error";
				$ret['msg'] = "Password lama tidak sama...";
			} else if ($p2_md5 != $p3_md5) {
				$ret['status'] = "error";
				$ret['msg'] = "Password baru konfirmasinya tidak sama...";
			} else if (strlen($p->p2) < 6) {
				$ret['status'] = "error";
				$ret['msg'] = "Password baru minimal terdiri dari 6 huruf..";
			} else {
				$this->db->query("UPDATE user SET password = '".$p3_md5."' WHERE id = '".$a['sess_admin_id']."'");
				$ret['status'] = "ok";
				$ret['msg'] = "Password berhasil diubah...";
			}
			j($ret);
			exit;
		} else {
			$data = $this->db->query("SELECT id, kon_id, level, username FROM user WHERE id = '".$a['sess_admin_id']."'")->row();
			j($data);
			exit;
		}
	}
	public function sudah_selesai_ujian() {
		$this->cek_aktif();
		
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		
		$q_nilai = $this->db->query("SELECT nilai, tgl_selesai FROM hasil_ujian WHERE id_tes = $uri3 AND id_user = '".$a['sess_konid']."' AND status = 'N'")->row();
		if (empty($q_nilai)) {
			redirect('adm/ikut_ujian/_/'.$uri3);
		} else {
			
			$a['p'] = "v_selesai_ujian";
			
			if ($this->config->item('tampil_nilai')) {
				$a['data'] = "<div class='alert alert-danger'>Anda telah selesai mengikuti ujian ini pada : <strong style='font-size: 16px'>".tjs($q_nilai->tgl_selesai, "l")."</strong>, dan mendapatkan nilai : <strong style='font-size: 16px'>".$q_nilai->nilai."</strong></div>";
			} else {
				$a['data'] = "<div class='alert alert-danger'>Anda telah selesai mengikuti ujian ini pada : <strong style='font-size: 16px'>".tjs($q_nilai->tgl_selesai, "l")."</strong>. Nilai akan diumumkan oleh Guru yang bersangkutan.</div>";
			}
		}
		$this->load->view('home', $a);
	}
	public function login() {
		$this->load->view('login');
	}
	
	public function act_login() {
		
		$username	= $this->input->post('username');
		$password	= $this->input->post('password');
		
		$password2	= md5($password);
		
		$q_data		= $this->db->query("SELECT * FROM user WHERE username = '".$username."' AND password = '$password2'");
		$j_data		= $q_data->num_rows();
		$a_data		= $q_data->row();
		
		$_log		= array();
		if ($j_data === 1) {
			$sess_nama_user = "";
			if ($a_data->level == "siswa") {
				$det_user = $this->db->query("SELECT nama FROM siswa WHERE id = '".$a_data->kon_id."'")->row();
				if (!empty($det_user)) {
					$sess_nama_user = $det_user->nama;
				}
			} else if ($a_data->level == "guru") {
				$det_user = $this->db->query("SELECT nama FROM guru WHERE id = '".$a_data->kon_id."'")->row();
				if (!empty($det_user)) {
					$sess_nama_user = $det_user->nama;
				}
			} else {
				$sess_nama_user = "Administrator";
			}
			$data = array(
				'admin_id' => $a_data->id,
				'admin_user' => $a_data->username,
				'admin_level' => $a_data->level,
				'admin_konid' => $a_data->kon_id,
				'admin_nama' => $sess_nama_user,
				'admin_valid' => true
			);
			$this->session->set_userdata($data);
			$_log['log']['status']			= "1";
			$_log['log']['keterangan']		= "Login berhasil";
			$_log['log']['detil_admin']		= $this->session->userdata;
		} else {
			$_log['log']['status']			= "0";
			$_log['log']['keterangan']		= "Maaf, username dan password tidak ditemukan";
			$_log['log']['detil_admin']		= null;
		}
		
		j($_log);
	}
	
	public function logout() {
		$data = array(
			'admin_id' 		=> "",
			'admin_user' 	=> "",
			'admin_level' 	=> "",
			'admin_konid' 	=> "",
			'admin_nama' 	=> "",
			'admin_valid' 	=> false
		);
		$this->session->set_userdata($data);
		redirect('adm');
	}
	public function get_akhir($tabel, $field, $kode_awal, $pad) {
		$get_akhir	= $this->db->query("SELECT MAX($field) AS max FROM $tabel LIMIT 1")->row();
		$data		= (intval($get_akhir->max)) + 1;
		$last		= $kode_awal.str_pad($data, $pad, '0', STR_PAD_LEFT);

		return $last;
	}
	
	
}
