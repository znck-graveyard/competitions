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
            'image'   => $entry->image ?: 'https://unsplash.it/256/?random&' . str_random(4),
            'upvotes' => $entry->upvotes,
            'views'   => $entry->views ?: 0,
            'owner'   => [
                'image' => $entry->entryable->image ?: 'https://unsplash.it/40/?random&' . str_random(4),
                'name'  => $entry->entryable->name,
                'link'  => $entry->entryable->link,
            ]
        ];
    }
}