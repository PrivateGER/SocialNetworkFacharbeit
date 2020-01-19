<script>
	import {curRoute, onMount} from 'svelte';

	let email = "";
	let password = "";

	onMount(() => {

	});

	function login() {
		if (password === "") {
			return;
		}

		let formData = new FormData();
		formData.append("email", email);
		formData.append("password", password);

		fetch("/api/login", {
			method: 'POST',
			body: formData
		}).then((res) => {
			return res.json()
		})
				.then((res) => {
					if (res.token === undefined) {
						window.Swal.fire("Error", "Ungültige Anmeldedaten!", "error");
						return;
					}
					console.log("Got new auth token: " + res.token);

					localStorage.setItem("token", res.token);
					window.location.href = "/home";
				}).catch((err) => {
			console.log(err);
		});
	}

</script>
<style>

</style>

<div class="card" style="width: 18rem;">
	<div class="card-body">
		<form onsubmit="return false;" id="loginForm">
			<p>Anmelden</p>
			<div class="form-group">
				<label for="exampleInputEmail1">Email Adresse</label>
				<input type="email" class="form-control" bind:value={email}>
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Passwort</label>
				<input type="password" class="form-control" bind:value={password}>
			</div>
			<button on:click={login} class="btn btn-primary">Login</button>
		</form>
	</div>
</div>
