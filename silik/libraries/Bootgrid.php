<?php
	if (! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Bootgrid {
		protected $core;
		protected $title;
		protected $tableId;
		protected $table;
		protected $tableJoin;
		protected $tableJoinType;
		protected $tableJoinCondition;
		protected $conditions = array();
		protected $columns = array();
		protected $errors;
		protected $output = array();
		protected $editBtn = array();
		protected $deleteBtn = array();
		protected $addBtn = array();
		protected $lockBtn = array();
		protected $toolbarBtn = array();
		protected $sortBy;
		protected $sortType;
		protected $search = array();
		protected $rowCount;
		protected $customFilter = array();
		protected $customFilterOptions = array();
		protected $cardRemove = "";
		protected $cardPrint = false;
		protected $cardDetail = array();
		protected $cardLink = array();
		protected $cardEdit = array();
		protected $columnTotal = array();
		
		public function __construct() {
			$this->core =& get_instance();
		}
		
		protected function setTableId() {
			$this->tableId = md5(uniqid(rand(), true));
		}
		
		protected function reset() {
			$this->tableId = "";
			$this->title = "";
			$this->table = "";
			$this->tableJoin = "";
			$this->tableJoinType = "";
			$this->tableJoinCondition = array();
			$this->conditions = array();
			$this->columns = array();
			$this->errors = "";
			$this->output = array();
			$this->editBtn = array();
			$this->deleteBtn = array();
			$this->addBtn = array();
			$this->toolbarBtn = array();
			$this->lockBtn = array();
			$this->sortBy = "";
			$this->sortType = "";
			$this->search = array();
			$this->rowCount = 10;
			$this->customFilter = array();
			$this->customFilterOptions = array();
			$this->cardRemove = "";
			$this->cardPrint = false;
			$this->cardDetail = array();
			$this->cardLink = array();
			$this->cardEdit = array();
			$this->columnTotal = array();
			
			$this->setTableId();
		}
		
		public function setTable ($table, $conditions = array()) {
			$this->reset();
			$this->table = $table;
			$this->conditions = $conditions;
		}
		
		public function setTitle ($title = "") {
			if (!empty($title)) {
				$this->title = $title;
			}
		}
		
		public function setTableJoin ($table) {
			$this->tableJoin = $table;
		}
		
		public function setTableJoinType ($type) {
			$this->tableJoinType = $type;
		}
		
		public function setTableJoinCondition ($condition) {
			$this->tableJoinCondition = $condition;
		}
		
		public function setFilter ($filter) {
			$this->filters = $filter;
		}
		
		public function setCustomFilter ($customFilter, $customFilterOptions = array()) {
			$this->customFilter[] = $customFilter;
			
			if (!empty($customFilterOptions)) {
				$this->customFilterOptions[$customFilter] = $customFilterOptions;
			}
		}
		
		public function setColumns ($param) {
			$this->columns = $param;
		}
		
		public function setConditions ($conditions) {
			$this->conditions = $conditions;
		}
		
		public function setAddButton ($param) {
			
			if (!isset($param["href"])) {
				$param["href"] = "/";
			}
			
			if (!isset($param["modal"])) {
				$param["modal"] = "normal";
			}
			
			$this->addBtn = $param;
		}
		
		public function setLockButton ($param) {			
			$this->lockBtn = $param;
		}
		
		public function setToolbarButton ($param) {
			$this->toolbarBtn[] = $param;
		}
		
		public function setEditButton ($param) {
			$this->editBtn = $param;
		}
		
		public function setDeleteButton ($param) {
			$this->deleteBtn = $param;
		}
		
		public function setToolButton ($param) {
			$this->toolBtn = $param;
		}
		
		public function setCardRemove ($param) {
			$this->cardRemove = $param;
		}
		
		public function setCardDetail ($param) {
			$this->cardDetail = $param;
		}
		
		public function setCardLink ($param) {
			$this->cardLink = $param;
		}
		
		public function setCardEdit ($param) {
			$this->cardEdit = $param;
		}
		
		public function setCardPrint ($param) {
			$this->cardPrint = $param;
		}
		
		public function sortBy ($param) {
			$this->sortBy = $param;
		}
		
		public function sortType ($param) {
			$this->sortType = $param;
		}
		
		private function checkErrors () {
			if (empty($this->table)) {
				$this->errors[] = "Need to set table name to display";
			}
			
			if (empty($this->columns)) {
				$this->errors[] = "Need to set field name to display";
			}
		}
		
		public function setRowCount($rowCount = 10) {
			$this->rowCount = $rowCount;
		}
		
		public function setRowTotal($columnTotal) {
			if (!empty($columnTotal)) {
				$this->columnTotal = $columnTotal;	
			}
		}
		
		private function renderErrors () {
			if (!empty($this->errors)) {
				foreach ($this->errors as $error) {
					$this->output[] = '<div class="alert alert-danger">'.$error.'</div>';
				}
			}
		}
		
		public function render () {
			$this->checkErrors();
			
			if (empty($this->errors)) {
				if (!empty($this->columns)) {
					$this->output[] = '<div class="card" id="bootgrid-card-'.$this->tableId.'">
					<div class="card-header">
						<h5 class="bootgrid-title">'.$this->title.'</h5>
					';
					
					if (!empty($this->cardDetail) || !empty($this->cardEdit) || $this->cardPrint || !empty($this->cardRemove || !empty($this->cardLink))) {
						$this->output[] = '<div class="card-header-right">
						<div class="btn-group card-option">
							<button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="feather icon-more-horizontal"></i>
							</button>
							<ul class="list-unstyled card-option dropdown-menu dropdown-menu-right" x-placement="bottom-end">';
							
							if (!empty($this->cardLink)) {
								foreach ($this->cardLink as $link) {
									$linkData = "";
									$linkClass = "";
									
									if (isset($link["data"]) && !empty($link["data"])) {
										foreach ($link["data"] as $key => $val) {
											$linkData .= ' data-'.$key.'="'.$val.'"';
										}
									}
									
									if (isset($link["class"]) && !empty($link["class"])) {
										$linkClass = $link["class"];
									}
									
									$this->output[] = '<li class="dropdown-item"><a href="'.$link["target"].'" class="link-card '.$linkClass.'" '.$linkData.'><i class="'.$link["icon"].'"></i> '.$link["text"].'</a></li>';
								}
							}
						
							if (!empty($this->cardDetail) && isset($this->cardDetail["modal"]["view"])) {
								$this->output[] = '<li class="dropdown-item"><a href="javascript:;" class="detail-card" data-modal-view="'.$this->cardDetail["modal"]["view"].'"><i class="feather icon-clipboard"></i> Detail</a></li>';
							}
						
							if (!empty($this->cardEdit) && isset($this->cardEdit["modal"]["view"])) {
								$this->output[] = '<li class="dropdown-item"><a href="javascript:;" class="edit-card" data-modal-view="'.$this->cardEdit["modal"]["view"].'"><i class="feather icon-edit"></i> Edit</a></li>';
							}
						
							if ($this->cardPrint) {
								$this->output[] = '<li class="dropdown-item"><a href="javascript:;" class="print-card"><i class="feather feather icon-printer"></i> Print</a></li>';
							}
							
							if (!empty($this->cardRemove)) {
								$this->output[] = '<li class="dropdown-item"><a href="javascript:;" class="remove-card" data-confirm="'.$this->cardRemove.'"><i class="feather icon-trash"></i> Hapus</a></li>';
							}

						$this->output[] = '</ul>
							</div>
						</div>';
					}
					
					$this->output[] = '</div>
					<div class="card-body">';
					
					$this->output[] = "<table id='bootgrid-".$this->tableId."' class='table table-condensed table-hover table-striped'>\n";
						$this->output[] = "<thead>\n";
							$this->output[] = "<tr>\n";
								foreach ($this->columns as $column) {
									$attr = "";
									if (isset($column["width"]) && !empty($column["width"])) {
										if (!empty($attr)) {$attr .= " ";}
										$attr .= "data-width='".$column["width"]."'";
									}
									
									if (isset($column["type"]) && !empty($column["type"])) {
										if (!empty($attr)) {$attr .= " ";}
										$attr .= "data-type='".$column["type"]."'";
									}
									
									if (isset($column["identifier"]) && !empty($column["identifier"])) {
										if (!empty($attr)) {$attr .= " ";}
										$attr .= "data-identifier='".$column["identifier"]."'";
									}
									
									if (isset($column["order"]) && !empty($column["order"])) {
										if (!empty($attr)) {$attr .= " ";}
										$attr .= "data-order='".$column["order"]."'";
									}
									
									if (isset($column["visible"]) && !empty($column["visible"])) {
										if (!empty($attr)) {$attr .= " ";}
										$attr .= "data-visible='".$column["visible"]."'";
									}
									
									if (isset($column["visibleInSelection"]) && !empty($column["visibleInSelection"])) {
										if (!empty($attr)) {$attr .= " ";}
										$attr .= "data-visible-in-selection='".$column["visible"]."'";
									}
									
									if (isset($column["align"]) && !empty($column["align"])) {
										if (!empty($attr)) {$attr .= " ";}
										$attr .= "data-align='".$column["align"]."'";
									}
									
									if (isset($column["class"]) && !empty($column["class"])) {
										if (!empty($attr)) {$attr .= " ";}
										$attr .= "data-header-css-class='".$column["class"]."'";
										$attr .= "data-css-class='".$column["class"]."'";
									}
									
									$this->output[] = "<th data-column-id='".$column["id"]."' ".$attr.">".$column["name"]."</th>\n";
								}
								
								if (!empty($this->editBtn) || !empty($this->deleteBtn)) {
									$colEditDeleteWidth = 88;
										
									if (!empty($this->editBtn)) {
										//$colEditDeleteWidth += 60;
									}

									if (!empty($this->deleteBtn)) {
										//$colEditDeleteWidth += 62;
									}
									
									$this->output[] = "<th data-column-id='edit-delete-action' data-visible-in-selection='false' class='headCol' data-width='".$colEditDeleteWidth."px'></th>\n";
								}
								else {
									$colEditDeleteWidth = 88;
									$this->output[] = "<th data-column-id='edit-delete-action' data-visible-in-selection='false' class='headCol' data-width='".$colEditDeleteWidth."px'></th>\n";
								}
					
							$this->output[] = "</tr>\n";
						$this->output[] = "</thead>\n";
					
						if (!empty($this->columnTotal)) {
							$indexTextTotal = $this->columnTotal["index_text"];
							
							$this->output[] = "<tfoot>\n";
								$this->output[] = "<tr>\n";
							
									foreach ($this->columns as $column) {
										
										if ($column["id"] == $indexTextTotal) {
											$this->output[] = "<th data-column-id='".$column["id"]."' data-sum='0'>TOTAL</th>\n";
										}
										else if (!empty($this->columnTotal["column_sum"]) && in_array($column["id"], $this->columnTotal["column_sum"])) {
											$colFormat = "";
											if (isset($column["format"])) {
												$colFormat = "data-format='".$column["format"]."'";
											}

											$this->output[] = "<th data-column-id='".$column["id"]."' data-sum='1' ".$colFormat.">Calculating..</th>\n";
										}
										else {
											$this->output[] = "<th data-column-id='".$column["id"]."' data-sum='0'>&nbsp;</th>\n";
										}
									}

									if (!empty($this->editBtn) || !empty($this->deleteBtn)) {
										$colEditDeleteWidth = 0;
										
										if (!empty($this->editBtn)) {
											$colEditDeleteWidth += 60;
										}
										
										if (!empty($this->deleteBtn)) {
											$colEditDeleteWidth += 62;
										}
										
										$this->output[] = "<th data-column-id='edit-delete-action' data-visible-in-selection='false' class='headCol' data-sum='0' data-width='".$colEditDeleteWidth."px' col='".count($this->columns)."'>&nbsp;</th>\n";
									}
									else {
										$colEditDeleteWidth = 0;
										
										//if (!empty($this->editBtn)) {
											$colEditDeleteWidth += 60;
										//}
										
										//if (!empty($this->deleteBtn)) {
											$colEditDeleteWidth += 62;
										//}
										
										$this->output[] = "<th data-column-id='edit-delete-action' data-visible-in-selection='false' class='headCol' data-sum='0' data-width='".$colEditDeleteWidth."px' col='".count($this->columns)."'>&nbsp;</th>\n";
									}

								$this->output[] = "</tr>\n";
							$this->output[] = "</tfoot>\n";
						}
					$this->output[] = "</table>\n";
					
					$this->output[] = '</div></div>';
					
					$model = array();
					$model["table"] = $this->table;
					$model["columns"] = $this->columns;
					
					if (!empty($this->conditions)) {
						$model["conditions"] = $this->conditions;
					}
					
					if (!empty($this->tableJoin)) {
						$model["tableJoin"] = $this->tableJoin;
					}
					
					if (!empty($this->tableJoinType)) {
						$model["tableJoinType"] = $this->tableJoinType;
					}
					
					if (!empty($this->tableJoinCondition)) {
						$model["tableJoinCondition"] = $this->tableJoinCondition;
					}
					
					if (!empty($this->editBtn)) {
						$model["editBtn"] = $this->editBtn;
					}
					
					if (!empty($this->deleteBtn)) {
						$model["deleteBtn"] = $this->deleteBtn;
					}
					
					$removeFooter = '';
					if ($this->rowCount < 0) {
						$removeFooter = '$("#bootgrid-'.$this->tableId.'-footer").remove()';
					}
					
					
					$addBtn = "";
					
					if (!empty($this->addBtn)) {
						
						$addBtnParentId = '';
						
						if (isset($this->addBtn["parent"])) {
							$addBtnParentId = 'data-parent=\''.$this->addBtn["parent"].'\'';
						}
						
						$addBtnData = '';
						$addBtnDataJs = '';
						$addBtnDataParam = '';
						
						if (isset($this->addBtn["modal"]["data"]) && !empty($this->addBtn["modal"]["data"])) {
							$addBtnDataJs .= 'var modalData = [];';
							foreach ($this->addBtn["modal"]["data"] as $keyDo => $do) {
								$addBtnData .= ' data-'.$keyDo.'=\''.$do.'\'';
								$addBtnDataJs .= 'var obj'.$keyDo.' = {}; obj'.$keyDo.'["name"] = \''.$keyDo.'\';  obj'.$keyDo.'["value"] = \''.$do.'\'; ';
								$addBtnDataJs .= 'modalData.push(obj'.$keyDo.');';
								
								// hack
								$addBtnDataParam .= $keyDo.': \''.$do.'\',';
							}
							
							//$addBtnDataParam .= 'data: modalData,';
						}
						
						$addBtn = 'if (!$("#bootgrid-'.$this->tableId.'-header").find(".bootgrid-add-btn").length) {
							$("<a id=\'bootgrid-add-'.$this->tableId.'\' title=\'Tambah\' class=\'bootgrid-add-btn btn btn-info\' data-view=\''.$this->addBtn["modal"]["view"].'\' '.$addBtnParentId.$addBtnData.'>'.$this->addBtn["text"].'</a>").insertBefore("#bootgrid-'.$this->tableId.'-header .actionBar .actions");
						}
						$("#bootgrid-add-'.$this->tableId.'").click(function() {
							$("#add-modal-'.$this->tableId.'").modal("show");
							var modalAction = $(this).attr("data-action");
							var modalView = $(this).attr("data-view");
							var modalTableId = $(this).attr("data-table-id");
							var modalParentId = $(this).attr("data-parent");
							
							'.$addBtnDataJs.'
							
							Loader.start();
							
							$.ajax({
								type: "POST",
								url: "/bootgrids/loadModalForm/?v="+Math.random(),
								data: {
									action: modalAction,
									view: modalView,
									tableId: modalTableId,
									parentId: modalParentId,
									'.$addBtnDataParam.'
									version: Math.random()				
								},
								dataType: "html",
								success: function(html){
									Loader.stop();
									var modalWrap = \'<div class="modal fade" id="add-modal-'.$this->tableId.'"  role="dialog" aria-labelledby="add-modal-'.$this->tableId.'" data-backdrop="static"><div id="replace-modal-'.$this->tableId.'">\'+html+\'</div></div>\';
									
									if (!$("#add-modal-'.$this->tableId.'").length) {
										$("body").append(modalWrap);
										$("#add-modal-'.$this->tableId.'").find("form").attr("data-table-id","bootgrid-'.$this->tableId.'");

										AutoNumeric.init();
										Select2.init();
										Datepicker.init();
									}
									
									$("#add-modal-'.$this->tableId.'").modal("show");
								}
							});
						});';
					}
					
					
					$toolbarBtn = "";
					
					if (!empty($this->toolbarBtn)) {
						foreach ($this->toolbarBtn as $foo) {
							$toolbarParent = "";

							if (isset($foo["parent"])) {
								$toolbarParent = "data-parent='".$foo["parent"]."'";
							}

							$toolbarParentTable = "";

							if (isset($foo["parent_field"])) {
								$toolbarParentTable = "data-parent-field='".$foo["parent_field"]."'";
							}

							$toolbarBtn .= 'if (!$("#bootgrid-'.$this->tableId.'-header").find(".'.$foo["class"].'").length) {
								$("#bootgrid-'.$this->tableId.'-header .actionBar .actions").append("<button '.$toolbarParent." ".$toolbarParentTable.' class=\'btn btn-default '.$foo["class"].'\' type=\'button\' data-table=\''.$this->table.'\' title=\''.$foo["title"].'\'><span class=\''.$foo["icon"].'\'></span></button>");
							}';
						}
					}
					
					
					
					$lockBtn = "";
					
					if (!empty($this->lockBtn)) {
						$iconLock = '<span class=\'fas fa-unlock-alt\'></span>';
						$valueLock = "1";
						$titleLock = "Lock All";
						
						if ($this->lockBtn["lock"] == "1") {
							$iconLock = '<span class=\'fas fa-lock\'></span>';
							$valueLock = "0";
							$titleLock = "Unlock All";
						}
						
						$lockBtn = 'if (!$("#bootgrid-'.$this->tableId.'-header").find(".bootgrid-lock-btn").length) {
							$("#bootgrid-'.$this->tableId.'-header .actionBar .actions").append("<button class=\'btn btn-default bootgrid-lock-btn\' data-spj=\''.$this->lockBtn["spj"].'\' data-lock=\''.$valueLock.'\' type=\'button\' title=\''.$titleLock.'\'>'.$iconLock.'</button>");
						}';
					}
					
					$yearCreatedDate = '';
					$modelYearCreatedDate = '';
					$kabKota = '';
					$modelKabKota = '';
					$kabKotaTujuan = '';
					$modelKabKotaTujuan = '';
					$filterBulan = '';
					$modelFilterBulan = '';
					$filKelas = '';
					$modelKelas = '';
					
					if (!empty($this->customFilter)) {
						foreach ($this->customFilter as $cf) {
							if ($cf == "year_created_date") {
								$yearCreatedDate = 'if (!$("#bootgrid-'.$this->tableId.'-header").find(".bootgrid-year_created_date-filter").length) {';
								$yearCreatedDate .= '$(\'<div class="bootgrid-year_created_date-filter form-group"><select class="year_created_date_filter form-control">';
									$yearMin5 = date("Y") - 5;
									$yearNow = date("Y");
								
									foreach (range($yearMin5,$yearNow) as $filterYear) {
										$selected = '';
										if ($filterYear == $yearNow) {
											$selected = 'selected="selected"';
										}
										$yearCreatedDate .= '<option value="'.$filterYear.'" '.$selected.'>'.$filterYear.'</option>';
									}
									
									$yearCreatedDate .= '</select></div>\').insertAfter("#bootgrid-'.$this->tableId.'-header .search"); ';
								
									$yearCreatedDate .= '$("#bootgrid-'.$this->tableId.'-header").find(".bootgrid-year_created_date-filter select").change(function () { Table.refreshTable("bootgrid-'.$this->tableId.'"); });';
								
								$yearCreatedDate .= '} ';
								
								$modelYearCreatedDate = 'if ($("#bootgrid-'.$this->tableId.'-header").find(".bootgrid-year_created_date-filter").length) {
									model.filterYearCreatedDate = $("#bootgrid-'.$this->tableId.'-header").find(".bootgrid-year_created_date-filter select").val();
								} else {model.filterYearCreatedDate = "'.$yearNow.'"; }';
							}
							else if ($cf == "kabupaten_kota") {
								$kabKota = 'if (!$("#bootgrid-'.$this->tableId.'-header").find(".bootgrid-kab_kota-filter").length) {';
								$kabKota .= '$(\'<div class="bootgrid-kab_kota-filter form-group" style="display:inline-block;"><select class="kab_kota_filter form-control">';
									
									$areas = array();
									$areas[""] = "Semua Kabupaten"; 

									foreach ($this->core->config->item("provinsi") as $provinsi => $kabs) {

										if ($provinsi == $_ENV["DEFAULT_PROVINSI"]) {
											
											foreach ($kabs as $kab) {
												$areas[$kab] = $kab;
											}
										}
										
									}
																	
									foreach ($areas as $area) {
										$kabKota .= '<option value="'.$area.'">'.$area.'</option>';
									}
									
									$kabKota .= '</select></div>\').insertAfter("#bootgrid-'.$this->tableId.'-header .search"); ';
								
									$kabKota .= '$("#bootgrid-'.$this->tableId.'-header").find(".bootgrid-kab_kota-filter select").change(function () { Table.reloadTable("bootgrid-'.$this->tableId.'"); });';
								
								$kabKota .= '} ';
								
								$modelKabKota = 'if ($("#bootgrid-'.$this->tableId.'-header").find(".bootgrid-kab_kota-filter").length) {
									model.filterKabKota = $("#bootgrid-'.$this->tableId.'-header").find(".bootgrid-kab_kota-filter select").val();
								} else {model.filterKabKota = ""; }';
							}
							else if ($cf == "kabupaten_kota_tujuan") {
								$kabKotaTujuan = 'if (!$("#bootgrid-'.$this->tableId.'-header").find(".bootgrid-kab_kota_tujuan-filter").length) {';
								$kabKotaTujuan .= '$(\'<div class="bootgrid-kab_kota_tujuan-filter form-group" style="display:inline-block;"><select class="kab_kota_tujuan_filter form-control">';
									
									$areas = array();
									$areas[""] = "Semua Kabupaten"; 

									foreach ($this->core->config->item("provinsi") as $provinsi => $kabs) {

										if ($provinsi == $_ENV["DEFAULT_PROVINSI"]) {
											
											foreach ($kabs as $kab) {
												$areas[$kab] = $kab;
											}
										}
										
									}
																	
									foreach ($areas as $area) {
										$kabKotaTujuan .= '<option value="'.$area.'">'.$area.'</option>';
									}
									
									$kabKotaTujuan .= '</select></div>\').insertAfter("#bootgrid-'.$this->tableId.'-header .search"); ';
								
									$kabKotaTujuan .= '$("#bootgrid-'.$this->tableId.'-header").find(".bootgrid-kab_kota_tujuan-filter select").change(function () { Table.reloadTable("bootgrid-'.$this->tableId.'"); });';
								
								$kabKotaTujuan .= '} ';
								
								$modelKabKotaTujuan = 'if ($("#bootgrid-'.$this->tableId.'-header").find(".bootgrid-kab_kota_tujuan-filter").length) {
									model.filterKabKotaTujuan = $("#bootgrid-'.$this->tableId.'-header").find(".bootgrid-kab_kota_tujuan-filter select").val();
								} else {model.filterKabKotaTujuan = ""; }';
							}
							else if ($cf == "bulan") {
								$filterBulan = 'if (!$("#bootgrid-'.$this->tableId.'-header").find(".bootgrid-bulan-filter").length) {';
								$filterBulan .= '$(\'<div class="bootgrid-bulan-filter form-group" style="display:inline-block;"><select class="bulan_filter form-control">';
									
									$bulans = array (
										1 => 'Januari',
										2 => 'Februari',
										3 => 'Maret',
										4 => 'April',
										5 => 'Mei',
										6 => 'Juni',
										7 => 'Juli',
										8 => 'Agustus',
										9 => 'September',
										10 => 'Oktober',
										11 => 'November',
										12 => 'Desember'
									);

									$selectedValue = date("m");

									if (isset($this->customFilterOptions[$cf]["selected"]) && !empty($this->customFilterOptions[$cf]["selected"])) {
										$selectedValue = $this->customFilterOptions[$cf]["selected"];
									}
																	
									foreach ($bulans as $keyBulan => $bulan) {
										$selected = "";

										if ($keyBulan == $selectedValue) {
											$selected = 'selected="selected"';
										}
										
										$filterBulan .= '<option value="'.$keyBulan.'" '.$selected.'>'.$bulan.'</option>';
									}
									
									$filterBulan .= '</select></div>\').insertAfter("#bootgrid-'.$this->tableId.'-header .search"); ';
								
									$filterBulan .= '$("#bootgrid-'.$this->tableId.'-header").find(".bootgrid-bulan-filter select").change(function () { Table.reloadTable("bootgrid-'.$this->tableId.'"); });';
								
								$filterBulan .= '} ';
								
								$modelFilterBulan = 'if ($("#bootgrid-'.$this->tableId.'-header").find(".bootgrid-bulan-filter").length) {
									model.filterBulan = $("#bootgrid-'.$this->tableId.'-header").find(".bootgrid-bulan-filter select").val();
								} else {model.filterBulan = "'.$selectedValue.'"; }';
							}
							else if ($cf == "kelas") {
								$filKelas = 'if (!$("#bootgrid-'.$this->tableId.'-header").find(".bootgrid-filter_kelas-filter").length) {';
								$filKelas .= '$(\'<div class="bootgrid-filter_kelas-filter form-group" style="display:inline-block;"><select class="filter_kelas form-control">';
								
									$kelas = array();
									$kelas[""] = "Semua Kelas";
									$kategories = array();
								
									if (isset($this->customFilterOptions[$cf]) && !empty($this->customFilterOptions[$cf])) {
										$kategories = explode("\n", $this->customFilterOptions[$cf]);
									}
									
									if (!empty($kategories)) {
										foreach ($kategories as $kls) {
											$kelas[$kls] = $kls;
										}
										
										foreach ($kelas as $kls) {
											$filKelas .= '<option value="'.$kls.'">'.$kls.'</option>';
										}
									}
									
									$filKelas .= '</select></div>\').insertAfter("#bootgrid-'.$this->tableId.'-header .search"); ';
								
									$filKelas .= '$("#bootgrid-'.$this->tableId.'-header").find(".bootgrid-filter_kelas-filter select").change(function () { Table.reloadTable("bootgrid-'.$this->tableId.'"); });';
								
								$filKelas .= '} ';

								$modelKelas = 'if ($("#bootgrid-'.$this->tableId.'-header").find(".bootgrid-filter_kelas-filter").length) {
									model.filterKelas = $("#bootgrid-'.$this->tableId.'-header").find(".bootgrid-filter_kelas-filter select").val();
								} else {model.filterKelas = ""; }';
							}
						}
					}
					
					$freeze = "var freezeId = {};";
					$freeze .= '$("#bootgrid-'.$this->tableId.' thead th:not(.select-cell)").each(function(i){';
						$freeze .= 'var nth = i + 2;';	
						$freeze .= 'freezeId[$(this).attr("data-column-id")] = nth;';
					$freeze .= '});';
					
					foreach ($this->columns as $iC => $column) {
						if (isset($column["freeze"]) && ($column["freeze"] == "1" || $column["freeze"] == "true")) {
							$nth = $iC + 2;
							$freeze .= 'if ("'.$column["id"].'" in freezeId) {';
							$freeze .= '$("#bootgrid-'.$this->tableId.' tr > :nth-child("+freezeId["'.$column["id"].'"]+")").attr("data-freeze","1");';
							$freeze .= '}';
						}
					}
					
					$calculateTotal = "";
					
					if (!empty($this->columnTotal)) {
						$calculateTotal = 'Table.rowTotal("bootgrid-'.$this->tableId.'");';
					}
					
					
					// default set order data
					$sortDataDefault = "";
					
					if (!empty($this->sortBy)) {
						$sortDataDefault = "model.sortBy = '".$this->sortBy."';";
						
						if (!empty($this->sortType)) {
							$sortDataDefault .= "model.sortDirection = '".$this->sortType."';";
						}
						else {
							$sortDataDefault .= "model.sortDirection = 'ASC';";
						}
					}
					
					$this->output[] = '<script type="text/javascript">
						$(document).ready(function() {
							var selectedAllRows = [];
							var selectedRows = [];
							var deselectedRows = [];
							var gridFirstLoaded = [];

							var grid_'.$this->tableId.' = $("#bootgrid-'.$this->tableId.'").bootgrid({
								selection: true,
								multiSelect: true,
								keepSelection: false,
								rowCount: '.$this->rowCount.',
								requestHandler: function (request) {
									var model = '.json_encode($model).';

									model.current = request.current;
									model.rowCount = request.rowCount;
									model.search = request.searchPhrase;
									
									'.$sortDataDefault.'
									
									for (var key in request.sort) {
										model.sortBy = key;
										model.sortDirection = request.sort[key];
									}
									
									'.$modelYearCreatedDate.'
									
									'.$modelKabKota.'

									'.$modelKabKotaTujuan.'

									'.$modelFilterBulan.'

									'.$modelKelas.'

									return JSON.stringify(model);
								},
								ajaxSettings: {
									method: "POST",
									contentType: "application/json"
								},
								ajax: true,
								url: "/bootgrids/data/"
							}).on("loaded.rs.jquery.bootgrid", function(e) {
								'.$yearCreatedDate.'
								'.$kabKota.'
								'.$kabKotaTujuan.'
								'.$filterBulan.'
								'.$filKelas.'
								'.$addBtn.'
								'.$toolbarBtn.'
								'.$lockBtn.'
								'.$removeFooter.'
								
								if (!$("#bootgrid-'.$this->tableId.'").parent(".wrap-table-bootgrid").length) {
									$("#bootgrid-'.$this->tableId.'").wrap(\'<div class="wrap-table-bootgrid"></div>\');
								}
								
								if ($("#bootgrid-'.$this->tableId.' tr > :nth-child(1)").hasClass("select-cell")) {
									$("#bootgrid-'.$this->tableId.' tr > :nth-child(1)").attr("data-freeze","1");
								}
								
								'.$freeze.'
								
								Table.columnFreeze("bootgrid-'.$this->tableId.'");
								
								'.$calculateTotal.'
															
								$("#bootgrid-'.$this->tableId.' .row-event-click").click(function(e) {
									Table.rowEventClick(e);
								});


								if (typeof selectedAllRows["'.$this->tableId.'"] === "undefined") {
									selectedAllRows["'.$this->tableId.'"] = false;
								}

								if (typeof selectedRows["'.$this->tableId.'"] === "undefined") {
									selectedRows["'.$this->tableId.'"] = {};
								}

								if (typeof deselectedRows["'.$this->tableId.'"] === "undefined") {
									deselectedRows["'.$this->tableId.'"] = {};
								}

								if (selectedAllRows["'.$this->tableId.'"]) {
									// Fetch only the rows visible on this newly loaded page
									var currentPageRows = $(this).bootgrid("getCurrentRows");
									
									// Extract their IDs
									var currentIds = currentPageRows.map(function(row) { return row.id; });
									var visited = false;

									$.each(currentIds, function(key, value) {
										if (typeof selectedRows["'.$this->tableId.'"][value] !== "undefined") {
											visited = true;
										}
									});

									
									if (visited) {
										if (typeof selectedRows["'.$this->tableId.'"] !== "undefined" && selectedRows["'.$this->tableId.'"] !== null && !$.isEmptyObject(selectedRows["'.$this->tableId.'"])) {
											var selectAgain = [];

											$.each(selectedRows["'.$this->tableId.'"], function(key, value) {
												selectAgain.push(value);
											});

											if (selectAgain.length) {
												$(this).bootgrid("select", selectAgain);
											}
										}
									}
									else {
										// Automatically check them so they dont appear blank to the user
										$(this).bootgrid("select", currentIds);
									}
   								}
								else {

									if (typeof selectedRows["'.$this->tableId.'"] !== "undefined" && selectedRows["'.$this->tableId.'"] !== null && !$.isEmptyObject(selectedRows["'.$this->tableId.'"])) {
										var selectAgain = [];

										$.each(selectedRows["'.$this->tableId.'"], function(key, value) {
											selectAgain.push(value);
										});

										if (selectAgain.length) {
											$(this).bootgrid("select", selectAgain);
										}
									}
								}

								if (typeof gridFirstLoaded["'.$this->tableId.'"] === "undefined" || gridFirstLoaded["'.$this->tableId.'"] === null || $.isEmptyObject(gridFirstLoaded["'.$this->tableId.'"])) {
									
									$(e.target).find("thead").find(".select-box").change(function () {
										if ($(this).is(":checked")) {
											selectedAllRows["'.$this->tableId.'"] = true;
											selectedRows["'.$this->tableId.'"] = {};
											deselectedRows["'.$this->tableId.'"] = {};
										} else {
											selectedAllRows["'.$this->tableId.'"] = false;
											selectedRows["'.$this->tableId.'"] = {};
											deselectedRows["'.$this->tableId.'"] = {};
											grid_'.$this->tableId.'.bootgrid("deselect");
										}
									});

									gridFirstLoaded["'.$this->tableId.'"] = true;
								}

							}).on("selected.rs.jquery.bootgrid", function(e, rows) {

								rows.forEach(function(row) {
									selectedRows["'.$this->tableId.'"][row.id] = row.id;

									if ("'.$this->tableId.'" in deselectedRows && row.id in deselectedRows["'.$this->tableId.'"]) {
										delete deselectedRows["'.$this->tableId.'"][row.id];
									}
								});

							}).on("deselected.rs.jquery.bootgrid", function(e, rows) {

								rows.forEach(function(row) {
									delete selectedRows["'.$this->tableId.'"][row.id];

									if (selectedAllRows["'.$this->tableId.'"]) {
										deselectedRows["'.$this->tableId.'"][row.id] = row.id;
									}
								});
							});

							$(document).on("click", "#bootgrid-'.$this->tableId.'-header .delete_multi_item", function () {

								if (selectedAllRows["'.$this->tableId.'"] || !$.isEmptyObject(selectedRows["'.$this->tableId.'"])) {

									var tableName = $(this).attr("data-table");
									var parent = $(this).attr("data-parent");
									var parentField = $(this).attr("data-parent-field");

									Swal.fire({
										title: "Apakah anda yakin?",
										text: "Data yang telah dihapus tidak bisa dikembalikan lagi",
										icon: "warning",
										showCancelButton: true,
										confirmButtonText: "Ya, Hapus",
										cancelButtonText: "Batal"
									}).then((result) => {
										if (result.value) {
											Loader.start();
		
											$.ajax({
												type: "POST",
												url: "/bootgrids/delete_multi_row/",
												data: {
													all_rows: selectedAllRows["'.$this->tableId.'"],
													selected_rows: selectedRows["'.$this->tableId.'"],
													deselected_rows: deselectedRows["'.$this->tableId.'"],
													table: tableName,
													parent_field: parentField,
													parent: parent,
													version: Math.random()				
												},
												dataType: "json",
												success: function(obj){
													selectedAllRows["'.$this->tableId.'"] = false;
													selectedRows["'.$this->tableId.'"] = {};
													deselectedRows["'.$this->tableId.'"] = {};

													Table.refreshTable("bootgrid-'.$this->tableId.'");
													
													Loader.stop();
												}
											});
										}
									});
								}
								else {
									Swal.fire(
										"Peringatan!",
										"Tidak ada item yang dipilih.",
										"warning"
									);
								}
									
							});
						});
						
					</script>';
				}
			}
			else {
				$this->renderErrors();
			}
			
			return join($this->output);
		}
	}
?>