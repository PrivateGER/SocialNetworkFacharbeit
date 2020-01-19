
import Home from './Home.svelte';
import Login from './Login.svelte';
import Landing from './Landing.svelte';
import ViewProduct from './ViewProduct.svelte';
import { writable } from 'svelte/store';

const router = {
    '/': Landing,
    '/home': Home,
    '/login': Login,
    '/product': ViewProduct
};

export default router;
export const curRoute = writable('/home');
