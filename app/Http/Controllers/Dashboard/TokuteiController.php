<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Tokutei;
use Illuminate\Http\Request;

class TokuteiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tokutei  $tokutei
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tokutei = Tokutei::find($id);

        return view('dashboard.tokuteis.show', compact('tokutei'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tokutei  $tokutei
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tokutei = Tokutei::find($id);

        return view('dashboard.tokuteis.edit', compact('tokutei'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tokutei  $tokutei
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tokutei $tokutei)
    {
        $request->validate([
            'seller' => 'required',
            'administrator' => 'required',
            'tel' => 'required',
            'address' => 'required',
            'contact' => 'required',
        ],
        [
            'seller.required' => '販売者名は必須です。',
            'administrator.required' => '運営統括責任者は必須です。',
            'description.required' => '商品説明は必須です。',
            'tel.required' => '電話番号は必須です。',
            'address.required' => '所在地は必須です。',
            'contact.required' => 'お問い合わせ先は必須です。',
        ]);

        $tokutei->seller = $request->input('seller');
        $tokutei->administrator = $request->input('administrator');
        $tokutei->tel = $request->input('tel');
        $tokutei->address = $request->input('address');
        $tokutei->contact = $request->input('contact');
        $tokutei->delivery_time = $request->input('delivery_time');
        $tokutei->delivery_of_goods = $request->input('delivery_of_goods');
        $tokutei->caution = $request->input('caution');
        $tokutei->personal_information = $request->input('personal_information');
        $tokutei->required_fee = $request->input('required_fee');
        $tokutei->payment_method = $request->input('payment_method');
        $tokutei->payment_time_credit = $request->input('payment_time_credit');
        $tokutei->payment_time_bank_transfer = $request->input('payment_time_bank_transfer');
        $tokutei->cancel = $request->input('cancel');
        $tokutei->recurring_method = $request->input('recurring_method');
        $tokutei->recurring_time_credit = $request->input('recurring_time_credit');
        $tokutei->recurring_time_bank_transfer = $request->input('recurring_time_bank_transfer');
        $tokutei->recurring_midterm_cancel = $request->input('recurring_midterm_cancel');

        $tokutei->update();

        return redirect()->route('dashboard.tokuteis.edit', '1');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tokutei  $tokutei
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tokutei $tokutei)
    {
        //
    }
}
