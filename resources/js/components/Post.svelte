<script>
	import SpinningLoader from "./SpinningLoader.svelte";
	import RouterLink from "./RouterLink.svelte";
	import NewPost from "./NewPost.svelte";

	export let postID = 1;

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
</script>
<style>
	.hiddenCommentSection {
		display: none;
	}
</style>

{#await getPostDetails() }
    <SpinningLoader />
{:then post}
    { #if post.type === "text" }
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{ post.author_name }</h5>
               <h6 class="card-subtitle mb-2 text-muted">{ post.created_at }</h6>
                <p class="card-text">{ post.content }</p>

				<button class="card-link btn btn-primary" on:click={toggleComments}>
					<i class="fas fa-comments"></i> Kommentare ({comments.length})
				</button>

				<div class="hiddenCommentSection" id={randomCommentsID}>
					<br /><br />
					<div class="card">
						<ul class="list-group list-group-flush">
							{ #each comments as comment }
								<li class="list-group-item">
									{ comment.author_name }:<br/>
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
{/await}

<svelte:window on:newComment={updateComments} />

