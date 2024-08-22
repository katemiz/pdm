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



class PdmStats extends Component
{


    public $no_of_users;
    public $no_of_ecns; 
    public $no_of_sellables;
    public $no_of_documents;
    public $no_of_items;  

    public $labels;
    public $data;


    public $stat_data;


    public function render()
    {
        $this->getNoOfParameters(); 
        $this->graphData(); 

        $this->stat_data = [

            [
                "title" => "Active Users",
                "data" => $this->no_of_users,
                "img" => "stats_users.svg",
                "content" => "Number of Active PDM App Users",
            ],


            [
                "title" => "Number of ECNs",
                "data" => $this->no_of_ecns["wip"] .'/'.$this->no_of_ecns["completed"],
                "img" => "stats_ecns.svg",
                "content" => "Number of Engineering Change Notices (ECN). Work in Progress and Completed ECNs.",
            ],

            [
                "title" => "Sellable Items 7 Customer Drawings",
                "data" => $this->no_of_sellables,
                "img" => "stats_sellables.svg",
                "content" => "Number of Sellable Products",
            ],

            [
                "title" => "Number of Documents",
                "data" => $this->no_of_documents,
                "img" => "stats_documents.svg",
                "content" => "Number of documents created in PDM System",
            ],


            [
                "title" => "Number of Components",
                "data" => $this->no_of_items,
                "img" => "stats_products.svg",
                "content" => "Number of Components/Parts Created in PDM System",
            ],
        ];

        return view('livewire.stats');
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
        for ($i = 0; $i <= 8; $i++ ) {

            $date = Carbon::today()->subDays((8-$i)*7)->toDateString();

            $this->labels[] = $date;
            
            $this->data['item'][] = Item::where('is_latest', true)->where('created_at', '<=',$date)->count();
            $this->data['sellable'][] = EProduct::where('is_latest', true)->where('created_at', '<=',$date)->count();
            $this->data['docs'][] = Document::where('is_latest', true)->where('created_at', '<=',$date)->count();
        } 
        
    }








        



}











