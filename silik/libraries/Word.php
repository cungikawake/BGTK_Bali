<?php
	if (! defined('BASEPATH')) exit('No direct script access allowed');
	
	require APPPATH .'third_party/PhpWord/Autoloader.php';
	
	use PhpOffice\PhpWord\Autoloader;
	use PhpOffice\PhpWord\Settings;

	Autoloader::register();
	Settings::loadConfig();

	class Word {
		var $CI;
		
		public function __construct () {
			$this->CI =& get_instance();
		}
		
		public function save ($data) {
			$this->CI->load->library('utility');

			$templateProcessor = new PhpOffice\PhpWord\TemplateProcessor(APPPATH."../KKS_PM.docx");
			
			$templateProcessor->setValue('sekolah', $data["sekolah"]);
			$templateProcessor->setValue('nomor_bgtk', $data["nomor_bgtk"]);
			$templateProcessor->setValue('nomor_sekolah', $data["nomor_sekolah"]);

			$tgl_perjanjian = $data["tgl_perjanjian"];
			$hari_perjanjian = $this->CI->utility->formatDay($tgl_perjanjian);
			$templateProcessor->setValue('hari_perjanjian', $hari_perjanjian);

			$tgl = date("d", strtotime($tgl_perjanjian));
			$terbilang_tgl = $this->CI->utility->angka_huruf($tgl);
			$templateProcessor->setValue('terbilang_tgl', $terbilang_tgl);

			$tgl = date("n", strtotime($tgl_perjanjian));
			$terbilang_bln = $this->CI->utility->namaBulan($tgl);
			$templateProcessor->setValue('terbilang_bln', $terbilang_bln);

			$tgl = date("d-m-Y", strtotime($tgl_perjanjian));
			$templateProcessor->setValue('tgl_angka', $tgl);

			$templateProcessor->setValue('nama_kepala_sekolah', $data["nama_kepala_sekolah"]);
			$templateProcessor->setValue('jabatan_kepala_sekolah', $data["jabatan_kepala_sekolah"]);
			$templateProcessor->setValue('alamat_sekolah', $data["alamat_sekolah"]);
			$templateProcessor->setValue('nip_kepala_sekolah', $data["nip_kepala_sekolah"]);

			$templateProcessor->setValue('jumlah_guru', $data["jumlah_guru"]);
			$templateProcessor->setValue('jumlah_ks', $data["jumlah_ks"]);
			$templateProcessor->setValue('jumlah_semua', $data["jumlah_guru"] + $data["jumlah_ks"]);

			$templateProcessor->setValue('jenis_dana', $data["jenis_dana"]);

			$templateProcessor->setValue('tlp_sekolah', $data["tlp_sekolah"]);
			$templateProcessor->setValue('email_sekolah', $data["email_sekolah"]);

			$templateProcessor->setValue('kabupaten', $data["kabupaten"]);

			$tgl_ttd = $this->CI->utility->formatDateIndo($tgl_perjanjian);
			$templateProcessor->setValue('tgl_ttd', $tgl_ttd);
			
			$templateProcessor->setValue('biaya_pnbp', $this->CI->utility->format_number($data["biaya_pnbp_ks"] + $data["biaya_pnbp_guru"]));
			$templateProcessor->setValue('biaya_pnbp_ks', $this->CI->utility->format_number($data["biaya_pnbp_ks"]));
			$templateProcessor->setValue('biaya_pnbp_guru', $this->CI->utility->format_number($data["biaya_pnbp_guru"]));

			$templateProcessor->setValue('biaya_non_pnbp', $this->CI->utility->format_number($data["biaya_non_pnbp_ks"] + $data["biaya_non_pnbp_guru"]));
			$templateProcessor->setValue('biaya_non_pnbp_ks', $this->CI->utility->format_number($data["biaya_non_pnbp_ks"]));
			$templateProcessor->setValue('biaya_non_pnbp_guru', $this->CI->utility->format_number($data["biaya_non_pnbp_guru"]));
			
			$biayaTotalPnbpKs = $data["jumlah_ks"]*$data["biaya_pnbp_ks"];
			$biayaTotalPnbpGuru = $data["jumlah_guru"]*$data["biaya_pnbp_guru"];
			$biayaTotalPnbp = $biayaTotalPnbpKs + $biayaTotalPnbpGuru;
			$templateProcessor->setValue('biaya_total_pnbp', $this->CI->utility->format_number($biayaTotalPnbp));
			$templateProcessor->setValue('biaya_total_pnbp_ks', $this->CI->utility->format_number($biayaTotalPnbpKs));
			$templateProcessor->setValue('biaya_total_pnbp_guru', $this->CI->utility->format_number($biayaTotalPnbpGuru));

			$biayaTotalNonPnbpKs = $data["jumlah_ks"]*$data["biaya_non_pnbp_ks"];
			$biayaTotalNonPnbpGuru = $data["jumlah_guru"]*$data["biaya_non_pnbp_guru"];
			$biayaTotalNonPnbp = $biayaTotalNonPnbpKs + $biayaTotalNonPnbpGuru;
			$templateProcessor->setValue('biaya_total_non_pnbp', $this->CI->utility->format_number($biayaTotalNonPnbp));
			$templateProcessor->setValue('biaya_total_non_pnbp_ks', $this->CI->utility->format_number($biayaTotalNonPnbpKs));
			$templateProcessor->setValue('biaya_total_non_pnbp_guru', $this->CI->utility->format_number($biayaTotalNonPnbpGuru));

			$biayaTotalPelatihan = $biayaTotalPnbp + $biayaTotalNonPnbp;
			$templateProcessor->setValue('biaya_total_pelatihan', $this->CI->utility->format_number($biayaTotalPelatihan));

			$templateProcessor->setValue('nomor_rekening', $data["nomor_rekening"]);
			$templateProcessor->setValue('nama_rekening', $data["nama_rekening"]);

			$templateProcessor->saveAs(APPPATH."../assets/kontrak_pm/".$data["npsn"]."_".$data["sekolah"].".docx");
		}

	}