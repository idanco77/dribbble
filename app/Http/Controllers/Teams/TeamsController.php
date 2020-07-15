<?php

namespace App\Http\Controllers\Teams;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use App\Repositories\Contracts\TeamContract;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// todo: start lesson 4
class TeamController extends Controller
{
    protected $teams;

    public function __construct(TeamContract $teams)
    {
        $this->teams = $teams;
    }

    public function index()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:80', 'unique:teams.name']
        ]);

        // create team in database
        $team = $this->teams->create([
            'owner_id' => auth()->id(),
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        // current user is inserted as team member using boot method in Team model

        return new TeamResource($team);

    }

    public function fetchUserTeams()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }

    public function findById()
    {

    }

    public function findBySlug()
    {

    }
}
