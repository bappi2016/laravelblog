<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //Table Name
    protected $table = 'posts';
    // Primary Key
    public $primaryKey = 'id';

    //Timestamps
    public  $timestapms = true;
    // relationship between user and post
    public function user()
    {
        // return only one to one relationship in dashboad.
        // That is the posts that belongs to the user who has write the post
        return $this->belongsTo('App\User');
    }
}
