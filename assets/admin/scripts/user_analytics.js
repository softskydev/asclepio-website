$(document).ready(function () {
    // load_chart_asclepedia();
    // load_chart_asclepiogo();
    $("#asclepediaSummary").trigger('change');
    $("#asclepiogoSummary").trigger('change');
    $("#year_pedia").trigger('change');
    $("#year_piogo").trigger('change');
    $("#year").trigger('change');
    // load_kelas_asclepedia();
    // load_kelas_asclepiogo();
});

// asclepedia
$("#asclepedia_year").hide();
$("#asclepedia_month").hide();
$("#asclepedia_week").hide();
$("#asclepedia_day").hide();


$("#asclepiogo_year").hide();
$("#asclepiogo_month").hide();
$("#asclepiogo_week").hide();
$("#asclepiogo_day").hide();


function asclepedia(val) {
    if (val == 'year') {
        $("#asclepedia_year").show();
        $("#asclepedia_month").hide();
        $("#asclepedia_week").hide();
        $("#asclepedia_day").hide();
        load_kelas_asclepedia_year();
    } else if (val == 'month') {
        $("#asclepedia_year").hide();
        $("#asclepedia_month").show();
        $("#asclepedia_week").hide();
        $("#asclepedia_day").hide();
        load_kelas_asclepedia_month();
    } else if (val == 'week') {
        $("#asclepedia_year").hide();
        $("#asclepedia_month").hide();
        $("#asclepedia_week").show();
        $("#asclepedia_day").hide();
        load_kelas_asclepedia_week();
    } else {
        $("#asclepedia_year").hide();
        $("#asclepedia_month").hide();
        $("#asclepedia_week").hide();
        $("#asclepedia_day").show();
        load_kelas_asclepedia_day();
    }
}

function asclepiogo(val) {
    if (val == 'year') {
        $("#asclepiogo_year").show();
        $("#asclepiogo_month").hide();
        $("#asclepiogo_week").hide();
        $("#asclepiogo_day").hide();
        load_kelas_asclepiogo_year();
    } else if (val == 'month') {
        $("#asclepiogo_year").hide();
        $("#asclepiogo_month").show();
        $("#asclepiogo_week").hide();
        $("#asclepiogo_day").hide();
        load_kelas_asclepiogo_month();
    } else if (val == 'week') {
        $("#asclepiogo_year").hide();
        $("#asclepiogo_month").hide();
        $("#asclepiogo_week").show();
        $("#asclepiogo_day").hide();
        load_kelas_asclepiogo_week();
    } else {
        $("#asclepiogo_year").hide();
        $("#asclepiogo_month").hide();
        $("#asclepiogo_week").hide();
        $("#asclepiogo_day").show();
        load_kelas_asclepiogo_day();
    }
}


