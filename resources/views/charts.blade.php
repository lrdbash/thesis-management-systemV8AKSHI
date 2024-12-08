<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://d3js.org/d3.v5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3-cloud/1.2.5/d3.layout.cloud.min.js"></script>
    <style>
        @font-face {
            font-family: 'Lexie';
            src: url('fonts/Lexie-Regular.woff2') format('woff2'),
                 url('fonts/Lexie-Regular.woff') format('woff'),
                 url('fonts/Lexie-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        body {
            background-color: #f8f9fa;
            font-family: 'Lexie', sans-serif;
        }
        .navbar {
            background-color: #014a7f; /* Strathmore Blue */
        }
        .navbar a {
            color: white;
        }
        .content-section {
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            background-color: white;
            margin-top: 20px;
        }
        .metrics {
            list-style: none;
            padding: 0;
            margin-top: 20px;
            background-color: #e9ecef;
            border-radius: 5px;
            padding: 15px;
        }
        .metrics li {
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        .metrics li:last-child {
            border-bottom: none;
        }
        canvas {
            margin: 20px 0;
        }
        .nav-link.active {
            background-color: #cc0000; /* Strathmore Red */
            color: white;
        }
        #sidebar {
            background-color: #014a7f;
            min-height: 100vh;
            padding-top: 20px;
        }
        #sidebar .nav-link {
            color: white;
        }
        #sidebar .nav-link:hover {
            background-color: #cc0000;
        }
        .kpi-card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.3s ease-in-out;
        }
        .kpi-card:hover {
            transform: translateY(-5px);
        }
        .kpi-title {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 10px;
        }
        .kpi-value {
            font-size: 2rem;
            font-weight: bold;
            color: #014a7f;
        }
    </style>
    <script type="text/javascript">
        function showDiv1() {
            document.getElementById('div1').style.display = 'block';
            document.getElementById('div2').style.display = 'none';
        }
                function showDiv2() {
            document.getElementById('div2').style.display = 'block';
            document.getElementById('div1').style.display = 'none';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/anychart/dist/js/anychart-bundle.min.js"></script>
  <script src='https://cdn.plot.ly/plotly-2.35.2.min.js'></script>
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" onclick="showContent('landing')">
                                Landing Page
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showContent('programs')">
                                Program/Course Info
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showContent('students')">
                                Student Info
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showContent('examiners')">
                                Examiner Info
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}" >
                                Go Home
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Administrator Analytics</h1>
                </div>

                <div id="landing" class="content-section">
                    <h3>Overall Analytics</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="kpi-card" onclick="showDiv1();">
                                <div class="kpi-title">Total Enrolled</div>
                                <div class="kpi-value">1,200</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="kpi-card">
                                <div class="kpi-title">Total Courses</div>
                                <div class="kpi-value">150</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="kpi-card">
                                <div class="kpi-title">Total Professors</div>
                                <div class="kpi-value">200</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="kpi-card" onclick="showDiv2();">
                                <div class="kpi-title">Total Thesis</div>
                                <div class="kpi-value">1,000</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="kpi-card">
                                <div class="kpi-title">Total Approved</div>
                                <div class="kpi-value">800</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="kpi-card">
                                <div class="kpi-title">Total Rejected</div>
                                <div class="kpi-value">200</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="display: none;" id="div1">
                            <canvas id="enrolledStudents"></canvas>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="display: none;" id="div2">
                            <canvas id="thesisTopics"></canvas>
                        </div>
                    </div>
                </div>

                <div id="programs" class="content-section" style="display:none;">
                    <h3>Program/Course Information</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="studentsPerProgram1"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="thesisPerProgram1"></canvas>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="programStatus"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="approvedDisapprovedThesis"></canvas>
                        </div>
                    </div>
                </div>

                <div id="students" class="content-section" style="display:none;">
                    <h3>Student Information</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="progressTracking"></canvas>
                        </div>
                                                <div class="col-md-6">
                            <canvas id="passedFailed"></canvas>
                        </div>
                    </div>
                    <div class="row">
                        <h4>Word Cloud (2023-2024)</h4>
                        <br>
                        <div class="col-md-12">
                            <div id="wordCloud"></div>
                        </div>
                    </div>
                </div>

                <div id="examiners" class="content-section" style="display:none;">
                    <h3>Examiner/Professor Information</h3>
<div class="row" style="display: flex; justify-content: center;">
  <div class="col-md-12" style="display: flex; justify-content: center;">
    <div id="myDiv" style="width: 80%;"></div>
  </div>
