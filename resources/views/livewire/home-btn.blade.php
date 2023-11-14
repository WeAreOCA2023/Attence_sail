<div class="button">
    <p id="timer" class="text-center">00:00:00</p>
    <ul id="btn" class="d-flex justify-content-around">
        <li class="btn-item" id="toggleBtn"><img src="{{ asset('img/start.svg') }}" alt=""></li>
        <li class="btn-item disabled" id="reset" wire:click="receiveVariable"><img src="{{ asset('img/stop.svg') }}" alt=""/></li>
    </ul>
</div>
