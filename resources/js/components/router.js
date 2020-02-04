
import Home from './Home.svelte';
import Login from './Login.svelte';
import Landing from './Landing.svelte';

import { writable } from 'svelte/store';

const router = {
    '/': Landing,
    '/home': Home,
    '/login': Login,
};

export default router;
export const curRoute = writable('/home');