</div>

                    <div class="row">
                                                <div class="col-md-6">
                            <canvas id="examinerDuration"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="responseTime"></canvas>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
   <script>
    function showContent(section) {
    document.querySelectorAll('.nav-link').forEach(function(link) {
        link.classList.remove('active');
    });

    document.querySelector(`.nav-link[onclick="showContent('${section}')"]`).classList.add('active');

    document.querySelectorAll('.content-section').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById(section).style.display = 'block';
}

    fetch('/treemap-data')
    .then(response => response.json())
    .then(data => {
        // Log the data to check its structure
        console.log('Treemap Data:', data);
        
        if (!Array.isArray(data)) {
            throw new Error("Expected an array of data for the treemap.");
        }

        let treemapLabels = data.map(item => item.label);
        let treemapParents = data.map(item => item.parent);
        let treemapValues = data.map(item => item.value);

        // Ensure data consistency
        if (treemapLabels.length !== treemapParents.length || treemapLabels.length !== treemapValues.length) {
            throw new Error("Data arrays do not match in length.");
        }

        // Plot the treemap
        Plotly.newPlot('myDiv', [{
            type: "treemap",
            labels: treemapLabels,
            parents: treemapParents,
            values: treemapValues,
            textinfo: "value Allocated",
            outsidetextfont: {"size": 20, "color": "#377eb8"},
            marker: {"line": {"width": 2}},
            pathbar: {"visible": false}
        }], {
            title: "Thesis Allocation by Year and Examiner (2023-2024)",
            width: 1200,
            height: 600
        }).catch(err => {
            console.error('Error rendering treemap:', err);
        });
    })
    .catch(error => {
        console.error('Error fetching data:', error);
    });


    // Word cloud data
// Fetch the word cloud data from the backend
fetch('/word-cloud-data')
    .then(response => response.json())
    .then(data => {
        // Process data into the format required for the word cloud
        const wordCloudData = data.map(item => ({
            word: item.word,
            value: item.value
        }));

        // Word cloud rendering setup
        const width = 900;
        const height = 600;

        const svg = d3.select('#wordCloud')
            .append('svg')
            .attr('width', width)
            .attr('height', height);

        const layout = d3.layout.cloud()
            .size([width, height])
            .words(wordCloudData.map(d => ({text: d.word, size: d.value})))
            .padding(5)
            .rotate(() => ~~(Math.random() * 2) * 90)
            .fontSize(d => d.size)
            .on('end', draw);

        layout.start();

        function draw(words) {
            svg.append('g')
                .attr('transform', `translate(${width / 2},${height / 2})`)
                .selectAll('text')
                .data(words)
                .enter().append('text')
                .style('font-size', d => d.size + 'px')
                .style('font-family', 'Impact')
                .style('fill', () => {
                    const colors = ['#007bff', '#0056b3', '#cc0000', '#dc3545'];
                    return colors[Math.floor(Math.random() * colors.length)];
                })
                .attr('text-anchor', 'middle')
                .attr('transform', d => `translate(${d.x},${d.y})rotate(${d.rotate})`)
                .text(d => d.text);
        }
    })
    .catch(error => console.error('Error fetching word cloud data:', error));

// Utility function to generate random colors
function generateRandomColors(count) {
    return Array.from({length: count}, () => 'hsl(' + (Math.random() * 360) + ', 70%, 50%)');
}

        // Utility function to generate random data
        function generateRandomData(count, min, max) {
            return Array.from({length: count}, () => Math.floor(Math.random() * (max - min + 1)) + min);
        }

// Initialize Chart.js colors and defaults
const CHART_COLORS = {
    red: 'rgba(255, 99, 132, 0.8)',
    blue: 'rgba(54, 162, 235, 0.8)',
    green: 'rgba(75, 192, 192, 0.8)',
    orange: 'rgba(255, 159, 64, 0.8)',
    purple: 'rgba(153, 102, 255, 0.8)'
};

// Function to create charts with error handling
function createChart(canvasId, type, data, options = {}) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) {
        console.error(`Canvas element with id '${canvasId}' not found`);
        return null;
    }

    // Add willReadFrequently attribute to address the warning
    const ctx = canvas.getContext('2d', { willReadFrequently: true });

    try {
        return new Chart(ctx, {
            type: type,
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: options.title || '',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    },
                    legend: {
                        position: 'bottom'
                    }
                },
                ...options
            }
        });
    } catch (error) {
        console.error(`Error creating chart ${canvasId}:`, error);
        return null;
    }
}

