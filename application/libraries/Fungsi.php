<?php
class Fungsi
{
    function __construct()
    {
        $this->ci = &get_instance();
    }

    function pdfGenerator($html, $fileName, $paper, $orintation)
    {
        $dompdf = new Dompdf\Dompdf();
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper($paper, $orintation);

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream($fileName, array('Attachment' => 0));
    }

    function notifikasi()
    {
        $ci = &get_instance();
        $ci->db->where('stock <= "100"');
        return $ci->db->get('barang')->num_rows();
    }
}
