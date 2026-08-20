$(document).ready(function () {
	$('[name="golongan"]').change(function () {
		var pangkat = $(this).find(":selected").data('pangkat');
		$('[name="pangkat"]').val(pangkat);
	});

	$(".change-photo-profile").click(function () {
		var modalHtml = '<div class="modal fade" id="modal-change-photo-profile" tabindex="-1" role="dialog" aria-labelledby="modal-card-detail" aria-hidden="true" data-backdrop="static"><div id="replace-modal-change-photo-profile"></div></div>';

		$('#modal-change-photo-profile').remove();
		$('body').append(modalHtml);

		$.ajax({
			type: "POST",
			url: "/admin/user/change_photo_profile",
			data: {
				version: Math.random()				
			},
			dataType: 'html',
			success: function(html){
				$('#replace-modal-change-photo-profile').replaceWith(html);
				$('#modal-change-photo-profile').modal('show');
			}
		});
	});
});