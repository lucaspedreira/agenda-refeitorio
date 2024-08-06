<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ScheduleController extends Controller
{

    public function index()
    {
        return Inertia::render('Aluno/Index', [
            'schedules' => auth()->user()->schedules->paginate(5),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'data_agendamento' => 'required|date',
            'refeicao' => 'required|integer|between:1,4',
        ]);

        $request->user()->schedules()->create([
            'data_agendamento' => $request->data_agendamento,
            'refeicao' => $request->refeicao,
        ]);

        return to_route('aluno.index');
    }
}
