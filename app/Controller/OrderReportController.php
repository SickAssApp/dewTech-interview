<?php
	class OrderReportController extends AppController{

		public function index(){

			$this->setFlash('Multidimensional Array.');

			// $this->loadModel('Order');
			// $orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));
			// // debug($orders);exit;

			// $this->loadModel('Portion');
			// $portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));
			// // debug($portions);exit;

		// Tab item
			$this->loadModel('Order');
			$query = "select order_id, item_id, quantity, order_name, value_sum*quantity as value_sum, ingredient_name
						from
						(
						SELECT	
							od.order_id as order_id,	
							od.item_id as item_id,
							od.quantity as quantity,
							o.name as order_name,	
						sum(pd.value) as value_sum,
							pt.name as ingredient_name 
						FROM
							order_details od
						join orders o on od.order_id = o.id
						join items i on od.item_id = i.id
						join portions p on p.item_id = i.id
						join portion_details pd on p.id = pd.portion_id
						join parts pt on pt.id = pd.part_id
						group by pd.part_id,od.order_id
						) tb1
					order by order_id,item_id asc";			
			$res = $this->Order->query($query);
			// var_dump($res);

			$order_reports = array();
			$orders = array();
			foreach($res as $key => $val){
				$order_reports[$val['tb1']['order_name']] = array();
				$orders[$val['tb1']['order_id']] = $val['tb1']['order_name'];
			}
			foreach($res as $key => $val){
				$order_reports[$val['tb1']['order_name']][$val['tb1']['ingredient_name']] = $val[0]['value_sum'];
			}
			
			$this->loadModel('Portion');
			$query = "select * from(
						SELECT	
							i.id as item_id,
							i.name as item_name,
							pt.id as parts_id,
							pt.name as parts_name,
							pd.value as value,
							p.id as portion_id
						FROM portion_details pd
						join portions p on p.id = pd.portion_id
						join items i on i.id = p.item_id
						join parts pt on pt.id = pd.part_id
					) tb1";			
			$res = $this->Portion->query($query);
			
			$portions = array();
			foreach($res as $key => $val){
				$portions[$val['tb1']['item_id']] = [$val['tb1']['item_name'],$val['tb1']['portion_id']];
			}
			// var_dump($portions);

			$this->set('order_reports',$order_reports);
			$this->set('orders',$orders);
			$this->set('portions',$portions);

			$this->set('title',__('Orders Report'));
		}

		public function Question(){

			$this->setFlash('Multidimensional Array.');

			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));

			// debug($orders);exit;

			$this->set('orders',$orders);

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));
				
			// debug($portions);exit;

			$this->set('portions',$portions);

			$this->set('title',__('Question - Orders Report'));
		}

	}