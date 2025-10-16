@extends('layouts.app')

@section('content')
@php
    $spentPercent = $totalBudget > 0 ? round(($totalSpent / $totalBudget) * 100) : 0;
    $remainingPercent = 100 - $spentPercent;
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 text-center">
    <!-- Total Budget -->
    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-2">Total Budget</h3>
        <div class="relative w-28 h-28 mx-auto">
            <canvas id="budgetCircle" width="112" height="112"></canvas>
            <div class="absolute inset-0 flex items-center justify-center text-indigo-600 dark:text-indigo-300 font-bold text-lg">
                100%
            </div>
        </div>
        <p class="mt-4 text-indigo-600 dark:text-indigo-300 font-bold text-lg">
            ₱{{ number_format($totalBudget, 2) }}
        </p>
    </div>

    <!-- Total Spent -->
    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-2">Total Spent</h3>
        <div class="relative w-28 h-28 mx-auto">
            <canvas id="spentCircle" width="112" height="112"></canvas>
            <div class="absolute inset-0 flex items-center justify-center text-red-600 dark:text-red-300 font-bold text-lg">
                {{ $spentPercent }}%
            </div>
        </div>
        <p class="mt-4 text-red-600 dark:text-red-300 font-bold text-lg">
            ₱{{ number_format($totalSpent, 2) }}
        </p>
    </div>

    <!-- Remaining -->
    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-2">Remaining</h3>
        <div class="relative w-28 h-28 mx-auto">
            <canvas id="remainingCircle" width="112" height="112"></canvas>
            <div class="absolute inset-0 flex items-center justify-center text-green-600 dark:text-green-300 font-bold text-lg">
                {{ $remainingPercent }}%
            </div>
        </div>
        <p class="mt-4 text-green-600 dark:text-green-300 font-bold text-lg">
            ₱{{ number_format($totalBudget - $totalSpent, 2) }}
        </p>
    </div>
</div>

<!-- Chart Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
        <h4 class="font-semibold text-gray-800 dark:text-white mb-2">Monthly Expense Trend</h4>
        <canvas id="monthlyTrendChart"></canvas>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
        <h4 class="font-semibold text-gray-800 dark:text-white mb-2">Budget vs. Actual</h4>
        <canvas id="budgetBarChart"></canvas>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
        <h4 class="font-semibold text-gray-800 dark:text-white mb-2">Category Breakdown</h4>
        <canvas id="categoryPieChart"></canvas>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
        <h4 class="font-semibold text-gray-800 dark:text-white mb-2">Top 5 Categories</h4>
        <canvas id="topCategoriesChart"></canvas>
    </div>
</div>

<!-- Export Buttons -->
<div class="mt-8 text-right space-x-2">
    <button onclick="exportPDF()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Export PDF</button>
    <button onclick="exportCSV()" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Export CSV</button>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    const chartData = @json($chartData);
    const categoryData = @json($categoryBreakdown);
    const top5Data = @json($topCategories);

    // Circular progress chart helper
    const makeCircle = (elementId, percent, color) => {
        new Chart(document.getElementById(elementId), {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [percent, 100 - percent],
                    backgroundColor: [color, '#e5e7eb'],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '75%',
                plugins: { legend: { display: false }, tooltip: { enabled: false } },
                responsive: false
            }
        });
    };

    makeCircle('budgetCircle', 100, '#4f46e5');
    makeCircle('spentCircle', {{ $spentPercent }}, '#dc2626');
    makeCircle('remainingCircle', {{ $remainingPercent }}, '#16a34a');

    // Monthly Expense Trend Line Chart
    new Chart(document.getElementById('monthlyTrendChart'), {
        type: 'line',
        data: {
            labels: [...Array(12)].map((_, i) => new Date(0, i).toLocaleString('default', { month: 'short' })),
            datasets: [{
                label: 'Expenses',
                data: Object.values(chartData),
                borderColor: 'rgb(75, 192, 192)',
                fill: false
            }]
        },
        options: { responsive: true }
    });

    // Budget vs Actual Bar Chart
    new Chart(document.getElementById('budgetBarChart'), {
        type: 'bar',
        data: {
            labels: ['Budget', 'Spent'],
            datasets: [{
                label: 'Amount',
                data: [{{ $totalBudget }}, {{ $totalSpent }}],
                backgroundColor: ['#4f46e5', '#ef4444']
            }]
        },
        options: { responsive: true }
    });

    // Pie Chart for Category Breakdown
    new Chart(document.getElementById('categoryPieChart'), {
        type: 'doughnut',
        data: {
            labels: categoryData.map(c => c.category),
            datasets: [{
                data: categoryData.map(c => c.total),
                backgroundColor: ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#3b82f6']
            }]
        },
        options: { responsive: true }
    });

    // Top 5 Categories Bar Chart
    new Chart(document.getElementById('topCategoriesChart'), {
        type: 'bar',
        data: {
            labels: top5Data.map(d => d.category),
            datasets: [{
                label: 'Top 5 Categories',
                data: top5Data.map(d => d.total),
                backgroundColor: '#0ea5e9'
            }]
        },
        options: { responsive: true }
    });

    function exportPDF() {
        html2canvas(document.body).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const pdf = new jspdf.jsPDF('landscape');
            pdf.addImage(imgData, 'PNG', 10, 10);
            pdf.save('dashboard.pdf');
        });
    }

    function exportCSV() {
        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.json_to_sheet(categoryData);
        XLSX.utils.book_append_sheet(wb, ws, 'Categories');
        XLSX.writeFile(wb, 'categories-report.xlsx');
    }

    setInterval(() => location.reload(), 30000);
</script>
@endsection
