<script>
	import {onDestroy, onMount} from 'svelte';
	import SpinningLoader from "./SpinningLoader.svelte";
	import ShopDisplay from "./ShopDisplay.svelte";
	import Navbar from "./Navbar.svelte";

	let seconds = 0;

	let defaultShopID = 1;

	onDestroy(() => {

	});

	onMount(() => {

	});


</script>
<style>

</style>

{ #await window.retrieveUserInfo(localStorage.getItem("token")) }
	<SpinningLoader />
{:then data}
    <h1>Willkommen zurück, { data.data.name }!</h1>
{ /await }

<ShopDisplay shopID={defaultShopID} maxProducts="3" />
