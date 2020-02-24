<script>
	import {onDestroy, onMount} from 'svelte';
	import SpinningLoader from "./SpinningLoader.svelte";
	import Feed from './Feed.svelte';
	import NewPost from "./NewPost.svelte";
	import RouterLink from "./RouterLink.svelte";

	function displayUserData() {
		return new Promise((resolve, reject) => {
			fetch("/api/auth/info?token=" + localStorage.getItem("token"))
					.then((data) => {
						if (data.status === 401) {
							return;
						}
						return data.json();
					})
					.then((data) => {
						if (data === undefined) {
							window.location = "/login";
						}

						resolve(data);
					})
					.catch((data) => {
						reject("Der Server konnte nicht erreicht werden.");
					})
		});
	}

</script>
<style>

</style>

<div class="card">
	<div class="card-body">
		{ #await displayUserData() }
			<SpinningLoader />
		{:then data}
			<h1>Willkommen zurück, { data.data.username }
				<span class="badge badge-secondary">{ window.permissionLevelToRole(data.data.permission_level) }</span>!
			</h1>
			{ #if data.data.permission_level > 2}
				<h5>Sie haben administrativen Zugang! <RouterLink page={{path: '/admin', name: 'Admin', placeholder: "Klicken sie hier, um zum Dashboard zu gelangen!", "class": ""}} /></h5>
			{/if}
		{:catch error}
			<h1 class="alert-danger">{ error }</h1>
		{ /await }
	</div>
</div>

<br />

<NewPost type="post" />
<Feed postCount="10" />
