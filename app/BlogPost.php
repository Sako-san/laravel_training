<?php

namespace App;

use App\Scopes\LatestScope;
use App\Scopes\DeletedAdminScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class BlogPost extends Model
{
    // protected $table = 'blogposts';
    use SoftDeletes;

    protected $fillable = ['title', 'content', 'user_id'];

    public function comments()
    {
        return $this->hasMany('App\Comment')->latest();
    }

    public function scopeLatest(Builder $query){
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public function scopeControversial(Builder $query)
    {
        // Below 'withCount' creates a new field comments_count
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function boot()
    {
        static::addGlobalscope(new DeletedAdminScope);
        parent::boot();

        // static::addGlobalScope( new LatestScope);
        static::deleting( function( BlogPost $blogPost){
            $blogPost->comments()->delete();
        });

        static::restoring( function( Blogpost $blogPost){
            $blogPost->comments()->restore();
        });
    }
}
