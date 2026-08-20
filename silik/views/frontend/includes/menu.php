<?php
	$url_1 = $this->uri->segment(1);
	$url_2 = $this->uri->segment(2);

	$showMenu = true;

	if (isset($_SESSION["guest_menu"]) && $_SESSION["guest_menu"] == "false") {
		$showMenu = false;
	}
?>
<!-- [ navigation menu ] start -->
<nav class="pcoded-navbar <?php if (!$showMenu) { print "navbar-collapsed"; } ?>">
	<div class="navbar-wrapper">
		<div class="navbar-brand header-logo">
			<a href="<?php print base_url("/"); ?>" class="b-brand">
				<div class="b-bg">
				   <img src="<?php print base_url("/assets/images/logo-kemdikbud-icon.png"); ?>" />
			   </div>
			   <span class="b-title" title="<?php print $this->config->item("site_description"); ?>"><?php print $this->config->item("site_name"); ?></span>
			</a>
			<a class="mobile-menu <?php if (!$showMenu) { print "on"; } ?>" id="mobile-collapse" href="javascript:"><span></span></a>
		</div>
		<div class="navbar-content scroll-div">
			<ul class="nav pcoded-inner-navbar">
				<li class="nav-item pcoded-menu-caption">
					<label>Unit</label>
				</li>
				<li class="nav-item <?php if ($url_1 == "" || $url_1 == "user") print "active"; ?>">
					<a href="<?php print base_url('/'); ?>" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Beranda</span></a>
				</li>
				
				<?php
					$notifHai = '';
					
					if (isset($_SESSION["guest"]["notif"]["hai"]) && !empty($_SESSION["guest"]["notif"]["hai"])) {
						$notifHai = '<span class="pcoded-badge label label-danger">'.$_SESSION["guest"]["notif"]["hai"].'</span>';
					}
				?>
				<li class="nav-item <?php if ($url_1 == "tiket") print "active"; ?>">
					<a href="<?php print base_url('/tiket/'); ?>" class="nav-link "><span class="pcoded-micon"><i class="feather icon-message-circle"></i></span><span class="pcoded-mtext">Hai BGTK</span><?php print $notifHai; ?></a>
				</li>
				<li class="nav-item pcoded-menu-caption">
					<label>Pengaturan</label>
				</li>
				<li class="nav-item <?php if ($url_1 == "user" && $url_2 == "detail") print "active"; ?>">
					<a href="<?php print base_url('/user/detail'); ?>" class="nav-link "><span class="pcoded-micon"><i class="feather icon-user"></i></span><span class="pcoded-mtext">Profil</span></a>
				</li>
				<li class="nav-item">
					<a href="<?php print base_url('/user/logout'); ?>" class="nav-link "><span class="pcoded-micon"><i class="feather icon-log-out"></i></span><span class="pcoded-mtext">Keluar</span></a>
				</li>
			</ul>
		</div>
	</div>
</nav>
<!-- [ navigation menu ] end -->