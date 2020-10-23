<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
			.boudin {
				color: #fff;
				display: inline-block;
				background-color : #04c;
				cursor: pointer;
				font-weight: bold;
				padding: 10px 5px;
			}
        </style>
		<meta name="csrf-token" content="{{ csrf_token() }}"></meta>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>
        <p>Results go here</p>
		<div id="ResultsGoHere" style="width:100%; height:200px; overflow-y:scroll;border: 1px solid black"></div>
		<hr>
		<div class='boudin' method='POST' url='api/token' 
			data='{"email":"wlewis.wlewis@gmail.com","password":"password"}'
		>Get Token for Wes</div>
		<div class='boudin' method='POST' url='token' 
			data='{"email":"wlewis.wlewis@gmail.com","password":"wrong"}'
		>Get Token - Bad UN / PW</div>
		<div class='boudin' method='POST' url='api/products' 
			data='{"name":"Cheetos","description":"It aint easy bein cheesy","price":"1.49"}'
		>Create Product - No Token</div>
		<div class='boudin' method='POST' url='api/products?api_token=EIdCBSGlFdvFupGqP7VAydm20paUIvblCZTWXxfJWXPopBLAc31ae1Vd0fIr' 
			data='{"name":"Cheetos","description":"It aint easy bein cheesy","price":"1.49"}'
		>Create Product - Wes' Token</div>
		<div class='boudin' method='PUT' url='api/products/1?api_token=EIdCBSGlFdvFupGqP7VAydm20paUIvblCZTWXxfJWXPopBLAc31ae1Vd0fIr' 
			data='{"name":"Cheetos","description":"It aint easy bein cheesy"}'
		>Update Product 1 - missing field</div>
		<div class='boudin' method='PUT' url='api/products/1?api_token=EIdCBSGlFdvFupGqP7VAydm20paUIvblCZTWXxfJWXPopBLAc31ae1Vd0fIr' 
			data='{"name":"Flamin Hot Cheetos","description":"Flamin hot!","price":"1.99"}'
		>Update Product 1 - Wes' Token</div>
		<div class='boudin' method='PUT' url='api/products/1?api_token=3vgOlXU1XTu2BhP4Zy4gyCWFT4D5JUDVjERIPWW0EXGcQOz73qZYedB8qZ3V' 
			data='{"name":"Flamin Hot Cheetos Popcorn","description":"Flamin hot! And popcorn!","price":"2.49"}'
		>Update Product 1 - Jello's Token</div>
		<div class='boudin' method='DELETE' url='api/products/1?api_token=EIdCBSGlFdvFupGqP7VAydm20paUIvblCZTWXxfJWXPopBLAc31ae1Vd0fIr' 
			data='{}'
		>Delete Product 1 - Wes' Token</div>
		<div class='boudin' method='DELETE' url='api/products/2?api_token=EIdCBSGlFdvFupGqP7VAydm20paUIvblCZTWXxfJWXPopBLAc31ae1Vd0fIr' 
			data='{}'
		>Delete Product 2 - Wes' Token</div>
		<div class='boudin' method='GET' url='api/products?api_token=EIdCBSGlFdvFupGqP7VAydm20paUIvblCZTWXxfJWXPopBLAc31ae1Vd0fIr' 
			data='{}'
		>List All Products</div>
    </body>
	<script>
$(document).ready(function() {
	
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	$(".boudin").on("click", function() {
		var $t = $(this);
		var method = $t.attr("method");
		var url = $t.attr("url");
		var data = JSON.parse($t.attr("data"));
		
		$.ajax(url, {
			method : method,
			data : data,
			success : function(response) {
				$("#ResultsGoHere").html(JSON.stringify(response));	
			},
			error : function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				$("#ResultsGoHere").html(errorThrown + "<br>" + jqXHR.responseJSON );	
			},
		});
	});
});
	</script>
</html>
