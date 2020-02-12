<script>
	import router, {curRoute} from './router.js';
	import RouterLink from './RouterLink.svelte';
	import {onMount} from 'svelte';
	import Navbar from "./Navbar.svelte";

	let showNavbar = false;

	onMount(() => {
		curRoute.set(window.location.pathname);
		if (!history.state) {
			window.history.replaceState({path: window.location.pathname}, '', window.location.href)
		}
    });


	function handlerBackNavigation(event) {
		curRoute.set(event.state.path)
	}


</script>
<style>
	#pageContent {
		padding: 1%;
		overflow-x: hidden;
	}

</style>

<svelte:window on:popstate={handlerBackNavigation} />

<Navbar />
<br />
<div id="pageContent">
	<svelte:component this={router[$curRoute]} />
</div>
