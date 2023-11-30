<div class="next-7-days">
    <h1>Next7Days</h1>
    <div class="dayTasks d-flex">
        @foreach ($weekList as $eachDay)
            <x-next-7-each-day eachDay="{{ $eachDay }}"></x-next-7-each-day>
        @endforeach
    </div>
</div>
