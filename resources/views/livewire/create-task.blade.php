<div>
@if($taskCreate)
    <form wire:submit="save">
        <input type="text" wire:model.lazy="title" placeholder="タイトルを入力">
        <input type="text" wire:model.lazy="description" placeholder="詳細を入力">
        <button type="submit">Save</button>
    </form>
@endif
</div>
