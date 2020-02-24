<script>
	import Post from "./Post.svelte";
	import { findGETParameter } from "../app";


</script>

<Post postID={ findGETParameter("id") } collapsedComments={false} />
