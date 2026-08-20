<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Developer extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model("kegiatan_model");
		$this->load->model("kegiatan_options_model");
	}
	
	public function index () {
		$this->auth->login();

		$kegiatan = $this->kegiatan_model->get_all();

		$komponens = array("peserta","narasumber","moderator","panitia","pp","fasil","instruktur","pengawas","kepala_sekolah");

		if (!empty($kegiatan)) {
			foreach ($kegiatan as $keg) {
				$keg = (array) $keg;
				
				if (!empty($keg)) {
					//Build Own Array
					foreach ($komponens as $kom) {
						$options = array();
						$options["kegiatan_id"] = $keg["id"];
						$options["code_komponen"] = $kom;
						$options["key"] = "link_on";
						$options["value"] = $keg["link_".$kom."_on"];
						$this->kegiatan_options_model->save($options);

						$options = array();
						$options["kegiatan_id"] = $keg["id"];
						$options["code_komponen"] = $kom;
						$options["key"] = "link";
						$options["value"] = $keg["link_".$kom];
						$this->kegiatan_options_model->save($options);

						$options = array();
						$options["kegiatan_id"] = $keg["id"];
						$options["code_komponen"] = $kom;
						$options["key"] = "form_show_bank";
						$options["value"] = $keg["form_show_bank_".$kom];
						$this->kegiatan_options_model->save($options);

						$options = array();
						$options["kegiatan_id"] = $keg["id"];
						$options["code_komponen"] = $kom;
						$options["key"] = "form_show_confirm_paket";
						$options["value"] = $keg["form_show_confirm_paket_".$kom];
						$this->kegiatan_options_model->save($options);

						$options = array();
						$options["kegiatan_id"] = $keg["id"];
						$options["code_komponen"] = $kom;
						$options["key"] = "form_ttd";
						$options["value"] = $keg["form_ttd_".$kom];
						$this->kegiatan_options_model->save($options);

						$options = array();
						$options["kegiatan_id"] = $keg["id"];
						$options["code_komponen"] = $kom;
						$options["key"] = "form_upload_surtug";
						$options["value"] = $keg["form_upload_surtug_".$kom];
						$this->kegiatan_options_model->save($options);

						$options = array();
						$options["kegiatan_id"] = $keg["id"];
						$options["code_komponen"] = $kom;
						$options["key"] = "form_wajib_surtug";
						$options["value"] = $keg["form_wajib_surtug_".$kom];
						$this->kegiatan_options_model->save($options);


						$options = array();

						$komp = $kom;

						if ($kom == "pp") {
							$komp = "pengajar_praktek";
						}

						if ($kom == "fasil") {
							$komp = "fasilitator";
						}

						$options["kegiatan_id"] = $keg["id"];
						$options["code_komponen"] = $kom;
						$options["key"] = "npsn";
						$options["value"] = $keg["form_npsn_".$komp];
						$this->kegiatan_options_model->save($options);

						$options = array();
						$options["kegiatan_id"] = $keg["id"];
						$options["code_komponen"] = $kom;
						$options["key"] = "kategori";
						$options["value"] = $keg["spd_nama"];
						$this->kegiatan_options_model->save($options);

						$options = array();
						$options["kegiatan_id"] = $keg["id"];
						$options["code_komponen"] = $kom;
						$options["key"] = "wa_grup";
						$options["value"] = $keg["wa_grup_".$kom];
						$this->kegiatan_options_model->save($options);
						
						$options = array();
						$options["kegiatan_id"] = $keg["id"];
						$options["code_komponen"] = $kom;
						$options["key"] = "tele_grup";
						$options["value"] = $keg["tele_grup_".$kom];
						$this->kegiatan_options_model->save($options);

						$options = array();
						$options["kegiatan_id"] = $keg["id"];
						$options["code_komponen"] = $kom;
						$options["key"] = "sertificate";
						$options["value"] = $keg["sertificate_".$kom];
						$this->kegiatan_options_model->save($options);

						$options = array();
						$options["kegiatan_id"] = $keg["id"];
						$options["code_komponen"] = $kom;
						$options["key"] = "spd_nama";
						$options["value"] = $keg["spd_nama"];
						$this->kegiatan_options_model->save($options);

						$options = array();
						$options["kegiatan_id"] = $keg["id"];
						$options["code_komponen"] = $kom;
						$options["key"] = "spd_nip";
						$options["value"] = $keg["spd_nip"];
						$this->kegiatan_options_model->save($options);

						$options = array();
						$options["kegiatan_id"] = $keg["id"];
						$options["code_komponen"] = $kom;
						$options["key"] = "spd_jabatan";
						$options["value"] = $keg["spd_jabatan"];
						$this->kegiatan_options_model->save($options);

						$options = array();
						$options["kegiatan_id"] = $keg["id"];
						$options["code_komponen"] = $kom;
						$options["key"] = "spd_satker";
						$options["value"] = $keg["spd_satker"];
						$this->kegiatan_options_model->save($options);
					}
				}
			}
		}

		
	}

	public function geolocation () {
		?>
			<!DOCTYPE html>
			<html>
			<head>
				<title>Absensi dengan Geolocation</title>
				<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
			</head>
			<body>
				<button id="getLocation">Dapatkan Lokasi Saya</button>
				<div id="lokasi"></div>
				<div id="peta"></div>

				<script>
					$(document).ready(function() {
						$("#getLocation").click(function() {
							if (navigator.geolocation) {
								// Permintaan izin akses lokasi
								navigator.geolocation.getCurrentPosition(
									function(position) { // Jika sukses
										const latitude = position.coords.latitude;
										const longitude = position.coords.longitude;
										const lokasi = `${latitude},${longitude}`;

										$("#lokasi").html(`
											<p>Latitude: ${latitude}</p>
											<p>Longitude: ${longitude}</p>
										`);

										// Kirim data ke server (AJAX)
										$("#peta").append(`
											<iframe 
												width="1000" 
												height="500" 
												frameborder="0" 
												src="https://maps.google.com/maps?q=${latitude},${longitude}&output=embed">
											</iframe>
										`);
									},
									function(error) { // Jika gagal
										let errorMessage;
										switch(error.code) {
											case error.PERMISSION_DENIED:
												errorMessage = "Izin lokasi ditolak oleh pengguna.";
												break;
											case error.POSITION_UNAVAILABLE:
												errorMessage = "Informasi lokasi tidak tersedia.";
												break;
											case error.TIMEOUT:
												errorMessage = "Permintaan lokasi timeout.";
												break;
											default:
												errorMessage = "Error tidak diketahui.";
										}
										$("#lokasi").html(`<p style="color:red;">${errorMessage}</p>`);
									}
								);
							} else {
								$("#lokasi").html("<p>Browser tidak mendukung geolocation!</p>");
							}
						});
					});
				</script>
			</body>
			</html>
		<?php
	}
}
