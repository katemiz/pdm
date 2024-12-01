<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Material;
use App\Models\Company;
use App\Models\Counter;



class MaterialForm extends Form
{
    public ?Material $material;

    // MATERAL DEFINITON AND SPECIFICATION
    #[Validate('required', message: 'Please add material definition')]
    #[Validate('min:4', message: 'Material definition is too short. At least 4 characters')]
    public String $description = '';

    #[Validate('required', message: 'Please add material specification.')]
    #[Validate('min:4', message: 'Material specification is too short. At least 4 characters')]
    public String $specification = '';

    // RECORD ID
    public $uid;

    #[Validate('required', message: 'Please select material family')]
    public String $family;

    public String $form = '100';


    #[Validate('required', message: 'Please select status')]
    public String $status = 'Active';

    public $remarks;


    // FILES
    public $files = [];







    public function setMaterial(Int $id)
    {
        $this->uid = $id;
        $this->material = Material::find($id);
        $this->description = $this->material->description;
        $this->specification = $this->material->specification;
        $this->form = $this->material->form;
        $this->family = $this->material->family;
        $this->status = $this->material->status;
        $this->remarks = $this->material->remarks;
    }




    public function store()
    {
        $this->validate();

        $props['user_id'] = Auth::id();
        $props['updated_uid'] = Auth::id();

        $props['description'] = $this->description;
        $props['specification'] = $this->specification;
        $props['form'] = $this->form;
        $props['family'] = $this->family;
        $props['status'] = $this->status;
        $props['remarks'] = $this->synopsis;

        $id = Material::create($props)->id;

        session()->flash('msg',[
            'type' => 'success',
            'text' => 'Material has been created successfully.'
        ]);

        return $id;
    }


    public function update($id)
    {
        $this->validate();

        $props['updated_uid'] = Auth::id();
        $props['doc_type'] = $this->doc_type;
        $props['language'] = $this->language;
        $props['company_id'] = $this->company_id;
        $props['title'] = $this->title;
        $props['remarks'] = $this->synopsis;

        $props['toc'] = json_encode([]);

        $document = Document::findOrFail($id);

        $document->update($props);

        session()->flash('msg',[
            'type' => 'success',
            'text' => 'Document has been updated successfully.'
        ]);

        return true;
    }



    public function getDocumentNo() {

        $parameter = 'document_no';
        $initial_no = config('appconstants.counters.document_no');
        $counter = Counter::find($parameter);

        if ($counter == null) {
            Counter::create([
                'counter_type' => $parameter,
                'counter_value' => $initial_no
            ]);

            return $initial_no;
        }

        $new_no = $counter->counter_value + 1;
        $counter->update(['counter_value' => $new_no]);         // Update Counter
        return $new_no;
    }















}








