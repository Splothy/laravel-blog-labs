<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Carbon\Carbon;

class DiggingDeeperController extends Controller
{
    public function collections()
    {
        $eloquentCollection = BlogPost::withTrashed()->get();

        // dd(__METHOD__, $eloquentCollection, $eloquentCollection->toArray());

        $collection = collect($eloquentCollection->toArray());

        // dd(get_class($eloquentCollection), get_class($collection), $collection);

        $result = [];

        $result['first'] = $collection->first();
        $result['last'] = $collection->last();

        $result['where']['data'] = $collection
            ->where('category_id', 10)
            ->values()
            ->keyBy('id');

        $result['where']['count'] = $result['where']['data']->count();
        $result['where']['isEmpty'] = $result['where']['data']->isEmpty();
        $result['where']['isNotEmpty'] = $result['where']['data']->isNotEmpty();

        $result['where_first'] = $collection
            ->firstWhere('created_at', '>', '2020-02-24 03:46:16');

        $result['map']['all'] = $collection->map(function ($item) {
            $newItem = new \stdClass();
            $newItem->item_id = $item['id'];
            $newItem->item_name = $item['title'];
            $newItem->exists = is_null($item['deleted_at']);

            return $newItem;
        });

        $result['map']['not_exists'] = $result['map']['all']
            ->where('exists', false)
            ->values()
            ->keyBy('item_id');

        // dd($result);

        $collection->transform(function ($item) {
            $newItem = new \stdClass();
            $newItem->item_id = $item['id'];
            $newItem->item_name = $item['title'];
            $newItem->exists = is_null($item['deleted_at']);
            $newItem->created_at = Carbon::parse($item['created_at']);

            return $newItem;
        });

        // dd($collection);

        $newItem = new \stdClass();
        $newItem->item_id = 9999;
        $newItem->item_name = 'First test item';
        $newItem->exists = true;
        $newItem->created_at = Carbon::now();

        $newItem2 = new \stdClass();
        $newItem2->item_id = 8888;
        $newItem2->item_name = 'Last test item';
        $newItem2->exists = true;
        $newItem2->created_at = Carbon::now();

        $newItemFirst = $collection->prepend($newItem)->first();
        $newItemLast = $collection->push($newItem2)->last();
        $pulledItem = $collection->pull(1);

        // dd(compact('collection', 'newItemFirst', 'newItemLast', 'pulledItem'));

        $filtered = $collection->filter(function ($item) {
            $byDay = $item->created_at->isFriday();
            $byDate = $item->created_at->day == 11;

            return $byDay && $byDate;
        });

        // dd(compact('filtered'));

        $sortedSimpleCollection = collect([5, 3, 1, 2, 4])->sort()->values();
        $sortedAscCollection = $collection->sortBy('created_at')->values();
        $sortedDescCollection = $collection->sortByDesc('item_id')->values();

        // dd(compact('sortedSimpleCollection', 'sortedAscCollection', 'sortedDescCollection'));

        return [
            'result' => $result,
            'newItemFirst' => $newItemFirst,
            'newItemLast' => $newItemLast,
            'pulledItem' => $pulledItem,
            'filtered' => $filtered->values(),
            'sortedSimpleCollection' => $sortedSimpleCollection,
            'sortedAscCollection' => $sortedAscCollection,
            'sortedDescCollection' => $sortedDescCollection,
        ];
    }
}
