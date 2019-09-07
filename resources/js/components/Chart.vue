<template>
    <canvas width="100%" height="30"></canvas>
</template>

<script>
    import Chart from 'chart.js';

    export default {
        name: "Chart",

        props: {
            label: {
                type: String,
                default: ''
            },
            labels: {
                default: function () {
                    return [];
                }
            },
            values: {
                default: function () {
                    return [];
                }
            }
        },

        mounted() {
            var data = {
                labels: this.labels,

                datasets: [
                    {
                        label: this.label,
                        lineTension: 0.3,
                        backgroundColor: "rgba(2,117,216,0.2)",
                        borderColor: "rgba(2,117,216,1)",
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(2,117,216,1)",
                        pointBorderColor: "rgba(255,255,255,0.8)",
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "rgba(2,117,216,1)",
                        pointHitRadius: 50,
                        pointBorderWidth: 2,
                        data: this.values
                    },
                ]
            };

            var options = {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            // max: 40000,
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                },
                legend: {
                    display: false
                }
            };

            new Chart(this.$el.getContext('2d'), {
                type: 'line',
                data: data,
                options: options
            });
        }
    }
</script>
