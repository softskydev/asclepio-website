$(document).ready(function () {
    $("#incomeSummary").trigger('change');
    $("#asclepediaSummary").trigger('change');
    $("#asclepiogoSummary").trigger('change');
    $("#year_pedia").trigger('change');
    $("#year_piogo").trigger('change');

    // load_chart_asclepiogo();
});
$("#chart_year").hide();
$("#chart_month").hide();
$("#chart_week").hide();
$("#chart_day").hide();

$("#chart_asclepedia_year").hide();
$("#chart_asclepedia_month").hide();
$("#chart_asclepedia_week").hide();
$("#chart_asclepedia_day").hide();

$("#chart_asclepiogo_year").hide();
$("#chart_asclepiogo_month").hide();
$("#chart_asclepiogo_week").hide();
$("#chart_asclepiogo_day").hide();

function income(val) {
    if (val == 'year') {
        $("#chart_year").show();
        $("#chart_month").hide();
        $("#chart_week").hide();
        $("#chart_day").hide();
        load_chart_tahunan();
    } else if (val == 'month') {
        $("#chart_year").hide();
        $("#chart_month").show();
        $("#chart_week").hide();
        $("#chart_day").hide();
        load_chart_bulanan();
    } else if (val == 'week') {
        $("#chart_year").hide();
        $("#chart_month").hide();
        $("#chart_week").show();
        $("#chart_day").hide();
        load_chart_mingguan();
    } else {
        $("#chart_year").hide();
        $("#chart_month").hide();
        $("#chart_week").hide();
        $("#chart_day").show();
        load_chart_harian();
    }
}

function asclepedia(val) {
    if (val == 'year') {
        $("#chart_asclepedia_year").show();
        $("#chart_asclepedia_month").hide();
        $("#chart_asclepedia_week").hide();
        $("#chart_asclepedia_day").hide();
        load_chart_asclepedia_year();
    } else if (val == 'month') {
        $("#chart_asclepedia_year").hide();
        $("#chart_asclepedia_month").show();
        $("#chart_asclepedia_week").hide();
        $("#chart_asclepedia_day").hide();
        load_chart_asclepedia_month();
    } else if (val == 'week') {
        $("#chart_asclepedia_year").hide();
        $("#chart_asclepedia_month").hide();
        $("#chart_asclepedia_week").show();
        $("#chart_asclepedia_day").hide();
        load_chart_asclepedia_week();
    } else {
        $("#chart_asclepedia_year").hide();
        $("#chart_asclepedia_month").hide();
        $("#chart_asclepedia_week").hide();
        $("#chart_asclepedia_day").show();
        load_chart_asclepedia_day();
    }
}

function asclepiogo(val) {
    if (val == 'year') {
        $("#chart_asclepiogo_year").show();
        $("#chart_asclepiogo_month").hide();
        $("#chart_asclepiogo_week").hide();
        $("#chart_asclepiogo_day").hide();
        load_chart_asclepiogo_year();
    } else if (val == 'month') {
        $("#chart_asclepiogo_year").hide();
        $("#chart_asclepiogo_month").show();
        $("#chart_asclepiogo_week").hide();
        $("#chart_asclepiogo_day").hide();
        load_chart_asclepiogo_month();
    } else if (val == 'week') {
        $("#chart_asclepiogo_year").hide();
        $("#chart_asclepiogo_month").hide();
        $("#chart_asclepiogo_week").show();
        $("#chart_asclepiogo_day").hide();
        load_chart_asclepiogo_week();
    } else {
        $("#chart_asclepiogo_year").hide();
        $("#chart_asclepiogo_month").hide();
        $("#chart_asclepiogo_week").hide();
        $("#chart_asclepiogo_day").show();
        load_chart_asclepiogo_day();
    }
}

function load_chart_asclepedia(year) {
    $.ajax({
        type: "get",
        url: global_url + "Income_analytics/chart_asclepedia/" + year,
        dataType: "json",
        success: function (response) {
            $("#chart_asclepedia").remove();
            $(".box_canvas_pedia").append("<canvas id='chart_asclepedia' width='100%'></canvas>");
            var jsonfile = response;
            var labels = jsonfile.items.map(function (e) {
                return e.label;
            });
            var data_gmk = jsonfile.items.map(function (e) {
                return e.gmk;
            });
            var data_skill = jsonfile.items.map(function (e) {
                return e.skills_lab;
            });

            var ctx = document.getElementById('chart_asclepedia').getContext('2d');
            var config = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Good Morning Knowledge',
                        data: data_gmk,
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)'
                    }, {
                        label: 'Skills Lab',
                        data: data_skill,
                        backgroundColor: 'rgb(255, 159, 64)',
                        borderColor: 'rgb(255, 159, 64)'
                    }]
                }
            };

            var chart = new Chart(ctx, config);

        }
    });

}

