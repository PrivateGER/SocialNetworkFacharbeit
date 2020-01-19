<script>
	import {onMount} from 'svelte';
	import LoginForm from "./LoginForm.svelte";

	onMount(() => {

	});
</script>
<style>
    #form {
        margin-top: 10%;
        display: flex;
        justify-content: center;
    }
</style>

<div id="form">
    <LoginForm />
</div>
