<ul class="nav nav-pills nav-pills-perjadin">
	<li class="nav-item">
		<a class="nav-link <?php if ($unsur == "peserta") { print "active"; } ?>" href="<?php print base_url("admin/spj/peserta/".$spj["id"]."/"); ?>">Peserta</a>
	</li>

	<li class="nav-item">
		<a class="nav-link <?php if ($unsur == "narasumber") { print "active"; } ?>" href="<?php print base_url("admin/spj/narasumber/".$spj["id"]."/"); ?>">Narasumber</a>
	</li>
	
	<li class="nav-item">
		<a class="nav-link <?php if ($unsur == "instruktur") { print "active"; } ?>" href="<?php print base_url("admin/spj/instruktur/".$spj["id"]."/"); ?>">Instruktur</a>
	</li>
	
	<li class="nav-item">
		<a class="nav-link <?php if ($unsur == "pengajar_praktek") { print "active"; } ?>" href="<?php print base_url("admin/spj/pengajar_praktek/".$spj["id"]."/"); ?>">Pengajar Praktek</a>
	</li>
	
	<li class="nav-item">
		<a class="nav-link <?php if ($unsur == "fasilitator") { print "active"; } ?>" href="<?php print base_url("admin/spj/fasilitator/".$spj["id"]."/"); ?>">Fasilitator</a>
	</li>

	<li class="nav-item">
		<a class="nav-link <?php if ($unsur == "panitia") { print "active"; } ?>" href="<?php print base_url("admin/spj/panitia/".$spj["id"]."/"); ?>">Panitia</a>
	</li>
	
	<?php
			
		$showMoreOpt = false;
		$opt = "keg-more-opt-peserta";
	
		if ($unsur == "peserta") {
			$showMoreOpt = true;
			$opt = "keg-more-opt-peserta";
		}
		else if ($unsur == "narasumber") {
			$showMoreOpt = true;
			$opt = "keg-more-opt-narasumber";
		}
		else if ($unsur == "instruktur") {
			$showMoreOpt = true;
			$opt = "keg-more-opt-instruktur";
		}
		else if ($unsur == "pengajar_praktek") {
			$showMoreOpt = true;
			$opt = "keg-more-opt-pengajar_praktek";
		}
		else if ($unsur == "fasilitator") {
			$showMoreOpt = true;
			$opt = "keg-more-opt-fasilitator";
		}
		else if ($unsur == "panitia") {
			$showMoreOpt = true;
			$opt = "keg-more-opt-panitia";
		}
	
		if ($showMoreOpt) {
	?>
		<li class="nav-more-opt"><a data-toggle="collapse" href="#<?php print $opt; ?>" role="button" aria-expanded="true" aria-controls="<?php print $opt; ?>"><i class="fas fa-angle-down"></i></a></li>
	<?php
		}
	?>
</ul>

<div class="keg-more-opt">
	<input type="hidden" class="spj_id" value="<?php print $spj["id"]; ?>" />
	<?php
		if ($unsur == "peserta") {
			$this->load->view("backend/spj/menu_peserta");
		} else {
			$this->load->view("backend/spj/menu_honor");
		}
	?>
</div>
<div style="display: block;height: 15px;">&nbsp;</div>