function load_chart_all(year) {
    $.ajax({
        type: "get",
        url: global_url + "User_analytics/chart_all/" + year,
        dataType: "json",
        success: function (response) {
            $("#chart_all").remove();
            $(".box_canvas_all").append("<canvas id='chart_all' width='100%'></canvas>");
            var jsonfile = response;
            var labels = jsonfile.items.map(function (e) {
                return e.label;
            });
            var data = jsonfile.items.map(function (e) {
                return e.data;
            });

            var ctx = document.getElementById('chart_all').getContext('2d');
            var config = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Analisa Peserta',
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
function load_chart_asclepedia(year) {
    $.ajax({
        type: "get",
        url: global_url + "User_analytics/chart_asclepedia/" + year,
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
        url: global_url + "User_analytics/chart_asclepiogo/" + year,
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

function load_kelas_asclepedia_year() {
    $.ajax({
        type: "get",
        url: global_url + "User_analytics/chart_kelas_asclepedia_year",
        dataType: "json",
        success: function (response) {
            $("#asclepedia_year").remove();
            $(".box_kelas_pedia").append("<canvas id='asclepedia_year' width='100%'></canvas>");
            var labels = response.labels;
            var datapoint = response.items;

            console.log(datapoint);


            var ctx = document.getElementById('asclepedia_year').getContext('2d');
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

function load_kelas_asclepedia_month() {
    $.ajax({
        type: "get",
        url: global_url + "User_analytics/chart_kelas_asclepedia_month",
        dataType: "json",
        success: function (response) {
            $("#asclepedia_month").remove();
            $(".box_kelas_pedia").append("<canvas id='asclepedia_month' width='100%'></canvas>");

            var labels = response.labels;
            var datapoint = response.items;

            console.log(datapoint);


            var ctx = document.getElementById('asclepedia_month').getContext('2d');
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
function load_kelas_asclepedia_week() {
    $.ajax({
        type: "get",
        url: global_url + "User_analytics/chart_kelas_asclepedia_week",
        dataType: "json",
        success: function (response) {
            $("#asclepedia_week").remove();
            $(".box_kelas_pedia").append("<canvas id='asclepedia_week' width='100%'></canvas>");

            var labels = response.labels;
            var datapoint = response.items;

            console.log(datapoint);


            var ctx = document.getElementById('asclepedia_week').getContext('2d');
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
function load_kelas_asclepedia_day() {
    $.ajax({
        type: "get",
        url: global_url + "User_analytics/chart_kelas_asclepedia_day",
        dataType: "json",
        success: function (response) {
            $("#asclepedia_day").remove();
            $(".box_kelas_pedia").append("<canvas id='asclepedia_day' width='100%'></canvas>");

            var labels = response.labels;
            var datapoint = response.items;

            console.log(datapoint);


            var ctx = document.getElementById('asclepedia_day').getContext('2d');
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


function load_kelas_asclepiogo_year() {
    $.ajax({
        type: "get",
        url: global_url + "User_analytics/chart_kelas_asclepiogo_year",
        dataType: "json",
        success: function (response) {
            $("#asclepiogo_year").remove();
            $(".box_kelas_piogo").append("<canvas id='asclepiogo_year' width='100%'></canvas>");

            var labels = response.labels;
            var datapoint = response.items;

            console.log(datapoint);


            var ctx = document.getElementById('asclepiogo_year').getContext('2d');
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

function load_kelas_asclepiogo_month() {
    $.ajax({
        type: "get",
        url: global_url + "User_analytics/chart_kelas_asclepiogo_month",
        dataType: "json",
        success: function (response) {

            $("#asclepiogo_month").remove();
            $(".box_kelas_piogo").append("<canvas id='asclepiogo_month' width='100%'></canvas>");

            var labels = response.labels;
            var datapoint = response.items;

            console.log(datapoint);


            var ctx = document.getElementById('asclepiogo_month').getContext('2d');
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
function load_kelas_asclepiogo_week() {
    $.ajax({
        type: "get",
        url: global_url + "User_analytics/chart_kelas_asclepiogo_week",
        dataType: "json",
        success: function (response) {

            $("#asclepiogo_week").remove();
            $(".box_kelas_piogo").append("<canvas id='asclepiogo_week' width='100%'></canvas>");

            var labels = response.labels;
            var datapoint = response.items;

            console.log(datapoint);


            var ctx = document.getElementById('asclepiogo_week').getContext('2d');
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

function load_kelas_asclepiogo_day() {
    $.ajax({
        type: "get",
        url: global_url + "User_analytics/chart_kelas_asclepiogo_day",
        dataType: "json",
        success: function (response) {
            $("#asclepiogo_day").remove();
            $(".box_kelas_piogo").append("<canvas id='asclepiogo_day' width='100%'></canvas>");

            var labels = response.labels;
            var datapoint = response.items;

            console.log(datapoint);


            var ctx = document.getElementById('asclepiogo_day').getContext('2d');
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

// function load_kelas_asclepiogo_week() {
//     $.ajax({
//         type: "get",
//         url: global_url + "User_analytics/chart_kelas_asclepiogo_week",
//         dataType: "json",
//         success: function (response) {
//             $("#asclepiogo_week").remove();
//             $(".box_kelas_pedia").append("<canvas id='asclepiogo_week' width='100%'></canvas>");

//             var labels = response.labels;
//             var datapoint = response.items;

//             console.log(datapoint);


//             var ctx = document.getElementById('asclepiogo_week').getContext('2d');
//             var config = {
//                 type: 'line',
//                 data: {
//                     labels: labels,
//                     datasets: datapoint
//                 }
//             };

//             var chart = new Chart(ctx, config);
//         }
//     });

// }