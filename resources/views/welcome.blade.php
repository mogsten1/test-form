<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Price Form
                </div>
                <div class="card-body">
                    <form id="submit_form" method="POST">
                        <div class="form-group">
                            <input class="form-control" type="text" name="product_name" id="product_name" placeholder="Product Name" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="number" name="quantity" id="quantity" placeholder="Quantity in Stocks" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="number" name="price" id="price" placeholder="Price Per Item" required>
                        </div>

                        <button class="btn btn-primary float-right">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 mt-3">
            <div class="row">
                <div class="col-3">Product Name</div>
                <div class="col-3">Quantity in Stocks</div>
                <div class="col-3">Price Per Item</div>
                <div class="col-3">Total</div>
            </div>
            <hr>
            <div id="product_list">
            @foreach($products as $product)
                <div class="row">
                    <div class="col-3">{{ $product->product_name }}</div>
                    <div class="col-3">{{ $product->quantity }}</div>
                    <div class="col-3">{{ $product->price }}</div>
                    <div class="col-3">$ {{ $product->quantity * $product->price }}</div>
                </div>
                <hr>
            @endforeach
            </div>
            <div class="row">
                <div class="col-3 offset-9" id="total">
                    ${{ $total }}
                </div>
            </div>

        </div>
    </div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Optional JavaScript; choose one of the two! -->
<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
-->
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script>
    $('form').submit(function(e){
        e.preventDefault();

        $.ajax({
            url: '/submit',
            type: 'POST',
            data: {
                product_name: $('#product_name').val(),
                quantity: $('#quantity').val(),
                price: $('#price').val()
            },
            success: function(resp){
                if(resp.status == 'success'){

                }
                var product = resp.product;
                $('#product_list').append('<div class="row">' +
                    '<div class="col-3">'+ product.product_name +'</div>' +
                    '<div class="col-3">'+ product.quantity + '</div>' +
                '<div class="col-3">' + product.price + '</div>' +
                '<div class="col-3">$ ' + parseFloat(product.quantity * product.price) + '</div>' +
                '</div>' +
                '<hr>');
            }
        })
    })
</script>
</body>
</html>
