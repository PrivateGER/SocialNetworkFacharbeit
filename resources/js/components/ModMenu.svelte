<script>
	import Post from "./Post.svelte";
	import { findGETParameter } from "../app";
	import Swal from 'sweetalert2'

	let id = findGETParameter("id");
	if(id === null || isNaN(id) || id === "") {
		window.close();
	}

	function deletePost() {
		let formData = new FormData();
		formData.append("id", id);
		formData.append("banUser", false);
		formData.append("token", localStorage.getItem("token"));

		fetch("/api/admin/post/delete", { method: "POST", body: formData }).then(() => {
			Swal.fire({
				html: "<i class=\"fas fa-trash-alt\" style='font-size: 300%; background: #6c757d; padding: 30px; border-radius: 50%; color: white'></i><br /><br />" +
						"Post gelöscht!",
			});
		});
	}

	async function deleteAndBan() {
		let response = await Swal.fire({
			title: "Löschen & Sperren",
			text: "Bist du sicher, dass du diesen Post löschen und den Autor sperren möchtest?",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Ja",
			cancelButtonText: "Abbrechen",
			cancelButtonColor: "#dc3545"
		}).then((response) => {
			if (response.value === true) {

				let formData = new FormData();
				formData.append("id", id);
				formData.append("banUser", true);
				formData.append("token", localStorage.getItem("token"));

				fetch("/api/admin/post/delete", {method: "POST", body: formData}).then(() => {
					Swal.fire({
						html: "<i class=\"fas fa-trash-alt\" style='font-size: 300%; background: #6c757d; padding: 30px; border-radius: 50%; color: white'></i><br /><br />" +
										"Post gelöscht!",
					});
				})
			}
		});
	}
</script>
<style>
	.pad {
		padding: 1%;
	}
</style>

<div class="card">
	<div class="card-body pad">
		<div class="header">
			<h3>Moderationsmenü</h3>
		</div>
		<br />
		<Post postID={ findGETParameter("id") }/>
		<hr>
		<button class="btn btn-primary" on:click={deletePost}><i class="fas fa-trash-alt"></i> Lösche den Post</button>
		<button class="btn btn-danger" on:click={deleteAndBan}><i class="fas fa-gavel"></i> Lösche & sperre den Nutzer</button>
	</div>
</div>
