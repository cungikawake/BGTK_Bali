var Kepegawaian = {};

Kepegawaian.formatResult = function (result) {
	return result.nama;
};

Kepegawaian.formatRepoSelection = function (repo) {
	return repo.nama;
}

Kepegawaian.selectKegiatan = function () {
	if ($("#select-kegiatan").length) {
		
		var option = {};
		option["ajax"] = {
			url: "/admin/kepegawaian/search_kegiatan",
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
		
		option["templateResult"] = Kepegawaian.formatResult;
		option["templateSelection"] = Kepegawaian.formatRepoSelection;
		option["minimumInputLength"] = 3;
		option["placeholder"] = "Pilih kegiatan...";
		
		var selected = $("#select-kegiatan").attr("data-selected");
		
		if (selected == "0" || selected == "") {
			$("#select-kegiatan").select2(option);
		}
		else {
			$.ajax({
				type: "POST",
				url: "/admin/kepegawaian/json_penugasan_kegiatan/?v="+Math.random(),
				data: {
					id: selected,
					version: Math.random()				
				},
				dataType: 'json',
				success: function(obj){
					option["data"] = [obj];
					$("#select-kegiatan").select2(option);
					$('.tgl-mulai-kegiatan').val(obj.tgl_mulai_kegiatan);
					$('.tgl-selesai-kegiatan').val(obj.tgl_selesai_kegiatan);
				}
			});
		}
		
		$("#select-kegiatan").on('select2:select', function (e) {
			var data = e.params.data;
			
			$('[name="nama"]').val(data.nama);
			$('.tgl-mulai-kegiatan').val(data.tgl_mulai_kegiatan);
			$('.tgl-selesai-kegiatan').val(data.tgl_selesai_kegiatan);
		});
	}
}

Kepegawaian.provinsi = [];

Kepegawaian.getKabupaten = function (provinsi) {
	var items = [];
	provinsi = typeof provinsi !== 'undefined' ? provinsi : "Bali";
	var kabupaten = [];
	
	if (Kepegawaian.provinsi.length > 0) {
		$.each(Kepegawaian.provinsi, function (i, provs) {
			$.each(provs, function (prov, kabs) {
				if (prov == provinsi) {
					kabupaten = kabs;
				}
			});
		});	
	}

	return kabupaten;
}

Kepegawaian.submitPenugasan = function (status) {
	Loader.start();
	
	var dataForm = $('form.form-penugasan').serializeArray();
	
	dataForm.push({'name':'status', 'value':status});
	
	
	var tipe = $('[name="tipe"]').val();

	if (tipe == "monev") {
		$('.penugasan-monev .penugasan-monev-sec').each(function (i) {
			var tglMulaiMonev = $(this).find('.tgl-mulai-tugas').val();
			var tglSelesaiMonev = $(this).find('.tgl-selesai-tugas').val();
			var provAsal = $(this).find('.provinsi-asal').val();
			var provTujuan = $(this).find('.provinsi-tujuan').val();
			var kabAsal = $(this).find('.kab-asal').val();
			var kabTujuan = $(this).find('.kab-tujuan').val();
			var tempatTujuan = $(this).find('.tempat-tujuan').val();
			
			dataForm.push({'name':'petugas['+i+'][tgl_mulai_tugas]', 'value':tglMulaiMonev});
			dataForm.push({'name':'petugas['+i+'][tgl_selesai_tugas]', 'value':tglSelesaiMonev});
			dataForm.push({'name':'petugas['+i+'][provinsi_asal]', 'value':provAsal});
			dataForm.push({'name':'petugas['+i+'][provinsi_tujuan]', 'value':provTujuan});
			dataForm.push({'name':'petugas['+i+'][kab_asal]', 'value':kabAsal});
			dataForm.push({'name':'petugas['+i+'][kab_tujuan]', 'value':kabTujuan});
			dataForm.push({'name':'petugas['+i+'][tempat_tujuan]', 'value':tempatTujuan});

			var getPetugas = $(this).find('.petugas-monev').val();

			if (getPetugas.length) {
				$.each(getPetugas,function (x, petugasId) {
					dataForm.push({'name':'petugas['+i+'][petugas]['+x+']', 'value':petugasId});
				});	
			}
		});
	}
	
	
	$.ajax({
		type: "POST",
		url: "/admin/kepegawaian/savePenugasan?v"+Math.random(),
		data: dataForm,
		dataType: 'json',
		success: function(obj){
			$('.modal').modal('hide');
					
			if ($('.bootgrid-header').length) {
				var tableId = $('.bootgrid-header').attr('id').replace('-header','');

				Table.reloadTable(tableId);
				
				if (status == '1') {
					var msg = 'Berhasil mengusulkan penugasan untuk validasi';
				}
				else {
					var msg = 'Berhasil menyimpan penugasan'; 
				}
				
				Swal.fire({
					icon: 'success',
					title: 'Sukses...',
					text: msg,
					showConfirmButton: true,
				});
			}
			
			Loader.stop();
		}
	});
}

Kepegawaian.setDropzonePenugasan = function () {
	
	if ($("div#dropzone-surat-tugas").length) {
		$("div#dropzone-surat-tugas").dropzone({ 
			url: "/admin/kepegawaian/savePenugasan?v"+Math.random(),
			paramName: "file", // The name that will be used to transfer the file
			maxFilesize: 5, // MB
			autoProcessQueue: false,
			acceptedFiles: '.pdf',
			addRemoveLinks: true,
			parallelUploads : 10,
			init: function() {
				var submitButton = document.querySelector(".btn-modal-form-submit-penugasan");
				var submitValid = document.querySelector(".btn-modal-form-valid-penugasan");
				var formPenugasan = document.querySelector(".form-penugasan");
				
				var myDropzone = this;
				var status = '0';
				
				formPenugasan.addEventListener("submit", function(e) {
					e.preventDefault();
					
					if (status == '1') {
						if (myDropzone.getQueuedFiles().length <= 0 && $('.surat-tugas-penugasan').length) {
							Swal.fire({
								text: 'Apakah anda yakin mengirim usulan penugasan untuk validasi?',
								title: 'Kirim Usulan Penugasan',
								icon: 'warning',
								showCancelButton: true,
								confirmButtonText: 'Kirim Usulan',
								cancelButtonText: 'Batal'
							}).then((result) => {
								if (result.value) {
									Kepegawaian.submitPenugasan('1');
								}
							});
						}
						else if (myDropzone.getQueuedFiles().length <= 0) {
							Swal.fire(
								'Perhatian!',
								'Mohon mengupload <strong>Surat Tugas</strong>',
								'warning'
							);
						}
						else {
							Swal.fire({
								text: 'Apakah anda yakin mengirim usulan penugasan untuk validasi?',
								title: 'Kirim Usulan Penugasan',
								icon: 'warning',
								showCancelButton: true,
								confirmButtonText: 'Kirim Usulan',
								cancelButtonText: 'Batal'
							}).then((result) => {
								if (result.value) {
									myDropzone.processQueue();
								}
							});
						}
					}
					else {
						if (myDropzone.getQueuedFiles().length <= 0 && $('.surat-tugas-penugasan').length) {
							Kepegawaian.submitPenugasan(status);
						}
						else if (myDropzone.getQueuedFiles().length <= 0) {
							Swal.fire(
								'Perhatian!',
								'Mohon mengupload <strong>Surat Tugas</strong>',
								'warning'
							);
						}
						else {
							myDropzone.processQueue();
						}
					}
					
					return false;
				});
				
				submitValid.addEventListener("click", function() {
					status = '1';
				});

				myDropzone.on('sending', function(file, xhr, formData){
					Loader.start();
					
					var dataForm = $('form.form-penugasan').serializeArray();
					
					if (dataForm.length) {
						$.each(dataForm, function (i, data) {
							formData.append(data.name, data.value);
						});
					}
					
					formData.append('status', status);
					
					var tipe = $('[name="tipe"]').val();
					
					if (tipe == "monev") {						
						$('.penugasan-monev .penugasan-monev-sec').each(function (i) {
							var tglMulaiMonev = $(this).find('.tgl-mulai-tugas').val();
							var tglSelesaiMonev = $(this).find('.tgl-selesai-tugas').val();
							var provAsal = $(this).find('.provinsi-asal').val();
							var kabAsal = $(this).find('.kab-asal').val();
							var provTujuan = $(this).find('.provinsi-tujuan').val();
							var kabTujuan = $(this).find('.kab-tujuan').val();
							var tempatTujuan = $(this).find('.tempat-tujuan').val();
							
							formData.append('petugas['+i+'][tgl_mulai_tugas]', tglMulaiMonev);
							formData.append('petugas['+i+'][tgl_selesai_tugas]', tglSelesaiMonev);
							formData.append('petugas['+i+'][provinsi_asal]', provAsal);
							formData.append('petugas['+i+'][provinsi_tujuan]', provTujuan);
							formData.append('petugas['+i+'][kab_asal]', kabAsal);
							formData.append('petugas['+i+'][kab_tujuan]', kabTujuan);
							formData.append('petugas['+i+'][tempat_tujuan]', tempatTujuan);
							
							var getPetugas = $(this).find('.petugas-monev').val();
							
							if (getPetugas.length) {
								$.each(getPetugas,function (x, petugasId) {
									formData.append('petugas['+i+'][petugas]['+x+']', petugasId);
								});	
							}
						});
					}
				});

				myDropzone.on("success", function(file) {
					myDropzone.removeFile(file);
					$('.modal').modal('hide');
					
					if ($('.bootgrid-header').length) {
						var tableId = $('.bootgrid-header').attr('id').replace('-header','');
						
						Table.reloadTable(tableId);
					}
					
					if (status == '1') {
						var msg = 'Berhasil mengusulkan validasi penugasan';
					}
					else {
						var msg = 'Berhasil menyimpan penugasan'; 
					}

					Swal.fire({
						icon: 'success',
						title: 'Sukses...',
						text: msg,
						showConfirmButton: true,
					});
					
					Loader.stop();
				});
			},
		});
	}
}

Kepegawaian.bootgridRincianPetugas = function () {
	$("#grid-rincian-petugas").bootgrid({
		rowCount: -1,
		templates: {
			actionDropDown: "",
			search: "",
			infos: ""
		}
	});
}

Kepegawaian.groupMonevNo = 0;
Kepegawaian.groupUndanganNo = 0;

Kepegawaian.modalInit = function () {
	Kepegawaian.selectKegiatan();
	Kepegawaian.setDropzonePenugasan();
	
	if ($('select[name="tipe"]').length) {
		$('select[name="tipe"]').on('select2:select', function (e) {
			var data = e.params.data;
			
			$('.penugasan-kegiatan-pilih').hide();
			$('.penugasan-kegiatan').hide();
			$('.keterangan-monev').hide();
			$('.penugasan-monev').hide();
			
			$('.penugasan-kegiatan #select-kegiatan').prop('disabled', true);
			$('.penugasan-kegiatan .petugas-kegiatan').prop('disabled', true);
			
			$('.penugasan-monev-sec').each(function () {
				$(this).find(':input').prop("disabled", true);
			});
			
			
			if (data.id == "monev") {
				$('.keterangan-monev').show();
				$('.penugasan-monev').show();
				
				$('.penugasan-monev-sec').each(function () {
					$(this).find(':input').prop("disabled", false);
				});
			}
			else {
				$('.penugasan-kegiatan-pilih').show();
				$('.penugasan-kegiatan').show();
				$('.penugasan-kegiatan-pilih #select-kegiatan').prop('disabled', false);
				$('.penugasan-kegiatan .petugas-kegiatan').prop('disabled', false);
			}
		});
	}
	
	$('.add-group-monev').click(function () {
		var html = $($('.penugasan-monev-sample').html());
		
		if (Kepegawaian.groupMonevNo == 0) {
			var countGroup = $('.penugasan-monev .monev-section .penugasan-monev-sec').length + 1;
			Kepegawaian.groupMonevNo = countGroup
		}
		else {
			Kepegawaian.groupMonevNo = Kepegawaian.groupMonevNo + 1;
		}
		
		html.find('.penugasan-monev-group-no').text(Kepegawaian.groupMonevNo);
		html.find('.select2-after-dom').addClass('select2').removeClass('select2-after-dom');
		html.find('.datepicker-after-dom').addClass('datepicker').removeClass('datepicker-after-dom');
		
		$('.penugasan-monev .monev-section').append(html);
		
		Select2.init();
		Datepicker.init();
	});
	
	$(document).on('click', '.remove-monev-sec', function () {
		var btnHapus = $(this);
		var groupName = $(this).closest('.penugasan-monev-head').find('label').text();
		
		Swal.fire({
			text: 'Apakah anda yakin menghapus penugasan '+groupName+' ?',
			title: 'Hapus Group Petugas',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Hapus',
			cancelButtonText: 'Batal'
		}).then((result) => {
			if (result.value) {
				btnHapus.closest('.penugasan-monev-sec').remove();
			}
		});
	});
	
	$('.add-group-undangan').click(function () {
		var html = $($('.penugasan-undangan-sample').html());
		
		if (Kepegawaian.groupUndanganNo == 0) {
			var countGroup = $('.penugasan-undangan .undangan-section .penugasan-undangan-sec').length + 1;
			Kepegawaian.groupUndanganNo = countGroup
		}
		else {
			Kepegawaian.groupUndanganNo = Kepegawaian.groupUndanganNo + 1;
		}
		
		html.find('.penugasan-undangan-group-no').text(Kepegawaian.groupUndanganNo);
		html.find('.select2-after-dom').addClass('select2').removeClass('select2-after-dom');
		html.find('.datepicker-after-dom').addClass('datepicker').removeClass('datepicker-after-dom');
		
		$('.penugasan-undangan .undangan-section').append(html);
		
		Select2.init();
		Datepicker.init();
	});
	
	$(document).on('click', '.remove-undangan-sec', function () {
		var btnHapus = $(this);
		var groupName = $(this).closest('.penugasan-undangan-head').find('label').text();
		
		Swal.fire({
			text: 'Apakah anda yakin menghapus penugasan '+groupName+' ?',
			title: 'Hapus Group Petugas',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Hapus',
			cancelButtonText: 'Batal'
		}).then((result) => {
			if (result.value) {
				btnHapus.closest('.penugasan-undangan-sec').remove();
			}
		});
	});
	
	$(document).on('change', '.provinsi-asal', function (e) {
		var provinsi = $(this).val();
		var kabupaten = Kepegawaian.getKabupaten(provinsi);
		var data = [];
		data.push({id:0,text:''});

		$(this).closest('.form-group').find('.kab-asal').empty().trigger("change");

		if (kabupaten.length > 0) {
			var data = [];
			data.push({id:'',text:''});

			$.each(kabupaten, function (i, kab) {
				data.push({id:kab,text:kab});
			});
		}
		$(this).closest('.form-group').find('.kab-asal').select2({data:data});

	});
	
	$(document).on('change', '.provinsi-tujuan', function (e) {
		var provinsi = $(this).val();
		var kabupaten = Kepegawaian.getKabupaten(provinsi);
		var data = [];
		data.push({id:0,text:''});

		$(this).closest('.form-group').find('.kab-tujuan').empty().trigger("change");

		if (kabupaten.length > 0) {
			var data = [];
			data.push({id:'',text:''});

			$.each(kabupaten, function (i, kab) {
				data.push({id:kab,text:kab});
			});
		}
		$(this).closest('.form-group').find('.kab-tujuan').select2({data:data});

	});
}

$(document).on('hidden.bs.modal','#modal-edit-row', function () {
	Kepegawaian.groupMonevNo = 0;
	Kepegawaian.groupUndanganNo = 0;
});

Kepegawaian.approvalPenugasan = function () {
	$('.approve-penugasan').click(function () {
		Swal.fire({
			text: 'Apakah anda menyetujui usulan penugasan ini?',
			title: 'Setuju Penugasan',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Setuju',
			cancelButtonText: 'Batal'
		}).then((result) => {
			if (result.value) {
				var penugasanId = $('.penugasan-id').val();
				
				Loader.start();
				
				$.ajax({
					type: "POST",
					url: "/admin/kepegawaian/saveApprovePenugasan/?v="+Math.random(),
					data: {
						id: penugasanId,
						status: '2',
						version: Math.random()				
					},
					dataType: 'json',
					success: function(obj){
						if (obj.error) {
							Swal.fire({
								icon: 'error',
								title: 'Oops...',
								text: obj.msg,
								showConfirmButton: true,
							});
						}
						else {
							Swal.fire({
								icon: 'success',
								title: 'Sukses...',
								text: obj.msg,
								showConfirmButton: true,
							});
							
							$('.btn-approval').html('<div class="alert alert-success mb-0" role="alert"><h5 class="alert-heading"><span class="material-icons" title="Penugasan Diterima">&#xe8e8;</span> Telah Disetujui</h5><p class="mb-2">Usulan penugasan ini telah berhasil disetujui.</p></div>');
						}
						
						Loader.stop();
					}
				});
			}
		});
	});
}

Kepegawaian.discardPenugasan = function () {
	$('.discard-penugasan').click(function () {
		var modalTolak = '<div id="tolak-penugasan" class="modal fade" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button><h5 class="modal-title">Alasan menolak penugasan</h5></div><div class="modal-body"><textarea class="form-control alasan-tolak" rows="5"></textarea></div><div class="modal-footer"><button type="button" class="btn btn-danger btn-tolak-penugasan mb-0">Tolak</button><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div></div></div></div>';
		
		$('html').append(modalTolak);
		
		$('#tolak-penugasan').modal({backdrop: 'static', keyboard: false});
		$('#tolak-penugasan').modal('show');
	});
	
	$(document).on('click', '.btn-tolak-penugasan', function () {
		var alasan = $('.alasan-tolak').val();
		var penugasanId = $('.penugasan-id').val();
		
		Loader.start();
		
		$.ajax({
			type: "POST",
			url: "/admin/kepegawaian/saveApprovePenugasan/?v="+Math.random(),
			data: {
				id: penugasanId,
				status: '3',
				keterangan: alasan,
				version: Math.random()				
			},
			dataType: 'json',
			success: function(obj){
				$('#tolak-penugasan').modal('hide');
				
				if (obj.error) {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: obj.msg,
						showConfirmButton: true,
					});
				}
				else {
					Swal.fire({
						icon: 'success',
						title: 'Sukses...',
						text: obj.msg,
						showConfirmButton: true,
					});

					$('.btn-approval').html('<div class="alert alert-danger mb-0" role="alert"><h5 class="alert-heading"><span class="material-icons" title="Penugasan Diterima">&#xe8e8;</span> Telah Ditolak</h5><p class="mb-2">Usulan penugasan ini telah berhasil ditolak.</p></div>');
				}
				
				Loader.stop();
			}
		});
	});
}

