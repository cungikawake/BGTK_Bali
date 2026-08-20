
<script src="<?php print base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?php print base_url('assets/js/pcoded.min.js'); ?>"></script>
<script src="<?php print base_url('assets/plugins/bootgrid/jquery.bootgrid.min.js'); ?>"></script>
<script src="<?php print base_url('assets/plugins/sweetalert/dist/sweetalert2.all.min.js'); ?>"></script>
<script src="<?php print base_url('assets/plugins/autoNumeric/autoNumeric.js'); ?>"></script>
<script src="<?php print base_url('assets/plugins/select2/select2.js'); ?>"></script>
<script src="<?php print base_url('assets/plugins/datepicker/js/bootstrap-datepicker.min.js'); ?>"></script>
<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
<script src="<?php print base_url('assets/plugins/signaturePad/signature-pad.js'); ?>"></script>
<script src="<?php print base_url('assets/js/script.js'); ?>"></script>
<script type="text/javascript">
	var Biodata = {};
	var Dropzone = function() {};
	
	Biodata.siganturePad = function() {};
	
	Biodata.setDropzone = function () {
		if ($('#dropzone-surat-tugas').length) {
			var form = $('.form-submit-registrasi');
			
			$("#dropzone-surat-tugas").dropzone({ 
				url: "/kegiatan/registrasi_save/?v"+Math.random(),
				paramName: "surat_tugas", // The name that will be used to transfer the file
				maxFilesize: 3, // MB
				autoProcessQueue: false,
				acceptedFiles: '.jpg,.jpeg,.pdf,.png',
				addRemoveLinks: true,
				parallelUploads: 10,
				uploadMultiple: false,
				maxFiles: 1,
				init: function() {
					Dropzone = this;

					Dropzone.on('sending', function(file, xhr, formData){
						var formFields = form.serializeArray();
						
						$.each(formFields, function(index, field) {
							formData.append(field.name, field.value);
						});
					});

					Dropzone.on("success", function(file, xhr) {
						Dropzone.removeFile(file);
						Biodata.stopLoader();
						
						var res = JSON.parse(xhr);
						$('.card').html(res.html);
					});
				},
			});
		}
	}
	
	Biodata.init = function () {
		// Golongan Dan Pangkat
		$('[name="golongan"]').change(function () {
			var pangkat = $(this).find(":selected").data('pangkat');
			$('[name="pangkat"]').val(pangkat);
		});
		
		// Menghitung NIK
		$('[name="nik"]').on('keyup', function(e) {
			var jmlh_char = this.value.length;
			var nik = $(this).val();
			
			$('.hitung-digit').text(jmlh_char);
			
			if (e.keyCode != 17) {
				if (jmlh_char == 16) { // KTP
					Biodata.findByNIK(nik);
				}
			}
		});
		
		// Menangkap NIK Jika Copy Paste
		$('[name="nik"]').on('paste', function (e) {
			if (e.originalEvent.clipboardData) {
				var text = e.originalEvent.clipboardData.getData("text/plain");
				$('[name="nik"]').val(text).keyup();
			}
		});
		
		
		// Only Number
		$('[name="no_rekening"]').on('keypress', function(e) {
			if(e.which < 48 || e.which > 58){
				return false;
			}
		});
		
		// Menangkap NIK Jika Copy Paste
		$('[name="no_rekening"]').on('paste', function (e) {
			if (e.originalEvent.clipboardData.getData('Text').match(/[^\d]/)) {
				e.preventDefault();
			}
		});
		
		
		// Provinsi
		$('[name="provinsi_unit_kerja"]').on("change", function(e) { 
			var provinsi = $(this).val();
			var kabupaten = Biodata.kabupatenProvinsi(provinsi);
			var data = [];
			data.push({id:0,text:''});
			
			$('[name="kab_unit_kerja"]').empty().trigger("change");
			
			if (kabupaten.length > 0) {
				var data = [];
				data.push({id:'',text:''});
				
				$.each(kabupaten, function (i, kab) {
					data.push({id:kab,text:kab});
				});
			}
			$('[name="kab_unit_kerja"]').select2({data:data});
			
		}).trigger('change');
		
		
		// Set Dropzone
		Biodata.setDropzone();
		
		
		// Submit Form
		$(document).on("submit","form.form-submit-registrasi",function (e) {
			e.preventDefault();
			
			// Validasi
			var jabatan = $('[name="jabatan"]').val();

			if (jabatan.length <= 3) {
				Swal.fire(
					'Perhatian!',
					'Mohon mengisi <strong>Jabatan</strong> dengan benar',
					'warning'
				).then((result) => {
					$('html, body').animate({
						scrollTop: $('[name="jabatan"]').offset().top-200
					}, 500, function(){$('[name="jabatan"]').focus();});
				});

				return false;
			}

			var alamatRumah = $('[name="alamat_tinggal"]').val();

			if (alamatRumah.length <= 20) {
				Swal.fire(
					'Perhatian!',
					'Mohon mengisi <strong>Alamat Rumah</strong> lebih lengkap',
					'warning'
				).then((result) => {
					$('html, body').animate({
						scrollTop: $('[name="alamat_tinggal"]').offset().top-200
					}, 500, function(){$('[name="alamat_tinggal"]').focus();});
				});

				return false;
			}
			
			var unitKerja = $('[name="unit_kerja"]').val();
			
			if (unitKerja.length <= 5) {
				Swal.fire(
					'Perhatian!',
					'Mohon mengisi <strong>Nama Unit Kerja/Sekolah</strong> dengan benar',
					'warning'
				).then((result) => {
					$('html, body').animate({
						scrollTop: $('[name="unit_kerja"]').offset().top-200
					}, 500, function(){$('[name="unit_kerja"]').focus();});
				});

				return false;
			}
			
			var alamatKantor = $('[name="alamat_unit_kerja"]').val();

			if (alamatKantor.length <= 20) {
				Swal.fire(
					'Perhatian!',
					'Mohon mengisi <strong>Alamat Unit Kerja/Sekolah</strong> lebih lengkap',
					'warning'
				).then((result) => {
					$('html, body').animate({
						scrollTop: $('[name="alamat_unit_kerja"]').offset().top-200
					}, 500, function(){$('[name="alamat_unit_kerja"]').focus();});
				});

				return false;
			}
			
			//
			if ($('#dropzone-surat-tugas').length && $('#dropzone-surat-tugas').hasClass("required")) {
				if (Dropzone.getQueuedFiles().length <= 0) {
					Swal.fire(
						'Perhatian!',
						'Mohon mengupload <strong>Surat Tugas</strong>',
						'warning'
					).then((result) => {
						$('html, body').animate({
							scrollTop: $('#dropzone-surat-tugas').offset().top-200
						}, 500, function(){$('#dropzone-surat-tugas').focus();});
					});

					return false;
				}
			}
			
			// handle ttd
			if ($('#signature-pad').length) {
				var sign = Biodata.siganturePad.toDataURL();
				
				if (sign == "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAArAAAADVCAYAAACv4sN2AAAAAXNSR0IArs4c6QAAC+dJREFUeF7t1kENAAAMArHh3/R0XNIpIB0Pdo4AAQIECBAgQIBASGChrKISIECAAAECBAgQOANWCQgQIECAAAECBFICBmzqXcISIECAAAECBAgYsDpAgAABAgQIECCQEjBgU+8SlgABAgQIECBAwIDVAQIECBAgQIAAgZSAAZt6l7AECBAgQIAAAQIGrA4QIECAAAECBAikBAzY1LuEJUCAAAECBAgQMGB1gAABAgQIECBAICVgwKbeJSwBAgQIECBAgIABqwMECBAgQIAAAQIpAQM29S5hCRAgQIAAAQIEDFgdIECAAAECBAgQSAkYsKl3CUuAAAECBAgQIGDA6gABAgQIECBAgEBKwIBNvUtYAgQIECBAgAABA1YHCBAgQIAAAQIEUgIGbOpdwhIgQIAAAQIECBiwOkCAAAECBAgQIJASMGBT7xKWAAECBAgQIEDAgNUBAgQIECBAgACBlIABm3qXsAQIECBAgAABAgasDhAgQIAAAQIECKQEDNjUu4QlQIAAAQIECBAwYHWAAAECBAgQIEAgJWDApt4lLAECBAgQIECAgAGrAwQIECBAgAABAikBAzb1LmEJECBAgAABAgQMWB0gQIAAAQIECBBICRiwqXcJS4AAAQIECBAgYMDqAAECBAgQIECAQErAgE29S1gCBAgQIECAAAEDVgcIECBAgAABAgRSAgZs6l3CEiBAgAABAgQIGLA6QIAAAQIECBAgkBIwYFPvEpYAAQIECBAgQMCA1QECBAgQIECAAIGUgAGbepewBAgQIECAAAECBqwOECBAgAABAgQIpAQM2NS7hCVAgAABAgQIEDBgdYAAAQIECBAgQCAlYMCm3iUsAQIECBAgQICAAasDBAgQIECAAAECKQEDNvUuYQkQIECAAAECBAxYHSBAgAABAgQIEEgJGLCpdwlLgAABAgQIECBgwOoAAQIECBAgQIBASsCATb1LWAIECBAgQIAAAQNWBwgQIECAAAECBFICBmzqXcISIECAAAECBAgYsDpAgAABAgQIECCQEjBgU+8SlgABAgQIECBAwIDVAQIECBAgQIAAgZSAAZt6l7AECBAgQIAAAQIGrA4QIECAAAECBAikBAzY1LuEJUCAAAECBAgQMGB1gAABAgQIECBAICVgwKbeJSwBAgQIECBAgIABqwMECBAgQIAAAQIpAQM29S5hCRAgQIAAAQIEDFgdIECAAAECBAgQSAkYsKl3CUuAAAECBAgQIGDA6gABAgQIECBAgEBKwIBNvUtYAgQIECBAgAABA1YHCBAgQIAAAQIEUgIGbOpdwhIgQIAAAQIECBiwOkCAAAECBAgQIJASMGBT7xKWAAECBAgQIEDAgNUBAgQIECBAgACBlIABm3qXsAQIECBAgAABAgasDhAgQIAAAQIECKQEDNjUu4QlQIAAAQIECBAwYHWAAAECBAgQIEAgJWDApt4lLAECBAgQIECAgAGrAwQIECBAgAABAikBAzb1LmEJECBAgAABAgQMWB0gQIAAAQIECBBICRiwqXcJS4AAAQIECBAgYMDqAAECBAgQIECAQErAgE29S1gCBAgQIECAAAEDVgcIECBAgAABAgRSAgZs6l3CEiBAgAABAgQIGLA6QIAAAQIECBAgkBIwYFPvEpYAAQIECBAgQMCA1QECBAgQIECAAIGUgAGbepewBAgQIECAAAECBqwOECBAgAABAgQIpAQM2NS7hCVAgAABAgQIEDBgdYAAAQIECBAgQCAlYMCm3iUsAQIECBAgQICAAasDBAgQIECAAAECKQEDNvUuYQkQIECAAAECBAxYHSBAgAABAgQIEEgJGLCpdwlLgAABAgQIECBgwOoAAQIECBAgQIBASsCATb1LWAIECBAgQIAAAQNWBwgQIECAAAECBFICBmzqXcISIECAAAECBAgYsDpAgAABAgQIECCQEjBgU+8SlgABAgQIECBAwIDVAQIECBAgQIAAgZSAAZt6l7AECBAgQIAAAQIGrA4QIECAAAECBAikBAzY1LuEJUCAAAECBAgQMGB1gAABAgQIECBAICVgwKbeJSwBAgQIECBAgIABqwMECBAgQIAAAQIpAQM29S5hCRAgQIAAAQIEDFgdIECAAAECBAgQSAkYsKl3CUuAAAECBAgQIGDA6gABAgQIECBAgEBKwIBNvUtYAgQIECBAgAABA1YHCBAgQIAAAQIEUgIGbOpdwhIgQIAAAQIECBiwOkCAAAECBAgQIJASMGBT7xKWAAECBAgQIEDAgNUBAgQIECBAgACBlIABm3qXsAQIECBAgAABAgasDhAgQIAAAQIECKQEDNjUu4QlQIAAAQIECBAwYHWAAAECBAgQIEAgJWDApt4lLAECBAgQIECAgAGrAwQIECBAgAABAikBAzb1LmEJECBAgAABAgQMWB0gQIAAAQIECBBICRiwqXcJS4AAAQIECBAgYMDqAAECBAgQIECAQErAgE29S1gCBAgQIECAAAEDVgcIECBAgAABAgRSAgZs6l3CEiBAgAABAgQIGLA6QIAAAQIECBAgkBIwYFPvEpYAAQIECBAgQMCA1QECBAgQIECAAIGUgAGbepewBAgQIECAAAECBqwOECBAgAABAgQIpAQM2NS7hCVAgAABAgQIEDBgdYAAAQIECBAgQCAlYMCm3iUsAQIECBAgQICAAasDBAgQIECAAAECKQEDNvUuYQkQIECAAAECBAxYHSBAgAABAgQIEEgJGLCpdwlLgAABAgQIECBgwOoAAQIECBAgQIBASsCATb1LWAIECBAgQIAAAQNWBwgQIECAAAECBFICBmzqXcISIECAAAECBAgYsDpAgAABAgQIECCQEjBgU+8SlgABAgQIECBAwIDVAQIECBAgQIAAgZSAAZt6l7AECBAgQIAAAQIGrA4QIECAAAECBAikBAzY1LuEJUCAAAECBAgQMGB1gAABAgQIECBAICVgwKbeJSwBAgQIECBAgIABqwMECBAgQIAAAQIpAQM29S5hCRAgQIAAAQIEDFgdIECAAAECBAgQSAkYsKl3CUuAAAECBAgQIGDA6gABAgQIECBAgEBKwIBNvUtYAgQIECBAgAABA1YHCBAgQIAAAQIEUgIGbOpdwhIgQIAAAQIECBiwOkCAAAECBAgQIJASMGBT7xKWAAECBAgQIEDAgNUBAgQIECBAgACBlIABm3qXsAQIECBAgAABAgasDhAgQIAAAQIECKQEDNjUu4QlQIAAAQIECBAwYHWAAAECBAgQIEAgJWDApt4lLAECBAgQIECAgAGrAwQIECBAgAABAikBAzb1LmEJECBAgAABAgQMWB0gQIAAAQIECBBICRiwqXcJS4AAAQIECBAgYMDqAAECBAgQIECAQErAgE29S1gCBAgQIECAAAEDVgcIECBAgAABAgRSAgZs6l3CEiBAgAABAgQIGLA6QIAAAQIECBAgkBIwYFPvEpYAAQIECBAgQMCA1QECBAgQIECAAIGUgAGbepewBAgQIECAAAECBqwOECBAgAABAgQIpAQM2NS7hCVAgAABAgQIEDBgdYAAAQIECBAgQCAlYMCm3iUsAQIECBAgQICAAasDBAgQIECAAAECKQEDNvUuYQkQIECAAAECBAxYHSBAgAABAgQIEEgJGLCpdwlLgAABAgQIECBgwOoAAQIECBAgQIBASsCATb1LWAIECBAgQIAAAQNWBwgQIECAAAECBFICBmzqXcISIECAAAECBAgYsDpAgAABAgQIECCQEjBgU+8SlgABAgQIECBAwIDVAQIECBAgQIAAgZSAAZt6l7AECBAgQIAAAQIGrA4QIECAAAECBAikBAzY1LuEJUCAAAECBAgQMGB1gAABAgQIECBAICVgwKbeJSwBAgQIECBAgIABqwMECBAgQIAAAQIpAQM29S5hCRAgQIAAAQIEDFgdIECAAAECBAgQSAkYsKl3CUuAAAECBAgQIGDA6gABAgQIECBAgEBKwIBNvUtYAgQIECBAgAABA1YHCBAgQIAAAQIEUgIGbOpdwhIgQIAAAQIECBiwOkCAAAECBAgQIJASeI92ANYVskDgAAAAAElFTkSuQmCC") {
					Swal.fire(
						'Perhatian!',
						'Mohon mengisi <strong>Tanda Tangan</strong> dengan benar',
						'warning'
					).then((result) => {
						$('html, body').animate({
							scrollTop: $('#signature-pad').offset().top-200
						}, 500, function(){$('#signature-pad').focus();});
					});

					return false;	
				}
			}
			
			
			
			Biodata.stopLoader();
			Biodata.saveLoader();
			
			// handle ttd
			if ($('#signature-pad').length) {
				Biodata.siganturePad.removeBlanks();
				$('.signature-data').val(Biodata.siganturePad.toDataURL());
			}
			
			var dropzoneHandle = false;
			
			if ($('#dropzone-surat-tugas').length) {
				if (Dropzone.getQueuedFiles().length > 0) {
					dropzoneHandle = true;
				}
			}
			
			if (dropzoneHandle) {
				Dropzone.processQueue();	
			}
			else {
				var url = window.location.href;
				var action = $(this).attr('action');
				var data = $(this).serialize();
				var form = $(this);

				if (typeof action === typeof undefined && action === false) {
					action = url;
				}

				$.ajax({
					type: "POST",
					url: action,
					data: data,
					dataType: 'json',
					success: function(obj){
						Biodata.stopLoader();

						if (obj.error) {
							Swal.fire(
								'Gagal!',
								obj.msg,
								'error'
							);
						}
						else {
							$('.card').html(obj.html);
						}
					}
				});
			}
		});	
		
		if ($('#signature-pad').length) {
			var wrapper = document.getElementById("signature-pad");
			var clearButton = wrapper.querySelector("[data-action=clear]");
			var canvas = wrapper.querySelector("canvas");
			
			Biodata.siganturePad = new SignaturePad(canvas, {
			  penColor: "rgb(2, 2, 2)"
			});
			
			Biodata.siganturePad.off();
			
			function resizeCanvas() {
			  var ratio =  Math.max(window.devicePixelRatio || 1, 1);

			  // This part causes the canvas to be cleared
			  canvas.width = canvas.offsetWidth * ratio;
			  canvas.height = canvas.offsetHeight * ratio;
			  canvas.getContext("2d").scale(ratio, ratio);
			  Biodata.siganturePad.clear();
			}
			
			window.onresize = resizeCanvas;
			resizeCanvas();
			
			clearButton.addEventListener("click", function (event) {
				Biodata.siganturePad.clear();
			});
		}
	}
	
	Biodata.stopLoader = function () {
		$(".loader").remove();
	}
	
	Biodata.startLoader = function () {
		Biodata.stopLoader();
		
		$("body").append('<div class="loader"><div class="loader-wrap"><div class="loader-image"><img src="/assets/images/loader.gif?v=12" width="100" /></div><div class="loader-text">LOADING DATA...</div></div></div>');
	}
	
	Biodata.saveLoader = function () {
		Biodata.stopLoader();
		
		$("body").append('<div class="loader"><div class="loader-wrap"><div class="loader-image"><img src="/assets/images/loader.gif?v=12" width="100" /></div><div class="loader-text">SAVING DATA...</div></div></div>');
	}
	
	Biodata.provinsi = function () {
		var provinsi = [];
		
		<?php
			foreach ($this->config->item("provinsi") as $provinsi => $kabupaten) {
				print "provinsi.push('".$provinsi."');";
			}
		?>
		
		return provinsi;
	}
	
	Biodata.kabupatenProvinsi = function (provinsi) {
		var items = [];
		provinsi = typeof provinsi !== 'undefined' ? provinsi : $_ENV['DEFAULT_PROVINSI'];
		var kabupaten = [];
		
		<?php
			foreach ($this->config->item("provinsi") as $provinsi => $kabupaten) {
				print "var item = [];";
				
				foreach ($kabupaten as $foo) {
					print "item.push('".$foo."');";
				}
				
				print "items.push({'".$provinsi."':item});";
			}
		?>
		
		if (items.length > 0) {
			$.each(items, function (i, provs) {
				$.each(provs, function (prov, kabs) {
					if (prov == provinsi) {
						kabupaten = kabs;
					}
				});
			});	
		}
		
		return kabupaten;
	}
	
	Biodata.findByNIK = function (nik) {
		
		Biodata.startLoader();
		
		$.ajax({
			type: "POST",
			url: "/admin/biodata/getDetailByNik",
			data: {
				version: Math.random(),
				nik: nik
			},
			dataType: 'json',
			success: function(obj){
				$('[name="nama"]').removeAttr("disabled").val(obj.nama);
				
				$('[name="golongan"]').prop("disabled",false).val(obj.golongan).trigger("change");
				
				$('[name="pangkat"]').removeAttr("disabled").val(obj.pangkat);
				$('[name="tempat_lahir"]').removeAttr("disabled").val(obj.tempat_lahir);
				$('[name="tgl_lahir"]').removeAttr("disabled").datepicker('update', new Date(obj.tgl_lahir));
				$('[name="telp"]').removeAttr("disabled").val(obj.telp);
				$('[name="jenis_kelamin"]').prop("disabled",false).val(obj.jenis_kelamin).trigger("change");
				$('[name="npwp"]').removeAttr("disabled").val(obj.npwp);
				$('[name="email"]').removeAttr("disabled").val(obj.email);
				$('[name="alamat_tinggal"]').removeAttr("disabled").val(obj.alamat_tinggal);
				$('[name="unit_kerja"]').removeAttr("disabled").val(obj.unit_kerja);
				$('[name="nip"]').removeAttr("disabled").val(obj.nip);
				$('[name="jabatan"]').removeAttr("disabled").val(obj.jabatan);
				$('[name="telp_unit_kerja"]').removeAttr("disabled").val(obj.telp_unit_kerja);
				
				if (obj.kab_unit_kerja == "Badung" || obj.kab_unit_kerja == "Bangli" || obj.kab_unit_kerja == "Buleleng" || obj.kab_unit_kerja == "Gianyar" || obj.kab_unit_kerja == "Jembrana" || obj.kab_unit_kerja == "Karangasem" || obj.kab_unit_kerja == "Klungkung" || obj.kab_unit_kerja == "Tabanan" || obj.kab_unit_kerja == "Denpasar" || obj.kab_unit_kerja == "" || typeof obj.kab_unit_kerja === "undefined") {
					obj.provinsi_unit_kerja = "Bali";	
				}
				$('[name="provinsi_unit_kerja"]').prop("disabled",false).val(obj.provinsi_unit_kerja).trigger("change");
				
				
				$('[name="kab_unit_kerja"]').prop("disabled",false).val(obj.kab_unit_kerja).trigger("change");
				$('[name="alamat_unit_kerja"]').removeAttr("disabled").val(obj.alamat_unit_kerja);
				
				$('[name="nama_bank"]').prop("disabled",false).val(obj.nama_bank).trigger("change");
				$('[name="nama_pemilik_rekening"]').removeAttr("disabled").val(obj.nama_pemilik_rekening);
				$('[name="no_rekening"]').removeAttr("disabled").val(obj.no_rekening);
				$('[name="buku_tabungan"]').removeAttr("disabled");
				$('[name="konfirmasi_paket"]').prop("disabled", false);
				
				$('[name="surat_tugas"]').removeAttr("disabled");
				
				if ($('#signature-pad').length) {
					Biodata.siganturePad.on();	
				}
				
				$('.btn-modal-form-submit').removeAttr("disabled");
				
				Biodata.stopLoader();
			}
		});
	}
	
	$(document).ready(function () {
		Biodata.init();
	});
</script>
</body>
</html>