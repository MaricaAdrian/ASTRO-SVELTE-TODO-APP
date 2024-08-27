import { writable } from 'svelte/store';

const storedUser = localStorage.getItem('user');
const initialState = storedUser
  ? JSON.parse(storedUser)
  : { username: '', isLoggedIn: false };

export const userStore = writable(initialState);

userStore.subscribe((value) => {
  localStorage.setItem('user', JSON.stringify(value));
});