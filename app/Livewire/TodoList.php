<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{
    use WithPagination;
    #[Rule('required|min:1|max:300')]
    public $name;

    public $search;
    public function create()
    {
        $validated = $this->validateOnly('name');

        Todo::create($validated);

        $this->reset('name');

        session()->flash('success', 'created');
    }
    public function render()
    {
        $toDoList = Todo::latest()->paginate(3);
        return view('livewire.todo-list', compact('toDoList'));
    }
}