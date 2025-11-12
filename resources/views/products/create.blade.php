<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body class=" bg-secondary">
    <header class="bg-primary p-4">Header</header>
    <div class="container">
        <h1 class="mt-2 text-center">Create product</h1>
        <div class="card p-4 mt-4">
            <form class="row g-3" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="col-md-6">
                    <label for="inputName" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="inputSlug" class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
                    @error('slug')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="inputPrice" class="form-label">Price</label>
                    <input type="number" name="price" class="form-control" id="inputPrice">
                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="inputQuantity" class="form-label">Quantity</label>
                    <select id="inputQuantity" name="quantity" class="form-select">
                        <option selected disabled>Choose...</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                    </select>
                    @error('quantity')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="inputZip" class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" id="inputZip">
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="inputStatus" class="form-label">Status</label>
                    <select id="inputStatus" name="status" class="form-select">
                        <option selected disabled>Choose...</option>
                        <option value="1">Active</option>
                        <option value="2">Inactive</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="inputStatus" class="form-label">Description</label>
                    <textarea name="description" id="" cols="50" rows="5" class="form-control"></textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary text-capitalize">Create</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
