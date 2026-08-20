var Loader = {};

Loader.stop = function () {
		$(".loader").remove();
	}
	
Loader.start = function () {
	Loader.stop();

	$("body").append('<div class="loader"><div class="loader-wrap"><div class="loader-image"><img src="/assets/images/loader.gif?v=12" width="100" /></div><div class="loader-text">PLEASE WAIT...</div></div></div>');
}
	

var User = {};

User.showAlasanTolak = function (id) {
	$.ajax({
		type: "POST",
		url: "/admin/user/getJsonItemPenugasan/?v="+Math.random(),
		data: {
			id: id,
			version: Math.random()				
		},
		dataType: 'json',
		success: function(obj){
			var modalTolak = '<div id="alasan-tolak-laporan" class="modal fade" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button><h5 class="modal-title">Alasan laporan ditolak</h5></div><div class="modal-body"><p>'+obj.keterangan_ditolak+'</p></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div></div></div></div>';
		
			$('html').append(modalTolak);

			$('#alasan-tolak-laporan').modal({backdrop: 'static', keyboard: false});
			$('#alasan-tolak-laporan').modal('show');
		}
	});
}

User.init = function () {
	User.collapseMenu();
	User.signaturePad = function () {};
	
	User.resizeCanvas = function (wrapper, canvas) {
		var ratio =  Math.max(window.devicePixelRatio || 1, 1);

		// This part causes the canvas to be cleared
		canvas.width = wrapper.offsetWidth * ratio;
		canvas.height = (wrapper.offsetHeight * ratio) - 30;
		canvas.getContext("2d").scale(ratio, ratio);
		User.signaturePad.clear();
	}
	
	User.submitLaporan = function (data) {
		Loader.start();
				
		$.ajax({
			url: "/admin/user/saveLaporanPerjadin/",
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			data: data,                        
			type: 'post',
			success: function(obj){
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

					var tableId = $('.list-penugasan').find('.card').attr('id').replace('-card','');
					Table.refreshTable(tableId);
				}

				Loader.stop();
			}
		 });
	}
 	
	$(document).on('shown.bs.modal','.table-penugasan_item', function () { 
		if ($('#signature-pad').length) {
			var wrapper = document.getElementById("signature-pad");
			var clearButton = wrapper.querySelector("[data-action=clear]");
			var canvas = wrapper.querySelector("canvas");

			User.signaturePad = new SignaturePad(canvas, {
			  penColor: "rgb(2, 2, 2)"
			});

			window.onresize = User.resizeCanvas(wrapper, canvas);
			User.resizeCanvas(wrapper, canvas);

			clearButton.addEventListener("click", function (event) {
				User.signaturePad.clear();
			});	
		}
	});
	
	$(document).on('click', '.btn-submit', function () {
		var tipe = $(this).attr('data-submit');
		$('[name="submit_btn"]').val(tipe);
	});
	
	$(document).on('submit','.submit-laporan', function () {
		
		var form = $(this).serializeArray();
		var foto1 = $('.foto-lap-1').prop('files')[0];
		var foto2 = $('.foto-lap-2').prop('files')[0];
		var stamp = $('.stamp-satker').prop('files')[0];
		var buktiPengeluaran = $('.bukti-pengeluaran').prop('files')[0];
		var tipe = $('[name="submit_btn"]').val();
		
		var data = new FormData();
		
		$.each(form, function (i, val) {
			data.append(val.name, val.value);
		});
		
		data.append('stamp', stamp);
		data.append('laporan_foto[0]', foto1);
		data.append('laporan_foto[1]', foto2);
		
		if ($('.bukti-pengeluaran').length) {
			data.append('bukti_pengeluaran', buktiPengeluaran);
		}
		
		if (tipe == "validasi") {
			Swal.fire({
				text: 'Apakah anda yakin mengirim laporan perjalanan dinas untuk validasi?',
				title: 'Kirim Laporan Perjalanan Dinas',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Kirim Laporan',
				cancelButtonText: 'Batal'
			}).then((result) => {
				if (result.value) {
					User.submitLaporan(data);
				}
			});
		}
		else {
			User.submitLaporan(data);
		}
		
		return false;
	});

	$('.refresh-captcha').click(function () {
		$.ajax({
			type: "POST",
			url: "/admin/user/refresh_captcha",
			data: {
				version: Math.random()				
			},
			dataType: 'json',
			success: function(obj){
				$('#captcha-img').replaceWith(obj.captcha);
			}
		});
	});
}

