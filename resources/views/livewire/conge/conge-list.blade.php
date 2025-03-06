<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-xl font-semibold mb-4">Historique des demandes de congé</h3>

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

    <div class="flex flex-wrap gap-4 mb-4">
        <div class="w-full md:w-auto">
            <label class="block text-gray-700 text-sm mb-1">Statut</label>
            <select wire:model.live="status" class="w-full md:w-48 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Tous les statuts</option>
                <option value="pending">En attente</option>
                <option value="approved">Approuvé</option>
                <option value="rejected">Rejeté</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jours</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($conges as $conge)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $conge->type }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($conge->start_date)->format('d/m/Y') }} -
                            {{ \Carbon\Carbon::parse($conge->end_date)->format('d/m/Y') }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $conge->total_days }} jour(s)</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
    {{ $conge->status == 'approved' ? 'bg-green-100 text-green-800' : 
       ($conge->status == 'rejected' ? 'bg-red-100 text-red-800' : 
       'bg-yellow-100 text-yellow-800') }}">
                            {{ $conge->status == 'approved' ? 'Approuvé' : 
       ($conge->status == 'rejected' ? 'Rejeté' : 'En attente') }}
                        </span>
                    </td>
    
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
    @if($conge->status == 'pending')
    <button
        wire:click="cancelRequestRh({{ $conge->id }})"
        wire:confirm="Êtes-vous sûr de vouloir rejeter cette demande de congé en tant que RH ?"
        class="p-2 bg-red-600 hover:bg-red-400 text-white rounded-sm">
        Rejeter RH
    </button>
    <button
        wire:click="cancelRequestManager({{ $conge->id }})"
        wire:confirm="Êtes-vous sûr de vouloir rejeter cette demande de congé en tant que manager ?"
        class="p-2 bg-red-600 hover:bg-red-400 text-white rounded-sm">
        Rejeter manager
    </button>
    <button
        wire:click="approveRequestRh({{ $conge->id }})"
        wire:confirm="Êtes-vous sûr de vouloir approuver cette demande de congé en tant que RH ?"
        class="p-2 bg-green-600 hover:bg-green-400 text-white rounded-sm">
        Approuver RH
    </button>
    <button
        wire:click="approveRequestManager({{ $conge->id }})"
        wire:confirm="Êtes-vous sûr de vouloir approuver cette demande de congé en tant que manager ?"
        class="p-2 bg-green-600 hover:bg-green-400 text-white rounded-sm">
        Approuver manager
    </button>
    @else
    <span class="text-gray-400">-</span>
    @endif
</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Aucune demande de congé trouvée.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $conges->links() }}
    </div>
</div>