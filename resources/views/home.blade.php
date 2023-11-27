@extends('layouts.fixed')

@section('content')
    <div class="home d-flex justify-content-center h-100 mx-auto py-4">
        <div class="stopWatch">
            <h1 class="mx-auto text-center d-flex align-items-center justify-content-center status" id="status">勤務時間外</h1>
            <h2 class="text-center">2023/8/30</h2>
            <div class="home-timer mx-auto">
                <div class="position-relative circle mx-auto">
                    <svg id="progress" class="position-absolute top-50 start-50 translate-middle" width="400" height="400" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path id="progressPath" d="M200 10C224.951 10 249.658 14.9145 272.71 24.4629C295.762 34.0113 316.707 48.0066 334.35 65.6497C351.993 83.2929 365.989 104.238 375.537 127.29C385.086 150.342 390 175.049 390 200C390 224.951 385.085 249.658 375.537 272.71C365.989 295.762 351.993 316.707 334.35 334.35C316.707 351.993 295.762 365.989 272.71 375.537C249.658 385.086 224.951 390 200 390C175.049 390 150.342 385.085 127.29 375.537C104.238 365.989 83.2928 351.993 65.6497 334.35C48.0065 316.707 34.0112 295.762 24.4629 272.71C14.9145 249.658 9.99999 224.951 10 200C10 175.049 14.9145 150.342 24.4629 127.29C34.0113 104.238 48.0066 83.2928 65.6498 65.6496C83.2929 48.0065 104.238 34.0112 127.29 24.4628C150.342 14.9145 175.049 9.99998 200 10L200 10Z" stroke="url(#paint0_linear_567_156)" stroke-width="20"/>
                        <defs>
                            <linearGradient id="paint0_linear_567_156" x1="200" y1="6.73532e-06" x2="200" y2="400" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#BF09FF"/>
                                <stop offset="1" stop-color="#FF2626"/>
                            </linearGradient>
                        </defs>
                    </svg>
                    <p id="timer" class="text-center position-absolute top-50 start-50 translate-middle">00:00:00</p>
                </div>
                <div class="button">
                    <ul id="btn" class="d-flex justify-content-around">
                        <li class="btn-item toggleButton" id="toggleBtn"></li>
                        <li class="btn-item disabled resetButton" id="reset" ></li>
                    </ul>

                </div>
            </div>
        </div>
        <div class="infoBox d-flex justify-content-between flex-column">
            <div class="taskList  d-flex flex-column justify-content-around">
                <div class="taskListTitle d-flex">
                    <img src="{{ asset('img/newsLogo.svg') }}" alt="" class="player-timer-btn" />
                    <h3>期限が迫ってるタスク</h3>
                </div>
                <div class="taskListTasks">
                    @foreach ($tasks as $taskName => $deadLine)
                        <p>{{$taskName}} ---- {{$deadLine}}</p>
                    @endforeach
                </div>
                <div class="taskListButton d-flex justify-content-center">
                    <a href="/tasks"><button class="btn btn-primary">一覧をみる</button></a>
                </div>
            </div>
            <div class="workHourList d-flex justify-content-around">
                <div class="weekWorkTime w-100 d-flex flex-column align-items-center justify-content-around">
                    <h1>総労働時間(今週)</h1>
                    <div class="showTime d-flex w-100 justify-content-around">
                        <h2>現在:{{$weekWorkTime}}時間</h2>
                        <h2>上限: {{$weekWorkLimit}}時間</h2>
                    </div>
                    <progress class="mx-auto" id="creditScore" value={{$weekWorkTime}} max={{$weekWorkLimitBar}}>88%</progress>
                </div>
                <div class="monthWorkTime w-100 d-flex flex-column align-items-center justify-content-around">
                    <h1>総労働時間(今週)</h1>
                    <div class="showTime d-flex w-100 justify-content-around">
                        <h2>現在:{{$monthWorkTime}}時間</h2>
                        <h2>上限: {{$monthWorkLimit}}時間</h2>
                    </div>
                    <progress class="mx-auto" id="creditScore" value={{$weekOverLimit}} max={{$weekOverLimitBar}}>88%</progress>
                </div>
            </div>
            <div class="extraWorkList d-flex justify-content-around">
                <div class="weekOverTime w-100 d-flex flex-column align-items-center justify-content-around">
                    <h1>総残業時間(先週)</h1>
                    <div class="showTime d-flex w-100 justify-content-around">
                        <h2>{{$weekOverTime}}時間</h2>
                        <h2>上限: {{$weekOverLimit}}時間</h2>
                    </div>
                    <progress class="mx-auto" id="creditScore" value={{$monthWorkLimit}} max={{$monthWorkLimitBar}}>88%</progress>
                </div>
                <div class="monthOverTime w-100 d-flex flex-column align-items-center justify-content-around">
                    <h1>総残業時間(先月)</h1>
                    <div class="showTime d-flex w-100 justify-content-around">
                        <h2>{{$monthOverTime}}時間</h2>
                        <h2>上限: {{$monthOverLimit}}時間</h2>
                    </div>
                    <progress class="mx-auto" id="creditScore" value={{$monthOverLimit}} max={{$monthOverLimitBar}}>88%</progress>
                </div>
            <div class="extraWorkList ">
            </div>
            <div class="workHourList ">
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function() {
            let setTimeoutId = undefined;
            let isRunning = false; // タイマーが動いているかどうかのフラグ
            let startTime = 0; // タイマーを開始した時間
            let currentTime = 0; // 現在の時間
            let elapsedTime = 0; // 経過時間
            let breakStartTime = 0; // 休憩開始時間
            let breakTime = 0; // 休憩時間
            let intervalId; // タイマーを動かすための変数
            const totalDuration = 60 * 1000; // タイマーのゴール時間
            const progressBar = document.getElementById('progressPath');
            const progressBarLength = progressBar.getTotalLength();


            // 普通に出勤中のTimer(出勤中は定期的に呼ばれる / 多分休憩中は呼ばれてない)
            function runTimer() {
                currentTime = new Date();
                // ↓ここでプログレスバーを読んでる
                intervalId = setTimeout(updateProgressBar, 100); // 10ミリ秒ごとにプログレスバーを更新
                if(setTimeoutId){
                    clearTimeout(setTimeoutId);
                }
                //　↑ をコンソールで出すとIDが毎回変わってるそれが理由で止めたいsetIntervalが認識できてない可能性がある
                showTime(startTime); // タイマーを表示
                progressBar.style.display = 'block';
                setTimeoutId = setTimeout(() => {
                    runTimer();
                }, 0)
            }

            // 休憩の時間のTimer(休憩中は定期的に呼ばれる / 出勤中は多分呼ばれてない)
            function runBreakTimer() {
                currentTime = new Date();
                showTime(breakStartTime); // タイマーを表示
                setTimeoutId = setTimeout(() => {
                    runBreakTimer();
                }, 0)
            }

            // タイマーを表示させる関数(変更した秒数を表示するために定期的に呼ばれてる[break and normal])
            function showTime(time){
                let d = new Date(currentTime - time);
                const getHour = d.getHours() - 9;
                const getMin = d.getMinutes();
                const getSec =d.getSeconds();
                $("#timer").text(`${String(getHour).padStart(2,'0')}:${String(getMin).padStart(2,'0')}:${String(getSec).padStart(2,'0')}`);
            }

            // 今使ってない
            function classReplacementRun()  {
                $("#start").addClass("disabled");
                $("#stop").removeClass("disabled");
                $("#reset").addClass("disabled");
            }
            // 今使ってない
            function classReplacementStop()  {
                $("#start").removeClass("disabled");
                $("#stop").addClass("disabled");
                $("#reset").removeClass("disabled");
            }

            // プログレスバーを更新する関数 (この関数を10ミリ秒ごとに呼び出してるから円のやつが動いてる)
            function updateProgressBar() {
                const progress = Math.min(((currentTime - startTime) / totalDuration) * progressBarLength, progressBarLength);
                progressBar.style.strokeDashoffset = progressBarLength - progress;
            }

            function resetProgressBar() {
                progressBar.style.display = 'none';
            }


            // 退勤ボタンを押した時の処理
            $("#reset").click(function() {
                //ここでredirectする前にdbにデータを入れる必要がある
                //↓ await 使ってもいいかも？
                console.log("beforeFetch");
                elapsedTime = startTime - Date.now();
                console.log(elapsedTime);
                console.log(breakTime);
                const data = {
                    'elapsed_time': elapsedTime,
                    'break_time': breakTime,
                }
                fetch('home', { // 第1引数に送り先
                    method: 'POST', // メソッド指定
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }, // jsonを指定
                    body: JSON.stringify(data) // json形式に変換して添付
                })
                    .then(response => response.json()) // 返ってきたレスポンスをjsonで受け取って次のthenへ渡す
                    .then(res => {
                        console.log(res); // 返ってきたデータ
                        console.log("hello")
                    });
                console.log(data);
                console.log("afterFetch");
                // ↓ で/homeにredirectしてる
                window.location.replace("/home");
            });

            // toggleするボタンを押した時
            $("#toggleBtn").click(function() {
                // タイマーが動いてるかどうかのif文
                if (isRunning) {
                    // このif文の中はボタンが押された時が出勤中だった時の処理
                    clearTimeout(setTimeoutId); // タイマーを止めてる
                    // ↓ プログレスバーが動いてるかどうかのif文
                    if(intervalId){
                        // ↓ プログレスバー止めてる
                        clearTimeout(intervalId);
                    }
                    breakStartTime = Date.now() + breakTime; // ここはどういう処理？(休憩の開始時間を変数に入れてる？)
                    elapsedTime = startTime - Date.now(); //ここでelapsedTimeに今まで進んだ時間を代入
                    runBreakTimer(); // 休憩タイマーの変数を読んでる
                    $("#toggleBtn").removeClass("pauseButton");
                    $("#toggleBtn").addClass("restartButton");
                    $("#status").text("休憩中");
                    $("#status").removeClass("start");
                    $("#status").addClass("break");
                } else {
                    // この中はボタンが押された時が休憩中もしくは出勤してないだった時の処理
                    if (breakStartTime !== 0){
                        breakTime = breakStartTime - Date.now();
                    }
                    startTime = Date.now() + elapsedTime; // ここはどういう処理？(startTimeにどんな時間が入ってる？)
                    runTimer(); // 普通の出勤タイマーを起動してる
                    $("#reset").removeClass("disabled"); // リセットボタンが機能するようにしてる
                    $("#toggleBtn").removeClass("toggleButton");
                    $("#status").text("勤務中");
                    $("#status").addClass("start");
                    $("#toggleBtn").addClass("pauseButton");
                    if ($("#toggleBtn").hasClass("restartButton")){
                        $("#toggleBtn").removeClass("restartButton");
                        $("#toggleBtn").addClass("pauseButton");
                        $("#status").text("勤務中");
                        $("#status").removeClass("break");
                        $("#status").addClass("start");
                    }
                }
                isRunning = !isRunning; // フラグを反転(なんで反転させてる？)
            });
        });
    </script>
@endsection