Kepegawaian.showAlasanTolak = function (id) {
	$.ajax({
		type: "POST",
		url: "/admin/kepegawaian/getJsonPenugasan/?v="+Math.random(),
		data: {
			id: id,
			version: Math.random()				
		},
		dataType: 'json',
		success: function(obj){
			var modalTolak = '<div id="alasan-tolak-penugasan" class="modal fade" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button><h5 class="modal-title">Alasan penugasan ditolak</h5></div><div class="modal-body"><p>'+obj.keterangan+'</p></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div></div></div></div>';
		
			$('html').append(modalTolak);

			$('#alasan-tolak-penugasan').modal({backdrop: 'static', keyboard: false});
			$('#alasan-tolak-penugasan').modal('show');
		}
	});
}

Kepegawaian.batalPenugasan = function (elm) {
	var id = $(elm).attr('data-id');
	var nama = $(elm).attr('data-nama');
	
	Swal.fire({
		text: 'Apakah anda yakin membatalkan penugasan "'+nama+'"?',
		title: 'Batalkan Penugasan',
		icon: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Ya!',
		cancelButtonText: 'Tidak'
	}).then((result) => {
		if (result.value) {
			Loader.start();
			
			$.ajax({
				type: "POST",
				url: "/admin/kepegawaian/batalPenugasan/?v="+Math.random(),
				data: {
					id: id,
					version: Math.random()				
				},
				dataType: 'json',
				success: function(obj){
					Loader.stop();
					
					Swal.fire({
						icon: 'success',
						title: 'Sukses...',
						text: 'Penugasan atas nama "'+nama+'" telah berhasil dibatalkan.',
						showConfirmButton: true,
					}).then(function() {
						location.reload();
					});
				}
			});
		}
	});
}

