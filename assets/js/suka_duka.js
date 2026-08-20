var SukaDuka = {};

SukaDuka.init = function () {
	$(document).on("click", ".sukadukaMonth", function () {
		var modalHtml = '<div class="modal fade" id="suka-duka-card" tabindex="-1" role="dialog" aria-labelledby="modal-card-detail" aria-hidden="true" data-backdrop="static"><div id="suka-duka-pembayaran"></div></div>';

		$('#suka-duka-card').remove();
		$('body').append(modalHtml);
		
		var dataMonth = $(this).attr("data-month");
		var dataYear = $(this).attr("data-year");

		$.ajax({
			type: "POST",
			url: '/admin/suka_duka/pembayaran',
			data: {
				month: dataMonth,
				year: dataYear,
				version: Math.random()				
			},
			dataType: 'html',
			success: function(html){
				$('#suka-duka-pembayaran').replaceWith(html);
				$('#suka-duka-card').modal('show');
			}
		});
	});
}

$(document).ready(function (){
	SukaDuka.init();
});