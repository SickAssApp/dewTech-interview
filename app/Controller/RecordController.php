<?php
	class RecordController extends AppController{
		
		public function index(){

			$this->setFlash('Listing Record page too slow, try to optimize it.');			
			$this->set('title',__('List Record'));

		}
		
		public function getList(){
			// ajax function
			$this->layout = null ;
			
			// Get params
			$start 		= $this->request->query('iDisplayStart');
			$defLimit 	= $this->request->query('iDisplayLength');
			$sEcho		= $this->request->query('sEcho');

			// Calculate current page.
			$page = ceil(($start - 1) / $defLimit) + 1;

			ini_set('memory_limit','256M');
			set_time_limit(0);					
						
			// $records = $this->Record->find('all');
			$this->paginate = array(			
				'fields' 	=> array('id', 'name'),
				'page'		=> $page,
				'limit' 	=> $defLimit,
				'order' 	=> array('id' => 'asc'),
			);			
			
			$total = $this->Record->find('count', array('fields' => 'id',));			

			$tmp = $this->paginate('Record');
			$records = array_column($tmp, 'Record');
			// var_dump($records);

			$res = array(
				'sEcho' 				=> $sEcho+1,
				'iTotalRecords'			=> $total,
				'iTotalDisplayRecords'	=> $total,
				'aaData'				=> $records,
			);

			$this->set('res', $res);
			$this->render('/Record/ajaxReturn'); 
		}
// 		public function update(){
// 			ini_set('memory_limit','256M');
			
// 			$records = array();
// 			for($i=1; $i<= 1000; $i++){
// 				$record = array(
// 					'Record'=>array(
// 						'name'=>"Record $i"
// 					)			
// 				);
				
// 				for($j=1;$j<=rand(4,8);$j++){
// 					@$record['RecordItem'][] = array(
// 						'name'=>"Record Item $j"		
// 					);
// 				}
				
// 				$this->Record->saveAssociated($record);
// 			}
			
			
			
// 		}
	}