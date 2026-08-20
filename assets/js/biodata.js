var Biodata = {};

$(document).ready(function () {
	
	$(document).on("click", ".biodata_import_data_bank", function () {
		
		Loader.start();
		
		var modalHtml = '<div class="modal fade" id="modal-data-bank" role="dialog" aria-labelledby="modal-edit-row" aria-hidden="true" data-backdrop="static"><div id="replace-modal-import-data-bank"></div></div>';
			
		$('#modal-edit-row').remove();
		$('body').append(modalHtml);

		$.ajax({
			type: "POST",
			url: "/admin/biodata/import_data_bank/?v="+Math.random(),
			data: {
				version: Math.random()				
			},
			dataType: 'html',
			success: function(html){
				$('#replace-modal-import-data-bank').replaceWith(html);
				

				$('#modal-data-bank').modal('show');
				Loader.stop();
			}
		});
		
	});
	
	$(document).on("submit", ".import_data_bank", function (e) {
		Loader.start();
		
		e.preventDefault();
		
		var action = $(this).attr("action");
		var data = new FormData();
		
		var csv = $('.csv_data_bank').prop('files')[0];
    	data.append('csv_data_bank', csv);
		
		$.ajax({
			    url: action,
				dataType: 'json',
    			cache: false,
    			contentType: false,
    			processData: false,
    			data: data,                        
    			type: 'post',
				success: function(obj){
					
					if (obj.error) {
						$('.log-import-data-bank').html(obj.msg);
					}
					else {
						var html = '<table width="100%" class="table" cellpadding="0" cellspacing="0">';
						
						html += '<tr>';
							html += '<th>&nbsp;</th>';
							html += '<th>No</th>';
							html += '<th>No. Rekening</th>';
							html += '<th>Nama Rekening</th>';
							html += '<th>Nama Bank</th>';
						html += '</tr>';
						
						$.each (obj.result, function (key, val) {
							html += '<tr>';
							
								if (val.result >= 1) {
									html += '<td><i class="icon-green fas fa-check-circle"></i></td>';
								}
								else {
									html += '<td><i class="icon-red fas fa-exclamation-circle"></i></td>';
								}
							
								html += '<td>'+val.no+'</td>';
								html += '<td>'+val.no_rekening+'</td>';
								html += '<td>'+val.nama_pemilik_rekening+'</td>';
								html += '<td>'+val.nama_bank+'</td>';
							
							html += '</tr>';
						});
						
						html += '</table>';
						
						$('.log-import-data-bank').html(html);
					}
					
					Loader.stop();
				}
			});
		
		return false;
	});
	
});