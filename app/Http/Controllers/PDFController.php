<?php

namespace App\Http\Controllers;

use App\Models\Item;

use Illuminate\Http\Request;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF; // If you created the alias

class MYPDF extends \TCPDF {

    //Page header
    public function Header() {
        // Logo
        //$image_file = '/images/logo.svg';
        //$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // $this->ImageSVG($file='/images/logo.svg', $x=15, $y=30, $w='', $h='', $link='https://masttech.net', $align='', $palign='', $border=0, $fitonpage=false);

        $this->SetY(10);



        //$this->SetFillColor(45, 245, 220); // Set a light yellow background
        //$this->Rect(0, 0, $this->getPageWidth(), $this->getPageHeight(), 'DF');

        //$this->SetFillColor(45, 245, 20); // Set a light yellow background

        //$this->Rect(0, 0, $this->getPageWidth(), 60, 'DF');


        //$this->Image('/images/mtlogo.png', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

        $this->SetFillColor(45, 145, 220); // Set a light yellow background


        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        //$this->Cell(0, 15, 'BILL OF MATERIALS', 0, false, 'C', 0, '', 1, false, 'M', 'M');

        $this->ImageSVG($file='/images/mtlogo.svg', $x=10, $y=10, $w='', $h='10', $link='http://rrrrrrr.tcpdf.org', $align='', $palign='', $border=0, $fitonpage=false);


        $this->ImageSVG($file='/images/pdm_logo.svg', $x=185, $y=10, $w='15', $h='', $link='http://rrrrrrr.tcpdf.org', $align='', $palign='', $border=0, $fitonpage=false);


        // $this->ImageSVG($file='/images/icon_manual.svg', $x=12, $y=12, $w='20', $h='20', $link='http://rrrrrrr.tcpdf.org', $align='', $palign='', $border=1, $fitonpage=false);

        $this->SetXY(35,17);

        // $this->Cell(0, 0, 'BILL OF MATERIALS', 1, false, 'C', 1, '', 0, false, 'M', 'M');


    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        //$this->SetY(-15);

        $this->ImageSVG($file="/images/baykus_orange.svg", $x=8, $y=285, $w='6', $h='6', $link='https://kapkara.one', $align='', $palign='', $border=0, $fitonpage=false);

        $this->SetXY(14,290);
        $this->SetFont('helvetica', '', 6);

        $this->Cell(30, 0, 'kapkara.one', 0, false, 'L', 0, '', 0, false, 'M', 'M');

        $this->SetXY(170,290);
        $this->Cell(30, 0, 'masttech.net', 0, false, 'R', 0, '', 0, false, 'M', 'M');
        $this->SetXY(170,287);

        $this->Cell(30, 0, 'PDM Product Data Management', 0, false, 'R', 0, '', 0, false, 'M', 'M');

        $this->SetXY(100,285);

        // Set font
        $this->SetFont('dejavusans', '', 8);
        // Page number
        //$this->Cell(10, 10, $this->getAliasNumPage().'/'.$this->getAliasNbPages(), 1, false, 'R', 0, '', 0, false, 'T', 'M');

    }
}



class PDFController extends Controller
{

    public function generatePdf()
    {

        $item = Item::find(request('id'));

        switch ($item->part_type) {
            case 'Detail':
                $url = url('/').'/details/view/'.$item->id;
                break;

            case 'Assy':
                $url = url('/').'/products-assy/view/'.$item->id;
                break;
                    
            case 'Buyable':
                $url = url('/').'/buyables/view/'.$item->id;
                break;
            
        }





        // Create a new TCPDF instance
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'utf-8', false);

        // Set document information
        $pdf->SetCreator('Your Name');
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Sample PDF');






        // Add a page
        $pdf->AddPage();



        $pdf->SetY(50);
        $pdf->SetFont('dejavusans', '', 16);


        //$pdf->SetFillColor(45, 145, 120); // Set a light yellow background
        $pdf->Cell(0, 0, 'ÜRÜN VERİSİ / BILL OF MATERIALS', 0, false, 'C', 0, '', 0, false, 'M', 'M');







        $pdf->SetXY(PDF_MARGIN_LEFT,60);

        $qr = QrCode::generate($url);



        $pdf->ImageSVG($file="@$qr", $x=10, $y=60, $w='20', $h='20', $link='http://rrrrrrr.tcpdf.org', $align='', $palign='', $border=0, $fitonpage=false);

        $pdf->SetXY(32,60);

        $pdf->SetFont('dejavusans', 'B', 24);
        $pdf->Cell(0, 10, $item->part_number.'-'.$item->version, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'T');


        $pdf->SetXY(32,70);
        $pdf->SetFont('dejavusans', '', 12);
        //$pdf->Cell(0, 8, $item->description, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'B');

        $pdf->MultiCell(0, 8, $item->description, 0, 'L', 0, 0, '', '', true);


        $pdf->SetFont('dejavusans', '', 12);



        // set filling color
        //$pdf->SetTextColor(255,255,128);


        $pdf->Ln();
        $pdf->SetY(90);



        //$pdf->SetX(20);

        // $pdf->Ln();

        // $pdf->SetY(100);



        // $pdf->SetY(140);











        if ($item->bom) {

            $pdf->SetFont('dejavusans', '', 10);


            $bom = '
            <table border="1" cellpadding="3" cellspacing="0" align="left" border-collapse="collapse" border=="1px solid gray">

            


                <thead>
                <tr>
                    <th style="width:15%">Part Number</th>
                    <th style="width:10%">Type</th>
                    <th style="width:60%">Description</th>
                    <th style="width:15%;text-align:right;">Miktar<br>Quantity</th>
                </tr>
                </thead>';

                foreach (json_decode($item->bom) as $i) {
                    $bom .= '
                    <tr>
                        <td style="width:15%">'.$i->name.'-'.$i->version.'</td>
                        <td style="width:10%">'.$i->part_type.'</td>
                        <td style="width:60%">'.$i->description.'</td>
                        <td style="width:15%;text-align:right;">'.$i->qty.'</td>
                    </tr>';
                }

            $bom .= '
            </tbody>
            </table>';

            $pdf->writeHTML($bom, true, false, false, false, '');

        };

















        


        // Output the PDF to the browser or save it to a file
        $pdf->Output('sample.pdf', 'I'); // 'I' means inline, you can change it to 'D' to force download
    }


}


