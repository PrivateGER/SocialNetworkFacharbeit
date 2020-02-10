<script>
    import SpinningLoader from "./SpinningLoader.svelte";
    import RouterLink from "./RouterLink.svelte";

    export let postID = 1;

    function getPostDetails() {
        return new Promise((resolve, reject) => {
            fetch("/api/post/view/" + postID + "?token=" + localStorage.getItem("token"))
                    .then((data) => {
                        return data.json();
                    })
                    .then((data) => {
                        resolve(data);
                    });
        })

    }
</script>
<style>

</style>

{#await getPostDetails() }
    <SpinningLoader />
{:then post}
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{ post.author_name }</h5>
            <h6 class="card-subtitle mb-2 text-muted">{ post.created_at }}</h6>
            <p class="card-text">{ post.content }</p>

            <RouterLink page={{path: '/comments?id=' + postID, name: 'Comments', placeholder: "<i class=\"fas fa-comments\"></i> Kommentare", "class": "card-link"}} />
        </div>
    </div>
{/await}
