<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">APPPROVAL LAPORAN</h5>
		</div>
		
		<form action="/admin/spi/terima_laporan_kegiatan" method="post" class="form-submit" autocomplete="off">
			<input type="hidden" name="id" class="form-control kegiatan-id" value="" />
			<div class="modal-body" style="background: #f4f7fa;">
				<div class="card mb-0">
					<div class="card-body">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Kode Arsip (Min 9 Huruf)</label>
									<input type="text" name="kode" id="kode-arsip" class="form-control" value="" />
									<small>Jumlah <span id="kode-arsip-char">0</span> huruf</small>
								</div>
							</div>
						</div>

						<hr class="mb-3" />

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Nama Laporan</label>
									<input type="text" id="nama-kegiatan" name="nama" class="form-control" value="" disabled="disabled" />
								</div>
							</div>
						</div>

						<?php /*<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Tgl Mulai Kegiatan</label>
									<input type="text" id="tgl-mulai-kegiatan" name="nama" class="form-control" value="" disabled="disabled" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Tgl Selesai Kegiatan</label>
									<input type="text" id="tgl-selesai-kegiatan" name="nama" class="form-control" value="" disabled="disabled" />
								</div>
							</div>
						</div>*/ ?>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Pembuat Laporan</label>
									<input type="text" id="pembuat-laporan" name="nama" class="form-control" value="" disabled="disabled" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 arsip-msg">

							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-info btn-modal-form-submit disabled" disabled="disabled">Terima Laporan</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
			</div>
		</form>
	</div>
</div>

<style type="text/css">
	@media (min-width: 768px) {
		.modal-dialog {
			width: 880px;
		}
	}
</style>

<script>
	$(document).ready(function(){

		$('#kode-arsip').on('input', function(){
			this.value = this.value.toUpperCase().trim();

			var jumlahChar = $(this).val().length;

			$("#kode-arsip-char").html(jumlahChar);
		});

		$('#kode-arsip').on('change', function(){
			var jumlahChar = $(this).val().length;
			
			if (jumlahChar >= 9){
				var kodeArsip = $(this).val();

				loadDataArsip(kodeArsip);
			}
		});

		function loadDataArsip(kodeArsip){
			Loader.start();

			$.ajax({
				type: "POST",
				url: "/admin/spi/load_data_arsip/?v="+Math.random(),
				data: {
					kode: kodeArsip,
					version: Math.random()				
				},
				dataType: 'json',
				success: function(obj){
					$('.arsip-msg').html("");
					$('.btn-modal-form-submit').removeAttr("disabled");

					if ('arsip' in obj && 'jenis_berkas' in obj.arsip && (obj.arsip.jenis_berkas == 'Laporan Keuangan dan BMN' || obj.arsip.jenis_berkas == 'Laporan Kegiatan')) {
						if ('nama' in obj.kegiatan) {
							$(".kegiatan-id").val(obj.kegiatan.id);
							$("#nama-kegiatan").val(obj.arsip.nama);
						}
						else {
							$(".kegiatan-id").val("");
							$("#nama-kegiatan").val(obj.arsip.nama);
						}

						if ('nama' in obj.pembuat_laporan) {
							$("#pembuat-laporan").val(obj.pembuat_laporan.nama);
							$('.btn-modal-form-submit').removeClass("disabled").removeAttr("disabled");
						}
						else {
							$("#pembuat-laporan").val("");
							$('.btn-modal-form-submit').addClass("disabled").attr("disabled","disabled");
						}

						if ('status' in obj.arsip && obj.arsip.status == "Divalidasi SPI") {
							html = '<div class="alert alert-danger mt-3">Laporan ini sudah diterima pada tgl <strong>'+obj.arsip.tgl_laporan_diterima_spi+'</strong> oleh <strong>'+obj.petugas_terima_spi.nama+'</strong></div>';
							$('.arsip-msg').html(html);
							$('.btn-modal-form-submit').attr("disabled", "disabled");
						}
						else if ('status' in obj.arsip && (obj.arsip.status != "Baru" && obj.arsip.status != "Divalidasi SPI" && obj.arsip.status != "Ditolak SPI")) {
							html = '<div class="alert alert-danger mt-3">Laporan ini sudah disetujui pada tgl <strong>'+obj.arsip.tgl_laporan_disetujui_spi+'</strong> oleh <strong>'+obj.petugas_setuju_spi.nama+'</strong></div>';
							$('.arsip-msg').html(html);
							$('.btn-modal-form-submit').attr("disabled", "disabled");
						}

						Loader.stop();
				
					}
					else {
						html = '<div class="alert alert-danger mt-3">Arsip '+$('#kode-arsip').val()+' bukan merupakan arsip laporan</div>';
						
						$('.arsip-msg').html(html);
						$('.btn-modal-form-submit').attr("disabled", "disabled");

						$(".kegiatan-id").val("");
						$("#nama-kegiatan").val("");
						$("#pembuat-laporan").val("");

						Loader.stop();
					}
				}
			});
		}

	});
</script>