<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Translations;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $Translations = Translations::orderBy('updated_at', 'DESC')->get();

        return view('admin.translations.index', compact('Translations'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(): Renderable
    {
        return view('admin.translations.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        Translations::create([
            'key' => $request->key,
            'value' => $request->value,
            'race' => $request->race,
            'lang' => $request->lang,
            'plural' => $request->plural
        ]);

        return redirect('admin/translate/'. ( $request->id ?? null));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $Translations = Translations::orderBy('updated_at', 'DESC')->get();

        return view('admin.translations.index', compact('Translations', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $Translation = Translations::where('id', $id)->first();

        return view('admin.translations.edit', compact('Translation'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        Translations::where('id', $id)->update([
            'key' => $request->key,
            'value' => $request->value,
            'race' => $request->race,
            'lang' => $request->lang,
            'plural' => $request->plural
        ]);

        return redirect('admin/translate/'. ( $request->id ?? null));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