User.keepAuth = function () {
	$.ajax({
		type: "POST",
		url: "/admin/user/keep_auth/",
		data: {
			version: Math.random()				
		},
		dataType: 'json',
		success: function(obj){
			
		}
	});	
}

User.keepMenu = function () {
	$.ajax({
		type: "POST",
		url: "/admin/user/keep_menu/",
		data: {
			version: Math.random()				
		},
		dataType: 'json',
		success: function(obj){
			
		}
	});	
}

User.collapseMenu = function () {
	$(".mobile-menu").click(function () {
		if ($(this).hasClass("on")){
			$.ajax({
				type: "POST",
				url: "/admin/user/set_menu/",
				data: {
					version: Math.random(),
					menu: true
				},
				dataType: 'json',
				success: function(obj){

				}
			});	
		}
		else {
			$.ajax({
				type: "POST",
				url: "/admin/user/set_menu/",
				data: {
					version: Math.random(),
					menu: false
				},
				dataType: 'json',
				success: function(obj){

				}
			});	
		}
	});
}



var AutoNumeric = {};
AutoNumeric.init = function () {
	if ($('.autoNumeric').length) {
		$('.autoNumeric').autoNumeric('init',{aSep:'.', aDec:',', mDec: '0' });
	}
}

AutoNumeric.destroy = function () {
	if ($('.autoNumeric').length) {
		$('.autoNumeric').each(function () {
			var val = $(this).autoNumeric('get');
			$(this).autoNumeric('destroy');
			$(this).val(val);
		});
	}
}

var Select2 = {};
Select2.init = function (){
	if ($('.select2').length) {
		
		var opt = {};
		
		if ($(".modal-body").length) {
			opt = {dropdownParent: $(".modal-body")};
		}
		
		$('.select2').select2(opt);
	}
}

var Datepicker = {};
Datepicker.init = function () {
	if ($('.datepicker').length) {
		$('.datepicker').datepicker({
			todayHighlight: true,
			format: 'dd/mm/yyyy'
		});

		$('.datepicker').on('changeDate', function(ev){
			$(this).datepicker('hide');
		});
	}
}
Datepicker.Reformat = function () {
	
}

$(document).on("submit","form.form-submit",function (e) {
	e.preventDefault();
	
	AutoNumeric.destroy();
	
	var url = window.location.href;
	var action = $(this).attr('action');
	var data = $(this).serialize();
	var form = $(this);

	if (typeof action === typeof undefined && action === false) {
		action = url;
	}
	
	Loader.start();
	
	$.ajax({
		type: "POST",
		url: action,
		data: data,
		dataType: 'json',
		success: function(obj){
			Loader.stop();
			
			if (obj.error) {
				AutoNumeric.init();
				
				if(typeof(obj.redirect) != "undefined" && obj.redirect !== null) {
					window.location.href = obj.redirect;
				}
				else {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: obj.msg
					});
				}
			}
			else {
				if(typeof(obj.redirect) != "undefined" && obj.redirect !== null) {
					window.location.href = obj.redirect;
				}
				else if (typeof(obj.reload) != "undefined" && (obj.reload !== null || obj.reload !== false)) {
					
					Swal.fire({
					  icon: 'success',
						title: 'Sukses...',
					  text: obj.msg,
					  showConfirmButton: true,
					}).then(function() {
						location.reload();
					});
					
				}
				else {
					if (obj.close_modal) {
						form.closest('.modal').modal('hide');
					}
					
					if (obj.reload_table) {
						var tableId = form.attr('data-table-id');
						Table.refreshTable(tableId);
					}
					
					/*form.each(function(){
						this.reset();
					});*/
						
					Swal.fire({
					  icon: 'success',
						title: 'Sukses...',
					  text: obj.msg,
					  showConfirmButton: true,
					});
				}
			}
		}
	});
});

var Kegiatan = {};

