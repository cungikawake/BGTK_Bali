<?php $url_3 = $this->uri->segment(4); ?>

<ul class="nav nav-pills nav-pills-tiket">
	<li class="nav-item">
		<a class="nav-link <?php if ($url_3 == "baru") { print "active"; } ?>" href="<?php print base_url("/admin/tiket/lists/baru"); ?>">Baru 

			<?php if (isset($new_tiket) && !empty($new_tiket)) { ?>
				<div class="numb-notif"><?php print count($new_tiket); ?></div>
			<?php } ?>
		</a>
	</li>

	<li class="nav-item">
		<a class="nav-link <?php if ($url_3 == "proses") { print "active"; } ?>" href="<?php print base_url("/admin/tiket/lists/proses"); ?>">Proses

			<?php if (isset($proses_tiket) && !empty($proses_tiket)) { ?>
				<div class="numb-notif"><?php print count($proses_tiket); ?></div>
			<?php } ?>
		</a>
	</li>

	<li class="nav-item">
		<a class="nav-link <?php if ($url_3 == "selesai") { print "active"; } ?>" href="<?php print base_url("/admin/tiket/lists/selesai"); ?>">Selesai</a>
	</li>
</ul>