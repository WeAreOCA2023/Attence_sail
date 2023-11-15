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
{{--                <h1>{{ $finalHours }}</h1>--}}
            </div>
            <div class="workHourList bg-white">

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

        // function stopInterval() {
        //     console.log("999999999999999999999");
        //     clearInterval(intervalId);
        // }

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
                this.innerHTML = '<img src="{{ asset('img/restart.svg') }}" alt="">'; // ボタンの画像を変えてる
            } else {
                // この中はボタンが押された時が休憩中もしくは出勤してないだった時の処理
                if (breakStartTime !== 0){
                    breakTime = breakStartTime - Date.now();
                }
                startTime = Date.now() + elapsedTime; // ここはどういう処理？(startTimeにどんな時間が入ってる？)
                runTimer(); // 普通の出勤タイマーを起動してる
                $("#reset").removeClass("disabled"); // リセットボタンが機能するようにしてる
                this.innerHTML = '<img src="{{ asset('img/pause.svg') }}" alt="">'; // ボタンの画像を変えてる
            }
            isRunning = !isRunning; // フラグを反転(なんで反転させてる？)
        });
    });
</script>
@endsection
