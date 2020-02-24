<script>
    import SpinningLoader from "./SpinningLoader.svelte";
    import RouterLink from "./RouterLink.svelte";
    import Swal from 'sweetalert2'

    export let type = "post";
    export let parentID = 0;

	let randomPostContentID = Math.random().toString(36).substring(7);
	let randomNewPostButtonID = Math.random().toString(36).substring(7);

    let placeholder = "Text eingeben...";
    let postContent = placeholder;

    function createPost() {
        if(type === "post") {
        	return postPost();
		} else if (type === "comment") {
			return postComment();
		}
    }

	function postPost() {
		return new Promise((resolve, reject) => {
			let formData = new FormData();
			formData.append("postType", "text");
			formData.append("postContent", postContent);
			formData.append("token", localStorage.getItem("token"));

			fetch("/api/post/create", {
				method: 'POST',
				body: formData
			}).then((res) => {
				return res.json();
			})
					.then((data) => {
						if(data.err !== "") {
							Swal.fire(
									'',
									data.err,
									'error'
							);
							return;
						}

						const newPostEvent = new CustomEvent('newPost', { });
						window.dispatchEvent(newPostEvent);
						postContent = "";
					});
		});
	}

	function postComment() {
		return new Promise((resolve, reject) => {
			let formData = new FormData();
			formData.append("parentID", parentID);
			formData.append("postContent", postContent);
			formData.append("token", localStorage.getItem("token"));

			fetch("/api/post/create_comment", {
				method: 'POST',
				body: formData
			}).then((res) => {
				return res.json();
			})
				.then((data) => {
					if(data.err !== "") {
						Swal.fire(
								'',
								data.err,
								'error'
						);
						return;
					}
					const newCommentEvent = new CustomEvent('newComment', { "parentID": parentID });
					window.dispatchEvent(newCommentEvent);
					postContent = placeholder;
				});
		});
	}

    function removePlaceholder() {
        document.getElementById(randomPostContentID).classList.remove("text-muted");
		document.getElementById(randomNewPostButtonID).disabled = false;
		document.getElementById(randomNewPostButtonID).classList.remove("bg-dark");

        if(postContent === placeholder) {
            postContent = "";
        }
    }

    function title() {
		if(type === "post") {
			return "Neuer Post";
		} else if (type === "comment") {
			return "Neuer Kommentar";
		}
	}

</script>
<style>

    .content {
        padding-left: 1%;
    }

</style>

<div class="card border-dark" id="newPost">
    <div class="card-body">
        <h5 class="card-title">{title()}</h5>
        <p id={randomPostContentID} class="card-text text-muted content" contenteditable="true" bind:innerHTML={postContent} on:focus={removePlaceholder}></p>
        <button id={randomNewPostButtonID} class="text-white bg-primary btn-circle btn-circle-lg float-right bg-dark" on:click={createPost} disabled><i class="fas fa-paper-plane"></i></button>
    </div>
</div>
<br />
