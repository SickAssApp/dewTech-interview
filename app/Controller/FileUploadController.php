<?php

class FileUploadController extends AppController {
	public function index() {

		// data[FileUpload][file]	
		
		$this->set('title', __('File Upload Answer'));

		// $file_uploads = $this->FileUpload->find('all');
		// $this->set(compact('file_uploads'));
	}

	public function uploadFile() {
		$folder = WWW_ROOT.'files/uploaded'.DS;
		if (!$this->request->is('post')) return;

		if(!empty($this->request->data)){
			//Check if image has been uploaded
			if(!empty($this->request->data['FileUpload']['file'])){
					$file = $this->request->data['FileUpload']['file']; //put the data into a var for easy use
					// var_dump($this->request->data);

					$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
					$arr_ext = array('csv'); //set allowed extensions

					//only process if the extension is valid
					if(in_array($ext, $arr_ext)){

						//do the actual uploading of the file. First arg is the tmp name, second arg is 
						//where we are putting it
						$newFilename = $file['name']; // edit/add here as you like your new filename to be.
						$result = move_uploaded_file( $file['tmp_name'], $folder . $newFilename );

						// debug( $result );
						ini_set('auto_detect_line_endings',TRUE);
						$csvData = fopen($folder.$file['name'], "r");
						
						$row = 0;
						$fileRows = array();
						while (($column = fgetcsv($csvData, 10000, ",")) !== FALSE) {							
							if($row != 0 ){
								$fileRow = array(
									'FileUpload' => array(
										'id' 		=> $row,
										'name'		=> $column[0],
										'email'		=> $column[1],
										'created' 	=> date("Y-m-d H:i:s"),
									)
								);								
								array_push($fileRows,$fileRow);
							}							
							$row++;
						}

						ini_set('auto_detect_line_endings',FALSE);
						fclose($csvData);
						
						$this->set('file_uploads', $fileRows);
			
					}				
			}
		}

		$this -> render('/FileUpload/index');
	}
}