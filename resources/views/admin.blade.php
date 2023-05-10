@extends('layout')

@section('title', 'Administrace')
 
<?php

$courses_list = DB::table('courses')
    ->select('id', 'abbreviation')
    ->orderBy('abbreviation', 'ASC')
    ->get();

$courses = DB::table('courses')
    ->select('*')
    ->get();

$evaluations = DB::table('evaluations')
    ->select('evaluations.id as evaluations_id', 'evaluations.*', 'courses.abbreviation')
    ->join('courses', 'evaluations.course_id', 'courses.id')
    ->orderByRaw('evaluations_id ASC, evaluations.semester ASC')
    ->get();

?>

@section('content')
    <section class="m-5">
        <h1>Administrace</h1>
        <div class="my-3">
            <h2>Předměty</h2>
            <div class='jumbotron p-3'>
                <table class='w-100'>
                    <tr>
                        <th scope='col' style='width: 25%;'>Zkratka</th>
                        <th scope='col' style='width: 50%;'>Název</th>
                        <th scope='col' style='width: 20%;' class='text-center'>Počet kreditů</th>
                        <th scope='col' style='width: 5%;' class='text-center'>Operace</th>
                    </tr>
                    <?php
                        foreach($courses as $course)
                        {
                            printf("
                                <tr>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td class='text-center'>%d</td>
                                    <td class='text-center'>
                                        <form action='/api/courses/delete' method='POST'>
                                            <input name='id' type='hidden' value='%d'/>
                                            <input type='submit' class='btn btn-square btn-danger' value='-'/>
                                        </form>
                                    </td>
                                </tr>",
                                $course->abbreviation,
                                $course->title,
                                $course->credits,
                                $course->id
                            );
                        }
                    ?>
                    <form action='/api/courses/insert' method='POST'>
                        <td class='text-center'>
                            <input name='abbreviation' type='text' class='form-control w-100'></input>
                        </td>
                        <td class='text-center p-1'>
                            <input name='title' type='text' class='form-control w-100' ></input>
                        </td>
                        <td class='text-center p-1'>
                            <input name='credits' class='form-control w-100' type='number' min='0' max='10'></input>
                        </td>
                        <td class='text-center p-1'>
                            <input type='submit' class='btn btn-success btn-square text-white' value='+'></input>
                        </td>
                    </form>
                </table>
            </div>
        </div>
        <hr>
        <br>
        <div class="my-3">
            <h2>Hodnocení</h2>
                <div class='jumbotron p-3'>
                    <table class='w-100'>
                        <tr>
                            <th scope='col' style='width: 20%;'>Předmět</th>
                            <th scope='col' style='width: 20%;' class='text-center'>Zápočet</th>
                            <th scope='col' style='width: 20%;' class='text-center'>Počet bodů</th>
                            <th scope='col' style='width: 20%;' class='text-center'>Známka</th>
                            <th scope='col' style='width: 10%;' class='text-center'>Semestr</th>
                            <th scope='col' style='width: 10%;' class='text-center'>Operace</th>
                        </tr>
                        <?php
                            foreach($evaluations as $evaluation)
                            {
                                printf("
                                    <tr>
                                        <td>%s</td>
                                        <td class='text-center'>%s%s</td>
                                        <td class='text-center'>%s</td>
                                        <td class='text-center'><b>%s</b>%s</td>
                                        <td class='text-center'>%d</td>
                                        <td class='text-center'>
                                            <form action='/api/evaluations/delete' method='POST'>
                                                <input name='id' type='hidden' value='%d'/>
                                                <input type='submit' class='btn btn-square btn-danger' value='-'/>
                                            </form>
                                        </td>
                                    </tr>",
                                    $evaluation->abbreviation,
                                    !is_null($evaluation->credits_given_date) ? ($evaluation->credits_given_date ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-solid fa-xmark"></i>') : '',
                                    !is_null($evaluation->credits_given_date) ? ' (' . $evaluation->credits_given_date . ')' : '',
                                    $evaluation->points,
                                    $evaluation->grade,
                                    !is_null($evaluation->grade_date) ? ' (' . $evaluation->grade_date . ')' : '',
                                    $evaluation->semester,
                                    $evaluation->evaluations_id
                                );
                            }
                        ?>
                        <tr>
                            <form action='/api/evaluations/insert' method='POST'>
                                <td class='text-center'>
                                    <select class='form-control w-100' type='select' name='course_id'>
                                        <?php
                                            foreach($courses_list as $course)
                                            {
                                                printf("<option value='%d'>%s</option>", $course->id, $course->abbreviation);
                                            }
                                        ?>
                                    </select>
                                </td>
                                <td class='text-center p-1'>
                                    <input name='credits_given_date' class='form-control w-100' type='date'></input>
                                </td>
                                <td class='text-center p-1'>
                                    <input name='points' class='form-control w-100' type='number' min='0' max='100'></input>
                                </td>
                                <td class='text-center p-1' style='display: flex; flex-direction: row; align-items: stretch;'>
                                    <select name='grade' class='form-control w-25' class='m-1'>
                                        <option value='A'>A</option>
                                        <option value='B'>B</option>
                                        <option value='C'>C</option>
                                        <option value='D'>D</option>
                                        <option value='E'>E</option>
                                        <option value='F'>F</option>
                                    </select>
                                    <input name='grade_date' class='form-control w-100' type='date' style='diplay: inline-box;'></input>
                                </td>
                                <td class='text-center p-1'>
                                    <input name='semester' class='form-control w-100' value="1" type='number' min='1' max='99' size='3'></input>
                                </td>
                                <td class='text-center p-1'>
                                    <input type='submit' class='btn btn-success btn-square text-white' value='+'></input>
                                </td>
                            </form>
                        </tr>
                    </table>
                </div>
            <br>
        </div>
    </section>
@stop