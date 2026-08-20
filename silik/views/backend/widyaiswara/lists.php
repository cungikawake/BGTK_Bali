<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="fa fa-graduation-cap"></i> Widyaiswara</h5>
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
				<div class="col-md-12 list-laporan-wi">										
					<?php
						$conditions = array(
							array(
								"field" => "user_id",
								"operator" => "=",
								"value" => $_SESSION["user"]["id"]
							)
						);

						$this->bootgrid->setTable("widyaiswara", $conditions);
						$this->bootgrid->setTitle("Widyaiswara");
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
							"id" => "judul",
							"field" => "judul",
							"name" => "Judul",
							"visible" => "true",
							"width" => "200px",
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
							"width" => "10%"
						);

						$columns[] = array(
							"id" => "jam_pelajaran",
							"field" => "jam_pelajaran",
							"name" => "Jumlah JP",
							"visible" => "true",
							"width" => "5%"
						);
						$columns[] = array(
							"id" => "total_jam_pelajaran",
							"field" => "total_jam_pelajaran",
							"name" => "Akumulasi JP",
							"visible" => "true",
							"width" => "5%"
						);
						$columns[] = array(
							"id" => "kelebihan_jam_pelajaran",
							"field" => "kelebihan_jam_pelajaran",
							"name" => "Kelebihan JP",
							"visible" => "true",
							"class" => "text_right",
							"width" => "5%"
						);

						$columns[] = array(
							"id" => "bukti_dokumen",
							"field" => "status",
							"name" => "Bukti",
							"visible" => "true",
							"width" => "10%",
							"format" => "laporan_wi"
						);

						$columns[] = array(
							"id" => "status",
							"field" => "status",
							"name" => "Status",
							"format" => "status_laporan_wi",
							"visible" => "true",
							"width" => "10%"
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
					
						$addButton = array(
							"text" => "<i class='fas fa-plus mr-0'></i>",
							"modal" => array(
								"view" => "backend/widyaiswara/modal_edit"
							)
						); 
						$this->bootgrid->setAddButton($addButton);
						
						$editButton = array(
							"text" => '<i class="fas fa-edit mr-0"></i>',
							"modal" => array(
								"view" => "backend/widyaiswara/modal_edit"
							),
							"conditions" => array(
								array(
									"field" => "status",
									"operator" => "!=",
									"value" => 1
								),
								array(
									"field" => "status",
									"operator" => "!=",
									"value" => 2
								)
							)
						);
						$this->bootgrid->setEditButton($editButton);
					
						$deleteButton = array(
							"text" => '<i class="fas fa-trash-alt mr-0"></i>',
							"conditions" => array(
								array(
									"field" => "status",
									"operator" => "!=",
									"value" => 1
								),
								array(
									"field" => "status",
									"operator" => "!=",
									"value" => 2
								)
							)
						);
						$this->bootgrid->setDeleteButton($deleteButton);
						

						$this->bootgrid->setCustomFilter("bulan");

						$total = array(
							"index_text" => "autonumeric",
							"column_sum" => array("jam_pelajaran","total_jam_pelajaran","kelebihan_jam_pelajaran")
						);

						//$this->bootgrid->setRowTotal($total);

						$this->bootgrid->setRowCount('-1');

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
			
			var data = new FormData();
			
			$.each(form, function (i, val) {
				data.append(val.name, val.value);
			});

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