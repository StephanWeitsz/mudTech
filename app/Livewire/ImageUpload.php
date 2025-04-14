<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ImageUpload extends Component
{
    use WithFileUploads;

    public $image;
    public $path;
    public $successMessage;

    protected $rules = [
        'image' => 'required|image|max:2048', // max 2MB
    ];

    public function updatedImage()
    {
        dd($this->image);
        $this->validateOnly('image');
    }

    public function upload()
    {
        dd($this->image);
        $this->validate();

        $this->path = $this->image->store('uploads', 'public');
        $this->successMessage = 'Image uploaded successfully!';
        $this->reset('image');
    }

    public function render()
    {
        return view('livewire.image-upload');
    }
}
