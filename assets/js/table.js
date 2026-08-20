var Loader = {};

Loader.stop = function () {
		$(".loader").remove();
	}
	
Loader.start = function () {
	Loader.stop();

	$("body").append('<div class="loader"><div class="loader-wrap"><div class="loader-image"><img src="/assets/images/loader.gif?v=12" width="100" /></div><div class="loader-text">PLEASE WAIT...</div></div></div>');
}

var Table = {};

Table.cardOption = function () {
	if ($('.card-option').length) {
		$(document).on("click",".card-option a", function (e) {

			var modalView = $(e.target).attr('data-modal-view');
			var dataConfirm = $(e.target).attr('data-confirm');

			if (typeof modalView !== typeof undefined && modalView !== false) {

				var modalHtml = '<div class="modal fade" id="modal-card-detail" tabindex="-1" role="dialog" aria-labelledby="modal-card-detail" aria-hidden="true" data-backdrop="static"><div id="replace-modal-card-detail"></div></div>';

				$('#modal-card-detail').remove();
				$('body').append(modalHtml);

				$.ajax({
					type: "POST",
					url: modalView,
					data: {
						version: Math.random()				
					},
					dataType: 'html',
					success: function(html){
						$('#replace-modal-card-detail').replaceWith(html);
						$('#modal-card-detail').modal('show');
					}
				});
			}
			else if (typeof dataConfirm !== typeof undefined && dataConfirm !== false) {
				Swal.fire({
					title: 'Apakah anda yakin?',
					text: "Data yang telah dihapus tidak bisa dikembalikan lagi!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonText: 'Ya, hapus!',
					cancelButtonText: 'Batal'
				}).then((result) => {
					if (result.value) {
						$.ajax({
							type: "POST",
							url: dataConfirm,
							data: {
								version: Math.random()				
							},
							dataType: 'json',
							success: function(obj){
								if (obj.error) {
									Swal.fire(
										'Gagal!',
										'Data anda gagal dihapus.',
										'error'
									);
								}
								else {
									Swal.fire(
										'Berhasil!',
										'Data anda telah dihapus.',
										'success'
									);

									$(e.target).closest('.card').slideUp(300);
								}
							}
						});
					}
				});
			}

		});
	}
}

Table.columnFreezeFirstLoad = 1;

Table.columnFreeze = function (tableId) {
	var recordFreeze = {};
	var firstLoad = 1;
	
	$("#"+tableId+" tr").each(function() {

		$(this).find("[data-freeze]").not('.no-results').each(function(i){
			var colWidth = parseInt($(this).css("width"));

			if (i >= 1 && Table.columnFreezeFirstLoad == 1) {
				colWidth = colWidth + 15;
			}

			if (i in recordFreeze) {
				if (colWidth > recordFreeze[i]) {
					recordFreeze[i] = colWidth;
				}
			}
			else {
				recordFreeze[i] = colWidth;
			}
		});
	});

	$("#"+tableId+" tr").each(function(i) {
		var leftFreeze = 25;
		var leftFreezePrint = "auto";
		var lastFreeze;
		var widthFreeze = 0;

		$(this).find("[data-freeze]").each(function(i){
			if (leftFreeze > 25) {
				leftFreezePrint = leftFreeze;
			}

			$(this).css("width",recordFreeze[i]);
			$(this).css("left",leftFreezePrint);

			lastFreeze = $(this);
			var colWidth = parseInt($(this).css("width"));
			leftFreeze = leftFreeze + colWidth;
			widthFreeze = widthFreeze + colWidth;
		});
		
		if ($(this).find("[data-freeze]").length) {
			if (lastFreeze.next().length) {
				lastFreeze.addClass("lastFreeze");
				lastFreeze.next().css("padding-left",widthFreeze + 7);
			}
		}
	});
	
	Table.columnFreezeFirstLoad = 0;
}

Table.rowTotal = function (tableId) {
	
	var columnId = {};
	
	$("#"+tableId+" tfoot tr th").each(function(e) {
		if ($(this).attr('data-sum') == '1'){
			columnId[e] = $(this).attr('data-column-id');
		}
	});
	
	var totalAmount = {};
	
    $("#"+tableId).find('tbody tr').each(function() {
        $(this).find('td').each(function(i){
			if(i in columnId){
				if(typeof(totalAmount[i]) == "undefined" || totalAmount[i] === null) {
					totalAmount[i] = 0;
				}
				
				var text = $(this).text().replace(/\./g,'').replace(/Rp /g, '').replace(/\,/g,'.');
				totalAmount[i] = totalAmount[i] + parseFloat(text);
			}
        });
    });
	
	$.each(columnId, function (key, value) {
		
		// Check Money Format
		var attr = $('#'+tableId+' tfoot tr th[data-column-id="'+value+'"]').attr('data-format');
		
		$('#'+tableId+' tfoot tr th[data-column-id="'+value+'"]').autoNumeric('destroy');
		
		if (typeof attr !== typeof undefined && attr !== false) {
			if (attr == "money") {
				$('#'+tableId+' tfoot tr th[data-column-id="'+value+'"]').text(totalAmount[key]).autoNumeric('init',{aSep:'.', aDec:',', mDec: '0',aSign: 'Rp. ' });
			}
			else {
				$('#'+tableId+' tfoot tr th[data-column-id="'+value+'"]').text(totalAmount[key]).autoNumeric('init',{aSep:'.', aDec:',', mDec: '0'});
			}
		}
		else {
			$('#'+tableId+' tfoot tr th[data-column-id="'+value+'"]').text(totalAmount[key]).autoNumeric('init',{aSep:'.', aDec:',', mDec: '0'});
		}
	});
}

