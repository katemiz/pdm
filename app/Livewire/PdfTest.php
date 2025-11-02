<?php

namespace App\Livewire;

use Livewire\Component;

use App\Livewire\EngMast;

use Barryvdh\DomPDF\Facade\Pdf;


class PdfTest extends Component
{



    public function render()
    {

        // $data = ['title' => 'Invoice', 'items' => [...]];

        $data = ['title' => 'Invoice'];

        
        // Generate from view
        $pdf = Pdf::loadView('product-brochure2');
        
        // Download
        return $pdf->download('invoice.pdf');
        
        // Or stream in browser
        // return $pdf->stream('invoice.pdf');
        
        // Or save to storage
        $pdf->save(storage_path(path: 'app/public/invoice.pdf'));
    }
















}
