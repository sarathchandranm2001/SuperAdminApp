<x-app-layout>
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Payment Page</h2>
        <form id="paymentForm">
            <label for="amount" class="block text-lg mb-2">Enter Amount:</label>
            <input type="number" id="amount" name="amount" class="border p-2 rounded mb-4 w-full" required>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Pay</button>
        </form>
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        const form = document.getElementById('paymentForm');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const amount = document.getElementById('amount').value;

            const response = await fetch('{{ route('payment.process') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ amount })
            });
            const data = await response.json();

            const options = {
                key: data.key,
                amount: amount * 100,
                currency: 'INR',
                order_id: data.orderId,
                handler: function (response) {
                    fetch('{{ route('payment.verify') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(response)
                    }).then(() => location.reload());
                }
            };
            const rzp = new Razorpay(options);
            rzp.open();
        });
    </script>
</x-app-layout>
