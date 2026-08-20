<?php
	if (! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Chart {
		protected $CI;
		
		public function __construct() {
			$this->CI =& get_instance();
		}
		
		public function pie ($id, $chart, $width = "100%", $height = "100%") {
			print '<div id="'.$id.'" style="width:'.$width.'; height:'.$height.';"></div>';
			
			$chartData = array();
			
			if (!empty($chart["data"])) {
				foreach ($chart["data"] as $key => $foo) {
					$chartData[$key]["name"] = $foo["nama"];
					$chartData[$key]["y"] = $foo["value"];
				}	
			}
			
			print '<script type="text/javascript">$(document).ready(function() {';
				print "var ".$id." = Highcharts.chart('".$id."', {
					chart: {
						plotBackgroundColor: null,
						plotBorderWidth: null,
						zooming: {
							type: 'xy'
						},
						plotShadow: true,
						type: 'pie'
					},
					title: {
						text: '".$chart["title"]."',
						style: {
							fontSize: '18px',
							fontFamily: '\"Open Sans\", sans-serif',
							fontWeight: 400 
						}
					},
					tooltip: {
						pointFormat: '<b>{point.percentage:.1f}%</b>'
					},
					accessibility: {
						point: {
							valueSuffix: '%'
						}
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true
							},
							showInLegend: true
						},
						series: {
							dataLabels: {
								enabled: true,
								formatter: function() {
									return Math.round(this.percentage*100)/100 + ' %';
								},
								distance: -30,
								style:{
									fontSize: '11px'
								}
							}
						}
					},
					series: [{
						name: '".$chart["title"]."',
						colorByPoint: true,
						data: ".json_encode($chartData)."
					}],
					legend: {
						itemStyle: {
							fontSize:'11px'
						}
					}
				});";
			print '});</script>';
		}
		
		
		public function column ($id, $chart, $width = "100%", $height = "100%") {
			
			print '<div id="'.$id.'" style="width:'.$width.'; height:'.$height.';"></div>';
			
			$chartData = array();
			
			if (!empty($chart["data"])) {
				foreach ($chart["data"] as $key => $foo) {
					$chartData[$key]["name"] = $foo["nama"];
					$chartData[$key]["data"] = $foo["value"];
				}	
			}
			
			print '<script type="text/javascript">$(document).ready(function() {';
			print "var ".$id." = Highcharts.chart('".$id."', {
				chart: {
					type: 'column'
				},
				title: {
					text: '".$chart["title"]."',
					style: {
						fontSize: '18px',
						fontFamily: '\"Open Sans\", sans-serif',
						fontWeight: 400 
					}
				},
				subtitle: {
					text: ''
				},
				xAxis: {
					categories: ".json_encode($chart["categories"]).",
					crosshair: true,
					labels: {
						style:{
							fontSize: '11px'
						}
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: ''
					},
					labels: {
						style:{
							fontSize: '11px'
						}
					}
				},
				tooltip: {
					headerFormat: '<span style=\"font-size:10px\">{point.key}</span><table>',
					pointFormat: '<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>' +
						'<td style=\"padding:0\"><b>{point.y:,.0f}</b></td></tr>',
					footerFormat: '</table>',
					shared: true,
					useHTML: true
				},
				plotOptions: {
					column: {
						pointPadding: 0.1,
						borderWidth: 0
					}
				},
				legend: {
					itemStyle: {
						fontSize:'11px'
					}
				},
				series: ".json_encode($chartData)."
			});";
			print '});</script>';
		}
		
		
		public function columnDouble ($id, $chart, $width = "100%", $height = "100%") {
			
			print '<div id="'.$id.'" style="width:'.$width.'; height:'.$height.';"></div>';
			
			$chartData = array();
			
			if (!empty($chart["data"])) {
				foreach ($chart["data"] as $key => $foo) {
					$chartData[$key]["name"] = $foo["nama"];
					$chartData[$key]["data"] = $foo["value"];
					$chartData[$key]["stack"] = 'male';
				}	
			}
			
			print '<script type="text/javascript">$(document).ready(function() {';
				print "var ".$id." = Highcharts.chart('".$id."', {

					chart: {
						type: 'column'
					},

					title: {
						text: '".$chart["title"]."',
						style: {
							fontSize: '18px',
							fontFamily: '\"Open Sans\", sans-serif',
							fontWeight: 400 
						}
					},

					xAxis: {
						categories: ".json_encode($chart["categories"])."
					},

					yAxis: {
						allowDecimals: false,
						min: 0,
						title: {
							text: ''
						}
					},

					tooltip: {
						formatter: function () {
							return '<b>' + this.x + '</b><br/>' +
								this.series.name + ': Rp. ' + SPJ.formatNumber(this.y) + '<br/>' +
								'Total: Rp. ' + SPJ.formatNumber(this.point.stackTotal);
						}
					},

					plotOptions: {
						column: {
							stacking: 'normal'
						}
					},

					series: ".json_encode($chartData)."
				});";
			
			print '});</script>';
		}
		
		public function lineDate ($id, $chart, $width = "100%", $height = "100%") {
			print '<div id="'.$id.'" style="width:'.$width.'; height:'.$height.';"></div>';
			
			print '<script type="text/javascript">$(document).ready(function() {';
			print "
				Highcharts.chart('".$id."', {
				  title: {
					text: '".$chart["title"]."',
					style: {
						fontSize: '18px',
						fontFamily: '\"Open Sans\", sans-serif',
						fontWeight: 400 
					}
				  },
				  yAxis: {
						title: {
							text: '".$chart["title_y"]."'
						}
					},
				  xAxis: {
					type: 'category',
				  },
				  series: ".json_encode($chart["data"])."
				});
			";
			
			print '});</script>';
		}

		public function stackedPct ($id, $chart, $width = "100%", $height = "100%") {
			print '<div id="'.$id.'" style="width:'.$width.'; height:'.$height.';"></div>';

			print '<script type="text/javascript">$(document).ready(function() {';
			print "Highcharts.chart('".$id."', {
				chart: {
					type: 'column'
				},
				title: {
					text: '".$chart["title"]."',
				},
				xAxis: {
					categories: ['2019', '2020', '2021', '2022']
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Percent'
					}
				},
				tooltip: {
					pointFormat: '<span style=\"color:{series.color}\">{series.name}</span>' +
						': <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
					shared: true
				},
				plotOptions: {
					column: {
						stacking: 'percent',
						dataLabels: {
							enabled: true,
							format: '{point.percentage:.0f}%'
						}
					}
				},
				colors: ['#2ebf55', '#d4b428', '#bf2e2e'],
				series: [
				{
					name: 'Tepat Waktu',
					data: [59, 58, 54, 50]
				},
				{
					name: 'Terlambat',
					data: [3, 5, 8, 14]
				},
				{
					name: 'Tidak Hadir',
					data: [2, 1, 2, 0]
				}]
			});";
			print '});</script>';
		}
	}
?>