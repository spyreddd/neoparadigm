<?php

namespace App\Http\Livewire\Characters;

use App\Models\Character;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddCharacter extends Component
{
    use WithFileUploads;
    public $name, $description, $image;

    public function render()
    {
        return view('livewire.characters.add-character');
    }

    public function addCharacter()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image|max:10480'
        ]);

        $imagePath = $this->image->storePublicly('media/characters', 'public');

        Character::create([
            'name' => $this->name,
            'description' => $this->description,
            'image' => $imagePath,
        ]);
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => "Character added successfully."]);
        $this->dispatchBrowserEvent('notifyUpdate');
    }
}
