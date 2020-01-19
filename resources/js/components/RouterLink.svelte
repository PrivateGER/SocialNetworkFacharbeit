<script >
	import { curRoute } from './router.js';

	export let page = {
		path: '/home',
		name: 'Home',
        placeholder: path,
        class: ''
	};

	function redirectTo(event){
		// change current router path
		curRoute.set(event.target.pathname);
		// push the path into web browser history API
		window.history.pushState({path: page.path}, '', window.location.origin + page.path);

		window.ensureAuth(event.target.pathname);

	}

	function redirectToPath(path) {
		// change current router path
		curRoute.set(path);
		// push the path into web browser history API
		window.history.pushState({path: page.path}, '', window.location.origin + path);

		window.ensureAuth(path);
    }

</script>


<style>

</style>

<a href={page.path} class={page.class} on:click|preventDefault={redirectTo}>{page.placeholder}</a>
