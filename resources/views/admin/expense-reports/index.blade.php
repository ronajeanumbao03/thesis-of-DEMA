@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-4">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Expense Reports (All Departments)</h2>

    <!-- Filter Form -->
    <form method="GET" class="mb-6 flex flex-wrap gap-4">
        <div>
            <label for="status" class="block text-sm text-gray-600 dark:text-gray-300">Status</label>
            <select name="status" id="status" class="w-48 px-3 py-2 rounded border dark:bg-gray-800">
                <option value="">All</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <div>
            <label for="month" class="block text-sm text-gray-600 dark:text-gray-300">Month</label>
            <select name="month" id="month" class="w-48 px-3 py-2 rounded border dark:bg-gray-800">
                <option value="">All</option>
                @foreach(range(1,12) as $m)
                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                        {{ date('F', mktime(0,0,0,$m,1)) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="self-end">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                Filter
            </button>
        </div>
    </form>

    <!-- Totals Summary -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-green-100 dark:bg-green-900 p-4 rounded shadow">
            <h3 class="text-green-800 dark:text-green-200 font-bold">Approved</h3>
            <p class="text-lg font-semibold">₱{{ number_format($totalApproved, 2) }}</p>
        </div>
        <div class="bg-yellow-100 dark:bg-yellow-900 p-4 rounded shadow">
            <h3 class="text-yellow-800 dark:text-yellow-200 font-bold">Pending</h3>
            <p class="text-lg font-semibold">₱{{ number_format($totalPending, 2) }}</p>
        </div>
        <div class="bg-red-100 dark:bg-red-900 p-4 rounded shadow">
            <h3 class="text-red-800 dark:text-red-200 font-bold">Rejected</h3>
            <p class="text-lg font-semibold">₱{{ number_format($totalRejected, 2) }}</p>
        </div>
    </div>

    <!-- Export Buttons -->
    <div class="mb-4 text-right space-x-2">
        <button onclick="window.print()" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
            Print
        </button>
        <button onclick="exportToCSV()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Export CSV
        </button>
        <button onclick="exportToPDF()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
            Export PDF
        </button>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto bg-white dark:bg-gray-800 p-4 rounded shadow">
        <table id="reportTable" class="min-w-full text-sm">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white">
                <tr>
                    <th class="px-4 py-2 text-left">Date</th>
                    <th class="px-4 py-2 text-left">Category</th>
                    <th class="px-4 py-2 text-left">Amount</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Submitted By</th>
                    <th class="px-4 py-2 text-left">Department</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 dark:text-gray-300">
                @forelse($expenses as $expense)
                    <tr>
                        <td class="px-4 py-2">{{ $expense->expense_date }}</td>
                        <td class="px-4 py-2">{{ $expense->category }}</td>
                        <td class="px-4 py-2">₱{{ number_format($expense->amount, 2) }}</td>
                        <td class="px-4 py-2 capitalize">{{ $expense->status }}</td>
                        <td class="px-4 py-2">{{ $expense->user->first_name }} {{ $expense->user->last_name }}</td>
                        <td class="px-4 py-2">{{ $expense->department->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-400 py-4">No expense records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Export Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    function exportToCSV() {
        const table = document.getElementById("reportTable");
        const wb = XLSX.utils.table_to_book(table, { sheet: "Expenses" });
        XLSX.writeFile(wb, "admin-expense-report.csv");
    }

    function exportToPDF() {
        html2canvas(document.getElementById("reportTable")).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const pdf = new jspdf.jsPDF('landscape');
            pdf.addImage(imgData, 'PNG', 10, 10, 280, 0);
            pdf.save("admin-expense-report.pdf");
        });
    }
</script>
@endsection
