<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="fa fa-graduation-cap"></i> Approve Widyaiswara</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- [ breadcrumb ] end -->
	<style type="text/css">
		.iframe-laporan iframe { width :100%; border:0; min-height:550px; }
	</style>
	<div class="main-body">
		<div class="page-wrapper">
			<!-- [ Main Content ] start -->
			<div class="row">
				<div class="col-md-12 list-laporan-wi">										
					<?php
						$conditions = array(
							array(
								"field" => "status",
								"operator" => "=",
								"value" => "1"
							)
						);

						$this->bootgrid->setTable("widyaiswara", $conditions);
						$this->bootgrid->setTitle("Approve Widyaiswara");
						$this->bootgrid->sortBy("id");
						$this->bootgrid->sortType("ASC");

						$columns = array();
						$columns[] = array(
							"id" => "id",
							"field" => "id",
							"name" => "ID",
							"type" => "numeric",
							"width" => "5%",
							"identifier" => "true",
							"visible" => "false"
						);
						$columns[] = array(
							"id" => "autonumeric",
							"field" => "autonumeric",
							"name" => "No",
							"type" => "autonumeric",
							"width" => "5%",
							"visible" => "true"
						);

						$columns[] = array(
							"id" => "nama_wi",
							"field" => "user_id",
							"name" => "Nama",
							"visible" => "true",
							"class" => "wraptext",
							"format" => "nama_admin",
							"width" => "15%"
						);

						$columns[] = array(
							"id" => "judul",
							"field" => "judul",
							"name" => "Fasilitasi",
							"visible" => "true",
							"class" => "wraptext",
							"format" => "judul_wi",
							"width" => "40%"
						);

						/*$columns[] = array(
							"id" => "kabupaten",
							"field" => "kab_tempat_kegiatan",
							"name" => "Kab/Kota",
							"visible" => "true"
						);

						$columns[] = array(
							"id" => "tempat",
							"field" => "tempat_kegiatan",
							"name" => "Tempat",
							"visible" => "true",
							"class" => "wraptext"
						);*/

						$columns[] = array(
							"id" => "tgl_kegiatan",
							"field" => "tgl_mulai_kegiatan",
							"name" => "Tgl Kegiatan",
							"format" => "date_range",
							"date_range" => array(
								"start" => "widyaiswara.tgl_mulai_kegiatan",
								"end" => "widyaiswara.tgl_selesai_kegiatan"
							),
							"visible" => "true",
							"class" => "wraptext",
							"width" => "15%"
						);

						$columns[] = array(
							"id" => "jam_pelajaran",
							"field" => "jam_pelajaran",
							"name" => "Jumlah JP",
							"visible" => "true",
							"width" => "10%"
						);
						$columns[] = array(
							"id" => "total_jam_pelajaran",
							"field" => "total_jam_pelajaran",
							"name" => "Akumulasi JP",
							"visible" => "true",
							"width" => "10%"
						);
						$columns[] = array(
							"id" => "kelebihan_jam_pelajaran",
							"field" => "kelebihan_jam_pelajaran",
							"name" => "Kelebihan JP",
							"visible" => "true",
							"class" => "text_right",
							"width" => "10%"
						);
						
						$columns[] = array(
							"id" => "preview",
							"field" => "widyaiswara.id",
							"name" => "Laporan",
							"format" => "button",
							"button" => array(
								"text" => '<i class="fab fa-sistrix mr-0" title="Preview"></i> Lihat'
							),
							"modal" => array(
								"view" => "backend/widyaiswara/modal_approve_laporan"
							),
							"width" => "5%"
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

						$this->bootgrid->setColumns($columns);

						$this->bootgrid->setRowCount();

						print $this->bootgrid->render();
					?>
				</div>
			</div>
			<!-- [ Main Content ] end -->
		</div>
	</div>
<?php $this->load->view("backend/includes/footer"); ?>

<script type="text/javascript">
	$(document).ready(function () {
		var LaporanWI = {};

		LaporanWI.submitLaporan = function (data) {
			Loader.start();
					
			$.ajax({
				url: "/admin/widyaiswara/save/",
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,
				data: data,                        
				type: 'post',
				success: function(obj){
					var tableId = $('.list-laporan-wi').find('.card').attr('id').replace('-card','');
					$('#'+tableId+'-header .btn[title="Refresh"]').click();

					if (obj.error) {
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							text: obj.msg
						});
					}
					else {

						if (obj.close_modal) {
							$('.modal').modal('hide');

							Swal.fire({
								icon: 'success',
								title: 'Sukses...',
								text: obj.msg,
								showConfirmButton: true,
							});
						}
					}

					Loader.stop();
				}
			});
		}

		var submitButtonValue; // Variable to store the value

		$(document).on('click','[name="submit_btn"]', function () {
			submitButtonValue = $(this).val();
		});

		$(document).on('submit','.submit-laporan-wi', function () {

			var form = $(this).serializeArray();
			var bukti_dokumen = $('.bukti_dokumen').prop('files')[0];
			
			var data = new FormData();
			
			$.each(form, function (i, val) {
				data.append(val.name, val.value);
			});

			if ($('.bukti_dokumen').length) {
				data.append('bukti_dokumen', bukti_dokumen);
			}

			data.append('submit_btn', submitButtonValue);
			
			if (submitButtonValue == "validasi") {
				Swal.fire({
					text: 'Apakah anda yakin mengirim laporan ini untuk validasi?',
					title: 'Kirim Laporan',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonText: 'Kirim Laporan',
					cancelButtonText: 'Batal'
				}).then((result) => {
					if (result.value) {
						LaporanWI.submitLaporan(data);
					}
				});
			}
			else {
				LaporanWI.submitLaporan(data);
			}
			
			return false;
		});
	});
</script>