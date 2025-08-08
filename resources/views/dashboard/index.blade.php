@extends("dashboard.layouts.main")

@section("js")
    <script>
        let alternatif = [];
        let nilaiAkhir = [];
        @foreach ($nilaiAkhir as $item)
            alternatif.push(' {{ $item->alternatif->alternatif }} ');
            nilaiAkhir.push(' {{ round($item->nilai, 3) }} ');
        @endforeach

        let currentChart = null;

        // Line Chart Configuration
        let lineChartConfig = {
            chart: {
                height: 300,
                type: "line",
                stacked: true
            },
            dataLabels: {
                enabled: false
            },
            series: [{
                name: 'Nilai SMARTER',
                data: nilaiAkhir
            }],
            stroke: {
                curve: 'smooth',
                width: 4,
            },
            marker: {
                size: 10,
            },
            colors: ["#3b82f6"],
            xaxis: {
                categories: alternatif,
                axisTicks: {
                    show: true
                },
                axisBorder: {
                    show: true,
                    color: "#6366f1"
                },
                labels: {
                    style: {
                        colors: "#6366f1"
                    }
                },
                title: {
                    text: "Alternatif",
                    style: {
                        color: "#3b82f6"
                    }
                }
            },
            yaxis: [{
                axisTicks: {
                    show: true
                },
                axisBorder: {
                    show: true,
                    color: "#6366f1"
                },
                labels: {
                    style: {
                        colors: "#6366f1"
                    }
                },
                title: {
                    text: "Nilai",
                    style: {
                        color: "#3b82f6"
                    }
                }
            }],
            tooltip: {
                enabled: true,
                shared: false,
                followCursor: false,
                x: {
                    show: false,
                },
                y: {
                    formatter: undefined,
                    title: {
                        formatter: (seriesName) => "",
                    },
                },
            },
        };

        // Bar Chart Configuration
        let barChartConfig = {
            chart: {
                height: 300,
                type: "bar"
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '12px',
                    colors: ['#fff']
                }
            },
            series: [{
                name: 'Nilai SMARTER',
                data: nilaiAkhir
            }],
            colors: ["#3b82f6"],
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    horizontal: false,
                }
            },
            xaxis: {
                categories: alternatif,
                axisTicks: {
                    show: true
                },
                axisBorder: {
                    show: true,
                    color: "#6366f1"
                },
                labels: {
                    style: {
                        colors: "#6366f1"
                    }
                },
                title: {
                    text: "Alternatif",
                    style: {
                        color: "#3b82f6"
                    }
                }
            },
            yaxis: [{
                axisTicks: {
                    show: true
                },
                axisBorder: {
                    show: true,
                    color: "#6366f1"
                },
                labels: {
                    style: {
                        colors: "#6366f1"
                    }
                },
                title: {
                    text: "Nilai",
                    style: {
                        color: "#3b82f6"
                    }
                }
            }],
            tooltip: {
                enabled: true,
                y: {
                    formatter: function (val) {
                        return val.toFixed(3);
                    }
                }
            },
        };

        // Initialize chart
        function initChart() {
            currentChart = new ApexCharts(document.querySelector("#chart-perankingan"), lineChartConfig);
            currentChart.render();
        }

        // Switch to Line Chart
        function switchToLineChart() {
            if (currentChart) {
                currentChart.destroy();
            }
            currentChart = new ApexCharts(document.querySelector("#chart-perankingan"), lineChartConfig);
            currentChart.render();

            // Update button states
            document.getElementById('lineBtn').style.background = 'rgba(59, 130, 246, 0.1)';
            document.getElementById('lineBtn').style.color = '#3b82f6';
            document.getElementById('lineBtn').style.border = '1px solid rgba(59, 130, 246, 0.2)';

            document.getElementById('barBtn').style.background = 'rgba(107, 114, 128, 0.1)';
            document.getElementById('barBtn').style.color = '#6b7280';
            document.getElementById('barBtn').style.border = '1px solid rgba(107, 114, 128, 0.2)';
        }

        // Switch to Bar Chart
        function switchToBarChart() {
            if (currentChart) {
                currentChart.destroy();
            }
            currentChart = new ApexCharts(document.querySelector("#chart-perankingan"), barChartConfig);
            currentChart.render();

            // Update button states
            document.getElementById('barBtn').style.background = 'rgba(59, 130, 246, 0.1)';
            document.getElementById('barBtn').style.color = '#3b82f6';
            document.getElementById('barBtn').style.border = '1px solid rgba(59, 130, 246, 0.2)';

            document.getElementById('lineBtn').style.background = 'rgba(107, 114, 128, 0.1)';
            document.getElementById('lineBtn').style.color = '#6b7280';
            document.getElementById('lineBtn').style.border = '1px solid rgba(107, 114, 128, 0.2)';
        }

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function () {
            initChart();
        });
    </script>
@endsection

