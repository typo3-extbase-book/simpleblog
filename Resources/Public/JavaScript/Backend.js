/**
 * Main JavaScript for Backend Module
 */

define(
    [
        'jquery',
        'TYPO3/CMS/Simpleblog/Chart'
    ],
    function ($) {
        var Module = {};

        // Initialize
        Module.initialize = function () {
            $.ajax({
                url: TYPO3.settings.ajaxUrls['simpleblog_dispatch'],
                method: 'GET',
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                success: function (response) {
                    Module.renderChartLastComments('last-comments', response.lastComments.data, response.lastComments.labels);
                    Module.renderChartPostsPerBlog('posts-per-blog', response.postsPerBlog.data, response.postsPerBlog.labels);
                }
            });
        }

        // Render "last comments" chart
        Module.renderChartLastComments = function (id, data, labels) {
            var canvas = document.getElementById(id);
            var chart = new Chart(canvas, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: false,
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
        }

        // Render "last comments" chart
        Module.renderChartPostsPerBlog = function (id, data, labels) {

            var randomColors = function () {
                var r = Math.floor(Math.random() * 255);
                var g = Math.floor(Math.random() * 255);
                var b = Math.floor(Math.random() * 255);
                return {
                    "borderColor": "rgb(" + r + "," + g + "," + b + ", 0.3)",
                    "backgroundColor": "rgb(" + r + "," + g + "," + b + ", 0.2)"
                };
            };

            var borderColor = [];
            var backgroundColor = [];
            for (var i in data) {
                randomColor = randomColors();
                borderColor.push(randomColor["borderColor"]);
                backgroundColor.push(randomColor["backgroundColor"]);
            }

            var pie = document.getElementById(id);
            var chart = new Chart(pie, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        borderColor: borderColor,
                        backgroundColor: backgroundColor
                    }]
                },
                options: {
                    legend: {
                        position: 'right'
                    }
                }
            });
        };

        // Initialize
        $(document).ready(function () {
            Module.initialize();
        });
    }
);
