<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">JILID LAPORAN</h5>
		</div>
		
		<form action="/admin/arsip/terima_laporan_kegiatan_jilid" method="post" class="form-submit" autocomplete="off">
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

						
						if ('status' in obj.arsip && obj.arsip.status == "Proses Jilid") {
							html = '<div class="alert alert-danger mt-3">Laporan ini sudah diterima jilid tgl <strong>'+obj.arsip.tgl_laporan_diterima_jilid+'</strong> oleh <strong>'+obj.petugas_terima_jilid.nama+'</strong></div>';
							$('.arsip-msg').html(html);
							$('.btn-modal-form-submit').attr("disabled", "disabled");
						}

						else if ('status' in obj.arsip && (obj.arsip.status == "Baru" || obj.arsip.status == "Divalidasi SPI" || obj.arsip.status == "Ditolak SPI" || obj.arsip.status == "Divalidasi Kepala" || obj.arsip.status == "Ditolak Kepala")) {
							html = '<div class="alert alert-danger mt-3">Laporan ini belum disetujui Kepala</div>';
							$('.arsip-msg').html(html);
							$('.btn-modal-form-submit').attr("disabled", "disabled");
						}

						else if ('status' in obj.arsip && (obj.arsip.status != "Disetujui SPI" && obj.arsip.status != "Disetujui Kepala" && obj.arsip.status != "Proses Jilid")) {
							html = '<div class="alert alert-danger mt-3">Laporan ini sudah selesai jilid pada tgl <strong>'+obj.arsip.tgl_laporan_selesai_jilid+'</strong> oleh <strong>'+obj.petugas_selesai_jilid.nama+'</strong></div>';
							$('.arsip-msg').html(html);
							$('.btn-modal-form-submit').attr("disabled", "disabled");
						}

						Loader.stop();
				
					}
					else if ('arsip' in obj && 'jenis_berkas' in obj.arsip && obj.arsip.jenis_berkas == 'Pengadaan Barang dan Jasa') {
						$(".kegiatan-id").val("");
						$("#nama-kegiatan").val(obj.arsip.nama);

						if ('nama' in obj.pembuat_laporan) {
							$("#pembuat-laporan").val(obj.pembuat_laporan.nama);
							$('.btn-modal-form-submit').removeClass("disabled").removeAttr("disabled");
						}
						else {
							$("#pembuat-laporan").val("");
							$('.btn-modal-form-submit').addClass("disabled").attr("disabled","disabled");
						}

						if ('status' in obj.arsip && obj.arsip.status == "Proses Jilid") {
							html = '<div class="alert alert-danger mt-3">Kontrak Pengadaan Barang dan Jasa ini sudah diterima jilid tgl <strong>'+obj.arsip.tgl_laporan_diterima_jilid+'</strong> oleh <strong>'+obj.petugas_terima_jilid.nama+'</strong></div>';
							$('.arsip-msg').html(html);
							$('.btn-modal-form-submit').attr("disabled", "disabled");
						}
						else if ('status' in obj.arsip && obj.arsip.status == "Baru") {
							$('.arsip-msg').html("");
							$('.btn-modal-form-submit').removeAttr("disabled");
						}
						else {
							html = '<div class="alert alert-danger mt-3">Kontrak Pengadaan Barang dan Jasa ini sudah dijilid tgl <strong>'+obj.arsip.tgl_laporan_selesai_jilid+'</strong> oleh <strong>'+obj.petugas_selesai_jilid.nama+'</strong></div>';
							$('.arsip-msg').html(html);
							$('.btn-modal-form-submit').attr("disabled", "disabled");
						}

						Loader.stop();
					}
					else {
						html = '<div class="alert alert-danger mt-3">Arsip '+$('#kode-arsip').val()+' tidak untuk dijilid</div>';
						
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