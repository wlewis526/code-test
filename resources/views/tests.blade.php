<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Code Test - API Testing</title>

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
				padding: 5px 10px;
				margin: 5px 10px;
			}
        </style>
		{{--<meta name="csrf-token" content="{{ csrf_token() }}"></meta>--}}
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>
        <p>Results go here</p>
		<div id="ResultsGoHere" style="width:100%; height:100px; overflow-y:scroll;border: 1px solid black"></div>
		<hr>
		<h4>API Token</h4>
		<div id="ApiToken" style="width:50%; margin: 0 auto; height:24px; border: 1px solid black"></div>
		<hr>
		<h4>Product ID</h4>
		<input type="text" id="ProductID">
		<hr>
		<h4>Image Input (for Upload Image API)</h4>
		<input type="file" id="ImageInput">
		<hr>
		<h4>Set User</h4>
		<div class='boudin token'
			data='{"email":"wlewis.wlewis@gmail.com","password":"password"}'
		>Testy McTesterson</div>
		<div class='boudin token'
			data='{"email":"jello@holiday.kh","password":"SoIThrewTheRock"}'
		>Jello Biafra</div>
		<div class='boudin token'
			data='{"email":"greg@epitaph.org","password":"NoControl"}'
		>Greg Graffin</div>
		<div class='boudin token'
			data='{"email":"dick_lucas@bath.co.uk","password":"WhenTheBombDrops"}'
		>Dick Lucas (inactive sub)</div>
		<div class='boudin token'
			data='{"email":"stza@ninth_and_c.org","password":"RockThe40oz"}'
		>Scott Sturgeon (no sub)</div>
		<div class='boudin token' 
			data='{"email":"wlewis.wlewis@gmail.com","password":"wrong"}'
		>Bad UN / PW</div>
		<hr>
		<h4>APIs</h4>
		<div class='boudin api' method='POST' url='api/products' 
			data='{"name":"Cheetos","description":"It aint easy bein cheesy","price":"1.49"}'
		>Create Product</div>
		<div class='boudin api' method='PUT' url='api/products' append-id=1
			data='{"name":"Cheetos","description":"It aint easy bein cheesy"}'
		>Update Product - missing field</div>
		<div class='boudin api' method='PUT' url='api/products' append-id=1
			data='{"name":"Flamin Hot Cheetos","description":"Flamin hot!","price":"1.99"}'
		>Update Product</div>
		<div class='boudin api' method='DELETE' url='api/products' append-id=1
			data='{}'
		>Delete Product</div>
		<div class='boudin api' method='GET' url='api/products' 
			data='{}'
		>List All Products</div>
		<div class='boudin api' method='GET' url='api/product-users' 
			data='{}'
		>List User's Products</div>
		<div class='boudin api' method='PUT' url='api/product-users' append-id=1
			data='{}'
		>Add Product to User</div>
		<div class='boudin api' method='DELETE' url='api/product-users' append-id=1
			data='{}'
		>Remove Product from User</div>
		<div class='boudin uploadImage'>Upload Image</div>
    </body>
	<script>
$(document).ready(function() {
	$(".token").on("click", function() {
		var $t = $(this);
		var data = JSON.parse($t.attr("data"));
		
		$.ajax("api/token", {
			method : "POST",
			data : data,
			success : function(response) {
				var strToken = JSON.stringify(response);
				$("#ResultsGoHere").html(strToken);	
				$("#ApiToken").html(strToken.replaceAll('"', ''));
			},
			error : function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				$("#ResultsGoHere").html(errorThrown + "<br>" + jqXHR.responseJSON );
				$("#ApiToken").html("");
			},
		});
	});
		
	$(".api").on("click", function() {
		var $t = $(this);
		var method = $t.attr("method");
		var url = $t.attr("url");
		if ($t.attr("append-id")) {
			url += "/" + $("#ProductID").val();
		}
		var apiToken = $("#ApiToken").html();
		if (apiToken.length) {
			url += "?api_token=" + apiToken;
		}
		var data = JSON.parse($t.attr("data"));
			
		$.ajax(url, {
			method : method,
			data : data,
			success : function(response) {
				$("#ResultsGoHere").html(JSON.stringify(response));
				if (response.id) {
					$("#ProductID").val(response.id);
				}
			},
			error : function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				$("#ResultsGoHere").html(errorThrown + "<br>" + jqXHR.responseJSON );	
			},
		});
	});
	
	$(".uploadImage").on("click", function() {
		var $t = $(this);
		var method = "PUT";
		var url = "api/products/" + $("#ProductID").val() + "/image";

		var apiToken = $("#ApiToken").html();
		if (apiToken.length) {
			url += "?api_token=" + apiToken;
		}
		var input = document.getElementById("ImageInput");
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onerror = function(event) {
				$("#ResultsGoHere").html("Image input failed.");
			};
			reader.onload = function(event) {
				var data = {
					image : event.target.result
				};
				$.ajax(url, {
					method : method,
					data : data,
					success : function(response) {
						$("#ResultsGoHere").html(JSON.stringify(response));
						if (response.id) {
							$("#ProductID").val(response.id);
						}
					},
					error : function(jqXHR, textStatus, errorThrown) {
						console.log(jqXHR);
						$("#ResultsGoHere").html(errorThrown + "<br>" + jqXHR.responseJSON );	
					},
				});
			}
			reader.readAsDataURL(input.files[0]);
		}
	});
});
	</script>
</html>
