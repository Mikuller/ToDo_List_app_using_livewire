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

    public $edittingTodoId;

    #[Rule('required|min:1|max:300')]
    public $edittingTodoName;
    public function create()
    {
        $validated = $this->validateOnly('name');

        Todo::create($validated);

        $this->reset('name');

        session()->flash('success', 'created');

        $this->resetPage();
    }
    public function delete(Todo $todo)
    {
        $todo->delete();
    }

    public function edit($todoId)
    {
        $this->edittingTodoId = $todoId;
        $this->edittingTodoName = Todo::find($todoId)->name;
    }
    public function update(Todo $todo)
    {
        $validated = $this->validateOnly('edittingTodoName');
        $todo->update([
            'name'=> $this->edittingTodoName,
        ]);
        $this->reset('edittingTodoName', 'edittingTodoId');

    }
    public function cancelEdit()
    {
        $this->reset('edittingTodoName', 'edittingTodoId');
    }

    public function toggle(Todo $todo)
    {
        $todo->completed = !$todo->completed;
        $todo->save();
    }
    public function render()
    {
        $toDoList = Todo::latest()
            ->where('name', 'like', "%{$this->search}%")
            ->paginate(3);
        return view('livewire.todo-list', compact('toDoList'));
    }
}
