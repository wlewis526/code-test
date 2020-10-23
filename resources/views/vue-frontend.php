<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/bootstrap.css">
	<style>
		.login {
			max-width: 400px;
		}
		.errorBanner {
			background-color : #fee;
			border : 1px solid #fcc;
			border-radius : 2px;
			position: absolute;
			top: 10px;
			left: calc(50% - 300px);
			width: 600px;
			text-align: center;
		}
		.btn-tiny {
			  padding: 0.1rem 0.2rem;
			  font-size: 0.5rem;
			  border-radius: 0.2rem;
		}
		.thumbelina {
			height: 30px;
		}
	</style>
	<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
	<div id="codeTestApp">
		<div class="container">
			<p class="text-right"><a href="tests">Go to API test page (not part of Vue app)</a></p>
			<div class="errorBanner" v-if="errorMessage">{{ errorMessage }}</div>
			<div v-on:click="hideError">
				<div class="login mx-auto my-5" v-if="!user.api_token">
					<div>
						<input class="my-2" v-model="user.email" type="text" placeholder="email address"/>
					</div>
					<div>
						<input class="my-2" v-model="user.password" type="password" placeholder="password"/>
					</div>
					<div class="my-2 btn btn-success" v-on:click="login">Login</div>
				</div>
				<div class="mx-auto my-5" v-if="user.api_token">
					<ul class="nav nav-tabs">
						<li class="nav-item" v-bind:class="[ myProductsActive ? 'active' : '' ]">
							<a class="nav-link" href="#" v-on:click="showMyProducts">My Products</a>
						</li>
						<li class="nav-item" v-bind:class="[ allProductsActive ? 'active' : '' ]">
							<a class="nav-link" href="#" v-on:click="showAllProducts">All Products</a>
						</li>
					</ul>
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane" role="tabpanel" v-bind:class="[ myProductsActive ? 'active' : '' ]">
							<table class="table">
								<thead>
									<tr>
										<th>ID</th><th>Name</th><th>Description</th><th>Image</th><th>Creator</th><th></th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(product, i) in myProducts" :key="i">
										<td>{{ product.id }}</td>
										<td>{{ product.name }}</td>
										<td>{{ product.description }}</td>
										<td><img class="thumbelina" :src="product.image"></td>
										<td>{{ product.creator.first_name }} {{ product.creator.last_name }}</td>
										<td><a class="btn btn-warning btn-sm" v-on:click="removeProduct(product)">Remove from My Products</a></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="tab-pane" role="tabpanel" v-bind:class="[ allProductsActive ? 'active' : '' ]">
							<table class="table">
								<thead>
									<tr>
										<th>ID</th><th>Name</th><th>Description</th><th>Image</th><th>Creator</th><th></th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(product, i) in allProducts" :key="i">
										<td>{{ product.id }}</td>
										<td>{{ product.name }}</td>
										<td>{{ product.description }}</td>
										<td><img class="thumbelina" :src="product.image"></td>
										<td>{{ product.creator.first_name }} {{ product.creator.last_name }}</td>
										<td><a class="btn btn-success btn-sm" v-on:click="addProduct(product)">Add to My Products</a></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script type="application/javascript">
var codeTestApp = new Vue({
	el: '#codeTestApp',
	data : {
		user : {
			email : "",
			password : "",
			api_token : "",
		},
		myProducts : [],
		allProducts : [],
		errorMessage : "",
		myProductsActive : false,
		allProductsActive : false,
	},
	methods: {
		makeURI : function(baseURI, product_id) {
			var uri = "api/" + baseURI;
			if (product_id) {
				uri += "/" + product_id;
			}
			uri += "?api_token=" + codeTestApp.user.api_token;
			return uri;
		},
		showError : function(err) {
			codeTestApp.errorMessage = err.response ? err.response.data : "An error has occurred.";
			console.log(err.response ? err.response : err);
		},
		hideError : function() {
			codeTestApp.errorMessage = "";
		},
		login : function() {
			axios.post("api/token", codeTestApp.user).then(function(response) {
				codeTestApp.user.api_token = response.data;
				codeTestApp.showMyProducts();
			}).catch(function(err) {
				codeTestApp.showError(err);
			});
		},
		loadMyProducts : function(callback) {
			axios.get(codeTestApp.makeURI("product-users"), { transformResponse: (r) => r }).then(function(response) {
				var parsed = JSON.parse(response.data);
				codeTestApp.myProducts = parsed;
				if (typeof callback == "function") {
					callback();
				}
			}).catch(function(err) {
				codeTestApp.showError(err);
			});
		},
		showMyProducts : function() {
			codeTestApp.loadMyProducts(function() {
				codeTestApp.myProductsActive = true;
				codeTestApp.allProductsActive = false;
			});
		},
		showAllProducts : function() {
			axios.get(codeTestApp.makeURI("products"), { transformResponse: (r) => r }).then(function(response) {
				var parsed = JSON.parse(response.data);
				codeTestApp.allProducts = parsed;
				codeTestApp.myProductsActive = false;
				codeTestApp.allProductsActive = true;
			}).catch(function(err) {
				codeTestApp.showError(err);
			});
		},
		addProduct : function(product) {
			axios.put(codeTestApp.makeURI("product-users", product.id), { transformResponse: (r) => r }).then(function(response) {
				codeTestApp.loadMyProducts();
			}).catch(function(err) {
				codeTestApp.showError(err);
			});
		},
		removeProduct : function(product) {
			axios.delete(codeTestApp.makeURI("product-users", product.id), { transformResponse: (r) => r }).then(function(response) {
				codeTestApp.loadMyProducts();
			}).catch(function(err) {
				codeTestApp.showError(err);
			});
		},
	}
})
</script>
</html>