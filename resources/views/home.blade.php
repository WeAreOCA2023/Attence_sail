@extends('layouts.fixed')

@section('content')
<div class="home">
    <svg id="progress" width="400" height="400" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
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
    <div id="timerDisplay">00:00:00</div>
    <button id="startButton">Start</button>
    <button id="stopButton">Stop</button>
    <button id="resetButton">Reset</button>
</div>

<script>
    let timerInterval;  // タイマーを管理する setInterval の ID
    let startTime;      // タイマーが開始された時間
    let elapsedTime = 0;  // 経過した時間（ミリ秒単位）
    let isRunning = false;  // タイマーが動作中かどうかの状態
    const goalTime = 60 * 1000;  // 目標時間（ミリ秒単位）

    // SVGのパス要素
    const svgPath = document.getElementById('progressPath');

    window.addEventListener('DOMContentLoaded', () => {
        // ページ読み込み時に円を非表示にする
        svgPath.style.strokeDasharray = '0';  // 初めは表示しないようにする
        updateSVG(0);
    });

    // タイマーを開始する関数
    function startTimer() {
        if (!isRunning) {
            startTime = Date.now() - elapsedTime;
            timerInterval = setInterval(updateDisplay, 10);
            isRunning = true;
            svgPath.style.strokeDasharray = '1000';
        }
    }

    // タイマーを停止する関数
    function stopTimer() {
        if (isRunning) {
            clearInterval(timerInterval);
            isRunning = false;
        }
    }

    // タイマーをリセットする関数
    function resetTimer() {
        stopTimer();
        elapsedTime = 0;
        updateDisplay();
    }

    // タイマーの表示を更新する関数
    function updateDisplay() {
        const currentTime = Date.now();
        elapsedTime = currentTime - startTime;
        const formattedTime = formatTime(elapsedTime);
        document.getElementById('timerDisplay').textContent = formattedTime;

        updateSVG(elapsedTime);
    }

    // 時間をフォーマットする関数（HH:mm:ss 形式）
    function formatTime(milliseconds) {
        const date = new Date(milliseconds);
        const hours = date.getUTCHours().toString().padStart(2, '0');
        const minutes = date.getMinutes().toString().padStart(2, '0');
        const seconds = date.getSeconds().toString().padStart(2, '0');
        return `${hours}:${minutes}:${seconds}`;
    }

    // SVGの表示を更新する関数
    function updateSVG(elapsedTime) {
        // const progress = Math.min((elapsedTime / goalTime) * 100, 100);
        const circumference = svgPath.getTotalLength();
        // const dashoffset = circumference * (progress / 100);
        const dashoffset = circumference - (elapsedTime / goalTime) * circumference;
        svgPath.style.strokeDashoffset = dashoffset; 
        console.log(dashoffset);
    }

    // "Start" ボタンがクリックされた時の処理
    document.getElementById('startButton').addEventListener('click', startTimer);

    // "Stop" ボタンがクリックされた時の処理
    document.getElementById('stopButton').addEventListener('click', stopTimer);

    // "Reset" ボタンがクリックされた時の処理
    document.getElementById('resetButton').addEventListener('click', resetTimer);

</script>
@endsection
