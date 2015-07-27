<?php namespace App\Entry;

use App\Entry;
use Illuminate\Http\Request;

/**
 * This file belongs to competitions.
 *
 * Author: Rahul Kadyan, <hi@znck.me>
 * Find license in root directory of this project.
 */
class TextEntry extends AbstractEntry
{
    protected $rules = [
        'content' => 'required|min:20',
    ];

    public function fill(Entry &$entry, Request $request)
    {
        parent::fill($entry, $request);
        $entry->abstract = \Markdown::convertToHtml(strip_tags($request->get('content')));
    }

    public function viewCreate()
    {
        return 'comparator.create.text';
    }

    public function viewShow()
    {
        return 'comparator.show.text';
    }
}