<script>
	import RouterLink from './RouterLink.svelte';

</script>
<style>
.centeredtext {
	text-align: center;
}
</style>

<div class="card mx-auto align-items-center">
	<div class="card-body">
		<img src="gsm-logo_farbe.jpg" class="card-img-top" alt="St Michael Logo">
		<div class="card-body">
			<h2 class="card-text centeredtext">Willkommen bei SchulNet!</h2>
			<h3 class="centeredtext">Bitte <RouterLink page={{path: '/login', name: 'Home', placeholder: "melde dich an", "class": ""}} />, um mitzumachen!</h3>
		</div>
	</div>
</div>
