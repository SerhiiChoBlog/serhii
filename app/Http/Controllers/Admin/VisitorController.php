<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Visitor\IndexRequest;
use App\Models\Visitor;
use Illuminate\Pagination\LengthAwarePaginator;

class VisitorController extends Controller
{
    /**
     * @return LengthAwarePaginator<int, Visitor>
     */
    public function index(IndexRequest $request): LengthAwarePaginator
    {
        $query = Visitor::query()
            ->withCount('postViews')
            ->orderBy($request->order, $request->direction);

        if ($request->search) {
            $query->where('ip', 'like', "%{$request->search}%")
                ->orWhere('id', 'like', "%{$request->search}%")
                ->orWhere('city', 'like', "%{$request->search}%")
                ->orWhere('code', 'like', "%{$request->search}%")
                ->orWhere('country', 'like', "%{$request->search}%");
        }

        return $query->paginate(30);
    }

    public function block(Visitor $visitor): void
    {
        $visitor->update(['is_blocked' => true]);
    }

    public function unblock(Visitor $visitor): void
    {
        $visitor->update(['is_blocked' => false]);
    }
}
