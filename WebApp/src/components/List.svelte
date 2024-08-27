<script>
    import { onMount } from 'svelte';
    import { writable } from 'svelte/store';
    import { apiFetch } from "../utils/api";

    export let listId;

    const tasks = writable([]);
    const newTask = writable({ name: '', description: '' });
    let list = {};

    // To fetch all tasks we need to fetch current list, since we also need data from it
    async function fetchTasks() {
        const response = await apiFetch(`/api/todolist/${listId}`);
        list = response;
        tasks.set(response.tasks);
    }

    // Add a new task
    async function addTask() {
        const taskData = {
            name: $newTask.name,
            description: $newTask.description,
            status: 1,
            toDoListId: listId,
        };

        const response = await apiFetch('/api/task/new', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(taskData),
        });

        if (response.task) {
            fetchTasks(); // Refresh the task list after adding a new task
            newTask.set({ name: '', description: '' }); // Clear input fields
        } else {
            console.error('Failed to add task');
        }
    }

    async function markAsDone(taskId) {
        const response = await apiFetch(`/api/task/${taskId}/edit`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ status: 2 }), // Update status to STATUS_DONE
        });

        if (response.task) {
            fetchTasks(); // Refresh the task list after marking as done
        } else {
            console.error('Failed to mark task as done');
        }
    }

    onMount(() => {
        fetchTasks();
    });
</script>

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Task List ({list.name})</h1>

    <div class="mb-4">
        <input
            type="text"
            class="border p-2 mr-2"
            placeholder="Task Name"
            bind:value={$newTask.name}
        />
        <input
            type="text"
            class="border p-2 mr-2"
            placeholder="Task Description"
            bind:value={$newTask.description}
        />
        <button
            class="bg-blue-500 text-white px-4 py-2"
            on:click={addTask}
        >
            Add Task
        </button>
    </div>

    <ul class="space-y-2">
        {#each $tasks as task}
            <li class="flex justify-between items-center p-4 bg-gray-100 rounded">
                <div>
                    <h2 class="text-xl font-semibold">{task.name}</h2>
                    <p>{task.description}</p>
                </div>
                <div>
                    {#if task.status === 1}
                        <button
                            class="bg-green-500 text-white px-4 py-2"
                            on:click={() => markAsDone(task.id)}
                        >
                            Mark as Done
                        </button>
                    {:else}
                        <span class="text-green-600">Done</span>
                    {/if}
                </div>
            </li>
        {/each}
    </ul>
</div>