<?php namespace App\Transformer;

use App\Entry;
use League\Fractal\TransformerAbstract;

/**
 * This file belongs to competitions.
 *
 * Author: Rahul Kadyan, <hi@znck.me>
 * Find license in root directory of this project.
 */
class EntryTransformer extends TransformerAbstract
{
    public function transform(Entry $entry)
    {
        return [
            'uuid'    => $entry->uuid,
            'title'   => $entry->title,
            'image'   => $entry->imageUrl(300, 300) ?: asset('image/placeholder.jpg'),
            'upvotes' => $entry->upvotes,
            'views'   => $entry->views ?: 0,
            'link'    => route('contest.entry.show', [$entry->contest->slug, $entry->uuid]),
            'owner'   => [
                'image' => $entry->entryable->imageUrl() ?: asset('image/placeholder.jpg'),
                'name'  => $entry->entryable->name,
                'link'  => $entry->entryable->link,
            ],
            'contest' => [
                'image' => $entry->contest->imageUrl() ?: asset('image/placeholder.jpg'),
                'name'  => $entry->contest->name,
                'type'  => ucwords($entry->contest->contest_type),
            ]
        ];
    }
}