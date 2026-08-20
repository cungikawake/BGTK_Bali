<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="feather icon-folder"></i> Arsip</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- [ breadcrumb ] end -->

	<div class="main-body">
		<div class="page-wrapper">
			<!-- [ Main Content ] start -->
			<div class="row">
				<div class="col-md-12">										
					<?php
						$conditions = array(
							array(
								"field" => "arsip.dibuat_oleh",
								"operator" => "=",
								"value" => $_SESSION["user"]["id"]
							)
						);

						$this->bootgrid->setTable("arsip", $conditions);
						$this->bootgrid->setTitle("ARSIP");
						$this->bootgrid->setTableJoin("kegiatan");
						$this->bootgrid->setTableJoinType("LEFT");
						$this->bootgrid->setTableJoinCondition("arsip.kegiatan_id = kegiatan.id");
						$this->bootgrid->sortBy("arsip.id");
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
							"id" => "kode",
							"field" => "kode",
							"name" => "Kode"
						);
						
						$columns[] = array(
							"id" => "jenis_berkas",
							"field" => "jenis_berkas",
							"name" => "Jenis Berkas",
							"format" => "jenis_arsip",
							"visible" => "false"
						);

						$columns[] = array(
							"id" => "nama",
							"field" => "nama",
							"name" => "Nama Arsip",
							"class" => "wraptext",
							"width" => "780px"
						);

						$columns[] = array(
							"id" => "status",
							"field" => "status",
							"name" => "Status",
							"format" => "label_arsip"
						);

						$columns[] = array(
							"id" => "no_kabinet",
							"field" => "no_kabinet",
							"name" => "Kabinet",
							"class" => "text-center",
							"width" => "100px"
						);

						$columns[] = array(
							"id" => "no_laci",
							"field" => "no_laci",
							"name" => "Laci",
							"class" => "text-center",
							"width" => "100px"
						);

						$columns[] = array(
							"id" => "no_folder",
							"field" => "no_folder",
							"name" => "Folder",
							"class" => "text-center",
							"width" => "100px"
						);

						$columns[] = array(
							"id" => "diubah_tgl",
							"field" => "diubah_tgl",
							"name" => "Diubah Tgl",
							"format" => "date",
							"date" => array(
								"format" => "d M Y"
							),
							"visible" => "false"
						);

						$columns[] = array(
							"id" => "print_label",
							"field" => "id",
							"name" => "Label",
							"format" => "button",
							"button" => array(
								"text" => "<i class='fas fa-print mr-0'></i>",
								"class" => "print-label-arsip"
							),
							"link" => array(
								"url" => "/admin/arsip/label/{{arsip__id}}",
								"target" => "_blank"
							)
						);

						$this->bootgrid->setColumns($columns);
						
						$addButton = array(
							"text" => "<i class='fas fa-plus mr-0'></i>",
							"modal" => array(
								"view" => "backend/arsip/modal_arsip"
							)
						);
						$this->bootgrid->setAddButton($addButton);	
					
				
						$editButton = array(
							"text" => '<i class="fas fa-edit mr-0"></i>',
							"modal" => array(
								"view" => "backend/arsip/modal_arsip"
							),
							"conditions" => array(
								/*array(
									"field" => "kegiatan__progress_laporan",
									"operator" => "==",
									"value" => "0"
								),
								array("operator" => "OR"),
								array(
									"field" => "kegiatan__progress_laporan",
									"operator" => "==",
									"value" => "3"
								),
								array("operator" => "OR"),
								array(
									"field" => "kegiatan__progress_laporan",
									"operator" => "==",
									"value" => "6"
								)*/
							)
						);

						$this->bootgrid->setEditButton($editButton);

						$deleteButton = array(
							"text" => '<i class="fas fa-trash-alt mr-0"></i>',
							"conditions" => array(
								array(
									"field" => "arsip__status",
									"operator" => "==",
									"value" => "Baru"
								),
								array(
									"field" => "arsip__jenis_berkas",
									"operator" => "!=",
									"value" => "Laporan Kegiatan"
								)
							)
						);
						$this->bootgrid->setDeleteButton($deleteButton);
					
						$this->bootgrid->setRowCount('15');

						print $this->bootgrid->render();
					?>
				</div>
			</div>
			<!-- [ Main Content ] end -->
		</div>
	</div>
