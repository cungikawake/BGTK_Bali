var Spj_Keuangan = {};

Spj_Keuangan.formatResult = function (result) {
	return result.nama;
};

Spj_Keuangan.formatRepoSelection = function (repo) {
	return repo.nama;
}

Spj_Keuangan.getKegiatan = function () {
	if ($(".select2-kegiatan").length) {
		
		var option = {};
		option["ajax"] = {
			url: "/admin/spj/kegiatan_typehead",
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
		
		option["templateResult"] = Spj_Keuangan.formatResult;
		option["templateSelection"] = Spj_Keuangan.formatRepoSelection;
		option["minimumInputLength"] = 3;
		option["placeholder"] = "Pilih kegiatan...";
		option["dropdownParent"] = $(".modal-body");
		
		var selected = $(".select2-kegiatan").attr("data-selected-kegiatan");
		
		if (selected == "0" || selected == "") {
			$(".select2-kegiatan").select2(option);
		}
		else {
			$.ajax({
				type: "POST",
				url: "/admin/spj/json_kegiatan/?v="+Math.random(),
				data: {
					id: selected,
					version: Math.random()			
				},
				dataType: 'json',
				success: function(obj){
					option["data"] = [obj];
					$(".select2-kegiatan").select2(option);
				}
			});
		}
		
		$(".select2-kegiatan").on('select2:select', function (e) {
			var data = e.params.data;
			
			$('[name="nama"]').val(data.nama);
		});
	}
}

Spj_Keuangan.getPenugasan = function () {
	if ($(".select2-penugasan").length) {
		
		var opt = {};
		
		if ($(".modal-body").length) {
			opt = {dropdownParent: $(".modal-body")};
		}
		
		$('.select2-penugasan').select2(opt);
		
		$(".select2-penugasan").on('select2:select', function (e) {
			var data = $(this).select2('data')
			
			$('[name="nama"]').val(data[0].text);
		});
		
		/*var option = {};
		option["ajax"] = {
			url: "/admin/spj/penugasan_typehead",
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
		
		option["templateResult"] = Spj_Keuangan.formatResult;
		option["templateSelection"] = Spj_Keuangan.formatRepoSelection;
		option["minimumInputLength"] = 3;
		option["placeholder"] = "Pilih penugasan...";
		
		var selected = $(".select2-penugasan").attr("data-selected-penugasan");
		
		if (selected == "0" || selected == "") {
			$(".select2-penugasan").select2(option);
		}
		else {
			$.ajax({
				type: "POST",
				url: "/admin/spj/json_penugasan/?v="+Math.random(),
				data: {
					id: selected,
					version: Math.random()			
				},
				dataType: 'json',
				success: function(obj){
					option["data"] = [obj];
					$(".select2-penugasan").select2(option);
				}
			});
		}
		
		
		$(".select2-penugasan").on('select2:select', function (e) {
			var data = e.params.data;
			
			$('[name="nama"]').val(data.nama);
		});*/
	}
}

Spj_Keuangan.editBtn = function (e) {
	var id = $(e).attr("data-id");
	
	$.ajax({
		url: "/admin/spj/modal_edit_spj/",
		dataType: 'html',
		data: {
			id: id,
			version: Math.random()
		},                        
		type: 'POST',
		success: function(html){
			$('body').append(html);

			var opt = {};

			if ($(".modal-body").length) {
				opt = {dropdownParent: $(".modal-body")};
			}

			$('.modal-body .select2').select2(opt);

			Spj_Keuangan.getKegiatan();
			Spj_Keuangan.getPenugasan();

			$('#add-spj-modal').modal('show');
		}
	 });
}

Spj_Keuangan.deleteBtn = function (e) {
	var id = $(e).attr("data-id");
	
	Swal.fire({
		title: 'Delete SPJ Keuangan?',
		text: "Apakah anda yakin untuk menghapus spj ini?",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Hapus',
		cancelButtonText: 'Batal'
	}).then((result) => {
		if (result.value) {
			Loader.start();
			
			$.ajax({
				url: "/admin/spj/delete_spj/",
				dataType: 'json',
				data: {
					id: id,
					version: Math.random()
				},                        
				type: 'POST',
				success: function(obj){
					var current = $('#grid-data-footer .pagination .active').removeClass("active").removeClass("disabled");
					current.find("a").click();
					current.addClass("active");
					
					var current = $('#grid-data-kegiatan-footer .pagination .active').removeClass("active").removeClass("disabled");
					current.find("a").click();
					current.addClass("active");
					
					Loader.stop();
				}
			 });
		}
	});
}

Spj_Keuangan.import = function (id, urutan) {
	Loader.start();
	
	$.ajax({
		url: "/admin/spj/import_spj_item/",
		dataType: 'json',
		data: {
			id: id,
			urutan: urutan,
			version: Math.random()
		},                        
		type: 'POST',
		success: function(obj){
			var tableId = $('.spj-items').find('.bootgrid-header').attr('id').replace("-header","");
			Table.refreshTable(tableId);
			
			Spj_Keuangan.loadTableRalisasi();
			
			$('.modal').modal('hide');
			Loader.stop();
			
			if (obj.error) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: obj.msg
				});
			}
			else {
				Swal.fire({
				  icon: 'success',
					title: 'Sukses...',
				  text: obj.msg,
				  showConfirmButton: true,
				});
			}
		}
	 });
}

