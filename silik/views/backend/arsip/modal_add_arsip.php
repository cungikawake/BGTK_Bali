<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">TAMBAH ARSIP BARU</h5>
		</div>
		
		<form action="/admin/arsip/tambah_arsip" method="post" class="form-submit" autocomplete="off">
			<input type="hidden" name="id" class="form-control arsip-id" value="" />
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
									<label>Nama Arsip</label>
									<input type="text" id="nama-arsip" name="nama" class="form-control" value="" disabled="disabled" />
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Program</label>
									<input type="text" id="nama-program" name="nama" class="form-control" value="" disabled="disabled" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Jenis Arsip</label>
									<input type="text" id="jenis-arsip" name="nama" class="form-control" value="" disabled="disabled" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Pembuat Arsip</label>
									<input type="text" id="pembuat-arsip" name="nama" class="form-control" value="" disabled="disabled" />
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
				<button type="submit" class="btn btn-info btn-modal-form-submit disabled" disabled="disabled">Tambah Arsip</button>
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
				url: "/admin/arsip/load_data_arsip/?v="+Math.random(),
				data: {
					kode: kodeArsip,
					version: Math.random()				
				},
				dataType: 'json',
				success: function(obj){
					$('.arsip-msg').html("");

					if ('nama' in obj.arsip) {
						$(".arsip-id").val(obj.arsip.id);
						$("#nama-arsip").val(obj.arsip.nama);
						$("#nama-program").val(obj.arsip.program);
						$("#jenis-arsip").val(obj.arsip.jenis_berkas);
						$("#pembuat-arsip").val(obj.pembuat_arsip.nama);

						$('.btn-modal-form-submit').removeClass("disabled").removeAttr("disabled");
					}
					else {
						$(".arsip-id").val("");
						$("#nama-arsip").val("");
						$("#nama-program").val("");
						$("#jenis-arsip").val("");
						$("#pembuat-arsip").val("");

						html = '<div class="alert alert-danger mt-3">Arsip tidak ditemukan </div>';
						$('.arsip-msg').html(html);

						$('.btn-modal-form-submit').addClass("disabled").attr("disabled","disabled");
					}

					if ('status' in obj.arsip && (obj.arsip.status == "Divalidasi Arsiparis" || obj.arsip.status == "Ditolak Arsiparis" || obj.arsip.status == "Dipinjam" || obj.arsip.status == "Diarsipkan")) {
						html = '<div class="alert alert-danger mt-3">Arsip ini sudah ditambahkan </div>';
						$('.arsip-msg').html(html);
						$('.btn-modal-form-submit').addClass("disabled").attr("disabled","disabled");
					}

					if ('jenis_berkas' in obj.arsip && (obj.arsip.jenis_berkas == "Laporan Kegiatan" || obj.arsip.jenis_berkas == "Laporan Keuangan dan BMN") && (obj.arsip.status == "Baru" || obj.arsip.status == "Divalidasi SPI" || obj.arsip.status == "Ditolak SPI" || obj.arsip.status == "Disetujui SPI" || obj.arsip.status == "Divalidasi Kepala" || obj.arsip.status == "Ditolak Kepala" || obj.arsip.status == "Disetujui Kepala" || obj.arsip.status == "Proses Jilid")) {
						html = '<div class="alert alert-danger mt-3">Laporan kegiatan ini belum dijilid, belum bisa ditambahkan ke arsip</strong></div>';
						$('.arsip-msg').html(html);
						$('.btn-modal-form-submit').addClass("disabled").attr("disabled","disabled");
					}

					Loader.stop();
				}
			});
		}

	});
</script>