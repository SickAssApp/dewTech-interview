<?php
	class MigrationController extends AppController{
		
		public function q1(){
			
			$this->setFlash('Question: Migration of data to multiple DB table');
				
			
// 			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
		}
		
		public function q1_instruction(){

			$this->setFlash('Question: Migration of data to multiple DB table');
				
			
			
// 			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
		}
		
		public function index(){
			
			App::import('Vendor', 'PhpExcel.PHPExcel');        
			require_once(APP. 'Vendor'.DS.'PHPExcel'.DS.'IOFactory.php');
			
			$objPHPExcel = PHPExcel_IOFactory::load(WWW_ROOT.'files'.DS.'migration_sample_1.xlsx');
			
			$objWorksheet = $objPHPExcel->getActiveSheet();
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {				
			
				foreach ($worksheet->getRowIterator() as $row) {
					// echo '    Row number - '.$row->getRowIndex().'<br>';
					$rowNum = $row->getRowIndex();
			
					$cellIterator = $row->getCellIterator();
					$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
					if($rowNum != 1){
						$member = array();
						$tran = array();
						$tranItem = array();

						foreach ($cellIterator as $cell) {

							if (!is_null($cell)) {								
								$cord = $cell->getCoordinate();
								// echo 'Cell - ' , $cell->getCoordinate() , ' - ' , $cell->getCalculatedValue() , '<br>';
								// echo '        Cell - ' , $cell->getCoordinate() , ' - ' , $cell->getValue() , '<br>';
								switch ($cord[0]) {
									case 'A':
										$cellDate = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($cell->getValue()));
										$tmpAry = explode('-',$cellDate);
										$tran['date'] = $cellDate;
										$tran['month'] = $tmpAry[0];
										$tran['year'] = $tmpAry[2];
										break;
									case 'B':
										$tran['ref_no'] = $cell->getCalculatedValue();
										break;
									case 'C':
										$member['name']		= $cell->getCalculatedValue();
										break;
									case 'D':										
										$tmpAry = explode(" ",$cell->getCalculatedValue());
										$member['type'] 	= $tmpAry[0];
										$member['no'] 		= $tmpAry[1];
										break;	
									case 'E':
										$tran['member_paytype'] = $cell->getCalculatedValue();
										break;
									case 'G':
										$tran['payment_method'] = $cell->getCalculatedValue();
										break;
									case 'L':
										$tran['renewal_year'] = $cell->getCalculatedValue();
										if(empty($tran['renewal_year'])){
											$tran['renewal_year'] = 0;
										}
										break;
									case 'I':
										$tran['receipt_no'] = $cell->getCalculatedValue();
										break;
									case 'J':
										$tran['cheque_no'] = $cell->getCalculatedValue();
										break;
									case 'K':
										$tran['payment_type'] = $cell->getCalculatedValue();
										break;
									case 'H':
										$tran['batch_no'] = $cell->getCalculatedValue();
										break;
									case 'M':
										$tran['subtotal'] = $cell->getCalculatedValue();
										$tranItem['unit_price'] = $tran['subtotal'];
										$tranItem['sum'] = $tran['subtotal'];
										break;
									case 'N':
										$tran['tax'] = $cell->getCalculatedValue();
										break;
									case 'O':
										$tran['total'] = $cell->getCalculatedValue();
										break;
								}

							}
							
						}
						// var_dump($member);
						// var_dump($tran);
						
						$tranItem['description'] = 'Being Payment for : '.$tran['payment_type'].' : '.$tran['year'];
						// var_dump($tranItem);
						// Insert here

						// created and modified will be NOW() here since it is insert
						$this->loadModel('Member');
						$query = 'INSERT IGNORE members (type, `no`,`name`,company,valid,created,modified	)
									VALUES ("'.$member['type'].'","'.$member['no'].'","'.$member['name'].'","",1,NOW(),NOW())';
						$this->Member->query($query);	
						// $mId = $this->Member->query('select last_insert_id() as id;');
						// debug($this->Member->validationErrors);
						
						$this->loadModel('Transactions');						
						$query = 'INSERT INTO `transactions` (							
							`member_id`,
							`member_name`,
							`member_paytype`,
							`member_company`,
							`date`,
							`year`,
							`month`,
							`ref_no`,
							`receipt_no`,
							`payment_method`,
							`batch_no`,
							`cheque_no`,
							`payment_type`,
							`renewal_year`,
							`remarks`,
							`subtotal`,
							`tax`,
							`total`,
							`valid`,
							`created`,
							`modified`
						)
						VALUES
							(								
								(select id from members where name = "'.$member['name'].'"),
								"'.$member['name'].'",
								"'.$tran['member_paytype'].'",
								NULL,
								"'.$tran['date'].'",
								"'.$tran['year'].'",
								"'.$tran['month'].'",
								"'.$tran['ref_no'].'",
								"'.$tran['receipt_no'].'",
								"'.$tran['payment_method'].'",
								"'.$tran['batch_no'].'",
								NULL,
								"'.$tran['payment_type'].'",
								"'.$tran['renewal_year'].'",
								NULL,
								"'.$tran['subtotal'].'",
								"'.$tran['tax'].'",
								"'.$tran['total'].'",
								1,
								NOW(),
								NOW()
							);';

						$this->Transactions->query($query);	
						$tId = $this->Transactions->query('select last_insert_id() as id;',false);

						// var_dump($tId);
						// debug($this->Transactions->validationErrors);
						$this->loadModel('TransactionItems');
						$query = 'INSERT INTO `transaction_items` (
							`transaction_id`,
							`description`,
							`quantity`,
							`unit_price`,
							`uom`,
							`sum`,
							`valid`,
							`created`,
							`modified`,
							`table`,
							`table_id`
						)
						VALUES
							(
								'.$tId[0][0]['id'].',
								"'.$tranItem['description'].'",
								"1.00",
								"'.$tranItem['unit_price'].'",
								NULL,
								"'.$tranItem['sum'].'",
								"1",
								NOW(),
								NOW(),
								"Member",
								"1"
							);
						
						';
						$this->TransactionItems->query($query);	
					}
					
				}
			}
			$this->setFlash('Migration complete.');
			$this->set('title',__('Migration of data to multiple DB table'));
		}
		
	}