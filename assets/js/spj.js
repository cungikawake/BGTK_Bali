var SPJ = {};
SPJ.formatNumber = function (value) {
	return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
SPJ.loadTableRalisasi = function (unsur) {
	var spjId = $('.spj_id').val();

	$.ajax({
		type: "POST",
		url: "/admin/spj/loadTableRealisasi/"+unsur+"/?v="+Math.random(),
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

SPJ.optionSubmit = function () {
	var unsur = $('.unsur-spj').val();
	
	Swal.fire({
		title: 'Apakah anda yakin?',
		text: "Penerapan opsi ini akan menimpa semua rincian pada spj "+unsur,
		icon: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Lanjutkan!',
		cancelButtonText: 'Batal'
	}).then((result) => {
		if (result.value) {
			Loader.start();
			AutoNumeric.destroy();

			var spjId = $('.spj_id').val();
			var data = $('.form-spj-option').serializeArray();
			
			$.ajax({
				type: "POST",
				url: "/admin/spj/saveOption/?v="+Math.random(),
				data: {
					spj_id: spjId,
					unsur: unsur,
					based: data,
					version: Math.random()				
				},
				dataType: 'json',
				success: function(obj){
					AutoNumeric.init();
					Loader.stop();
					
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
						}).then(function() {
							console.log(unsur);
							var tableId = $('.spj-'+unsur).find('.bootgrid-table').attr("id");
							Table.refreshTable(tableId);
							
							SPJ.loadTableRalisasi(unsur);
						});
					}
				}
			});
		}
	});
}

SPJ.importSPJ = function () {
	var spjId = $('.spj_id').val();
	var unsur = $('.unsur-spj').val();
	
	$('.modal').modal('hide');
	
	Loader.start();
	
	$.ajax({
		type: "POST",
		url: "/admin/spj/importData/?v="+Math.random(),
		data: {
			spj_id: spjId,
			unsur: unsur,
			version: Math.random()				
		},
		dataType: 'json',
		success: function(obj){
			Loader.stop();

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
				}).then(function() {
					$('.spj-'+unsur).find('.btn[title="Refresh"]').click();
					SPJ.loadTableRalisasi(unsur);
				});
			}
		}
	});
}

SPJ.updateLock = function (e) {
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

SPJ.printDok = function (e) {
	var btn = $(e);
	
	var id = btn.attr('data-id');
	var table = btn.attr('data-table');
	var val = btn.attr('value');
	var unsur = $('.unsur-spj').val();
	
	$.ajax({
		type: "POST",
		url: "/admin/spj/updatePrint/?v="+Math.random(),
		data: {
			id: id,
			table: table,
			value: val,
			version: Math.random()				
		},
		dataType: 'json',
		success: function(obj){			
			if (val == "1") {
				btn.attr('title','Sudah diprint').attr('value','1').css('color','#f44236');
				btn.html('<i class="fas fa-print"></i>');
			}
			
			var win = window.open('/admin/spj/generate/'+unsur+'/'+id, '_blank');
			if (win) {
				//Browser has allowed it to be opened
				win.focus();
			} else {
				//Browser has blocked it
				alert('Please allow popups for this website');
			}
		}
	});
}

SPJ.formatResult = function (result) {
	return result.nama;
};

SPJ.formatRepoSelection = function (repo) {
	return repo.nama;
}

SPJ.getPenerimaSPBy = function (element, optionUrl, selectedUrl) {
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
		
		option["templateResult"] = SPJ.formatResult;
		option["templateSelection"] = SPJ.formatRepoSelection;
		option["minimumInputLength"] = 3;
		option["placeholder"] = "Pilih nama...";
		
		var selected = element.attr("data-selected");
		
		if (selected == "0") {
			element.select2(option);
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
						option["data"] = [obj];
					}
					
					element.select2(option);
				}
			});
		}
	}
}

