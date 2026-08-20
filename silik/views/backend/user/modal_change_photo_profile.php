
<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">Upload Foto Profil</h5>
		</div>

		<div class="modal-body">
			<div class="form-group">
				<label>Foto (jpg, jpeg, png) Max 3Mb</label>
				<div id="dropzone-photo-profile" class="dropzone">
					<div class="dz-message needsclick">    
					Drop files here or click to upload.
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="submit" class="btn btn-info btn-submit-document mb-0">Upload</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
		</div>
	</div>
</div>

<script type="text/javascript">
	$("div#dropzone-photo-profile").dropzone({ 
		url: "/admin/user/upload_photo_profile?v"+Math.random(),
		paramName: "file", // The name that will be used to transfer the file
		maxFilesize: 3, // MB
		autoProcessQueue: false,
		acceptedFiles: '.jpg,.jpeg,.png',
		addRemoveLinks: true,
		parallelUploads : 10,
		maxFiles: 1,
		init: function() {
			
			var submitButton = document.querySelector(".btn-submit-document");
			
			myDropzone = this;

			submitButton.addEventListener("click", function() {
				myDropzone.processQueue(); 
			});

			myDropzone.on("success", function(file, xhr) {
				myDropzone.removeFile(file);
				var out = JSON.parse(xhr);
				
				$('.modal').modal('hide');

				if (out.error) {
					Swal.fire(
						'Gagal!',
						out.msg,
						'error'
					);
				}
				else {
					var modalHtml = '<div class="modal fade" id="modal-crop-photo-profile" tabindex="-1" role="dialog" aria-labelledby="modal-card-detail" aria-hidden="true" data-backdrop="static"><div id="replace-modal-crop-photo-profile"></div></div>';

					$('#modal-crop-photo-profile').remove();
					$('body').append(modalHtml);

					Loader.start();

					$.ajax({
						type: "POST",
						url: "/admin/user/crop_photo_profile",
						data: {
							version: Math.random()				
						},
						dataType: 'html',
						success: function(html){
							$('#replace-modal-crop-photo-profile').replaceWith(html);
							Loader.stop();
							$('#modal-crop-photo-profile').modal('show');
						}
					});
				}
			});
			
			this.on("maxfilesexceeded", function(file){
				Swal.fire(
					'Perhatian!',
					'Hanya 1 file yang boleh diupload.',
					'warning'
				);
				myDropzone.removeFile(file);
			});
		},
	});
</script>