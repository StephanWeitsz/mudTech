<?php

namespace Mudtec\Ezimeeting\Livewire\Admin\Corporations;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;

use Illuminate\Support\Facades\Storage;

use Mudtec\Ezimeeting\Models\Corporation;

class CorporationCreate extends Component
{

    use WithFileUploads;

    public $name;
    public $description;
    public $website;
    public $text;
    public $logo;

    public $page_heading = 'Corporations';
    public $page_sub_heading = 'Adding a new company';

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'required',
            'website' => 'required',
            'email' => 'required',
            'logo' => 'required|image|mimes:jpeg,png,jpg',
            'secret' => 'required',
        ]);

        $logoPath = $this->logo->store('corporate/logos', 'public');
        
        $corp = Corporation::create([
            'name' => $this->name,
            'description' => $this->description,
            'text' => $this->text,
            'website' => $this->website,
            'email' => $this->email,
            'logo' => $logoPath,
            'secret' => bcrypt($this->secret)
        ]);

        //$this->reset(['name', 'description','text', 'website', 'logo']);

        //$this->emit('corporationsCreated');

        session()->flash('success', 'Corporate Created!');
        $this->dispatch('Corporate Created', $corp);

    }

    public function render()
    {
        return view('ezimeeting::livewire.admin.corporations.corporation-create');
    }
}