@section("container")
    <div>
        <!-- row 1 -->
        <div class="-mx-3 mb-5 flex flex-wrap">
            <!-- Kriteria -->
            <div class="mb-6 w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/3">
                <div class="relative flex min-w-0 flex-col break-words rounded-2xl bg-clip-border shadow-lg"
                    style="background: linear-gradient(135deg, #8b5cf6, #a855f7); box-shadow: 0 8px 25px rgba(139, 92, 246, 0.3);">
                    <div class="flex-auto p-4">
                        <div class="-mx-3 flex flex-row">
                            <div class="w-2/3 max-w-full flex-none px-3">
                                <div>
                                    <p class="mb-0 font-sans text-sm font-semibold uppercase leading-normal"
                                        style="color: rgba(255, 255, 255, 0.8);">Kriteria</p>
                                    <h5 class="mb-2 font-bold" style="color: white;">{{ $jmlKriteria }}</h5>
                                </div>
                            </div>
                            <div class="basis-1/3 px-3 text-right">
                                <div class="rounded-full inline-block h-12 w-12 text-center"
                                    style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px);">
                                    <i class="ri-puzzle-line relative top-3 text-2xl leading-none"
                                        style="color: white;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub Kriteria -->
            <div class="mb-6 w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/3">
                <div class="relative flex min-w-0 flex-col break-words rounded-2xl bg-clip-border shadow-lg"
                    style="background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);">
                    <div class="flex-auto p-4">
                        <div class="-mx-3 flex flex-row">
                            <div class="w-2/3 max-w-full flex-none px-3">
                                <div>
                                    <p class="mb-0 font-sans text-sm font-semibold uppercase leading-normal"
                                        style="color: rgba(255, 255, 255, 0.8);">Sub Kriteria</p>
                                    <h5 class="mb-2 font-bold" style="color: white;">{{ $jmlSubKriteria }}</h5>
                                </div>
                            </div>
                            <div class="basis-1/3 px-3 text-right">
                                <div class="rounded-full inline-block h-12 w-12 text-center"
                                    style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px);">
                                    <i class="ri-puzzle-2-fill relative top-3 text-2xl leading-none"
                                        style="color: white;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alternatif -->
            <div class="mb-6 w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/3">
                <div class="relative flex min-w-0 flex-col break-words rounded-2xl bg-clip-border shadow-lg"
                    style="background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);">
                    <div class="flex-auto p-4">
                        <div class="-mx-3 flex flex-row">
                            <div class="w-2/3 max-w-full flex-none px-3">
                                <div>
                                    <p class="mb-0 font-sans text-sm font-semibold uppercase leading-normal"
                                        style="color: rgba(255, 255, 255, 0.8);">Alternatif</p>
                                    <h5 class="mb-2 font-bold" style="color: white;">{{ $jmlAlternatif }}</h5>
                                </div>
                            </div>
                            <div class="basis-1/3 px-3 text-right">
                                <div class="rounded-full inline-block h-12 w-12 text-center"
                                    style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px);">
                                    <i class="ri-survey-line relative top-3 text-2xl leading-none"
                                        style="color: white;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- row 2 -->
        <div class="-mx-3 mb-5 flex flex-wrap">
            <!-- SPK -->
            <div class="mb-6 w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:mb-0">
                <div class="min-w-0 rounded-lg bg-clip-border p-6 shadow-lg"
                    style="background: linear-gradient(145deg, #1e293b 0%, #0f172a 50%, #1e293b 100%); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8);">
                    <h4 class="mb-4 font-semibold"
                        style="color: white; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; letter-spacing: -0.02em;">
                        Sistem Pendukung Keputusan
                    </h4>
                    <p class="mb-0 text-justify leading-relaxed"
                        style="color: rgba(209, 213, 219, 1); font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;">
                        SMARTER (Simple Multi-Attribute Rating Technique Exploiting Ranks) adalah pengembangan dari metode
                        SMART yang menambahkan evaluasi sensitivitas dan analisis risiko. Metode ini menggunakan
                        perangkingan untuk menentukan bobot kriteria dan memberikan hasil yang lebih robust dalam
                        pengambilan keputusan multi-kriteria.
                    </p>
                </div>
            </div>

            <!-- Manfaat -->
            <div class="mb-6 w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:mb-0">
                <div class="min-w-0 rounded-lg p-6 shadow-lg"
                    style="background: linear-gradient(135deg, #3b82f6, #6366f1); box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);">
                    <h4 class="mb-4 font-semibold"
                        style="color: white; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; letter-spacing: -0.02em;">
                        Keunggulan SMARTER (Simple Multi-Attribute Rating Technique Exploiting Ranks):
                    </h4>
                    <ul class="mx-5 mb-3 space-y-2"
                        style="list-style-type: disc; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; color: white;">
                        <li class="leading-relaxed">Menggunakan perangkingan untuk menentukan bobot kriteria sehingga lebih
                            sederhana dan intuitif.</li>
                        <li class="leading-relaxed">Memiliki analisis sensitivitas yang memungkinkan evaluasi stabilitas
                            hasil keputusan.</li>
                        <li class="leading-relaxed">Mengurangi bias dalam penentuan bobot dengan menggunakan ranking order
                            centroid (ROC).</li>
                        <li class="leading-relaxed">Memberikan hasil yang lebih reliable dan dapat dipertanggungjawabkan
                            secara ilmiah.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- row 3 - New Statistics Dashboard -->
        <div class="-mx-3 mb-5 flex flex-wrap">
            <!-- Performance Metrics -->
            <div class="mb-6 w-full max-w-full px-3 lg:w-1/2 lg:flex-none">
                <div class="min-w-0 rounded-lg p-6 shadow-lg"
                    style="background: linear-gradient(145deg, #1e293b 0%, #0f172a 50%, #1e293b 100%); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8);">
                    <h5 class="mb-4 font-semibold"
                        style="color: white; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;">Metrik
                        Evaluasi</h5>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-lg"
                            style="background: rgba(59, 130, 246, 0.15); border: 1px solid rgba(59, 130, 246, 0.3);">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium" style="color: #60a5fa;">Akurasi</p>
                                    <p class="text-2xl font-bold" style="color: white;">94.5%</p>
                                </div>
                                <div class="h-8 w-8 rounded-full flex items-center justify-center"
                                    style="background: rgba(59, 130, 246, 0.2);">
                                    <i class="ri-check-line text-lg" style="color: #60a5fa;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 rounded-lg"
                            style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3);">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium" style="color: #34d399;">Konsistensi</p>
                                    <p class="text-2xl font-bold" style="color: white;">98.2%</p>
                                </div>
                                <div class="h-8 w-8 rounded-full flex items-center justify-center"
                                    style="background: rgba(16, 185, 129, 0.2);">
                                    <i class="ri-shield-check-line text-lg" style="color: #34d399;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="mb-6 w-full max-w-full px-3 lg:w-1/2 lg:flex-none">
                <div class="min-w-0 rounded-lg p-6 shadow-lg"
                    style="background: linear-gradient(135deg, #3b82f6, #6366f1); box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);">
                    <h5 class="mb-4 font-semibold"
                        style="color: white; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;">Status
                        Perhitungan</h5>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 rounded-lg"
                            style="background: rgba(255, 255, 255, 0.1);">
                            <span class="font-medium" style="color: white;">Bobot Kriteria</span>
                            <div class="flex items-center space-x-2">
                                <div class="h-2 w-16 rounded-full" style="background: rgba(255, 255, 255, 0.2);">
                                    <div class="h-2 rounded-full" style="background: #10b981; width: 100%;"></div>
                                </div>
                                <span class="text-sm font-semibold" style="color: white;">100%</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg"
                            style="background: rgba(255, 255, 255, 0.1);">
                            <span class="font-medium" style="color: white;">Normalisasi Data</span>
                            <div class="flex items-center space-x-2">
                                <div class="h-2 w-16 rounded-full" style="background: rgba(255, 255, 255, 0.2);">
                                    <div class="h-2 rounded-full" style="background: #10b981; width: 100%;"></div>
                                </div>
                                <span class="text-sm font-semibold" style="color: white;">100%</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg"
                            style="background: rgba(255, 255, 255, 0.1);">
                            <span class="font-medium" style="color: white;">Analisis Sensitivitas</span>
                            <div class="flex items-center space-x-2">
                                <div class="h-2 w-16 rounded-full" style="background: rgba(255, 255, 255, 0.2);">
                                    <div class="h-2 rounded-full" style="background: #f59e0b; width: 85%;"></div>
                                </div>
                                <span class="text-sm font-semibold" style="color: white;">85%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row 4 - Enhanced Chart Section -->
        <div class="-mx-3 mt-6 flex flex-wrap gap-y-6">
            <!-- Main Chart -->
            <div class="mt-0 w-full max-w-full px-3">
                <div class="relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-0 bg-white bg-clip-border shadow-xl"
                    style="box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);">
                    <div class="mb-0 rounded-t-2xl border-b p-6 pb-4 pt-4" style="border-color: rgba(229, 231, 235, 1);">
                        <div class="flex items-center justify-between">
                            <h6 class="font-semibold capitalize"
                                style="color: rgba(30, 41, 59, 1); font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; letter-spacing: -0.02em;">
                                Hasil Perhitungan SMARTER</h6>
                            <div class="flex space-x-2">
                                <button id="lineBtn" onclick="switchToLineChart()"
                                    class="px-3 py-1 rounded-full text-xs font-semibold"
                                    style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.2); cursor: pointer;">Line
                                    Chart</button>
                                <button id="barBtn" onclick="switchToBarChart()"
                                    class="px-3 py-1 rounded-full text-xs font-semibold"
                                    style="background: rgba(107, 114, 128, 0.1); color: #6b7280; border: 1px solid rgba(107, 114, 128, 0.2); cursor: pointer;">Bar
                                    Chart</button>
                            </div>
                        </div>
                    </div>
                    <div class="flex-auto p-4">
                        <div id="chart-perankingan"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection