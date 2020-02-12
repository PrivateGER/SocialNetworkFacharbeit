<script>
    import {onDestroy, onMount} from 'svelte';
    import SpinningLoader from "./SpinningLoader.svelte";
    import Feed from './Feed.svelte';
    import NewPost from "./NewPost.svelte";

    function displayUserData() {
        return new Promise((resolve, reject) => {
            fetch("/api/auth/info?token=" + localStorage.getItem("token"))
                .then((data) => {
                    if (data.status === 401) {
                        return;
                    }
                    return data.json();
                })
                .then((data) => {
                    if (data === undefined) {
                        window.location = "/login";
                    }

                    resolve(data);
                })
                .catch((data) => {
                    reject("Der Server konnte nicht erreicht werden.");
                })
        });
    }

</script>
<style>

</style>

{ #await displayUserData() }
	<SpinningLoader />
{:then data}
    <h1>Willkommen zurück, { data.data.username }!</h1>
{:catch error}
    <h1 class="alert-danger">{ error }</h1>
{ /await }

<NewPost type="post" />
<Feed postCount="10" />
