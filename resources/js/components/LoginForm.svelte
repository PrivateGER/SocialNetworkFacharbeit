<script>
	import {curRoute, onMount} from 'svelte';
	import Swal from 'sweetalert2'


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
			if(res.banned === true) {
				bannedUser();
				return;
			}
            if (res === undefined || res.token === undefined) {
                return;
            }
            console.log("Got new auth token: " + res.token);

			localStorage.setItem("admin", res.permission_level > 2);
			localStorage.setItem("userid", res.user_id);
            localStorage.setItem("token", res.token);
            window.location.href = "/home";
        }).catch((err) => {
			console.log(err);
			Swal.fire("Fehler", "Fehler bei der Kommunikation mit dem Server.", "error");
		});
	}

	function bannedUser() {
		Swal.fire({
			html: "<i class=\"fas fa-gavel\" style='font-size: 300%; background: #ff0000; padding: 30px; border-radius: 50%; color: white'></i><br /><br />Sie wurden von einem Administrator aufgrund eines Regelbruchs von SchulNet verwiesen.<br />Ihre Inhalte sind für alle anderen Nutzer nun unsichtbar.",
			footer: "Sollten weitere Fragen bestehen, senden Sie bitte eine E-Mail an support@schulnet.de."
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
