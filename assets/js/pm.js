$(document).ready(function () {
	
	$(document).on("click", ".import_data_kontrak_pm", function () {
		
		Loader.start();
		
		var modalHtml = '<div class="modal fade" id="modal-data-kontrak-pm" role="dialog" aria-labelledby="modal-edit-row" aria-hidden="true" data-backdrop="static"><div id="replace-modal-import-data-kontrak-pm"></div></div>';
			
		$('#modal-edit-row').remove();
		$('body').append(modalHtml);

		$.ajax({
			type: "POST",
			url: "/admin/tool/import_data_kontrak_pm/?v="+Math.random(),
			data: {
				version: Math.random()				
			},
			dataType: 'html',
			success: function(html){
				$('#replace-modal-import-data-kontrak-pm').replaceWith(html);
				

				$('#modal-data-kontrak-pm').modal('show');
				Loader.stop();
			}
		});
		
	});
	
	$(document).on("submit", ".import_data_kontrak_pm", function (e) {
		Loader.start();
		
		e.preventDefault();
		
		var action = $(this).attr("action");
		var data = new FormData();
		
		var csv = $('.csv_data_kontrak_pm').prop('files')[0];
    	data.append('csv_data_kontrak_pm', csv);
		
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
						$('.log-import-data-kontrak-pm').html(obj.msg);
					}
					else {
						var html = '<table width="100%" class="table" cellpadding="0" cellspacing="0">';
						
						html += '<tr>';
							html += '<th>&nbsp;</th>';
							html += '<th>No</th>';
							html += '<th>NPSN</th>';
							html += '<th>Nama Sekolah</th>';
							html += '<th>Kabupaten</th>';
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
								html += '<td>'+val.npsn+'</td>';
								html += '<td>'+val.nama_sekolah+'</td>';
								html += '<td>'+val.kabupaten+'</td>';
							
							html += '</tr>';
						});
						
						html += '</table>';
						
						$('.log-import-data-kontrak-pm').html(html);
					}
					
					Loader.stop();
				}
			});
		
		return false;
	});
	
});