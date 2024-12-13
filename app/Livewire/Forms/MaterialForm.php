<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Material;
use App\Models\Company;



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
    public $family;

    public String $shape = '100';


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
        $this->shape = $this->material->shape;
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
        $props['shape'] = $this->shape;
        $props['family'] = $this->family;
        $props['status'] = $this->status;
        $props['remarks'] = $this->remarks;

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
        $props['description'] = $this->description;
        $props['specification'] = $this->specification;
        $props['shape'] = $this->shape;
        $props['family'] = $this->family;
        $props['status'] = $this->status;
        $props['remarks'] = $this->remarks;

        $material = Material::findOrFail($id);

        $material->update($props);

        session()->flash('msg',[
            'type' => 'success',
            'text' => 'Material has been updated successfully.'
        ]);

        return true;
    }


















}








