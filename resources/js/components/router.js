
import Home from './Home.svelte';
import Login from './Login.svelte';
import Landing from './Landing.svelte';
import Post from './Post.svelte'
import AdminDashboard from './AdminDashboard.svelte';
import PermalinkPost from './PermalinkPost.svelte';
import ModMenu from './ModMenu.svelte';

import { writable } from 'svelte/store';

const router = {
    '/': Landing,
    '/home': Home,
    '/login': Login,
    '/post': PermalinkPost,
	'/admin': AdminDashboard,
	'/modmenu': ModMenu,
};

export default router;
export const curRoute = writable('/');