function load_chart_asclepiogo(year) {
    $.ajax({
        type: "get",
        url: global_url + "Income_analytics/chart_asclepiogo/" + year,
        dataType: "json",
        success: function (response) {
            $("#chart_asclepiogo").remove();
            $(".box_canvas_piogo").append("<canvas id='chart_asclepiogo' width='100%'></canvas>");
            var jsonfile = response;
            var labels = jsonfile.items.map(function (e) {
                return e.label;
            });
            var data_open = jsonfile.items.map(function (e) {
                return e.open;
            });
            var data_expert = jsonfile.items.map(function (e) {
                return e.expert;
            });

            var ctx = document.getElementById('chart_asclepiogo').getContext('2d');
            var config = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Open Class',
                        data: data_open,
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)'
                    }, {
                        label: 'Expert Class',
                        data: data_expert,
                        backgroundColor: 'rgb(255, 159, 64)',
                        borderColor: 'rgb(255, 159, 64)'
                    }]
                }
            };

            var chart = new Chart(ctx, config);


        }
    });

}

function load_chart_tahunan() {
    $.ajax({
        type: "get",
        url: global_url + "Income_analytics/chart_tahunan",
        dataType: "json",
        success: function (response) {
            $("#chart_year").remove();
            $(".box_pemasukan").append("<canvas id='chart_year' width='100%'></canvas>");
            var labels = response.labels;
            var datapoint = response.items;

            console.log(datapoint);


            var ctx = document.getElementById('chart_year').getContext('2d');
            var config = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: datapoint
                }
            };

            var chart = new Chart(ctx, config);
        }
    });

}

function load_chart_bulanan() {
    $.ajax({
        type: "get",
        url: global_url + "Income_analytics/chart_bulanan",
        dataType: "json",
        success: function (response) {
            $("#chart_month").remove();
            $(".box_pemasukan").append("<canvas id='chart_month' width='100%'></canvas>");
            var jsonfile = response;
            var labels = jsonfile.items.map(function (e) {
                return e.label;
            });
            var data = jsonfile.items.map(function (e) {
                return e.data;
            });

            var ctx = document.getElementById('chart_month').getContext('2d');
            var config = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Pemasukan',
                        data: data,
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)'
                    }]
                }
            };

            var chart = new Chart(ctx, config);
        }
    });

}

function load_chart_mingguan() {
    $.ajax({
        type: "get",
        url: global_url + "Income_analytics/chart_mingguan",
        dataType: "json",
        success: function (response) {
            $("#chart_week").remove();
            $(".box_pemasukan").append("<canvas id='chart_week' width='100%'></canvas>");
            var labels = response.labels;
            var datapoint = response.items;

            console.log(datapoint);


            var ctx = document.getElementById('chart_week').getContext('2d');
            var config = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: datapoint
                }
            };

            var chart = new Chart(ctx, config);
        }
    });

}

function load_chart_harian() {
    $.ajax({
        type: "get",
        url: global_url + "Income_analytics/chart_harian",
        dataType: "json",
        success: function (response) {
            $("#chart_day").remove();
            $(".box_pemasukan").append("<canvas id='chart_day' width='100%'></canvas>");
            var labels = response.labels;
            var datapoint = response.items;

            console.log(datapoint);


            var ctx = document.getElementById('chart_day').getContext('2d');
            var config = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: datapoint
                }
            };

            var chart = new Chart(ctx, config);
        }
    });

}


// asclepedia
function load_chart_asclepedia_year() {
    $.ajax({
        type: "get",
        url: global_url + "Income_analytics/chart_asclepedia_year",
        dataType: "json",
        success: function (response) {
            $("#chart_asclepedia_year").remove();
            $(".box_pemasukan_pedia").append("<canvas id='chart_asclepedia_year' width='100%'></canvas>");
            var labels = response.labels;
            var datapoint = response.items;

            console.log(datapoint);


            var ctx = document.getElementById('chart_asclepedia_year').getContext('2d');
            var config = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: datapoint
                }
            };

            var chart = new Chart(ctx, config);
        }
    });

}

