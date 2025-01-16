<div class="ml-2">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('GST Module') }}
        </h2>
    </x-slot>
<div class="bg-gray-800 p-6 rounded-lg">
    <h2 class="text-2xl text-teal-400 mb-4">GST Module</h2>
    <div class="text-gray-300">
        <p>Manage GST-related tasks and reports.</p>
    </div>

    <div class="mt-4">
        <!-- GST Filing Section -->
        <div class="bg-gray-900 p-4 rounded-lg">
            <h3 class="text-xl text-teal-300 mb-2">GST Filing</h3>
            <form action="{{ route('employee.gst.file') }}" method="POST" class="space-y-4">
                @csrf
                <div class="flex space-x-4">
                    <div class="w-1/3">
                        <label for="month" class="text-gray-400">Filing Month</label>
                        <select id="month" name="month" class="w-full bg-gray-800 text-gray-300 p-2 rounded" required>
                            @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                <option value="{{ $month }}">{{ $month }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-1/3">
                        <label for="year" class="text-gray-400">Filing Year</label>
                        <select id="year" name="year" class="w-full bg-gray-800 text-gray-300 p-2 rounded" required>
                            @for($i = date('Y'); $i >= date('Y')-2; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="flex space-x-4">
                    <div class="w-1/3">
                        <label for="total_sales" class="text-gray-400">Total Sales Amount</label>
                        <input type="number" step="0.01" id="total_sales" name="total_sales" class="w-full bg-gray-800 text-gray-300 p-2 rounded" required>
                    </div>
                    <div class="w-1/3">
                        <label for="total_tax" class="text-gray-400">Total Tax Amount</label>
                        <input type="number" step="0.01" id="total_tax" name="total_tax" class="w-full bg-gray-800 text-gray-300 p-2 rounded" required>
                    </div>
                </div>
                <button type="submit" class="bg-teal-500 text-gray-200 px-4 py-2 rounded hover:bg-teal-600">Submit GST Filing</button>
            </form>
        </div>

        <!-- GST Reports Section -->
        <div class="bg-gray-900 p-4 rounded-lg mt-6">
            <h3 class="text-xl text-teal-300 mb-2">GST Reports</h3>
            <div class="text-gray-300">
                <p>View and download your GST reports.</p>
                <a href="{{ route('employee.gst.reports') }}" class="text-teal-400 hover:text-teal-500">View Reports</a>
            </div>
        </div>
    </div>
</div>