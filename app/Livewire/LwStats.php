<?php

namespace App\Livewire;

use Livewire\Component;

use Illuminate\Support\Collection;

use App\Models\User;
use App\Models\CNotice;
use App\Models\Document;
use App\Models\EProduct;
use App\Models\Item;



use Carbon\Carbon;



class LwStats extends Component
{


    public $no_of_users;
    public $no_of_ecns; 
    public $no_of_sellables;
    public $no_of_documents;
    public $no_of_items;  

    public $labels;
    public $data;






    public function render()
    {
        $this->getNoOfParameters(); 
        $this->graphData(); 

        return view('components.elements.lw-stats');
    }




    public function getNoOfParameters()
    {
        $this->no_of_users = User::where('status', 'active')->count();

        $this->no_of_ecns =[
            "wip" => CNotice::where('status', 'wip')->count(),
            "completed" => CNotice::where('status', 'completed')->count()
        ];

        $this->no_of_sellables = EProduct::where('is_latest', true)->count();
        $this->no_of_documents = Document::where('is_latest', true)->count();
        $this->no_of_items = Item::where('is_latest', true)->count();
    } 








    public function graphData()
    {
        $noOfPoints = 24; 
        $daysInterval = 30; 

        for ($i = 0; $i <=$noOfPoints ; $i++ ) {

            $date = Carbon::today()->subDays(($noOfPoints-$i)*$daysInterval)->toDateString();

            $this->labels[] = $date;
            
            $this->data['item'][] = Item::where('is_latest', true)->where('created_at', '<=',$date)->count();
            $this->data['sellable'][] = EProduct::where('is_latest', true)->where('created_at', '<=',$date)->count();
            $this->data['docs'][] = Document::where('is_latest', true)->where('created_at', '<=',$date)->count();
        } 
        
    }








        



}