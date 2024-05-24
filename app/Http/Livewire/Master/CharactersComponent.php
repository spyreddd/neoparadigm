<?php

namespace App\Http\Livewire\Master;

use App\Models\Character;
use Livewire\Component;
use Livewire\WithPagination;

class CharactersComponent extends Component
{
    use WithPagination;

    public $perPage = 4;

    protected $paginationTheme = 'bootstrap'; // Use Bootstrap for pagination styling

    public function render()
    {
        $characters = Character::latest()->paginate($this->perPage);
        return view('livewire.master.characters-component', ['characters' => $characters]);
    }
}
