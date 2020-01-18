<?php
Class Laporanpdf extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->library('pdf');
        $this->load->model('mAll');
    }
    
    function index(){
        ob_start();
        $pdf = new FPDF('l','mm','A4');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',16);
        // mencetak string 
        $pdf->Cell(290,7,'STIKI MALANG',0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(290,7,'PRESENSI WORKSHOP',0,1,'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,7,'',0,1);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(20,6,'NRP',1,0);
        $pdf->Cell(85,6,'NAMA MAHASISWA',1,0);
        $pdf->Cell(100,6,'NAMA EVENT',1,0);
        $pdf->Cell(30,6,'KETERANGAN',1,1);
        $pdf->SetFont('Arial','',10);
        $mahasiswa = $this->mAll->showDataAbsensi();
        foreach ($mahasiswa as $row){
            $pdf->Cell(20,6,$row->nrp_siswa,1,0);
            $pdf->Cell(85,6,$row->nama_siswa,1,0);
            $pdf->Cell(100,6,$row->nama_event,1,0);
            $pdf->Cell(30,6,$row->ket_kehadiran,1,1); 
        }
        $pdf->Output();
        ob_end_flush(); 
    }
}