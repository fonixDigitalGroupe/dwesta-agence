<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ColisController extends Controller
{
    /**
     * Display a listing of orders assigned to the current agency.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $agence = $user->pointRelais()->first();

        if (!$agence) {
            return view('colis.index', [
                'agence' => null,
                'orders' => collect([]),
                'counts' => ['incoming' => 0, 'stock' => 0, 'history' => 0],
                'activeTab' => 'stock'
            ]);
        }

        $activeTab = $request->query('tab', 'stock'); // stock (disponible), incoming (en_route), history (livre)
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $query = Order::where('destination_point_relais_id', $agence->id);

        // Count totals for badges
        $counts = [
            'incoming' => Order::where('destination_point_relais_id', $agence->id)->whereIn('statut', [Order::STATUT_EN_ATTENTE, Order::STATUT_PAYE, Order::STATUT_PRET, Order::STATUT_EN_ROUTE])->count(),
            'stock' => Order::where('destination_point_relais_id', $agence->id)->whereIn('statut', [Order::STATUT_DISPONIBLE, Order::STATUT_LITIGE])->count(),
            'history' => Order::where('destination_point_relais_id', $agence->id)->whereIn('statut', [Order::STATUT_LIVRE, Order::STATUT_ANNULE])->count(),
        ];

        // Filter by tab
        if ($activeTab === 'incoming') {
            $query->whereIn('statut', [Order::STATUT_EN_ATTENTE, Order::STATUT_PAYE, Order::STATUT_PRET, Order::STATUT_EN_ROUTE]);
        } elseif ($activeTab === 'history') {
            $query->whereIn('statut', [Order::STATUT_LIVRE, Order::STATUT_ANNULE]);
        } else {
            // Default to 'stock' (Disponible)
            $query->whereIn('statut', [Order::STATUT_DISPONIBLE, Order::STATUT_LITIGE]);
        }

        // Recherche par référence uniquement
        if ($search) {
            $query->where('reference', 'like', "%{$search}%");
        }

        $orders = $query->with(['buyer', 'seller.user', 'seller.pagePro', 'litiges'])->latest()->paginate($perPage)->withQueryString();

        return view('colis.index', compact('agence', 'orders', 'counts', 'activeTab', 'search', 'perPage'));
    }

    /**
     * Mark an order as received at the agency.
     */
    public function receive(Request $request, Order $order): RedirectResponse
    {
        // Security check
        $agence = $request->user()->pointRelais()->first();
        if (!$agence || $order->destination_point_relais_id !== $agence->id) {
            return Redirect::back()->with('error', 'Action non autorisée.');
        }

        $order->update(['statut' => Order::STATUT_DISPONIBLE, 'received_at' => now(), 'received_by' => $request->user()->id]);

        return Redirect::route('operations.stock', ['tab' => 'stock'])->with('status', 'colis-reçu');
    }

    /**
     * Mark an order as delivered to the customer.
     */
    public function deliver(Request $request, Order $order): RedirectResponse
    {
        // Security check
        $agence = $request->user()->pointRelais()->first();
        if (!$agence || $order->destination_point_relais_id !== $agence->id) {
            return Redirect::back()->with('error', 'Action non autorisée.');
        }

        if ($order->statut !== Order::STATUT_DISPONIBLE) {
            return Redirect::back()->with('error', 'Seuls les colis en stock peuvent être livrés.');
        }

        if ($order->litiges()->where('statut', 'en_cours')->exists()) {
            return Redirect::back()->with('error', 'Remise impossible : un litige a été signalé sur cette commande.');
        }

        $order->update(['statut' => Order::STATUT_LIVRE, 'delivered_by' => $request->user()->id]);

        return Redirect::route('operations.stock', ['tab' => 'history'])->with('status', 'colis-livré');
    }

    /**
     * Signaler un litige (colis à retourner) — géré par l'admin Karnou.
     */
    public function signalLitige(Request $request, Order $order): RedirectResponse
    {
        $agence = $request->user()->pointRelais()->first();
        if (!$agence || $order->destination_point_relais_id !== $agence->id) {
            return Redirect::back()->with('error', 'Action non autorisée.');
        }

        $data = $request->validate([
            'motif'       => 'required|in:non_recu,non_conforme,autre',
            'description' => 'nullable|string|max:1000',
        ]);

        $labels = [
            'non_recu'     => 'Client non venu (colis non récupéré)',
            'non_conforme' => 'Colis non conforme',
            'autre'        => "Le client n'en veut plus",
        ];

        \App\Models\Litige::create([
            'commande_id' => $order->id,
            'reporter_id' => $request->user()->id,
            'reported_id' => $order->user_id,
            'motif'       => $data['motif'],
            'description' => $data['description'] ?: ('Colis à retourner — ' . ($labels[$data['motif']] ?? '')),
            'statut'      => 'en_cours',
        ]);

        // La commande passe en litige → visible dans l'admin Karnou (orders?status=litige),
        // tout en restant affichée dans le stock de l'agence (marquée, non livrable).
        $order->update(['statut' => Order::STATUT_LITIGE]);

        return Redirect::route('operations.stock', ['tab' => 'stock'])
            ->with('success', "Litige signalé. La commande est transmise à l'administration Karnou pour retour.");
    }

    /**
     * Page de détails du colis.
     */
    public function show(Request $request, Order $order)
    {
        $agence = $request->user()->pointRelais()->first();
        if (!$agence || $order->destination_point_relais_id !== $agence->id) {
            abort(403);
        }

        $order->load(['buyer', 'seller.user', 'items.annonce.medias']);

        return view('colis.show', ['order' => $order, 'agence' => $agence]);
    }

    /**
     * Fiche détaillée du colis en PDF.
     */
    public function detailsPdf(Request $request, Order $order)
    {
        $agence = $request->user()->pointRelais()->first();
        if (!$agence || $order->destination_point_relais_id !== $agence->id) {
            abort(403);
        }

        $order->load(['buyer', 'seller.user', 'items.annonce.medias']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('colis.pdf', [
            'order'  => $order,
            'agence' => $agence,
        ])->setPaper('a4');

        return $pdf->stream('colis-' . $order->reference . '.pdf');
    }

    /**
     * Handle barcode scan for receiving or delivering.
     */
    public function scan(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $code = $request->code;
        $user = $request->user();
        $agence = $user->pointRelais()->first();

        if (!$agence) {
            return response()->json(['success' => false, 'message' => 'Aucune agence associée à votre compte.'], 403);
        }

        // Search by reference or tracking token
        $order = Order::where('destination_point_relais_id', $agence->id)
            ->where(function($q) use ($code) {
                $q->where('reference', $code)
                  ->orWhere('tracking_token', $code);
            })
            ->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Colis non trouvé ou n\'appartient pas à cette agence.'], 404);
        }

        $oldStatut = $order->statut;
        $message = "";
        $action = "";

        if (in_array($oldStatut, [Order::STATUT_EN_ATTENTE, Order::STATUT_PAYE, Order::STATUT_PRET, Order::STATUT_EN_ROUTE])) {
            $order->update(['statut' => Order::STATUT_DISPONIBLE, 'received_at' => now(), 'received_by' => $request->user()->id]);
            $message = "Colis {$order->reference} réceptionné avec succès.";
            $action = "received";
        } elseif ($oldStatut === Order::STATUT_DISPONIBLE) {
            $order->update(['statut' => Order::STATUT_LIVRE]);
            $message = "Colis {$order->reference} livré au client.";
            $action = "delivered";
        } else {
            $statusLabel = match($oldStatut) {
                Order::STATUT_LIVRE => 'déjà livré',
                Order::STATUT_ANNULE => 'annulé',
                default => $oldStatut
            };
            return response()->json(['success' => false, 'message' => "Ce colis est {$statusLabel}."], 422);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'action' => $action,
            'order' => [
                'reference' => $order->reference,
                'buyer' => ($order->buyer->prenom ?? '') . ' ' . ($order->buyer->nom ?? $order->buyer->name ?? ''),
            ]
        ]);
    }
}
