<?php $this->load->view("backend/includes/header"); ?>
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-10"><i class="feather icon-clipboard"></i> Task Detail</h5>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="main-body">
		<div class="page-wrapper">
			<!-- [ Main Content ] start -->
			<div class="row">
				<div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Detail</h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between" style="margin-top:-1px;">
                                <div class="list-tab m-0"><i class="feather icon-folder f-16 text-primary"></i> &nbsp;Category:</div>
                                <div class="f-right">Arsip</div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <div class="list-tab m-0"><i class="feather icon-flag f-16 text-primary"></i> &nbsp;Priority:</div>
                                <div class="f-right">
                                    <div class="btn-group">
                                        <button type="button" id="task-priority" class="btn btn-sm btn-light-success t-bold dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Normal
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item priority-item" data-priority="4" href="javascript:;"><span class="fas fa-circle text-light-danger f-10 me-2"></span>&nbsp; Kritis</a>
                                            <a class="dropdown-item priority-item" data-priority="3" href="javascript:;"><span class="fas fa-circle text-light-warning f-10 me-2"></span>&nbsp; Tinggi</a>
                                            <a class="dropdown-item priority-item" data-priority="2" href="javascript:;"><span class="fas fa-circle text-light-success f-10 me-2"></span>&nbsp; Normal</a>
                                            <a class="dropdown-item priority-item" data-priority="1" href="javascript:;"><span class="fas fa-circle text-light-info f-10 me-2"></span>&nbsp; Rendah</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <div class="list-tab m-0"><i class="feather icon-pie-chart f-16 text-primary"></i> &nbsp;Status:</div>
                                <div class="f-right">
                                    <div class="btn-group">
                                        <button type="button" id="task-status" class="btn btn-sm btn-light-danger t-bold dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Baru
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item status-item" data-status="1" href="javascript:;"><span class="fas fa-circle text-light-danger f-10 me-2"></span>&nbsp; Baru</a>
                                            <a class="dropdown-item status-item" data-status="2" href="javascript:;"><span class="fas fa-circle text-light-info f-10 me-2"></span>&nbsp; Proses</a>
                                            <a class="dropdown-item status-item" data-status="3" href="javascript:;"><span class="fas fa-circle text-light-warning f-10 me-2"></span>&nbsp; Tunda</a>
                                            <a class="dropdown-item status-item" data-status="4" href="javascript:;"><span class="fas fa-circle text-light-success f-10 me-2"></span>&nbsp; Selesai</a>
                                            <a class="dropdown-item status-item" data-status="5" href="javascript:;"><span class="fas fa-circle text-light f-10 me-2"></span>&nbsp; Tutup</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <div class="list-tab m-0"><i class="feather icon-user f-16 text-primary"></i> &nbsp;Added by:</div>
                                <div class="f-right">Bayu Prawira</div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <div class="list-tab m-0"><i class="feather icon-airplay f-16 text-primary"></i> &nbsp;Created:</div>
                                <div class="f-right">Senin, 27 Mei 2024</div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <div class="list-tab m-0"><i class="feather icon-clock f-16 text-primary"></i> &nbsp;Updated:</div>
                                <div class="f-right">Senin, 27 Mei 2024</div>
                            </li>
                        </ul>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5>Assigned Users</h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="align-items-center">
                                    <div class="row">
                                        <div class="col-md-4"><a href="#!"><img class="img-fluid img-radius wid-45" src="<?php print base_url("assets/images/user/avatar-4.jpg"); ?>"></a></div>
                                        <div class="col-md-8"><a href="#!" class="link-secondary"><span class="assign-user-name">Sortino media</span></a></div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="align-items-center">
                                    <div class="row">
                                        <div class="col-md-4"><a href="#!"><img class="img-fluid img-radius wid-45" src="<?php print base_url("assets/images/user/avatar-3.jpg"); ?>"></a></div>
                                        <div class="col-md-8"><a href="#!" class="link-secondary"><span class="assign-user-name">Larry heading</span></a> </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5>#24. Create UI design model</h5>
                        </div>
                        <div class="card-body card-border-bottom">
                            <p>A collection of textile samples lay <b>spread out</b> on the table One morning, when <b>Gregor Samsa</b> woke from troubled Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer...</p>
                            <p>A collection of textile samples lay <b>spread out</b> on the table One morning, when <b>Gregor Samsa</b> woke from troubled Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer...</p>
                            <p>A collection of textile samples lay <b>spread out</b> on the table One morning, when <b>Gregor Samsa</b> woke from troubled Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer...</p>
                        </div>
                        <div class="card-body card-border-bottom">
                            <div class="mb-2">Attached Files:</div>
                            <div class="row">
                                <div class="col-md-6"><a href="" class="btn-attch-file"><i class="far fa-file-pdf f-22 text-warning"></i> &nbsp;File PDF Terbaru</a></div>
                                <div class="col-md-6"><a href="" class="btn-attch-file"><i class="far fa-file-excel f-22 text-success"></i> &nbsp;File 2 Excel Versi Baru</a></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5><i class="feather icon-message-circle f-20 text-primary"></i> Comments</h5><button type="button" class="btn btn-light-primary btn-sm mb-0"><i class="fas fa-plus"></i> Add</button>
                        </div>
                        <div class="card-body border-bottom">
                            <div class="row-comment">
                                <div class="col-auto me-0"><img class="img-fluid img-radius wid-45 img-thumbnail" src="<?php print base_url("/assets/images/user/avatar-1.jpg"); ?>"></div>
                                <div class="col">
                                    <div class="h6">Larry heading <span class="f-12 text-muted ms-1 comment-time"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock wid-15 hei-15">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg> 15 min ago</span></div>
                                    <p class="comment-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                    <a href="#!" class="me-2 link-success">Edit</a>&nbsp;&nbsp;&nbsp;<a href="#!" class="me-2 link-danger text-danger">Delete</a>
                                    <hr />
                                </div>
                            </div>
                            <div class="row-comment">
                                <div class="col-auto me-0"><img class="img-fluid img-radius wid-45 img-thumbnail" src="<?php print base_url("assets/images/user/avatar-2.jpg"); ?>" alt="Generic placeholder image"></div>
                                <div class="col">
                                    <div class="h6">Joseph William <span class="f-12 text-muted ms-1 comment-time"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock wid-15 hei-15">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg> Just now</span></div>
                                    <p class="comment-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                    <a href="#!" class="me-2 link-success">Edit</a>&nbsp;&nbsp;&nbsp;<a href="#!" class="me-2 link-danger text-danger">Delete</a>
                                    <hr />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
			<!-- [ Main Content ] end -->
		</div>
	</div>
<?php $this->load->view("backend/includes/footer"); ?>
<script src="<?php print base_url('assets/js/task.js?v='.rand()); ?>"></script>