Kegiatan.switchRegistration = function (keg, type, val) {
	
	if (val) {
		$(".generateBitlyLinkTarget").removeClass("generateBitlyLinkTargetOff");
	}
	else {
		$(".generateBitlyLinkTarget").addClass("generateBitlyLinkTargetOff");
	}
		
	$.ajax({
		type: "POST",
		url: "/admin/kegiatan/switchRegistration/?v="+Math.random(),
		data: {
			kegiatanId: keg,
			type: type,
			switch: val,
			version: Math.random()				
		},
		dataType: 'json',
		success: function(obj){

		}
	});
}

Kegiatan.switchDaftarHadir = function (keg, komponen, tanggal, val) {
	
	if (val) {
		$(".group-switch-"+tanggal).removeClass("link-off");
		$(".group-switch-"+tanggal+" .btn-edit-dh-bitly").removeAttr("disabled");
	}
	else {
		$(".group-switch-"+tanggal).addClass("link-off");
		$(".group-switch-"+tanggal+" .btn-edit-dh-bitly").attr("disabled", "disabled");
	}
		
	$.ajax({
		type: "POST",
		url: "/admin/kegiatan/switchDaftarHadir/?v="+Math.random(),
		data: {
			kegiatanId: keg,
			komponen: komponen,
			tanggal: tanggal,
			switch: val,
			version: Math.random()				
		},
		dataType: 'json',
		success: function(obj){

		}
	});
}

Kegiatan.loadDakungList = function (kegiatanId, section) {
	$('.wrap-dakung[data-section="'+section+'"]').html('<div class="d-flex justify-content-center dakung-loader"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
	
	$.ajax({
		type: "POST",
		url: "/admin/kegiatan/dakungList/?v="+Math.random(),
		data: {
			kegiatanId: kegiatanId,
			section: section,
			version: Math.random()				
		},
		dataType: 'html',
		success: function(html){
			$('.wrap-dakung[data-section="'+section+'"]').html(html);
			
			if ($('.wrap-dakung[data-section="'+section+'"]').find("tr").length) {
				$('.wrap-dakung[data-section="'+section+'"]').closest('.card').find('.dakung-alert-circle').removeClass('text-c-red').addClass('text-c-green');
			}
			else {
				$('.wrap-dakung[data-section="'+section+'"]').closest('.card').find('.dakung-alert-circle').removeClass('text-c-green').addClass('text-c-red');
			}
		}
	});
}

Kegiatan.formatResult = function (result) {
	return result.nama;
};

Kegiatan.formatRepoSelection = function (repo) {
	return repo.nama;
}

Kegiatan.getTemplateSertificate = function () {
	if ($("#select-serticate").length) {
		
		var option = {};
		option["ajax"] = {
			url: "/admin/kegiatan/sertificate_typehead",
			contentType: 'application/json',
			dataType: 'json',
			data: function(params) {
				return {
					q: params.term, // search term
					page: params.page
				};
			},
			processResults: function(data) {
				return {
					results: data.items
				};
			},
			cache: false
		};
		
		option["templateResult"] = Kegiatan.formatResult;
		option["templateSelection"] = Kegiatan.formatRepoSelection;
		option["minimumInputLength"] = 3;
		option["placeholder"] = "Pilih sertifikat template...";
		
		var selected = $("#select-serticate").attr("data-selected-sertificate");
		
		if (selected == "0") {
			$("#select-serticate").select2(option);
		}
		else {
			$.ajax({
				type: "POST",
				url: "/admin/sertifikat/json_detail/?v="+Math.random(),
				data: {
					id: selected,
					version: Math.random()				
				},
				dataType: 'json',
				success: function(obj){
					option["data"] = [obj];
					$("#select-serticate").select2(option);
				}
			});
		}
	}
}

Kegiatan.loadReportPendaftaran = function () {
	$('#report-pendaftaran').html('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
		
		var id = $('[name="id"]').val();
		var unsur = $('.unsur-pendaftaran').val();
	
		$.ajax({
			type: "POST",
			url: "/admin/kegiatan/report/",
			data: {
				id: id,
				unsur: unsur,
				version: Math.random()				
			},
			dataType: 'html',
			success: function(html){
				$('#report-pendaftaran').html(html);
				
				$('#report-pendaftaran a.nav-link').click(function (e) {
					e.preventDefault();
					$(this).tab('show');
				});
				
				$('#report-pendaftaran a.first-tab').tab('show');
			}
		});
}

Kegiatan.duplikat = function (e) {
	var title = $(e).closest('tr').find('.row-event-click').attr('title');
	var tableId = $(e).closest('.card').attr('id').replace("bootgrid-card-","");
	var id = $(e).attr('data-id');
	
	Swal.fire({
			title: 'Apakah anda yakin untuk duplikat kegiatan',
			text: title,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Duplikat',
			cancelButtonText: 'Batal'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					type: "POST",
					url: "/admin/kegiatan/duplikat/",
					data: {
						id: id,
						version: Math.random()				
					},
					dataType: 'json',
					success: function(obj){
						if (obj.error) {
							Swal.fire(
								'Gagal!',
								obj.msg,
								'error'
							);
						}
						else {
							Swal.fire(
								'Berhasil!',
								obj.msg,
								'success'
							);
							
							Table.refreshTable("bootgrid-"+tableId);
						}
					}
				});
			}
		});
}

