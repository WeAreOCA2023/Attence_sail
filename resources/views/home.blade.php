@extends('layouts.fixed')

@section('content')
    <div class="container home d-flex justify-content-around h-100 align-items-center">
        <div class="stopWatch bg-white rounded d-flex align-items-center flex-column">
            <h1 class="bg-black text-white text-center rounded">休憩中</h1>
            <div class="timeDisplay d-flex justify-content-center align-items-lg-center">
                <p id="stopwatch">00:00:00</p>
            </div>
            <div class="stopwatchButtons">
                <button id="startStop" onclick="startStop()">Start</button>
                <button id="reset" onclick="resetStopwatch()">Reset</button>
            </div>
        </div>
        <div class="infoBox d-flex justify-content-between flex-column">
            <div class="taskList bg-white rounded ">

            </div>
            <div class="extraWorkList bg-white rounded">

            </div>
            <div class="workHourList bg-white rounded">

            </div>
        </div>
    </div>

    <script>
        let timer;
        let isRunning = false;
        let seconds = 0;
        let minutes = 0;
        let hours = 0;

        function startStop() {
            if (isRunning) {
                clearInterval(timer);
                document.getElementById("startStop").textContent = "Start";
            } else {
                timer = setInterval(updateStopwatch, 1000);
                document.getElementById("startStop").textContent = "Stop";
            }
            isRunning = !isRunning;
        }

        function resetStopwatch() {
            clearInterval(timer);
            document.getElementById("startStop").textContent = "Start";
            isRunning = false;
            seconds = 0;
            minutes = 0;
            hours = 0;
            updateStopwatch();
        }

        function updateStopwatch() {
            const timeString = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            document.getElementById("stopwatch").textContent = timeString;

            seconds++;
            if (seconds >= 60) {
                seconds = 0;
                minutes++;
                if (minutes >= 60) {
                    minutes = 0;
                    hours++;
                }
            }
        }
    </script>
@endsection
