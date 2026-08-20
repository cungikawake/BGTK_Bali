<?php
	if (! defined('BASEPATH')) exit('No direct script access allowed');
	
	require APPPATH .'third_party/Office/vendor/autoload.php';
	
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Cell\DataType;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	use PhpOffice\PhpSpreadsheet\Writer\Csv;

	class Excel {
		
		protected function createSpreadsheet ($data = array()) {
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			
			$colKey = array();
			
			for ($i = 65; $i <= 90; $i++) {
				$colKey[] = chr($i);
			}
			
			foreach ($colKey as $foo) {
				for ($i = 65; $i <= 90; $i++) {
					$colKey[] = $foo.chr($i);
				}
			}

			if (!empty($data)) {
				$row = 1;
				
				foreach ($data as $cols) {
					foreach ($cols as $key => $val) {
						$sheet->setCellValueExplicit($colKey[$key].$row, $val, DataType::TYPE_STRING);
						
						// SET COLOR VALID REKENING
						if ($key == 23 && $val == 1) {
							$sheet
							->getStyle($colKey[$key-3].$row.":".$colKey[$key].$row)
							->getFill()
							->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							->getStartColor()
							->setARGB('9cd6a3');
						}
						
					}
					
					$row++;
				}
			}
			
			return $spreadsheet;
		}
		
		public function create ($data = array(), $name = "export_sipandu") {
			$spreadsheet = $this->createSpreadsheet($data);

			$writer = new Xlsx($spreadsheet);
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="'. $name.".xlsx".'"');
			$writer->save('php://output');
		}
		
		public function csv ($data = array(), $name = "export_sipandu") {
			$spreadsheet = $this->createSpreadsheet($data);

			$writer = new Csv($spreadsheet);
			$writer->setDelimiter(',');
			//$writer->setEnclosure('"');
			$writer->setEnclosure('');
			$writer->setLineEnding("\r\n");
			$writer->setSheetIndex(0);
			
			header('Content-Type: text/csv');
			header('Content-Disposition: attachment; filename="'. $name.".csv".'"');
			$writer->save('php://output');
		}
	}