function load_chart_asclepedia_month() {
    $.ajax({
        type: "get",
        url: global_url + "Income_analytics/chart_asclepedia_month",
        dataType: "json",
        success: function (response) {
            $("#chart_asclepedia_month").remove();
            $(".box_pemasukan_pedia").append("<canvas id='chart_asclepedia_month' width='100%'></canvas>");
            var labels = response.labels;
            var datapoint = response.items;

            console.log(datapoint);


            var ctx = document.getElementById('chart_asclepedia_month').getContext('2d');
            var config = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: datapoint
                }
            };

            var chart = new Chart(ctx, config);
        }
    });

}

function load_chart_asclepedia_week() {
    $.ajax({
        type: "get",
        url: global_url + "Income_analytics/chart_asclepedia_week",
        dataType: "json",
        success: function (response) {
            $("#chart_asclepedia_week").remove();
            $(".box_pemasukan_pedia").append("<canvas id='chart_asclepedia_week' width='100%'></canvas>");
            var labels = response.labels;
            var datapoint = response.items;

            console.log(datapoint);


            var ctx = document.getElementById('chart_asclepedia_week').getContext('2d');
            var config = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: datapoint
                }
            };

            var chart = new Chart(ctx, config);
        }
    });

}

function load_chart_asclepedia_day() {
    $.ajax({
        type: "get",
        url: global_url + "Income_analytics/chart_asclepedia_day",
        dataType: "json",
        success: function (response) {
            $("#chart_asclepedia_day").remove();
            $(".box_pemasukan_pedia").append("<canvas id='chart_asclepedia_day' width='100%'></canvas>");
            var labels = response.labels;
            var datapoint = response.items;

            console.log(datapoint);


            var ctx = document.getElementById('chart_asclepedia_day').getContext('2d');
            var config = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: datapoint
                }
            };

            var chart = new Chart(ctx, config);
        }
    });

}


// end asclepedia

function load_chart_asclepiogo_year() {
    $.ajax({
        type: "get",
        url: global_url + "Income_analytics/chart_asclepiogo_year",
        dataType: "json",
        success: function (response) {
            $("#chart_asclepiogo_year").remove();
            $(".box_pemasukan_piogo").append("<canvas id='chart_asclepiogo_year' width='100%'></canvas>");
            var labels = response.labels;
            var datapoint = response.items;

            console.log(datapoint);


            var ctx = document.getElementById('chart_asclepiogo_year').getContext('2d');
            var config = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: datapoint
                }
            };

            var chart = new Chart(ctx, config);
        }
    });

}

function load_chart_asclepiogo_month() {
    $.ajax({
        type: "get",
        url: global_url + "Income_analytics/chart_asclepiogo_month",
        dataType: "json",
        success: function (response) {
            $("#chart_asclepiogo_month").remove();
            $(".box_pemasukan_piogo").append("<canvas id='chart_asclepiogo_month' width='100%'></canvas>");
            var labels = response.labels;
            var datapoint = response.items;

            console.log(datapoint);


            var ctx = document.getElementById('chart_asclepiogo_month').getContext('2d');
            var config = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: datapoint
                }
            };

            var chart = new Chart(ctx, config);
        }
    });

}

function load_chart_asclepiogo_week() {
    $.ajax({
        type: "get",
        url: global_url + "Income_analytics/chart_asclepiogo_week",
        dataType: "json",
        success: function (response) {
            $("#chart_asclepiogo_week").remove();
            $(".box_pemasukan_piogo").append("<canvas id='chart_asclepiogo_week' width='100%'></canvas>");
            var labels = response.labels;
            var datapoint = response.items;

            console.log(datapoint);


            var ctx = document.getElementById('chart_asclepiogo_week').getContext('2d');
            var config = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: datapoint
                }
            };

            var chart = new Chart(ctx, config);
        }
    });

}

function load_chart_asclepiogo_day() {
    $.ajax({
        type: "get",
        url: global_url + "Income_analytics/chart_asclepiogo_day",
        dataType: "json",
        success: function (response) {
            $("#chart_asclepiogo_day").remove();
            $(".box_pemasukan_piogo").append("<canvas id='chart_asclepiogo_day' width='100%'></canvas>");
            var labels = response.labels;
            var datapoint = response.items;

            console.log(datapoint);


            var ctx = document.getElementById('chart_asclepiogo_day').getContext('2d');
            var config = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: datapoint
                }
            };

            var chart = new Chart(ctx, config);
        }
    });

}