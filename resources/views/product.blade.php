<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .button-container {
            text-align: right;
        }

        .error {
            border: 1px solid red !important;
        }
    </style>
</head>
<body>

<div class="container" style="padding:100px">
    <h1>Purchase Product</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Product Name</th>
                <th scope="col">QTY</th>
                <th scope="col">Price</th>
                <th scope="col">D</th>
            </tr>
        </thead>
        <tbody id="all_data">
        <form class="form" id="form" method="post" action="#">
            @csrf
            <tr id="row_1">
                    <div class="row">
                        <td>
                            <div class="col">
                                <?php $product=DB::Table('download_product')->get()?>
                            <select class="custom-select product" id="inputGroupSelect01"  name="product[]" id="product_1">
                                <option selected value="">Select Product Name</option>
                                @foreach($product as $data)
                                <option value="{{$data->id}}">{{$data->name}}</option>
                                @endforeach
                            </select>
                            </div>
                        </td>
                        <td>
                            <div class="col">
                                <input type="number" class="form-control" placeholder="qty" name="qty[]" id="qty_1" min="1">
                            </div>
                        </td>
                        <td>
                            <div class="col">
                                <input type="text" class="form-control price" name="price[]" id="price_1">
                            </div>
                        </td>
                        <td>
                        <div class="col">
                        <button type="button"  style="margin-top:8px;"><span><i class="fa-solid fa-x"></i></span></button>

                        </td>

                    </div>
            </tr>
        </form>



        </tbody>
        <tfoot>
        <tr>
                <td colspan="3">
                    <div class="button-container">
                    <button type="button" id="addmore"  style="margin-top:8px;"><span><i class="fa-solid fa-plus"></i></span></button>
                    </div>
                </td>
            </tr>
        </tfoot>
        <tr>
            <td colspan="3">
               <center><button class="btn btn-primary" id="btnclick">Save</button></center>
            </td>
        </tr>
    </table>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {

    $('#addmore').click(function()
    {

        var html=``;
        html+=`
        <tr id="row_1">
                    <div class="row">
                        <td>
                            <div class="col">
                                <?php $product=DB::Table('download_product')->get()?>
                            <select class="custom-select product" id="inputGroupSelect01"  name="product[]" id="product_1">
                                <option selected value="">Select Product Name</option>
                                @foreach($product as $data)
                                <option value="{{$data->id}}">{{$data->name}}</option>
                                @endforeach
                            </select>
                            </div>
                        </td>
                        <td>
                            <div class="col">
                                <input type="number" class="form-control" placeholder="qty" name="qty[]" id="qty_1" min="1">
                            </div>
                        </td>
                        <td>
                            <div class="col">
                                <input type="text" class="form-control price" name="price[]" id="price_1">
                            </div>
                        </td>
                        <td>
                        <div class="col">

                        <button type="button" class="delete" style="margin-top:8px;"><span><i class="fa-solid fa-x"></i></span></button>

                        </td>

                    </div>
            </tr>

        `;

        $('#all_data').append(html);
    });

    $('tbody').on('change', '.product', function()
    {
            var portID = $(this).val();
            var tr = $(this).closest('tr');
            var price = tr.find('.price');

            $.ajax({
                type: "GET",
                cache: false,
                url: "{{ url('/') }}/get_price/" + portID,
                dataType: "json",
                success: function(response) {
                    if (response.hasOwnProperty('price')) {
                        price.val(response.price);
                    } else {
                        console.error('Price data not found in the response');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr, status, error);
                }
            });
    });

});

    $(document).on('click', '.delete', function() {

        $(this).closest('tr').remove();
    });


    $(document).on('click', '#btnclick', function() {

        var flag = 1;

        $('input[type="text"], input[type="number"]').each(function() {

                if ($(this).val() === '') {
                    flag = 0;
                    console.log('hello');
                    $(this).addClass('error');
                } else {
                    $(this).removeClass('error');
                    console.log('hi');
                }
        });



            jQuery('select').each(function()
            {
                if ($(this).val() === '') {
                    flag = 0;
                    $(this).addClass('error');
                } else {
                    $(this).removeClass('error');
                }
            });

            if(flag == 1)
            {
                call_submit();
            }

            else
            {
                alert('Please fill in all fields in each row.');
            }


        });


        function call_submit()
        {
            var postdata = new FormData(jQuery('#form')[0]);
            console.log(postdata);
            jQuery.ajax({
                        type: "POST",
                        cache: false,
                        url: "{{ url('/add_action') }}",
                        data: postdata,
                        datatype: "json",
                        contentType: false,
                        processData: false,
                        async: false,
                        error: function(request, error) {
                            console.log("Server Error");
                        },
                        success: function(response) {
                            if (response.status == false) {

                            }

                        }
            });
        }
</script>

</body>
</html>



    </body>
</html>
