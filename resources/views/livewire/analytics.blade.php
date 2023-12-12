<div class="analytics">
    <h2>時間</h2>
    <div>
        <canvas id="myChart"></canvas>
    </div>
    <div>
        <button wire:click="decrementWeek">前の週</button>
        <button wire:click="incrementWeek">次の週</button>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('buttonClicked', () => {
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
                currentWorkHours: @json($currentWorkHours['raw']),
                secondWorkHours: @json($secondWorkHours['raw']),
                thirdWorkHours: @json($thirdWorkHours['raw']),
                fourthWorkHours: @json($fourthWorkHours['raw']),
                fifthWorkHours: @json($fifthWorkHours['raw']),
                sixthWorkHours: @json($sixthWorkHours['raw']),
                seventhWorkHours: @json($seventhWorkHours['raw']),
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

            // チャートが既に存在していれば破棄する
            let existingChart = Chart.getChart(ctx);
            if (existingChart) {
                existingChart.destroy();
            }

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [analyticsData.seventhDate, analyticsData.sixthDate, analyticsData.fifthDate, analyticsData.fourthDate, analyticsData.thirdDate, analyticsData.secondDate, analyticsData.currentDate],
                    datasets: [{
                        label: '出勤時間',
                        data: [analyticsData.seventhWorkHours, analyticsData.sixthWorkHours, analyticsData.fifthWorkHours, analyticsData.fourthWorkHours, analyticsData.thirdWorkHours, analyticsData.secondWorkHours, analyticsData.currentWorkHours],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return formatTime(value, 'label');
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return '出勤時間：' + formatTime(context.parsed.y, 'tooltip');
                                }
                            }
                        }
                    }
                }
            });
        });
    })
</script>
