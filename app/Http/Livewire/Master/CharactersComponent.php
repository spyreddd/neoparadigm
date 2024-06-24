<?php

namespace App\Http\Livewire\Master;

use App\Models\Character;
use Livewire\Component;
use Livewire\WithPagination;

class CharactersComponent extends Component
{
    use WithPagination;

    public $perPage = 4;
    public $search = '';

    protected $paginationTheme = 'bootstrap'; // Use Bootstrap for pagination styling

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Character::query();

        if ($this->search) {
            $query->where('name', 'LIKE', '%' . $this->search . '%')
                  ->orWhere('description', 'LIKE', '%' . $this->search . '%');
        }

        $characters = $query->latest()->paginate($this->perPage);
        return view('livewire.master.characters-component', ['characters' => $characters]);
    }
}
