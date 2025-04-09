<?php

namespace Mudtec\Ezimeeting\Livewire\Admin\Corporations;

use Mudtec\Ezimeeting\Models\Corporation;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class CorporationList extends Component
{
    use WithPagination;

    public $showEditForm = false;
    public $editingCorporation;

    public $search;
    //public $corporations;

    public $page_heading = 'Corporations';
    public $page_sub_heading = 'All companies';

    public function delete($corporation) {
        try {
            Corporation::findOrfail($corporation)->delete();
        } catch(Exception $e) {
            request()->session()->flash('error', 'Delete Failed!');
            return;
        }
    }

    public function edit(Corporation $corporation)
    {
        $this->showEditForm = true;
        $this->editingCorporation = $corporation;
    }

    public function render()
    {
        if (verify_user("SuperUser|Admin")) {
            $corporations = Corporation::latest()
                ->where('name', 'ilike', "%{$this->search}%")
                ->paginate(20);
        } //if (verify_user("SuperUser|Admin")) { 
        else {
            $myCorporations = get_user_corporation();
            
            if ($myCorporations && $myCorporations->isNotEmpty()) {
                $corporations = Corporation::latest()
                    ->where('name', 'ilike', "%{$this->search}%")
                    ->whereIn('id', $myCorporations->pluck('id'))
                    ->paginate(20);
            } else {
                $corporations = collect();
                session()->flash('error', 'There is no corporation you can access!');
            }
        } //else   
        
        /*
        $this->corporations = $corporations;
        return view('ezimeeting::livewire.admin.corporations.corporation-list');
        */
        
        return view('ezimeeting::livewire.admin.corporations.corporation-list', [
            'corporations' => $corporations
        ]);
      
    }
}
