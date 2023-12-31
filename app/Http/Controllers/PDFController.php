<?php

namespace App\Http\Controllers;

use App\Models\Item;

use Illuminate\Http\Request;
use PDF; // If you created the alias

class MYPDF extends \TCPDF {

    //Page header
    public function Header() {
        // Logo
        //$image_file = '/images/logo.svg';
        //$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // $this->ImageSVG($file='/images/logo.svg', $x=15, $y=30, $w='', $h='', $link='https://masttech.net', $align='', $palign='', $border=0, $fitonpage=false);

        $this->SetY(10);



        $this->SetFillColor(45, 245, 220); // Set a light yellow background
        $this->Rect(0, 0, $this->getPageWidth(), $this->getPageHeight(), 'DF');

        //$this->SetFillColor(45, 245, 20); // Set a light yellow background

        //$this->Rect(0, 0, $this->getPageWidth(), 60, 'DF');


        //$this->Image('/images/mtlogo.png', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

        $this->SetFillColor(45, 145, 220); // Set a light yellow background


        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0, 15, 'BILL OF MATERIALS', 0, false, 'C', 0, '', 1, false, 'M', 'M');

        $this->ImageSVG($file='/images/icon_manual.svg', $x=12, $y=12, $w='20', $h='20', $link='http://rrrrrrr.tcpdf.org', $align='', $palign='', $border=1, $fitonpage=false);

        $this->SetXY(35,17);

        $this->Cell(0, 0, 'BILL OF MATERIALS', 1, false, 'C', 1, '', 0, false, 'M', 'M');


    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}



class PDFController extends Controller
{

    public function generatePdf()
    {

        $item = Item::find(request('id'));



        // Create a new TCPDF instance
        $pdf = new MYPDF();

        // Set document information
        $pdf->SetCreator('Your Name');
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Sample PDF');






        // Add a page
        $pdf->AddPage();



        $pdf->SetY(70);


        $pdf->SetFillColor(45, 145, 120); // Set a light yellow background
        $pdf->Cell(0, 0, 'BILL OF MATERIALS', 0, false, 'C', 1, '', 0, false, 'M', 'M');










        // Set font
        $pdf->SetFont('times', 'B', 12);

        // Add content to the PDF
        //$pdf->Cell(0, 10, 'Hello, this is a sample PDF generated using TCPDF in Laravel.', 0, 1, 'C');

        //$pdf->ImageSVG($file='/images/hero.svg', $x=15, $y=90, $w='40', $h='50', $link='http://www.tcpdf.org', $align='', $palign='', $border=0, $fitonpage=false);

        // $html = <<<HTML
        // <div class="column">
        //     <label class="label">Material</label>
        //     Aluminum | Sheet/Plate | rtrytrytry | tyutyu
        // </div>
        // HTML;

        // $pdf->writeHTML($html, true, false, true, false, '');


        $pdf->SetXY(12,80);

        $pdf->ImageSVG($file='/images/baykus_orange.svg', $x=12, $y=80, $w='30', $h='30', $link='http://rrrrrrr.tcpdf.org', $align='', $palign='', $border=1, $fitonpage=false);

        $pdf->SetXY(45,80);

        $pdf->SetFont('helvetica', 'B', 36);
        $pdf->Cell(42, 16, $item->part_number, 1, $ln=0, 'L', 0, '', 0, false, 'T', 'T');

        $pdf->Cell(20, 0, '-'.$item->version, 1, $ln=0, 'L', 0, '', 0, false, 'T', 'T');

        $pdf->SetXY(45,98);
        $pdf->SetFont('times', '', 28);
        $pdf->Cell(0, 12, $item->description, 1, $ln=0, 'L', 0, '', 0, false, 'T', 'B');


        $pdf->SetFont('times', 'B', 12);


        $pdf->SetX(100);

        // set filling color
//$pdf->SetTextColor(255,255,128);


        $pdf->Ln();


        //$pdf->SetX(20);

        $pdf->Ln();

        $pdf->SetY(100);



        $pdf->SetY(140);




        $tbl = <<<EOD
        <table border="1" cellpadding="0" cellspacing="0" align="center">
         <tr nobr="true">
          <th colspan="2">NON-BREAKING ROWS</th>
         </tr>
         <tr nobr="true">
          <td>ROW 1<br />COLUMN 1</td>
          <td>ROW 1<br />COLUMN 2</td>
         </tr>
         <tr nobr="true">
          <td>ROW 2<br />COLUMN 1</td>
          <td>ROW 2<br />COLUMN 2</td>
         </tr>
         <tr nobr="true">
          <td>ROW 3<br />COLUMN 1</td>
          <td>ROW 3<br />COLUMN 2</td>
         </tr>
        </table>
        EOD;







        if ($item->bom) {

            $bom = '
            <table border="1" cellpadding="3" cellspacing="0" align="left" >

            


                <thead>
                <tr>
                    <th style="width:15%">Part Number</th>
                    <th style="width:10%">Type</th>
                    <th style="width:65%">Description</th>
                    <th style="width:10%">Quantity</th>
                </tr>
                </thead>';

                foreach (json_decode($item->bom) as $i) {
                    $bom .= '
                    <tr>
                        <td style="width:15%">'.$i->name.'-'.$i->version.'</td>
                        <td style="width:10%">'.$i->part_type.'</td>
                        <td style="width:65%">'.$i->description.'</td>
                        <td style="width:10%">'.$i->qty.'</td>
                    </tr>';
                }

            $bom .= '
            </tbody>
            </table>';
        };
















        $pdf->writeHTML($tbl, true, false, false, false, '');

        
        $pdf->writeHTML($bom, true, false, false, false, '');


        // Output the PDF to the browser or save it to a file
        $pdf->Output('sample.pdf', 'I'); // 'I' means inline, you can change it to 'D' to force download
    }


}


