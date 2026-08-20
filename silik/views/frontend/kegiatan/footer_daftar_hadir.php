
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
	
	Biodata.init = function () {
		
		// Menghitung NIK
		$('[name="nik"]').on('keyup', function(e) {
			var jmlh_char = this.value.length;
			
			$('.hitung-digit').text(jmlh_char);
			
			if (e.keyCode != 17) {
				if (jmlh_char == 16) { // KTP
					Biodata.findByNIK();
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
		
		
		// Submit Form
		$(document).on("submit","form.form-submit-daftar-hadir",function (e) {
			e.preventDefault();
			
			// handle ttd
			if ($('#signature-pad').length) {
				var sign = Biodata.siganturePad.toDataURL();
				
				if (Biodata.siganturePad.isEmpty()) {
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
			
			var url = window.location.href;
			var action = $(this).attr('action');
			var form = $(this).serializeArray();
			
			var data = new FormData();
		
    		$.each(form, function (i, val) {
    			data.append(val.name, val.value);
    		});
			
			if (typeof action === typeof undefined && action === false) {
				action = url;
			}

			$.ajax({
			    url: action,
				dataType: 'json',
    			cache: false,
    			contentType: false,
    			processData: false,
    			data: data,                        
    			type: 'post',
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
			
			return false;
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
	
	Biodata.findByNIK = function (nik, kegiatanId) {
		
		Biodata.startLoader();
		
		var nik = $('[name="nik"]').val();
		var kegiatanId = $('[name="kegiatan_id"]').val();
		var type = $('[name="type"]').val();
		
		$.ajax({
			type: "POST",
			url: "/kegiatan/getItemKegiatan",
			data: {
				version: Math.random(),
				nik: nik,
				kegiatan: kegiatanId,
				type: type
			},
			dataType: 'json',
			success: function(obj){
				
				if ("biodata" in obj) {
					$('[name="nama"]').val(obj.biodata.nama);
					$('[name="nip"]').val(obj.biodata.nip);
					$('[name="jabatan"]').val(obj.biodata.jabatan);
					$('[name="golongan"]').val(obj.biodata.golongan).trigger("change");
					$('[name="pangkat"]').val(obj.biodata.pangkat);
					$('[name="unit_kerja"]').val(obj.biodata.unit_kerja);

					if ($('#signature-pad').length) {
						Biodata.siganturePad.on();	
					}

					$('.btn-modal-form-submit').removeAttr("disabled");
					
					Biodata.stopLoader();
				}
				else {
					Biodata.stopLoader();
					
					Swal.fire({
						icon: "warning",
						title: "Anda Belum Terdaftar",
						text: "Silahkan mendaftar terlebih dulu kemudian mengisi daftar hadir",
						confirmButtonText: 'Daftar Sekarang',
						showCancelButton: true,
					}).then((result) => {
						if (result.value === true) {
							window.location.href = '<?php print base_url("/kegiatan/registrasi_".strtolower(str_replace(" ","_",$type)."/".$kegiatan["id"])); ?>';
						}
					});
				}
			}
		});
	}
	
	$(document).ready(function () {
		Biodata.init();
	});
</script>
</body>
</html>