<?php
	class TransactionItems extends AppModel{
		public $useTable = 'transaction_items';
		public $belongsTo = array('Transactions');
	}