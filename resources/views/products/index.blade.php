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
                @forelse ($products as $item)
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <img src="{{ asset('storage/' . $item->image_url) }}" class="card-img-top"
                                    alt="Product Image" height="200px">
                                <h5 class="card-title">{{ $item->name }}</h5>
                                <p class="card-text">Price: ${{ $item->price }}</p>
                                <a href="#" class="btn btn-primary addToCartBtn" data-id="{{ $item->id }}">Add
                                    to cart</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <h2>Product not found!</h2>
                @endforelse
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

            $('.addToCartBtn').click(function(e) {
                e.preventDefault();
                var product_id = $(this).data('id');
                $.ajax({
                    url: "{{ route('products.addToCart') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        product_id: product_id,
                        quantity: 2
                    },
                    success: function(response) {
                        // alert(response.message);
                        $('#addcartMessage').show().text(response.message);
                        console.log(response.message);
                        
                    },
                    error: function(xhr) {
                        alert('Error adding product to cart.');
                    }
                });
            });
        });
    </script>
</body>

</html>
