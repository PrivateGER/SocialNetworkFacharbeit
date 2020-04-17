<script>
	import SpinningLoader from "./SpinningLoader.svelte";
	import RouterLink from "./RouterLink.svelte";
	import NewPost from "./NewPost.svelte";
	import Swal from "sweetalert2";
	import { copyTextToClipboard } from "../app";
	import { redirectToPath } from "./RouterLink.svelte"

	export let postID = 1;
	export let collapsedComments = true;
	export let hidePost = false;

	let comments = [];

	let randomCommentsID = Math.random().toString(36).substring(7); // Random String, 7 chars

	function getPostDetails() {
		return new Promise((resolve, reject) => {
			fetch("/api/post/view/" + postID + "?token=" + localStorage.getItem("token"))
					.then((data) => {
						return data.json();
					})
					.then((data) => {
						comments = data.comments;
						resolve(data);
					});
		})
	}

	function updateComments(event) {
		getPostDetails();
	}

	function toggleComments() {
		document.getElementById(randomCommentsID).classList.toggle("hiddenCommentSection");
	}

	async function openReportMenu() {
		let response = await Swal.fire({
			title: "Melden",
			text: "Bist du sicher, dass du diesen Post melden möchtest?",
			icon: "question",
			showCancelButton: true,
			confirmButtonText: "Ja",
			cancelButtonText: "Abbrechen",
			cancelButtonColor: "#dc3545"
		}).then((response) => {
			if(response.value === true) {
				let formData = new FormData();
				formData.append("type", "report");
				formData.append("token", localStorage.getItem("token"));

				fetch("/api/post/report/" + postID, {
					method: 'POST',
					body: formData
				})
				.then(() => {
					Swal.fire("Gemeldet!", "Der Post wurde den Moderatoren gemeldet!", "success");
				})
			}
		})
	}

	async function openAlarmMenu() {
		let response = await Swal.fire({
			title: "Alarm",
			text: "Bist du sicher, dass du diesen Post als kritisch melden möchtest?\nDas Ausnutzen dieser Funktion kann Konsequenzen mit sich ziehen.",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Ja",
			cancelButtonText: "Abbrechen",
			cancelButtonColor: "#dc3545"
		}).then((response) => {
			if (response.value === true) {
				let formData = new FormData();
				formData.append("type", "alert");
				formData.append("token", localStorage.getItem("token"));

				fetch("/api/post/report/" + postID, {
					method: 'POST',
					body: formData
				}).then(() => {
					Swal.fire("Gemeldet!", "Der Post wurde den Moderatoren als kritisch gemeldet!", "success");
				})
			}
		})
	}

	function copyPostLink() {
		copyTextToClipboard(window.location.origin + "/post?id=" + postID);
		Swal.fire("Kopiert!", "Der Link zu diesem Post wurde in die Zwischenablage gelegt!", "success");
	}

	function openModeratorMenu() {
		redirectToPath("/admin/modmenu?id=" + postID);
	}

	async function deletePost() {
		let response = await Swal.fire({
			title: "Löschen",
			text: "Bist du sicher, dass du diesen Post löschen möchtest?",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Ja",
			cancelButtonText: "Abbrechen",
			cancelButtonColor: "#dc3545"})
				.then((response) => {
					if (response.value === true) {
						let formData = new FormData();
						formData.append("token", localStorage.getItem("token"));
						fetch("/api/post/delete/" + postID, {
							method: 'POST',
							body: formData
						}).then(() => {
							Swal.fire({
								html: "<i class=\"fas fa-trash-alt\" style='font-size: 300%; background: #6c757d; padding: 30px; border-radius: 50%; color: white'></i><br /><br />" +
										"Post gelöscht!",
							});
							hidePost = true;
						})
					}
		});



	}

</script>
<style>
	.hiddenCommentSection {
		display: none;
	}
</style>

{#await getPostDetails() }
    <SpinningLoader />
{:then post}
<div style={ hidePost ? "display: none" : "" }>
    { #if post.type === "text" }
        <div class="card">
            <div class="card-body">
				<button class="float-right bg-transparent border-0" on:click={copyPostLink}><i class="fas fa-link"></i></button>
				<button class="float-right bg-transparent border-0" on:click={openAlarmMenu}><i class="fas fa-exclamation-circle"></i></button>
				<button class="float-right bg-transparent border-0" on:click={openReportMenu}><i class="fas fa-flag"></i></button>

				<h5 class="card-title">{ post.author_name } <span class="badge badge-secondary">{ window.permissionLevelToRole(post.author_permissions) }</span></h5>
               	<h6 class="card-subtitle mb-2 text-muted">{ post.created_at }</h6>
                <p class="card-text">{ post.content }</p>

				{ #if post.author_id == localStorage.getItem("userid") }
					<button class="float-right bg-transparent border-0" on:click={deletePost}><i class="fas fa-trash-alt"></i></button>
				{ /if }

				{ #if localStorage.getItem("admin") === "true" }
					<a href={"/modmenu?id=" + postID } target="_blank"><button class="float-right bg-transparent border-0" on:click={openModeratorMenu}><i class="fas fa-user-cog"></i></button></a>
				{ /if }

				<button class="card-link btn btn-primary" on:click={toggleComments}>

					<i class="fas fa-comments"></i> Kommentare <span class="badge badge-light">{comments.length}</span>
				</button>


				<div class={ collapsedComments == true ? "hiddenCommentSection" : "" } id={randomCommentsID}>
					<br /><br />
					<div class="card">
						<ul class="list-group list-group-flush">
							{ #each comments as comment }
								<li class="list-group-item">
									{ comment.author_name } <span class="badge badge-secondary">{ window.permissionLevelToRole(comment.author_permissions) }</span><br/>
									{ comment.content }
								</li>
							{ /each }
						</ul>
					</div>
					<NewPost type="comment" parentID={postID} />
				</div>
            </div>
        </div>
    { /if }
</div>
{/await}

<svelte:window on:newComment={updateComments} />

