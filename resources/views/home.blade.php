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
        <div class="player-timer">
            <!-- タイマーの下地になるサークル -->
            <svg class="player-timer-circle player-timer-track-circle" width="220" height="220" viewBox="0 0 220 220" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="110" cy="110" r="108.5" stroke="white" stroke-width="3"/>
            </svg>
            <!-- タイマーの移動する部分のサークル -->
            <svg class="player-timer-circle player-timer-moving-circle" width="220" height="220" viewBox="0 0 220 220" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="110" cy="110" r="108.5" stroke="#B7B7B7" stroke-width="3"/>
            </svg>
            <!-- 再生ボタン -->
            <img src="{{ asset('img/start.svg') }}" alt="" class="player-timer-btn" />
            <h3 class='timeDisplay'>0:00</h3>
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

        const playBtn = document.querySelector('.player-timer-btn')
        let leftTime = 1000;

        window.addEventListener('DOMContentLoaded', () => {
            mapCheckPlayingEvent();
        });
        
        const mapCheckPlayingEvent = () => {
            playBtn.addEventListener('click', () => {
                startStop();
            });
        }
    </script>
@endsection
