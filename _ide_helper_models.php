<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 */
	class User extends \Eloquent {}
}

namespace App{
/**
 * App\Word
 *
 * @property-read mixed $formatted_date
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Word newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Word newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Word query()
 */
	class Word extends \Eloquent {}
}