// Function to render all charts
function renderCharts(chartData) {
    try {
        // Enrolled Students Chart
        createChart('enrolledStudents', 'bar', {
            labels: chartData.enrolledStudents.labels,
            datasets: [{
                label: 'Enrolled Students',
                data: chartData.enrolledStudents.datasets[0].data,
                backgroundColor: CHART_COLORS.blue
            }]
        }, {
            title: 'Enrolled Students per Program (2023-2024)',
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Students'
                    }
                }
            }
        });

        // Passed vs Failed Students Chart
        createChart('passedFailed', 'bar', {
            labels: chartData.passedFailed.labels,
            datasets: [{
                label: 'Passed Students',
                data: chartData.passedFailed.datasets[0].passed,
                backgroundColor: '#28a745',  // Green for Passed
                borderColor: '#218838',
                borderWidth: 1
            }, {
                label: 'Failed Students',
                data: chartData.passedFailed.datasets[0].failed,
                backgroundColor: '#dc3545',  // Red for Failed
                borderColor: '#c82333',
                borderWidth: 1
            }]
        }, {
            title: 'Students Passed vs Failed (2023-2024)',
            plugins: {
                title: {
                    display: true,
                    text: 'Students Passed vs Failed (2023-2024)'
                }
            }
        });

        // Thesis Topics Chart
        createChart('thesisTopics', 'bar', {
            labels: chartData.thesisTopics.labels,
            datasets: [{
                label: 'Thesis Topics',
                data: chartData.thesisTopics.datasets[0].data,
                backgroundColor: CHART_COLORS.red
            }]
        }, {
            title: 'Thesis Topics per Program (2023-2024)'
        });

        // Thesis per Program Chart
        createChart('thesisPerProgram', 'bar', {
            labels: chartData.thesisPerProgram.labels,
            datasets: [{
                label: 'Thesis per Program',
                data: chartData.thesisPerProgram.datasets[0].data,
                backgroundColor: CHART_COLORS.orange
            }]
        }, {
            title: 'Thesis per Program (2023-2024)'
        });

        // Students per Program Chart
        createChart('studentsPerProgram', 'bar', {
            labels: chartData.studentsPerProgram.labels,
            datasets: [{
                label: 'Students per Program',
                data: chartData.studentsPerProgram.datasets[0].data,
                backgroundColor: CHART_COLORS.green
            }]
        }, {
            title: 'Students per Program (2023-2024)'
        });

        // Program Status Chart
        createChart('programStatus', 'pie', {
            labels: chartData.programStatus.labels,
            datasets: [{
                data: chartData.programStatus.datasets[0].data,
                backgroundColor: [CHART_COLORS.green, CHART_COLORS.red]
            }]
        }, {
            title: 'Program Status (2023-2024)'
        });

        // Thesis per Program Chart
        createChart('thesisPerProgram1', 'bar', {
            labels: chartData.thesisPerProgram1.labels,
            datasets: [{
                label: 'Thesis per Program',
                data: chartData.thesisPerProgram1.datasets[0].data,
                backgroundColor: CHART_COLORS.orange
            }]
        }, {
            title: 'Thesis per Program (2023-2024)'
        });

        // Students per Program Chart
        createChart('studentsPerProgram1', 'bar', {
            labels: chartData.studentsPerProgram1.labels,
            datasets: [{
                label: 'Students per Program',
                data: chartData.studentsPerProgram1.datasets[0].data,
                backgroundColor: CHART_COLORS.green
            }]
        }, {
            title: 'Students per Program (2023-2024)'
        });  

        // Approved/Disapproved Thesis Chart
        createChart('approvedDisapprovedThesis', 'bar', {
            labels: chartData.approvedDisapprovedThesis.labels,
            datasets: chartData.approvedDisapprovedThesis.datasets
        }, {
            title: 'Approved and Disapproved Thesis per Program (2023-2024)',
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    stacked: true,
                    beginAtZero: true
                }
            }
        });

        // Examiner Duration Chart
        createChart('examinerDuration', 'pie', {
            labels: chartData.examinerDuration.labels,
            datasets: [{
                data: chartData.examinerDuration.datasets[0].data,
                backgroundColor: Object.values(CHART_COLORS)
            }]
        }, {
            title: 'Examiner Duration (2023-2024)'
        });

        // Response Time Chart
        createChart('responseTime', 'line', {
            labels: chartData.responseTime.labels,
            datasets: [{
                label: 'Average Response Time (hours)',
                data: chartData.responseTime.datasets[0].data,
                borderColor: CHART_COLORS.purple,
                tension: 0.1,
                fill: false
            }]
        }, {
            title: 'Professor Response Time (2023-2024)',
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Hours'
                    }
                }
            }
        });

        // Progress Tracking Chart
        createChart('progressTracking', 'bar', {
            labels: chartData.progressTracking.labels,
            datasets: [{
                label: 'Progress Tracking',
                data: chartData.progressTracking.datasets[0].data,
                backgroundColor: CHART_COLORS.purple
            }]
        }, {
            title: 'Progress Tracking (2023-2024)',
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Students'
                    }
                }
            }
        });

    } catch (error) {
        console.error('Error rendering charts:', error);
        document.querySelectorAll('canvas').forEach(canvas => {
            if (canvas) {
                canvas.insertAdjacentHTML('beforebegin', 
                    '<div class="error-message" style="color: red; text-align: center;">Error rendering charts</div>'
                );
            }
        });
    }
}

