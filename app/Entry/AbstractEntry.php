<?php namespace App\Entry;

use App\Entry;
use Illuminate\Http\Request;
use Symfony\Component\Debug\Exception\UndefinedMethodException;

/**
 * This file belongs to competitions.
 *
 * Author: Rahul Kadyan, <hi@znck.me>
 * Find license in root directory of this project.
 */
abstract class AbstractEntry
{
    protected $rules    = [];
    protected $messages = [];

    public function fill(Entry &$entry, Request $request)
    {
        $entry->title = ucfirst($request->get('title'));
    }

    final public function rules($orig = [])
    {
        return array_merge($orig, $this->rules);
    }

    final public function messages($orig = [])
    {
        return array_merge($orig, $this->messages);
    }

    public function viewCreate()
    {
        throw new UndefinedMethodException;
    }

    public function viewShow()
    {
        throw new UndefinedMethodException;
    }
}