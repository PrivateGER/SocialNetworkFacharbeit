<script>
    import {onMount} from 'svelte';
    import SpinningLoader from "./SpinningLoader.svelte";
    import Post from "./Post.svelte";

    function displayFeed() {
        return new Promise((resolve, reject) => {
            fetch("/api/post/feed?token=" + localStorage.getItem("token"))
                    .then((data) => {
                        return data.json();
                    })
                    .then((data) => {
                        resolve(data);
                    })
        });
    }
</script>
<style>

</style>

{ #await displayFeed() }
    <SpinningLoader />
{:then data}
    { #each data as post }
        <Post postID={ post.id } />
        <br />
    { /each }
{:catch error}
    <h1 class="alert-danger">{ error }</h1>
{ /await }
