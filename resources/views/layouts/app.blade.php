<!DOCTYPE html>
<html lang="en">
<head>
    <title>JennyCreation Inventory</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body class="bg-gray-100 min-h-screen">

    <!-- NAVBAR -->
    <nav class="bg-white shadow px-6 py-4 flex gap-6">
        <a href="{{ route('inventory.dashboard') }}" class="font-semibold text-gray-700 hover:text-blue-600">Dashboard</a>
        <a href="{{ route('inventory.categories') }}" class="text-gray-700 hover:text-blue-600">Categories</a>
        <a href="{{ route('inventory.products') }}" class="text-gray-700 hover:text-blue-600">Products</a>
        <a href="{{ route('inventory.stock') }}" class="text-gray-700 hover:text-blue-600">Stock</a>
        <a href="{{ route('inventory.movements') }}" class="text-gray-700 hover:text-blue-600">Movements</a>
    </nav>

    <!-- PAGE CONTENT -->
    <main class="max-w-6xl mx-auto p-6">
        @yield('content')
    </main>
    <script>
async function ajaxForm(form, onSuccess) {
    const formData = new FormData(form);

    const response = await fetch(form.action, {
        method: form.method || 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
        },
        body: formData
    });

    const data = await response.json();

    if (!response.ok) {
        throw data;
    }

    onSuccess(data);
}
</script>

</body>
</html>
