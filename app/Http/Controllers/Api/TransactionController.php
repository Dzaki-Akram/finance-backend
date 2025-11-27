<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Transaction::where('user_id', $user->id);

        // search
        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // filter type
        if ($type = $request->query('type')) {
            $query->where('type', $type);
        }

        // filter category
        if ($category = $request->query('category')) {
            $query->where('category', $category);
        }

        // filter date range
        if ($dateFrom = $request->query('date_from')) {
            $query->whereDate('date', '>=', $dateFrom);
        }
        if ($dateTo = $request->query('date_to')) {
            $query->whereDate('date', '<=', $dateTo);
        }

        // filter amount range
        if ($amountMin = $request->query('amount_min')) {
            $query->where('amount', '>=', $amountMin);
        }
        if ($amountMax = $request->query('amount_max')) {
            $query->where('amount', '<=', $amountMax);
        }

        // sorting
        $allowedSortBy = ['date', 'amount', 'category', 'created_at'];
        $sortBy = $request->query('sort_by', 'date');
        $sortOrder = $request->query('sort_order', 'desc');

        if (! in_array($sortBy, $allowedSortBy)) {
            $sortBy = 'date';
        }
        if (! in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc';
        }

        $query->orderBy($sortBy, $sortOrder);

        // pagination
        $perPage = (int) $request->query('per_page', 10);
        $transactions = $query->paginate($perPage);

        return response()->json($transactions);
    }

    public function store(StoreTransactionRequest $request)
    {
        $user = $request->user();

        $data = $request->validated();
        $data['user_id'] = $user->id;

        $transaction = Transaction::create($data);

        return response()->json([
            'message' => 'Transaksi berhasil dibuat',
            'data'    => $transaction,
        ], 201);
    }

    public function show(Transaction $transaction)
    {
        $this->authorizeUser($transaction);

        return response()->json($transaction);
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        $this->authorizeUser($transaction);

        $transaction->update($request->validated());

        return response()->json([
            'message' => 'Transaksi berhasil diupdate',
            'data'    => $transaction,
        ]);
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorizeUser($transaction);

        $transaction->delete();

        return response()->json([
            'message' => 'Transaksi berhasil dihapus',
        ]);
    }

    protected function authorizeUser(Transaction $transaction): void
    {
        // memastikan user hanya bisa akses transaksi miliknya
        if (auth()->id() !== $transaction->user_id) {
            abort(403, 'Tidak boleh mengakses transaksi ini.');
        }
    }
}