Kegiatan.getBitlyModal = function (bitlyLink) {
	var modalHtml = '<div class="modal fade" data-remove-modal="false" id="modal-bitly" tabindex="-1" role="dialog" aria-labelledby="modal-button-row" aria-hidden="true" data-backdrop="static"><div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h5 class="modal-title">Generate Bitly Registrasi</h5></div><form action="" method="post" class="" autocomplete="off"><input type="hidden" name="kegiatan_id" class="form-control" value="" /><div class="modal-body"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="inputGroup-sizing-sm">bit.ly/</span></div><input type="text" class="form-control" name="bitly_link" value="'+bitlyLink+'" /></div></div></form><div class="modal-footer"><button type="submit" class="btn btn-info btn-submit-generate-link">Generate</button><button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button></div></div></div></div>';
	
	return modalHtml;
}

Kegiatan.getBitlyDaftarHadirModal = function (bitlyLink, labelBitly, tanggal) {
	var modalHtml = '<div class="modal fade" data-remove-modal="false" id="modal-bitly" tabindex="-1" role="dialog" aria-labelledby="modal-button-row" aria-hidden="true" data-backdrop="static"><div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h5 class="modal-title">Generate Bitly - '+labelBitly+'</h5></div><form action="" method="post" class="" autocomplete="off"><div class="modal-body"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="inputGroup-sizing-sm">bit.ly/</span></div><input type="text" class="form-control" name="bitly_link" value="'+bitlyLink+'" /></div></div></form><div class="modal-footer"><button type="submit" class="btn btn-info btn-submit-generate-df-link" data-tanggal="'+tanggal+'">Generate</button><button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button></div></div></div></div>';
	
	return modalHtml;
}

Kegiatan.getBitlySPD = function (bitlyLink) {
	var modalHtml = '<div class="modal fade" data-remove-modal="false" id="modal-bitly" tabindex="-1" role="dialog" aria-labelledby="modal-button-row" aria-hidden="true" data-backdrop="static"><div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h5 class="modal-title">Edit SPD Link</h5></div><form action="" method="post" class="" autocomplete="off"><input type="hidden" name="kegiatan_id" class="form-control" value="" /><div class="modal-body"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="inputGroup-sizing-sm">bit.ly/</span></div><input type="text" class="form-control" name="bitly_link" value="'+bitlyLink+'" /></div></div></form><div class="modal-footer"><button type="submit" class="btn btn-info btn-submit-generate-spd-link">Generate</button><button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button></div></div></div></div>';
	
	return modalHtml;
}

