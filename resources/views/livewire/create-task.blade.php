<div class="job">
    <form wire:submit="save">
        <input type="text" wire:model="title" placeholder="タイトルを入力">
        <input type="text" wire:model="description" placeholder="詳細を入力">
        <button type="submit">Save</button>
    </form>
</div>
