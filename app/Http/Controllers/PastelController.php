<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePastelRequest;
use App\Http\Requests\UpdatePastelRequest;
use App\Models\Pastel;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Controller para gerenciamento de pastéis
 *
 * @package App\Http\Controllers
 */
class PastelController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return LengthAwarePaginator
     */
    public function index() : LengthAwarePaginator {
        return Pastel::query()->paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreatePastelRequest $request
     *
     * @return Pastel
     */
    public function store( CreatePastelRequest $request ) : Pastel {
        return Pastel::query()->create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param Pastel $pastel
     *
     * @return Pastel
     */
    public function show( Pastel $pastel ) : Pastel {
        return $pastel;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePastelRequest $request
     * @param Pastel              $pastel
     */
    public function update( UpdatePastelRequest $request, Pastel $pastel ) : void {
        $pastel->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Pastel $pastel
     *
     * @throws Exception
     */
    public function destroy( Pastel $pastel ) : void {
        $pastel->delete();
    }
}
