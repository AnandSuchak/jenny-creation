@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4">Categories</h1>

<div class="bg-white p-6 rounded shadow mb-6">
    <h2 class="font-semibold mb-4">Add Category</h2>

    <form method="POST"
      action="/api/inventory/categories"
      onsubmit="event.preventDefault(); submitCategory(this);"
      class="grid grid-cols-1 md:grid-cols-3 gap-4">

        @csrf

        <input class="border rounded px-3 py-2" name="name" placeholder="Category name" required>
        <input class="border rounded px-3 py-2" name="slug" placeholder="Slug" required>
        <input class="border rounded px-3 py-2" name="filter_tag" placeholder="Type (box/puttha)">

        <button class="bg-blue-600 text-white px-4 py-2 rounded col-span-full hover:bg-blue-700">
            Add Category
        </button>
    </form>
</div>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3">Name</th>
                <th class="p-3">Type</th>
                <th class="p-3">Status</th>
            </tr>
        </thead>
        <tbody id="categoryTable">
            @foreach ($categories as $category)
                <tr class="border-t">
                    <td class="p-3">{{ $category->name }}</td>
                    <td class="p-3">{{ $category->filter_tag }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 text-sm rounded bg-green-100 text-green-700">
                            Active
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
</div>

<script>
function submitCategory(form) {
    ajaxForm(form, (response) => {
        const category = response.category;

        const row = `
            <tr class="border-t">
                <td class="p-3">${category.name}</td>
                <td class="p-3">${category.filter_tag ?? ''}</td>
                <td class="p-3">
                    <span class="px-2 py-1 text-sm rounded bg-green-100 text-green-700">
                        Active
                    </span>
                </td>
            </tr>
        `;

        document
            .getElementById('categoryTable')
            .insertAdjacentHTML('afterbegin', row);

        form.reset();
    }).catch(err => {
        alert(Object.values(err.errors)[0][0]);
    });
}
</script>

@endsection
