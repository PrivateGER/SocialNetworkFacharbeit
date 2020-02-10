<script>
	import {curRoute, onMount} from 'svelte';

	let email = "";
	let password = "";

	onMount(() => {

	});

	function login() {
		if (email === "" || password === "") {
			return;
		}

		let formData = new FormData();
		formData.append("email", email);
		formData.append("password", password);

		fetch("/api/auth/login", {
			method: 'POST',
			body: formData
		}).then((res) => {
		    if(res.status === 401) {
                document.getElementById("errMsg").classList.remove("invisible");
                return;
            }
			return res.json()
		})
		.then((res) => {
            if (res === undefined || res.token === undefined) {
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
    .invisible {
        display: none;
    }
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
            <p class="invisible alert alert-danger alert-heading" id="errMsg">Falsches Passwort!</p>
			<button on:click={login} class="btn btn-primary">Login</button>
		</form>
	</div>
</div>
