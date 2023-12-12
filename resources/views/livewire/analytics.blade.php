<div class="analytics">
    <h2>時間</h2>
    <div>
        <canvas id="myChart"></canvas>
    </div>
    <div>
        <button wire:click="decrementWeek">Previous Week</button>
        <button wire:click="incrementWeek">Next Week</button>
    </div>
</div>
<script>
    $(document).ready(function() {
        const ctx = document.getElementById('myChart');

        let analyticsData = {
            currentDate: @json($currentDate),
            secondDate: @json($secondDate),
            thirdDate: @json($thirdDate),
            fourthDate: @json($fourthDate),
            fifthDate: @json($fifthDate),
            sixthDate: @json($sixthDate),
            seventhDate: @json($seventhDate),
            workedAt: @json($workedAt),
            currentWorkHours: @json($currentWorkHours),
            secondWorkHours: @json($secondWorkHours),
            thirdWorkHours: @json($thirdWorkHours),
            fourthWorkHours: @json($fourthWorkHours),
            fifthWorkHours: @json($fifthWorkHours),
            sixthWorkHours: @json($sixthWorkHours),
            seventhWorkHours: @json($seventhWorkHours),
        };
        function formatTime(time, type) {
            let hours = Math.floor(time)
            let minutes = Math.round((time - hours) * 60)
            if (type === 'label') {
                return hours + '時間' + minutes + '分';
            } else if (type === 'tooltip') {
                return hours + '時間' + minutes + '分';
            }
        }
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [analyticsData.seventhDate, analyticsData.sixthDate, analyticsData.fifthDate, analyticsData.fourthDate, analyticsData.thirdDate, analyticsData.secondDate, analyticsData.currentDate ],
                datasets: [{
                    label: '出勤時間',
                    data: [analyticsData.seventhWorkHours['raw'], analyticsData.sixthWorkHours['raw'], analyticsData.fifthWorkHours['raw'], analyticsData.fourthWorkHours['raw'], analyticsData.thirdWorkHours['raw'], analyticsData.secondWorkHours['raw'], analyticsData.currentWorkHours['raw']],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        tricks: {
                            callback: function (value) {
                                return formatTime(value, 'label');
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '出勤時間：' + formatTime(context.parsed.y, 'tooltip');
                            }
                        }
                    }
                }
            }
        });
    });


</script>
