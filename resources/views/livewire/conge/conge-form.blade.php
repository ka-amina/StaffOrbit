<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-xl font-semibold mb-4">Demande de congé</h3>
    
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    <div class="flex justify-center">
    <form class="w-96 " wire:submit.prevent="submit">
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Type de congé</label>
            <select wire:model="type" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="Congé annuel">Congé annuel</option>
                <option value="Congé maladie">Congé maladie</option>
                <option value="Congé parental">Congé parental</option>
                <option value="Congé sans solde">Congé sans solde</option>
                <option value="Autre">Autre</option>
            </select>
            @error('type') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Date de début</label>
            <input type="date" wire:model="start_date" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('start_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Date de fin</label>
            <input type="date" wire:model="end_date" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('end_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Nombre de jours (jours ouvrés)</label>
            <input type="text" disabled value="{{ $total_days }}" class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2">
        </div>
        
        
        <div class="mb-4 p-4 bg-blue-50 rounded">
            <p class="text-blue-800">
                <span class="font-semibold">Solde disponible :</span> {{ $leaveBalance }} jours
            </p>
            <p class="text-sm text-gray-600 mt-1">
                Pour les congés annuels, la demande doit être soumise au moins une semaine à l'avance.
            </p>
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                Soumettre la demande
            </button>
        </div>
    </form>
    </div>
</div>