// Helper function to generate random colors (if needed)
function generateRandomColors(count) {
    const colors = [];
    for (let i = 0; i < count; i++) {
        const color = `hsla(${Math.random() * 360}, 70%, 50%, 0.8)`;
        colors.push(color);
    }
    return colors;
}

// Initialize charts when DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Fetch data from Laravel backend
    fetch('/programs')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Process the data for the charts
            const chartData = {
                enrolledStudents: {
                    labels: data.map(item => item.name),
                    datasets: [{
                        data: data.map(item => item.enrolled_students)
                    }]
                },
                passedFailed: {
                    labels: data.map(item => item.name),
                    datasets: [{
                        passed: data.map(item => item.passed_students),
                        failed: data.map(item => item.failed_students)
                    }]
                },
                thesisTopics: {
                    labels: data.map(item => item.name),
                    datasets: [{
                        data: data.map(item => item.thesis_topics)
                    }]
                },
                thesisPerProgram: {
                    labels: data.map(item => item.name),
                    datasets: [{
                        data: data.map(item => item.thesis_topics)
                    }]
                },
                studentsPerProgram: {
                    labels: data.map(item => item.name),
                    datasets: [{
                        data: data.map(item => item.students_count)
                    }]
                },
                                                thesisPerProgram1: {
                    labels: data.map(item => item.name),
                    datasets: [{
                        data: data.map(item => item.thesis_topics)
                    }]
                },
                studentsPerProgram1: {
                    labels: data.map(item => item.name),
                    datasets: [{
                        data: data.map(item => item.students_count)
                    }]
                },
                programStatus: {
                    labels: ['Active', 'Inactive'],
                    datasets: [{
                        data: [15, 6] // Sample data - adjust as needed
                    }]
                },
                approvedDisapprovedThesis: {
                    labels: data.map(item => item.name),
                    datasets: [
                        {
                            label: 'Approved',
                            data: data.map(item => item.approved_theses),
                            backgroundColor: CHART_COLORS.green
                        },
                        {
                            label: 'Disapproved',
                            data: data.map(item => item.disapproved_theses),
                            backgroundColor: CHART_COLORS.red
                        }
                    ]
                },
                examinerDuration: {
                    labels: ['0-2 years', '2-5 years', '5-10 years', '10+ years'],
                    datasets: [{
                        data: [
                            data.reduce((sum, item) => sum + item.examiner_duration_0_2, 0),
                            data.reduce((sum, item) => sum + item.examiner_duration_2_5, 0),
                            data.reduce((sum, item) => sum + item.examiner_duration_5_10, 0),
                            data.reduce((sum, item) => sum + item.examiner_duration_10_plus, 0)
                        ]
                    }]
                },
                responseTime: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        data: data.map(item => item.average_response_time)
                    }]
                },
                progressTracking: {
                    labels: data.map(item => item.name),
                    datasets: [{
                        label: 'Progress Tracking',
                        data: data.map(item => item.enrolled_students),
                        backgroundColor: CHART_COLORS.purple
                    }]
                }
            };

            // Render all charts
            renderCharts(chartData);
        })
        .catch(error => {
            console.error('Error fetching program data:', error);
            document.querySelectorAll('canvas').forEach(canvas => {
                if (canvas) {
                    canvas.insertAdjacentHTML('beforebegin', 
                        '<div class="error-message" style="color: red; text-align: center;">Error loading chart data</div>'
                    );
                }
            });
        });
});



    </script>
</body>
</html>
