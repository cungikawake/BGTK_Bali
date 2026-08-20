
<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">Crop Foto Profil</h5>
		</div>

		<div class="modal-body">
			<?php $targetFile = "photo_".$_SESSION["user"]["id"].".jpg"; ?>
			<div id="display_image_div">
				<img name="display_image_data" id="display_image_data" src="<?php print base_url("assets/user_profile/".$targetFile."?v=".rand()); ?>" alt="Picture">
			</div>
			<input type="hidden" name="cropped_image_data" id="cropped_image_data">

			<div id="cropped_image_result">
				<img style="width: 350px;" src="dummy-image.png" />
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-info mb-0" id="crop_button">Crop</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
		</div>
	</div>
</div>

<style type="text/css">
	#display_image_div {
		text-align:center;
	}
	#display_image_data {
		max-height:500px;
		max-width:100%;
	}

	#cropped_image_result {
		display: none;
	}

	.cropper-view-box,
    .cropper-face {
      border-radius: 50%;
    }

    /* The css styles for `outline` do not follow `border-radius` on iOS/Safari (#979). */
    .cropper-view-box {
      outline: 0;
      box-shadow: 0 0 0 1px #39f;
    }
</style>

<script type="text/javascript">
	function getRoundedCanvas(sourceCanvas) {
		var canvas = document.createElement('canvas');
		var context = canvas.getContext('2d');
		var width = sourceCanvas.width;
		var height = sourceCanvas.height;
		canvas.width = width;
		canvas.height = height;
		context.imageSmoothingEnabled = true;
		context.drawImage(sourceCanvas, 0, 0, width, height);
		context.globalCompositeOperation = 'destination-in';
		context.beginPath();
		context.arc(width / 2, height / 2, Math.min(width, height) / 2, 0, 2 * Math.PI, true);
		context.fill();
		return canvas;
	}

	var image = document.getElementById('display_image_data');
	var button = document.getElementById('crop_button');
	var result = document.getElementById('cropped_image_result');
	var croppable = false;
	
	var cropper = new Cropper(image, {
		aspectRatio: 1,
		viewMode: 1,
		ready: function() {
			croppable = true;
		},
	});
	
	button.onclick = function() {
		Loader.start();

		var croppedCanvas;
		var roundedCanvas;
		var roundedImage;

		if (!croppable) {
			return;
		}

		// Crop
		croppedCanvas = cropper.getCroppedCanvas();
		// Round
		roundedCanvas = getRoundedCanvas(croppedCanvas);
		// Show
		roundedImage = document.createElement('img');
		roundedImage.src = roundedCanvas.toDataURL()
		result.innerHTML = '';
		result.appendChild(roundedImage);

		var base64data = $('#cropped_image_result img').attr('src');
		//alert(base64data);

		$.ajax({
			type: "POST",
			dataType: "json",
			url: "/admin/user/cropped_photo_profile",
			data: {
				image: base64data
			},
			success: function(response) {
				if (response.status == true) {
					$('#modal-crop-photo-profile').modal('hide');
					$('.user-photo-profile').attr("src",response.path);

				} else {
					alert("Image not uploaded.");
				}

				Loader.stop();
			}
		});
	};
</script>