Kegiatan.init = function () {
	$(document).on('keypress','[name="bitly_link"]', function(e) {
		var regex = new RegExp("^[a-zA-Z0-9]+$");
    	var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		
		if (e.which == 32){
			return false;
		}
		else if (!regex.test(key)) {
       		e.preventDefault();
       		return false;
    	}
	});
	
	$(document).on('click','.generateBitlyLinkTarget', function () {
		if (!$(this).hasClass("generateBitlyLinkTargetOff")) {
			$(this).select();
		}
		else {
			$(this)[0].selectionStart = $(this)[0].selectionEnd;
		}
	});

	$(document).on('click','.form-link-dh', function () {
		if (!$(this).closest('.form-group').hasClass("link-off")) {
			$(this).select();
		}
		else {
			$(this)[0].selectionStart = $(this)[0].selectionEnd;
		}
	});
	
	$(document).on('click','.input-edit-spd-link', function () {
		$(this).select();
	});
	
	$(document).on("change", "#generateLinkRegistrasi", function () {
		var kegiatanId = $(this).val();
		var type = $(this).attr('data-type');
		
		if ($(this).is(':checked')) {
			if (!$('.generateBitlyLinkTarget').length) {
				var modalHtml = Kegiatan.getBitlyModal("");
			
				$('#modal-bitly').remove();
				$('body').append(modalHtml);
				
				$('#modal-bitly').modal('show');
				$('#modal-bitly [name="bitly_link"]').focus();
			}
			else {
				Kegiatan.switchRegistration(kegiatanId, type, 1);
			}
		}
		else {
			Kegiatan.switchRegistration(kegiatanId, type, 0);
		}
	});
	
	$(document).on('click', '.btn-edit-bitly', function () {
		var bitlyLink = $(this).parent().find('.generateBitlyLinkTarget').val().replace("bit.ly/","");
		var baseUrl = $('[name="base_url"]').val();

		if(bitlyLink.indexOf(baseUrl) >= 0){
			bitlyLink = "";
		}
		
		var modalHtml = Kegiatan.getBitlyModal(bitlyLink);
		$('#modal-bitly').remove();
		$('body').append(modalHtml);

		$('#modal-bitly').modal('show');
		$('#modal-bitly [name="bitly_link"]').focus();
	});

	$(document).on('click', '.btn-edit-dh-bitly', function () {
		var bitlyLink = $(this).closest('.form-group-switch').find('.form-link-dh').val().replace("bit.ly/","");
		var labelBitly = $(this).closest('.form-group-switch').find('.label-daftar-hadir').text();
		var tanggal = $(this).attr("data-tanggal");
		var baseUrl = $('[name="base_url"]').val();

		if(bitlyLink.indexOf(baseUrl) >= 0){
			bitlyLink = "";
		}
		
		var modalHtml = Kegiatan.getBitlyDaftarHadirModal(bitlyLink, labelBitly, tanggal);
		$('#modal-bitly').remove();
		$('body').append(modalHtml);

		$('#modal-bitly').modal('show');
		$('#modal-bitly [name="bitly_link"]').focus();
	});
	
	$(document).on('click', '.btn-edit-spd-link', function () {
		var bitlyLink = $(this).parent().find('.input-edit-spd-link').val().replace("bit.ly/","");
		var baseUrl = $('[name="base_url"]').val();
		
		if(bitlyLink.indexOf(baseUrl) >= 0){
			bitlyLink = "";
		}
		
		var modalHtml = Kegiatan.getBitlySPD(bitlyLink);
		$('#modal-bitly').remove();
		$('body').append(modalHtml);

		$('#modal-bitly').modal('show');
		$('#modal-bitly [name="bitly_link"]').focus();
	});
	
	$(document).on('click', '.btn-submit-generate-link', function () {
		var kegiatanId = $('#generateLinkRegistrasi').val();
		var type = $('#generateLinkRegistrasi').attr('data-type');
		var customLink = $('[name="bitly_link"]').val();
		$('#modal-bitly').modal('hide');
		
		Loader.start();
		
		$.ajax({
			type: "POST",
			url: "/admin/kegiatan/generateBitly/?v="+Math.random(),
			data: {
				kegiatanId: kegiatanId,
				type: type,
				customLink: customLink,
				version: Math.random()				
			},
			dataType: 'json',
			success: function(obj){
				Loader.stop();
				
				if (obj.error) {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: obj.desc
					}).then(function() {
						$('#modal-bitly').modal('show');
					});
				}
				else {
					Kegiatan.switchRegistration(kegiatanId, type, 1);
					$("input.generateBitlyLinkTarget").replaceWith('<input type="text" class="generateBitlyLinkTarget " value="'+obj.custom_bitlinks+'" readonly="readonly">');
					
					Swal.fire({
					  icon: 'success',
						title: 'Sukses...',
					  text: 'Generate Link Berhasil',
					  showConfirmButton: true,
					}).then(function() {
						$('#modal-bitly').modal('hide');
						$('#modal-bitly').remove();
					});
				}
			}
		});
	});
	
	$(document).on('click', '.btn-submit-generate-df-link', function () {
		var kegiatanId = $('.keg-opt-form [name="id"]').val();
		var komponen = $('.keg-opt-form [name="komponen"]').val();
		var customLink = $('[name="bitly_link"]').val();
		var tanggal = $(this).attr("data-tanggal");
		$('#modal-bitly').modal('hide');
		
		Loader.start();
		
		$.ajax({
			type: "POST",
			url: "/admin/kegiatan/generateBitlyDaftarHadir/?v="+Math.random(),
			data: {
				kegiatanId: kegiatanId,
				komponen: komponen,
				customLink: customLink,
				tanggal: tanggal,
				version: Math.random()			
			},
			dataType: 'json',
			success: function(obj){
				Loader.stop();
				
				if (obj.error) {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: obj.desc
					}).then(function() {
						$('#modal-bitly').modal('show');
					});
				}
				else {
					Kegiatan.switchDaftarHadir(kegiatanId, komponen, tanggal, 1);
					$('.form-link-dh-'+tanggal).val(obj.custom_bitlinks);
					
					Swal.fire({
					  icon: 'success',
						title: 'Sukses...',
					  text: 'Generate Link Berhasil',
					  showConfirmButton: true,
					}).then(function() {
						$('#modal-bitly').modal('hide');
						$('#modal-bitly').remove();
					});
				}
			}
		});
	});
	
	$(document).on('click','.add-dakung', function () {
		var kegiatan = $(this).attr("data-kegiatan");
		var section = $(this).attr("data-section");
		
		$.ajax({
			type: "POST",
			url: "/admin/kegiatan/formUploadDakung/?v="+Math.random(),
			data: {
				kegiatan: kegiatan,
				section: section,
				version: Math.random()				
			},
			dataType: 'html',
			success: function(html){
				$('body').append(html);
				
				$('#modal-dakung').modal('show');
				
				$("div#dropzone-dakung").dropzone({ 
					url: "/admin/kegiatan/uploadDakung?v"+Math.random(),
					paramName: "file", // The name that will be used to transfer the file
    				maxFilesize: 10, // MB
					autoProcessQueue: false,
					acceptedFiles: '.jpg,.jpeg,.pdf,.doc,.docx',
					addRemoveLinks: true,
					parallelUploads : 10,
					init: function() {
						var submitButton = document.querySelector(".btn-submit-dakung")
						myDropzone = this;
						
						submitButton.addEventListener("click", function() {
							myDropzone.processQueue(); 
						});
						
						myDropzone.on('sending', function(file, xhr, formData){
							formData.append('kegiatan', kegiatan);
							formData.append('section', section);
						});
						
						myDropzone.on("success", function(file) {
							myDropzone.removeFile(file);
							$('#modal-dakung').modal('hide');
							
							Kegiatan.loadDakungList(kegiatan, section);
						});
					},
				});
			}
		});
	});

	$(document).on("change", ".bitly-dh", function () {
		var kegiatanId = $(this).attr('data-kegiatan');
		var komponen = $(this).attr('data-type');
		var date = $(this).attr('data-date');
		
		if ($(this).is(':checked')) {
			Kegiatan.switchDaftarHadir(kegiatanId, komponen, date, 1);
		}
		else {
			Kegiatan.switchDaftarHadir(kegiatanId, komponen, date, 0);
		}
	});
	
	if ($('.wrap-dakung').length) {
		Dropzone.autoDiscover = false;
		
		var all = $(".wrap-dakung").map(function() {
			var kegiatan = $(this).attr("data-kegiatan");
			var section = $(this).attr("data-section");
			
			Kegiatan.loadDakungList(kegiatan, section);
		}).get();
	}
	
	if ($('#report-pendaftaran').length) {
		Kegiatan.loadReportPendaftaran();
	}
	
	$(document).on("click", '.download-biodata-kegiatan', function () {
		Loader.start();
		var kegiatanId = $(this).attr('data-kegiatan');
		var tipe = $(this).attr('data-tipe');
		
		$.ajax({
			type: "POST",
			url: "/admin/kegiatan/download_biodata2/"+kegiatanId+"/"+tipe+"/",
			data: {
				version: Math.random()				
			},
			dataType: 'json',
			success: function(obj){
				Loader.stop();

				if (obj.page > 0) {
					for (var i = 1; i <= obj.page; i++) {
						var win = window.open("/admin/kegiatan/download_biodata2/"+kegiatanId+"/"+tipe+"/"+i, '_blank');
						
						if (win) {
							//Browser has allowed it to be opened
							win.focus();
						} else {
						//	//Browser has blocked it
							alert('Please allow popups for this website');
						}
					}
				}
				else {
					Swal.fire(
						'Gagal!',
						'Gagal download biodata.',
						'error'
					);
				}
			}
		});
	});

	$(document).on("click", '.download-daftar-hadir-kegiatan', function () {
		var html = "";
		var kegiatanId = $(this).attr('data-kegiatan');
		var tipe = $(this).attr('data-tipe');

		Loader.start();
		
		$.ajax({
			type: "POST",
			url: "/admin/kegiatan/option_daftar_hadir_peserta",
			data: {
				kegiatan_id: kegiatanId,
				tipe: tipe,
				version: Math.random()				
			},
			dataType: 'html',
			success: function(html){
				Loader.stop();				
				$('#modal-rekap-daftar-hadir-peserta').html(html);
				$('#modal-show-rekap-daftar-hadir-peserta').modal('show');
			}
		});
	});

	$(document).on('click','.tugas_panitia', function () {
		var html = "";
		var id = $('input[name="id"]').val();
		var tableId = $(this).closest(".bootgrid-header").attr("id").replace("-header","");

		Loader.start();
		
		$.ajax({
			type: "POST",
			url: "/admin/kegiatan/tugas_panitia",
			data: {
				id: id,
				table_id: tableId,
				version: Math.random()				
			},
			dataType: 'html',
			success: function(html){
				Loader.stop();				
				$('#modal-tugas-panitia').html(html);
				Select2.init();
				$('#modal-atur-tugas-panitia').modal('show');
			}
		});
	});

	$(document).on('click','.rekap_daftar_hadir_peserta', function () {
		var html = "";
		var id = $('input[name="id"]').val();
		var tableId = $(this).closest(".bootgrid-header").attr("id").replace("-header","");

		Loader.start();
		
		$.ajax({
			type: "POST",
			url: "/admin/kegiatan/rekap_daftar_hadir_peserta",
			data: {
				id: id,
				table_id: tableId,
				version: Math.random()				
			},
			dataType: 'html',
			success: function(html){
				Loader.stop();				
				$('#modal-rekap-daftar-hadir-peserta').html(html);
				$('#modal-show-rekap-daftar-hadir-peserta').modal('show');
			}
		});
	});

	$(document).on("click", '.download-option-daftar-hadir-execute', function () {
		Loader.start();
		var kegiatanId = $(this).attr('data-kegiatan');
		var tipe = $(this).attr('data-tipe');
		var tanggal = "";

		$('.check-daftar-hadir').each(function () {
			if ($(this).is(':checked')) {

				if (tanggal == "") {
					tanggal = $(this).val();
				}
				else {
					tanggal += "_"+$(this).val();
				}
				
			}
		});

		var win = window.open("/admin/kegiatan/download_option_daftar_hadir/"+kegiatanId+"/"+tipe+"/"+tanggal, '_blank');
						
		if (win) {
			//Browser has allowed it to be opened
			win.focus();
		} else {
		//	//Browser has blocked it
			alert('Please allow popups for this website');
		}

		Loader.stop();

	});
	
	Kegiatan.getTemplateSertificate();
}

