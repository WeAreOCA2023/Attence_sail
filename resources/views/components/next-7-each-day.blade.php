@props(['eachDay' => "default"])
@props(['index' => null])

<div id="{{ $index }}" class="eachDay">
    <h1>{{ $eachDay }}</h1>
    <div class="eachTask d-flex mx-auto justify-content-between">
        <p>Task1</p>
        <p>期限 10:00</p>
    </div>
</div>


