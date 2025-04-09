<?php

namespace Mudtec\Ezimeeting\Livewire\Admin\Corporations;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;

use Mudtec\Ezimeeting\Models\Corporation;

class CorporationEdit extends Component
{
    use WithFileUploads;

    public $corporation;
    public $name;
    public $description;
    public $text;
    public $website;
    public $email;
    public $logo;
    public $logoPath;

    public $page_heading = 'Corporations';
    public $page_sub_heading = 'Editing a company';

    public function mount(Corporation $corporation)
    {
        $this->corporation = $corporation;
        $this->name = $corporation->name;
        $this->description = $corporation->description;
        $this->text = $corporation->text;
        $this->website = $corporation->website;
        $this->email = $corporation->email;
        $this->logoPath = $corporation->logo;
        $this->logo = "";
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'required',
            'website' => 'required',
            'email' => 'email',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg',
            'secret' => 'required',
        ]);

        if($this->logo)
            $logoPath = $this->logo->store('corporate/logos', 'public');
        else
            $logoPath = $this->logoPath;     

        $corp = $this->corporation->update([
            'name' => $this->name,
            'description' => $this->description,
            'text' => $this->text,
            'website' => $this->website,
            'email' => $this->email,
            'logo' => $logoPath,
            'secret' => bcrypt($this->secret)
        ]);

        //$this->reset(['name', 'description','text', 'website', 'logo']);

        session()->flash('success', 'Corporate Updated!');
        $this->dispatch('Corporate Updated', $corp);
        return;
    }

    public function render()
    {
        return view('ezimeeting::livewire.admin.corporations.corporation-edit');
    }
}