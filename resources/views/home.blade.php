@extends('layouts.fixed')

@section('content')
    <div class="home d-flex justify-content-center h-100 mx-auto py-4">
        <div class="stopWatch">
            <h1 class="mx-auto text-center d-flex align-items-center justify-content-center">休憩中</h1>
            <h2 class="text-center">2023/8/30</h2>
            <div class="home-timer mx-auto">
                <div class="position-relative circle mx-auto">
                    <svg width="400" height="400" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="200" cy="200" r="195" stroke="#E8E8E8" stroke-width="10"/>
                    </svg>
                    <svg id="progress" class="position-absolute top-50 start-50 translate-middle" width="400" height="400" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path id="progressPath" d="M200 5C225.608 5 250.965 10.0438 274.623 19.8435C298.282 29.6432 319.778 44.0068 337.886 62.1142C355.993 80.2216 370.357 101.718 380.157 125.377C389.956 149.035 395 174.392 395 200C395 225.608 389.956 250.965 380.156 274.623C370.357 298.282 355.993 319.778 337.886 337.886C319.778 355.993 298.282 370.357 274.623 380.157C250.965 389.956 225.608 395 200 395C174.392 395 149.035 389.956 125.377 380.156C101.718 370.357 80.2215 355.993 62.1141 337.886C44.0067 319.778 29.6431 298.282 19.8435 274.623C10.0438 250.965 4.99999 225.608 5 200C5.00001 174.392 10.0439 149.035 19.8435 125.377C29.6432 101.718 44.0068 80.2215 62.1143 62.1141C80.2217 44.0067 101.718 29.6431 125.377 19.8434C149.035 10.0438 174.392 4.99998 200 5L200 5Z" stroke="url(#paint0_linear_227_203)" stroke-width="10"/>
                        <defs>
                            <linearGradient id="paint0_linear_227_203" x1="200" y1="0" x2="200" y2="400" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#71FF6F"/>
                                <stop offset="0.324447" stop-color="#C0FF5A"/>
                                <stop offset="0.671875" stop-color="#FFC076"/>
                                <stop offset="1" stop-color="#FF7D7D"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="button">
                    <p id="timer" class="text-center">00:00:00</p>
                    <ul id="btn" class="d-flex justify-content-around">
                        <li class="btn-item" id="toggleBtn"><img src="{{ asset('img/start.svg') }}" alt=""></li>
                        <li class="btn-item disabled" id="reset" ><img src="{{ asset('img/stop.svg') }}" alt=""/></li>
                    </ul>

                </div>
            </div>
        </div>
        <div class="infoBox d-flex justify-content-between flex-column">
            <div class="taskList bg-white d-flex flex-column justify-content-around">
                <div class="taskListTitle d-flex">
                    <img src="{{ asset('img/newsLogo.svg') }}" alt="" class="player-timer-btn" />
                    <h3>今日中に終わらせなければいけないタスク</h3>
                </div>
                <div class="taskListTasks">
                    <p>タスク名    ----  期限(時間)</p>
                    <p>タスク名    ----  期限(時間)</p>
                    <p>タスク名    ----  期限(時間)</p>
                </div>
            </div>
            <div class="extraWorkList bg-white">

            </div>
            <div class="workHourList bg-white">

            </div>
        </div>
    </div>
<script>
    $(document).ready(function() {
        let setTimeoutId = undefined;
        let isRunning = false;
        let startTime = 0;
        let currentTime = 0;
        let elapsedTime = 0;
        let breakStartTime = 0;
        let breakTime = 0;
        let intervalId;
        const totalDuration = 60 * 1000;
        const progressBar = document.getElementById('progressPath');
        const progressBarLength = progressBar.getTotalLength();

        function runTimer() {
            currentTime = new Date();
            // if (intervalId) {
            //     clearInterval(intervalId);
            // }
            intervalId = setInterval(upda4teProgressBar, 10)
            console.log(intervalId);
            showTime(startTime);
            progressBar.style.display = 'block';
            setTimeoutId = setTimeout(() => {
                runTimer();
            }, 0)
        }

        function runBreakTimer() {
            currentTime = new Date();
            clearInterval(intervalId);
            showTime(breakStartTime);
            setTimeoutId = setTimeout(() => {
                runBreakTimer();
            }, 0)
        }

        function showTime(time){
            let d = new Date(currentTime - time);
            const getHour = d.getHours() - 9;
            const getMin = d.getMinutes();
            const getSec =d.getSeconds();
            $("#timer").text(`${String(getHour).padStart(2,'0')}:${String(getMin).padStart(2,'0')}:${String(getSec).padStart(2,'0')}`);
        }

        function classReplacementRun()  {
            $("#start").addClass("disabled");
            $("#stop").removeClass("disabled");
            $("#reset").addClass("disabled");
        }

        function classReplacementStop()  {
            $("#start").removeClass("disabled");
            $("#stop").addClass("disabled");
            $("#reset").removeClass("disabled");
        }

        function classReplacementInitial()  {
            $("#start").removeClass("disabled");
            $("#stop").addClass("disabled");
            $("#reset").addClass("disabled");
        }

        // プログレスバーを更新する関数
        function updateProgressBar() {
            const progress = Math.min(((currentTime - startTime) / totalDuration) * progressBarLength, progressBarLength);
            progressBar.style.strokeDashoffset = progressBarLength - progress;
        }

        function resetProgressBar() {
            progressBar.style.display = 'none';
        }

        $("#reset").click(function() {
            if($(this).hasClass('disabled')){
                return;
            }
            classReplacementInitial()
            elapsedTime = 0;
            startTime = 0;
            resetProgressBar();
            $("#timer").text("00:00:00");
        });

        document.getElementById('toggleBtn').addEventListener('click', function() {
            if (isRunning) {
                clearTimeout(setTimeoutId);
                breakStartTime = Date.now() - breakTime;
                runBreakTimer();
                this.innerHTML = '<img src="{{ asset('img/restart.svg') }}" alt="">';
            } else {
                startTime = Date.now() - elapsedTime;
                runTimer();
                $("#reset").addClass("disabled");
                this.innerHTML = '<img src="{{ asset('img/pause.svg') }}" alt="">';
            }
            isRunning = !isRunning;
        });

        document.getElementById('reset').addEventListener('click', function() {
            clearTimeout(setTimeoutId);
            runBreakTimer();
            this.innerHTML = '<img src="{{ asset('img/start.svg') }}" alt="">';
        });
    });
</script>
@endsection
