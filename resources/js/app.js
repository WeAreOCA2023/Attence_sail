/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');

(() => {
    'use strict'
    const tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.forEach(tooltipTriggerEl => {
      new bootstrap.Tooltip(tooltipTriggerEl)
    })
  })()

$(document).ready(function() {
    let setTimeoutId = undefined;
    let isRunning = false;
    let startTime = 0;
    let currentTime = 0;
    let elapsedTime = 0;
    let interval;
    const totalDuration = 60 * 1000;
    const progressBar = document.getElementById('progressPath');
    const progressBarLength = progressBar.getTotalLength();

    function runTimer(){
        currentTime = new Date();
        interval = setInterval(updateProgressBar, 10);
        showTime();
        progressBar.style.display = 'block';
        setTimeoutId = setTimeout(() => {
            runTimer();
        },0)
    }

    function showTime(){
        let d = new Date(currentTime - startTime);
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
            $("#reset").removeClass("disabled");
            elapsedTime = currentTime - startTime;
            this.innerHTML = '<img src="{{ asset('img/start.svg') }}" alt="">';
        } else {
            console.log(elapsedTime);
            startTime = Date.now() - elapsedTime;
            runTimer();
            $("#reset").addClass("disabled");
            this.innerHTML = '<img src="{{ asset('img/pause.svg') }}" alt="">';
        }
        isRunning = !isRunning;
    });

});