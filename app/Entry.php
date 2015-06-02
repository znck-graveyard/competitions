<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['abstract', 'file_type', 'file_size', 'contest_id', 'is_team_entry','entryable_id','entryable_type'];

    protected $table = "entries";

    /**
     * A entry can be team entry or an individual entry
     * Polymorphic relation is used to specify its type
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function entryable()
    {
        return $this->morphTo();
    }

    /**
     * An Entry is submitted to a particular contest
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

}
