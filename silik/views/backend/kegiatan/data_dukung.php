<?php $this->load->view("backend/includes/header"); ?>
<?php $this->load->view("backend/kegiatan/header"); ?>
<?php $this->load->view("backend/kegiatan/menu"); ?>

<?php
	$dakungs = array(
		"Surat Keputusan" => "Surat Keputusan",
		"Prosedur Operasional" => "Prosedur Operasional",
		"Surat Undangan" => "Surat Undangan",
		"Surat Tugas" => "Surat Tugas",
		"Notula" => "Notula, Materi, Daftar Hadir Dll",
		"Laporan" => "Laporan",
		"Bukti Pembayaran" => "Bukti Pembayaran & Pajak",
	);
?>

<div class="main-body">
	<div class="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h5 class="bootgrid-title">DATA DUKUNG</h5>
						<input type="hidden" name="kegiatan_id" value="<?php print $kegiatan["id"]; ?>" />
					</div>
					<div class="card-body">
						<div class="bootgrid-header">
							<div class="row">
								<div class="col-md-12 actionBar">
									<a class="bootgrid-add-btn btn btn-info btn-add-dakung" data-kegiatan="<?php print $kegiatan["id"]; ?>">Tambah</a>
								</div>
							</div>
						</div>
						<div class="wrap-table-bootgrid wrap-table-dakung">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="modal-data-dukung"></div>

<?php $this->load->view("backend/includes/footer"); ?>
<script type="text/javascript">
	var Dakung = {};

	Dakung.init = function () {
		$('.btn-add-dakung').click(function () {
			var kegiatannId = $(this).attr("data-kegiatan");
			Loader.start();

			$.ajax({
				type: "POST",
				url: "/admin/kegiatan/formUploadDakung/?v="+Math.random(),
				data: {
					kegiatan_id: kegiatannId,
					version: Math.random()				
				},
				dataType: 'html',
				success: function(html){
					Loader.stop();

					$('#modal-data-dukung').html(html);
					Select2.init();

					$('#modal-dakung').modal("show");
				}
			});
		});

		$(document).on("submit", ".form-dakung", function (e) {
			e.preventDefault();
			Loader.start();

			var form_data = new FormData($(this)[0]);
			
			$.ajax({
				type: "POST",
				url: "/admin/kegiatan/uploadDakung/?v="+Math.random(),
				data: form_data,
				processData: false,
    			contentType: false,
				dataType: 'html',
				success: function(html){
					$('#modal-dakung').modal("hide");
					Loader.stop();

					Dakung.loadTable();
				}
			});
		});

		$(document).on("click", ".view-dokumen", function () {
			var id = $(this).attr("data-id");
			var table = $(this).attr("data-table");
			var modal = $(this).attr("data-modal-view");

			Loader.start();

			$.ajax({
				type: "POST",
				url: "/bootgrids/loadModalForm/?v="+Math.random(),
				data: {
					id: id,
					table: table,
					view: modal,
					version: Math.random()				
				},
				dataType: 'html',
				success: function(html){
					Loader.stop();

					$("body").append(html);
					$('#modal-view-dakung').modal("show");
				}
			});
		});

		$(document).on("click", '.delete-dakung', function () {
			var id = $(this).attr("data-id");
		
			Swal.fire({
				title: 'Apakah anda yakin?',
				text: "File yang telah dihapus tidak bisa dikembalikan lagi!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Ya, hapus!',
				cancelButtonText: 'Batal'
			}).then((result) => {
				if (result.value) {
					Loader.start();
					
					$.ajax({
						type: "POST",
						url: "/admin/kegiatan/deleteDakung/",
						data: {
							id: id,
							version: Math.random()				
						},
						dataType: 'json',
						success: function(obj){
							Loader.stop();
							
							if (obj.error) {
								Swal.fire(
									'Gagal!',
									'Gagal menghapus file.',
									'error'
								);
							}
							else {
								Swal.fire(
									'Berhasil!',
									'File telah dihapus.',
									'success'
								);
								
								Dakung.loadTable();
							}
						}
					});
				}
			})
		});

		Dakung.loadTable();
	}

	Dakung.loadTable = function () {
		Loader.start();
		var kegiatanId = $('[name="kegiatan_id"]').val();

		$.ajax({
			type: "POST",
			url: "/admin/kegiatan/dakungList/?v="+Math.random(),
			data: {
				kegiatanId: kegiatanId,
				version: Math.random()				
			},
			dataType: 'html',
			success: function(html){
				$('.wrap-table-dakung').html(html);

				Loader.stop();
			}
		});
	}

	$(document).ready(function () {
		Dakung.init();
	});
</script>
