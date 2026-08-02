<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Carbon\Carbon;

class OperationController extends Controller
{
    public function stock()
    {
        return view('operations.stock');
    }

    public function litiges()
    {
        return view('operations.litiges');
    }

    public function journal()
    {
        return view('operations.journal');
    }

    public function statistiques(Request $request)
    {
        $agence = Auth::user()->pointRelais()->first();

        $start  = $request->input('date_debut') ?: now()->startOfMonth()->toDateString();
        $end    = $request->input('date_fin') ?: now()->endOfMonth()->toDateString();
        $statut = $request->input('statut', 'tous');
        $userId = $request->input('user');

        $approche = [Order::STATUT_EN_ATTENTE, Order::STATUT_PAYE, Order::STATUT_PRET, Order::STATUT_EN_ROUTE];

        if (! $agence) {
            return view('operations.stats', [
                'agence' => null, 'orders' => null, 'agents' => collect(),
                'counts' => ['approche' => 0, 'stock' => 0, 'livre' => 0, 'litige' => 0],
                'start'  => $start, 'end' => $end, 'statut' => $statut, 'userId' => $userId,
            ]);
        }

        $agents = $agence->users()->orderBy('prenom')->get();

        $base = Order::where('destination_point_relais_id', $agence->id)
            ->whereBetween('created_at', [Carbon::parse($start)->startOfDay(), Carbon::parse($end)->endOfDay()]);

        // Filtre par utilisateur ayant traité (réception / remise / signalement)
        if ($userId) {
            $base->where(function ($q) use ($userId) {
                $q->where('received_by', $userId)
                  ->orWhere('delivered_by', $userId)
                  ->orWhereHas('litiges', fn ($lq) => $lq->where('reporter_id', $userId));
            });
        }

        $counts = [
            'approche' => (clone $base)->whereIn('statut', $approche)->count(),
            'stock'    => (clone $base)->where('statut', Order::STATUT_DISPONIBLE)->count(),
            'livre'    => (clone $base)->where('statut', Order::STATUT_LIVRE)->count(),
            'litige'   => (clone $base)->where('statut', Order::STATUT_LITIGE)->count(),
        ];

        $query = clone $base;
        match ($statut) {
            'approche' => $query->whereIn('statut', $approche),
            'stock'    => $query->where('statut', Order::STATUT_DISPONIBLE),
            'livre'    => $query->where('statut', Order::STATUT_LIVRE),
            'litige'   => $query->where('statut', Order::STATUT_LITIGE),
            default    => $query,
        };

        $orders = $query->with(['buyer', 'receivedBy', 'deliveredBy', 'litiges.reporter'])
            ->latest()->paginate(20)->withQueryString();

        return view('operations.stats', compact('agence', 'orders', 'counts', 'start', 'end', 'statut', 'agents', 'userId'));
    }
}
