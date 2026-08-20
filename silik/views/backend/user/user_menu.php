<?php
	$url_2 = $this->uri->segment(3);
	$user = $_SESSION["biodata"];
?>

<style type="text/css">
	.change-photo-profile {
		position: absolute;
		left: 0;
		top: 0;
		font-size: 22px;
		padding: 24px 29px;
		background: #777;
		opacity: 0;
		border-radius: 50%;
		color: #ddd;
		-webkit-transition: opacity 0.2s ease-in-out;
		-moz-transition: opacity 0.2s ease-in-out;
		-ms-transition: opacity 0.2s ease-in-out;
		-o-transition: opacity 0.2s ease-in-out;
		transition: opacity 0.2s ease-in-out;
	}
	.change-photo-profile:hover {
		opacity: 0.6;
	}
	.change-photo-profile i {
		color:#ddd;
	}
</style>

<div class="col-lg-4">
	<div class="card user-card user-card-1">
		<div class="card-body pb-0">
			<div class="media user-about-block align-items-center mt-0 mb-3">
				<div class="position-relative d-inline-block">
					<?php $photo = $this->utility->getUserPhoto(); ?>
					<img class="img-radius img-fluid wid-80 user-photo-profile" src="<?php print $photo; ?>" alt="User image">
					<div class="certificated-badge">
						<i class="fas fa-certificate text-primary bg-icon"></i>
						<i class="fas fa-check front-icon text-white"></i>
					</div>
					<a href="javascript:;" class="change-photo-profile"><i class="fas fa-camera"></i></a>
				</div>
				<div class="media-body ms-3">
					<h6 class="mb-1 mt-4"><?php print $user["nama"]; ?></h6>
					<p class="mb-0 text-muted">NIP <?php print $user["nip"]; ?></p>
				</div>
			</div>
		</div>
		<ul class="list-group list-group-flush" style="margin-bottom: 10px;">
			<li class="list-group-item">
				<span class="f-w-500"><i class="feather icon-award m-r-10"></i></span>
				<span><?php print $user["jabatan"]; ?></span>
			</li>
			<li class="list-group-item">
				<span class="f-w-500"><i class="feather icon-mail m-r-10"></i></span>
				<a href="mailto:<?php print $user["email"]; ?>" class="text-body"><?php print $user["email"]; ?></a>
			</li>
			<li class="list-group-item">
				<span class="f-w-500"><i class="feather icon-phone-call m-r-10"></i></span>
				<a href="https://wa.me/<?php print $user["telp"]; ?>" target="_blank" class="text-body"><?php print $user["telp"]; ?></a>
			</li>
			<li class="list-group-item border-bottom-0">
				<span class="f-w-500"><i class="feather icon-map-pin m-r-10"></i> Alamat Tinggal</span><br />
				<p class="mb-0 mt-2"><?php print $user["alamat_tinggal"]; ?></p>
			</li>
		</ul>
	</div>

	<div class="card user-card">
		<div class="nav flex-column nav-pills list-group list-group-flush list-pills" id="user-set-tab" role="tablist" aria-orientation="vertical">
		<a class="nav-link list-group-item list-group-item-action <?php if ($url_2 == "profile") print "active"; ?>" href="<?php print base_url("/admin/user/profile"); ?>">
			<span class="f-w-500"><i class="feather icon-user m-r-10 h5 "></i>Biodata</span>
		<span class="float-end"><i class="feather icon-chevron-right"></i></span>
		</a>
		<a class="nav-link list-group-item list-group-item-action <?php if ($url_2 == "bank") print "active"; ?>" href="<?php print base_url("/admin/user/bank"); ?>">
			<span class="f-w-500"><i class="fas fa-wallet m-r-10"></i>Rekening</span>
		<span class="float-end"><i class="feather icon-chevron-right"></i></span>
		</a>
			
		<a class="nav-link list-group-item list-group-item-action <?php if ($url_2 == "quotes") print "active"; ?>" href="<?php print base_url("/admin/user/quotes"); ?>">
			<span class="f-w-500"><i class="fas fa-quote-right m-r-10"></i>Kutipan</span>
		<span class="float-end"><i class="feather icon-chevron-right"></i></span>
		</a>
			
		<a class="nav-link list-group-item list-group-item-action <?php if ($url_2 == "change_password") print "active"; ?>" href="<?php print base_url("/admin/user/change_password"); ?>">
			<span class="f-w-500"><i class="feather icon-shield m-r-10 h5 "></i>Ganti Password</span>
		<span class="float-end"><i class="feather icon-chevron-right"></i></span>
		</a>

		<?php /* ?>
		<a class="nav-link list-group-item list-group-item-action <?php if ($url_2 == "sync_drive") print "active"; ?>" href="<?php print base_url("/admin/user/sync_drive"); ?>">
			<span class="f-w-500"><i class="fab fa-google-drive m-r-10"></i>Sync Google Drive</span>
		<span class="float-end"><i class="feather icon-chevron-right"></i></span>
		*/ ?>
		</a>
	</div>
	</div>
</div>