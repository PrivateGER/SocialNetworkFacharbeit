<script>
    import {onMount} from 'svelte';
    import SpinningLoader from "./SpinningLoader.svelte";
    import Post from "./Post.svelte";

    export let postCount = 50;

    let postsToDisplay = [];
    let page = 1;

    function displayFeed() {
        return new Promise((resolve, reject) => {
            fetch("/api/post/feed?limit=" + postCount + "&page=" + page + "&token=" + localStorage.getItem("token"))
                    .then((data) => {
                        return data.json();
                    })
                    .then((data) => {
                    	data.reverse().forEach((el) => {
							postsToDisplay.push(el);
						});

						postsToDisplay = removeDuplicatesAndSort(postsToDisplay).reverse();
                        page++;
                        resolve("");
                    })
        });
    }

	function removeDuplicatesAndSort(posts) {
		let knownPostIDs = [];
		let uniquePosts = [];

		posts.forEach((post) => {
			if(knownPostIDs.indexOf(post.id) > -1) {
				return;
			} else {
				knownPostIDs.push(post.id);
				uniquePosts.push(post);
			}
		});

		return uniquePosts.sort((first, second) => {
			return first.id - second.id;
		});
	}
</script>
<style>

</style>

{ #await displayFeed() }
    <SpinningLoader />
{:catch error}
    <h1 class="alert-danger">{ error }</h1>
{ /await }

{ #each postsToDisplay as post (post.id) }
	<Post postID={ post.id } />
	<br />
{ /each }

<button class="btn btn-primary" on:click={displayFeed}>Mehr laden</button>

<svelte:window on:newPost={displayFeed} />