Spj_Keuangan.pay = function (e) {
	var elm = $(e);
	var id = elm.attr('data-id');
	var nama = elm.attr('data-nama');

	Swal.fire({
		title: 'Bayarkan SPJ?',
		text: "Apakah anda yakin membayarkan SPJ ini?",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Bayarkan',
		cancelButtonText: 'Batal'
	}).then((result) => {
		if (result.value) {
			$.ajax({
				type: "POST",
				url: "/admin/spj/updatePaid/?v="+Math.random(),
				data: {
					id: id,
					paid: 1,
					version: Math.random()				
				},
				dataType: 'json',
				success: function(obj){
					var tableId = $('.spj-items').find('.bootgrid-header').attr('id').replace("-header","");
					Table.refreshTable(tableId);
					
					Swal.fire({
					  icon: 'success',
						title: 'Sukses...',
					  text: "Berhasil mengubah status menjadi dibayarkan",
					  showConfirmButton: true,
					});
				}
			});
		}
	});
}

Spj_Keuangan.getPenerimaSPBy = function (element, optionUrl, selectedUrl) {
	if (element.length) {
		
		var option = {};
		option["ajax"] = {
			url: optionUrl+Math.random(),
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
		
		option["templateResult"] = Spj_Keuangan.formatResult;
		option["templateSelection"] = Spj_Keuangan.formatRepoSelection;
		option["minimumInputLength"] = 3;
		option["placeholder"] = "Pilih nama...";
		
		var selected = element.attr("data-selected");
		
		if (selected == "0") {
			element.select2(option);
			
			element.on('select2:select', function (e) {
				var data = e.params.data;
				element.closest('.form-group').find('.nama-penerima-spby').val(data.nama);
				element.closest('.form-group').find('.nip-penerima-spby').val(data.nip);
			});
		}
		else {
			$.ajax({
				type: "POST",
				url: selectedUrl+Math.random(),
				data: {
					id: selected,
					version: Math.random()				
				},
				dataType: 'json',
				success: function(obj){
					if (obj.length) {
						option["data"] = obj;
					}
					
					element.select2(option);
					
					element.on('select2:select', function (e) {
						var data = e.params.data;
						element.closest('.form-group').find('.nama-penerima-spby').val(data.nama);
						element.closest('.form-group').find('.nip-penerima-spby').val(data.nip);
					});
				}
			});
		}
	}
}

Spj_Keuangan.getItemSPBy = function (spjId, spbyId, akun, tglSpby) {
	Loader.start();
	
	$.ajax({
		url: "/admin/spj/list_spby_item/",
		dataType: 'html',
		data: {
			spj_id: spjId,
			spby_id: spbyId,
			akun: akun,
			tgl_spby: tglSpby,
			version: Math.random()
		},                        
		type: 'POST',
		success: function(html){
			Loader.stop();
			$('.spby-items').html(html);
		}
	 });
}

Spj_Keuangan.printSPBy = function (elm, printPaketMeeting) {
	var id = $(elm).attr('data-id');
	
	Loader.start();
	
	$.ajax({
		url: "/admin/spj/print_kelengkapan_spby/",
		dataType: 'json',
		data: {
			id: id,
			version: Math.random()
		},                        
		type: 'POST',
		success: function(obj){
			Loader.stop();
			
			var win = window.open("/admin/spj/print_spby/"+id, '_blank');
			
			//if (obj.sppd == "1") {
				var win2 = window.open("/admin/spj/spd_paket_meeting/"+id, '_blank');
			//}
			
			////if (obj.daftar_hadir == "1") {
				var win2 = window.open("/admin/spj/print_daftar_hadir/"+id, '_blank');
			//}
		}
	 });
}


Spj_Keuangan.loadTableRalisasi = function () {
	var spjId = $('.spj_id').val();

	$.ajax({
		type: "POST",
		url: "/admin/spj/loadTableRealisasi/?v="+Math.random(),
		data: {
			spj_id: spjId,
			version: Math.random()				
		},
		dataType: 'html',
		success: function(html){
			$('#table-realisasi').html(html);
			
			$('#table-realisasi a.nav-link').click(function (e) {
				e.preventDefault();
				$(this).tab('show');
			});
			
			$('#table-realisasi .nav-tabs a.first-tab').tab('show');
		}
	});
}

Spj_Keuangan.updateLock = function (e) {
	var btn = $(e);
	
	var id = btn.attr('data-id');
	var table = btn.attr('data-table');
	var val = btn.attr('value');

	$.ajax({
		type: "POST",
		url: "/admin/spj/updateLock/?v="+Math.random(),
		data: {
			id: id,
			table: table,
			value: val,
			version: Math.random()				
		},
		dataType: 'json',
		success: function(obj){			
			if (val == "1") {
				btn.attr('title','Unlock').attr('value','0').css('color','#f44236');
				btn.html('<i class="fas fa-lock"></i>');
			}
			else {
				btn.attr('title','Lock').attr('value','1').css('color','#999');
				btn.html('<i class="fas fa-unlock-alt"></i>');
			}
		}
	});
}

Spj_Keuangan.exportMCM = function (e) {
	var id = $(e).attr("data-id");
	
	console.log(id);
	
	var win = window.open('/admin/spj/export_mcm_spby/'+id, '_blank');
	
	if (win) {
		//Browser has allowed it to be opened
		win.focus();
	} else {
		//Browser has blocked it
		alert('Please allow popups for this website');
	}
}

Spj_Keuangan.paySPBy = function (e) {
	var id = $(e).attr("data-id");
	
	Swal.fire({
		title: 'Bayarkan SPBy?',
		text: "Apakah anda yakin membayarkan semua item pada SPBy ini?",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Bayarkan',
		cancelButtonText: 'Batal'
	}).then((result) => {
		if (result.value) {
			Loader.start();
			
			$.ajax({
				type: "POST",
				url: "/admin/spj/paySPBy/?v="+Math.random(),
				data: {
					id: id,
					version: Math.random()			
				},
				dataType: 'json',
				success: function(obj){
					var tableId = $(e).closest('table').attr('id');
					Table.refreshTable(tableId);

					Swal.fire({
						icon: 'success',
						title: 'Sukses...',
						text: "Berhasil membayarkan item pada SPBy.",
						showConfirmButton: true,
					});
					
					Loader.stop();
				}
			});
		}
	});
}

Spj_Keuangan.calculateSpbyItems = function () {
	var jumlah = 0;
	var pajak = 0;
	var transfer = 0;
	
	$("input:checkbox.select-spby-item:checked").each(function(){
		var itemId = $(this).val();
		var spjVal = parseInt($('.item-value-'+itemId).val());
		var pajakVal = parseInt($('.item-pajak-'+itemId).val());
		var TransferVal = parseInt($('.item-transfer-'+itemId).val());
		
		jumlah = jumlah + spjVal;
		pajak = pajak + pajakVal;
		transfer = transfer + TransferVal;
	});
	
	$('.jumlah-spby').val(jumlah).trigger("keypress");
	$('.jumlah-pajak').val(pajak).trigger("keypress");
	$('.jumlah-transfer').val(transfer).trigger("keypress");
}

Spj_Keuangan.changeSpbyItems = function () {
	var spjId = $('[name="spj_id"]').val();
	var spbyId = $('[name="spby_id"]').val();
	var akun = $('.spby_akun[name="dipa_akun"]').val();
	var tglSpby = $('[name="tgl_spby"]').val();
	
	Spj_Keuangan.getItemSPBy(spjId, spbyId, akun, tglSpby);
}

Spj_Keuangan.init = function () {
	$(document).on('click', '#bootgrid-add-grid-data', function () {
		Loader.start();
		
		$.ajax({
			url: "/admin/spj/modal_edit_spj/",
			dataType: 'html',
			data: {
				id: '',
				version: Math.random()
			},                        
			type: 'POST',
			success: function(html){
				$('body').append(html);

				var opt = {};

				if ($(".modal-body").length) {
					opt = {dropdownParent: $(".modal-body")};
				}

				$('.modal-body .select2').select2(opt);
				
				Spj_Keuangan.getPenugasan();

				$('#add-spj-modal').modal('show');
				Loader.stop();
			}
		 });
	});

	$(document).on('click', '#bootgrid-add-grid-data-kegiatan', function () {
		Loader.start();
		
		$.ajax({
			url: "/admin/spj/modal_edit_spj_kegiatan/",
			dataType: 'html',
			data: {
				id: '',
				version: Math.random()
			},                        
			type: 'POST',
			success: function(html){
				$('body').append(html);

				var opt = {};

				if ($(".modal-body").length) {
					opt = {dropdownParent: $(".modal-body")};
				}

				$('.modal-body .select2').select2(opt);
				
				Spj_Keuangan.getKegiatan();

				$('#add-spj-modal').modal('show');
				Loader.stop();
			}
		 });
	});
	
	$(document).on('change', '.tipe-tugas', function () {
		var tipe = $(this).val();
		
		if (tipe == "monev") {
			$('.opt-kegiatan').hide();
			$('.opt-monev').show();
			
			$('.opt-kegiatan .select2-kegiatan').prop('disabled', true);
			$('.opt-monev .select2-penugasan').prop('disabled', false);
		}
		else {
			$('.opt-kegiatan').show();
			$('.opt-monev').hide();
			
			$('.opt-kegiatan .select2-kegiatan').prop('disabled', false);
			$('.opt-monev .select2-penugasan').prop('disabled', true);
		}
	});
	
	$(document).on('submit', '.form-spj', function () {
		Loader.start();
		
		var data = $(this).serializeArray();
		
		$.ajax({
			url: "/admin/spj/save_spj/?v="+Math.random(),
			dataType: 'json',
			data: data,                        
			type: 'POST',
			success: function(obj){
				Loader.stop();
				$('#add-spj-modal').modal('hide');
				
				var current = $('#grid-data-footer .pagination .active').removeClass("active").removeClass("disabled");
				current.find("a").click();
				current.addClass("active");
				
				var current = $('#grid-data-kegiatan-footer .pagination .active').removeClass("active").removeClass("disabled");
				current.find("a").click();
				current.addClass("active");
			}
		});
		
		return false;
	});
	
	
	$(document).on('submit', '.form-spj-option', function () {
		var valid = true;
		var requiredError = '';
		
		var requires = $('.form-spj-option').find(".required");
		
		requires.each(function () {
			var name = $(this).attr('data-name');
			var value = $(this).val();
			
			if (value == "") {
				valid = false;
				
				if (requiredError != "") {
					requiredError += ', ';
				}
				
				requiredError += name;
			}
		});
		
		if (valid) {
			Swal.fire({
				title: 'Apakah anda yakin?',
				text: "Penerapan opsi ini akan menimpa semua rincian pada SPJ Kecuali item terkunci",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Lanjutkan!',
				cancelButtonText: 'Batal'
			}).then((result) => {
								
				if (result.value) {
					Loader.start();
					
					AutoNumeric.destroy();

					var data = $('.form-spj-option').serializeArray();

					$.ajax({
						url: "/admin/spj/save_spj_based/?v="+Math.random(),
						dataType: 'json',
						data: data,                        
						type: 'POST',
						success: function(obj){
							AutoNumeric.init();

							var tableId = $('.spj-items').find('.bootgrid-header').attr('id').replace("-header","");
							Table.refreshTable(tableId);

							Spj_Keuangan.loadTableRalisasi();

							Loader.stop();

							Swal.fire({
							  icon: 'success',
								title: 'Sukses...',
							  text: "Berhasil menerapkan opsi ini",
							  showConfirmButton: true,
							});
							
							$('.keg-opt-form [type="submit"]').prop("disabled", true);
						}
					});
				}
			});
		}
		else {
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: "Form "+requiredError+" tidak boleh kosong."
			});
		}
		
		return false;
	});
	
	$(document).on("click",".btn-submit-mcm", function () {
		var downloadVal = $(this).attr("value");
		$('.form-mcm-transfer [name="download"]').val(downloadVal);
	});
	
	$(document).on("submit",".form-mcm-transfer", function () {
		Loader.start();
		
		var data = $(this).serializeArray();
		var id = $('.mcm_spby_id').val();
		
		$.ajax({
			url: "/admin/spj/save_mcm_transfer/?v="+Math.random(),
			dataType: 'json',
			data: data,                        
			type: 'POST',
			success: function(obj){
				$("#modal-button-row").modal('hide');
				
				var win = window.open('/admin/spj/export_mcm_spby/'+id+'/'+obj.download, '_blank');
	
				if (win) {
					//Browser has allowed it to be opened
					win.focus();
				} else {
					//Browser has blocked it
					alert('Please allow popups for this website');
				}
				
				Loader.stop();
			}
		});
		
		return false;
	});

	$(document).on("submit",".form-daftar-hadir", function () {
		Loader.start();
		
		var data = $(this).serializeArray();
		
		$.ajax({
			url: "/admin/spj/save_daftar_hadir/?v="+Math.random(),
			dataType: 'json',
			data: data,                        
			type: 'POST',
			success: function(obj){
				
				if (obj.error) {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: "Gagal menyimpan daftar hadir."
					});
				}
				else {
					Swal.fire({
						icon: 'success',
						title: 'Sukses...',
						text: "Berhasil menyimpan daftar hadir.",
						showConfirmButton: true,
					});
					
					var tableId = $(".daftar-hadir-kegiatan").find('.bootgrid-table').attr("id");
					Table.refreshTable(tableId);
				}
				
				$(".modal").modal('hide');
				
				Loader.stop();
			}
		});
		
		return false;
	});
	
	$(document).on('change', '.updateST', function () {
		var id = $(this).attr('data-id');

		if ($(this).is(':checked')) {
			var value = 1;
		}
		else {
			var value = 0;
		}
		
		$.ajax({
			type: "POST",
			url: "/admin/spj/updateST/?v="+Math.random(),
			data: {
				id: id,
				surat_tugas: value,
				version: Math.random()				
			},
			dataType: 'json',
			success: function(obj){
			}
		});
	});
	
	$(document).on('change', '.updateSPD', function () {
		var id = $(this).attr('data-id');

		if ($(this).is(':checked')) {
			var value = 1;
		}
		else {
			var value = 0;
		}

		$.ajax({
			type: "POST",
			url: "/admin/spj/updateSPD/?v="+Math.random(),
			data: {
				id: id,
				spd: value,
				version: Math.random()				
			},
			dataType: 'json',
			success: function(obj){
			}
		});
	});
	
	$(document).on('change', '[type="checkbox"].updateLP', function () {
		var id = $(this).attr('data-id');
		var checkbox = $(this);

		if ($(this).is(':checked')) {
			var value = 1;
		}
		else {
			var value = 0;
		}
		
		
		Swal.fire({
			title: 'Terima Laporan Perjaalanan Dinas?',
			text: "Apakah anda yakin menerima laporan perjalanan dinas ini?",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Terima',
			cancelButtonText: 'Batal'
		}).then((result) => {
			if (result.value) {
				
				Loader.start();
				
				$.ajax({
					type: "POST",
					url: "/admin/spj/updateLP/?v="+Math.random(),
					data: {
						id: id,
						laporan: value,
						version: Math.random()				
					},
					dataType: 'json',
					success: function(obj){
						if (obj.error) {
							Swal.fire({
								icon: 'error',
								title: 'Oops...',
								text: obj.msg
							});
							
							checkbox.prop("checked", false);
						}
						else {
							checkbox.attr("disabled", "disabled");
						}
						
						Loader.stop();
					}
				});
			}
			else {
				checkbox.prop("checked", false);
			}
		});
	});
	
	$(document).on('change', '.approve-dipa', function () {
		var disableBtn = $('.possible-use-dipa-balai').val();
		var dipaBalai = $(this).val();
		
		if (dipaBalai == "1") {
			$('.use-dipa-balai').show();
			$('.use-dipa-penyelenggara').hide();
			
			if (disableBtn == "1") {
				$('button.approve-perjadin').removeAttr("disabled");
			}
			else {
				$('button.approve-perjadin').attr("disabled","disabled");
			}
		}
		else {
			$('.use-dipa-balai').hide();
			$('.use-dipa-penyelenggara').show();
			$('button.approve-perjadin').removeAttr("disabled");
		}
	});
	
	$(document).on('click','.tolak-perjadin', function () {
		var id = $(this).attr('data-id');
		
		var modalTolak = '<div id="modal-tolak-perjadin" class="modal fade" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button><h5 class="modal-title">Alasan menolak laporan perjalanan dinas</h5></div><div class="modal-body"><textarea class="form-control alasan-tolak" rows="5"></textarea></div><div class="modal-footer"><button type="button" class="btn btn-danger btn-tolak-perjadin" data-id="'+id+'">Tolak</button><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button></div></div></div></div>';
		
		$('html').append(modalTolak);
		
		$('#modal-button-row').modal('hide');
		$('#modal-tolak-perjadin').modal({backdrop: 'static', keyboard: false});
		$('#modal-tolak-perjadin').modal('show');
		
		$('.alasan-tolak').focus();
	});
	
	$(document).on('click','.btn-tolak-perjadin', function () {
		var id = $(this).attr('data-id');
		var status = '4';
		var keterangan = $('.alasan-tolak').val();
		
		Loader.start();
		
		$.ajax({
			type: "POST",
			url: "/admin/user/saveApprovePerjadin/?v="+Math.random(),
			data: {
				id: id,
				status: status,
				keterangan: keterangan,
				version: Math.random()				
			},
			dataType: 'json',
			success: function(obj){
				if (obj.error) {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: obj.msg
					}).then(function() {

					});
				}
				else {
					Swal.fire({
						icon: 'success',
						title: 'Sukses...',
						text: obj.msg,
						showConfirmButton: true,
					});
				}
				
				$('#modal-tolak-perjadin').modal('hide');
				
				var tableId = $('.bootgrid-header').attr('id').replace('-header','');
				Table.refreshTable(tableId);
				
				Loader.stop();
			}
		});
	});
	
	$(document).on('submit','.form-approve-perjadin', function () {
		
		Swal.fire({
			text: 'Apakah anda yakin menyetujui laporan perjalanan dinas ini?',
			title: 'Setujui Laporan',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Setuju',
			cancelButtonText: 'Batal'
		}).then((result) => {
			if (result.value) {
				Loader.start();
				AutoNumeric.destroy();
				
				var data = $('.form-approve-perjadin').serializeArray();

				$.ajax({
					type: "POST",
					url: "/admin/user/saveApprovePerjadin/?v="+Math.random(),
					data: data,
					dataType: 'json',
					success: function(obj){
						if (obj.error) {
							Swal.fire({
								icon: 'error',
								title: 'Oops...',
								text: obj.msg,
								showConfirmButton: true
							});
						}
						else {
							Swal.fire({
								icon: 'success',
								title: 'Sukses...',
								text: obj.msg,
								showConfirmButton: true
							});
						}

						$('.table-penugasan_item').modal('hide');

						var tableId = $('.bootgrid-header').attr('id').replace('-header','');
						Table.refreshTable(tableId);
						Loader.stop();
					}
				});
			}
		});
		
		return false;
	});
	
	
	if ($('#table-realisasi').length) {
		Spj_Keuangan.loadTableRalisasi();
	}
	
	if ($('#select_spby').length) {
		var spjId = $('.spj_id').val();
		var element = $('#select_spby');

		var optionUrl = "/admin/spj/typehead/"+spjId+"/";
		var selectedUrl = "/admin/spj/selected_spby/";

		Spj_Keuangan.getPenerimaSPBy(element, optionUrl, selectedUrl);
	}
	
	if ($('#select_spby_honor').length) {
		var spjId = $('.spj_id').val();
		var element = $('#select_spby_honor');

		var optionUrl = "/admin/spj/typehead/"+spjId+"/";
		var selectedUrl = "/admin/spj/selected_spby/";

		Spj_Keuangan.getPenerimaSPBy(element, optionUrl, selectedUrl);
	}

	var grid = $("#grid-data").bootgrid({
		selection: true,
		multiSelect: true,
		keepSelection: true,
		rowCount: 15,
		requestHandler: function (request) {
			var model = {};

			model.current = request.current;
			model.rowCount = request.rowCount;
			model.search = request.searchPhrase;
			model.sort = request.sort;

			return JSON.stringify(model);
		},
		ajaxSettings: {
			method: "POST",
			contentType: "application/json"
		},
		ajax: true,
		url: "/admin/spj/json_list/"
	}).on("loaded.rs.jquery.bootgrid", function() {
		if (!$("#grid-data-header").find(".bootgrid-add-btn").length) {
			$("<a id='bootgrid-add-grid-data' class='bootgrid-add-btn btn btn-info'>Buat SPJ</a>").insertBefore("#grid-data-header .actionBar .actions");
		}
		
		$('#grid-data tr.success').removeClass('success');
	});
	
	
	var grid = $("#grid-data-kegiatan").bootgrid({
		selection: true,
		multiSelect: true,
		keepSelection: true,
		rowCount: 15,
		requestHandler: function (request) {
			var model = {};

			model.current = request.current;
			model.rowCount = request.rowCount;
			model.search = request.searchPhrase;
			model.sort = request.sort;

			return JSON.stringify(model);
		},
		ajaxSettings: {
			method: "POST",
			contentType: "application/json"
		},
		ajax: true,
		url: "/admin/spj/json_list_kegiatan/"
	}).on("loaded.rs.jquery.bootgrid", function() {
		if (!$("#grid-data-kegiatan-header").find(".bootgrid-add-btn").length) {
			$("<a id='bootgrid-add-grid-data-kegiatan' class='bootgrid-add-btn btn btn-info'>Buat SPJ</a>").insertBefore("#grid-data-kegiatan-header .actionBar .actions");
		}
		
		$('#grid-data-kegiatan tr.success').removeClass('success');
	});
	
	$(document).on('click', '.keg-opt-form .nav-tabs .nav-link', function () {
		var id = $(this).attr('aria-controls');
		var navTabs = $(this).closest('.nav-tabs');
		
		if($('.keg-opt-form [type="submit"]').is(':disabled')){
			navTabs.find('.nav-link').removeClass('active');
			$(this).addClass('active');

			$(".keg-opt-form .tab-content .tab-pane :input").prop("disabled", true);

			$('.keg-opt-form .tab-content .tab-pane').removeClass('show active');
			$('.keg-opt-form .tab-content #'+id).addClass('show active');
			$('.keg-opt-form .tab-content #'+id+" :input").prop("disabled", false);
		}
		else {
			Swal.fire({
				title: 'Abaikan Perubahan?',
				text: "Perubahan belum disimpan. Apakah anda yakin mengabaikan perubahan?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Ya!',
				cancelButtonText: 'Tidak'
			}).then((result) => {
								
				if (result.value) {
					navTabs.find('.nav-link').removeClass('active');
					$(this).addClass('active');

					$(".keg-opt-form .tab-content .tab-pane :input").prop("disabled", true);

					$('.keg-opt-form .tab-content .tab-pane').removeClass('show active');
					$('.keg-opt-form .tab-content #'+id).addClass('show active');
					$('.keg-opt-form .tab-content #'+id+" :input").prop("disabled", false);
					
					$('.keg-opt-form [type="submit"]').prop("disabled", true);
				}
			});
		}
	});
	
	$(document).on("change", ".keg-opt-form .tab-content .tab-pane :input", function () {
		$('.keg-opt-form [type="submit"]').prop("disabled", false);
	});
	
	$(document).on('click', '.modal .nav-tabs .nav-link', function () {
		var id = $(this).attr('aria-controls');
		var navTabs = $(this).closest('.nav-tabs');
		
		navTabs.find('.nav-link').removeClass('active');
		$(this).addClass('active');
		
		$('.modal .tab-content .tab-pane').removeClass('show active');
		$('.modal .tab-content #'+id).addClass('show active');
	});
	
	$(document).on("click",".btn-import-data-spj", function () {
		var id = $(this).attr('data-spj');
		var orderBy = "pendaftaran";

		if ($('[name="order"]').length) {
			orderBy = $('[name="order"]').val();
		}

		Spj_Keuangan.import(id, orderBy);
	});
	
	$(document).on("change", ".select-spby-item", function () {
		Spj_Keuangan.calculateSpbyItems();
	});
	
	$(document).on("change", ".select-all-item-spby", function () {
		if($(this).is(':checked')){
			$('.select-spby-item').prop('checked', true);
		}
		else {
			$('.select-spby-item').prop('checked', false);
		}
		
		Spj_Keuangan.calculateSpbyItems();
	});
	
	$(document).on("change", ".spby_akun", function () {
		Spj_Keuangan.changeSpbyItems();
	});
	
	
	$(document).on('click', '.print_rincian_perjalanan_dinas', function () {
		var cardId = $(this).closest('.card').attr("id");
		var checked = $('#'+cardId+' .select-box:checkbox:checked');
		
		if (checked.length) {
			Loader.start();
			
			var item = [];
			
			$('#'+cardId+' .select-box:checkbox:checked').each(function () {
				item.push($(this).val());
			});
			
			var win = window.open("/admin/spj/print_selected_item/"+item.join('_'), '_blank');

			if (win) {
				//Browser has allowed it to be opened
				win.focus();
			} else {
			//	//Browser has blocked it
				alert('Please allow popups for this website');
			}

			Loader.stop();
		}
		else {
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: "Tidak ada item yang dipilih"
			});
		}
	});
	
	$(document).on('click', '.print_amplop', function () {
		var cardId = $(this).closest('.card').attr("id");
		var checked = $('#'+cardId+' .select-box:checkbox:checked');
		
		if (checked.length) {
			Loader.start();
			
			var item = [];
			
			$('#'+cardId+' .select-box:checkbox:checked').each(function () {
				item.push($(this).val());
			});
			
			var win = window.open("/admin/spj/print_amplop/"+item.join('_'), '_blank');

			if (win) {
				//Browser has allowed it to be opened
				win.focus();
			} else {
			//	//Browser has blocked it
				alert('Please allow popups for this website');
			}

			Loader.stop();
		}
		else {
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: "Tidak ada item yang dipilih"
			});
		}
	});
	
	$(document).on('click','.btn-rinci-tgl-tgs', function () {
		var form = $("#form-rinci-tgl-tgs").html();
		var countRincianTgl = $("#rinci-tgl-tgs").find('.form-rincian-tgl').length;

		if (countRincianTgl < 1) {
			var html = '<div class="col-md-12 label-rincian-tgl-tgs"><label>Rincian Tanggal Tugas</label></div>';
			$("#rinci-tgl-tgs").append(html);
		}
		
		$('.btn-rinci-tgl-tgs').html('Tambah tanggal tugas');
		
		var noRincian = countRincianTgl + 1;
		var form = $(form).find('.no-rincian-tgl').html(noRincian).closest('.form-rincian-tgl');

		$("#rinci-tgl-tgs").append(form);
		$('.default-tgl-tgs').hide();

		Datepicker.init();
	});
	
	$(document).on('click','.remove-rinci-tgl-tugas', function () {
		var form = $(this).closest('.form-rincian-tgl');
		
		Swal.fire({
			title: 'Hapus tanggal tugas?',
			text: "Apakah anda yakin untuk menghapus tanggal tugas ini?",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Hapus',
			cancelButtonText: 'Batal'
		}).then((result) => {
			if (result.value) {
				form.remove();
				
				var countRincianTgl = $("#rinci-tgl-tgs").find('.form-rincian-tgl').length;

				if (countRincianTgl < 1) {
					$('.label-rincian-tgl-tgs').remove();
					$('.default-tgl-tgs').show();
					$('.btn-rinci-tgl-tgs').html('Rinci tanggal tugas');
				}
				else {
					var no = 1;
					$("#rinci-tgl-tgs").find('.form-rincian-tgl').each(function () {
						$(this).find('.no-rincian-tgl').html(no);
					
						no++;
					});
				}
			}
		});
		
	});
	
	$(document).on('click','.bootgrid-lock-btn', function () {
		var btn = $(this);
		var spj = $(this).attr("data-spj");
		var val = $(this).attr("data-lock");

		$.ajax({
			type: "POST",
			url: "/admin/spj/updateLockAll/?v="+Math.random(),
			data: {
				spj_id: spj,
				value: val,
				version: Math.random()				
			},
			dataType: 'json',
			success: function(obj){
				if (val == "1") {
					btn.attr('title','Unlock All').attr('data-lock','0');
					btn.html('<span class="fas fa-lock"></span>');
				}
				else {
					btn.attr('title','Lock All').attr('data-lock','1');
					btn.html('<span class="fas fa-unlock-alt"></span>');
				}

				//btn.parent().find('.btn[title="Refresh"]').click();

				var tableId = btn.closest(".card").find('.bootgrid-table').attr("id");
				Table.refreshTable(tableId);
			}
		});
	});
	
	$(document).on('change','.cal-apr-perjadin', function () {
		let rupiahIndonesia = Intl.NumberFormat('id-ID');
		
		var tiketBerangkat = $(".cal-apr-perjadin.cal-apr-pesawat-berangkat").val();
		var tiketPulang = $(".cal-apr-perjadin.cal-apr-pesawat-pulang").val();
		var taksiAsal = $(".cal-apr-perjadin.cal-apr-taksi-asal").val();
		var taksiTujuan = $(".cal-apr-perjadin.cal-apr-taksi_pulang").val();
		
		var transport = $(".cal-apr-perjadin.cal-apr-transport").val();
		var transportLainnya = $(".cal-apr-perjadin.cal-apr-transport-lainnya").val();
		var uangHarian = $(".cal-apr-perjadin.cal-apr-uang-harian").val();
		var penginapan = $(".cal-apr-perjadin.cal-apr-penginapan").val();
		var lamaTugas = parseInt($(".cal-apr-lama-tugas").val());
		var lamaNginap = lamaTugas-1;
		
		var calTiketBerangkat = parseInt(tiketBerangkat.replace(/\./g,'')) || 0;
		var calTiketPulang = parseInt(tiketPulang.replace(/\./g,'')) || 0;
		var calTaksiAsal = parseInt(taksiAsal.replace(/\./g,'')) || 0;
		var calTaksiTujuan = parseInt(taksiTujuan.replace(/\./g,'')) || 0;
		var calTransport = parseInt(transport.replace(/\./g,'')) || 0;
		var calTransportLainnya = parseInt(transportLainnya.replace(/\./g,'')) || 0;
		var calUangHarian = parseInt(uangHarian.replace(/\./g,'')) || 0;
		var calPenginapan = parseInt(penginapan.replace(/\./g,'')) || 0;
		
		var totalUangHarian = calUangHarian*lamaTugas;
		var totalPenginapan = calPenginapan*lamaNginap;
		var totalDiterima = calTiketBerangkat+calTiketPulang+calTaksiAsal+calTaksiTujuan+calTransport+calTransportLainnya+totalUangHarian+totalPenginapan;
		
		$('.row-cal').addClass("hide");

		if (calTiketBerangkat > 0) { $('.row-tiket-berangkat').removeClass("hide"); }
		if (calTiketPulang > 0) { $('.row-tiket-pulang').removeClass("hide"); }
		if (calTaksiAsal > 0) { $('.row-taksi-asal').removeClass("hide"); }
		if (calTaksiTujuan > 0) { $('.row-taksi-tujuan').removeClass("hide"); }
		if (calTransport > 0) { $('.row-transport').removeClass("hide"); }
		if (calTransportLainnya > 0) { $('.row-transport-lainnya').removeClass("hide"); }
		if (totalUangHarian > 0) { $('.row-total-uang-harian').removeClass("hide"); }
		if (totalPenginapan > 0) { $('.row-total-penginapan').removeClass("hide"); }

		$('.row-cal:not(.hide)').each(function (i) {
			var no = i+1;
			$(this).find(".row-cal-no").text(no);
		});

		$('.apr-uang-harian').html("Rp. "+rupiahIndonesia.format(calUangHarian));
		$('.apr-penginapan').html("Rp. "+rupiahIndonesia.format(calPenginapan));
		
		$('.apr-total-tiket-berangkat').html("Rp. "+rupiahIndonesia.format(calTiketBerangkat));
		$('.apr-total-tiket-pulang').html("Rp. "+rupiahIndonesia.format(calTiketPulang));
		$('.apr-total-taksi-asal').html("Rp. "+rupiahIndonesia.format(calTaksiAsal));
		$('.apr-total-taksi-tujuan').html("Rp. "+rupiahIndonesia.format(calTaksiTujuan));
		$('.apr-total-transport').html("Rp. "+rupiahIndonesia.format(calTransport));
		$('.apr-total-transport-lainnya').html("Rp. "+rupiahIndonesia.format(calTransportLainnya));
		$('.apr-total-uang-harian').html("Rp. "+rupiahIndonesia.format(totalUangHarian));
		$('.apr-total-penginapan').html("Rp. "+rupiahIndonesia.format(totalPenginapan));
		$('.apr-total-diterima').html("Rp. "+rupiahIndonesia.format(totalDiterima));
	});
	
	$(document).on("click", ".show-ket-trans", function () {
		$(".row-keterangan-trans").slideToggle("fast");
	});
	
	$(document).on("click", ".show-ket-trans-lainnya", function () {
		$(".row-keterangan-trans-lainnya").slideToggle("fast");
	});
	
	$(document).on("click", ".show-ket-penginapan", function () {
		$(".row-keterangan-penginapan").slideToggle("fast");
	});
	
	$(document).on("change", ".keterangan_trans_lainnya", function () {
		var ket = $(this).val();
		$('.apr-keterangan-transport-lainnya').html(ket);
	});
	
	if ($('#barcode-reader').length) {
		$('#barcode-reader').focus();	
	}
	
	$(document).on("submit",".scan-barcode-form", function () {
		var spj_item_id = $("#barcode-reader").val();
		
		$.ajax({
			type: "POST",
			url: "/admin/spj/loadSpjItemBarcode/?v="+Math.random(),
			data: {
				spj_item_id: spj_item_id,
				version: Math.random()				
			},
			dataType: 'html',
			success: function(html){
				var modalHtml = '<div class="modal fade" id="modal-scan-barcode" tabindex="-1" role="dialog" aria-labelledby="modal-card-detail" aria-hidden="true" data-backdrop="static">'+html+'</div>';

				$('#modal-scan-barcode').remove();
				$('body').append(modalHtml);
				
				$('#modal-scan-barcode').modal("show");
				
				$('#modal-scan-barcode').on('hidden.bs.modal', function () {
					$('#barcode-reader').val("").focus();
				});
				
				$('#modal-scan-barcode').on('shown.bs.modal', function () {
					if ($('#terima-scan-laporan').length) {
						$('#terima-scan-laporan').focus();
					}
					else {
						$('.btn-close-terima-perjadin').focus();
					}
				});
			}
		});
		
		return false;
	});
	
	$(document).on("click","#terima-scan-laporan", function () {
		Loader.start();
		
		var id = $(this).attr("data-spj-item-id");
				
		$.ajax({
			type: "POST",
			url: "/admin/spj/updateLP/?v="+Math.random(),
			data: {
				id: id,
				laporan: 1,
				version: Math.random()				
			},
			dataType: 'json',
			success: function(obj){
				if (obj.error) {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: obj.msg
					});
				}
				else {
					// Refresh Table
					var tableId = $('.scan-barcode-body').find('.bootgrid-header').attr('id').replace("-header","");
					Table.refreshTable(tableId);
				}

				Loader.stop();
				$('#modal-scan-barcode').modal("hide");
			}
		});
	});
}


$(document).ready (function () {
	Spj_Keuangan.init();
});