<?php $this->load->view("backend/includes/footer"); ?>
<script>
	var Arsip = {};

	Arsip.resetNoItem = function () {
		$('.table-uraian-arsip tbody tr').each(function (i) {
			var no = i+1;
			$(this).find('.no-item').html(no);
		});
	}

	Arsip.setSelect2Item = function () {
		var opt = {};
		
		if ($(".modal-body").length) {
			opt = {dropdownParent: $(".modal-body")};
		}
		$('.table-uraian-arsip tbody tr .select2').select2(opt);
	}

	Arsip.showAlasanTolakSpi = function (id) {
		$.ajax({
			type: "POST",
			url: "/admin/arsip/getJsonArsip/?v="+Math.random(),
			data: {
				id: id,
				version: Math.random()				
			},
			dataType: 'json',
			success: function(obj){
				var modalTolak = '<div id="alasan-tolak-penugasan" class="modal fade" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button><h5 class="modal-title">Alasan ditolak SPI</h5></div><div class="modal-body"><p>'+obj.keterangan_spi+'</p></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div></div></div></div>';
			
				$('html').append(modalTolak);

				$('#alasan-tolak-penugasan').modal({backdrop: 'static', keyboard: false});
				$('#alasan-tolak-penugasan').modal('show');
			}
		});
	}

	Arsip.showAlasanTolakKepala = function (id) {
		$.ajax({
			type: "POST",
			url: "/admin/arsip/getJsonArsip/?v="+Math.random(),
			data: {
				id: id,
				version: Math.random()				
			},
			dataType: 'json',
			success: function(obj){
				var modalTolak = '<div id="alasan-tolak-penugasan" class="modal fade" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button><h5 class="modal-title">Alasan ditolak Kepala</h5></div><div class="modal-body"><p>'+obj.keterangan_kepala+'</p></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div></div></div></div>';
			
				$('html').append(modalTolak);

				$('#alasan-tolak-penugasan').modal({backdrop: 'static', keyboard: false});
				$('#alasan-tolak-penugasan').modal('show');
			}
		});
	}

	Arsip.showAlasanTolakArsip = function (id) {
		$.ajax({
			type: "POST",
			url: "/admin/arsip/getJsonArsip/?v="+Math.random(),
			data: {
				id: id,
				version: Math.random()				
			},
			dataType: 'json',
			success: function(obj){
				var modalTolak = '<div id="alasan-tolak-penugasan" class="modal fade" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button><h5 class="modal-title">Alasan ditolak Petugas Arsip</h5></div><div class="modal-body"><p>'+obj.keterangan_arsip+'</p></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div></div></div></div>';
			
				$('html').append(modalTolak);

				$('#alasan-tolak-penugasan').modal({backdrop: 'static', keyboard: false});
				$('#alasan-tolak-penugasan').modal('show');
			}
		});
	}

	$(document).ready(function () {
		$(document).on("click",'.delete-arsip-item', function () {
			var btn = $(this);
			var lengthRow = $('.table-uraian-arsip tbody tr').length;

			if (lengthRow > 1) {
				Swal.fire({
					title: 'Apakah anda yakin?',
					text: "Data yang telah dihapus tidak bisa dikembalikan lagi!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonText: 'Ya, hapus!',
					cancelButtonText: 'Batal'
				}).then((result) => {
					if (result.value) {
						btn.closest('tr').remove();

						Arsip.resetNoItem();
					}
				});
			}
			else {
				Swal.fire(
					'Peringatan!',
					'Arsip harus memiliki paling sedikit 1 uraian item',
					'warning'
				);
			}
		});

		$(document).on("click",'.duplicate-arsip-item', function () {
			var btn = $(this);
			var tr = btn.closest("tr");
			var valItem = tr.find('.select-item').val();
			var valPerkembangan = tr.find('.select-perkembangan').val();
			var valBerkas = tr.find('.select-berkas').val();

			$('.table-uraian-arsip tbody tr select.select2').select2("destroy");

			var trClone = tr.clone().wrap("tr");
			trClone.find('.select-item').val(valItem);
			trClone.find('.select-perkembangan').val(valPerkembangan);
			trClone.find('.select-berkas').val(valBerkas);
			trClone.end();

			$('.table-uraian-arsip tbody').append(trClone);

			Arsip.resetNoItem();
			Arsip.setSelect2Item();
			Datepicker.init();
		});
	});
</script>