var Tiket = {};

Tiket.init = function () {
	Tiket.setDropzone();
	Tiket.loadChat();
	
	$('.show-tiket-upload').click(function () {
		$('.tiket-upload').slideToggle('fast');
	});
	
	$('.ticket-status-change').change(function () {
		var status = $(this);
		var statusVal = status.val();
		var tiket = $(this).attr("tiket-id");
		
		if (statusVal == "2") {
			Swal.fire({
				title: 'Apakah anda yakin mengubah status tiket?',
				text: 'Tiket dengan status "Selesai" tidak bisa ditindaklanjuti lagi',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Ya, Ubah Status',
				cancelButtonText: 'Batal'
			}).then((result) => {
				if (result.value) {
					$.ajax({
						type: "POST",
						url: "/admin/tiket/ubah_status/",
						data: {
							status: statusVal,
							tiketId: tiket,
							version: Math.random()				
						},
						dataType: 'json',
						success: function(obj){
							if (obj.error) {
								Swal.fire(
									'Gagal!',
									'Gagal mengubah status tiket.',
									'error'
								);
							}
							else {
								Swal.fire(
									'Berhasil!',
									'Berhasil mengubah status tiket.',
									'success'
								);
							}
						}
					});
				}
				else {
					status.val("1");
				}
			});
		}
	});
}

