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
		window.ensureAuth(window.location.pathname);

		setInterval(checkNavbarAuth, 1000);
	});

	function checkNavbarAuth() {
		if(localStorage.getItem("token") !== undefined && localStorage.getItem("token") !== null && localStorage.getItem("token").length === 128) {
			showNavbar = true;
		} else {
			showNavbar = false;
		}
    }

    checkNavbarAuth();

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
<!--
<RouterLink page={{path: '/home', name: 'Home'}} />
<RouterLink page={{path: '/login', name: 'Login'}} />-->

{ #if showNavbar }
    <Navbar />
{ /if }
<br />
<div id="pageContent">
	<svelte:component this={router[$curRoute]} />
</div>
