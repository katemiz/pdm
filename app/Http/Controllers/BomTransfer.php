<?php

namespace App\Http\Controllers;

use App\Models\Item;

class BomTransfer extends Controller
{
    public function index()
    {
        $all_items =  Item::where('part_type', '=', "Assy")->whereNotNull('bom');

        $results = [];
        $olanlar = [];

        foreach ($all_items->get() as $k => $item) {

            if (count(json_decode($item->bom)) > 0) {

                foreach (json_decode($item->bom) as $record) {

                    $existing = Item::find($item->id)->components()->where('child_id',$record->id)->first();

                    if ($existing) {
                        $olanlar[] = $item->id. '--'.$record->id. '--'.$record->qty . '--EXISTS--' . $existing->pivot->quantity;

                    } else {
                        $item->components()->attach($record->id, [
                            'quantity' => $record->qty
                        ]);

                        $results[$k][] = $item->id. '--'.$record->id. '--'.$record->qty;
                    }
                }
            } else {
                $results[$k][] = $item->id. '--'.'No BOM';
            }
        }

        return view('bom-transfer', [
            'results' => $results,
            'olanlar' => $olanlar,
            'all_items' => $all_items->get()

        ]);
    }
}