Tiket.submitChatWithoutFiles = function () {
	var msg = $('.msg-send-chat').val();
	var tiketId = $('[name="tiket_id"]').val();
	
	$.ajax({
		type: "POST",
		url: "/admin/tiket/saveChatAdmin/",
		data: {
			msg: msg,
			tiket_id: tiketId,
			version: Math.random()				
		},
		dataType: 'json',
		success: function(obj){
			$('.msg-send-chat').val("");
			Tiket.loadChat();
			Loader.stop();
		}
	});
}

Tiket.setDropzone = function () {
	if ($('#dropzone-tiket').length) {
		$("div#dropzone-tiket").dropzone({ 
			url: "/admin/tiket/saveChatAdmin?v"+Math.random(),
			paramName: "file", // The name that will be used to transfer the file
			maxFilesize: 10, // MB
			autoProcessQueue: false,
			acceptedFiles: '.jpg,.jpeg,.pdf,.doc,.docx,.png',
			addRemoveLinks: true,
			parallelUploads : 10,
			uploadMultiple:true,
			init: function() {
				var myDropzone = this;
				var submitButton = document.querySelector(".btn-submit-tiket");
				
				submitButton.addEventListener("click", function() {
					Loader.start();
					var msg = $('.msg-send-chat').val();
					
					if (msg == "" && myDropzone.getQueuedFiles().length == 0) {
						$('.msg-send-chat').focus();
					}
					else {
						if (myDropzone.getQueuedFiles().length > 0) {                        
							myDropzone.processQueue();
						} else { 
							Tiket.submitChatWithoutFiles();
						}	
					}
				});
				
				myDropzone.on('sending', function(file, xhr, formData){
					var msg = $('.msg-send-chat').val();
					var tiketId = $('[name="tiket_id"]').val();
					
					formData.append('msg', msg);
					formData.append('tiket_id', tiketId);
				});

				myDropzone.on("success", function(file) {
					myDropzone.removeFile(file);
					$('.msg-send-chat').val("");
					Tiket.loadChat();
					Loader.stop();
				});
			},
		});
	}
}

Tiket.loadChat = function () {
	if ($('.main-friend-chat').length) {
		var id = $('[name="tiket_id"]').val();
		
		$.ajax({
			type: "POST",
			url: "/admin/tiket/chat/",
			data: {
				id: id,
				version: Math.random()				
			},
			dataType: 'html',
			success: function(html){
				$('.main-friend-chat').html(html);
				
				var objDiv = $('.msg-user-chat')[0];
				objDiv.scrollTop = objDiv.scrollHeight;
			}
		});	
	}
}

$(document).ready(function () {
	// Keep Auth Alive
	window.setInterval(function(){
	  	User.keepAuth();
		User.keepMenu();
	}, 30000);
	
	$('html, body').animate({scrollLeft: 0}, 200);
	
	$(document).on('hidden.bs.modal','.modal:not([data-remove-modal="false"])', function (e) {
		$(this).remove();
	});
	
	Select2.init();
	Datepicker.init();
	AutoNumeric.init();
	
	User.init();
	Tiket.init();
	Kegiatan.init();
});

if (typeof Table != "undefined") {
   Table.cardOption();
}