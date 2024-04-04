<div class="container-fluid">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0"><i class="fa fa-dashboard" aria-hidden="true"></i> BME280 Dashboard </h3>
        <small id="lastest_data_date" style="color:#36b9cc;">Loading...</small>
        <a class="btn btn-primary btn-sm d-none d-sm-inline-block visually-hidden" role="button" href="#"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Generate Report</a>
    </div>
    <div class="row">
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-start-primary py-2 h-100 w-100">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>TEMPERATUE</span></div>
                            <div class="text-dark fw-bold h5 mb-0"><span id="temperature">Loading...</span></div>
                        </div>
                        <div class="col-auto my-auto"><i class="fas fa-temperature-high fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-start-success py-2 h-100 w-100">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-success fw-bold text-xs mb-1"><span>HUMIDITY</span></div>
                            <div class="text-dark fw-bold h5 mb-0"><span id="humidity">Loading...</span></div>
                        </div>
                        <div class="col-auto my-auto"><i class="fas fa-tint fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-start-info py-2 h-100 w-100">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-info fw-bold text-xs mb-1"><span>PRESSER</span></div>
                            <div class="row g-0 align-items-center">
                                <div class="col-auto">
                                    <div class="text-dark fw-bold h5 mb-0 me-3"><span id="pressure">Loading...</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto my-auto"><i class="fas fa-gauge fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-start-warning py-2 h-100 w-100">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span>ALTITUDE</span></div>
                            <div class="text-dark fw-bold h5 mb-0"><span id="altitude">Loading...</span></div>
                        </div>
                        <div class="col-auto my-auto"><i class="fas fa-mountain fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="text-primary fw-bold m-0">
                        Chart Data
                        <!-- Button Toggle Auto Update and select interval -->
                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            <!-- Toggle -->
                            <button type="button" class="btn btn-primary" id="toggleAutoUpdate" onclick="toggleAutoUpdate()"><i class="fas fa-toggle-on"></i> Auto Update On</button>
                        </div>
                    </h6>
                    <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                        <div class="dropdown-menu shadow dropdown-menu-end animated--fade-in">
                            <p class="text-center dropdown-header">dropdown header:</p><a class="dropdown-item" href="#">&nbsp;Action</a><a class="dropdown-item" href="#">&nbsp;Another action</a>
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="#">&nbsp;Something else here</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <!-- Create a live graph with chart.js -->
                        <!-- Create live chart -->
                        <canvas id="myChart" class="h-100 w-100 mx-auto"></canvas>
                        <script>
                            var ctx = document.getElementById('myChart').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: [
                                        <?php
                                        $data_chart = query("SELECT * FROM `sensor-data` ORDER BY `id` DESC LIMIT 10");
                                        while ($data = $data_chart->fetch()) {
                                            // minimize time
                                            $data["time"] = date("H:i:s", strtotime($data["time"]));
                                            echo '"' . $data["time"] . '",';
                                        }
                                        ?>
                                    ],
                                    datasets: [{
                                        label: 'Temperature (°C)',
                                        data: [
                                            <?php
                                            $data_chart = query("SELECT * FROM `sensor-data` ORDER BY `id` DESC LIMIT 10");
                                            while ($data = $data_chart->fetch()) {
                                                echo '"' . $data["temp"] . '",';
                                            }
                                            ?>
                                        ],
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                        ],
                                        borderWidth: 1,
                                        yAxisID: 'temp' // กำหนด ID ของแกน y สำหรับ Temperature
                                    }, {
                                        label: 'Humidity (%)',
                                        data: [
                                            <?php
                                            $data_chart = query("SELECT * FROM `sensor-data` ORDER BY `id` DESC LIMIT 10");
                                            while ($data = $data_chart->fetch()) {
                                                echo '"' . $data["humidity"] . '",';
                                            }
                                            ?>
                                        ],
                                        backgroundColor: [
                                            'rgba(54, 162, 235, 0.2)',
                                        ],
                                        borderColor: [
                                            'rgba(54, 162, 235, 1)',
                                        ],
                                        borderWidth: 1,
                                        yAxisID: 'humidity' // กำหนด ID ของแกน y สำหรับ Temperature
                                    }]
                                },
                                options: {
                                    scales: {
                                        temp: {
                                            type: 'linear',
                                            display: true,
                                            position: 'left',
                                            ticks: {
                                                // °C and set 2 decimal places
                                                callback: function(value, index, values) {
                                                    // set 2 decimal places
                                                    value = value.toFixed(2);
                                                    return value + '°C';
                                                }
                                            },

                                        },
                                        humidity: {
                                            type: 'linear',
                                            display: true,
                                            position: 'right',
                                            grid: {
                                                drawOnChartArea: false, // only want the grid lines for one axis to show up
                                            },
                                            ticks: {
                                                // %
                                                callback: function(value, index, values) {
                                                    // set 2 decimal places
                                                    value = value.toFixed(2);
                                                    return value + '%';
                                                }
                                            },

                                        },
                                    },
                                    maintainAspectRatio: false
                                }
                            });

                            // Auto update
                            var autoUpdate = true;

                            // Toggle auto update
                            function toggleAutoUpdate() {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    }
                                });


                                if (autoUpdate) {
                                    autoUpdate = false;
                                    Toast.fire({
                                        icon: "success",
                                        title: "Auto Update Off"
                                    });
                                    // $.ajax({
                                    //     url: "_api/sendNotify.php",
                                    //     type: "POST",
                                    //     data: {
                                    //         text: "Auto Update Off"
                                    //     },
                                    // });
                                    $("#toggleAutoUpdate").html('<i class="fas fa-toggle-off"></i> Auto Update Off');

                                } else {
                                    autoUpdate = true;
                                    Toast.fire({
                                        icon: "success",
                                        title: "Auto Update On"
                                    });
                                    // $.ajax({
                                    //     url: "_api/sendNotify.php",
                                    //     type: "POST",
                                    //     data: {
                                    //         text: "Auto Update On"
                                    //     },
                                    // });
                                    $("#toggleAutoUpdate").html('<i class="fas fa-toggle-on"></i> Auto Update On');
                                }
                            }

                            var interval;
                            // Select interval
                            function getDataRate(callback) {
                                $.ajax({
                                    url: "_api/getData.php",
                                    type: "GET",
                                    dataType: "json",
                                    success: function(data) {
                                        interval = data.data_rate;
                                        callback(interval);
                                    },
                                    error: function(data) {
                                        // console.log(data);
                                    }
                                });
                            }
                            // Update chart every new data received from database update
                            function updateChart() {
                                $.ajax({
                                    url: "_api/getData.php",
                                    type: "GET",
                                    dataType: "json",
                                    success: function(data) {
                                        // Temperature
                                        myChart.data.datasets[0].data.push(data.temperature);
                                        myChart.data.datasets[0].data.shift();

                                        // Humidity
                                        myChart.data.datasets[1].data.push(data.humidity);
                                        myChart.data.datasets[1].data.shift();

                                        // Time
                                        // Minimize time
                                        data.time = data.time.split(" ")[1];

                                        myChart.data.labels.push(data.time);
                                        myChart.data.labels.shift();

                                        // Update chart
                                        myChart.update();

                                    },
                                    error: function(data) {
                                        // console.log(data);
                                    }
                                });
                            }
                            // Wait for getDataRate() to finish
                            // Use updateChart function
                            getDataRate(function(interval) {
                                setInterval(function() {
                                    if (autoUpdate) {
                                        updateChart();
                                    }
                                }, (interval * 1000));
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Update temperature value every new data received from database update
    function updateSensorData() {
        $.ajax({
            url: "_api/getData.php",
            type: "GET",
            dataType: "json",
            success: function(data) {
                // Compare old data with new data
                // Temperature
                if (data.temperature > data.old_temperature) {
                    var temperatureDiff = (data.temperature - data.old_temperature).toFixed(2);
                    $("#temperature").html(data.temperature + "°C <small class='text-danger'><i class='fa fa-arrow-up' aria-hidden='true'></i> " + temperatureDiff + "°C</small>");
                } else if (data.temperature < data.old_temperature) {
                    var temperatureDiff = (data.old_temperature - data.temperature).toFixed(2);
                    $("#temperature").html(data.temperature + "°C <small class='text-success'><i class='fa fa-arrow-down' aria-hidden='true'></i> " + temperatureDiff + "°C</small>");
                } else {
                    $("#temperature").html(data.temperature + "°C");
                }

                // Humidity
                if (data.humidity > data.old_humidity) {
                    var humidityDiff = (data.humidity - data.old_humidity).toFixed(2);
                    $("#humidity").html(data.humidity + "% <small class='text-danger'><i class='fa fa-arrow-up' aria-hidden='true'></i> " + humidityDiff + "%</small>");
                } else if (data.humidity < data.old_humidity) {
                    var humidityDiff = (data.old_humidity - data.humidity).toFixed(2);
                    $("#humidity").html(data.humidity + "% <small class='text-success'><i class='fa fa-arrow-down' aria-hidden='true'></i> " + humidityDiff + "%</small>");
                } else {
                    $("#humidity").html(data.humidity + "%");
                }

                // Pressure
                if (data.pressure > data.old_pressure) {
                    var pressureDiff = (data.pressure - data.old_pressure).toFixed(2);
                    $("#pressure").html(data.pressure + "hPa <small class='text-danger'><i class='fa fa-arrow-up' aria-hidden='true'></i> " + pressureDiff + "hPa</small>");
                } else if (data.pressure < data.old_pressure) {
                    var pressureDiff = (data.old_pressure - data.pressure).toFixed(2);
                    $("#pressure").html(data.pressure + "hPa <small class='text-success'><i class='fa fa-arrow-down' aria-hidden='true'></i> " + pressureDiff + "hPa</small>");
                } else {
                    $("#pressure").html(data.pressure + "hPa");
                }

                // Altitude
                if (data.altitude > data.old_altitude) {
                    var altitudeDiff = (data.altitude - data.old_altitude).toFixed(2);
                    $("#altitude").html(data.altitude + "m <small class='text-danger'><i class='fa fa-arrow-up' aria-hidden='true'></i> " + altitudeDiff + "m</small>");
                } else if (data.altitude < data.old_altitude) {
                    var altitudeDiff = (data.old_altitude - data.altitude).toFixed(2);
                    $("#altitude").html(data.altitude + "m <small class='text-success'><i class='fa fa-arrow-down' aria-hidden='true'></i> " + altitudeDiff + "m</small>");
                } else {
                    $("#altitude").html(data.altitude + "m");
                }

                $("#lastest_data_date").html("ข้อมูลเซนเซอร์ล่าสุด: " + data.time);
            },
            error: function(data) {
                // console.log(data);
            }
        });
    }

    // Use updateTemperature function every 3 second
    setInterval(updateSensorData, 1000);
</script>