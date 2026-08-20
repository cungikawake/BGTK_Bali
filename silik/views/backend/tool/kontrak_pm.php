<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="feather icon-file-text"></i> KKS Pembelajaran Mendalam</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- [ breadcrumb ] end -->

	<style type="text/css">
		.border-table-left {
			border-left: 1px solid #ccc;
			padding-left: 10px !important;
		}
	</style>

	<div class="main-body">
		<div class="page-wrapper">
			<!-- [ Main Content ] start -->
			<div class="row">
				<div class="col-md-12">										
					<?php
						$this->bootgrid->setTable("kontrak_pm");
						$this->bootgrid->setTitle("KKS PEMBELAJARAN MENDALAM");
						$this->bootgrid->sortBy("id");
						$this->bootgrid->sortType("ASC");

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
							"name" => "No",
							"type" => "autonumeric",
							"width" => "25px",
							"visible" => "true"
						);
						$columns[] = array(
							"id" => "npsn",
							"field" => "npsn",
							"name" => "NPSN"
						);
						$columns[] = array(
							"id" => "nama_sekolah",
							"field" => "nama_sekolah",
							"name" => "Nama Sekolah"
						);
						$columns[] = array(
							"id" => "kab_unit_kerja",
							"field" => "kab_unit_kerja",
							"name" => "Kabupaten"
						);
						$columns[] = array(
							"id" => "nomor_rekening",
							"field" => "nomor_rekening",
							"name" => "Nomor Rekening"
						);
						$columns[] = array(
							"id" => "nama_rekening",
							"field" => "nama_rekening",
							"name" => "Nama Rekening"
						);
						$columns[] = array(
							"id" => "nomor_bgtk",
							"field" => "nomor_bgtk",
							"name" => "Nomor Surat BGTK",
							"class" => "border-table-left"
						);
						$columns[] = array(
							"id" => "tgl_kks",
							"field" => "tgl_kks",
							"name" => "Tanggal KKS"
						);
						$columns[] = array(
							"id" => "jumlah_ks",
							"field" => "jumlah_ks",
							"name" => "KS",
							"class" => "border-table-left"
						);
						$columns[] = array(
							"id" => "biaya_pnbp_ks",
							"field" => "biaya_pnbp_ks",
							"name" => "PNBP KS",
							"format" => "money"
						);
						$columns[] = array(
							"id" => "biaya_non_pnbp_ks",
							"field" => "biaya_non_pnbp_ks",
							"name" => "Non PNBP KS",
							"format" => "money"
						);
						$columns[] = array(
							"id" => "biaya_per_ks",
							"field" => "biaya_pnbp_ks",
							"name" => "Harga Per KS",
							"format" => "formula_money",
							"formula" => "({{biaya_pnbp_ks}}+{{biaya_non_pnbp_ks}})"
						);
						$columns[] = array(
							"id" => "biaya_total_ks",
							"field" => "biaya_non_pnbp_ks",
							"name" => "Total KS",
							"format" => "formula_money",
							"formula" => "({{jumlah_ks}}*{{biaya_pnbp_ks}})+({{jumlah_ks}}*{{biaya_non_pnbp_ks}})"
						);

						$columns[] = array(
							"id" => "jumlah_guru",
							"field" => "jumlah_guru",
							"name" => "Guru",
							"class" => "border-table-left"
						);
						$columns[] = array(
							"id" => "biaya_pnbp_guru",
							"field" => "biaya_pnbp_guru",
							"name" => "PNBP Guru",
							"format" => "money"
						);
						
						$columns[] = array(
							"id" => "biaya_non_pnbp_guru",
							"field" => "biaya_non_pnbp_guru",
							"name" => "Non PNBP Guru",
							"format" => "money"
						);

						$columns[] = array(
							"id" => "biaya_per_guru",
							"field" => "biaya_pnbp_guru",
							"name" => "Harga Per Guru",
							"format" => "formula_money",
							"formula" => "({{biaya_pnbp_guru}}+{{biaya_non_pnbp_guru}})"
						);

						$columns[] = array(
							"id" => "biaya_total_guru",
							"field" => "biaya_non_pnbp_guru",
							"name" => "Total Guru",
							"format" => "formula_money",
							"formula" => "({{jumlah_guru}}*{{biaya_pnbp_guru}})+({{jumlah_guru}}*{{biaya_non_pnbp_guru}})"
						);

						$columns[] = array(
							"id" => "biaya_total_ks_guru",
							"field" => "biaya_non_pnbp_guru",
							"name" => "Total",
							"format" => "formula_money",
							"formula" => "({{jumlah_ks}}*{{biaya_pnbp_ks}})+({{jumlah_ks}}*{{biaya_non_pnbp_ks}})+({{jumlah_guru}}*{{biaya_pnbp_guru}})+({{jumlah_guru}}*{{biaya_non_pnbp_guru}})",
							"class" => "border-table-left"
						);
					
						$columns[] = array(
							"id" => "preview",
							"field" => "id",
							"name" => "",
							"format" => "button",
							"button" => array(
								"text" => '<i class="fas fa-download mr-0" title="Download Dokumen"></i>',
								"class" => "download-dokumen"
							),
							"link" => array(
								"url" => base_url("/admin/tool/download_kontrak_pm/{{id}}")
							)
						);

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

						$this->bootgrid->setColumns($columns);
					
						$this->bootgrid->setCustomFilter("kabupaten_kota");
						
						$toolbarButton = array(
							"class" => "import_data_kontrak_pm",
							"title" => "Import Data KKS",
							"icon" => "fas fa-cloud-upload-alt"
						);

						$this->bootgrid->setToolbarButton($toolbarButton);
					
						$this->bootgrid->setRowCount('15');

						print $this->bootgrid->render();
					?>
				</div>
			</div>
			<!-- [ Main Content ] end -->
		</div>
	</div>
<?php $this->load->view("backend/includes/footer"); ?>
<script src="<?php print base_url('assets/js/pm.js?v='.rand()); ?>"></script>
