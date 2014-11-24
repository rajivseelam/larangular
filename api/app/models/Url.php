<?php

class Url extends Eloquent{

	protected $table = 'urls';

	protected $fillable = ['url', 'title', 'user_id'];
}
