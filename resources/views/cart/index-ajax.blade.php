<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>

<body class=" bg-secondary">
    <header class="bg-primary p-4">Header</header>
    <div class="container">
        <h1 class="mt-2 text-center">Products</h1>
        <div class="card p-4 mt-4">
            @session('success')
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endsession
            <div class="alert alert-success" id="addcartMessage">
                {{ session('success') }}
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="checkoutForm">
                                @csrf
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selectAll"></th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($carts as $item)
                                            <tr>
                                                <td><input type="checkbox" class="itemCheckbox" name="cart_ids[]"
                                                        value="{{ $item->id }}"></td>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->product->name }}</td>
                                                <td><img src="{{ asset('storage/' . $item->product->image_url) }}"
                                                        class="card-img-top" alt="Product Image" height="100px"
                                                        width="50px"></td>
                                                <td>{{ $item->unit_price }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $item->total_price }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6">No items in cart.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5" class="text-end">Grand Total:</th>
                                            <th>{{ number_format($grandTotal, 2) }}
                                            </th>
                                        </tr>
                                </table>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5>Grand Total: ₹<span id="grandTotal">0.00</span></h5>
                                    <button type="submit" class="btn btn-success" id="checkoutBtn">Proceed to
                                        Pay</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
        integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous">
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        $(document).ready(function() {

            // Select / Deselect all checkboxes
            $('#selectAll').on('click', function() {
                $('.itemCheckbox').prop('checked', this.checked);
                calculateTotal();
            });

            $('.itemCheckbox').on('change', calculateTotal);

            function calculateTotal() {
                let total = 0;
                $('.itemCheckbox:checked').each(function() {
                    let row = $(this).closest('tr');
                    let itemTotal = parseFloat(row.find('td').eq(6).text().replace('₹', '')) || 0;
                    total += itemTotal;
                });
                $('#grandTotal').text(total.toFixed(2));
            }

            // Checkout selected items
            $('#checkoutForm').on('submit', function(e) {
                e.preventDefault();

                let selectedItems = $('.itemCheckbox:checked');

                if (selectedItems.length === 0) {
                    alert('Please select at least one product to checkout.');
                    return;
                }

                let formData = $(this).serialize();

                $.ajax({
                    url: "",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            alert('Redirecting to payment gateway...');
                            // example: redirect to Razorpay/Stripe page
                            window.location.href = response.redirect_url;
                        }
                    },
                    error: function(xhr) {
                        alert('Something went wrong!');
                    }
                });
            });
        });
    </script>
</body>

</html>
