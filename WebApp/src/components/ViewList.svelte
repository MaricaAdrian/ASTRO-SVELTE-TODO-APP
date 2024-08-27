<script>
    import { apiFetch } from "../utils/api";
    export let list;
    export let fetchLists;
    async function deleteList() {

        const response = await apiFetch(`/api/todolist/${list.id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
        });

        if (response.status) {
            fetchLists();
        } else {
            console.error('Failed to delete list');
        }
    }
</script>


<div class="border border-gray-200 rounded p-4">
    <div class="text-lg font-semibold text-center text-white">{list.name}</div>   
    <div class="mt-4 flex space-x-1 items-center">
        <a class="bg-blue-500 mr-auto text-white px-4 py-2 rounded hover:bg-blue-600" href="/list/{list.id}">
            View
        </a>
        <button on:click={() => deleteList(list.id)}
 class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
            Delete
        </button>
    </div>
</div>