SPJ.init = function () {
	$(document).ready(function () {
		$('.form-spj-option').submit(function (e) {
			e.preventDefault();
			SPJ.optionSubmit();
		});
		
		$(document).on('click','.btn-import-data-spj', function () {
			SPJ.importSPJ();
		});
		
		$(document).on('click', '.nav-tabs a', function () {
			$(this).closest('.nav-tabs').find('a').removeClass('active');
			$(this).addClass('active');
			
			var idPane = $(this).attr('aria-controls');
			
			$('.tab-pane#'+idPane).closest('.tab-content').find('.tab-pane').removeClass('active show');
			$('.tab-pane#'+idPane).addClass('active show');
		});
		
		if ($('#table-realisasi').length) {
			var unsur = $('.unsur-spj').val();
			SPJ.loadTableRalisasi(unsur);
		}
		
		$(document).on('change', '.updateST', function () {
			var table = $(this).attr('data-table');
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
					table: table,
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
			var table = $(this).attr('data-table');
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
					table: table,
					id: id,
					spd: value,
					version: Math.random()				
				},
				dataType: 'json',
				success: function(obj){
				}
			});
		});
		
		$(document).on('click', '.printSelected', function () {
			var tableId = $(this).closest('.bootgrid-header').attr('id').replace("-header","");
			var tableDb = $(this).data("table");
			var unsur = $('.unsur-spj').val();
			
			var selected = [];
			$('table#'+tableId+' input.select-box:checked').each(function() {
				selected.push($(this).val());
			});
			
			if (selected.length > 0) {
				
				$.ajax({
					type: "POST",
					url: "/admin/spj/updatePrintSelected/?v="+Math.random(),
					data: {
						ids: selected,
						table: tableDb,
						version: Math.random()				
					},
					dataType: 'json',
					success: function(obj){
						var ids = "";
						$.each(selected, function(i, id) {
							if (ids != "") {
								ids += ",";
							}

							ids += id;
						});

						Table.refreshTable(tableId);


						var url = "/admin/spj/generateSelected/"+unsur+"/"+encodeURIComponent(ids);

						var win = window.open(url, '_blank');
						if (win) {
							//Browser has allowed it to be opened
							win.focus();
						} else {
							//Browser has blocked it
							alert('Please allow popups for this website');
						}
					}
				});
			}
			else {
				Swal.fire({
				  	icon: 'warning',
					title: 'Peringatan...',
				  	text: "Mohon untuk memilih beberapa record untuk di print",
				  	showConfirmButton: true,
				})
			}
		});
		
		$(document).on('click', '.printSpby', function () {
			var spjId = $('.spj_id').val();
			var tableDb = $(this).data("table");
			var type = "peserta";
			
			
			if (tableDb == "spj_kegiatan_narasumber") {
				type = "narasumber";
			}
			else if (tableDb == "spj_kegiatan_fasilitator") {
				type = "fasilitator";
			}
			else if (tableDb == "spj_kegiatan_instruktur") {
				type = "instruktur";
			}
			else if (tableDb == "spj_kegiatan_pengajar_praktek") {
				type = "pengajar_praktek";
			}
			else if (tableDb == "spj_kegiatan_panitia") {
				type = "panitia";
			}
			
			
			$.ajax({
				type: "POST",
				url: "/admin/spj/printSpby/",
				data: {
					spjId: spjId,
					table: tableDb,
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
						var url = "/admin/spj/generateSpby/"+type+"/"+spjId;

						var win = window.open(url, '_blank');
						if (win) {
							//Browser has allowed it to be opened
							win.focus();
						} else {
							//Browser has blocked it
							alert('Please allow popups for this website');
						}
					}
				}
			});
		});
		
		$(document).on('click', '.printDaftarPenerimaan', function () {
			var spjId = $('.spj_id').val();
			var type = $('.unsur-spj').val();			
			
			var url = "/admin/spj/generateDaftarPenerimaan/"+type+"/"+spjId;

			var win = window.open(url, '_blank');
			if (win) {
				//Browser has allowed it to be opened
				win.focus();
			} else {
				//Browser has blocked it
				alert('Please allow popups for this website');
			}
		});
		
		$(document).on('click','.bootgrid-lock-btn', function () {
			var btn = $(this);
			var spj = $(this).attr("data-spj");
			var unsur = $(this).attr("data-unsur");
			var val = $(this).attr("data-lock");
			
			$.ajax({
				type: "POST",
				url: "/admin/spj/updateLockAll/?v="+Math.random(),
				data: {
					spj_id: spj,
					unsur: unsur,
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
		
		
		if ($('#select_spby').length) {
			var spjId = $('.spj_id').val();
			var element = $('#select_spby');
			var unsur = $('.unsur-spj').val();
			
			var optionUrl = "/admin/spj/typehead/"+unsur+"/"+spjId+"/";
			var selectedUrl = "/admin/spj/selected_spby/"+unsur+"/"+spjId+"/";
			
			SPJ.getPenerimaSPBy(element, optionUrl, selectedUrl);
		}
		
		if ($('#select_spby_honor').length) {
			var spjId = $('.spj_id').val();
			var element = $('#select_spby_honor');
			var unsur = $('.unsur-spj').val();
			
			var optionUrl = "/admin/spj/typehead/"+unsur+"/"+spjId+"/";
			var selectedUrl = "/admin/spj/selected_spby/"+unsur+"/"+spjId+"/";
			
			SPJ.getPenerimaSPBy(element, optionUrl, selectedUrl);
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
}

$(document).ready (function () {
	SPJ.init();
});
