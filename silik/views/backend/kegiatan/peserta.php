<?php $this->load->view("backend/includes/header"); ?>
<?php $this->load->view("backend/kegiatan/header"); ?>
<?php $this->load->view("backend/kegiatan/menu"); ?>

<div class="main-body">
	<div class="page-wrapper">
		<!-- [ Main Content ] start -->
		<div class="row">
			<div class="col-md-12">

				<?php
					$linkRegistrasiType = "link_peserta";
					$linkRegistrasi = "";
					$linkRegistrasiOn = "";
					$linkRegistrasiTargetClass = "generateBitlyLinkTargetOff";					

					if ($kegiatan[$linkRegistrasiType."_on"]) {
						$linkRegistrasiOn = 'checked="checked"';
						$linkRegistrasiTargetClass = "";
					}
				
					$linkRegisUrl = base_url("/kegiatan/registrasi_peserta/".$kegiatan["id"]);
				
					if (!empty($kegiatan[$linkRegistrasiType]) && !empty($kegiatan[$linkRegistrasiType]["custom_bitlinks"])) {
						
						$linkRegisUrl = $kegiatan[$linkRegistrasiType]["custom_bitlinks"];
					}
				
					$linkRegistrasi = '<input type="text" class="generateBitlyLinkTarget '.$linkRegistrasiTargetClass.'" value="'.$linkRegisUrl.'" readonly="readonly" /><button class="btn btn-edit-bitly" title="Edit Bitly Link"><i class="fas fa-edit"></i></button>';

				
					$turnOnRegisterButton = '
					<div class="switch d-inline generateBitlyLinkBtn">
						<input type="checkbox" id="generateLinkRegistrasi" '.$linkRegistrasiOn.' data-type="peserta" value="'.$kegiatan["id"].'" />
						<label for="generateLinkRegistrasi" class="cr" style="top:8px;" title="Aktifkan Registrasi"></label>
					</div>
					<div class="generateBitlyLink">'.$linkRegistrasi.'</div>';

					$conditions = array(
						array(
							"field" => "kegiatan_id",
							"operator" => "=",
							"value" => $kegiatan["id"]
						)
					);

					$this->bootgrid->setTable("kegiatan_peserta", $conditions);
					$this->bootgrid->setTitle("PESERTA ".$turnOnRegisterButton);
					$this->bootgrid->sortBy("kode");
					$this->bootgrid->sortType("ASC");

					$cardLink = array();
					$cardLink[] = array(
						"target" => "javascript:;",
						"icon" => "fas fa-file-pdf",
						"data" => array("kegiatan" => $kegiatan["id"], "tipe" => "peserta"),
						"class" => "download-biodata-kegiatan",
						"text" => "Download Biodata"
					);
					$cardLink[] = array(
						"target" => "/admin/kegiatan/download_daftar_hadir/".$kegiatan["id"]."/peserta",
						"icon" => "fas fa-file-pdf",
						"text" => "Download Daftar Hadir"
					);

					$cardLink[] = array(
						"target" => "/admin/kegiatan/export_excel/".$kegiatan["id"]."/peserta",
						"icon" => "fas fa-file-excel",
						"text" => "Export Excel"
					);

					$this->bootgrid->setCardLink($cardLink);



					$columns = array();
					$columns[] = array(
						"id" => "id",
						"field" => "id",
						"name" => "ID",
						"type" => "numeric",
						"width" => "25px",
						"identifier" => "true",
						"visible" => "false"
					);
					$columns[] = array(
						"id" => "autonumeric",
						"field" => "autonumeric",
						"name" => "Auto",
						"type" => "autonumeric",
						"width" => "25px",
						"visible" => "false"
					);
					$columns[] = array(
						"id" => "no_urut",
						"field" => "kode",
						"name" => "No",
						"width" => "25px",
						"visible" => "true",
						"format" => "nomor_urut"
					);
					$columns[] = array(
						"id" => "kode",
						"field" => "kode",
						"name" => "Kode",
						"visible" => "false"
					);
					$columns[] = array(
						"id" => "ktp",
						"field" => "ktp",
						"name" => "NIK",
						"visible" => "false"
					);
					$columns[] = array(
						"id" => "nama",
						"field" => "nama",
						"name" => "Nama"
					);
					$columns[] = array(
						"id" => "tempat_lahir",
						"field" => "tempat_lahir",
						"name" => "Tempat Lahir",
						"visible" => "false"
					);
					$columns[] = array(
						"id" => "tgl_lahir",
						"field" => "tgl_lahir",
						"name" => "Tgl Lahir",
						"visible" => "false"
					);
					$columns[] = array(
						"id" => "alamat_tinggal",
						"field" => "alamat_tinggal",
						"name" => "Alamat",
						"visible" => "false"
					);
					$columns[] = array(
						"id" => "telp",
						"field" => "telp",
						"name" => "Telp",
						"visible" => "false"
					);
					$columns[] = array(
						"id" => "nip",
						"field" => "nip",
						"name" => "NIP"
					);
					$columns[] = array(
						"id" => "pangkat",
						"field" => "pangkat",
						"name" => "Pangkat",
						"visible" => "false"
					);
					$columns[] = array(
						"id" => "golongan",
						"field" => "golongan",
						"name" => "Gol",
						"visible" => "true"
					);
					$columns[] = array(
						"id" => "jabatan",
						"field" => "jabatan",
						"name" => "Jabatan",
						"visible" => "true"
					);
					$columns[] = array(
						"id" => "unit_kerja",
						"field" => "unit_kerja",
						"name" => "Unit Kerja"
					);
					
					if (isset($kegiatan["kategori"]["peserta"]) && !empty($kegiatan["kategori"]["peserta"])) {
						$columns[] = array(
							"id" => "kategori",
							"field" => "kategori",
							"name" => "Kelas"
						);
					}
				
					$columns[] = array(
						"id" => "kab_unit_kerja",
						"field" => "kab_unit_kerja",
						"name" => "Kab/Kota"
					);
					
					$columns[] = array(
						"id" => "biodata",
						"field" => "id",
						"name" => "Biodata",
						"format" => "button",
						"button" => array(
							"text" => "<i class='fas fa-address-book'></i> Biodata",
							"class" => "download-biodata"
						),
						"link" => array(
							"url" => "/admin/kegiatan/download_single_biodata/peserta/{{id}}",
							"target" => "_blank"
						),
						"visible" => "false"
					);
					
					$showSurtug = "false";
					if (!empty($kegiatan["form_upload_surtug_peserta"]) || !empty($kegiatan["form_wajib_surtug_peserta"]))  {
						$showSurtug = "true";
					}
				
					$columns[] = array(
						"id" => "surat_tugas",
						"field" => "surat_tugas",
						"name" => "Surat Tugas",
						"format" => "surat_tugas",
						"link" => array(
							"url" => "/assets/surat_tugas/".$_SESSION["tahun_anggaran"]."/".$kegiatan["kode"]."/",
							"target" => "_blank"
						),
						"visible" => $showSurtug
					);
				
					$columns[] = array(
						"id" => "alamat_unit_kerja",
						"field" => "alamat_unit_kerja",
						"name" => "Alamat Unit Kerja",
						"visible" => "false"
					);
					$columns[] = array(
						"id" => "telp_unit_kerja",
						"field" => "telp_unit_kerja",
						"name" => "Telp Unit Kerja",
						"visible" => "false"
					);

					$columns[] = array(
						"id" => "npwp",
						"field" => "npwp",
						"name" => "NPWP",
						"visible" => "false"
					);

					$columns[] = array(
						"id" => "email",
						"field" => "email",
						"name" => "Email",
						"visible" => "false"
					);
				
					if ($kegiatan["tipe_kegiatan"] == "Daring") {
						$start_date = new DateTime($kegiatan["tgl_mulai_kegiatan"]);
						$end_date = new DateTime($kegiatan["tgl_selesai_kegiatan"]);
						$end_date->setTime(0,0,1);

						// Step 2: Defining the Date Interval
						$interval = new DateInterval('P1D');

						// Step 3: Creating the Date Range
						$date_range = new DatePeriod($start_date, $interval, $end_date);
						
						$date_sign = array();
						foreach($date_range as $date) {
							$dateFormated = $date->format('Y-m-d');
							$date_sign[] = $dateFormated;
						}

						if (!empty($kegiatan["detail_tgl_kegiatan"])) {
							$date_sign = $kegiatan["detail_tgl_kegiatan"];
						}

						if (!empty($date_sign)) {
							foreach ($date_sign as $df) {
								$columns[] = array(
									"id" => "daftar_hadir_".$df,
									"field" => "daftar_hadir",
									"name" => "Hadir ".$this->utility->formatDateShortMonthIndo($df),
									"class" => "text-center",
									"format" => "checklistHadir"
								);
							}
						}
						
					}

					$columns[] = array(
						"id" => "dibuat_tgl",
						"field" => "dibuat_tgl",
						"name" => "Dibuat Tgl",
						"format" => "date",
						"date" => array(
							"format" => "d/m/Y H:i a"
						),
						"visible" => "false"
					);

					$columns[] = array(
						"id" => "diubah_tgl",
						"field" => "diubah_tgl",
						"name" => "Diubah Tgl",
						"format" => "date",
						"date" => array(
							"format" => "d/m/Y H:i a"
						),
						"visible" => "false"
					);
				
					$columns[] = array(
						"id" => "preview",
						"field" => "id",
						"name" => "",
						"format" => "button",
						"button" => array(
							"text" => '<i class="fab fa-sistrix mr-0" title="Preview"></i> Lihat'
						),
						"modal" => array(
							"view" => "backend/kegiatan/modal_kegiatan_item"
						)
					);

					$this->bootgrid->setColumns($columns);
				
					$this->bootgrid->setCustomFilter("kabupaten_kota");
				
					if (isset($kegiatan["kategori"]["peserta"]) && !empty($kegiatan["kategori"]["peserta"])) {
						$this->bootgrid->setCustomFilter("kelas", $kegiatan["kategori"]["peserta"]);
					}

					if ($this->utility->hasUserAccess("peserta_kegiatan","add")) {
						$addButton = array(
							"text" => "Tambah",
							"parent" => $kegiatan["id"],
							"modal" => array(
								"view" => "backend/kegiatan/modal_kegiatan_item",
								"data" => array(
									"table" => "kegiatan_peserta"
								)
							)
						);
						$this->bootgrid->setAddButton($addButton);
					}

					if ($this->utility->hasUserAccess("peserta_kegiatan","edit")) {
						$editButton = array(
							"text" => "Edit",
							"parent" => $kegiatan["id"],
							"modal" => array(
								"view" => "backend/kegiatan/modal_kegiatan_item"
							)
						);
						$this->bootgrid->setEditButton($editButton);
					}

					if ($this->utility->hasUserAccess("peserta_kegiatan","delete")) {
						$deleteButton = array(
							"text" => "Delete"
						);
						$this->bootgrid->setDeleteButton($deleteButton);
					}

					$this->bootgrid->setRowCount('15');

					print $this->bootgrid->render();
				?>
			</div>
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h5 class="bootgrid-title">REPORT PENDAFTARAN PESERTA</h5>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<input type="hidden" class="unsur-pendaftaran" value="<?php print $unsur; ?>" />
								<div id="report-pendaftaran">
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- [ Main Content ] end -->
	</div>
</div>

<div id="modal-perjadin-nomnatif"></div>

<?php $this->load->view("backend/includes/footer"); ?>
<script src="https://code.highcharts.com/highcharts.js"></script>