Kepegawaian.gantiPenugasan = function (elm) {
	var id = $(elm).attr('data-id');
	Loader.start();
	
	$.ajax({
		type: "POST",
		url: "/bootgrids/loadModalForm/?v="+Math.random(),
		data: {
			id: id,
			table: 'penugasan_item',
			view: 'backend/kepegawaian/modal_ganti_petugas',
			version: Math.random()				
		},
		dataType: 'html',
		success: function(html){
			Loader.stop();
			
			var modal = $('<div class="modal fade" id="modal-ganti-petugas" role="dialog" aria-labelledby="modal-edit-row" aria-hidden="true" data-backdrop="static"></div>');
			
			modal.append(html);
			
			$('body').append(modal);
			
			Select2.init();
			Datepicker.init();
			
			$('#modal-ganti-petugas').modal('show');
		}
	});
}

Kepegawaian.ubahPenugasan = function (elm) {
	var id = $(elm).attr('data-id');
	Loader.start();
	
	$.ajax({
		type: "POST",
		url: "/bootgrids/loadModalForm/?v="+Math.random(),
		data: {
			id: id,
			table: 'penugasan_item',
			view: 'backend/kepegawaian/modal_edit_detail_petugas',
			version: Math.random()				
		},
		dataType: 'html',
		success: function(html){
			Loader.stop();
			
			var modal = $('<div class="modal fade" id="modal-ubah-petugas" role="dialog" aria-labelledby="modal-edit-row" aria-hidden="true" data-backdrop="static"></div>');
			
			modal.append(html);
			
			$('body').append(modal);
			
			Select2.init();
			Datepicker.init();
			
			$('#modal-ubah-petugas').modal('show');
		}
	});
}

