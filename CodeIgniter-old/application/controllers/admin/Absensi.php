<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('mAll');
	}
	public function index(){
        $result['data'] = $this->mAll->showDataAbsensi();
        $result['kategori'] = $this->mAll->showKategori();
        $result['ruang'] = $this->mAll->showRuangan();
		$this->load->view('admin/vAbsensi',$result);
    }
    public function addAbsensi(){
        $nama_Absensi = $this->input->post('nama_Absensi');
        $id_kategori = $this->input->post('id_kategori');
        $id_ruang = $this->input->post('id_ruang');
        $kuota_Absensi = $this->input->post('kuota_Absensi');
        $tanggal_Absensi = $this->input->post('tanggal_Absensi');
        $jam_mulai_Absensi = $this->input->post('jam_mulai_Absensi');
        $jam_berakhir_Absensi = $this->input->post('jam_berakhir_Absensi');
        
        $data = array (
            'nama_Absensi' => $nama_Absensi,
            'id_kategori' => $id_kategori,
            'id_ruang' => $id_ruang,
            'kuota_Absensi' => $kuota_Absensi,
            'tanggal_Absensi' => $tanggal_Absensi,
            'jam_mulai_Absensi' => $jam_mulai_Absensi,
            'jam_berakhir_Absensi' => $jam_berakhir_Absensi
            );
        $this->mAll->inputData($data, 'tbl_Absensi');
        redirect('admin/Absensi/index');
    }
    public function editAbsensi(){
        $result['data'] = $this->mAll->showDataAbsensi();
        $id= $this->input->post('id');
        $nama_Absensi = $this->input->post('nama_Absensi');
        $kuota_Absensi = $this->input->post('kuota_Absensi');
        $tanggal_Absensi = $this->input->post('tanggal_Absensi');
        $jam_mulai_Absensi = $this->input->post('jam_mulai_Absensi');
        $jam_berakhir_Absensi = $this->input->post('jam_berakhir_Absensi');
        $data = array (
            'nama_Absensi' => $nama_Absensi,
            'kuota_Absensi' => $kuota_Absensi,
            'tanggal_Absensi' => $tanggal_Absensi,
            'jam_mulai_Absensi' => $jam_mulai_Absensi,
            'jam_berakhir_Absensi' => $jam_berakhir_Absensi
        );
        $where = array(
            'id_Absensi' => $id
        );
        $this->mAll->updateData($where, $data, 'tbl_Absensi');
        redirect('admin/Absensi/index');
    }
    public function deleteAbsensi(){
        $id= $this->input->post('id');
        $this->mAll->deleteData($id);
        redirect('admin/Absensi/index');
    }
    public function generate_pdf() {
        //load pdf library
        $this->load->library('pdf');
        
        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Devi Ambar');
        $pdf->SetTitle('Report Absensi');
        $pdf->SetSubject('Report generated using Codeigniter and TCPDF');
        $pdf->SetKeywords('TCPDF, PDF, MySQL, Codeigniter');
    
        // set default header data
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
    
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    
        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    
        // set font
        $pdf->SetFont('times', 'BI', 12);
        
        // ---------------------------------------------------------
        
        
        //Generate HTML table data from MySQL - start
        $template = array(
            'table_open' => '<table border="1" cellpadding="2" cellspacing="1">'
        );
    
        $this->table->set_template($template);
    
        $this->table->set_heading('No', 'Nama Event', 'Nama Peserta', 'NRP', 'Jurusan', 'Kehadiran');
        
        $reportinfo = $this->mAbsensi->showData();
            
        foreach ($reportinfo as $sf):
            $this->table->add_row($sf->id_pendaftaran, $sf->nama_event, $sf->nama_siswa, $sf->nrp_siswa, $sf->nama_jurusan, $sf->ket_kehadiran);
        endforeach;
        
        $html = $this->table->generate();
        //Generate HTML table data from MySQL - end
        
        // add a page
        $pdf->AddPage();
        
        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');
        
        // reset pointer to the last page
        $pdf->lastPage();
    
        //Close and output PDF document
        $pdf->Output(md5(time()).'.pdf', 'D');
    }
}
?>