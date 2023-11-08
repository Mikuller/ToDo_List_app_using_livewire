<div>
    @include('livewire.includes.create_todo_box')
    @include('livewire.includes.search_box')
    <div id="todos-list">
        @foreach ($toDoList as $toDo)
         @include('livewire.includes.show_todo_list')
        @endforeach
        <div class="my-2">
            {{ $toDoList->links() }};
        </div>
    </div>
</div>
