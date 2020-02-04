<script>
	import {onDestroy, onMount} from 'svelte';
	import SpinningLoader from "./SpinningLoader.svelte";

	let seconds = 0;

	let defaultShopID = 1;

	onDestroy(() => {

	});

	onMount(() => {

	});


</script>
<style>

</style>

{ #await new Promise(resolve => {}) }
	<SpinningLoader />
{:then data}
    <h1>Willkommen zurück, { data.data.name }!</h1>
{ /await }
