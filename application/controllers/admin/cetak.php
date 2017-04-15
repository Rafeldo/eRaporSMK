<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Cetak extends Backend_Controller {
	var $B;
	var $I;
	var $U;
	var $HREF; 
	public function __construct(){
		parent::__construct();
		//$this->load->library('fpdf_gen');
	}
	public function rapor_word($kur,$ajaran_id,$rombel_id,$siswa_id){
		$this->load->library('phpword');
		$phpWord = new \PhpOffice\PhpWord\PhpWord();
		$phpWord->getCompatibility()->setOoxmlVersion(14);
		$phpWord->getCompatibility()->setOoxmlVersion(15);
		$phpWord->setDefaultFontName('Times New Roman');
		$phpWord->setDefaultFontSize(12);
		$targetFile = "./files/words/";
		$sekolah = Datasekolah::first();
		$setting = Setting::first();
		$siswa = Datasiswa::find($siswa_id);
		$filename = strtolower(str_replace(' ','_',$siswa->nama)).".docx";
		$section = $phpWord->addSection();
		$format_header = array('bold' => true,'name'=> 'times new roman','size' => 14);
		$center = array('align' => 'center', 'spaceAfter'=>0);
		$section->addText('RAPOR SISWA', $format_header, $center);
		$section->addText('SEKOLAH MENENGAH KEJURUAN', $format_header, $center);
		$section->addText('(SMK)', $format_header, $center);
		$section->addTextBreak(4);
		$section->addImage('assets/img/logo.png', array('width'=>250, 'height'=>250, 'align'=>'center'));
		$section->addTextBreak(4);
		$section->addText('Nama Siswa', 
			array("size" => 12),
			array('align' => 'center')
		);
		$section->addText($siswa->nama, 
			array("size" => 21),
			array('align' => 'center', "borderSize"=>6, "borderColor"=>"000000")
		);
		$section->addTextBreak(1);
		$section->addText('NISN', 
			array("size" => 12),
			array('align' => 'center')
		);
		$section->addText($siswa->nisn, 
			array("size" => 21),
			array('align' => 'center', "borderSize"=>6, "borderColor"=>"000000")
		);
		$section->addTextBreak(1);
		$section->addText('KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN', $format_header, $center);
		$section->addText('REPUBLIK INDONESIA', $format_header, $center);
		//$source = 'http://php.net/images/logos/php-med-trans-light.gif';
		//$section->addText("Remote image from: {$source}");
		//$section->addMemoryImage($source);
		$section->addPageBreak();
		$styleCell = array('valign'=>'center');
		$fontStyle = array('bold'=>false, 'align'=>'left');
		$table = $section->addTable();
		$table->addRow(900);
		$table->addCell(4000, $styleCell)->addText('Nama Sekolah', $fontStyle);
		$table->addCell(12000, $styleCell)->addText(': '.$sekolah->nama, $fontStyle);
		$table->addRow();
		$table->addCell(4000, $styleCell)->addText('NPSN / NSS', $fontStyle);
		$table->addCell(12000, $styleCell)->addText(': '.$sekolah->npsn.' / '.$sekolah->nss, $fontStyle);
		$table->addRow();
		$table->addCell(4000, $styleCell)->addText('Alamat', $fontStyle);
		$table->addCell(12000, $styleCell)->addText(': '.$sekolah->alamat, $fontStyle);
		$table->addRow();
		$table->addCell(4000, $styleCell)->addText('', $fontStyle);
		$table->addCell(12000, $styleCell)->addText('  Kodepos : '.$sekolah->kode_pos.' Telp : '.$sekolah->no_telp, $fontStyle);
		$table->addRow();
		$table->addCell(4000, $styleCell)->addText('Desa/Kelurahan', $fontStyle);
		$table->addCell(12000, $styleCell)->addText(': '.$sekolah->desa_kelurahan, $fontStyle);
		$table->addRow();
		$table->addCell(4000, $styleCell)->addText('Kecamatan', $fontStyle);
		$table->addCell(12000, $styleCell)->addText(': '.$sekolah->kecamatan, $fontStyle);
		$table->addRow();
		$table->addCell(4000, $styleCell)->addText('Kabupaten/Kota', $fontStyle);
		$table->addCell(12000, $styleCell)->addText(': '.$sekolah->kabupaten, $fontStyle);
		$table->addRow();
		$table->addCell(4000, $styleCell)->addText('Provinsi', $fontStyle);
		$table->addCell(12000, $styleCell)->addText(': '.$sekolah->provinsi, $fontStyle);
		$table->addRow();
		$table->addCell(4000, $styleCell)->addText('Website', $fontStyle);
		$table->addCell(12000, $styleCell)->addText(': '.$sekolah->website, $fontStyle);
		$table->addRow();
		$table->addCell(4000, $styleCell)->addText('Email', $fontStyle);
		$table->addCell(12000, $styleCell)->addText(': '.$sekolah->email, $fontStyle);
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
		$objWriter->save($filename);
		// send results to browser to download
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.$filename);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($filename));
		flush();
		readfile($filename);
		unlink($filename); // deletes the temporary file
		exit;
	}
	public function rapor_pdf($kur,$ajaran_id,$rombel_id,$siswa_id){
        $this->load->library('m_pdf');
		$data['ajaran_id'] = $ajaran_id;
		$data['rombel_id'] = $rombel_id;
		$data['siswa_id'] = $siswa_id;
		$data['kurikulum_id'] = $kur;
		$siswa = Datasiswa::find($siswa_id);
		$rombel = Datarombel::find($rombel_id);
        $pdfFilePath = strtolower(str_replace(' ','_',$siswa->nama)).".pdf";
		$wm = base_url() . 'assets/img/logo.png';
		$this->m_pdf->pdf->SetWatermarkImage($wm);
		$this->m_pdf->pdf->showWatermarkImage = false;
		$this->m_pdf->pdf->SetHTMLFooter('<b style="font-size:8px;"><i>'.$siswa->nama.' - '.$rombel->nama.'<i></b>');
		$rapor_header=$this->load->view('backend/cetak/rapor_header', $data, true);
        $this->m_pdf->pdf->WriteHTML($rapor_header);
		$rapor_cover=$this->load->view('backend/cetak/rapor_cover', $data, true);
        $this->m_pdf->pdf->WriteHTML($rapor_cover);
		$this->m_pdf->pdf->AddPage('P');
		$rapor_identitas_sekolah=$this->load->view('backend/cetak/rapor_identitas_sekolah', $data, true);
        $this->m_pdf->pdf->WriteHTML($rapor_identitas_sekolah);
		$this->m_pdf->pdf->AddPage('P');
		$rapor_identitas_siswa=$this->load->view('backend/cetak/rapor_identitas_siswa', $data, true);
        $this->m_pdf->pdf->WriteHTML($rapor_identitas_siswa);
		$this->m_pdf->pdf->AddPage('L'); // Adds a new page in Landscape orientation
 		$rapor_sikap=$this->load->view('backend/cetak/rapor_sikap', $data, true);
		$this->m_pdf->pdf->WriteHTML($rapor_sikap);
		$this->m_pdf->pdf->AddPage('L'); // Adds a new page in Landscape orientation
 		$rapor_nilai=$this->load->view('backend/cetak/rapor_nilai', $data, true);
		$this->m_pdf->pdf->WriteHTML($rapor_nilai);
		$rapor_prakerin=$this->load->view('backend/cetak/rapor_prakerin', $data, true);
		$this->m_pdf->pdf->WriteHTML($rapor_prakerin);
		$rapor_ekskul=$this->load->view('backend/cetak/rapor_ekskul', $data, true);
		$this->m_pdf->pdf->WriteHTML($rapor_ekskul);
		$rapor_prestasi=$this->load->view('backend/cetak/rapor_prestasi', $data, true);
		$this->m_pdf->pdf->WriteHTML($rapor_prestasi);
		$rapor_absen=$this->load->view('backend/cetak/rapor_absen', $data, true);
		$this->m_pdf->pdf->WriteHTML($rapor_absen);
		$rapor_catatan_wali_kelas=$this->load->view('backend/cetak/rapor_catatan_wali_kelas', $data, true);
		$this->m_pdf->pdf->WriteHTML($rapor_catatan_wali_kelas);
		$rapor_footer=$this->load->view('backend/cetak/rapor_footer', $data, true);
		$this->m_pdf->pdf->WriteHTML($rapor_footer);
        //download it.
		//Output($file,'I') browser
		//Output($file,'F') simpan di server
		//Output($file,'S') Kirim ke email
		//Output($file,'D') Download
		$this->m_pdf->pdf->Output($pdfFilePath,'I');   
	}
	public function rapor_debug($kur,$ajaran_id,$rombel_id,$siswa_id){
		$data['ajaran_id'] = $ajaran_id;
		$data['rombel_id'] = $rombel_id;
		$data['siswa_id'] = $siswa_id;
		$data['kurikulum_id'] = $kur;
 		$this->load->view('backend/cetak/rapor_header', $data);
        $this->load->view('backend/cetak/rapor_identitas', $data);
        $this->load->view('backend/cetak/rapor_sikap', $data);
		$this->load->view('backend/cetak/rapor_nilai', $data);
		$this->load->view('backend/cetak/rapor_prakerin', $data);
		$this->load->view('backend/cetak/rapor_ekskul', $data);
		$this->load->view('backend/cetak/rapor_prestasi', $data);
		$this->load->view('backend/cetak/rapor_absen', $data);
		$this->load->view('backend/cetak/rapor_catatan_wali_kelas', $data);
		$this->load->view('backend/cetak/rapor_footer', $data);
	}
	public function legger($ajaran_id,$rombel_id,$kompetensi_id){
		$sekolah = Datasekolah::first();
		$ajaran = get_ta();
		$nama_rombel = Datarombel::find($rombel_id);
		$get_wali = Dataguru::find($nama_rombel->guru_id);
		$data_siswa = Datasiswa::find_all_by_data_rombel_id($rombel_id);
		$data_mapel = Kurikulum::find_all_by_ajaran_id_and_rombel_id($ajaran_id,$rombel_id);
		//echo $nama_rombel->nama;
		//echo $get_wali->nama;
		//die();
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
        //name the worksheet
		$nama_kompetensi = 'PENGETAHUAN';
		if($kompetensi_id == 2){
			$nama_kompetensi = 'KETERAMPILAN';
		}
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A7')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B7')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('C7')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A8')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode('0000000000');
		$objPHPExcel->getActiveSheet()->mergeCells('A8:C8');
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'LEGGER '.$nama_kompetensi);
		$objPHPExcel->getActiveSheet()->setCellValue('A2', strtoupper($sekolah->nama));
		$objPHPExcel->getActiveSheet()->setCellValue('A3', 'TAHUN PELAJARAN '.strtoupper($ajaran->tahun));
		$objPHPExcel->getActiveSheet()->setCellValue('C4', 'KELAS');
		$objPHPExcel->getActiveSheet()->setCellValue('C5', 'WALI KELAS');
		$objPHPExcel->getActiveSheet()->setCellValue('D4', $nama_rombel->nama);
		$objPHPExcel->getActiveSheet()->setCellValue('D5', $get_wali->nama);
		$objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('A8', 'KKM');
		$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('A7', 'NO.');
		$objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('B7', 'NISN');
		$objPHPExcel->getActiveSheet()->getStyle('B7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('C7', 'NAMA SISWA');
        $objPHPExcel->getActiveSheet()->setTitle('LEGGER');
		$row = 9;
		$row_mapel = 7;
		$row_kkm = 8;
		$merger_mapel = 4;
		$merger_wali = 5;
		$x= 'D';
		$plus1 = 'E';
		$plus2 = 'F';
		for($i=0;$i<count($data_mapel);$i++){
			$huruf[] = $x;
			$last = $x;
			$plus_1 = $plus1;
			$plus_2 = $plus2;
			$x++;
			$plus1++;
			$plus2++;
		}
		//echo $plus_1.'<br />';
		//echo $plus_2.'<br />';
		//die();
		$i=1;
		foreach($data_siswa as $siswa){
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $i);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $siswa->nisn);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $siswa->nama);
			foreach($data_mapel as $key=>$mapel){
				$all_nilai = Nilaiakhir::find_all_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,$kompetensi_id,$rombel_id,$mapel->id_mapel,$siswa->id);
				if($all_nilai){
					$nilai_value = 0;
					foreach($all_nilai as $allnilai){
						$nilai_value += $allnilai->nilai;
					}
					$jumlah_nilai = number_format($nilai_value,2);
				} else {
					$jumlah_nilai = 0;
				}
				$objPHPExcel->getActiveSheet()->getStyle($huruf[$key].$row_mapel)->getAlignment()->setTextRotation(90);
				$objPHPExcel->getActiveSheet()->getColumnDimension($huruf[$key])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($huruf[$key].$row_mapel)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue($huruf[$key].$row_mapel, get_nama_mapel($ajaran_id,$rombel_id,$mapel->id_mapel));
				$objPHPExcel->getActiveSheet()->setCellValue($huruf[$key].$row_kkm, get_kkm($ajaran_id,$rombel_id,$mapel->id_mapel));
				$objPHPExcel->getActiveSheet()->setCellValue($huruf[$key].$row, number_format($jumlah_nilai,0));
				$objPHPExcel->getActiveSheet()->setCellValue($plus_1.$row, '=SUM(D'.$row.':'.$huruf[$key].$row.')');
				$objPHPExcel->getActiveSheet()->setCellValue($plus_2.$row, '=AVERAGE(D'.$row.':'.$huruf[$key].$row.')');
				$objPHPExcel->getActiveSheet()->getStyle($plus_1.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
				$objPHPExcel->getActiveSheet()->getStyle($plus_2.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
			}
			$i++;
			$row++;
		}
		$objPHPExcel->getActiveSheet()->mergeCells('A1:'.$plus_2.'1');
		$objPHPExcel->getActiveSheet()->mergeCells('A2:'.$plus_2.'2');
		$objPHPExcel->getActiveSheet()->mergeCells('A3:'.$plus_2.'3');
		$objPHPExcel->getActiveSheet()->mergeCells('D4:'.$plus_2.'4');
		$objPHPExcel->getActiveSheet()->mergeCells('D5:'.$plus_2.'5');
		$objPHPExcel->getActiveSheet()->getColumnDimension($plus_1)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension($plus_2)->setAutoSize(true);
		//$objPHPExcel->getActiveSheet()->getRowDimension(7)->setRowHeight(100);
		$objPHPExcel->getActiveSheet()->getStyle($plus_1.$row_mapel)->getAlignment()->setTextRotation(90);
		$objPHPExcel->getActiveSheet()->getStyle($plus_2.$row_mapel)->getAlignment()->setTextRotation(90);
		$objPHPExcel->getActiveSheet()->setCellValue($plus_1.$row_mapel, 'JUMLAH');
		$objPHPExcel->getActiveSheet()->setCellValue($plus_2.$row_mapel, 'RATA-RATA');
		$styleArray = array(
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
								'color' => array('argb' => '00000000'),
							),
						),
					);
		$objPHPExcel->getActiveSheet()->getStyle('A7:'.$plus_2.($row - 1))->applyFromArray($styleArray);
        $filename='LEGGER '.$nama_kompetensi.'_'.str_replace(' ','_',$nama_rombel->nama).'.xlsx'; //save our workbook as this file name
 
        header('Content-Type: application/vnd.ms-excel'); //mime type
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
 
        header('Cache-Control: max-age=0'); //no cache
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); 
 
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
	}
}