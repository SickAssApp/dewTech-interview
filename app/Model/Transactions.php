<?php
	class Transactions extends AppModel{
		public $useTable = 'transactions';
		public $hasMany = array('TransactionItems');
	}