Table.refreshTable = function (tableId) {
	//$('#'+tableId+'-header .btn[title="Refresh"]').click();
	if ($('#'+tableId+'-footer').length) {
		var current = $('#'+tableId+'-footer .pagination .active').removeClass("active").removeClass("disabled");
		current.find("a").click();
		current.addClass("active");
		console.log(tableId);
	}
	else {
		$('#'+tableId+'-header .btn[title="Refresh"]').click();
	}
}

Table.reloadTable = function (tableId) {
	$('#'+tableId+'-header .btn[title="Refresh"]').click();
}

Table.rowEventClick = function (e) {
	var id = $(e.target).attr('data-id');
	var table = $(e.target).attr('data-table');
	var action = $(e.target).attr('data-action');
	var tableId = $(e.target).closest('.table').attr('id');
	
	if(typeof(id) == "undefined") {
		id = $(e.target).attr('data-'+table+".id");
	}
	
	if (action == "delete-row") {
		Swal.fire({
			title: 'Apakah anda yakin?',
			text: "Data yang telah dihapus tidak bisa dikembalikan lagi!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Ya, hapus!',
			cancelButtonText: 'Batal'
		}).then((result) => {
			if (result.value) {
				Loader.start();
				
				$.ajax({
					type: "POST",
					url: "/bootgrids/deleteRow/",
					data: {
						id: id,
						table: table,
						version: Math.random()				
					},
					dataType: 'json',
					success: function(obj){
						Loader.stop();
						
						if (obj.error) {
							Swal.fire(
								'Gagal!',
								'Data anda gagal dihapus.',
								'error'
							);
						}
						else {
							Swal.fire(
								'Berhasil!',
								'Data anda telah dihapus.',
								'success'
							);
							
							Table.refreshTable(tableId);
						}
					}
				});
			}
		})
	}
	else if (action == "edit-row") {
		var modalView = $(e.target).attr('data-modal-view');
		var modalParentId = $(e.target).attr('data-parent');
		var linkHref = $(e.target).attr('data-href');
		
		if (typeof modalView !== typeof undefined && modalView !== false) {
			Loader.start();
			
			var modalHtml = '<div class="modal fade" id="modal-edit-row" role="dialog" aria-labelledby="modal-edit-row" aria-hidden="true" data-backdrop="static"><div id="replace-modal-edit-row"></div></div>';
			
			$('#modal-edit-row').remove();
			$('body').append(modalHtml);
			
			$.ajax({
				type: "POST",
				url: "/bootgrids/loadModalForm/?v="+Math.random(),
				data: {
					id: id,
					table: table,
					view: modalView,
					parentId: modalParentId,
					version: Math.random()				
				},
				dataType: 'html',
				success: function(html){
					$('#replace-modal-edit-row').replaceWith(html);
					$('#modal-edit-row').find('form').attr('data-table-id',tableId);
					
					AutoNumeric.init();
					Select2.init();
					Datepicker.init();
					
					$('#modal-edit-row').modal('show');
					Loader.stop();
				}
			});
		}
		else if (typeof linkHref !== typeof undefined && linkHref !== false) {
			var url = $(e.target).attr('data-href');
		
			if (url != "") {
				window.location.href = url;
			}
		}
	}
	else if (action == "modal") {
		var modalView = $(e.target).attr('data-modal-view');
		var modalParentId = $(e.target).attr('data-parent');
		
		if (typeof modalView !== typeof undefined && modalView !== false) {
			
			var modalHtml = '<div class="modal fade table-'+table+'" id="modal-button-row" tabindex="-1" role="dialog" aria-labelledby="modal-button-row" aria-hidden="true" data-backdrop="static"><div id="replace-modal-button-row"></div></div>';
			
			$('#modal-button-row').remove();
			$('body').append(modalHtml);
			
			Loader.start();
			
			$.ajax({
				type: "POST",
				url: "/bootgrids/loadModalForm/?v="+Math.random(),
				data: {
					id: id,
					table: table,
					view: modalView,
					parentId: modalParentId,
					version: Math.random()				
				},
				dataType: 'html',
				success: function(html){
					$('#replace-modal-button-row').replaceWith(html);
					$('#modal-button-row').find('form').attr('data-table-id',tableId);
					
					AutoNumeric.init();
					Select2.init();
					Datepicker.init();

					$('#modal-button-row').modal('show');
					Loader.stop();
				}
			});
		}
	}
	else if (action == "link") {
		var url = $(e.target).attr('data-href');
		var tar = $(e.target).attr('data-target');
		
		if (url != "") {
			if (tar == "_blank") {
				window.open(url, '_blank');
			}
			else {
				window.location.href = url;
			}
		}
	}
}