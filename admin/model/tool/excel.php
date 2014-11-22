<?php
class ModelToolExcel extends Model {
	public function getActiveSheet( $file ) {
		$objPHPExcel = PHPExcel_IOFactory::load($file);

		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		
		return $sheetData;
	}

	public function createExcelFile( $aMatrix, $sFileLink, $sAutoFilter = null, $bIsDownload = false ){
		$objPHPExcel = new PHPExcel();
// var_dump($sAutoFilter);exit;
		// Set properties
		// $objPHPExcel->getProperties()->setCreator("Maarten Balliauw");
		// $objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");
		// $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
		// $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
		// $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

		ini_set("memory_limit", "384M"); // set in php.ini, I cannot change this
		set_time_limit(0);

		// Initiate cache
		$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
		$cacheSettings = array( 'memoryCacheSize' => '32MB');
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

		// Add data
		$objPHPExcel->setActiveSheetIndex(0);
		$activeSheet = $objPHPExcel->getActiveSheet();
		foreach ( $aMatrix as $sCol => $sValue ) {
			$aCols = explode('-', $sCol);
			if ( count($aCols) > 1 ){
				$concat =  $aCols[0] . ":" . $aCols[1];
    			$activeSheet->mergeCells($concat);
    			$sCol = $aCols[0];
			}
			$activeSheet->SetCellValue($sCol, $sValue);
			unset($aCols);
		}

		if ( $sAutoFilter != null ) {
			$activeSheet->setAutoFilter($sAutoFilter);
		}

		// Rename sheet
		// $objPHPExcel->getActiveSheet()->setTitle('Simple');

		// Save Excel 2007 file
		$objWriter = new PHPExcel_Writer_Excel2007( $objPHPExcel );
		$objWriter->save( $sFileLink );

		// Redirect output to a client’s web browser (Excel2007)
		if ( $bIsDownload ){
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="'.basename($sFileLink).'"');
			header('Cache-Control: max-age=0');
			readfile( $sFileLink );
		}
	}
}
?>