Kepegawaian.init = function () {
	$('.ganti-penugasan').click(function () {
		Kepegawaian.gantiPenugasan(this);
	});
	
	$('.ubah-penugasan').click(function () {
		Kepegawaian.ubahPenugasan(this);
	});
	
	$('.batal-penugasan').click(function () {
		Kepegawaian.batalPenugasan(this);
	});
	
	$(document).on('submit', '.form-ganti-petugas', function () {
		
		var petugasLama = $('.nama-petugas-lama').val();
		var petugasBaru = $('.nama-petugas-baru').select2('data')[0].text;
		
		Swal.fire({
			text: 'Apakah anda yakin mengganti "'+petugasLama+'" dengan "'+petugasBaru+'"?',
			title: 'Ganti Petugas',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Ya! Ganti',
			cancelButtonText: 'Tidak'
		}).then((result) => {
			if (result.value) {
				Loader.start();
				
				var form = $('.form-ganti-petugas').serializeArray();
				var suratTugas = $('.surat-tugas-baru').prop('files')[0];

				var data = new FormData();

				$.each(form, function (i, val) {
					data.append(val.name, val.value);
				});

				data.append('surat_tugas', suratTugas);
				
				$.ajax({
					url: "/admin/kepegawaian/gantiPenugasan/?v="+Math.random(),
					dataType: 'json',
					cache: false,
					contentType: false,
					processData: false,
					data: data,                        
					type: 'post',
					success: function(obj){
						
						Loader.stop();
						$('.modal').modal('hide');
						
						Swal.fire({
							icon: 'success',
							title: 'Sukses...',
							text: 'Penugasan telah berhasil diganti.',
							showConfirmButton: true,
						}).then(function() {
							location.reload();
						});
					}
				});
			}
		});
		
		return false;
	});
}

$(document).ready(function () {
	//Kepegawaian.bootgridRincianPetugas();
	Kepegawaian.approvalPenugasan();
	Kepegawaian.discardPenugasan();
	Kepegawaian.init();	
});

