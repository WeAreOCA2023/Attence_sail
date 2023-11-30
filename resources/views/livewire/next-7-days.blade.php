<div class="next-7-days">
    <h1>Next7Days</h1>
    <div class="dayTasks d-flex">
        @foreach ($weekList as $index => $eachDay)
            <x-next-7-each-day index="{{$index}}" eachDay="{{ $eachDay }}"></x-next-7-each-day>
        @endforeach
    </div>
</div>
<script>
    let ids = [];
    let eachDay = document.querySelectorAll('.eachDay');
    eachDay.forEach((eachDay) => {
        ids.push(eachDay.id);
    });
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('getIdList', (data) => {
            Livewire.dispatch('getIds', {idList: ids})
        })
    })
</script>
