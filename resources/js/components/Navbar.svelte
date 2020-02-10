<script>
	import RouterLink from "./RouterLink.svelte";

	function toggleNavbar() {
        document.getElementById("collapsibleNavbar").classList.toggle("collapse");
    }
</script>
<style>
    .nav-link {
        color: rgba(255, 255, 255, 0.5) !important;
        text-decoration: none;
    }
</style>

<div class="row">
	<div class="col-sm-4">
		<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
			<RouterLink page={{path: '/home', name: 'Home', placeholder: "SchulNet", "class": "navbar-brand "}} />
			<!--<a class="navbar-brand" href="/home">
				<img  style="width: 100px" src="image.png" alt=" logo" >
                <p class="align-baseline">Marktplatz</p>
			</a>-->
			<button class="navbar-toggler" type="button" on:click={toggleNavbar} aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="collapsibleNavbar">
				<ul class="navbar-nav">
					<li class="nav-item">
                        <RouterLink page={{path: '/home', name: 'Home', placeholder: "Home", "class": "nav-link"}} />
						<!--<a class="nav-link" href="#section1">Home</a>-->
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#section2">Section 2</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#section3">Section 3</a>
					</li>
				</ul>

			</div>
		</nav>
	</div>
	<div class="col-sm-8">
		<!-- Toggler/collapsibe Button -->
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
			<span class="navbar-toggler-icon"></span>
		</button>
	</div>
</div>
