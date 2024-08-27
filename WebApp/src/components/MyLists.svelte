<script>
    import { onMount } from 'svelte';
    import { apiFetch } from "../utils/api";
    import { writable } from 'svelte/store';
    import ViewList from "./ViewList.svelte";

    let myLists = [];
    let isLoading = true;
    const newList = writable({name: '', description: ''});

    async function addList() {
        const listData = {
            name: $newList.name,
            description: $newList.description
        }

        const response = await apiFetch('/api/todolist/new', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(listData)
        });

        if(response.toDoList) {
            fetchLists();
            newList.set({name: '', description: ''});
        } else {
            console.error('Failed to add new list');
        }
    }

    async function fetchLists() {
        try {
        apiFetch('/api/todolist/all').then((result) => {
            myLists = result;
            isLoading = false;
        });
        } catch (e) {
            console.log('Error while trying to fetch my lists', e.message);
            isLoading = false;
        }
    }

    onMount(() => {
        fetchLists();
    });

</script>

<div class="flex p-4 rounded-lg">
    <input
        type="text"
        class="border p-2 mr-2"
        placeholder="Task Name"
        bind:value={$newList.name}
    />
    <input
        type="text"
        class="border p-2 mr-2"
        placeholder="Task Description"
        bind:value={$newList.description}
    />
    <button on:click={addList} class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Create New List
    </button>
</div>

<div class="flex flex-col gap-4">
    {#if isLoading}
        <p>Loading...</p>
    {:else if myLists.length > 0}
        {#each myLists as myList}
            <ViewList list={myList} fetchLists={fetchLists} />
        {/each}
    {:else}
        <p>No lists available.</p>
    {/if}
</div>